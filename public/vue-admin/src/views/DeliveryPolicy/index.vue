<template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Delivery Policy</h2>

     <section class="section-page-control">
        <v-row>
           <v-col cols="7" >
             <v-btn @click="showCreateModel()" class="ma-2" outlined color="indigo"> <b-icon-plus></b-icon-plus> Add New</v-btn>
             <router-link to="/DeliveryPolicy/sort"> <v-btn class="ma-2" outlined color="black"> <b-icon-filter></b-icon-filter> Sort  </v-btn> </router-link>
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
          <th> Title en </th>
          <th> Title ar </th>
          <th> Action </th>
       </thead>
       <tbody is="transition-group" name="my-list" >
          <tr v-for="(item,index) in mainList.data" :key="item.id">
             <td>{{ item.id }}</td>
             <td>{{ item.title_en }}</td>
             <td>{{ item.title_ar }}</td>
             <td style="width: 25%;">
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
                <v-dialog v-model="createDialog" scrollable  max-width="1000px">
                   <v-card>
                     <v-card-title   class="headline grey lighten-2"   primary-title   >
                       Create New
                     </v-card-title>
                     <v-card-text>
                       <v-container>
                         <v-form  id="create_form" ref="createForm" v-model="isValid_createForm" :lazy-validation="false" >
                             <v-row>
                               <v-col>
                                   <v-text-field label="Title En" v-model="CF.title_en" outlined :rules="requiredRules" ></v-text-field>
                                   <v-textarea label="Body En" v-model="CF.text_en" name="input-7-4" outlined rows="15" :rules="requiredRules"></v-textarea>
                                 </v-col>
                               <v-col>
                                    <v-text-field label="Title Ar" v-model="CF.title_ar" outlined required :rules="requiredRules"></v-text-field>
                                    <v-textarea label="Body En" v-model="CF.text_ar" name="input-7-4" outlined rows="15" :rules="requiredRules"></v-textarea>
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
                         <v-btn large color="success" dark @click="create()" :disabled="btn_submit" >Save</v-btn>
                     </v-card-actions>
                   </v-card>
                 </v-dialog>
               </v-row>

              <!-- ------------------- Edit ----------------------- - -->
              <v-row justify="center">
                <v-dialog v-model="editDialog" scrollable  max-width="1000px">
                   <v-card>
                     <v-card-title   class="headline grey lighten-2"   primary-title   >
                       Edit
                     </v-card-title>
                     <v-card-text>
                       <v-container>
                         <v-form  id="edit_image" ref="editForm" v-model="isValid_editForm" :lazy-validation="false" >
                             <v-row>
                                <v-col>
                                    <v-text-field label="Title En" v-model="EF.title_en" outlined :rules="requiredRules" ></v-text-field>
                                    <v-textarea label="Body En" v-model="EF.text_en" name="input-7-4" outlined rows="15" :rules="requiredRules"></v-textarea>
                                  </v-col>
                                <v-col>
                                     <v-text-field label="Title Ar" v-model="EF.title_ar" outlined required :rules="requiredRules"></v-text-field>
                                     <v-textarea label="Body En" v-model="EF.text_ar" name="input-7-4" outlined rows="15" :rules="requiredRules"></v-textarea>
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
    name: 'DeliveryPolicy',
    mixins: [AdminMixin],
     data: () => ({
        Permission: 'DeliveryPolicy',
        api_get_list: 'DeliveryPolicy/list',
        api_showORhide: 'DeliveryPolicy/showORhide',
        api_delete: 'DeliveryPolicy/delete',
        api_create: 'DeliveryPolicy/create',
        api_update: 'DeliveryPolicy/update',
    }),//end data
    created(){

    },
    methods:{

    }//End methods
}//End export default
</script>
