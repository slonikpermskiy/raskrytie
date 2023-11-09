<template>
	<v-app id="inspire" class="maincontainer">
	
		<v-app-bar app clipped-right dark height="64" color="menuicons" style="z-index: 100;">
		  		  
		    <a href="/">
				<v-img class="mx-2 imghover" src="/img/logo.png" max-height="40" max-width="40" contain href="/"></v-img>
			</a>
					
			<v-toolbar-title class="mx-2">Панель администратора</v-toolbar-title>
		  		  
		</v-app-bar>
		
		<v-main>		
			<v-container>
				<v-layout wrap class="justify-center">
					<v-flex xs9 sm7 md6 lg5>
						
						<v-card elevation="4" light flat>
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
										label="Логин"
										:rules="loginRules_log"
										required
										type="text"
										spellcheck="false"
										v-model="form_log.login"></v-text-field>
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
								<v-spacer></v-spacer>
								<v-btn color="info" :large="$vuetify.breakpoint.smAndUp" @click="login" :loading="loading_log">
									<v-icon left>lock</v-icon>
									Вход
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
		
			loginRules_log: [],
			passwordRules_log: [],
		
			valid_log: true,
			
			loading_log: false,

			pagepath: window.location.pathname,
						
			errors_log: '',
			
			response: '',
			response_res: '',
			
			form_log: {
				login: '',
				password: ''
			},
		}),
		
		props: ['token'],
		
		methods: {
			login () {		
				this.loginRules_log = [
					value => !!value || 'Поле обязательно для заполнения',
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
							window.location.replace('/adminaccesspanel');
						})
						.catch(error => {	
							this.loading_log = false;
							this.errors_log = error.response.data.errors;
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
			onResize () {
				if (window.innerWidth > 959) {
				this.drawer = false
				}
			},
		},
		
		mounted () {

		},

		watch:{
			'form_log.login' (val) {
				this.loginRules_log = []
			},
			'form_log.password' (val) {
				this.passwordRules_log = []
			},
		},
		
		
	}
	
</script>

<style scoped>
		
	.maincontainer {
		min-width: 480px;
	}	
	.imghover:hover {
		cursor: pointer;
	}

</style>