<style scoped>
  .sub_img{
      border: 1px dashed black;
      max-height: 140px;width:auto;
      max-width: 100%;
      display: table;
      margin: 0 auto;
  }
</style>
 <template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Categories Create</h2>

     <router-link to="/CategoriesSubCategories"> <span> Categories </span> </router-link> / <span>Create</span>
     <br><br>

    <!-- ------------------- create ----------------------- - -->

    <v-form  id="create_form" ref="createForm" v-model="isValid_createForm" :lazy-validation="false" >

<v-card>
   <v-subheader :inset="false">Main Info</v-subheader>
   <v-container>
    <v-row>
     <v-col>

          <v-text-field label="Name En" v-model="CF.name_en" outlined :rules="[v => !!v || 'field is required']" ></v-text-field>
          <v-text-field label="Name Ar" v-model="CF.name_ar" outlined required :rules="requiredRules"></v-text-field>

          <img id="Preview_image_create" class="Preview_image_small" >
          <v-file-input @change="Preview_image($event,'Preview_image_create')" label="Mobile icon" name="icon" hint="55*55 Pixels" :persistent-hint="true" prepend-icon="" show-size outlined ></v-file-input>
      </v-col>
      <v-col>
       <div class="div_Preview_image">

          <v-file-input @change="Preview_image($event,'Preview_image_create_en')" name="banner_en" label="Banner En" hint="1513*372 Pixels" :persistent-hint="true" prepend-icon="" show-size outlined :rules="requiredRules" ></v-file-input>
          <img id="Preview_image_create_en" class="sub_img" >

          <v-file-input @change="Preview_image($event,'Preview_image_create_ar')" name="banner_ar" label="Banner Ar" hint="1513*372 Pixels" :persistent-hint="true" prepend-icon="" show-size outlined :rules="requiredRules" ></v-file-input>
          <img id="Preview_image_create_ar" class="sub_img" >
       </div>
      </v-col>
   </v-row>
  </v-container>
</v-card>
  <br>

<v-card>
  <v-subheader :inset="false">Category banners</v-subheader>
  <v-container>

     <table class="table">
        <thead>
           <td> banner En </td>
           <td> banner Ar </td>
           <td> Info </td>
           <td> Del </td>
        </thead>
        <tbody is="transition-group" name="my-list" id="tbody_add_images">
           <tr v-for="(Banner,index) in Banners" :key="Banner.cc" >
              <td width="35%">
                 <v-file-input @change="Preview_image($event,'Preview_banners_en'+index)" name="Banners_image_en[]" :label="'banner image en '+(1+index)" hint="810*204 Pixels"
                               :persistent-hint="true" prepend-icon="" show-size outlined :rules="requiredRules" ></v-file-input>
                 <img :id="'Preview_banners_en'+index" class="sub_img"  >
              </td>
              <td width="35%">
                 <v-file-input @change="Preview_image($event,'Preview_banners_ar'+index)" name="Banners_image_ar[]" :label="'banner image ar '+(1+index)" hint="810*204 Pixels"
                               :persistent-hint="true" prepend-icon="" show-size outlined :rules="requiredRules" ></v-file-input>
                 <img :id="'Preview_banners_ar'+index" class="sub_img" >
              </td>
              <td>
                 <v-text-field label="banner seo name" name="Banners_name[]" v-model="Banner.name" outlined :rules="requiredRules" ></v-text-field>
                  <v-text-field label="banner link" name="Banners_link[]" v-model="Banner.link" outlined ></v-text-field>
              </td>
              <td>
                 <b-icon-trash @click="del_banner_row(index)" font-scale="1.6" variant="danger" class="pointer"></b-icon-trash>
              </td>
           </tr>
        </tbody>
     </table>
     <div class="text-right">
        <v-btn @click="add_new_Banner()" class="ma-2" small outlined color="indigo">
           <b-icon-plus></b-icon-plus>
           <span>Add new Banner</span>
        </v-btn>
     </div>

  </v-container>
</v-card>

<br>

<v-card>
   <v-subheader :inset="false">Add Sub Categories</v-subheader>
   <v-container>

      <table class="table">
         <thead>
            <td> Sub En </td>
            <td> Sub Ar </td>
            <td> Del </td>
         </thead>
         <tbody>
            <tr v-for="(Sub,index) in Subs" :key="Sub.cc" >
               <td width="45%">
                   <v-text-field :label="'sub '+(1+index)+' En'" v-model="Sub.name_en" outlined required :rules="requiredRules"></v-text-field>
               </td>
               <td width="45%">
                   <v-text-field :label="'sub '+(1+index)+' Ar'" v-model="Sub.name_ar" outlined required :rules="requiredRules"></v-text-field>
               </td>
               <td>
                   <b-icon-trash @click="del_row(index)" font-scale="1.6" variant="danger" class="pointer"></b-icon-trash>
               </td>
            </tr>
         </tbody>
      </table>
      <div class="text-right">
         <v-btn @click="add_new_sub()" class="ma-2" small outlined color="indigo">
            <b-icon-plus></b-icon-plus>
            <span>Add new Sub</span>
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
      <router-link to="/CategoriesSubCategories">
         <v-btn large color="error" width="100%"  >Back</v-btn>
      </router-link>
   </v-col>
   <v-col>
      <v-btn large color="success" width="100%" @click="create()" :disabled="btn_submit" >Add Category </v-btn>
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
    name: 'CategoriesSubCategories-create',
    components: {spinner2},
     data: () => ({
        Permission: 'CategoriesSubCategories',
        api_create: 'CategoriesSubCategories/create',
        show_spinner:false,
        btn_submit:false,
        CF: { },
        Banners: [ { cc: 1 } ],
        Subs: [ { cc: 1 } ],
        isValid_createForm: true,
        isValid_editForm: true,
        image_main:false,
        CatsSubCats: [],
        requiredRules: [
          v => !!v || 'field is required',
        ],
    }),//end data
    created(){
      if(!localStorage.getItem('jwt')){
         this.$router.push('/login');
      }
      this.check_Permission(this.Permission);
      // this.getCategories_list();
    },
    methods:{
         getCategories_list()
         {
               $.ajax({
                  type:"get" ,
                  url: `${Admin_BASE_url}/CategoriesSubCategories/Categories_SubCategories` ,
                  headers: { 'jwt': localStorage.getItem('jwt') }
              })
              .done(function(Response){
                 if(Response.status == 'unValidJWT'){
                      localStorage.removeItem('jwt');
                      this.$router.push('/login');
                 }
                 this.CatsSubCats = Response;
              }.bind(this))
              .fail(function(data){
                 new Noty({text: 'proplem' , type: 'error' }).show();
              });
         },
         add_new_sub()
         {
            this.Subs.push({ cc: Math.random() });
         },
         add_new_Banner()
         {
            this.Banners.push({ cc: Math.random() });
         },
         Preview_image(e,from_id)
         {
              if(e) {
                 $('#'+from_id).attr('src', URL.createObjectURL(e)) ;
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
            this.Subs.splice(index,1);
         },
         del_banner_row(index)
         {
            this.Banners.splice(index,1);
         },
         create()
         {
               this.$refs.createForm.validate();

               if( this.isValid_createForm )
               {
                   this.btn_submit = true;
                   this.show_spinner = true;

                   let my_formData = new FormData($('#create_form')[0]);
                   for (var key in { ...this.CF })
                   {
                      if (this.CF.hasOwnProperty(key)) {
                           my_formData.append(key, this.CF[key] );
                      }
                   }
                    my_formData.append('Subs',JSON.stringify(this.Subs) );

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
                               this.Subs = [ { cc: 1 } ];
                               this.Banners = [ { cc: 1 } ];
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
