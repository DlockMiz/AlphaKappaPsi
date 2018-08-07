<template>
  <div style="width: 100%; height: 500px;">
    <center>
      <h1 class="title is-2">New Chapter Comments</h1>
      <div style="width: 30%;">
        <input class="input is-info inputChapter" type="text" placeholder="Title...">
        <datepicker class="input is-info inputChapter" placeholder="Date..." :config="{ dateFormat: 'Y/m/d', static: true }"></datepicker>
        <input class="input is-info inputChapter" type="text" placeholder="Location...">
      </div>
    </center>
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
	.inputChapter{
		width: 100%;
		margin: 10px;
		float: left;
	}
</style>
