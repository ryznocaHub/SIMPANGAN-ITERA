<?php

namespace App\Http\Controllers;

use App\Models\ProcurementAccounts;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DocumentsController extends Controller
{
    public function boq ($id) {
        
        $procurement = ProcurementAccounts::find($id)->with('items')->first();
        // dd($id,$procurement);    
        return Inertia::render('Document/Boq',[
            'procurement' => $procurement
        ]);      
    }
}
