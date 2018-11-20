<template>
  <div>
    <a href="#/account_page/exec_event_viewer"><i class="fa fa-angle-left fa-1x" aria-hidden="true"> Back</i></a>
    <center>
      <div>
        <a class="button is-info" style="margin-left: 20px;" @click="completeEvent()">Complete Event</a>
        <a class="button is-info" style="margin-left: 20px;" @click="replaceMembers()">Replace Two Memebers</a>
        <a class="button is-info" style="margin-left: 20px;" @click="sendEmails()">Send Emails</a>
      </div>
    </center>
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
      <center>
        <div id="tableWrapper">
          <div>
            <table class="table" style="border: black solid 5px;">
              <thead>
                <tr>
                  <th>Signed Users</th>
                  <th>Email</th>
                  <th>Phone Number</th>
                  <th>Attended</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(user, index) user in users" :id="'attended_user'+user.id">
                  <td @click="gotToProfile(user.id)">{{users[index].name}}</td>
                  <td @click="gotToProfile(user.id)">{{users[index].noti_email}}</td>
                  <td @click="gotToProfile(user.id)">{{users[index].phone_number}}</td>
                  <td><a @click="placeUser('attended',user.id)" class="button is-primary">Y</a>
                    <a @click="placeUser('not_attended',user.id)" class="button is-danger">N</a></td>
                </tr>
              </tbody>
            </table>
            <hr>
          </div>
          <center>
            <div v-for="req in switches" class="switchRequest">
              {{req.name}} is requesting to switch out!
              <div>
                <a class="button is-primary" @click="requestChange('approve')">Approve</a>
                <a class="button is-danger" @click="requestChange('deny')">Deny</a>
              </div>
            </div>
          </center>
        </div>
      </center>
  </div>
</template>
<script>
window.$ = window.jQuery = require('jquery');

import replace_members_list_one from './replace_members_list_one'
import replace_members_list_two from './replace_members_list_two'
import { getSingleEvent, getSignedUsers, attendUser, switchAttendance, setPastEvent, fufillRequirement, switchUsers, sendSignedUsersEmail, fundraisingSwithcRequests, changeRequest } from '../../router/config.js'

export default {
  data() {
    return {
      id: 0,
      event: {},
      users: [],
      attends: [],
      non_attends: [],
      switches: [],
      showReplaceMembersBox: false,
    }
  },
  components: {
    replace_members_list_one,
    replace_members_list_two,
  },
  methods: {
    requestChange(type) {
      if (type == 'approve') {
        var postData = {
          id: localStorage.getItem("event"),
          type: 'approve'
        }
        this.$http.post(changeRequest, postData).then(response => {})
      } else if (type == 'deny') {
        var postData = {
          id: localStorage.getItem("event"),
          type: 'deny'
        }
        this.$http.post(changeRequest, postData).then(response => {})
      }
    },
    sendEmails() {
      var postData = {
        users: this.users,
        event: this.event
      }
      this.$http.post(sendSignedUsersEmail, postData).then(response => {
        console.log(response.data)
      })
    },
    getEvent() {
      $('#loading').show()
      this.$http.post(getSingleEvent, this.id).then(response => {
        this.event = response.data[0]
        if (this.event.completed == 1) {
          this.showCompleteEvent = false
        }
        var that = this
        setTimeout(function() {
          that.loadAttended()
        }, 2000)
        this.loadUsers()
      })
    },
    gotToProfile(id) {
      this.$router.push('/account_page/members_list/member_info:' + id)
      localStorage.setItem('from_event', id)
    },
    changeDisplayName() {
      setTimeout(function() {
        document.getElementById("mem1").innerHTML = localStorage.getItem("replace_member_one")
        document.getElementById("mem2").innerHTML = localStorage.getItem("replace_member_two")
      }, 200)
    },
    loadSwitchRequests() {
      var postData = {
        event_id: localStorage.getItem("event")
      }
      this.$http.post(fundraisingSwithcRequests, postData).then(response => {
        this.switches = response.data
      })
    },
    loadUsers() {
      var users = JSON.parse(this.event.signed_users)

      var postData = {
        users: users.id,
        event_id: localStorage.getItem("event"),
        type: 'parse_signed_users'
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
    loadAttended() {
      var attended_users = JSON.parse(this.event.attended_users)
      var non_attended_users = JSON.parse(this.event.non_attended_users)
      var that = this

      var postData = {
        users: attended_users.id
      }
      var postData2 = {
        users: non_attended_users.id
      }
      this.$http.post(getSignedUsers, postData).then(response => {
        var that = this
        response.data.forEach(function(user) {
          that.attends.push(user.id)
        })
      })
      this.$http.post(getSignedUsers, postData2).then(response => {
        var that = this
        response.data.forEach(function(user) {
          that.non_attends.push(user.id)
        })
      })
    },
    colorRows() {
      var that = this
      $('#loading').hide()
      $('#tableWrapper').show()
      this.users.forEach(function(user) {
        that.attends.forEach(function(id) {
          if (user.id == id)
            document.getElementById('attended_user' + user.id).style.backgroundColor = '#96f0e0'
        })
        that.non_attends.forEach(function(id) {
          if (user.id == id)
            document.getElementById('attended_user' + user.id).style.backgroundColor = '#ffb4c3'
        })
      })
    },
    placeUser(type, id) {
      var allUserIds = []
      this.users.forEach(function(user) {
        allUserIds.push(user.id)
      })

      if (type == 'attended') {
        document.getElementById('attended_user' + id).style.backgroundColor = '#96f0e0'
        if (!this.attends.includes(id)) {
          this.attends.push(id)
          if (this.non_attends.includes(id)) {
            var index = this.non_attends.indexOf(id)
            this.non_attends.splice(index, id)
          }
          var postData = {
            event_id: localStorage.getItem('event'),
            att_users: JSON.stringify({ id: this.attends }),
            non_att_users: JSON.stringify({ id: this.non_attends })
          }
          this.$http.post(switchAttendance, postData).then(response => {})
        }
      } else if (type == 'not_attended') {
        document.getElementById('attended_user' + id).style.backgroundColor = '#ffb4c3'
        if (!this.non_attends.includes(id)) {
          this.non_attends.push(id)
          if (this.attends.includes(id)) {
            var index = this.attends.indexOf(id)
            this.attends.splice(index, id)
          }
          var postData = {
            event_id: localStorage.getItem('event'),
            att_users: JSON.stringify({ id: this.attends }),
            non_att_users: JSON.stringify({ id: this.non_attends })
          }
          this.$http.post(switchAttendance, postData).then(response => {})
        }
      }

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
    this.loadSwitchRequests()
    setTimeout(this.colorRows, 5000)
  },
}

</script>
<style>
.listBox {
  float: left;
  margin: 10px;
  height: 200px;
  overflow: auto;
  border: 3px black solid;
}

#tableWrapper {
  width: 80%;
  margin-top: 30px;
}


.switchRequest {
  border: solid black 5px;
  width: 30%;
  padding: 10px;
}

</style>
