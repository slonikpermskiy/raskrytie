<template>
	
	<v-container fluid fill-height class="maincontainer elevation-1 pa-1 ma-0 align-start">
		
		<v-container fluid class="pa-3">

			<v-tabs
				v-model="tab"
				background-color="transparent"
				color="indigo"
				grow
				class="px-1">
				
				<v-tab>
					Календарь
				</v-tab>
				<v-tab>
					Список
				</v-tab>
				<v-tab>
					Вся отчетность
				</v-tab>
				
			</v-tabs>

			<v-row class="d-flex align-center mt-4 pt-3">
										
				<v-col cols="12" class="my-0 py-0">				
					<div>				  					
						<v-alert
							icon="mdi-calendar-month-outline"
							prominent
							text
							dismissible
							type="info">
							<v-row align="center">
								<v-col>
									Создайте свой собственный план отчетности в личном кабинете.
								</v-col>
								<v-col class="shrink">
									<v-btn 
										color="info"
										outlined
										href="/lk">
											ЛИЧНЫЙ КАБИНЕТ
									</v-btn>
								</v-col>
							</v-row>
						</v-alert>
					</div>
			
				</v-col>

			</v-row>


			<v-row class="d-flex align-center mt-3 pt-2 mb-2" v-if="tab == 0 | tab == 1">
										
				<v-col cols="6" class="my-0 py-0">
				
					<div>				  
						
						<label class="typo__label justify-center">Категория</label>
				
						<v-select
							:items="categoryitems"
							hide-details
							no-data-text="Нет данных"
							placeholder="Выберите значение"
							item-value="id"
							item-text="categoryname"										
							solo
							clearable
							v-model="category_selected_item"
							:loading="category_loading_select"
							class="d-flex align-center">
						</v-select>
					
					</div>
			
				</v-col>

				<v-col cols="6" class="my-0 py-0">
				
					<div>				  
						
						<label class="typo__label justify-center">Кто сдает</label>
				
						<v-select
							:items="whosenditems"
							hide-details
							no-data-text="Нет данных"
							placeholder="Выберите значение"
							item-value="id"
							item-text="categoryname"										
							solo
							clearable
							v-model="whosend_selected_item"
							class="d-flex align-center">
						</v-select>
					
					</div>
			
				</v-col>
			
			</v-row>
			

			<v-row class="fill-height mt-1" v-if="tab == 0 | tab == 1"> 
			
				<v-col>
			
					<v-sheet height="64">
						<v-toolbar flat>
							
							<v-spacer></v-spacer>

							<v-tooltip left max-width="400px" :disabled="!monthlessthenneed">
								<template v-slot:activator="{ on, attrs }">
																					
									<div v-on="on">
										<v-btn
											fab
											x-small
											outlined
											color="indigo darken-2"
											@click="prev"
											class="me-3"
											:disabled="monthlessthenneed">
											
											<v-icon small>
												mdi-chevron-left
											</v-icon>
										</v-btn>
									</div>

								</template>

								<span>Больше информации в Личном кабинете. Зарегистрируйтесь бесплатно.</span>

							</v-tooltip>

							<v-toolbar-title v-if="$refs.calendar" class="indigo--text text--darken-2">
								{{ firstLetterUp() }}
							</v-toolbar-title>
						
							
							<v-tooltip left max-width="400px" :disabled="!monthmorethenneed">
								<template v-slot:activator="{ on, attrs }">
																					
									<div v-on="on">
										<v-btn
											fab
											x-small
											outlined
											color="indigo darken-2"
											@click="next"
											class="ms-3"
											:disabled="monthmorethenneed">
											<v-icon small>
											mdi-chevron-right
											</v-icon>
										</v-btn>
									</div>

								</template>

								<span>Больше информации в Личном кабинете. Зарегистрируйтесь бесплатно.</span>

							</v-tooltip>

							<v-spacer></v-spacer>
					
						</v-toolbar>
					</v-sheet>

				</v-col>
			</v-row>


			<div class="text-center">
				<v-progress-circular
					v-show="loader"
					:size="50"
					color="primary"
					indeterminate
					class="fill-height mt-8">
				</v-progress-circular>
			</div>


			<v-tabs-items v-model="tab" class="px-1">

				<v-tab-item>

					<div v-show="!loader && $refs.calendar">
					
						<v-row class="fill-height my-2"> 
							<v-col>

								<v-sheet>
									
									<v-calendar
										ref="calendar"
										v-model="focus"
										:now="selectedday"
										:value="selectedday"
										color="primary"
										:events="filteredevents"
										:event-height="0"
										:event-margin-bottom="0"
										:show-month-on-first="false"
										type="month"
										@click:date="showDay"
										@change="updateRange"
										weekdays="1,2,3,4,5,6,0"
										locale="ru-ru">
				
											<template v-slot:day="{ date }">
											
												<div class="d-flex justify-center">

													<div class="d-flex flex-wrap mb-4 justify-center">
														
														<v-chip @click="movetoDay(date)" small color="blue white--text font-weight-bold" class="ma-1" v-if="dayevents(date) != 0">
															{{ dayevents(date) }}
														</v-chip>
													
													</div>
													
												</div>
																					
											</template>	
											
									</v-calendar>
								
									
								</v-sheet>
							</v-col>
						</v-row>
						
						<v-row class="d-flex align-center my-2 pt-2">
													
							<v-col cols="12" class="my-0 py-0">
							
								<div class="d-flex flex-row align-center justify-center">				  
									<v-toolbar-title v-if="$refs.calendar">							
										{{ convertDate(selectedday) }}
									</v-toolbar-title>
								</div>
						
							</v-col>
						
						</v-row>
						
						
						<v-row class="d-flex justify-center align-center my-3 pt-2 pb-2" v-if="eventsMap(this.selectedday).length == 0">
							
							<v-col cols="12" class="my-0 py-0 d-flex justify-center">
							
								<div class="d-flex flex-row align-center">				  
									В этот день отсутствуют отчеты, которые необходимо сдать. 
								</div>
						
							</v-col>				
							
						</v-row>
												
						<maindayevents 
							:date="selectedday"
							:events="filteredevents"/>
					
					</div>

				</v-tab-item>
			  
				<v-tab-item>
				
					<div v-show="!loader && $refs.calendar">					
					
						<div v-for="(date, i) in eventsDays()" :key="i">
						
							<v-row class="d-flex align-center my-2">
														
								<v-col cols="12" class="my-0 py-0">
								
									<div class="d-flex flex-row align-center justify-center">				  
										<v-toolbar-title>							
											{{ convertDate(date) }}
										</v-toolbar-title>
									</div>
							
								</v-col>
							
							</v-row>

							<maindayevents 
								:date="date"
								:events="filteredevents"/>
							
						</div>

						<v-row class="d-flex justify-center align-center my-3 pt-2 pb-2" v-if="eventsDays().length == 0">
							
							<v-col cols="12" class="my-0 py-0 d-flex justify-center">
							
								<div class="d-flex flex-row align-center">				  
									Отсутствуют отчеты, которые необходимо сдать. 
								</div>
						
							</v-col>				
							
						</v-row>

					</div>
						
				</v-tab-item>

				<v-tab-item>

					<v-row class="d-flex align-center mt-4 pt-2 mb-3">
										
						<v-col cols="12" class="my-0 py-0">
						
							<div>				  
								
								<label class="typo__label justify-center">Категория</label>
						
								<v-select
									:items="categoryitems"
									hide-details
									no-data-text="Нет данных"
									placeholder="Выберите значение"
									item-value="id"
									item-text="categoryname"										
									solo
									v-model="category_selected_item_tab3"
									:loading="category_loading_select"
									class="d-flex align-center">
								</v-select>
							
							</div>
					
						</v-col>

					</v-row>

					<div v-if="category_selected_item_tab3" class="mt-4">				
						
						<v-row class="my-0 py-0">	
						
							<v-col
								cols="12"
								md="6"
								v-if="category_detailed_item.categoryname" class="d-flex align-center my-0 py-0">
											
								<v-list-item>
									<v-list-item-content>
										<v-list-item-subtitle class="indigo--text wrap-text">Наименование отчетности</v-list-item-subtitle>
										<v-list-item-title class="black--text wrap-text" v-text="category_detailed_item.categoryname"></v-list-item-title>
									</v-list-item-content>
								</v-list-item>
								
							</v-col>					
							
							<v-col
								cols="12"
								md="6"
								v-if="category_detailed_item.goverment" class="d-flex align-center my-0 py-0">
						
								<v-list-item>
									<v-list-item-content>
										<v-list-item-subtitle class="indigo--text wrap-text">Государственный орган</v-list-item-subtitle>
										<v-list-item-title class="black--text wrap-text">{{ category_detailed_item.goverment }}</v-list-item-title>
									</v-list-item-content>
								</v-list-item>
							
							</v-col>
							
							<v-col
								cols="12"
								md="6"
								v-if="category_detailed_item.law" class="d-flex align-center my-0 py-0">
							
								<v-list-item>
									<v-list-item-content>
										<v-list-item-subtitle class="indigo--text wrap-text">Нормативный документ</v-list-item-subtitle>
										<v-list-item-title class="black--text wrap-text">{{ category_detailed_item.law }}</v-list-item-title>
										<v-list-item-title class="wrap-text" v-if="category_detailed_item.lawlink">						

											<a target="_blank" :href="category_detailed_item.lawlink" v-if="linkornot(category_detailed_item.lawlink)">
												{{ category_detailed_item.lawlink }}
											</a>
											
											<div v-if="!linkornot(category_detailed_item.lawlink)">
												{{ category_detailed_item.lawlink }}
											</div>

										</v-list-item-title>
									</v-list-item-content>
								</v-list-item>
							
							</v-col>
												
							<v-col
								cols="12"
								md="6"
								v-if="category_detailed_item.place" class="d-flex align-center my-0 py-0">
										
								<v-list-item>
									<v-list-item-content>
										<v-list-item-subtitle class="indigo--text wrap-text">Место отчетности</v-list-item-subtitle>
										<v-list-item-title class="black--text wrap-text">{{ category_detailed_item.place }}</v-list-item-title>
									</v-list-item-content>
								</v-list-item>
							
							</v-col>
												
							<v-col
								cols="12"
								md="6"
								v-if="category_detailed_item.comment" class="d-flex align-center my-0 py-0">
								
								<v-list-item>
									<v-list-item-content>
										<v-list-item-subtitle class="indigo--text wrap-text">Комментарий</v-list-item-subtitle>
										<v-list-item-title class="black--text wrap-text">{{ category_detailed_item.comment }}</v-list-item-title>
									</v-list-item-content>
								</v-list-item>			
												
							</v-col>
										
						</v-row>
					
					</div>

					<v-row class="d-flex align-center">
										
						<v-col cols="12" class="">
					
							<v-data-table 
								:headers="headers"
								:items="otchets"
								:search="search"
								:custom-filter="customSearch"
								sort-by="id"
								class="elevation-1 my-3"
								mobile-breakpoint= "960"
								:loading="loading_otchs" 
								data-table-header-mobile="Загрузка данных..."
								loading-text="Загрузка данных..."
								:footer-props="{itemsPerPageText: 'Строк на странице', itemsPerPageAllText: 'Все'}"
								:header-props="{sortByText: 'Сортировка'}"
								v-if="category_selected_item_tab3">
								
								<template v-slot:item.reportdays="{ item }">
													
									<div v-for="(value, index) in JSON.parse(item.reportdays)" :key="index" class="pa-0 ma-0">
																								
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
											textsize="text-body-2"
											padding="py-1"/>

									</div>

								</template>	

								<template v-slot:item.whosend="{ item }">																	
									{{ JSON.parse(item.whosend).join(', ') }}				
								</template>

								<template v-slot:item.otchetlink="{ item }">								
									
									<a target="_blank" :href="item.otchetlink" v-if="linkornot(item.otchetlink)">
										{{ item.otchetlink }}
									</a>
									
									<div v-if="!linkornot(item.otchetlink)">
										{{ item.otchetlink }}
									</div>
									
								</template>	
																
								<template v-slot:no-results>
									<span>Ничего не найдено</span>
								</template>
								
								<template v-slot:no-data>
									<span>Нет данных</span>
								</template>
								
								<template v-slot:[`footer.page-text`]="items"> 
									{{ items.pageStart }} - {{ items.pageStop }} из {{ items.itemsLength }}
								</template>
								
								<template v-slot:top>

									<v-toolbar 
										flat>
									
										<v-toolbar-title>Отчеты</v-toolbar-title>
										
										<v-divider
											class="mx-4"
											inset
											vertical>
										</v-divider>
								
										<v-text-field
											v-model="search"
											append-icon="mdi-magnify"
											label="Поиск (название, уточнение, кто предоставляет)"
											single-line
											hide-details
											spellcheck="false">
										</v-text-field>
										
										<v-spacer></v-spacer>
															
									</v-toolbar>
								</template>
								
								<template v-slot:item.соmmenttooltip="{ item }">
				
										<v-tooltip left v-if="item.comment != null & item.comment != ''" max-width="400px">
										
										<template v-slot:activator="{ on, attrs }">
										
											<v-icon
												v-bind="attrs"
												v-on="on"
												color="primary">
													mdi-comment-text-outline
												</v-icon>

										</template>
										
										<span>{{ item.comment }}</span>
									
									</v-tooltip>

								</template>
							
							</v-data-table>
					
						</v-col>
					
					</v-row>


					
				</v-tab-item>
			
			</v-tabs-items>

		</v-container>

	</v-container>
	
</template>


<script>

	import {DateTime} from "luxon";

    export default {
	
		data: () => ({
			
			tab: null,
			
			loader: false,

			user: [],
			
			focus: '',
			
			selectedday: DateTime.now().toFormat('yyyy-MM-dd'),
			
			events: [],

			calendarmonthfirstdate: '',
			
			categoryitems: [],

			category_loading_select: false,

			category_selected_item: '',

			category_selected_item_tab3: 0,

			category_detailed_item: {},

			whosend_selected_item: '',

			whosenditems: ['Не указано', 'Генерация ЭЭ', 'ТСО', 'Энергосбыт', 'Управление ЕЭС', 'Регулятор ЭЭ', 'Потребители ЭЭ', 'Нефть', 'Газ', 'Уголь'],

			headers: [			
				{ text: 'Отчет', value: 'otchetname', sortable: true, filterable: true },	
				{ text: 'Уточнение', value: 'razdelname', sortable: false, filterable: true },				
				{ text: 'Срок предоставления', value: 'reportdays', sortable: false, filterable: false },
				{ text: 'Кто предоставляет', value: 'whosend', sortable: false, filterable: true  },
				{ text: 'Бланк отчета', value: 'otchetlink', sortable: false, filterable: false  },
				{ text: 'Комментарий', value: 'соmmenttooltip', sortable: false, filterable: false },				
			],

			search: '',

			loading_otchs: false,

			otchets: [],

			freqitems: [
				{ id: 1, value: 'Однократно' },
				{ id: 2, value: 'День' },
				{ id: 3, value: 'Неделя' },
				{ id: 4, value: 'Месяц' },
				{ id: 5, value: 'Квартал' },
				{ id: 6, value: 'Год' },
			],
			
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

		
		created () {
			this.initialize()	
		},
		
		
		watch: {

			// слушатель изменения переменной
			category_selected_item_tab3(newSelected_item, oldSelected_item) {
				this.category_detailed_item = Object.assign({}, this.categoryitems.find(o => o.id === newSelected_item));				
				this.initializeforms();
			},
			
		},

		
		computed: {

			monthlessthenneed () {

				if (DateTime.fromISO(this.calendarmonthfirstdate) <= DateTime.now().minus({ months: 6 })) {
					return true;
				} else {
					return false;
				}
				
			},

			monthmorethenneed () {

				if (DateTime.now().plus({ months: 5 }) <= DateTime.fromISO(this.calendarmonthfirstdate)) {
					return true;
				} else {
					return false;
				}
			},

			filteredevents () {

				var map = []
				this.events.forEach((event) => {
					
					if ((this.category_selected_item == null | this.category_selected_item == '') && (this.whosend_selected_item == null | this.whosend_selected_item == '')) {
						map.push(event);
					} else {

						if (this.category_selected_item && event.otchetdata.category == this.category_selected_item) {

							if (this.whosend_selected_item == null | this.whosend_selected_item == '') {
								map.push(event);
							} else if (event.otchetdata.whosend && JSON.parse(event.otchetdata.whosend).includes(this.whosend_selected_item)) {
								map.push(event);
							} else if ((!event.otchetdata.whosend || JSON.parse(event.otchetdata.whosend).length == 0) && this.whosend_selected_item == 'Не указано') {
									
								map.push(event);
							}

						} else if (this.category_selected_item == null | this.category_selected_item == '') {

							if (this.whosend_selected_item == null | this.whosend_selected_item == '') {
								map.push(event);
							} else if (event.otchetdata.whosend && JSON.parse(event.otchetdata.whosend).includes(this.whosend_selected_item)) {
								map.push(event);
							} else if ((!event.otchetdata.whosend || JSON.parse(event.otchetdata.whosend).length == 0) && this.whosend_selected_item == 'Не указано') {
									
								map.push(event);
							}

						}

					}

				})
				return map
			},
	
		},
		
		methods: {

			initialize () {	
				this.setCategoriesList();
			},

			firstLetterUp() {

				var title = this.$refs.calendar.title;

				if (title) {
					return title[0].toUpperCase() + title.slice(1)
				} else {
					return '';
				}

			},

			setCategoriesList () {
				
				this.category_loading_select = true;
				
				axios.get('/getstandartcategorieslist')
				.then((response) => {
					
					this.categoryitems = response.data;

					if (this.category_selected_item_tab3 === 0) {
						this.category_selected_item_tab3 = response.data[0].id;	
					}
										
					if (this.category_selected_item_tab3 !== 0) {
						this.category_detailed_item = Object.assign({}, this.categoryitems.find(o => o.id === this.category_selected_item_tab3));
						this.category_selected_item_tab3 = this.category_selected_item_tab3;
					}
					
				})
				.catch(error => {})
				.finally(() => {this.category_loading_select = false;}); 
			},
			
			eventsMap (date) {
				var map = []
				this.filteredevents.forEach((event) => {
					if (date == event.start) {
						map.push(event);
					}
				})
				return map
			},
									
			eventsDays () {
				
				var days = []
				
				// Получение дат
				this.filteredevents.forEach((event) => {
					days.push(event.start);
				})
				
				// Оставляем только уникальные значения
				var uniquedays = [];
				days.forEach((element) => {
					if (!uniquedays.includes(element)) {
						uniquedays.push(element);
					}
				});
				
				// Сортировка
				uniquedays.sort(function(a,b){
				  return new Date(a) - new Date(b);
				});
								
				return uniquedays
			},
			
			convertDate(date) {
				
				var monthNames = ["января", "февраля", "марта", "апреля", "мая", "июня",
				  "июля", "августа", "сентября", "октября", "ноября", "декабря"
				];
				
				var curdate = DateTime.fromISO(date);
				
				return curdate.day + ' ' + monthNames[curdate.month-1] + ' ' + curdate.year
				
			},


			formatDate(date) {
				if (date === null || date === undefined) {
					return null
				} else {
					return DateTime.fromISO(date).toFormat('dd.MM.yyyy');
				}
			},
						
			
			focusNext(elem) {
				const currentIndex = Array.from(elem.form.elements).indexOf(elem);
				elem.form.elements.item(
					currentIndex < elem.form.elements.length - 1 ?
					currentIndex + 1 : 0
				).focus(); 
			},
			
			prev () {
				this.$refs.calendar.prev()
			},
			
			next () {
				this.$refs.calendar.next()
			},
			  
			showDay ({ date }) {
				this.selectedday = date
			},
			
			movetoDay (date) {
				this.selectedday = date
			},

			setToday () {
				this.selectedday = ''
			},
			  			  
			updateRange ({ start, end }) {

				this.loader = true;
				
				var month = DateTime.fromISO(start.date).month;
				this.calendarmonthfirstdate = start.date;
				var year = DateTime.fromISO(start.date).year;

				if (month == DateTime.now().month && year == DateTime.now().year) {
					this.selectedday = DateTime.now().toFormat('yyyy-MM-dd');
				} else {
					this.selectedday = DateTime.fromISO(start.date).toFormat('yyyy-MM-dd');				
				}
				
				axios.get('/getmaincalendarotchets', {
					params: {
						month: month,
						year: year,
					}
					})
				.then((response) => {

					this.events = response.data
	
				})
				.catch(error => {})
				.finally(() => {this.loader = false;});
			},
						
			dayevents (date) {
				var count = 0;
				this.filteredevents.forEach((event) => {
					if (date == event.start) {
						count++;
					}
				})
				return count;
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

			customSearch (value, search, item) {
				if ((item.otchetname != null && item.otchetname.toString().toLowerCase().includes(search.toLowerCase())) || (item.razdelname != null && item.razdelname.toString().toLowerCase().includes(search.toLowerCase())) || (item.whosend != null && JSON.parse(item.whosend).join(", ").toString().toLowerCase().includes(search.toLowerCase()))) {
					return true;
				} else {
					return false;
				}
			},

			initializeforms () {			  
				
				this.loading_otchs = true;
				

				axios.get('/getstandartotchetslist', {
					params: {
						category: this.category_detailed_item.id,
						categorytable: this.category_detailed_item.table,
					}
					})
				.then((response) => {

					this.otchets = response.data;
					
				})
				.catch(error => {})
				.finally(() => {this.loading_otchs = false;});
				
			},
				
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
	
	.v-dialog__content {
		min-width: 480px;	
	}
	
	.v-calendar-weekly__week {
		display: flex;
		flex: 1;
		height: unset;
		min-height: 0;
	}

</style>

