<template>
  <div>
    <div>
      If you cannot create a customized event, please use the master doc <a>here</a>.
    </div>
    <i v-show="$store.state.user.status == '1' " @click="showAddEvent = !showAddEvent" id="addEventIcon" class="fa fa-plus-square fa-2x" aria-hidden="true"></i>
    <div v-show="showAddEvent" id="addBrotherBox">
      <center>
        <div>
          <div>Only Selected Can View:</div>
          <label class="radio">
            <input style="margin-left: 20px;" class="selectedView" type="checkbox" name="active" value="2" checked> Active
          </label>
          <label class="radio">
            <input style="margin-left: 20px;" class="selectedView" type="checkbox" name="pledge" value="3" checked> Pledge
          </label>
        </div>
      </center>
      <input v-model="addTitle" class="input is-info" type="text" placeholder="Title...">
      <input v-model="addTime" class="input is-info" type="text" placeholder="Time...">
      <datepicker v-model="addDate" placeholder="Date..." :config="{ dateFormat: 'Y/m/d', static: true }" style="width:280px !important;"></datepicker>
      <input v-model="addLocation" class="input is-info" type="text" placeholder="Location...">
      <input v-model="addMaxUsers" class="input is-info" type="number" placeholder="Max Users...">
      <textarea v-model="addDesc" class="textarea is-info" type="text" placeholder="Description..."></textarea>
      <center><a class="button is-info" @click="addBrotherEvent()" style="margin-top: 10px;">Add Event</a></center>
    </div>
    <div id="brotherEventBox" v-for="(event, index) event in events" style="margin-top: 50px;" v-show="event.current_perms[0] == $store.state.user.status || event.current_perms[1] == $store.state.user.status || event.current_perms[2] == $store.state.user.status">
      <i v-show="$store.state.user.status == '1'" class="fa fa-minus-square icon_hover" @click="showDeleteEvent(index)" aria-hidden="true"></i>
      <i v-show="$store.state.user.status == '1'" class="fa fa-pencil-square icon_hover" @click="showEditEvent(index)" aria-hidden="true"></i>
      <div id="editBrotherEventWrapper">
        <div :id="'editBrotherEventBox'+index" style="display: none;">
          <center>
            <div>
              <div>Only Selected Can View:</div>
              <label class="radio">
                <input style="margin-left: 20px;" class="selectedView" type="checkbox" :class="'selectedViewActive'+event.id" :name="'active_edit'+index" value="2"> Active
              </label>
              <label class="radio">
                <input style="margin-left: 20px;" class="selectedView" type="checkbox" :class="'selectedViewPledge'+event.id" :name="'pledge_edit'+index" value="3"> Pledge
              </label>
            </div>
          </center>
          <input v-model="event.title" class="input is-info" type="text" placeholder="Title...">
          <input v-model="event.time" class="input is-info" type="text" placeholder="Time...">
          <datepicker v-model="event.date" placeholder="Date..." :config="{ dateFormat: 'Y/m/d', static: true }"></datepicker>
          <input v-model="event.location" class="input is-info" type="text" placeholder="Location...">
          <input v-model="event.max_users" class="input is-info" type="number" placeholder="Max Users...">
          <textarea v-model="event.description" class="textarea is-info" type="text" placeholder="Description..."></textarea>
          <center><a class="button is-info" @click="editEvent(index)" style="margin-top: 10px;">Edit Event</a></center>
        </div>
      </div>
      <div :id="'deleteBrotherEventBox'+index" style="display: none;">
        <center>
          <h1>Are you sure you want to delete this event?</h1></center>
        <center><a class="button is-info" @click="deleteEvent(index)" style="margin-top: 10px;">Delete Event</a></center>
      </div>
      <div>
        <div :id="'brotherEventBox'+index">
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
            <center><a v-show="event.is_max_users == false" :id="'brotherSignUpButton'+event.id" :name="event.title" class="button is-info" @click="signUp(index)">Sign Up</a></center>
            <center><a v-show="event.is_max_users == true" style="color:blue">Event Full</a></center>
          </div>
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
      addTitle: '',
      addTime: '',
      numberOfHours: '',
      addDate: '',
      addLocation: '',
      addDesc: '',
      addMaxUsers: '',
    }
  },

  mounted: function() {
    this.getBrotherEvents()
  },

  beforeUpdate: function() {
    this.checkSignedIn()
  },

  methods: {
    getBrotherEvents() {
      var postData = {
        event_type: "brotherhood"
      }
      this.$http.post(getEvents, postData).then(response => {
        var that = this
        response.data.forEach(function(event) {
          //finding permissions for each event
          var perms = JSON.parse(event.censor_perms)
          var parse_perms = []
          perms.id.forEach(function(p) {
            parse_perms.push(p)
          })

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
            hours: event.hours,
            current_perms: parse_perms
          }
          that.events.push(obj)
        })
      })
    },
    signUp(index) {
      var postData = {
        id: this.$store.state.user.id,
        event_id: this.events[index].id,
      }
      this.$http.post(userSignedEvent, postData).then(response => {
        if (response.data == 'fail') {
          alert('The Event is Filled')
          location.reload()
        }
        location.reload()
      })
    },

    addBrotherEvent() {
      var users = { "id": [] }
      var postData = {
        title: this.addTitle,
        location: this.addLocation,
        date: this.addDate,
        time: this.addTime,
        description: this.addDesc,
        event_type: "brotherhood",
        month: this.addDate.split("/")[1],
        signed_users: JSON.stringify(users),
        max_users: this.addMaxUsers,
        hours: this.numberOfHours,
        attended_users: JSON.stringify(users),
        complete: 0,
        censor_perms: {}
      }

      var radios = document.getElementsByClassName('selectedView');
      var censor_perms = { id: ['1', '0', '0'] }
      for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked)
          censor_perms.id[i] = radios[i].value
      }
      postData.censor_perms = JSON.stringify(censor_perms)

      this.$http.post(addEvent, postData).then(response => { location.reload() })
    },

    checkSignedIn() {
      var that = this
      this.events.forEach(function(event) {
        if (event.current_perms[1] == '2')
          $('.selectedViewActive' + event.id).prop('checked', true)
        if (event.current_perms[2] == '3')
          $('.selectedViewPledge' + event.id).prop('checked', true)
        event.users.id.forEach(function(id) {
          if (id == that.$store.state.user.id) {
            $(document).ready(function() {
              $('#brotherSignUpButton' + event.id).hide()
            })
            return
          }
        })
      })
    },

    showEditEvent(index) {
      if ($('#brotherEventBox' + index).css('display') == 'block') {
        $("#editBrotherEventBox" + index).show()
        $("#brotherEventBox" + index).hide()
      } else if ($('#brotherEventBox' + index).css('display') == 'none' && $('#deleteBrotherEventBox' + index).css('display') == 'none') {
        $("#editBrotherEventBox" + index).hide()
        $("#brotherEventBox" + index).show()
      } else if ($('#deleteBrotherEventBox' + index).css('display') == 'block' && $('#brotherEventBox' + index).css('display') == 'none') {
        $("#deleteBrotherEventBox" + index).hide()
        $("#editBrotherEventBox" + index).show()
      }
    },

    showDeleteEvent(index) {
      if ($('#brotherEventBox' + index).css('display') == 'block') {
        $("#deleteBrotherEventBox" + index).show()
        $("#brotherEventBox" + index).hide()
      } else if ($('#brotherEventBox' + index).css('display') == 'none' && $('#editBrotherEventBox' + index).css('display') == 'none') {
        $("#deleteBrotherEventBox" + index).hide()
        $("#brotherEventBox" + index).show()
      } else if ($('#editBrotherEventBox' + index).css('display') == 'block' && $('#brotherEventBox' + index).css('display') == 'none') {
        $("#editBrotherEventBox" + index).hide()
        $("#deleteBrotherEventBox" + index).show()
      }
    },

    editEvent(index) {
      var postData = {
        id: this.events[index].id,
        title: this.events[index].title,
        location: this.events[index].location,
        date: this.events[index].date,
        time: this.events[index].time,
        description: this.events[index].description,
        month: this.events[index].date.split("/")[1],
        max_users: this.events[index].max_users,
        hours: this.events[index].hours,
        censor_perms: {}
      }

      var a_radios = document.getElementsByClassName('selectedViewActive'+this.events[index].id);
      var p_radios = document.getElementsByClassName('selectedViewPledge'+this.events[index].id);  
      var censor_perms = { id: ['1', '0', '0'] }

      console.log(a_radios)
      console.log(p_radios)



      if(a_radios[0].checked == true)
        censor_perms.id[1] = '2'
      else if(p_radios[0].checked == true)
        censor_perms.id[2] = '3'

      postData.censor_perms = JSON.stringify(censor_perms)
      this.$http.post(editEvent, postData).then(response => { location.reload() })
    },

    deleteEvent(index) {
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
#brotherEventBox {
  border: solid #164380 2px;
  border-radius: 10px 10px 10px 10px;
  width: 29.5%;
  margin-left: 40px;
  padding: 10px;
  float: left;
}

#addBrotherBox {
  background-color: lightgrey;
  width: 300px;
  position: absolute;
  margin: 40px;
  padding: 10px;
}

#addBrotherBox input,
textarea {
  width: 100%;
  margin-top: 10px;
}

#editBrotherEventBox {
  padding: 10px;
  background-color: lightgrey;
}

#editBrotherEventWrapper input,
textarea {
  width: 100%;
  margin-top: 10px;
}

#deleteBrotherEventBox {
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
