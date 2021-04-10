<style  >
  #sec_product .active{
    color: green;
  }
</style>
<template>
  <div class="page-wrapper" id="sec_product">

     <h2 class="font-italic font-weight-light font-weight-bold float-left">Products ({{ mainList.total }})</h2>
     <!-- <a :href="export_url" target="_blank" class="float-right">  <v-btn class="ma-2 btn-refresh" outlined > Export </v-btn> </a> -->
     <div style="clear:both"> </div>


     <section class="section-page-control">
        <v-row>
           <v-col cols="7" style="padding-bottom: 0px;">
             <router-link to="/Product/create"> <v-btn class="ma-2" outlined color="indigo"> <b-icon-plus></b-icon-plus> Add New</v-btn> </router-link>
             <router-link to="/Product/sort"> <v-btn class="ma-2" outlined color="black"> <b-icon-filter></b-icon-filter> Sort  </v-btn> </router-link>
             <!-- <router-link to="/Product/update_stock_with_excel"> <v-btn class="ma-2" outlined color="indigo"> <b-icon-plus></b-icon-plus> update stock with excel </v-btn> </router-link> -->
               <br>
             <!-- <router-link to="/Product/sort/chef"> <v-btn class="ma-2" outlined color="black"> <b-icon-filter></b-icon-filter>  sort Chef </v-btn> </router-link>
             <router-link to="/Product/sort/new"> <v-btn class="ma-2" outlined color="black"> <b-icon-filter></b-icon-filter>  sort New </v-btn> </router-link>
             <router-link to="/Product/sort/discount"> <v-btn class="ma-2" outlined color="black"> <b-icon-filter></b-icon-filter>  sort Discount </v-btn> </router-link> -->
          </v-col>
          <v-col  style="padding-bottom: 0px;">
              <div class="text-right">

                 <v-text-field v-model="ST.search" @keyup.enter="getResults()" label="Search" outlined shaped style="width:42%;display:inline-block;" ></v-text-field>
                 <v-btn @click="getResults()" class="ma-2 btn-refresh" fab  outlined   color="indigo"> <font-awesome-icon icon="redo" size="lg" spin  /> </v-btn>
              </div>
          </v-col>
        </v-row>
        <v-row>
          <v-col style="padding: 0 5px;">
                <div class="text-center">
                   <v-select @change="category_changed()" outlined v-model="ST.category_id" :items="CatsBaseProduct" item-text="label" item-value="value" label="Category" style="width:22%;display:inline-block;margin-right:10px"  ></v-select>
                   <v-select @change="getResults()" outlined v-model="ST.base_product_id" :items="BaseProducts" item-text="label" item-value="value" label="Base Products" style="width:22%;display:inline-block;margin-right:10px"  ></v-select>
                   <v-select @change="category_changed()" outlined v-model="ST.availability" :items="stock_search" item-text="label" item-value="value" label="Availability" style="width:22%;display:inline-block;margin-right:10px"  ></v-select>
                   <v-select @change="getResults()" outlined v-model="ST.type" :items="Type" item-text="label" item-value="value" label="Type" style="width:22%;display:inline-block;margin-right:10px"  ></v-select>
                    <!-- <v-btn @click="getResults()" class="ma-2 btn-refresh" fab  outlined   color="indigo"> <b-icon-arrow-repeat font-scale="1.5"></b-icon-arrow-repeat> </v-btn> -->
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
          <th> Path </th>
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
                <span style="display:block">{{item.category_name}}</span>
                  <b-icon-arrow-bar-down font-scale="1.6" color="black" ></b-icon-arrow-bar-down>
                <span style="display:block">{{item.sub_category_name}}</span>
                <v-chip v-if="item.discount_percentage" class="ma-2" color="red" text-color="white" > {{item.discount_percentage}}% off</v-chip>
             </td>
             <td>
                 {{ item.created_at | moment("d/M/YYYY, h:mm:ss a") }} <br> [{{ item.created_at | moment("from", "now") }}]
                     <hr>
                <p style="margin-bottom: 0px;">
                     <b v-if="item.is_available" style="color:green">is available</b>
                     <b v-else style="color:red">not available</b>
                </p>
                <p style="margin-bottom: 0px;">
                     <b v-if="item.is_bundle" > Bundle</b>
                     <b v-else >Product</b>
                </p>

           </td>
             <td>
                 <ActionRowTd :item="item" :index="index" @showORhide="showORhide(item)" :show_edit="false"
                              @showEditModel="showEditModel(item)" @del_row="del_row(item,index)" >
                        <router-link :to="'Product/edit/'+item.id">
                            <v-btn>
                                <font-awesome-icon icon="edit" size="lg" />
                            </v-btn>
                        </router-link>

                 </ActionRowTd>
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
    name: 'Product',
    mixins: [AdminMixin],
     data: () => ({
        Permission: 'Product',
        api_get_list: 'Product/list',
        api_showORhide: 'Product/showORhide',
        api_delete: 'Product/delete',
        api_isChefRec: 'Product/switch_is_chef_rec',
        api_isNew: 'Product/switch_is_new',
        categoiry_subCategory: [],
        export_url: Admin_BASE_url+`/Export/${localStorage.getItem('jwt')}/Products`,
        Type: [
          { label: 'All' , value: null },
          { label: 'products' , value: 'product' },
          { label: 'bundles' , value: 'bundle' },
        ],
        stock_search: [
          { label: 'All' , value: null },
          { label: 'is available ' , value: 'is available' },
          { label: 'not available' , value: 'not available' },
        ],
        CatsBaseProduct: [],
        providers: []
    }),//end data
    created(){
      this.getCategories_list();
    },
    methods:{
         getCategories_list()
         {
               $.ajax({
                  type:"get",
                  url: `${Admin_BASE_url}/Product/selection_data` ,
                  headers: { 'jwt': localStorage.getItem('jwt') }
               })
              .done(function(Response){
                 if(Response.status == 'unValidJWT'){
                      localStorage.removeItem('jwt');
                      this.$router.push('/login');
                 }
                 this.CatsBaseProduct = Response.categoiry_BaseProducts;
                 this.providers = Response.providers;
                 this.CatsBaseProduct.unshift({ label:'All ' , value: null });
                 this.providers.unshift({ label:'All ' , value: null });
              }.bind(this))
              .fail(function(data){
                 new Noty({text: 'proplem' , type: 'error'  }).show();
              });
         },
         category_changed()
         {
            this.ST.base_product_id = null;
            this.getResults();
         },
         switch_is_chef_rec(item)
         {
              $.ajax({
                 type:"get",
                 url: `${Admin_BASE_url}/${this.api_isChefRec}/${item.id}` ,
                 headers: { 'jwt': localStorage.getItem('jwt') }
             })
             .done(function(Response){
                item.is_chef_rec = Response.case;
                if(Response.case){
                   new Noty({text: 'Product assigned as chef rec', type: 'success'  }).show();
                }
                else {
                   new Noty({text: 'Product removed from chef rec' , type: 'error'  }).show();
                }
             }.bind(this))
             .fail(function(data){
                new Noty({text: 'proplem' , type: 'error'  }).show();
             });
         },
         switch_is_new(item)
         {
              $.ajax({
                 type:"get",
                 url: `${Admin_BASE_url}/${this.api_isNew}/${item.id}` ,
                 headers: { 'jwt': localStorage.getItem('jwt') }
             })
             .done(function(Response){
                item.is_new = Response.case;
                if(Response.case){
                   new Noty({text: 'Product assigned as new', type: 'success'  }).show();
                }
                else {
                   new Noty({text: 'Product removed from new' , type: 'error'  }).show();
                }
             }.bind(this))
             .fail(function(data){
                new Noty({text: 'proplem' , type: 'error'  }).show();
             });
         },
    },//End methods
    computed: {
        BaseProducts()
        {
              var get_subCat = this.CatsBaseProduct.find(obj=>obj.value == this.ST.category_id);
              if(get_subCat){
                return get_subCat.BaseProducts;
             }
        },
    }
}//End export default
</script>
