 <template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Trusted By</h2>

     <section class="section-page-control">
        <v-row>
           <v-col cols="7" >
             <v-btn @click="showCreateModel()" class="ma-2" outlined color="indigo"> <b-icon-plus></b-icon-plus> Add New</v-btn>
             <router-link to="/TrustedBy/sort"> <v-btn class="ma-2" outlined color="black"> <b-icon-filter></b-icon-filter> Sort  </v-btn> </router-link>

          </v-col>
          <v-col>
                <div class="">
                   <v-text-field v-model="ST.search" @keyup.enter="getResults()" label="Search" outlined shaped style="width:80%;display:inline-block;" ></v-text-field>
                   <v-btn @click="getResults()" class="ma-2 btn-refresh" fab  outlined   color="indigo"> <font-awesome-icon icon="redo" size="lg" spin  /> </v-btn>
                </div>
          </v-col>
        </v-row>
    </section><!--End section-page-control-->

    <table class="tbl_mainList">
       <thead>
          <th> Id </th>
          <th> Image </th>
          <th> Name  </th>
          <th> Created date </th>
          <th> Action </th>
       </thead>
       <tbody is="transition-group" name="my-list" >
          <tr v-for="(item,index) in mainList.data" :key="item.id">
             <td>{{ item.id }}</td>
             <td> <img :src="item.image" class="img-table">   </td>
             <td>{{ item.name }}</td>
             <td>{{ item.created_at }} <br> [{{ item.created_at | moment("from", "now") }}] </td>
             <td>
                <ActionRowTd :item="item" :index="index" @showORhide="showORhide(item)"
                            @showEditModel="showEditModel(item)" @del_row="del_row(item,index)" >
                </ActionRowTd>
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
                      <v-row>
                        <v-col>
                            <div class="div_Preview_image">
                               <img id="Preview_image_create" class="Preview_image" >
                               <v-file-input @change="Preview_image($event,'Preview_image_create')" label="File input" name="image" hint="400*400 Pixels" persistent-hint="true" prepend-icon="" show-size outlined ></v-file-input>
                            </div>
                         </v-col>
                        <v-col>
                            <v-text-field label="Name" v-model="CF.name" outlined required :rules="requiredRules"></v-text-field>

                         </v-col>
                      </v-row>
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
                      <v-row>
                        <v-col>
                            <div class="div_Preview_image">
                               <img :src="EF.image" id="Preview_image_edit" class="Preview_image" >
                               <v-file-input @change="Preview_image($event,'Preview_image_edit')" label="File input" name="image" hint="400*400 Pixels" persistent-hint="true" prepend-icon="" show-size outlined ></v-file-input>
                            </div>
                        </v-col>
                        <v-col>
                            <v-text-field label="Name" v-model="EF.name" outlined required :rules="requiredRules"></v-text-field>
                         </v-col>
                      </v-row>
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
    name: 'TrustedBy',
    mixins: [AdminMixin],
     data: () => ({
        Permission: 'TrustedBy',
        api_get_list: 'TrustedBy/list',
        api_showORhide: 'TrustedBy/showORhide',
        api_delete: 'TrustedBy/delete',
        api_create: 'TrustedBy/create',
        api_update: 'TrustedBy/update',
    }),//end data
    created(){

    },
    methods:{

    }//End methods
}//End export default
</script>
