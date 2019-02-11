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
          <tr v-for="user in users" @click="" :class="[user.dues === 'not payed' ? 'unpaid':'']">
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
import { getSignedUsers, getSingleEvent, getRegisteredUsers } from '../../router/config.js'
window.$ = window.jQuery = require('jquery');

export default {
  data() {
    return {
      id: 0,
      users: [],
      event: {},
    }
  },
  props:{
    eventData
  }
  methods: {
    loadUsers() {
      var that = this
      setTimeout(function() {
        var users = JSON.parse(that.event.signed_users)

        var postData = {
          users: users.id,
          event_id: localStorage.getItem("event"),
          type: 'parse_signed_users'
        }

        that.$http.post(getSignedUsers, postData).then(response => {
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
    this.getEvent()
  },
}

</script>
