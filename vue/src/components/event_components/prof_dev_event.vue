<template>
  <div>
    <div>
      If you cannot create a customized event, please use the master doc <a>here</a>.
    </div>
    <i v-show="$store.state.user.status == '1' " @click="showAddEvent = !showAddEvent" id="addEventIcon" class="fa fa-plus-square fa-2x" aria-hidden="true"></i>
    <div v-show="showAddEvent" id="addServiceBox">
      <input v-model="addProfTitle" class="input is-info" type="text" placeholder="Title...">
      <input v-model="addProfTime" class="input is-info" type="text" placeholder="Time...">
      <datepicker v-model="addProfDate" placeholder="Date..." :config="{ dateFormat: 'Y/m/d', static: true }" style="width:280px !important;"></datepicker>
      <input v-model="addProfLocation" class="input is-info" type="text" placeholder="Location...">
      <input v-model="addMaxUsers" class="input is-info" type="number" placeholder="Max Users...">
      <textarea v-model="addProfDesc" class="textarea is-info" type="text" placeholder="Description..."></textarea>
      <center><a class="button is-info" @click="addProfEvent()" style="margin-top: 10px;">Add Event</a></center>
    </div>
    <div id="profDevEventBox" v-for="(event, index) event in events" style="margin-top: 50px;">
      <i v-show="$store.state.user.status == '1'" class="fa fa-minus-square icon_hover" @click="showDeleteProfEvent(index)" aria-hidden="true"></i>
      <i v-show="$store.state.user.status == '1'" class="fa fa-pencil-square icon_hover" @click="showEditProfEvent(index)" aria-hidden="true"></i>
      <div id="editProfEventWrapper">
        <div :id="'editProfEventBox'+index" style="display: none;">
          <input v-model="event.title" class="input is-info" type="text" placeholder="Title...">
          <input v-model="event.time" class="input is-info" type="text" placeholder="Time...">
          <datepicker v-model="event.date" placeholder="Date..." :config="{ dateFormat: 'Y/m/d', static: true }"></datepicker>
          <input v-model="event.location" class="input is-info" type="text" placeholder="Location...">
          <input v-model="event.max_users" class="input is-info" type="number" placeholder="Max Users...">
          <textarea v-model="event.description" class="textarea is-info" type="text" placeholder="Description..."></textarea>
          <center><a class="button is-info" @click="editProfEvent(index)" style="margin-top: 10px;">Edit Event</a></center>
        </div>
      </div>
      <div :id="'deleteProfEventBox'+index" style="display: none;">
        <center>
          <h1>Are you sure you want to delete this event?</h1></center>
        <center><a class="button is-info" @click="deleteProfEvent(index)" style="margin-top: 10px;">Delete Event</a></center>
      </div>
      <div :id="'profDevEventBox'+index">
        <h1 style="text-align: center; font-size: 16pt;">{{event.title}}</h1>
        <div>
          <hr>
          <h2><b>Time:</b> {{event.time}}</h2>
          <hr>
          <h2><b>Date:</b> {{event.date}}</h2>
          <hr>
          <h2><b>Location:</b> {{event.location}}</h2>
          <hr>
          <h2 style="margin-bottom: 12px;"> <b>Description:</b> </h2>
          <p style="height: 150px; overflow: auto">{{event.description}}</p>
          <hr>
          <center><a v-show="event.is_max_users == false" :id="'profDevSignUpButton'+event.id" :name="event.title" class="button is-info" @click="signUp(index)">Sign Up</a></center>
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
      addProfTitle: '',
      addProfTime: '',
      numberOfHours: '',
      addProfDate: '',
      addProfLocation: '',
      addProfDesc: '',
      addMaxUsers: ''
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
        event_type: "prof_dev"
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
            max_users: event.max_users,
            hours: event.hours
          }
          that.events.push(obj)
        })
      })
    },
    signUp(index) {
      this.events[index].users.id.push(this.$store.state.user.id)

      var postData = {
        id: this.events[index].id,
        signed_users: JSON.stringify(this.events[index].users),
      }
      this.$http.post(userSignedEvent, postData).then(response => {
        if (response.data == 'fail') {
          alert('The Event is Filled')
          location.reload()
        }
      })
    },

    addProfEvent() {
      var users = { "id": [] }
      var postData = {
        title: this.addProfTitle,
        location: this.addProfLocation,
        date: this.addProfDate,
        time: this.addProfTime,
        description: this.addProfDesc,
        event_type: "prof_dev",
        month: this.addProfDate.split("/")[1],
        signed_users: JSON.stringify(users),
        max_users: this.addMaxUsers,
        hours: this.numberOfHours,
        attended_users: JSON.stringify(users),
        complete: 0
      }
      this.$http.post(addEvent, postData).then(response => { location.reload() })
    },

    checkSignedIn() {
      var that = this
      this.events.forEach(function(event) {
        event.users.id.forEach(function(id) {
          if (id == that.$store.state.user.id) {
            $(document).ready(function() {
              $('#profDevSignUpButton' + event.id).hide()
            })
            return
          }
        })
      })
    },

    showEditProfEvent(index) {
      if ($('#profDevEventBox' + index).css('display') == 'block') {
        $("#editProfEventBox" + index).show()
        $("#profDevEventBox" + index).hide()
      } else if ($('#profDevEventBox' + index).css('display') == 'none' && $('#deleteProfEventBox' + index).css('display') == 'none') {
        $("#editProfEventBox" + index).hide()
        $("#profDevEventBox" + index).show()
      } else if ($('#deleteProfEventBox' + index).css('display') == 'block' && $('#profDevEventBox' + index).css('display') == 'none') {
        $("#deleteProfEventBox" + index).hide()
        $("#editProfEventBox" + index).show()
      }
    },

    showDeleteProfEvent(index) {
      if ($('#profDevEventBox' + index).css('display') == 'block') {
        $("#deleteProfEventBox" + index).show()
        $("#profDevEventBox" + index).hide()
      } else if ($('#profDevEventBox' + index).css('display') == 'none' && $('#editProfEventBox' + index).css('display') == 'none') {
        $("#deleteProfEventBox" + index).hide()
        $("#profDevEventBox" + index).show()
      } else if ($('#editProfEventBox' + index).css('display') == 'block' && $('#profDevEventBox' + index).css('display') == 'none') {
        $("#editProfEventBox" + index).hide()
        $("#deleteProfEventBox" + index).show()
      }
    },

    editProfEvent(index) {
      var postData = {
        id: this.events[index].id,
        title: this.events[index].title,
        location: this.events[index].location,
        date: this.events[index].date,
        time: this.events[index].time,
        description: this.events[index].description,
        month: this.events[index].date.split("/")[1],
        max_users: this.events[index].max_users,
        hours:this.events[index].hours,
      }
      this.$http.post(editEvent, postData).then(response => { location.reload() })
    },

    deleteProfEvent(index) {
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
#profDevEventBox {
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

#editProfEventBox {
  padding: 10px;
  background-color: lightgrey;
}

#editProfEventWrapper input,
textarea {
  width: 100%;
  margin-top: 10px;
}

#deleteProfEventBox {
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
