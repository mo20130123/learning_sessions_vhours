<!-- must have fontawesome -->
<!--
<n-select :options="Attributes.finish" searchable="true" value="سوبر لوكس" dir="rtl" name="myInput" n_first="dd" v-on:n_onchange="n_change()"></n-select>
 -->
<style scoped lang="scss">
$main_color: #22704b;
$hover_color: #184e35;
.input-container
{
   position: relative;
   width: 100%;
   cursor: pointer;
   p
   {
         padding: 7px 21px;
         border-radius: 4px;
         background-color: #fff;
         border: 1px solid #a0a0a0;
         box-shadow: inset 0px 0px 45px -21px #d7d7d7;
         width: 100%;
         color: black;
   }
   i{
      position: absolute;
      right: 12px;
      top: 10px;
      font-size: 20px;
      z-index: 10;
      color: #423f3f;
   }
}//End .input-container
ul
{
    background-color: $main_color ;
    padding: 0;
    position: absolute;
    width: 90%;
    z-index: 20;
    li
    {
      height: 35px;
      list-style: none;
      border-bottom: 1px solid #ccc;
      border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent;
      padding: 6px 20px;
      &:hover:not(.search-wrapper) , &.active{
         cursor: pointer;
         background-color: $hover_color;
      }
      //----search----
      &.search-wrapper
      {
         position: relative;
         input
         {
            height: 20px;
            width: 87%;
         }
         i.fa-search
         {
             position: absolute;
             left: 25px;
             top: 12px;
             z-index: 48;
             color: black;
         }
         i.fa-times
         {
             position: absolute;
             right: 19px;
             font-size: 20px;
             top: 9px;
             z-index: 48;
             color: black;
             &:hover
             {
                transition: .3s;
                transform: scale(1.2);
                cursor: pointer;
             }
         }
      }//End &.search-wrapper
   }//End li
}//End ul
// *************rtl**************
.select-wrapper.rtl
{
   text-align: right;
   .input-container
   {
      i
      {
         right: auto;
         left: 12px;
      }
   }
   ul
   {
      li.search-wrapper
      {
         input
         {
             text-align: right;
         }
      }
      i.fa-search
      {
         right: 25px;
         left: auto;
      }
      i.fa-times
      {
         left: 19px;
         right: auto;
      }
   }//End ul
}//End .select-wrapper.rtl
</style>

<template>
      <div :class="['select-wrapper',{'rtl':dir=='rtl'}]"  :id="the_id" >
         <div class="input-container" v-on:click="select_wrapper_clicked()" >
            <input type="hidden"  :name="name" v-model="vm_inp.value" :required="required ? true : false" >
            <p> {{vm_inp.label}}  </p>
            <i v-if="options_case=='close'" class="fas fa-angle-down" v-on:click="focusOnInput()"   ></i>
            <i v-if="options_case=='open'"  class="fas fa-angle-up" v-on:click="focusOnInput()" ></i>
         </div>

         <ul v-show="options_case=='open'">
              <li class="search-wrapper" v-show="searchable">
                 <i class="fas fa-search" ></i>
                 <input type="text" v-model="inp_search">
                 <i class="fas fa-times" v-on:click="cancel_options()"></i>
              </li>
              <li v-on:click="choose_option(vm_inp_default)" v-if="vm_inp_default.lebel!='-'" > {{vm_inp_default.label}} </li>
              <li v-for="option in filtered_options" v-on:click="choose_option(option)" :class="{'active':option.value==vm_inp.value}" > {{option.label}} </li>
         </ul>
    </div>
</template>

<script>
    export default {
         props: {
             options: Array,
             n_onchange: Function,
             // s_id: '',
             // s_class: '',
             name: '',
             dir: '',
             // main_color: '',
             value: "",
             searchable: true,
             required: false,
             readonly: false,
             n_first: '',
             main_color: 'red'
         },
         data(){
          return {
              the_id: 'select_'+ Math.random().toString(36),
               options_case: 'close',
              vm_inp: {
                 label: '',
                 value: null
              },
              vm_inp_default: {
                 label: '-',
                 value: null
              },
              inp_search: '',
          }
       },
        mounted() {
           //set default value
           if(this.value) {
               this.vm_inp = this.options.find(option => option.value==this.value);
           }
           if(this.n_first) {
              this.vm_inp_default.label = this.n_first;
           }
           //----START close when click outside-----
             let selectWrapper_id = this.the_id;
              document.addEventListener("click", (evt) => {
                   const flyoutElement = document.getElementById(selectWrapper_id);
                   let targetElement = evt.target; // clicked element
                   do {
                        if (targetElement == flyoutElement) { return; }
                        targetElement = targetElement.parentNode;
                   } while (targetElement);
                   this.options_case = 'close';
              });
          //----END close when click outside-----
        },//End mounted
        methods:{
           select_wrapper_clicked()
           {
             if(this.options_case == 'close')
                this.options_case = 'open';
             else
                this.options_case = 'close';
          },
          cancel_options(){
             this.options_case = 'close';
             this.vm_inp = this.vm_inp_default;
             this.$emit('n_onchange');
          },
          choose_option(option)
          {
             this.options_case = 'close';
             this.vm_inp = option;
             this.$emit('n_onchange');
          }
       },//End methods
       computed: {
            filtered_options() {
                return this.options.filter((option) => option.label.match(this.inp_search));
            }
        },//End computed
    };
</script>
