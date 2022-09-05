<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function unit () {
        return Inertia::render('Unit/Index');
    }

    public function TimHPS()    
    {   
        // dd("s");
        // $users = User::first();
        // dd($users->name);
        return Inertia::render('TimHPS/Index');
    }

    public function Cek()    
    {   
        // dd("s");
        // $users = User::first();
        // dd($users->name);
        return Inertia::render('Cek');
    }
}
