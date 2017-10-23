<template>
  <div>
    <b>Title for the event:</b>
    <input class="input is-info" v-model="addEvent.addTitle" type="text" placeholder="Title...">
    <hr>
    <b>Description for the event:</b>
    <textarea class="textarea is-info" v-model="addEvent.addDesc" type="text" placeholder="Description..."></textarea>
    <hr>
    <b>Type of event:</b>
    <div class="select is-info">
      <select style="width: 100vw;">
        <option selected>Event 1</option>
        <option>Event 2</option>
      </select>
    </div>
    <hr>
    <div><b>Date of event:</b></div>
    <datepicker v-model="addEvent.addDate" placeholder="Date..." :config="{ dateFormat: 'Y/m/d', static: true }"></datepicker>
    <hr>
    <center><a class="button is-info" @click="submitEvent()">Add Event</a></center>
    <div v-show="showAddEventError" style="color:red; text-align:center;"><b>Please Fill in All Blanks</b></div>
    <div v-show="showAddSuccess" style="color:green; text-align:center;"><b>Event Added</b></div>
  </div>
</template>
<script>
import Datepicker from 'vue-bulma-datepicker'
import { submitEventRoute } from '../../router/config.js'

export default {
  data() {
    return {
      addEvent: { addTitle: '', addDate: '', addDesc: '' },
      showAddEventError: false,
      showAddSuccess: false
    }
  },
  methods: {
    submitEvent() {
      var eventMonth

      this.showAddEventError = false
      if (this.addEvent.addDesc == '' || this.addEvent.addTitle == '' || this.addEvent.addDate == '') {
        this.showAddEventError = true
        return;
      }

      var parseDate = this.addEvent.addDate.split("/")

      const postData = {
        desc: this.addEvent.addDesc,
        title: this.addEvent.addTitle,
        date: this.addEvent.addDate,
        month: parseInt(parseDate[1])
      }
      this.$http.post(submitEventRoute, postData).then(response => {
        this.showAddSuccess = true
      })
    },
  },
  components: {
    Datepicker,
  },
}

</script>
