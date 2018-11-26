<template>
  <div v-if="propsData.showModal">
    <div id="backgroundModalWrapper">
      <div id="modalWrapper">
        <i @click="$emit('close-modal')" class="fa fa-window-close fa-2x" aria-hidden="true" style="color: red; cursor: pointer;"></i>
        <slot></slot>
      </div>
    </div>
  </div>
</template>
<script>
var methods = {}
export default {
  name: 'modal',
  data() {
    return {}
  },
  methods: methods,
  props: ['propsData'],
  mounted: function() {
    this.$on('close-modal', function() {
      this.propsData.showModal = false
    })
  }
}

</script>
<style>
#modalWrapper {
  border: black solid 3px;
  background-color: white;
  overflow: auto;
  padding: 20px;
  width: 50%;
  margin: auto;
  margin-top: 5%;
  z-index: 1000;
}

#backgroundModalWrapper {
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  position: fixed;
  background-color: rgba(0, 0, 0, .5);
}

</style>
