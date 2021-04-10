<!-- must have fontawesome -->
<!--
<n-multiselect :options="Attributes.finish" searchable="true" :value="n_m_values" dir="rtl"  name="myInput" n_first="dd"   v-on:n_onchange="n_change()" ></n-multiselect>
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
      div.checkbox
      {
         position: relative;
         cursor: pointer;
         input[type='checkbox']
         {
            cursor: pointer;
            appearance: none;
            &:checked + label {
               &:after {
                 transform: scale(1) rotate(0deg);
               }
            }
         }
         label
         {
            padding-left: 25px;
            cursor: pointer;
            &:before
            {
               content: '';
               width: 20px;
               height: 20px;
               background-color: #EEE;
               border: 1px solid #5A5A5A;
               position: absolute;
               left: 0;
               top: 0px;
               cursor: pointer;
            }
            &:after
            {
              font-family: 'FontAwesome';
              content: "\f00c";
              position: absolute;
              top: 0px;
              left: 0;
              width: 20px;
              height: 20px;
              color: $main_color;
              font-size: 14px;
              text-align: center;
              transform: scale(0) rotate(360deg);
              transition: all .3s ease-in-out;
              cursor: pointer;
            }
         }//End label
      }//End div.checkbox
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
      li
      {
         div.checkbox
         {
            label
            {
               padding-right: 25px;
               padding-left: 0px;
               &:before
               {
                  right: 0;
                  left: auto;
               }
               &:after
               {
                 right: 0;
                 left: auto;
               }
            }//End label
         }//End div.checkbox
      }
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
// ================checkbox
</style>

<template>
      <div :class="['select-wrapper',{'rtl':dir=='rtl'}]"  :id="the_id" >
         <div class="input-container" v-on:click="select_wrapper_clicked()" >
            <input type="hidden"  :name="name"  v-model="selected_values" :required="required ? true : false" ><!-- loop-->

            <p v-if="vm_inps.length>0"> <span v-for="loop in vm_inps"> {{loop.label}} ,</span>   </p>
            <p v-else> <span  > {{vm_inp_default.label}} </span>   </p>

            <i v-if="options_case=='close'" class="fas fa-angle-down" v-on:click="focusOnInput()"   ></i>
            <i v-if="options_case=='open'"  class="fas fa-angle-up" v-on:click="focusOnInput()" ></i>
         </div>

         <ul v-show="options_case=='open'">
              <li class="search-wrapper" v-show="searchable">
                 <i class="fas fa-search" ></i>
                 <input type="text" v-model="inp_search">
                 <i class="fas fa-times" v-on:click="cancel_options()"></i>
              </li>
               <li v-for="(option,index) in filtered_options" :key="index" v-on:click="choose_option(option)"  > <!-- :class="{'active':option.value==vm_inp.value}" -->

                     <div class="checkbox">
                        <input type="checkbox" name="" :id="'id-'+index" v-model="option.is_checked">
                        <label  >{{option.label}}</label>
                     </div>

               </li>
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
             value: '',
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
              vm_inps: [ ],
              vm_inp_default: {
                 label: '-',
                 value: null
              } ,
              inp_search: '',
          }
       },
        mounted() {
           //set default value
           if(this.value.length>0)
           {
                for (var i = 0; i < this.value.length; i++)
                {
                    var fin = this.options.find(option => option.value==this.value[i]);
                    fin.is_checked = true;
                    this.vm_inps.push(fin);
                }
                this.$forceUpdate();
            }
           //set default text
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
             this.vm_inps = [];
              this.options.forEach(function (arrayItem, key, arr) {
                   arrayItem.is_checked = false;
               });
             this.$emit('n_onchange');
          },
          choose_option(option)
          {
             if(option.is_checked)
             {
                option.is_checked = false;
                let find = this.vm_inps.findIndex(obj => obj.value == option.value );
                this.vm_inps.splice(find, 1);
             }
             else
             {
                option.is_checked = true;
                this.vm_inps.push(option);
             }
             this.$forceUpdate();
             this.$emit('n_onchange');
          }
       },//End methods
       computed: {
            filtered_options() {
                return this.options.filter((option) => option.label.match(this.inp_search));
            },
            selected_values()
            {
                let the_values = '[';
               this.vm_inps.forEach(function (arrayItem, key, arr) {
                     if(arrayItem.value)
                     {
                         if(key > 0){
                            the_values += ',' ;
                         }
                         the_values += arrayItem.value ;
                     }
                });
                the_values += ']';
                return the_values;
            }
        },//End computed
    };
</script>
