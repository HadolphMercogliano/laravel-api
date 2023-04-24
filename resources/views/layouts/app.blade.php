<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	{{-- Bootstrap Icons --}}
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

	<!-- Usando Vite -->
	@vite(['resources/js/admin_app.js'])
</head>

<body>
	<div id="app">
		<header>
			@include('partials.navbar')
		</header>

		<main class="main">
			@yield('title')
			<div class="container">
				<div class="w-50 my-3">
					@if (session('message_content'))
						<div class="alert {{ session('message_type') }}">
							{{ session('message_content') }}
						</div>
					@endif
				</div>
			</div>
			@yield('content')
		</main>
	</div>
	@yield('scripts')
</body>

</html>
