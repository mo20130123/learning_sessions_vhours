<!-- Vue component -->
<!--  npm install vue-multiselect --save  -->
<!--  register the component vue-multiselect and use it  -->
<template>

  <div>
     <input type="hidden" :name="name" :value=" inpName "  >
     <label class="typo__label"> {{mylabel}}  </label>
     <multiselect v-model="the_model" deselect-label=" " track-by="label" label="label" placeholder="Select one"
                  :options="options" :searchable="true" :allow-empty="false" @Select="dispatchAction()"  @input="dispatchAction()" >  <!-- deselect-label="Can't remove this value"   -->

          <template slot="singleLabel" slot-scope="{ option }"><strong>{{ option.label }}</strong>  </template>

     </multiselect>
     <!-- <pre class="language-json"><code>{{ the_model }}</code></pre> -->
   </div>

</template>

<script>
  import Multiselect from 'vue-multiselect'

  // register globally
  Vue.component('multiselect', Multiselect)

  export default {
    // OR register locally
    props: {
           options: Array,
           name: '',
           thevalue: '',
           s_change: Function,
           mylabel: '',
        // required: false,
        // readonly: false
    },
    components: { Multiselect },
    data () {
      return {
        the_model: null,
      }
    },
    mounted(){
      let vm = this;
               setTimeout(function () {
                     if(vm.thevalue){
                         vm.the_model = vm.options.find(obj=>obj.value == vm.thevalue);
                     }
               }, 500);
        if(this.thevalue){
           this.the_model = this.options.find(obj=>obj.value == this.thevalue);
        }
    },
    watch: {
      thevalue(val){    console.log('thevalue watch');
         this.the_model = this.options.find(obj=>obj.value == val);
      },
    },//End watch
    methods:{
      dispatchAction(actionName, id)
      {
           this.$emit('s_change');
      }
   },
   computed:{
      inpName()
      {
         if(this.the_model){
            return this.the_model.value;
         }
         else {
            return null;
         }
      },

   }
  }//end all
</script>

<!-- New step!  Add Multiselect CSS. Can be added as a static asset or inside a component. -->
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<!-- custom css -->
<style>

</style>


<!-- how to use it -->
<!--

  <vue-multiselect :options="options" :thevalue="'2'"  :mylabel="'my label'" v-on:s_change="chh()" :name="'go'"  ></vue-multiselect>

 -->

 <!--
 let myVue = new Vue({
    el: '#myVue',
    data:{
        options: [
           { label: 'Vue.js', value: 1 },
           { label: 'Rails', value: 2 },
           { label: 'Sinatra', value: 3 },
           { label: 'Laravel', value: 4 },
           { label: 'Phoenix', value: 5 }
        ],
        mymodel:''
    },
    methods:{
       chh() {
          console.log('chh');
       }
    }
 });
 -->
