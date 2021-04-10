<style lang="scss" scoped >
    #theContainer
    {
       margin: 120px 100px ;
       .LeftArrow1{
         animation: moveAlong 1s ease-in-out infinite;
       }
       .LeftArrow2{
         animation: moveAlong 1s 1s ease-in-out infinite;
       }
       .LeftArrow3{
         animation: moveAlong 1s 2s ease-in-out infinite;
       }
    }

    @keyframes moveAlong{
       0% { transform: translateX(0); }
       100% { transform: translateX(-50px); }
    }
</style>
<template>
  <div class="home">
    <!-- <img alt="Vue logo" src="../assets/logo.png" > -->

   <div id="theContainer">
        <h1> Please choose one tab from the side bar </h1>
        <font-awesome-icon icon="arrow-alt-circle-left" size="4x" class="LeftArrow1" /> <br>
        <font-awesome-icon icon="arrow-alt-circle-left" size="4x" class="LeftArrow2" /> <br>
        <font-awesome-icon icon="arrow-alt-circle-left" size="4x" class="LeftArrow3" />
      </div>

  </div>
</template>

<script>
// @ is an alias to /src
import HelloWorld from '@/components/HelloWorld.vue'

export default {
  name: 'Home',
  components: {
    HelloWorld
  }
}
</script>
