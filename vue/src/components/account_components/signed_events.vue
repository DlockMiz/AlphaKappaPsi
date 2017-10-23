<template>
  <div>
    <div class="select is-info" style="margin: 15px;">
      <select>
        <option>Service</option>
        <option>Brotherhood</option>
      </select>
    </div>
    <div v-for="event in events">
      <div id="loadSignedEventsBox">
        <center>
          <h1>{{event.title}}</h1></center>
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
