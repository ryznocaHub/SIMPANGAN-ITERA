<?php

namespace App\Http\Controllers;

use App\Models\ProcurementAccounts;
use App\Models\ProcurementItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProcurementItemController extends Controller
{
    public function store (Request $request) {
        

    }

    public function edit () {

        
    }

    public function show ($id) {
        $items = ProcurementItem::where("procure_acc_id", $id)->get();
        // dd($items);
        $url = User::StringRole[Auth::user()->role -1] . '/Item/Show';

        return Inertia::render($url,[
            'items' => $items
        ]);
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'image' => 'image',
        ]);

        $item = ProcurementItem::find($id);

        $image = $request->file('image');
        // $cek = $image->clientExtension();
        // dd($cek);
        $path = 'public/image/' . $item->procure_acc_id . '/' ;
        $file_name = $item->name . '.' . $image->clientExtension();
        // $store = $image->storeAs($path, $image->getClientOriginalName());
        $store = $image->storeAs($path, $file_name);
        $link = $request->root() . '/storage/image/' . $item->procure_acc_id . '/' . $file_name;
        $image = Storage::url($store);
        $image = $request->root() . $image;

        ProcurementItem::find($id)
                        -> update([
                            'image' => $link
                        ]);
    }

    public function updateHPS (Request $request, $id){
        $validated = $request->validate([
            'price' => 'required|integer|min:1000',
            'total' => 'required|integer|min:1000',
        ]);
        
        if($request->source){
            $source = $request->source;
            $file   = null;
        }else if($request->file){
            $item = ProcurementItem::find($id);
            $file = $request->file('file');
            $path = 'public/file/' . $item->procure_acc_id . '/' ;
            $file_name = $item->name . '.' . $file[0]->clientExtension();
            $store = $file[0]->storeAs($path, $file_name);
            $link = $request->root() . '/storage/file/' . $item->procure_acc_id . '/' . $file_name;
            $file = Storage::url($store);
            $file = $request->root() . $file;

            $source= null;
            $file = $link;
        }
        $item = ProcurementItem::find($id)
                                ->update([
                                    'estimate_price'    => $request->price,
                                    'estimate_total'    => $request->total,
                                    'estimate_source'   => $source,
                                    'estimate_file'     => $file
                                ]);
    }
}
