<template>
  <div class="page-wrapper" id="sec_roles">

     <h2 class="font-italic font-weight-light font-weight-bold">Roles</h2>

     <section class="section-page-control">
        <v-row>
           <v-col cols="7" >
             <v-btn @click="showCreateModel()" class="ma-2" outlined color="indigo"> <b-icon-plus></b-icon-plus> Add New</v-btn>

          </v-col>
          <v-col>
                <div class="">
                   <v-text-field v-model="ST.search" @keyup.enter="getResults()" label="Search" outlined shaped style="width:80%;display:inline-block;" ></v-text-field>
                   <v-btn @click="getResults()" class="ma-2 btn-refresh" fab  outlined   color="indigo"> <b-icon-arrow-repeat font-scale="1.5"></b-icon-arrow-repeat> </v-btn>
                </div>
          </v-col>
        </v-row>
    </section><!--End section-page-control-->

    <table class="tbl_mainList">
       <thead>
          <th> Id </th>
          <th> Name  </th>
          <th> Comment </th>
          <!-- <th> Created date </th> -->
          <th> Action </th>
       </thead>
       <tbody is="transition-group" name="my-list" >
          <tr v-for="(item,index) in mainList.data" :key="item.id">
             <td>{{ item.id }}</td>
             <td>{{ item.name }}</td>
             <td>{{ item.comment }}</td>
             <!-- <td>{{ item.created_at }} <br> [{{ item.created_at | moment("from", "now") }}] </td> -->
             <td style="width: 18%;">
                <!-- <div>
                   <b-icon-eye       v-if="item.status" @click="showORhide(item)" font-scale="1.6" variant="success"></b-icon-eye>
                   <b-icon-eye-slash v-else             @click="showORhide(item)" font-scale="1.6" variant="danger"></b-icon-eye-slash>
                </div> -->
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
                          <v-text-field label="Name" v-model="CF.name" outlined :rules="[v => !!v || 'field is required']" ></v-text-field>
                          <v-textarea label="Comment" v-model="CF.comment" name="input-7-4" outlined rows="6" :rules="requiredRules"></v-textarea>
                       </v-col>
                       <v-col>
                          <v-switch v-model="CF.permissions" label="DashBoard" value="1" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="Members" value="2" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="Contact Us" value="22" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="Applicant" value="26" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="Subscriber" value="27" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="City" value="9" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="District" value="4" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="FAQs" value="14" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="Pages Banner" value="16" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="Home Slider" value="17" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="Categories & Sub Categories" value="3" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="Product" value="19" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="update Stock With Excel" value="37" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="Bundel" value="20" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="Recipe" value="18" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="Promo Codes" value="21" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="Info & Content" value="24" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="Seo Keywords" value="25" color="success" hide-details ></v-switch>
                          <hr>
                          <v-switch v-model="CF.permissions" label="Orders"             value="36" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="Order Acknowledged" value="31" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="Order Preparing"    value="32" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="Order Dispatched"   value="33" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="Order Delivered"    value="34" color="success" hide-details ></v-switch>
                          <v-switch v-model="CF.permissions" label="Order Canceled"     value="35" color="success" hide-details ></v-switch>
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
                          <v-text-field label="Name" v-model="EF.name" outlined :rules="[v => !!v || 'field is required']" ></v-text-field>
                          <v-textarea label="Comment" v-model="EF.comment" name="input-7-4" outlined rows="6" :rules="requiredRules"></v-textarea>
                       </v-col>
                       <v-col>
                            <v-switch v-model="EF.permissions" label="DashBoard" value="1" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="Members" value="2" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="Contact Us" value="22" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="Applicant" value="26" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="Subscriber" value="27" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="City" value="9" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="District" value="4" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="FAQs" value="14" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="Pages Banner" value="16" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="Home Slider" value="17" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="Categories & Sub Categories" value="3" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="Product" value="19" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="update Stock With Excel" value="37" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="Bundel" value="20" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="Recipe" value="18" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="Promo Codes" value="21" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="Info & Content" value="24" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="Seo Keywords" value="25" color="success" hide-details ></v-switch>
                            <hr>
                            <v-switch v-model="EF.permissions" label="Orders"             value="36" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="Order Acknowledged" value="31" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="Order Preparing"    value="32" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="Order Dispatched"   value="33" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="Order Delivered"    value="34" color="success" hide-details ></v-switch>
                            <v-switch v-model="EF.permissions" label="Order Canceled"     value="35" color="success" hide-details ></v-switch>
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
    name: 'Admin',
    mixins: [AdminMixin],
     data: () => ({
        Permission: 'is_super_admin',
        api_get_list: 'Roles/list',
        api_showORhide: 'Roles/showORhide',
        api_delete: 'Roles/delete',
        api_create: 'Roles/create',
        api_update: 'Roles/update',
        CF: {
           permissions: []
        },
        EF: {
           permissions: []
        },
    }),//end data
    created(){

    },
    methods:{
         showEditModel(this_data)
         {
             this.editDialog = true;
             this.EF = this_data;
             this.EF.permissions = this_data.permissions ? this_data.permissions.split(',') : [] ;
         },
    }//End methods
}//End export default
</script>
