<template>
  <div>
    <a href="#/account_page/past_event_viewer"><i class="fa fa-angle-left fa-1x" aria-hidden="true"> Back</i></a>
    <div>
      <table class="table" style="border: black solid 5px;">
        <thead>
          <tr>
            <th>Users</th>
            <th>Email</th>
            <th>Phone Number</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, index) user in users" :id="'attended_user'+user.id">
            <td>{{users[index].name}}</td>
            <td>{{users[index].noti_email}}</td>
            <td>{{users[index].phone_number}}</td>
          </tr>
        </tbody>
      </table>
      <hr>
    </div>
  </div>
</template>
<script>
import { getSingleEvent, getSignedUsers } from '../../router/config.js'
export default {
  data() {
    return {
      id: 0,
      event: {},
      users: [],
    }
  },
  methods: {
    loadUsers() {
      var users = JSON.parse(this.event.signed_users)

      var postData = {
        users: users.id,
        event_id: localStorage.getItem("event"),
        type: ''
      }

      this.$http.post(getSignedUsers, postData).then(response => {
        var that = this
        response.data.forEach(function(user) {
          var obj = {
            id: user.id,
            name: user.name,
            email: user.email,
            noti_email: user.noti_email,
            phone_number: user.phone_number
          }
          that.users.push(obj)
        })
      })
    },
    gotToProfile(id) {
      this.$router.push('/account_page/members_list/member_info:' + id)
      localStorage.setItem('from_event', id)
    },
    getEvent() {
      this.$http.post(getSingleEvent, this.id).then(response => {
        this.event = response.data[0]
        if (this.event.completed == 1) {
          this.showCompleteEvent = false
        }
        var that = this
        this.loadUsers()
      })
    },
  },
  mounted: function() {
    this.id = localStorage.getItem("event")
    this.getEvent()
  },
}

</script>
