<style>
   .ck-editor__editable_inline {
     min-height: 140px;
   }

</style>
<template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Base Products ({{ mainList.total }})</h2>

     <section class="section-page-control">
        <v-row>
           <v-col cols="4" >
             <v-btn @click="showCreateModel()" class="ma-2" outlined color="indigo"> <b-icon-plus></b-icon-plus> Add New</v-btn>
             <router-link to="/BaseProduct/sort"> <v-btn class="ma-2" outlined color="black"> <b-icon-filter></b-icon-filter> Sort  </v-btn> </router-link>

          </v-col>
          <v-col>
                <div class="text-right">
                   <v-select @change="getResults()" outlined v-model="ST.category_id" :items="Categories" item-text="label" item-value="value" label="Categories" style="width:42%;display:inline-block;margin-right:10px"  ></v-select>
                   <v-text-field v-model="ST.search" @keyup.enter="getResults()" label="Search" outlined shaped style="width:42%;display:inline-block;" ></v-text-field>
                   <v-btn @click="getResults()" class="ma-2 btn-refresh" fab  outlined   color="indigo"> <font-awesome-icon icon="redo" size="lg" spin  /> </v-btn>
                </div>
          </v-col>
        </v-row>
    </section><!--End section-page-control-->

    <table class="tbl_mainList">
       <thead>
          <th> Id </th>
          <th> Category </th>
          <th> Name En </th>
          <th> Name Ar </th>
          <th> Created date </th>
          <th> Action </th>
       </thead>
       <tbody is="transition-group" name="my-list" >
          <tr v-for="(item,index) in mainList.data" :key="item.id">
             <td>{{ item.id }}</td>
             <td>{{ item.category_name }}</td>
             <td>{{ item.name_en }}</td>
             <td>{{ item.name_ar }}</td>
             <td>{{ item.created_at }} <br> [{{ item.created_at | moment("from", "now") }}] </td>
             <td style="width: 30%;">
                 <ActionRowTd :item="item" :index="index" @showORhide="showORhide(item)"
                              @showEditModel="showEditModel(item)" @del_row="del_row(item,index)" >
                 </ActionRowTd>
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
                        <v-select  outlined v-model="CF.category_id" :items="Categories" item-text="label" item-value="value" label="Categories" :rules="requiredRules" ></v-select>
                        <v-text-field label="Name En" v-model="CF.name_en" outlined :rules="[v => !!v || 'field is required']" ></v-text-field>
                        <v-text-field label="Name Ar" v-model="CF.name_ar" outlined required :rules="requiredRules"></v-text-field>

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
                  <v-btn large color="success" dark @click="create()" :disabled="btn_submit" >Save</v-btn>
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
                        <v-select  outlined v-model="EF.category_id" :items="Categories" item-text="label" item-value="value" label="Categories" :rules="requiredRules" ></v-select>
                        <v-text-field label="Name En" v-model="EF.name_en" outlined :rules="[v => !!v || 'field is required']" ></v-text-field>
                        <v-text-field label="Name Ar" v-model="EF.name_ar" outlined required :rules="requiredRules"></v-text-field>

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
                  <v-btn large color="success" dark @click="edit()" :disabled="btn_submit" >Save</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-row>

  </div><!--End page-wrapper-->
</template>

<script>
  import {AdminMixin} from '@/mixins/Admin_mixin';

  export default {
    name: 'BaseProduct',
    mixins: [AdminMixin],
     data: () => ({
        Permission: 'BaseProduct',
        api_get_list: 'BaseProduct/list',
        api_showORhide: 'BaseProduct/showORhide',
        api_delete: 'BaseProduct/delete',
        api_create: 'BaseProduct/create',
        api_update: 'BaseProduct/update',
        Categories: []
    }),//end data
    created(){
        this.vars_for_selections();
    },
    methods:{
        vars_for_selections()
        {
              $.ajax({
                 type:"get",
                 url: `${Admin_BASE_url}/BaseProduct/selection_data` ,
                 headers: { 'jwt': localStorage.getItem('jwt') }
             })
             .done(function(Response){
                if(Response.status == 'unValidJWT'){
                     localStorage.removeItem('jwt');
                     this.$router.push('/login');
                }
                this.Categories = Response.Categories;
                this.Categories.unshift({ label:'All ' , value: null });
             }.bind(this))
             .fail(function(data){
                new Noty({text: 'proplem' , type: 'error'  }).show();
             });
        }
    }//End methods
}//End export default
</script>
