<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

use App\Models\Login;
use App\Models\StudentLogin;

class PasswordResetLinkController extends Controller
{
	/**
	* Display the password reset link request view.
	*/
	public function create(): View
	{
		return view('auth.forgot-password');
	}

	/**
	* Handle an incoming password reset link request.
	*
	* @throws \Illuminate\Validation\ValidationException
	*/
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			'login_type' => ['required', 'in:staff,student'],
			'username' => ['required'],
		]);

		$guard = $request->login_type; // 'staff' or 'students' or 'users'

		$broker = match ($guard) {
			'staff' => 'staff',
			'student' => 'student',
			default => 'staff'
		};

		$status = Password::broker($broker)->sendResetLink(
			$request->only('username')
		);

		return $status === Password::RESET_LINK_SENT
		? back()->with('status', __($status))
		: back()->withErrors(['username' => __($status)]);
	}
}
