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




import 'vue-event-calendar/dist/style.css'
import 'bulma/css/bulma.css'

Vue.config.productionTip = false
Vue.use(vueEventCalendar, { locale: 'en', color: '#a4c1e4' })
Vue.use(VueResource)
Vue.use(Vuex)
Vue.use(store)
Vue.use(VueGoodTable);
Vue.use(VueSweetalert2);


/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App }
})
