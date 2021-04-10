<style>
   .setting_input .v-label.v-label--active.theme--light {
   font-size: 22px !important;
   color: black !important;
   font-weight: bold;
   }

</style>
 <template>
  <div class="page-wrapper" id="setting_wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Info & Content</h2>

     <br>

    <!-- ------------------- Edit ----------------------- - -->

    <v-form  id="edit_form" ref="editForm" v-model="isValid_Form" :lazy-validation="false" >

<v-card>
   <v-subheader :inset="false">Info</v-subheader>
   <v-container>
    <v-row>
     <v-col>
         <v-textarea label="Our Location En" v-model="Ef.our_location_en" name="input-7-4" outlined filled class="setting_input" rows="2" :rules="requiredRules"></v-textarea>
         <v-textarea label="Our Location Ar" v-model="Ef.our_location_ar" name="input-7-4" outlined filled class="setting_input" rows="2" :rules="requiredRules"></v-textarea>
           <hr>
          <v-text-field label="Our Phone 1" v-model="Ef.our_phone_1" outlined filled class="setting_input" :rules="requiredRules"></v-text-field>
          <!-- <v-text-field label="Our Phone 2" v-model="Ef.our_phone_2" outlined filled class="setting_input" :rules="requiredRules"></v-text-field> -->
      </v-col>
     <v-col>
           <!-- <div class="div_Preview_image">
              <img :src="Ef.banner" id="Preview_image_edit" class="Preview_image" >
              <v-file-input @change="Preview_image_banner($event,'Preview_image_edit')" label="Banner" name="banner" prepend-icon="" show-size outlined filled  ></v-file-input>
           </div> -->
           <v-text-field label="facebook" v-model="Ef.facebook_link" outlined filled class="setting_input" :rules="requiredRules"></v-text-field>
           <v-text-field label="instagram" v-model="Ef.instagram_link" outlined filled class="setting_input" :rules="requiredRules"></v-text-field>
           <!-- <v-text-field label="linkedin" v-model="Ef.linkedin_link" outlined filled class="setting_input" :rules="requiredRules"></v-text-field> -->
           <hr>
           <v-text-field label="Our Email" v-model="Ef.our_email" outlined filled class="setting_input" :rules="requiredRules"></v-text-field>
      </v-col>
   </v-row>
  </v-container>
</v-card>

<br>

<v-card>
   <v-subheader :inset="false">Pricing</v-subheader>
   <v-container>
      <v-row>
       <v-col>
          <v-text-field label="Minimum basket amount (EGP)" v-model="Ef.minimum_basket_amount" outlined filled class="setting_input" :rules="requiredRules"></v-text-field>
          <!-- <v-text-field label="Minimum free Taste amount (EGP)" v-model="Ef.minimum_freeTast_amount" outlined filled class="setting_input" :rules="requiredRules"></v-text-field> -->
        </v-col>
        <v-col>
           <!-- <v-text-field label="Tax percentage (%)" v-model="Ef.tax_price" outlined filled class="setting_input" :rules="requiredRules"></v-text-field>
           <v-text-field label="shipping price" v-model="Ef.shipping_price" outlined filled class="setting_input" :rules="requiredRules"></v-text-field> -->
        </v-col>
      </v-row>
   </v-container>
</v-card>

<br>
<v-card>
   <v-subheader :inset="false">About us</v-subheader>
   <v-container>
      <v-row>
        <v-col>
             <v-textarea label="About us En" v-model="Ef.aboutus_en" name="input-7-4" outlined filled class="setting_input" rows="15" :rules="requiredRules"></v-textarea>
             <v-textarea label="About us Ar" v-model="Ef.aboutus_ar" name="input-7-4" outlined filled class="setting_input" rows="15" :rules="requiredRules" style="direction: rtl;"></v-textarea>
        </v-col>
        <v-col>
             <div class="div_Preview_image">
                <img :src="Ef.aboutus_side_image" id="Preview_image_banner" class="Preview_image" style="max-height:340px;" >
                <v-file-input @change="Preview_image_banner($event,'Preview_image_banner')" label="Banner" name="aboutus_side_image" prepend-icon="" show-size outlined filled  ></v-file-input>
             </div>
        </v-col>
      </v-row>
   </v-container>
</v-card>



<!-- <v-card>
   <v-subheader :inset="false">Privacy Policy</v-subheader>
   <v-container>
      <v-row>
       <v-col>
           <v-textarea label="INFORMATION USE En" v-model="Ef.PrivacyPolicy_INFORMATION_USE_en" name="input-7-4" outlined filled class="setting_input" rows="22" :rules="requiredRules"></v-textarea>
       </v-col>
       <v-col>
         <v-textarea label="INFORMATION USE Ar" v-model="Ef.PrivacyPolicy_INFORMATION_USE_ar" name="input-7-4" outlined filled class="setting_input" rows="22" :rules="requiredRules"></v-textarea>
        </v-col>
      </v-row>
      <v-row>
       <v-col>
           <v-textarea label="INFORMATION DISCLOSURE En" v-model="Ef.PrivacyPolicy_INFORMATION_DISCLOSURE_en" name="input-7-4" outlined filled class="setting_input" rows="8" :rules="requiredRules"></v-textarea>
       </v-col>
       <v-col>
         <v-textarea label="INFORMATION DISCLOSURE Ar" v-model="Ef.PrivacyPolicy_INFORMATION_DISCLOSURE_ar" name="input-7-4" outlined filled class="setting_input" rows="8" :rules="requiredRules"></v-textarea>
        </v-col>
      </v-row>
   </v-container>
</v-card> -->

<br>


   <!-- - - - - - -START spinner- - - - - - - -->
   <spinner2 v-if="show_spinner"></spinner2>
   <!-- - - - - - -End spinner- - - - - - - -->


<v-row>
   <v-col>

   </v-col>
   <v-col>
      <v-btn large color="success" width="100%" @click="edit()" :disabled="btn_submit" > Update  </v-btn>
   </v-col>
</v-row>

</v-form>
<br>
<br>

  </div><!--End page-wrapper-->
</template>

<script>
  import spinner2 from '@/components/spinner2';

  export default {
    name: 'Setting',
    components: {spinner2},
     data: () => ({
        Permission: 'Refrence',
        api_update: 'Setting/update',
        show_spinner:false,
        btn_submit:false,
        Ef: { },
        isValid_Form: true,
        requiredRules: [
          v => !!v || 'field is required',
        ],
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
              this.Applicants = [];
              this.show_spinner = true;
              $.ajax({
                    type:"get",
                    url: `${Admin_BASE_url}/Setting/list` ,
                    headers: { 'jwt': localStorage.getItem('jwt') },
               })
               .done(function(Response){
                  if(Response.status == 'unValidJWT'){
                     localStorage.removeItem('jwt');
                     this.$router.push('/login');
                  }  console.log(Response);
                  this.Ef = Response;
                  this.show_spinner = false;
               }.bind(this))
               .fail(function(data){
                 new Noty({text: 'proplem' , type: 'error'  }).show();
               });
         },
         edit()
         {
               this.$refs.editForm.validate();

               if( this.isValid_Form )
               {
                   this.btn_submit = true;
                   this.show_spinner = true;

                   let my_formData = new FormData( );
                   for (var key in { ...this.Ef })
                   {
                      if (this.Ef.hasOwnProperty(key)) {
                           my_formData.append(key, this.Ef[key] );
                      }
                   }

                   $("#edit_form input[type=file]").each(function(){
                         if( $(this).get(0).files.length != 0 ){
                              my_formData.append( $(this).attr("name") , $(this)[0].files[0]);
                         }
                   });

                   $.ajax({
                       type:"post",
                       url: `${Admin_BASE_url}/${this.api_update}` ,
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
                               new Noty({ text: 'Content has updated', type: 'success',timeout: 1500  }).show();
                               this.data = this.Ef;
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
         // Preview_image(e,image)
         // {
         //      if(e) {
         //         image.image = URL.createObjectURL(e);
         //      }
         // },
         Preview_image_banner(e,from_id)
         {
              if(e) {
                 $('#'+from_id).attr('src', URL.createObjectURL(e)) ;
              }
         },
    },//End methods
    computed: {

    }
}//End export default
</script>
