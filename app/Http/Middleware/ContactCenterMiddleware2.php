<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class ContactCenterMiddleware2 {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if (Session::has('contact_center_admin')) {
			return $next($request);
		} else {
			return redirect('/contact_center_2');
		}
	}
}
