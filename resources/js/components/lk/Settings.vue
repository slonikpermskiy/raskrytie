<template>
	
	<v-container fluid fill-height class="maincontainer elevation-1 pa-1 ma-0 align-start">
		
		<v-container fluid class="pa-3" v-if="user.id">
			
			<v-row class="my-0 py-0">

				<v-col
					cols="12">
					
					
					<div class="d-flex align-center my-0 py-0">
					
				
						<div class="font-weight-bold text-h6 text-uppercase">Регистрационные данные</div>
					
						
						<v-spacer></v-spacer>

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
								<v-list-item @click="changeUser">
									<v-list-item-title>Изменить данные</v-list-item-title>
								</v-list-item>
								<v-list-item @click="changePassword">
									<v-list-item-title>Изменить пароль</v-list-item-title>
								</v-list-item>
							</v-list>
						</v-menu>

					</div>						

				
				</v-col>
				
			
				<v-col
					cols="12"
					md="6"
					class="d-flex align-center my-0 py-0">
								
					<v-list-item>
						<v-list-item-content>
							<v-list-item-subtitle class="indigo--text wrap-text">Наименование организации</v-list-item-subtitle>
							<v-list-item-title class="black--text wrap-text">{{ user.name }}</v-list-item-title>
						</v-list-item-content>
					</v-list-item>
					
				</v-col>					
				
				<v-col
					cols="12"
					md="6"
					class="d-flex align-center my-0 py-0">
			
					<v-list-item>
						<v-list-item-content>
							<v-list-item-subtitle class="indigo--text wrap-text">Email</v-list-item-subtitle>
							<v-list-item-title class="black--text wrap-text">{{ user.email }}</v-list-item-title>
						</v-list-item-content>
					</v-list-item>
				
				</v-col>
									
				<v-col
					cols="12"
					md="6"
					class="d-flex align-center my-0 py-0">
							
					<v-list-item>
						<v-list-item-content>
							<v-list-item-subtitle class="indigo--text wrap-text">Уровень доступа</v-list-item-subtitle>								
							<v-list-item-title class="black--text wrap-text" v-if="premiumstatus">Премиум до {{ formatDate(user.premium_to_date) }} </v-list-item-title>
							<v-list-item-title class="black--text wrap-text" v-if="!premiumstatus">Стандарт</v-list-item-title>
						</v-list-item-content>
					</v-list-item>
				
				</v-col>
				
				<v-col
					cols="12"
					md="6"
					class="d-flex align-center my-2 py-2">
							
					<v-list-item>
						<v-list-item-content>
							<v-list-item-subtitle class="indigo--text wrap-text">Получение рассылок</v-list-item-subtitle>	
							<v-list-item-title class="black--text wrap-text" v-if="user.getemails">Да</v-list-item-title>
							<v-list-item-title class="black--text wrap-text" v-if="!user.getemails">Нет</v-list-item-title>
						</v-list-item-content>
					</v-list-item>
				
				</v-col>
							
			</v-row>
						
			
			<div class="p-0 m-0 mt-3">
	
				<p class="font-weight-bold text-h6 text-uppercase">Уровень доступа - Премиум</p>
				
				
				<v-row no-gutters>
				
					<v-col cols="12" class="">
						
						<div class="d-flex my-2">
							<div class="align-self-center me-3">						
								<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
							</div>
							<div class="align-self-center">
								<p class="text-start fs-5">Возможность создавать свои собственные категории и отчеты.</p>
							</div>
						</div>
						
						<div class="d-flex my-2">
							<div class="align-self-center me-3">						
								<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
							</div>
							<div class="align-self-center">
								<p class="text-start fs-5">Возможность менять статус сдачи отчетов.</p>
							</div>
						</div>
						
						<div class="d-flex my-2">
							<div class="align-self-center me-3">						
								<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
							</div>
							<div class="align-self-center">
								<p class="text-start fs-5">Бесплатные консультации и техническая поддержка.</p>
							</div>
						</div>

					</v-col>
					
				</v-row>
				
				
				<v-row no-gutters v-if="firsttimepremium">
										
					<v-col cols="12" class="my-0 py-0 mt-1 mb-9">
					
						<v-btn
							:loading="loadingpremium"
							color="success"
							@click="getPremium">
							
							<v-icon left dark>
								mdi-crown
							</v-icon>
								Получить Премиум доступ бесплатно на 3 месяца
						</v-btn>
					
					</v-col>
						
				</v-row>

				<v-row no-gutters>

					<v-col cols="12" sm="12" md="6" lg="4" xl="4" class="mb-4">

						<v-select
							:items="perioditems"
							hide-details
							no-data-text="Нет данных"
							placeholder="Выберите значение"
							item-value="id"
							item-text="period"										
							solo
							v-model="selected_period"
							class="d-flex align-center">
						</v-select>

					</v-col>

					<v-col cols="12" class="mb-4">

						<div class="word-break py-0 font-weight-black text-h5">{{ periodprice.find(o => o.id === selected_period).price }} руб.</div>
										
					</v-col>

					<v-col cols="12" class="mb-4">						

						<v-btn
							color="primary"
							@click="buypremiumdialog(selected_period, periodprice.find(o => o.id === selected_period).price)">
								Оплатить
						</v-btn>
									
					</v-col>

				</v-row>

			</div>

		</v-container>
		
		
		
		<v-dialog
			v-model="userdatadialog"
			scrollable
			max-width="600px"
			persistent>

			<v-card>

				<v-card-title>
					<span class="text-h5">Изменить данные</span>
					<v-spacer></v-spacer>
					<v-btn
						icon
						@click="userdatadialog = false">
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
										v-model="edituser.name"
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
										@keydown.enter="savechanges"
										v-model="edituser.email"
										label="Email"
										:rules="emailRules_change"
										outline
										required
										type="text"
										spellcheck="false">
									</v-text-field>
								</v-col>
							</v-row>
				  

							<v-row class="my-0 py-0" v-if="premiumstatus"> 

								<v-col
									cols="12"
									sm="auto"
									md="auto"
									class="py-0">
									<v-switch
										v-model="edituser.getemails"
										inset
										color
										label="Получение рассылок"
										class="my-0 py-0"
										hide-details>
										
										<template v-slot:label>
													
											<v-list-item>
												<v-list-item-content>
													<v-list-item-title class="black--text wrap-text">Получение рассылок</v-list-item-title>	
												</v-list-item-content>
											</v-list-item>

										</template>	

									</v-switch>
								</v-col>

							</v-row>									
				  
			
						</v-form>
				
					</v-container>
				</v-card-text>

				<v-card-actions>
					<v-spacer></v-spacer>
		
					<v-btn color="info" @click="savechanges" :loading="loading_change" class="mb-2">
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
								label="Действующий пароль"
								:rules="oldpasswordRules"
								required
								type="password"
								spellcheck="false"
								v-model="formpass.oldpassword"></v-text-field>
							<v-text-field
								v-on:keyup.enter="focusNext($event.target)"
								outline
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
		
		<v-dialog v-model="dialogSendBill" max-width="600px" scrollable persistent>
			<v-card>
			
				<v-card-title>
					<span class="text-h5">Оплата доступа</span>
					<v-spacer></v-spacer>
					<v-btn
						icon
						@click="dialogSendBill = false">
							<v-icon>mdi-close</v-icon>
					</v-btn>  
				</v-card-title>
				
				<v-card-text>
					<v-container>
			  
						<div v-if="errors_sendbill">
							<div v-for="(v, k) in errors_sendbill" :key="k">
								<v-alert type="error" v-for="error in v" :key="error">{{ error }}</v-alert>
							</div>
						</div>
						<div class="black--text text-body-1 wrap-text">
							Отправить инструкцию по оплате на электронную почту?
						</div>
						<div class="black--text text-body-1 wrap-text">
							Срок использования - {{ sendbill_time }} <span v-if="sendbill_time === 1">месяц</span><span v-if="sendbill_time === 3">месяца</span><span v-if="sendbill_time === 6 | sendbill_time === 12">месяцев</span>.
						</div>
						<div class="black--text text-body-1 wrap-text">
							Сумма к оплате - {{ sendbill_summ }} рублей.
						</div>
						
					</v-container>
				</v-card-text>
	
				<v-card-actions>
					<v-spacer></v-spacer>
					
						<v-btn color="info" @click="buypremium" :loading="loading_sendbill" class="mb-2">
							<v-icon left>email</v-icon>
							Отправить
						</v-btn>

				</v-card-actions>
			</v-card>
		</v-dialog>
						
						

	</v-container>
	
</template>



<script>

	// Отправка рассылок
	// https://laravel.su/docs/8.x/scheduling
	// https://laravel.su/docs/8.x/notifications
	// https://timeweb.com/ru/docs/virtualnyj-hosting/planirovshchik-zadanij-cron/

	import {DateTime} from "luxon";

    export default {
	
		data: () => ({
			loadingpremium: false,
			userdatadialog: false,
			errors_change: '',
			valid_change: true,
			nameRules_change: [],
			emailRules_change: [],
			user: [],
			edituser: [],
			loading_change: false,
			dialog_pass: false,
			errors_pass: '',
			valid_pass: true,
			loading_pass: false,
			oldpasswordRules: [],
			passwordRules: [],
			passwordEqualRules: [],	
			formpass: {
				id: '',
				oldpassword: '',
				password: '',
				password_confirmation: '',				
			},
			default_formpass: {
				id: '',
				oldpassword: '',
				password: '',
				password_confirmation: '',				
			},
			dialogSendBill: false,
			errors_sendbill: '',
			loading_sendbill: false,
			sendbill_time: '',
			sendbill_summ: '',
			perioditems: [
				{ id: 1, period: '1 месяц' },
				{ id: 3, period: '3 месяца' },
				{ id: 6, period: '6 месяцев' },
				{ id: 12, period: '12 месяцев' },
			],
			periodprice: [
				{ id: 1, price: '500' },
				{ id: 3, price: '1400' },
				{ id: 6, price: '2600' },
				{ id: 12, price: '5000' },
			],
			selected_period: 1,
		}),
		
		created () {
			this.initialize()
		},
		
		watch: {
			userdatadialog (val) {
				val || this.close()
			},	
			dialog_pass (val) {
				val || this.closepass()
			},	
			dialogSendBill (val) {
				val || this.closeSendBill()
			},
			'this.user.name' (val) {
				this.nameRules_change = []
			},
			'this.user.email' (val) {
				this.emailRules_change = []
			},	
			'formpass.oldpassword' (val) {
				this.oldpasswordRules = []
			},
			'formpass.password' (val) {
				this.passwordRules = []
			},
			'formpass.password_confirmation' (val) {
				this.passwordEqualRules = []
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
			
		},
		
		methods: {
			
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
				})
				.catch(error => {})
				.finally(() => {/*this.loading_otchs = false;*/}); 
				
			},
			
			changeUser () {
				this.edituser = Object.assign({}, this.user)
				this.errors_change = '',
				this.userdatadialog = true
			},

			savechanges () {	  
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
						axios.post('changeuserdata', this.edituser)
						.then((response) => {
							
							if (response.data.reload == 1) {
							
								axios.post('/email/verification-notification')
								.then((response) => {
								
								})
								.catch(error => {})
								.finally(() => {
									
									this.loading_change = false;
									this.errors_change = '';	
									this.close();
									
									window.location.replace('/lk');
									
								}); 
							
							} else  {

								this.loading_change = false;
								this.errors_change = '';	
								this.close();
								
								this.getUserData ();
								this.getUserSideBar ();
								//this.$parent.$parent.$parent.getUser ();
								
							}
							
						})
						.catch(error => {
							this.loading_change = false;
							if (error.response.data.errors)
							this.errors_change = error.response.data.errors;
						});
								
					}  
				}.bind(this))

			},
			
			changePassword (item) {			  			
				this.formpass = Object.assign({}, this.default_formpass)
				this.errors_pass = '',
				this.formpass.id = this.user.id; 	
				this.dialog_pass = true
			},
				
			newpass () {	  				
				this.oldpasswordRules = [
					value => !!value || 'Поле обязательно для заполнения',
				]
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
							
							this.closepass();
							
							this.logout();
						})
						.catch(error => {
							this.loading_pass = false;
							if (error.response.data.errors)
							this.errors_pass = error.response.data.errors;
						});			
					}  
				}.bind(this))
			},
			
			logout() {
				axios.post('/logout')
				.then((response) => {
					window.location.replace('/lk');
				})
				.catch(error => {
				});
			},
			
			close () {
				this.userdatadialog = false
				this.nameRules_change = [];
				this.emailRules_change = [];
				this.edituser = [];
			},
			
			closepass () {
				this.dialog_pass = false
				this.oldpasswordRules = [];
				this.passwordRules = [];
				this.passwordEqualRules = [];
			},
			
			closeSendBill () {
				this.dialogSendBill = false
			},
			
			getPremium() {
				
				if (this.firsttimepremium) {

					setTimeout(function () {
						this.loadingpremium = true;	
						axios.post('getfreepremium', {userid: this.user.id})
						.then((response) => {
							this.loadingpremium = false;
							this.getUserData ();
							this.getUserSideBar ();					
						})
						.catch(error => {
							this.loadingpremium = false;
						});					 
					}.bind(this))
				
				}
				
			},
			
			buypremiumdialog (time, summ) {
				this.errors_sendbill = '';
				this.sendbill_time = time;
				this.sendbill_summ = summ;
				this.dialogSendBill = true;
			},
			
			buypremium() {
				this.loading_sendbill = true;
				axios.post('sendbill', {
						sendbill_time: this.sendbill_time,
						sendbill_summ: this.sendbill_summ
					})
				.then((response) => {
					this.errors_sendbill = '';
					this.loading_sendbill = false;
					this.dialogSendBill = false;				
				})
				.catch(error => {
					this.loading_sendbill = false;
					this.errors_sendbill = error.response.data.errors;
				})
				.finally(() => {});				
			},
			
			focusNext(elem) {
				const currentIndex = Array.from(elem.form.elements).indexOf(elem);
				elem.form.elements.item(
					currentIndex < elem.form.elements.length - 1 ?
					currentIndex + 1 : 0
				).focus(); 
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

</style>
