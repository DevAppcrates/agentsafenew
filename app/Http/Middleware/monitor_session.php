<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class monitor_session
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

        if(Session::has('monitor_admin')){

        return $next($request);
        }else{
            return redirect('/monitor-hub?returnUrl='.urlencode($request->fullUrl()));
        }
    }
}
