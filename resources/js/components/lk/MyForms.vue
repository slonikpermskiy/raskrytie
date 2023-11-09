<template>
	
	<v-container fluid fill-height class="maincontainer elevation-1 pa-1 ma-0 align-start">
		
		<v-container fluid class="pa-3" v-if="user.id">
					
			<v-tabs
				v-model="tab"
				background-color="transparent"
				color="indigo"
				grow
				class="px-1">
				
				<v-tab>
					Системные отчеты
				</v-tab>
				<v-tab>
					Мои отчеты
				</v-tab>
			</v-tabs>

			<v-tabs-items v-model="tab" class="px-1">

				<v-tab-item>

					<v-row class="d-flex align-center mt-4 pt-2 mb-3">
										
						<v-col cols="12" class="my-0 py-0">
						
							<div>				  
								
								<label class="typo__label justify-center">Категория</label>
						
								<v-select
									:items="items"
									hide-details
									no-data-text="Нет данных"
									placeholder="Выберите значение"
									item-value="id"
									item-text="categoryname"										
									solo
									v-model="selected_item"
									:loading="loading_select"
									class="d-flex align-center">
								</v-select>
							
							</div>
					
						</v-col>
					
					</v-row>
								
					<div v-if="selected_item" class="mt-4">				
						
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
										<v-list-item-title class="wrap-text" v-if="detailed_item.lawlink">						

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
					
					
					<v-row class="d-flex align-center">
										
						<v-col cols="12" class="">
					
							<v-data-table 
								:headers="headers"
								:items="otchetsfilter"
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


										<div class="ms-5 me-3">
											<v-switch
												v-model="inplan"
												hide-details
												inset
												label="В плане отчетности">
											</v-switch>
										</div>
										
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
									
								<template v-slot:item.actions="{ item }">
								
									<div v-if="item.otchetstartdate === null">
									
										<v-tooltip left max-width="400px">
											
											<template v-slot:activator="{ on, attrs }">
												
												<v-icon
													v-bind="attrs"
													v-on="on"
													class="mr-1"
													color="red">
														mdi-close-thick
												</v-icon>

											</template>
										  
											<span>Нет в плане отчетности</span>
											
										</v-tooltip>

										<v-icon
											class="mr-1"
											color="green"
											@click="openOtchDate(item)">
												mdi-plus-box
										</v-icon>

									</div>
									
									<div v-if="item.otchetstartdate !== null">

										<v-tooltip left max-width="400px">
											
											<template v-slot:activator="{ on, attrs }">
											
												<v-icon
													v-bind="attrs"
													v-on="on"	
													class="mr-1"
													color="green">
														mdi-check-bold
												</v-icon>

											</template>
										  
											<span>В плане отчетности с {{ formatDate(item.otchetstartdate.date) }}</span>
										
										</v-tooltip>

										<v-icon
											class="mr-1"
											color="red"
											@click="deletePlan(item.otchetstartdate.id)">
												mdi-delete-forever
										</v-icon>

									</div>

								</template>

								<template v-slot:item.statistic="{ item }">

									<v-icon
										v-if="item.otchetstartdate !== null"
										color="primary"
										class="mr-1"
										@click="openOtchStatData(item)">
											mdi-list-status
									</v-icon>

								</template>
							
							</v-data-table>
					
						</v-col>
					
					</v-row>

				</v-tab-item>
			  
				<v-tab-item>
				
					<v-row class="d-flex align-center justify-center my-5 pt-2 mb-3" v-if="!premiumstatus">
										
						<v-col cols="12" class="my-0 py-0">
						
							<div class="d-flex flex-row align-center justify-center">				  
								
								<v-icon
									color="red"
									x-large
									class="mr-3">
										mdi-cancel
								</v-icon>

								<div>Добавление своих отчетов доступно только для пользователей с уровнем доступа Премиум. Узнайте как изменить уровень доступа в разделе 
									<router-link to="/lk/settings">Настройки пользователя</router-link>.</div>
							</div>
					
						</v-col>
					
					</v-row>
		
					<v-row class="d-flex align-center mt-4 pt-2 mb-3" v-if="premiumstatus">
					
						<v-col cols="12" class="my-0 py-0">
					
							<div>				  
								
								<label class="typo__label justify-center">Категория</label>
																
								<v-select
									:items="useritems"
									hide-details
									no-data-text="Нет данных"
									placeholder="Выберите значение"
									item-value="id"
									item-text="categoryname"										
									solo
									v-model="user_selected_item"
									:loading="user_loading_select"
									class="d-flex align-center">
									
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
													<v-list-item @click="newUserCategory">
														<v-list-item-title>Новая категория</v-list-item-title>
													</v-list-item>
													<v-list-item @click="changeUserCategory" v-if="user_selected_item">
														<v-list-item-title>Изменить категорию</v-list-item-title>
													</v-list-item>
													<v-list-item @click="deleteUserCategory" v-if="user_selected_item">
														<v-list-item-title>Удалить категорию</v-list-item-title>
													</v-list-item>
												</v-list>
											</v-menu>					
										</template>
									
								</v-select>
							
							</div>
					
						</v-col>
					
					</v-row>
					
					<div v-if="premiumstatus && user_selected_item" class="mt-4 px-1">				
				
						<v-row class="my-0 py-0">	
						
							<v-col
								cols="12"
								md="6"
								v-if="user_detailed_item.categoryname" class="d-flex align-center my-0 py-0">
											
								<v-list-item>
									<v-list-item-content>
										<v-list-item-subtitle class="indigo--text wrap-text">Наименование отчетности</v-list-item-subtitle>
										<v-list-item-title class="black--text wrap-text" v-text="user_detailed_item.categoryname"></v-list-item-title>
									</v-list-item-content>
								</v-list-item>
								
							</v-col>					
							
							<v-col
								cols="12"
								md="6"
								v-if="user_detailed_item.goverment" class="d-flex align-center my-0 py-0">
						
								<v-list-item>
									<v-list-item-content>
										<v-list-item-subtitle class="indigo--text wrap-text">Государственный орган</v-list-item-subtitle>
										<v-list-item-title class="black--text wrap-text">{{ user_detailed_item.goverment }}</v-list-item-title>
									</v-list-item-content>
								</v-list-item>
							
							</v-col>
							
							<v-col
								cols="12"
								md="6"
								v-if="user_detailed_item.law" class="d-flex align-center my-0 py-0">
							
								<v-list-item>
									<v-list-item-content>
										<v-list-item-subtitle class="indigo--text wrap-text">Нормативный документ</v-list-item-subtitle>
										<v-list-item-title class="black--text wrap-text">{{ user_detailed_item.law }}</v-list-item-title>
									</v-list-item-content>
								</v-list-item>
							
							</v-col>
												
							<v-col
								cols="12"
								md="6"
								v-if="user_detailed_item.place" class="d-flex align-center my-0 py-0">
										
								<v-list-item>
									<v-list-item-content>
										<v-list-item-subtitle class="indigo--text wrap-text">Место отчетности</v-list-item-subtitle>
										<v-list-item-title class="black--text wrap-text">{{ user_detailed_item.place }}</v-list-item-title>
									</v-list-item-content>
								</v-list-item>
							
							</v-col>
												
							<v-col
								cols="12"
								md="6"
								v-if="user_detailed_item.comment" class="d-flex align-center my-0 py-0">
								
								<v-list-item>
									<v-list-item-content>
										<v-list-item-subtitle class="indigo--text wrap-text">Комментарий</v-list-item-subtitle>
										<v-list-item-title class="black--text wrap-text">{{ user_detailed_item.comment }}</v-list-item-title>
									</v-list-item-content>
								</v-list-item>			
												
							</v-col>
										
						</v-row>
					
					</div>
					
					<v-row class="d-flex align-center" v-if="premiumstatus && user_selected_item">
										
						<v-col cols="12" class="">
					
							<v-data-table 
								:headers="userheaders"
								:items="userotchetsfilter"
								:search="usersearch"
								sort-by="id"
								class="elevation-1 my-3"
								mobile-breakpoint= "960"
								:loading="user_loading_otchs" 
								data-table-header-mobile="Загрузка данных..."
								loading-text="Загрузка данных..."
								:footer-props="{itemsPerPageText: 'Строк на странице', itemsPerPageAllText: 'Все'}"
								:header-props="{sortByText: 'Сортировка'}"
								v-if="user_selected_item">
								
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
											v-model="usersearch"
											append-icon="mdi-magnify"
											label="Поиск (название, уточнение)"
											single-line
											hide-details
											spellcheck="false">
										</v-text-field>

										<div class="ms-5 me-3">
											<v-switch
												v-model="userinplan"
												hide-details
												inset
												label="В плане отчетности">
											</v-switch>
										</div>
										
										<v-spacer></v-spacer>
						
										<v-btn
											color="indigo"
											dark
											@click="newUserForm"
											class="mb-2">
												Новый отчет
										</v-btn>
															
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

								<template v-slot:item.actions="{ item }">


									<div v-if="item.otchetstartdate === null">
									
										<v-tooltip left max-width="400px">
											
											<template v-slot:activator="{ on, attrs }">
												
												<v-icon
													v-bind="attrs"
													v-on="on"
													class="mr-1"
													color="red">
														mdi-close-thick
												</v-icon>

											</template>
										
											<span>Нет в плане отчетности</span>
											
										</v-tooltip>

										<v-icon
											class="mr-1"
											color="green"
											@click="openOtchDate(item)">
												mdi-plus-box
										</v-icon>
										
									</div>
									
									<div v-if="item.otchetstartdate !== null">

										<v-tooltip left max-width="400px">
											
											<template v-slot:activator="{ on, attrs }">
											
												<v-icon
													v-bind="attrs"
													v-on="on"	
													class="mr-1"
													color="green">
														mdi-check-bold
												</v-icon>

											</template>
										
											<span>В плане отчетности с {{ formatDate(item.otchetstartdate.date) }}</span>
										
										</v-tooltip>

										<v-icon
											class="mr-1"
											color="red"
											@click="deletePlan(item.otchetstartdate.id)">
												mdi-delete-forever
										</v-icon>


									</div>

								</template>	

								<template v-slot:item.statistic="{ item }">

									<v-tooltip left max-width="400px" :disabled="premiumstatus">
										<template v-slot:activator="{ on, attrs }">
																							
											<v-icon
												v-if="item.otchetstartdate !== null"
												v-bind="attrs" 
												v-on="on"
												color="primary"
												class="mr-1"
												@click="openOtchStatData(item)">
													mdi-list-status
											</v-icon>
											

										</template>

										<span>Данные о статистике доступны только для уровня доступа Премиум.</span>

									</v-tooltip>

								</template>

								<template v-slot:item.useractions="{ item }">
									
									<v-icon
										class="mr-1"
										@click="editUserForm(item)">
											mdi-pencil
									</v-icon>

									<v-icon
										class="mr-1"
										@click="deleteUserForm(item)">
											mdi-delete
									</v-icon>

								</template>	
							
							</v-data-table>
					
						</v-col>
					
					</v-row>
					
				</v-tab-item>
			  
			</v-tabs-items>
			
		</v-container>
		
	
		<v-dialog v-model="dialogOtchDate" max-width="500px" scrollable persistent>
			<v-card>
			
				<v-card-title>
					<span class="text-h5">Дата начала сдачи отчета</span>
					<v-spacer></v-spacer>
					<v-btn
						icon
						@click="dialogOtchDate = false">
							<v-icon>mdi-close</v-icon>
					</v-btn>  
				</v-card-title>
				
				<v-card-text class="pb-0">
								  
					<div v-if="errors_otch_date">
						<div v-for="(v, k) in errors_otch_date" :key="k">
							<v-alert type="error" v-for="error in v" :key="error">{{ error }}</v-alert>
						</div>
					</div>
					
					
					<v-date-picker
						v-model="otch_plan.firstdate"
						full-width
						class="my-4"
						no-title
						:first-day-of-week="1"
						locale="ru-ru">
					</v-date-picker>
											
				</v-card-text>
	
				<v-card-actions>
					<v-spacer></v-spacer>
					
						<v-btn color="info" @click="setOtchetFirstDate" :loading="loading_otch_date" class="mb-2">
							Сохранить
						</v-btn>

				</v-card-actions>
			</v-card>
		</v-dialog>
		
		<v-dialog v-model="dialogDeletePlan" max-width="500px" scrollable persistent>
			<v-card>
			
				<v-card-title>
					<span class="text-h5">Удалить из плана отчетности?</span>
					<v-spacer></v-spacer>
					<v-btn
						icon
						@click="dialogDeletePlan = false">
							<v-icon>mdi-close</v-icon>
					</v-btn>  
				</v-card-title>
				
				<v-card-text>
				
					<v-container>
								  
						<div v-if="errors_delplan">
							<div v-for="(v, k) in errors_delplan" :key="k">
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
					
					<v-btn color="info" @click="deletePlanConfirm" :loading="loading_delplan" class="mb-2">
						Удалить
					</v-btn>

				</v-card-actions>
			</v-card>
		</v-dialog>
		
		
		<v-dialog
			v-model="user_dialog_cat"
			scrollable
			max-width="800px"
			persistent>

			<v-card>
				<v-card-title>
					<span class="text-h5">{{ userCategoryTitle }}</span>
					<v-spacer></v-spacer>
					<v-btn
						icon
						@click="user_dialog_cat = false">
						<v-icon>mdi-close</v-icon>
					</v-btn>  
				</v-card-title>
				
				<v-card-text>
					<v-container>
						<div v-if="user_errors_cat">
							<div v-for="(v, k) in user_errors_cat" :key="k">
								<v-alert type="error" v-for="error in v" :key="error">{{ error }}</v-alert>
							</div>
						</div>
						
						<v-row class="my-0 py-0 d-flex flex-column">
		  
							<v-form ref="user_form_cat" v-model="user_valid_cat">
							
								<v-col cols="12" class="pt-0">
						
									<v-text-field
										v-model="user_form_cat.categoryname"
										label="Наименование отчетности"
										v-on:keyup.enter="focusNext($event.target)"
										:rules="userNameRules"
										required
										outline
										autofocus
										type="text"
										spellcheck="false">
									</v-text-field>
								
								</v-col>
								
								<v-col cols="12" class="pt-0">
														
									<v-text-field
										v-model="user_form_cat.goverment"
										label="Государственный орган"
										v-on:keyup.enter="focusNext($event.target)"
										outline
										type="text"
										spellcheck="false">
									</v-text-field>
								
								</v-col>
								
								<v-col cols="12" class="pt-0">
															
									<v-text-field
										v-model="user_form_cat.law"
										label="Нормативный документ"
										v-on:keyup.enter="focusNext($event.target)"
										outline
										type="text"
										spellcheck="false">
									</v-text-field>
								
								</v-col>
								
								<v-col cols="12" class="pt-0">
														
									<v-text-field
										v-model="user_form_cat.place"
										label="Место отчетности"
										v-on:keyup.enter="focusNext($event.target)"
										outline
										type="text"
										spellcheck="false">
									</v-text-field>
								
								</v-col>
								
								<v-col cols="12" class="pt-0">
															
									<v-text-field
										v-model="user_form_cat.comment"
										label="Комментарий"
										@keydown.enter="saveusercategory"
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
			
					<v-btn color="info" @click="saveusercategory" :loading="user_loading_cat" class="mb-2">
						Сохранить
					</v-btn>
				</v-card-actions>
			</v-card>

		</v-dialog>
		
		<v-dialog v-model="dialogUserCategoryDelete" max-width="500px" scrollable persistent>
			<v-card>
			
				<v-card-title>
					<span class="text-h5">Удалить категорию?</span>
					<v-spacer></v-spacer>
					<v-btn
						icon
						@click="dialogUserCategoryDelete = false">
							<v-icon>mdi-close</v-icon>
					</v-btn>  
				</v-card-title>
				
				<v-card-text>
				
					<v-container>
								  
						<div v-if="user_errors_del">
							<div v-for="(v, k) in user_errors_del" :key="k">
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
					
					<v-btn color="info" @click="deleteUserCategoryConfirm" :loading="user_loading_del" class="mb-2">
						Удалить
					</v-btn>

				</v-card-actions>
			</v-card>
		</v-dialog>
		
		
		<v-dialog
			v-model="dialog_user_otch"
			scrollable
			max-width="800px"
			persistent>

			<v-card>

				<v-card-title>
					<span class="text-h5">{{ userFormTitle }}</span>
					<v-spacer></v-spacer>
					<v-btn
						icon
						@click="dialog_user_otch = false">
							<v-icon>mdi-close</v-icon>
					</v-btn>  
				</v-card-title>

				<v-card-text>
					<v-container>
			  
						<div v-if="user_errors_otch">
							<div v-for="(v, k) in user_errors_otch" :key="k">
								<v-alert type="error" v-for="error in v" :key="error">{{ error }}</v-alert>
							</div>
						</div>
						
						
						<v-row class="my-0 py-0 d-flex flex-column">
						
							<v-form ref="user_form_otch" v-model="user_valid_otch">
	
								<v-col cols="12" class="pt-0">	
										
									<v-text-field
										v-model="user_form_otch.otchetname"
										label="Наименование отчета"
										v-on:keyup.enter="focusNext($event.target)"
										:rules="nameUserFormRules"
										required
										outline
										autofocus
										type="text"
										spellcheck="false">
									</v-text-field>

								</v-col>
								
								<v-col cols="12" class="pt-0 pb-0">	
										
									<v-text-field
										v-model="user_form_otch.razdelname"
										label="Уточнение (статья, пункт постановления)"
										v-on:keyup.enter="focusNext($event.target)"
										outline
										type="text"
										spellcheck="false">
									</v-text-field>

								</v-col>
													
								<v-col cols="12" class="pt-4 pb-2" v-if="!user_form_otch.status">	
										
									<v-spacer></v-spacer>

									<v-btn color="info" :disabled="user_form_otch.status" @click="addperiodform" class="px-2 mb-2">
										<v-icon>mdi-plus</v-icon>
										Срок предоставления
									</v-btn>

								</v-col>
								
								<v-col cols="12" class="pt-2 pb-2" v-if="user_form_otch.status">	
										
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
								
								<v-col cols="12" class="pt-2 pb-3" v-if="user_form_otch.status">	
										
									<v-btn small dark color="red" @click="deleteStatistic()" :loading="loading_delete_statistic">
										Удалить статистику
									</v-btn>

								</v-col>
															
								<v-col cols="12" class="py-0">	
										
									<div v-if="userreportdays">
										<v-list class="pa-0">									  
											<v-list-item v-for="(value, index) in userreportdays" :key="index" class="pa-0">
																				
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

												<v-list-item-action v-if="!user_form_otch.status">										
													<v-btn icon>											
														<v-icon @click="removeperiod(index)">
															mdi-delete
														</v-icon>												
													</v-btn>
												</v-list-item-action>
											</v-list-item>
									
										</v-list>
										
										<div v-if="user_form_otch.status" class="pb-2"></div>
										
									</div>
									
								</v-col>
								
								<v-col cols="12" class="pt-0">	
										
									<v-text-field
										v-model="user_form_otch.comment"
										label="Комментарий"
										@keydown.enter="saveuserform"
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
		
					<v-btn color="info" @click="saveuserform" :loading="user_loading_otch" class="mb-2">
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
		
		
		<v-dialog v-model="dialogDeleteUserForm" max-width="500px" scrollable persistent>
			<v-card>
			
				<v-card-title>
					<span class="text-h5">Удалить отчет?</span>
					<v-spacer></v-spacer>
					<v-btn
						icon
						@click="dialogDeleteUserForm = false">
							<v-icon>mdi-close</v-icon>
					</v-btn>  
				</v-card-title>
				
				<v-card-text>
				
					<v-container>
								  
						<div v-if="user_errors_delform">
							<div v-for="(v, k) in user_errors_delform" :key="k">
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
					
					<v-btn color="info" @click="deleteUserFormConfirm" :loading="user_loading_delform" class="mb-2">
						Удалить
					</v-btn>

				</v-card-actions>
			</v-card>
		</v-dialog>


		<v-dialog v-model="dialogOtchStatData" max-width="800px" scrollable persistent>
			<v-card>
			
				<v-card-title>
					<span class="text-h5">Статистика сдачи отчета</span>
					<v-spacer></v-spacer>
					<v-btn
						icon
						@click="dialogOtchStatData = false">
							<v-icon>mdi-close</v-icon>
					</v-btn>  
				</v-card-title>
				
				<v-card-text>

					<v-row class="my-0 py-0">

						<v-col cols="12">
							<v-divider></v-divider>
						</v-col>			
						
						<v-col cols="12" class="fill-height my-0 py-0">
			
							<v-sheet height="64">
								<v-toolbar flat>
									
									<v-spacer></v-spacer>
										
									<v-btn
										fab
										x-small
										outlined
										color="grey darken-2"
										@click="prev"
										class="me-3">
										
										<v-icon small>
											mdi-chevron-left
										</v-icon>
									</v-btn>
						  
									<v-toolbar-title v-if="$refs.calendar">
										{{ $refs.calendar.title }}
									</v-toolbar-title>
								  
								
									<v-btn
										fab
										x-small
										outlined
										color="grey darken-2"
										@click="next"
										class="ms-3">
										<v-icon small>
										  mdi-chevron-right
										</v-icon>
									</v-btn>
							  
									<v-spacer></v-spacer>
							  
								</v-toolbar>
							</v-sheet>

						</v-col>
						
						<v-row class="d-flex flex-column ma-0 pa-0">

							<v-row class="ma-0 pa-0 mb-4">

								<v-col cols="12" class="py-0 py-2 mb-2">

									<v-sheet>

										<div>

										<v-progress-linear
											:style="{visibility: loader ? 'visible' : 'hidden'}"
											indeterminate
											color="primary">
										</v-progress-linear>

										</div>
										
										<v-calendar
											ref="calendar"
											v-model="focus"
											:now="selectedday"
											:value="selectedday"
											color="primary"
											:events="events"
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
														
															<v-chip @click="movetoDay(date)" small color="red white--text font-weight-bold" class="ma-1" v-if="dayeventsno(date) != 0 && getotchetstartdayicon(date) == true">
																{{ dayeventsno(date) }}
															</v-chip>
															
															<v-chip @click="movetoDay(date)" small color="green white--text font-weight-bold" class="ma-1" v-if="dayeventsyes(date) != 0 && getotchetstartdayicon(date) == true">
																{{ dayeventsyes(date) }}
															</v-chip>
															
															<v-chip @click="movetoDay(date)" small color="orange white--text font-weight-bold" class="ma-1" v-if="dayeventsnotnow(date) != 0 && getotchetstartdayicon(date) == true">
																{{ dayeventsnotnow(date) }}
															</v-chip>

															<v-icon
																v-if="getotchetstartdayicon(date) == false"
																@click="movetoDay(date)"
																color="red">
																	mdi-close-thick
															</v-icon>
														
														</div>
														
													</div>
																						
												</template>	
												
										</v-calendar>
									
									</v-sheet>
								</v-col>
									
															
								<v-col cols="12" class="my-0 pt-2">
								
									<div class="d-flex flex-row align-center justify-center">				  
										<v-toolbar-title>							
											{{ convertDate(selectedday) }}
										</v-toolbar-title>
									</div>
							
								</v-col>
								
								<v-col cols="12" class="my-0 py-0 pb-4 d-flex justify-center" v-if="eventsMap(this.selectedday).length == 0">
								
									<div class="d-flex justify-center flex-row align-center text-subtitle-1">				  
										{{ getotchetstartdaytext(this.selectedday) }}  
									</div>

								</v-col>
								
								<v-col cols="12" class="py-0">

								<v-sheet>
				
								<otchetplanfacts								
									:date="selectedday"
									:events="events"
									:premiumstatus="premiumstatus"
									:userid="user.id"/>

								</v-sheet>
								</v-col>

							</v-row>
							
						</v-row>
	
					</v-row>
			
				</v-card-text>

			</v-card>
		</v-dialog>


				
	</v-container>
	
</template>


<script>

	import {DateTime} from "luxon";

	export default {
	
		data: () => ({
		
			user: [],
			tab: null,
			
			items: [],
			selected_item: 0,			
			detailed_item: {},
			loading_select: false,
			
			headers: [			
				{ text: 'Отчет', value: 'otchetname', sortable: true, filterable: true },	
				{ text: 'Уточнение', value: 'razdelname', sortable: false, filterable: true },				
				{ text: 'Срок предоставления', value: 'reportdays', sortable: false, filterable: false },
				{ text: 'Кто предоставляет', value: 'whosend', sortable: false, filterable: true  },
				{ text: 'Бланк отчета', value: 'otchetlink', sortable: false, filterable: false  },
				{ text: 'Комментарий', value: 'соmmenttooltip', sortable: false, filterable: false },				
				{ text: 'В плане отчетности?', value: 'actions', sortable: false, filterable: false },
				{ text: 'Статистика', value: 'statistic', sortable: false, filterable: false },
			],
			
			loading_otchs: false,
			
			search: '',
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
			

			dialogOtchDate: false,
			loading_otch_date: false,
			errors_otch_date: '',


			otch_plan: {},
			
			default_otch_plan: {
				userid: '',
				categorytable: '',
				category: '',
				formid: '',
				firstdate: '',
			},
			
			dialogDeletePlan: false,
			errors_delplan: '',
			loading_delplan: false,				
			plantodelid: 0,	

			useritems: [],
			user_selected_item: 0,			
			user_detailed_item: {},
			user_loading_select: false,
			userCategoryTitle: '',

			user_form_cat: {},
			default_user_form_cat_item: {
				id: '',
				categoryname: '',
				goverment: '',	
				law: '',	
				place: '',
				comment: '',
				organisation: '',
				staff: 0,
			},
			
			user_dialog_cat: false,
			userNameRules: [],
			user_errors_cat: '',
			user_valid_cat: true,
			user_loading_cat: false,
			
			user_errors_del: '',
			dialogUserCategoryDelete: false,
			user_loading_del: false,	

			userheaders: [			
				{ text: 'Отчет', value: 'otchetname', sortable: true, filterable: true },	
				{ text: 'Уточнение', value: 'razdelname', sortable: false, filterable: true },				
				{ text: 'Срок предоставления', value: 'reportdays', sortable: false, filterable: false },
				{ text: 'Комментарий', value: 'соmmenttooltip', sortable: false, filterable: false },
				{ text: 'В плане отчетности?', value: 'actions', sortable: false, filterable: false },
				{ text: 'Статистика', value: 'statistic', sortable: false, filterable: false },
				{ text: 'Действия', value: 'useractions', sortable: false, filterable: false },
			],
			
			user_loading_otchs: false,
			userotchets: [],
			usersearch: '',
			
			dialog_user_otch: false,
			user_errors_otch: '',
			user_loading_otch: false,
			user_valid_otch: true,
			nameUserFormRules: [],
			
			user_form_otch: {},
			
			default_user_form_otch_item: {
				id: '',
				category: '',
				categorytable: '',
				otchetname: '',
				razdelname: '',
				reportdays: [],			
				comment: '',
				organisation: '',
				staff: 0,
				neworedit: 0,
			},	
			
			userreportdays: [],
			userFormTitle: '',
			
			dialog_addperiod: false,

			dialogDeleteUserForm: false,
			user_errors_delform: '',	
			user_loading_delform: false,	
			userformtodelid: 0,
			
			loading_delete_statistic: false,

			dialogOtchStatData: false,
			loader: false,
			selectedday: '',
			events: [],
			focus: '',
			selected_otchet: '',

			inplan: false,

			userinplan: false,

		}),
		
		watch: {
			
			// слушатель изменения переменной
			selected_item(newSelected_item, oldSelected_item) {
				this.detailed_item = Object.assign({}, this.items.find(o => o.id === newSelected_item));				
				this.initializeforms();
			},
			
			user_selected_item(newSelected_item, oldSelected_item) {
				this.user_detailed_item = Object.assign({}, this.useritems.find(o => o.id === newSelected_item));				
				this.initializeuserforms();
			},
			
			dialogOtchDate (val) {
				val || this.closeOtchDate()
			},
			
			dialogDeletePlan (val) {
				val || this.closeDeletePlan()
			},
			
			user_dialog_cat (val) {
				val || this.closeUserCatDialog()
			},
			
			dialogUserCategoryDelete (val) {
				val || this.closeDeleteUserCategory()
			},
			
			'this.user_form_cat.categoryname' (val) {
				this.userNameRules = []
			},
			
			dialog_user_otch (val) {
				val || this.closeUserOtch()
			},
			
			dialogDeleteUserForm (val) {
				val || this.closeDeleteUserForm()
			},
			
			userreportdays (val) {
				this.user_form_otch.reportdays = [];
				this.userreportdays.forEach((item, index) => {
					this.user_form_otch.reportdays.push(item);
				})
				//this.user_form_otch.reportdays = {...this.userreportdays}
			},

			dialogOtchStatData (val) {
				val || this.closeOtchStatData()
			},
		},
		
		created () {
			this.initialize()
		},
		
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

			otchetsfilter () {			
				if (this.inplan) {
					var map = []
					
					this.otchets.forEach((event) => {
						if (event.otchetstartdate) {
							map.push(event);
						}
					})
					return map

				} else {
					return this.otchets;
				}

			},

			userotchetsfilter () {			
				if (this.userinplan) {
					var map = []
					
					this.userotchets.forEach((event) => {
						if (event.otchetstartdate) {
							map.push(event);
						}
					})
					return map

				} else {
					return this.userotchets;
				}

			},

		},
		
		methods: {

			customSearch (value, search, item) {
				if ((item.otchetname != null && item.otchetname.toString().toLowerCase().includes(search.toLowerCase())) || (item.razdelname != null && item.razdelname.toString().toLowerCase().includes(search.toLowerCase())) || (item.whosend != null && JSON.parse(item.whosend).join(", ").toString().toLowerCase().includes(search.toLowerCase()))) {
					return true;
				} else {
					return false;
				}
			},

			getUserData () {
				axios.get('getuser')
				.then((response) => {
					this.user = response.data
				})
				.catch(error => {})
				.finally(() => {}); 				
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
			
			initialize () {	
			
				axios.get('getuser')
				.then((response) => {
					this.user = response.data
					this.setCategoriesList ();
					this.setUserCategoriesList ();
				})
				.catch(error => {})
				.finally(() => {});
								
			},
			
			setCategoriesList () {
				
				this.loading_select = true;
				
				axios.get('standartcategorieslist')
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
				

				axios.get('standartotchetslist', {
					params: {
						category: this.detailed_item.id,
						categorytable: this.detailed_item.table,
						userid: this.user.id,
					}
					})
				.then((response) => {

					this.otchets = response.data;
					
				})
				.catch(error => {})
				.finally(() => {this.loading_otchs = false;}); 
				
			},
			
			
			openOtchDate (item) {	
				this.otch_plan = Object.assign({}, this.default_otch_plan)	
				this.otch_plan.userid = this.user.id;
				this.otch_plan.categorytable = item.categorytable;
				this.otch_plan.category = item.category;
				this.otch_plan.formid = item.id;				
				this.otch_plan.firstdate = DateTime.now().toFormat('yyyy-MM-dd');				
				this.errors_otch_date = '',
				this.dialogOtchDate = true
			},
			
			
			setOtchetFirstDate () {
				
				setTimeout(function () {
					
					if (!this.loading_otch_date){
		
						this.loading_otch_date = true;						
					
						axios.post('settootchetplan', this.otch_plan)
						.then((response) => {
							this.loading_otch_date = false;
							this.errors_otch_date = '';
							this.initializeforms ();
							this.initializeuserforms ();							
							this.closeOtchDate()
						})
						.catch(error => {
							this.loading_otch_date = false;
							if (error.response.data.errors)
							this.errors_otch_date = error.response.data.errors;
						});
												
					}  
				}.bind(this))
		
			},
			
			newUserCategory (item) {
				
				if (this.premiumstatus) {
				
					this.userCategoryTitle = 'Новая категория';
					this.user_dialog_cat = true
					this.user_form_cat = Object.assign({}, this.default_user_form_cat_item)				
					this.user_form_cat.organisation = this.user.id
					this.user_errors_cat = '';  
				
				}
				
			},
			
			changeUserCategory (item) {
				
				if (this.premiumstatus) {
					
					this.userCategoryTitle = 'Измененить категорию';
					this.user_dialog_cat = true
					this.user_form_cat = Object.assign({}, this.default_user_form_cat_item)						
					this.user_errors_cat = '';
					this.user_form_cat = Object.assign({}, this.useritems.find(o => o.id === this.user_selected_item));
				
				}
				
			},
			
			deleteUserCategory (item) {
				
				if (this.premiumstatus) {
				
					this.user_errors_del = '';
					this.dialogUserCategoryDelete = true
				
				}
				
			},
			
			deleteUserCategoryConfirm () {
				
				if (this.premiumstatus) {
					
					setTimeout(function () {
						this.user_loading_del = true;	
						axios.post('deleteusercategory', this.useritems.find(o => o.id === this.user_selected_item))
						.then((response) => {
							this.user_loading_del = false;
							this.user_errors_del = '';
							this.closeDeleteUserCategory();
							this.user_selected_item = 0
							this.setUserCategoriesList ();
						})
						.catch(error => {
							this.user_loading_del = false;
							if (error.response.data.errors)
							this.user_errors_del = error.response.data.errors;
						});					 
					}.bind(this))
				
				}
			},
			
			saveusercategory () {	  
			
				this.userNameRules = [
					value => !!value || 'Поле обязательно для заполнения',
				]	
				
				if (this.premiumstatus) {

					setTimeout(function () {
						if (this.$refs.user_form_cat.validate() == true && !this.user_loading_cat){
							
							this.user_loading_cat = true;						
							axios.post('newusercategory', this.user_form_cat)
							.then((response) => {
								this.user_loading_cat = false;
								this.user_errors_cat = '';
								this.user_selected_item = response.data.newid;
								this.closeUserCatDialog()
								this.setUserCategoriesList();
							})
							.catch(error => {
								this.user_loading_cat = false;
								if (error.response.data.errors)
								this.user_errors_cat = error.response.data.errors;
							});
									
						}  
					}.bind(this))
				
				}

			},
			
			setUserCategoriesList () {
				
				if (this.premiumstatus) {
				
					this.user_loading_select = true;
					
					axios.get('usercategorieslist', {
						params: {
							organisation: this.user.id
						}
						})
					.then((response) => {
												
						this.useritems = response.data;

						if (this.user_selected_item === 0) {
							this.user_selected_item = response.data[0].id;	
						}
											
						if (this.user_selected_item !== 0) {
							this.user_detailed_item = Object.assign({}, this.useritems.find(o => o.id === this.user_selected_item));
							this.user_selected_item = this.user_selected_item;
						}
					})
					.catch(error => {})
					.finally(() => {this.user_loading_select = false;}); 
				
				}
			},
			
			
			initializeuserforms () {

				if (this.premiumstatus) {
				
					this.user_loading_otchs = true;
					

					axios.get('userotchetslist', {
						params: {
							category: this.user_detailed_item.id,
							categorytable: this.user_detailed_item.table,
							userid: this.user.id,
						}
						})
					.then((response) => {
						this.userotchets = response.data;	
					})
					.catch(error => {})
					.finally(() => {this.user_loading_otchs = false;});
				
				}
				
			},
			
			newUserForm () {

				if (this.premiumstatus) {
					
					this.user_form_otch = Object.assign({}, this.default_user_form_otch_item)	
					this.user_form_otch.organisation = JSON.parse(JSON.stringify(this.user.id))				
					this.user_form_otch.category = JSON.parse(JSON.stringify(this.user_detailed_item.id))
					this.user_form_otch.categorytable = JSON.parse(JSON.stringify(this.user_detailed_item.table))
					this.userreportdays = [];
					this.user_form_otch.neworedit = 0;
					this.user_form_otch.staff = 0;
					this.userFormTitle = 'Новый отчет';			
					this.dialog_user_otch = true;
					this.user_errors_otch = '';

				}
				
			},
			
			editUserForm (item) {
				
				if (this.premiumstatus) {
					
					this.userFormTitle = 'Измененить отчет';
					this.dialog_user_otch = true
					this.user_form_otch = Object.assign({}, this.default_user_form_otch_item)	
					this.userreportdays = [];				
					this.user_errors_otch = '';
					this.user_form_otch = Object.assign({}, this.userotchets.find(o => o.id === item.id));
					this.userreportdays = JSON.parse(item.reportdays);
					this.user_form_otch.neworedit = 1;
					this.user_form_otch.staff = 0;

				}
				
			},
			
			addperiodform () {
				this.dialog_addperiod = true
			},
			
			addtoreportdays(value) {
				this.userreportdays.push(value);
			},
						
			removeperiod(index) {
				this.userreportdays.splice(index, 1);
			},

					
			saveuserform () {	  
			
				this.nameUserFormRules = [
					value => !!value || 'Поле обязательно для заполнения',
				]	
				
				if (this.premiumstatus) {
				
					setTimeout(function () {
						
						if (this.$refs.user_form_otch.validate() == true && !this.user_loading_otch){
							
							if (this.user_form_otch.reportdays.length == 0) {
								
								this.user_errors_otch = [{error: 'Не указан срок предоставления отчета'}];
								
							} else {
								
								this.user_loading_otch = true;						
							
								axios.post('newuserotchet', this.user_form_otch)
								.then((response) => {
									this.user_loading_otch = false;
									this.user_errors_otch = '';
									this.initializeuserforms ();							
									this.closeUserOtch()
								})
								.catch(error => {
									this.user_loading_otch = false;
									if (error.response.data.errors)
									this.user_errors_otch = error.response.data.errors;
								});
							
							}
							
						}  
					}.bind(this))
				
				}

			},
			
			
			deleteUserForm(item) {
				this.user_errors_delform = '';
				this.dialogDeleteUserForm = true;
				this.userformtodelid = item.id;
			},
			
			
			deleteUserFormConfirm () {
				
				setTimeout(function () {
					this.user_loading_delform = true;	
					axios.post('deleteuserotchet', this.userotchets.find(o => o.id === this.userformtodelid))
					.then((response) => {
						this.user_loading_delform = false;
						this.user_errors_delform = '';
						this.userformtodelid = 0
						this.closeDeleteUserForm();
						this.initializeuserforms ();
					})
					.catch(error => {
						this.user_loading_delform = false;
						if (error.response.data.errors)
						this.user_errors_delform = error.response.data.errors;
					});					 
				}.bind(this))

			},
			
			deletePlan(itemid) {
				this.errors_delplan = '';
				this.dialogDeletePlan = true;
				this.plantodelid = itemid;
			},
			
			deletePlanConfirm () {
				
				setTimeout(function () {
					this.loading_delplan = true;	
					axios.post('deletetootchetplan', {todelid: this.plantodelid, userid: this.user.id})
					.then((response) => {
							this.loading_delplan = false;
							this.errors_delplan = '';
							this.plantodelid = 0
							this.closeDeletePlan();
							this.initializeforms ();
							this.initializeuserforms ();
						})
						.catch(error => {
							this.loading_delplan = false;
							if (error.response.data.errors)
							this.errors_delplan = error.response.data.errors;
						});					 
					}.bind(this))

			},
			
			closeOtchDate () {				
				this.dialogOtchDate = false
			},
			
			closeDeletePlan () {
				this.dialogDeletePlan = false
			},
			
			closeUserCatDialog () {
				this.user_dialog_cat = false
				this.userNameRules = [];
			},
			
			closeDeleteUserCategory () {
				this.dialogUserCategoryDelete = false
			},
			
			closeUserOtch () {
				this.dialog_user_otch = false
				this.nameUserFormRules = [];
			},
			
			closeDeleteUserForm () {
				this.dialogDeleteUserForm = false
			},
			
			formatDate(date) {
				if (date === null || date === undefined) {
					return DateTime.now().toFormat('dd.MM.yyyy');
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
			
			deleteStatistic () {
				
				setTimeout(function () {
					
					if (!this.loading_delete_statistic){
		
						this.loading_delete_statistic = true;	

						axios.post('deleteotchetstatistic', this.user_form_otch)
						.then((response) => {
							this.loading_delete_statistic = false;
							this.user_form_otch.status = false;
						})
						.catch(error => {
							this.loading_delete_statistic = false;
						});
												
					}  
				}.bind(this))
		
			},

			convertDate(date) {
				
				var monthNames = ["января", "февраля", "марта", "апреля", "мая", "июня",
				  "июля", "августа", "сентября", "октября", "ноября", "декабря"
				];
				
				var curdate = DateTime.fromISO(date);
				
				return curdate.day + ' ' + monthNames[curdate.month-1] + ' ' + curdate.year
				
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

				this.events = [];

				var premium = 0;

				if (this.premiumstatus) {
					premium = 1;
				}
				
				axios.get('getplanfactdates', {
					params: {
						userid: this.user.id,
						premium: premium,
						month: month,
						year: year,
						otchet: this.selected_otchet,
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
				this.events.forEach((event) => {
					if (date == event.start && (!event.status || event.status.status == 0)) {
						count++;
					}
				})
				return count;
			},
						
			dayeventsyes (date) {
				var count = 0;
				this.events.forEach((event) => {
					if (date == event.start && event.status && event.status.status == 1) {
						count++;
					}
				})
				return count;
			},
			
			dayeventsnotnow (date) {
				var count = 0;
				this.events.forEach((event) => {
					if (date == event.start && event.status && event.status.status == 2) {
						count++;
					}
				})
				return count;
			},			
	  
		
			eventsMap (date) {
				var map = []
				this.events.forEach((event) => {
					if (date == event.start) {
						map.push(event);
					}
				})
				return map
			},


			getotchetstartdaytext (date) {

				if (this.selected_otchet.otchetstartdate && (DateTime.fromISO(date) < DateTime.fromISO(this.selected_otchet.otchetstartdate.date))) {
					return 'Дата первого отчета - ' + DateTime.fromISO(this.selected_otchet.otchetstartdate.date).toFormat('dd.MM.yyyy');
				} else {
					return 'В этот день отчет не сдается'
				}
			},


			getotchetstartdayicon (date) {
				if (this.selected_otchet.otchetstartdate && (DateTime.fromISO(date) < DateTime.fromISO(this.selected_otchet.otchetstartdate.date)) &&  DateTime.fromISO(date).month == DateTime.fromISO(this.selectedday).month ) {
					return false
				} else {
					return true
				}
			},
		
			openOtchStatData(otchet) {
				
				if (this.selected_otchet && otchet && ((this.selected_otchet.category == otchet.category && this.selected_otchet.id != otchet.id) | (this.selected_otchet.category != otchet.category))) {

					this.events = [];

					this.loader = true;

					var month = DateTime.now().month;
					var year = DateTime.now().year;

					var premium = 0;

					if (this.premiumstatus) {
						premium = 1;
					}
					
					axios.get('getplanfactdates', {
						params: {
							userid: this.user.id,
							premium: premium,
							month: month,
							year: year,
							otchet: otchet,
						}
						})
					.then((response) => {
						this.events = response.data
					})
					.catch(error => {})
					.finally(() => {this.loader = false;});

				}

				this.selected_otchet = '';
				this.selected_otchet = otchet;				
				this.focus = DateTime.now().toFormat('yyyy-MM-dd');;
				this.focus = '';
				this.selectedday = DateTime.now().toFormat('yyyy-MM-dd');
				this.dialogOtchStatData = true;

			},
			
			closeOtchStatData () {
				this.dialogOtchStatData = false
			},
			
		},
		
	}
		
		
</script>


<style scoped>

	.maincontainer {
		min-width: 480px;
	}

	.v-application ul, .v-application ol {
		padding-left: 0px;
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
