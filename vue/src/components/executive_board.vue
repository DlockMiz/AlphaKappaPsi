<template>
  <div>
    <div v-for="member in board" class="exec-board-box">
      <h1 style="font-size: 18pt;">President: <strong>{{member.name}}</strong></h1>
      <br>
      <div class="description">
      	{{member.desc}}
        <div class="exec-info">
          <strong>{{member.info}}</strong>
        </div>
      </div>
      <hr>
    </div>
  </div>
</template>
<script>
import {getExecBoard} from '../router/config.js'

export default {
  data() {
    return {
    	board: []
    }
  },
  methods: {
  	getExecBoard(){
  		this.$http.post(getExecBoard).then(response =>{
  			this.board = response.data
  		})
  	}
  },
  mounted: function(){
  	this.getExecBoard()
  }
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

</style>
