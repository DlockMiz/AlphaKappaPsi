<template>
  <div>
    <a href="#/account_page/members_list"><i class="fa fa-angle-left fa-1x" aria-hidden="true"> Back</i></a>
    <hr>
    <i class="fa fa-pencil-square fa-2x" aria-hidden="true" @click="showEditMember()"></i>
    <hr>
    <h1 v-show="showData">Name: {{user.name}}</h1>
    <input class="editUserInfo input is-info" v-model="user.name">
    <hr>
    <h1 v-show="showData">Email: {{user.email}}</h1>
    <input class="editUserInfo input is-info" v-model="user.email">
    <hr>
    <h1 v-show="showData">Status: {{user.status}}</h1>
    <div class="select is-info editUserInfo">
      <select v-model="user.status">
        <option>Pledge</option>
        <option>Active</option>
        <option>Executive</option>
      </select>
    </div>
    <hr>
    <h1 v-show="showData">ID: {{user.id}}</h1>
    <hr v-show="showData">
    <div>
      <strong>Current Requirement Status:</strong>
      <div style="margin-top: 10px;">
        <div style="margin-top: 5px;">
          <div v-show="showData">Fundraising: {{requirements.fundraising}}</div>
          <div class="editUserInfo">Fundraising
            <input class="input is-info" type="number" name="fundraising" v-model="requirements.fundraising">
          </div>
        </div>
        <div style="margin-top: 5px;">
          <div v-show="showData">Service: {{requirements.service}}</div>
          <div class="editUserInfo">Service
            <input class="input is-info" type="number" name="service" v-model="requirements.service">
          </div>
        </div>
        <div style="margin-top: 5px;">
          <div v-show="showData">Proffessional Development: {{requirements.prof_dev}}</div>
          <div class="editUserInfo">Proffessional Development
            <input class="input is-info" type="number" name="prof_dev" v-model="requirements.prof_dev">
          </div>
        </div>
      </div>
    </div>
    <hr>
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
      showData: true,
      editButton: false,
      requirements: {}
    }
  },
  methods: {
    getUser() {
      var postData = {
        id: this.id,
        type: 'requirements'
      }
      this.$http.post(getUser, postData).then(response => {
        this.user = response.data[0]
        this.requirements = response.data[1]
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
      this.showData = !this.showData
      this.editButton = !this.editButton

      if (this.showData == true) {
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
        user: this.user,
        requirements: this.requirements
      }

      this.$http.post(editUser, postData).then(response => {
        this.$swal('Nice!', "This users profile has been changed!", 'success').then((result) => { location.reload() })
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
  width: 30%;
}

.editUserInfo select {
  width: 100%;
}

</styles>
