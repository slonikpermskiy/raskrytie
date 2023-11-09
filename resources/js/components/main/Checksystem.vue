<template>

	<v-container fluid class="maincontainer pa-0 ma-0">

		<v-layout class="masthead white--text text-center bg-image py-0 fillheight" style="background-image: url('/img/header_bg.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center; width: 100%;" id="header">

				<div class="" style="height: 100%; width: 100%;">

					<div class="d-flex align-end" style="background: linear-gradient(to top, rgba(0, 0, 0, 0.45), transparent); height: 50%">	 			
						
						<div class="flex-column justify-center" style="width: 100%">
						
						
							<div class="d-flex justify-center" style="width: 100%">
								<h2 class="text-uppercase mb-0 mt-1 fw-bold" style="width: 90%">Планирование и контроль отчетности в области энергетики</h2>
							</div>

							<div class="d-flex justify-center" style="width: 100%">
								<div class="divider-custom divider-light my-1">
									<div class="divider-custom-line"></div>
									<div class="divider-custom-icon"><i class="fa-solid fa-bolt"></i></div>
									<div class="divider-custom-line"></div>
								</div>
							</div>


						</div>

					</div>	
				
					<div class="flex-column align-start" style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.45), transparent); height: 50%">
						
						<div class="d-flex justify-center" style="width: 100%">

							<v-btn rounded outlined large dark @click="$vuetify.goTo('#about')" class="mt-3">
								Подробнее
								<v-icon class="ml-2">mdi-arrow-down</v-icon>
							</v-btn>

						</div>

					</div>
				</div>

		</v-layout>


		<div class="d-flex justify-center p-0 m-0 pt-8" id="about">
		
			<div class="" style="width: 90%">

				<h2 class="text-center text-uppercase mb-0 fw-bold">О системе</h2>
				<!-- Icon Divider-->
				<div class="divider-custom my-1">
					<div class="divider-custom-line"></div>
					<div class="divider-custom-icon"><i class="fa-solid fa-bolt"></i></div>
					<div class="divider-custom-line"></div>
				</div>
				
				<div class="row mt-6 d-flex justify-center">
					<p class="fs-5" style="text-align: justify; text-justify: inter-word;">Удобрый сервис планирования и контроля отчетности в области энергетики.</p>
				</div>

				<v-row align="center" justify="center" class="ma-0 pa-0 mt-8">

					<v-row align="center" justify="space-around">

						<v-col
							cols="12"
							class="ma-0 px-0"
							v-for="(item, i) in features"
							:key="i">

								<v-card shaped>

									<div class="d-flex flex-no-wrap">

										<v-avatar
											class="ma-5"
											size="64"
											tile>

											<v-img :src="item.img"></v-img>
										</v-avatar>
										
										<div>
											<v-card-title
												class="text-h5 word-break"
												v-text="item.title">
											</v-card-title>
											<v-card-subtitle class="text-subtitle-1" v-text="item.text"></v-card-subtitle>
										</div>

									</div>
								</v-card>

						</v-col>
					</v-row>

				</v-row>
				
			</div>
		</div>


		<div class="d-flex justify-center p-0 m-0 pt-8" id="pricing">
		
			<div class="" style="width: 90%">

				<h2 class="text-center text-uppercase mb-0 fw-bold">Условия использования</h2>
				<!-- Icon Divider-->
				<div class="divider-custom my-1">
					<div class="divider-custom-line"></div>
					<div class="divider-custom-icon"><i class="fa-solid fa-bolt"></i></div>
					<div class="divider-custom-line"></div>
				</div>
				
				<div class="row mt-6 d-flex justify-center">
					<p class="fs-5" style="text-align: justify; text-justify: inter-word;">Каждому зарегистрировавшемуся - Премиум доступ на 3 месяца в подарок.</p>
				</div>

				<v-row align="center" justify="center" class="mt-8 mb-6">

					<v-row align="center" justify="space-around">

						<v-col class="ma-0 col-12 col-md-6">

							<v-card class="pa-3">

								<div class="d-flex justify-center mt-2 mb-5">
                      				<div class="circle1">
                        				<div class="circle2">
                          					<v-img src="/img/paperplane.svg"></v-img>
                        				</div>
                      				</div>
                    			</div>

								<div class="d-flex justify-center text--disabled text-uppercase text-h5 my-2">Стандарт</div>
								<v-divider class="my-2"/>
								<div class="">Создание плана отчетности 
									<v-chip small color="orange white--text font-weight-bold">
										стандартные отчеты
									</v-chip>
								</div>
								<v-divider class="my-2"/>
								<div class="">Добавление своих отчетов
									<v-chip small color="red white--text font-weight-bold">
										нет
									</v-chip>
								</div>
								<v-divider class="my-2"/>
								<div class="">Смена статуса сдачи отчетности (сдано | не сдано)
									<v-chip small color="red white--text font-weight-bold">
										нет
									</v-chip>
								</div>
								<v-divider class="my-2"/>
								<div class="d-flex justify-center text-h5 my-6 indigo--text">Бесплатно</div>
			
							</v-card>

						</v-col>


						<v-col class="ma-0 col-12 col-md-6">

							<v-card class="pa-3">

								<div class="d-flex justify-center mt-2 mb-5">
									<div class="circle1">
										<div class="circle2">
											<v-img src="/img/aeroplane.svg"></v-img>
										</div>
									</div>
								</div>

								<div class="d-flex justify-center text--disabled text-uppercase text-h5 my-2">Премиум</div>
								<v-divider class="my-2"/>
								<div class="">Создание плана отчетности
									<v-chip small color="green white--text font-weight-bold">
										да
									</v-chip>
								</div>
								<v-divider class="my-2"/>
								<div class="">Добавление своих отчетов
									<v-chip small color="green white--text font-weight-bold">
										да
									</v-chip>
								</div>
								<v-divider class="my-2"/>
								<div class="">Смена статуса сдачи отчетности (сдано | не сдано)
									<v-chip small color="green white--text font-weight-bold">
										да
									</v-chip>
								</div>
								<v-divider class="my-2"/>
								<div class="d-flex justify-center text-h5 my-6 indigo--text">500 руб. в месяц</div>

							</v-card>

						</v-col>

					</v-row>

				</v-row>
				
			</div>
		</div>

		<div class="d-flex justify-center p-0 m-0 pt-8" id="contacts">
		
			<div class="" style="width: 90%">

				<h2 class="text-center text-uppercase mb-0 fw-bold">Контакты</h2>
				<!-- Icon Divider-->
				<div class="divider-custom my-1">
					<div class="divider-custom-line"></div>
					<div class="divider-custom-icon"><i class="fa-solid fa-bolt"></i></div>
					<div class="divider-custom-line"></div>
				</div>
				
				<div class="row mt-6 d-flex justify-center">
					<p class="fs-5" style="text-align: justify; text-justify: inter-word;">Свяжитесь с нами, если у Вас возникли дополнительные вопросы или требуется уточняющая информация.</p>
				</div>

				<v-row align="center" justify="center" class="mt-5 mb-10">

					<v-row align="center" justify="space-around">

						<v-col cols="12" class="">

							<v-list-item class="d-flex justify-center">
								<v-list-item-icon>
									<v-icon color="indigo">
										mdi-phone
									</v-icon>
								</v-list-item-icon>

								<div class="d-flex-col">
									<ul>+7-902-643-6676</ul>
									<ul><v-list-item-subtitle>Viber, WhatsApp</v-list-item-subtitle></ul>
								</div>

							</v-list-item>

							<v-list-item class="d-flex justify-center">
								<v-list-item-icon>
									<v-icon color="indigo">
										mdi-email
									</v-icon>
								</v-list-item-icon>

								<div class="d-flex-col">
									<ul>dmitriy@edu-sam.ru</ul>
									<ul><v-list-item-subtitle>Email</v-list-item-subtitle></ul>
								</div>

							</v-list-item>

						</v-col>

					</v-row>

				</v-row>
				
			</div>
		</div>

	</v-container>

</template>


<script>

	import {DateTime} from "luxon";

    export default {
	
		data: () => ({

			features: [
			{
			img: "/img/control.png",
			title: "Контроль отчетности в одном месте",
			text: "Вы больше не забудете о не сданном в госорган отчете. Больше нет необходимости вести заметки в блокноте.",
			},
			{
			img: "/img/knowledge.png",
			title: "Много возможностей",
			text: "Система позволяет создать собственный план отчетности, учитывать какие отчеты в госорганы сданы, а по каким подходят сроки, контролировать факт сдачи отчетности (сдано | не сдано), а также ведет статистику.",
			},
			{
			img: "/img/information.png",
			title: "Много полезной информации",
			text: "По сдаваемым в госорганы отчетам представлена вся необходимая информация: ссылки на постановления и законы, сроки сдачи, кому необходимо сдавать.",
			},
			{
			img: "/img/document.png",
			title: "Пользовательские отчеты",
			text: "В личном кабинете есть возможность добавлять свои собственные отчеты, устанавливать любые сроки сдачи, контролировать факт сдачи отчетности.",
			},
			{
			img: "/img/easy.png",
			title: "Легко использовать",
			text: "Благодаря простому интерфейсу с системой очень легко разобраться.",
			},
			
		],
				
		}),
	
		created () {

		},
				
		watch: {
			
		},
	
		computed: {
			
		},
		
		methods: {
					
		},
    }
</script>

<style scoped>

	.word-break {
		word-break: break-word;
	}
	
	.maincontainer {
		min-width: 480px;
	}

	.wrap-text {
		white-space: normal;
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

	.fillheight {
		height: calc(100vh - 64px);
	}

	.circle1 {
		border-radius: 50%;
		width: 90px;
		height: 90px;
		background-color: #f0f8ff;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.circle2 {
		border-radius: 50%;
		width: 60px;
		height: 60px;
		background-color: #e0effc;
		display: flex;
		align-items: center;
		justify-content: center;
	}

</style>



