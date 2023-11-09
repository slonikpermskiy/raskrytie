<template>

	<v-app id="inspire" class="maincontainer">

		<v-overlay :value="drawer" z-index="4">
		</v-overlay>
		
		<v-navigation-drawer v-model="drawer" app clipped dark hide-overlay disable-resize-watcher color="menuicons" right width="280" :style="{ top: $vuetify.application.top + 'px', zIndex: 6 }">
					
			<div class="d-flex flex-column px-4">	
				<router-link class="nav-link text-decoration-none text-uppercase p-0 p-lg-0 py-2" to="/main/checksystem" @click="drawer = false">О СИСТЕМЕ</router-link>
				<router-link class="nav-link text-decoration-none text-uppercase p-0 p-lg-0 pt-4 pb-2" to="/main/otchetnost" @click="drawer = false">ТЕКУЩАЯ ОТЧЕТНОСТЬ</router-link>
				<router-link class="nav-link text-decoration-none text-uppercase p-0 p-lg-0 pt-2 pb-4" to="/main/services" @click="drawer = false">УСЛУГИ</router-link>
			</div>

			<template>	  
				<div class="px-4">
					<v-btn @click="drawer = false" href="/lk" outlined>Личный кабинет</v-btn>
				</div>
			</template>		  
		  
		</v-navigation-drawer>

		<v-app-bar app clipped-right dark height="64" color="menuicons" style="z-index: 100;">
		  
			<a href="/">
				<v-img class="mx-2 imghover" src="/img/logo.png" max-height="40" max-width="40" contain></v-img>
			</a>

			<div class="d-none d-md-block">
				<div class="d-inline mx-5">
					<router-link class="nav-link text-decoration-none text-uppercase font-weight-bold p-0 p-lg-0" to="/main/checksystem">О СИСТЕМЕ</router-link>
				</div>
				<div class="d-inline mx-5">
					<router-link class="nav-link text-decoration-none text-uppercase font-weight-bold p-0 p-lg-0" to="/main/otchetnost">ТЕКУЩАЯ ОТЧЕТНОСТЬ</router-link>
				</div>
				<div class="d-inline mx-5">
					<router-link class="nav-link text-decoration-none text-uppercase font-weight-bold p-0 p-lg-0" to="/main/services">УСЛУГИ</router-link>
				</div>
			</div>


			<v-spacer></v-spacer>
			
			<div class="d-none d-md-block">
			
				<div class="px-4">
					<v-btn href="/lk" outlined>Личный кабинет</v-btn>
				</div>
			
			</div>
	
	
			<v-app-bar-nav-icon @click.stop="drawer = !drawer" color="white" class="d-block d-md-none mx-2">
	
			</v-app-bar-nav-icon>
		  
		  
		</v-app-bar>


		<v-main app>

			<v-container fluid fill-height ma-0 pa-0>

				<router-view></router-view>

			</v-container>

		</v-main>

  </v-app>

</template>


<script>

import {computed, inject, ref} from "vue";


export default {
	setup() {
  
	},
	methods: {

		onResize () {
			if (window.innerWidth > 959) {
			this.drawer = false
			}
		},

	},
	data () {
      return {
        drawer: false,
      }
    },
	mounted () {
      this.onResize()
      window.addEventListener('resize', this.onResize, { passive: true })
    },
	beforeDestroy () {
      if (typeof window === 'undefined') return

      window.removeEventListener('resize', this.onResize, { passive: true })
    },

};


</script>


<style scoped>

	.nav-link:hover {
		color: #1abc9c;
	}
	.nav-link {
		color: #fff;
	}	
	.nav-link.active {
		color: #1abc9c;
	}	

	.router-link-active, .router-link-exact-active {
		background-color: transparent;
		cursor: pointer;
		color: #1abc9c;
	}

	.maincontainer {
		min-width: 480px;
	}	
	.imghover:hover {
		cursor: pointer;
	}

</style>

