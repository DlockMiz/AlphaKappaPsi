<template>
  <div>
    <center><a href="/"> <img src="../assets/images/akp_logo.png" alt="" style="height: 100px; margin-top: 100px;"> </a></center>
    <center>
      <div style="width: 50%;">
        <input style="margin-bottom: 20px;" class="input is-info input_tags" type="text" name="pass1" v-model="first_password" placeholder="Enter New Password">
        <input style="margin-bottom: 20px;" class="input is-info input_tags" type="password" name="pass2" v-model="second_password" placeholder="Re-enter Password">
        <a id="submitPasswordReset" @click="changePassword" class="button is-info inputs">Change Password</a>
      </div>
    </center>
  </div>
</template>
<script>
import { changePassword } from '../router/config'

export default {
  data() {
    return {
      token: null,
      first_password: null,
      second_password: null
    }
  },
  methods: {
    changePassword() {
      if (this.first_password != this.second_password) {
        this.$swal('Error!', 'Your Passwords must match!', 'error')
        return
      }

      var postData = {
        token: this.token,
        first_password: this.first_password
      }
      this.$http.post(changePassword, postData).then(response => {
        this.$swal('Success', 'Your password is now reset, go try again!', 'success').then((result) => {
          this.$router.push('/login')
        })
      })
    }
  },
  mounted() {
    this.token = window.location.href.split('password_reset/')[1]
  }
}

</script>
