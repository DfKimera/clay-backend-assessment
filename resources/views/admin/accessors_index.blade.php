@extends('admin.layout')
@section('title', 'Accessors')
@section('main')

	<div class="pb-4">
		<a href="{{route('admin.accessors.create')}}" class="btn btn-outline-dark"><i class="fa fa-plus"></i> Create new</a>
	</div>

	<table class="table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>E-mail</th>
				<th>Options</th>
			</tr>
		</thead>
		<tbody>
			@foreach($accessors as $accessor)
				<tr>
					<td>{{$accessor->id}}</td>
					<td>{{$accessor->name}}</td>
					<td>{{$accessor->email}}</td>
					<td>
						<a href="{{route('admin.accessors.edit', [$accessor->id])}}" class="btn btn-sm btn-outline-dark"><i class="fa fa-edit"></i></a>

						<form class="d-inline-block" method="POST" action="{{route('admin.accessors.destroy', [$accessor->id])}}">
							<button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa fa-edit"></i></button>
						</form>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	{!! $accessors->links() !!}

@endsection