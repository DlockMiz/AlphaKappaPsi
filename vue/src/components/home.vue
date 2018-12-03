<template>
  <div>
    <div style="width: 30%; height: 1000px; float:left; border-left: solid black 3px;border-right: solid black 3px; height: 1000px; margin-left: 30px;">
      <div id="twitter-time">
        <Timeline style="height: 1000px;overflow: scroll;" :id="'akpsi_mizzou'" :sourceType="'profile'"/>
      </div>
    </div>
    <div style="width: 32%; float:left; height: 1000px; margin-left: 10px;">
      <!-- <div style="text-align:center; width: 40%; float:left; margin-left: 50px;">
        <div>Comments</div>
        <textarea v-model="comments" style="width: 100%; height: 300px;"></textarea>
        <button @click="submitComments()">Submit Comments</button>
      </div>
      <div style="width: 40%; float:left;">
        <div style="line-height: 30px; float: left; margin-left: 20px; font-size: 15px; width:40%; height: 400px;">If you have any suggestions to make the website flow better or any small quality of life improvments, please leave a comment, anything I can do to improve the site goes a long way for everyone! <strong><br><br>Thanks - Daniel</strong>
        </div>
      </div> -->
      <center>
        <strong>
        <div style="line-height: 70px;font-size: 16pt;">Alpha Kappa Psi recognizes that
          <br>We live in deeds, not years;
          <br>In thought, not breath,
          <br>In service, not in figures on the dial.
          <br>We count time by heartthrobs,
          <br>When they beat for God, for man, for duty;
          <br>He lives most who thinks most,
          <br>Is noblest, acts the best.</div>
        </strong>
      </center>
    </div>
    <div id="pageContainer" style="width: 32%; float:left; border-left: solid black 3px; border-right: solid black 3px; margin-left: 10px;">
      <center><iframe class="fbIframe facebook" src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FAKPsiMizzou&tabs=timeline&width=500&height=1000&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="500" height="1000" style="border:none;" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
      </center>
    </div>
  </div>
</template>
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
<script>
import { submitComments } from '../router/config.js'
import Timeline from 'vue-tweet-embed/timeline'
window.$ = window.jQuery = require('jquery');

export default {
  data() {
    return {
      comments: null,
    }
  },

  mounted: function() {
    $(".facebook").delay(1000).animate({ opacity: 1 }, 3000)
    $("#twitter-time").delay(1000).animate({ opacity: 1 }, 3000)
  },

  methods: {
    googleSheets() {
      var sheetId = '1yRwjUaXYb9mazn3K8ZHu-fcImWIYoMPWKsjyg2dSIQY'
      var apiKey = 'AIzaSyCEMLeO6dZ_KY4N_3-3YWwYd7ZMHm2lrlc'
      this.$http.get('https://sheets.googleapis.com/v4/spreadsheets/' + sheetId + '/values/Fundraising!A2:A10?key=' + apiKey).then(response => {})
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
  },
  components: {
    Timeline
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

#twitter-time{
  opacity: 0;
}

</style>
