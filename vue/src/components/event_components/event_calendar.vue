<template>
  <div>
    <div>
      <template onload="loadDates()">
        <vue-event-calendar id="calendar" :events.async="akpEvents.events"></vue-event-calendar>
      </template>
    </div>
  </div>
</template>
<script>
import { loadDates } from '../../router/config.js'

export default {
  data() {
    return {
      akpEvents: { events: [] },
      showCalendarEventBox: false,
    }
  },


  methods: {
    loadDates() {
      this.$http.post(loadDates).then(response => {

        var that = this
        var data = response.data

        data.forEach(function(value) {
          var obj = {
            date: value.date,
            title: value.title,
            desc: value.description,
          }
          that.akpEvents.events.push(obj)
        })
      })
    },
  },
  mounted: function() {
    this.loadDates()
  }

}

</script>
<style>
#showCalendarEventBox {
  border: solid #a4c1e4;
  box-shadow: 0px 0px 10px 10px #a4c1e4;
  background-color: #a4c1e4;
  color: black;
  padding: 10px;
  width: 370px;
  margin: 20px;
}

#calendar {
  height: 698px;
  width: 75%;
  min-width: 700px;
  box-shadow: 0px 0px 10px 10px #a4c1e4;
  margin-bottom: 10%;
  margin-left: 0px !important;
  position: absolute;
}

.events-wrapper {
  border-radius: 0px 0px 0px 0px !important;
}

input.input.flatpickr-input {
  width: 100%;
}

</style>
