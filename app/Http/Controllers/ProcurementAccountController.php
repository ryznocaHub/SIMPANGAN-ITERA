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
use Illuminate\Validation\ValidationException;
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
            $procurements = ProcurementAccounts::with(['budget_plan', 'timeline'])
                -> where('status','>=', $status)
                -> get();
            // dd($procurements);
            return Inertia::render($url,[
                'procurements' => $procurements,
            ]);
        }
        else if(Auth::user()->role == User::ROLE_PPK)
        {
            $procurements = $procurements = ProcurementAccounts::whereHas('executor', function ($query) {
                    $query->where('ppk', Auth::id());
                })
                ->where('status','>=',$status)
                ->with(['budget_plan','estimate','executor.hps'])
                ->get();

            // if(!$procurements) return abort(404);
            $hpsTeams   = User::where('role',User::ROLE_HPS_TEAM)->get();
            $ppList     = User::where('role',User::ROLE_PP)->get();
            return Inertia::render($url, [
                'procurements'  => $procurements,
                'hpsteams'      => $hpsTeams,
                'ppList'        => $ppList
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
        else if(Auth::user()->role == User::ROLE_PP)
        {
            $procurements = $procurements = ProcurementAccounts::whereHas('executor', function ($query) {
                    $query->where('pp', Auth::id());
                })
                -> with(['suppliers', 'estimate'])
                ->where('status','>=',$status)
                ->get();

            return Inertia::render($url, [
                'procurements'  => $procurements,
            ]);
        }
        else
        {
            $procurements = ProcurementAccounts::where('status','>=', $status)
                -> with(['suppliers', 'estimate', 'contract'])
                -> get();
            // dd($procurements);
            // $suppliers = Supplier::all()->sortBy('name');
            // dd($suppliers);
            return Inertia::render($url, [
                'procurements'  => $procurements,
                // 'suppliers'     => $suppliers
            ]);
        }

    }

    public function show ($id){
        $status = ProcurementAccounts::status[Auth::user()->role -1];

        $procurement = ProcurementAccounts::with(['suppliers', 'executor.ppk', 'executor.hps', 'executor.siren_approval', 'executor.siren_reject', 'executor.pp', 'executor.contract', 'budget_plan', 'timeline', 'contract', 'estimate'])
                            -> where('status','>=', $status)
                            -> find($id);
                            
        if(!$procurement) return abort(404);
        if(Auth::user()->role == User::ROLE_UNIT && $procurement -> user_id != Auth::id()) return abort(403);
        else if (Auth::user()->role == User::ROLE_HPS_TEAM && $procurement -> executor -> hps != Auth::id()) return abort(403);

        $url = User::StringRole[Auth::user()->role -1] . '/Procurement/Show';


        $suppliers = Supplier::all();
        // dd($procurement);
        return Inertia::render($url,[
            'procurement'   => $procurement,
            'suppliers'     => $suppliers
        ]);
    }

    public function create (){
        $ppks = User::where("role","=",User::ROLE_PPK)->get();
        // dd($ppk);
        return Inertia::render('Unit/Procurement/Create',[
            'ppks' => $ppks
        ]);
    }

    public function store (Request $request){
        $validated = $request->validate([
            'description'                       => 'required|String',
            'category'                          => 'required|String|exists:categories,name',
            'account'                           => 'required|String|unique:procurement_accounts,account',
            'dataInfo.PPK'                      => 'required|exists:users,name',
            'dataInfo.executor'                 => 'required',
            'dataInfo.executor_id'              => 'required',
            'dataInfo.person_responsible'       => 'required',
            'dataInfo.person_responsible_id'    => 'required',
        ],[
            'description.required'                      => 'Masukkan deskripsi singkat tentang paket',
            'description.String'                        => 'deskripsi berupa huruf',
            'category.required'                         => 'Pilih kategori yang tersedia',
            'category.String'                           => 'Kategori berupa huruf',
            'category.exists'                           => 'Kategori salah, Pilih kategori yang tersedia',
            'account.required'                          => 'Nomor akun harus diisi',
            'account.String'                            => 'Nomor akun berupa huruf',
            'account.unique'                            => 'Nomor akun sudah terpakai',
            'dataInfo.PPK.required'                     => 'Nama PPK harus diisi',
            'dataInfo.PPK.exists'                       => 'Nama PPK salah atau tidak tersedia',
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
                'name'                  => $info['name'],
                'description'           => $request->description,
                'account'               => $request->account,
                'user_id'               => Auth::id(),
                'unit'                  => Auth::user()->units->full_name,
                'category'              => $request->category,
                'year'                  => $info['year'],
                'status'                => 1,
                'executor_id'           => $executor->id,
                'budget_plan_id'        => $budget_plan->id,
                'estimate_id'           => $estimate->id,
                'timeline_id'           => $timeline->id,
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
        $procurement = ProcurementAccounts::with(['estimate', 'budget_plan', 'executor']) -> find($id);
        if(!$procurement) return abort(404);

        if(Auth::user()->role == User::ROLE_UNIT && $procurement -> user_id != Auth::id()) throw abort(401);
        else if (Auth::user()->role == User::ROLE_HPS_TEAM && $procurement -> executor -> hps != Auth::id()) throw abort(403);

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
            if($procurement->status != ProcurementAccounts::is_HPSReject)
            {
                $items = ProcurementItem::where('procure_acc_id',$id)
                            ->where('estimate_price',null)
                            ->get();
            }else
            {
                $items = ProcurementItem::where('procure_acc_id',$id)->get();
            }
            
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
                ],[
                    'comment.required'  => 'Berikan komentar untuk mempermudah unit',
                    'comment.string'    => 'Komentar berupa huruf',
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
                    'rup_code'          => 'required|string|unique:procurement_accounts,rup_code',
                ],[
                    'rup_code.required' => 'Kode RUP harus diisi',
                    'rup_code.string'   => 'Kode RUP berupa huruf',
                    'rup_code.unique'   => 'Kode RUP telah terpakai',
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
                    $hps_executor = User::where('name', $request->hps)
                        ->where('role',User::ROLE_HPS_TEAM)
                        ->firstOrFail();
                        
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
                $request->validate([
                    'pp'       => 'required|string|exists:users,name'
                ],[
                    'pp.required'  => 'Pilih Pejabat Pengadaan yang tersedia',
                    'pp.string'    => 'Nama PP berupa huruf',
                    'pp.exists'    => 'Nama PP salah, Pilih Nama yang tersedia',
                ]);

                DB::transaction(function () use($request, $procurement)
                {
                    $pp = User::where('name', $request->pp)
                        ->where('role',User::ROLE_PP)
                        ->firstOrFail();
                    Executor::find($procurement->executor_id)
                        -> update([
                            'pp'   => $pp->id
                        ]);

                    $procurement -> update([
                        'comment'   => null
                    ]);
    
                    Timeline::find($procurement->timeline_id)
                        -> update ([
                            'hps_approved'      => Carbon::now('Asia/Jakarta')
                        ]);

                    $contract = Contract::create();
                    $procurement->contract_id = $contract->id;
                });
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
            //create BAKN
            if($request->status == 1){
                $request->validate([
                    'no_bakn'   => 'required|string|unique:contracts,no_bakn',
                    'days'      => 'required|integer|min:1',
                    'date_bakn' => 'required|date',
                ],[
                    'no_bakn.required'  => 'Nomor BAKN tidak boleh kosong',
                    'no_bakn.string'    => 'Nomor BAKN berupa huruf',
                    'no_bakn.unique'    => 'Nomor BAKN telah terpakai',
                    'days.required'     => 'Masukkan masa pekerjaan ',
                    'days.integer'      => 'Masa Pekerjaan berupa angka',
                    'days.min'          => 'Masa Pekerjaan diatas 1 hari',
                    'date_bakn.required'=> 'Masukkan tanggal pembuatan BAKN',
                    'date_bakn.date'    => 'Format tanggal salah',
                ]);
    
                $procurement = ProcurementAccounts::with('contract')->find($id);
    
                DB::transaction(function () use($request, $procurement)
                {
                    if($procurement->status == ProcurementAccounts::is_ChoosingSupplier)
                    {
                        Timeline::find($procurement->timeline_id)
                            -> update ([
                                'bakn_created'      => Carbon::now('Asia/Jakarta')
                            ]);
        
                        $procurement->contract
                        ->update([
                            'no_bakn'   => $request->no_bakn,
                            'days'      => $request->days,
                            'date_bakn' => Carbon::parse($request->date_bakn)
                        ]);
                    }
                });
            }
            // create BAHP
            else if($request->status == 2){
                $validated = $request->validate([
                    'no_bahp'   => 'required|string|unique:contracts,no_bahp',
                    'date_bahp' => 'required|date',
                ],[
                    'no_bahp.required'  => 'Nomor BAHP tidak boleh kosong',
                    'no_bahp.unique'    => 'Nomor BAHP sudah terpakai',
                    'date_bahp.required'  => 'Pilih tanggal BAHP',
                    'date_bahp.date'    => 'Format tanggal tidak sesuai'
                ]);
                // dd($request);

                $procurement = ProcurementAccounts::with('contract')->find($id);

                DB::transaction(function () use($request, $procurement){
                    if($procurement->status == ProcurementAccounts::is_ChoosingSupplier){
                        
                        Timeline::find($procurement->timeline_id)
                            -> update ([
                                'bahp_created'      => Carbon::now('Asia/Jakarta'),
                                'supplier_selected' => Carbon::now('Asia/Jakarta'),
                            ]);
        
                        $procurement->contract->update([
                            'no_bahp'   => $request->no_bahp,
                            'date_bahp' => Carbon::parse($request->date_bahp)
                        ]);
                        
                        $procurement->update([
                            'status'    => ProcurementAccounts::is_CreateContract,
                        ]);
                    }
                });
            }
            // create BAEP
            else if($request->status == 3){
                $validated = $request->validate([
                    'no_baep'   => 'required|string|unique:contracts,no_baep',
                    'date_baep' => 'required|date',
                    'correction'=> 'required|integer',
                ],[
                    'no_baep.required'      => 'Nomor BAE tidak boleh kosong',
                    'no_baep.unique'        => 'Nomor BAE sudah terpakai',
                    'date_baep.required'    => 'Tanggal BAE tidak boleh kosong',
                    'date_baep.date'        => 'Format tanggal salah',
                    'correction.required'   => 'Masukkan nilai koreksi',
                    'correction.integer'    => 'Nilai koreksi berupa angka',
                ]);

                $procurement = ProcurementAccounts::with('contract')->find($id);
                if($procurement->contract->offer < $request->correction) throw ValidationException::withMessages([
                    'correction'  => "Nilai Koreksi tidak boleh diatas nilai Penawaran Rp." . $procurement->contract->offer,
                ]);
                
                DB::transaction(function () use($request, $procurement){
                    if($procurement->status == ProcurementAccounts::is_ChoosingSupplier){
                        
                        Timeline::find($procurement->timeline_id)
                            -> update ([
                                'baep_created' => Carbon::now('Asia/Jakarta')
                            ]);
        
                        $procurement->contract->update([
                            'no_baep'       => $request->no_baep,
                            'correction'    => $request->correction,
                            'date_baep'     => Carbon::parse($request->date_baep)
                        ]);
                    }
                });
            }
            // create file offer
            else if($request->status == 4)
            {
                $request->validate([
                    'no_offer'   => 'required|string|unique:contracts,no_offer',
                    'supplier'  => 'required|string',
                    'offer'      => 'required|integer',
                    'file_offer' => 'required',     
                    'date_offer' => 'required|date',
                ],[
                    'no_offer.required'     => 'Nomor penawaran tidak boleh kosong',
                    'no_offer.unique'       => 'Nomor penawaran sudah terpakai',
                    'supplier.required' => 'Pilih atau masukkan nama supplier',
                    'offer.required'        => 'Masukkan nilai penawaran',
                    'offer.integer'         => 'Nilai penawaran berupa angka',
                    'file_offer.required'   => 'Lampirkan file penawaran',
                    'date_offer.required'   => 'Masukkan tanggal penawaran',
                    'date_offer.date'       => 'Format tanggal tidak sesuai, pilih kembali',
                ]);

                $procurement = ProcurementAccounts::with('estimate')->find($id);
                if($procurement->estimate->total < $request->offer) throw ValidationException::withMessages([
                    'offer'  => "Nilai Penawaran tidak boleh diatas nilai HPS Rp." . $procurement->estimate->total,
                ]);

                $file       = $request->file('file_offer');
                
                if($file) {
                    if($file[0]->clientExtension() != 'pdf') throw ValidationException::withMessages([
                        'file'  => "Format file berupa pdf",
                    ]);

                    $path       = 'public/file/' . $id . '/' ;
                    $file_name  = 'Offer_File' . '.' . $file[0]->clientExtension();
                    $store      = $file[0]->storeAs($path, $file_name);
                    $link       = $request->root() . '/storage/file/' . $id . '/' . $file_name;
                    $file       = Storage::url($store);
                    $file       = $request->root() . $file;
                    $file       = $link;
                }
                else throw ValidationException::withMessages([
                    'file'  => "Format file berupa pdf",
                ]);
                
                $procurement    = ProcurementAccounts::find($id);
                
                $supplier = Supplier::firstOrCreate(['name' => $request->supplier]);
                $procurement -> update([
                    'supplier_id'   => $supplier->id,
                ]);

                Contract::find($procurement->contract_id)
                    -> update([
                        'no_offer'   => $request->no_offer,     
                        'offer'      => $request->offer,     
                        'file_offer' => $file,     
                        'date_offer' => Carbon::parse($request->date_offer),
                    ]);

            }
            else {
                $status = ['','','','','BAKN','BAHP','BAE'];
                $procurement = ProcurementAccounts::find($id);
                if      ($request->status == 4) $file       = $request->file('file_bakn');
                else if ($request->status == 5) $file       = $request->file('file_bahp');
                else if ($request->status == 6) $file       = $request->file('file_baep');
                
                if($file[0]->clientExtension() != 'pdf') throw ValidationException::withMessages([
                    'file'  => "Format file berupa pdf",
                ]);

                $path       = 'public/file/' . $id . '/' . 'PP/';
                $file_name  = $procurement->name . '_' . $status[$request->status] .'.' . $file[0]->clientExtension();
                $store      = $file[0]->storeAs($path, $file_name);
                $link       = $request->root() . '/storage/file/' . $id . '/' . 'PP/' . $file_name;
                $file       = Storage::url($store);
                $file       = $request->root() . $file;
                $file       = $link;
                
                if      ($request->status == 4) Contract::find($procurement->contract_id) -> update (['file_bakn' => $file]);
                else if ($request->status == 5) Contract::find($procurement->contract_id) -> update (['file_bahp' => $file]);
                else if ($request->status == 6) Contract::find($procurement->contract_id) -> update (['file_baep' => $file]);
            }

            return Redirect::route('pp.procurement.show', $id);
        }
        else if(Auth::user()->role == User::ROLE_CONTRACT_TEAM){
            // create sppbj
            if($request->status == 1)
            {
                $request->validate([
                    'no_sppbj'      => 'required|string|unique:contracts,no_sppbj',
                    'purpose_sppbj' => 'required|string',
                    'date_sppbj'    => 'required|date',
                ],[
                    'no_sppbj.required'     => 'Masukkan nomor SPPBJ',
                    'no_sppbj.unique'       => 'Nomor SPPBJ sudah terpakai',
                    'purpose_sppbj.required'=> 'Masukkan prihal',
                    'date_bahp.required'    => 'Pilih tanggal SPPBJ',
                    'date_bahp.date'        => 'Format tanggal tidak sesuai'
                ]);

                // dd($request);
                DB::transaction(function () use($request,$id)
                {
                    $procurement    = ProcurementAccounts::find($id);
                    Contract::find($procurement->contract_id)
                        -> update([
                            'no_sppbj'          => $request->no_sppbj,
                            'purpose_sppbj'     => $request->purpose_sppbj,
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
            // create spk
            else if($request->status == 2)
            {
                $request->validate([
                    'no_spk'    => 'required|string|unique:contracts,no_spk',
                    'mak_code'  => 'required|string',
                    'start'     => 'required|date',
                    'end'       => 'required|date',
                ],[
                    'no_spk.required'       => 'Masukkan nomor SPK',
                    'no_spk.unique'         => 'Nomor SPK sudah terpakai',
                    'mak_code.required'     => 'Masukkan Kode MAK',
                    'mak_code.string'       => 'Kode MAK berupa huruf',
                    'start.required'        => 'Pilih tanggal mulai kontrak',
                    'start.required'        => 'Format tanggal tindak sesuai',
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
                            'date_start_spk'    => Carbon::parse($request->start),
                            'date_end_spk'      => Carbon::parse($request->end),
                        ]);
                    
                    Timeline::find($procurement->timeline_id)
                        -> update ([
                            'spk_created'       => Carbon::now('Asia/Jakarta')
                        ]);
                },3);

            }
            // create bast
            else if($request->status == 3)
            {
                $validated = $request->validate([
                    'no_bastp'      => 'required|string|unique:contracts,no_bastp',
                    'date_bastp'    => 'required|date',
                ],[
                    'no_bastp.required'     => 'Masukkan nomor BAST',
                    'no_bastp.unique'       => 'Nomor BAST sudah terpakai',
                    'date_bahp.required'    => 'Pilih tanggal BAST',
                    'date_bahp.date'        => 'Format tanggal tidak sesuai'
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
            // create BAP
            else if($request->status == 4)
            {
                $request->validate([
                    'no_bap'      => 'required|string|unique:contracts,no_bap',
                    'date_bap'    => 'required|date',
                ],[
                    'no_bap.required'       => 'Masukkan nomor BAP',
                    'no_bap.unique'         => 'Nomor BAP sudah terpakai',
                    'date_bap.required'    => 'Pilih tanggal BAP',
                    'date_bap.date'        => 'Format tanggal tidak sesuai'
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
            // create SP
            else if($request->status == 5)
            {
                $request->validate([
                    'no_sp'      => 'required|string|unique:contracts,no_sp',
                    'date_sp'    => 'required|date',
                ],[
                    'no_sp.required'      => 'Masukkan nomor SP',
                    'no_sp.unique'        => 'Nomor sudah terpakai',
                    'date_sp.required'    => 'Pilih tanggal',
                    'date_sp.date'        => 'Format tanggal tidak sesuai'
                ]);

                // dd($request);
                DB::transaction(function () use($request,$id)
                {
                    $procurement    = ProcurementAccounts::find($id);
                    Contract::find($procurement->contract_id)
                        -> update([
                            'no_sp'          => $request->no_sp,
                            // 'paket_sp'          => $request->paket_sp,
                            'date_sp'        => Carbon::parse($request->date_sp),
                        ]);
                    
                    Timeline::find($procurement->timeline_id)
                        -> update ([
                            'spmk_or_spp_created'     => Carbon::now('Asia/Jakarta')
                        ]);
                },3);
            }
            // create BP
            else if($request->status == 6)
            {
                $request->validate([
                    'no_bp'      => 'required|string|unique:contracts,no_bp',
                    'date_bp'    => 'required|date',
                ],[
                    'no_bp.required'      => 'Masukkan nomor BP',
                    'no_bp.unique'        => 'Nomor sudah terpakai',
                    'date_bp.required'    => 'Pilih tanggal',
                    'date_bp.date'        => 'Format tanggal tidak sesuai'
                ]);

                // dd($request);
                DB::transaction(function () use($request,$id)
                {
                    $procurement    = ProcurementAccounts::find($id);
                    Contract::find($procurement->contract_id)
                        -> update([
                            'no_bp'        => $request->no_bp,
                            'no_bp'        => Carbon::parse($request->date_bp),
                        ]);
                    
                    Timeline::find($procurement->timeline_id)
                        -> update ([
                            'bp_created'     => Carbon::now('Asia/Jakarta')
                        ]);

                    $procurement -> update([
                        'status' => ProcurementAccounts::is_CheckingRealItems
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
            'description'           => 'required|String',
            'category'              => 'required|String|exists:categories,name',
            'account'               => 'required|String',
            'judul'                 => 'required|String',
        ],[
            'description.required'  => 'Masukkan deskripsi singkat tentang paket',
            'description.String'    => 'deskripsi berupa huruf',
            'category.required'     => 'Pilih kategori yang tersedia',
            'category.String'       => 'Kategori berupa huruf',
            'category.exists'       => 'Kategori salah, Pilih kategori yang tersedia',
            'account.required'      => 'Nomor akun harus diisi',
            'account.String'        => 'Nomor akun berupa huruf',
            'judul.required'        => 'Judul harus diisi',
            'judul.String'          => 'Judul berupa huruf',
        ]);

        $newprocurementId = DB::transaction(function() use($id, $request){

            ProcurementAccounts::find($id)
                -> update([
                    'name'          => $request->judul,
                    'description'   => $request->description,
                    'account'       => $request->account,
                    'category'      => $request->category,
                    'status'        => 2,
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
