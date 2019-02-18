<template>
  <div>
    <center><img id="loading" style="margin-top: 100px;" src="../../assets/images/loading.gif" height="200" width="200"></center>
    <div id="accountSettingsWrapper">
      <h1 class="title is-2">Account Info</h1>
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
        <div><small>If not filled out, emails will be sent to your mizzou account, which go automatically to spam!</small></div>
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
      <div v-if="this.$store.state.user.status != 1">
        <div>
          <hr>
          <h1 class="title is-2">Personal Info</h1>
          <hr v-if="this.$store.state.user.status != 1" style="background-color: darkslateblue; height: 5px;">
          <div>
            <strong>Major: <span>{{major}}</span></strong>
            <div style="margin-top: 10px; margin-bottom: 10px;">
              <div v-if="infoFilled" class="select">
                <select v-model="major">
                  <option>Accounting</option>
                  <option>Finance</option>
                  <option>International Business</option>
                  <option>Management</option>
                  <option>Marketing</option>
                  <option>Economics</option>
                  <option>Other</option>
                </select>
              </div>
              <div v-show="major == 'Other'">
                <input v-model="other_major" class="input is-info" v-if="infoFilled" style="width: 25%; margin-top: 10px;" placeholder="Please type major..."></input>
              </div>
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
        <div>
          <strong>Phone Number: <span>{{phone_number}}</span></strong>
          <div v-if="infoFilled">
            <input v-model="phone_number" style="width: 25%;" class="input is-info" type="text">
          </div>
          <hr>
        </div>
        <div>
          <strong>Short Description</strong>
          <div v-show="description != null && infoFilled != true">
            {{description}}
          </div>
          <div v-if="infoFilled">
            <textarea v-model="description" style="width: 25%;" class="input is-info" type="text"></textarea>
          </div>
          <hr>
        </div>
        <a v-if="infoFilled" class="button is-info" @click="saveInfo()" style="margin-bottom: 20px;">Save Info</a>
        <a v-if="!infoFilled" class="button is-info" @click="infoFilled = !infoFilled" style="margin-bottom: 20px;">Edit Info</a>
      </div>
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


    this.major = this.user.major_minor.major[0]
    this.minor = this.user.major_minor.minor[0]
    this.grad_date = this.user.grad_date
    this.phone_number = this.user.phone_number
    this.description = this.user.description

    var other_major = this.major.split("Other")
    if (other_major[0] == "") {
      this.major = other_major[1]
    }


    if (this.phone_number != null)
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
  console.log(this.minor)
  if (this.major == null || this.minor == null || this.grad_date == null || this.phone_number == null || this.major == '' || this.minor == '' || this.grad_date == null || this.phone_number == '') {
    this.$swal('Nope', 'Please enter something in every field!', 'error')
    return
  }

  if (this.major == 'Other') {
    this.user.major_minor.major[0] = "Other" + this.other_major
  } else {
    this.user.major_minor.major[0] = this.major
  }
  this.user.major_minor.minor[0] = this.minor
  this.user.grad_date = this.grad_date
  this.user.phone_number = this.phone_number
  this.user.description = this.description
  
  JSON.stringify(this.user.major_minor)

  var postData = {
    user: this.user
  }
  console.log(this.user)

  this.$http.post(savePersonalInfo, postData).then(response => {
    this.getUserInfo()
    this.$swal('Success', 'Info Successfully Changed', 'success')
    this.$store.commit('CHANGE_INFO')
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
      major: null,
      minor: null,
      grad_date: null,
      phone_number: null,
      infoFilled: true,
      other_major: null,
      description: null
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
