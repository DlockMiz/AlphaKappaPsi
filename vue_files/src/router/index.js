import Vue from 'vue'
import Router from 'vue-router'
import Vuetify from 'vuetify'
import VuetifyStyle from 'vuetify/dist/vuetify.min.css'
require('vuetify/dist/vuetify.min.css')

Vue.component('app', require('../App.vue'))
Vue.use(Router)
Vue.use(Vuetify)
Vue.use(VuetifyStyle)

export default new Router({
  routes: [{
    path: '/',
    name: '',
    component: resolve => require(['../components/layout.vue'], resolve),
    children: [{
      path: '',
      name: '',
      component: resolve => require(['../components/home.vue'], resolve)
    }, {
      path: '/home',
      name: 'Home',
      component: resolve => require(['../components/home.vue'], resolve)
    }, {
      path: '/about',
      name: 'About the Webpage',
      component: resolve => require(['../components/about.vue'], resolve)
    }, {
      path: '/internship_2017',
      name: 'Internship',
      component: resolve => require(['../components/internship.vue'], resolve)
    }]
  }]
})
