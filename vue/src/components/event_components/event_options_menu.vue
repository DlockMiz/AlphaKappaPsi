<template>
  <div id="currentActivitiesMenu">
    <aside class="menu">
      <p class="menu-label">
        Current Events
      </p>
      <ul class="menu-list">
        <hr>
        <li><a class="link is-info" @click="loadPage('event_calendar')" id="event_calendar"><i class="fa fa-calendar is-active" aria-hidden="true"></i>Event Calendar</a>
          <ul>
            <li><a v-show="this.$store.state.user.status == 1" class="link is-info" @click="loadPage('event_calendar_options')" id="event_calendar_options">Event Options</a></li>
          </ul>
        </li>
        <hr>
        <li><a class="link is-info"><i class="fa fa-black-tie" aria-hidden="true"></i>Merchandise</a></li>
        <hr>
        <li><a class="link is-info"><i class="fa fa-home" aria-hidden="true"></i>Homecoming</a></li>
        <hr>
        <li><a class="link is-info"><i class="fa fa-money" aria-hidden="true"></i>Fundraising</a></li>
        <hr>
        <li><a class="link is-info"><i class="fa fa-handshake-o" aria-hidden="true"></i>Professional Development</a></li>
        <hr>
        <li><a class="link is-info" @click="loadPage('service_event')" id="service_event"><i class="fa fa-trash" aria-hidden="true"></i>Service</a></li>
        <hr>
        <li><a class="link is-info"><i class="fa fa-users" aria-hidden="true"></i>Brotherhood</a></li>
        <hr>
        <li><a class="link is-info"><i class="fa fa-id-card" aria-hidden="true"></i>Membership</a></li>
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
      if (e == 'event_options' && this.$store.state.user.status != 1) {
        alert("You must be an Exec Member to access this page.")
        this.$router.push('/event_page')
        return
      }
      $('.menu a').removeClass('is-active')
      this.$router.push('/event_page/' + e)
      $('#' + e).addClass('is-active')
    }
  }
}

</script>
<style>
#currentActivitiesMenu .menu-list a.is-active {
  background-color: #1b4d8a;
}

#currentActivitiesMenu {
  width: 20%;
  margin-left: 20px !important;
  position: absolute;
  margin-top: 0px !important;
}

i {
  margin-right: 10px;
}

</style>
