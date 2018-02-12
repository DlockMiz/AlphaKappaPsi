<template>
  <div>
    <div class="req_title" id="absences_box">
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
    </div>
    <!-- <div class="req_title" id="spring_f_box">
      Fundraising Spring
      <div class="req_content">
        Spring: 1 B-Ball Games
      </div>
    </div>
    <div class="req_title" id="fall_f_box">
      Fall Fundraising
      <div class="req_content">
        B-Ball Games: {{fall_f_bball}}
      </div>
      <div class="req_content">
        F-Ball Games: {{fall_f_football}}
      </div>
    </div> -->
    <div class="req_title" id="fundraising_box">
      Fundraising
      <div class="req_content">
        Required Events: {{fund_requirement}}
        <hr> Completed Events: {{fundraising}}
      </div>
    </div>
    <div class="req_title" id="hours_box">
      Service
      <div class="req_content">
        {{service_hours}} Hours
      </div>
    </div>
    <div class="req_title" id="prof_dev_box">
      Prof Dev
      <div class="req_content">
        {{prof_dev}} Event
      </div>
    </div>
    <div class="req_title" id="dues_box">
      Dues
      <div class="req_content">
        {{dues}}
      </div>
    </div>
  </div>
</template>
<script>
import { checkActiveRequirements, getReqParams } from '../../router/config.js'

export default {
  data() {
    return {
      service_hours: '',
      prof_dev: '',
      absences: '',
      unexcused: '',
      fundraising: '',
      dues: '',
      fund_requirement: ''
    }
  },

  methods: {

    checkRequirements() {
      var postData = {
        id: this.$store.state.user.id
      }

      this.$http.post(checkActiveRequirements, postData).then(response => {
        this.service_hours = response.data.service
        this.prof_dev = response.data.prof_dev
        this.absences = response.data.absence
        this.unexcused = response.data.unexcused
        this.dues = response.data.dues
        this.fundraising = response.data.fundraising

        if (this.service_hours == 4)
          document.getElementById("hours_box").style = "border-color: green;"

        if (this.prof_dev >= 1)
          document.getElementById("prof_dev_box").style = "border-color: green;"

        if (this.absences <= 3)
          document.getElementById("absences_box").style = "border-color: green;"

        if (this.dues == null)
          this.dues = 'Not Payed'
        else if (this.dues == 'payed') {
          this.dues = 'Payed'
          document.getElementById("dues_box").style = "border-color: green;"
        }

        if (this.unexcused == null) {
          this.unexcused = '1'
          document.getElementById("unexcused_box").style = "border-color: green;"
        } else if (this.unexcused == 'used') {
          this.unexcused = '0'
          document.getElementById("unexcused_box").style = "border-color: green;"
        }
        this.$http.post(getReqParams).then(response => {
          this.fund_requirement = response.data[0].parameters
          if (this.fundraising <= this.fund_requirement) {
            document.getElementById("fundraising_box").style = "border-color: green;"
          }
        })
      })
    }
  },

  mounted: function() {
    this.checkRequirements()
  }
}

</script>
<style>
.req_title {
  font-size: 16pt;
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
