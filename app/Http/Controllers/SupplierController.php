<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SupplierController extends Controller
{
    public function index ()
    {
        $suppliers = Supplier::get();

        // if(Auth::user()->role != User::ROLE_CONTRACT_TEAM || Auth::user()->role != User::ROLE_PP){
            // $suppliers = $suppliers->whereNotNull('npwp');
        // }
        // dd($suppliers);

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
        $request->validate([
            'name'          => 'required|string',
            'pic'           => 'required|string',
            'pic_position'  => 'required|string',
            // 'npwp'          => 'required|string|regex:/^\d{15,20}$/',
            'npwp'          => 'required|string',
            'entity'        => 'required|string',
            'address'       => 'required|string',
            'province'      => 'required|string',
            'regency'       => 'required|string',
            'bank'          => 'required|string',
            'account'       => 'required|string',
            // 'account'       => 'required|string|regex:/^\d{10,16}$/',
        ]);

        Supplier::create([
            'name'          => $request->name,
            'pic'           => $request->pic,
            'pic_position'  => $request->pic_position,
            'npwp'          => $request->npwp,
            'entity'        => $request->entity,
            'address'       => $request->address,
            'province'      => $request->province,
            'regency'       => $request->regency,
            'bank'          => $request->bank,
            'account'       => $request->account,
        ]);

        return Redirect::route('supplier.index');
    }

    public function edit ($id) 
    {
        $supplier = Supplier::find($id);
        return Inertia::render('Supplier/Edit',[
            'supplier' => $supplier
        ]);
    }
    public function update (Request $request, $id){
        $request->validate([
            'name'          => 'required|string',
            'pic'           => 'required|string',
            'pic_position'  => 'required|string',
            'npwp'          => 'required|string',
            'entity'        => 'required|string',
            'address'       => 'required|string',
            'province'      => 'required|string',
            'regency'       => 'required|string',
            'bank'          => 'required|string',
            'account'       => 'required|string',
        ]);

        Supplier::find($id)->update([
            'name'          => $request->name,
            'pic'           => $request->pic,
            'pic_position'  => $request->pic_position,
            'npwp'          => $request->npwp,
            'entity'        => $request->entity,
            'address'       => $request->address,
            'province'      => $request->province,
            'regency'       => $request->regency,
            'bank'          => $request->bank,
            'account'       => $request->account,
        ]);

        return Redirect::route('supplier.show',$id);
    }
}
