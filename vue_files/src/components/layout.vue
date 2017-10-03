<template>
  <div style="padding:0;">
    <header_bar></header_bar>
    <left_menu></left_menu>
    <div id="home">
      <router-view></router-view>
    </div>
  </div>
</template>
<script>
import left_menu from './left-menu.vue'
import header_bar from './header.vue'

export default {

  components: {
    left_menu,
    header_bar
  }

}

</script>

<style>
#home {
  overflow: scroll;
  position: absolute;
  left: 250px;
  width: calc(100vw - 250px);
  min-width: calc(100vw - 250px);
  top: 92px;
  bottom: 0;
  border-bottom: solid;
  border-right: solid;
  border-width: 5px;
}

</style>
