<template>
  <div>
    <div v-for="event in events">
      <div id="loadSignedEventsBox">
        <center><h1>{{event.title}}</h1></center>
        <hr>
        <p>Time: {{event.time}}</p>
        <hr>
        <p>Date: {{event.date}}</p>
        <hr>
        <p>Location: {{event.location}}</p>
      </div>
    </div>
  </div>
</template>
<script>
import { loadSignedEvents } from '../../router/config'

export default {
  data() {
    return {
      events: []
    }
  },

  mounted: function() {
    this.loadEvents()
  },

  methods: {
    loadEvents() {
      this.$http.post(loadSignedEvents, this.$store.state.user.id).then(response => {
        this.events = response.data
        console.log(this.events)
      })
    }
  }
}

</script>
<style>
#loadSignedEventsBox {
  border: solid 3px;
  width: 25%;
  padding: 10px;
  margin-left: 15px;
  float: left;
}

</style>
