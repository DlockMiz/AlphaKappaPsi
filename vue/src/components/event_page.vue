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
        this.$router.push('/')
        this.$swal('You must be logged in to see!', "", 'error')
      }
      if(this.$store.state.user.dues == 'not payed'){
        this.$router.push('/')
        this.$swal('LMAO nice try','Go pay your dues', 'error')
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
