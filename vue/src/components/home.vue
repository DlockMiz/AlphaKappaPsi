<template>
  <div>
    <div style="width: 50%; float:left;">
    </div>
    <div style="width: 50%; float:left;">
    	<center>Comments</center>
    	<center><textarea v-model="comments" style="width: 65%; height: 400px;"></textarea></center>
    	<center><button @click="submitComments()">Submit Comments</button></center>
    </div>
  </div>
</template>
<script>
import{ submitComments } from '../router/config.js'


export default {
  data() {
    return {
    	comments: '',
    }
  },

  methods:{
  	submitComments(){
  		var postData = {
  			comments: this.comments
  		}

  		this.$http.post(submitComments, postData).then(response =>{
  			console.log(response.data)
  			alert('Thanks for your comments.')
  			location.reload();
  		})
  	}
  }
}

</script>
<style>
#homeBody b {
  font-size: 16pt;
}

</style>
