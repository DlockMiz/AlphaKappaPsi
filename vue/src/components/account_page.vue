<template>
  <div id="accountWrapper">
    <account_menu></account_menu>
    <div id="contentBox">
      <router-view></router-view>
    </div>
  </div>
</template>
<script>
import account_menu from './account_components/account_menu'

export default{
  components:{
    account_menu
  },
  mounted: function(){
    if(this.$store.state.user == null){
      alert('Please Login to View This Page')
      this.$router.push('/')
    }
  }
}

</script>
<style>
#accountWrapper {
  height: 100%;
  margin: 10px;
}

.menu-list a.is-active {
  background-color: #1b4d8a;
}

#accountWrapper .menu {
  padding: 10px;
  width: 20%;
  float: left;
}

#contentBox {
  width: 75%;
  float: left;
  margin-left: 30px;
}

</style>
