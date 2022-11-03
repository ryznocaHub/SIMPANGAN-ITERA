<?php

namespace App\Http\Controllers;

use App\Models\BudgetPlan;
use App\Models\Contract;
use App\Models\Estimate;
use App\Models\Executor;
use App\Models\ProcurementAccounts;
use App\Models\ProcurementItem;
use App\Models\Supplier;
use App\Models\Timeline;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Type\Time;

class ProcurementAccountController extends Controller
{
    public function index (){
        
        // if(Auth::user()->role == User::ROLE_HPS_TEAM)
        // {
            // $procurements = ProcurementAccounts::with(['executor' => function ($query)  {
            //     $query->when('executor', function ($query) {
            //         $query->where('hps',Auth::id());
            //     });
            // }])->get();
            // $procurements = ProcurementAccounts::whereHas('executor', function ($query) {
            //     $query->where('hps', Auth::id());
            // })->with('suppliers')->get();
        // }

        $status = ProcurementAccounts::status[Auth::user()->role -1];
        $url = User::StringRole[Auth::user()->role -1] . '/Procurement/Index';
        
        if(Auth::user()->role == User::ROLE_UNIT){
            $procurements = ProcurementAccounts::where('user_id',Auth::id())
                -> with('budget_plan')
                -> where('status','>=', $status)
                -> get();
            
            return Inertia::render($url,[
                'procurements' => $procurements,
            ]);
        }
        else if(Auth::user()->role == User::ROLE_VerifAccount){
            $procurements = ProcurementAccounts::with('budget_plan')
                -> where('status','>=', $status)
                -> get();
            
            return Inertia::render($url,[
                'procurements' => $procurements,
            ]);
        }
        else if(Auth::user()->role == User::ROLE_PPK)
        {
            $procurements = ProcurementAccounts::where('status','>=', $status)
                -> with('executor.hps')
                -> get();

            $hpsTeams = User::where('role',User::ROLE_HPS_TEAM)->get();
            // dd($procurements);
            return Inertia::render($url, [
                'procurements'  => $procurements,
                'hpsteams'      => $hpsTeams
            ]);
        }
        else if(Auth::user()->role == User::ROLE_HPS_TEAM)
        {
            $procurements = ProcurementAccounts::where('status','>=', $status)
                ->with(['suppliers', 'estimate'])    
                ->whereHas('executor', function ($query) {
                    $role = User::StringRole[Auth::user()->role -1];
                    $query->where($role, Auth::id());
                })  
                ->get();
            
            return Inertia::render($url, [
                'procurements'  => $procurements,
            ]);
        }
        else
        {
            $procurements = ProcurementAccounts::where('status','>=', $status)
                -> with(['suppliers', 'estimate'])
                -> get();
            // dd($procurements);
            $suppliers = Supplier::all();
            // dd($suppliers);
            return Inertia::render($url, [
                'procurements'  => $procurements,
                'datasuppliers'      => $suppliers
            ]);
        }

    }

    public function show ($id){
        $procurement = ProcurementAccounts::with(['suppliers', 'executor.ppk', 'budget_plan', 'timeline', 'contract'])
                                            -> find($id);
        // dd($procurement);
        $url = User::StringRole[Auth::user()->role -1] . '/Procurement/Show';
        return Inertia::render($url,[
            'procurement' => $procurement,
        ]);
    }

    public function create (){
        return Inertia::render('Unit/Procurement/Create');
    }

    public function store (Request $request){
        $validated = $request->validate([
            'category'                          => 'required|String|exists:categories,name',
            'account'                           => 'required|String|unique:procurement_accounts,account',
            'dataInfo.PPK'                      => 'required|exists:users,name',
            'dataInfo.executor'                 => 'required',
            'dataInfo.executor_id'              => 'required',
            'dataInfo.person_responsible'       => 'required',
            'dataInfo.person_responsible_id'    => 'required',
        ],[
            'category.required'                         => 'Pilih kategori yang tersedia',
            'category.String'                           => 'Kategori berupa huruf',
            'category.exists'                           => 'Kategori salah, Pilih kategori yang tersedia',
            'account.required'                          => 'Nomor akun harus diisi',
            'account.String'                            => 'Nomor akun berupa huruf',
            'dataInfo.PPK.required'                     => 'Nama PPK harus diisi',
            'dataInfo.PPK.exists'                       => 'Nama PPK salah',
            'dataInfo.executor.required'                => 'Nama Pelaksana harus diisi',
            'dataInfo.executor_id.required'             => 'Identitas Pelaksana harus diisi',
            'dataInfo.person_responsible.required'      => 'Nama Penanggung Jawab harus diisi',
            'dataInfo.person_responsible_id.required'   => 'Identitas Penanggung Jawab harus diisi',
            'dataInfo.treasurer.required'               => 'Nama Bendahara Pengeluaran harus diisi',
            'dataInfo.treasurer_id.required'            => 'Identitas Bendahara Pengeluaran harus diisi',
        ]);

        $info = $request->dataInfo;
        $newprocurementId = DB::transaction(function() use($info, $request){
            $ppk = User::where('name','like',$info['PPK'])->first();
            // dd($ppk);
            $executor = Executor::create([
                'ppk'                    => $ppk->id,
                'executor'               => $info['executor'],
                'executor_id'            => $info['executor_id'],
                'person_responsible'     => $info['person_responsible'],
                'person_responsible_id'  => $info['person_responsible_id'],
                'treasurer'              => $info['treasurer'],
                'treasurer_id'           => $info['treasurer_id'],
            ]);

            $budget_plan = BudgetPlan::create([
                'ppn'                    => $info['ppn'],
                'overheat'               => $info['overheat'],
                'sub_total'              => $info['sub_total'],
                'total'                  => $info['total'],
            ]);

            $timeline = Timeline::create([
                'procurement_start'      => Carbon::now('Asia/Jakarta')
            ]);

            $estimate = Estimate::create([
                'sub_total'              => 0
            ]);

            $newProcurement_Account = ProcurementAccounts::create([
                'name'                   => $info['name'],
                'account'                => $request->account,
                'user_id'                => Auth::id(),
                'unit'                   => Auth::user()->units->full_name,
                'category'               => $request->category,
                'year'                   => $info['year'],
                'status'                 => 1,
                'executor_id'            => $executor->id,
                'budget_plan_id'         => $budget_plan->id,
                'estimate_id'            => $estimate->id,
                'timeline_id'            => $timeline->id,
            ]);
    
            $items=[];
            foreach ($request->dataList as $item) {
                // dd($item[8],$item[9]);
                $items[]=[
                    'procure_acc_id'    => $newProcurement_Account->id,
                    'name'              => $item[1],
                    'specification'     => $item[2],
                    'quantity'          => $item[3],
                    'unit'              => $item[4],
                    'price'             => $item[5],
                    'total'             => $item[6],
                    'allocation'        => $item[8],
                    'source'            => $item[9],
                ];
            }
            ProcurementItem::Insert($items);

            return $newProcurement_Account->id;
        },3);

        return Redirect::route('unit.procurement.edit',$newprocurementId);
    }

    public function edit ($id){
        if(Auth::user()->role == User::ROLE_UNIT){
            $items = ProcurementItem::where('procure_acc_id',$id)
                                    -> whereNull('image')
                                    -> get();
            // dd($items);
            return Inertia::render('Unit/Procurement/Edit',[
                'items' => $items,
                'id'    => $id,
            ]); 
        }else{
            $procurement = ProcurementAccounts::find($id);

            if($procurement->status != ProcurementAccounts::is_HPSReject)
            {
                $items = ProcurementItem::where('procure_acc_id',$id)
                            ->where('estimate_price',null)
                            ->get();
            }else
            {
                $items = ProcurementItem::where('procure_acc_id',$id)->get();
            }
            
            $procurement = ProcurementAccounts::with(['estimate', 'budget_plan'])-> find($id);
            return Inertia::render('Hps/Procurement/Edit',[
                'items'         => $items,
                'procurement'   => $procurement,
                'id'            => $id
            ]);
        }

    }

    public function update (Request $request, $id) {
        if(Auth::user()->role == User::ROLE_UNIT){
            $validated = $request->validate([
                'status' => 'required|integer|min:2|max:2|'
            ]);

            DB::transaction(function () use ($id, $request){
                $procurement = ProcurementAccounts::find($id);
                $procurement->status = $request->status;
                $procurement->save();

                if($procurement->status != 3 ){
                    Timeline::find($procurement->timeline_id)
                        -> update([
                            'rab_submitted' => Carbon::now('Asia/Jakarta')
                        ]);
                }
            });
            // dd($procurement);
            // if($procurement->status == ProcurementAccounts::is_UploadImageItem){
                // $procurement->status = $request->status;
                // $procurement->rab_submitted = Carbon::now('Asia/Jakarta');
                // $procurement->save();

                return Redirect::route('unit.procurement.show',$id);
            // }
        }
        else if(Auth::user()->role == User::ROLE_VerifAccount){
            $validated = $request->validate([
                'status'    => 'required|integer|min:3|max:4',
            ]);

            $procurement = ProcurementAccounts::find($id);

            if($request->status == ProcurementAccounts::is_RABReject){
                $validated = $request->validate([
                    'comment'    => 'required|string',
                ]);
                DB::transaction(function () use($procurement, $request){
                    $procurement->comment = $request->comment;

                    Timeline::find($procurement->timeline_id)
                            ->update([
                                'siren_rejected'    =>  Carbon::now('Asia/Jakarta')
                            ]);

                    Executor::find($procurement->executor_id)
                            ->update([
                                'siren_reject'      => Auth::id()
                            ]);
                });

            }else if($request->status == ProcurementAccounts::is_ChoosingHpsExecutor){
                $validated = $request->validate([
                    'rup_code'    => 'required|string|exist:procurement_accounts,rup_code',
                ]);
                DB::transaction(function () use($procurement, $request){
                    $procurement->rup_code = $request->rup_code;
                    $procurement->comment = null;

                    Timeline::find($procurement->timeline_id)
                            ->update([
                                'siren_approved'    =>  Carbon::now('Asia/Jakarta')
                            ]);

                    Executor::find($procurement->executor_id)
                            ->update([
                                'siren_approval'      => Auth::id()
                            ]);
                });
            }

            $procurement->status = $request->status;
            $procurement->save();
            // dd("done");
            return Redirect::route('siren.procurement.index');
        }
        else if(Auth::user()->role == User::ROLE_PPK ){
            $validated = $request->validate([
                'status'    => 'required|integer|min:5|max:8',
            ]);

            $procurement = ProcurementAccounts::find($id);

            if($request->status==ProcurementAccounts::is_CreateHPS)
            {
                $validated = $request->validate([
                    'hps'       => 'required|string|exists:users,name'
                ],[
                    'hps.required'  => 'Pilih Tim HPS yang tersedia',
                    'hps.string'    => 'Nama Tim HPS berupa huruf',
                    'hps.exists'    => 'Nama Tim HPS salah, Pilih Nama yang tersedia',
                ]);

                DB::transaction(function () use($request, $procurement)
                {
                    $hps_executor = User::where('name', $request->hps)->firstOrFail();
                    Executor::find($procurement->executor_id)
                        -> update([
                            'hps'   => $hps_executor->id
                        ]);
                    
                    Timeline::find($procurement->timeline_id)
                        -> update([
                            'hps_selected'  => Carbon::now('Asia/Jakarta')
                        ]);
                });
            }
            else if($request->status==ProcurementAccounts::is_HPSReject)
            {
                $validated = $request->validate([
                    'comment'    => 'required|string',
                ],[
                    'comment.required'  => 'Berikan komentar untuk mempermudah Tim HPS'
                ]);
                
                Timeline::find($procurement->timeline_id)
                    -> update ([
                        'hps_rejected'      => Carbon::now('Asia/Jakarta')
                    ]);

                $procurement->comment = $request->comment;
            }
            else if($request->status==ProcurementAccounts::is_ChoosingSupplier)
            {
                $procurement->comment = null;
                Timeline::find($procurement->timeline_id)
                    -> update ([
                        'hps_approved'      => Carbon::now('Asia/Jakarta')
                    ]);
            }

            $procurement->status = $request->status;
            $procurement->save();
            return Redirect::route('ppk.procurement.index');
            // if($procurement->status == ProcurementAccounts::is_ChoosingHpsExecutor){

            // }
        }
        else if(Auth::user()->role == User::ROLE_HPS_TEAM){
            $validated = $request->validate([
                'status'        => 'required|integer|min:6|max:6',
                'sub_total'     => 'required|integer',
                'ppn'           => 'required|integer',
                'overheat'      => 'required|integer',
                'percentage'    => 'required|numeric|between:0,19.99',
                'chooser'       => 'required|boolean',
            ],[
                'percentage.max'    =>  'overheat maksimal 20%'
            ]);

            DB::transaction(function () use($request, $id){
                $procurement = ProcurementAccounts::find($id);

                $total = $request->sub_total + $request->overheat + ($request->ppn * $request->chooser);
                Estimate::find($procurement->estimate_id)
                    -> update ([
                        'sub_total'             => $request->sub_total,
                        'overheat'              => $request->overheat,
                        'overheat_percentage'   => $request->percentage,
                        'ppn'                   => $request->ppn * $request->chooser,
                        'total'                 => $total,
                    ]);
                
                $procurement->status            = $request->status;
                $procurement->save();
                
                Timeline::find($procurement->timeline_id)
                    -> update ([
                        'hps_submitted'         => Carbon::now('Asia/jakarta')
                    ]);
                
            },3);

            // $total = $request->sub_total + $request->ppn + ($request->provit * $request->sub_total /100);
            // if($procurement->status == ProcurementAccounts::is_CreateHPS){
                // $procurement->status            = $request->status;
                // $procurement->estimate_total    = $total;
                // $procurement->provit            = $request->provit;
                // $procurement->save();

                return Redirect::route('hps.procurement.index');
            // }
        }
        else if(Auth::user()->role == User::ROLE_PP){
            $validated = $request->validate([
                'status'    => 'required|integer|min:9|max:9',
                'supplier'  => 'required|string',
                'offer'     => 'required|integer|min:1',
            ]);

            $procurement = ProcurementAccounts::with('estimate')->find($id);

            if($request->offer > $procurement->estimate->total) return "Penawaran harus dibawah total Harga Perkiraan Sementara (Rp. )" . $procurement->estimate->total;

            DB::transaction(function () use($request, $procurement){

                $supplier = Supplier::firstOrCreate(['name' => $request->supplier]);
    
                if($procurement->status == ProcurementAccounts::is_ChoosingSupplier){
                    
                    Timeline::find($procurement->timeline_id)
                        -> update ([
                            'supplier_selected' => Carbon::now('Asia/Jakarta')
                        ]);

                    Executor::find($procurement->timeline_id)
                        -> update ([
                            'pp'    => Auth::id()
                        ]);

                    $contract = Contract::create([
                        'offer'     => $request->offer
                    ]);

                    $procurement->status = $request->status;
                    $procurement->supplier_id = $supplier->id;
                    $procurement->contract_id = $contract->id;
                    $procurement->save();
                    
                }
            });
            return Redirect::route('pp.procurement.index');
        }
        else if(Auth::user()->role == User::ROLE_CONTRACT_TEAM){
            if($request->status == 1)
            {
                $validated = $request->validate([
                    'no_sppbj'      => 'required|string',
                    'purpose_sppbj' => 'required|string',
                    'no_offer'      => 'required|string',
                    'date_offer'    => 'required|date',
                    'date_sppbj'    => 'required|date',
                ]);

                // dd($request);
                DB::transaction(function () use($request,$id)
                {
                    $procurement    = ProcurementAccounts::find($id);
                    Contract::find($procurement->contract_id)
                        -> update([
                            'no_sppbj'          => $request->no_sppbj,
                            'purpose_sppbj'     => $request->purpose_sppbj,
                            'no_offer'          => $request->no_offer,     
                            'date_offer'        => Carbon::parse($request->date_offer),
                            'date_sppbj'        => Carbon::parse($request->date_sppbj),
                        ]);
                    
                    Timeline::find($procurement->timeline_id)
                        -> update ([
                            'sppbj_created'     => Carbon::now('Asia/Jakarta')
                        ]);

                    Executor::find($procurement->executor_id)
                        -> update ([
                            'contract'          => Auth::id()
                        ]);
                },3);

            }
            else if($request->status == 2)
            {
                $validated = $request->validate([
                    'no_spk'    => 'required|string',
                    'mak_code'  => 'required|string',
                    'days'      => 'required|numeric|min:1',
                    'start'     => 'required|date',
                    'end'       => 'required|date',
                ]);
                // dd($request);
                DB::transaction(function () use($request,$id)
                {
                    $procurement    = ProcurementAccounts::find($id);
                    $supplier       = Supplier::find($procurement->supplier_id);

                    Contract::find($procurement->contract_id)
                        -> update([
                            'pic'               => $supplier->pic,
                            'pic_position'      => $supplier->pic_position,
                            'no_spk'            => $request->no_spk,
                            'mak_code'          => $request->mak_code,
                            'days'              => $request->days,
                            'date_start_spk'    => Carbon::parse($request->start),
                            'date_end_spk'      => Carbon::parse($request->end),
                        ]);
                    
                    Timeline::find($procurement->timeline_id)
                        -> update ([
                            'spk_created'       => Carbon::now('Asia/Jakarta')
                        ]);
                },3);

            }
            else if($request->status == 3)
            {
                $validated = $request->validate([
                    'no_bastp'      => 'required|string',
                    'date_bastp'    => 'required|date',
                ]);

                // dd($request);
                DB::transaction(function () use($request,$id)
                {
                    $procurement    = ProcurementAccounts::find($id);
                    Contract::find($procurement->contract_id)
                        -> update([
                            'no_bastp'          => $request->no_bastp,
                            'date_bastp'        => Carbon::parse($request->date_bastp),
                        ]);
                    
                    Timeline::find($procurement->timeline_id)
                        -> update ([
                            'bastp_created'     => Carbon::now('Asia/Jakarta')
                        ]);
                },3);

            }
            else if($request->status == 4)
            {
                $validated = $request->validate([
                    'no_bap'      => 'required|string',
                    'date_bap'    => 'required|date',
                ]);

                // dd($request);
                DB::transaction(function () use($request,$id)
                {
                    $procurement    = ProcurementAccounts::find($id);
                    Contract::find($procurement->contract_id)
                        -> update([
                            'no_bap'          => $request->no_bap,
                            'date_bap'        => Carbon::parse($request->date_bap),
                        ]);
                    
                    Timeline::find($procurement->timeline_id)
                        -> update ([
                            'bap_created'     => Carbon::now('Asia/Jakarta')
                        ]);
                },3);
            }
            else if($request->status == 5)
            {
                $validated = $request->validate([
                    'no_sp'      => 'required|string',
                    'paket_sp'   => 'required|string',
                    'date_sp'    => 'required|date',
                ]);

                // dd($request);
                DB::transaction(function () use($request,$id)
                {
                    $procurement    = ProcurementAccounts::find($id);
                    Contract::find($procurement->contract_id)
                        -> update([
                            'no_sp'          => $request->no_sp,
                            'paket_sp'          => $request->paket_sp,
                            'date_sp'        => Carbon::parse($request->date_sp),
                        ]);
                    
                    Timeline::find($procurement->timeline_id)
                        -> update ([
                            'spmk_or_spp_created'     => Carbon::now('Asia/Jakarta')
                        ]);
                },3);
            }
            return Redirect::route('kontrak.procurement.show', $id);
        }
    }

    public function reUploadRAB($id){
        
        $procurement = ProcurementAccounts::find($id);
        return Inertia::render('Unit/Procurement/Reupload',[
            'procurement'   =>  $procurement
        ]);
    }

    public function editDataRAB(Request $request, $id){
        $validated = $request->validate([
            'category'                          => 'required|String|exists:categories,name',
            'account'                           => 'required|String',
            'judul'                             => 'required|String',
        ],[
            'category.required'                 => 'Pilih kategori yang tersedia',
            'category.String'                   => 'Kategori berupa huruf',
            'category.exists'                   => 'Kategori salah, Pilih kategori yang tersedia',
            'account.required'                  => 'Nomor akun harus diisi',
            'account.String'                    => 'Nomor akun berupa huruf',
            'judul.required'                    => 'Judul harus diisi',
            'judul.String'                      => 'Judul berupa huruf',
        ]);

        $newprocurementId = DB::transaction(function() use($id, $request){

            ProcurementAccounts::find($id)
                                    -> update([
                'name'                   => $request->judul,
                'account'                => $request->account,
                'category'               => $request->category,
                'status'                 => 2,
            ]);
    
            $procurement = ProcurementAccounts::find($id);

            Timeline::find($procurement->timeline_id)
                        -> update([
                            'rab_reupload'  =>  Carbon::now('Asia/Jakarta')
                        ]);

        },3);

        return Redirect::route('unit.procurement.show',$id);
    }

    public function editItemRAB(Request $request, $id){
        $validated = $request->validate([
            'category'                          => 'required|String|exists:categories,name',
            'account'                           => 'required|String',
            'judul'                             => 'required|String',
            'dataInfo.PPK'                      => 'required|exists:users,name',
            'dataInfo.executor'                 => 'required',
            'dataInfo.executor_id'              => 'required',
            'dataInfo.person_responsible'       => 'required',
            'dataInfo.person_responsible_id'    => 'required',
        ],[
            'category.required'                         => 'Pilih kategori yang tersedia',
            'category.String'                           => 'Kategori berupa huruf',
            'category.exists'                           => 'Kategori salah, Pilih kategori yang tersedia',
            'account.required'                          => 'Nomor akun harus diisi',
            'account.String'                            => 'Nomor akun berupa huruf',
            'judul.required'                            => 'Judul harus diisi',
            'judul.String'                              => 'Judul berupa huruf',
            'dataInfo.PPK.required'                     => 'Nama PPK harus diisi',
            'dataInfo.PPK.exists'                       => 'Nama PPK salah',
            'dataInfo.executor.required'                => 'Nama Pelaksana harus diisi',
            'dataInfo.executor_id.required'             => 'Identitas Pelaksana harus diisi',
            'dataInfo.person_responsible.required'      => 'Nama Penanggung Jawab harus diisi',
            'dataInfo.person_responsible_id.required'   => 'Identitas Penanggung Jawab harus diisi',
            'dataInfo.treasurer.required'               => 'Nama Bendahara Pengeluaran harus diisi',
            'dataInfo.treasurer_id.required'            => 'Identitas Bendahara Pengeluaran harus diisi',
        ]);

        $info = $request->dataInfo;
        $procurement = ProcurementAccounts::find($id);
        DB::transaction(function() use($info, $request, $procurement, $id){
            $ppk = User::where('name','like',$info['PPK'])->first();
            Executor::find($procurement->executor_id)
                -> update([
                    'ppk'                    => $ppk->id,
                    'executor'               => $info['executor'],
                    'executor_id'            => $info['executor_id'],
                    'person_responsible'     => $info['person_responsible'],
                    'person_responsible_id'  => $info['person_responsible_id'],
                    'treasurer'              => $info['treasurer'],
                    'treasurer_id'           => $info['treasurer_id'],
            ]);

            BudgetPlan::find($procurement->budget_plan_id)
                -> update([
                    'ppn'                    => $info['ppn'],
                    'overheat'               => $info['overheat'],
                    'sub_total'              => $info['sub_total'],
                    'total'                  => $info['total'],
            ]);

            Timeline::find($procurement->timeline_id)
                -> update([
                    'rab_reupload'      => Carbon::now('Asia/Jakarta')
            ]);

            ProcurementAccounts::find($id)
                ->update([
                    'name'                   => $info['name'],
                    'account'                => $request->account,
                    'category'               => $request->category,
                    'year'                   => $info['year'],
                    'status'                 => 2,
            ]);
    
            ProcurementItem::where('procure_acc_id',$id)->delete();
            $url = 'storage/image/' . $id;
            Storage::deleteDirectory($url);

            $items=[];
            foreach ($request->dataList as $item) {
                // dd($item[8],$item[9]);
                $items[]=[
                    'procure_acc_id'    => $id,
                    'name'              => $item[1],
                    'specification'     => $item[2],
                    'quantity'          => $item[3],
                    'unit'              => $item[4],
                    'price'             => $item[5],
                    'total'             => $item[6],
                    'allocation'        => $item[8],
                    'source'            => $item[9],
                ];
            }
            ProcurementItem::Insert($items);

        },3);

        return Redirect::route('unit.procurement.edit', $id);
    }
    
}
