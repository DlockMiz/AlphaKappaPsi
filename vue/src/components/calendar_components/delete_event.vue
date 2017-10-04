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
    </div>
    <div v-show="showDeleteMonth">
      <div v-for="(item, index) item in dates.events">
        <input type="radio" :value="dates.events.title">
        <label>{{ dates.events[index].title }}</label>
      </div>
    </div>
  </div>
</template>
<script>
import { loadMonthEventsRoute } from '../../router/config.js'
export default {
  data() {
    return {
      month: '',
      months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      dates: { events: [] },
      showSearchMonth: true,
      showDeleteMonth: false
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
        if (response.data.lenth != 0) {
          this.showSearchMonth = false
          this.showDeleteMonth = true

          response.data.forEach(function(value) {
            var obj = {
              title: value.title
            }
            that.dates.events.push(obj)
          })
        }
      })
    }
  }

}

</script>
<style>
#loadButton {
  margin-top: 10px;
  margin-left: 30%;
}

</style>
