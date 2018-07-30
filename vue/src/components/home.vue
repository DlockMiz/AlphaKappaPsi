<template>
  <div>
    <div style="width: 33%; float:left; border-left: solid green 3px;border-right: solid green 3px; height: 1000px; margin-left: 10px;">
      <center>TWITTER / INSTAGRAM FEED</center>
    </div>
    <div style="width: 33%; float:left; border-left: solid blue 3px;border-right: solid blue 3px; height: 1000px; margin-left: 10px;">
      <!-- <div style="text-align:center; width: 40%; float:left; margin-left: 50px;">
        <div>Comments</div>
        <textarea v-model="comments" style="width: 100%; height: 300px;"></textarea>
        <button @click="submitComments()">Submit Comments</button>
      </div>
      <div style="width: 40%; float:left;">
        <div style="line-height: 30px; float: left; margin-left: 20px; font-size: 15px; width:40%; height: 400px;">If you have any suggestions to make the website flow better or any small quality of life improvments, please leave a comment, anything I can do to improve the site goes a long way for everyone! <strong><br><br>Thanks - Daniel</strong>
        </div>
      </div> -->
      <center>UPCOMING EVENTS FEED</center>
    </div>
    <div style="width: 500px; float:left; border-left: solid black 3px; border-right: solid black 3px; margin-left: 10px;">
      <div class="facebook" style="float:right;" id="fb-root"></div>
      <div class="fb-page facebook" data-href="https://www.facebook.com/AKPsiMizzou" data-tabs="timeline" data-width="500" data-height="1000" data-small-header="true" data-adapt-container-width="false" data-hide-cover="true" data-show-facepile="false">
        <blockquote cite="https://www.facebook.com/AKPsiMizzou" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/AKPsiMizzou">Alpha Kappa Psi - Mizzou</a></blockquote>
      </div>
    </div>
  </div>
</template>
<script>
import { submitComments } from '../router/config.js'
window.$ = window.jQuery = require('jquery');

$(window).on('load', function() {
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.1';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
  $(".facebook").delay(2000).animate({ opacity: 1 }, 2000)
})

export default {
  data() {
    return {
      comments: null,
    }
  },

  mounted: function() {},

  methods: {

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

</style>
