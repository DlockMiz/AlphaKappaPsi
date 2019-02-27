<template>
  <div>
    <center><img id="loading" style="margin-top: 100px;" src="../../assets/images/loading.gif" height="200" width="200"></center>
    <div id="memListWrapper">
      <a style="margin-bottom: 10px;" @click="showExecAddInputs = !showExecAddInputs" class="button is-info">Add Exec Account</a>
      <a style="margin-bottom: 10px;" @click="makePledgesActives()" class="button is-primary">Make All Pledges Actives</a>
      <a style="margin-bottom: 10px;" @click="makeAlumni()" class="button is-danger">Make Selected Users Alumni</a>
      <download-excel :data="users" style="margin-right:8px; float:left;">
        <a style="margin-bottom: 10px;" class="button is-warning">Export Excel</a>
      </download-excel>
      <div style="margin-bottom: 10px;" v-show="showExecAddInputs" class="addExecBox">
        <center>
          <div style="line-height: 55px;">
            <input style="margin-bottom: 10px; margin-top: 10px; width: 63%;" class="input is-info" type="text" name="email" v-model="registerEmail" placeholder="Email..."> <b style="font-size:1vw">@gmail.com</b>
          </div>
        </center>
        <center>
          <input style="margin-bottom: 10px; margin-top: 10px; width: 93%;" class="input is-info" type="text" name="username" v-model="registerName" placeholder="Position Name...">
          <a style="margin-bottom: 10px;" @click="addExecAccount()" class="button is-info">Submit</a>
        </center>
      </div>
      <div>
        <hr>
        <input v-model="search_name" class="input is-info" placeholder="Search Individual" style="width: 20%;">
        <input v-model="search_major" class="input is-info" placeholder="Search Major" style="width: 20%;">
        <hr>
        <table class="table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Major</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th>Graduation Date</th>
              <th>X</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :class="[user.dues === 'not payed' ? 'unpaid':'']">
              <td @click="goToMember(user)">{{user.name}}</td>
              <td @click="goToMember(user)">{{user.major}}</td>
              <td @click="goToMember(user)">{{user.email}}</td>
              <td @click="goToMember(user)">{{user.phone_number}}</td>
              <td @click="goToMember(user)">{{user.grad_date}}</td>
              <td><input type="checkbox" class="checkedUser" :value="user.id"></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>
</template>
<script>
import { getRegisteredUsers, addExecAccount, makePledgesActives, makeAlumni } from '../../router/config.js'
window.$ = window.jQuery = require('jquery');

export default {
  data() {
    return {
      showExecAddInputs: false,
      registerName: null,
      registerEmail: null,
      id: 0,
      all_users: [],
      users: [],
      search_name: null,
      search_major: null
    }
  },
  methods: {
    makePledgesActives() {
      this.$swal({
        title: 'Are you sure?',
        text: "If you're wrong you will have to go back and manually change each person.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.value) {
          this.$http.post(makePledgesActives).then(response => {
            this.$swal('Success', 'All your pledges are now actives!', 'success')
          })
        } else
          return
      })
    },
    loadUsers() {
      $('#loading').show()
      $('#memListWrapper').hide()
      this.$http.post(getRegisteredUsers).then(response => {
        $('#loading').hide()
        $('#memListWrapper').show()
        var that = this
        response.data.forEach(function(user) {
          if (user.status == 1)
            return
          var obj = {
            id: user.id,
            name: user.name,
            email: user.email,
            grad_date: user.grad_date,
            major: JSON.parse(user.major_minor).major[0],
            phone_number: user.phone_number,
            dues: user.dues,
            prof_dev: user.prof_dev,
            service: user.service,
            fundraising: user.fundraising
          }
          that.all_users.push(obj)
        })
        this.users = this.all_users
      })
    },
    goToMember(user) {
      this.$router.push('/account_page/members_list/member_info:' + user.id)
      localStorage.setItem("member", user.id)
      localStorage.setItem('from_event', 'no')
    },
    makeAlumni() {
      var postData = {
        users_id: []
      }
      var users = $('.checkedUser:checkbox:checked')
      var length = $('.checkedUser:checkbox:checked').length
      for (var x = 0; x < length; x++) {
        postData.users_id.push(users[x].value)
      }
      this.$swal({
        title: 'Are you sure?',
        text: "This action can't be undone.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.value) {
          this.$http.post(makeAlumni, postData).then(response => {
            this.$swal('User(s) have been moved to the alumni list.')
          })
        } else
          return
      })
    },
    addExecAccount() {
      if (this.registerName == null || this.registerEmail == null) {
        this.$swal('Uh Oh', 'Please fill in the required fields (Email and Name)', 'error').then((result) => {
          this.loadUsers()
          return
        })
      }
      var postData = {
        email: this.registerEmail + '@gmail.com',
        name: this.registerName
      }
      this.$http.post(addExecAccount, postData).then(response => {
        if (response.data == 200)
          this.$swal('Success!', 'Executive Account has been made!', 'success').then((result) => {
            location.reload()
          })
      })
    },
    exportCSV() {
      console.log(this.users)
    }
  },
  mounted: function() {
    this.loadUsers()
    if (this.$store.state.user.status != 1) {
      alert('Executive Only Page')
      this.$router.push('/account_page')
    }
  },
  watch: {
    search_name: function(name) {
      var that = this
      this.all_users.forEach(function(user) {
        if (user.name == name) {
          that.users = []
          that.users.push(user)
        } else if (name == '')
          that.users = that.all_users
      })
    },
    search_major: function(major) {
      var that = this
      this.all_users.forEach(function(user) {
        if (user.major == major) {
          that.users = []
          that.users.push(user)
        } else if (major == '')
          that.users = that.all_users
      })
    }
  }
}

</script>
<style>
.addExecBox {
  background-color: lightgrey;
  width: 30%;
}

.unpaid {
  background-color: #ffaaaa;
}

</style>
