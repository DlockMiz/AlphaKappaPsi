<template>
  <div>
    <center><img id="loading" style="margin-top: 100px;" src="../../assets/images/loading.gif" height="200" width="200"></center>
    <div id="eventWrapper">
      <table class="table">
        <thead>
          <tr>
            <th>
              Name
            </th>
            <th>
              Email
            </th>
            <th>
              Add
            </th>
            <th>
              Remove
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, index) user in users">
            <th>{{user.name}}</th>
            <td>{{user.email}}
            </td>
            <td>
              <center>
                <input :name="'request'+index" type="radio" class="addMember" :value="user.id">
              </center>
            </td>
            <td>
              <center>
                <input :name="'request'+index" type="radio" class="removeMember" :value="user.id">
              </center>
            </td>
          </tr>
          <a @click="addMembers()" class="button is-info" style="margin-top: 15px;">Add and Remove Members</a>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
import { getRequestedUsers, addRequestedUsers, removeRequestedUsers } from '../../router/config.js'
window.$ = window.jQuery = require('jquery');

export default {
  data() {
    return {
      users: [],
    }
  },
  methods: {
    loadUsers() {
      this.$http.post(getRequestedUsers).then(response => {
        $('#loading').hide()
        $('#eventWrapper').show()
        var that = this
        response.data.forEach(function(user) {
          var obj = {
            id: user.id,
            name: user.name,
            email: user.email
          }
          that.users.push(obj)
        })
      })
    },
    addMembers() {
      this.removeMemebers()
      var allInputs = document.getElementsByClassName("addMember")
      var checkedInputs = []

      for (var i = 0, max = allInputs.length; i < max; i++) {
        if (allInputs[i].checked == true) {
          checkedInputs.push(allInputs[i].value)
        }
      }

      if (checkedInputs.length == 0) {
        alert('Please Check the Users.')
        return
      }

      var postData = { id: checkedInputs }
      this.$http.post(addRequestedUsers, postData).then(response => {})
    },
    removeMemebers() {
      var allInputs = document.getElementsByClassName("removeMember")
      var checkedInputs = []

      for (var i = 0, max = allInputs.length; i < max; i++) {
        if (allInputs[i].checked == true) {
          checkedInputs.push(allInputs[i].value)
        }
      }
      var postData = { id: checkedInputs }
      if (confirm("Are you sure you want to do this, this action cannot be undone.")) {
        this.$http.post(removeRequestedUsers, postData).then(response => {
          location.reload();
        })
      }
    }
  },
  mounted: function() {
    $('#loading').show()
    $('#eventWrapper').hide()
    this.loadUsers()
    if (this.$store.state.user.status != 1) {
      alert('Executive Only Page')
      this.$router.push('/account_page')
    }
  }
}

</script>
