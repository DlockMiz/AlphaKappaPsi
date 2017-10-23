<template>
  <div>
    <event_option_bar></event_option_bar>
    <div id="activitiesContentBox">
      <router-view></router-view>
    </div>
  </div>
</template>
<script>
import event_option_bar from './event_options_bar'

var reloaded = false
export default {
  components: {
    event_option_bar,
  },
}

</script>
<style>
#activitiesContentBox {
  margin-left: 25%;
}

</style>
