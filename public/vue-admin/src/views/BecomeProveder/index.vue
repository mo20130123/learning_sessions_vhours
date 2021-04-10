<template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold float-left">Become Proveder ({{ mainList.total }})</h2>
     <!-- <a :href="export_url" target="_blank" class="float-right">  <v-btn class="ma-2 btn-refresh" outlined > Export </v-btn> </a> -->
     <div style="clear:both"> </div>
     <section class="section-page-control">
        <v-row>
           <v-col>
             <!-- <v-btn @click="showCreateModel()" class="ma-2" outlined color="indigo"> <b-icon-plus></b-icon-plus> Add New</v-btn>   -->
          </v-col>
          <v-col cols="7">
                <div class="text-right">
                   <v-select @change="getResults()" outlined v-model="ST.connection" :items="connection_items" item-text="label" item-value="value" label="connection" style="width:42%;display:inline-block;margin-right:10px"  ></v-select>
                   <v-text-field v-model="ST.search" @keyup.enter="getResults()" label="Search" outlined shaped style="width:42%;display:inline-block;" ></v-text-field>
                   <v-btn @click="getResults()" class="ma-2 btn-refresh" fab  outlined   color="indigo"> <font-awesome-icon icon="redo" size="lg" spin  /> </v-btn>
                </div>
          </v-col>
        </v-row>
    </section><!--End section-page-control-->

    <table class="tbl_mainList">
       <thead>
          <th> Id </th>
          <th> Company Name </th>
          <th> Company Size </th>
          <th> Company Type </th>
          <th> Created date </th>
          <th> Contacted </th>
          <th> Action </th>
       </thead>
       <tbody is="transition-group" name="my-list" >
          <tr v-for="(item,index) in mainList.data" :key="item.id">
             <td>{{ item.id }}</td>
             <td>{{ item.CompanyName }}</td>
             <td>{{ item.CompanySize }}</td>
             <td>{{ item.CompanyType }}</td>
             <td>{{ item.created_at | moment("d/M/YYYY, h:mm:ss a") }} <br> [{{ item.created_at | moment("from", "now") }}] </td>
             <td>
                <v-chip v-if="item.is_contacted" color="green" dark> Yes </v-chip>
                <v-chip v-else color="red" dark> No </v-chip>
             </td>
             <td style="width: 20%;">
                <div>
                   <b-icon-person-check-fill v-if="item.is_contacted" @click="ContatctedOrNot(item)" font-scale="1.6" ></b-icon-person-check-fill>
                   <b-icon-person-dash  v-else            @click="ContatctedOrNot(item)" font-scale="1.6"  ></b-icon-person-dash>
                </div>
                <div>
                   <b-icon-search @click="showShowModel(item)" font-scale="1.6" ></b-icon-search>
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
         <v-dialog v-model="showDialog" scrollable  max-width="500px">
            <v-card>
              <v-card-title   class="headline grey lighten-2"   primary-title   >
                Show
              </v-card-title>
              <v-card-text>
                <v-container>
                   <table class="table" >
                      <tr>
                         <th> Company Name: </th>
                         <td> {{SF.CompanyName}} </td>
                      </tr>
                      <tr>
                         <th> Company Size: </th>
                         <td> {{SF.CompanySize}} </td>
                      </tr>
                      <tr>
                         <th> Company Type: </th>
                         <td> {{SF.CompanyType}} </td>
                      </tr>
                      <tr>
                         <th> Website: </th>
                         <td> {{SF.Website}} </td>
                      </tr>
                      <tr>
                         <th> Industry: </th>
                         <td> {{SF.Industry}} </td>
                      </tr>
                      <tr>
                         <th> Location: </th>
                         <td> {{SF.Location}} </td>
                      </tr>
                      <tr>
                         <th> no products: </th>
                         <td> {{SF.no_products}} </td>
                      </tr>
                      <tr>
                         <th> Target Market: </th>
                         <td> {{SF.TargetMarket}} </td>
                      </tr>
                      <tr>
                         <th> First Name: </th>
                         <td> {{SF.FirstName}} </td>
                      </tr>
                      <tr>
                         <th> Last Name: </th>
                         <td> {{SF.LastName}} </td>
                      </tr>
                      <tr>
                         <th> Contact Email: </th>
                         <td> {{SF.ContactEmail}} </td>
                      </tr>
                      <tr>
                         <th> Job Title: </th>
                         <td> {{ SF.JobTitle }} </td>
                      </tr>
                      <tr>
                         <th> mobile: </th>
                         <td> {{SF.mobile}} </td>
                      </tr>
                       <tr>
                         <th> Created date: </th>
                         <td> {{ SF.created_at | moment("d/M/YYYY, h:mm:ss a") }} <br> [{{ SF.created_at | moment("from", "now") }}] </td>
                      </tr>
                   </table>

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

  </div><!--End page-wrapper-->
</template>

<script>
  import {AdminMixin} from '@/mixins/Admin_mixin';

  export default {
    name: 'BecomeProveder',
    mixins: [AdminMixin],
     data: () => ({
        Permission: 'BecomeProveder',
        api_get_list: 'BecomeProveder/list',
        api_switch_contacted: 'BecomeProveder/switch_contacted',
        api_delete: 'BecomeProveder/delete',
        connection_items: [
           { value: null , label: 'All' },
           { value: 'contacted' , label: 'Contacted' },
           { value: 'notContacted' , label: 'Not Contacted yet' }
        ],
        export_url: Admin_BASE_url+`/Export/${localStorage.getItem('jwt')}/BecomeProveder`,
    }),//End data
    created(){

    },
    methods:{

    }//End methods
}//End export default
</script>
