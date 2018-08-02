<template>
  <div>
    <div>
      <vue-good-table :columns="columns" :rows="users" :onClick="viewUser" />
    </div>
  </div>
</template>
<script>
import { getSingleEvent, getRegisteredUsers } from '../../router/config.js'
window.$ = window.jQuery = require('jquery');

export default {
  data() {
    return {
      id: 0,
      users: [],
      viewUser: function(row, index) {
        setTimeout(function() {
          localStorage.setItem("replace_member_two", row.name)
          localStorage.setItem("replace_member_two_id", row.id)
        }, 100);
      },
      columns: [{
        label: 'All Members',
        field: 'name',
        filterable: true,
      }, ],
    }
  },
  methods: {
    loadUsers() {
      var that = this
      setTimeout(function() {
        that.$http.post(getRegisteredUsers).then(response => {
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
    this.loadUsers()
  },
}

</script>
