<template>
  <div style="margin-top: 60px">
    <nav class="level header">
      <p class="level-item has-text-centered">
        <a class="link is-info" href="/">Home</a>
      </p>
      <p class="level-item has-text-centered">
        <a @click="checkDues()" class="link is-info">Current Events</a>
      </p>
      <p class="level-item has-text-centered">
        <a href="/">
          <img  src="../assets/images/akp_logo.png" alt="" style="height: 50px;">
        </a>
      </p>
      <p class="level-item has-text-centered">
        <a class="link is-info" href="#/executive_board">Executive Board</a>
      </p>
      <p class="level-item has-text-centered">
        <a href="http://mizzou.orgsync.com/org/akpsi" class="link is-info">About Us</a>
      </p>
    </nav>
    <hr>
  </div>
</template>
<script>
export default {
  data() {
    return {}
  },
  methods: {
    checkDues() {
      if (this.$store.state.user) {
        if (this.$store.state.user.dues == 'not payed') {
          this.$swal('WOAH!', 'You should go pay your dues, contact the treasurer.', 'error')
          return
        } else
          this.$router.push('/event_page')
      } else if(this.$store.state.user == null)
        this.$swal('Error', 'Please login to view this page!', 'error')
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

p.level-item.has-text-centered {
  width: 10%;
}

.header a:hover {
  box-shadow: 0px 0px 5px 5px #adc6e6;
  background-color: #bad0ec;
}

</style>
