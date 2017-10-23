<template>
  <div>
    <i @click="showBarsBox = !showBarsBox" class="fa fa-bars fa-2x" id="bars" aria-hidden="true"></i>
    <div v-show="showBarsBox" id="settingsBox">
      <a v-show="loginButton" class="button is-info buttons" @click="goToLogin()">Login</a>
      <a v-show="accountSettingsButton" href="#/account_page" @click="showBarsBox = false" class="button is-info buttons">Account Settings</a>
      <a v-show="showLogoutButton" @click="logoutUser()" class="button is-info buttons">Logout</a>
    </div>
    <nav_bar></nav_bar>
    <router-view></router-view>
  </div>
</template>
<script>

import nav_bar from './nav_bar'
export default {
  data() {
    return {
      showAccountSettings: false,
      showBarsBox: false,
      loginButton: true,
      registerButton: true,
      accountSettingsButton: false,
      showLogoutButton: false
    }
  },

  mounted: function() {
    this.checkUser()
  },

  components: {
    nav_bar,
  },
  methods: {
    goToLogin() {
      this.$router.push('/login')
    },
    logoutUser() {
      sessionStorage.clear()
      location.reload()
      this.$router.push('/')
    },
    checkUser() {
      if (this.$store.state.user != null) {
        this.loginButton = false
        this.registerButton = false
        this.accountSettingsButton = true
        this.showLogoutButton = true
      }
    },
    rightMenu() {

    }
  }
}

</script>
<style>
div#settingsBox {
  margin: 10px !important;
  top: 30px;
  right: 30px;
  position: fixed;
  width: 10%;
  background-color: #ebe9e9;
}

.buttons {
  width: 94%;
  margin: 5px;
}

#bars {
  position: absolute;
  top: 10px;
  right: 10px;
}

#bars:hover {
  cursor: pointer;
}

</style>
