<template>
  <div>
    <div v-show="showSearchMonth">
      <h3>Load all events from a certain month:</h3>
      <div class="select is-info">
        <select v-model="month" style="width: 100vw;">
          <option v-for="month in months" :value="month">{{ month }}</option>
        </select>
      </div>
      <a id="loadButton" class="button is-info" @click="loadEvents()">Load Events</a>
      <div v-show="loadError" style="color:red; text-align:center;"><b>Couldn't Load Events</b></div>
    </div>
    <div v-show="showDeleteMonth">
      <div v-for="(item, index) item in dates.events">
        <input class="checkbox" type="checkbox" :value="dates.events[index].id">
        <label>{{ dates.events[index].title }}</label>
      </div>
      <hr>
      <a id="deleteButton" class="button is-info" @click="deleteEvent()">Delete Events</a>
      <div v-show="deleteSuccess" style="color:green; text-align:center;"><b>Events Deleted</b></div>
    </div>
  </div>
</template>
<script>
window.$ = window.jQuery = require('jquery');

$(document).ready(function() {

})

import { loadMonthEventsRoute, deleteEventRoute } from '../../router/config.js'
export default {
  data() {
    return {
      month: '',
      months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      dates: { events: [] },
      showSearchMonth: true,
      showDeleteMonth: false,
      deleteSuccess: false,
      loadError: false
    }
  },

  methods: {
    loadEvents() {
      var monthId = 0
      var monthString
      var that = this

      this.months.forEach(function(e) {
        monthId++;
        if (e == that.month) {
          monthString = monthId.toString()
          return;
        }
      })

      const postData = {
        month: monthString
      }

      this.$http.post(loadMonthEventsRoute, postData).then(response => {
        if (response.data.length != 0) {
          this.showSearchMonth = false
          this.showDeleteMonth = true

          response.data.forEach(function(value) {
            var obj = {
              title: value.title,
              id: value.id
            }
            that.dates.events.push(obj)
          })
        } else if (this.month == '') {
          this.loadError = true
        }
      })
    },
    deleteEvent() {
      var allInputs = document.getElementsByTagName("input")
      var checkedInputs = []
      for (var i = 0, max = allInputs.length; i < max; i++) {
        if (allInputs[i].checked == true)
          checkedInputs.push(allInputs[i].value)
      }
      const postData = {
        id: checkedInputs,
        size: checkedInputs.length
      }
      this.$http.post(deleteEventRoute, postData).then(response => {
        this.deleteSuccess = true
      })
    }
  }

}

</script>
<style>
#loadButton {
  margin-top: 10px;
  margin-left: 33%;
}

#deleteButton {
  margin-left: 30%;
}

</style>
