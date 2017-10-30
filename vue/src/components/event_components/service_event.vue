<template>
  <div>
    <i v-show="$store.state.user.status == '1' " @click="showAddEvent = !showAddEvent" id="addEventIcon" class="fa fa-plus-square fa-2x" aria-hidden="true"></i>
    <div v-show="showAddEvent" id="addServiceBox">
      <input v-model="addServiceTitle" class="input is-info" type="text" placeholder="Title...">
      <input v-model="addServiceTime" class="input is-info" type="text" placeholder="Time...">
      <datepicker v-model="addServiceDate" placeholder="Date..." :config="{ dateFormat: 'Y/m/d', static: true }" style="width:280px !important;"></datepicker>
      <input v-model="addServiceLocation" class="input is-info" type="text" placeholder="Location...">
      <input v-model="addMaxUsers" class="input is-info" type="number" placeholder="Max Users...">
      <textarea v-model="addServiceDesc" class="textarea is-info" type="text" placeholder="Description..."></textarea>
      <center><a class="button is-info" @click="addServiceEvent()" style="margin-top: 10px;">Add Event</a></center>
    </div>
    <div id="serviceEventBox" v-for="(event, index) event in events" style="margin-top: 50px;">
      <i v-show="$store.state.user.status == '1'" class="fa fa-minus-square icon_hover" @click="showDeleteServiceEvent(index)" aria-hidden="true"></i>
      <i v-show="$store.state.user.status == '1'" class="fa fa-pencil-square icon_hover" @click="showEditServiceEvent(index)" aria-hidden="true"></i>
      <div id="editServiceEventWrapper">
      <div :id="'editServiceEventBox'+index" style="display: none;">
        <input v-model="event.title" class="input is-info" type="text" placeholder="Title...">
        <input v-model="event.time" class="input is-info" type="text" placeholder="Time...">
        <datepicker v-model="event.date" placeholder="Date..." :config="{ dateFormat: 'Y/m/d', static: true }"></datepicker>
        <input v-model="event.location" class="input is-info" type="text" placeholder="Location...">
        <input v-model="event.max_users" class="input is-info" type="number" placeholder="Max Users...">
        <textarea v-model="event.description" class="textarea is-info" type="text" placeholder="Description..."></textarea>
        <center><a class="button is-info" @click="editServiceEvent(index)" style="margin-top: 10px;">Edit Event</a></center>
      </div>
    </div>
      <div :id="'deleteServiceEventBox'+index" style="display: none;">
        <center>
          <h1>Are you sure you want to delete this event?</h1></center>
        <center><a class="button is-info" @click="deleteServiceEvent(index)" style="margin-top: 10px;">Delete Event</a></center>
      </div>
      <div :id="'serviceEventBox'+index">
        <h1 style="text-align: center; font-size: 16pt;">{{event.title}}</h1>
        <div>
          <hr>
          <h2><b>Time:</b> {{event.time}} on {{event.date}}</h2>
          <hr>
          <h2><b>Date:</b> {{event.date}}</h2>
          <hr>
          <h2><b>Location:</b> {{event.location}}</h2>
          <hr>
          <h2 style="margin-bottom: 12px;"> <b>Description:</b> </h2>
          <p style="height: 150px; overflow: scroll">{{event.description}}</p>
          <hr>
          <center><a v-show="event.is_max_users == false" :id="'serviceSignUpButton'+event.id" :name="event.title" class="button is-info" @click="signUp(index)">Sign Up</a></center>
          <center><a v-show="event.is_max_users == true" style="color:blue">Event Full</a></center>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Datepicker from 'vue-bulma-datepicker'
import { getEvents, addEvent, userSignedEvent, editEvent, deleteEvent } from '../../router/config'

window.$ = window.jQuery = require('jquery');


export default {
  data() {
    return {
      events: [],
      showAddEvent: false,
      showEvent: true,
      showDeleteEvent: false,
      showEditEvent: false,
      addServiceTitle: '',
      addServiceTime: '',
      addServiceDate: '',
      addServiceLocation: '',
      addServiceDesc: '',
      addMaxUsers: '',
    }
  },

  mounted: function() {
    this.getServiceEvents()
  },

  beforeUpdate: function() {
    this.checkSignedIn()
  },

  methods: {
    getServiceEvents() {
      var postData = {
        event_type: "service"
      }
      this.$http.post(getEvents, postData).then(response => {
        var that = this
        response.data.forEach(function(event) {
          var maxUsers = false
          var counted_users = 0
          var parse = JSON.parse(event.signed_users)
          if (parse.id.length != 0) {
            parse.id.forEach(function(user) {
              counted_users++
            })
            if (counted_users == event.max_users) {
              maxUsers = true
            } else {
              maxUsers = false
            }
          }
          var obj = {
            id: event.id,
            title: event.title,
            location: event.location,
            date: event.date,
            time: event.time,
            description: event.description,
            users: JSON.parse(event.signed_users),
            is_max_users: maxUsers,
            max_users: event.max_users
          }
          that.events.push(obj)
        })
      })
    },
    signUp(index) {
      this.events[index].users.id.push(this.$store.state.user.id)

      var postData = {
        id: this.events[index].id,
        signed_users: JSON.stringify(this.events[index].users)
      }
      this.$http.post(userSignedEvent, postData).then(response => {
        if (response.data == 'fail') {
          alert('The Event is Filled')
          location.reload()
        }
      })
    },

    addServiceEvent() {
      var users = { "id": [] }
      var postData = {
        title: this.addServiceTitle,
        location: this.addServiceLocation,
        date: this.addServiceDate,
        time: this.addServiceTime,
        description: this.addServiceDesc,
        event_type: "service",
        month: this.addServiceDate.split("/")[1],
        signed_users: JSON.stringify(users),
        max_users: this.addMaxUsers,
        attended_users: JSON.stringify(users)
      }
      this.$http.post(addEvent, postData).then(response => { location.reload() })
    },

    checkSignedIn() {
      var that = this
      this.events.forEach(function(event) {
        event.users.id.forEach(function(id) {
          if (id == that.$store.state.user.id) {
            $(document).ready(function() {
              $('#serviceSignUpButton' + event.id).hide()
            })
            return
          }
        })
      })
    },

    showEditServiceEvent(index) {
      if ($('#serviceEventBox' + index).css('display') == 'block') {
        $("#editServiceEventBox" + index).show()
        $("#serviceEventBox" + index).hide()
      } else if ($('#serviceEventBox' + index).css('display') == 'none' && $('#deleteServiceEventBox' + index).css('display') == 'none') {
        $("#editServiceEventBox" + index).hide()
        $("#serviceEventBox" + index).show()
      } else if ($('#deleteServiceEventBox' + index).css('display') == 'block' && $('#serviceEventBox' + index).css('display') == 'none') {
        $("#deleteServiceEventBox" + index).hide()
        $("#editServiceEventBox" + index).show()
      }
    },

    showDeleteServiceEvent(index) {
      if ($('#serviceEventBox' + index).css('display') == 'block') {
        $("#deleteServiceEventBox" + index).show()
        $("#serviceEventBox" + index).hide()
      } else if ($('#serviceEventBox' + index).css('display') == 'none' && $('#editServiceEventBox' + index).css('display') == 'none') {
        $("#deleteServiceEventBox" + index).hide()
        $("#serviceEventBox" + index).show()
      } else if ($('#editServiceEventBox' + index).css('display') == 'block' && $('#serviceEventBox' + index).css('display') == 'none') {
        $("#editServiceEventBox" + index).hide()
        $("#deleteServiceEventBox" + index).show()
      }
    },

    editServiceEvent(index) {
      var postData = {
        id: this.events[index].id,
        title: this.events[index].title,
        location: this.events[index].location,
        date: this.events[index].date,
        time: this.events[index].time,
        description: this.events[index].description,
        month: this.events[index].date.split("/")[1],
        max_users: this.events[index].max_users,
      }
      this.$http.post(editEvent, postData).then(response => { location.reload() })
    },

    deleteServiceEvent(index) {
      var postData = {
        id: this.events[index].id
      }
      this.$http.post(deleteEvent, postData).then(response => { location.reload() })
    }

  },

  components: {
    Datepicker,
  },

}

</script>
<style>
#serviceEventBox {
  border: solid #164380 2px;
  border-radius: 10px 10px 10px 10px;
  width: 29.5%;
  margin-left: 40px;
  padding: 10px;
  float: left;
}

#addServiceBox {
  background-color: lightgrey;
  width: 300px;
  position: absolute;
  margin: 40px;
  padding: 10px;
}

#addServiceBox input,
textarea {
  width: 100%;
  margin-top: 10px;
}

#editServiceEventBox {
  padding: 10px;
  background-color: lightgrey;
}

#editServiceEventWrapper input,
textarea {
  width: 100%;
  margin-top: 10px;
}

#deleteServiceEventBox {
  background-color: lightgrey;
  padding: 10px;
}

.flatpickr-month {
  height: 50px !important;
}

#signUpButtons {
  display: inline;
}

#addEventIcon {
  float: left;
  position: absolute;
  margin-top: 10px;
}

#addEventIcon:hover {
  cursor: pointer;
}

.icon_hover:hover {
  cursor: pointer;
}

</style>
