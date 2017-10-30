<template>
  <div>
    <aside class="menu">
      <p class="menu-label">
        My Account
      </p>
      <hr>
      <ul class="menu-list">
        <li><a @click="loadPage('signed_events')" id="signed_events">My Signed Up Events</a></li>
        <hr>
        <li><a @click="loadPage('members_list')" id="members_list" v-show="$store.state.user.status == 1">Members List</a></li>
        <hr v-show="$store.state.user.status == 1">
        <li><a>Account Settings</a></li>
        <hr>
      </ul>
    </aside>
  </div>
</template>
<script>
window.$ = window.jQuery = require('jquery');

export default {
  mounted: function() {
    $(".menu a").each(function(e) {
      if (this.id == window.location.href.split('/')[5]) {
        $(this).addClass('is-active')
      }
    })
  },
  methods: {
    loadPage(e) {
      $('.menu a').removeClass('is-active')
      this.$router.push('/account_page/' + e)
      $('#' + e).addClass('is-active')
    }
  }
}

</script>
<style>
.menu-list a.is-active {
  background-color: #1b4d8a;
}

</style>
