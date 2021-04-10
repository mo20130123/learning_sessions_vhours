<template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Pages Banners</h2>

     <section class="section-page-control">
        <v-row>
           <v-col cols="7" >

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
          <!-- <th> Id </th> -->
          <th> Page </th>
          <th> Image En </th>
          <th> Image Ar </th>
          <!-- <th> Title </th> -->
          <th> Action </th>
       </thead>
       <tbody is="transition-group" name="my-list" >
          <tr v-for="(item,index) in mainList.data" :key="item.id">
             <!-- <td>{{ item.id }}</td> -->
             <td> <b>{{ item.page }}</b> </td>
             <td> <img :src="item.imageen" class="img-table">   </td>
             <td> <img :src="item.imagear" class="img-table">   </td>
             <!-- <td>{{ item.title_en }}</td> -->
             <td style="width: 20%;">
                <div>
                   <b-icon-pencil-square @click="showEditModel(item)" font-scale="1.6"  ></b-icon-pencil-square>
                </div>
             </td>
          </tr>
       </tbody>
    </table>

       <!-- - - - - - -START spinner & paginate - - - - - - - -->
       <spinnerPagnation :mainList="mainList" :show_spinner="show_spinner" @getResults="getResults"></spinnerPagnation>
       <!-- - - - - - -END spinner & paginate - - - - - - - -->

       <!-- ------------------- Edit ----------------------- - -->
       <v-row justify="center">
         <v-dialog v-model="editDialog" scrollable  max-width="800px">
            <v-card>
              <v-card-title   class="headline grey lighten-2"   primary-title   >
                Edit ({{EF.page}})
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-form  id="edit_image" ref="editForm" v-model="isValid_editForm" :lazy-validation="false" >
                     <div class="div_Preview_image">
                        <img :src="EF.imageen" id="Preview_image_edit1" class="Preview_image" >
                        <v-file-input @change="Preview_image($event,'Preview_image_edit1')" label="Banner En" name="imageen" hint="1513*372 Pixels" :persistent-hint="true" prepend-icon="" show-size outlined ></v-file-input>
                     </div>
                     <br>
                     <div class="div_Preview_image">
                        <img :src="EF.imagear" id="Preview_image_edit2" class="Preview_image" >
                        <v-file-input @change="Preview_image($event,'Preview_image_edit2')" label="Banner Ar" name="imagear" hint="1513*372 Pixels" :persistent-hint="true" prepend-icon="" show-size outlined ></v-file-input>
                     </div>
                     <br>
                     <div v-if="EF.page=='home_1'||EF.page=='home_2'">
                        <v-text-field label="Link" v-model="EF.link" outlined required  ></v-text-field>
                     </div>
                     <!-- <v-text-field label="Title En" v-model="EF.title_en" outlined   ></v-text-field>
                     <v-text-field label="Title Ar" v-model="EF.title_ar" outlined required  ></v-text-field> -->
                     <!--
                      <v-row>
                        <v-col>
                           <v-text-field label="Name En" v-model="EF.title_en" outlined :rules="[v => !!v || 'field is required']" ></v-text-field>
                        </v-col>
                        <v-col>
                           <v-text-field label="Name Ar" v-model="EF.title_ar" outlined required :rules="requiredRules"></v-text-field>
                        </v-col>
                      </v-row>
                      -->

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
                  <v-btn large color="success" dark @click="edit(true)" :disabled="btn_submit" >Save</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-row>

  </div><!--End page-wrapper-->
</template>

<script>
  import {AdminMixin} from '@/mixins/Admin_mixin';

  export default {
    name: 'Pages-Banner',
    mixins: [AdminMixin],
     data: () => ({
        Permission: 'PagesBanner',
        api_get_list: 'PagesBanner/list',
        api_showORhide: 'PagesBanner/showORhide',
        api_delete: 'PagesBanner/delete',
        api_create: 'PagesBanner/create',
        api_update: 'PagesBanner/update',
    }),//end data
    created(){

    },
    methods:{

    }//End methods
}//End export default
</script>
