<template>
  <div>
    <i v-show="$store.state.user.status == '1' " @click="showAddEvent = !showAddEvent" id="addEventIcon" class="fa fa-plus-square fa-2x" aria-hidden="true"></i>
    <div v-show="showAddEvent" id="addServiceBox">
      <input v-model="addServiceTitle" class="input is-info" type="text" placeholder="Title...">
      <input v-model="addServiceTime" class="input is-info" type="text" placeholder="Time...">
      <datepicker v-model="addServiceDate" placeholder="Date..." :config="{ dateFormat: 'Y/m/d', static: true }" style="width:280px !important;"></datepicker>
      <input v-model="addServiceLocation" class="input is-info" type="text" placeholder="Location...">
      <textarea v-model="addServiceDesc" class="textarea is-info" type="text" placeholder="Description..."></textarea>
      <center><a class="button is-info" @click="addServiceEvent()" style="margin-top: 10px;">Add Event</a></center>
    </div>
    <div id="serviceEventBox" v-for="(event, index) event in events" style="margin-top: 50px;">
      <h1 style="text-align: center; font-size: 16pt;">{{event.title}}</h1>
      <hr>
      <h2>Time: {{event.time}} on {{event.date}}</h2>
      <hr>
      <h2>Location: {{event.location}}</h2>
      <hr>
      <h2 style="margin-bottom: 12px;"> Description: </h2>
      <p>{{event.description}}</p>
      <hr>
      <center><a :id="'button'+event.id" :name="event.title" class="button is-info" @click="signUp(index)">Sign Up</a></center>
    </div>
  </div>
</template>
<script>
window.$ = window.jQuery = require('jquery');

import Datepicker from 'vue-bulma-datepicker'
import { getEvents, addServiceEventRoute, userSignedEvent } from '../router/config'

export default {
  data() {
    return {
      events: [],
      showAddEvent: false,
      addServiceTitle: '',
      addServiceTime: '',
      addServiceDate: '',
      addServiceLocation: '',
      addServiceDesc: '',
    }
  },

  mounted: function() {
    this.getServiceEvents()
    this.checkUserLogin()
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
          var obj = {
            id: event.id,
            title: event.title,
            location: event.location,
            date: event.date,
            time: event.time,
            description: event.description,
            users: JSON.parse(event.signed_users),
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
        console.log(response.data)
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
        signed_users: JSON.stringify(users)
      }
      this.$http.post(addServiceEventRoute, postData).then(response => { location.reload() })
    },

    checkSignedIn() {
      var that = this
      this.events.forEach(function(event) {
        event.users.id.forEach(function(id) {
          if (id == that.$store.state.user.id) {
            $(document).ready(function() {
              $('#button' + event.id).hide()
            })
            return
          }
        })
      })
    },
    checkUserLogin() {
      if (this.$store.state.user == null) {
        alert('Please login to view this page.')
        this.$router.push('/')
      }
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
  width: 22%;
  margin-left: 40px;
  padding: 10px;
  float: left;
}

#eventBox hr {
  margin-top: 8px;
  margin-bottom: 8px;
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

</style>
