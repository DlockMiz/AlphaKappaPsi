<template>
  <div>
    <div id="middleWrapper">
      <a href="/"><img src="../assets/images/akp_logo.png" alt="" style="height: 100px;"> </a>
      <div id="optionsBox">
        <div id="loginBox">
          <input style="width:50%;" class="input is-info input_tags" type="text" v-model="pawprint" placeholder="Pawprint...">
          <a id="emailTag">@mail.missouri.edu</a>
          <input id="finalInput" class="input is-info input_tags" v-on:keyup.enter="loginUser()" type="password" v-model="password" placeholder="Password...">
          <a id="loginPageButton" @click="loginUser()" class="button is-info inputs">Login</a>
          <a id="loginPageButton" @click="forgotPassword()" class="button is-info inputs">Forgot Password?</a>
          <a @click="signInWithGoogle()" id="loginGoogleButton" class="button"><img src="../assets/images/google_icon.png" style="height: 15px;"></a>
          <a id="failedTag" v-show="showLoginFail">Login Failed</a>
        </div>
        <div id="registerBox">
          <input class="input is-info input_tags" type="text" name="email" v-model="registerEmail" placeholder="Email...">
          <input class="input is-info input_tags" type="text" name="username" v-model="registerFName" placeholder="First Name...">
          <input class="input is-info input_tags" type="text" name="username" v-model="registerLName" placeholder="Last Name...">
          <input class="input is-info input_tags" type="password" name="pass" v-model="registerPassword" placeholder="Password...">
          <input class="input is-info input_tags" v-on:keyup.enter="registerUser()" type="password" name="pass" v-model="checkPass" placeholder="Check Password...">
          <a id="failedTag" v-show="noPasswordMatch">Passwords Do Not Match</a>
          <a id="registerPageButton" @click="registerUser()" class="button is-info inputs">Register</a>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
window.$ = window.jQuery = require('jquery');
import { store } from '../store.js'
import { findUser, addUser, signInActiveWithGoogle, sendResetPassEmail } from '../router/config'

export default {
  data() {
    return {
      pawprint: '',
      password: '',
      checkPass: '',
      noPasswordMatch: false,
      registerPassword: '',
      registerEmail: '',
      registerFName: '',
      registerLName: '',
      userCreds: {},
      showLoginFail: false,

    }
  },
  methods: {

    loginUser() {
      const authUser = {}
      authUser.email = this.pawprint + "@mail.missouri.edu"
      authUser.password = this.password
      this.confirmUser(authUser)
    },

    forgotPassword() {
      const { value: name } = this.$swal({
        title: 'What is your email?',
        input: 'text',
        inputPlaceholder: 'Email...',
        showCancelButton: true,
        inputValidator: (value) => {
          return !value && 'You need to write something!'
        }
      }).then(response => {
        var postData = {
          email: response.value
        }

        this.$http.post(sendResetPassEmail, postData).then(response => {
          this.$swal('Success','An email has been sent with a link to reset your password!','success')
        })
      })
    },

    registerUser() {
      const postData = {
        email: this.registerEmail,
        password: this.registerPassword,
        name: this.registerFName +" "+ this.registerLName,
      }
      console.log(postData)
      var $emailCheck = this.registerEmail.split('@')

      if (this.registerEmail == '' || this.registerPassword == '' || this.registerName == '') {
        this.$swal('Error', "Please fill in all the blanks!", 'error')
        return
      }

      if ($emailCheck[1] != 'mail.missouri.edu') {
        this.$swal('Error', "Email must end in @mail.missouri.edu", 'error')
        return
      }

      if (this.registerPassword != this.checkPass) {
        this.noPasswordMatch = true;
        return;
      } else if (this.registerPassword == this.checkPass) {
        this.noPasswordMatch = false;
      }

      this.$http.post(addUser, postData).then(response => {
        this.$swal('Registration Confirmed', "You can login when an Executive approves your account!", 'success').then((result) => { this.$router.push('/') })
      })


    },
    goHome() {
      this.$router.push('/')
    },
    confirmUser(user) {
      this.$http.post(findUser, user).then(response => {
        if (response.data.length == 0) {
          this.showLoginFail = true

        } else {
          this.showLoginFail = false
          this.userCreds.id = response.data[0].id
          this.userCreds.name = response.data[0].name
          this.userCreds.status = response.data[0].status
          this.userCreds.email = response.data[0].email
          this.userCreds.google_email = response.data[0].google_email
          this.userCreds.noti_email = response.data[0].noti_email
          this.userCreds.dues = response.data[0].dues

          if (response.data[0].major == null)
            this.userCreds.personal_info = 'no'
          else
            this.userCreds.personal_info = 'yes'

          this.$store.dispatch('setUser', this.userCreds).then(response => {
            this.goHome()
          })
        }
        return
      })
    },
    signInWithGoogle() {
      var that = this
      this.$googleAuth().directAccess()
      this.$googleAuth().signIn(function(googleUser) {
        var postData = {
          email: googleUser.w3.U3,
        }
        that.$http.post(signInActiveWithGoogle, postData).then(response => {
          if (response.data.length != 0) {
            that.showLoginFail = false
            that.userCreds.id = response.data[0].id
            that.userCreds.name = response.data[0].name
            that.userCreds.status = response.data[0].status
            that.userCreds.email = response.data[0].email
            that.userCreds.google_email = response.data[0].google_email
            that.userCreds.noti_email = response.data[0].noti_email
            that.userCreds.dues = response.data[0].dues
            if (response.data[0].grad_date == null)
              that.userCreds.personal_info = 'no'
            else
              that.userCreds.personal_info = 'yes'
            that.$store.dispatch('setUser', that.userCreds).then(response => {
              that.goHome()
            })
          } else {
            that.$swal('You need an Alpha Kappa Psi Account First', "Once you have a registered account by an executive, you can go into your settings and link a google account, allowing you access to login this way.", 'error')
          }
        })
      })
    }
  }
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

.input_tags,
#loginPageButton,
#failedTag,
#registerPageButton,
#loginGoogleButton {
  margin-top: 10px;
  width: 100%;
  float: left;
}

#loginBox {
  width: 50%;
  float: left;
  padding: 7px;
}

#registerBox {
  float: left;
  width: 50%;
  padding: 7px;
  border-left: solid #3273dc 5px;
}

#optionsBox {
  height: 300px;
  margin-top: 10px;
}

#failedTag {
  color: #3273dc;
}

#emailTag {
  font-size: 1vw;
  color: #3273dc;
  line-height: 40px;
  margin-top: 15px;
}

</style>
