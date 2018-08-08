<template>
  <div style="width: 60%; margin: auto;">
    <center>
      <h1 class="title is-2">New Chapter Comments</h1>
      <input class="input is-info inputChapter" type="text" placeholder="Title...">
      <datepicker class="input is-info inputChapter" placeholder="Date..." :config="{ dateFormat: 'Y/m/d', static: true }"></datepicker>
      <input class="input is-info inputChapter" type="text" placeholder="Location...">
    </center>
    <div>
      <center>
        <a class="button is-info inputChapter" @click="$swal('success','success','success')">Submit</a>
      </center>
    </div>
  </div>
</template>
<script>
import Datepicker from 'vue-bulma-datepicker'


export default {
  data() {
    return {

    }
  },
  components: {
    Datepicker
  }
}

</script>
<style>
.inputChapter {
  /*width: 100%;*/
  margin-top: 10px;
  /*float: left;*/
}

.flatpickr-wrapper {
  display: block !important;
}
.flatpickr-calendar{
  position: relative !important; 
}


</style>
