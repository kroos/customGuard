<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Helpers\UserGuardHelper;

class EmailVerificationPromptController extends Controller
{
	/**
	 * Display the email verification prompt.
	 */
	public function __invoke(Request $request): RedirectResponse|View
	{
		// dd(UserGuardHelper::auth_user());
		// return $request->user()->hasVerifiedEmail()
		return UserGuardHelper::auth_user()->hasVerifiedEmail()
					? redirect()->intended(url(UserGuardHelper::auth_guard().'/dashboard'))
					: view('auth.verify-email');
	}
}
