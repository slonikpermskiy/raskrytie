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
						<v-list-item-title class="blue-grey-darken-3--text text-body-2 font-weight-bold">Администратор</v-list-item-title>
					</v-list-item-content>				  
					<v-list-item-action>
						<v-btn icon color="menuicons" @click.native="logout">
							<v-icon dark>mdi-logout</v-icon>
						</v-btn>
					</v-list-item-action>
				</v-list-item>
			</template>
	  
			<v-divider></v-divider>
				
			<v-list-item link to="/adminaccesspanel/adminforms" v-on:click="closedrawer()">			
				<v-list-item-icon>
					<v-icon color="blue-grey darken-3">mdi-clipboard-list-outline</v-icon>
				</v-list-item-icon>
				<v-list-item-title class="blue-grey-darken-3--text text-body-2 font-weight-bold">Отчеты</v-list-item-title>
			</v-list-item>
					
			<v-list-item link to="/adminaccesspanel/adminusers" v-on:click="closedrawer()">
				<v-list-item-icon>
					<v-icon color="blue-grey darken-3">mdi-account</v-icon>
				</v-list-item-icon>
				<v-list-item-title class="blue-grey-darken-3--text text-body-2 font-weight-bold">Пользователи</v-list-item-title>
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

				<router-view></router-view>
    
			</v-container>
  
		</v-main>

	</v-app>

</template>


<script>

// Скрытие меню navigation-drawer в Desktop
//:expand-on-hover="!$vuetify.breakpoint.sm && !$vuetify.breakpoint.xs"
//:mini-variant="!$vuetify.breakpoint.sm && !$vuetify.breakpoint.xs"

export default {

	data () {
		return {
			drawer: false,
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
		}
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
			
		},		
    },
	
}

</script>


<style scoped>

	.maincontainer {
		min-width: 480px;
	}

</style>
