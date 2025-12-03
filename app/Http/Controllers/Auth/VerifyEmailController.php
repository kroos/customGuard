<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
// use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Requests\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

use App\Helpers\UserGuardHelper;

class VerifyEmailController extends Controller
{
	/**
	* Mark the authenticated user's email address as verified.
	*/
	public function __invoke(EmailVerificationRequest $request): RedirectResponse
	{
		if (UserGuardHelper::auth_user()->hasVerifiedEmail()) {
			return redirect()->intended(url(UserGuardHelper::auth_guard().'/dashboard').'?verified=1');
		}

		if (UserGuardHelper::auth_user()->markEmailAsVerified()) {
			event(new Verified(UserGuardHelper::auth_user()));
		}

		return redirect()->intended(url(UserGuardHelper::auth_guard().'/dashboard').'?verified=1');
	}
}
