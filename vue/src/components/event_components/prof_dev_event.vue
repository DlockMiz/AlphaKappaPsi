<template>
  <div>
    <center><img id="loading" style="margin-top: 100px;" src="../../assets/images/loading.gif" height="200" width="200"></center>
    <div id="profEventWrapper">
      <a v-show="$store.state.user.status == '1' " @click="propsData.showModal = true" id="addEventIcon" class="button is-info" aria-hidden="true">Create Prof Dev Event</a>
      <h1 style="text-align: center;" v-if="events.length == 0" class="title is-2">No Current Events</h1>
      <modal :propsData="propsData">
        <prof-dev-event-form :propsData="propsData"></prof-dev-event-form>
      </modal>
      <div id="profDevEventBox" v-for="(event, index) event in events" style="margin-top: 50px;" v-show="event.current_perms[0] == $store.state.user.status || event.current_perms[1] == $store.state.user.status || event.current_perms[2] == $store.state.user.status">
        <i v-show="$store.state.user.status == '1'" class="fa fa-minus-square icon_hover" @click="showDeleteEvent(index)" aria-hidden="true"></i>
        <i v-show="$store.state.user.status == '1'" class="fa fa-pencil-square icon_hover" @click="showEditEvent(index)" aria-hidden="true"></i>
        <div id="editProfEventWrapper">
          <div :id="'editProfEventBox'+index" style="display: none;">
            <div>
              <center>
                <div>Only Selected Can View:</div>
                <label class="radio">
                  <input style="margin-left: 20px;" type="checkbox" :class="'selectedViewActive'+event.id" :name="'active_edit'+index" value="2"> Active
                </label>
                <label class="radio">
                  <input style="margin-left: 20px;" type="checkbox" :class="'selectedViewPledge'+event.id" :name="'pledge_edit'+index" value="3"> Pledge
                </label>
              </center>
            </div>
            <input v-model="event.title" class="input is-info" type="text" placeholder="Title...">
            <input v-model="event.time" class="input is-info" type="text" placeholder="Time...">
            <datepicker v-model="event.date" placeholder="Date..." :config="{ dateFormat: 'Y/m/d', static: true }"></datepicker>
            <input v-model="event.location" class="input is-info" type="text" placeholder="Location...">
            <input v-model="event.max_users" class="input is-info" type="number" placeholder="Max Users...">
            <textarea v-model="event.description" class="textarea is-info" type="text" placeholder="Description..."></textarea>
            <center><a class="button is-info" @click="editEvent(index)" style="margin-top: 10px;">Edit Event</a></center>
          </div>
        </div>
        <div :id="'deleteProfEventBox'+index" style="display: none;">
          <center>
            <h1>Are you sure you want to delete this event?</h1></center>
          <center><a class="button is-info" @click="deleteEvent(index)" style="margin-top: 10px;">Delete Event</a></center>
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
  </div>
</template>
<script>
import modal from '../content_modal'
import Datepicker from 'vue-bulma-datepicker'
import ProfDevEventForm from './add_event_forms/prof_dev_event_form'
import { getEvents, userSignedEvent, editEvent, deleteEvent } from '../../router/config'

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
      addDatef: '',
      addLocation: '',
      addDesc: '',
      addMaxUsers: '',
      propsData: {
        showModal: this.showModal
      }
    }
  },

  mounted: function() {
    this.getProfDevEvents()
  },

  beforeUpdate: function() {
    this.checkSignedIn()
  },
  watch: {
    propsData: {
      handler: function(value) {
        if (this.propsData.showModal == false) {
          this.getProfDevEvents()
        }
      },
      deep: true,
    }
  },

  methods: {
    getProfDevEvents() {
      this.events = []
      $('#loading').show()
      $('#profEventWrapper').hide()
      var postData = {
        event_type: "prof_dev"
      }
      this.$http.post(getEvents, postData).then(response => {
        $('#loading').hide()
        $('#profEventWrapper').show()
        var that = this
        response.data.forEach(function(event) {

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
          this.$swal('Error', 'This event is already filled!', 'error')
          this.getBrotherEvents()
        }
        this.$swal('Success', 'You are now signed up for this event.', 'success').then((result) => {
          $('#serviceSignUpButton' + this.events[index].id).hide()
        })
      })
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
              $('#profDevSignUpButton' + event.id).hide()
            })
            return
          }
        })
      })
    },

    showEditEvent(index) {
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

    showDeleteEvent(index) {
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
      var a_radios = document.getElementsByClassName('selectedViewActive' + this.events[index].id);
      var p_radios = document.getElementsByClassName('selectedViewPledge' + this.events[index].id);
      var censor_perms = { id: ['1', '0', '0'] }

      if (a_radios[0].checked == true)
        censor_perms.id[1] = '2'
      if (p_radios[0].checked == true)
        censor_perms.id[2] = '3'

      postData.censor_perms = JSON.stringify(censor_perms)
      this.$http.post(editEvent, postData).then(response => {
        this.$swal('Event Edited', '', 'success').then((result) => {
          this.events[index] = postData
          this.showEditEvent(index)
        })
      })
    },

    deleteEvent(index) {
      var postData = {
        id: this.events[index].id
      }
      this.$http.post(deleteEvent, postData).then(response => { this.getProfDevEvents() })
    }

  },

  components: {
    Datepicker,
    ProfDevEventForm,
    modal
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

#addProfDevBox {
  background-color: lightgrey;
  width: 300px;
  position: absolute;
  margin: 40px;
  padding: 10px;
}

#addProfDevBox input,
textarea {
  width: 100%;
  margin-top: 10px;
}

#editProfEventBox {
  padding: 10px;
  background-color: lightgrey;
}

.input{
  position: relative;
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
  margin-left: 40px;
}

.button {
  position: static;
}

.flatpickr-wrapper {
  display: block !important;
}

.flatpickr-calendar {
  position: relative !important;
}

</style>
