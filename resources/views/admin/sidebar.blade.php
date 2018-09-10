<nav class="col-md-2 d-none d-md-block bg-light sidebar">
	<div class="sidebar-sticky">
		<ul class="nav flex-column">
			<li class="nav-item"><a class="nav-link {{Route::is('dashboard') ? 'active' : ''}} " href="{{route('admin.dashboard')}}"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
			<li class="nav-item"><a class="nav-link {{Route::is('accessors') ? 'active' : ''}} " href="{{route('admin.accessors.index')}}"><i class="fa fa-user"></i> Accessors</a></li>
			<li class="nav-item"><a class="nav-link {{Route::is('locks') ? 'active' : ''}} " href="{{route('admin.locks.index')}}"><i class="fa fa-lock"></i> Locks</a></li>
		</ul>
	</div>
</nav>