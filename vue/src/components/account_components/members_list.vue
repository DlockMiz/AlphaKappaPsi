<template>
  <div>
    <center><img id="loading" style="margin-top: 100px;" src="../../assets/images/loading.gif" height="200" width="200"></center>    
    <div id="memListWrapper">
      <a style="margin-bottom: 10px;" @click="showExecAddInputs = !showExecAddInputs" class="button is-info">Add Exec Account</a>
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
        <vue-good-table :columns="columns" :rows="users" :paginate="true" :lineNumbers="true" :onClick="viewUser" />
      </div>
    </div>
  </div>
</template>
<script>
import { getRegisteredUsers, addExecAccount } from '../../router/config.js'
window.$ = window.jQuery = require('jquery');

export default {
  data() {
    return {
      showExecAddInputs: false,
      registerName: null,
      registerEmail: null,
      viewUser: function(row, index) {
        this.$router.push('/account_page/members_list/member_info:' + row.id)
        localStorage.setItem("member", row.id)
      },
      id: 0,
      users: [],
      columns: [{
          label: 'Name',
          field: 'name',
          filterable: true,
        },
        {
          label: 'Email',
          field: 'email',
          type: 'email',
          filterable: true,
        },
        {
          label: 'Status',
          field: 'status',
          type: 'name',
          filterable: true,
        },
      ],
    }
  },
  methods: {
    loadUsers() {
      $('#loading').show()
      $('#memListWrapper').hide()
      this.$http.post(getRegisteredUsers).then(response => {
        $('#loading').hide()
        $('#memListWrapper').show()
        var that = this
        response.data.forEach(function(user) {
          var status
          switch (user.status) {
            case '1':
              status = 'Executive'
              break;
            case '2':
              status = 'Active'
              break;
            case '3':
              status = 'Pledge'
              break;
          }
          var obj = {
            id: user.id,
            name: user.name,
            email: user.email,
            status: status,
            joined: user.created_at
          }
          that.users.push(obj)
        })
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
    }
  },
  mounted: function() {
    this.loadUsers()
    if (this.$store.state.user.status != 1) {
      alert('Executive Only Page')
      this.$router.push('/account_page')
    }
  }
}

</script>
<style>
.addExecBox {
  background-color: lightgrey;
  width: 30%;
}

</style>
