<template>
  <div>
    <center>
      <div style="margin-bottom: 20px;">
        <div>Make Masterdoc Event?</div>
        <label class="radio">
          <input style="margin-left: 10px;" type="radio" class="masterdocType" name="doc" value="1"> Yes
        </label>
        <label class="radio">
          <input style="margin-left: 10px;" type="radio" class="masterdocType" name="doc" value="0" checked> No
        </label>
        <hr>
        <div>Only Selected Can View:</div>
        <label class="radio">
          <input class="selectedType" type="radio" name="fund_type" value="6" checked> Football
        </label>
        <label class="radio">
          <input style="margin-left: 20px;" class="selectedType" type="radio" name="fund_type" value="3"> Basketball
        </label>
      </div>
      <hr>
      <div style="margin-bottom: 20px;">
        <div>Only Selected Can View:</div>
        <label class="radio">
          <input class="selectedView" type="checkbox" name="active" value="2" checked> Active
        </label>
        <label class="radio">
          <input style="margin-left: 20px;" class="selectedView" type="checkbox" name="pledge" value="3" checked> Pledge
        </label>
      </div>
    </center>
    <center>
      <div style="width: 60%;">
        <input v-model="title" class="inputs input is-info" type="text" placeholder="Title...">
        <input v-model="time" class="inputs input is-info" type="text" placeholder="Time...">
        <datepicker v-model="date" class="inputs is-info" placeholder="Date..." :config="{ dateFormat: 'Y/m/d', static: true }"></datepicker>
        <input v-model="location" class="inputs input is-info" type="text" placeholder="Location...">
        <input v-model="max" class="inputs input is-info" type="number" placeholder="Max Users...">
        <textarea v-model="desc" class="inputs textarea is-info" type="text" placeholder="Description..." style="width: 50%;"></textarea>
        <center>
          <a class="button is-info" @click="addBrotherEvent()" style="margin-top: 10px;">Add Event</a>
        </center>
      </div>
    </center>
  </div>
</template>
<script>
import { addEvent } from '../../../router/config'
import Datepicker from 'vue-bulma-datepicker'


export default {
  data() {
    return {
      title: null,
      time: null,
      date: null,
      location: null,
      max: null,
      desc: null,
      masterdoc: null
    }
  },
  components: {
    Datepicker
  },
  props: ['propsData'],
  methods: {
    addBrotherEvent() {

      if (this.title == null || this.time == null || this.date == null || this.location == null || this.max == null) {
        this.$swal('Error', 'You must fill out every field!', 'error')
        return;
      }

      var type = document.getElementsByClassName('selectedType')
      var value;
      if (type[0].checked)
        value = type[0].value
      else if (type[1].checked)
        value = type[1].value

      var users = { "id": [] }
      var postData = {
        title: this.title,
        location: this.location,
        date: this.date,
        time: this.time,
        description: this.desc,
        event_type: "fundraising",
        month: this.date.split("/")[1],
        signed_users: JSON.stringify(users),
        max_users: this.max,
        hours: value,
        attended_users: JSON.stringify(users),
        masterdoc: null,
        complete: 0,
        censor_perms: {}
      }

      var masterdoc = document.getElementsByClassName('masterdocType');
      var radios = document.getElementsByClassName('selectedView');      
      var censor_perms = { id: ['1', '0', '0'] }
      for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked)
          censor_perms.id[i + 1] = radios[i].value
      }
      if(masterdoc[0].checked == true){
        postData.masterdoc = 1
      } else{
        postData.masterdoc = 0
      }
      
      postData.censor_perms = JSON.stringify(censor_perms)
      this.$http.post(addEvent, postData).then(response => {
        this.$swal('Nice', 'A New Fundraising Event Has Been Created!', 'success').then((result) => {
          this.propsData.showModal = false
        })
      })
    },
  }
}

</script>
<style>
.inputs {
  margin-top: 20px;
  width: 100% !important;
}

.flatpickr-wrapper {
  display: block !important;
}

.flatpickr-calendar {
  position: relative !important;
}

</style>
