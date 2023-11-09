<template>

	<v-container fluid class="ma-0 pa-0">
		
		<v-container fluid class="ma-0 pa-0">

			<v-row class="d-flex align-center mt-2 mb-6 pt-2" v-if="eventsMap(date).length != 0">
															
				<v-col cols="12" class="my-0 py-0">

					<v-card>

						<template v-for="(event, i) in eventsMap(date)" link>
												
							<v-list-item class="d-flex align-center my-0 px-3 py-2" @click="openOtchData(event)">
								
								<v-list-item-content class="ma-0 pa-0 ms-2">
									<v-list-item-title class="wrap-text me-2" v-if="event.name">{{ event.name }}</v-list-item-title>
									<v-list-item-title class="wrap-text me-2" v-if="event.otchetdata.razdelname">{{ event.otchetdata.razdelname }}</v-list-item-title>
									<v-list-item-title class="wrap-text me-2" v-if="event.reportday">				
										<otchetperiods 
											:value="event.reportday" 
											:intervdayitems="intervdayitems"
											:intervweekitems="intervweekitems"
											:weekdaysitems="weekdaysitems"		
											:intervmonthitems="intervmonthitems"
											:defaultmonthdays="defaultmonthdays"
											:monthweekitems="monthweekitems"
											:intervquarteritems="intervquarteritems"
											:quarterdays="quarterdays"
											:intervyearitems="intervyearitems"
											:yearmonthitems="yearmonthitems"
											textsize="text-body-1"
											padding="py-0"/>
									</v-list-item-title>
									<v-list-item-subtitle class="wrap-text me-2" v-if="event.otchetdata.categorydata.categoryname">{{ event.otchetdata.categorydata.categoryname }} </v-list-item-subtitle>

								</v-list-item-content>

							</v-list-item>

							<v-divider
								v-if="i < eventsMap(date).length - 1">
							</v-divider>
						  
						</template>

				  </v-card>

				</v-col>
			
			</v-row>
		
		</v-container>
	

		<v-dialog v-model="dialogOtchData" max-width="800px" scrollable persistent>
			<v-card>
			
				<v-card-title>
					<span class="text-h5">Информация</span>
					<v-spacer></v-spacer>
					<v-btn
						icon
						@click="dialogOtchData = false">
							<v-icon>mdi-close</v-icon>
					</v-btn>  
				</v-card-title>
				
				<v-card-text>
				
				
					<v-row class="my-0 py-0">

						<v-col cols="12">
							<v-divider></v-divider>
						</v-col>
						
						<v-col
							cols="12"
							class="d-flex align-center my-0 py-0">
								<div class="text-h6 justify-center">Отчет</div>
						</v-col>	
						
						
						<v-col
							cols="12"
							md="6"
							v-if="otch_data.otchetname" class="d-flex align-center my-0 py-0">
										
							<v-list-item class="mx-0 px-0">
								<v-list-item-content>
									<v-list-item-subtitle class="indigo--text wrap-text">Наименование отчета</v-list-item-subtitle>
									<v-list-item-title class="black--text wrap-text" v-text="otch_data.otchetname"></v-list-item-title>
								</v-list-item-content>
							</v-list-item>
							
						</v-col>					
						
						<v-col
							cols="12"
							md="6"
							v-if="otch_data.razdelname" class="d-flex align-center my-0 py-0">
					
							<v-list-item class="mx-0 px-0">
								<v-list-item-content>
									<v-list-item-subtitle class="indigo--text wrap-text">Уточнение</v-list-item-subtitle>
									<v-list-item-title class="black--text wrap-text">{{ otch_data.razdelname }}</v-list-item-title>
								</v-list-item-content>
							</v-list-item>
						
						</v-col>
						
						<v-col
							cols="12"
							md="6"
							v-if="otch_data.reportdays" class="d-flex align-center my-0 py-0">
					
							<v-list-item class="mx-0 px-0">
								<v-list-item-content>
									<v-list-item-subtitle class="indigo--text wrap-text">Срок предоставления</v-list-item-subtitle>
									<v-list-item-title class="black--text wrap-text">
									
										<div v-for="(value, index) in JSON.parse(otch_data.reportdays)" :key="index" class="pa-0 ma-0">
																			
											<otchetperiods 
												:value="value" 
												:intervdayitems="intervdayitems"
												:intervweekitems="intervweekitems"
												:weekdaysitems="weekdaysitems"		
												:intervmonthitems="intervmonthitems"
												:defaultmonthdays="defaultmonthdays"
												:monthweekitems="monthweekitems"
												:intervquarteritems="intervquarteritems"
												:quarterdays="quarterdays"
												:intervyearitems="intervyearitems"
												:yearmonthitems="yearmonthitems"
												padding="py-1"/>

										</div>

									</v-list-item-title>
								</v-list-item-content>
							</v-list-item>
						
						</v-col>												
						
						<v-col
							cols="12"
							md="6"
							v-if="otch_data.whosend && JSON.parse(otch_data.whosend).length > 0" class="d-flex align-center my-0 py-0">
					
							<v-list-item class="mx-0 px-0">
								<v-list-item-content>
									<v-list-item-subtitle class="indigo--text wrap-text">Кто предоставляет</v-list-item-subtitle>
									<v-list-item-title class="black--text wrap-text">{{ JSON.parse(otch_data.whosend).join(', ') }}</v-list-item-title>
								</v-list-item-content>
							</v-list-item>
						
						</v-col>
													
						<v-col
							cols="12"
							md="6"
							v-if="otch_data.otchetlink" class="d-flex align-center my-0 py-0">
						
							<v-list-item class="mx-0 px-0">
								<v-list-item-content>
									<v-list-item-subtitle class="indigo--text wrap-text">Бланк отчета</v-list-item-subtitle>
									<v-list-item-title class="wrap-text">						

										<a target="_blank" :href="otch_data.otchetlink" v-if="linkornot(otch_data.otchetlink)">
											{{ otch_data.otchetlink }}
										</a>
										
										<div v-if="!linkornot(otch_data.otchetlink)">
											{{ otch_data.otchetlink }}
										</div>

									</v-list-item-title>
								</v-list-item-content>
							</v-list-item>
						
						</v-col>												
										
						<v-col
							cols="12"
							md="6"
							v-if="otch_data.comment" class="d-flex align-center my-0 py-0">
							
							<v-list-item class="mx-0 px-0">
								<v-list-item-content>
									<v-list-item-subtitle class="indigo--text wrap-text">Комментарий</v-list-item-subtitle>
									<v-list-item-title class="black--text wrap-text">{{ otch_data.comment }}</v-list-item-title>
								</v-list-item-content>
							</v-list-item>			
											
						</v-col>

									
					</v-row>
					
					<v-row class="my-0 py-0">

						<v-col cols="12">
							<v-divider></v-divider>
						</v-col>
						
						<v-col
							cols="12"
							class="d-flex align-center my-0 py-0">
								<div class="text-h6 justify-center">Категория</div>
						</v-col>
						
						<v-col
							cols="12"
							md="6"
							v-if="otch_data.categoryname" class="d-flex align-center my-0 py-0">
										
							<v-list-item class="mx-0 px-0">
								<v-list-item-content>
									<v-list-item-subtitle class="indigo--text wrap-text">Наименование отчетности</v-list-item-subtitle>
									<v-list-item-title class="black--text wrap-text" v-text="otch_data.categoryname"></v-list-item-title>
								</v-list-item-content>
							</v-list-item>
							
						</v-col>	

						<v-col
							cols="12"
							md="6"
							v-if="otch_data.categorygoverment" class="d-flex align-center my-0 py-0">
					
							<v-list-item class="mx-0 px-0">
								<v-list-item-content>
									<v-list-item-subtitle class="indigo--text wrap-text">Государственный орган</v-list-item-subtitle>
									<v-list-item-title class="black--text wrap-text">{{ otch_data.categorygoverment }}</v-list-item-title>
								</v-list-item-content>
							</v-list-item>
						
						</v-col>
						
						<v-col
							cols="12"
							md="6"
							v-if="otch_data.categorylaw" class="d-flex align-center my-0 py-0">
						
							<v-list-item class="mx-0 px-0">
								<v-list-item-content>
									<v-list-item-subtitle class="indigo--text wrap-text">Нормативный документ</v-list-item-subtitle>
									<v-list-item-title class="black--text wrap-text">{{ otch_data.categorylaw }}</v-list-item-title>
									<v-list-item-title class="wrap-text" v-if="otch_data.categorylawlink">						

										<a target="_blank" :href="otch_data.categorylawlink" v-if="linkornot(otch_data.categorylawlink)">
											{{ otch_data.categorylawlink }}
										</a>
										
										<div v-if="!linkornot(otch_data.categorylawlink)">
											{{ otch_data.categorylawlink }}
										</div>

									</v-list-item-title>
								</v-list-item-content>
							</v-list-item>
						
						</v-col>
											
						<v-col
							cols="12"
							md="6"
							v-if="otch_data.categoryplace" class="d-flex align-center my-0 py-0">
									
							<v-list-item class="mx-0 px-0">
								<v-list-item-content>
									<v-list-item-subtitle class="indigo--text wrap-text">Место отчетности</v-list-item-subtitle>
									<v-list-item-title class="black--text wrap-text">{{ otch_data.categoryplace }}</v-list-item-title>
								</v-list-item-content>
							</v-list-item>
						
						</v-col>
											
						<v-col
							cols="12"
							md="6"
							v-if="otch_data.categorycomment" class="d-flex align-center my-0 py-0">
							
							<v-list-item class="mx-0 px-0">
								<v-list-item-content>
									<v-list-item-subtitle class="indigo--text wrap-text">Комментарий</v-list-item-subtitle>
									<v-list-item-title class="black--text wrap-text">{{ otch_data.categorycomment }}</v-list-item-title>
								</v-list-item-content>
							</v-list-item>			
											
						</v-col>					
									
					</v-row>
			
				</v-card-text>

			</v-card>
		</v-dialog>
		
	</v-container>
	
</template>

<script>

	import {DateTime} from "luxon";

	export default {
		
		name: "DayEvents",
				
		data: () => ({

			default_otch_status: {
				itemindex: '',
				id: '',
				userid: '',
				formid: '',
				categorytable: '',
				category: '',
				status: '',
				plandate: '',
				realdate: '',
			},
		
			statuscolors: ['red', 'green', 'orange'],
			statusnames: ['Не сдано', 'Сдано', 'Не сдается'],
			
			intervdayitems: [
				{ id: 1, value: 'Ежедневно' },
				{ id: 2, value: '1 раз в 2 дня' },
				{ id: 3, value: '1 раз в 3 дня' },
				{ id: 4, value: '1 раз в 4 дня' },
				{ id: 5, value: '1 раз в 5 дней' },
				{ id: 6, value: '1 раз в 6 дней' },
				{ id: 7, value: '1 раз в 7 дней' },
				{ id: 8, value: '1 раз в 8 дней' },
				{ id: 9, value: '1 раз в 9 дней' },
				{ id: 10, value: '1 раз в 10 дней' },
				{ id: 15, value: '1 раз в 15 дней' },
				{ id: 20, value: '1 раз в 20 дней' },
				{ id: 25, value: '1 раз в 25 дней' },
				{ id: 30, value: '1 раз в 30 дней' },
				{ id: 50, value: '1 раз в 50 дней' },
				{ id: 100, value: '1 раз в 100 дней' },
			],
					
			
			intervweekitems: [
				{ id: 1, value: 'Еженедельно' },
				{ id: 2, value: '1 раз в 2 недели' },
				{ id: 3, value: '1 раз в 3 недели' },
				{ id: 4, value: '1 раз в 4 недели' },
			],
			
				
			weekdaysitems: [
				{ id: 1, value: 'Понедельник' },
				{ id: 2, value: 'Вторник' },
				{ id: 3, value: 'Среда' },
				{ id: 4, value: 'Четверг' },
				{ id: 5, value: 'Пятница' },
				{ id: 6, value: 'Суббота' },
				{ id: 7, value: 'Воскресенье' },
			],
			
			intervmonthitems: [
				{ id: 1, value: 'Ежемесячно' },
				{ id: 2, value: '1 раз в 2 месяца' },
				{ id: 3, value: '1 раз в 3 месяца' },
				{ id: 4, value: '1 раз в 4 месяца' },
				{ id: 5, value: '1 раз в 5 месяцев' },
				{ id: 6, value: '1 раз в 6 месяцев' },
				{ id: 7, value: '1 раз в 9 месяцев' },
				{ id: 8, value: '1 раз в 12 месяцев' },
			],
			

			defaultmonthdays: [
				{ id: 1, value: 1 }, { id: 2, value: 2 }, { id: 3, value: 3 }, { id: 4, value: 4 }, { id: 5, value: 5 }, { id: 6, value: 6 }, { id: 7, value: 7 }, { id: 8, value: 8 },
				{ id: 9, value: 9 }, { id: 10, value: 10 }, { id: 11, value: 11 }, { id: 12, value: 12 }, { id: 13, value: 13 }, { id: 14, value: 14 },
				{ id: 15, value: 15 }, { id: 16, value: 16 }, { id: 17, value: 17 }, { id: 18, value: 18 }, { id: 19, value: 19 }, { id: 20, value: 20 },
				{ id: 21, value: 21 }, { id: 22, value: 22 }, { id: 23, value: 23 }, { id: 24, value: 24 }, { id: 25, value: 25 }, { id: 26, value: 26 }, 
				{ id: 27, value: 27 }, { id: 28, value: 28 }, { id: 29, value: 29 }, { id: 30, value: 30 }, { id: 31, value: 31 }, { id: 'last', value: 'Последний' },
			],
			
			
			monthweekitems: [
				{ id: 1, value: 'Первая' },
				{ id: 2, value: 'Вторая' },
				{ id: 3, value: 'Третья' },
				{ id: 4, value: 'Четвертая' },
				{ id: 5, value: 'Последняя' },
			],
			
			
			intervquarteritems: [
				{ id: 1, value: 'Ежеквартально' },
				{ id: 2, value: '1 раз в 2 квартала' },
				{ id: 3, value: '1 раз в 3 квартала' },
				{ id: 4, value: '1 раз в 4 квартала' },
			],
			
			
			quarterdays: [
				{ id: 1, value: 1 }, { id: 2, value: 2 }, { id: 3, value: 3 }, { id: 4, value: 4 }, { id: 5, value: 5 }, { id: 6, value: 6 }, { id: 7, value: 7 }, { id: 8, value: 8 },
				{ id: 9, value: 9 }, { id: 10, value: 10 }, { id: 11, value: 11 }, { id: 12, value: 12 }, { id: 13, value: 13 }, { id: 14, value: 14 },
				{ id: 15, value: 15 }, { id: 16, value: 16 }, { id: 17, value: 17 }, { id: 18, value: 18 }, { id: 19, value: 19 }, { id: 20, value: 20 },
				{ id: 21, value: 21 }, { id: 22, value: 22 }, { id: 23, value: 23 }, { id: 24, value: 24 }, { id: 25, value: 25 }, { id: 26, value: 26 }, 
				{ id: 27, value: 27 }, { id: 28, value: 28 }, { id: 29, value: 29 }, { id: 30, value: 30 }, { id: 35, value: 35 }, { id: 40, value: 40 },
				{ id: 45, value: 45 }, { id: 50, value: 50 }, { id: 55, value: 55 }, { id: 60, value: 60 }, { id: 65, value: 65 }, { id: 70, value: 70 }, 
				{ id: 75, value: 75 }, { id: 80, value: 80 }, { id: 85, value: 85 }, { id: 90, value: 90 }, { id: 'last', value: 'Последний' }, 
			],
			
			
			intervyearitems: [
				{ id: 1, value: 'Ежегодно' },
				{ id: 2, value: '1 раз в 2 года' },
				{ id: 3, value: '1 раз в 3 года' },
			],
			
			yearmonthitems: [
				{ id: 1, value: 'Январь' }, { id: 2, value: 'Февраль' }, { id: 3, value: 'Март' }, { id: 4, value: 'Апрель' }, 
				{ id: 5, value: 'Май' }, { id: 6, value: 'Июнь' }, { id: 7, value: 'Июль' }, { id: 8, value: 'Август' }, 
				{ id: 9, value: 'Сентябрь' }, { id: 10, value: 'Октябрь' }, { id: 11, value: 'Ноябрь' }, { id: 12, value: 'Декабрь' }, 
			],
			
			dialogOtchData: false,
			
			otch_data: {},
		
		}),
		
		watch: {
						
			dialogOtchData (val) {
				val || this.closeOtchData()
			},
	
		},
		
		props: {
			date: String,
			events: Array,
		},
		
		
		methods: {
		
			eventsMap (date) {
				var map = []
				this.events.forEach((event) => {
					if (date == event.start) {
						map.push(event);
					}
				})
				return map
			},
		
			formatDate(date) {
				if (date === null || date === undefined) {
					return null
				} else {
					return DateTime.fromISO(date).toFormat('dd.MM.yyyy');
				}
			},
			
			
			linkornot(link){
				if (link === null) {
					return false;
				} else {
					if (link.indexOf('http') > -1) {
						return true;
					} else {
						return false;
					}
				}	
			},
			
			
			openOtchData(event) {
				
				this.otch_data = {};
				
				this.otch_data.otchetname = event.otchetdata.otchetname;
				this.otch_data.razdelname = event.otchetdata.razdelname;
				this.otch_data.reportdays = event.otchetdata.reportdays;
				this.otch_data.whosend = event.otchetdata.whosend;
				this.otch_data.otchetlink = event.otchetdata.otchetlink;
				this.otch_data.comment = event.otchetdata.comment;
				this.otch_data.categoryname = event.otchetdata.categorydata.categoryname;
				this.otch_data.categorygoverment = event.otchetdata.categorydata.goverment;
				this.otch_data.categorylaw = event.otchetdata.categorydata.law;
				this.otch_data.categorylawlink = event.otchetdata.categorydata.lawlink;
				this.otch_data.categoryplace = event.otchetdata.categorydata.place;
				this.otch_data.categorycomment = event.otchetdata.categorydata.comment;
								
				this.dialogOtchData = true
				
			},
			
			closeOtchData () {
				this.dialogOtchData = false
			},
						
	
		},

	}

</script>

<style scoped>

	.word-break {
		word-break: break-word;
	}
	
	.wrap-text {
		white-space: normal;
	}
	
	.v-dialog__content {
		min-width: 480px;	
	}
	
	.v-list-item--link::before { 
		background-color: transparent; 
	}

	
</style>