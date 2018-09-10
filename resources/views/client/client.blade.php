<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Clay - Backend Assessment">
		<meta name="author" content="Clay">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<link rel="icon" href="/favicon.ico">

		<title>Clay - Backend Assessment Client</title>

		<link rel="stylesheet" href="{{asset('css/client.css')}}" />
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous" />

		@stack('head')

	</head>

	<body>

		<div id="app">

			<div class="container">
				<div class="row justify-content-center py-4">
					<main role="main" class="col-md-6">
						<app></app>
					</main>
				</div>
			</div>
		</div>

		<script src="{{asset('js/client.js')}}"></script>

		@stack('scripts')

	</body>
</html>
