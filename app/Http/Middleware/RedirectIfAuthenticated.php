<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $route = '';
                switch (Auth::user()->role) {
                    # Head UKPBJ
                    case User::ROLE_Head_UKPBJ:
                      $route = '/admin/dashboard';
                    break;
                
                    # PPK
                    case User::ROLE_PPK:
                      $route = '/ppk/dashboard';
                    break;
                
                    # PP
                    case User::ROLE_PP:
                      $route = '/pp/dashboard';
                    break;
                
                    # HPS Team
                    case User::ROLE_HPS_TEAM:
                      $route = '/hps/dashboard';
                    break;
                
                    # Contract Team
                    case User::ROLE_CONTRACT_TEAM:
                      $route = '/kontrak/dashboard';
                    break;
                
                    # Technical Team
                    case User::ROLE_TECHNICAL_TEAM:
                      $route = '/teknis/dashboard';
                    break;
                
                    # unit
                    case User::ROLE_UNIT:
                      $route = '/unit/dashboard';
                    break;
                
                    case User::ROLE_VerifAccount:
                      $route = '/siren/dashboard';
                    break;
                    
                    default: break;
                }

                return redirect($route);
            }
        }

        return $next($request);
    }
}
