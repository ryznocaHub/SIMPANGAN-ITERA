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
        $procurements   = ProcurementAccounts::select(['procurement_accounts.id', 'procurement_accounts.name', 'procurement_accounts.status', 'budget_plans.total as total','procurement_accounts.unit', 'timelines.rab_submitted as date'])
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
        $status = ProcurementAccounts::status[User::ROLE_PPK - 1];

        $procurements   = ProcurementAccounts::select(['procurement_accounts.id', 'procurement_accounts.user_id', 'procurement_accounts.name', 'procurement_accounts.account', 'procurement_accounts.status', 'estimates.total as total', 'timelines.rab_submitted as date'])
            -> join('estimates','procurement_accounts.estimate_id', '=', 'estimates.id')
            -> join('timelines','procurement_accounts.timeline_id', '=', 'timelines.id')
            -> join('executors','procurement_accounts.executor_id', '=', 'executors.id')
            -> where('executors.ppk','=',Auth::id())
            -> where('procurement_accounts.status','>=',$status)
            -> orderBy('procurement_accounts.status')
            -> get()
            -> groupBy('status');
            // -> paginate(100);
        // $grouped        = $procurements  -> groupBy('status');
        // dd($procurements );
        
        return Inertia::render('PPK/Index',[
            // 'procurements'  => $procurements,
            'groupedProc'   => $procurements
        ]);
    }

    public function hps()    
    {   
        $status = ProcurementAccounts::status[User::ROLE_HPS_TEAM - 1];

        $procurements   = ProcurementAccounts::select(['procurement_accounts.id', 'procurement_accounts.user_id', 'procurement_accounts.name', 'procurement_accounts.account', 'procurement_accounts.status', 'estimates.total as total', 'budget_plans.total as rab_total', 'timelines.rab_submitted as date'])
            -> join('estimates','procurement_accounts.estimate_id', '=', 'estimates.id')
            -> join('budget_plans','procurement_accounts.budget_plan_id', '=', 'budget_plans.id')
            -> join('timelines','procurement_accounts.timeline_id', '=', 'timelines.id')
            -> join('executors','procurement_accounts.executor_id', '=', 'executors.id')
            -> where('executors.hps','=',Auth::id())
            -> where('procurement_accounts.status','>=',$status)
            -> orderBy('procurement_accounts.status')
            -> get()
            -> groupBy('status');

        return Inertia::render('Hps/Index',[
            // 'procurements'  => $procurements,
            'groupedProc'   => $procurements
        ]);
    }

    public function pp()    
    {   
        $status = ProcurementAccounts::status[User::ROLE_PP - 1];
        
        $procurements   = ProcurementAccounts::select(['procurement_accounts.id', 'procurement_accounts.user_id', 'procurement_accounts.name', 'procurement_accounts.account', 'procurement_accounts.status', 'estimates.total as total', 'timelines.rab_submitted as date'])
            -> join('estimates','procurement_accounts.estimate_id', '=', 'estimates.id')
            -> join('timelines','procurement_accounts.timeline_id', '=', 'timelines.id')
            -> join('executors','procurement_accounts.executor_id', '=', 'executors.id')
            -> where('procurement_accounts.status','>=',$status)
            -> where('executors.pp','=',Auth::id())
            -> orderBy('procurement_accounts.status')
            -> get()
            -> groupBy('status');
        
        return Inertia::render('Pp/Index',[
            'groupedProc'   => $procurements
        ]);
    }

    public function kontrak()    
    {   
        $status = ProcurementAccounts::status[User::ROLE_CONTRACT_TEAM - 1];

        $procurements   = ProcurementAccounts::select(['procurement_accounts.id', 'procurement_accounts.user_id', 'procurement_accounts.name', 'procurement_accounts.account', 'procurement_accounts.status', 'estimates.total as total', 'timelines.rab_submitted as date'])
            -> join('estimates','procurement_accounts.estimate_id', '=', 'estimates.id')
            -> join('timelines','procurement_accounts.timeline_id', '=', 'timelines.id')
            -> join('executors','procurement_accounts.executor_id', '=', 'executors.id')
            -> where('procurement_accounts.status','>=',$status)
            -> orderBy('procurement_accounts.status')
            -> get()
            -> groupBy('status');

        return Inertia::render('Kontrak/Index',[
            'groupedProc'   => $procurements
        ]);
    }

    public function unit () 
    {
        $procurements   = ProcurementAccounts::select(['procurement_accounts.id', 'procurement_accounts.user_id', 'procurement_accounts.name', 'procurement_accounts.account', 'procurement_accounts.status', 'budget_plans.total as total', 'timelines.rab_submitted as date'])
            -> join('budget_plans','procurement_accounts.budget_plan_id', '=', 'budget_plans.id')
            -> join('timelines','procurement_accounts.timeline_id', '=', 'timelines.id')
            -> where('procurement_accounts.user_id','=',Auth::id())
            -> orderBy('timelines.rab_submitted')
            -> paginate(100);
        // dd($procurements);
        // with('budget_plan', 'timeline') -> orderBy('status') -> get();
        $grouped        = $procurements -> sortBy('status') -> groupBy('status');
        // dd($procurements ,$grouped);
        
        return Inertia::render('Unit/Index',[
            'procurements'  => $procurements,
            'groupedProc'   => $grouped
        ]);
    }

    public function siren () 
    {
        $status = ProcurementAccounts::status[User::ROLE_VerifAccount - 1];

        $procurements   = ProcurementAccounts::select(['procurement_accounts.id', 'procurement_accounts.user_id', 'procurement_accounts.name', 'procurement_accounts.rup_code', 'procurement_accounts.account', 'procurement_accounts.status', 'budget_plans.total as total', 'timelines.rab_submitted as date'])
            -> join('budget_plans','procurement_accounts.budget_plan_id', '=', 'budget_plans.id')
            -> join('timelines','procurement_accounts.timeline_id', '=', 'timelines.id')
            -> where('procurement_accounts.status','>=',$status)
            -> orderBy('procurement_accounts.status')
            -> get()
            -> groupBy('status');
            // -> paginate(100);
        // $grouped        = $procurements  -> groupBy('status');
        // dd($procurements );
        
        return Inertia::render('Siren/Index',[
            // 'procurements'  => $procurements,
            'groupedProc'   => $procurements
        ]);
    }
}
