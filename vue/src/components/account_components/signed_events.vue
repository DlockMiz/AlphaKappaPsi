<template>
  <div>
    <div class="select is-info" style="margin: 15px;">
      <select v-model="selected">
        <option value="service">Service</option>
        <option value="prof_dev">Professional Development</option>
        <option value="brotherhood">Brotherhood</option>
        <option value="fundraising">Fundraising</option>
      </select>
    </div>
    <center><img id="loading" style="margin-top: 100px;" src="../../assets/images/loading.gif" height="200" width="200"></center>
      <div id="myEventsWrapper">
        <div v-if="this.events[0] == null">
          You have not signed up for any events in this category.
        </div>
        <div v-for="(event, index) event in events">
          <div id="loadSignedEventsBox">
            <center>
              <h1>{{event.title}}</h1>
            </center>
            <hr>
            <p>Time: {{event.time}}</p>
            <hr>
            <p>Date: {{event.date}}</p>
            <hr>
            <p>Location: {{event.location}}</p>
            <hr>
            <center>
              <a v-if="selected != 'fundraising'" class="button is-info" v-show="backOutValidity[index].isUnSignValid" @click="unSignUserFromEvent(event.id)">Un-Sign</a>
              <a class="button is-warning" @click="requestUserSwitch(index)">Request Switch</a>
            </center>
          </div>
        </div>
      </div>
  </div>
</template>
<script>
window.$ = window.jQuery = require('jquery');
import { loadSignedEvents, removeSignedUser, requestUserSwitch } from '../../router/config'
export default {
  data() {
    return {
      events: [],
      backOutValidity: [],
      selected: 'service'
    }
  },

  mounted: function() {
    this.loadEvents()
  },
  watch: {
    selected: function() {
      this.loadEvents()
    }
  },

  methods: {
    requestUserSwitch(index) {
      var postData = {
        id: this.$store.state.user.id,
        post_event: this.events[index]
      }

      this.$swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.value) {
          this.$http.post(requestUserSwitch, postData).then(response => {
            if (response.data == 100)
              this.$swal('No No No', 'You have already put in a request!', 'error')
            else if (response.data == 200)
              this.$swal('You should reload the page!', 'Reload the page and the event should disappear, someone probably replaced you! :)', 'error')
            else {
              if (this.selected = 'fundraising') {
                this.$swal('Great', "An email has been sent to the VPF's and they will confirm or deny.", 'success')
              } else
                this.$swal('Awesome', 'The request has been posted', 'success')
            }
          })
        } else
          return
      })
    },
    loadEvents() {
      $('#loading').show()
      $('#myEventsWrapper').hide()
      var postData = {
        id: this.$store.state.user.id,
        event_type: this.selected
      }
      this.$http.post(loadSignedEvents, postData).then(response => {
        $('#loading').hide()
        $('#myEventsWrapper').show()
        this.backOutValidity = []
        var that = this
        response.data.forEach(function(event) {
          var date = event.date.split("/")
          var eventDate = new Date(date[0], parseInt(date[1]) - 1, date[2])
          var currentDate = new Date

          var valid = {
            isUnSignValid: false
          }
          if (eventDate.getDate() - currentDate.getDate() >= 2)
            valid.isUnSignValid = true
          that.backOutValidity.push(valid)
        })
        this.events = response.data

      })
    },
    unSignUserFromEvent(id) {
      var postData = {
        event_id: id,
        user_id: this.$store.state.user.id
      }
      this.$http.post(removeSignedUser, postData).then(response => {
        this.$swal('Confirmed!', "You are no longer signed up for this event!", 'success').then((result) => { location.reload() })
      })
    }
  }
}

</script>
<style>
#loadSignedEventsBox {
  border: solid 3px;
  border-radius: 10px 10px 10px 10px;
  width: 25%;
  padding: 10px;
  margin-left: 15px;
  float: left;
}

#loadSignedEventsBox h1 {
  font-size: 16pt;
}

</style>
