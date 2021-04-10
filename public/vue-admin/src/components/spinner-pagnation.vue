<style>
   ul.pagination{
      flex-wrap: wrap;
      /* justify-content: space-between; */
      margin: 20px 0;
   }
</style>
<template>
  <div>

      <!-- - - - - - -START spinner- - - - - - - -->
      <spinner2 v-if="show_spinner"></spinner2>
      <!-- - - - - - -End spinner- - - - - - - -->
     <!-- <hr> -->
     <!-- - - - - - -START paginate- - - - - - - -->
       <pagination :data="mainList" :limit="15" v-on:pagination-change-page="getResults" >
          <span slot="prev-nav">&lt;   </span>
          <span slot="next-nav">   &gt;</span>
       </pagination>
     <!-- - - - - - -End paginate- - - - - - - -->

<!-- <hr> -->
  </div>
</template>

<script>
  import spinner2 from '@/components/spinner2';

  export default {
    name: 'spinnerPagnation',
    components: {
      spinner2
    },
    props:{
      show_spinner: {
         type: Boolean ,
         default: () => false
      },
      mainList: {
         type: Object,
         default: () => {data:[]}
      }
    },
    data: () => ({

    }),
    methods:{
      getResults(page = 1){
         this.$emit('getResults',page);
      }
    }
  }
</script>
