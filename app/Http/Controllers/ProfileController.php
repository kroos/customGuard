<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Helpers\UserGuardHelper;

class ProfileController extends Controller
{
	/**
	* Display the user's profile form.
	*/
	public function edit(Request $request): View
	{
		$user = UserGuardHelper::auth_user();
		$relate = UserGuardHelper::auth_guard() == 'staff'?$user->belongstouser:$user->belongstostudent;
		return view('profile.edit', [
			'user' => $relate,
		]);
	}

	/**
	* Update the user's profile information.
	*/
	public function update(ProfileUpdateRequest $request): RedirectResponse
	{
		$user = UserGuardHelper::auth_user();
		$relate = UserGuardHelper::auth_guard() == 'staff'?$user->belongstouser:$user->belongstostudent;

		$relate->fill($request->validated());

		if ($relate->isDirty('email')) {
			$relate->email_verified_at = null;
		}

		$relate->save();

		return Redirect::route('profile.edit')->with('status', 'profile-updated');
	}

	/**
	* Delete the user's account.
	*/
	public function destroy(Request $request): RedirectResponse
	{
		$user = UserGuardHelper::auth_user();
		$relate = UserGuardHelper::auth_guard() == 'staff'?$user->belongstouser:$user->belongstostudent;

		$request->validateWithBag('userDeletion', [
			'password' => ['required', 'current_password'],
		]);
		Auth::logout();
		$user->delete();
		// $user->belongstouser->delete();

		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return Redirect::to('/');
	}
}
