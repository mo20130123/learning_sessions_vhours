<template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Categories </h2>

     <section class="section-page-control">
        <v-row>
           <v-col cols="7" >
             <router-link to="/CategoriesSubCategories/create"> <v-btn class="ma-2" outlined color="indigo"> <b-icon-plus></b-icon-plus> Add New</v-btn> </router-link>
             <router-link to="/CategoriesSubCategories/sort"> <v-btn class="ma-2" outlined color="black"> <b-icon-filter></b-icon-filter> Sort Cats </v-btn> </router-link>
             <router-link to="/CategoriesSubCategories/subsCats"> <v-btn class="ma-2" outlined color="black"> <b-icon-filter></b-icon-filter> Sort subs  </v-btn> </router-link>

          </v-col>
          <v-col>
                <div class="text-right">
                    <v-text-field v-model="ST.search" @keyup.enter="getResults()" label="Search" outlined shaped style="width:82%;display:inline-block;" ></v-text-field>
                   <v-btn @click="getResults()" class="ma-2 btn-refresh" fab  outlined   color="indigo"> <b-icon-arrow-repeat font-scale="1.5"></b-icon-arrow-repeat> </v-btn>
                </div>
          </v-col>
        </v-row>
    </section><!--End section-page-control-->

    <table class="tbl_mainList">
       <thead>
          <th> Id </th>
          <th> Icon </th>
          <th> Name En </th>
          <th> Name Ar </th>
          <th> Created date </th>
          <th> Action </th>
       </thead>
       <tbody is="transition-group" name="my-list" >
          <tr v-for="(item,index) in mainList.data" :key="item.id">
             <td>{{ item.id }}</td>
             <td> <img :src="item.icon" class="img-table">   </td>
             <td>{{ item.name_en }}</td>
             <td>{{ item.name_ar }}</td>
             <td>{{ item.created_at }} <br> [{{ item.created_at | moment("from", "now") }}] </td>
             <td style="width: 25%;">
                <div>
                   <b-icon-eye       v-if="item.status" @click="showORhide(item)" font-scale="1.6" variant="success"></b-icon-eye>
                   <b-icon-eye-slash v-else             @click="showORhide(item)" font-scale="1.6" variant="danger"></b-icon-eye-slash>
                </div>
                <div>
                   <router-link :to="'/CategoriesSubCategories/edit/'+item.id" >
                      <b-icon-pencil-square font-scale="1.6" color="black" ></b-icon-pencil-square>
                   </router-link>
                </div>
                <!-- <div>
                   <router-link :to="'/CategoriesSubCategories/sortProducts/'+item.id" v-b-tooltip.hover.top title="Sort Products">
                      <b-icon-filter font-scale="1.6" color="black" ></b-icon-filter>
                   </router-link>
                </div> -->
                <div>
                   <b-icon-trash @click="del_row(item,index)" font-scale="1.6" variant="danger" ></b-icon-trash>
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
    name: 'CategoriesSubCategories',
    mixins: [AdminMixin],
     data: () => ({
        Permission: 'CategoriesSubCategories',
        api_get_list: 'CategoriesSubCategories/list',
        api_showORhide: 'CategoriesSubCategories/showORhide',
        api_delete: 'CategoriesSubCategories/delete',
        CategoriesSubCategoriesCategory: [],
    }),//end data
    created(){

    },
    methods:{

    }//End methods
}//End export default
</script>
