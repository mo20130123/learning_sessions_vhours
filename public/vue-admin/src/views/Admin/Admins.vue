<style scoped>
   .super_admin
   {
      background-color: green!important;
      color: white;
   }
</style>
<template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Admins</h2>

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
          <th> User name </th>
          <th> Email </th>
          <th> Phone </th>
          <th> Role </th>
          <!-- <th> Created date </th> -->
          <th> Action </th>
       </thead>
       <tbody is="transition-group" name="my-list" >
          <tr v-for="(item,index) in mainList.data" :key="item.id" v-if="item.id!=2" :class="{'super_admin':item.super_admin}" >
             <td>{{ item.id }}</td>
             <td>{{ item.name }}</td>
             <td>{{ item.username }}</td>
             <td>{{ item.email }}</td>
             <td>{{ item.phone }}</td>
             <td>
                <span v-if="!item.super_admin" > {{ item.role }} </span>
                <span v-else > <v-chip color="red" dark> Super Admin  </v-chip> </span>
             </td>
             <!-- <td>{{ item.created_at }} <br> [{{ item.created_at | moment("from", "now") }}] </td> -->
             <td style="width: 18%;">
                <!-- <div>
                   <b-icon-eye       v-if="item.status" @click="showORhide(item)" font-scale="1.6" variant="success"></b-icon-eye>
                   <b-icon-eye-slash v-else             @click="showORhide(item)" font-scale="1.6" variant="danger"></b-icon-eye-slash>
                </div> -->
                <div>
                   <b-icon-pencil-square  @click="showEditModel(item)" font-scale="1.6"  ></b-icon-pencil-square>
                </div>
                <div>
                   <b-icon-trash v-if="!item.super_admin" @click="del_row(item,index)" font-scale="1.6" variant="danger" ></b-icon-trash>
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
                           <v-text-field label="User name" v-model="CF.username" outlined required :rules="requiredRules"></v-text-field>
                           <v-text-field label="Password" v-model="CF.password" outlined required :rules="requiredRules" ></v-text-field>
                       </v-col>
                       <v-col>
                           <v-text-field label="Email" v-model="CF.email" name="input-7-4" outlined :rules="requiredRules"></v-text-field>
                           <v-text-field label="Phone" v-model="CF.phone" name="input-7-4" outlined :rules="requiredRules" type="number"></v-text-field>
                           <v-select outlined v-model="CF.role_id" :items="roles" item-text="label" item-value="value" label="role" :rules="requiredRules" ></v-select>
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
                             <v-text-field label="User name" v-model="EF.username" outlined required :rules="requiredRules"></v-text-field>
                             <v-text-field label="Password" v-model="EF.password" outlined required   ></v-text-field>
                           </v-col>
                        <v-col>
                             <v-text-field label="Email" v-model="EF.email" name="input-7-4" outlined :rules="requiredRules"></v-text-field>
                             <v-text-field label="Phone" v-model="EF.phone" name="input-7-4" outlined :rules="requiredRules" type="number"></v-text-field>
                             <v-select outlined v-show="!EF.super_admin" v-model="EF.role_id" :items="roles" item-text="label" item-value="value" label="role" :rules="requiredRules" ></v-select>
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
        api_get_list: 'Admin/list',
        api_showORhide: 'Admin/showORhide',
        api_delete: 'Admin/delete',
        api_create: 'Admin/create',
        api_update: 'Admin/update',
        roles: []
    }),//end data
    created(){
      this.roles_list();
    },
    methods:{
      roles_list()
      {
             $.ajax({
                type:"get",
                url: `${Admin_BASE_url}/Admin/selection_data` ,
                headers: { 'jwt': localStorage.getItem('jwt') }
            })
            .done(function(Response){
               if(Response.status == 'unValidJWT'){
                    localStorage.removeItem('jwt');
                    this.$router.push('/login');
               }
               this.roles = Response.roles;
               this.roles.unshift({ label:'All' , value: null });
            }.bind(this))
            .fail(function(data){
               new Noty({text: 'proplem' , type: 'error'  }).show();
            });
      }
    }//End methods
}//End export default
</script>
