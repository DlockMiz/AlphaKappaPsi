<template>
  <div>
    <event_option_bar></event_option_bar>
    <router-view></router-view>
  </div>
</template>
<script>
import event_option_bar from './event_options_bar'

export default {
  components: {
    event_option_bar,
  }
}

</script>
