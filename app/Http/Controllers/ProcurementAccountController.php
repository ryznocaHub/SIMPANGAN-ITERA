<?php

namespace App\Http\Controllers;

use App\Models\ProcurementAccounts;
use App\Models\ProcurementItem;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProcurementAccountController extends Controller
{
    public function index (){
        // dd(Auth::id());
        if(Auth::user()->role == User::ROLE_UNIT){
            $procurements = ProcurementAccounts::where('user_id',Auth::id())->get();
            // dd($procurements);
            return Inertia::render('Unit/Procurement/Index',[
                'procurements' => $procurements,
            ]);
        }
        
        if(Auth::user()->role == User::ROLE_HPS_TEAM)
        {
            $procurements = ProcurementAccounts::where('hps_executor', Auth::id())->with('hpsexecutor')->get();
            return Inertia::render('Hps/Procurement/Index',[
                'procurements' => $procurements,
            ]);
        }

        $status = ProcurementAccounts::status[Auth::user()->role -1];
        
        if(Auth::user()->role == User::ROLE_PPK)
        {
            $procurements = ProcurementAccounts::where('status','>=', $status)->with('hpsexecutor')->get();
            // dd($procurements);
            $hpsTeams = User::where('role',User::ROLE_HPS_TEAM)->get();
            $url = User::StringRole[Auth::user()->role -1] . '/Procurement/Index';
            // dd($procurements);
            return Inertia::render($url, [
                'procurements'  => $procurements,
                'hpsteams'      => $hpsTeams
            ]);
        }
        $procurements = ProcurementAccounts::where('status','>=', $status)->with('suppliers')->get();
        $suppliers = Supplier::all();
        $url = User::StringRole[Auth::user()->role -1] . '/Procurement/Index';
        return Inertia::render($url, [
            'procurements'  => $procurements,
            'suppliers'      => $suppliers
        ]);
    }

    public function show ($id){
        $procurement = ProcurementAccounts::with('suppliers')
                                            -> find($id);
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
            'category'  => 'required|String|',
            'judul'     => 'required|String|',
            'account'   => 'required|String'
        ]);

        $info = $request->dataInfo;
        
        $newprocurementId = DB::transaction(function() use($info, $request){
            $newProcurement_Account = ProcurementAccounts::create([
                'name'                   => $info['name'],
                'account'                => $request->account,
                'user_id'                => Auth::id(),
                'unit'                   => Auth::user()->units->full_name,
                'category'               => $request->category,
                'year'                   => $info['year'],
                'executor'               => $info['executor'],
                'executor_id'            => $info['executor_id'],
                'person_responsible'     => $info['person_responsible'],
                'person_responsible_id'  => $info['person_responsible_id'],
                'PPK'                    => $info['PPK'],
                'PPK_id'                 => $info['PPK_id'],
                'treasurer'              => $info['treasurer'],
                'treasurer_id'           => $info['treasurer_id'],
                'PPN'                    => $info['PPN'],
                'sub_total'              => $info['sub_total'],
                'total'                  => $info['total'],
                'status'                 => 1,
                'procurement_start'      => Carbon::now('Asia/Jakarta')
            ]);
    
            $items=[];
            foreach ($request->dataList as $item) {
                $items[]=[
                    'procure_acc_id'    => $newProcurement_Account->id,
                    'name'              => $item[1],
                    'specification'     => $item[2],
                    'unit'              => $item[3],
                    'price'             => $item[4],
                    'total'             => $item[5],
                    'allocation'        => $item[7],
                    'source'            => $item[8],
                ];
            }
            ProcurementItem::Insert($items);

            return $newProcurement_Account->id;
        });

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
            $items = ProcurementItem::where('procure_acc_id',$id)
                                    ->where('estimate_price',null)
                                    ->get();
            $procurement = ProcurementAccounts::find($id);
            // dd($items);
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
            $procurement = ProcurementAccounts::find($id);
            // if($procurement->status == ProcurementAccounts::is_UploadImageItem){
                $procurement->status = $request->status;
                $procurement->rab_submitted = Carbon::now('Asia/Jakarta');
                $procurement->save();

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
                $procurement->comment = $request->comment;

            }else if($request->status == ProcurementAccounts::is_ChoosingHpsExecutor){
                $validated = $request->validate([
                    'rup_code'    => 'required|string',
                ]);
                $procurement->rup_code = $request->rup_code;
                $procurement->comment = null;
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
                    'hps'       => 'required|string'
                ]);
                $hps_executor = User::where('name', $request->hps)->firstOrFail();
                $procurement->hps_executor = $hps_executor->id;
            }
            else if($request->status==ProcurementAccounts::is_HPSReject)
            {
                $validated = $request->validate([
                    'comment'    => 'required|string',
                ]);
                $procurement->comment = $request->comment;
            }
            else if($request->status==ProcurementAccounts::is_ChoosingSupplier)
            {
                $procurement->comment = null;
                $procurement->hps_submitted = Carbon::now('Asia/Jakarta');
            }

            $procurement->status = $request->status;
            $procurement->save();
            return Redirect::route('ppk.procurement.index');
            // if($procurement->status == ProcurementAccounts::is_ChoosingHpsExecutor){

            // }
        }
        else if(Auth::user()->role == User::ROLE_HPS_TEAM){
            $validated = $request->validate([
                'status'    => 'required|integer|min:6|max:6',
                'sub_total' => 'required|integer',
                'ppn' => 'required|integer',
                'provit'    => 'required|integer'
            ]);

            $procurement = ProcurementAccounts::find($id);
            $total = $request->sub_total + $request->ppn + ($request->provit * $request->sub_total /100);
            // if($procurement->status == ProcurementAccounts::is_CreateHPS){
                $procurement->status            = $request->status;
                $procurement->estimate_total    = $total;
                $procurement->provit            = $request->provit;
                $procurement->save();

                return Redirect::route('hps.procurement.index');
            // }
        }
        else if(Auth::user()->role == User::ROLE_PP){
            $validated = $request->validate([
                'status'    => 'required|integer|min:9|max:9',
                'supplier'  => 'required|string'
            ]);
            $supplier = Supplier::firstOrCreate(['name' => $request->supplier]);

            $procurement = ProcurementAccounts::find($id);
            if($procurement->status == ProcurementAccounts::is_ChoosingSupplier){
                $procurement->status = $request->status;
                $procurement->supplier_id = $supplier->id;
                $procurement->supplier_submitted = Carbon::now('Asia/Jakarta');
                $procurement->save();
                // dd($procurement);
                return Redirect::route('pp.procurement.index');
            }
        }
        
    }

    
}
