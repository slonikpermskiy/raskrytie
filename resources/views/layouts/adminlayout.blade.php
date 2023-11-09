<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Отчетность ТСО - Панель администратора</title>
	
	<!-- Favicon-->
	<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
	
	<!-- Font Awesome icons -->
	<script src="https://kit.fontawesome.com/bb86c29e96.js" crossorigin="anonymous"></script>
		
	<!-- Google fonts-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	
	<!-- Дополнительные стили -->
	<link rel="stylesheet" type="text/css" href="{{ asset('css/my_styles.css') }}">
	
	<!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
	<script type="text/javascript" src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
	
</head>
<body>

<style>
			
	.mycontainer {
		min-width: 480px;
	}
	
	#mainNav .navbar-nav li.nav-item a.logout_link:hover {
	  color: #dc3545;
	}
	
	
</style>

		<div id="app">
	
        <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top navbar-shrink d-flex align-items-center p-0 m-0" id="mainNav"  style="height: 72px !important; min-width: 320px !important;">
            
			<div class="container-fluid bg-secondary">
                					
				<div class="navbar-brand p-0 m-0 mx-3" style="height: 72px !important;">				
					<div class="h-100 d-flex align-items-center">				
						<a href="/" class="p-0 m-0" >
							<img src="{{ asset('img/logo.png') }}" height="50">					
						</a>
					
						@if (Request::is('adminaccesspanel/login'))				
							<div class="me-auto m-0">
								<div class="h6 align-middle d-inline-flex m-0 px-2 text-white">Панель администратора</div>         																
							</div>
						@endif
					
					</div>				
				</div>
				

				@if (Request::is('adminaccesspanel/login'))				
					
				@else
					<button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded mx-3 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive">
						Меню
						<i class="fas fa-bars"></i>
					</button>

					<div class="collapse navbar-collapse mx-3" id="navbarResponsive">
			   
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto m-0">

						<li class="nav-item mx-0 mx-lg-1"><router-link :to="{name: 'Users'}" active-class="active" class="nav-link  p-0 p-lg-0 pt-3 px-0 px-lg-3 rounded">Пользователи</router-link></li>
						<li class="nav-item mx-0 mx-lg-1"><router-link :to="{name: 'Example'}" active-class="active" class="nav-link p-0 p-lg-0 pt-3 px-0 px-lg-3 rounded">Формы</router-link></li>

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto m-0">
                        <!-- Authentication Links -->
								
						<li class="nav-item m-0 mx-0 mx-lg-1">						
							<a name="logout_link"  id='logout_link' class="logout_link nav-item nav-link p-0 p-lg-0 py-3 px-0 px-lg-3 d-flex justify-content-start border-primary" href="{{ route('adminLogout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
								Выйти
							</a>
						</li>

						<form id="logout-form" action="{{ route('adminLogout') }}" method="POST" style="display: none;">
							@csrf
						</form>

                    </ul>
                </div>
					
				@endif
				
			</div>
            
        </nav>

		

			<main name="main" id="main" class="container-fluid mycontainer">
			
				<div class="h-100 my-5" style="padding-top: 72px;">
				
					@yield('content')
				
				</div>
				
			</main>
		
		</div>
	
</body>

<script>
	
	// Установка высоты контента
	var minheight = $(window).height() - $('#navbar').outerHeight() - parseInt($('#main').css("marginTop").replace('px', ''))*2;
	document.getElementById("central_area").style.minHeight = minheight +"px";
		
</script>

</html>
