<template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Products sort for sub category ({{$route.params.id}})</h2>

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
    name: 'categories-subCategories-product-sort',
    mixins: [AdminSortMixin],
    data: () => ({
        Permission: 'CategoriesSubCategories',
        api_get_listWithoutPaginate: `Product/list_products_by_category_id`,
        // api_get_listWithoutPaginate: `Product/list_products_by_category_id/1021`,
        api_updateRowsPosition: 'Product/updateRowsPosition',
    }),//end data
    created(){
     },
    methods:{
      listWithoutPaginate()
      {
        this.mainList_no_Paginate = [];
        this.show_spinner = true;
         $.ajax({
           type:"get",
           url: `${Admin_BASE_url}/${this.api_get_listWithoutPaginate}/${this.$route.params.id}` ,
           headers: { 'jwt': localStorage.getItem('jwt') }
         })
         .done(function(Response){
              if(Response.status == 'unValidJWT'){
                 localStorage.removeItem('jwt');
                 this.$router.push('/login');
              }
              this.mainList_no_Paginate = Response;
              this.show_spinner = false;

              $( ".row_sortable" ).sortable({
                  delay: 150,
                  stop: function() {
                      var selectedData = new Array();
                      $('.row_sortable>tr').each(function() {
                           selectedData.push($(this).data("id"));
                      });
                      this.updateRowsPosition(selectedData);
                  }.bind(this)
               });//End sortable()

         }.bind(this))
         .fail(function(data){
            new Noty({text: 'proplem' , type: 'error'  }).show();
         });
      },
    }//End methods
}//End export default
</script>
