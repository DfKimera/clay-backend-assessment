<nav class="navbar navbar-dark sticky-top bg-clay-light flex-md-nowrap p-0">
	<a class="navbar-brand col-sm-3 col-md-2 mr-0" href="/">Clay</a>

	<div class="w-50 text-left text-white">
		<h4 class="my-0">@yield('title')</h4>
	</div>

	<div class="w-25 text-right px-4 text-white">
		@auth
			<i class="fa fa-user"></i> {{auth()->user()->name}}
		@endauth
	</div>

	<ul class="navbar-nav px-3 ">
		<li class="nav-item text-right">
			@auth
				<form method="POST" action="{{route('auth.logout')}}">
					{!! csrf_field() !!}
					<button type="submit" class="bg-clay-light border-0 nav-link">Exit <i class="fa fa-sign-out-alt"></i></button>
				</form>
			@endauth
		</li>
	</ul>
</nav>