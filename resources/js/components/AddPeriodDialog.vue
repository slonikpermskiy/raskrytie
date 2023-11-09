<template>

	<v-dialog
			v-model="show"
			scrollable
			max-width="800px"
			persistent>

			<v-card>

				<v-card-title>
					<span class="text-h5">Срок предоставления</span>
					<v-spacer></v-spacer>
					<v-btn
						icon
						@click.stop="show=false">
							<v-icon>mdi-close</v-icon>
					</v-btn>  
				</v-card-title>

				<v-card-text>
					<v-container>
			  
						<v-row class="my-0 py-0">

							<v-col
								cols="12"
								sm="6"
								md="6">
								
								<v-select
									:items="freqitems"
									hide-details
									no-data-text="Нет данных"
									placeholder="Выберите значение" 
									label="Частота"
									item-text="value"
									item-value="id"
									v-model="reportday.selected_freq"
									:loading="loading_freq"
									@change="(selection) => freqselectionChanged(selection)"
									class="d-flex align-center">
								</v-select>
							</v-col>

							<v-col
								cols="12"
								sm="6"
								md="6"
								v-if="reportday.selected_freq==1">
								
								<v-menu
									v-model="onetimedaymenu"
									:close-on-content-click="false"
									:nudge-right="40"
									transition="scale-transition"
									offset-y
									min-width="auto">        
									<template v-slot:activator="{ on, attrs }">
										<v-text-field
											v-model="computedDateFormatted"
											label="Дата отчета"
											prepend-icon="mdi-calendar"
											readonly
											hide-details
											v-bind="attrs"
											v-on="on"
											outline
											append-icon="mdi-close"
											@click:append="clearOnetimeday">
										</v-text-field>
									</template>
									<v-date-picker
										v-model="reportday.onetimeday"
										no-title
										@input="onetimedaymenu = false"
										:first-day-of-week="1"
										locale="ru-ru">
									</v-date-picker>
								</v-menu>
							</v-col>
							
							<v-col
								cols="12"
								sm="6"
								md="6"
								v-if="reportday.selected_freq==2">
								
								<v-select
									:items="intervdayitems"										
									no-data-text="Нет данных"
									placeholder="Выберите значение" 
									label="Интервал"
									item-text="value"
									item-value="id"
									hide-details
									v-model="reportday.selected_intervday"
									:loading="loading_intervday"
									class="d-flex align-center">
								</v-select>
							</v-col>

							<v-col
								cols="12"
								sm="6"
								md="6"
								v-if="reportday.selected_freq==3">
								
								<v-select
									:items="intervweekitems"										
									no-data-text="Нет данных"
									placeholder="Выберите значение" 
									label="Интервал"
									item-text="value"
									item-value="id"
									hide-details
									v-model="reportday.selected_intervweek"
									:loading="loading_intervweek"
									class="d-flex align-center">
								</v-select>
							</v-col>

							<v-col
								cols="12"
								sm="6"
								md="6"
								v-if="reportday.selected_freq==3">
								
								<v-select										
									:items="weekdaysitems"										
									no-data-text="Нет данных"
									placeholder="Выберите значение" 
									label="День"
									item-text="value"										
									item-value="id"
									hide-details							
									v-model="reportday.selected_weekdays"
									:loading="loading_weekdays"
									class="d-flex align-center">	
								</v-select>
							</v-col>

							<v-col
								cols="12"
								sm="6"
								md="6"
								v-if="reportday.selected_freq==4">
								
								<v-select
									:items="intervmonthitems"										
									no-data-text="Нет данных"
									placeholder="Выберите значение" 
									label="Интервал"
									item-text="value"
									item-value="id"
									hide-details
									v-model="reportday.selected_intervmonth"
									:loading="loading_intervmonth"
									class="d-flex align-center">
								</v-select>
							</v-col>

							<v-col
								cols="12"									
								v-if="reportday.selected_freq==4"
								class="d-flex align-center">
							
								<v-radio-group 
									v-model="reportday.monthmethod"
									row
									hide-details
									mandatory
									class="my-0">
										<v-radio name="reportday.monthmethod" label="День" :value="1"></v-radio>
										<v-radio name="reportday.monthmethod" label="Неделя" :value="2"></v-radio>                
								</v-radio-group>
				
							</v-col>

							<v-col
								cols="12"
								sm="4"
								md="4"
								v-if="reportday.selected_freq==4 & reportday.monthmethod==1">

								<v-select								
									:items="monthdays"										
									no-data-text="Нет данных"
									placeholder="Выберите значение" 
									label="День"
									item-text="value"
									item-value="id"
									hide-details							
									v-model="reportday.selected_monthdays"
									:loading="loading_monthdays"
									class="d-flex align-center">
								</v-select>
																
							</v-col>								
							
							<v-col
								cols="12"
								sm="6"
								md="6"
								v-if="reportday.selected_freq==4 & reportday.monthmethod==2">

								<v-select										
									:items="monthweekitems"										
									no-data-text="Нет данных"
									placeholder="Выберите значение" 
									label="Неделя месяца"
									item-text="value"
									item-value="id"
									hide-details							
									v-model="reportday.selected_monthweek"
									:loading="loading_monthweek"
									class="d-flex align-center">
								</v-select>
																
							</v-col>

							<v-col
								cols="12"
								sm="6"
								md="6"
								v-if="reportday.selected_freq==4 & reportday.monthmethod==2">
								
								<v-select										
									:items="weekdaysitems"										
									no-data-text="Нет данных"
									placeholder="Выберите значение" 
									label="День"
									item-text="value"										
									item-value="id"
									hide-details							
									v-model="reportday.selected_monthweekdays"
									:loading="loading_monthweekdays"
									class="d-flex align-center">	
								</v-select>
							</v-col>
															
							<v-col
								cols="12"
								sm="6"
								md="6"
								v-if="reportday.selected_freq==5">
								
								<v-select
									:items="intervquarteritems"										
									no-data-text="Нет данных"
									placeholder="Выберите значение" 
									label="Интервал"
									item-text="value"
									item-value="id"
									hide-details
									v-model="reportday.selected_intervquarter"
									:loading="loading_intervquarter"
									class="d-flex align-center">
								</v-select>
							</v-col>
							
							<v-col
								cols="12"
								sm="4"
								md="4"
								v-if="reportday.selected_freq==5">

								<v-select								
									:items="quarterdays"										
									no-data-text="Нет данных"
									placeholder="Выберите значение" 
									label="День"
									item-text="value"
									item-value="id"
									hide-details							
									v-model="reportday.selected_quarterdays"
									:loading="loading_quarterdays"
									class="d-flex align-center">
								</v-select>
																
							</v-col>
							
							<v-col
								cols="12"
								sm="6"
								md="6"
								v-if="reportday.selected_freq==6">
								
								<v-select
									:items="intervyearitems"										
									no-data-text="Нет данных"
									placeholder="Выберите значение" 
									label="Интервал"
									item-text="value"
									item-value="id"
									hide-details
									v-model="reportday.selected_intervyear"
									:loading="loading_intervyear"
									class="d-flex align-center">
								</v-select>
							</v-col>
															
							<v-col
								cols="12"
								sm="6"
								md="6"
								v-if="reportday.selected_freq==6">
								
								<v-select
									:items="yearmonthitems"										
									no-data-text="Нет данных"
									placeholder="Выберите значение" 
									label="Месяц"
									item-text="value"
									item-value="id"
									hide-details
									v-model="reportday.selected_yearmonth"
									:loading="loading_yearmonth"
									@change="(selection) => monthselectionChanged(selection)"
									class="d-flex align-center">
								</v-select>
							</v-col>
							
							<v-col
								cols="12"	
								v-if="reportday.selected_freq==6"
								class="d-flex align-center">
								
								
								<v-radio-group 
									v-model="reportday.yearmethod"
									row
									hide-details
									mandatory
									class="my-0">
										<v-radio name="reportday.yearmethod" label="День" :value="1"></v-radio>
										<v-radio name="reportday.yearmethod" label="Неделя" :value="2"></v-radio>                
								</v-radio-group>

							</v-col>
							
							<v-col
								cols="12"
								sm="4"
								md="4"
								v-if="reportday.selected_freq==6 & reportday.yearmethod==1">

								<v-select								
									:items="monthdays"										
									no-data-text="Нет данных"
									placeholder="Выберите значение" 
									label="День"
									item-text="value"
									item-value="id"
									hide-details							
									v-model="reportday.selected_yearmonthdays"
									:loading="loading_yearmonthdays"
									class="d-flex align-center">
								</v-select>
																
							</v-col>
							
							<v-col
								cols="12"
								sm="6"
								md="6"
								v-if="reportday.selected_freq==6 & reportday.yearmethod==2">

								<v-select									
									:items="monthweekitems"										
									no-data-text="Нет данных"
									placeholder="Выберите значение" 
									label="Неделя месяца"
									item-text="value"
									item-value="id"
									hide-details							
									v-model="reportday.selected_yearmonthweek"
									:loading="loading_yearmonthweek"
									class="d-flex align-center">
								</v-select>
																
							</v-col>
							
							<v-col
								cols="12"
								sm="6"
								md="6"
								v-if="reportday.selected_freq==6 & reportday.yearmethod==2">
								
								<v-select										
									:items="weekdaysitems"										
									no-data-text="Нет данных"
									placeholder="Выберите значение" 
									label="День"
									item-text="value"										
									item-value="id"
									hide-details							
									v-model="reportday.selected_yearmonthweekdays"
									:loading="loading_yearmonthweekdays"
									class="d-flex align-center">	
								</v-select>
							</v-col>
							
							<v-col
								cols="12">
							
								<v-text-field
									v-model="reportday.comment"
									label="Коментарий"
									outline
									hide-details
									type="text"
									spellcheck="false">
								</v-text-field>
						
							</v-col>
							

						</v-row>

					</v-container>
				</v-card-text>

				<v-card-actions>
					<v-spacer></v-spacer>
		
					<v-btn color="info" @click="addperiod" :loading="loading_addperiod" class="mb-2">
						Добавить
					</v-btn>
				</v-card-actions>
			</v-card>

		</v-dialog>

</template>

<script>

	import {DateTime} from "luxon";

	export default {
		
		name: "AddPeriodDialog",
				
		data: () => ({
			
			loading_addperiod: false,
			
			reportday: {
				
			},
			
			defaultreportday: {
				selected_freq: 1,	
				onetimeday: DateTime.now().toFormat('yyyy-MM-dd'),
				comment: '',
				selected_intervday: 1,					
				selected_intervweek: 1,			
				selected_weekdays: 1,			
				selected_intervmonth: 1,		
				selected_monthdays: 1,		
				selected_monthweek: 1,
				selected_monthweekdays: 1,
				selected_intervquarter: 1,
				selected_quarterdays: 1,
				selected_intervyear: 1,
				selected_yearmonth: 1,
				selected_yearmonthdays: 1,
				selected_yearmonthweek: 1,
				selected_yearmonthweekdays: 1,
				monthmethod: 1,
				yearmethod: 1,			
			},
			
			onetimedaymenu: false,
			
			loading_freq: false,
			loading_intervday: false,
			loading_intervweek: false,
			loading_weekdays: false,
			loading_intervmonth: false,
			loading_monthdays: false,
			loading_monthweek: false,
			loading_monthweekdays: false,
			loading_intervquarter: false,
			loading_quarterdays: false,
			loading_intervyear: false,
			loading_yearmonth: false,
			loading_yearmonthdays: false,
			loading_yearmonthweek: false,
			loading_yearmonthweekdays: false,
		}),
		
		created () {
				
		},
		
		props: {
			value: Boolean,
			addtoreportdays: Function,
			freqitems: Array,
			intervdayitems: Array,
		  	intervweekitems: Array,
			weekdaysitems: Array,
			intervmonthitems: Array,
			defaultmonthdays: Array,
			monthweekitems: Array,
			intervquarteritems: Array,
			quarterdays: Array,
			intervyearitems: Array,
			yearmonthitems: Array,
		},
		
		watch: {
			value(value) {
				if (value) {
					this.reportday = Object.assign({}, this.defaultreportday)
				}
			}
		},
		
		computed: {
			show: {
				get () {
					return this.value
				},
				set (value) {
					this.$emit('input', value)
				}
			},
			
			computedDateFormatted () {
				return this.formatDate(this.reportday.onetimeday)
			},
		},
		
		
		methods: {
			
			addperiod() {
				
				this.loading_addperiod = true;
				
				if (this.reportday.selected_freq == 1) {
					this.addtoreportdays({freq: 1, onetimeday: this.reportday.onetimeday, comment: this.reportday.comment})
				} else if (this.reportday.selected_freq == 2) {
					this.addtoreportdays({freq: 2, intervday: this.reportday.selected_intervday, comment: this.reportday.comment});
				} else if (this.reportday.selected_freq == 3) {
					this.addtoreportdays({freq: 3, intervweek: this.reportday.selected_intervweek, weekdays: this.reportday.selected_weekdays, comment: this.reportday.comment});
				} else if (this.reportday.selected_freq == 4) {
					if (this.reportday.monthmethod == 1) {
						this.addtoreportdays({freq: 4, intervmonth: this.reportday.selected_intervmonth, monthmethod: 1, monthdays: this.reportday.selected_monthdays, comment: this.reportday.comment});
					} else if (this.reportday.monthmethod == 2) {
						this.addtoreportdays({freq: 4, intervmonth: this.reportday.selected_intervmonth, monthmethod: 2, monthweek: this.reportday.selected_monthweek, monthweekdays: this.reportday.selected_monthweekdays, comment: this.reportday.comment});					
					}
				} else if (this.reportday.selected_freq == 5) {		
					this.addtoreportdays({freq: 5, intervquarter: this.reportday.selected_intervquarter, quarterdays: this.reportday.selected_quarterdays, comment: this.reportday.comment});
				} else if (this.reportday.selected_freq == 6) {
					if (this.reportday.yearmethod == 1) {
						this.addtoreportdays({freq: 6, intervyear: this.reportday.selected_intervyear, yearmethod: 1, yearmonth: this.reportday.selected_yearmonth, yearmonthdays: this.reportday.selected_yearmonthdays, comment: this.reportday.comment});
					} else if (this.reportday.yearmethod == 2) {
						this.addtoreportdays({freq: 6, intervyear: this.reportday.selected_intervyear, yearmethod: 2, yearmonth: this.reportday.selected_yearmonth, yearmonthweek: this.reportday.selected_yearmonthweek, yearmonthweekdays: this.reportday.selected_yearmonthweekdays, comment: this.reportday.comment});					
					}					
				}
				
				this.loading_addperiod = false;
				
				this.show = false
				
			},
			
			freqselectionChanged(selection) {
				if (selection == 4) {
					this.monthdays = [...this.defaultmonthdays];
					//this.monthdays.splice(this.monthdays.findIndex(o => o.id === 29), 1);
					//this.monthdays.splice(this.monthdays.findIndex(o => o.id === 30), 1);
					//this.monthdays.splice(this.monthdays.findIndex(o => o.id === 31), 1);					
				} else if (selection == 6) {
					this.monthdays = [...this.defaultmonthdays];
					this.monthdays.splice(this.monthdays.findIndex(o => o.id === 32), 1);
				}
			},
			
			
			monthselectionChanged(selection) {
				if (selection == 1 | selection == 3 | selection == 5 | selection == 7 | selection == 8 | selection == 10 | selection == 12) {
					this.monthdays = [...this.defaultmonthdays];
					this.monthdays.splice(this.monthdays.findIndex(o => o.id === 32), 1);					
				} else if (selection == 2) {
					this.monthdays = [...this.defaultmonthdays];
					this.monthdays.splice(this.monthdays.findIndex(o => o.id === 29), 1);
					this.monthdays.splice(this.monthdays.findIndex(o => o.id === 30), 1);
					this.monthdays.splice(this.monthdays.findIndex(o => o.id === 31), 1);
					this.monthdays.splice(this.monthdays.findIndex(o => o.id === 32), 1);
				} else if (selection == 4 | selection == 6 | selection == 9 | selection == 11) {
					this.monthdays = [...this.defaultmonthdays];
					this.monthdays.splice(this.monthdays.findIndex(o => o.id === 31), 1);
					this.monthdays.splice(this.monthdays.findIndex(o => o.id === 32), 1);
				}
			},
		
			formatDate(date) {
				if (date === null || date === undefined) {
					return null
				} else {
					return DateTime.fromISO(date).toFormat('dd.MM.yyyy');
				}
			},
			
			clearOnetimeday() {
				this.reportday.onetimeday = null;
			},
				
		},

	}

</script>