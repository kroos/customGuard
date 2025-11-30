<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('student_logins', function (Blueprint $table) {
			$table->id();
			$table->foreignId('student_id')->nullable()->index();
			$table->string('username')->unique();
			$table->string('password');
			// $table->boolean('active');
			$table->rememberToken();
			$table->timestamps();
			$table->softDeletes('deleted_at', precision: 0);
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('student_logins');
	}
};
