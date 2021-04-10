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

     <h2 class="font-italic font-weight-light font-weight-bold">Categories Edit</h2>

     <router-link to="/CategoriesSubCategories"> <span> Categories </span> </router-link> / <span>Edit</span>
     <br><br>

    <!-- ------------------- Edit ----------------------- - -->

    <v-form  id="edit_form" ref="editForm" v-model="isValid_Form" :lazy-validation="false" >

<v-card>
   <v-subheader :inset="false">Main Info</v-subheader>
   <v-container>
    <v-row>
      <v-col>
           <v-text-field label="Name En" v-model="Ef.name_en" outlined :rules="[v => !!v || 'field is required']" ></v-text-field>
           <v-text-field label="Name Ar" v-model="Ef.name_ar" outlined required :rules="requiredRules"></v-text-field>

           <img :src="Ef.icon" id="Preview_image_edit" class="Preview_image_small" >
           <v-file-input @change="Preview_image($event,'Preview_image_edit')" label="Mobile icon" name="icon" hint="55*55 Pixels" :persistent-hint="true" prepend-icon="" show-size outlined ></v-file-input>
      </v-col>
      <v-col>
        <div class="div_Preview_image">
           <v-file-input @change="Preview_image($event,'Preview_image_create_en')" name="banner_en" label="Banner En" hint="1513*372 Pixels" :persistent-hint="true" prepend-icon="" show-size outlined ></v-file-input>
           <img :src="Ef.banner_en" id="Preview_image_create_en" class="sub_img" >

           <v-file-input @change="Preview_image($event,'Preview_image_create_ar')" name="banner_ar" label="Banner Ar" hint="1513*372 Pixels" :persistent-hint="true" prepend-icon="" show-size outlined ></v-file-input>
           <img :src="Ef.banner_ar" id="Preview_image_create_ar" class="sub_img" >
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
                <input type="hidden" name="old_Banner_ids[]" v-model="Banner.id">
                 <v-file-input @change="Preview_image_banner($event,Banner,'en','Preview_banners_en'+index)" name="Banners_image_en[]" :label="'banner image en '+(1+index)" hint="810*204 Pixels"
                               :persistent-hint="true" prepend-icon="" show-size outlined   ></v-file-input>
                 <img :id="'Preview_banners_en'+index" :src="Banner.image_en" class="sub_img"  >
              </td>
              <td width="35%">
                 <v-file-input @change="Preview_image_banner($event,Banner,'ar','Preview_banners_ar'+index)" name="Banners_image_ar[]" :label="'banner image ar '+(1+index)" hint="810*204 Pixels"
                               :persistent-hint="true" prepend-icon="" show-size outlined   ></v-file-input>
                 <img :id="'Preview_banners_ar'+index" :src="Banner.image_ar" class="sub_img" >
              </td>
              <td>
                 <v-text-field label="banner seo name" name="Banners_name[]" v-model="Banner.name" outlined :rules="requiredRules" ></v-text-field>
                  <v-text-field label="banner link" name="Banners_link[]" v-model="Banner.link" outlined ></v-text-field>
              </td>
              <td>
                 <b-icon-trash @click="del_banner_row(index,Banner)" font-scale="1.6" variant="danger" class="pointer"></b-icon-trash>
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
                     <input type="hidden" :value="Sub.id">
                       <!-- <input type="hidden" name="old_cats_ids[]" v-if="Sub.id" :value="Sub.id">
                       <input type="hidden" name="cats_no[]" :value="index"> -->

                   <!-- <input type="hidden" name="old_images_ids[]" v-model="Sub.id"> -->
                   <v-text-field :label="'sub '+(1+index)+' En'" v-model="Sub.name_en" outlined required :rules="requiredRules"></v-text-field>
                   <!-- <v-file-input @change="Preview_image_banner($event,'Preview_image_edit_en'+index)" :label="'Image En '+(1+index)" hint="1740*700 Pixels" :persistent-hint="true" prepend-icon="" show-size outlined   ></v-file-input>
                   <img :id="'Preview_image_edit_en'+index" :src="Sub.banner_en" class="sub_img" > -->
               </td>
               <td width="45%">
                   <v-text-field :label="'sub '+(1+index)+' Ar'" v-model="Sub.name_ar" outlined required :rules="requiredRules"></v-text-field>
                   <!-- <v-file-input @change="Preview_image_banner($event,'Preview_image_edit_ar'+index)" :label="'Image Ar '+(1+index)" hint="1740*700 Pixels" :persistent-hint="true" prepend-icon="" show-size outlined   ></v-file-input>
                   <img :id="'Preview_image_edit_ar'+index" :src="Sub.banner_ar" class="sub_img" > -->
               </td>

               <td>
                 <v-btn @click="del_row(index,Sub)">
                   <b-icon-trash  font-scale="1.6" variant="danger" class="pointer"></b-icon-trash>
                 </v-btn>
                 <router-link v-if="Sub.id" :to="'/CategoriesSubCategories/sortProducts/'+Sub.id" target="_blank" v-b-tooltip.hover.top title="Sort Products">
                 <v-btn  style="margin-top:10px;">
                     <b-icon-filter font-scale="1.6" color="black" ></b-icon-filter>
                 </v-btn>
               </router-link>
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
         <v-btn large color="error" width="100%" >Back</v-btn>
      </router-link>
   </v-col>
   <v-col>
      <v-btn large color="success" width="100%" @click="edit()" :disabled="btn_submit" >Update Category</v-btn>
   </v-col>
</v-row>

</v-form>
<br>
<br>

  </div><!--End page-wrapper-->
</template>

<script>
  import spinner2 from '@/components/spinner2';
  import Swal from 'sweetalert2'

  export default {
    name: 'CategoriesSubCategories-edit',
    components: {spinner2},
     data: () => ({
        Permission: 'CategoriesSubCategories',
        api_update: 'CategoriesSubCategories/update',
        show_spinner:false,
        btn_submit:false,
        Ef: { is_main: null },
        Banners: [ { cc: 1 } ],
        Subs: [ { cc: 1 } ],
        isValid_Form: true,
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
      this.getResults();
    },
    methods:{
         getResults(){

              this.show_spinner = true;
              $.ajax({
                    type:"get",
                    url: `${Admin_BASE_url}/CategoriesSubCategories/show/${this.$route.params.id}` ,
                    headers: { 'jwt': localStorage.getItem('jwt') },
               })
               .done(function(Response){
                  if(Response.status == 'unValidJWT'){
                     localStorage.removeItem('jwt');
                     this.$router.push('/login');
                  }
                  this.Ef = Response.Category;
                  this.Subs = Response.SubCategory;
                  this.Banners = Response.CategoryBanners;
                  this.show_spinner = false;
               }.bind(this))
               .fail(function(data){
                 new Noty({text: 'proplem' , type: 'error'  }).show();
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
         Preview_imagee(e,image)
         {
              if(e) {
                $('#'+image).attr('src', URL.createObjectURL(e)) ;
                 // this.Ef.icon = URL.createObjectURL(e);
              }
         },
         Preview_image_banner(e,Banner,lang,from_id)
         {
            $('#'+from_id).attr('src', URL.createObjectURL(e)) ;
            switch (lang)
            {
              case 'en':
                  Banner.image_en = URL.createObjectURL(e);
                break;
              case 'ar':
                  Banner.image_ar = URL.createObjectURL(e);
                break;
            }
         },
         del_row(index,item)
         {
            if(item.id)
            {
                 Swal.fire({
                   title: `you wanna delete (${item.name_en}) ?`,
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
                             url: `${Admin_BASE_url}/CategoriesSubCategories/DestroySubCategoiry/${item.id}` ,
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
                             Swal.fire("Deleted!", "  ", "success");
                             this.Subs.splice(index,1);
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
            else
              this.Subs.splice(index,1);
         },
         del_banner_row(index,item)
         {
              if(item.id)
              {
                   Swal.fire({
                     title: `you wanna delete (${item.name_en}) ?`,
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
                               url: `${Admin_BASE_url}/CategoriesSubCategories/DestroyBanner/${item.id}` ,
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
                               Swal.fire("Deleted!", "  ", "success");
                               this.Banners.splice(index,1);
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
              else
                this.Banners.splice(index,1);
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
                    my_formData.append('id', this.$route.params.id );
                    my_formData.append('Subs',JSON.stringify(this.Subs) );

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
                               this.Subs = responce.SubCategory;
                               this.Banners = responce.CategoryBanners;
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
