<style scoped>

</style>

<!-- v-on:s_change="myfun()"  -->


<template>
    <select :class="s_class" :name="name" :id="s_id" :data-the_id="the_id" :value="value" :required="required ? true : false" readonly='true'  > <!-- :value="value" v-model="model"-->
        <option value=""> {{f_item?f_item:' اختار '}} </option>
        <!-- <option value=""> chosse </option> -->
        <option v-for="row in options" :value="row.value" v-text="row.label"  >  </option>
    </select>
</template>

<script>
    export default {
        props: {
            options: Array,
            s_onchange: Function,
            s_id: '',
            s_class: '',
            name: '',
            dir: '',
            value: "",
            // model: "",
            f_item: '',
            required: false,
            readonly: false
        },
        data(){
          return {
              the_id: 'select_'+ Math.random().toString(36)
          }
        },
        mounted() {
                                 console.log('select  mounted');
            $("select[data-the_id='"+this.the_id+"']").select2({width:'100%',dir:this.dir?this.dir:'rtl'});

            $("select[data-the_id='"+this.the_id+"']").change(function(event) {
                this.$emit('s_change');
            }.bind(this));


        },
        watch: {
            options()
            {                               console.log('options changed f => '+this.the_id); $("select[data-the_id='"+this.the_id+"']").val(this.value); 
                  // $("select[data-the_id='"+this.the_id+"']").empty();
                  // this.options.forEach((op)=>{
                  //     var newOption = new Option(op.label, op.value, false, false);
                  //     $("select[data-the_id='"+this.the_id+"']").append(newOption).trigger('change');
                  // });
            },
            value()
            { console.log('val');
               $("select[data-the_id='"+this.the_id+"']").val(this.value);
            }
        }
    }
</script>
