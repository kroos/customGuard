<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
	<div class="container-fluid">
		<a
			class="navbar-brand"
			@if(auth('staff')->check())
				href="{{ url('staff/dashboard') }}"
			@endif
			@if(auth('student')->check())
				href="{{ url('student/dashboard') }}"
			@endif
			@guest
				href="{{ url('/') }}"
			@endguest
		>
			{!! config('app.name') !!}<img src="">
		</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarColor01">
			<!-- <ul class="navbar-nav me-auto"> -->
			<ul class="navbar-nav mx-auto">

				@if(auth('staff')->check())
					@include('layouts.staff-navigation')
				@endif
				@if(auth('student')->check())
					@include('layouts.student-navigation')
				@endif
				@if(!auth('staff')->check() && !auth('student')->check())
					<!-- guest link -->
				@endif
			</ul>
			@if (Route::has('login'))


				@if(auth('staff')->check())
					<div class="dropdown me-5">
						<a href="#" class="btn btn-sm btn-outline-secondary dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							@if(\Auth::guard('staff')->user()->belongstouser->unreadNotifications?->count())<span class="badge text-bg-warning">{{ \Auth::guard('staff')->user()->belongstouser->unreadNotifications->count() }}</span>@endif
              {{ Auth::guard('staff')->user()->belongstouser->name }}
            </a>
						<ul class="dropdown-menu">
							<li>
								<a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fa-regular fa-user"></i> Profile</a>
							</li>
							<li>
								<!-- notification -->
								@include('layouts.staff-notification')
							</li>
							<li>
								<form method="POST" action="{{ route('logout') }}">
									@csrf
									<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"><i class="fas fa-light fa-right-from-bracket"></i> Log Out</a>
								</form>
							</ul>
								</li>
					</div>
				@endif






				@if(auth('student')->check())
					<div class="dropdown me-5">
						<a href="#" class="btn btn-sm btn-outline-secondary dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							@if(\Auth::guard('student')->user()->belongstostudent->unreadNotifications?->count())
								<span class="badge text-bg-warning">
									{{ \Auth::guard('student')->user()->belongstostudent->unreadNotifications->count() }}
								</span>
							@endif
              {{ Auth::guard('student')->user()->belongstostudent->name }}
            </a>
						<ul class="dropdown-menu">
							<li>
								<a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fa-regular fa-user"></i> Profile</a>
							</li>
							<li>
								<!-- notification -->
								@include('layouts.student-notification')
							</li>
							<li>
								<form method="POST" action="{{ route('logout') }}">
									@csrf
									<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
										<i class="fas fa-light fa-right-from-bracket"></i> Log Out
									</a>
								</form>
							</ul>
								</li>
					</div>
				@endif





				@if(!auth('staff')->check() && !auth('student')->check())
					<a class="btn btn-sm btn-secondary {{ (Route::has('register'))?'me-1':'me-5' }}"
						href="{{ route('login') }}">
						Sign in
					</a>
					@if (Route::has('register'))
						<a href="{{ route('register') }}" class="btn btn-sm btn-secondary me-5">Sign up</a>
					@endif
				@endguest

			@endif
		</div>
	</div>
</nav>

