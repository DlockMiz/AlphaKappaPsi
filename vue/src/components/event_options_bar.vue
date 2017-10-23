<template>
  <div id="currentActivitiesMenu">
    <aside class="menu">
      <p class="menu-label">
        Current Events
      </p>
      <ul class="menu-list">
        <hr>
        <li><a @click="loadPage('event_calendar')" id="event_calendar"><i class="fa fa-calendar is-active" aria-hidden="true"></i>Event Calendar</a>
          <ul>
            <li><a @click="loadPage('event_options')" id="event_options">Event Options</a></li>
          </ul>
        </li>
        <hr>
        <li><a class="link is-info"><i class="fa fa-black-tie" aria-hidden="true"></i>Merchandise</a></li>
        <hr>
        <li><a class="link is-info"><i class="fa fa-home" aria-hidden="true"></i>Homecoming</a></li>
        <hr>
        <li><a class="link is-info"><i class="fa fa-money" aria-hidden="true"></i>Fundraising</a></li>
        <hr>
        <li><a class="link is-info"><i class="fa fa-handshake-o" aria-hidden="true"></i>Proffesional Development</a></li>
        <hr>
        <li><a @click="loadPage('service_event')" id="service_event" class="link is-info"> <i class="fa fa-trash" aria-hidden="true"></i>Service</a></li>
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
  margin-left: 10px;
}

</style>
