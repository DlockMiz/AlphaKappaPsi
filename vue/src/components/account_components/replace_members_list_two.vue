<template>
  <div>
    <div>
      <table class="table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Major</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Graduation Date</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" @click="userSignedEvent(user)" :class="[user.dues === 'not payed' ? 'unpaid':'']">
            <td>{{user.name}}</td>
            <td>{{user.major}}</td>
            <td>{{user.email}}</td>
            <td>{{user.phone_number}}</td>
            <td>{{user.grad_date}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
import { getSingleEvent, getRegisteredUsers, forceAddUser } from '../../router/config.js'
window.$ = window.jQuery = require('jquery');

export default {
  data() {
    return {
      users: [],
    }
  },
  props: ['eventData'],
  methods: {
    userSignedEvent(user) {
      var postData = {
        id: user.id,
        event: this.eventData,
      }
      this.$swal({
        title: 'Are you sure you want to add ' + user.name + '?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.value) {
          this.$http.post(forceAddUser, postData).then(response => {
            if(response.data == 300){
              this.$swal('Nope', user.name+' is already signed up!', 'error')
              return
            }
            this.$swal('Success', user.name+' is now signed up for this event.', 'success')
          })
        }
      })
    },
    loadUsers() {
      var that = this
      setTimeout(function() {
        that.$http.post(getRegisteredUsers).then(response => {
          response.data.forEach(function(user) {
            var obj = {
              id: user.id,
              name: user.name,
            }
            that.users.push(obj)
          })
        })
      }, 1500)
    }
  },
  mounted: function() {
    this.loadUsers()
  },
}

</script>
