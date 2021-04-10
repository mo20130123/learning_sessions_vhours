<style lang="scss" >
   .card-info
   {
       padding: 5px;
      .card-icon
      {
         width: 20%;
         display: inline-block;
         border-right: 1px solid #ccc;
         margin-right: 15px;
         padding: 10px;
      }

      div.card-text
      {
         width: 50%;
         display: inline-block;
         span:first-of-type{
            font-weight: bold;
            font-size: 25px;
          }
         span:last-of-type{
            font-weight: bold;
            font-size: 18px;
          }
      }
   }//End .card-info
</style>
 <template>
  <div class="page-wrapper" id="setting_wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Dashboard</h2>

     <v-row>
        <v-col>
           <v-card>
                <div class="card-info">
                   <div class="card-icon">
                      <b-icon-person class="h1 mb-2"></b-icon-person>
                   </div>
                   <div class="card-text">
                      <span class=""> {{card.Members_count}} </span> <br>
                      <span class=""> Members  </span>
                   </div>
                </div>
          </v-card>
        </v-col>
        <v-col>
           <v-card>
                <div class="card-info">
                   <div class="card-icon">
                      <b-icon-bag class="h1 mb-2"></b-icon-bag>
                   </div>
                   <div class="card-text">
                      <span> {{card.Products_count}} </span> <br>
                      <span> Products  </span>
                   </div>
                </div>
          </v-card>
        </v-col>
        <v-col>
           <v-card>
                <div class="card-info">
                   <div class="card-icon">
                      <b-icon-card-list class="h1 mb-2"></b-icon-card-list>
                   </div>
                   <div class="card-text">
                      <span> {{card.Recipts_count}} </span> <br>
                      <span> Orders  </span>
                   </div>
                </div>
          </v-card>
        </v-col>
        <v-col>
           <v-card>
                <div class="card-info">
                   <div class="card-icon">
                      <b-icon-briefcase class="h1 mb-2"></b-icon-briefcase>
                   </div>
                   <div class="card-text">
                      <span> {{card.Recipts_sum}} EGP </span> <br>
                      <span> Orders Sum  </span>
                   </div>
                </div>
          </v-card>
        </v-col>
     </v-row>

     <section class="section-page-control">
        <v-row>
          <v-col cols="7" >

          </v-col>
          <v-col>
                <div class="">
                   <v-text-field v-model="selected_year" @keyup.enter="getResults()" label="Year" outlined shaped style="width:80%;display:inline-block;" ></v-text-field>
                   <v-btn @click="getResults()" class="ma-2 btn-refresh" fab  outlined   color="indigo"> <b-icon-arrow-repeat font-scale="1.5"></b-icon-arrow-repeat> </v-btn>
                </div>
          </v-col>
        </v-row>
    </section><!--End section-page-control-->

    <!-- ================================================================================================ -->

<v-card>
   <v-card-title class="headline"> <b-icon-people-circle></b-icon-people-circle> <span> Members </span> </v-card-title>

   <v-container>
     <bar-chart
          id="bar"
           :data='morris_members'
          xkey="month"
          ykeys='["count" ]'
          colors='[ "#FF6384" ]'
          grid="true"
          grid-text-weight="bold"
          resize="true"
        >
      </bar-chart>
  </v-container>

</v-card>


   <br>

   <v-row>
      <v-col cols="8">
         <v-card>
            <v-card-title class="headline"> <b-icon-people-circle></b-icon-people-circle> <span> Recipts </span> </v-card-title>
            <v-container>
                     <bar-chart
                        id="bar2"
                        :data='morris_recipts'
                        xkey="month"
                        ykeys='["count" ]'
                        colors='[ "#746F7D" ]'
                        grid="true"
                        grid-text-weight="bold"
                        resize="true"
                      >
                  </bar-chart>
            </v-container>
          </v-card>
      </v-col>
      <v-col cols="4" >
         <v-card>
            <v-card-title class="headline"> <b-icon-people-circle></b-icon-people-circle> <span> Recipts </span> </v-card-title>

               <donut-chart
                  id="donut"
                  :data="donutData"
                  colors='[ "#FF6384", "#36A2EB", "#FFCE56" ,"#746F7D", "#FF6384" ]'
                  resize="true">
               </donut-chart>

         </v-card>
      </v-col>
   </v-row>


<br>


<v-card>
    <v-card-title class="headline grey lighten-2" primary-title >
       Rating Average
    </v-card-title>
    <v-container>
          <table  class="table" >
            <thead>
                <th> Question </th>
                <th> Rating Stars </th>
                <th> Rating </th>
            </thead>
            <tbody>
              <tr>
                 <th> 1- How satisfied are you with the way the SuperDeli agent handled your </th>
                 <td> <v-rating v-model="Rating.q1_avg" background-color="indigo lighten-3" color="purple" half-increments :readonly="true"></v-rating> </td>
                 <td> {{Rating.q1_avg}} </td>
              </tr>
              <tr>
                 <th> 2- How satisfied are you with our range of the products? </th>
                 <td> <v-rating v-model="Rating.q2_avg" background-color="indigo lighten-3" color="pink" half-increments :readonly="true"></v-rating> </td>
                 <td> {{Rating.q2_avg}} </td>
              </tr>
              <tr>
                 <th> 3. How satisfied are you with the delivery speed and service? </th>
                 <td> <v-rating v-model="Rating.q3_avg" background-color="indigo lighten-3" color="orange" half-increments :readonly="true"></v-rating> </td>
                 <td> {{Rating.q3_avg}} </td>
              </tr>
              <tr>
                 <th> 4. Did the product meet your expectations </th>
                 <td> <v-rating v-model="Rating.q4_avg" background-color="indigo lighten-3" color="green" half-increments :readonly="true"></v-rating> </td>
                 <td> {{Rating.q4_avg}} </td>
              </tr>
              <tr>
                 <th> 5. How likely would it be that you recommend SuperDeli to a friend? </th>
                 <td> <v-rating v-model="Rating.q5_avg" background-color="indigo lighten-3" color="indigo" half-increments :readonly="true"></v-rating> </td>
                 <td> {{Rating.q5_avg}} </td>
              </tr>
            </tbody>
          </table>
    </v-container>
</v-card>





   <!-- - - - - - -START spinner- - - - - - - -->
   <spinner2 v-if="show_spinner"></spinner2>
   <!-- - - - - - -End spinner- - - - - - - -->

  </div><!--End page-wrapper-->
</template>

<script>
  import spinner2 from '@/components/spinner2';
  import { DonutChart, BarChart } from 'vue-morris';


  export default {
    name: 'Dashboard',
    components: {spinner2 , DonutChart, BarChart},
     data: () => ({
        Permission: 'Dashboard',
        show_spinner:false,
        btn_submit:false,
        selected_year: new Date().getFullYear(),
        donutData: [],
        card: {},
        Rating: {},
        morris_members: [],
        morris_recipts: [],
    }),//end data
    created(){
      if(!localStorage.getItem('jwt')){
         this.$router.push('/login');
      }
      this.check_Permission(this.Permission);
      this.getResults();
    },
    methods:{
         getResults(){

              this.show_spinner = true;
              $.ajax({
                    type:"get",
                    url: `${Admin_BASE_url}/DashBoard/${this.selected_year}` ,
                    headers: { 'jwt': localStorage.getItem('jwt') },
               })
               .done(function(Response){
                  if(Response.status == 'unValidJWT'){
                     localStorage.removeItem('jwt');
                     this.$router.push('/login');
                  }

                  this.card = {
                           Members_count: Response.Members_count,
                           Products_count: Response.Products_count,
                           Recipts_count: Response.Recipts_count,
                           Recipts_sum: Response.Recipts_sum,
                     };
                  this.morris_members = Response.morris_members;
                  this.morris_recipts = Response.morris_recipts;

                  this.donutData = [
                    { label: 'canceled', value: Response.Recipt_canceled_count },
                    { label: 'delivered', value: Response.Recipt_delivered_count },
                    { label: 'processing', value: Response.Recipt_processing_count },
                    { label: 'shipping', value: Response.Recipt_shipping_count },
                    { label: 'Dispatched', value: Response.Recipt_Dispatched_count }
                  ];

                  this.Rating = Response.Rating;

                  this.show_spinner = false;
               }.bind(this))
               .fail(function(data){
                 new Noty({text: 'proplem' , type: 'error' }).show();
               });
         },
    },//End methods
    computed: {

    }
}//End export default
</script>
