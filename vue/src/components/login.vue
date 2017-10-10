<template>
  <div>
    <input type="text" name="username" v-model="username" placeholder="Username...">
    <input type="text" name="username" v-model="password" placeholder="Password...">
    <button @click="login()">Login</button>
    <button @click="test()">test</button>
  </div>
</template>
<script>
import { store } from '../store.js'
import { findUser } from '../router/config'

export default {
  data() {
    return {
      username: '',
      password: ''
    }
  },
  methods: {
    login() {
      const authUser = {}
      authUser.username = this.username
      authUser.password = this.password

      window.sessionStorage.setItem('authorized', JSON.stringify(authUser))
      this.$store.dispatch('setUser', authUser).then(response => {
      })
    },

    test() {
      console.log(this.$store.state.user)
    },
    confirmUser(user) {
      this.$http.post(findUser, user).then(response => {

      })
    }
  }
}

</script>
