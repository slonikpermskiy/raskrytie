<template>
	
	<v-container fluid fill-height class="maincontainer elevation-1 pa-1 ma-0 align-start">
		
		<v-container fluid class="pa-3" v-if="user.id">
			
			<v-row class="my-0 py-0">

				<v-col
					cols="12">
					
					
					<div class="d-flex align-center my-0 py-0">
					
						<div class="font-weight-bold text-h6 text-uppercase">Часто задаваемые вопросы</div>

					</div>						

				
				</v-col>
				
                <v-col
					cols="12">

                    <v-expansion-panels accordion>
                        <v-expansion-panel>
                            <v-expansion-panel-header>Item</v-expansion-panel-header>
                                <v-expansion-panel-content>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </v-expansion-panel-content>
                        </v-expansion-panel>
                        <v-expansion-panel>
                            <v-expansion-panel-header>Item</v-expansion-panel-header>
                                <v-expansion-panel-content>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </v-expansion-panel-content>
                        </v-expansion-panel>
                        <v-expansion-panel>
                            <v-expansion-panel-header>Item</v-expansion-panel-header>
                                <v-expansion-panel-content>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </v-expansion-panel-content>
                        </v-expansion-panel>
                        <v-expansion-panel>
                            <v-expansion-panel-header>Item</v-expansion-panel-header>
                                <v-expansion-panel-content>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </v-expansion-panel-content>
                        </v-expansion-panel>
                        <v-expansion-panel>
                            <v-expansion-panel-header>Item</v-expansion-panel-header>
                                <v-expansion-panel-content>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </v-expansion-panel-content>
                        </v-expansion-panel>
                    </v-expansion-panels>

                </v-col>						
			</v-row>
						
			
			<div class="p-0 m-0 mt-3">
	
				<p class="font-weight-bold text-h6 text-uppercase">Напишите нам</p>
	
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
								<p class="text-start fs-5">Получение еженедельной рассылки с информацией об отчетах, которые необходимо сдать.</p>
							</div>
						</div>
						
						<div class="d-flex my-2">
							<div class="align-self-center me-3">						
								<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
							</div>
							<div class="align-self-center">
								<p class="text-start fs-5">Отсутствие рекламы.</p>
							</div>
						</div>
						
						<div class="d-flex my-2">
							<div class="align-self-center me-3">						
								<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
							</div>
							<div class="align-self-center">
								<p class="text-start fs-5">Приоритетная техническая поддержка.</p>
							</div>
						</div>

					</v-col>
					
				</v-row>

			</div>

		</v-container>

	</v-container>
	
</template>



<script>

	import {DateTime} from "luxon";

    export default {
	
		data: () => ({
			user: [],
		}),
		
		created () {
			this.initialize()
		},
		
		watch: {
	
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

