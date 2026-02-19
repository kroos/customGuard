@extends('layouts.app')

@section('content')
<div class="col-sm-12 row justify-content-center align-items-center my-2 m-0 border border-success">
	<div class="card">
		<div class="card-header d-flex justify-content-between">
			<h3 class="my-auto">Home </h3>
		</div>
		<div class="card-body">
			<h1 class="text-center">{{ config('app.name', 'Laravel') }}</h1>
		</div>

	</div>

</div>
@endsection

@section('js')
@endsection
