@extends('admin.layout')
@section('title', 'Accessors - Edit accessor')
@section('main')

	<form method="POST" action="{{route('admin.accessors.save', $accessor->id ? [$accessor->id] : [])}}">
		@csrf

		<div class="form-group">
			<label for="fld-name">Name</label>
			<input id="fld-name" name="name" type="text" class="form-control" required value="{{$accessor->name}}" />
		</div>

		<div class="form-group">
			<label for="fld-email">E-mail</label>
			<input id="fld-email" name="email" type="email" class="form-control" required value="{{$accessor->email}}" />
		</div>

		<div class="form-group">
			<label for="fld-password">Password</label>
			<input id="fld-password" name="password" type="password" class="form-control" @if(!$accessor->id) required @endif />
		</div>

		<div class="form-group">
			<label for="fld-clp_id">CLP ID</label>
			<input id="fld-clp_id" name="clp_id" type="text" class="form-control" required value="{{$accessor->clp_id}}" />
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
		</div>

	</form>

@endsection