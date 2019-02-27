<template>
  <div>
    <div id="middleWrapper">
      <a href="/"> <img src="../assets/images/akp_logo.png" alt="" style="height: 100px;"> </a>
      <h1 class="title is-1">Exec Login</h1>
      <a class="button is-info" @click="signInAdmin()">Sign In With Google</a>
    </div>
  </div>
</template>
<script>
import { store } from '../store.js'
import { findUser, addUser } from '../router/config'

var methods = {}

methods.signInAdmin = function() {
  var that = this
  this.$googleAuth().directAccess()
  this.$googleAuth().signIn(function(googleUser) {
    var postData = {
      email: googleUser.w3.U3,
      type: 'admin'
    }
    that.$http.post(findUser, postData).then(response => {
      if (response.data.length != 0) {
        var userCreds = {}
        userCreds.id = response.data[0].id
        userCreds.name = response.data[0].name
        userCreds.status = response.data[0].status
        userCreds.google_email = response.data[0].google_email        

        that.$store.dispatch('setUser', userCreds).then(response => {
          that.$router.push('/')
        })
      }else
      that.$swal('Nope!','This is not a registered account!','error')
    })
  })
}

export default {
  data() {
    return {}
  },
  methods: methods,
  mounted: function() {}
}

</script>
<style>
#middleWrapper {
  width: 40%;
  text-align: center;
  margin: auto;
  margin-bottom: 50%;
  margin-top: 15%;
  height: 5%;
}

</style>
