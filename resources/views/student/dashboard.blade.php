@extends('layouts.app')

@section('content')
<div class="col-sm-12 d-flex flex-column align-items-center justify-content-center">
<?php
// if (request()->session()->missing('users')) {
// 	request()->session()->put('users', \Auth::user());
// }
// dd(request()->session()->all(), \Auth::user())
// request()->session()->flush();
?>
	<h3>Dashboard</h3>
	<p class="text-gray text-center">You're logged in!</p>

	<div class="card col-sm-6">
		<div class="card-header">Student</div>
		<div class="card-body">
		</div>
	</div>


</div>
@endsection

@section('js')
@endsection
