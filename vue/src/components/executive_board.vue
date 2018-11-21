<template>
  <div>
    <center><img id="loading" style="margin-top: 100px;" src="../assets/images/loading.gif" height="200" width="200"></center>
      <div v-for="(member,index) member in board" class="exec-board-box">
        <h1 style="font-size: 18pt;">{{positions[index]}}: <strong>{{member.name}}</strong>
      <a v-if="$store.state.user.status == 1" @click="propsData.showModal = true, editMember = member" style="float: right;" class="button is-info">Edit Info</a>
      </h1>
        <br>
        <div class="description">
          {{member.desc}}
        </div>
        <div class="exec-info">
          <br>
          <strong>Info: {{member.info}}</strong>
        </div>
        <hr>
      </div>
      <modal :propsData="propsData">
        <center>
          <div>
            <strong style="font-size: 12pt;">Name: </strong>
            <div><input v-model="editMember.name" class="inputs input is-info"></div>
          </div>
          <hr>
          <div>
            <strong style="font-size: 12pt;">Description: </strong>
            <div><textarea style="height: 200px;" v-model="editMember.desc" class="inputs input is-info"></textarea></div>
          </div>
          <hr>
          <div>
            <strong style="font-size: 12pt;">Info: </strong>
            <div><input v-model="editMember.info" class="inputs input is-info"></div>
          </div>
          <hr>
          <a @click="saveEditMember()" class="button is-info">Save</a>
        </center>
      </modal>
  </div>
</template>
<script>
import { getExecBoard, editExecMember } from '../router/config.js'
import modal from './content_modal'
window.$ = window.jQuery = require('jquery');


export default {
  data() {
    return {
      board: [],
      editMember: {
        name: '',
        desc: '',
        info: ''
      },
      positions: [
        'President',
        'VP Internal Relations',
        'VP External Relations',
        'VP Membership',
        'VP Membership',
        'Risk Management',
        'Treasurer',
        'College of Business Relations',
        'VP of Fundraising',
        'VP of Fundraising',
        'Assistant Treasurer',
        'Brotherhood',
        'Master of Rituals',
        'Secretary',
        'Professional Development',
        'Marketing Director',
        'Service',
      ],
      propsData: {
        showModal: this.showModal,
      }
    }
  },
  methods: {
    getExecBoard() {
      $('#loading').show()
      $('#exec-board-box').hide()
      this.$http.post(getExecBoard).then(response => {
        $('#loading').hide()
        $('#exec-board-box').show()
        this.board = response.data
      })
    },
    saveEditMember() {
      var postData = {
        member: this.editMember
      }
      this.$http.post(editExecMember, postData).then(response => {
        this.$swal('Success', 'Exec board member has been changed!', 'success')
        this.getExecBoard()
        this.propsData.showModal = false
      })
    }
  },
  mounted: function() {
    this.getExecBoard()
  },
  components: {
    modal
  },
}

</script>
<style>
.exec-board-box {
  width: 75%;
  margin: auto;
}

.description {
  margin-left: 50px;
  margin-bottom: 20px;
}

.exec-info {
  margin-top: 15px;
}

.inputs {
  width: 60%;
}

</style>
