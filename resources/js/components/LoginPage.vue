<template>
	<v-app id="inspire" class="maincontainer">
	
		<v-overlay :value="drawer" z-index="4">
		</v-overlay>
		
		<v-navigation-drawer v-model="drawer" app clipped dark hide-overlay disable-resize-watcher color="menuicons" right width="280" :style="{ top: $vuetify.application.top + 'px', zIndex: 6 }">
			<v-list dense class="my-0 py-0">
				<v-list-item class="mt-4 mb-2" @click="drawer = false, changeroute('#login')">ВХОД</v-list-item>
				<v-list-item class="my-2" link @click="drawer = false, changeroute('#register')">РЕГИСТРАЦИЯ</v-list-item>
			</v-list>
		</v-navigation-drawer>

		<v-app-bar app clipped-right dark height="64" color="menuicons" style="z-index: 100;">
		  		  
		  <a href="/">
		  	<v-img class="mx-2 imghover" src="/img/logo.png" max-height="40" max-width="40" contain href="/"></v-img>
		  </a>
					
			<v-spacer></v-spacer>

				<div class="d-none d-md-block">

				<div class="d-inline mx-5">
					<a :class="{ 'active': tab === 'tab-1' }" class="nav-link text-decoration-none text-uppercase font-weight-bold p-0 p-lg-0 pt-3" @click="changeroute('#login')">Вход</a>
				</div>
				<div class="d-inline mx-5">
					<a :class="{ 'active': tab === 'tab-2' }" class="nav-link text-decoration-none text-uppercase font-weight-bold p-0 p-lg-0 pt-3" @click="changeroute('#register')">Регистрация</a>
				</div>
			
			</div>

			<v-app-bar-nav-icon @click.stop="drawer = !drawer" color="white" class="d-block d-md-none mx-2">
	
			</v-app-bar-nav-icon>
		  		  
		</v-app-bar>
		
		<v-main>		
			<v-container>
				<v-layout wrap class="justify-center">
					<v-flex xs8 sm7 md6 lg5 xl4>
						
						<v-card elevation="4" light flat v-if="this.tab==='tab-1'">
							<v-card-title>
								<v-layout align-center justify-space-between>
									<h3 class="headline">Авторизация</h3>
									<v-icon right>lock</v-icon>
								</v-layout>
							</v-card-title>
							<v-divider></v-divider>
							<v-card-text>
								<div v-if="errors_log">
									<div v-for="(v, k) in errors_log" :key="k">
										<v-alert type="error" v-for="error in v" :key="error">{{ error }}</v-alert>
									</div>
								</div>
								<v-form ref="formlog" v-model="valid_log">
									<v-text-field
										v-on:keyup.enter="focusNext($event.target)"
										outline
										autofocus
										label="Email"
										:rules="emailRules_log"
										required
										type="text"
										spellcheck="false"
										v-model="form_log.email"></v-text-field>
									<v-text-field
										@keydown.enter="login"
										outline
										label="Пароль"
										:rules="passwordRules_log"
										required
										type="password"
										spellcheck="false"
										v-model="form_log.password"></v-text-field>
								</v-form>
							</v-card-text>
							<v-divider></v-divider>
							<v-card-actions :class="{ 'pa-3': $vuetify.breakpoint.smAndUp }">
								<v-btn color="info" text @click="changeroute('#forgot')">							
									Забыли пароль?
								</v-btn>
								<v-spacer></v-spacer>
								<v-btn color="info" :large="$vuetify.breakpoint.smAndUp" @click="login" :loading="loading_log">
									<v-icon left>lock</v-icon>
									Вход
								</v-btn>
							</v-card-actions>
						</v-card>
						
						<v-card elevation="4" light flat v-if="this.tab==='tab-2'">
							<v-card-title>
								<v-layout align-center justify-space-between>
									<h3 class="headline">Регистрация</h3>
									<v-icon right>person_add</v-icon>
								</v-layout>
							</v-card-title>
							<v-divider></v-divider>
							<v-card-text>
								<div v-if="errors_reg">
									<div v-for="(v, k) in errors_reg" :key="k">
										<v-alert type="error" v-for="error in v" :key="error">{{ error }}</v-alert>
									</div>
								</div>
								<v-form ref="formreg" v-model="valid_reg">
									<v-text-field
										v-on:keyup.enter="focusNext($event.target)"
										outline
										autofocus
										label="Организация"
										:rules="nameRules_reg"
										required
										type="text"
										spellcheck="false"
										v-model="form_reg.name"></v-text-field>
									<v-text-field
										v-on:keyup.enter="focusNext($event.target)"
										outline
										label="Email"
										:rules="emailRules_reg"
										required
										type="text"
										spellcheck="false"
										v-model="form_reg.email"></v-text-field>
									<v-text-field
										v-on:keyup.enter="focusNext($event.target)"
										outline
										label="Пароль"
										:rules="passwordRules_reg"
										:counter="8"
										required
										type="password"
										spellcheck="false"
										v-model="form_reg.password"></v-text-field>
									<v-text-field
										@keydown.enter="register"
										outline
										label="Подтверждение пароля"
										:rules="passwordEqualRules_reg"
										:counter="8"
										required
										type="password"
										spellcheck="false"
										v-model="form_reg.password_confirmation"></v-text-field>
								</v-form>
							</v-card-text>
							<v-divider></v-divider>
							<v-card-actions :class="{ 'pa-3': $vuetify.breakpoint.smAndUp }">
								<v-spacer></v-spacer>
								<v-btn color="info" :large="$vuetify.breakpoint.smAndUp" @click="register" :loading="loading_reg">
									<v-icon left>person_add</v-icon>
									Регистрация
								</v-btn>
							</v-card-actions>											
						</v-card> 		  
			  
						<v-card elevation="4" light flat v-if="this.tab==='tab-3'">			
							<v-card-title>
								<v-layout align-center justify-space-between>
									<h3 class="headline">Сброс пароля</h3>
									<v-icon right>email</v-icon>
								</v-layout>
							</v-card-title>
							<v-divider></v-divider>				
								<v-card-text>
									<div v-if="errors_fog">
										<div v-for="(v, k) in errors_fog" :key="k">
											<v-alert type="error" v-for="error in v" :key="error">{{ error }}</v-alert>
										</div>
									</div>
									<div v-if="response">
										<v-alert type="info">{{ response }}</v-alert>
									</div>

									<v-form ref="formfog" v-model="valid_fog" v-on:submit.prevent="sendlink">
										<v-text-field
											outline
											autofocus
											label="Email"
											:rules="emailRules_fog"
											required
											type="text"
											spellcheck="false"
											v-model="form_fog.email"></v-text-field>
									</v-form>
								</v-card-text>
								<v-divider></v-divider>
								<v-card-actions :class="{ 'pa-3': $vuetify.breakpoint.smAndUp }">
									<v-spacer></v-spacer>
									<v-btn color="info" :large="$vuetify.breakpoint.smAndUp" @click="sendlink" :loading="loading_fog">
										<v-icon left>email</v-icon>
										Отправить
									</v-btn>
								</v-card-actions>
							</v-card>
			
							<v-card elevation="4" light flat v-if="this.tab==='tab-4'">			
								<v-card-title>
									<v-layout align-center justify-space-between>
										<h3 class="headline">Восстановление пароля</h3>
										<v-icon right>vpn_key</v-icon>
									</v-layout>
								</v-card-title>
								<v-divider></v-divider>
								<v-card-text>
									<div v-if="errors_res">
										<div v-for="(v, k) in errors_res" :key="k">
											<v-alert type="error" v-for="error in v" :key="error">{{ error }}</v-alert>
										</div>
									</div>
									<div v-if="response_res">
										<v-alert type="info">{{ response }}</v-alert>
									</div>
									<v-form ref="formres" v-model="valid_res">
										<v-text-field
											outline
											label="Email"
											:rules="emailRules_res"
											required
											readonly
											type="text"
											spellcheck="false"
											v-model="form_res.email"></v-text-field>										
										<v-text-field
											v-on:keyup.enter="focusNext($event.target)"
											outline
											label="Пароль"
											:rules="passwordRules_res"
											:counter="8"
											autofocus
											required
											type="password"
											spellcheck="false"
											v-model="form_res.password"></v-text-field>
										<v-text-field
											@keydown.enter="newpass"
											outline
											label="Подтверждение пароля"
											:rules="passwordEqualRules_res"
											:counter="8"
											required
											type="password"
											spellcheck="false"
											v-model="form_res.password_confirmation"></v-text-field>	
									</v-form>
								</v-card-text>
								<v-divider></v-divider>
								<v-card-actions :class="{ 'pa-3': $vuetify.breakpoint.smAndUp }">
									<v-spacer></v-spacer>
									<v-btn color="info" :large="$vuetify.breakpoint.smAndUp" @click="newpass" :loading="loading_res">
										<v-icon left>vpn_key</v-icon>
										Сохранить
									</v-btn>
								</v-card-actions>
							</v-card>
			
					</v-flex>
				</v-layout>
			</v-container>	
		</v-main>
	</v-app>
</template>
	
	


<script>
	
	export default {
		data: () => ({
		
			emailRules_log: [],
			passwordRules_log: [],
			
			nameRules_reg: [],
			emailRules_reg: [],
			passwordRules_reg: [],
			passwordEqualRules_reg: [],
			
			emailRules_fog: [],
			
			emailRules_res: [],
			passwordRules_res: [],
			passwordEqualRules_res: [],
		
			valid_log: true,
			valid_reg: true,
			valid_fog: true,
			valid_res: true,
			
			loading_log: false,
			loading_reg: false,	
			loading_fog: false,
			loading_res: false,
			
			tab: null,
			
			drawer: false,
			pagepath: window.location.pathname,
						
			errors_log: '',
			errors_reg: '',
			errors_fog: '',
			errors_res: '',
			
			response: '',
			response_res: '',
			
			form_log: {
				email: '',
				password: ''
			},
			form_reg: {
				name: '',
				email: '',
				password: '',
				password_confirmation: '',				
			},
			form_fog: {
				email: ''	
			},
			form_res: {
				email: '',
				token: '',
				password: '',
				password_confirmation: '',
			},
		}),
		props: ['token', 'useremail'],
		
		created() {
			this.form_res.email = this.useremail;
			this.form_res.token = this.token;
		},
		methods: {
			login () {		
				this.emailRules_log = [
					value => !!value || 'Поле обязательно для заполнения',
					value => /.+@.+\..+/.test(value) || 'Некорректный E-mail',
				]  
				this.passwordRules_log = [
					value => !!value || 'Поле обязательно для заполнения',
				]
				
				setTimeout(function () {
					if (this.$refs.formlog.validate() == true && !this.loading_log){
						this.loading_log = true;
						axios.post('login', this.form_log)
						.then((response) => {
							this.loading_log = false;
							this.errors_log = '';
							this.$refs.formlog.reset();
							window.location.replace('/lk');
						})
						.catch(error => {
							this.loading_log = false;
							this.errors_log = error.response.data.errors;							
						});
					} 
				}.bind(this))	
			},
			register () {			
				this.nameRules_reg = [
					value => !!value || 'Поле обязательно для заполнения',
				]
				this.emailRules_reg = [
					value => !!value || 'Поле обязательно для заполнения',
					value => /.+@.+\..+/.test(value) || 'Некорректный E-mail',
				]  
				this.passwordRules_reg = [
					value => !!value || 'Поле обязательно для заполнения',
					value => (value || '').length >= 8 || 'Пароль д.б. не менее 8 символов',
				]
				this.passwordEqualRules_reg = [
					value => !!value || 'Поле обязательно для заполнения',
					value => (value || '').length >= 8 || 'Пароль д.б. не менее 8 символов',
					value => value === this.form_reg.password || 'Пароли не совпадают',
				]							
				setTimeout(function () {
					if (this.$refs.formreg.validate() == true && !this.loading_reg){
						this.loading_reg = true;
						axios.post('register', this.form_reg)
						.then((response) => {
							this.loading_reg = false;
							this.errors_reg = '';
							this.$refs.formreg.reset();
							window.location.replace('/lk');
						})
						.catch(error => {
							this.loading_reg = false;
							this.errors_reg = error.response.data.errors;
							console.log(error);
						});
					}  
				}.bind(this))	
			},
			sendlink () {
				this.emailRules_fog = [
					value => !!value || 'Поле обязательно для заполнения',
					value => /.+@.+\..+/.test(value) || 'Некорректный E-mail',
				]  
				setTimeout(function () {
					if (this.$refs.formfog.validate() == true && !this.loading_fog){
						this.loading_fog = true;
						axios.post('password/email', this.form_fog)
						.then((response) => {
							this.loading_fog = false;
							this.errors_fog = '';
							this.response = '';
							this.$refs.formfog.reset();
							this.response = response.data.message;
						})
						.catch(error => {
							this.loading_fog = false;
							this.errors_fog = error.response.data.errors;
						});
					} 
				}.bind(this))
			},
			newpass () {
			
				this.emailRules_res = [
					value => !!value || 'Поле обязательно для заполнения',
					value => /.+@.+\..+/.test(value) || 'Некорректный E-mail',
				]  
				this.passwordRules_res = [
					value => !!value || 'Поле обязательно для заполнения',
					value => (value || '').length >= 8 || 'Пароль д.б. не менее 8 символов',
				]
				this.passwordEqualRules_res = [
					value => !!value || 'Поле обязательно для заполнения',
					value => (value || '').length >= 8 || 'Пароль д.б. не менее 8 символов',
					value => value === this.form_res.password || 'Пароли не совпадают',
				]							
				setTimeout(function () {
					if (this.$refs.formres.validate() == true && !this.loading_res){
						this.loading_res = true;
						axios.post('password/reset', this.form_res)
						.then((response) => {
							this.loading_res = false;
							this.errors_res = '';
							this.response_res = '';
							this.$refs.formres.reset();
							window.location.replace('/lk');
						})
						.catch(error => {
							this.loading_res = false;
							this.errors_res = error.response.data.errors;
						});
					}  
				}.bind(this))
			},
			changeroute (route) {
			
				window.history.pushState(null, null, window.location.pathname + route);
							
				window.location.href = route;
			
			},
			redirect(link) {
				window.location.href = link;
			},
			focusNext(elem) {
				const currentIndex = Array.from(elem.form.elements).indexOf(elem);
				elem.form.elements.item(
					currentIndex < elem.form.elements.length - 1 ?
					currentIndex + 1 : 0
				).focus(); 
			},
			onResize () {
				if (window.innerWidth > 959) {
				this.drawer = false
				}
			},
		},
		mounted () {
			this.onResize()
			window.addEventListener('resize', this.onResize, { passive: true });
			
			if (window.location.hash === '') {
				window.location.href = '#login';			
			}
			
			if (window.location.hash === '#login') {
				this.tab = 'tab-1';
			} else if (window.location.hash === '#register') {
				this.tab = 'tab-2';
			} else if (window.location.hash === '#forgot') {
				this.tab = 'tab-3';
			} else if (window.location.hash === '#reset') {
				this.tab = 'tab-4';
			}
			
			console.log(window.location.hash);

		},
		beforeDestroy () {
			if (typeof window === 'undefined') return
			window.removeEventListener('resize', this.onResize, { passive: true });
		},
		watch:{
			$route (to, from){			
				if (to.hash == '#login') {
					this.tab = 'tab-1';
				} else if (to.hash == '#register') {
					this.tab = 'tab-2';
				} else if (to.hash == '#forgot') {
					this.tab = 'tab-3';
				} else if (to.hash == '#reset') {
					this.tab = 'tab-4';
				}
			},
			
			'form_log.email' (val) {
				this.emailRules_log = []
			},
			'form_log.password' (val) {
				this.passwordRules_log = []
			},
			'form_reg.name' (val) {
				this.nameRules_reg = []
			},
			'form_reg.email' (val) {
				this.emailRules_reg = []
			},
			'form_reg.password' (val) {
				this.passwordRules_reg = []
			},
			'form_reg.password_confirmation' (val) {
				this.passwordEqualRules_reg = []
			},
			'form_fog.email' (val) {
				this.emailRules_fog = []
			},
			'form_res.email' (val) {
				this.emailRules_res = []
			},
			'form_res.password' (val) {
				this.passwordRules_res = []
			},
			'form_res.password_confirmation' (val) {
				this.passwordEqualRules_res = []
			},
		},
		
		
	}
	
</script>

<style scoped>

	a.nav-link:hover {
		color: #1abc9c;
	}
	a.nav-link {
		color: #fff;
	}	
	a.nav-link.active {
		color: #1abc9c;
	}			
	.maincontainer {
		min-width: 480px;
	}	
	.imghover:hover {
		cursor: pointer;
	}

</style>