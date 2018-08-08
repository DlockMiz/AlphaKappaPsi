<template>
  <div style="font-size: 60pt;top:0;left:0;background-color:white;position: fixed; width: 100%;">
    <center>
      I'M BREAKING UP WITH YOU.
    </center>
  </div>
</template>

<!-- <template>
  <div>
    <div style="width: 32%; float:left; border-left: solid green 3px;border-right: solid green 3px; height: 1000px; margin-left: 10px;">
      <center>TWITTER / INSTAGRAM FEED</center>
      <button @click="googleSheets()">test</button>
    </div>
    <div style="width: 32%; float:left; border-left: solid blue 3px;border-right: solid blue 3px; height: 1000px; margin-left: 10px;">
      
      <center>UPCOMING EVENTS FEED</center>
    </div>
    <div id="pageContainer" style="width: 32%; float:left; border-left: solid black 3px; border-right: solid black 3px; margin-left: 10px;">
      <center><iframe class="fbIframe facebook" src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FAKPsiMizzou&tabs=timeline&width=500&height=1000&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="500" height="1000" style="border:none;" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
      </center>
    </div>
  </div>
</template>
<script>
import { submitComments } from '../router/config.js'
window.$ = window.jQuery = require('jquery');

export default {
  data() {
    return {
      comments: null,
    }
  },

  mounted: function() {
    $(".facebook").delay(1000).animate({ opacity: 1 }, 3000)
  },

  methods: {

    googleSheets() {
      var sheetId = '1yRwjUaXYb9mazn3K8ZHu-fcImWIYoMPWKsjyg2dSIQY'
      var apiKey = 'AIzaSyCEMLeO6dZ_KY4N_3-3YWwYd7ZMHm2lrlc'
      this.$http.get('https://sheets.googleapis.com/v4/spreadsheets/' + sheetId + '/values/Fundraising!A2:A10?key=' + apiKey).then(response => {
      })
    },

    submitComments() {
      var postData = {
        comments: this.comments,
        name: this.$store.state.user.name
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

.facebook {
  opacity: 0;
  font-size: 21px;
  text-align: center;
}

#pageContainer {
  overflow-x: scroll;  
  z-index: 1;
}

#pageContainer iframe {
  position: relative;
  z-index: 0;
}

</style> -->

<!-- <div style="text-align:center; width: 40%; float:left; margin-left: 50px;">
        <div>Comments</div>
        <textarea v-model="comments" style="width: 100%; height: 300px;"></textarea>
        <button @click="submitComments()">Submit Comments</button>
      </div>
      <div style="width: 40%; float:left;">
        <div style="line-height: 30px; float: left; margin-left: 20px; font-size: 15px; width:40%; height: 400px;">If you have any suggestions to make the website flow better or any small quality of life improvments, please leave a comment, anything I can do to improve the site goes a long way for everyone! <strong><br><br>Thanks - Daniel</strong>
        </div>
      </div> -->
