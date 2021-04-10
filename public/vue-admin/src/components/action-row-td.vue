
<template>
  <div>
    <div v-if="show_eye">
        <v-btn v-if="item.status" @click="showORhide()" >
            <font-awesome-icon icon="eye" size="lg" :style="{ color: 'green' }" />
        </v-btn>
        <v-btn v-else @click="showORhide()" >
            <font-awesome-icon icon="eye-slash" size="lg" :style="{ color: '#dc3545' }" />
        </v-btn>
    </div>
    <div v-if="show_edit">
         <v-btn @click="showEditModel()">
            <font-awesome-icon icon="edit" size="lg"   />
         </v-btn>
     </div>

     <slot></slot>

    <div v-if="show_trash">
        <v-btn @click="del_row()">
           <font-awesome-icon icon="trash-alt" size="lg"  :style="{ color: '#dc3545' }" />
        </v-btn>
    </div>



  </div>
</template>

<script>
  export default {
    name: 'ActionRowTd',
    props:{
      item: Object,
      index: Number,
      show_eye: {
         type: Boolean ,
         default: () => true
      },
      show_edit: {
         type: Boolean ,
         default: () => true
      },
      show_trash: {
         type: Boolean ,
         default: () => true
      },
    },
    data: () => ({

    }),
    methods:{
        showORhide() {
           this.$emit('showORhide', this.item);
        },
        showEditModel() {
           this.$emit('showEditModel',this.item);
        },
        del_row() { console.log('index' + this.index );
           this.$emit('del_row',this.item,this.index);
        },
    }
  }
</script>
