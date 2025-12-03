<?php
namespace App\Helpers;

class UserGuardHelper
{
	public function __construct()
	{
		$this->middleware(['userauth']);
	}

	public static function auth_user() {
		return auth('staff')->user() ?? auth('student')->user();
	}

	public static function auth_guard() {
		return auth('staff')->check() ? 'staff' : 'student';
	}

}
