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
      var allInputs1 = document.getElementsByClassName("addMember")
      var allInputs2 = document.getElementsByClassName("removeMember")

      var checkedInputs1 = []
      var checkedInputs2 = []


      for (var i = 0, max = allInputs1.length; i < max; i++) {
        if (allInputs1[i].checked == true) {
          checkedInputs1.push(allInputs1[i].value)
        }
      }
      for (var i = 0, max = allInputs2.length; i < max; i++) {
        if (allInputs2[i].checked == true) {
          checkedInputs2.push(allInputs2[i].value)
        }
      }

      var postData1 = { id: checkedInputs1 }
      var postData2 = { id: checkedInputs2 }

      if (checkedInputs1.length == 0 && checkedInputs2.length == 0) {
        alert('Please Check the Users.')
        return
      }
      this.$swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.value) {
          this.$http.post(addRequestedUsers, postData1).then(response => {
            this.users = []
            this.loadUsers()
          })
          this.$http.post(removeRequestedUsers, postData2).then(response => {})
        }
      })

    },
    removeMembers() {
      var allInputs = document.getElementsByClassName("removeMembers")
      var checkedInputs = []

      for (var i = 0, max = allInputs.length; i < max; i++) {
        if (allInputs[i].checked == true) {
          checkedInputs.push(allInputs[i].value)
        }
      }
      var postData = { id: checkedInputs }
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
