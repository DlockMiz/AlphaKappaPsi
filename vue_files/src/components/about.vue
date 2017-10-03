<template>
  <div>
    <h4>ABOUT THIS WEBPAGE</h4>
    <b> CLICK ICON FOR MORE INFORMATION</b>
    <div id="github">
      <i class="fa fa-github" aria-hidden="true" style="font-size: 25pt;"></i>
      <a id="git" href="https://github.com/DlockMiz/daniellock">Github Link</a>
    </div>
    <div>
      <div style="margin-left:80px;">
        <div class="box" id="lara">
          <a href="https://laravel.com/"><img class="images" style="margin-left: 115px !important;" src="../assets/images/laravel-logo.png"></a>
          <p class="text_box">
            {{lara}}
          </p>
        </div>
        <div class="box" id="vuetify">
          <a href="https://vuetifyjs.com/"> <img class="images" src="../assets/images/vuetify-logo.jpg"></a>
          <p class="text_box">
            {{vuetify}}
          </p>
        </div>
        <div class="box" id="vue">
          <a href="https://vuejs.org/"> <img class="images" src="../assets/images/vue-logo.png"></a>
          <p class="text_box">
            {{vue}}
          </p>
        </div>
        <div class="box" id="sql">
          <img class="images" src="../assets/images/sql-logo.png">
          <p class="text_box">
            {{sql}}
          </p>
        </div>
        <div class="box" id="ocean">
          <img class="images" src="../assets/images/ocean-logo.jpg">
          <p class="text_box">
            {{ocean}}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {
  getAboutData
} from '../config.js'


export default {
  data() {
    return {
      lara: '',
      vuetify: '',
      vue: '',
      sql: '',
      ocean: ''
    }
  },

  mounted: function() {
    this.loadData()
  },
  methods: {
    loadData() {
      this.$http.post(getAboutData).then(response => {
        this.lara = response.data[0].description
        this.vuetify = response.data[1].description
        this.vue = response.data[2].description
        this.sql = response.data[3].description
        this.ocean = response.data[4].description
        console.log(response.data)
      })
    }
  }
}

</script>
<style>
#git, #github {
  font-size: 16pt;
  margin-top: 10px;
}

.images {
  height: 92px;
  float: left;
  margin: 20px;
  margin-top: 30px;
  margin-left: 130px;
}

.box {
  border-style: solid;
  border-width: 7px;
  float: left;
  margin-left: 30px !important;
  margin-top: 30px;
  height: 500px;
  width: 350px;
  margin-bottom: 20px;
}

#lara {
  border-color: rgb(249, 82, 67);
  color: rgb(249, 82, 67);
}

#vuetify {
  border-color: rgb(130, 197, 250);
  color: rgb(34, 106, 184);
}

#vue {
  border-color: rgb(65, 184, 131);
  color: rgb(65, 184, 131);
}

#sql {
  border-color: rgb(68, 116, 202);
  color: rgb(68, 116, 202);
}

#ocean {
  border-color: rgb(22, 131, 252);
  color: rgb(22, 131, 252);
}

.text_box {
  margin-top: 200px;
  font-size: 20px;
}

</style>
