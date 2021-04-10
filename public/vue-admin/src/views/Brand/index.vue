<template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Brand</h2>

     <section class="section-page-control">
        <v-row>
           <v-col cols="4"  >
             <v-btn @click="showCreateModel()" class="ma-2" outlined color="indigo"> <b-icon-plus></b-icon-plus> Add New</v-btn>
             <router-link to="/Brand/sort"> <v-btn class="ma-2" outlined color="black"> <b-icon-filter></b-icon-filter> Sort  </v-btn> </router-link>

          </v-col>
          <v-col  >
                <div class="text-right">
                   <v-select @change="search_cat()" outlined v-model="ST.Category_id" :items="cats_subCats" item-text="label" item-value="value" label="Categories" style="width:28%;display:inline-block;margin-right:10px"  ></v-select>
                   <v-select @change="getResults()" outlined v-model="ST.SubCategory_id" :items="search_subCats" item-text="label" item-value="value" label="Sub Categories" style="width:28%;display:inline-block;margin-right:10px"  ></v-select>

                   <v-text-field v-model="ST.search" @keyup.enter="getResults()" label="Search" outlined shaped style="width:28%;display:inline-block;" ></v-text-field>
                   <v-btn @click="getResults()" class="ma-2 btn-refresh" fab  outlined   color="indigo"> <b-icon-arrow-repeat font-scale="1.5"></b-icon-arrow-repeat> </v-btn>
                </div>
          </v-col>
        </v-row>
    </section><!--End section-page-control-->

    <table class="tbl_mainList">
       <thead>
          <th> Id </th>
          <th> Name En </th>
          <th> Name Ar </th>
          <th> Category </th>
          <th> Created date </th>
          <th> Action </th>
       </thead>
       <tbody is="transition-group" name="my-list" >
          <tr v-for="(item,index) in mainList.data" :key="item.id">
             <td>{{ item.id }}</td>
             <td>{{ item.name_en }}</td>
             <td>{{ item.name_ar }}</td>
             <td>
               <p>{{ item.cat_name }}</p>
               <p>{{ item.sub_cat_name }}</p>
             </td>
             <td>{{ item.created_at }} <br> [{{ item.created_at | moment("from", "now") }}] </td>
             <td style="width: 20%;">
                <div>
                   <b-icon-eye       v-if="item.status" @click="showORhide(item)" font-scale="1.6" variant="success"></b-icon-eye>
                   <b-icon-eye-slash v-else             @click="showORhide(item)" font-scale="1.6" variant="danger"></b-icon-eye-slash>
                </div>
                <div>
                   <b-icon-pencil-square @click="showEditModel(item)" font-scale="1.6"  ></b-icon-pencil-square>
                </div>
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


       <!-- ------------------- create ----------------------- - -->
       <v-row justify="center">
         <v-dialog v-model="createDialog" scrollable  max-width="800px">
            <v-card>
              <v-card-title   class="headline grey lighten-2"   primary-title   >
                Create New
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-form  id="create_form" ref="createForm" v-model="isValid_createForm" :lazy-validation="false" >
                      <v-row>
                        <v-col>
                            <v-select outlined v-model="CF.category_id" :items="cats_subCats" item-text="label" item-value="value" label="Categories" :rules="requiredRules"  ></v-select>
                            <v-select outlined v-model="CF.sub_category_id" :items="create_subCats" item-text="label" item-value="value" label="Sub Categories" :rules="requiredRules" ></v-select>
                            <hr>
                            <v-text-field label="Name En" v-model="CF.name_en" outlined :rules="[v => !!v || 'field is required']" ></v-text-field>
                            <v-text-field label="Name Ar" v-model="CF.name_ar" outlined required :rules="requiredRules"></v-text-field>
                         </v-col>
                         <v-col>
                           <v-textarea label="Tags Description En" v-model="CF.og_description_en" name="input-7-4" outlined rows="5" ></v-textarea>
                           <v-textarea label="Tags Description Ar" v-model="CF.og_description_ar" name="input-7-4" outlined rows="5" ></v-textarea>
                         </v-col>
                      </v-row>
                  </v-form>
                    <!-- - - - - - -START spinner- - - - - - - -->
                    <spinner3 v-if="action_spinner"></spinner3>
                    <!-- - - - - - -End spinner- - - - - - - -->
                </v-container>

              </v-card-text>
              <v-divider></v-divider>
              <v-card-actions>
                 <v-spacer></v-spacer>
                  <v-btn large dark @click="createDialog = false">Close</v-btn>
                  <v-btn large color="success" dark @click="create(true)" :disabled="btn_submit" >Save</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-row>

       <!-- ------------------- Edit ----------------------- - -->
       <v-row justify="center">
         <v-dialog v-model="editDialog" scrollable  max-width="800px">
            <v-card>
              <v-card-title   class="headline grey lighten-2"   primary-title   >
                Edit
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-form  id="edit_image" ref="editForm" v-model="isValid_editForm" :lazy-validation="false" >
                      <v-row>
                        <v-col>
                            <v-select outlined v-model="EF.category_id" :items="cats_subCats" item-text="label" item-value="value" label="Categories" :rules="requiredRules" ></v-select>
                            <v-select outlined v-model="EF.sub_category_id" :items="edit_subCats" item-text="label" item-value="value" label="Sub Categories" :rules="requiredRules" ></v-select>
                            <hr>
                            <v-text-field label="Name En" v-model="EF.name_en" outlined :rules="[v => !!v || 'field is required']" ></v-text-field>
                            <v-text-field label="Name Ar" v-model="EF.name_ar" outlined required :rules="requiredRules"></v-text-field>
                         </v-col>
                         <v-col>
                           <v-textarea label="Tags Description En" v-model="EF.og_description_en" name="input-7-4" outlined rows="5" ></v-textarea>
                           <v-textarea label="Tags Description Ar" v-model="EF.og_description_ar" name="input-7-4" outlined rows="5" ></v-textarea>
                         </v-col>
                      </v-row>
                  </v-form>
                    <!-- - - - - - -START spinner- - - - - - - -->
                    <spinner3 v-if="action_spinner"></spinner3>
                    <!-- - - - - - -End spinner- - - - - - - -->
                </v-container>

              </v-card-text>
              <v-divider></v-divider>
              <v-card-actions>
                 <v-spacer></v-spacer>
                  <v-btn large dark @click="editDialog = false">Close</v-btn>
                  <v-btn large color="success" dark @click="edit(true)" :disabled="btn_submit" >Save</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-row>

  </div><!--End page-wrapper-->
</template>

<script>
  import {AdminMixin} from '@/mixins/Admin_mixin';

  export default {
    name: 'Brand',
    mixins: [AdminMixin],
     data: () => ({
        Permission: 'Brand',
        api_get_list: 'Brand/list',
        api_showORhide: 'Brand/showORhide',
        api_delete: 'Brand/delete',
        api_create: 'Brand/create',
        api_update: 'Brand/update',
        cats_subCats: []
    }),//end data
    created(){
       this.getCategoiry_subCategory_list();
    },
    methods:{
      getCategoiry_subCategory_list()
      {
            $.ajax({
               type:"get",
               url: `${Admin_BASE_url}/Brand/selection_data` ,
               headers: { 'jwt': localStorage.getItem('jwt') }
           })
           .done(function(Response){
              if(Response.status == 'unValidJWT'){
                   localStorage.removeItem('jwt');
                   this.$router.push('/login');
              }
              this.cats_subCats = Response.categoiry_subCategory;
              this.cats_subCats.unshift({ label:'All ' , value: null });
           }.bind(this))
           .fail(function(data){
              new Noty({text: 'proplem' , type: 'error'  }).show();
           });
      },
      search_cat()
      {
          this.ST.SubCategory_id = null;
          this.getResults();
      }
    },//End methods
    computed:{
       search_subCats()
       {
           if(this.ST.Category_id)
           {
               var find = this.cats_subCats.find( obj => obj.value == this.ST.Category_id );
               return find.subCategoiry;
           }
           else
           {
             this.ST.SubCategory_id = null;
             return [];
           }
       },
       create_subCats()
       {
           if(this.CF.category_id)
           {
               var find = this.cats_subCats.find( obj => obj.value == this.CF.category_id );
               return find.subCategoiry;
           }
           return [];
       },
       edit_subCats()
       {
           if(this.EF.category_id)
           {
               var find = this.cats_subCats.find( obj => obj.value == this.EF.category_id );
               return find.subCategoiry;
           }
           return [];
       }
    }
}//End export default
</script>
