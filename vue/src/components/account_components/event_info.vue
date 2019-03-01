<template>
  <div>
    <a href="#/account_page/exec_event_viewer"><i class="fa fa-angle-left fa-1x" aria-hidden="true"> Back</i></a>
    <center>
      <div>
        <a class="button is-primary" style="margin-left: 20px;" @click="completeEvent()">Complete Event</a>
        <a class="button is-warning" style="margin-left: 20px;" @click="sendEmails()">Send Emails</a>
        <a class="button is-danger" style="margin-left: 20px;" @click="markPriority()">Mark as High Priority</a>
        <a class="button is-info" style="margin-left: 20px;" @click="addPerson()">Add Person</a>
      </div>
    </center>
    <center>
      <div v-if="showReplaceMembersBox">
        <div class="listBox">
          <replace_members_list_two :eventData="eventData"></replace_members_list_two>
        </div>
      </div>
    </center>
    <center><img id="loading" style="margin-top: 100px;" src="../../assets/images/loading.gif" height="200" width="200"></center>
    <center>
      <div id="tableWrapper">
        <div>
          <table class="table" style="border: black solid 5px;">
            <thead>
              <tr>
                <th>Remove User</th>
                <th>Signed Users</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Attended</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(user, index) user in users" :id="'attended_user'+user.id">
                <td>
                  <center><a @click="removeUser(user.id)" class="button is-danger">-</a></center>
                </td>
                <td @click="gotToProfile(user.id)">{{users[index].name}}</td>
                <td @click="gotToProfile(user.id)">{{users[index].noti_email}}</td>
                <td @click="gotToProfile(user.id)">{{users[index].phone_number}}</td>
                <td><a @click="placeUser('attended',user.id)" class="button is-primary">Y</a>
                  <a @click="placeUser('not_attended',user.id)" class="button is-danger">N</a>
                </td>
              </tr>
            </tbody>
          </table>
          <hr>
        </div>
        <center>
          <div v-for="(req,index) req in switches" class="switchRequest">
            {{req.name}} is requesting to switch out!
            <div>
              <a class="button is-primary" @click="requestChange('approve',switch_ids[index].id,index)">Approve</a>
              <a class="button is-danger" @click="requestChange('deny',switch_ids[index].id,index)">Deny</a>
            </div>
          </div>
        </center>
      </div>
    </center>
  </div>
</template>
<script>
window.$ = window.jQuery = require('jquery');

import replace_members_list_two from './replace_members_list_two'
import { getSingleEvent, getSignedUsers, attendUser, switchAttendance, setPastEvent, fufillRequirement, switchUsers, sendSignedUsersEmail, fundraisingSwithcRequests, changeRequest, markPriority, removeUserFromEvent } from '../../router/config.js'

export default {
  data() {
    return {
      id: 0,
      event: {},
      users: [],
      attends: [],
      non_attends: [],
      switch_ids: [],
      switches: [],
      showReplaceMembersBox: false,
      eventData: null
    }
  },
  components: {
    replace_members_list_two,
  },
  methods: {
    removeUser(user_id) {
      var postData = {
        user_id: user_id,
        event_id: this.id
      }
      var that = this
      this.$http.post(removeUserFromEvent, postData).then(response => {
        if (response.data == 100) {
          this.$swal('Removed!', 'This user is new removed from the event', 'success').then((response) => {
            location.reload()
          })
        }
      })
    },
    addPerson() {
      this.eventData = this.id
      this.showReplaceMembersBox = !this.showReplaceMembersBox;
    },
    markPriority() {
      var postData = {
        id: this.id,
      }
      this.$http.post(markPriority, postData).then(response => {
        this.$swal('Marked!', 'This event is now marked as high priority!', 'success').then(
          this.getEvent()
        )
      })
    },
    requestChange(type, id, index) {
      if (type == 'approve') {
        var postData = {
          id: id,
          type: 'approve'
        }
        this.$http.post(changeRequest, postData).then(response => {
          this.$swal('Success!', 'Switch Request Approved', 'success')
        })
      } else if (type == 'deny') {
        var postData = {
          id: id,
          type: 'deny'
        }
        this.$http.post(changeRequest, postData).then(response => {
          this.$swal('Success!', 'Switch Request Denied', 'success')
        })
      }
      this.switches.splice(index, 1)
    },
    sendEmails() {
      const { value: text } = this.$swal({
        input: 'textarea',
        inputPlaceholder: 'Type your message here...',
        showCancelButton: true
      }).then(value => {
        var postData = {
          users: this.users,
          event: this.event,
          custom_message: value.value
        }
        this.$http.post(sendSignedUsersEmail, postData).then(response => {
          this.$swal('Nice!', 'Email Successfully Sent!', 'success')
        })
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
      localStorage.setItem('member', id)

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
        if (response.data == 500)
          return
        this.switches = response.data[0]
        this.switch_ids = response.data[1]
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
      this.$swal({
        title: 'Are you sure?',
        text: "This will give everyone that has attended points.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.value) {
          this.$http.post(setPastEvent, postData).then(response => {
            this.$router.push('/account_page/exec_event_viewer')
          })
          var postData2 = {
            attended_users: this.attends,
            event: this.event,
            hours: this.event.hours
          }
          this.$http.post(fufillRequirement, postData2).then(response => {})
        } else
          return
      })
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
  margin: 10px;
  height: 200px;
  overflow: auto;
  border: 3px black solid;
  width: 50%;
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
