<template>
  <div>
    <div>
      <vue-good-table :columns="columns" :rows="users" :onClick="viewUser" />
    </div>
  </div>
</template>
<script>
import { getSignedUsers, getSingleEvent, getRegisteredUsers } from '../../router/config.js'
window.$ = window.jQuery = require('jquery');

export default {
  data() {
    return {
      id: 0,
      users: [],
      event: {},
      viewUser: function(row, index) {
        setTimeout(function() {
          localStorage.setItem("replace_member_one", row.name)
          localStorage.setItem("replace_member_one_id", row.id)
        }, 100);
      },
      columns: [{
        label: 'Signed Members',
        field: 'name',
        filterable: true,
      }, ],
    }
  },
  methods: {
    getEvent() {
      this.$http.post(getSingleEvent, localStorage.getItem("event")).then(response => {
        this.event = response.data[0]
        this.loadUsers()        
      })
    },
    loadUsers() {
      var that = this
      setTimeout(function() {
        var users = JSON.parse(that.event.signed_users)

        var postData = {
          users: users.id,
          event_id: localStorage.getItem("event"),
          type: 'parse_signed_users'
        }

        that.$http.post(getSignedUsers, postData).then(response => {
          response.data.forEach(function(user) {
            var obj = {
              id: user.id,
              name: user.name,
            }
            that.users.push(obj)
          })
        })
      }, 1500)
    }
  },
  mounted: function() {
    this.getEvent()
  },
}

</script>
