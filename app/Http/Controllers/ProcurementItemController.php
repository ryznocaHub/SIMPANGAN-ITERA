<?php

namespace App\Http\Controllers;

use App\Models\ProcurementAccounts;
use App\Models\ProcurementItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProcurementItemController extends Controller
{
    public function store (Request $request) {
        

    }

    public function edit () {

        
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'image' => 'image',
        ]);

        $item = ProcurementItem::find($id);

        $image = $request->file('image');
        $path = 'public/image/' . $item->procure_acc_id . '/item' .'/' ;
        // $store = $image->storeAs($path, $image->getClientOriginalName());
        $store = $image->storeAs($path, $item->name);
        $link = $request->root() . '/storage/image/' . $item->procure_acc_id . '/' . $item->name;
        $image = Storage::url($store);
        $image = $request->root() . $image;

        ProcurementItem::find($id)
                        -> update([
                            'image' => $link
                        ]);
    }
}
