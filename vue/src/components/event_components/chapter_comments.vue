<template>
  <div>
    <modal>
    	<chapter-comments-form></chapter-comments-form>
    </modal>
  </div>
</template>
<script>
var methods = {}
import modal from '../content_modal'
import ChapterCommentsForm from './add_event_forms/chapter_comments_form'
window.$ = window.jQuery = require('jquery');

export default {
  name: 'chatper_comments',
  data() {
    return {
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
