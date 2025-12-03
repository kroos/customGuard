@extends('layouts.app')

@section('content')
<div class="col-sm-12 d-flex flex-column align-items-center justify-content-center">
	<form method="POST" action="{{ route('password.email') }}" id="form" class="needs-validation">
		@csrf

		<div class="card">
			<div class="card-header">
				<h3>Forgot your password? No problem. Just let us know your username and we will email you a password reset link that will allow you to choose a new one.</h3>
			</div>
			<div class="card-body">

				<div class="form-group row m-2 @error('login_type') has-error @enderror">
					<label class="col-sm-4 col-form-label col-form-label-sm">Login Type : </label>
					<div class="col-sm-8 my-auto form-check ">
						<div class="btn-group @error('login_type') is-invalid @enderror" role="group" aria-label="Basic radio toggle button group">
							<input type="radio" name="login_type" value="staff" id="btnradio1" class="btn-check @error('login_type') is-invalid @enderror" {{ (old('login_type') === 'staff')?'checked':NULL }}>
							<label class="btn btn-sm btn-outline-primary" for="btnradio1">Staff</label>
							<input type="radio" name="login_type" value="student" id="btnradio2" class="btn-check @error('login_type') is-invalid @enderror" {{ (old('login_type') === 'student')?'checked':NULL }}>
							<label class="btn btn-sm btn-outline-primary" for="btnradio2">Student</label>
						</div>
						@error('login_type') <div class="invalid-feedback fw-lighter">{{ $message }}</div> @enderror
					</div>
				</div>






				<div class="form-group row m-2 @error('username') has-error @enderror">
					<label for="username" class="col-sm-4 col-form-label col-form-label-sm">Username : </label>
					<div class="col-sm-8">
						<input type="text" name="username" id="username" value="{{ old('username') }}" class="form-control form-control-sm @error('username') is-invalid @enderror" placeholder="Username">
						@error('username') <div class="invalid-feedback fw-lighter">{{ $message }}</div> @enderror
					</div>
				</div>
			</div>
			<div class="card-footer">
				<div class="m-0">
					<button type="submit" class="btn btn-sm btn-primary m-3">
						{{ __('Password Reset Link') }}
					</button>
				</div>
			</div>
		</div>

	</form>
</div>
@endsection

@section('js')
@endsection
