@extends('admin.layout')
@section('main')
	<form class="admin-login my-5" method="POST" action="{{route('auth.login')}}">

		{!! csrf_field() !!}

		<h1 class="h3 mb-3 font-weight-normal text-center">Login</h1>

		<label for="fld-email" class="sr-only">E-mail</label>
		<input type="email" name="email" id="fld-email" class="form-control" placeholder="E-mail" required autofocus>

		<label for="fld-password" class="sr-only">Password</label>
		<input type="password" name="password" id="fld-password" class="form-control" placeholder="Password" required>

		<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in <i class="fa fa-sign-in"></i></button>

	</form>
@endsection