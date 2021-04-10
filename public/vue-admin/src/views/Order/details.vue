 <style lang="scss" scoped>
#sec_order_details .v-timeline
{
   padding-top: 10px;
}
#sec_order_details .v-timeline-item
{
   padding-bottom: 20px;
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

</style>
 <style lang="scss" >


    .page-wrapper table.tbl_mainList tbody tr.removePadding td:last-child div {
        padding: 2px 0px;
    }
    .page-wrapper table.tbl_mainList tbody tr.removePadding td:last-child .timeLine_card div {
        padding: 2px 10px;
    }
    #sec_order_details .v-timeline-item__divider{
        padding: 2px 15px;
    }

    .modification_card
    {
        width: 600px;
        // width: 100%;
        position: relative;
        background-color: rgb(230, 230, 230);
        box-shadow: 1px 1px 5px black;
        padding: 15px!important;
        margin: 6px;
        h2{
            font-size: 26px;
        }
    }
    // for the right arrow
    .modification_card:after {
        content: " ";
        position: absolute;
        right: -15px;
        top: 35%;
        border-top: 15px solid transparent;
        border-right: none;
        border-left: 15px solid rgb(230, 230, 230);
        border-bottom: 15px solid transparent;
    }

    .flexx{
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
    }

    .flexx > div{
    }

    .modification_first_col{
        // flex:   50%;
    }

    .modification_middle_col
    {
        min-width: 190px;
        text-align: center;
    }

</style>
<template>
  <div class="page-wrapper" id="sec_order_details">

        <div style="float: right;">
              <!-- <a :href="Admin_BASE_url+'/Order/print/'+order.id" target="_blank" class="btn btn-default" style="font-size: 18px;border: 2px solid black;padding: 5px 34px;">
                 <span class="fa fa-print"> Print </span>
              </a> -->
        </div>

     <h2 class="font-italic font-weight-light font-weight-bold"> INVOICE </h2>
     <div>
        <router-link to="/Order"> <span> Orders </span> </router-link> / <span>Details</span>
     </div>


     <v-row>
        <v-col>
           <v-card>
               <v-card-title class="headline grey lighten-2" primary-title >
                  From
               </v-card-title>
               <v-container class="text-center">
                  <img :src="logo_site" style="max-height:120px" >
               </v-container>
           </v-card>




        </v-col>
        <v-col>
           <v-card>
               <v-card-title class="headline grey lighten-2" primary-title >
                  To
               </v-card-title>
               <v-container>
                     <table class="table" >
                        <tr>
                           <th width="110px"> Member id </th>
                           <td> {{order.member_id}} </td>
                        </tr>
                        <tr>
                           <th> name </th>
                           <td> {{order.member_name}} </td>
                        </tr>
                        <tr>
                           <th> phone </th>
                           <td> {{order.member_phone}} </td>
                        </tr>
                        <tr>
                           <th> email </th>
                           <td> {{order.member_email}} </td>
                        </tr>
                     </table>
               </v-container>
           </v-card>
        </v-col>
        <v-col>
           <v-card>
               <v-card-title class="headline grey lighten-2" primary-title >
                  Invoice
               </v-card-title>
               <v-container>
                     <table class="table" >
                        <tr>
                           <th> Invoice id </th>
                           <td> {{order.id}} </td>
                        </tr>
                        <!-- <tr>
                           <th> Sap code: </th>
                           <td>
                               <form class="form-inline">
                                  <input type="text" v-model="order.serial_no" class="form-control" placeholder="Serial number" style="width:65%">
                                  <button type="button" class="btn btn-danger" @click="add_serial_to_recipt" :disabled="btn_submit" > add </button>
                               </form>
                           </td>
                        </tr> -->
                        <tr>
                           <th> Invoice Date: </th>
                           <td> {{ order.created_at | moment("d/M/YYYY, h:mm:ss a") }} <br> [{{ order.created_at | moment("from", "now") }}] </td>
                        </tr>
                        <tr>
                           <th> Total: </th>
                           <td> {{order.total_price}} EGP </td>
                        </tr>
                        <!-- <tr>
                           <th> Points: </th>
                           <td> {{order.points_deduction_price}} EGP </td>
                        </tr> -->
                        <tr>
                           <th> Discount: </th>
                           <td> {{order.discount_percentage}}% </td>
                        </tr>
                        <tr>
                           <th> Vat: </th>
                           <td> {{order.vat_price}} EGP </td>
                        </tr>
                        <tr>
                           <th> Wallet: </th>
                           <td> {{order.wallet_deduction}} EGP </td>
                        </tr>
                        <tr>
                           <th> Final price: </th>
                           <td> {{order.final_price}} EGP </td>
                        </tr>
                        <!-- <tr>
                           <th> Payment method: </th>
                           <td> {{order.payment_method}}  </td>
                        </tr> -->
                     </table>
               </v-container>
           </v-card>
        </v-col>

     </v-row>


     <!-- <v-card>
         <v-card-title class="headline grey lighten-2" primary-title >
            Member comment
         </v-card-title>
         <v-container>
            <p v-if="order.member_comment"> {{order.member_comment}} </p>
            <p v-else class="error--text"> No comment added by this member for this order </p>

         </v-container>
     </v-card> -->

     <div>
        <v-divider class="mx-4"></v-divider>
        <h3 class="font-italic font-weight-light font-weight-bold">Items</h3>

        <table class="tbl_mainList text-left"  >
           <thead>
             <!-- <th> Image </th> -->
             <th> Id </th>
             <th> Image </th>
             <th> Name </th>
             <th> Info </th>
             <th> delivery status </th>
          </thead>
          <tbody  v-for="(item,index) in products" :key="item.id"> <!-- is="transition-group" name="my-list" -->

             <tr   style="position:relative!important">
                <td> {{ item.product_id }}    <br> <span style="visibility:hidden" > <!-- order item id: -->  {{ item.id }}</span></td>
                <td width="15%">
                     <span v-if="item.is_bundle"> <p>Bundle</p> </span>
                     <span v-else> <img :src="item.image" width="100" style="max-height:150px"> </span>


                     <v-switch v-model="item.showModificationsList" :label="'('+ item.get_order_modifications.length +') Modif' " value="1" color="success" hide-details ></v-switch>

                </td>
                <td style="max-width:35%">
                   <p>
                        <b>{{item.provider_name}}</b>
                         <br>  <font-awesome-icon icon="caret-down" size="lg"  />   <br>
                        {{item.product_name}}
                   </p>
                   <!-- <div v-if="item.member_brief">
                                  <hr style=" margin-top: 10px; margin-bottom: 10px;">
                       <p style="margin-bottom: 5px;" class="text-center"> <b>Member Brief</b> </p>
                       <p> {{ item.member_brief }} </p>
                   </div> -->
                </td>
                <td>
                    <b>{{item.price}} EGP </b>
                        <hr>
                    <p @click="show_memberBrief_sheet(item.member_brief)" class="pointer"> Member brief </p>
                        <hr>
                    <p @click="show_marketingBrief_sheet(item.get_marketing_brief)" class="pointer"> Marketing brief </p>
                        <hr>
                    <p @click="show_AdminComment_popup(item)" class="pointer"> Admin Comment </p>
                </td>
                <td class="td_delivery_status" style="width: 45%;" >
                    <p>
                        <span v-if="item.delivery_status =='Acknowledged'" class="selected"> <b-icon-check-circle></b-icon-check-circle> Acknowledged ({{ order.created_at | moment("d/M/YYYY, h:mm:ss a") }}) </span>
                        <span v-else @click="changeDeliveryStatus(item,'Acknowledged')"> <b-icon-circle></b-icon-circle> Acknowledged ({{ order.created_at | moment("d/M/YYYY, h:mm:ss a") }})</span>
                    </p>
                    <p>
                        <span v-if="item.delivery_status =='Prototype'" class="selected"> <b-icon-check-circle></b-icon-check-circle> Prototype ({{ item.get_order_details_admin_info.Prototype_date | moment("d/M/YYYY, h:mm:ss a") }})  </span>
                        <span v-else  @click="changeDeliveryStatus(item,'Prototype')"> <b-icon-circle></b-icon-circle> Prototype ({{ item.get_order_details_admin_info.Prototype_date | moment("d/M/YYYY, h:mm:ss a") }}) </span>
                    </p>
                    <p>
                        <span v-if="item.delivery_status =='Prototype Modification'" class="selected"> <b-icon-check-circle></b-icon-check-circle> Prototype Modification ({{ item.get_order_details_admin_info.PrototypeModification_date | moment("d/M/YYYY, h:mm:ss a") }}) </span>
                        <span v-else  @click="changeDeliveryStatus(item,'Prototype Modification')"> <b-icon-circle></b-icon-circle> Prototype Modification ({{ item.get_order_details_admin_info.PrototypeModification_date | moment("d/M/YYYY, h:mm:ss a") }}) </span>
                    </p>
                    <p>
                        <span v-if="item.delivery_status =='Finalization'" class="selected"> <b-icon-check-circle></b-icon-check-circle> Finalization ({{ item.get_order_details_admin_info.Finalization_date | moment("d/M/YYYY, h:mm:ss a") }}) </span>
                        <span v-else  @click="changeDeliveryStatus(item,'Finalization')"> <b-icon-circle></b-icon-circle> Finalization ({{ item.get_order_details_admin_info.Finalization_date | moment("d/M/YYYY, h:mm:ss a") }}) </span>
                    </p>
                    <p>
                        <span v-if="item.delivery_status =='Finalizing Modification'" class="selected"> <b-icon-check-circle></b-icon-check-circle> Finalizing Modification ({{ item.get_order_details_admin_info.FinalizingModification_date | moment("d/M/YYYY, h:mm:ss a") }}) </span>
                        <span v-else  @click="changeDeliveryStatus(item,'Finalizing Modification')"> <b-icon-circle></b-icon-circle> Finalizing Modification ({{ item.get_order_details_admin_info.FinalizingModification_date | moment("d/M/YYYY, h:mm:ss a") }}) </span>
                    </p>
                    <p>
                        <span v-if="item.delivery_status =='Delivered'" class="selected"> <b-icon-check-circle></b-icon-check-circle> Delivered ({{ item.get_order_details_admin_info.Delivered_date | moment("d/M/YYYY, h:mm:ss a") }}) </span>
                        <span v-else  @click="changeDeliveryStatus(item,'Delivered')"> <b-icon-circle></b-icon-circle> Delivered ({{ item.get_order_details_admin_info.Delivered_date | moment("d/M/YYYY, h:mm:ss a") }}) </span>
                    </p>
                </td>

             </tr>
             <tr > <!-- modifcation area -->
                <td colspan="5" v-show="item.showModificationsList">

                     <div class="flexx" v-for="modification in item.get_order_modifications" :key="modification.id" >
                         <div class="modification_first_col">
                             <div class="modification_card">
                                <h2> {{ modification.name_en }} </h2>
                                <p style="white-space: pre-line;"> {{ modification.description_en }} </p>
                            </div>
                         </div>
                         <div class="modification_middle_col">
                            <div>
                                {{ modification.created_at| moment("d/M/YYYY, h:mm:ss a") }}
                                 <br>
                                [{{ modification.created_at | moment("from", "now") }}]
                                <br>
                                <v-chip v-if="modification.is_piad" color="green" dark> piad  </v-chip>
                                <v-chip v-else color="red" dark> Not piad </v-chip>
                            </div>
                         </div>
                         <div>
                             <div>
                                <v-btn @click="openShowModifcationDialog(modification)">
                                  <font-awesome-icon icon="search" size="lg"    />
                               </v-btn>
                               <br><br>
                               <v-btn @click="del_modifacation()">
                                  <font-awesome-icon icon="trash-alt" size="lg"  :style="{ color: '#dc3545' }" />
                               </v-btn>
                             </div>

                         </div>
                         <hr>
                     </div>


                    <v-spacer></v-spacer>
                      <div style="float: right;">
                        <v-btn large color="info" dark @click="Add_modification(item)" :disabled="btn_submit" >Add Modification</v-btn>
                     </div>

                </td>
             </tr>
          </tbody>
       </table>



     </div>

     <hr>



 <!-- ------------------- marketing brief Sheet ----------------------- - -->
        <div class="text-center">

            <v-bottom-sheet v-model="showMarketingBriefSheet">
            <v-sheet  class="text-center"   >
                <v-btn  class="mt-6" text  color="red" @click="showMarketingBriefSheet = !showMarketingBriefSheet" >
                  close
                </v-btn>
                <div class="py-3">

                   <v-row v-if="Mark_Brief">
                        <v-col>
                            <table class="table">
                                <tr>
                                    <th> Name </th>
                                    <td> {{ Mark_Brief.name }} </td>
                                </tr>
                                <tr>
                                    <th> About Brand </th>
                                    <td> {{ Mark_Brief.about_brand }} </td>
                                </tr>
                                <tr>
                                    <th> Site link </th>
                                    <td> {{ Mark_Brief.site_link }} </td>
                                </tr>
                                <tr>
                                    <th> USPs </th>
                                    <td> {{ Mark_Brief.USPs }} </td>
                                </tr>
                                <tr>
                                    <th> kpi </th>
                                    <td> {{ Mark_Brief.kpi }} </td>
                                </tr>
                                <tr>
                                    <th> Primary Target </th>
                                    <td> {{ Mark_Brief.talk_to_primary }} </td>
                                </tr>
                                <tr>
                                    <th> Secondary Target </th>
                                    <td> {{ Mark_Brief.talk_to_secondary }} </td>
                                </tr>

                            </table>
                        </v-col>
                        <v-col>
                             <table class="table">
                                <tr>
                                    <th> Goals </th>
                                    <td> {{ Mark_Brief.key_response }} </td>
                                </tr>
                                <tr>
                                    <th> Colors </th>
                                    <td> {{ Mark_Brief.colors }} </td>
                                </tr>
                                <tr>
                                    <th> Competitors </th>
                                    <td v-if="Mark_Brief.competitors">
                                        <span v-for="item in JSON.parse(Mark_Brief.competitors)" > {{ item.competitor }} , </span>
                                    </td>
                                </tr>
                                <tr v-if="Mark_Brief.created_at">
                                    <th> Created date </th>
                                    <td>  [{{ Mark_Brief.created_at | moment("from", "now") }}] </td>
                                </tr>
                                <tr v-if="Mark_Brief.updated_at">
                                    <th> Updated date </th>
                                    <td>  [{{ Mark_Brief.updated_at | moment("from", "now") }}] </td>
                                </tr>

                            </table>
                        </v-col>
                   </v-row>
                   <div v-else> <!-- no marketing brief -->
                        <h3>No marketing brief choosen</h3>
                   </div>


                </div>
            </v-sheet>
            </v-bottom-sheet>
        </div>
<!-- ------------------- Member brief Sheet ----------------------- - -->
        <div class="text-center">

            <v-bottom-sheet v-model="showMemberBriefSheet" inset >
            <v-sheet  class="text-center"   >
                <v-btn  class="mt-6" text  color="red" @click="showMemberBriefSheet = !showMemberBriefSheet" >
                  close
                </v-btn>
                <div class="py-3">
                   <div v-if="Member_Brief">
                       {{ Member_Brief }}
                   </div>
                   <div v-else> <!-- no Member brief -->
                        <h3>No Member brief  </h3>
                   </div>
                </div>
            </v-sheet>
            </v-bottom-sheet>
        </div>
<!-- ------------------- Admin Commment Popup ----------------------- - -->
          <v-row justify="center">
         <v-dialog v-model="AdminCommentPopup" scrollable  max-width="600px">
            <v-card>
              <v-card-title class="headline grey lighten-2" primary-title >
                 Admin Commment
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-form id="create_form" ref="createForm" v-model="isValid_AdminCommentForm" :lazy-validation="false" >
                      <p> Admin Comment for  ({{Admin_Comment.product_name }})   </p>

                        <v-textarea label="Admin Comment" v-model="Admin_Comment.get_order_details_admin_info.admin_comment" outlined rows="8" :rules="[v => !!v || 'field is required']" ></v-textarea>

                  </v-form>
                          <!-- - - - - - -START spinner- - - - - - - -->
                          <spinner3 v-if="action_spinner"></spinner3>
                          <!-- - - - - - -End spinner- - - - - - - -->
                </v-container>

              </v-card-text>
              <v-divider></v-divider>
              <v-card-actions>
                 <v-spacer></v-spacer>
                  <v-btn large dark @click="AdminCommentPopup = false">Close</v-btn>
                  <v-btn large color="success" dark @click="submitAdminComment()" :disabled="btn_submit" >Save</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-row>
<!-- ------------------- Add Modifcation Dialog ----------------------- - -->
            <v-row justify="center">
                <v-dialog v-model="showModificationDialog" scrollable  max-width="1000px">
                    <v-card>
                        <v-card-title class="headline grey lighten-2" primary-title >
                             Create New Modification for ({{ Modification_selected_product.product_name }})
                        </v-card-title>
                        <v-card-text>
                        <v-container>
                            <v-form  id="create_form" ref="createForm" v-model="isValid_ModificationForm" :lazy-validation="false" >
                                <v-row>
                                <v-col>
                                    <v-text-field label="Title En" v-model="createModification.name_en" outlined :rules="requiredRules" ></v-text-field>
                                    <v-textarea label="Description En" v-model="createModification.description_en" name="input-7-4" outlined rows="8" :rules="requiredRules"></v-textarea>
                                </v-col>
                                <v-col>
                                    <v-text-field label="Title Ar" v-model="createModification.name_ar" outlined required :rules="requiredRules"></v-text-field>
                                    <v-textarea label="Description En" v-model="createModification.description_ar" name="input-7-4" outlined rows="8" :rules="requiredRules"></v-textarea>
                                    <v-text-field label="price" type="number" v-model="createModification.price" outlined required :rules="requiredRules"></v-text-field>
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
                            <v-btn large dark @click="showModificationDialog = false">Close</v-btn>
                            <v-btn large color="success" dark @click="submitNewModification()" :disabled="btn_submit" >Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-row>
<!-- ------------------- show Modifcation Dialog----------------------- - -->
            <v-row justify="center">
                <v-dialog v-model="ShowModifcationDialog" scrollable  max-width="800px">
                    <v-card>
                        <v-card-title class="headline grey lighten-2" primary-title >
                             Show Modification
                        </v-card-title>
                        <v-card-text>
                        <v-container>

                            <table class="table">
                                <tr>
                                    <th style="width:200px" > Title En </th>
                                    <td> {{ show_Modifcation.name_en }} </td>
                                </tr>
                                <tr>
                                    <th> Title Ar </th>
                                    <td> {{ show_Modifcation.name_ar }} </td>
                                </tr>
                                <tr>
                                    <th> Description En </th>
                                    <td style="white-space: pre-line;"> {{ show_Modifcation.description_en }} </td>
                                </tr>
                                <tr>
                                    <th> Description Ar </th>
                                    <td style="white-space: pre-line;"> {{ show_Modifcation.description_ar }} </td>
                                </tr>
                                <tr>
                                    <th> Price</th>
                                    <td> {{ show_Modifcation.price }} EGP </td>
                                </tr>
                                <tr>
                                    <th> Creation Date</th>
                                    <td>
                                          {{ show_Modifcation.created_at| moment("d/M/YYYY, h:mm:ss a") }}
                                         [{{ show_Modifcation.created_at | moment("from", "now") }}]
                                    </td>
                                </tr>
                                <tr>
                                    <th> Is Paid </th>
                                    <td>
                                        <v-chip v-if="show_Modifcation.is_piad" color="green" dark>
                                            piad [ {{ show_Modifcation.piad_at| moment("d/M/YYYY, h:mm:ss a") }} ]
                                            [{{ show_Modifcation.piad_at | moment("from", "now") }}]
                                        </v-chip>
                                        <v-chip v-else color="red" dark> Not piad </v-chip>
                                    </td>
                                </tr>
                            </table>

                            <!-- - - - - - -START spinner- - - - - - - -->
                            <spinner3 v-if="action_spinner"></spinner3>
                            <!-- - - - - - -End spinner- - - - - - - -->
                        </v-container>

                        </v-card-text>
                        <v-divider></v-divider>
                        <v-card-actions>
                        <v-spacer></v-spacer>
                            <v-btn large dark @click="ShowModifcationDialog = false">Close</v-btn>
                         </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-row>



     <!-- <v-card>
         <v-card-title class="headline grey lighten-2" primary-title >
            Rating
         </v-card-title>
         <v-container>
               <div v-if="!Object.keys(Rating).length" class="error--text"> <b> No Rating</b> </div>
               <table v-else class="table" >
                  <tr>
                     <th> 1- How satisfied are you with the way the SuperDeli agent handled your </th>
                     <td> <v-rating v-model="Rating.q1" background-color="indigo lighten-3" color="purple" :readonly="true"></v-rating> </td>
                  </tr>
                  <tr>
                     <th> 2- How satisfied are you with our range of the products? </th>
                     <td> <v-rating v-model="Rating.q2" background-color="indigo lighten-3" color="pink" :readonly="true"></v-rating> </td>
                  </tr>
                  <tr>
                     <th> 3. How satisfied are you with the delivery speed and service? </th>
                     <td> <v-rating v-model="Rating.q3" background-color="indigo lighten-3" color="orange" :readonly="true"></v-rating> </td>
                  </tr>
                  <tr>
                     <th> 4. Did the product meet your expectations </th>
                     <td> <v-rating v-model="Rating.q4" background-color="indigo lighten-3" color="green" :readonly="true"></v-rating> </td>
                  </tr>
                  <tr>
                     <th> 5. How likely would it be that you recommend SuperDeli to a friend? </th>
                     <td> <v-rating v-model="Rating.q5" background-color="indigo lighten-3" color="indigo" :readonly="true"></v-rating> </td>
                  </tr>
                  <tr>
                     <th> Comments </th>
                     <td>  <p> {{Rating.comment}} </p> </td>
                  </tr>
                  <tr>
                     <th> Rating date </th>
                     <td>  <p> {{Rating.created_at}} <br>[{{ Rating.created_at | moment("from", "now") }}] </p> </td>
                  </tr>

               </table>
         </v-container>
     </v-card> -->

    <!-- - - - - - -START spinner- - - - - - - -->
     <spinner2 v-if="show_spinner"></spinner2>
    <!-- - - - - - -End spinner- - - - - - - -->

  </div><!--End page-wrapper-->
</template>

<script>
  import spinner3 from '@/components/spinner3';
  import logo_site from "@/assets/logo_site.svg";

  export default {
    name: 'Orders-details',
    components: {
      spinner3
    },
     data: () => ({
        logo_site,
        Permission: 'Order',
        show_spinner: false,
        order: {},
        Rating: {},
        products: [],
        Admin_BASE_url: Admin_BASE_url,

        showMarketingBriefSheet: false,
        Mark_Brief: {},

        showMemberBriefSheet: false,
        Member_Brief: '',

        showModificationDialog: false,
        isValid_ModificationForm: true,
        Modification_selected_product: {},
        createModification: {},

        ShowModifcationDialog: false,
        show_Modifcation: {},

        AdminCommentPopup: false,
        isValid_AdminCommentForm: true,
        Admin_Comment: {get_order_details_admin_info:''},
        btn_submit: false,
        action_spinner: false,
    }),//end data
    created(){
      this.getOrders();
    },
    methods:{
         getOrders()
         {
               $.ajax({
                  type:"get",
                  url: `${Admin_BASE_url}/Order/details/${this.$route.params.id}` ,
                  headers: { 'jwt': localStorage.getItem('jwt') }
              })
              .done(function(Response){
                if(Response.status == 'unValidJWT'){
                    localStorage.removeItem('jwt');
                    this.$router.push('/login');
                }
                this.order = Response.Order;
             //  this.Rating = Response.Rating;
                this.products = Response.Products;

              }.bind(this))
              .fail(function(data){
                 new Noty({text: 'proplem' , type: 'error' }).show();
              });
         },
         changeDeliveryStatus(item,new_delivery_status)
         {
            if(item.delivery_status == new_delivery_status){  return ; }

            // --- for not allowing the status to go back ---
                var allow_change = true;
            switch (new_delivery_status)
            {
                case 'Acknowledged':
                        allow_change = false;
                    break;
                case 'Prototype':
                    if( ['Prototype Modification', 'Finalization', 'Finalizing Modification', 'Delivered'].includes(item.delivery_status) )
                        allow_change = false;
                    break;
                case 'Prototype Modification':
                    if( [ 'Finalization', 'Finalizing Modification', 'Delivered'].includes(item.delivery_status) )
                        allow_change = false;
                    break;
                case 'Finalization':
                    if( [ 'Finalizing Modification', 'Delivered'].includes(item.delivery_status) )
                        allow_change = false;
                    break;
                case 'Finalizing Modification':
                    if( [ 'Delivered'].includes(item.delivery_status) )
                        allow_change = false;
                    break;
            }

            if(!allow_change){
                new Noty({text: 'Can\'t go back in status due to time calclations' , type: 'error' }).show();
                return ;
            }


               var jwt = localStorage.getItem('jwt');
                var myVars = {
                    jwt ,
                    order_details_id: item.id,
                    delivery_status: new_delivery_status
                };
           $.post(`${Admin_BASE_url}/Order/changeDeliveryStatus`,myVars)
            .done(function(Response){
                if(Response.status == 'unValidJWT'){
                    localStorage.removeItem('jwt');
                    this.$router.push('/login');
                }
                item.delivery_status = Response.delivery_status;
                item.get_order_details_admin_info = Response.getOrderDetailsAdminInfo;
                new Noty({text: `Delivered status changed to ${item.delivery_status}`, type: 'success' }).show();
            }.bind(this))
            .fail(function(data){
                new Noty({text: 'proplem' , type: 'error' }).show();
            });
         },
         submitAdminComment()
         {
                var jwt = localStorage.getItem('jwt');
                var myVars = {
                    jwt ,
                    admin_comment: this.Admin_Comment.get_order_details_admin_info.admin_comment,
                    order_details_adminInfo_id: this.Admin_Comment.get_order_details_admin_info.id
                };
                this.action_spinner = true;
                 $.post(`${Admin_BASE_url}/Order/updateAdminComment_of_orderDetails`,myVars)
                    .done(function(Response){
                        if(Response.status == 'unValidJWT'){
                            localStorage.removeItem('jwt');
                            this.$router.push('/login');
                        }

                        this.action_spinner = false;

                        new Noty({text: `comment has updated`, type: 'success' }).show();
                    }.bind(this))
                    .fail(function(data){
                        new Noty({text: 'proplem' , type: 'error' }).show();
                    });
         },
         submitNewModification()
         {
                var jwt = localStorage.getItem('jwt');
                var myVars = {
                    jwt ,
                    order_details_id: this.Modification_selected_product.id ,
                    name_en: this.createModification.name_en ,
                    name_ar: this.createModification.name_ar ,
                    description_en: this.createModification.description_en ,
                    description_ar: this.createModification.description_ar ,
                    price: this.createModification.price ,
                };
                this.action_spinner = true;
                 $.post(`${Admin_BASE_url}/Order/Add_modification`,myVars)
                    .done(function(Response){
                        if(Response.status == 'unValidJWT'){
                            localStorage.removeItem('jwt');
                            this.$router.push('/login');
                        }

                        this.action_spinner = false;
                        this.showModificationDialog = false;

                        new Noty({text: `modification has added`, type: 'success' }).show();
                    }.bind(this))
                    .fail(function(data){
                        new Noty({text: 'proplem' , type: 'error' }).show();
                    });
         },
         show_marketingBrief_sheet(item)
         {
            this.showMarketingBriefSheet = true;
            this.Mark_Brief = item;
         },
         show_memberBrief_sheet(item)
         {
            this.showMemberBriefSheet = true;
            this.Member_Brief = item;
         },
         show_AdminComment_popup(item)
         {
            this.AdminCommentPopup = true;
            this.Admin_Comment = item;
         },
         Add_modification(item)
         {
             this.showModificationDialog = true;
             this.Modification_selected_product = item;
         },
         openShowModifcationDialog(modification)
         {
              this.ShowModifcationDialog = true;
              this.show_Modifcation = modification;
         }
    }//End methods
}//End export default
</script>
