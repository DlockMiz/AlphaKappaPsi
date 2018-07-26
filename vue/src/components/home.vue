<template>
  <div>
    <div style="text-align:center; width: 20%; float:left; margin-left: 50px;">
      <div>Comments</div>
      <textarea v-model="comments" style="width: 100%; height: 300px;"></textarea>
      <button @click="submitComments()">Submit Comments</button>
    </div>
    <div style="width: 15%; float:left;">
      <div style="line-height: 40px; float: left; margin-left: 20px; font-size: 15px; width:100%; height: 300px;">If you have any suggestions to make the website flow better or any small quality of life improvments, please leave a comment, anything I can do to improve the site goes a long way for everyone! <strong><br><br>Thanks - Daniel</strong>
      </div>
    </div>
    <div style="float:right;">
      <div style="float:right;" id="fb-root"></div>
      <div class="fb-page" data-href="https://www.facebook.com/AKPsiMizzou" data-tabs="timeline" data-width="500" data-height="1000" data-small-header="true" data-adapt-container-width="false" data-hide-cover="true" data-show-facepile="false">
        <blockquote cite="https://www.facebook.com/AKPsiMizzou" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/AKPsiMizzou">Alpha Kappa Psi - Mizzou</a></blockquote>
      </div>
    </div>
  </div>
</template>
<script>
import { submitComments } from '../router/config.js'


export default {
  data() {
    return {
      comments: null,
    }
  },

  mounted: function() {
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s);
      js.id = id;
      js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.1';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

  },

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

</style>
