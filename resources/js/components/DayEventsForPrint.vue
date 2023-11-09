<template>

	<div style="-webkit-text-size-adjust: 100%; word-break: normal; tab-size: 4; text-rendering: optimizeLegibility; line-height: 1.5; color: rgba(0, 0, 0, 0.87); text-align: center; background-repeat: no-repeat; box-sizing: inherit; width: 100%; max-width: 100%; margin: 0px !important; padding: 0px !important;">

		<div style="text-size-adjust: 100%; word-break: normal; tab-size: 4; text-rendering: optimizelegibility; line-height: 1.5; color: rgba(0, 0, 0, 0.87); text-align: center; background-repeat: no-repeat; box-sizing: inherit; width: 100%; max-width: 100%; margin: 0px !important; padding: 0px !important;">

			<div style="-webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-size-adjust: 100%; word-break: normal; tab-size: 4; text-rendering: optimizelegibility; line-height: 1.5; color: rgba(0, 0, 0, 0.87); text-align: center; background-repeat: no-repeat; box-sizing: inherit; padding: 0; flex-wrap: wrap; flex: 1 1 auto; margin: -12px; display: flex !important; align-items: center !important; margin-top: 8px !important; margin-bottom: 24px !important; padding-top: 8px !important;" v-if="eventsMap(date).length != 0">
															
				<div style="-webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-size-adjust: 100%; word-break: normal; tab-size: 4; text-rendering: optimizelegibility; line-height: 1.5; color: rgba(0, 0, 0, 0.87); text-align: center; background-repeat: no-repeat; box-sizing: inherit; margin: 0; width: 100%; flex: 0 0 100%; max-width: 100%; margin-top: 0px !important; margin-bottom: 0px !important; padding-top: 0px !important; padding-bottom: 0px !important;">

					<div style="-webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-size-adjust: 100%; word-break: normal; tab-size: 4; text-rendering: optimizelegibility; line-height: 1.5; text-align: center; background-repeat: no-repeat; box-sizing: inherit; padding: 0; margin: 0; border-width: thin; display: block; max-width: 100%; outline: none; text-decoration: none; overflow-wrap: break-word; position: relative; white-space: normal; background-color: #FFFFFF; color: rgba(0, 0, 0, 0.87); border-radius: 4px; border: 1px solid #e3e3e3;">

						<div v-for="(event, i) in eventsMap(date)">

							<div style="-webkit-text-size-adjust: 100%; word-break: normal; tab-size: 4; text-rendering: optimizeLegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; overflow-wrap: break-word; white-space: normal; background-repeat: no-repeat; box-sizing: inherit; margin: 0; flex: 1 1 100%; letter-spacing: normal; min-height: 48px; outline: none; position: relative; text-decoration: none; cursor: pointer; user-select: none; display: flex !important; align-items: center !important; margin-top: 0px !important; margin-bottom: 0px !important; padding-right: 12px !important; padding-left: 12px !important; padding-top: 8px !important; padding-bottom: 8px !important; color: rgba(0, 0, 0, 0.87); border-top-left-radius: inherit; border-top-right-radius: inherit;">

					
								<table style="width:100%;">
								
									<tr>
																			
									<td v-if="event.otchetdata.myornot == 'my'" style="text-align: center; vertical-align: middle; width: 1px;">
								
										<div style="text-align: center; text-size-adjust: 100%; word-break: normal; tab-size: 4; text-rendering: optimizelegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); overflow-wrap: break-word; letter-spacing: normal; user-select: none; box-sizing: inherit; margin: 0; align-items: center; cursor: default; display: inline-flex; line-height: 20px; max-width: 100%; outline: none; overflow: hidden; padding: 5px 12px; position: relative; text-decoration: none; transition-duration: 0.28s; transition-property: box-shadow, opacity; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); vertical-align: middle; white-space: nowrap; color: #FFFFFF !important; caret-color: #FFFFFF !important; border-radius: 16px; font-size: 0.9rem; background-color: #01579b !important; border-color: #01579b !important; background: #01579b;">
											Мой
										</div>
									</td>
			
									
									<td style="text-align: center; vertical-align: middle; width:100%;">
								
										<div style="-webkit-text-size-adjust: 100%; word-break: normal; tab-size: 4; font-size: 1rem; text-rendering: optimizeLegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; overflow-wrap: break-word; white-space: normal; letter-spacing: normal; cursor: pointer; user-select: none; color: rgba(0, 0, 0, 0.87); background-repeat: no-repeat; box-sizing: inherit; align-items: center; align-self: left; flex-wrap: wrap; flex: 1 1; overflow: hidden; margin: 0px !important; margin-left: 8px !important; margin-right: 8px !important; padding: 0px !important;">

											<div style="text-align: center; text-size-adjust: 100%; word-break: normal; tab-size: 4; text-rendering: optimizelegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; overflow-wrap: break-word; letter-spacing: normal; cursor: pointer; user-select: none; color: rgba(0, 0, 0, 0.87); background-repeat: no-repeat; box-sizing: inherit; padding: 0; margin: 0; flex: 1 1 100%; overflow: hidden; text-overflow: ellipsis; align-self: left; font-size: 1rem; display: flex !important; margin-right: 8px !important; white-space: normal;" v-if="event.name">{{ event.name }}</div>
											<div style="text-align: center; text-size-adjust: 100%; word-break: normal; tab-size: 4; text-rendering: optimizelegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; overflow-wrap: break-word; letter-spacing: normal; cursor: pointer; user-select: none; color: rgba(0, 0, 0, 0.87); background-repeat: no-repeat; box-sizing: inherit; padding: 0; margin: 0; flex: 1 1 100%; overflow: hidden; text-overflow: ellipsis; align-self: left; font-size: 1rem; display: flex !important; margin-right: 8px !important; white-space: normal;" v-if="event.otchetdata.razdelname">{{ event.otchetdata.razdelname }}</div>
											<div style="text-align: center; text-size-adjust: 100%; word-break: normal; tab-size: 4; text-rendering: optimizelegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; overflow-wrap: break-word; letter-spacing: normal; cursor: pointer; user-select: none; color: rgba(0, 0, 0, 0.87); background-repeat: no-repeat; box-sizing: inherit; padding: 0; margin: 0; flex: 1 1 100%; overflow: hidden; text-overflow: ellipsis; align-self: left; font-size: 1rem; display: flex !important; margin-right: 8px !important; white-space: normal;" v-if="event.reportday">				
												

													<div style="text-align: center; text-size-adjust: 100%; word-break: normal; tab-size: 4; text-rendering: optimizelegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; overflow-wrap: break-word; letter-spacing: normal; cursor: pointer; user-select: none; color: rgba(0, 0, 0, 0.87); font-size: 1rem; white-space: normal; background-repeat: no-repeat; box-sizing: inherit; margin: 0; align-items: center; align-self: center; flex-wrap: wrap; flex: 1 1; overflow: hidden; padding: 12px 0; display: flex !important; padding-top: 0px !important; padding-bottom: 0px !important;">

														<div style="text-align: center; text-size-adjust: 100%; word-break: normal; tab-size: 4; text-rendering: optimizelegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); overflow-wrap: break-word; cursor: pointer; user-select: none; color: rgba(0, 0, 0, 0.87); background-repeat: no-repeat; box-sizing: inherit; padding: 0; margin: 0; flex: 1 1 100%; overflow: hidden; text-overflow: ellipsis; align-self: center; white-space: normal; display: flex !important; font-size: 1rem !important; font-weight: 400; line-height: 1.5rem; letter-spacing: 0.03125em !important;">
																													
															<span v-if="event.reportday.freq==1">
																<span>Однократно</span><!--
																--><span v-if="event.reportday.onetimeday!='' & event.reportday.onetimeday!=null">, </span><!--
																--><span v-if="event.reportday.onetimeday!='' & event.reportday.onetimeday!=null">{{ formatDate(event.reportday.onetimeday)}}</span><!--
																--><span v-if="event.reportday.comment!='' & event.reportday.comment!=null">, </span><!--			
																--><span v-if="event.reportday.comment!='' & event.reportday.comment!=null">{{ event.reportday.comment }}</span>												
															</span>
															
															<span v-if="event.reportday.freq==2">															
																<span>{{ intervdayitems.find(o => o.id === event.reportday.intervday).value }}</span><!--
																--><span v-if="event.reportday.comment!='' & event.reportday.comment!=null">, </span><!--			
																--><span v-if="event.reportday.comment!='' & event.reportday.comment!=null">{{ event.reportday.comment }}</span>
															</span>
															
															<span v-if="event.reportday.freq==3">															
																<span>{{ intervweekitems.find(o => o.id === event.reportday.intervweek).value+',' }}</span>
																<span>{{ weekdaysitems.find(o => o.id === event.reportday.weekdays).value  }}</span><!--
																--><span v-if="event.reportday.comment!='' & event.reportday.comment!=null">, </span><!--			
																--><span v-if="event.reportday.comment!='' & event.reportday.comment!=null">{{ event.reportday.comment }}</span>
															</span>
															
															<span v-if="event.reportday.freq==4">															
																<span>{{ intervmonthitems.find(o => o.id === event.reportday.intervmonth).value+',' }}</span>
																<span v-if="event.reportday.monthmethod==1">{{ defaultmonthdays.find(o => o.id === event.reportday.monthdays).value+' день' }}</span><!--
																--><span v-if="event.reportday.monthmethod==2">{{ monthweekitems.find(o => o.id === event.reportday.monthweek).value+' неделя, ' }}</span><!--
																--><span v-if="event.reportday.monthmethod==2">{{ weekdaysitems.find(o => o.id === event.reportday.monthweekdays).value }}</span><!--
																--><span v-if="event.reportday.comment!='' & event.reportday.comment!=null">, </span><!--			
																--><span v-if="event.reportday.comment!='' & event.reportday.comment!=null">{{ event.reportday.comment }}</span>														
															</span>
															
															<span v-if="event.reportday.freq==5">															
																<span>{{ intervquarteritems.find(o => o.id === event.reportday.intervquarter).value+',' }}</span>
																<span>{{ quarterdays.find(o => o.id === event.reportday.quarterdays).value+' день' }}</span><!--
																--><span v-if="event.reportday.comment!='' & event.reportday.comment!=null">, </span><!--			
																--><span v-if="event.reportday.comment!='' & event.reportday.comment!=null">{{ event.reportday.comment }}</span>																			
															</span>
															
															<span v-if="event.reportday.freq==6">															
																<span>{{ intervyearitems.find(o => o.id === event.reportday.intervyear).value+',' }}</span>
																<span>{{ yearmonthitems.find(o => o.id === event.reportday.yearmonth).value+',' }}</span>
																<span v-if="event.reportday.yearmethod==1">{{ defaultmonthdays.find(o => o.id === event.reportday.yearmonthdays).value+' день' }}</span><!--
																										
																--><span v-if="event.reportday.yearmethod==2">{{ monthweekitems.find(o => o.id === event.reportday.yearmonthweek).value+' неделя, ' }}</span><!--
																--><span v-if="event.reportday.yearmethod==2">{{ weekdaysitems.find(o => o.id === event.reportday.yearmonthweekdays).value }}</span><!--
																
																--><span v-if="event.reportday.comment!='' & event.reportday.comment!=null">, </span><!--			
																--><span v-if="event.reportday.comment!='' & event.reportday.comment!=null">{{ event.reportday.comment }}</span>														
															</span>								
															
														</div>								
														</div>

											</div>

											<div style="text-align: center; text-size-adjust: 100%; word-break: normal; tab-size: 4; text-rendering: optimizelegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; overflow-wrap: break-word; letter-spacing: normal; cursor: pointer; user-select: none; color: rgba(0, 0, 0, 0.6); background-repeat: no-repeat; box-sizing: inherit; padding: 0; margin: 0; flex: 1 1 100%; overflow: hidden; text-overflow: ellipsis; align-self: left; font-size: 0.875rem; display: flex !important; margin-right: 8px !important; white-space: normal;" v-if="event.otchetdata.categorydata.categoryname">{{ event.otchetdata.categorydata.categoryname }} </div>

										</div>

									</td>
																
									<td style="text-align: center; vertical-align: middle; width: 1px;">	
										<div style="text-align: center; text-size-adjust: 100%; word-break: normal; tab-size: 4; text-rendering: optimizelegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); overflow-wrap: break-word; letter-spacing: normal; user-select: none; box-sizing: inherit; margin: 0; align-items: center; cursor: default; display: inline-flex; line-height: 20px; max-width: 100%; outline: none; overflow: hidden; padding: 6px 14px; position: relative; text-decoration: none; transition-duration: 0.28s; transition-property: box-shadow, opacity; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); vertical-align: middle; white-space: nowrap; color: #FFFFFF !important; caret-color: #FFFFFF !important; border-radius: 16px; font-size: 0.9rem; text-transform: uppercase !important;" v-bind:style="{ 'background-color': getStatusColor(event.status), 'background': getStatusColor(event.status), 'border-color': getStatusColor(event.status) }">
											{{ getStatusName(event.status) }}
										</div>
									</td>
								</tr>

							</table>

							</div>

							<div v-if="i < eventsMap(date).length - 1" style="width: 100%; height: 1px; border-bottom: 1px solid #e3e3e3; box-sizing: inherit; margin: 0; flex: 1 1 100%; letter-spacing: normal; outline: none; position: relative; display: flex !important; align-items: center !important; margin-top: 0px !important; margin-bottom: 0px !important;"></div>

						</div>

					</div>

				</div>
			
			</div>
		
		</div>

	</div>
	
</template>

<script>

	import {DateTime} from "luxon";

	export default {
		
		name: "DayEvents",
				
		data: () => ({

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
			
		}),
		
		watch: {
	
		},
		
		props: {
			date: String,
			events: Array,
			premiumstatus: Boolean,
			userid: Number,
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
			
			getStatusColor (status) {				
				if (/*this.premiumstatus &&*/ status) {
					return this.statuscolors[status.status]
				} else {
					return this.statuscolors[0]
				}
			},
			
			getStatusName (status) {
				if (/*this.premiumstatus &&*/ status) {
					if (status.status == 1) {
						return this.statusnames[status.status] + ' ' + this.formatDate(status.realdate)
					} else {
						return this.statusnames[status.status]
					}
				} else {
					return this.statusnames[0]
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

	@media print {    
		.no-print, .no-print * {
			display: none !important;
		}

		.no-print-margine, .no-print-margine * {
			margin: 0 !important;
		}
	}

	
</style>