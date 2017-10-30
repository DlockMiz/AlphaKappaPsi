<template>
  <div>
    <a href="#/account_page/members_list"><i class="fa fa-angle-left fa-1x" aria-hidden="true"> Back</i></a>
    <h1>Name: {{user.name}}</h1>
    <hr>
    <h1>Email: {{user.email}}</h1>
    <hr>
    <h1>Status: {{user.status}}</h1>
    <hr>
    <h1>ID: {{user.id}}</h1>
    <hr>
  </div>
</template>
<script>
import { getUser } from '../../router/config.js'

export default {
  data() {
    return {
      id: 0,
      user: {}

    }
  },
  methods: {
    getUser() {
      var postData = {
        id: this.id
      }
      console.log(postData)
      this.$http.post(getUser, postData).then(response => {
      	console.log(response.data)
        this.user = response.data
        switch (this.user.status) {
          case '1':
            this.user.status = 'Admin'
            break;
          case '2':
            this.user.status = 'Active'
            break;
          case '3':
            this.user.status = 'Pledge'
            break;
        }

      })
    }
  },
  mounted: function() {
    this.id = window.location.href.split(':')[3]
    this.getUser()
  }
}

</script>
