<template>
	
	<v-container fluid fill-height class="maincontainer elevation-1 pa-1 ma-0 align-start" id="toPDF">
		
		<v-container fluid class="pa-3" v-if="user.id">

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
				
			</v-tabs>

			<v-row class="d-flex align-center justify-center mt-6" v-if="otchetscount == 1">
										
				<v-col cols="12" class="my-0 py-0">
				
					<div class="d-flex flex-row align-center justify-center">				  
						
						<v-icon
							color="red"
							x-large
							class="mr-3">
								mdi-information-outline
						</v-icon>

						<div>В вашем плане отчетности отсутствуют отчеты. Добавить отчеты в план можно в разделе 
							<router-link to="/lk/myforms">Моя отчетность</router-link>.</div>
					</div>
			
				</v-col>
			
			</v-row>

			<v-row class="d-flex align-center mt-6" v-if="tab == 1">

				<v-col cols="12" class="my-0 py-0">
			
					<div class="d-flex d-row">

						<v-spacer></v-spacer>

						<v-btn
							class="ms-2 pa-0"
							fab
							dark
							small
							@click="print()"
							color="indigo">
								<v-icon dark>
									mdi-printer
								</v-icon>
						</v-btn>

						<v-btn
							class="ms-2 pa-0"
							fab
							dark
							small
							@click="sendplandialog()"
							color="indigo">
								<v-icon dark>
									mdi-email-outline
								</v-icon>
						</v-btn>
					
					</div>
				</v-col>

			</v-row>


			<v-row class="d-flex align-center mt-6" v-if="tab == 0 | tab == 1">
										
				<v-col cols="12" class="my-0 py-0">
				
					<div id="printMeSelect">				  
						
						<label class="typo__label justify-center">Категория</label>
				
						<v-select
							:items="categoryitems"
							hide-details
							no-data-text="Нет данных"
							placeholder="Выберите значение"
							item-text="categoryname"
							return-object										
							solo
							clearable
							v-model="category_selected_item"
							:loading="category_loading_select"
							class="d-flex align-center">

								<template v-slot:item="data">									
									<v-list-item-content>
										<v-list-item-title class="black--text wrap-text">{{ data.item.categoryname }}</v-list-item-title>
										<v-list-item-subtitle class="wrap-text" v-if="data.item.table == 'admin'">Системная</v-list-item-subtitle>
										<v-list-item-subtitle class="wrap-text" v-if="data.item.table == 'user'">Моя</v-list-item-subtitle>
									</v-list-item-content>
								</template>
								
								<template v-slot:selection="data">			
									<v-list-item-content>
										<v-list-item-title class="black--text wrap-text">{{ data.item.categoryname }}</v-list-item-title>
										<v-list-item-subtitle class="wrap-text" v-if="data.item.table == 'admin'">Системная</v-list-item-subtitle>
										<v-list-item-subtitle class="wrap-text" v-if="data.item.table == 'user'">Моя</v-list-item-subtitle>
									</v-list-item-content>
								</template>

						</v-select>
					
					</div>
			
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


			<v-row class="fill-height mt-4" v-show="!loader && $refs.calendar"> 
			
				<v-col>
			
					<div>
					
					<v-sheet height="64">
						<v-toolbar flat>
							
							<v-spacer></v-spacer>
								
							<v-btn
								fab
								x-small
								outlined
								color="indigo darken-2"
								@click="prev"
								class="me-3 no-print">
								
								<v-icon small>
									mdi-chevron-left
								</v-icon>
							</v-btn>
				  
							<v-toolbar-title v-if="$refs.calendar" class="indigo--text text--darken-2">
								{{ firstLetterUp() }}
							</v-toolbar-title>
						  
							<v-tooltip left max-width="400px" v-if="!premiumstatus">
										
								<template v-slot:activator="{ on, attrs }">
									
									<v-icon 
										v-bind="attrs"
										v-on="on" 
										class="pa-0 ms-2"
										color="red">
											mdi-information-outline
									</v-icon>

								</template>
						  
								<span>При отсутствии уровня доступа Премиум доступны только системные отчеты.</span>
						
							</v-tooltip>
						
							<v-btn
								fab
								x-small
								outlined
								color="indigo darken-2"
								@click="next"
								class="ms-3 no-print">
								<v-icon small>
								  mdi-chevron-right
								</v-icon>
							</v-btn>
					  
							<v-spacer></v-spacer>
					  
						</v-toolbar>
					</v-sheet>

					</div>

				</v-col>
			</v-row>
			
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
													
														<v-chip @click="movetoDay(date)" small color="red white--text font-weight-bold" class="ma-1" v-if="dayeventsno(date) != 0">
															{{ dayeventsno(date) }}
														</v-chip>
														
														<v-chip @click="movetoDay(date)" small color="green white--text font-weight-bold" class="ma-1" v-if="dayeventsyes(date) != 0">
															{{ dayeventsyes(date) }}
														</v-chip>
														
														<v-chip @click="movetoDay(date)" small color="orange white--text font-weight-bold" class="ma-1" v-if="dayeventsnotnow(date) != 0">
															{{ dayeventsnotnow(date) }}
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
									В этот день отсутствуют запланированные отчеты. 
								</div>
						
							</v-col>				
							
						</v-row>
												
						<dayevents 
							:date="selectedday"
							:events="filteredevents"
							:premiumstatus="premiumstatus"
							:userid="user.id"/>
					
					</div>
			
				</v-tab-item>
			  
				<v-tab-item>
				
					<div>
					
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

								<dayevents 
									:date="date"
									:events="filteredevents"
									:premiumstatus="premiumstatus"
									:userid="user.id"/>
								
							</div>

							<v-row class="d-flex justify-center align-center my-3" v-if="eventsDays().length == 0">
								
								<v-col cols="12" class="my-0 py-0 d-flex justify-center">
								
									<div class="d-flex flex-row align-center">				  
										Отсутствуют запланированные отчеты. 
									</div>
							
								</v-col>				
								
							</v-row>

						</div>

					</div>

					<div id="printMe" class="d-none">

						<div v-show="!loader && $refs.calendar" style="min-width: 600px; margin: 10px;">
							
							<div v-if="category_selected_item != null && category_selected_item != ''" style="-webkit-text-size-adjust: 100%; word-break: normal; tab-size: 4; font-size: 1rem; text-rendering: optimizeLegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; color: rgba(0, 0, 0, 0.87); background-repeat: no-repeat; box-sizing: inherit; padding: 0; margin: 0;">

								<label style="-webkit-text-size-adjust: 100%; word-break: normal; tab-size: 4; font-size: 1rem; text-rendering: optimizeLegibility; line-height: 1.5; color: rgba(0, 0, 0, 0.87); background-repeat: no-repeat; box-sizing: inherit; padding: 0; margin: 0; justify-content: center !important;"> 
									Категория
								</label>

								<div style="-webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-size-adjust: 100%; word-break: normal; tab-size: 4; font-size: 1rem; text-rendering: optimizelegibility; line-height: 1.5; text-align: center; background-repeat: no-repeat; box-sizing: inherit; padding: 0; margin: 0; border-width: thin; display: block; max-width: 100%; outline: none; text-decoration: none; overflow-wrap: break-word; position: relative; white-space: normal; background-color: #FFFFFF; color: rgba(0, 0, 0, 0.87); border-radius: 4px; border: 1px solid #e3e3e3;">

									<div style="-webkit-text-size-adjust: 100%; word-break: normal; tab-size: 4; font-size: 1rem; text-rendering: optimizeLegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; overflow-wrap: break-word; white-space: normal; background-repeat: no-repeat; box-sizing: inherit; margin: 0; flex: 1 1 100%; letter-spacing: normal; outline: none; position: relative; text-decoration: none; cursor: pointer; user-select: none; display: flex !important; align-items: center !important; margin-top: 0px !important; margin-bottom: 0px !important; padding-right: 12px !important; padding-left: 12px !important; padding-top: 8px !important; padding-bottom: 8px !important; color: rgba(0, 0, 0, 0.87); border-top-left-radius: inherit; border-top-right-radius: inherit;">
									
										<div style="-webkit-text-size-adjust: 100%; word-break: normal; tab-size: 4; font-size: 1rem; text-rendering: optimizeLegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; overflow-wrap: break-word; white-space: normal; letter-spacing: normal; cursor: pointer; user-select: none; color: rgba(0, 0, 0, 0.87); background-repeat: no-repeat; box-sizing: inherit; align-items: center; align-self: left; flex-wrap: wrap; flex: 1 1; overflow: hidden; margin: 0px !important; padding: 0px !important;">
											<div style="text-align: center; text-size-adjust: 100%; word-break: normal; tab-size: 4; text-rendering: optimizelegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; overflow-wrap: break-word; letter-spacing: normal; cursor: pointer; user-select: none; color: rgba(0, 0, 0, 0.87); background-repeat: no-repeat; box-sizing: inherit; padding: 0; margin: 0; flex: 1 1 100%; overflow: hidden; text-overflow: ellipsis; align-self: left; font-size: 1rem; display: flex !important; margin-right: 8px !important; white-space: normal;">{{ category_selected_item.categoryname }}</div>
										</div>

									</div>

								</div>
		
							</div>

							<div v-if="$refs.calendar" style="-webkit-text-size-adjust: 100%; word-break: normal; tab-size: 4; font-size: 1.6rem; text-rendering: optimizeLegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; color: rgba(0, 0, 0, 0.87); text-align: center; background-repeat: no-repeat; box-sizing: inherit; padding: 0; margin: 0; display: flex !important; align-items: center !important; margin-top: 8px !important; margin-bottom: 8px !important;">
							
								<div style="text-size-adjust: 100%; word-break: normal; tab-size: 4; font-size: 1.6rem; text-rendering: optimizelegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; color: rgba(0, 0, 0, 0.87); text-align: center; background-repeat: no-repeat; box-sizing: inherit; margin: 0; width: 100%; padding: 12px; flex: 0 0 100%; max-width: 100%; margin-top: 10px !important; margin-bottom: 0px !important; padding-top: 0px !important; padding-bottom: 0px !important;">

									<div style="-webkit-text-size-adjust: 100%; word-break: normal; tab-size: 4; font-size: 1.6rem; text-rendering: optimizeLegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; color: rgba(0, 0, 0, 0.87); background-repeat: no-repeat; box-sizing: inherit; padding: 0; margin: 0; justify-content: center !important; align-items: center !important;">	
										
										<div style="-webkit-text-size-adjust: 100%; word-break: normal; tab-size: 4; text-rendering: optimizeLegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); background-repeat: no-repeat; box-sizing: inherit; padding: 0; margin: 0; font-size: 1.6rem; line-height: 1.5; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: #00257f !important; caret-color: #00257f !important;">							
											{{ firstLetterUp() }}
										</div>

									</div>
							
								</div>
							
							</div>

						
							<div v-for="(date, i) in eventsDays()" :key="i" style="width: 100%; text-align: center;">
							
								<div style="-webkit-text-size-adjust: 100%; word-break: normal; tab-size: 4; font-size: 1.25rem; text-rendering: optimizeLegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; color: rgba(0, 0, 0, 0.87); text-align: center; background-repeat: no-repeat; box-sizing: inherit; padding: 0; margin: 0; display: flex !important; align-items: center !important; margin-top: 8px !important; margin-bottom: 8px !important;">
							
									<div style="text-size-adjust: 100%; word-break: normal; tab-size: 4; font-size: 1.25rem; text-rendering: optimizelegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; color: rgba(0, 0, 0, 0.87); text-align: center; background-repeat: no-repeat; box-sizing: inherit; margin: 0; width: 100%; padding: 12px; flex: 0 0 100%; max-width: 100%; margin-top: 0px !important; margin-bottom: 0px !important; padding-top: 0px !important; padding-bottom: 0px !important;">

										<div style="-webkit-text-size-adjust: 100%; word-break: normal; tab-size: 4; font-size: 1.25rem; text-rendering: optimizeLegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; color: rgba(0, 0, 0, 0.87); background-repeat: no-repeat; box-sizing: inherit; padding: 0; margin: 0; justify-content: center !important; align-items: center !important;">	
											
											<div style="-webkit-text-size-adjust: 100%; word-break: normal; tab-size: 4; text-rendering: optimizeLegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); color: rgba(0, 0, 0, 0.87); background-repeat: no-repeat; box-sizing: inherit; padding: 0; margin: 0; font-size: 1.25rem; line-height: 1.5; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">							
												{{ convertDate(date) }}
											</div>

										</div>
								
									</div>
								
								</div>

								<dayeventsforprint 
									:date="date"
									:events="filteredevents"
									:premiumstatus="premiumstatus"
									:userid="user.id"/>
								
							</div>

							<div v-if="eventsDays().length == 0" style="-webkit-text-size-adjust: 100%; word-break: normal; tab-size: 4; font-size: 1rem; text-rendering: optimizeLegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; color: rgba(0, 0, 0, 0.87); text-align: center; background-repeat: no-repeat; box-sizing: inherit; padding: 0; margin: 0; display: flex !important; align-items: center !important; margin-top: 10px !important; margin-bottom: 8px !important;">
							
								<div style="text-size-adjust: 100%; word-break: normal; tab-size: 4; font-size: 1rem; text-rendering: optimizelegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; color: rgba(0, 0, 0, 0.87); text-align: center; background-repeat: no-repeat; box-sizing: inherit; margin: 0; width: 100%; padding: 12px; flex: 0 0 100%; max-width: 100%; margin-top: 0px !important; margin-bottom: 0px !important; padding-top: 0px !important; padding-bottom: 0px !important;">

									<div style="-webkit-text-size-adjust: 100%; word-break: normal; tab-size: 4; font-size: 1rem; text-rendering: optimizeLegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; color: rgba(0, 0, 0, 0.87); background-repeat: no-repeat; box-sizing: inherit; padding: 0; margin: 0; justify-content: center !important; align-items: center !important;">	
										
										<div style="-webkit-text-size-adjust: 100%; word-break: normal; tab-size: 4; text-rendering: optimizeLegibility; -webkit-font-smoothing: antialiased; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); color: rgba(0, 0, 0, 0.87); background-repeat: no-repeat; box-sizing: inherit; padding: 0; margin: 0; font-size: 1rem; line-height: 1.5; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">							
											Отсутствуют запланированные отчеты.
										</div>

									</div>
							
								</div>
							
							</div>

						</div>

					</div>
						
				</v-tab-item>
			
			</v-tabs-items>

		</v-container>

		<v-dialog v-model="dialogSendPlan" max-width="600px" scrollable persistent>
			<v-card>
			
				<v-card-title>
					<span class="text-h5">Отправка плана</span>
					<v-spacer></v-spacer>
					<v-btn
						icon
						@click="dialogSendPlan = false">
							<v-icon>mdi-close</v-icon>
					</v-btn>  
				</v-card-title>
				
				<v-card-text>
					<v-container>
			  
						<div v-if="errors_sendplan">
							<div v-for="(v, k) in errors_sendplan" :key="k">
								<v-alert type="error" v-for="error in v" :key="error">{{ error }}</v-alert>
							</div>
						</div>
						<div class="black--text text-body-1 wrap-text">
							Отправить план отчетности на электронную почту указанную при регистрации?
						</div>
						
					</v-container>
				</v-card-text>
	
				<v-card-actions>
					<v-spacer></v-spacer>
					
						<v-btn color="info" @click="sendplan" :loading="loading_sendplan" class="mb-2">
							<v-icon left>email</v-icon>
							Отправить
						</v-btn>

				</v-card-actions>
			</v-card>
		</v-dialog>

	</v-container>
	
</template>


<script>

	import {DateTime} from "luxon";


    export default {
	
		data: () => ({
			
			tab: null,
			
			loader: false,

			user: [],
			
			otchetscount: '',
			
			focus: '',
			
			selectedday: DateTime.now().toFormat('yyyy-MM-dd'),
			
			events: [],

			categoryitems: [],

			category_loading_select: false,

			category_selected_item: '',

			dialogSendPlan: false,

			errors_sendplan: '',

			loading_sendplan: false,
			
		}),

		
		created () {
			this.initialize()	
		},
		
		
		watch: {

			dialogSendPlan (val) {
				val || this.closeSendPlan()
			},
			
		},
		
		props: ['getUserSideBar'],
		
		computed: {
			
			premiumstatus() {

				if (!this.user.premium_to_date || this.user.premium_to_date === null || this.user.premium_to_date === undefined) {					
					return false;
				} else {
					var date = DateTime.now();
				
					if (DateTime.fromISO(this.user.premium_to_date) < date.minus({ days: 1 })) {
						return false;
					} else {
						return true;
					}
				}
			},	
			
			firsttimepremium() {
				if (!this.user.premium_to_date || this.user.premium_to_date === null || this.user.premium_to_date === undefined) {					
					return true;
				} else {
					return false;
				}
			},

			filteredevents () {

				var map = []
				this.events.forEach((event) => {
					
					if (this.category_selected_item == null | this.category_selected_item == '') {
						map.push(event);
					} else {

						if (this.category_selected_item && event.otchetdata.category == this.category_selected_item.id && event.otchetdata.categorytable == this.category_selected_item.table) {
							map.push(event);
						}

					}

				})
				return map
			},

		},
		
		methods: {

			firstLetterUp() {

				var title = this.$refs.calendar.title;
				
				if (title) {
					return title[0].toUpperCase() + title.slice(1)
				} else {
					return '';
				}

			},

			print () {

				var contents = document.getElementById('printMe').innerHTML;
				var frame1 = document.createElement('iframe');
				frame1.name = "frame1";
				frame1.style.position = "absolute";
				frame1.style.top = "-1000000px";
				document.body.appendChild(frame1);
				var frameDoc = frame1.contentWindow ? frame1.contentWindow : frame1.contentDocument.document ? frame1.contentDocument.document : frame1.contentDocument;
				frameDoc.document.open();
				frameDoc.document.write('<!doctype html><html lang="en"><head><title>&nbsp;</title>');
				frameDoc.document.write('<style> @page {size: 252.45mm 357mm; margin: 1cm;}</style>');
				frameDoc.document.write('<link href="/css/vuetify.css" rel="stylesheet" type="text/css"/>');
				frameDoc.document.write('<style>@font-face { font-family: Nunito; src: url("/fonts/Nunito-Regular.ttf"); }</style>');
				frameDoc.document.write('<meta name="csrf-token" content="{{ csrf_token() }}">');
				// Get all stylesheets HTML
				let stylesHtml = '';
				for (const node of [...document.querySelectorAll('link[rel="stylesheet"], style')]) {
					stylesHtml += node.outerHTML;
				}
				frameDoc.document.write(` ${stylesHtml} `);
				frameDoc.document.write('</head><body><div id="app"><template><v-app><v-main app><v-container>');
				frameDoc.document.write(contents);
				frameDoc.document.write('</v-container></v-main></v-app></template></div></body></html>');
				frameDoc.document.write('<script type="text/javascript" src="/js/app.js"><\/script>');
				frameDoc.document.close();
				setTimeout(function () {
					window.frames["frame1"].focus();
					window.frames["frame1"].print();
					document.body.removeChild(frame1);
				}, 1000);
				
				return false;

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
						
			initialize () {	
				this.getUserData ();
			},
						
			getUserData () {
				axios.get('getuser')
				.then((response) => {
					this.user = response.data

					axios.get('getcalendarotchetscount', {
						params: {
							userid: this.user.id,
						}
					})
					.then((response) => {
						this.otchetscount = response.data	
					})
					.catch(error => {})
					.finally(() => {}); 

					this.setCategoriesList ();

					
				})
				.catch(error => {})
				.finally(() => {/*this.loading_otchs = false;*/}); 
			},

			
			setCategoriesList () {
				
				this.category_loading_select = true;

				var premium = 0;

				if (this.premiumstatus) {
					premium = 1;
				}
				
				axios.get('allcategorieslist', {
					params: {
						organisation: this.user.id,
						premium: premium,
					}
					})
				.then((response) => {

					this.categoryitems = response.data;
					
				})
				.catch(error => {})
				.finally(() => {this.category_loading_select = false;}); 
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
				var year = DateTime.fromISO(start.date).year;

				if (month == DateTime.now().month && year == DateTime.now().year) {
					this.selectedday = DateTime.now().toFormat('yyyy-MM-dd');
				} else {
					this.selectedday = DateTime.fromISO(start.date).toFormat('yyyy-MM-dd');				
				}

				var premium = 0;

				if (this.premiumstatus) {
					premium = 1;
				}
				
				axios.get('getcalendarotchets', {
					params: {
						userid: this.user.id,
						premium: premium,
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
			
			dayeventsno (date) {
				var count = 0;
				this.filteredevents.forEach((event) => {
					if (date == event.start && (!event.status || event.status.status == 0)) {
						count++;
					}
				})
				return count;
			},
						
			dayeventsyes (date) {
				var count = 0;
				this.filteredevents.forEach((event) => {
					if (date == event.start && event.status && event.status.status == 1) {
						count++;
					}
				})
				return count;
			},
			
			dayeventsnotnow (date) {
				var count = 0;
				this.filteredevents.forEach((event) => {
					if (date == event.start && event.status && event.status.status == 2) {
						count++;
					}
				})
				return count;
			},

			sendplandialog () {
				this.errors_sendplan = '';
				this.dialogSendPlan = true;
			},

			sendplan() {

				var contents = document.getElementById('printMe').innerHTML;

				var title = '';

				if (this.$refs.calendar) {
					title = this.$refs.calendar.title;
				}

				this.loading_sendplan = true;
				axios.post('sendplan', {
						html: contents,
						month: title
					})
				.then((response) => {
					this.errors_sendplan = '';
					this.loading_sendplan = false;
					this.dialogSendPlan = false;				
				})
				.catch(error => {
					this.loading_sendplan = false;
					console.log(error)
					this.errors_sendplan = error.response.data.errors;
				})
				.finally(() => {});	
			},
			
			closeSendPlan () {
				this.dialogSendPlan = false
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

	@media print {    
		.no-print, .no-print * {
			display: none !important;
		}
	}

</style>

