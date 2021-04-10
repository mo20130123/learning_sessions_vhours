<style lang="scss" scoped>
.tbl_mainList
{
   p{
      margin-bottom: 4px;
      text-align: left;
   }
   .td_delivery_status
   {
      text-transform: capitalize;
      .selected{
         color: #00796B;
      }
      p{
         margin-bottom: 10px;
         cursor: pointer;
      }
   }
   label{
      font-weight: bold;
      text-transform: capitalize;
   }

   img.img_store_logo
   {
      max-width: 120px;
      max-height: 60px;
   }
}
</style>
<template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">   Orders  </h2>

     <section class="section-page-control">
        <v-row>
          <v-col>
                <div class="text-right">

                   <!-- <v-text-field v-model="ST.search" type="date" @change="getResults()" label="From" outlined   style="width:18%;display:inline-block;" ></v-text-field>
                   <v-text-field v-model="ST.search" type="date" @change="getResults()" label="To" outlined   style="width:18%;display:inline-block;margin-right:10px" ></v-text-field> -->
                   <!-- <v-select @change="getResults()" outlined v-model="ST.payment_method" :items="payment_method" item-text="label" item-value="value" label="Payment method" style="width:25%;display:inline-block;margin-right:10px"  ></v-select> -->
                   <!-- <v-select @change="getResults()" outlined v-model="ST.delivery_status" :items="delivery_status" item-text="label" item-value="value" label="Delivery status" style="width:25%;display:inline-block;margin-right:10px"  ></v-select> -->
                   <v-text-field v-model="ST.search" @keyup.enter="getResults()" label="Search" outlined shaped style="width:25%;display:inline-block;" ></v-text-field>

                    <v-btn @click="getResults()" class="ma-2 btn-refresh" fab  outlined   color="indigo"> <font-awesome-icon icon="redo" size="lg" spin  /> </v-btn>

                </div>
          </v-col>
        </v-row>
    </section><!--End section-page-control-->

    <table class="tbl_mainList">
       <thead>
          <th> Id </th>
          <th> Member </th>
          <th> Price </th>
          <!-- <th> Delivery status </th> -->
          <th> Created date </th>
          <th> Action </th>
       </thead>
       <tbody is="transition-group" name="my-list" >
          <tr v-for="(item,index) in mainList.data" :key="item.id">
             <td>{{item.id}}</td>
             <td>
                <p> <label>Id:</label> <span>{{item.member_id}}  </span> </p>
                <p> <label>email:</label> <span>{{item.member_email}}  </span> </p>
                <p> <label>phone:</label> <span>{{item.member_phone}}  </span> </p>
             </td>
             <td>
                <p> <label>Total price:</label> <span>{{item.total_price}} EGP  </span> </p>
                <!-- <p> <label>Points:</label> <span>{{item.points_deduction_price}} EGP </span> </p> -->
                <p> <label>Promo:</label> <span>{{item.discount_percentage}}% </span> </p>
                <p> <label>vat :</label> <span>{{item.vat_price}} EGP </span> </p>
                <p> <label>wallet :</label> <span>{{item.wallet_deduction}} EGP </span> </p>
                <p> <label>Final price:</label> <span>{{item.final_price}} EGP </span> </p>
                <!-- <p> <label>Method:</label> <span>{{item.payment_method}}  </span> </p> -->
             </td>
             <!-- <td class="td_delivery_status" style="width: 18%;">
                <p>
                   <span v-if="item.delivery_status =='Acknowledged'" class="selected"> <b-icon-check-circle></b-icon-check-circle> Acknowledged </span>
                   <span v-else @click="changeDeliveryStatus(item,'Acknowledged')"> <b-icon-circle></b-icon-circle> Acknowledged </span>
                </p>
                <p>
                   <span v-if="item.delivery_status =='Preparing'" class="selected"> <b-icon-check-circle></b-icon-check-circle> Preparing </span>
                   <span v-else  @click="changeDeliveryStatus(item,'Preparing')"> <b-icon-circle></b-icon-circle> Preparing </span>
                </p>
                <p>
                   <span v-if="item.delivery_status =='Dispatched'" class="selected"> <b-icon-check-circle></b-icon-check-circle> Dispatched </span>
                   <span v-else  @click="changeDeliveryStatus(item,'Dispatched')"> <b-icon-circle></b-icon-circle> Dispatched </span>
                </p>
                <p>
                   <span v-if="item.delivery_status =='Delivered'" class="selected"> <b-icon-check-circle></b-icon-check-circle> Delivered </span>
                   <span v-else  @click="changeDeliveryStatus(item,'Delivered')"> <b-icon-circle></b-icon-circle> Delivered </span>
                </p>
                <p>
                   <span v-if="item.delivery_status =='canceled'" class="selected"> <b-icon-check-circle></b-icon-check-circle> Canceled </span>
                   <span v-else  @click="changeDeliveryStatus(item,'canceled')"> <b-icon-circle></b-icon-circle> Canceled </span>
                </p>
             </td> -->
             <td> {{ item.created_at | moment("d/M/YYYY, h:mm:ss a") }} <br> [{{ item.created_at | moment("from", "now") }}] </td>
             <td style="width: 10%;">
                <div>
                   <v-btn @click="switchPiad(item)"  >
                      <img :src="icon_paid" v-if="item.is_piad" >
                      <img :src="icon_not_paid" v-else >
                   </v-btn>
                </div>
                <br><br>
                <div>
                   <router-link :to="'/Order/details/'+item.id" >
                      <v-btn> <b-icon-search font-scale="1.6" color="black" ></b-icon-search> </v-btn>
                   </router-link>
                </div>
                <br><br>
                <div>
                   <v-btn  @click="del_row(item,index)"  >
                      <b-icon-trash  font-scale="1.6" variant="danger" ></b-icon-trash>
                   </v-btn>
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
  import icon_not_paid from "@/assets/icons/not_paid.svg";
  import icon_paid from "@/assets/icons/paid.svg";

  export default {
    name: 'Order',
    mixins: [AdminMixin],
     data: ()  => ({
        icon_not_paid,icon_paid,
        Permission: 'Order',
        api_get_list: 'Order/list',
        api_showORhide: 'Order/showORhide',
        api_delete: 'Order/delete',
        api_create: 'Order/create',
        api_update: 'Order/update',
        delivery_status: [
           { label: 'All', value: null },
           { label: 'Acknowledged', value: 'Acknowledged' },
           { label: 'Preparing', value: 'Preparing' },
           { label: 'Dispatched', value: 'Dispatched' },
           { label: 'Delivered', value: 'Delivered' },
           { label: 'canceled', value: 'canceled' },
        ],
        payment_method: [
           { label: 'All', value: null },
           { label: 'cod', value: 'cod' },
           { label: 'creadit card', value: 'creadit_card' },
        ],
    }),//end data
    methods:{
      switchPiad(item)
      {
            $.ajax({
               type:"get" ,
               url: `${Admin_BASE_url}/Order/switchPiad/${item.id}` ,
               headers: { 'jwt': localStorage.getItem('jwt') }
           })
           .done(function(Response){
              if(Response.status == 'unValidJWT'){
                   localStorage.removeItem('jwt');
                   this.$router.push('/login');
              }
                 item.is_piad = Response.case;
                 if(Response.case){
                   new Noty({text: 'Recipt is Paid', type: 'success' }).show();
                 }
                 else {
                   new Noty({text: 'Recipt is not Paid' , type: 'error' }).show();
                 }
           }.bind(this))
           .fail(function(data){
              new Noty({text: 'proplem' , type: 'error' }).show();
           });
       },
       changeDeliveryStatus(item,new_delivery_status)
       {
             if(item.delivery_status == 'Delivered'){
                 new Noty({text: 'can\'t change status once its Delivered' , type: 'error' }).show();
                 return ;
             }
             //check Permission
             if(this.Permissions[0] != 'is_super_admin')
             {
                 switch (new_delivery_status)
                 {
                   case 'Acknowledged':
                         if(this.Permissions.indexOf('Order_Acknowledged') == -1){
                            new Noty({text: 'you don\'t have a Permission to do this' , type: 'error' }).show();
                            return ;
                         }
                     break;
                   case 'Preparing':
                         if(this.Permissions.indexOf('Order_Preparing') == -1){
                            new Noty({text: 'you don\'t have a Permission to do this' , type: 'error' }).show();
                            return ;
                         }
                     break;
                   case 'Dispatched':
                         if(this.Permissions.indexOf('Order_Dispatched') == -1){
                            new Noty({text: 'you don\'t have a Permission to do this' , type: 'error' }).show();
                            return ;
                         }
                     break;
                   case 'Delivered':
                         if(this.Permissions.indexOf('Order_Delivered') == -1){
                            new Noty({text: 'you don\'t have a Permission to do this' , type: 'error' }).show();
                            return ;
                         }
                     break;
                   case 'canceled':
                         if(this.Permissions.indexOf('Order_Canceled') == -1){
                            new Noty({text: 'you don\'t have a Permission to do this' , type: 'error' }).show();
                            return ;
                         }
                     break;
                 }
             }

           $.ajax({
             type:"get" ,
             url: `${Admin_BASE_url}/Order/changeDeliveryStatus/${item.id}/${new_delivery_status}` ,
             headers: { 'jwt': localStorage.getItem('jwt') }
          })
          .done(function(Response){
             if(Response.status == 'unValidJWT'){
                  localStorage.removeItem('jwt');
                  this.$router.push('/login');
             }
                item.delivery_status = Response.case;
                if(Response.case){
                  new Noty({text: 'Delivered status changed ', type: 'success' }).show();
                }
                else {
                  new Noty({text: 'Delivered status problem' , type: 'error' }).show();
                }
          }.bind(this))
          .fail(function(data){
             new Noty({text: 'proplem' , type: 'error' }).show();
          });
       },
    }//End methods
}//End export default
</script>
