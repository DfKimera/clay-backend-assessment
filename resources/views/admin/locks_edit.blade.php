@extends('admin.layout')
@section('title', 'Locks - Edit lock')
@section('main')

	<form method="POST" class="card" action="{{route('admin.locks.save', $lock->id ? [$lock->id] : [])}}">
		@csrf

		<div class="card-header"><i class="fa fa-info"></i> Lock details</div>
		<div class="card-body">
			<div class="form-group">
				<label for="fld-name">Name</label>
				<input id="fld-name" name="name" type="text" class="form-control" required value="{{$lock->name}}" />
			</div>

			<div class="form-group">
				<label for="fld-location">Location</label>
				<input id="fld-location" name="location" type="text" class="form-control" required value="{{$lock->location}}" />
			</div>

			<div class="form-group">
				<label for="fld-clp_id">CLP ID</label>
				<input id="fld-clp_id" name="clp_id" type="text" class="form-control" required value="{{$lock->clp_id}}" />
			</div>

		</div>
		<div class="card-footer">
			<div class="form-group">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
			</div>
		</div>
	</form>

	@if($lock->id)

		<hr />

		<form class="card" method="POST" action="{{route('admin.locks.update_authorized_accessors', [$lock->id])}}">
			@csrf
			<div class="card-header"><i class="fa fa-users"></i> Allowed accessors</div>
			<div class="card-body">
				<div class="row">
					@foreach($accessors->split(2) as $column)
						<div class="col-md-6">
							<table class="table">
								<tbody>
									@foreach($column as $accessor)
										<tr>
											<td><i class="fa fa-user"></i> {{$accessor->name}}</td>
											<td>{{$accessor->email}}</td>
											<td>
												<label class="btn btn-sm btn-light">
													<input type="checkbox" @if(in_array($accessor->id, $allowedAccessorIDs)) checked @endif value="{{$accessor->id}}" name="accessor_ids[]" />
												</label>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					@endforeach
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-sm btn-outline-primary"><i class="fa fa-save"></i> Save</button>
			</div>
		</form>

	@endif

@endsection