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

     <h2 class="font-italic font-weight-light font-weight-bold">Bundel Create</h2>

     <router-link to="/Bundel"> <span> Bundels </span> </router-link> / <span>Create</span>
     <br><br>

    <!-- ------------------- create ----------------------- - -->

    <v-form  id="create_form" ref="createForm" v-model="isValid_createForm" :lazy-validation="false" >

<v-card>
   <v-subheader :inset="false">Main Info</v-subheader>
   <v-container>
    <v-row>
     <v-col>
          <v-text-field label="Name En" v-model="CF.name_en" outlined :rules="[v => !!v || 'field is required']" ></v-text-field>
          <v-text-field label="Name Ar" v-model="CF.name_ar" outlined :rules="requiredRules"></v-text-field>
          <v-text-field label="Bundle Label En" v-model="CF.bundle_summary_en" outlined :rules="requiredRules"></v-text-field>
          <v-text-field label="Bundle Label Ar" v-model="CF.bundle_summary_ar" outlined :rules="requiredRules"></v-text-field>
          <v-text-field label="Quantity in Stock :" type="number" v-model="CF.quantity" outlined :rules="requiredRules"></v-text-field>
          <v-text-field label="SAP code :" v-model="CF.sap_code" outlined    ></v-text-field>
          <v-text-field label="Main Price (EGP):" v-model="CF.price" type="number" outlined :rules="requiredRules"></v-text-field>
        </v-col>
     <v-col>
           <!-- <div class="div_Preview_image">
              <img  id="Preview_image_create" class="Preview_image" >
              <v-file-input @change="Preview_image_banner($event,'Preview_image_create')" label="Banner" name="banner" prepend-icon="" show-size outlined :rules="requiredRules"></v-file-input>
           </div> -->
          <v-text-field label="Short Description En" v-model="CF.short_description_en" outlined :rules="requiredRules"></v-text-field>
          <v-text-field label="Short Description Ar" v-model="CF.short_description_ar" outlined :rules="requiredRules"></v-text-field>

          <v-textarea label="Description En" v-model="CF.description_en" name="input-7-4" outlined rows="5" :rules="requiredRules"></v-textarea>
          <v-textarea label="Description Ar" v-model="CF.description_ar" name="input-7-4" outlined rows="5" :rules="requiredRules"></v-textarea>
      </v-col>
   </v-row>
  </v-container>
</v-card>

<br>


 <v-card>
    <v-subheader :inset="false">Bundle products</v-subheader>
    <v-container>

       <table class="table">
          <thead>
             <td> Image </td>
             <td> Name </td>
             <td> Add </td>
             <td> Del </td>
          </thead>
          <tbody is="transition-group" name="my-list" id="tbody_add_keyword">
             <tr v-for="(BProduct,index) in BundleProducts" :key="BProduct.cc" >
                <td>
                  <img :src="BProduct.image" class="img_BProduct" >
                </td>
                <td>
                    <p> {{BProduct.name}} </p>
                </td>
                <td width="25%">
                    <v-text-field label="product id"  v-model="BProduct.product_id" outlined :rules="requiredRules" class="v-tf_bundle_product_id" style=""></v-text-field>
                    <v-btn @click="getProductById(BProduct)" height="51" v-b-tooltip.hover.top title="get Product By Id">
                       <b-icon-search @click="getProductById(BProduct)" font-scale="1.6" ></b-icon-search>
                    </v-btn>
                    <spinner3 v-if="BProduct.showLoder"></spinner3>
                </td>
                <td>
                    <b-icon-trash v-if="index!=0" @click="del_row_BundleProduct(index)" font-scale="1.6" variant="danger" class="pointer"></b-icon-trash>
                </td>
             </tr>
          </tbody>
       </table>
       <div class="text-right">
          <v-btn @click="add_new_BundleProduct()" class="ma-2" small outlined color="indigo">
             <b-icon-plus></b-icon-plus>
             <span>Add new product</span>
          </v-btn>
       </div>

    </v-container>
 </v-card>

 <br>

 <v-card>
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
                    <v-text-field :label="'Name en '+(index+1)" name="Keywords_en[]" v-model="Keyword.name_en" outlined required :rules="requiredRules"></v-text-field>
                </td>
                <td>
                    <v-text-field :label="'Name ar '+(index+1)" name="Keywords_ar[]" v-model="Keyword.name_ar" outlined required :rules="requiredRules"></v-text-field>
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
 </v-card>
   <br>


<v-row>
   <v-col>
      <router-link to="/Bundel">
         <v-btn large color="error" width="100%"  >Back</v-btn>
      </router-link>
   </v-col>
   <v-col>
      <v-btn large color="success" width="100%" @click="create()" :disabled="btn_submit" >Add Bundel</v-btn>
   </v-col>
</v-row>

</v-form>
<br>

  </div><!--End page-wrapper-->
</template>

<script>
  import spinner3 from '@/components/spinner3';

  export default {
    name: 'Bundel-create',
    components: {spinner3},
     data: () => ({
        Permission: 'Bundel',
        api_create: 'Bundel/create',
        show_spinner:false,
        btn_submit:false,
        CF: {
           is_main: null,
           old_price: 0,
           discount_percentage: 0,
        },
        Keywords: [],
        BundleProducts: [ { cc: 1 , product_id:null, name: '', image:'', showLoder:false , isIdCorrect:false } ],
        isValid_createForm: true,
        isValid_editForm: true,
        image_main:false,
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
         add_new_BundleProduct()
         {
            this.BundleProducts.push({ cc: Math.random(), product_id:null, name: '', image:'', showLoder:false, isIdCorrect:false });
         },
         del_row(index)
         {
            this.images.splice(index,1);
         },
         del_row_BundleProduct(index)
         {
            this.BundleProducts.splice(index,1);
         },
         create()
         {
               this.$refs.createForm.validate();

               if( this.isValid_createForm )
               {
                   let my_formData = new FormData($('#create_form')[0]);
                   for (var key in { ...this.CF })
                   {
                      if (this.CF.hasOwnProperty(key)) {
                           my_formData.append(key, this.CF[key] );
                      }
                   }
                   var BundleProducts_ids = [];
                   var is_BundleProducts_all_correct = true;
                   this.BundleProducts.forEach((BProduct, i) => {
                       if(BProduct.isIdCorrect){
                           BundleProducts_ids.push(BProduct.product_id)
                       }
                       else {
                         is_BundleProducts_all_correct = false;
                       }
                   });

                   if(!is_BundleProducts_all_correct){
                       new Noty({ text: 'all Bundle Products ids must be correct' , type: 'warning',timeout: 1500  }).show();
                       return;
                   }

                   my_formData.append('bundle_products_ids', BundleProducts_ids.toString() );

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

                               this.BundleProducts = [ { cc: 1,product_id:null,name:'',image:'',showLoder:false,isIdCorrect:false } ];

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
