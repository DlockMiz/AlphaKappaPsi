<template>
  <div style="margin-top: 50px;">
    <div id="eventBox" v-for="event in events">
      <h1>{{event.title}}</h1>
      <h1>{{event.time}}</h1>
      <h1>{{event.location}}</h1>
      <h1>{{event.description}}</h1>
      <a class="button is-info" @click="signUp(event.id)">Sign Up</a>
    </div>
    <div id="addBox">
      <input type="text" name="Title">
      <input type="text" name="Time">
      <input type="text" name="Location">
      <input type="text" name="Description">
    </div>
  </div>
</template>
<style>
#eventBox {
  border: solid;
  width: 25%;
}

</style>
<script>
import { getEvents } from '../router/config'

export default {
  data() {
    return {
      events: []
    }
  },

  mounted: function() {
    this.getServiceEvents()
  },

  methods: {
    getServiceEvents() {
      this.$http.post(getEvents).then(response => {
        var that = this
        response.data.forEach(function(event) {
          var obj = {
            id: event.id,
            title: event.title,
            location: event.location,
            date: event.date,
            time: event.time,
            description: event.description
          }
          that.events.push(obj)
        })
      })
      console.log(this.events)
    },
    signUp(id){
      console.log(id)
    }
  }
}

</script>
