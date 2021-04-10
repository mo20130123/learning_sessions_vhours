<style>
   .ck-editor__editable_inline {
     min-height: 140px;
   }

</style>
<template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Home Slider</h2>

     <section class="section-page-control">
        <v-row>
           <v-col cols="7" >
             <v-btn @click="showCreateModel()" class="ma-2" outlined color="indigo"> <b-icon-plus></b-icon-plus> Add New</v-btn>
             <router-link to="/HomeSlider/sort"> <v-btn class="ma-2" outlined color="black"> <b-icon-filter></b-icon-filter> Sort  </v-btn> </router-link>

          </v-col>
          <v-col>
                <div class="">
                   <v-text-field v-model="ST.search" @keyup.enter="getResults()" label="Search" outlined shaped style="width:80%;display:inline-block;" ></v-text-field>
                   <v-btn @click="getResults()" class="ma-2 btn-refresh" fab  outlined   color="indigo"> <b-icon-arrow-repeat font-scale="1.5"></b-icon-arrow-repeat> </v-btn>
                </div>
          </v-col>
        </v-row>
    </section><!--End section-page-control-->

    <table class="tbl_mainList">
       <thead>
          <th> Id </th>
          <th> Image </th>
          <th> Name </th>
          <!-- <th> Name En </th> -->
          <!-- <th> Name Ar </th> -->
          <th> Created date </th>
          <th> Action </th>
       </thead>
       <tbody is="transition-group" name="my-list" >
          <tr v-for="(item,index) in mainList.data" :key="item.id">
             <td>{{ item.id }}</td>
             <td> <img :src="item.image_en" class="img-table">   </td>
             <td>{{ item.title }}</td>
             <!-- <td>{{ item.title_ar }}</td> -->
             <td>{{ item.created_at }} <br> [{{ item.created_at | moment("from", "now") }}] </td>
             <td style="width: 20%;">
                <div>
                   <b-icon-eye       v-if="item.status" @click="showORhide(item)" font-scale="1.6" variant="success"></b-icon-eye>
                   <b-icon-eye-slash v-else             @click="showORhide(item)" font-scale="1.6" variant="danger"></b-icon-eye-slash>
                </div>
                <div>
                   <b-icon-pencil-square @click="showEditModel(item)" font-scale="1.6"  ></b-icon-pencil-square>
                </div>
                <div>
                   <b-icon-trash @click="del_row(item,index)" font-scale="1.6" variant="danger" ></b-icon-trash>
                </div>
             </td>
          </tr>
       </tbody>
    </table>

       <!-- - - - - - -START spinner & paginate - - - - - - - -->
       <spinnerPagnation :mainList="mainList" :show_spinner="show_spinner" @getResults="getResults"></spinnerPagnation>
       <!-- - - - - - -END spinner & paginate - - - - - - - -->


       <!-- ------------------- create ----------------------- - -->
       <v-row justify="center">
         <v-dialog v-model="createDialog" scrollable  max-width="800px">
            <v-card>
              <v-card-title   class="headline grey lighten-2"   primary-title   >
                Create New
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-form  id="create_form" ref="createForm" v-model="isValid_createForm" :lazy-validation="false" >

                        <div class="div_Preview_image">
                           <img id="Preview_image_create_en" class="Preview_image" >
                           <v-file-input @change="Preview_image($event,'Preview_image_create_en')" label="Image En" name="image_en" hint="1513*372 Pixels" persistent-hint="true"  prepend-icon="" show-size outlined ></v-file-input>
                        </div>
                        <div class="div_Preview_image">
                           <img id="Preview_image_create_ar" class="Preview_image" >
                           <v-file-input @change="Preview_image($event,'Preview_image_create_ar')" label="Image Ar" name="image_ar" hint="1513*372 Pixels" persistent-hint="true"  prepend-icon="" show-size outlined ></v-file-input>
                        </div>

                        <v-text-field label="Title" v-model="CF.title" outlined   :rules="[v => !!v || 'field is required']" ></v-text-field>
                        <v-text-field label="Link" v-model="CF.link" outlined    ></v-text-field>
                      <!-- <v-row>
                        <v-col>

                            <label> Body En </label>
                            <ckeditor :editor="editor" v-model="CF.body_en" :config="editorConfig"></ckeditor>
                            <br>
                            <v-text-field label="Link" v-model="CF.link" outlined ></v-text-field>
                        </v-col>
                        <v-col>
                            <v-text-field label="Title En" v-model="CF.title_ar" outlined :rules="[v => !!v || 'field is required']" ></v-text-field>

                            <label> Body Ar </label>
                            <ckeditor :editor="editor" v-model="CF.body_ar" :config="editorConfig"></ckeditor>
                        </v-col>
                      </v-row> -->

                  </v-form>
                    <!-- - - - - - -START spinner- - - - - - - -->
                    <spinner3 v-if="action_spinner"></spinner3>
                    <!-- - - - - - -End spinner- - - - - - - -->
                </v-container>

              </v-card-text>
              <v-divider></v-divider>
              <v-card-actions>
                 <v-spacer></v-spacer>
                  <v-btn large dark @click="createDialog = false">Close</v-btn>
                  <v-btn large color="success" dark @click="create()" :disabled="btn_submit" >Save</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-row>

       <!-- ------------------- Edit ----------------------- - -->
       <v-row justify="center">
         <v-dialog v-model="editDialog" scrollable  max-width="800px">
            <v-card>
              <v-card-title   class="headline grey lighten-2"   primary-title   >
                Edit
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-form  id="edit_image" ref="editForm" v-model="isValid_editForm" :lazy-validation="false" >

                      <div class="div_Preview_image">
                          <img :src="EF.image_en" id="Preview_image_edit_en" class="Preview_image" >
                          <v-file-input @change="Preview_image($event,'Preview_image_edit_en')" label="Image En" name="image_en" hint="1513*372 Pixels" persistent-hint="true" prepend-icon="" show-size outlined ></v-file-input>
                       </div>
                      <div class="div_Preview_image">
                          <img :src="EF.image_ar" id="Preview_image_edit_ar" class="Preview_image" >
                          <v-file-input @change="Preview_image($event,'Preview_image_edit_ar')" label="Image Ar" name="image_ar" hint="1513*372 Pixels" persistent-hint="true" prepend-icon="" show-size outlined ></v-file-input>
                       </div>

                       <v-text-field label="Title" v-model="EF.title" outlined :rules="[v => !!v || 'field is required']" ></v-text-field>
                       <v-text-field label="Link" v-model="EF.link" outlined    ></v-text-field>
                     <!-- <v-row>
                       <v-col>

                           <label> Body En </label>
                           <ckeditor :editor="editor" v-model="EF.body_en" :config="editorConfig"></ckeditor>
                           <br>
                           <v-text-field label="Link" v-model="EF.link" outlined ></v-text-field>
                       </v-col>
                       <v-col>
                           <v-text-field label="Title En" v-model="EF.title_ar" outlined :rules="[v => !!v || 'field is required']" ></v-text-field>

                           <label> Body Ar </label>
                           <ckeditor :editor="editor" v-model="EF.body_ar" :config="editorConfig"></ckeditor>
                       </v-col>
                     </v-row>-->
                  </v-form>
                    <!-- - - - - - -START spinner- - - - - - - -->
                    <spinner3 v-if="action_spinner"></spinner3>
                    <!-- - - - - - -End spinner- - - - - - - -->
                </v-container>

              </v-card-text>
              <v-divider></v-divider>
              <v-card-actions>
                 <v-spacer></v-spacer>
                  <v-btn large dark @click="editDialog = false">Close</v-btn>
                  <v-btn large color="success" dark @click="edit()" :disabled="btn_submit" >Save</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-row>

  </div><!--End page-wrapper-->
</template>

<script>
  import {AdminMixin} from '@/mixins/Admin_mixin';

  export default {
    name: 'HomeSlider',
    mixins: [AdminMixin],
     data: () => ({
        Permission: 'HomeSlider',
        api_get_list: 'HomeSlider/list',
        api_showORhide: 'HomeSlider/showORhide',
        api_delete: 'HomeSlider/delete',
        api_create: 'HomeSlider/create',
        api_update: 'HomeSlider/update',
    }),//end data
    created(){

    },
    methods:{

    }//End methods
}//End export default
</script>
