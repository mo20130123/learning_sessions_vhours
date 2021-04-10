 <template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Refrence Create</h2>

     <router-link to="/Refrence"> <span> Refrences </span> </router-link> / <span>Create</span>
     <br><br>

    <!-- ------------------- create ----------------------- - -->

    <v-form  id="create_form" ref="createForm" v-model="isValid_createForm" :lazy-validation="false" >

<v-card>
   <v-subheader :inset="false">Main Info</v-subheader>
   <v-container>
    <v-row>
     <v-col>
          <v-autocomplete outlined v-model="CF.category_id" :items="Categories" item-text="label" item-value="value" label="Category" :rules="requiredRules" ></v-autocomplete>

          <v-text-field label="Name En" v-model="CF.name_en" outlined :rules="[v => !!v || 'field is required']" ></v-text-field>
          <v-text-field label="Name Ar" v-model="CF.name_ar" outlined required :rules="requiredRules"></v-text-field>
      </v-col>
     <v-col>
           <!-- <div class="div_Preview_image">
              <img  id="Preview_image_create" class="Preview_image" >
              <v-file-input @change="Preview_image_banner($event,'Preview_image_create')" label="Banner" name="banner" prepend-icon="" show-size outlined :rules="requiredRules"></v-file-input>
           </div> -->

          <v-textarea label="Description En" v-model="CF.description_en" name="input-7-4" outlined rows="5" :rules="requiredRules"></v-textarea>
          <v-textarea label="Description Ar" v-model="CF.description_ar" name="input-7-4" outlined rows="5" :rules="requiredRules"></v-textarea>
      </v-col>
   </v-row>
  </v-container>
</v-card>

<br>

<v-card>
   <v-subheader :inset="false">More Info</v-subheader>
   <v-container>
      <v-row>
       <v-col>
             <v-text-field label="Colour En" v-model="CF.colour_en" outlined required :rules="requiredRules"></v-text-field>
             <v-text-field label="Pile Height En" v-model="CF.pile_height_en" outlined required :rules="requiredRules"></v-text-field>
             <v-text-field label="Stitch Density En" v-model="CF.stitch_density_en" outlined required :rules="requiredRules"></v-text-field>
             <v-text-field label="Machine Gauge En" v-model="CF.machine_gauge_en" outlined required :rules="requiredRules"></v-text-field>
        </v-col>
       <v-col>
             <v-text-field label="Colour Ar" v-model="CF.colour_ar" outlined required :rules="requiredRules"></v-text-field>
             <v-text-field label="Pile Height Ar" v-model="CF.pile_height_ar" outlined required :rules="requiredRules"></v-text-field>
             <v-text-field label="Stitch Density Ar" v-model="CF.stitch_density_ar" outlined required :rules="requiredRules"></v-text-field>
             <v-text-field label="Machine Gauge Ar" v-model="CF.machine_gauge_ar" outlined required :rules="requiredRules"></v-text-field>
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
         <tbody>
            <tr v-for="(image,index) in images" :key="image.cc" >
               <td width="40%">
                  <v-file-input @change="Preview_image($event,'Preview_image_create'+index)" name="images[]" :label="'Image '+(1+index)" hint="925*541 Pixels" persistent-hint="true" prepend-icon="" show-size outlined :rules="requiredRules" ></v-file-input>
               </td>
               <td width="30%"> <img :id="'Preview_image_create'+index"  > </td>
               <td>
                   <input type="radio" name="is_main" :value="index" :rules="requiredRules"  /> {{ 1+index}}
               </td>
               <td>
                  <b-icon-trash @click="del_row(index)" font-scale="1.6" variant="danger" class="pointer"></b-icon-trash>
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

   <!-- - - - - - -START spinner- - - - - - - -->
   <spinner2 v-if="show_spinner"></spinner2>
   <!-- - - - - - -End spinner- - - - - - - -->

<v-row>
   <v-col>
      <router-link to="/Refrence">
         <v-btn large color="error" width="100%"   >Back</v-btn>
      </router-link>
   </v-col>
   <v-col>
      <v-btn   large color="success" width="100%" @click="create()" :disabled="btn_submit" >Add Refrence</v-btn>
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
    name: 'Refrence-create',
    components: {spinner2},
     data: () => ({
        Permission: 'Refrence',
        api_create: 'Refrence/create',
        show_spinner:false,
        btn_submit:false,
        CF: { is_main: null },
        images: [ { cc: 1 } ],
        isValid_createForm: true,
        isValid_editForm: true,
        image_main:false,
        Categories: [],
        requiredRules: [
          v => !!v || 'field is required',
        ],
    }),//end data
    created(){
      if(!localStorage.getItem('jwt')){
         this.$router.push('/login');
      }
      this.check_Permission(this.Permission);
      this.getCategories_list();
    },
    methods:{
         getCategories_list()
         {
               $.ajax({
                  type:"get" ,
                  url: `${Admin_BASE_url}/Refrence/get_Categories` ,
                  headers: { 'jwt': localStorage.getItem('jwt') }
              })
              .done(function(Response){
                 if(Response.status == 'unValidJWT'){
                      localStorage.removeItem('jwt');
                      this.$router.push('/login');
                 }
                 this.Categories = Response;
              }.bind(this))
              .fail(function(data){
                 new Noty({text: 'proplem' , type: 'error' }).show();
              });
         },
         add_new_image()
         {
            this.images.push({ cc: Math.random() });
         },
         Preview_image(e,from_id)
         {
              if(e) {
                 $('#'+from_id).attr('src', URL.createObjectURL(e))
                               .css(
                                  { "max-width": '150px' },
                                  { "max-height": '150px' },
                               );
              }
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
         create()
         {
               this.$refs.createForm.validate();

               if( this.isValid_createForm )
               {
                  if(!$('input[name="is_main"]:checked').val()){
                     new Noty({ text: 'choose a Main Image' , type: 'warning',timeout: 1500  }).show();
                     return ;
                  }
                   this.btn_submit = true;
                   this.show_spinner = true;

                   let my_formData = new FormData($('#create_form')[0]);
                   for (var key in { ...this.CF })
                   {
                      if (this.CF.hasOwnProperty(key)) {
                           my_formData.append(key, this.CF[key] );
                      }
                   }
                   my_formData.append('is_main',$('input[name="is_main"]:checked').val() );

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
                               new Noty({ text: 'Content has created', type: 'success',timeout: 1500  }).show();
                               $('#create_form').find('img').prop('src','');

                               this.$refs.createForm.reset();
                               this.$refs.createForm.resetValidation();
                               this.images = [ { cc: 1 } ];
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
    computed: {

    }
}//End export default
</script>
