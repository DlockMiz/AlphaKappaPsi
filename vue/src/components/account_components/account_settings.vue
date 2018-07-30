<template>
  <div>
    <h1 class="title is-2">Account Info</h1>
    <hr>
    <div>
      <strong>Name:</strong> {{user.name}}
    </div>
    <hr>
    <div>
      <strong>Mizzou Email:</strong> {{user.email}}
    </div>
    <hr>
    <div>
      <strong>Status:</strong> {{user.status}}
    </div>
    <hr>
    <div v-if="this.$store.state.user.google_email == null" style="width: 100%; height: 36px; line-height: 36px;">
      <strong>Google Account: </strong> No Current Email Linked
        <a @click="signInAdmin()" style="width: 5%;" class="button"><img src="../../assets/images/google_icon.png" style="height: 15px;"></a>
    </div>
    <div v-if="this.$store.state.user.google_email != null" style="width: 100%; height: 36px; line-height: 36px;">
      <strong>Google Account:</strong> {{this.$store.state.user.google_email}}
      <a style="float:right;" @click="unlinkGoogleAccount" class="button is-info">Unlink</a>
    </div>
    <hr>
  </div>
</template>
<script>
import { registerCurrentUserWithGoogle, addUser, unlinkGoogleAccount, getUser } from '../../router/config'
var methods = {}

methods.getUserInfo = function() {
  var postData = {
    id: this.$store.state.user.id,
    type: 'requirements'
  }
  this.$http.post(getUser, postData).then(response => {
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
    this.getUserInfo()
  }
}

</script>
