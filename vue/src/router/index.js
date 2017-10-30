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
      //
      //All of these routes are for accounts settings
      //
      path: '/account_page',
      name: 'Account Page',
      component: resolve => require(['../components/account_page.vue'], resolve),
      children: [{
        path: '/account_page',
        name: 'Default Account',
        component: resolve => require(['../components/account_components/central_account_page.vue'], resolve)
      }, {
        path: '/account_page/signed_events',
        name: 'Signed Events',
        component: resolve => require(['../components/account_components/signed_events.vue'], resolve)
      }, {
        path: '/account_page/members_list',
        name: 'Members List',
        component: resolve => require(['../components/account_components/members_list.vue'], resolve)
      }, {
        path: '/account_page/members_list/member_info:id',
        name: 'Member Info',
        component: resolve => require(['../components/account_components/member_info.vue'], resolve)
      }]
    }, {
      //
      //All of these routes are for the events page
      //
      path: '/event_page',
      name: 'Event Page',
      component: resolve => require(['../components/event_page.vue'], resolve),
      children: [{
        path: '/event_page',
        name: 'Event Calendar Default',
        component: resolve => require(['../components/event_components/central_event_page.vue'], resolve)
      }, {
        path: '/event_page/event_calendar',
        name: 'Event Calendar',
        component: resolve => require(['../components/event_components/event_calendar.vue'], resolve)
      }, {
        path: '/event_page/event_calendar_options',
        name: 'Calendar Event Options',
        component: resolve => require(['../components/calendar_components/event_calendar_options.vue'], resolve)
      }, {
        path: '/event_page/service_event',
        name: 'Service Event',
        component: resolve => require(['../components/event_components/service_event.vue'], resolve)
      }]
    }]
  }, {
    path: '/login',
    name: 'Login Page',
    component: resolve => require(['../components/login.vue'], resolve)
  }]
})
