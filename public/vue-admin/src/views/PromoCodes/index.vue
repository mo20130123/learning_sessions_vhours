<template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Promo Codes</h2>

     <section class="section-page-control">
        <v-row>
           <v-col cols="7" >
             <v-btn @click="showCreateModel()" class="ma-2" outlined color="indigo"> <b-icon-plus></b-icon-plus> Add New</v-btn>
             <!-- <router-link to="/PromoCodes/sort"> <v-btn class="ma-2" outlined color="black"> <b-icon-filter></b-icon-filter> Sort  </v-btn> </router-link> -->

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
          <th> Code </th>
          <th> discount <br> %</th>
          <th> Allowed no <br> of usage</th>
          <th> Allowed no <br> per user</th>
          <th> Actual no <br> of usage</th>
          <th> From date </th>
          <th> To date </th>
          <th> Action </th>
       </thead>
       <tbody is="transition-group" name="my-list" >
          <tr v-for="(item,index) in mainList.data" :key="item.id">
             <td>{{ item.id }}</td>
             <td>{{ item.code }}</td>
             <td>{{ item.discount_percentage }} %</td>
             <td>{{ item.allowed_number_of_usage }} </td>
             <td>{{ item.allowed_number_per_user }} </td>
             <td>{{ item.actual_number_of_usage }} </td>
             <td>{{ item.from_date }}</td>
             <td>{{ item.to_date }}</td>
             <!-- <td>{{ item.created_at }} <br> [{{ item.created_at | moment("from", "now") }}] </td> -->
             <td style="width: 20%;">
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
                            <v-text-field label="discount percentage %" v-model="CF.discount_percentage" type="number" outlined :rules="requiredRules" ></v-text-field>
                            <v-text-field label="code" v-model="CF.code" outlined :rules="[v => !!v || 'field is required']" ></v-text-field>
                            <v-text-field label="from date" v-model="CF.from_date" type="date" outlined :rules="requiredRules" ></v-text-field>
                            <v-text-field label="to date" v-model="CF.to_date" type="date" outlined :rules="requiredRules" ></v-text-field>
                            <v-text-field label="allowed number of usage" v-model="CF.allowed_number_of_usage" type="number" outlined :rules="requiredRules" ></v-text-field>
                            <v-text-field label="allowed number per user" v-model="CF.allowed_number_per_user" type="number" outlined :rules="requiredRules" ></v-text-field>
                             <!-- <v-select  outlined v-model="CF.city_id" :items="Cities" item-text="label" item-value="value" label="Cities" ></v-select> -->
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
                           <v-text-field label="discount percentage %" v-model="EF.discount_percentage" type="number" outlined :rules="requiredRules" ></v-text-field>
                           <v-text-field label="code" v-model="EF.code" outlined :rules="[v => !!v || 'field is required']" ></v-text-field>
                           <v-text-field label="from date" v-model="EF.from_date" type="date" outlined :rules="requiredRules" ></v-text-field>
                           <v-text-field label="to date" v-model="EF.to_date" type="date" outlined :rules="requiredRules" ></v-text-field>
                           <v-text-field label="allowed number of usage" v-model="EF.allowed_number_of_usage" type="number" outlined :rules="requiredRules" ></v-text-field>
                           <v-text-field label="allowed number per user" v-model="EF.allowed_number_per_user" type="number" outlined :rules="requiredRules" ></v-text-field>
                           <!-- <v-select  outlined v-model="EF.city_id" :items="Cities" item-text="label" item-value="value" label="Cities" ></v-select> -->
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
    name: 'PromoCodes',
    mixins: [AdminMixin],
     data: () => ({
        Permission: 'PromoCodes',
        api_get_list: 'PromoCodes/list',
        api_showORhide: 'PromoCodes/showORhide',
        api_delete: 'PromoCodes/delete',
        api_create: 'PromoCodes/create',
        api_update: 'PromoCodes/update',
        Cities: []
    }),//end data
    created(){
    //    this.getCities_list();
    },
    methods:{
        // getCities_list()
        // {
        //       $.ajax({
        //          type:"get",
        //          url: `${Admin_BASE_url}/District/selection_data` ,
        //          headers: { 'jwt': localStorage.getItem('jwt') }
        //      })
        //      .done(function(Response){
        //         if(Response.status == 'unValidJWT'){
        //              localStorage.removeItem('jwt');
        //              this.$router.push('/login');
        //         }
        //         this.Cities = Response.Cities;
        //         this.Cities.unshift({ label:'All ' , value: null });
        //      }.bind(this))
        //      .fail(function(data){
        //         new Noty({text: 'proplem' , type: 'error' }).show();
        //      });
        // }
    }//End methods
}//End export default
</script>
