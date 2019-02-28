<template>
  <div>
    <center><img id="loading" style="margin-top: 100px;" src="../../assets/images/loading.gif" height="200" width="200"></center>
    <div id="memListWrapper">
      <download-excel :data="users" style="margin-right:8px;">
        <a style="margin-bottom: 10px;" class="button is-warning">Export Excel</a>
        <a style="margin-bottom: 10px;" class="button is-danger">Delete Alumni</a>        
      </download-excel>
      <div>
        <hr>
        <input v-model="search_name" class="input is-info" placeholder="Search Individual" style="width: 20%;">
        <input v-model="search_major" class="input is-info" placeholder="Search Major" style="width: 20%;">
        <input v-model="search_grad" class="input is-info" placeholder="Search Graduation(YYYY-MM)" style="width: 20%;">        
        <hr>
        <table class="table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Major</th>
              <th>Phone Number</th>
              <th>Graduation Date</th>                         
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :class="[user.dues === 'not payed' ? 'unpaid':'']">
              <td>{{user.name}}</td>
              <td>{{user.major}}</td>
              <td>{{user.phone_number}}</td>
              <td>{{user.grad_date}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>
</template>
<script>
import { getAlumni, } from '../../router/config.js'
window.$ = window.jQuery = require('jquery');

export default {
  data() {
    return {
      id: 0,
      all_users: [],
      users: [],
      search_name: null,
      search_major: null,
      search_grad: null
    }
  },
  methods: {
    loadUsers() {
      $('#loading').show()
      $('#memListWrapper').hide()
      this.$http.post(getAlumni).then(response => {
        $('#loading').hide()
        $('#memListWrapper').show()
        var that = this
        response.data.forEach(function(user) {
          if (user.status == 1)
            return
          var obj = {
            id: user.id,
            name: user.name,
            grad_date: user.grad_date,
            major: JSON.parse(user.major_minor).major[0],
            phone_number: user.phone_number
          }
          that.all_users.push(obj)
        })
        this.users = this.all_users
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
    },
    search_grad: function(date) {
      var that = this
      that.users = []
      this.all_users.forEach(function(user) {
        var new_date = user.grad_date.substring(0, 7)
        if (new_date == date) {
          that.users.push(user)
        } else if (date == '') {
          that.users = that.all_users
        }
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
