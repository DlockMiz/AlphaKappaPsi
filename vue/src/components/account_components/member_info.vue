<template>
  <div>
    <a href="#/account_page/members_list"><i class="fa fa-angle-left fa-1x" aria-hidden="true"> Back</i></a>
    <hr>
    <i class="fa fa-pencil-square fa-2x" aria-hidden="true" @click="showEditMember()"></i>
    <hr>
    <h1 v-show="showName">Name: {{user.name}}</h1>
    <input class="editUserInfo input is-info" v-model="user.name">
    <hr>
    <h1 v-show="showEmail">Email: {{user.email}}</h1>
    <input class="editUserInfo input is-info" v-model="user.email">
    <hr>
    <h1 v-show="showStatus">Status: {{user.status}}</h1>
    <div class="select is-info editUserInfo">
      <select v-model="user.status">
        <option>Pledge</option>
        <option>Active</option>
        <option>Executive</option>
      </select>
    </div>
    <hr>
    <h1 v-show="showID">ID: {{user.id}}</h1>
    <hr v-show="showID">
    <a class="button is-info" v-show="editButton" @click="editMember()">Edit Member</a>
  </div>
</template>
<script>
window.$ = window.jQuery = require('jquery');
import { getUser, editUser } from '../../router/config.js'

export default {
  data() {
    return {
      id: 0,
      user: {},
      showName: true,
      showEmail: true,
      showStatus: true,
      showID: true,
      editButton: false
    }
  },
  methods: {
    getUser() {
      var postData = {
        id: this.id
      }
      this.$http.post(getUser, postData).then(response => {
        this.user = response.data
        switch (this.user.status) {
          case '1':
            this.user.status = 'Executive'
            break;
          case '2':
            this.user.status = 'Active'
            break;
          case '3':
            this.user.status = 'Pledge'
            break;
        }
      })
    },
    showEditMember() {
      this.showName = !this.showName
      this.showEmail = !this.showEmail
      this.showStatus = !this.showStatus
      this.showID = !this.showID
      this.editButton = !this.editButton

      if (this.showName == true) {
        $('.editUserInfo').hide()
      } else {
        $('.editUserInfo').show()
      }
    },
    editMember() {
      switch (this.user.status) {
        case 'Executive':
          this.user.status = '1'
          break;
        case 'Active':
          this.user.status = '2'
          break;
        case 'Pledge':
          this.user.status = '3'
          break;
      }
      var postData = {
        name: this.user.name,
        id: this.user.id,
        email: this.user.email,
        status: this.user.status
      }
      this.$http.post(editUser, postData).then(response => {
        console.log(response.data)
        location.reload()
      })
    },
  },

  mounted: function() {
    this.id = localStorage.getItem("member")
    this.getUser()
  }
}

</script>
<style>
.editUserInfo {
  display: none;
  width: 20%;
}

.editUserInfo select {
  width: 100%;
}

</styles>
