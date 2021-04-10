 <template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Product - update stock with excel</h2>

     <router-link to="/Product"> <span> Products </span> </router-link> / <span>update stock with excel</span>
     <br><br>

    <!-- ------------------- create ----------------------- - -->

    <v-form  id="create_form" ref="createForm" v-model="isValid_createForm" :lazy-validation="false" >

<v-card>
   <v-subheader :inset="false">Main Info</v-subheader>
   <v-container>
     <!-- <p class=".font-weight-regular"> Main Info </p> -->

     <table class="table">
       <tr>
           <th> Structure </th>
           <td> First column must be sap_code , Second column must be stock </td>
       </tr>
       <tr>
           <th> sap_code </th>
           <td> the added code for each product </td>
       </tr>
       <tr>
           <th> stock </th>
           <td> Integer number bigger than or equal to 0 </td>
       </tr>
     </table>
     <hr>
     <!-- - - - - - -START spinner- - - - - - - -->
     <spinner2 v-if="show_spinner"></spinner2>
     <!-- - - - - - -End spinner- - - - - - - -->

    <v-row>
      <v-col>
           <v-file-input label="Excel file" name="excel_file" :disabled="btn_submit" prepend-icon="" show-size outlined :rules="requiredRules" id="excel_file"></v-file-input>
      </v-col>
      <v-col>
         <v-btn @click="update_stock()" x-large dark color="indigo">
            <b-icon-plus></b-icon-plus>
            <span> Update the stock </span>
         </v-btn>
      </v-col>
   </v-row>
  </v-container>
</v-card>

<br>



</v-form>

  </div><!--End page-wrapper-->
</template>

<script>
  import spinner2 from '@/components/spinner2';

  export default {
    name: 'updateStockWithExcel',
    components: {spinner2},
     data: () => ({
        Permission: 'updateStockWithExcel',
        api_create: 'Product/updateStockWithExcel',
        show_spinner:false,
        btn_submit:false,
        isValid_createForm: true,
        isValid_editForm: true,
        btn_submit:false,
        requiredRules: [
          v => (!!v || v == '0' ) || 'field is required',
        ],
    }),//end data
    created(){
      if(!localStorage.getItem('jwt')){
         this.$router.push('/login');
      }
      this.check_Permission(this.Permission);

    },
    methods:{
         update_stock()
         {
               this.$refs.createForm.validate();

               if( this.isValid_createForm )
               {
                   this.btn_submit = true;
                   this.show_spinner = true;

                   let my_formData = new FormData($('#create_form')[0]);
                   my_formData.append('excel_file', $('#excel_file').val() );

                   $.ajax({
                       type:"post",
                       url: `${Admin_BASE_url}/${this.api_create}` ,
                       data: my_formData,
                       processData: false,
                       contentType: false,
                       headers: { 'jwt': localStorage.getItem('jwt') },
                       success : function(responce){
                           if(responce.status == 'unValidJWT'){
                              localStorage.removeItem('jwt');
                              this.$router.push('/login');
                           }
                           else if(responce.status == 'success')
                           {
                               new Noty({ text: 'Stock has been update', type: 'success',timeout: 1500  }).show();

                               this.$refs.createForm.reset();
                               this.$refs.createForm.resetValidation();
                           }
                           else if(responce.status == 'notValid')
                           {
                               for (var property in responce.data)
                               {
                                   if (responce.data.hasOwnProperty(property))
                                   {
                                      new Noty({ text: responce.data[property][0] , type: 'warning',timeout: 1500  }).show();
                                   }
                               }
                           }
                           this.show_spinner = false;
                           this.btn_submit = false;
                       }.bind(this) ,
                   })
                   .fail(function(data){
                      new Noty({text: 'proplem' , type: 'error'  }).show();
                   });
               }
         },

    },//End methods
}//End export default
</script>
