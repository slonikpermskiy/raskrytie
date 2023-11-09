<template>

	<v-app class="maincontainer">

		<v-overlay v-if="$vuetify.breakpoint.sm | $vuetify.breakpoint.xs" :value="drawer" z-index="4"></v-overlay>
    
		<!-- Диррективы :expand-on-hover и :mini-variant позволяют скрывать меню на экранах средних размеров -->
		<v-navigation-drawer
			v-model="drawer"
			:permanent="!$vuetify.breakpoint.sm && !$vuetify.breakpoint.xs"
			:expand-on-hover="!$vuetify.breakpoint.sm && !$vuetify.breakpoint.xs && !$vuetify.breakpoint.xl"
			:mini-variant="!$vuetify.breakpoint.sm && !$vuetify.breakpoint.xs && !$vuetify.breakpoint.xl"
			app
			clipped
			hide-overlay
			:style="{ top: $vuetify.application.top + 'px', zIndex: 6 }"
			:width="width">
		
			<template v-slot:prepend>
				<v-list-item two-line class="px-2">
					<v-list-item-avatar>
						<v-img src="/img/account.png"></v-img>
					</v-list-item-avatar>
					<v-list-item-content>
						<v-list-item-title class="blue-grey-darken-3--text text-body-2 font-weight-bold">{{ company }}</v-list-item-title>
						<v-list-item-subtitle class="subtitlepromo--text text-caption font-weight-bold">
							<v-chip x-small color="primary">
								{{ source }}
							</v-chip>
						</v-list-item-subtitle>
					</v-list-item-content>				  
					<v-list-item-action>
						<v-btn icon color="menuicons" @click.native="logout">
							<v-icon dark>mdi-logout</v-icon>
						</v-btn>
					</v-list-item-action>
				</v-list-item>
			</template>
	  
			<v-divider></v-divider>
			
			<v-list-item link to="/lk/formscontrol" v-on:click="closedrawer()">           
				<v-list-item-icon>
					<v-icon color="blue-grey darken-3">mdi-calendar-clock</v-icon>
				</v-list-item-icon>
				<v-list-item-title class="blue-grey-darken-3--text text-body-2 font-weight-bold">Контроль отчетности</v-list-item-title>
			</v-list-item>
			
			<v-list-item link to="/lk/myforms" v-on:click="closedrawer()">
				<v-list-item-icon>
					<v-icon color="blue-grey darken-3">mdi-clipboard-list-outline</v-icon>
				</v-list-item-icon>
				<v-list-item-title class="blue-grey-darken-3--text text-body-2 font-weight-bold">Моя отчетность</v-list-item-title>
			</v-list-item>

			<v-divider></v-divider>
       
			<v-list-item link to="/lk/settings" v-on:click="closedrawer()">
				<v-list-item-icon>
					<v-icon color="blue-grey darken-3">mdi-cog</v-icon>
				</v-list-item-icon>
				<v-list-item-title class="blue-grey-darken-3--text text-body-2 font-weight-bold">Настройки пользователя</v-list-item-title>
			</v-list-item>

			<v-list-item link to="/lk/support" v-on:click="closedrawer()">
				<v-list-item-icon>
					<v-icon color="blue-grey darken-3">mdi-lifebuoy</v-icon>
				</v-list-item-icon>
				<v-list-item-title class="blue-grey-darken-3--text text-body-2 font-weight-bold">Помощь</v-list-item-title>
			</v-list-item>			
		
			<v-divider></v-divider>
	
		</v-navigation-drawer>

		<v-app-bar
			app
			clipped-left
			dark
			color="menuicons"
			v-if="$vuetify.breakpoint.sm | $vuetify.breakpoint.xs"
			height="64"
			style="z-index: 100;">
			
			<v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
			<v-toolbar-title></v-toolbar-title>
		</v-app-bar>

		
		<v-main app>

			<v-container fluid fill-height>

				<router-view :getUserSideBar="getUser"></router-view>
    
			</v-container>
  
		</v-main>

	</v-app>

</template>


<script>

// Скрытие меню navigation-drawer в Desktop
//:expand-on-hover="!$vuetify.breakpoint.sm && !$vuetify.breakpoint.xs"
//:mini-variant="!$vuetify.breakpoint.sm && !$vuetify.breakpoint.xs"


import {DateTime} from "luxon";

export default {
	
	data () {
		return {
			drawer: false,
			userid: '',
			company: '',
			premium: '',
		}
	},
	methods: {
		logout() {
			axios.post('/logout')
				.then((response) => {
					window.location.replace('/');
					//location.reload();
				})
				.catch(error => {
					//this.errors = error.response.data.errors;
				});
		},
		closedrawer () {
			this.drawer = false;		
		},
		
		getUser () {
			
			axios.get('getuser')
			.then((response) => {

				this.userid = response.data.id;
				this.company = response.data.name;
				this.premium = response.data.premium_to_date;
				
			})
			.catch(error => {})
			.finally(() => {});
			
		},
		
		changeName () {
			this.edituser = Object.assign({}, this.user)
			this.errors_change = '',
			this.userdatadialog = true
		},
	},	
	created () {
		this.getUser ();
	},

	setup () {	
	},
	props: [],
	computed: {
		width () {
			switch (this.$vuetify.breakpoint.name) {
				case 'xs': return 300
				case 'sm': return 300
				case 'md': return 300
				case 'lg': return 300
				case 'xl': return 300
				case 'xxl': return 300
			}
		},
		source() {
		
			if (!this.premium || this.premium === null || this.premium === undefined) {					
				return 'Стандарт';
			} else {

				var date = DateTime.now();
				
				if (DateTime.fromISO(this.premium) < date.minus({ days: 1 })) {
					return 'Стандарт';
				} else {
					return 'Премиум';
				}

			}
			
		},		
    },
	
}

</script>


<style scoped>

	.maincontainer {
		min-width: 480px;
	}

</style>
