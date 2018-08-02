<template>
  <div>
    <div>
      If you cannot create a customized event, please use the master doc <a>here</a>.
    </div>
    <i v-show="$store.state.user.status == '1' " @click="showAddEvent = !showAddEvent" id="addEventIcon" class="fa fa-plus-square fa-2x" aria-hidden="true"></i>
    <!-- below is adding an event -->    
    <div v-show="showAddEvent" id="addFundBox">
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
      <input v-model="addPoints" class="input is-info" type="text" placeholder="Points...">
      <input v-model="addLocation" class="input is-info" type="text" placeholder="Location...">
      <input v-model="addMaxUsers" class="input is-info" type="number" placeholder="Max Users...">
      <textarea v-model="addDesc" class="textarea is-info" type="text" placeholder="Description..."></textarea>
      <center><a class="button is-info" @click="addEvent()" style="margin-top: 10px;">Add Event</a></center>
    </div>
    <div id="fundEventBox" v-for="(event, index) event in events" style="margin-top: 50px;" v-show="event.current_perms[0] == $store.state.user.status || event.current_perms[1] == $store.state.user.status || event.current_perms[2] == $store.state.user.status">
      <i v-show="$store.state.user.status == '1'" class="fa fa-minus-square icon_hover" @click="showDeleteEvent(index)" aria-hidden="true"></i>
      <i v-show="$store.state.user.status == '1'" class="fa fa-pencil-square icon_hover" @click="showEditEvent(index)" aria-hidden="true"></i>
      <div id="editFundEventWrapper">
        <div :id="'editFundEventBox'+index" style="display: none;">
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
      <div :id="'deleteFundEventBox'+index" style="display: none;">
        <center>
          <h1>Are you sure you want to delete this event?</h1></center>
        <center><a class="button is-info" @click="deleteEvent(index)" style="margin-top: 10px;">Delete Event</a></center>
      </div>
      <div :id="'fundEventBox'+index">
        <h1 style="text-align: center; font-size: 16pt;">{{event.title}}</h1>
        <div>
          <hr>
          <h2><b>Time:</b> {{event.time}}</h2>
          <hr>
          <h2><b>Date:</b> {{event.date}}</h2>
          <hr>
          <h2><b>Points:</b> {{event.hours}}</h2>
          <hr>
          <h2><b>Location:</b> {{event.location}}</h2>
          <hr>
          <h2 style="margin-bottom: 12px;"> <b>Description:</b> </h2>
          <p style="height: 150px; overflow: auto">{{event.description}}</p>
          <hr>
          <center><a v-show="event.is_max_users == false" :id="'fundSignUpButton'+event.id" :name="event.title" class="button is-info" @click="signUp(index)">Sign Up</a></center>
          <center><a v-show="event.is_max_users == true" style="color:blue">Event Full</a></center>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Datepicker from 'vue-bulma-datepicker'
import { getEvents, addEvent, userSignedEvent, editEvent, deleteEvent, getReqParams, changeReqParams } from '../../router/config'

window.$ = window.jQuery = require('jquery');


export default {
  data() {
    return {
      events: [],
      showAddEvent: false,
      showEvent: true,
      reqParam: '',
      addTitle: '',
      addPoints: '',
      addTime: '',
      numberOfHours: '',
      addDate: '',
      addLocation: '',
      addDesc: '',
      addMaxUsers: ''
    }
  },

  mounted: function() {
    this.getFundEvents()
    this.getFundParams()
  },

  beforeUpdate: function() {
    this.checkSignedIn()
  },

  methods: {
    getFundParams() {
      this.$http.post(getReqParams).then(response => {
        console.log(response.data)
        this.reqParam = response.data[0].parameters
      })
    },
    getFundEvents() {
      var postData = {
        event_type: "fundraising"
      }
      this.$http.post(getEvents, postData).then(response => {
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
          alert('The Event is Filled')
          location.reload()
        }
        location.reload()
      })
    },

    addEvent() {
      var users = { "id": [] }
      var postData = {
        title: this.addTitle,
        location: this.addLocation,
        date: this.addDate,
        time: this.addTime,
        description: this.addDesc,
        event_type: "fundraising",
        month: this.addDate.split("/")[1],
        signed_users: JSON.stringify(users),
        max_users: this.addMaxUsers,
        hours: this.addPoints,
        attended_users: JSON.stringify(users),
        complete: 0,
        censor_perms: {}
      }
      var radios = document.getElementsByClassName('selectedView');
      var censor_perms = { id: ['1', '0', '0'] }
      for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked)
          censor_perms.id[i + 1] = radios[i].value
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
              $('#fundSignUpButton' + event.id).hide()
            })
            return
          }
        })
      })
    },

    showEditEvent(index) {
      if ($('#fundEventBox' + index).css('display') == 'block') {
        $("#editFundEventBox" + index).show()
        $("#fundEventBox" + index).hide()
      } else if ($('#fundEventBox' + index).css('display') == 'none' && $('#deleteFundEventBox' + index).css('display') == 'none') {
        $("#editFundEventBox" + index).hide()
        $("#fundEventBox" + index).show()
      } else if ($('#deleteFundEventBox' + index).css('display') == 'block' && $('#fundEventBox' + index).css('display') == 'none') {
        $("#deleteFundEventBox" + index).hide()
        $("#editFundEventBox" + index).show()
      }
    },

    showDeleteEvent(index) {
      if ($('#fundEventBox' + index).css('display') == 'block') {
        $("#deleteFundEventBox" + index).show()
        $("#fundEventBox" + index).hide()
      } else if ($('#fundEventBox' + index).css('display') == 'none' && $('#editFundEventBox' + index).css('display') == 'none') {
        $("#deleteFundEventBox" + index).hide()
        $("#fundEventBox" + index).show()
      } else if ($('#editFundEventBox' + index).css('display') == 'block' && $('#fundEventBox' + index).css('display') == 'none') {
        $("#editFundEventBox" + index).hide()
        $("#deleteFundEventBox" + index).show()
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
#fundEventBox {
  border: solid #164380 2px;
  border-radius: 10px 10px 10px 10px;
  width: 29.5%;
  margin-left: 40px;
  padding: 10px;
  float: left;
}

#reqParamBox {
  /*position: absolute;*/
  float: right;
  /*margin-top: 6px;*/
  margin-right: 10px;
  border: solid blue 3px;
  border-radius: 5px 5px 5px 5px;
  padding: 5px;
}

#addFundBox {
  background-color: lightgrey;
  width: 300px;
  position: absolute;
  margin: 40px;
  padding: 10px;
}

#addFundBox input,
textarea {
  width: 100%;
  margin-top: 10px;
}

#editFundEventBox {
  padding: 10px;
  background-color: lightgrey;
}

#editFundEventWrapper input,
textarea {
  width: 100%;
  margin-top: 10px;
}

#deleteFundEventBox {
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
