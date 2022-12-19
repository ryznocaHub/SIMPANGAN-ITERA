<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use App\Models\ProcurementAccounts;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class DocumentsController extends Controller
{
    public function boq ($id) {
        
        $procurement = ProcurementAccounts::with(['items', 'estimate'])->find($id);
        return Inertia::render('Document/Boq',[
            'procurement' => $procurement
        ]);      
    }
    public function hps ($id) {
        
        $procurement = ProcurementAccounts::with(['items', 'estimate', 'timeline', 'executor.ppk'])->find($id);
        return Inertia::render('Document/Hps',[
            'procurement' => $procurement
        ]);      
    }
    public function fisikhps (Request $request, $id) {
        $request->validate([
            'file' => 'required',     
        ],[
            'file.required'   => 'Lampirkan file HPS',
        ]);

        $file       = $request->file('file');
                
        if($file) {
            if($file[0]->clientExtension() != 'pdf') throw ValidationException::withMessages([
                'file'  => "Format file berupa pdf",
            ]);

            $path       = 'public/file/' . $id . '/' ;
            $file_name  = 'HPS' . '.' . $file[0]->clientExtension();
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

        Estimate::find($procurement->estimate_id)
            -> update([
                'file' => $file,     
            ]);
        // $procurement = ProcurementAccounts::with(['items', 'estimate', 'timeline', 'executor.ppk'])->find($id);
        // return Inertia::render('Document/Hps',[
        //     'procurement' => $procurement
        // ]);      
    }
    public function bakn ($id) {
        $procurement = ProcurementAccounts::with(['suppliers','contract', 'executor.pp'])->find($id);
        return Inertia::render('Document/BAKN',[
            'procurement' => $procurement
        ]);      
    }
    public function bahp ($id) {
        $procurement = ProcurementAccounts::with(['suppliers','contract', 'executor.pp', 'estimate'])->find($id);
        return Inertia::render('Document/BAHP',[
            'procurement' => $procurement
        ]);      
    }
    public function baep ($id) {
        $procurement = ProcurementAccounts::with(['suppliers','contract', 'executor.pp', 'estimate'])->find($id);
        // dd($procurement);
        return Inertia::render('Document/BAE',[
            'procurement' => $procurement
        ]);      
    }
    public function sppbj ($id) {
        
        $procurement = ProcurementAccounts::with(['suppliers','contract', 'executor.ppk'])->find($id);
        return Inertia::render('Document/SPPBJ',[
            'procurement' => $procurement
        ]);      
    }
    public function spk ($id) {
        
        $procurement = ProcurementAccounts::with(['suppliers','contract', 'executor.ppk'])->find($id);
        $supplier   = Supplier::find($procurement->supplier_id);
        return Inertia::render('Document/SPK',[
            'procurement' => $procurement,
            'supplier'      => $supplier
        ]);      
    }
    public function bastp ($id) {
        $procurement = ProcurementAccounts::with(['suppliers','contract', 'executor.ppk', 'estimate'])->find($id);
        return Inertia::render('Document/BASTP',[
            'procurement' => $procurement
        ]);      
    }
    public function bap ($id) {
        $procurement = ProcurementAccounts::with(['suppliers','contract', 'executor.ppk', 'estimate'])->find($id);
        return Inertia::render('Document/BAP',[
            'procurement' => $procurement
        ]);      
    }
    public function bp ($id) {
        $procurement = ProcurementAccounts::with(['suppliers','contract', 'executor.ppk'])->find($id);
        return Inertia::render('Document/BP',[
            'procurement' => $procurement
        ]);      
    }
    public function sp ($id) {
        $procurement = ProcurementAccounts::with(['suppliers','contract', 'estimate', 'executor.ppk'])->find($id);
        if($procurement->category == 'Barang') $title = 'SURAT PERINTAH PENGIRIMAN (SPP)';
        else $title = 'SURAT PERINTAH MULAI KERJA (SPMK)';

        return Inertia::render('Document/SP',[
            'procurement'   => $procurement,
            'title'        => $title
        ]);      
    }
}
