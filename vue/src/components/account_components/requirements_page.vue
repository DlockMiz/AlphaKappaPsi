<template>
  <div>
    <center><img id="loading" style="margin-top: 100px;" src="../../assets/images/loading.gif" height="200" width="200"></center>
    <div id="reqWrapper">
      <!--       <div class="req_title" id="absences_box">
        Absences
        <div class="req_content">
          {{absences}} Total
        </div>
      </div>
      <div class="req_title" id="unexcused_box">
        Unexcused Absences
        <div class="req_content">
          {{unexcused}} Left
        </div>
      </div> -->
      <div>
        <a class="button is-info" @click="clearPoints()">Clear All Users Points</a>
      </div>
      <hr>
      <div class="req_title" id="fundraising_box">
        Fundraising
        <div v-if="$store.state.user.status != 1" class="req_content">
          Required Points: {{fund_requirement}}
          <hr> {{fundraising}} - Completed Points
        </div>
        <div v-if="$store.state.user.status == 1" style="margin-top: 30px;">
          <a style="font-size: .7vw; width: 70%;" @click="changeReqParam('fund', fund_requirement)" class="button is-info is-small">Change Required Events</a>
        </div>
      </div>
      <div class="req_title" id="hours_box">
        Service
        <div class="req_content" v-if="$store.state.user.status != 1">
          Required Hours: {{service_req}}
          <hr> {{service_hours}} - Completed Hours
        </div>
        <div v-if="$store.state.user.status == 1" style="margin-top: 30px;">
          <a style="font-size: .7vw; width: 70%;" @click="changeReqParam('service', service_req)" class="button is-info is-small">Change Required Service Hours</a>
        </div>
      </div>
      <div class="req_title" id="prof_dev_box">
        Professional Development
        <div class="req_content" v-if="$store.state.user.status != 1">
          Required Events: {{prof_dev_req}}
          <hr> {{prof_dev}} - Completed Events
        </div>
        <div v-if="$store.state.user.status == 1" style="margin-top: 30px;">
          <a style="font-size: .7vw; width: 70%;" @click="changeReqParam('prof_dev', prof_dev_req)" class="button is-info is-small">Change Prof Dev Requirements</a>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
window.$ = window.jQuery = require('jquery');
import { checkActiveRequirements, getReqParams, changeReq, clearPoints } from '../../router/config.js'

export default {
  data() {
    return {
      service_hours: '',
      prof_dev: '',
      absences: '',
      unexcused: '',
      fundraising: '',
      fund_requirement: '',
      service_req: '',
      prof_dev_req: ''
    }
  },

  methods: {
    clearPoints() {
      this.$swal({
        title: 'Are you sure?',
        text: "This will clear everybody's points FOREVER, there is literally no way you can fix this!!!!!!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.value) {
          this.$swal({
            title: 'THIS IS YOUR FINAL WARNING!',
            text: "GO TO MEMBERS LIST AND EXPORT THE FILE WITH EVERYONES POINTS BEFORE DOING THIS I'M SERIOUS!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
          }).then((result) => {
            if (result.value) {
              this.$http.post(clearPoints).then(response => {
                this.$swal('Success', 'Everyone now has 0 points :)', 'success')
              })
            } else
              return
          })
        } else
          return
      })
    },

    changeReqParam(type, current) {
      var that = this
      const { value: name } = this.$swal({
        title: 'Input New Requirement',
        input: 'number',
        inputPlaceholder: 'Input New Requirement',
        showCancelButton: true,
        inputValue: current,
        inputValidator: (value) => {
          return !value && 'You need to write something!'
        }
      }).then(response => {
        var postData = {
          type: type,
          value: response.value
        }
        that.$http.post(changeReq, postData).then(response => {
          if (response.data) {
            that.$swal('Success!', 'Parameter Succesfully Changed', 'success')
            switch (type) {
              case 'fund':
                this.fund_requirement = response.data
                break;
              case 'prof_dev':
                this.prof_dev_req = response.data
                break;
              case 'service':
                this.service_req = response.data
                break;
            }
          }
        })
      })
    },

    checkRequirements() {
      var postData = {
        id: this.$store.state.user.id
      }

      this.$http.post(checkActiveRequirements, postData).then(response => {
        this.service_hours = response.data.service
        this.prof_dev = response.data.prof_dev
        this.absences = response.data.absence
        this.unexcused = response.data.unexcused
        this.fundraising = response.data.fundraising

        if (this.service_hours == 4)
          document.getElementById("hours_box").style = "border-color: green;"

        if (this.prof_dev >= 1)
          document.getElementById("prof_dev_box").style = "border-color: green;"

        // if (this.absences <= 3)
        //   document.getElementById("absences_box").style = "border-color: green;"

        // if (this.unexcused == null) {
        //   this.unexcused = '1'
        //   document.getElementById("unexcused_box").style = "border-color: green;"
        // } else if (this.unexcused == 'used') {
        //   this.unexcused = '0'
        //   document.getElementById("unexcused_box").style = "border-color: green;"
        // }
        this.$http.post(getReqParams).then(response => {
          $('#loading').hide()
          $('#reqWrapper').show()
          this.fund_requirement = response.data[0].parameters
          this.service_req = response.data[1].parameters
          this.prof_dev_req = response.data[2].parameters

          if (this.fundraising >= this.fund_requirement) {
            document.getElementById("fundraising_box").style = "border-color: green;"
          }
          if (this.service >= this.service_req) {
            document.getElementById("hours_box").style = "border-color: green;"
          }
          if (this.prof_dev >= this.prof_dev_req) {
            document.getElementById("prof_dev_box").style = "border-color: green;"
          }
        })
      })
    }
  },

  mounted: function() {
    $('#loading').show()
    $('#reqWrapper').hide()
    this.checkRequirements()
  }
}

</script>
<style>
.req_title {
  font-size: 1.2vw;
  text-align: center;
  padding: 5px;
  float: left;
  border: 5px crimson solid;
  margin: 10px;
  width: 31%;
  height: 300px;
}

.req_content {
  margin-top: 50px;
}

#req_top_wrapper {
  float: left;
  width: 100%;
}

#req_bottom_wrapper {
  float: left;
  width: 100%;
}

</style>
