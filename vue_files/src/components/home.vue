<template>
  <div id="wrapper">
    <div id="pic_background">
      <div style="position: absolute;">
        <img id="img" src="../assets/images/me.png">
      </div>
      <div class="bubble">
        <p id="description">
          My name is Daniel Lock and this is my personal website. I've created this site from the ground up using the knowledge I have as a web developer. I wouldn't consider myself a designer, but my goal is to adapt this site as my skills grow. Included in this webpage is past and current work experiences as well as how this was made. Below you will find about me as an individual, and a small view into my life as a young adult.
        </p>
      </div>
    </div>
    <div class="row">
      <h4 id="goals">Goals</h4>
      <h4 id="town">Hometown</h4>
      <h4 id="family">Family Life</h4>
      <h4 id="hobbies">Hobbies</h4>
      <h4 id="school">Schooling</h4>
    </div>
    <div id="goals_desc">
      <img src="../assets/images/WIP.jpeg">
    </div>
  </div>
</template>
<script>
export default {
  mounted: function() {
    window.$ = window.jQuery = require('jquery');
    $(document).ready(function() {
      $("#goals").mouseenter(function() {
        $("#goals_desc").show(1000);
        $("#goals").css("background-color", "lightgrey");

      })
      $("#goals").mouseout(function() {
        $("#goals_desc").hide();
        $("#goals").css("background-color", "white");
      })

      $("#town").mouseenter(function() {
        $("#goals_desc").show(1000);
        $("#town").css("background-color", "lightgrey");

      })
      $("#town").mouseout(function() {
        $("#goals_desc").hide();
        $("#town").css("background-color", "white");
      })

      $("#family").mouseenter(function() {
        $("#goals_desc").show(1000);
        $("#family").css("background-color", "lightgrey");

      })
      $("#family").mouseout(function() {
        $("#goals_desc").hide();
        $("#family").css("background-color", "white");
      })

      $("#hobbies").mouseenter(function() {
        $("#goals_desc").show(1000);
        $("#hobbies").css("background-color", "lightgrey");

      })
      $("#hobbies").mouseout(function() {
        $("#goals_desc").hide();
        $("#hobbies").css("background-color", "white");
      })

      $("#school").mouseenter(function() {
        $("#goals_desc").show(1000);
        $("#school").css("background-color", "lightgrey");

      })
      $("#school").mouseout(function() {
        $("#goals_desc").hide();
        $("#school").css("background-color", "white");

      })
    })
  }
}

</script>
<style>
@import url('https://fonts.googleapis.com/css?family=Arvo');


#wrapper {
  width: 1425px;
  height: 1425px;
  font-family: 'Arvo', serif;
}

#description {
  color: white;
  font-size: 20pt;
  height: 400px;
  width: 900px;
  margin: auto;
  margin-top: 60px;
}

.bubble {
  background-color: rgb(92, 87, 79);
  height: 450px;
  width: 950px;
  border-radius: 50px 50px 50px 50px;
  float: left;
  margin-left: 400px;
  margin-top: 50px;
}

#pic_background {
  height: 550px;
  width: 98%;
  margin: auto;
  margin-top: 30px;
  background-color: rgb(234, 218, 192);
  border-radius: 20px 20px 20px 20px;
}

#img {
  height: 450px;
  margin: auto;
  margin-left: 50px;
  margin-top: 50px;
  border-radius: 20px 20px 20px 20px;
}

#goals_desc {
  display: none;
  border: dotted 10px rgb(234, 218, 192);
  width: 12%;
  margin-top: 100px;
  margin: auto;
  padding: 5px;
}

.row {
  width: 100%;
  margin-top: 50px;
  height: 50px;
  margin-bottom: 50px;
}

.row h4 {
  float: left;
  margin-left: 110px;
  color: rgb(206, 172, 118);
  padding: 5px;
  border-radius: 10px 10px 10px 10px;
}

</style>
