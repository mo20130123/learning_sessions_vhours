<template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Applicants for ({{Job.title_en}}) </h2>

     <section class="section-page-control">
        <v-row>
           <v-col>
             <div>
               <router-link to="/Job"> <span> Jobs </span> </router-link> / <span>Applicants</span>
            </div>
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
          <th> Name </th>
          <th> Phone </th>
          <th> Email </th>
          <th> CV </th>
          <th> Created date </th>
          <th> Contacted </th>
          <th> Action </th>
       </thead>
       <tbody is="transition-group" name="my-list" >
          <tr v-for="(item,index) in Applicants" :key="item.id">
             <td>{{ item.id }}</td>
             <td>{{ item.name }}</td>
             <td>{{ item.phone }}</td>
             <td>{{ item.email }}</td>
             <td> <a :href="item.resume" target="_blank"> CV </a> </td>
             <td>{{ item.created_at }} <br> [{{ item.created_at | moment("from", "now") }}] </td>
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

    <!-- - - - - - -START spinner- - - - - - - -->
    <spinner2 v-if="show_spinner"></spinner2>
    <!-- - - - - - -End spinner- - - - - - - -->


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
                      <tr v-if="SF.job_category">
                         <th> Job category: </th>
                         <td> {{SF.job_category}} </td>
                      </tr>
                      <tr v-if="SF.job_title">
                         <th> Job title: </th>
                         <td> {{SF.job_title}} </td>
                      </tr>
                      <tr>
                         <th> Name: </th>
                         <td> {{SF.name}} </td>
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
                         <th> Current company: </th>
                         <td> {{SF.current_company}} </td>
                      </tr>
                      <tr>
                         <th> Seniority: </th>
                         <td> {{SF.seniority}} </td>
                      </tr>
                      <tr>
                         <th> Salary range: </th>
                         <td> {{SF.salary_range}} </td>
                      </tr>
                      <tr>
                         <th> Gender: </th>
                         <td> {{SF.gender}} </td>
                      </tr>
                      <tr>
                         <th> Location: </th>
                         <td> {{SF.location}} </td>
                      </tr>
                      <tr>
                         <th> Nationality: </th>
                         <td> {{SF.Nationality}} </td>
                      </tr>
                      <tr>
                         <th> Birthday: </th>
                         <td> {{SF.birth_day}} </td>
                      </tr>
                      <tr>
                         <th> Comment: </th>
                         <td> {{SF.Comment}} </td>
                      </tr>
                      <tr>
                         <th> Created date: </th>
                         <td> {{ SF.created_at }} <br> [{{ SF.created_at | moment("from", "now") }}] </td>
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
 import spinner2 from '@/components/spinner2';
 import Swal from 'sweetalert2'


  export default {
    name: 'ContactUs',
    components: {spinner2},
     data: () => ({
        Permission: 'Job',
        Job: {},
        Applicants: [],
        show_spinner:true,
        showDialog: false,
        ST: {}, //Search table
        SF: {}, //show Form
        connection_items: [
           { value: null , label: 'All' },
           { value: 'contacted' , label: 'Contacted' },
           { value: 'notContacted' , label: 'Not Contacted yet' }
        ]
    }),//End data
    created(){
      if(!localStorage.getItem('jwt')){
         this.$router.push('/login');
      }
      this.check_Permission(this.Permission);
      console.log(`From (${this.$options.name}) component`);
      this.getResults();
    },
    methods:{
         getResults(){
              this.Applicants = [];
              this.show_spinner = true;
              $.ajax({
                    type:"patch",
                    url: `${Admin_BASE_url}/Job/job_applicants/${this.$route.params.id}` ,
                    headers: { 'jwt': localStorage.getItem('jwt') },
                    data: this.ST,
               })
               .done(function(Response){
                  if(Response.status == 'unValidJWT'){
                     localStorage.removeItem('jwt');
                     this.$router.push('/login');
                  }
                  this.Job = Response.Job;
                  this.Applicants = Response.Applicants;
                  this.show_spinner = false;
               }.bind(this))
               .fail(function(data){
                 new Noty({text: 'proplem' , type: 'error'  }).show();
               });
         },
         showShowModel(this_data){
            this.showDialog = true;
            this.SF = this_data;
         },
         ContatctedOrNot(item){
             $.ajax({
                type:"get",
                url: `${Admin_BASE_url}/Job/switch_contacted/${item.id}` ,
                headers: { 'jwt': localStorage.getItem('jwt') }
            })
            .done(function(Response){
               item.is_contacted = Response.case;
               if(Response.case){
                  new Noty({text: 'Client has been contacted', type: 'success'  }).show();
               }
               else {
                  new Noty({text: 'Client is not contacted' , type: 'error'  }).show();
               }
            }.bind(this))
            .fail(function(data){
               new Noty({text: 'proplem' , type: 'error'  }).show();
            });
         },
         del_row(item,index)
         {
             Swal.fire({
               title: `you wanna delete (${item.id}) ?`,
               text: "You won't be able to revert this!",
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: 'Yes, delete it!'
             }).then((result) => {
               if (result.value) // if click yes delete
               {
                   new Promise((resolve,reject)=>{
                      $.ajax({
                         type:"get",
                         url: `${Admin_BASE_url}/Job/applicant_destroy/${item.id}` ,
                         headers: { 'jwt': localStorage.getItem('jwt') }
                       })
                      .done( function(Response){
                            resolve(Response);
                      }.bind(this))
                      .fail( function(xhr, textStatus, errorThrown) {
                          resolve('error');
                      });
                   })
                   .then(function(responce){
                      if (responce == 'true') {
                         Swal.fire("Deleted!", " can\'t be deleted because it\'s related to other data ", "success");
                         this.Applicants.splice(index,1);
                      }
                      else if(responce == 'error'){
                         Swal.fire("Sorry!", " problem , try to refresh ", "error");
                      }
                      else{
                         Swal.fire("Sorry!", " can\'t be deleted because it\'s related to other data ", "error");
                      }
                   }.bind(this)); //End Promise
                }
            });
       }
    }//End methods
}//End export default
</script>
