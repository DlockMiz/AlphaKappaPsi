<template>
  <div style="margin-top: 40px">
    <nav class="level header">
      <p class="level-item has-text-centered">
        <a class="link is-info" href="/">Home</a>
      </p>
      <p class="level-item has-text-centered">
        <a class="link is-info" @click="validateLogin()">Current Events</a>
      </p>
      <p class="level-item has-text-centered">
        <a href="/">
          <img  src="../assets/images/akp_logo.png" alt="" style="height: 50px;">
        </a>
      </p>
      <p class="level-item has-text-centered">
        <a class="link is-info">Executive Board</a>
      </p>
      <p class="level-item has-text-centered">
        <a class="link is-info">About Us</a>
      </p>
    </nav>
    <hr>
  </div>
</template>
<script>
export default{
  data(){
    return{

    }
  },
  methods:{
    validateLogin(){
      if(this.$store.state.user == null){
        alert("== Please Login To View This Page ==")
      } else{
        this.$router.push('/event_page')
      }
    }
  }
}

</script>
<style>
.header a {
  font-size: 22pt;
  color: #225089;
  border-radius: 10px 10px 10px 10px;
}

.header a:hover {
  box-shadow: 0px 0px 5px 5px #adc6e6;
  background-color: #bad0ec;
}

</style>
