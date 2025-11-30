<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
	/**
	 * Display the login view.
	 */
	public function create(): View
	{
		return view('auth.login');
	}

	/**
	 * Handle an incoming authentication request.
	 */
	public function store(LoginRequest $request): RedirectResponse
	{
		$request->validate([
				'username' => ['required', 'string'],
				'password' => ['required', 'string'],
				'login_type' =>['required', 'in:staff,student'],
			],[],[
				'username' => 'Username',
				'password' => 'Password',
				'login_type' => 'Login Type',
			]);
		$guard = $request->login_type === 'staff' ? 'staff' : 'student';

		$credentials = $request->only('username', 'password');

		if (! Auth::guard($guard)->attempt($credentials)) {
			return back()->withErrors([
				'username' => __('Invalid login credentials'),
			]);
		}

		$request->session()->regenerate();

		return $guard === 'staff'
		? redirect()->intended(url('/staff/dashboard'))
		: redirect()->intended(url('/student/dashboard'));
	}


	/**
	 * Destroy an authenticated session.
	 */
	public function destroy(Request $request): RedirectResponse
	{
		// Auth::guard('web')->logout();
		Auth::guard('staff')->logout();
		Auth::guard('student')->logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect('/');
	}
}
