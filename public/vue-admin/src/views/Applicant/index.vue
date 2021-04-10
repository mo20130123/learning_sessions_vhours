<template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Applicant</h2>

     <section class="section-page-control">
        <v-row>
           <v-col>
             <!-- <v-btn @click="showCreateModel()" class="ma-2" outlined color="indigo"> <b-icon-plus></b-icon-plus> Add New</v-btn>   -->
          </v-col>
          <v-col cols="7">
                <div class="text-right">
                   <v-select @change="getResults()" outlined v-model="ST.connection" :items="connection_items" item-text="label" item-value="value" label="connection" style="width:42%;display:inline-block;margin-right:10px"  ></v-select>
                   <v-text-field v-model="ST.search" @keyup.enter="getResults()" label="Search" outlined shaped style="width:42%;display:inline-block;" ></v-text-field>
                   <v-btn @click="getResults()" class="ma-2 btn-refresh" fab  outlined   color="indigo"> <b-icon-arrow-repeat font-scale="1.5"></b-icon-arrow-repeat> </v-btn>
                </div>
          </v-col>
        </v-row>
    </section><!--End section-page-control-->


    <table class="tbl_mainList">
       <thead>
          <th> Id </th>
          <th> Name   </th>
          <th> position </th>
          <th> email </th>
          <th> phone </th>
          <th> resume </th>
          <th> Created date </th>
          <th> Action </th>
       </thead>
       <tbody is="transition-group" name="my-list" >
          <tr v-for="(item,index) in mainList.data" :key="item.id">
             <td>{{ item.id }}</td>
             <td>{{ item.f_name }} {{ item.l_name }}</td>
             <td>{{ item.position }}</td>
             <td>{{ item.email }}</td>
             <td>{{ item.phone }}</td>
             <td> <a :href="item.resume" target="_blank">CV</a> </td>
             <td style="width: 15%;">{{ item.created_at }} <br> [{{ item.created_at | moment("from", "now") }}] </td>
             <td style="width: 20%;">
               <div>
                  <b-icon-person-check-fill v-if="item.is_contacted" @click="ContatctedOrNot(item)" font-scale="1.6" ></b-icon-person-check-fill>
                  <b-icon-person-dash  v-else            @click="ContatctedOrNot(item)" font-scale="1.6"  ></b-icon-person-dash>
               </div>
               <!-- <div>
                  <b-icon-search @click="showShowModel(item)" font-scale="1.6" ></b-icon-search>
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
    name: 'Applicant',
    mixins: [AdminMixin],
     data: () => ({
        Permission: 'Applicant',
        api_get_list: 'Applicant/list',
        api_switch_contacted: 'Applicant/switch_contacted',
        api_delete: 'Applicant/delete',
        connection_items: [
           { value: null , label: 'All' },
           { value: 'contacted' , label: 'Contacted' },
           { value: 'notContacted' , label: 'Not Contacted yet' }
        ]
    }),//end data
    created(){

    },
    methods:{

    }//End methods
}//End export default
</script>
