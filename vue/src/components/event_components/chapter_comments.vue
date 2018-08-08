<template>
  <div>
    <a v-show="$store.state.user.status == '1' " @click="propsData.showModal = true" class="button is-info" style="margin-bottom: 10px;">Create New Chapter</a>
    <modal :propsData="propsData">
      <chapter-comments-form :propsData="propsData"></chapter-comments-form>
    </modal>
    <div style="width: 95%;">
      <vue-good-table :columns="columns" :rows="events" :paginate="true" :lineNumbers="true" />
      <!-- <vue-good-table :columns="columns" :rows="events" :paginate="true" :lineNumbers="true" :onClick="viewUser" /> -->
    </div>
  </div>
</template>
<script>
var methods = {}
import modal from '../content_modal'
import ChapterCommentsForm from './add_event_forms/chapter_comments_form'
import { getEvents, addEvent, userSignedEvent, editEvent, deleteEvent } from '../../router/config'
window.$ = window.jQuery = require('jquery');

methods.loadChapters = function() {
  var postData = {
    event_type: 'chapter_comments'
  }
  this.$http.post(getEvents, postData).then(response => {
    this.events = response.data
  })
}

export default {
  name: 'chapter_comments',
  data() {
    return {
      propsData: {
        showModal: this.showModal
      },
      events: [],
      columns: [{
          label: 'Title',
          field: 'title',
          filterable: true,
        },
        {
          label: 'Location',
          field: 'location',
          filterable: true,
        },
        {
          label: 'Date',
          field: 'date',
          type: 'date',
          filterable: true,
          inputFormat: 'YYYY/MM/DD',
          outputFormat: 'MMMM Do',
        },
      ],
    }
  },
  mounted: function() {
    this.loadChapters()
  },
  watch: {
    propsData: {
      handler: function(value) {
        if (this.propsData.showModal == false) {
          this.loadChapters()
        }
      },
      deep: true,
    }
  },
  methods: methods,
  components: {
    modal,
    ChapterCommentsForm
  },
}

</script>
<style>


</style>
