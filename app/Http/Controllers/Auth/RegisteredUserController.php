<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentLogin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
	/**
	 * Display the registration view.
	 */
	public function create(): View
	{
		return view('auth.register');
	}

	/**
	 * Handle an incoming registration request.
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Student::class],
			'username' => ['required', 'string', 'max:255', 'unique:'.StudentLogin::class],
			'password' => ['required', 'confirmed', Rules\Password::defaults()],
		]);

		$user = Student::create($request->only(['name', 'email']));
		$login = StudentLogin::create([
			'student_id' => $user->id,
			'username' => $request->username,
			'password' => Hash::make($request->password)
		]);

		event(new Registered($login));

		Auth::guard('student')->login($login);
		// $login->createToken('MyApp')->plainTextToken;

		return redirect('/student/dashboard');
	}
}
