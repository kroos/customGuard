<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Auth
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		// if ((auth('staff')->check() || auth('student')->check())) {
		// 	return $next($request);
		// }
		foreach (['staff', 'student'] as $guard) {
			if (auth($guard)->check()) {
				auth()->shouldUse($guard);
				return $next($request);
			}
		}
		return redirect('/login')->with('danger', 'Please login');
	}
}
