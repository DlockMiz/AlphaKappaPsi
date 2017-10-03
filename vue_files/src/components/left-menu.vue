<template>
  <div>
    <div id="left_menu">
      <div class="col-md-12">
        <div class="option_tab">
          <v-btn flat class="left_btn" @click="goToHome">Home Page</v-btn>
        </div>
        <div class="option_tab">
          <v-btn flat class="left_btn" @click="goToAbout">About this Webpage</v-btn>
        </div>
        <div class="option_tab">
          <v-btn flat class="left_btn" @click="goToIntern">Internship 2017</v-btn>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  methods: {
    goToHome() {
      this.$router.push('/home')
    },
    goToAbout() {
      this.$router.push('/about')
    },
    goToIntern() {
      this.$router.push('/internship_2017')
    }
  }
}

</script>
<style>
#left_menu {
  width: 250px;
  background-color: rgb(206, 206, 206);
  overflow: scroll;
  position: fixed;
  top: 92px;
  bottom: 0;
  border-left: solid;
  border-bottom: solid;
  border-right: solid;
  border-width: 5px;
}

.option_tab {
  height: 100px;
  border-bottom: solid;
  border-width: 5px;
}

.left_btn {
  width: 100%;
  height: 100%;
  margin: 0;
}

</style>
