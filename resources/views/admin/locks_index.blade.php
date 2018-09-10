@extends('admin.layout')
@section('title', 'Locks')
@section('main')

	<div class="pb-4">
		<a href="{{route('admin.locks.create')}}" class="btn btn-outline-dark"><i class="fa fa-plus"></i> Create new</a>
	</div>

	<table class="table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Location</th>
				<th>Status</th>
				<th>Options</th>
			</tr>
		</thead>
		<tbody>
			@foreach($locks as $lock)
				<tr>
					<td>{{$lock->id}}</td>
					<td>{{$lock->name}}</td>
					<td>{{$lock->location}}</td>
					<td>
						@if($lock->isLocked())
							<div class="badge badge-danger"><i class="fa fa-lock"></i></div>
						@else
							<div class="badge badge-success"><i class="fa fa-unlock"></i></div>
						@endif
					</td>
					<td>
						<a href="{{route('admin.locks.edit', [$lock->id])}}" class="btn btn-sm btn-outline-dark"><i class="fa fa-edit"></i></a>

						<form class="d-inline-block" method="POST" action="{{route('admin.locks.destroy', [$lock->id])}}">
							<button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa fa-edit"></i></button>
						</form>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	{!! $locks->links() !!}

@endsection