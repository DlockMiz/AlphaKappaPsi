<template>
  <div style="width: 60%; margin: auto;">
    <center>
      <h1 class="title is-2">New Chapter Comments</h1>
      <input class="input is-info inputChapter" type="text" v-model="form.title" placeholder="Title...">
      <datepicker class="input is-info inputChapter" placeholder="Date..." v-model="form.date" :config="{ dateFormat: 'Y/m/d', static: true }"></datepicker>
      <input class="input is-info inputChapter" type="text" v-model="form.location" placeholder="Location...">
    </center>
    <div>
      <center>
        <a class="button is-info inputChapter" @click="createChapterComments()">Submit</a>
      </center>
    </div>
  </div>
</template>
<script>
import Datepicker from 'vue-bulma-datepicker'
import { addEvent } from '../../../router/config'

export default {
  data() {
    return {
      form: {
        title: null,
        location: null,
        date: null,
      }
    }
  },
  props: ['propsData'],
  components: {
    Datepicker
  },
  methods: {
    createChapterComments() {
      var users = { "id": [] }

      var postData = {
        event_type: 'chapter_comments',
        title: this.form.title,
        location: this.form.location,
        date: this.form.date,
        signed_users: JSON.stringify(users),
        attended_users: JSON.stringify(users)
      }
      this.$http.post(addEvent, postData).then(response => {
        if (response.data == 'success') {
          this.$swal('', 'A New Chapter Comment is Now Posted', 'success').then((result) => {
            this.propsData.showModal = false
          })
        }
      })
    }
  }
}

</script>
<style>
.inputChapter {
  margin-top: 10px;
}

.flatpickr-wrapper {
  display: block !important;
}

.flatpickr-calendar {
  position: relative !important;
}

</style>
