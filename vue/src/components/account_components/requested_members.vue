<template>
  <div>
    <div>
      <table class="table">
        <thead>
          <tr>
            <th>
              Name
            </th>
            <th>
              Email
            </th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, index) user in users">
            <th>{{user.name}}</th>
            <td>{{user.email}}
            </td>
            <td>
              <input type="checkbox" id="checkedMember" :value="user.id">
            </td>
          </tr>
          <a @click="addMembers()" class="button is-info" style="margin-top: 15px;">Add Members</a>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
import { getRequestedUsers, addRequestedUsers } from '../../router/config.js'
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
      var allInputs = document.getElementsByTagName("input")
      var checkedInputs = []

      for (var i = 0, max = allInputs.length; i < max; i++) {
        if (allInputs[i].checked == true)
          checkedInputs.push(allInputs[i].value)
      }

      if(checkedInputs.length == 0){
        alert('Please Check the Users.')
        return
      }


      var postData = { id: checkedInputs }

      this.$http.post(addRequestedUsers, postData).then(response => {
        location.reload();
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
