<template>
  <div>
    <div id="commentBoxWrapper">
      <a @click="$emit('close-event')"><i style="color:darkslateblue;" class="fa fa-angle-left fa-1x" aria-hidden="true"> Back</i></a>
      <hr>
      <div v-if="$store.state.user.status != '1'">
        <center>
          <div style="width: 50%;">
            <h1 class="title is-2">Submit a Comment for {{clicked_event.title}}</h1>
            <sub>Date:{{clicked_event.date}}</sub>
            <textarea v-model="comment" class="textarea is-info" type="text" placeholder="Place comments here..."></textarea>
            <a @click="submit()" style="margin-top: 10px;" class="button is-info">Submit Comment</a>
          </div>
        </center>
      </div>
      <div v-if="$store.state.user.status == '1'">
        <h1 class="title is-4">Comments from {{clicked_event.title}} on {{clicked_event.date}}</h1>
        <div id="commentsBox" v-for="comments in loadedComments">
          {{comments.comment}}
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { getChapterComments, submitChapterComment } from './../../router/config'

export default {
  data() {
    return {
      comment: null,
      loadedComments: []
    }
  },
  props: ['clicked_event'],
  methods: {
    submit() {
      var postData = {
        chapter_id: this.clicked_event.id,
        comment: this.comment
      }
      this.$http.post(submitChapterComment, postData).then(response => {
        if (response.data = 'success') {
          this.$swal('Success', 'Your Comment has been Submitted Anonymously', 'success')
        }
      })
    },
    loadComments() {
      $('#loading').show()
      $('#commentBoxWrapper').hide()
      var postData = {
        chapter_id: this.clicked_event.id
      }
      this.$http.post(getChapterComments, postData).then(response => {
        $('#loading').hide()
        $('#commentBoxWrapper').show()
        this.loadedComments = response.data
      })
    }
  },
  mounted: function() {
    this.loadComments()
  }
}

</script>
<style>
#commentsBox {
  border: solid black 2px;
  border-radius: 5px 5px 5px 5px;
  width: 50%;
  padding: 10px;
  margin-top: 20px;
}

</style>
