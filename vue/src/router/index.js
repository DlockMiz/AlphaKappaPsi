import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)
Vue.component('app', require('../App.vue'))

export default new Router({
  routes: [{
    path: '/',
    name: '',
    component: resolve => require(['../components/layout.vue'], resolve),
    children: [{
      path: '',
      name: 'Home',
      component: resolve => require(['../components/home.vue'], resolve)
    }, {
      path: '/event_page',
      name: 'Event Page',
      component: resolve => require(['../components/event_page.vue'], resolve),
      children: [{
        path: '/event_page/',
        name: 'Event Calendar Default',
        component: resolve => require(['../components/event_calendar.vue'], resolve)
      },{
        path: '/event_page/event_calendar',
        name: 'Event Calendar',
        component: resolve => require(['../components/event_calendar.vue'], resolve)
      }]
    }]
  }]
})
