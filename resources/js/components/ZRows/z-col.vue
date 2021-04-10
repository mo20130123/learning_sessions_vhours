<style scoped  >


</style>

<template>
    <div :style="Fstyle">
            <slot></slot>
    </div>
</template>

<script>
    export default {
         name: 'z-col',
         props: {
             // options: Array,
             // n_onchange: Function,
             // wrap: {
             //     type: Boolean ,
             //     default: () => true
             // },
             col: {
                 type: Number ,
                 default: () => null
             },
         },
         data: () => ({

         }),//end data
        mounted() {


        },//End mounted
        methods:{


       },//End methods
       computed: {
            Fstyle()
            {
                return {
                    'flex-grow': this.col
                };
            }
        },//End computed
    };
</script>
