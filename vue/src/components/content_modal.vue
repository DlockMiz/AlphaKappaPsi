<template>
  <div>
    <div id="backgroundModalWrapper">
      <div id="modalWrapper">
        <slot></slot>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'modal',
  data() {
    return {

    }
  },
  mounted: function() {
    // var body = document.getElementsByTagName('body')
  }
}

</script>
<style>

#modalWrapper {
  border: black solid 3px;
  background-color: white;
  overflow: scroll;
  padding: 20px;
  width: 50%;
  margin:auto;
  margin-top: 10%;
  max-height: 500px;
  z-index: 1;
}

#backgroundModalWrapper {
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  position: fixed;
  background-color: rgba(0,0,0,.5);
}

</style>
