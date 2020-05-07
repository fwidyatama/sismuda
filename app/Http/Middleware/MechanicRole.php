<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class MechanicRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userRole = Auth::user()->id_role;
        if($userRole==2){
            
            return $next($request);
        }
        else{
            Auth::logout();
            return redirect()->to('/')->with('status', 'Anda tidak punya hak akses untuk halaman ini');
        }
    }
    }

