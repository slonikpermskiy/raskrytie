<template>
	
	<v-container fluid fill-height class="elevation-1 pa-1 ma-0 align-start">
		
		<v-container fluid class="pa-3">
			
			<v-row class="d-flex align-center px-1">
											
				<v-col
					cols="12"
					sm="6"
					md="6"
					class="my-0 py-0 mt-3">
				
					<div>				  
						<label class="typo__label">Пользователь</label>
				  
						<multiselect 
							@select="userSelect" 
							v-model="selecteduser" 
							:options="newcategoryusers" 
							track-by="id" 
							label="name" 
							:searchable="true" 					
							:close-on-select="true" 
							:show-labels="false" 
							:allow-empty="false" 
							placeholder="Выберите значение">				  
								<template slot="singleLabel" slot-scope="{ option }">{{ option.name }}</template>
								<span slot="noResult">Ничего не найдено</span>
						</multiselect>
					</div>
				</v-col>


				<v-col cols="12" class="my-0 py-0 mt-4 mb-3">
				
					<div>				  
						
						<label class="typo__label">Категория</label>
				
						<v-select
							:items="items"
							hide-details
							no-data-text="Нет данных"
							placeholder="Выберите значение"
							item-value="id" 
							solo
							v-model="selected_item"
							:loading="loading_select"
							class="d-flex align-center">
							
								<template v-slot:item="data">									
									<v-list-item-content>
										<v-list-item-title class="black--text wrap-text">{{ data.item.categoryname }}</v-list-item-title>
										<v-list-item-subtitle class="wrap-text">{{ data.item.organisationname }}</v-list-item-subtitle>
									</v-list-item-content>
								</template>
								
								<template v-slot:selection="data">			
									<v-list-item-content>
										<v-list-item-title class="black--text wrap-text">{{ data.item.categoryname }}</v-list-item-title>
										<v-list-item-subtitle class="wrap-text">{{ data.item.organisationname }}</v-list-item-subtitle>
									</v-list-item-content>
								</template>
					
								<template slot="append-outer">		
									<v-menu bottom left>
										<template v-slot:activator="{ on, attrs }">
											<v-icon 
												large 
												v-bind="attrs"
												v-on="on" 
												class="ms-2 pa-0"
												color="indigo">
													mdi-cog
											</v-icon>
										</template>

										<v-list>
											<v-list-item @click="newCategory">
												<v-list-item-title>Новая категория</v-list-item-title>
											</v-list-item>
											<v-list-item @click="changeCategory" v-if="selected_item">
												<v-list-item-title>Изменить категорию</v-list-item-title>
											</v-list-item>
											<v-list-item @click="deleteCategory" v-if="selected_item">
												<v-list-item-title>Удалить категорию</v-list-item-title>
											</v-list-item>
										</v-list>
									</v-menu>					
							</template>

						</v-select>
					
					</div>
			
				</v-col>
			
			</v-row>
						
			<div v-if="selected_item" class="mt-4 px-1">				
				
				<v-row class="my-0 py-0">	
				
					<v-col
						cols="12"
						md="6"
						v-if="detailed_item.categoryname" class="d-flex align-center my-0 py-0">
									
						<v-list-item>
							<v-list-item-content>
								<v-list-item-subtitle class="indigo--text wrap-text">Наименование отчетности</v-list-item-subtitle>
								<v-list-item-title class="black--text wrap-text" v-text="detailed_item.categoryname"></v-list-item-title>
							</v-list-item-content>
						</v-list-item>
						
					</v-col>					
					
					<v-col
						cols="12"
						md="6"
						v-if="detailed_item.goverment" class="d-flex align-center my-0 py-0">
				
						<v-list-item>
							<v-list-item-content>
								<v-list-item-subtitle class="indigo--text wrap-text">Государственный орган</v-list-item-subtitle>
								<v-list-item-title class="black--text wrap-text">{{ detailed_item.goverment }}</v-list-item-title>
							</v-list-item-content>
						</v-list-item>
					
					</v-col>
					
					<v-col
						cols="12"
						md="6"
						v-if="detailed_item.law" class="d-flex align-center my-0 py-0">
					
						<v-list-item>
							<v-list-item-content>
								<v-list-item-subtitle class="indigo--text wrap-text">Нормативный документ</v-list-item-subtitle>
								<v-list-item-title class="black--text wrap-text">{{ detailed_item.law }}</v-list-item-title>
								<v-list-item-title class="wrap-text" v-if="selecteduserid==='admin' && detailed_item.lawlink">						

									<a target="_blank" :href="detailed_item.lawlink" v-if="linkornot(detailed_item.lawlink)">
										{{ detailed_item.lawlink }}
									</a>
									
									<div v-if="!linkornot(detailed_item.lawlink)">
										{{ detailed_item.lawlink }}
									</div>

								</v-list-item-title>
							</v-list-item-content>
						</v-list-item>
					
					</v-col>
										
					<v-col
						cols="12"
						md="6"
						v-if="detailed_item.place" class="d-flex align-center my-0 py-0">
								
						<v-list-item>
							<v-list-item-content>
								<v-list-item-subtitle class="indigo--text wrap-text">Место отчетности</v-list-item-subtitle>
								<v-list-item-title class="black--text wrap-text">{{ detailed_item.place }}</v-list-item-title>
							</v-list-item-content>
						</v-list-item>
					
					</v-col>
										
					<v-col
						cols="12"
						md="6"
						v-if="detailed_item.comment" class="d-flex align-center my-0 py-0">
						
						<v-list-item>
							<v-list-item-content>
								<v-list-item-subtitle class="indigo--text wrap-text">Комментарий</v-list-item-subtitle>
								<v-list-item-title class="black--text wrap-text">{{ detailed_item.comment }}</v-list-item-title>
							</v-list-item-content>
						</v-list-item>			
										
					</v-col>
								
				</v-row>
			
			</div>
			
			<v-data-table 
				:headers="headers"
				:items="otchets"
				:search="search"
				:custom-filter="customSearch"
				sort-by="id"
				class="elevation-1 mt-5 mx-1"
				mobile-breakpoint= "960"
				:loading="loading_otchs" 
				loading-text="Загрузка данных..."
				:footer-props="{itemsPerPageText: 'Строк на странице', itemsPerPageAllText: 'Все'}"
				:header-props="{sortByText: 'Сортировка'}"
				v-if="selected_item">
				
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
					{{ whosendarraytext(item) }}				
				</template>
				
				<template v-slot:item.otchetlink="{ item }">
																	
					<a target="_blank" :href="item.otchetlink" v-if="linkornot(item.otchetlink)">
						{{ item.otchetlink }}
					</a>
					
					<div v-if="!linkornot(item.otchetlink)">
						{{ item.otchetlink }}
					</div>
					
					
				</template>
				
				<template v-slot:item.firstdate="{ item }">
					<span>{{ formatDate(item.firstdate) }}</span>
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
							:label="tablesearchlabel"
							single-line
							hide-details
							spellcheck="false">
						</v-text-field>
						
						<v-spacer></v-spacer>
						
						<v-btn
							color="indigo"
							dark
							@click="newForm"
							class="mb-2">
								Новый отчет
						</v-btn>						
						
					</v-toolbar>
				</template>
				
				<template v-slot:item.соmmenttooltip="{ item }">
				
					 <v-tooltip left v-if="item.comment != null & item.comment != ''" max-width="400px">
						
						<template v-slot:activator="{ on, attrs }">
						
							<v-icon
								small
								v-bind="attrs"
								v-on="on"
								color="primary">
									mdi-comment-text-outline
								</v-icon>

						</template>
					  
						<span>{{ item.comment }}</span>
					
					</v-tooltip>

				</template>	
					
				<template v-slot:item.actions="{ item }">
					<v-icon
						small
						class="mr-1"
						@click="editForm(item)">
							mdi-pencil
					</v-icon>
			  
					<v-icon
						small
						class="mr-1"
						@click="deleteForm(item)">
							mdi-delete
					</v-icon>
					
				</template>	

			</v-data-table>

		</v-container>
		
		<v-dialog
			v-model="dialog_cat"
			scrollable
			max-width="800px"
			persistent>

			<v-card>
				<v-card-title>
					<span class="text-h5">{{ categoryTitle }}</span>
					<v-spacer></v-spacer>
					<v-btn
						icon
						@click="dialog_cat = false">
						<v-icon>mdi-close</v-icon>
					</v-btn>  
				</v-card-title>

				<v-card-text>
					<v-container>
						<div v-if="errors_cat">
							<div v-for="(v, k) in errors_cat" :key="k">
								<v-alert type="error" v-for="error in v" :key="error">{{ error }}</v-alert>
							</div>
						</div>
						
						<v-row class="my-0 py-0 d-flex flex-column">
				  
							<v-form ref="form_cat" v-model="valid_cat">
							
								<v-col cols="12" class="pt-0">
								
									<v-text-field
										v-model="form_cat.categoryname"
										label="Наименование отчетности"
										v-on:keyup.enter="focusNext($event.target)"
										:rules="nameRules"
										required
										outline
										autofocus
										type="text"
										spellcheck="false">
									</v-text-field>
								
								</v-col>
								
								<v-col cols="12" class="pt-0">
														
									<v-text-field
										v-model="form_cat.goverment"
										label="Государственный орган"
										v-on:keyup.enter="focusNext($event.target)"
										outline
										type="text"
										spellcheck="false">
									</v-text-field>
								
								</v-col>
								
								<v-col cols="12" class="pt-0">
															
									<v-text-field
										v-model="form_cat.law"
										label="Нормативный документ"
										v-on:keyup.enter="focusNext($event.target)"
										outline
										type="text"
										spellcheck="false">
									</v-text-field>
								
								</v-col>
								
								<v-col cols="12" class="pt-0" v-if="selecteduserid==='admin'">
								
									<v-text-field
										v-model="form_cat.lawlink"
										label="Ссылка на нормативный документ"
										v-on:keyup.enter="focusNext($event.target)"
										outline
										type="text"
										spellcheck="false">
									</v-text-field>
								
								</v-col>
								
								<v-col cols="12" class="pt-0">
														
									<v-text-field
										v-model="form_cat.place"
										label="Место отчетности"
										v-on:keyup.enter="focusNext($event.target)"
										outline
										type="text"
										spellcheck="false">
									</v-text-field>
								
								</v-col>
								
								<v-col cols="12" class="pt-0">
															
									<v-text-field
										v-model="form_cat.comment"
										label="Комментарий"
										@keydown.enter="save"
										outline
										type="text"
										spellcheck="false">
									</v-text-field>
								
								</v-col>

							</v-form>
						
						</v-row>
					
					</v-container>
				</v-card-text>

				<v-card-actions>
					<v-spacer></v-spacer>
			
					<v-btn color="info" @click="save" :loading="loading_cat" class="mb-2">
						Сохранить
					</v-btn>
				</v-card-actions>
			</v-card>

		</v-dialog>
		
		
		<v-dialog v-model="dialogDelete" max-width="500px" scrollable persistent>
			<v-card>
			
				<v-card-title>
					<span class="text-h5">Удалить категорию?</span>
					<v-spacer></v-spacer>
					<v-btn
						icon
						@click="dialogDelete = false">
							<v-icon>mdi-close</v-icon>
					</v-btn>  
				</v-card-title>
				
				<v-card-text>
				
					<v-container>
								  
						<div v-if="errors_del">
							<div v-for="(v, k) in errors_del" :key="k">
								<v-alert type="error" v-for="error in v" :key="error">{{ error }}</v-alert>
							</div>
						</div>
						
						<div class="black--text text-body-1 wrap-text">
							При удалении категории будут удалены все связанные с ней отчеты. Подтвердите удаление.
						</div>
						
					</v-container>

				</v-card-text>

				<v-card-actions>
					<v-spacer></v-spacer>
					
					<v-btn color="info" @click="deleteCategoryConfirm" :loading="loading_del" class="mb-2">
						Удалить
					</v-btn>

				</v-card-actions>
			</v-card>
		</v-dialog>
		
				
		<v-dialog
			v-model="dialog_otch"
			scrollable
			max-width="800px"
			persistent>

			<v-card>

				<v-card-title>
					<span class="text-h5">{{ formTitle }}</span>
					<v-spacer></v-spacer>
					<v-btn
						icon
						@click="dialog_otch = false">
							<v-icon>mdi-close</v-icon>
					</v-btn>  
				</v-card-title>

				<v-card-text>
					<v-container>
			  
						<div v-if="errors_otch">
							<div v-for="(v, k) in errors_otch" :key="k">
								<v-alert type="error" v-for="error in v" :key="error">{{ error }}</v-alert>
							</div>
						</div>
						
						
						<v-row class="my-0 py-0 d-flex flex-column">
						
							<v-form ref="form_otch" v-model="valid_otch">
	
								<v-col cols="12" class="pt-0">	
										
									<v-text-field
										v-model="form_otch.otchetname"
										label="Наименование отчета"
										v-on:keyup.enter="focusNext($event.target)"
										:rules="nameFormRules"
										required
										outline
										autofocus
										type="text"
										spellcheck="false">
									</v-text-field>

								</v-col>
								
								<v-col cols="12" class="pt-0 pb-0">	
										
									<v-text-field
										v-model="form_otch.razdelname"
										label="Уточнение (статья, пункт постановления)"
										v-on:keyup.enter="focusNext($event.target)"
										outline
										type="text"
										spellcheck="false">
									</v-text-field>

								</v-col>

								<v-col cols="12" class="py-0 pt-4 mt-1" v-if="selecteduserid==='admin'">	
										
									<v-menu
										v-model="firstdatemenu"
										:close-on-content-click="false"
										:nudge-right="40"
										transition="scale-transition"
										offset-y
										min-width="auto">        
										<template v-slot:activator="{ on, attrs }">
											<v-text-field
												v-model="computedDateFormatted"
												label="Дата первого отчета"
												prepend-icon="mdi-calendar"
												readonly
												v-bind="attrs"
												v-on="on"
												outline
												class="py-0">
											</v-text-field>
										</template>
										<v-date-picker
											v-model="form_otch.firstdate"
											no-title
											@input="firstdatemenu = false"
											:first-day-of-week="1"
											locale="ru-ru">
										</v-date-picker>
									</v-menu>

								</v-col>
													
								<v-col cols="12" class="pt-4 pb-2" v-if="!form_otch.status">	
										
									<v-spacer></v-spacer>

									<v-btn color="info" @click="addperiodform" class="px-2 mb-2">
										<v-icon>mdi-plus</v-icon>
										Срок предоставления
									</v-btn>

								</v-col>
								
								<v-col cols="12" class="pt-2 pb-2" v-if="form_otch.status">	
										
									<div class="d-flex flex-row align-center text-body-2">				  
						
										<v-icon
											color="red"
											large
											class="mr-3">
												mdi-information-outline
										</v-icon>

										<div>Возможность редактирования периодичности сдачи отчета ограничена т.к. у отчета есть сохраненные данные о сроках сдачи. Для сохранения статистики, создайте новый отчет. Для редактирования периодичности сдачи, удалите данные о сроках сдачи.</div>
									</div>

								</v-col>
								
								<v-col cols="12" class="pt-2 pb-3" v-if="form_otch.status">	
										
									<v-btn small dark color="red" @click="deleteStatistic()" :loading="loading_delete_statistic">
										Удалить статистику
									</v-btn>

								</v-col>
								
								
								<v-col cols="12" class="py-0">	
										
									<div v-if="reportdays">
										<v-list class="pa-0">									  
											<v-list-item v-for="(value, index) in reportdays" :key="index" class="pa-0">
																				
												<v-list-item-avatar>
													<v-icon large color="indigo" dark>										  
														mdi-timer-outline
													</v-icon>
												</v-list-item-avatar>
												
												
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
													textsize="text-body-1"
													padding="py-1"/>

												<v-list-item-action v-if="!form_otch.status">										
													<v-btn icon>											
														<v-icon @click="removeperiod(index)">
															mdi-delete
														</v-icon>												
													</v-btn>
												</v-list-item-action>
											</v-list-item>
									
										</v-list>
										
										<div v-if="form_otch.status" class="pb-2"></div>
										
									</div>
								</v-col>

								<v-col cols="12" class="pt-0" v-if="selecteduserid==='admin'">	
										
									<v-select
										v-model="form_otch.whosend"
										label="Кто предоставляет"
										multiple
										:items="whosenditems">

										<template v-slot:prepend-item>
											<v-list-item
											ripple
											@mousedown.prevent
											@click="allselectedtoggle"
											>
											<v-list-item-action>
												<v-icon :color="(form_otch.whosend != null && form_otch.whosend.length > 0) ? 'indigo' : ''">
													{{ allselectedicon }}
												</v-icon>
											</v-list-item-action>
											<v-list-item-content>
												<v-list-item-title>
													Выбрать все
												</v-list-item-title>
											</v-list-item-content>
											</v-list-item>
											<v-divider class="mt-2"></v-divider>
										</template>


									</v-select>

								</v-col>
															
								<v-col cols="12" class="pt-0" v-if="selecteduserid==='admin'">	
										
									<v-text-field
										v-model="form_otch.otchetlink"
										label="Ссылка на бланк отчета"
										v-on:keyup.enter="focusNext($event.target)"
										outline
										type="text"
										spellcheck="false">
									</v-text-field>

								</v-col>
								
								
								<v-col cols="12" class="pt-0">	
										
									<v-text-field
										v-model="form_otch.comment"
										label="Комментарий"
										@keydown.enter="saveform"
										outline
										type="text"
										spellcheck="false">
									</v-text-field>

								</v-col>

							</v-form>
							
						</v-row>

					</v-container>
				</v-card-text>
				

				<v-card-actions>
					<v-spacer></v-spacer>
		
					<v-btn color="info" @click="saveform" :loading="loading_otch" class="mb-2">
						Сохранить
					</v-btn>
				</v-card-actions>
			</v-card>

		</v-dialog>
		
		
		
		<addperioddialog 
			v-model="dialog_addperiod"
			:addtoreportdays="addtoreportdays"
			:freqitems="freqitems"
			:intervdayitems="intervdayitems"
			:intervweekitems="intervweekitems"
			:weekdaysitems="weekdaysitems"		
			:intervmonthitems="intervmonthitems"
			:defaultmonthdays="defaultmonthdays"
			:monthweekitems="monthweekitems"
			:intervquarteritems="intervquarteritems"
			:quarterdays="quarterdays"
			:intervyearitems="intervyearitems"
			:yearmonthitems="yearmonthitems"/>
		
		
		<v-dialog v-model="dialogDeleteForm" max-width="500px" scrollable persistent>
			<v-card>
			
				<v-card-title>
					<span class="text-h5">Удалить отчет?</span>
					<v-spacer></v-spacer>
					<v-btn
						icon
						@click="dialogDeleteForm = false">
							<v-icon>mdi-close</v-icon>
					</v-btn>  
				</v-card-title>
				
				<v-card-text>
				
					<v-container>
								  
						<div v-if="errors_delform">
							<div v-for="(v, k) in errors_delform" :key="k">
								<v-alert type="error" v-for="error in v" :key="error">{{ error }}</v-alert>
							</div>
						</div>
						
						<div class="black--text text-body-1 wrap-text">
							Подтвердите удаление.
						</div>
						
					</v-container>

				</v-card-text>

				<v-card-actions>
					<v-spacer></v-spacer>
					
					<v-btn color="info" @click="deleteFormConfirm" :loading="loading_delform" class="mb-2">
						Удалить
					</v-btn>

				</v-card-actions>
			</v-card>
		</v-dialog>
		
		

	</v-container>
	
</template>



<script>

	import OtchetPeriods from "../OtchetPeriods.vue";
	import {DateTime} from "luxon";

	export default {
	
		data: () => ({
			dialog_cat: false,
			dialogDelete: false,
			errors_cat: '',
			errors_del: '',			
			valid_cat: true,
			loading_cat: false,
			loading_select: false,
			loading_userselect: false,
			loading_del: false,	
			nameRules: [],
			
			selecteduser: {id: 'admin', name: 'Администратор'},
			
			searchTerm: '',
			usersCopy: [],
			
			
			form_cat: {},
			default_form_cat_item: {
				id: '',
				categoryname: '',
				goverment: '',	
				law: '',	
				lawlink: '',
				place: '',
				comment: '',
				organisation: '',
				staff: 0,
			},
			
			newcategoryusers: [],
				
			items: [],
			selected_item: 0,			
			detailed_item: {},
			categoryTitle: '',
			
			
			
			loading_otchs: false,
			
			search: '',
			otchets: [],
			
			formTitle: '',
			

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
	
			monthdays: [],

						
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

			
			dialog_addperiod: false,
			
			reportdays: [],
			
			dialog_otch: false,
			errors_otch: '',
			loading_otch: false,
			valid_otch: true,
			nameFormRules: [],
			
			form_otch: {},
			
			default_form_otch_item: {
				id: '',
				category: '',
				categorytable: '',
				otchetname: '',
				razdelname: '',
				reportdays: [],	
				firstdate: '',		
				whosend: [],
				otchetlink: '',
				comment: '',
				organisation: '',
				staff: 0,
				neworedit: 0,
			},	

			dialogDeleteForm: false,
			errors_delform: '',	
			loading_delform: false,	
			formtodelid: 0,	

			loading_delete_statistic: false,
			
			firstdatemenu: false,

			whosenditems: ['Генерация ЭЭ', 'ТСО', 'Энергосбыт', 'Управление ЕЭС', 'Регулятор ЭЭ', 'Потребители ЭЭ', 'Нефть', 'Газ', 'Уголь'],
			
		}),
		
		computed: {
						
			selecteduserid () {
				return JSON.parse(JSON.stringify(this.selecteduser.id));
			},
			
			headers () {
				
				if (this.selecteduserid === 'admin') {
					return [
						{ text: 'ID', align: 'start', sortable: true, value: 'id', filterable: false },				
						{ text: 'Отчет', value: 'otchetname', sortable: true, filterable: true },	
						{ text: 'Уточнение', value: 'razdelname', sortable: false, filterable: true },				
						{ text: 'Срок предоставления', value: 'reportdays', sortable: false, filterable: false },
						{ text: 'Дата первого отчета', value: 'firstdate', sortable: false, filterable: false },
						{ text: 'Кто предоставляет', value: 'whosend', sortable: false, filterable: false  },
						{ text: 'Бланк отчета', value: 'otchetlink', sortable: false, filterable: false  },				
						{ text: 'Комментарий', value: 'соmmenttooltip', sortable: false, filterable: false },
						{ text: 'Действия', value: 'actions', sortable: false, filterable: false },
					];
				} else {
					
					return [
						{ text: 'ID', align: 'start', sortable: true, value: 'id', filterable: false },				
						{ text: 'Отчет', value: 'otchetname', sortable: true, filterable: true },	
						{ text: 'Уточнение', value: 'razdelname', sortable: false, filterable: true },				
						{ text: 'Срок предоставления', value: 'reportdays', sortable: false, filterable: false },				
						{ text: 'Кем добавлено', value: 'organisationname', sortable: false, filterable: false  },
						{ text: 'Комментарий', value: 'соmmenttooltip', sortable: false, filterable: false },
						{ text: 'Действия', value: 'actions', sortable: false, filterable: false },
					];
					
				}

			},

			tablesearchlabel () {
				
				if (this.selecteduserid === 'admin') {
					return 'Поиск (название, уточнение, кто предоставляет)';
				} else {
					return 'Поиск (название, уточнение)';
				}
	
			},

			computedDateFormatted () {
				return this.formatDate(this.form_otch.firstdate)
			},

			allselectedicon () {
				if (this.form_otch.whosend != null && this.whosenditems.length === this.form_otch.whosend.length) return 'mdi-close-box'
				if (this.form_otch.whosend != null && this.form_otch.whosend.length > 0 && this.whosenditems.length != this.form_otch.whosend.length) return 'mdi-minus-box'
				return 'mdi-checkbox-blank-outline'
			},
				
		},
				
				
		watch: {
			dialog_cat (val) {
				val || this.closecatdialog()
			},
			dialogDelete (val) {
				val || this.closeDelete()
			},
			dialog_otch (val) {
				val || this.closeOtch()
			},
			dialogDeleteForm (val) {
				val || this.closeDeleteForm()
			},
	  
			'this.form_cat.categoryname' (val) {
				this.nameRules = []
			},	
			
			
			'this.form_otch.otchetname' (val) {
				this.nameFormRules = []
			},
			
			
			reportdays (val) {
				this.form_otch.reportdays = [];
				this.reportdays.forEach((item, index) => {
					this.form_otch.reportdays.push(item);
				})
				//this.form_otch.reportdays = {...this.reportdays}
			},
			
			// слушатель изменения переменной
			selected_item(newSelected_item, oldSelected_item) {
				this.detailed_item = Object.assign({}, this.items.find(o => o.id === newSelected_item));	
				this.initializeforms();
			},
			
		},
		
		created () {
			this.initialize()
		},
			
		methods: {
						
			// сортировка input в selected
			/*sortSelection() {
				this.selected_weekdays.sort((x, y) => {
					if (x.id > y.id) return 1
					else if (y.id > x.id) return -1
					else return 0
				})
			},*/

			whosendarraytext (item) {
				if (item.whosend != null && JSON.parse(item.whosend).length != 0) {
					return JSON.parse(item.whosend).join(', ');
				} else {
					return '';
				}				
			},

			customSearch (value, search, item) {
				if ((item.otchetname != null && item.otchetname.toString().toLowerCase().includes(search.toLowerCase())) || (item.razdelname != null && item.razdelname.toString().toLowerCase().includes(search.toLowerCase())) || (item.whosend != null && JSON.parse(item.whosend).join(", ").toString().toLowerCase().includes(search.toLowerCase()))) {
					return true;
				} else {
					return false;
				}
			},

			allselectedtoggle () {
				this.$nextTick(() => {
				if (this.form_otch.whosend != null && this.whosenditems.length === this.form_otch.whosend.length) {
					this.form_otch.whosend = []
				} else if(this.form_otch.whosend != null && this.form_otch.whosend.length > 0 && this.whosenditems.length != this.form_otch.whosend.length) {
					this.form_otch.whosend = []
				} else {
					this.form_otch.whosend = this.whosenditems.slice()
				}
				})
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
			
			userSelect (option) {
				
				this.selected_item = 0;
				this.setCategoriesList ();
			  
			},
			
			
			formatDate(date) {
				if (date === null || date === undefined) {
					return DateTime.now().toFormat('dd.MM.yyyy');
				} else {
					return DateTime.fromISO(date).toFormat('dd.MM.yyyy');
				}
			},
				
			
			initialize () {	
				
				this.loading_userselect = true;
				
				this.newcategoryusers = [];
				this.newcategoryusers.push({id: 'admin', name: 'Администратор'});
				
				axios.get('userslist')
					.then((response) => {						
		
						response.data.forEach((item, index) => {
							this.newcategoryusers.push({id: item.id, name: item.name});
						})

						this.setCategoriesList ();
					})
					.catch(error => {
					})
					.finally(() => {this.loading_userselect = false;}); 
				
			},
			
			setCategoriesList () {
				
				this.loading_select = true;
				axios.get('categorieslist', {
					params: {
						organisation: this.selecteduser.id
					}
					})
				.then((response) => {
											
					this.items = response.data;

					if (this.selected_item === 0) {
						this.selected_item = response.data[0].id;	
					}
										
					if (this.selected_item !== 0) {
						this.detailed_item = Object.assign({}, this.items.find(o => o.id === this.selected_item));
						this.selected_item = this.selected_item;
					}
				})
				.catch(error => {})
				.finally(() => {this.loading_select = false;}); 
			},
			
			
			initializeforms () {			  
				
				this.loading_otchs = true;
				
				axios.get('otchetslist', {
					params: {
						category: this.detailed_item.id,
						categorytable: this.detailed_item.table
					}
					})
				.then((response) => {
											
					this.otchets = response.data;
					
				})
				.catch(error => {})
				.finally(() => {this.loading_otchs = false;}); 
				
			},
			

			newCategory (item) {
				
				this.categoryTitle = 'Новая категория';
				this.dialog_cat = true
				this.form_cat = Object.assign({}, this.default_form_cat_item)				
				this.form_cat.organisation = JSON.parse(JSON.stringify(this.selecteduser.id))
				this.errors_cat = '';  
				
			},
			
			changeCategory (item) {	

				this.categoryTitle = 'Изменить категорию';
				this.dialog_cat = true
				this.form_cat = Object.assign({}, this.default_form_cat_item)						
				this.errors_cat = '';
				this.form_cat = Object.assign({}, this.items.find(o => o.id === this.selected_item));				
				
			},
				
			save () {	  
			
				this.nameRules = [
					value => !!value || 'Поле обязательно для заполнения',
				]	
				
				setTimeout(function () {
					if (this.$refs.form_cat.validate() == true && !this.loading_cat){
						
						this.loading_cat = true;						
						axios.post('newcategory', this.form_cat)
						.then((response) => {
							this.loading_cat = false;
							this.errors_cat = '';
							this.selected_item = response.data.newid;
							this.closecatdialog()
							this.setCategoriesList();
						})
						.catch(error => {
							this.loading_cat = false;
							if (error.response.data.errors)
							this.errors_cat = error.response.data.errors;
						});
								
					}  
				}.bind(this))

			},
			
			
			deleteCategory (item) {
				this.errors_del = '';
				this.dialogDelete = true
			},


			deleteCategoryConfirm () {
				setTimeout(function () {
					this.loading_del = true;	
					axios.post('deletecategory', this.items.find(o => o.id === this.selected_item))
					.then((response) => {
						this.loading_del = false;
						this.errors_del = '';
						this.closeDelete();
						this.selected_item = 0
						this.setCategoriesList ();
					})
					.catch(error => {
						this.loading_del = false;
						if (error.response.data.errors)
						this.errors_del = error.response.data.errors;
					});					 
				}.bind(this))
			},
			
			
			newForm () {		
				this.form_otch = Object.assign({}, this.default_form_otch_item)	
				this.form_otch.organisation = JSON.parse(JSON.stringify(this.selecteduser.id))				
				this.form_otch.category = JSON.parse(JSON.stringify(this.detailed_item.id))
				this.form_otch.categorytable = JSON.parse(JSON.stringify(this.detailed_item.table))
				this.reportdays = [];
				
				this.form_otch.firstdate = DateTime.now().toFormat('yyyy-MM-dd'),

				this.form_otch.neworedit = 0;
				this.form_otch.staff = 0;
				
				
				this.formTitle = 'Новый отчет';			
				this.dialog_otch = true;
				this.errors_otch = '';			
			},
			
			
			editForm (item) {
				this.formTitle = 'Изменить отчет';
				this.dialog_otch = true
				this.form_otch = Object.assign({}, this.default_form_otch_item)	
				this.reportdays = [];		
				this.errors_otch = '';
				this.form_otch = Object.assign({}, this.otchets.find(o => o.id === item.id));
				//this.form_otch.firstdate = DateTime.fromISO(date).toFormat('dd.MM.yyyy');
				this.reportdays = JSON.parse(item.reportdays);
				this.form_otch.whosend = JSON.parse(item.whosend);
				this.form_otch.neworedit = 1;
				this.form_otch.staff = 0;	
				
			},
			
			addperiodform () {			
				this.dialog_addperiod = true
			},
			
			
			addtoreportdays(value) {
				this.reportdays.push(value);
			},
			
			
			removeperiod(index) {
				this.reportdays.splice(index, 1);
			},
			
			
			saveform () {	  
			
				this.nameFormRules = [
					value => !!value || 'Поле обязательно для заполнения',
				]	
				
				setTimeout(function () {
					
					if (this.$refs.form_otch.validate() == true && !this.loading_otch){
						
						if (this.form_otch.reportdays.length == 0) {
							
							this.errors_otch = [{error: 'Не указан срок предоставления отчета'}];
							
						} else {
							
							this.loading_otch = true;						
						
							axios.post('newotchet', this.form_otch)
							.then((response) => {
								this.loading_otch = false;
								this.errors_otch = '';
								this.initializeforms ();							
								this.closeOtch()
							})
							.catch(error => {
								this.loading_otch = false;
								if (error.response.data.errors)
								this.errors_otch = error.response.data.errors;
							});
						
						}
						
					}  
				}.bind(this))

			},
			
			
			deleteForm(item) {
				this.errors_delform = '';
				this.dialogDeleteForm = true;
				this.formtodelid = item.id;
			},
			
			
			deleteFormConfirm () {
				
				setTimeout(function () {
					this.loading_delform = true;	
					axios.post('deleteotchet', this.otchets.find(o => o.id === this.formtodelid))
					.then((response) => {
						this.loading_delform = false;
						this.errors_delform = '';
						this.formtodelid = 0
						this.closeDeleteForm();
						this.initializeforms ();
					})
					.catch(error => {
						this.loading_delform = false;
						if (error.response.data.errors)
						this.errors_delform = error.response.data.errors;
					});					 
				}.bind(this))

			},
			
			  
			focusNext(elem) {
				const currentIndex = Array.from(elem.form.elements).indexOf(elem);
				elem.form.elements.item(
					currentIndex < elem.form.elements.length - 1 ?
					currentIndex + 1 : 0
				).focus(); 
			},
							
			closecatdialog () {
				this.dialog_cat = false
				this.nameRules = [];
			},
			
			closeDelete () {
				this.dialogDelete = false
			},
			
			closeOtch () {
				this.dialog_otch = false
				this.nameFormRules = [];
			},
			
			closeDeleteForm () {
				this.dialogDeleteForm = false
			},
			
			deleteStatistic () {
				
				setTimeout(function () {
					
					if (!this.loading_delete_statistic){
		
						this.loading_delete_statistic = true;	

						axios.post('admindeleteotchetstatistic', this.form_otch)
						.then((response) => {
							this.loading_delete_statistic = false;
							this.form_otch.status = false;
						})
						.catch(error => {
							this.loading_delete_statistic = false;
						});
								
					}  
				}.bind(this))
		
			},
		},

	}

</script>

<style scoped>

</style>


<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>


<style>

	.v-application ul, .v-application ol {
		padding-left: 0px;
	}
	
	.multiselect {
		color: #000000;
	}
		
	.multiselect__option--selected {
		background: #d7e5ef;
		font-weight: 100;
		color: #000000;
	}

	.multiselect__option--selected.multiselect__option--highlight {
		background: #d7e5ef;
		color: #000000;
	}

	.multiselect__option--highlight {
		background: #f6f6f6;
		color: #000000;
	}
	
	.wrap-text {
		white-space: normal;
	}
	
	.v-text-field.v-text-field--solo .v-input__prepend-outer, .v-text-field.v-text-field--solo .v-input__append-outer {
		margin-top: 0px;
	}

	.v-input__append-outer, .v-input__prepend-outer {
		margin-bottom: 0px;
		margin-top: 0px;
	}
	
	.v-select__selection {
		max-width: 100%;
	}
	
	.v-dialog__content {
		min-width: 480px;
	}
	.v-text-field .v-input__prepend-inner, .v-text-field .v-input__append-inner {
		align-self: center;
	}
	
	
	.v-text-field.v-text-field--solo:not(.v-text-field--solo-flat) > .v-input__control > .v-input__slot {
		border: 1px solid #e8e8e8;
		box-shadow: none;
	}
		
</style>


