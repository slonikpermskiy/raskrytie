<template>

	<v-container fluid fill-height class="pa-0 ma-0 align-start">

		<v-container fluid class="pa-0">

			<v-data-table 
				:headers="headers"
				:items="desserts"
				:search="search"
				sort-by="id"
				class="elevation-1"
				mobile-breakpoint= "960"
				:loading="loading" 
				loading-text="Загрузка данных..."
				:footer-props="{itemsPerPageText: 'Строк на странице', itemsPerPageAllText: 'Все'}"
				:header-props="{sortByText: 'Сортировка'}">
				
				<template v-slot:item.created_at="{ item }">
					<span>{{ formatDate(item.created_at) }}</span>
				</template>
				
				<template v-slot:item.premium_to_date="{ item }">
					<span>{{ formatDate(item.premium_to_date) }}</span>
				</template>

				<template v-slot:item.getemails="{ item }">
					<span v-if="item.getemails">Да</span>
					<span v-if="!item.getemails">Нет</span>
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
					
						<v-toolbar-title>Пользователи</v-toolbar-title>
						
						<v-divider
							class="mx-4"
							inset
							vertical>
						</v-divider>
				
						<v-text-field
							v-model="search"
							append-icon="mdi-magnify"
							label="Поиск по организации"
							single-line
							hide-details
							spellcheck="false">
						</v-text-field>
						
						<v-spacer></v-spacer>
						
						<v-dialog
							v-model="dialog"
							scrollable
							max-width="600px"
							persistent>

							<v-card>

								<v-card-title>
									<span class="text-h5">Изменить данные</span>
									<v-spacer></v-spacer>
									<v-btn
										icon
										@click="dialog = false">
											<v-icon>mdi-close</v-icon>
									</v-btn>  
								</v-card-title>

								<v-card-text>
									<v-container>
							  
										<div v-if="errors_change">
											<div v-for="(v, k) in errors_change" :key="k">
												<v-alert type="error" v-for="error in v" :key="error">{{ error }}</v-alert>
											</div>
										</div>
							  
										<v-form ref="formchange" v-model="valid_change">
											
											<v-row class="my-0 py-0">
												<v-col
													cols="12"
													class="py-0">
													<v-text-field
														v-model="editedItem.name"
														label="Организация"
														v-on:keyup.enter="focusNext($event.target)"
														:rules="nameRules_change"
														required
														outline
														autofocus
														type="text"
														spellcheck="false">
													</v-text-field>	
												</v-col>
											</v-row>
								  
											<v-row class="my-0 py-0">				  
												<v-col
													cols="12"
													class="py-0">
													<v-text-field
														v-model="editedItem.email"
														label="Email"
														:rules="emailRules_change"
														outline
														required
														type="text"
														spellcheck="false">
													</v-text-field>
												</v-col>
											</v-row>
								  
											<v-row class="my-0 py-0">
												<v-col
													cols="12"
													sm="6"
													md="6"
													class="py-0">
													<v-menu
														v-model="menu"
														:close-on-content-click="false"
														:nudge-right="40"
														transition="scale-transition"
														offset-y
														min-width="auto">        
														<template v-slot:activator="{ on, attrs }">
															<v-text-field
																v-model="computedDateFormatted"
																label="Верификация Email"
																prepend-icon="mdi-calendar"
																readonly
																v-bind="attrs"
																v-on="on"
																outline
																append-icon="mdi-close"
																@click:append="clearVerifiedDate">
															</v-text-field>
														</template>
														<v-date-picker
															v-model="editedItem.email_verified_at"
															no-title
															class="py-4"
															@input="menu = false"
															:first-day-of-week="1"
															locale="ru-ru">
														</v-date-picker>
													</v-menu>
												</v-col>
												
											</v-row>

											<v-row class="my-0 py-0"> 

												<v-col
													cols="12"
													sm="auto"
													md="auto"
													class="py-0">
													<v-switch
														v-model="editedItem.blocked"
														inset
														label="Заблокирован">
													</v-switch>
												</v-col>

											</v-row>									
								  
											<v-row class="my-0 py-0"> 				 
								   
												<v-col
													cols="12"
													sm="6"
													md="6"
													class="py-0">
													<v-menu
														v-model="menu2"
														:close-on-content-click="false"
														:nudge-right="40"
														transition="scale-transition"
														offset-y
														min-width="auto">
														<template v-slot:activator="{ on, attrs }">
															<v-text-field
																v-model="computedDateFormatted2"
																label="Премиум до"
																prepend-icon="mdi-calendar"
																readonly
																v-bind="attrs"
																v-on="on"
																append-icon="mdi-close"
																@click:append="clearPremiumDate">
															</v-text-field>
														</template>
														<v-date-picker
															v-model="editedItem.premium_to_date"
															no-title
															class="py-4"
															@input="menu2 = false"
															:first-day-of-week="1"
															locale="ru-ru">
														</v-date-picker>
													</v-menu>
												</v-col>
											</v-row>

											<v-row class="my-0 py-0"> 

												<v-col
													cols="12"
													sm="auto"
													md="auto"
													class="py-0">
													<v-switch
														v-model="editedItem.getemails"
														inset
														label="Подписка">
													</v-switch>
												</v-col>

											</v-row>	

											
										</v-form>
								
									</v-container>
								</v-card-text>

								<v-card-actions>
									<v-spacer></v-spacer>
						
									<v-btn color="info" @click="save" :loading="loading_change" class="mb-2">
										<v-icon left>person</v-icon>
										Сохранить
									</v-btn>
								</v-card-actions>
							</v-card>

						</v-dialog>
						
						<v-dialog
							v-model="dialog_pass"
							scrollable
							max-width="600px"
							persistent>

							<v-card>

								<v-card-title>
									<span class="text-h5">Изменить пароль</span>
									<v-spacer></v-spacer>
									<v-btn
										icon
										@click="dialog_pass = false">
											<v-icon>mdi-close</v-icon>
									</v-btn>  
								</v-card-title>

								<v-card-text>
									<v-container>
							  
										<div v-if="errors_pass">
											<div v-for="(v, k) in errors_pass" :key="k">
												<v-alert type="error" v-for="error in v" :key="error">{{ error }}</v-alert>
											</div>
										</div>
							  
										<v-form ref="formpass" v-model="valid_pass">
																		
											<v-text-field
												v-on:keyup.enter="focusNext($event.target)"
												outline
												autofocus
												label="Пароль"
												:rules="passwordRules"
												:counter="8"
												required
												type="password"
												spellcheck="false"
												v-model="formpass.password"></v-text-field>
											<v-text-field
												@keydown.enter="newpass"
												outline
												label="Подтверждение пароля"
												:rules="passwordEqualRules"
												:counter="8"
												required
												type="password"
												spellcheck="false"
												v-model="formpass.password_confirmation"></v-text-field>
			
										</v-form>
								
									</v-container>
								</v-card-text>

								<v-card-actions>
									<v-spacer></v-spacer>
						
									<v-btn color="info" @click="newpass" :loading="loading_pass" class="mb-2">
										<v-icon left>vpn_key</v-icon>
										Сохранить
									</v-btn>
								</v-card-actions>
							</v-card>

						</v-dialog>
						
						<v-dialog v-model="dialogDelete" max-width="500px" scrollable persistent>
							<v-card>
							
								<v-card-title>
									<span class="text-h5">Удалить пользователя?</span>
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
										
									</v-container>
								</v-card-text>
					
								<v-card-actions>
									<v-spacer></v-spacer>
									
										<v-btn color="info" @click="deleteItemConfirm" :loading="loading_del" class="mb-2">
											<v-icon left>person</v-icon>
											Удалить
										</v-btn>

								</v-card-actions>
							</v-card>
						</v-dialog>
					</v-toolbar>
				</template>
					
				<template v-slot:item.actions="{ item }">
					
					<v-icon
						small
						class="mr-1"
						@click="editItem(item)">
							mdi-pencil
					</v-icon>
				  
					<v-icon
						small
						class="mr-1"
						@click="changePassword(item)">
							mdi-key
					</v-icon>
				  
					<v-icon
						small
						class="mr-1"
						@click="deleteItem(item)">
							mdi-delete
					</v-icon>
					
				</template>	
			
			</v-data-table>
				
		</v-container>

	</v-container>
	
</template>



<script>

	import {DateTime} from "luxon";

	export default {
		data: () => ({
			menu: false,
			menu2: false,		  
			switch1: '',		  
			errors_change: '',
			errors_pass: '',
			errors_del: '',			
			valid_change: true,
			valid_pass: true,
			loading: false,
			loading_change: false,
			loading_pass: false,
			loading_del: false,			
			nameRules_change: [],
			emailRules_change: [],
			passwordRules: [],
			passwordEqualRules: [],	
			formpass: {
				id: '',
				password: '',
				password_confirmation: '',				
			},
			default_formpass: {
				id: '',
				password: '',
				password_confirmation: '',				
			},			
			search: '',
			myloadingvariable: false,
			dialog: false,
			dialog_pass: false,
			dialogDelete: false,
			headers: [
				{ text: 'ID', align: 'start', sortable: true, value: 'id', filterable: false },
				{ text: 'Организация', value: 'name', sortable: true, filterable: true },
				{ text: 'Email', value: 'email', sortable: false, filterable: false  },
				{ text: 'Создан', value: 'created_at', sortable: false, filterable: false  },
				{ text: 'Премиум до', value: 'premium_to_date', sortable: false, filterable: false  },
				{ text: 'Подписка', value: 'getemails', sortable: false, filterable: false  },
				{ text: 'Действия', value: 'actions', sortable: false, filterable: false },
			], 
			desserts: [],
			//editedIndex: -1,
			editedItem: [],
		}),

		computed: {
			formTitle () {
				return 'Изменить пользователя'
			},
			computedDateFormatted () {
				return this.formatDate(this.editedItem.email_verified_at)
			},
			computedDateFormatted2 () {
				return this.formatDate(this.editedItem.premium_to_date)
			},
		},

		watch: {
			dialog (val) {
				val || this.close()
			},
			dialogDelete (val) {
				val || this.closeDelete()
			},	
			dialog_pass (val) {
				val || this.closepass()
			},			
			'this.editedItem.name' (val) {
				this.nameRules_change = []
			},	
			'this.editedItem.email' (val) {
				this.emailRules_change = []
			},
			'formpass.password' (val) {
				this.passwordRules = []
			},
			'formpass.password_confirmation' (val) {
				this.passwordEqualRules = []
			},
		},

		created () {
			this.initialize()
		},

		methods: {
		
			formatDate(date) {
				if (date === null || date === undefined) {
					return DateTime.now().toFormat('dd.MM.yyyy');
				} else {
					return DateTime.fromISO(date).toFormat('dd.MM.yyyy');
				}
			},

			initialize () {			  
				this.loading = true;
				axios.get('userslist')
					.then((response) => {
					this.desserts = response.data;
					this.loading = false;
				})
				.catch(error => {
				}); 
			},

			editItem (item) {			  
				//this.editedIndex = this.desserts.indexOf(item)
				this.editedItem = Object.assign({}, item)
				
				// Даты
				if (this.editedItem.email_verified_at === null || this.editedItem.email_verified_at === undefined) {
					this.editedItem.email_verified_at = null
				} else {
					this.editedItem.email_verified_at = DateTime.fromISO(this.editedItem.email_verified_at).toFormat('yyyy-MM-dd');

					

				}
				if (this.editedItem.premium_to_date === null || this.editedItem.premium_to_date === undefined) {
					this.editedItem.premium_to_date = null
				} else {
					this.editedItem.premium_to_date = DateTime.fromISO(this.editedItem.premium_to_date).toFormat('yyyy-MM-dd');	
				}
				
				this.errors_change = '',
				this.dialog = true
			},
			
			
			changePassword (item) {			  			
				this.formpass = Object.assign({}, this.default_formpass)
				this.errors_pass = '',
				this.formpass.id = item.id; 	
				this.dialog_pass = true
			},
			
			
			newpass () {	  				
				this.passwordRules = [
					value => !!value || 'Поле обязательно для заполнения',
					value => (value || '').length >= 8 || 'Пароль д.б. не менее 8 символов',
				]
				this.passwordEqualRules = [
					value => !!value || 'Поле обязательно для заполнения',
					value => (value || '').length >= 8 || 'Пароль д.б. не менее 8 символов',
					value => value === this.formpass.password || 'Пароли не совпадают',
				]							
				
				setTimeout(function () {
					if (this.$refs.formpass.validate() == true && !this.loading_pass){
						this.loading_pass = true;	
						
						axios.post('changeuserpassword', this.formpass)
						.then((response) => {
							this.loading_pass = false;
							this.errors_pass = '';							
							
							this.closepass()
						})
						.catch(error => {
							this.loading_pass = false;
							if (error.response.data.errors)
							this.errors_pass = error.response.data.errors;
						});			
					}  
				}.bind(this))
			},
			
			clearPremiumDate() {
				this.editedItem.premium_to_date = null;
			},
			
			clearVerifiedDate() {
				this.editedItem.email_verified_at = null;
			},

			deleteItem (item) {
				//this.editedIndex = this.desserts.indexOf(item)
				this.editedItem = Object.assign({}, item)
				this.dialogDelete = true
			},

			deleteItemConfirm () {
				setTimeout(function () {
					this.loading_del = true;	
					axios.post('deleteuser', this.editedItem)
					.then((response) => {
						this.loading_del = false;
						this.errors_del = '';						
						//this.desserts.splice(this.editedIndex, 1)
						this.initialize ();						
						this.closeDelete();
					})
					.catch(error => {
						this.loading_del = false;
						if (error.response.data.errors)
						this.errors_del = error.response.data.errors;
					});					 
				}.bind(this))
			},

			closeDelete () {
				this.dialogDelete = false
				this.$nextTick(() => {
				  this.editedItem = []
				  //this.editedIndex = -1
				})
			},

			save () {	  
				this.nameRules_change = [
					value => !!value || 'Поле обязательно для заполнения',
				]
				this.emailRules_change = [
					value => !!value || 'Поле обязательно для заполнения',
					value => /.+@.+\..+/.test(value) || 'Некорректный E-mail',
				]		
				
				setTimeout(function () {
					if (this.$refs.formchange.validate() == true && !this.loading_change){
						this.loading_change = true;						
						axios.post('changeuserdata', this.editedItem)
						.then((response) => {
							this.loading_change = false;
							this.errors_change = '';	
							//Object.assign(this.desserts[this.editedIndex], this.editedItem)						
							this.initialize ();
							
							this.close()
						})
						.catch(error => {
							this.loading_change = false;
							if (error.response.data.errors)
							this.errors_change = error.response.data.errors;
						});
								
					}  
				}.bind(this))

			},
		  
			focusNext(elem) {
				const currentIndex = Array.from(elem.form.elements).indexOf(elem);
				elem.form.elements.item(
					currentIndex < elem.form.elements.length - 1 ?
					currentIndex + 1 : 0
				).focus(); 
			},
			
			close () {
				this.dialog = false
				this.$nextTick(() => {
				  //this.editedIndex = -1
				})
				
				this.nameRules_change = [];
				this.emailRules_change = [];
			},
			
			closepass () {
				this.dialog_pass = false
				this.passwordRules = [];
				this.passwordEqualRules = [];	
			},
		},
	}
  
</script>

<style>
	
	.v-dialog__content {
		min-width: 480px;
	}

</style>




