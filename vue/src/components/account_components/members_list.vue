<template>
  <div>
    <div>
      <vue-good-table :columns="columns" :rows="users" :paginate="true" :lineNumbers="true" :onClick="viewUser"/>
    </div>
  </div>
</template>
<script>
import { getRegisteredUsers } from '../../router/config.js'
window.$ = window.jQuery = require('jquery');

export default {
  data() {
    return {
      viewUser: function(row, index) {
        this.$router.push('/account_page/members_list/member_info:'+row.id)
        // console.log(row)
      },
      users: [],
      columns: [{
          label: 'Name',
          field: 'name',
          filterable: true,
        },
        {
          label: 'Email',
          field: 'email',
          type: 'email',
          filterable: true,
        },
        {
          label: 'Status',
          field: 'status',
          type: 'name',
          filterable: true,
        },
      ],
    }
  },
  methods: {
    loadUsers() {
      this.$http.post(getRegisteredUsers).then(response => {
        var that = this
        response.data.forEach(function(user) {
          var status
          switch (user.status) {
            case '1':
              status = 'Admin'
              break;
            case '2':
              status = 'Active'
              break;
            case '3':
              status = 'Pledge'
              break;
          }
          var obj = {
            id: user.id,
            name: user.name,
            email: user.email,
            status: status,
            joined: user.created_at
          }
          that.users.push(obj)
        })
      })
    }
  },
  mounted: function() {
    this.loadUsers()
    if (this.$store.state.user.status != 1) {
      alert('Executive Only Page')
      this.$router.push('/account_page')
    }
  }
}

</script>
