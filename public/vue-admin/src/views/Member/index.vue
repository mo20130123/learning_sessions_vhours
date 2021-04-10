<template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold float-left">Members ({{ mainList.total }}) </h2>

     <!-- <a :href="export_url" target="_blank" class="float-right">  <v-btn class="ma-2 btn-refresh" outlined > Export </v-btn> </a> -->
     <div style="clear:both"> </div>
     <section class="section-page-control">
        <v-row>
           <v-col >
             <v-btn @click="showCreateModel()" class="ma-2" outlined color="indigo"> <b-icon-plus></b-icon-plus> Add New</v-btn>
             <!-- <a :href="export_url" target="_blank">
                        <v-btn  class="ma-2" outlined color="indigo"> <b-icon-plus></b-icon-plus> Export</v-btn>
                </a> -->
          </v-col>
          <v-col>
                <div class="">
                   <v-text-field v-model="ST.search" @keyup.enter="getResults()" label="Search" outlined shaped style="width:80%;display:inline-block;" ></v-text-field>
                   <v-btn @click="getResults()" class="ma-2 btn-refresh" fab  outlined   color="indigo"> <font-awesome-icon icon="redo" size="lg" spin  /> </v-btn>
                </div>
          </v-col>
        </v-row>
    </section><!--End section-page-control-->

    <table class="tbl_mainList">
       <thead>
          <th> Id </th>
          <th> Company </th>
          <th> Name </th>
          <th> Phone </th>
          <th> Email </th>
          <th> Is allowed </th>
          <th> Created date </th>
          <th> Action </th>
       </thead>
       <tbody is="transition-group" name="my-list" >
          <tr v-for="(item,index) in mainList.data" :key="item.id">
             <td>{{ item.id }}</td>
             <td>{{ item.company }}</td>
             <td>{{ item.name }}</td>
             <td>{{ item.phone }}</td>
             <td>{{ item.email }}</td>
             <td>
                <v-chip v-if="item.is_allowed" color="green" dark> Allowed </v-chip>
                <v-chip v-else color="red" dark> Restricted </v-chip>
             </td>
             <td>  {{ item.created_at | moment("d/M/YYYY, h:mm:ss a") }} <br> [{{ item.created_at | moment("from", "now") }}] </td>
             <td style="width: 20%;">
                <div>
                   <b-icon-search @click="showShowModel(item)" font-scale="1.6" ></b-icon-search>
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


       <!-- ------------------- Show ----------------------- - -->
       <v-row justify="center">
         <v-dialog v-model="showDialog" scrollable  max-width="800px">
            <v-card>
              <v-card-title   class="headline grey lighten-2"   primary-title   >
                Show
              </v-card-title>
              <v-card-text>
                <v-container>

                   <v-row>
                     <v-col>
                        <table class="table" >
                           <!-- <tr>
                              <th> Image: </th>
                              <td>
                                 <img v-if="SF.image" :src="SF.image" style="max-height:100px;max-width:100px;">
                                 <p v-else> No Image </p>
                                 <v-rating v-model="SF.stars" background-color="green lighten-3" color="green" small readonly="false"></v-rating>
                              </td>
                           </tr> -->
                           <tr>
                              <th> Company: </th>
                              <td> {{SF.company}} </td>
                           </tr>
                           <tr>
                              <th> Name: </th>
                              <td> {{SF.name}} </td>
                           </tr>
                           <tr>
                              <th> Title: </th>
                              <td> {{SF.title}} </td>
                           </tr>
                           <tr>
                              <th> Company Size: </th>
                              <td> {{SF.company_size}} </td>
                           </tr>
                           <tr>
                              <th> Phone: </th>
                              <td> {{SF.phone}} </td>
                           </tr>
                           <tr>
                              <th> Email: </th>
                              <td> {{SF.email}} </td>
                           </tr>
                           <tr>
                              <th> Country : </th>
                              <td> {{SF.country_name}} </td>
                           </tr>
                           <tr>
                              <th> Created date: </th>
                              <td> {{ SF.created_at | moment("d/M/YYYY, h:mm:ss a") }}   <br> [{{ SF.created_at | moment("from", "now") }}] </td>
                           </tr>
                        </table>
                     </v-col>
                     <v-col>
                        <table class="table" >
                           <tr>
                              <th> Wallet: </th>
                              <td> {{SF.wallet}} </td>
                           </tr>
                        </table>

                        <h2> marketing brief </h2>
                        <ul>
                            <li v-for="marketing_brief in SF.get_marketing_brief">
                                <p  @click="show_marketingBrief_sheet(marketing_brief)" class="pointer">
                                    {{ marketing_brief.name }}
                                </p>
                            </li>
                        </ul>

                      </v-col>
                   </v-row>

                </v-container>
              </v-card-text>
              <v-divider></v-divider>
              <v-card-actions>
                 <v-spacer></v-spacer>
                  <v-btn large dark @click="showDialog = false">Close</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-row>



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
                                <v-text-field label="Company" v-model="CF.company" outlined :rules="requiredRules" ></v-text-field>
                                <v-text-field label="Name" v-model="CF.name" outlined :rules="requiredRules" ></v-text-field>
                                <v-text-field label="Title" v-model="CF.title" outlined :rules="requiredRules" ></v-text-field>
                                <v-text-field label="Company Size" v-model="CF.company_size" outlined :rules="requiredRules" ></v-text-field>
                                <v-switch v-model="CF.is_allowed" label="is allowed"  color="success" hide-details ></v-switch>
                            </v-col>
                            <v-col>
                                <v-text-field label="Phone" type="number" v-model="CF.phone" outlined :rules="requiredRules" ></v-text-field>
                                <v-select outlined v-model="CF.country_id" :items="Countries" item-text="label" item-value="value" label="Country" :rules="requiredRules" ></v-select>
                                <v-text-field label="Wallet" type="number" v-model="CF.wallet" outlined :rules="requiredRules" ></v-text-field>
                                <v-text-field label="Email" v-model="CF.email" outlined :rules="requiredRules" ></v-text-field>
                                <v-text-field label="Password"  v-model="CF.password" outlined :rules="requiredRules" ></v-text-field>
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
                                <v-text-field label="Company" v-model="EF.company" outlined :rules="requiredRules" ></v-text-field>
                                <v-text-field label="Name" v-model="EF.name" outlined :rules="requiredRules" ></v-text-field>
                                <v-text-field label="Title" v-model="EF.title" outlined :rules="requiredRules" ></v-text-field>
                                <v-text-field label="Company Size" v-model="EF.company_size" outlined :rules="requiredRules" ></v-text-field>
                                <v-switch v-model="EF.is_allowed" label="is allowed"  color="success" hide-details ></v-switch>
                            </v-col>
                            <v-col>
                                <v-text-field label="Phone" type="number" v-model="EF.phone" outlined :rules="requiredRules" ></v-text-field>
                                <v-select outlined v-model="EF.country_id" :items="Countries" item-text="label" item-value="value" label="Country" :rules="requiredRules" ></v-select>
                                <v-text-field label="Wallet" type="number" v-model="EF.wallet" outlined :rules="requiredRules" ></v-text-field>
                                <v-text-field label="Email" v-model="EF.email" outlined :rules="requiredRules" ></v-text-field>
                                <v-text-field label="Password"  v-model="EF.password" outlined ></v-text-field>
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


     <!-- ------------------- marketing brief ----------------------- - -->
        <div class="text-center">

            <v-bottom-sheet v-model="showMarketingBriefSheet">
            <v-sheet  class="text-center"   >
                <v-btn  class="mt-6" text  color="red" @click="showMarketingBriefSheet = !showMarketingBriefSheet" >
                  close
                </v-btn>
                <div class="py-3">

                   <v-row>
                        <v-col>
                            <table class="table">
                                <tr>
                                    <th> Name </th>
                                    <td> {{ M_Brief.name }} </td>
                                </tr>
                                <tr>
                                    <th> About Brand </th>
                                    <td> {{ M_Brief.about_brand }} </td>
                                </tr>
                                <tr>
                                    <th> Site link </th>
                                    <td> {{ M_Brief.site_link }} </td>
                                </tr>
                                <tr>
                                    <th> USPs </th>
                                    <td> {{ M_Brief.USPs }} </td>
                                </tr>
                                <tr>
                                    <th> kpi </th>
                                    <td> {{ M_Brief.kpi }} </td>
                                </tr>
                                <tr>
                                    <th> Primary Target </th>
                                    <td> {{ M_Brief.talk_to_primary }} </td>
                                </tr>
                                <tr>
                                    <th> Secondary Target </th>
                                    <td> {{ M_Brief.talk_to_secondary }} </td>
                                </tr>

                            </table>
                        </v-col>
                        <v-col>
                             <table class="table">
                                <tr>
                                    <th> Goals </th>
                                    <td> {{ M_Brief.key_response }} </td>
                                </tr>
                                <tr>
                                    <th> Colors </th>
                                    <td> {{ M_Brief.colors }} </td>
                                </tr>
                                <tr>
                                    <th> Competitors </th>
                                    <td v-if="M_Brief.competitors">
                                        <span v-for="item in JSON.parse(M_Brief.competitors)" > {{ item.competitor }} , </span>
                                    </td>
                                </tr>
                                <tr v-if="M_Brief.created_at">
                                    <th> Created date </th>
                                    <td> <!-- {{ M_Brief.created_at }} --> [{{ M_Brief.created_at | moment("from", "now") }}] </td>
                                </tr>
                                <tr v-if="M_Brief.updated_at">
                                    <th> Updated date </th>
                                    <td> <!--{{ M_Brief.updated_at }} -->[{{ M_Brief.updated_at | moment("from", "now") }}] </td>
                                </tr>

                            </table>
                        </v-col>
                   </v-row>


                </div>
            </v-sheet>
            </v-bottom-sheet>
        </div>


  </div><!--End page-wrapper-->
</template>

<script>
  import {AdminMixin} from '@/mixins/Admin_mixin';

  export default {
    name: 'Member',
    mixins: [AdminMixin],
     data: () => ({
        Permission: 'Member',
        api_get_list: 'Member/list',
        api_switch_contacted: 'Member/switch_contacted',
        api_delete: 'Member/destroy',
         api_create: 'Member/create',
        api_update: 'Member/update',
        connection_items: [
           { value: null , label: 'All' },
           { value: 'contacted' , label: 'Contacted' },
           { value: 'notContacted' , label: 'Not Contacted yet' }
        ],
        CF: {
            wallet: 0
        },
        export_url: Admin_BASE_url+`/Export/${localStorage.getItem('jwt')}/Member`,
        Countries: [],

        showMarketingBriefSheet: false,
        M_Brief: {}

    }),//End data
    created(){
       this.getCountries_list();
    },
    methods:{
        getCountries_list()
        {
             $.ajax({
                 type:"get",
                 url: `${Admin_BASE_url}/Member/selection_data` ,
                 headers: { 'jwt': localStorage.getItem('jwt') }
             })
             .done(function(Response){
                if(Response.status == 'unValidJWT'){
                     localStorage.removeItem('jwt');
                     this.$router.push('/login');
                }
                this.Countries = Response.Countries;
                this.Countries.unshift({ label:'All ' , value: null });
             }.bind(this))
             .fail(function(data){
                new Noty({text: 'proplem' , type: 'error'  }).show();
             });
        },
        show_marketingBrief_sheet(item)
        {
            this.showMarketingBriefSheet = true;
            this.M_Brief = item;
        }
    },//End methods
    computed:{
      Districts()
      {
           if(this.ST.city_id)
           {
              var find = this.Countries.find(obj => obj.value == this.ST.city_id);
              find.District.unshift({ label:'All ' , value: null });  console.log(find);
              return find.District;
           }
           return [];
      }
    }//End computed
}//End export default
</script>
