<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Kontrak
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {

            if(Auth::user()->status == 0) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
    
                throw ValidationException::withMessages([
                    'email'  => "Akun anda sudah tidak aktif, silahkan hubungi pihak pengadaan",
                ]);
            }

            $role = Auth::user()->role;
            if ($role == User::ROLE_CONTRACT_TEAM) {
                return $next($request);
            } else {
                abort(403);
            }
        } else {
            return redirect('login');
        }
    }
}
