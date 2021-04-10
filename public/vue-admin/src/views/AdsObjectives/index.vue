<style lang="scss">
  td.placements
  {
      ul{
        display: inline;

        li{
            list-style: none;
            display: inline;
        }
      }
  }
</style>
<template>
  <div class="page-wrapper">

     <h2 class="font-italic font-weight-light font-weight-bold">Ads Objective ({{ mainList.total }})</h2>


    <!-- - - - - - -START spinner & paginate - - - - - - - -->
    <spinnerPagnation :mainList="mainList" :show_spinner="show_spinner" @getResults="getResults"></spinnerPagnation>
    <!-- - - - - - -END spinner & paginate - - - - - - - -->



    <div v-for="(Objective,index) in mainList.data" :key="Objective.id">

         <h3 class="text-center">
            <v-chip class="ma-2" color="primary" label >
                {{Objective.name_en}}
                <v-btn @click="showObjectiveEditModel(Objective)" dark >
                    <font-awesome-icon icon="edit" />
                </v-btn>
            </v-chip>
         </h3>
         <!-- <h3 class="text-center">{{Objective.name_en}}</h3> -->

         <table class="tbl_mainList">
                <tbody is="transition-group" name="my-list" class="row_sortable" >
                    <tr v-for="(item,index2) in Objective.products" :key="item.id" :data-id="item.id">
                        <td>{{ item.id }}</td>
                        <td>{{ item.name_en }}</td>
                        <td>{{ item.name_ar }}</td>
                        <td class="placements">
                            <ul v-for="placement in item.placements.split(',')" >
                                <li>
                                    <font-awesome-icon v-if="placement=='f'" :icon="['fab', 'facebook-square']" size="lg" />
                                    <font-awesome-icon v-if="placement=='i'" :icon="['fab', 'instagram-square']" size="lg" />
                                    <font-awesome-icon v-if="placement=='m'" :icon="['fab', 'facebook-messenger']" size="lg" />
                                    <font-awesome-icon v-if="placement=='a'"  icon="network-wired" size="lg" />
                                </li>
                            </ul>
                        </td>
                        <td >
                            <div>
                                <v-btn v-if="item.status" @click="showORhide(item)" >
                                    <font-awesome-icon icon="eye" size="lg" :style="{ color: 'green' }" />
                                </v-btn>
                                <v-btn v-else @click="showORhide(item)" >
                                    <font-awesome-icon icon="eye-slash" size="lg" :style="{ color: '#dc3545' }" />
                                </v-btn>
                            </div>
                            <div>
                                <router-link :to="'AdsObjectives/edit/'+item.id">
                                    <v-btn>
                                        <font-awesome-icon icon="edit" size="lg"  />
                                    </v-btn>
                                </router-link>
                            </div>
                            <div>
                                <b-icon-arrows-move></b-icon-arrows-move>
                            </div>

                        </td>
                    </tr>
                </tbody>
            </table>
            <hr>
    </div>

    <!-- ------------------- Edit ----------------------- - -->
    <v-row justify="center">
        <v-dialog v-model="ObjectiveEditDialog" scrollable  max-width="800px">
        <v-card>
            <v-card-title class="headline grey lighten-2" primary-title >
            Edit
            </v-card-title>
            <v-card-text>
            <v-container>
                <v-form  id="edit_image" ref="editForm" v-model="isValid_editForm" :lazy-validation="false" >
                    <v-row>
                            <v-col>
                                <v-text-field label="Name En" v-model="objective.name_en" outlined :rules="[v => !!v || 'field is required']" ></v-text-field>
                                <v-text-field label="Name Ar" v-model="objective.name_ar" outlined required :rules="requiredRules"></v-text-field>
                                <div class="div_Preview_image">
                                    <img id="Preview_image_create" class="Preview_image" >
                                    <v-file-input @change="Preview_image($event,'Preview_image_create')" label="Image" name="image" hint="400*400 Pixels" persistent-hint="true" prepend-icon="" show-size outlined ></v-file-input>
                                </div>
                                <div class="div_Preview_image">
                                    <img id="Preview_image_create" class="Preview_image_small" >
                                    <v-file-input @change="Preview_image($event,'Preview_image_create')" label="Icon" name="image" hint="40*40 Pixels" persistent-hint="true" prepend-icon="" show-size outlined ></v-file-input>
                                </div>
                            </v-col>
                            <v-col>
                            <v-textarea label="Description En" v-model="objective.description_en" name="input-7-4" outlined rows="5" ></v-textarea>
                            <v-textarea label="Description Ar" v-model="objective.description_ar" name="input-7-4" outlined rows="5" ></v-textarea>
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
                <v-btn large dark @click="ObjectiveEditDialog = false">Close</v-btn>
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
    name: 'AdsObjectives',
    mixins: [AdminMixin],
     data: () => ({
        Permission: 'AdsObjectives',
        api_get_list: 'AdsObjectives/list',
        api_showORhide: 'AdsObjectives/AdProduct_showORhide',
        api_delete: 'AdsObjectives/delete',
        api_create: 'AdsObjectives/create',
        api_update: 'AdsObjectives/update',
        api_updateRowsPosition: 'AdsObjectives/updateRowsPosition',
        ObjectiveEditDialog: false,
        objective: {}
    }),//end data
    created(){

    },
    methods:{
        getResults(page = 1){
          this.mainList = {data:[]};
          this.show_spinner = true;
          this.ST.jwt = localStorage.getItem('jwt');
          $.post(`${Admin_BASE_url}/${this.api_get_list}?page=${page}`,this.ST)
           .done( function(Response){
                if(Response.status == 'unValidJWT'){ console.log('from cop to login');
                   localStorage.removeItem('jwt');
                   this.$router.push('/login');
                }
                 this.mainList = Response;


                let myThis = this;
                setTimeout(function(){
                    $( ".row_sortable" ).sortable({
                        delay: 550,
                        stop: function() {
                            var selectedData = new Array();
                            $('.row_sortable>tr').each(function() {
                                selectedData.push($(this).data("id"));
                            });
                            myThis.updateRowsPosition(selectedData);
                        }.bind(this)
                    });//End sortable()
                     myThis.show_spinner = false;
                }, 1000);


                // document.getElementById("myVue").scrollIntoView();
           }.bind(this))
           .fail( function(xhr, textStatus, errorThrown) {
                new Noty({text: 'proplem' , type: 'error'  }).show(); alert(xhr.responseText);
           });
        },

        updateRowsPosition(arrayList)
        {
           var my_formData = {
             postionArray: arrayList,
             jwt: localStorage.getItem('jwt')
           }

           $.post(`${Admin_BASE_url}/${this.api_updateRowsPosition}`,my_formData)
            .done( function(Response){
                if(Response.status == 'unValidJWT'){
                     localStorage.removeItem('jwt');
                     this.$router.push('/login');
                }
                else if(Response.status == 'success'){
                     new Noty({text: 'Items Rearranged', type: 'success' }).show();
                }
                else {
                     new Noty({text: 'problem in Rearranged please try agine' , type: 'error' }).show();
                }
            }.bind(this))
            .fail( function(xhr, textStatus, errorThrown) {
                 new Noty({text: 'proplem' , type: 'error'  }).show(); alert(xhr.responseText);
            });
        },
        showObjectiveEditModel(this_data){
             this.ObjectiveEditDialog = true;
             $("#edit_model input[type=file]").val('');
             this.objective = this_data;
        },

    }//End methods
}//End export default
</script>
