<template>
  <div>
    <nav_bar></nav_bar>
    <router-view></router-view>
  </div>
</template>
<script>
import nav_bar from './nav_bar'
export default {
  components: {
    nav_bar,
  }
}

</script>
