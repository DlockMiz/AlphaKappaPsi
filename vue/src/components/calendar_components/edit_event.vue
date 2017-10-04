<template>
  <div>
    <div v-show="showSearchBox">
      <h3>Search for an event to edit:</h3>
      <hr>
      <b>Title Search</b>
      <input class="input is-info" v-model="searchEvent.title" type="text" placeholder="Type in the title...">
      <hr>
      <div>
        <b>Date Search</b>
      </div>
      <datepicker v-model="searchEvent.date" placeholder="Select the date of the event..." :config="{ dateFormat: 'Y/m/d', static: true }"></datepicker>
      <hr>
      <a id="searchButton" class="button is-info" @click="searchEventData()">Search</a>
      <div v-show="showSearchError" style="color:red; text-align:center;"><b>Event Not Found</b></div>
    </div>
    <div v-show="showEditBox">
      <h3>Title Change:</h3>
      <input class="input is-info" v-model="eventEditObj.title" type="text" placeholder="Title...">
      <hr>
      <h3>Description Change:</h3>
      <textarea class="textarea is-info" v-model="eventEditObj.desc" type="text" placeholder="Description..."></textarea>
      <hr>
      <h3>Type of Event Change:</h3>
      <div class="select is-info">
        <select style="width: 100vw;">
          <option selected>Event 1</option>
          <option>Event 2</option>
        </select>
      </div>
      <hr>
      <h3>Date of Event Change:</h3>
      <datepicker v-model="eventEditObj.date" placeholder="Date..." :config="{ dateFormat: 'Y/m/d', static: true }"></datepicker>
      <hr>
      <a id="changeButton" class="button is-info" @click="changeSuccess()">Change</a>
      <div v-show="showEditEventSuccess" style="color:green; text-align:center;"><b>Successful Change</b></div>
      <a id="searchAgainButton" class="button is-info" @click="restartSearch()">Search Again</a>
    </div>
  </div>
</template>
<script>
import { editEventRoute, searchEventDataRoute } from '../../router/config.js'
import Datepicker from 'vue-bulma-datepicker'

export default {
  data() {
    return {
      eventEditObj: { title: '', date: '', desc: '', id: 0 },
      searchEvent: { title: '', date: '' },
      showSearchError: false,
      showEditEventSuccess: false,
      showSearchBox: true,
      showEditBox: false,
      showSuccess: false,
    }
  },
  methods: {
    searchEventData() {
      this.showSearchError = false
      const postData = {
        title: this.searchEvent.title,
        date: this.searchEvent.date
      }
      this.$http.post(searchEventDataRoute, postData).then(response => {
        if (response.data.length == 0) {
          this.showSearchError = true
        } else {
          this.showSearchBox = false
          this.showEditBox = true
          this.showEditEventSuccess = false;
          this.eventEditObj.title = response.data[0].title
          this.eventEditObj.date = response.data[0].event_date
          this.eventEditObj.desc = response.data[0].description,
            this.eventEditObj.id = response.data[0].id
        }
      })
    },
    changeSuccess() {
      const postData = {
        title: this.eventEditObj.title,
        date: this.eventEditObj.date,
        desc: this.eventEditObj.desc,
        id: this.eventEditObj.id,
      }

      this.$http.post(editEventRoute, postData).then(response => {
        this.showEditEventSuccess = true;
      })
    },
    restartSearch() {
      this.showEditBox = false
      this.showSearchBox = true
      this.searchEvent.title = ''
    },
  },
  components: {
    Datepicker
  }
}

</script>
