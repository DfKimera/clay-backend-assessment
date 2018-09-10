<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Clay - Backend Assessment">
		<meta name="author" content="Clay">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<link rel="icon" href="/favicon.ico">

		<title>Clay - Backend Assessment Admin</title>

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous" />
		<link rel="stylesheet" href="{{asset('css/app.css')}}" />

		@stack('head')

	</head>

	<body>

		<div id="app">

			@include('admin.topbar')

			<div class="container-fluid">
				<div class="row">

					@auth
						@include('admin.sidebar')
					@endauth

					<main role="main"
					      @auth class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4" @endauth
					      @guest class="col-12 pt-3 px-4" @endguest
					>
						@include('components.alert')
						@yield('main')
					</main>

				</div>
			</div>
		</div>

		<script src="{{asset('js/app.js')}}"></script>

		@stack('scripts')

	</body>
</html>
