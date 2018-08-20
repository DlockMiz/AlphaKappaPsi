<template>
  <div>
    <center><img id="loading" style="margin-top: 100px;" src="../../assets/images/loading.gif" height="200" width="200"></center>
    <div id="chapterCommentWrapper">
      <div v-if="showChapterList">
        <a v-show="$store.state.user.status == '1' " @click="propsData.showModal = true" class="button is-info" style="margin-bottom: 10px;">Create New Chapter</a>
        <modal :propsData="propsData">
          <chapter-comments-form :propsData="propsData"></chapter-comments-form>
        </modal>
        <div style="width: 95%;">
          <vue-good-table :columns="columns" :rows="events" :paginate="true" :lineNumbers="true" :onClick="viewEvent" />
        </div>
      </div>
      <div v-if="showChapterInfo">
        <chapter-event-comment :clicked_event="clicked_event" v-on:close-event="showChapterList = true; showChapterInfo = false;"></chapter-event-comment>
      </div>
    </div>
  </div>
</template>
<script>
var methods = {}
import modal from '../content_modal'
import ChapterCommentsForm from './add_event_forms/chapter_comments_form'
import ChapterEventComment from './chapter_event_comment'
import { getEvents, addEvent, userSignedEvent, editEvent, deleteEvent } from '../../router/config'
window.$ = window.jQuery = require('jquery');

methods.loadChapters = function() {
  $('#loading').show()
  $('#chapterCommentWrapper').hide()
  var postData = {
    event_type: 'chapter_comments'
  }
  this.$http.post(getEvents, postData).then(response => {
    $('#loading').hide()
    $('#chapterCommentWrapper').show()
    this.events = response.data
  })
}

export default {
  name: 'chapter_comments',
  data() {
    return {
      showChapterList: true,
      showChapterInfo: false,
      propsData: {
        showModal: this.showModal
      },
      viewEvent: function(row, index) {
        this.$parent.showChapterList = false
        this.$parent.showChapterInfo = true
        this.$parent.clicked_event = row
      },
      events: [],
      clicked_event: null,
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
    ChapterCommentsForm,
    ChapterEventComment
  },
}

</script>
