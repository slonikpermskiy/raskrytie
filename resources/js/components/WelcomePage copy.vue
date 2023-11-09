<template>

  
	<v-app id="inspire" class="maincontainer">

		<v-overlay :value="drawer" z-index="4">
		</v-overlay>
		
		<v-navigation-drawer v-model="drawer" app clipped dark hide-overlay disable-resize-watcher color="menuicons" right width="280" :style="{ top: $vuetify.application.top + 'px', zIndex: 6 }">
					
			<v-list dense class="my-0 py-0">
				<v-list-item class="my-2" link @click="scrollandclose('about'), drawer = false">О СИСТЕМЕ</v-list-item>
				<v-list-item class="my-2" link @click="scrollandclose('conditions'), drawer = false">УСЛОВИЯ</v-list-item>
				<v-list-item class="my-2" link @click="scrollandclose('services'), drawer = false">УСЛУГИ</v-list-item>
				<v-list-item class="mt-2 mb-4" link @click="scrollandclose('contacts'), drawer = false">КОНТАКТЫ</v-list-item>
			</v-list>

			<template>	  
				<div class="px-4">
					<v-btn @click="drawer = false" href="/lk" outlined>Личный кабинет</v-btn>
				</div>
			</template>
		  
		  
		</v-navigation-drawer>

		<v-app-bar app clipped-right dark height="64" color="menuicons" style="z-index: 100;">
		  
		  <v-img class="mx-2 imghover" src="/img/logo.png" max-height="40" max-width="40" contain @click="scroll('header')"></v-img>
		
			<div v-scroll-spy-active="{selector: 'a.nav-link', class: 'active'}" v-scroll-spy-link="{selector: 'a.nav-link'}" data-scroll-spy-id="1" class="d-none d-md-block">
				<div class="d-inline mx-5">
					<a class="nav-link text-decoration-none text-uppercase font-weight-bold p-0 p-lg-0 pt-3" onclick="event.preventDefault()">О системе</a>
				</div>
				<div class="d-inline mx-5">
					<a class="nav-link text-decoration-none text-uppercase font-weight-bold p-0 p-lg-0 pt-3" onclick="event.preventDefault()">Условия</a>
				</div>
				<div class="d-inline mx-5">
					<a class="nav-link text-decoration-none text-uppercase font-weight-bold p-0 p-lg-0 pt-3" onclick="event.preventDefault()">Услуги</a>
				</div>
				<div class="d-inline mx-5">
					<a class="nav-link text-decoration-none text-uppercase font-weight-bold p-0 p-lg-0 pt-3" onclick="event.preventDefault()">Контакты</a> 
				</div>
			</div>

			<v-spacer></v-spacer>
			
			<div class="d-none d-md-block">
			
				<div class="px-4">
					<v-btn href="/lk" outlined>Личный кабинет</v-btn>
				</div>
			
			</div>
	
	
			<v-app-bar-nav-icon @click.stop="drawer = !drawer" color="white" class="d-block d-md-none mx-2">
	
			</v-app-bar-nav-icon>
		  
		  
		</v-app-bar>
	
	
		<!-- Masthead-->
        <header class="masthead white--text text-center bg-image py-0" style="background-image: url('/img/header_bg.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center; height: 100vh" id="header">
			 
			 <div class="" style="padding-top: 64px; height: 100%">

				<div class="d-flex align-end" style="background: linear-gradient(to top, rgba(0, 0, 0, 0.45), transparent); height: 50%">	 			
					<div class="d-flex justify-center" style="width: 100%">
						<h2 class="text-uppercase mb-0 mt-1 fw-bold" style="width: 90%">Планирование и контроль отчетности в области энергетики</h2>
					</div>
				</div>	
			 
				<div class="d-flex align-start pt-2" style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.45), transparent); height: 50%">
					<div class="d-flex justify-center" style="width: 100%">
						<div class="divider-custom divider-light my-1">
							<div class="divider-custom-line"></div>
							<div class="divider-custom-icon"><i class="fa-solid fa-bolt"></i></div>
							<div class="divider-custom-line"></div>
						</div>
					</div>	
				</div>
			 
			 </div>

        </header>
		
		<div v-scroll-spy="{allowNoActive: true, offset: 64, time: 300, steps: 30}" data-scroll-spy-id="1">
		
				
			<!-- About Section-->
			<div class="d-flex justify-center p-0 m-0 pt-8" id="about">

				
				<div class="" style="width: 90%">

					<h2 class="text-center text-uppercase mb-0 fw-bold">О системе</h2>
					<!-- Icon Divider-->
					<div class="divider-custom my-1">
						<div class="divider-custom-line"></div>
						<div class="divider-custom-icon"><i class="fa-solid fa-bolt"></i></div>
						<div class="divider-custom-line"></div>
					</div>
					
					<div class="row mt-6">
						<div class="ms-auto"><p class="fs-5" style="text-align: justify; text-justify: inter-word;">Olson 22 - небольшая шведская парусная килевая яхта, предназначенная для непродолжительных прогулок (дейсейлер). Яхты Ohlson 22 выпускались с 1969 по 1979 год на верфи Fisksa Varv (Швеция). Яхта достаточно комфортабельна для своего класса, имеет хорошие мореходные качества и достаточный уровень безопасности.</p></div>
					</div>
					

					
					<v-row no-gutters>
					
						<v-col cols="12" md="6" lg="6" xl="6" class="ms-auto mt-8">
							
							<p class="font-weight-bold text-h6 text-uppercase">ХАРАКТЕРИСТИКИ:</p>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Вместимость - 4 человека (не считая экипажа)</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Длина корпуса - 6,5 м.</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Ширина корпуса - 2,45 м.</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Материал корпуса – стеклопластик</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Осадка - 1,25 м.</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Водоизмещение - 1,6 т.</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Подвесной двигатель</p>
								</div>
							</div>

						</v-col>
						
						<v-col cols="12" md="6" lg="6" xl="6" class="me-auto mt-8">
						
							<p class="font-weight-bold text-h6 text-uppercase">ИНТЕРЬЕР:</p>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Высота в каюте - 1,45 м.</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Количество спальных мест - 4</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Мягкий салон</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Раскладной столик</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Небольшой камбуз (кухня)</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Биотуалет</p>
								</div>
							</div>
							
						</v-col>
					
					</v-row>
					
				</div>
			</div>
			
			
			<!-- Conditions Section-->			
			<div class="d-flex justify-center p-0 m-0 pt-8" id="conditions">
	
				<div class="" style="width: 90%">
			
					<h2 class="text-center text-uppercase mb-0 fw-bold">Условия использования</h2>
					<!-- Icon Divider-->
					<div class="divider-custom my-1">
						<div class="divider-custom-line"></div>
						<div class="divider-custom-icon"><i class="fa-solid fa-bolt"></i></div>
						<div class="divider-custom-line"></div>
					</div>

					<v-row no-gutters>
					
						<v-col cols="12" md="4" lg="4" xl="4" class="ms-auto mt-6">

							<v-card height="100%" elevation="3" class="me-md-4">
					
								<v-card-title>Стоимость</v-card-title>
						

								<v-card-text>
									<p class="py-1">Понедельник - четверг: 1800 руб. в час</p>
									<p class="py-1">Пятница - воскресенье: 2500 руб. в час</p>
								</v-card-text>
							
							</v-card>
						
						</v-col>
						
						<v-col cols="12" md="4" lg="4" xl="4" class="ms-auto mt-6">	
						
							
							<v-card height="100%" elevation="3" class="me-md-4">
							 
								<v-card-title>Время</v-card-title>
			
								<v-card-text>
									<p class="py-1">Минимальное время аренды - 2 часа</p>
									<p class="py-1">Максимальное время аренды - 8 часов</p>
								</v-card-text>
								
							</v-card>

						</v-col>
						
						<v-col cols="12" md="4" lg="4" xl="4" class="ms-auto mt-6">

							<v-card height="100%" elevation="3" class="">

								<v-card-title>Предоплата</v-card-title>


								<v-card-text>
									<p class="py-1">20% от стоимости поездки</p>
									<p class="py-1">В случае отмены поездки с нашей стороны (например из-за плохой погоды), вернем предоплату или перенесем дату поездки на другое удобное время.</p>
								</v-card-text>
							
							</v-card>

						</v-col>
					
					</v-row>
					
					
					<v-row no-gutters>
					
						<v-col cols="12" class="mt-10">
							
							<p class="font-weight-bold text-h6 text-uppercase">ПРАВИЛА ПОВЕДЕНИЯ НА СУДНЕ:</p>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">На яхту заходят только в чистой обуви или разуваются. Нельзя заходить на яхту в обуви с черной подошвой, которая оставляет следы на палубе, и в обуви на каблуках.</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Все ценные вещи лучше оставить в каюте. Не оставляйте вещи без присмотра на палубе и в кокпите.</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Будьте внимательны при поворотах и изменении курса яхты. При движении под парусами ходить по палубе можно только после разрешения капитана.</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Дети в течение всей прогулки обязаны быть в спасательных жилетах.</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Строго придерживайтесь советов и рекомендаций капитана и действуйте только по его команде.</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Не засоряйте окружающую среду. Нельзя бросать неорганические отходы за борт.</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Соблюдайте чистоту на яхте.</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Курение возможно только после разрешения капитана.</p>
								</div>
							</div>

						</v-col>
						
					</v-row>

				</div>
				
			</div>
			
			
			<!-- Services Section-->
			<div class="d-flex justify-center p-0 m-0 pt-8" id="services">

				
				<div class="" style="width: 90%">

					<h2 class="text-center text-uppercase mb-0 fw-bold">Дополнительные услуги</h2>
					<!-- Icon Divider-->
					<div class="divider-custom my-1">
						<div class="divider-custom-line"></div>
						<div class="divider-custom-icon"><i class="fa-solid fa-bolt"></i></div>
						<div class="divider-custom-line"></div>
					</div>
					
					<div class="row mt-6">
						<div class="ms-auto"><p class="fs-5" style="text-align: justify; text-justify: inter-word;">Olson 22 - небольшая шведская парусная килевая яхта, предназначенная для непродолжительных прогулок (дейсейлер). Яхты Ohlson 22 выпускались с 1969 по 1979 год на верфи Fisksa Varv (Швеция). Яхта достаточно комфортабельна для своего класса, имеет хорошие мореходные качества и достаточный уровень безопасности.</p></div>
					</div>
					

					
					<v-row no-gutters>
					
						<v-col cols="12" md="6" lg="6" xl="6" class="ms-auto mt-8">
							
							<p class="font-weight-bold text-h6 text-uppercase">ХАРАКТЕРИСТИКИ:</p>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Калькулятор расчета платы за технологическое присоединение</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Сдадим отчетность ЕИАС за вас, заполним формы</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Ширина корпуса - 2,45 м.</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Материал корпуса – стеклопластик</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Осадка - 1,25 м.</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Водоизмещение - 1,6 т.</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Подвесной двигатель</p>
								</div>
							</div>

						</v-col>
						
						<v-col cols="12" md="6" lg="6" xl="6" class="me-auto mt-8">
						
							<p class="font-weight-bold text-h6 text-uppercase">ИНТЕРЬЕР:</p>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Высота в каюте - 1,45 м.</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Количество спальных мест - 4</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Мягкий салон</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Раскладной столик</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Небольшой камбуз (кухня)</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Биотуалет</p>
								</div>
							</div>
							
						</v-col>
					
					</v-row>
					
				</div>
			</div>
			
			
			
			
			<!-- Contacts Section-->
			<div class="d-flex justify-center p-0 m-0 py-8" id="contacts">
	
				<div class="" style="width: 90%">
			
					<h2 class="text-center text-uppercase mb-0 fw-bold">Контакты</h2>
					<!-- Icon Divider-->
					<div class="divider-custom my-1">
						<div class="divider-custom-line"></div>
						<div class="divider-custom-icon"><i class="fa-solid fa-bolt"></i></div>
						<div class="divider-custom-line"></div>
					</div>

					<v-row no-gutters>
					
						<v-col cols="12" md="4" lg="4" xl="4" class="ms-auto mt-6">

							<v-card height="100%" elevation="3" class="me-md-4">
					
								<v-card-title>Стоимость</v-card-title>
						

								<v-card-text>
									<p class="py-1">Понедельник - четверг: 1800 руб. в час</p>
									<p class="py-1">Пятница - воскресенье: 2500 руб. в час</p>
								</v-card-text>
							
							</v-card>
						
						</v-col>
						
						<v-col cols="12" md="4" lg="4" xl="4" class="ms-auto mt-6">	
						
							
							<v-card height="100%" elevation="3" class="me-md-4">
							 
								<v-card-title>Время</v-card-title>
			
								<v-card-text>
									<p class="py-1">Минимальное время аренды - 2 часа</p>
									<p class="py-1">Максимальное время аренды - 8 часов</p>
								</v-card-text>
								
							</v-card>

						</v-col>
						
						<v-col cols="12" md="4" lg="4" xl="4" class="ms-auto mt-6">

							<v-card height="100%" elevation="3" class="">

								<v-card-title>Предоплата</v-card-title>


								<v-card-text>
									<p class="py-1">20% от стоимости поездки</p>
									<p class="py-1">В случае отмены поездки с нашей стороны (например из-за плохой погоды), вернем предоплату или перенесем дату поездки на другое удобное время.</p>
								</v-card-text>
							
							</v-card>

						</v-col>
					
					</v-row>

				</div>
				
			</div>
			
		</div>

			
        <!-- Copyright Section-->
        <div class="copyright py-4 text-center white--text">
            <div class=""><small>Copyright &copy; 2022 SlonikPermskiy</small></div>
        </div>
		

  </v-app>

		
		
</template>



<script>

import {computed, inject, ref} from "vue";


export default {
	setup() {
  
	},
	methods: {
		scroll(section) {
			const element = document.getElementById(section);
			element.scrollIntoView({ behavior: 'smooth' });
		},
		scrollandclose(section) {
			var element = document.getElementById(section);
			var headerOffset = 64;
			var elementPosition = element.getBoundingClientRect().top;
			var offsetPosition = elementPosition + window.pageYOffset - headerOffset;
  
			window.scrollTo({
				 top: offsetPosition,
				 behavior: "smooth"
			});
		},
		onResize () {
			if (window.innerWidth > 959) {
			this.drawer = false
			}
		},
	},
	data () {
      return {
        drawer: false,
      }
    },
	mounted () {
      this.onResize()
      window.addEventListener('resize', this.onResize, { passive: true })
    },
	beforeDestroy () {
      if (typeof window === 'undefined') return

      window.removeEventListener('resize', this.onResize, { passive: true })
    },

};


</script>


<style scoped>

	a.nav-link:hover {
		color: #1abc9c;
	}
	a.nav-link {
		color: #fff;
	}	
	a.nav-link.active {
		color: #1abc9c;
	}			
	.maincontainer {
		min-width: 480px;
	}	
	.imghover:hover {
		cursor: pointer;
	}
	.divider-custom {
		width: 100%;
		display: flex;
		justify-content: center;
		align-items: center;
	}
	.divider-custom .divider-custom-line {
		width: 100%;
		max-width: 7rem;
		height: 0.25rem;
		background-color: #2c3e50;
		border-radius: 1rem;
		border-color: #2c3e50;
	}
	.divider-custom .divider-custom-line:first-child {
		margin-right: 1rem;
	}
	.divider-custom .divider-custom-line:last-child {
		margin-left: 1rem;
	}
	.divider-custom .divider-custom-icon {
		color: #2c3e50;
		font-size: 2rem;
	}
	.divider-custom.divider-light .divider-custom-line {
		background-color: #fff;
	}
	.divider-custom.divider-light .divider-custom-icon {
		color: #fff;
	}
	.footer {
		padding-top: 5rem;
		padding-bottom: 5rem;
		background-color: #2c3e50;
		color: #fff;
	}

	.copyright {
		background-color: #1a252f;
	}

</style>

