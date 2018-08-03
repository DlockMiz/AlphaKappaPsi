<template>
  <div>
    <b v-show="this.$store.state.user != null" style="top: 0px; right: 5px; position:absolute;">Logged in as {{currentUser}}</b>
    <b v-show="this.$store.state.user == null" style="top: 0px; right: 5px; position:absolute;">Not Logged In</b>
    <i class="fa fa-bars fa-2x" id="bars" aria-hidden="true"></i>
    <div id="settingsBox">
      <a v-show="loginButton" class="button is-info buttons" @click="goToLogin()">Login</a>
      <a v-show="loginButton" class="button is-info buttons" @click="goToLogin(true)">Exec Login</a>
      <a v-show="accountSettingsButton" href="#/account_page" @click="showBarsBox = false" class="button is-info buttons">Account</a>
      <a v-show="showLogoutButton" @click="logoutUser()" class="button is-info buttons">Logout</a>
    </div>
    <nav_bar></nav_bar>
    <router-view></router-view>
  </div>
</template>
<script>
var settingsBox = false
window.$ = window.jQuery = require('jquery');

import nav_bar from './nav_bar'
export default {
  data() {
    return {
      showBarsBox: false,
      loginButton: true,
      registerButton: true,
      accountSettingsButton: false,
      showLogoutButton: false,
      currentUser: ''
    }
  },

  mounted: function() {
    this.checkUser()
    $('#bars').click(function() {
      if (settingsBox == false) {
        $('#settingsBox').show(100)
        settingsBox = true
      } else {
        $('#settingsBox').hide(100)
        settingsBox = false
      }
    })
  },

  components: {
    nav_bar,
  },
  methods: {
    goToLogin(e) {
      if (e) {
        this.$router.push('/admin_login')
      } else
        this.$router.push('/login')
    },
    logoutUser() {
      sessionStorage.clear()
      this.$swal('Logout Successfull', "", 'success').then((result) => { this.$router.push('/'); setTimeout(function(){location.reload()},1000) })      
    },
    checkUser() {
      if (this.$store.state.user != null) {
        this.loginButton = false
        this.registerButton = false
        this.accountSettingsButton = true
        this.showLogoutButton = true
        this.currentUser = this.$store.state.user.name
        if (this.$store.state.user.status == 3) {
          this.currentUser = this.currentUser + ' - Pledge'
        } else if (this.$store.state.user.status == 2) {
          this.currentUser = this.currentUser + ' - Active'
        } else if (this.$store.state.user.status == 1) {
          this.currentUser = this.currentUser + ' - Executive'
        }
      }
    },
  }
}

</script>
<style>
div#settingsBox {
  margin: 10px !important;
  top: 0px;
  left: 40px;
  position: absolute;
  background-color: #ebe9e9;
  display: none;
}

.buttons {
  margin: 5px;
  background-color: #1b4d8a !important;
}

.buttons:hover {
  border-color: white !important;
}

#bars {
  position: absolute;
  top: 15px;
  left: 10px;
}

#bars:hover {
  cursor: pointer;
}

</style>
