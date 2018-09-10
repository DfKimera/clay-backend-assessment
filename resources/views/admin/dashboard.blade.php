@extends('admin.layout')
@section('main')

	<div class="row">
		<div class="col-md-12">
			<h3>Welcome</h3>

			<p>Welcome to Clay's admin panel!</p>

			<hr />

			<h3><i class="fa fa-history"></i> Last accesses</h3>

			<table class="table">
				<tbody>
					@foreach($recentAccesses as $access)
						<tr>
							<td>{{$access->accessor->name}}</td>
							<td>
								@if($access->access_type === \Clay\Access::UNLOCK)
									<strong class="text-success">unlocked</strong>
								@else
									<strong class="text-danger">locked</strong>
								@endif
							</td>
							<td>{{$access->lock->name}}</td>
							<td>{{$access->lock->name}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection