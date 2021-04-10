<template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Products Discount sort</h2>

      <div>
         <router-link to="/Product"> <span> Products </span> </router-link> / <span>Sort</span>
      </div>
         <h3 class="text-center"> Drag rows for rearrange</h3>
    <table class="tbl_mainList">
       <thead>
          <th> Id </th>
          <!-- <th> Image </th> -->
          <th> Name </th>
          <th> Price </th>
          <th> Action </th>
       </thead>
       <tbody is="transition-group" name="my-list" class="row_sortable">
          <tr v-for="(item,index) in mainList_no_Paginate" :key="item.id" :data-id="item.id">
             <td>{{ item.id }}</td>
             <!-- <td> <img :src="item.image" class="img-table">   </td> -->
             <td>{{ item.name }}</td>
             <td>{{ item.price }} EGP</td>
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
    name: 'Product-sort',
    mixins: [AdminSortMixin],
    data: () => ({
        Permission: 'Product',
        api_get_listWithoutPaginate: 'Product/list_without_paginate/discount',
        api_updateRowsPosition: 'Product/updateRowsPositionWithclassification/discount',
        Permission: 'Product'
    }),//end data
    created(){

    },
    methods:{
        updateRowsPosition(arrayList)
        {
           var my_formData = {
             postionArray: arrayList,
             classification: 'discount',
             jwt: localStorage.getItem('jwt')
           }

           $.post(`${Admin_BASE_url}/${this.api_updateRowsPosition}`,my_formData)
            .done( function(Response){
                if(Response.status == 'unValidJWT'){
                     localStorage.removeItem('jwt');
                     this.$router.push('/login');
                }
                else if(Response.status == 'success'){
                     new Noty({text: 'Items Rearranged', type: 'success' }).show();
                }
                else {
                     new Noty({text: 'problem in Rearranged please try agine' , type: 'error' }).show();
                }
            }.bind(this))
            .fail( function(xhr, textStatus, errorThrown) {
                 new Noty({text: 'proplem' , type: 'error'  }).show(); alert(xhr.responseText);
            });
         },
    }//End methods
}//End export default
</script>
