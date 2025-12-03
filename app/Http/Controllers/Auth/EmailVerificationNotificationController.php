<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use App\Helpers\UserGuardHelper;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if (UserGuardHelper::auth_user()->hasVerifiedEmail()) {
            return redirect()->intended(url(UserGuardHelper::auth_guard().'/dashboard', absolute: false));
        }

        UserGuardHelper::auth_user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
