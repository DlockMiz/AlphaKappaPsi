<template>
  <div>
    <div id="wrapper">
      <img src="../assets/images/pai-logo.png" style="float:left; height:155px; margin-left:25px;">
      <div id="review_box">
        <p>
          {{review}}
        </p>
      </div>
      <div class="column" style=" 
      width:65%; 
      float:right;
      padding-left:20px;
      border-left: solid; 
      border-color:rgb(122, 156, 62); 
      border-width: 5px; 
      background-color:rgb(206,206,206);">
        <div class="description_box" v-show="showBox === true">
          <p>
            {{description}}
          </p>
        </div>
        <div v-show="showWorkflow === true">
          <div class="vid_pic_box" style="height: 544px;">
            <img src="../assets/images/internship/requests.png">
          </div>
          <div class="vid_pic_box" style="height: 544px;">
            <img src="../assets/images/internship/tasks.png">
          </div>
          <div class="vid_pic_box">
            <iframe width="853.69" height="465" src="https://www.youtube.com/embed/db4jWRPWz5g" frameborder="0" allowfullscreen></iframe>
          </div>
        </div>
        <div v-show="showStats === true">
          <div class="vid_pic_box" style="height: 544px;">
            <img src="../assets/images/internship/stats.png">
          </div>
        </div>
        <div v-show="showCalendar === true">
          <div class="vid_pic_box" style="height: 544px;">
            <img src="../assets/images/internship/calendar.png">
          </div>
        </div>
        <div v-show="showNoti === true">
          <div class="vid_pic_box" style="height: 544px; width:55%; margin-left:20%;">
            <img src="../assets/images/internship/notifications.png">
          </div>
        </div>
        <div v-show="showMsg === true">
          <div class="vid_pic_box" style="height: 544px;">
            <img src="../assets/images/internship/messages.png">
          </div>
        </div>
        <div v-show="showVideos === true">
          <div style="margin-top: 10px; font-size: 20px;">
            <a href="https://www.youtube.com/channel/UC0iCW89qM5Jndi1v5ILHUTA">PAI TUTORIAL VIDEOS</a>
          </div>
          <div class="vid_pic_box" style="height: 544px;">
            <iframe width="853.69" height="465" src="https://www.youtube.com/embed/6I0PRIBuR18" frameborder="0" allowfullscreen></iframe>
          </div>
        </div>
      </div>
      <div class="column" style="width: 35%; padding-right:20px;">
        <div class="show_btn">
          <v-btn small fab class="light-green" @click="loadDescription('workflow')" style="float:left;">
            <v-icon>add</v-icon>
          </v-btn>
          <h6>The Workflow</h6>
        </div>
        <div class="show_btn">
          <v-btn small fab class="light-green" @click="loadDescription('stats')" style="float:left;">
            <v-icon>add</v-icon>
          </v-btn>
          <h6>Statistics Page</h6>
        </div>
        <div class="show_btn">
          <v-btn small fab class="light-green" @click="loadDescription('calendar')" style="float:left;">
            <v-icon>add</v-icon>
          </v-btn>
          <h6>Calendar</h6>
        </div>
        <div class="show_btn">
          <v-btn small fab class="light-green" @click="loadDescription('notifs')" style="float:left;">
            <v-icon>add</v-icon>
          </v-btn>
          <h6>Notifications</h6>
        </div>
        <div class="show_btn">
          <v-btn small fab class="light-green" @click="loadDescription('msgs')" style="float:left;">
            <v-icon>add</v-icon>
          </v-btn>
          <h6>Messages</h6>
        </div>
        <div class="show_btn">
          <v-btn small fab class="light-green" @click="loadDescription('tutorial')" style="float:left;">
            <v-icon>add</v-icon>
          </v-btn>
          <h6>Tutorial Videos</h6>
        </div>
        </p>
      </div>
    </div>
  </div>
</template>
<script>
import { getInternData } from '../config.js'


export default {
  data() {
    return {
      data: [],
      description: '',
      prevFeature: '',
      review: '',
      showBox: false,
      showWorkflow: false,
      showStats: false,
      showCalendar: false,
      showNoti: false,
      showMsg: false,
      showVideos: false,
      workflow: ''
    }
  },

  mounted: function() {
    this.getData()
  },
  methods: {

    getData() {
      this.$http.post(getInternData).then(response => {
        this.data = response.data
        this.review = response.data[0].description
      })
    },

    loadDescription(feature) {

      if (this.prevFeature !== feature) {
        this.showBox = false
        this.showWorkflow = false
        this.showStats = false
        this.showNoti = false
        this.showMsg = false
        this.showCalendar = false
        this.showVideos = false
      }

      this.prevFeature = feature
      if (feature === 'workflow') {
        if (this.showWorkflow === true) {
          this.showWorkflow = false
          this.showBox = false
        } else if (this.showWorkflow === false) {
          this.description = this.data[1].description
          this.showWorkflow = true
          this.showBox = true
        }
      }
      if (feature === 'stats') {
        if (this.showStats === true) {
          this.showStats = false
          this.showBox = false
        } else if (this.showStats === false) {
          this.description = this.data[2].description
          this.showStats = true
          this.showBox = true
        }
      }
      if (feature === 'notifs') {
        if (this.showNoti === true) {
          this.showNoti = false
          this.showBox = false
        } else if (this.showNoti === false) {
          this.description = this.data[4].description
          this.showNoti = true
          this.showBox = true
        }
      }
      if (feature === 'msgs') {
        if (this.showMsg === true) {
          this.showMsg = false
          this.showBox = false
        } else if (this.showMsg === false) {
          this.description = this.data[5].description
          this.showMsg = true
          this.showBox = true
        }
      }
      if (feature === 'calendar') {
        if (this.showCalendar === true) {
          this.showCalendar = false
          this.showBox = false
        } else if (this.showCalendar === false) {
          this.description = this.data[3].description
          this.showCalendar = true
          this.showBox = true
        }
      }
      if (feature === 'tutorial') {
        if (this.showVideos === true) {
          this.showVideos = false
          this.showBox = false
        } else if (this.showVideos === false) {
          this.description = this.data[6].description
          this.showVideos = true
          this.showBox = true
        }
      }
    }
  }
}

</script>
<style>
.vid_pic_box {
  border: solid;
  border-radius: 3px;
  border-width: 5px;
  border-color: rgb(122, 156, 62);
  width: 95.6%;
  height: 475px;
  float: left;
  margin-left: 7.5px;
  margin-top: 20px;
  margin-bottom: 8px;
}

.vid_pic_box img {
  height: 533.9px;
  float: left;
}

#review_box {
  width: 80%;
  border: solid;
  border-radius: 3px;
  border-color: rgb(122, 156, 62);
  background-color: rgb(215, 236, 178);
  padding-right: 10px;
  padding-left: 15px;
  padding-top: 15px;
  padding-bottom: 3px;
  margin: 50px;
  margin-top: 50px;
  margin-left: 15%;
  text-align: right;
}

#review_box p {
  font-size: 17px;
}

.show_btn {
  width: 93%;
  height: 60px;
  border: solid;
  border-color: rgb(122, 156, 62);
  border-radius: 3px;
  background-color: rgb(215, 236, 178);
  margin-left: 25px;
  margin-bottom: 10px;
}

.show_btn h6 {
  width: 150px;
  float: left;
  margin-top: 16px;
  text-align: left;
}

.description_box {
  border: solid;
  width: 97%;
  min-height: 50px;
  border-color: rgb(122, 156, 62);
  border-radius: 3px;
  background-color: rgb(215, 236, 178);
  margin-top: 8px;
}

.description_box p {
  font-size: 17px;
  padding-bottom: 0px;
  padding-top: 5px;
  padding-left: 5px;
  padding-right: 5px;
}

.column {
  height: 100%;
  width: 50%;
  margin-bottom: 20px;
}

#wrapper {
  height: 100%;
  min-width: 1430px;
}

</style>
