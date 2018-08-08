<template>
  <div>
    <i v-show="$store.state.user.status == '1' " @click="propsData.showModal = true" id="addEventIcon" class="fa fa-plus-square fa-2x" aria-hidden="true"></i>
    <modal :propsData="propsData">
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
  name: 'chapter_comments',
  data() {
    return {
      propsData: {
        showModal: this.showModal
      }
    }
  },
  mounted: function(){  },
  methods: methods,
  components: {
    modal,
    ChapterCommentsForm
  },
}

</script>
<style>


</style>
