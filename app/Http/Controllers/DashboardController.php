<?php

namespace App\Http\Controllers;

use App\Models\ProcurementAccounts;
use App\Models\ProcurementItem;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function headUKPBJ()    
    {   
        $procurements   = ProcurementAccounts::select(['procurement_accounts.id', 'procurement_accounts.name', 'procurement_accounts.status', 'budget_plans.total as total', 'timelines.rab_submitted as date'])
            -> join('budget_plans','procurement_accounts.budget_plan_id', '=', 'budget_plans.id')
            -> join('timelines','procurement_accounts.timeline_id', '=', 'timelines.id')
            -> orderBy('timelines.rab_submitted')
            -> paginate(100);
        // dd($procurements);
        // with('budget_plan', 'timeline') -> orderBy('status') -> get();
        $grouped        = $procurements -> sortBy('status') -> groupBy('status');
        // dd($procurements ,$grouped);
        
        return Inertia::render('Admin/Index',[
            'procurements'  => $procurements,
            'groupedProc'   => $grouped
        ]);
    }
    
    public function ppk()    
    {   
        return Inertia::render('PPK/Index');
    }

    public function hps()    
    {   
        return Inertia::render('Hps/Index');
    }

    public function pp()    
    {   
        return Inertia::render('Pp/Index');
    }

    public function kontrak()    
    {   
        return Inertia::render('Kontrak/Index');
    }

    public function unit () 
    {
        return Inertia::render('Unit/Index');
    }

    public function siren () 
    {
        return Inertia::render('Siren/Index');
    }

    public function Cek()    
    {   
        // dd("s");
        // $users = User::first();
        // dd($users->name);
        // $time = Carbon::now()->setTimezone('Asia/Jakarta');
        // $procurement = ProcurementAccounts::find(1)->with('hpsexecutor')->first();
        // $procurement = User::find(5)->with('hpsProcurement')->first();
        // $procurement = ProcurementAccounts::find(1)->first();
        // dd($procurement);
        $items = ProcurementItem::where('procure_acc_id',1)->get();
        // $user = Auth::user();
    
        // $unit_name = $user->units;
        // $units = Unit::with('users')->find(1);
        // dd($user);
        return Inertia::render('Cek', [
            'items' => $items,
        ]);
    }
}
