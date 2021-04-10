<style>
  .v-tf_bundle_product_id
  {
    width:70%;
    display: inline-block;
  }
  .img_BProduct
  {
    max-width: 100%;
    max-height: 115px;
  }
</style>
<template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Recipe Create</h2>

     <router-link to="/Recipe"> <span> Recipes </span> </router-link> / <span>Create</span>
     <br><br>

    <!-- ------------------- create ----------------------- - -->

    <v-form  id="create_form" ref="createForm" v-model="isValid_createForm" :lazy-validation="false" >

<v-card>
   <v-subheader :inset="false">Main Info</v-subheader>
   <v-container>
    <v-row>
     <v-col>
          <v-select  outlined v-model="CF.recipes_category_ids" :items="Categories" item-text="label" item-value="value" label="Category" multiple ></v-select>

          <v-text-field label="Name En" v-model="CF.name_en" outlined :rules="[v => !!v || 'field is required']" ></v-text-field>
          <v-text-field label="Name Ar" v-model="CF.name_ar" outlined :rules="requiredRules"></v-text-field>
          <v-text-field label="time En" v-model="CF.time_en" outlined :rules="requiredRules"></v-text-field>
          <v-text-field label="time Ar" v-model="CF.time_ar" outlined :rules="requiredRules"></v-text-field>
          <v-text-field label="servings En" v-model="CF.servings_en" outlined :rules="requiredRules"></v-text-field>
          <v-text-field label="servings Ar" v-model="CF.servings_ar" outlined :rules="requiredRules"></v-text-field>
          <v-text-field label="youtube Embded link (v=) " v-model="CF.youtube_link" outlined  ></v-text-field>
     </v-col>
     <v-col>
           <!-- <div class="div_Preview_image">
              <img  id="Preview_image_create" class="Preview_image" >
              <v-file-input @change="Preview_image_banner($event,'Preview_image_create')" label="Banner" name="banner" prepend-icon="" show-size outlined :rules="requiredRules"></v-file-input>
           </div> -->
          <v-textarea label="Description En" v-model="CF.body_en" name="input-7-4" outlined rows="8" :rules="requiredRules"></v-textarea>
          <v-textarea label="Description Ar" v-model="CF.body_ar" name="input-7-4" outlined rows="8" :rules="requiredRules"></v-textarea>
          <div >
            <iframe width="100%" height="200px" :src="'https://www.youtube.com/embed/'+CF.youtube_link" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
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
         <tbody is="transition-group" name="my-list" id="tbody_add_images">
            <tr v-for="(image,index) in images" :key="image.cc" >
               <td width="40%">
                  <v-file-input @change="Preview_image($event,'Preview_image_create'+index)" name="images[]" :label="'Image '+(1+index)" hint="220*220 Pixels" :persistent-hint="true" prepend-icon="" show-size outlined :rules="requiredRules" ></v-file-input>
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

<br>


 <v-card>
    <v-subheader :inset="false">Ingredients</v-subheader>
    <v-container>

       <table class="table">
          <thead>
             <td> Text </td>
             <td> Add </td>
             <td> Product Name </td>
             <td> Qty </td>
             <td> Del </td>
          </thead>
          <tbody is="transition-group" name="my-list" id="tbody_add_keyword">
             <tr v-for="(Ingredient,index) in Ingredients" :key="Ingredient.cc" >
                <td width="30%">
                    <v-text-field label="Text En" v-model="Ingredient.text_en" outlined :rules="requiredRules" ></v-text-field>
                    <v-text-field label="Text Ar" v-model="Ingredient.text_ar" outlined :rules="requiredRules" ></v-text-field>
                </td>
                <td width="25%">
                    <v-text-field label="product id"  v-model="Ingredient.product_id" @keyup="getProductById(Ingredient)" outlined  class="v-tf_bundle_product_id" style=""></v-text-field>
                    <v-btn @click="getProductById(Ingredient)" height="51" v-b-tooltip.hover.top title="get Product By Id">
                       <b-icon-search @click="getProductById(Ingredient)" font-scale="1.6" ></b-icon-search>
                    </v-btn>
                    <spinner3 v-if="Ingredient.showLoder"></spinner3>
                </td>
                <td width="25%">
                    <p class="green--text"> {{Ingredient.name}} </p>
                </td>
                <td width="12%">
                  <v-text-field label="Quantity" v-model="Ingredient.quantity" :rules="requiredRules" outlined  ></v-text-field>
                </td>
                <td>
                    <b-icon-trash @click="del_row_Ingredient(index)" font-scale="1.6" variant="danger" class="pointer"></b-icon-trash>
                </td>
             </tr>
          </tbody>
       </table>
       <div class="text-right">
          <v-btn @click="add_new_Ingredient()" class="ma-2" small outlined color="indigo">
             <b-icon-plus></b-icon-plus>
             <span>Add new Ingredient</span>
          </v-btn>
       </div>

    </v-container>
 </v-card>

   <!-- - - - - - -START spinner- - - - - - - -->
   <spinner2 v-if="show_spinner"></spinner2>
   <!-- - - - - - -End spinner- - - - - - - -->

<v-row>
   <v-col>
      <router-link to="/Recipe">
         <v-btn large color="error" width="100%"  >Back</v-btn>
      </router-link>
   </v-col>
   <v-col>
      <v-btn large color="success" width="100%" @click="create()" :disabled="btn_submit" >Add Recipe</v-btn>
   </v-col>
</v-row>

</v-form>
<br>
<br>

  </div><!--End page-wrapper-->
</template>

<script>
  import spinner2 from '@/components/spinner2';
  import spinner3 from '@/components/spinner3';

  export default {
    name: 'Recipe-create',
    components: {spinner2,spinner3},
     data: () => ({
        Permission: 'Recipe',
        api_create: 'Recipe/create',
        show_spinner:false,
        btn_submit:false,
        CF: {
           is_main: null,
           old_price: 0,
           discount_percentage: 0,
           recipes_category_ids: []
        },
        images: [ { cc: 1 } ],
        Categories: [],
        isValid_createForm: true,
        isValid_editForm: true,
        image_main:false,
        Ingredients: [ { cc: 1 , product_id:null, text_en: '',quantity:1,text_ar:'', showLoder:false, isIdCorrect:false } ],
        requiredRules: [
          v => (!!v || v == '0' ) || 'field is required',
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
       getProductById(BProduct)
       {
             BProduct.showLoder = true;
             BProduct.name = '';
             BProduct.image = '';
             BProduct.isIdCorrect = false;

             $.ajax({
                 type:"get" ,
                 url: `${Admin_BASE_url}/Bundel/get_Product_By_Id/${BProduct.product_id}` ,
                 headers: { 'jwt': localStorage.getItem('jwt') }
             })
             .done(function(Response){
                if(Response.status == 'unValidJWT'){
                     localStorage.removeItem('jwt');
                     this.$router.push('/login');
                }
                if (Response.status == 'success') {
                   BProduct.name = Response.Product.name;
                   BProduct.image = Response.Product.image;
                   BProduct.isIdCorrect = true;
                }
                else {
                   new Noty({text: Response.status_message , type: 'error' }).show();
                }
                BProduct.showLoder = false;
             }.bind(this))
             .fail(function(data){
                new Noty({text: 'proplem' , type: 'error' }).show();
             });
        },
        getCategories_list()
        {
                $.ajax({
                   type:"get",
                   url: `${Admin_BASE_url}/Recipe/selection_data` ,
                   headers: { 'jwt': localStorage.getItem('jwt') }
                })
               .done(function(Response){
                  if(Response.status == 'unValidJWT'){
                       localStorage.removeItem('jwt');
                       this.$router.push('/login');
                  }
                  this.Categories = Response.RecipesCategories;
                  // this.Categories.unshift({ label:'All ' , value: null });
               }.bind(this))
               .fail(function(data){
                  new Noty({text: 'proplem' , type: 'error'  }).show();
               });
         },
         add_new_Ingredient()
         {
            this.Ingredients.push({ cc: Math.random(), product_id:null, text_en: '',quantity:1,text_ar:'', showLoder:false, isIdCorrect:false });
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
         del_row(index)
         {
            this.images.splice(index,1);
         },
         del_row_Ingredient(index)
         {
            this.Ingredients.splice(index,1);
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


                   let my_formData = new FormData($('#create_form')[0]);
                   for (var key in { ...this.CF })
                   {
                      if (this.CF.hasOwnProperty(key)) {
                           my_formData.append(key, this.CF[key] );
                      }
                   }
                   my_formData.append('is_main',$('input[name="is_main"]:checked').val() );

                   var Ingredients_ids = [];
                   var is_Ingredients_all_correct = true;
                   this.Ingredients.forEach((ingredient, i) => {
                     if(ingredient.product_id)
                     {
                         if(ingredient.isIdCorrect){
                           Ingredients_ids.push(ingredient.product_id)
                         }
                         else {
                           is_Ingredients_all_correct = false;
                         }
                     }
                   });

                   if(!is_Ingredients_all_correct){
                       new Noty({ text: 'all Bundle Products ids must be correct' , type: 'warning',timeout: 1500  }).show();
                       return;
                   }

                   my_formData.append('Ingredients', JSON.stringify(this.Ingredients) );

                   this.btn_submit = true;
                   this.show_spinner = true;

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
                               $('#create_form #tbody_add_images').find('img').prop('src','');

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
         add_new_Keyword()
         {
            this.Keywords.push({ cc: Math.random() });
         },
         del_row_keyword(index)
         {
            this.Keywords.splice(index,1);
         },
    },//End methods
}//End export default
</script>
