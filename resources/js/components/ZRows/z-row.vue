<style scoped  >


</style>

<template>
    <div class="flex-container" :style="Fstyle">
            <slot></slot>
    </div>
</template>

<script>
    export default {
         name: 'z-row',
         props: {
             // options: Array,
             // n_onchange: Function,
             // wrap: {
             //     type: Boolean ,
             //     default: () => true
             // },
             wrap: {
                 type: String ,
                 default: () => 'wrap'
             },
         },
         data: () => ({
                co: 'red'
         }),//end data
        mounted() {


        },//End mounted
        methods:{

       },//End methods
       computed: {
            Fstyle()
            {
                return {
                    "display" : "flex",
                    "flex-wrap": this.wrap
                }
            }
        },//End computed
    };
</script>
