<?php

namespace App\Http\Controllers;

use App\Models\ProcurementAccounts;
use App\Models\ProcurementItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProcurementAccountController extends Controller
{
    public function index (){
        // dd(Auth::id());
        $procurements = ProcurementAccounts::where('user_id',Auth::id())->get();
        // dd($procurements);
        return Inertia::render('Unit/Procurement/Index',[
            'procurements' => $procurements,
        ]);
    }

    public function show ($id){
        $procurement = ProcurementAccounts::with('items')
                                            -> find($id);
        // $items = ProcurementAccounts::find($id)->items;
        return Inertia::render('Unit/Procurement/Show',[
            'procurement' => $procurement,
        ]);
    }

    public function store (Request $request){
        $data = $request->all();
        $info = $request->dataInfo;
        // $items = $request->dataList;
        // dd($items);
        
        $newProcurement_Account = ProcurementAccounts::create([
            'name'                   => $info['name'],
            'user_id'                => Auth::id(),
            'unit'                   => Auth::user()->unit_id,
            // 'user_id'                => 1,
            // 'unit'                   => 1,
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
            'status'                 => 1
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

        return Redirect::route('procurement.edit');
    }

    public function edit ($id){
        $items = ProcurementItem::where('procure_acc_id',$id)
                        -> whereNull('image')
                        -> get();

        // dd($items);
        return Inertia::render('Unit/Procurement/Edit',[
            'items' => $items,
            'id'    => $id
        ]);
    }

    public function updateStatus (Request $request, $id) {
        $validated = $request->validate([
            'status' => 'required|integer|min:2|max:2|'
        ]);

        $procurement = ProcurementAccounts::find($id)->first();

        if($procurement->status == ProcurementAccounts::is_UploadImageItem){
            $procurement->status = $request->status;
            $procurement->save();

            return Redirect::route('procurement.show',$id);
        }
    }
}
