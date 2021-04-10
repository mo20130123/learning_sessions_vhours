<style  >
  #sec_Recipe .active{
    color: green;
  }
</style>
<template>
  <div class="page-wrapper" id="sec_Recipe">

     <h2 class="font-italic font-weight-light font-weight-bold">Recipes</h2>

     <section class="section-page-control">
        <v-row>
           <v-col cols="5" style="padding-bottom: 0px;">
               <router-link to="/Recipe/create"> <v-btn class="ma-2" outlined color="indigo"> <b-icon-plus></b-icon-plus> Add New</v-btn> </router-link>
               <router-link to="/Recipe/sort"> <v-btn class="ma-2" outlined color="black"> <b-icon-filter></b-icon-filter> Sort  </v-btn> </router-link>

          </v-col>
          <v-col  style="padding-bottom: 0px;">
              <div class="text-right">
                 <v-select @change="getResults()" outlined v-model="ST.category_id" :items="Categories" item-text="label" item-value="value" label="Category" style="width:42%;display:inline-block;margin-right:10px"  ></v-select>
                 <v-text-field v-model="ST.search" @keyup.enter="getResults()" label="Search" outlined shaped style="width:42%;display:inline-block;" ></v-text-field>
                 <v-btn @click="getResults()" class="ma-2 btn-refresh" fab  outlined   color="indigo"> <b-icon-arrow-repeat font-scale="1.5"></b-icon-arrow-repeat> </v-btn>
              </div>
          </v-col>
        </v-row>

    </section><!--End section-page-control-->

    <table class="tbl_mainList">
       <thead>
          <th> Id </th>
          <th> Image </th>
          <!-- <th> Name En </th>
          <th> Name Ar </th> -->
          <th> Name   </th>
          <th> PREP TIME </th>
          <th> Created date </th>
          <th> Action </th>
       </thead>
       <tbody is="transition-group" name="my-list" >
          <tr v-for="(item,index) in mainList.data" :key="item.id">
             <td>{{ item.id }}</td>
             <td> <img :src="item.image" class="img-table">   </td>
             <td>
                <p>{{ item.name_en }}</p>
                <p>{{ item.name_ar }}</p>
             </td>
             <td>
                <p>{{ item.time_en }}</p>
                <p>{{ item.time_ar }}</p>
             </td>
             <td>
                {{ item.created_at }} <br> [{{ item.created_at | moment("from", "now") }}]
             </td>
             <td style="width: 20%;">
               <div class="">
                   <div>
                     <b-icon-eye       v-if="item.status" @click="showORhide(item)" font-scale="1.6" variant="success"></b-icon-eye>
                     <b-icon-eye-slash v-else             @click="showORhide(item)" font-scale="1.6" variant="danger"></b-icon-eye-slash>
                   </div>
                   <div>
                     <router-link :to="'/Recipe/edit/'+item.id" >
                       <b-icon-pencil-square font-scale="1.6" color="black" ></b-icon-pencil-square>
                     </router-link>
                   </div>
                   <div>
                     <b-icon-trash @click="del_row(item,index)" font-scale="1.6" variant="danger" ></b-icon-trash>
                   </div>
               </div>
             </td>
          </tr>
       </tbody>
    </table>

       <!-- - - - - - -START spinner & paginate - - - - - - - -->
       <spinnerPagnation :mainList="mainList" :show_spinner="show_spinner" @getResults="getResults"></spinnerPagnation>
       <!-- - - - - - -END spinner & paginate - - - - - - - -->

  </div><!--End page-wrapper-->
</template>

<script>
  import {AdminMixin} from '@/mixins/Admin_mixin';

  export default {
    name: 'Recipe',
    mixins: [AdminMixin],
     data: () => ({
        Permission: 'Recipe',
        api_get_list: 'Recipe/list',
        api_showORhide: 'Recipe/showORhide',
        api_delete: 'Recipe/delete',
        Categories: [],
        Type: [
          { label: 'All' , value: null },
          { label: 'chef recommends' , value: 'is_chef_rec' },
        ],
        stock_search: [
          { label: 'All' , value: null },
          { label: 'stock < 15' , value: '15' },
          { label: 'stock < 10' , value: '10' },
          { label: 'stock < 5' , value: '5' },
          { label: 'stock = 0' , value: '0' },
        ],
    }),//end data
    created(){
      this.getCategories_list();
    },
    methods:{
         getCategories_list()
         {
               $.ajax({
                  type:"get",
                  url: `${Admin_BASE_url}/Recipe/selection_data` ,
                  headers: { 'jwt': localStorage.getItem('jwt') }
               })
              .done(function(Response){
                 if(Response.status == 'unValidJWT'){
                      localStorage.removeItem('jwt');
                      this.$router.push('/login');
                 }
                 this.Categories = Response.RecipesCategories;
                 this.Categories.unshift({ label:'All ' , value: null });
              }.bind(this))
              .fail(function(data){
                 new Noty({text: 'proplem' , type: 'error'  }).show();
              });
         },
    },//End methods
    computed: {

    }
}//End export default
</script>
