@extends('layouts.app')

@section('content')

	@if (session('status') == 'verification-link-sent')
		<div class="my-4 col-sm-12 text-sm text-center text-success">
			{{ __('A new verification link has been sent to the email address you provided during registration.') }}
		</div>
	@endif

	<div class="col-sm-12 row mx-auto justify-content-center">
				<div class="card">
					<div class="card-header">
						Verification Link Request
					</div>
					<div class="card-body">
						<form method="POST" action="{{ route('verification.send') }}" id="form" class="needs-validation">
							@csrf
							<div class="col-sm-12 d-flex flex-column align-items-center justify-content-center">
								<h6>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</h6>
					</div>
					<div class="card-footer row  justify-content-center">

						<div class="col-sm-4">
							<button type="submit" class="btn btn-sm btn-primary m-0">
								{{ __('Resend Verification Email') }}
							</button>
						</div>
					</form>
						<div class="col-sm-4">
							<form method="POST" action="{{ route('logout') }}" id="form" class="needs-validation">
								@csrf
								<div class="col-sm-12 text-start">
									<button type="submit" class="btn btn-sm btn-primary m-0">
										{{ __('Log Out') }}
									</button>
								</div>
							</form>
						</div>

					</div>
				</div>


	</div>

</div>
@endsection

@section('js')
@endsection
