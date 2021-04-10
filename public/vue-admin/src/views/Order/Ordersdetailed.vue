<style lang="scss" scoped>
.tbl_mainList
{
   p{
      margin-bottom: 4px;
      text-align: left;
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

.delivery_status
{
   margin-left: 30%;
   margin-top: 15px;
   text-transform: capitalize;
   .selected{
      color: #00796B;
   }
   p{
      margin-bottom: 20px;
      font-size: 18px;
      cursor: pointer;
   }
}

 ul.products
 {
   text-align: left;
 }

</style>
<template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold"> Orders Detailed </h2>

     <section class="section-page-control">
        <v-row>
          <v-col>
                <div class="text-right">

                   <!-- <v-text-field v-model="ST.search" type="date" @change="getResults()" label="From" outlined   style="width:18%;display:inline-block;" ></v-text-field>
                   <v-text-field v-model="ST.search" type="date" @change="getResults()" label="To" outlined   style="width:18%;display:inline-block;margin-right:10px" ></v-text-field> -->
                   <!-- <v-select @change="getResults()" outlined v-model="ST.payment_method" :items="payment_method" item-text="label" item-value="value" label="Payment method" style="width:25%;display:inline-block;margin-right:10px"  ></v-select> -->
                   <v-select @change="getResults()" outlined v-model="ST.delivery_status" :items="delivery_status" item-text="label" item-value="value" label="Delivery status" style="width:25%;display:inline-block;margin-right:10px"  ></v-select>
                   <v-text-field v-model="ST.search" @keyup.enter="getResults()" label="Search" outlined shaped style="width:25%;display:inline-block;" ></v-text-field>
                   <v-btn @click="getResults()" class="ma-2 btn-refresh" fab  outlined   color="indigo"> <b-icon-arrow-repeat font-scale="1.5"></b-icon-arrow-repeat> </v-btn>
                </div>
          </v-col>
        </v-row>
    </section><!--End section-page-control-->

    <table class="tbl_mainList">
       <thead>
          <th> Id </th>
          <th> Member </th>
          <th> Info </th>
          <th> products </th>
          <th> Action </th>
       </thead>
       <tbody is="transition-group" name="my-list" >
          <tr v-for="(item,index) in mainList.data" :key="item.id">
             <td>{{item.id}}</td>
             <td>
                <p> <label>Id:</label> <span>{{item.member_id}}  </span> </p>
                <p> <label>email:</label> <span>{{item.member_email}}  </span> </p>
                <p> <label>phone:</label> <span>{{item.member_phone}}  </span> </p>
                <p> <span>{{item.city}}</span> - <span>{{item.district}}</span> </p>
                <p> <span>{{item.address}}</span> </p>
                <p> <label>street:</label> <span>{{item.street}}  </span> </p>
                <p> <label>building no:</label> <span>{{item.building_no}}  </span> </p>
                <p> <label>apartment no:</label> <span>{{item.apartment_no}}  </span> </p>
             </td>
             <td>
                <p> <label>Total price:</label> <span>{{item.total_price}} EGP  </span> </p>
                <p> <label>points :</label> <span>{{item.points_deduction_price}} EGP </span> </p>
                <p> <label>Promo :</label> <span>{{item.discount_percentage}}% </span> </p>
                <p> <label>Final price:</label> <span>{{item.final_price}} EGP </span> </p>
                <p> <label>Method :</label> <span>{{item.payment_method}}  </span> </p>
                <p> <label></label> <span> <b>{{item.delivery_status}}</b>   </span> </p>
                <hr>
                <p> {{ item.created_at }} <br> [{{ item.created_at | moment("from", "now") }}] </p>
             </td>
             <td>
               <ul class="products">
                 <li v-for="product in item.Products" > #{{product.id}} - {{product.product_name_en}} -(Qty: {{product.quantity}}) </li>
               </ul>
             </td>
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
                <br><br>
                <div>
                   <v-btn  @click="openChangeStatusDialog(item,index)"  >
                      <b-icon-check-circle font-scale="1.6"></b-icon-check-circle>
                   </v-btn>
                </div>
             </td>
          </tr>
       </tbody>
    </table>

       <!-- - - - - - -START spinner & paginate - - - - - - - -->
       <spinnerPagnation :mainList="mainList" :show_spinner="show_spinner" @getResults="getResults"></spinnerPagnation>
       <!-- - - - - - -END spinner & paginate - - - - - - - -->



       <!-- ------------------- change Status ----------------------- - -->
       <v-row justify="center">
         <v-dialog v-model="changeStatusDialog" scrollable  max-width="400px">
            <v-card>
              <v-card-title   class="headline grey lighten-2"   primary-title   >
                Change Order ({{changeStatusInfo.id}}) Status
              </v-card-title>
              <v-card-text>
                <v-container>
                  <div class="delivery_status">
                    <p>
                      <span v-if="changeStatusInfo.delivery_status =='Acknowledged'" class="selected"> <b-icon-check-circle></b-icon-check-circle> Acknowledged </span>
                      <span v-else @click="changeDeliveryStatus(changeStatusInfo,'Acknowledged')"> <b-icon-circle></b-icon-circle> Acknowledged </span>
                    </p>
                    <p>
                      <span v-if="changeStatusInfo.delivery_status =='Preparing'" class="selected"> <b-icon-check-circle></b-icon-check-circle> Preparing </span>
                      <span v-else  @click="changeDeliveryStatus(changeStatusInfo,'Preparing')"> <b-icon-circle></b-icon-circle> Preparing </span>
                    </p>
                    <p>
                      <span v-if="changeStatusInfo.delivery_status =='Dispatched'" class="selected"> <b-icon-check-circle></b-icon-check-circle> Dispatched </span>
                      <span v-else  @click="changeDeliveryStatus(changeStatusInfo,'Dispatched')"> <b-icon-circle></b-icon-circle> Dispatched </span>
                    </p>
                    <p>
                      <span v-if="changeStatusInfo.delivery_status =='Delivered'" class="selected"> <b-icon-check-circle></b-icon-check-circle> Delivered </span>
                      <span v-else  @click="changeDeliveryStatus(changeStatusInfo,'Delivered')"> <b-icon-circle></b-icon-circle> Delivered </span>
                    </p>
                    <p>
                      <span v-if="changeStatusInfo.delivery_status =='canceled'" class="selected"> <b-icon-check-circle></b-icon-check-circle> Canceled </span>
                      <span v-else  @click="changeDeliveryStatus(changeStatusInfo,'canceled')"> <b-icon-circle></b-icon-circle> Canceled </span>
                    </p>
                  </div>
                    <!-- - - - - - -START spinner- - - - - - - -->
                    <spinner3 v-if="action_spinner"></spinner3>
                    <!-- - - - - - -End spinner- - - - - - - -->
                </v-container>

              </v-card-text>
              <v-divider></v-divider>
              <v-card-actions>
                 <v-spacer></v-spacer>
                  <v-btn large dark @click="changeStatusDialog = false">Close</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-row>

  </div><!--End page-wrapper-->
</template>

<script>
  import {AdminMixin} from '@/mixins/Admin_mixin';
  import icon_not_paid from "@/assets/icons/not_paid.svg";
  import icon_paid from "@/assets/icons/paid.svg";

  export default {
    name: 'OrderProcessing',
    mixins: [AdminMixin],
     data: ()  => ({
        icon_not_paid,icon_paid,
        Permission: 'Order',
        api_get_list: 'Order/get_list_with_products',
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
        changeStatusDialog: false,
        changeStatusInfo: {}
    }),//end data
    methods:{
        openChangeStatusDialog(item,index)
        {
             this.changeStatusDialog = true;
             this.changeStatusInfo = item;
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

            this.action_spinner = true;
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
                 this.action_spinner = false;
           }.bind(this))
           .fail(function(data){
              new Noty({text: 'proplem' , type: 'error' }).show();
           });
        },
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
    }//End methods
}//End export default
</script>
