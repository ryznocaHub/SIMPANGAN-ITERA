<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use App\Models\ProcurementAccounts;
use App\Models\ProcurementItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Validation\ValidationException;

class ProcurementItemController extends Controller
{
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
            'image' => 'max:5120',
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
            'status'=> 'required'
        ],[
            'price.min' => 'Periksa kembali harga item'
        ]);

        if($request->status == 1) return 0;
        // dd($request->status);
        $item = ProcurementItem::find($id);
        // dd($request);
        DB::transaction(function () use($request, $item, $id) {
            if($request->source){
                $request->validate([
                    'source' => 'required|url',
                ],[
                    'source.url' => 'Periksa kembali url (e.g. https://www.tokopedia.com)'
                ]);
                $source     = $request->source;
                $file       = null;
            }else if($request->file){
                $file       = $request->file('file');
                
                if($file) {
                    if($file[0]->clientExtension() != 'pdf') throw ValidationException::withMessages([
                        'file'  => "Format file berupa pdf",
                    ]);

                    $path       = 'public/file/' . $item->procure_acc_id . '/' ;
                    $file_name  = $item->id . '.' . $file[0]->clientExtension();
                    // $file_name  = str_replace(' ', '_', $file_name);
                    $store      = $file[0]->storeAs($path, $file_name);
                    $link       = $request->root() . '/storage/file/' . $item->procure_acc_id . '/' . $file_name;
                    $file       = Storage::url($store);
                    $file       = $request->root() . $file;
                    $file       = $link;
                }else
                {
                    $file       = $request->file;
                }

                $source     = null;
            }

            $procurement = ProcurementAccounts::find($item->procure_acc_id);
            
            $estimate = Estimate::find($procurement->estimate_id);
            $estimate->sub_total = $estimate->sub_total + $request->total - $item->estimate_total;
            $estimate->save();

            ProcurementItem::find($id)
                ->update([
                    'estimate_price'    => $request->price,
                    'estimate_total'    => $request->total,
                    'estimate_source'   => $source,
                    'estimate_file'     => $file
                ]);

            // if($procurement->estimate_id == null)
            // {
            //     $estimate = Estimate::find()([
            //             'sub_total'     => $request->total
            //     ]);

            //     $procurement->estimate_id = $estimate->id;
            //     $procurement->save();
            // }else
            // {
                // $estimate = Estimate::find($procurement->estimate_id);

                // $estimate->sub_total = $estimate->sub_total + $request->total;
                // $estimate->save();
            // }
        });
    }

    public function list($name) {
        ProcurementItem::query()->where('name', 'LIKE',"%{$name}%")->get()->dd();
    }
}
