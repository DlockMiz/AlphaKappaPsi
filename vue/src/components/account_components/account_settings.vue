<template>
  <div>
    <center><img id="loading" style="margin-top: 100px;" src="../../assets/images/loading.gif" height="200" width="200"></center>
    <div id="accountSettingsWrapper">
      <h1 class="title is-2">Account Info</h1>
      <hr>
      <div>
        <strong>Name:</strong> {{this.$store.state.user.name}}
      </div>
      <hr>
      <div>
        <strong>Status:</strong> {{this.$store.state.user.status}}
      </div>
      <div v-if="this.$store.state.user.status != 1">
        <hr>
        <strong>Mizzou Email:</strong> {{this.$store.state.user.email}}
      </div>
      <div v-if="this.$store.state.user.status != 1 && this.$store.state.user.noti_email != null" style="line-height:36px;">
        <hr>
        <strong>Notifications Email: </strong>{{this.$store.state.user.noti_email}}
      </div>
      <div v-if="this.$store.state.user.status != 1 && this.$store.state.user.noti_email == null" style="line-height:36px;">
        <hr>
        <strong>Notifications Email:</strong>
        <a class="button is-info" @click="linkNotiEmail()">Link Notification Email</a>
      </div>
      <hr>
      <div v-if="this.$store.state.user.google_email == null && this.$store.state.user.status != 1" style="width: 100%; height: 36px; line-height: 36px;">
        <strong>Google Account: </strong> No Current Email Linked
        <a @click="signInAdmin()" style="width: 5%;" class="button"><img src="../../assets/images/google_icon.png" style="height: 15px;"></a>
      </div>
      <div v-if="this.$store.state.user.google_email != null" style="width: 100%; height: 36px; line-height: 36px;">
        <strong>Google Account:</strong> {{this.$store.state.user.google_email}}
        <a style="float:right;" @click="unlinkGoogleAccount" class="button is-info">Unlink</a>
      </div>
      <hr v-if="this.$store.state.user.status != 1">
    </div>
  </div>
</template>
<script>
import { registerCurrentUserWithGoogle, addUser, unlinkGoogleAccount, getUser, linkNotiEmail } from '../../router/config'
var methods = {}

methods.getUserInfo = function() {
  var postData = {
    id: this.$store.state.user.id,
    type: 'requirements'
  }
  this.$http.post(getUser, postData).then(response => {
    $('#loading').hide()
    $('#accountSettingsWrapper').show()
    this.user = response.data[0]
    this.requirements = response.data[1]
    switch (this.user.status) {
      case '1':
        this.user.status = 'Executive'
        break;
      case '2':
        this.user.status = 'Active'
        break;
      case '3':
        this.user.status = 'Pledge'
        break;
    }
  })
}

methods.linkNotiEmail = function() {
  var that = this
  const { value: email } = this.$swal({
    title: 'Input email address',
    input: 'email',
    inputPlaceholder: 'Enter your email address'
  }).then(response => {
    var postData = {
      user_id: this.$store.state.user.id,
      noti_email: response.value
    }
    this.$http.post(linkNotiEmail, postData).then(res => {
      this.$swal('Success!', 'Your email has been registered', 'success')
      that.$store.state.user.noti_email = res.data
    })
  })
}

methods.unlinkGoogleAccount = function() {
  var postData = {
    user_id: this.$store.state.user.id
  }
  this.$http.post(unlinkGoogleAccount, postData).then(response => {
    this.$swal('Success!', 'This email is no longer linked to this account!', 'success')
    this.$store.state.user.google_email = null;
  })
}

methods.signInAdmin = function() {
  var that = this
  this.$googleAuth().directAccess()
  this.$googleAuth().signIn(function(googleUser) {
    var postData = {
      email: googleUser.w3.U3,
      user_id: that.$store.state.user.id
    }
    that.$http.post(registerCurrentUserWithGoogle, postData).then(response => {
      that.$swal('Success!', 'This Google account is linked to your AlphaKappaPsi Account, you can now login with it!', 'success')
      that.$store.state.user.google_email = response.data
    })
  })
}


export default {
  data() {
    return {
      user: null,
    }
  },
  methods: methods,
  mounted: function() {
    $('#loading').show()
    $('#accountSettingsWrapper').hide()
    this.getUserInfo()
  }
}

</script>
