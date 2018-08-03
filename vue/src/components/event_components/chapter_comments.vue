<template>
  <div>
    <i v-show="$store.state.user.status == '1' " @click="addChapterEvent()" id="addEventIcon" class="fa fa-plus-square fa-2x" aria-hidden="true"></i>
  </div>
</template>
<script>
var methods = {}
import Datepicker from 'vue-bulma-datepicker'
window.$ = window.jQuery = require('jquery');

methods.addChapterEvent = function() {
  var date_input = "<datepicker placeholder='Date...' :config='{ dateFormat: 'Y/m/d', static: true }' style='width:280px !important;'></datepicker>"

  const { value: formValues } = this.$swal({
    title: 'New Chapter Comments',
    html: '<input type="text" id="datepicker">' + '<input id="swal-input2" class="swal2-input">',
    onOpen: function() {
    	$('#datepicker').datepicker();
    },
    focusConfirm: false,

    preConfirm: () => {
      return [
        document.getElementById('swal-input1').value,
        document.getElementById('swal-input2').value
      ]
    }
  })

  if (formValues) {
    this.$swal(json.stringify(formValues))
  }
}

export default {
  data() {
    return {

    }
  },
  methods: methods,
  components: {
    Datepicker,
  },
}

</script>
