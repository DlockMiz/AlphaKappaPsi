<template>
  <div>
    <div style="overflow: auto;">
      <a href="#/account_page/exec_event_viewer"><i class="fa fa-angle-left fa-1x" aria-hidden="true"> Back</i></a>
      <a class="button is-info" style="margin-left: 20px;" @click="completeEvent()">Complete Event</a>
      <a class="button is-warning" style="margin-left: 20px;" @click="replaceMembers()">Replace Two Memebers</a>
      <a class="button is-warning" style="margin-left: 20px;" @click="resetAttendedList()">Reset Attended List</a>
    </div>
    <div v-show="showReplaceMembersBox">
      <div class="listBox" @click="changeDisplayName()">
        <replace_members_list_one></replace_members_list_one>
      </div>
      <div class="listBox" @click="changeDisplayName()">
        <replace_members_list_two></replace_members_list_two>
      </div>
      <div id="testBox" style="padding-top: 90px;">
        Switch <strong id="mem1"></strong> with <strong id="mem2"></strong> for <strong>This Event</strong>
      </div>
      <a class="button is-info" @click="replaceSelectedMembers()">Replace Member</a>
    </div>
    <center><img id="loading" style="margin-top: 100px;" src="../../assets/images/loading.gif" height="200" width="200"></center>
    <div id="tableWrapper" style="min-width: 1300px; float:left;">
      <div style="float:left;">
        <table class="table">
          <thead>
            <tr>
              <th>Signed Users</th>
              <th>Email</th>
              <th>Attended</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(user, index) user in users" :id="'attended_user'+index">
              <td>{{users[index].name}}</td>
              <td>{{users[index].email}}</td>
              <td><a @click="attendedUser(index)" class="button is-primary">Y</a>
                <a @click="noAttendance(index)" class="button is-danger">N</a></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div style="float: left; margin-left: 50px;">
        <table class="table">
          <thead>
            <tr>
              <th>Attended Users</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(attend, index) attend in attends">
              <td>{{attends[index].name}}</td>
              <td>
                <button @click="change('attend', index)">Switch</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div style="float: left; margin-left: 100px;">
        <table class="table">
          <thead>
            <tr>
              <th>Non Attended Users</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(non_attend, index) non_attend in non_attends">
              <td>{{non_attends[index].name}}</td>
              <td>
                <button @click="change('non_attend', index)">Switch</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>
</template>
<script>
window.$ = window.jQuery = require('jquery');

import replace_members_list_one from './replace_members_list_one'
import replace_members_list_two from './replace_members_list_two'
import { getSingleEvent, getSignedUsers, attendUser, switchAttendance, setPastEvent, fufillRequirement, clearAttendees, switchUsers } from '../../router/config.js'

export default {
  data() {
    return {
      id: 0,
      event: {},
      users: [],
      attends: [],
      non_attends: [],
      showReplaceMembersBox: false,
    }
  },
  components: {
    replace_members_list_one,
    replace_members_list_two,
  },
  methods: {
    getEvent() {
      $('#loading').show()
      this.$http.post(getSingleEvent, this.id).then(response => {
        this.event = response.data[0]
        if (this.event.completed == 1) {
          this.showCompleteEvent = false
        }
        this.loadAttended()
        this.loadUsers()
      })
    },
    changeDisplayName() {
      setTimeout(function() {
        document.getElementById("mem1").innerHTML = localStorage.getItem("replace_member_one")
        document.getElementById("mem2").innerHTML = localStorage.getItem("replace_member_two")
      }, 200)
    },
    loadUsers() {
      var users = JSON.parse(this.event.signed_users)

      var postData = {
        users: users.id,
        event_id: localStorage.getItem("event"),
        type: 'parse_signed_users'
      }

      this.$http.post(getSignedUsers, postData).then(response => {
        $('#loading').hide()
        $('#tableWrapper').show()
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
    loadAttended() {
      var attended_users = JSON.parse(this.event.attended_users)
      var non_attended_users = JSON.parse(this.event.non_attended_users)

      var postData = {
        users: attended_users.id
      }
      var postData2 = {
        users: non_attended_users.id
      }
      this.$http.post(getSignedUsers, postData).then(response => {
        var that = this
        response.data.forEach(function(user) {

          var obj = {
            id: user.id,
            name: user.name,
            email: user.email
          }
          that.attends.push(obj)
        })
      })
      this.$http.post(getSignedUsers, postData2).then(response => {
        var that = this
        response.data.forEach(function(user) {
          var obj = {
            id: user.id,
            name: user.name,
            email: user.email
          }
          that.non_attends.push(obj)
        })
      })
    },
    noAttendance(index) {
      var users = { "id": [] }

      this.non_attends.push(this.users[index])
      this.non_attends.forEach(function(user) {
        users.id.push(user.id)
      })

      var postData = {
        users: JSON.stringify(users),
        event_id: localStorage.getItem("event"),
        type: 'non_attend'
      }
      this.$http.post(attendUser, postData).then(response => {})
      this.clearUser(index)
    },
    attendedUser(index) {
      var users = { "id": [] }

      this.attends.push(this.users[index])
      this.attends.forEach(function(user) {
        users.id.push(user.id)
      })

      var postData = {
        users: JSON.stringify(users),
        event_id: localStorage.getItem("event"),
        type: 'attend'
      }
      this.$http.post(attendUser, postData).then(response => {})
      this.clearUser(index)
    },
    change(type, index) {
      var att_users = { "id": [] }
      var non_att_users = { "id": [] }

      if (type == 'attend') {
        this.non_attends.push(this.attends[index])
        this.attends.splice(index, 1)
        this.non_attends.forEach(function(user) {
          non_att_users.id.push(user.id)
        })
        this.attends.forEach(function(user) {
          att_users.id.push(user.id)
        })

        var postData = {
          non_att_users: JSON.stringify(non_att_users),
          att_users: JSON.stringify(att_users),
          event_id: localStorage.getItem("event"),
        }
        this.$http.post(switchAttendance, postData).then(response => {})

      } else if (type == 'non_attend') {
        this.attends.push(this.non_attends[index])
        this.non_attends.splice(index, 1)
        this.non_attends.forEach(function(user) {
          non_att_users.id.push(user.id)
        })
        this.attends.forEach(function(user) {
          att_users.id.push(user.id)
        })
        var postData = {
          non_att_users: JSON.stringify(non_att_users),
          att_users: JSON.stringify(att_users),
          event_id: localStorage.getItem("event"),
        }
        this.$http.post(switchAttendance, postData).then(response => {})
      }
    },
    clearUser(index) {
      this.users.splice(index, 1)
    },

    completeEvent() {
      var postData = {
        event_id: localStorage.getItem("event"),
      }
      this.$http.post(setPastEvent, postData).then(response => {
        this.$router.push('/account_page/exec_event_viewer')
      })

      var postData2 = {
        attended_users: this.attends,
        event: this.event,
        hours: this.event.hours
      }
      this.$http.post(fufillRequirement, postData2).then(response => {})
    },

    replaceMembers() {
      this.showReplaceMembersBox = !this.showReplaceMembersBox
    },
    replaceSelectedMembers() {
      var postData = {
        id_one: localStorage.getItem('replace_member_one_id'),
        id_two: localStorage.getItem('replace_member_two_id'),
        event_id: localStorage.getItem("event")
      }

      if (postData.id_one == postData.id_two) {
        this.$swal('Error', 'The two people you selcted are the same.', 'error')
        return
      }

      this.$http.post(switchUsers, postData).then(response => {
        if (response.data == 200) {
          this.$swal('Error', 'This person is already signed up for this event!', 'error')
          return
        } else {
          $('#loading').show()
          $('#tableWrapper').hide()
          this.users = [];
          this.getEvent()
        }
      })
    },
    resetAttendedList() {
      $('#loading').show()
      $('#tableWrapper').hide()

      this.attends = null
      this.non_attends = null

      var postData = {
        event_id: localStorage.getItem("event")
      }

      this.$http.post(clearAttendees, postData).then(response => {
        this.users = [];
        this.loadUsers()
      })
    }
  },

  mounted: function() {
    $('#tableWrapper').hide()
    this.id = localStorage.getItem("event")
    this.getEvent()
  },
}

</script>
<style>
.editUserInfo {
  display: none;
  width: 20%;
}

.editUserInfo select {
  width: 100%;
}

.listBox {
  float: left;
  margin: 10px;
  height: 200px;
  overflow: auto;
  border: 3px black solid;
}

</style>
