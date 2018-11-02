<template>
  <div>
    <center><img id="loading" style="margin-top: 100px;" src="../../assets/images/loading.gif" height="200" width="200"></center>
      <div id="accountSettingsWrapper">
        <h1 class="title is-2">Account Info:</h1>
        <hr style="background-color: darkslateblue;height: 5px;">
        <div>
          <strong>Name:</strong> {{this.$store.state.user.name}}
        </div>
        <div v-if="this.$store.state.user.status != 1">
          <hr>
          <strong>Mizzou Email:</strong> {{this.$store.state.user.email}}
        </div>
        <div v-if="this.$store.state.user.status != 1 && this.$store.state.user.noti_email != null" style="line-height:36px;">
          <hr>
          <strong>Notifications Email: </strong>{{this.$store.state.user.noti_email}}
          <a style="float:right;" @click="linkNotiEmail()" class="button is-info">Replace</a>
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
          <a style="float:right;" @click="unlinkGoogleAccount()" class="button is-info">Unlink</a>
        </div>
        <hr v-if="this.$store.state.user.status != 1" style="background-color: darkslateblue; height: 5px;">
        <div>
          <h1 class="title is-2">Personal Info:</h1>
          <div>
            <strong>Major(s): <span v-if="this.major.length == 0">Add from the majors below.</span></strong>
            <div v-if="this.major.length == 0">
              <select class="select is-info" v-model="selected_major">
                <option value="Accounting">Accounting</option>
                <option value="Finance/Banking">Finance and Banking</option>
                <option value="Economics">Economics</option>
                <option value="International Business">Internaional Business</option>
                <option value="Marketing">Marketing</option>
                <option value="other">Other</option>
              </select>
              <div style="margin-top: 10px; margin-bottom: 10px;">
                <input class="input is-info" v-if="selected_major == 'other'" style="width: 25%;"></input>
              </div>
            </div>
            <div v-if="this.major.lenth != 0">
              <div v-for="major in major">
                - {{major}}
              </div>
            </div>
            <hr>
          </div>
          <div>
            <strong>Minor: <span>{{minor}}</span></strong>
            <div v-if="infoFilled">
              <input v-model="minor" style="width: 45%;" class="input is-info" type="text">
            </div>
            <hr>
          </div>
          <div>
            <strong>Graduation Date: <span>{{grad_date}}</span></strong>
            <div v-if="infoFilled">
              <datepicker v-model="grad_date" style="width: 25%;" class="input is-info"></datepicker>
            </div>
            <hr>
          </div>
          <div v-if="infoFilled">
            <strong>Phone Number: <span>{{phone_number}}</span></strong>
            <div>
              <input v-model="phone_number" style="width: 25%;" class="input is-info" type="text">
            </div>
            <hr>
          </div>
          <a class="button is-info" @click="saveInfo()" style="margin-bottom: 20px;">Save Info</a>
        </div>
      </div>
  </div>
</template>
<script>
import { registerCurrentUserWithGoogle, addUser, unlinkGoogleAccount, getUser, linkNotiEmail, savePersonalInfo } from '../../router/config'
import Datepicker from 'vue-bulma-datepicker'

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

    this.major = this.user.major_minor.major
    this.minor = this.user.major_minor.minor[0]
    this.grad_date = this.user.grad_date
    this.phone_number = this.user.phone_number

    if(this.phone_number != null)
      this.infoFilled = false

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
      that.resetUserCreds(res)
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

methods.saveInfo = function() {
  this.major.push(this.selected_major)
  this.user.major_minor.major = this.major
  this.user.major_minor.minor[0] = this.minor
  this.user.grad_date = this.grad_date
  this.user.phone_number = this.phone_number
  JSON.stringify(this.user.major_minor)

  console.log(this.user)

  var postData = {
    user: this.user
  }

  this.$http.post(savePersonalInfo, postData).then(response => {
    console.log(response.data)
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
      that.resetUserCreds(response)
    })
  })
}

methods.resetUserCreds = function(response) {
  var that = this
  var userCreds = {}
  userCreds.id = response.data.id
  userCreds.name = response.data.name
  userCreds.status = response.data.status
  userCreds.email = response.data.email
  userCreds.google_email = response.data.google_email
  userCreds.noti_email = response.data.noti_email
  this.$store.dispatch('setUser', userCreds)
}


export default {
  data() {
    return {
      user: null,
      major: [],
      minor: null,
      grad_date: null,
      phone_number: null,
      selected_major: null,
      infoFilled: true
    }
  },
  methods: methods,
  components: {
    Datepicker,

  },
  mounted: function() {
    $('#loading').show()
    $('#accountSettingsWrapper').hide()
    this.getUserInfo()
  }
}

</script>
