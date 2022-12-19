<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index (){
        // $procu = ProcurementAccounts:: groupBy('status')->get();
        $users = User::where('status','=','1') -> get() -> sortBy('role') -> groupBy('role');
        $units = Unit::all();
        // $users = $users->groupBy('status');
        // dd($users);
        return Inertia::render('Admin/Users/Index',[
            'users' => $users,
            'units' => $units
        ]);
    }

    public function usersNonActive (){
        $users = User::where('status','=','0') -> get() -> sortBy('role') -> groupBy('role');
        $units = Unit::all();

        return Inertia::render('Admin/Users/Index',[
            'users' => $users,
            'units' => $units
        ]);
    }

    public function create (){
        $units = Unit::all();

        return Inertia::render('Admin/Users/Create', [
            'units'     => $units,
        ]);
    }

    public function show ($id){
        if(Auth::id() != $id) return abort(403);

        $user = User::with('units')->find($id);

        return Inertia::render('Admin/Users/Show', [
            'user'     => $user,
        ]);
    }

    public function store (Request $request){
        $request->validate([
            'name'              => 'required|string|min:4|max:255',
            'identity_number'   => 'required|string|regex:/\d+[\d+\s*]+/',
            'identity_type'     => 'required', 
            'email'             => 'required|email|unique:users,email|max:255',
            'password'          => ['required',Rules\Password::defaults()],
            'role'              => 'required|digits_between:1,8',
            'unit'              => 'required|exists:units,full_name',
        ],[
            'name.required'     => 'Nama tidak boleh kosong',
            'name.min'          => 'Masukan nama lengkap',
            'name.max'          => 'Nama terlalu panjang',
            'name.string'       => 'Nama berupa huruf',
            'email.required'    => 'Email tidak boleh kosong', 
            'email.unique'      => 'Email sudah terpakai', 
            'email.unique'      => 'Periksa kembali format email', 
            'email.max'         => 'Email terlalu panjang', 
            'password.required' => 'password tidak boleh kosong', 
            'unit.required'     => 'Pilih Unit yang tersedia', 
            'unit.exists'       => 'Unit tidak tersedia', 
            'role.required'     => 'Pilih peran yang tersedia', 
            'role.digits_between'       => 'jabatan tidak tersedia', 
            'identity_number.required'  => 'Nomor identitas tidak boleh kosong',
            'identity_number.regex'     => 'Nomor identitas tidak sesuai format',
            'identity_number.string'    => 'Nomor identitas berupa huruf',
            'identity_type.required'    => 'Tipe identitas tidak boleh kosong',
        ]);
        
        // $stringRole = ['Admin','Pejabat Pembuat Komitmen (PPK)','Pejabat Pengadilan (PP)', 'Tim HPS', 'Tim Kontrak', 'Tim Teknis', 'Unit', 'RAB Checker'];
        // $role       = array_search($request->role, $stringRole);
        // if(!$role) return abort(403);
        $unit = Unit::where('full_name', $request->unit)->firstOrFail();

        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'identity_number'   => $request->identity_number,
            'identity_type'     => $request->identity_type,
            'role'              => $request->role,
            'unit_id'           => $unit->id
        ]);

        $user->units = $unit;

        return Inertia::render('Admin/Users/Show',[
            'user'  => $user,
        ]);
    }

    public function edit ($id) {
        if(Auth::user()->role != User::ROLE_Head_UKPBJ && Auth::id() != $id) return abort(403);
        $user   = User::find($id);
        $units  = Unit::all();

        return Inertia::render('Admin/Users/Edit',[
            'user'      => $user,
            'units'     => $units,
        ]);
    }

    public function update (Request $request, $id) {
        $request->validate([
            'name'              => 'required|string|min:4|max:255',
            'identity_number'   => 'required|string|regex:/\d+[\d+\s*]+/',
            'identity_type'     => 'required', 
            'email'             => 'required|email|unique:users,email,'.$id.'|max:255',
            'password'          => ['required',Rules\Password::defaults()],
            'role'              => 'required|digits_between:1,8',
            'unit'              => 'required|exists:units,full_name',
        ],[
            'name.required'     => 'Nama tidak boleh kosong',
            'name.min'          => 'Masukan nama lengkap',
            'name.max'          => 'Nama terlalu panjang',
            'name.string'       => 'Nama berupa huruf',
            'email.required'    => 'Email tidak boleh kosong', 
            'email.max'         => 'Email terlalu panjang', 
            'password.required' => 'password tidak boleh kosong', 
            'unit.required'     => 'Pilih Unit yang tersedia', 
            'unit.exists'        => 'Unit tidak tersedia', 
            'role.required'     => 'Pilih jabatan yang tersedia', 
            'role.digits_between'       => 'jabatan tidak tersedia', 
            'identity_number.required'  => 'Nomor identitas tidak boleh kosong',
            'identity_number.regex'     => 'Nomor identitas tidak sesuai format',
            'identity_number.string'    => 'Nomor identitas berupa huruf',
            'identity_type.required'    => 'Tipe identitas tidak boleh kosong',
        ]);
        $user = User::find($id);
        // $stringRole = ['','Pejabat Pembuat Komitmen (PPK)','Pejabat Pengadilan (PP)', 'Tim HPS', 'Tim Kontrak', 'Tim Teknis', 'Unit', 'RAB Checker'];
        // $role       = array_search($request->role, $stringRole);
        // if(!$role) return abort(403);
        $unit = Unit::where('full_name',$request->unit)->firstOrFail();

        // dd($unit);

        $user->update([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'identity_number'   => $request->identity_number,
            'identity_type'     => $request->identity_type,
            'role'              => $request->role,
            'unit_id'           => $unit->id,
        ]);

        $user->units = $unit;

        return Inertia::render('Admin/Users/Show',[
            'user'  => $user,
        ]);
    }

    public function nonActiveUser ($id) {
        // dd($id);
        $user = User::find($id);
        $user = $user->update([
            'status'    => 0,
        ]); 
    }

    public function activeUser ($id) {
        $user = User::find($id);
        $user = $user->update([
            'status'    => 1,
        ]); 
    }
}
