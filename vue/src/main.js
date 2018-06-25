// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import vueEventCalendar from 'vue-event-calendar'
import VueResource from 'vue-resource'
import Vuex from 'vuex'
import store from './store.js';
import VueGoodTable from 'vue-good-table';
import VueSweetalert2 from 'vue-sweetalert2';
import GoogleAuth from 'vue-google-auth'



import 'vue-event-calendar/dist/style.css'
import 'bulma/css/bulma.css'

Vue.config.productionTip = false
Vue.use(vueEventCalendar, { locale: 'en', color: '#a4c1e4' })
Vue.use(VueResource)
Vue.use(Vuex)
Vue.use(store)
Vue.use(VueGoodTable);
Vue.use(VueSweetalert2);

var api_key
var call

var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    this.api_key = JSON.parse(this.responseText)[0].api_key
    Vue.use(GoogleAuth, { client_id: this.api_key })
    Vue.googleAuth().load()
  }
};

if(window.location.hostname == 'localhost')
	call = 'http://akp.test/api/getGoogleApiKey'
else
	call = 'http://server.akpmiztest.ml/api/getGoogleApiKey'

xhttp.open("POST", call, true);
xhttp.send();

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App }
})
