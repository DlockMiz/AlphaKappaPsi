<template>
  <div id="accountWrapper">
    <aside class="menu">
      <p class="menu-label">
        My Account
      </p>
      <ul class="menu-list">
        <li><a href="#/account_page/signed_events" id="signedEvents" name="signedEvents" class="is-active">My Signed Up Events</a></li>
        <li><a>Account Settings</a></li>
      </ul>
    </aside>
    <div id="contentBox">
      <router-view></router-view>
    </div>
  </div>
</template>
<script>
window.$ = window.jQuery = require('jquery');
$(document).ready(function() {
  $(".menu a").click(function() {
    $(".menu a").removeClass('is-active')
    $(this).addClass('is-active')
  })
})

</script>
<style>

#accountWrapper{
	height: 100%;
	margin: 50px;
}

.menu-list a.is-active {
  background-color: #1b4d8a;
}

.menu {
  border: solid;
  padding: 10px;
  width: 20%;
  float: left;
}

#contentBox{
	/*border:solid;*/
	width: 75%;
	float: left;
	margin-left: 30px;
}

</style>
