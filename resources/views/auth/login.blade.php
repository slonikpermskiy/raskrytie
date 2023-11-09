<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, shrink-to-fit=no" />
	
	<title>Вход в систему отчетности</title>
	
	<!-- Favicon-->
	<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
	
	<!-- Font Awesome icons -->
	<script src="https://kit.fontawesome.com/bb86c29e96.js" crossorigin="anonymous"></script>
	
	<!-- Scripts -->
	<script src="{{ asset('js/app.js') }}" defer></script>
	
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	<style>
		@font-face {
			font-family: Nunito;
			src: url('{{asset('/fonts/Nunito-Regular.ttf')}}');
		}
	</style>
	

</head>
<body id="main" style="min-width: 480px !important;">
    <div class="maincontainer">
		<div id="app" class="h-full">
		
			<login-page token="{{ Request::get('token') ? Request::get('token') : '' }}" useremail="{{ Request::get('email') ? Request::get('email') : '' }} "></login-page>
		
		</div>
    </div>
</body>
</html>


