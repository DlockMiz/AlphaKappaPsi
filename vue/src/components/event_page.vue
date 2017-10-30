<template>
  <div>
    <event_option_bar></event_option_bar>
    <div id="activitiesContentBox">
      <router-view></router-view>
    </div>
  </div>
</template>
<script>
import event_option_bar from './event_components/event_options_menu'

var reloaded = false
export default {
  components: {
    event_option_bar,
  },
  methods: {
    checkUserLogin() {
      if (this.$store.state.user == null) {
        alert('== Please login to view this page. ==')
        this.$router.push('/')
      }
    },
  },
  mounted: function() {
    this.checkUserLogin()
  }
}

</script>
<style>
#activitiesContentBox {
  margin-left: 25%;
}

</style>
