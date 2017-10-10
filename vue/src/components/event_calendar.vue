<template>
  <div id="calendar_page">
    <template onload="loadDates()">
      <vue-event-calendar id="calendar" :events.async="akpEvents.events"></vue-event-calendar>
    </template>
    <div id="eventBox">
      <div class="tabs">
        <ul>
          <li id="createEvent" class="is-active" @click="createEvent()"><a>Add Event</a></li>
          <li id="editEvent" @click="editEvent()"><a>Edit Event</a></li>
          <li id="deleteEvent" @click="deleteEvent()"><a>Delete Event</a></li>
        </ul>
      </div>
      <div id="addEventbox" v-show="showAddEvent">
        <add_event></add_event>
      </div>
      <div id="editEventBox" v-show="showEditEvent">
        <edit_event></edit_event>
      </div>
      <div id="deleteEventBox" v-show="showDeleteEvent">
        <delete_event></delete_event>
      </div>
    </div>
  </div>
  </div>
</template>
<script>
import { loadDates } from '../router/config.js'
import Datepicker from 'vue-bulma-datepicker'
import add_event from './calendar_components/add_event'
import edit_event from './calendar_components/edit_event'
import delete_event from './calendar_components/delete_event'


window.$ = window.jQuery = require('jquery');
$(document).ready(function() {
  $("#createEvent").click(function() {
    $("#createEvent").addClass("is-active");
    $("#deleteEvent").removeClass("is-active");
    $("#editEvent").removeClass("is-active");
  })
  $("#deleteEvent").click(function() {
    $("#createEvent").removeClass("is-active");
    $("#deleteEvent").addClass("is-active");
    $("#editEvent").removeClass("is-active");
  })
  $("#editEvent").click(function() {
    $("#createEvent").removeClass("is-active");
    $("#deleteEvent").removeClass("is-active");
    $("#editEvent").addClass("is-active");
  })
})

export default {
  data() {
    return {
      akpEvents: { events: [] },
      showEditEvent: false,
      showAddEvent: true,
      showDeleteEvent: false,
    }
  },
  components: {
    Datepicker,
    add_event,
    edit_event,
    delete_event
  },

  methods: {
    loadDates() {
      this.$http.post(loadDates).then(response => {

        var that = this
        var data = response.data

        data.forEach(function(value) {
          var obj = {
            date: value.event_date,
            title: value.title,
            desc: String(value.description),
          }
          that.akpEvents.events.push(obj)
        })
      })
    },
    editEvent() {
      this.showEditEvent = true
      this.showDeleteEvent = false
      this.showAddEvent = false
    },
    deleteEvent() {
      this.showEditEvent = false
      this.showDeleteEvent = true
      this.showAddEvent = false
    },

    createEvent() {
      this.showEditEvent = false
      this.showDeleteEvent = false
      this.showAddEvent = true
    }
  },
  mounted: function() {
    this.loadDates()
  }

}

</script>
<style>
#eventBox {
  border: solid #a4c1e4;
  box-shadow: 0px 0px 10px 10px #a4c1e4;
  background-color: #a4c1e4;
  color: black;
  padding: 10px;
  width: 370px;
  margin-left: 35px;
  float: left;
}

#submitButton {
  margin-left: 35%;
}

#changeButton {
  margin-left: 37%;
}

#searchButton {
  margin-left: 38%;
}

#searchAgainButton {
  margin-left: 31.5%;
  margin-top: 20px;
}

#calendar {
  height: 698px;
  width: 94%;
  box-shadow: 0px 0px 10px 10px #a4c1e4;
  margin-left: 30px;
  margin-bottom: 10%;
  float: left;
}

#calendar_page {
  margin-top: 50px;
}

.events-wrapper {
  border-radius: 0px 0px 0px 0px !important;
}

.tabs a:hover {
  border-bottom-color: darkblue;
  color: darkblue;
}

.tabs li.is-active a {
  border-bottom-color: darkblue;
  color: darkblue;
}

input.input.flatpickr-input {
  width: 100%;
}

h1 {
  font-size: 20pt;
}

h3 {
  font-size: 16pt;
  margin-top: 20px;
}

</style>
