 <style scoped>
    .centered-input >>> input {
      text-align: center
    }
</style>
 <template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Product Edit</h2>

     <router-link to="/Product"> <span> Products </span> </router-link> / <span>Edit</span>
     <br><br>

    <!-- ------------------- Edit ----------------------- - -->

    <v-form  id="edit_form" ref="editForm" v-model="isValid_Form" :lazy-validation="false" >

<v-card>
   <v-subheader :inset="false">Main Info</v-subheader>
   <v-container>
    <v-row>
     <v-col>
          <v-autocomplete outlined v-model="CF.category_id" :items="CatsBaseProduct" item-text="label" item-value="value" label="Category" :rules="requiredRules" ></v-autocomplete>
          <v-select outlined v-model="CF.base_product_id" :items="BaseProducts" item-text="label" item-value="value" label="Base Product" :rules="requiredRules" ></v-select>
          <v-select outlined v-model="CF.provider_id" :items="providers" item-text="label" item-value="value" label="Provider" :rules="requiredRules" ></v-select>

          <v-text-field label="Name En" v-model="CF.name_en" outlined :rules="requiredRules" ></v-text-field>
          <v-text-field label="Name Ar" v-model="CF.name_ar" outlined :rules="requiredRules"></v-text-field>


          <v-text-field label="youtube Embded link (v=) " v-model="CF.youtube_link" outlined  ></v-text-field>

          <div >
            <iframe width="100%" height="200px" :src="'https://www.youtube.com/embed/'+CF.youtube_link" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>

           <v-row>
               <v-col>
                    <v-switch v-model="CF.is_available" label="is available" color="success" hide-details ></v-switch>
               </v-col>
               <v-col>
                    <v-switch v-model="CF.is_bundle" label="is bundle" color="success" hide-details ></v-switch>
               </v-col>
            </v-row>

       </v-col>
     <v-col>
           <!-- <div class="div_Preview_image">
              <img  id="Preview_image_create" class="Preview_image" >
              <v-file-input @change="Preview_image_banner($event,'Preview_image_create')" label="Banner" name="banner" prepend-icon="" show-size outlined :rules="requiredRules"></v-file-input>
           </div> -->

          <v-textarea label="Short Description En" v-model="CF.short_description_en" name="input-7-4" outlined rows="2" :rules="requiredRules"></v-textarea>
          <v-textarea label="Short Description Ar" v-model="CF.short_description_ar" name="input-7-4" outlined rows="2" :rules="requiredRules"></v-textarea>


          <v-text-field label="Offer %" type="number" v-model="CF.offer_percentage" outlined :rules="requiredRules"></v-text-field>

          <v-textarea label="Description En" v-model="CF.description_en" name="input-7-4" outlined rows="9" :rules="requiredRules"></v-textarea>
          <v-textarea label="Description Ar" v-model="CF.description_ar" name="input-7-4" outlined rows="9" :rules="requiredRules"></v-textarea>
      </v-col>
   </v-row>
  </v-container>
</v-card>

<br>
  <h1> Requirements </h1>
<v-row>
    <v-col>
        <v-card>
            <v-subheader :inset="false">Requirements En</v-subheader>
            <v-container>
                    <div v-for="(requirement,index) in CF.requirements_en">
                        <v-text-field :label="'requirement En '+(1+index)" type="text" v-model="requirement.requirement" outlined :rules="requiredRules" style="width:85%;display:inline-block;" ></v-text-field>
                        <v-btn fab small class="mx-2" outlined @click="del_Requirement_en(index)">
                             <b-icon-trash font-scale="1.6" variant="danger" class="pointer"></b-icon-trash>
                        </v-btn>
                    </div>

                    <div class="text-right">
                        <v-btn @click="add_Requirement_en()" class="ma-2" small outlined color="indigo">
                            <b-icon-plus></b-icon-plus>
                            <span>Add new Requirement</span>
                        </v-btn>
                    </div>

            </v-container>
        </v-card>
    </v-col>
    <v-col>
        <v-card>
            <v-subheader :inset="false">Requirements Ar</v-subheader>
            <v-container>
                    <div v-for="(requirement,index) in CF.requirements_ar">
                        <v-text-field :label="'requirement Ar '+(1+index)" type="text" v-model="requirement.requirement" outlined :rules="requiredRules" style="width:85%;display:inline-block;" ></v-text-field>
                        <v-btn fab small class="mx-2" outlined @click="del_Requirement_ar(index)">
                             <b-icon-trash font-scale="1.6" variant="danger" class="pointer"></b-icon-trash>
                        </v-btn>
                    </div>

                    <div class="text-right">
                        <v-btn @click="add_Requirement_ar()" class="ma-2" small outlined color="indigo">
                            <b-icon-plus></b-icon-plus>
                            <span>Add new Requirement</span>
                        </v-btn>
                    </div>

            </v-container>
        </v-card>
    </v-col>
</v-row>

<br>

  <div v-if="!CF.is_bundle"> <!--START Pakages wrapper-->

    <h1 class="text-center"> Pakages </h1>
                          <br>
    <h3>
        Basic Pakage
        <v-switch v-model="CF.have_BasicPakage" color="success" hide-details style="display: inline-block;" ></v-switch>
    </h3>
 <v-row v-if="CF.have_BasicPakage" >
     <v-col cols="3">
          <v-card  class="mx-auto" max-width="344" >
                <v-card-text>
                    <p class="display-1 text--primary">  Main  </p>
                    <div class="text--primary">
                            <table>
                              <tr>
                                    <td> Price </td>
                                    <td>
                                      <v-text-field   type="number" v-model="CF.Basic.price" name="Pakage_Basic_price" :rules="requiredRules" class="centered-input"   ></v-text-field>
                                    </td>
                                    <td> Egp </td>
                              </tr>
                              <tr>
                                    <td> Days </td>
                                    <td>
                                      <v-text-field   type="number" v-model="CF.Basic.days" name="Pakage_Basic_day" :rules="requiredRules" class="centered-input"  ></v-text-field>
                                    </td>
                                    <td> day </td>
                              </tr>
                              <tr>
                                    <td> Modifications </td>
                                    <td>
                                      <v-text-field   type="number" v-model="CF.Basic.modifications" name="Pakage_Basic_modification" :rules="requiredRules" class="centered-input"  ></v-text-field>
                                    </td>
                                    <td> mod  </td>
                              </tr>
                            </table>

                     </div>
                </v-card-text>
            </v-card>
     </v-col>
     <v-col>
          <v-card  class="mx-auto"   >
                <v-card-text>
                    <p class="display-1 text--primary">  Items En </p>
                    <div class="text--primary">

                            <div v-for="(Pakag,index) in CF.Pakage_Basic_items_en">
                                <v-text-field :label="'item En '+(1+index)" type="text" v-model="Pakag.item" outlined :rules="requiredRules" style="width:80%;display:inline-block;" ></v-text-field>
                                <v-btn fab small class="mx-2" outlined @click="del_Pakage_Basic_items_en(index)">
                                    <b-icon-trash font-scale="1.6" variant="danger" class="pointer"></b-icon-trash>
                                </v-btn>
                            </div>

                            <div class="text-right">
                                <v-btn @click="add_Pakage_Basic_items_en()" class="ma-2" small outlined color="indigo">
                                    <b-icon-plus></b-icon-plus>
                                    <span>Add new item </span>
                                </v-btn>
                            </div>
                    </div>
                </v-card-text>
            </v-card>
     </v-col>
     <v-col>
          <v-card  class="mx-auto"  >
                <v-card-text>
                    <p class="display-1 text--primary"> Items Ar </p>
                    <div class="text--primary">

                            <div v-for="(descrip,index) in CF.Pakage_Basic_items_ar">
                                <v-text-field :label="'item Ar '+(1+index)" type="text" v-model="descrip.item" outlined :rules="requiredRules" style="width:80%;display:inline-block;" ></v-text-field>
                                <v-btn fab small class="mx-2" outlined @click="del_Pakage_Basic_items_ar(index)">
                                    <b-icon-trash font-scale="1.6" variant="danger" class="pointer"></b-icon-trash>
                                </v-btn>
                            </div>

                            <div class="text-right">
                                <v-btn @click="add_Pakage_Basic_items_ar()" class="ma-2" small outlined color="indigo">
                                    <b-icon-plus></b-icon-plus>
                                    <span>Add new item </span>
                                </v-btn>
                            </div>
                    </div>
                </v-card-text>
            </v-card>
     </v-col>
   </v-row>

        <br>
  <h3>
      Standard Pakage
      <v-switch v-model="CF.have_StandardPakage" color="success" hide-details style="display: inline-block;"></v-switch>
  </h3>
 <v-row v-if="CF.have_StandardPakage">
     <v-col cols="3">
          <v-card  class="mx-auto" max-width="344" >
                <v-card-text>
                    <p class="display-1 text--primary">  Main  </p>
                    <div class="text--primary">
                            <table>
                              <tr>
                                    <td> Price </td>
                                    <td>
                                      <v-text-field   type="number" v-model="CF.Standard.price" name="Pakage_Standard_price" :rules="requiredRules" class="centered-input"   ></v-text-field>
                                    </td>
                                    <td> Egp </td>
                              </tr>
                              <tr>
                                    <td> Days </td>
                                    <td>
                                      <v-text-field   type="number" v-model="CF.Standard.days" name="Pakage_Standard_day" :rules="requiredRules" class="centered-input"  ></v-text-field>
                                    </td>
                                    <td> day </td>
                              </tr>
                              <tr>
                                    <td> Modifications </td>
                                    <td>
                                      <v-text-field   type="number" v-model="CF.Standard.modifications" name="Pakage_Standard_modification" :rules="requiredRules" class="centered-input"  ></v-text-field>
                                    </td>
                                    <td> mod  </td>
                              </tr>
                            </table>

                     </div>
                </v-card-text>
            </v-card>
     </v-col>
     <v-col>
          <v-card  class="mx-auto"   >
                <v-card-text>
                    <p class="display-1 text--primary"> Items En </p>
                    <div class="text--primary">

                            <div v-for="(Pakag,index) in CF.Pakage_Standard_items_en">
                                <v-text-field :label="'item En '+(1+index)" type="text" v-model="Pakag.item" outlined :rules="requiredRules" style="width:80%;display:inline-block;" ></v-text-field>
                                <v-btn fab small class="mx-2" outlined @click="del_Pakage_Standard_items_en(index)">
                                    <b-icon-trash font-scale="1.6" variant="danger" class="pointer"></b-icon-trash>
                                </v-btn>
                            </div>

                            <div class="text-right">
                                <v-btn @click="add_Pakage_Standard_items_en()" class="ma-2" small outlined color="indigo">
                                    <b-icon-plus></b-icon-plus>
                                    <span>Add new item </span>
                                </v-btn>
                            </div>
                    </div>
                </v-card-text>
            </v-card>
     </v-col>
     <v-col>
          <v-card  class="mx-auto"  >
                <v-card-text>
                    <p class="display-1 text--primary"> Items Ar </p>
                    <div class="text--primary">

                            <div v-for="(Pakag,index) in CF.Pakage_Standard_items_ar">
                                <v-text-field :label="'item Ar '+(1+index)" type="text" v-model="Pakag.item" outlined :rules="requiredRules" style="width:80%;display:inline-block;" ></v-text-field>
                                <v-btn fab small class="mx-2" outlined @click="del_Pakage_Standard_items_ar(index)">
                                    <b-icon-trash font-scale="1.6" variant="danger" class="pointer"></b-icon-trash>
                                </v-btn>
                            </div>

                            <div class="text-right">
                                <v-btn @click="add_Pakage_Standard_items_ar()" class="ma-2" small outlined color="indigo">
                                    <b-icon-plus></b-icon-plus>
                                    <span>Add new item </span>
                                </v-btn>
                            </div>
                    </div>
                </v-card-text>
            </v-card>
     </v-col>
   </v-row>

        <br>
  <h3>
      Premium Pakage
      <v-switch v-model="CF.have_PremiumPakage" color="success" hide-details style="display: inline-block;" ></v-switch>
  </h3>
 <v-row v-if="CF.have_PremiumPakage">
     <v-col cols="3">
          <v-card  class="mx-auto" max-width="344" >
                <v-card-text>
                    <p class="display-1 text--primary">  Main  </p>
                    <div class="text--primary">
                            <table>
                              <tr>
                                    <td> Price </td>
                                    <td>
                                      <v-text-field type="number" v-model="CF.Premium.price" name="Pakage_Premium_price" :rules="requiredRules" class="centered-input"   ></v-text-field>
                                    </td>
                                    <td> Egp </td>
                              </tr>
                              <tr>
                                    <td> Days </td>
                                    <td>
                                      <v-text-field type="number" v-model="CF.Premium.days" name="Pakage_Premium_day" :rules="requiredRules" class="centered-input"  ></v-text-field>
                                    </td>
                                    <td> day </td>
                              </tr>
                              <tr>
                                    <td> Modifications </td>
                                    <td>
                                      <v-text-field type="number" v-model="CF.Premium.modifications" name="Pakage_Premium_modification" :rules="requiredRules" class="centered-input"  ></v-text-field>
                                    </td>
                                    <td> mod  </td>
                              </tr>
                            </table>

                     </div>
                </v-card-text>
            </v-card>
     </v-col>
     <v-col>
          <v-card  class="mx-auto" >
                <v-card-text>
                    <p class="display-1 text--primary"> Items En </p>
                    <div class="text--primary">

                            <div v-for="(Pakag,index) in CF.Pakage_Premium_items_en">
                                <v-text-field :label="'item En '+(1+index)" type="text" v-model="Pakag.item" outlined :rules="requiredRules" style="width:80%;display:inline-block;" ></v-text-field>
                                <v-btn fab small class="mx-2" outlined @click="del_Pakage_Premium_items_en(index)">
                                    <b-icon-trash font-scale="1.6" variant="danger" class="pointer"></b-icon-trash>
                                </v-btn>
                            </div>

                            <div class="text-right">
                                <v-btn @click="add_Pakage_Premium_items_en()" class="ma-2" small outlined color="indigo">
                                    <b-icon-plus></b-icon-plus>
                                    <span>Add new item </span>
                                </v-btn>
                            </div>
                    </div>
                </v-card-text>
            </v-card>
     </v-col>
     <v-col>
          <v-card  class="mx-auto"  >
                <v-card-text>
                    <p class="display-1 text--primary"> Items Ar </p>
                    <div class="text--primary">

                            <div v-for="(Pakag,index) in CF.Pakage_Premium_items_ar">
                                <v-text-field :label="'item Ar '+(1+index)" type="text" v-model="Pakag.item" outlined :rules="requiredRules" style="width:80%;display:inline-block;" ></v-text-field>
                                <v-btn fab small class="mx-2" outlined @click="del_Pakage_Premium_items_ar(index)">
                                    <b-icon-trash font-scale="1.6" variant="danger" class="pointer"></b-icon-trash>
                                </v-btn>
                            </div>

                            <div class="text-right">
                                <v-btn @click="add_Pakage_Premium_items_ar()" class="ma-2" small outlined color="indigo">
                                    <b-icon-plus></b-icon-plus>
                                    <span>Add new item </span>
                                </v-btn>
                            </div>
                    </div>
                </v-card-text>
            </v-card>
     </v-col>
   </v-row>

 </div> <!--END Pakages wrapper-->


 <div v-if="CF.is_bundle"> <!--START Bundle Pakages wrapper-->
    <h3>  Bundle Pakage </h3>
 <v-row >
     <v-col cols="3">
          <v-card  class="mx-auto" max-width="344" >
                <v-card-text>
                    <p class="display-1 text--primary">  Main  </p>
                    <div class="text--primary">
                        <table>
                            <tr>
                                <td> Price </td>
                                <td>
                                    <v-text-field type="number" v-model="CF.Bundle.price" name="Pakage_Bundle_price" :rules="requiredRules" class="centered-input"   ></v-text-field>
                                </td>
                                <td> Egp </td>
                            </tr>
                            <tr>
                                <td> Days </td>
                                <td>
                                    <v-text-field type="number" v-model="CF.Bundle.days" name="Pakage_Bundle_day" :rules="requiredRules" class="centered-input"  ></v-text-field>
                                </td>
                                <td> day </td>
                            </tr>
                            <tr>
                                <td> Modifications </td>
                                <td>
                                    <v-text-field type="number" v-model="CF.Bundle.modifications" name="Pakage_Bundle_modification" :rules="requiredRules" class="centered-input"  ></v-text-field>
                                </td>
                                <td> mod  </td>
                            </tr>
                        </table>
                    </div>
                </v-card-text>
            </v-card>
     </v-col>
     <v-col>
            <v-card  class="mx-auto" >
                <v-card-text>
                    <p class="display-1 text--primary"> Items En </p>
                    <div class="text--primary">

                            <div v-for="(Pakag,index) in CF.Pakage_Bundle_items_en">
                                <v-text-field :label="'item En '+(1+index)" type="text" v-model="Pakag.item" outlined :rules="requiredRules" style="width:80%;display:inline-block;" ></v-text-field>
                                <v-btn fab small class="mx-2" outlined @click="del_Pakage_Bundle_items_en(index)">
                                    <b-icon-trash font-scale="1.6" variant="danger" class="pointer"></b-icon-trash>
                                </v-btn>
                            </div>

                            <div class="text-right">
                                <v-btn @click="add_Pakage_Bundle_items_en()" class="ma-2" small outlined color="indigo">
                                    <b-icon-plus></b-icon-plus>
                                    <span>Add new item </span>
                                </v-btn>
                            </div>
                    </div>
                </v-card-text>
            </v-card>
     </v-col>
     <v-col>
          <v-card  class="mx-auto"  >
                <v-card-text>
                    <p class="display-1 text--primary"> Items Ar </p>
                    <div class="text--primary">

                            <div v-for="(Pakag,index) in CF.Pakage_Bundle_items_ar">
                                <v-text-field :label="'item Ar '+(1+index)" type="text" v-model="Pakag.item" outlined :rules="requiredRules" style="width:80%;display:inline-block;" ></v-text-field>
                                <v-btn fab small class="mx-2" outlined @click="del_Pakage_Bundle_items_ar(index)">
                                    <b-icon-trash font-scale="1.6" variant="danger" class="pointer"></b-icon-trash>
                                </v-btn>
                            </div>

                            <div class="text-right">
                                <v-btn @click="add_Pakage_Bundle_items_ar()" class="ma-2" small outlined color="indigo">
                                    <b-icon-plus></b-icon-plus>
                                    <span>Add new item </span>
                                </v-btn>
                            </div>
                    </div>
                </v-card-text>
            </v-card>
     </v-col>
   </v-row>

  </div> <!--END Bundle Pakages wrapper-->


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
                   <input type="hidden" name="old_images_ids[]" :value="image.cc">
                   <v-file-input v-if="!image.id" :rules="requiredRules" @change="Preview_image_Vue($event,image)" name="images[]" :label="'Image '+(1+index)" hint="140*140 Pixels" :persistent-hint="true" prepend-icon="" show-size outlined  ></v-file-input>
               </td>
               <td width="30%"> <img :src="image.image" :id="'Preview_image_edit'+index" style="max-width:150px;max-height:150px;" > </td>
               <td>
                   <input type="radio" name="is_main"  :value="image.id" :rules="requiredRules" :checked="image.is_main" />
                   <span  > {{1+index}} </span>
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
   </v-card>
   <br>

   <!-- - - - - - -START spinner- - - - - - - -->
   <spinner2 v-if="show_spinner"></spinner2>
   <!-- - - - - - -End spinner- - - - - - - -->

<v-row>
   <v-col>
      <router-link to="/Product">
         <v-btn large color="error" width="100%"  >Back</v-btn>
      </router-link>
   </v-col>
   <v-col>
      <v-btn large color="success" width="100%" @click="edit()" :disabled="btn_submit" >Update Product</v-btn>
   </v-col>
</v-row>

</v-form>
<br>
<br>

  </div><!--End page-wrapper-->
</template>

<script>
  import spinner2 from '@/components/spinner2';
  import ProductMixinn  from '@/mixins/extra_mixins/product_mixin';


  export default {
    name: 'Product-edit',
    mixins: [ProductMixinn],
    components: {spinner2},
    data: () => ({
        Permission: 'Product',
        api_update: 'Product/update',
        show_spinner:false,
        btn_submit:false,
        CF: {
           is_main: null,
           provider_id: 1,
           is_available: true,
           Basic: { price:null,days:null,modifications:null },
           Standard: { price:null,days:null,modifications:null },
           Premium: { price:null,days:null,modifications:null },
           Bundle: { price:null,days:null,modifications:null },
           requirements_en: [{ requirement:null }],
           requirements_ar: [{ requirement:null }],
           Pakage_Basic_items_en:    [{ item:null }] ,
           Pakage_Standard_items_en: [{ item:null }] ,
           Pakage_Premium_items_en:  [{ item:null }] ,
           Pakage_Bundle_items_en:  [{ item:null }] ,
           Pakage_Basic_items_ar:    [{ item:null }] ,
           Pakage_Standard_items_ar: [{ item:null }] ,
           Pakage_Premium_items_ar:  [{ item:null }] ,
           Pakage_Bundle_items_ar:  [{ item:null }] ,
           have_BasicPakage: false,
           have_StandardPakage: false,
           have_PremiumPakage: false,
        },
        formItem: {},
        Keywords: [],
        images: [ { cc: 1, image:null } ],
        isValid_createForm: true,
        isValid_Form: true,
        image_main:false,
        CatsBaseProduct: [],
        providers: [],
        requiredRules: [
          v => (!!v || v == '0' ) || 'field is required',
        ],
    }),//end data
    created(){
        this.formItem = this.CF;
      if(!localStorage.getItem('jwt')){
         this.$router.push('/login');
      }
      this.check_Permission(this.Permission);
      this.getCategories_list();
      this.getResults();
    },
    methods:{
           getResults(){
              this.Applicants = [];
              this.show_spinner = true;
              $.ajax({
                    type:"get",
                    url: `${Admin_BASE_url}/Product/show/${this.$route.params.id}` ,
                    headers: { 'jwt': localStorage.getItem('jwt') },
               })
               .done(function(Response){
                  if(Response.status == 'unValidJWT'){
                     localStorage.removeItem('jwt');
                     this.$router.push('/login');
                  }
                  this.CF = Response.Product;
                  this.CF.description_en = Response.Product.description_en.replaceAll('\\n','\n');
                  this.CF.description_ar = Response.Product.description_ar.replaceAll('\\n','\n');
                    this.CF.Basic = Response.Basic;
                    this.CF.Standard = Response.Standard;
                    this.CF.Premium = Response.Premium;          // console.log(Response);
                    this.CF.Bundle = Response.Bundle;          // console.log(Response);

                    this.CF.requirements_en = JSON.parse(Response.Product.requirements_en);
                    this.CF.requirements_ar = JSON.parse(Response.Product.requirements_ar);

                    this.CF.Pakage_Basic_items_en  = JSON.parse(Response.Product.Pakage_Basic_items_en);
                    this.CF.Pakage_Standard_items_en  = JSON.parse(Response.Product.Pakage_Standard_items_en);
                    this.CF.Pakage_Premium_items_en  = JSON.parse(Response.Product.Pakage_Premium_items_en);
                    this.CF.Pakage_Bundle_items_en  = JSON.parse(Response.Product.Pakage_Bundle_items_en);
                    this.CF.Pakage_Basic_items_ar  = JSON.parse(Response.Product.Pakage_Basic_items_ar);
                    this.CF.Pakage_Standard_items_ar  = JSON.parse(Response.Product.Pakage_Standard_items_ar);
                    this.CF.Pakage_Premium_items_ar  = JSON.parse(Response.Product.Pakage_Premium_items_ar);
                    this.CF.Pakage_Bundle_items_ar  = JSON.parse(Response.Product.Pakage_Bundle_items_ar);

                  this.images = Response.Images;
                  this.Keywords = Response.Keywords;
                  this.show_spinner = false;          this.$forceUpdate();
               }.bind(this))
               .fail(function(data){
                 new Noty({text: 'proplem' , type: 'error'  }).show();
               });
         },
         getCategories_list()
         {
               $.ajax({
                  type:"get" ,
                  url: `${Admin_BASE_url}/Product/selection_data` ,
                  headers: { 'jwt': localStorage.getItem('jwt') }
              })
              .done(function(Response){
                 if(Response.status == 'unValidJWT'){
                      localStorage.removeItem('jwt');
                      this.$router.push('/login');
                 }
                 this.CatsBaseProduct = Response.categoiry_BaseProducts;
                 this.providers = Response.providers;
              }.bind(this))
              .fail(function(data){
                 new Noty({text: 'proplem' , type: 'error' }).show();
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
                   for (var key in { ...this.CF })
                   {
                      if (this.CF.hasOwnProperty(key)) {
                           my_formData.append(key, this.CF[key] );
                      }
                   }
                   my_formData.append('is_main',$('input[name="is_main"]:checked').val() );
                   my_formData.append('id', this.$route.params.id );

                    my_formData.append('requirements_en', JSON.stringify(this.CF.requirements_en) );
                    my_formData.append('requirements_ar', JSON.stringify(this.CF.requirements_ar) );

                    my_formData.append('Pakage_Basic_items_en', JSON.stringify(this.CF.Pakage_Basic_items_en) );
                    my_formData.append('Pakage_Standard_items_en', JSON.stringify(this.CF.Pakage_Standard_items_en) );
                    my_formData.append('Pakage_Premium_items_en', JSON.stringify(this.CF.Pakage_Premium_items_en) );
                    my_formData.append('Pakage_Bundle_items_en', JSON.stringify(this.CF.Pakage_Bundle_items_en) );
                    my_formData.append('Pakage_Basic_items_ar', JSON.stringify(this.CF.Pakage_Basic_items_ar) );
                    my_formData.append('Pakage_Standard_items_ar', JSON.stringify(this.CF.Pakage_Standard_items_ar) );
                    my_formData.append('Pakage_Premium_items_ar', JSON.stringify(this.CF.Pakage_Premium_items_ar) );
                    my_formData.append('Pakage_Bundle_items_ar', JSON.stringify(this.CF.Pakage_Bundle_items_ar) );

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

    },//End methods
    computed: {
        BaseProducts()
        {
              var get_subCat = this.CatsBaseProduct.find(obj=>obj.value == this.CF.category_id);
              if(get_subCat){
                return get_subCat.BaseProducts;
             }
        },
    }
}//End export default
</script>
