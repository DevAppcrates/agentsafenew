<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if($guard == "master_hub"){

             if(Session::has('admin'))
        {
            return redirect('/master-hub/dashboard');
        }
        }else{
            if(Session::has('contact_center_admin'))
            {
                
            return redirect('/dashboard');
            }
        
        }

        return $next($request);
    }
}
