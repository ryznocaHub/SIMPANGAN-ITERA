<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupplierController extends Controller
{
    public function index ()
    {
        $suppliers = Supplier::all();

        return Inertia::render('Supplier/Index',[
            'suppliers' => $suppliers
        ]);
    }

    public function create ()
    {
        return Inertia::render('Supplier/Create');
    }

    public function show ($id)
    {
        $supplier = Supplier::find($id);

        return Inertia::render('Supplier/Show',[
            'supplier' => $supplier
        ]);
    }

    public function store (Request $request){
        
    }

    public function edit ($id) 
    {
        $supplier = Supplier::find($id);
        return Inertia::render('Supplier/Edit',[
            'supplier' => $supplier
        ]);
    }
    public function update (){
        return Inertia::render('Supplier/Create');
    }
}
