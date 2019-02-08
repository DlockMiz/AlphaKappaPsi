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
      path: '/executive_board',
      name: 'Executive Board',
      component: resolve => require(['../components/executive_board.vue'], resolve)
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
        path: '/account_page/requirements_page',
        name: 'Requirements Page',
        component: resolve => require(['../components/account_components/requirements_page.vue'], resolve)
      }, {
        path: '/account_page/account_settings',
        name: 'Account Settings Page',
        component: resolve => require(['../components/account_components/account_settings.vue'], resolve)
      }, {
        path: '/account_page/switch_requests',
        name: 'Requirements Page',
        component: resolve => require(['../components/account_components/switch_requests.vue'], resolve)
      }, {
        path: '/account_page/signed_events',
        name: 'Signed Events',
        component: resolve => require(['../components/account_components/signed_events.vue'], resolve)
      }, {
        path: '/account_page/exec_event_viewer',
        name: 'Exec Event Viewer',
        component: resolve => require(['../components/account_components/exec_event_viewer.vue'], resolve)
      }, {
        path: '/account_page/exec_event_viewer/event_info:id',
        name: 'Event Information',
        component: resolve => require(['../components/account_components/event_info.vue'], resolve)
      }, {
        path: '/account_page/past_event_viewer',
        name: 'Past Event Viewer',
        component: resolve => require(['../components/account_components/past_event_viewer.vue'], resolve)
      }, {
        path: '/account_page/past_event_viewer/past_event_info:id',
        name: 'Past Event Information',
        component: resolve => require(['../components/account_components/past_event_info.vue'], resolve)
      }, {
        path: '/account_page/members_list',
        name: 'Members List',
        component: resolve => require(['../components/account_components/members_list.vue'], resolve)
      }, {
        path: '/account_page/members_list/member_info:id',
        name: 'Member Info',
        component: resolve => require(['../components/account_components/member_info.vue'], resolve)
      }, {
        path: '/account_page/requested_members',
        name: 'Requested Members',
        component: resolve => require(['../components/account_components/requested_members.vue'], resolve)
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
      }, {
        path: '/event_page/professional_development',
        name: 'Prof Dev Event',
        component: resolve => require(['../components/event_components/prof_dev_event.vue'], resolve)
      }, {
        path: '/event_page/brotherhood',
        name: 'Brotherhood Event',
        component: resolve => require(['../components/event_components/brother_event.vue'], resolve)
      }, {
        path: '/event_page/fundraising',
        name: 'Fundraising Event',
        component: resolve => require(['../components/event_components/fundraising_event.vue'], resolve)
      }, {
        path: '/event_page/chapter_comments',
        name: 'Chapter Comments',
        component: resolve => require(['../components/event_components/chapter_comments.vue'], resolve)
      }, {
        path: '/event_page/other',
        name: 'Other Events',
        component: resolve => require(['../components/event_components/any_event.vue'], resolve)
      }]
    }]
  }, {
    path: '/login',
    name: 'Login Page',
    component: resolve => require(['../components/login.vue'], resolve)
  }, {
    path: '/admin_login',
    name: 'Admin Login Page',
    component: resolve => require(['../components/admin_login.vue'], resolve)
  }, {
    path: '/password_reset/:token',
    name: 'Password Reset Page',
    component: resolve => require(['../components/password_reset.vue'], resolve)
  }]
})
