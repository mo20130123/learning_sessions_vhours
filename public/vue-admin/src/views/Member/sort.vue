<template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Members sort</h2>

      <div>
         <router-link to="/Member"> <span> Members </span> </router-link> / <span>Sort</span>
      </div>
         <h3 class="text-center"> Drag rows for rearrange</h3>
    <table class="tbl_mainList">
       <thead>
          <th> Id </th>
          <!-- <th> Image </th> -->
          <th> Name </th>
          <th> Action </th>
       </thead>
       <tbody is="transition-group" name="my-list" class="row_sortable">
          <tr v-for="(item,index) in mainList_no_Paginate" :key="item.id" :data-id="item.id">
             <td>{{ item.id }}</td>
             <!-- <td> <img :src="item.image" class="img-table">   </td> -->
             <td>{{ item.name }}</td>
             <td style="width: 20%;">
                <div>
                   <b-icon-arrows-move></b-icon-arrows-move>
                </div>
             </td>
          </tr>
       </tbody>
    </table>



  </div><!--End page-wrapper-->
</template>

<script>
  import {AdminSortMixin} from '@/mixins/Admin_sort_mixin';

  export default {
    name: 'Member-sort',
    mixins: [AdminSortMixin],
    data: () => ({
        api_get_listWithoutPaginate: 'Member/list_without_paginate',
        api_updateRowsPosition: 'Member/updateRowsPosition',
    }),//end data
    created(){

    },
    methods:{

    }//End methods
}//End export default
</script>
