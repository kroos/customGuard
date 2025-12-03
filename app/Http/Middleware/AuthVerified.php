<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Helpers\UserGuardHelper;

class AuthVerified
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		$user = UserGuardHelper::auth_user();

		if (!$user || !$user->hasVerifiedEmail()) {
			return $request->expectsJson()
			? abort(403, 'Your email is not verified.')
			: redirect()->route('verification.notice');
		}

		return $next($request);
	}
}
