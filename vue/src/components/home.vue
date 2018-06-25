<template>
  <div>
    <div style="width: 50%; float:left;">
    </div>
    <div style="width: 50%; float:left;">
      <center>Comments</center>
      <center>
        <textarea v-model="comments" style="width: 65%; height: 400px;"></textarea>
      </center>
      <center>
        <button @click="submitComments()">Submit Comments</button>
        <button @click="googleSheets()">Google Sign In</button>
      </center>
    </div>
  </div>
</template>
<script>
import { submitComments } from '../router/config.js'


export default {
  data() {
    return {
      comments: '',
    }
  },

  mounted: function(){
  },

  methods: {
    googleSheets(){
      var sheetId = '1yRwjUaXYb9mazn3K8ZHu-fcImWIYoMPWKsjyg2dSIQY'
      var apiKey = 'AIzaSyCEMLeO6dZ_KY4N_3-3YWwYd7ZMHm2lrlc'
      this.$http.get('https://sheets.googleapis.com/v4/spreadsheets/'+sheetId+'/values/Fundraising!A2:A10?key='+apiKey).then(response =>{
        console.log(response.data)
      })
    },

    submitComments() {
      var postData = {
        comments: this.comments
      }

      this.$http.post(submitComments, postData).then(response => {
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
