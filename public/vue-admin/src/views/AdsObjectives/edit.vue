 <style scoped>
    .centered-input >>> input {
      text-align: center
    }
</style>
 <template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Ads Objectives Edit</h2>

     <router-link to="/AdsObjectives"> <span> Ads Objectives </span> </router-link> / <span>Edit</span>
     <br><br>

    <!-- ------------------- Edit ----------------------- - -->

    <v-form  id="edit_form" ref="editForm" v-model="isValid_Form" :lazy-validation="false" >

<v-card>
   <v-subheader :inset="false">Main Info</v-subheader>
   <v-container>
    <v-row>
     <v-col>

          <!-- <v-select outlined v-model="Ef.provider_id" :items="providers" item-text="label" item-value="value" label="Provider" :rules="requiredRules" ></v-select> -->

          <v-text-field label="Name En" v-model="Ef.name_en" outlined :rules="requiredRules" disabled ></v-text-field>
          <v-text-field label="Name Ar" v-model="Ef.name_ar" outlined :rules="requiredRules"></v-text-field>


          <v-text-field label="youtube Embded link (v=) " v-model="Ef.youtube_link" outlined  ></v-text-field>

          <div>
            <iframe width="100%" height="200px" :src="'https://www.youtube.com/embed/'+Ef.youtube_link" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>

          <v-switch v-model="Ef.is_available" label="is available"  color="success" hide-details ></v-switch>
          <br>

       </v-col>
     <v-col>
           <!-- <div class="div_Preview_image">
              <img  id="Preview_image_create" class="Preview_image" >
              <v-file-input @change="Preview_image_banner($event,'Preview_image_create')" label="Banner" name="banner" prepend-icon="" show-size outlined :rules="requiredRules"></v-file-input>
           </div> -->

          <v-textarea label="Top Description En" v-model="Ef.top_description_en" name="input-7-4" outlined rows="8" :rules="requiredRules"></v-textarea>
          <v-textarea label="Top Description Ar" v-model="Ef.top_description_ar" name="input-8-4" outlined rows="8" :rules="requiredRules"></v-textarea>

      </v-col>
   </v-row>

   <v-row>
        <v-col>
            <v-textarea label="About Description En" v-model="Ef.description_en" name="input-7-4" outlined rows="5" :rules="requiredRules"></v-textarea>
        </v-col>
        <v-col>
            <v-textarea label="About Description Ar" v-model="Ef.description_ar" name="input-7-4" outlined rows="5" :rules="requiredRules"></v-textarea>
        </v-col>
   </v-row>

  </v-container>
</v-card>
<br>

<v-card>
   <v-subheader :inset="false">Images</v-subheader>
   <v-container>

     <table class="table">
         <thead>
            <td> Input </td>
            <td> Image </td>
            <td> Main </td>
            <td> Del </td>
         </thead>
         <tbody is="transition-group" name="my-list">
            <tr v-for="(image,index) in images" :key="image.cc" >
               <td width="40%">
                   <input type="hidden" name="old_images_ids[]" :value="image.id">
                   <v-file-input v-if="!image.id" :rules="requiredRules" @change="Preview_image2($event,image)" name="images[]" :label="'Image '+(1+index)" hint="140*140 Pixels" :persistent-hint="true" prepend-icon="" show-size outlined  ></v-file-input>
               </td>
               <td width="30%"> <img :src="image.image" :id="'Preview_image_edit'+index" style="max-width:150px;max-height:150px;" > </td>
               <td>
                   <input type="radio" name="is_main" v-if="image.id" :value="image.id" :rules="requiredRules" :checked="image.is_main" />
                   <span v-if="image.id"> {{1+index}} </span>
               </td>
               <td>
                  <b-icon-trash  @click="del_row(index,image)" font-scale="1.6" variant="danger" class="pointer"></b-icon-trash>
               </td>
            </tr>
         </tbody>
      </table>
      <div class="text-right">
         <v-btn @click="add_new_image()" class="ma-2" small outlined color="indigo">
            <b-icon-plus></b-icon-plus>
            <span>Add new Image</span>
         </v-btn>
      </div>

   </v-container>
</v-card>

<br>

   <!-- <v-card>
      <v-subheader :inset="false">Keywords</v-subheader>
      <v-container>

         <table class="table">
            <thead>
               <td> Name En </td>
               <td> Name Ar </td>
               <td> Del </td>
            </thead>
            <tbody is="transition-group" name="my-list" id="tbody_add_keyword">
               <tr v-for="(Keyword,index) in Keywords" :key="Keyword.cc" >
                  <td>
                      <v-text-field :label="'Name en '+(index+1)" name="Keywords_en[]" v-model="Keyword.name_en" outlined :rules="requiredRules"></v-text-field>
                  </td>
                  <td>
                      <v-text-field :label="'Name ar '+(index+1)" name="Keywords_ar[]" v-model="Keyword.name_ar" outlined :rules="requiredRules"></v-text-field>
                  </td>
                  <td>
                      <b-icon-trash @click="del_row_keyword(index)" font-scale="1.6" variant="danger" class="pointer"></b-icon-trash>
                  </td>
               </tr>
            </tbody>
         </table>
         <div class="text-right">
            <v-btn @click="add_new_Keyword()" class="ma-2" small outlined color="indigo">
               <b-icon-plus></b-icon-plus>
               <span>Add new keyword</span>
            </v-btn>
         </div>

      </v-container>
   </v-card> -->
   <br>

   <!-- - - - - - -START spinner- - - - - - - -->
   <spinner2 v-if="show_spinner"></spinner2>
   <!-- - - - - - -End spinner- - - - - - - -->

<v-row>
   <v-col>
      <router-link to="/AdsObjectives">
         <v-btn large color="error" width="100%"  >Back</v-btn>
      </router-link>
   </v-col>
   <v-col>
      <v-btn large color="success" width="100%" @click="edit()" :disabled="btn_submit" >Update AdsObjectives</v-btn>
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
    name: 'AdsObjectives-edit',
    components: {spinner2},
     data: () => ({
        Permission: 'AdsObjectives',
        api_update: 'AdsObjectives/AdProduct/update',
        show_spinner:false,
        btn_submit:false,
        Ef: {
           is_main: null,
           provider_id: 1,
           is_available: true,
        },
        Keywords: [],
        images: [ { cc: 1, image:null } ],
        isValid_createForm: true,
        isValid_editForm: true,
        image_main:false,
        CatsBaseAdsObjectives: [],
        providers: [],
        requiredRules: [
          v => (!!v || v == '0' ) || 'field is required',
        ],
        isValid_Form: false
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
                    url: `${Admin_BASE_url}/AdsObjectives/show/${this.$route.params.id}` ,
                    headers: { 'jwt': localStorage.getItem('jwt') },
               })
               .done(function(Response){
                  if(Response.status == 'unValidJWT'){
                     localStorage.removeItem('jwt');
                     this.$router.push('/login');
                  }
                  this.Ef = Response.AdProduct;
                  this.Ef.top_description_en = Response.AdProduct.top_description_en ? Response.AdProduct.top_description_en.replaceAll('\\n','\n') : Response.AdProduct.top_description_en;
                  this.Ef.top_description_ar = Response.AdProduct.top_description_ar ? Response.AdProduct.top_description_ar.replaceAll('\\n','\n') : Response.AdProduct.top_description_ar;
                  this.Ef.description_en = Response.AdProduct.description_en ? Response.AdProduct.description_en.replaceAll('\\n','\n') : Response.AdProduct;
                  this.Ef.description_ar = Response.AdProduct.description_ar ? Response.AdProduct.description_ar.replaceAll('\\n','\n') : Response.AdProduct;
                  this.images = Response.Images;
                  this.Keywords = Response.Keywords;
                  this.show_spinner = false;          this.$forceUpdate();
               }.bind(this))
               .fail(function(data){
                 new Noty({text: 'proplem' , type: 'error'  }).show();
               });
         },
         add_new_image()
         {
            this.images.push({ cc: Math.random(),image:null });
         },
         Preview_image2(e,item)
         {
            item.image = URL.createObjectURL(e);
         },
         Preview_image_banner(e,from_id)
         {
              if(e) {
                 $('#'+from_id).attr('src', URL.createObjectURL(e)) ;
              }
         },
         del_row(index)
         {
            this.images.splice(index,1);
         },
         edit()
         {
               this.$refs.editForm.validate();

               if( this.isValid_Form )
               {
                   this.btn_submit = true;
                   this.show_spinner = true;

                   let my_formData = new FormData($('#edit_form')[0]);
                   for (var key in { ...this.Ef })
                   {
                      if (this.Ef.hasOwnProperty(key)) {
                           my_formData.append(key, this.Ef[key] );
                      }
                   }
                   my_formData.append('is_main',$('input[name="is_main"]:checked').val() );
                   my_formData.append('id', this.$route.params.id );

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
                               this.images = responce.Images;
                               // Ef
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
               else
               {
                   new Noty({ text: 'please continue the missing data' , type: 'warning',timeout: 1500  }).show();
               }
         },
         add_new_Keyword()
         {
            this.Keywords.push({ cc: Math.random() });
         },
         del_row_keyword(index)
         {
            this.Keywords.splice(index,1);
         },
    },//End methods
    computed: {

    }
}//End export default
</script>
