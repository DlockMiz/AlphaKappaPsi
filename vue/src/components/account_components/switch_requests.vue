<template>
  <div>
    <center><img id="loading" style="margin-top: 100px;" src="../../assets/images/loading.gif" height="200" width="200"></center>
    <div id="switchWrapper">
      <div v-for="(event, index) event in events">
        <div class="requestBox">
          <center>
            <h1 style="margin:5px;" class="title is-4">{{event.title}}</h1>
            <h1 style="margin:5px;" class="subtitle is-6">Posted By: {{users[index].name}}</h1>
            <button style="margin:5px;" @click="switchUser(event.event_id, users[index].id, event.id)" class="button is-info">Switch</button>
          </center>
        </div>
      </div>
      <div v-if="events.length == 0">
        There is currently no one requesting to switch out of an event.
      </div>
    </div>
  </div>
</template>
<script>
import { getAllSwitchRequests, switchRequestedUser } from '../../router/config'
export default {
  data() {
    return {
      events: [],
      users:[]
    }
  },

  mounted: function() {
    this.loadEvents()
  },

  methods: {
    loadEvents() {
      $('#loading').show()
      $('#switchWrapper').hide()
      this.$http.post(getAllSwitchRequests).then(response => {
        $('#loading').hide()
        $('#switchWrapper').show()
        this.events = response.data[0]
        this.users = response.data[1]
      })
    },
    switchUser(eventid, posterid, switchid) {

      var postData = {
        user_id: this.$store.state.user.id,
        poster_id: posterid,
        event_id: eventid,
        switch_id: switchid
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
          this.$http.post(switchRequestedUser, postData).then(response => {
            if (response.data == 300)
              this.$swal('No No No', "You can't replace yourself! Or something you are already signed up for!", 'error')
            else
              this.$swal('Nice!', "You have taken this event!", 'success').then((result) => { location.reload() })
          })
        } else
          return
      })
    }
  }
}

</script>
<style>
.requestBox {
  border: 3px solid black;
  width: 20%;
  float: left;
  margin: 10px;
  border-radius: 10px 10px 10px 10px;
}

</style>
