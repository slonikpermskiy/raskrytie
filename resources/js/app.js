
require('./bootstrap');

window.Vue = require('vue').default;

import Vuetify from './plugins/vuetify'

import VueRouter from 'vue-router'

import Scrollspy from 'vue2-scrollspy';

// https://materialdesignicons.com/
import '@mdi/font/css/materialdesignicons.css'

// https://fonts.google.com/icons
import 'material-design-icons-iconfont/dist/material-design-icons.css';

// https://vue-multiselect.js.org/
import Multiselect from 'vue-multiselect';

import LoginPage from './components/LoginPage.vue';

import AdminLoginPage from './components/AdminLoginPage.vue';

import VerifyEmail from './components/VerifyEmail.vue';

import LkMainPageSideBar from './components/lk/LkMainPageSideBar.vue';
import FormsControl from './components/lk/FormsControl.vue';
import MyForms from './components/lk/MyForms.vue';
import Settings from './components/lk/Settings.vue';
import Support from './components/lk/Support.vue';

import AdminMainPageSideBar from './components/admin/AdminMainPageSideBar.vue';
import AdminForms from './components/admin/AdminForms.vue';
import AdminUsers from './components/admin/AdminUsers.vue';

import OtchetPeriods from './components/OtchetPeriods.vue';

import AddPeriodDialog from './components/AddPeriodDialog.vue';

import DayEvents from './components/DayEvents.vue';

import OtchetPlanFacts from './components/OtchetPlanFacts.vue';

import WelcomePage from './components/main/WelcomePage.vue';
import Otchetnost from './components/main/Otchetnost.vue';
import Checksystem from './components/main/Checksystem.vue';
import Services from './components/main/Services.vue';
import MainDayEvents from './components/main/MainDayEvents.vue';

import DayEventsForPrint from './components/DayEventsForPrint.vue';

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('welcome-page', WelcomePage);
Vue.component('login-page', LoginPage);
Vue.component('verifyemail-page', VerifyEmail);
Vue.component('lkmainpagesidebar', LkMainPageSideBar);
Vue.component('admin-login-page', AdminLoginPage);
Vue.component('adminmainpagesidebar', AdminMainPageSideBar);

Vue.component('otchetperiods', OtchetPeriods);

Vue.component('addperioddialog', AddPeriodDialog);

Vue.component('dayevents', DayEvents);

Vue.component('otchetplanfacts', OtchetPlanFacts);

Vue.component('maindayevents', MainDayEvents);

Vue.component('dayeventsforprint', DayEventsForPrint);

Vue.use(VueRouter);

Vue.use(Scrollspy);

Vue.component('multiselect', Multiselect);


// Define some routes
const routes = [
	{ path: '/lk', redirect: '/lk/formscontrol' },
	{ path: '/lk/formscontrol', component: FormsControl },
	{ path: '/lk/myforms', component: MyForms },
	{ path: '/lk/settings', component: Settings },
	{ path: '/lk/support', component: Support },
	{ path: '/adminaccesspanel', redirect: '/adminaccesspanel/adminforms' },
    { path: '/adminaccesspanel/adminforms', component: AdminForms },
    { path: '/adminaccesspanel/adminusers', component: AdminUsers },

	{ path: '/main', redirect: '/main/checksystem' },
	{ path: '/main/otchetnost', component: Otchetnost },
	{ path: '/main/checksystem', component: Checksystem },
	{ path: '/main/services', component: Services },
]

// Create the router instance and pass the `routes` option
const router = new VueRouter({
	mode: 'history',
    routes
})

export default router;


window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}


Vue.filter('dateOrNull', function(d, ...others) {
  return d ? Vue.filter('date')(d, ...others) : null;
});


const app = new Vue({
    vuetify: Vuetify,
	router
}).$mount('#app');
 
 
