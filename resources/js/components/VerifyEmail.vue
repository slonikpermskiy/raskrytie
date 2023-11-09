<template>
	<v-app id="inspire" class="maincontainer">
		<v-app-bar app clipped-right dark height="64" color="menuicons" style="z-index: 100;">
			<a href="/">
				<v-img class="mx-2 imghover" src="/img/logo.png" max-height="40" max-width="40" contain href="/"></v-img>
			</a>
			<v-spacer></v-spacer>
			
			<v-btn icon color="white" @click.native="logout" class="mx-1">
				<v-icon light>mdi-logout</v-icon>
			</v-btn>
			
		</v-app-bar>
		
		<v-main>
			<v-container>
				<v-layout wrap class="justify-center">
					<v-flex xs9 sm7 md6 lg5>
						<v-card elevation="4" light tag="section">
							<v-card-title>
								<v-layout align-center justify-space-between>
									<h3 class="headline">Подтверждение Email</h3>
									<v-icon right>lock</v-icon>
								</v-layout>
							</v-card-title>
							<v-divider></v-divider>
							<v-card-text>
								<div v-if="errors">
									<div v-for="(v, k) in errors" :key="k">
										<v-alert type="error" v-for="error in v" :key="error">{{ error }}</v-alert>
									</div>
								</div>
								<div v-if="response">
									<v-alert type="info">{{ response }}</v-alert>
								</div>
								
								<div class="text--primary text-subtitle-1">
									Проверьте почтовый ящик {{ useremail }} и подтвердите адрес электронной почты, чтобы продолжить.
								</div>			
								
							</v-card-text>
							<v-divider></v-divider>
							<v-card-actions :class="{ 'pa-3': $vuetify.breakpoint.smAndUp }">
								<v-spacer></v-spacer>
								<v-btn color="info" :large="$vuetify.breakpoint.smAndUp" @click="sendlink" :loading="loading">
									<v-icon left>lock</v-icon>
									Отправить еще раз
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
			loading: false,
			form: {
				email: '',
			},
			
			errors: '',
			response: '',

		}),
		props: ['useremail'],
		methods: {
			sendlink () {
				this.loading = true;
				axios.post('/email/verification-notification')
				.then((response) => {
					this.loading = false;
					this.errors = '';
					this.response = '';
					this.response = 'Ссылка для подтверждения электронного адреса была направлена!';
				})
				.catch(error => {
					this.loading = false;
					this.errors = error.response.data.errors;
				});
			},
			logout() {
				axios.post('/logout')
					.then((response) => {
						window.location.replace('/');
						//location.reload();
					})
					.catch(error => {
						this.errors = error.response.data.errors;
					});
			},
		},
	}
	
</script>


<style>

	.maincontainer {
		min-width: 480px;
	}

</style>