import spinner1 from '@/components/spinner1';
import spinner2 from '@/components/spinner2';
import spinner3 from '@/components/spinner3';
import spinnerPagnation from '@/components/spinner-pagnation';
import Swal from 'sweetalert2'

export const AdminMixin = {
   components: {
     spinner1 , spinner2, spinner3, spinnerPagnation
   },
   data: () => ({
      mainList: {data:[]},
      mainList_no_Paginate: [],
      show_spinner:true,
      action_spinner:false,
      SF: {}, //show Form
      EF: {}, //Edit Form
      CF: {}, //Create Form
      ST: {}, //Search table
      btn_submit: false,
      createDialog: false,
      editDialog: false,
      showDialog: false,
      isValid_createForm: true,
      isValid_editForm: true,
      requiredRules: [
        v => (!!v || v == '0' ) || 'field is required',
      ],
      //---ck editor
      editor:  ClassicEditor,
      editorData: '',
      editorConfig: {
           toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
           removePlugins: [ 'Heading', 'Link' ],
      },
      Permission: null
   }),//end data
   created(){
      if(!localStorage.getItem('jwt')){
         this.$router.push('/login');
      }
      this.check_Permission(this.Permission);
         console.log(`From (${this.$options.name}) component`);
      this.getResults();
   },//End mounted()

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
                //----for parse the \n in the text----
                this.mainList.data.forEach((item, i) => {
                  for (var key in { ...item })
                  {
                       if (item.hasOwnProperty(key))
                       {
                           if (typeof item[key] === 'string')
                             item[key] = item[key].replaceAll('\\n','\n');
                       }
                  }
                });
                this.show_spinner = false;
                // document.getElementById("myVue").scrollIntoView();
           }.bind(this))
           .fail( function(xhr, textStatus, errorThrown) {
                new Noty({text: 'proplem' , type: 'error'  }).show(); alert(xhr.responseText);
           });
        },
        showShowModel(this_data){
           this.showDialog = true;
           this.SF = this_data;
        },
        showCreateModel(){
           this.createDialog = true;
        },
        showEditModel(this_data){
             this.editDialog = true;
             $("#edit_model input[type=file]").val('');
             this.EF = this_data;
        },
        showORhide(item){
             $.ajax({
                type:"get",
                url: `${Admin_BASE_url}/${this.api_showORhide}/${item.id}` ,
                headers: { 'jwt': localStorage.getItem('jwt') }
            })
            .done(function(Response){
               item.status = Response.case;
               if(Response.case){
                  new Noty({text: 'Content has been shown in the site', type: 'success'  }).show();
               }
               else {
                  new Noty({text: 'Content now is hidden in the site' , type: 'error'  }).show();
               }
            }.bind(this))
            .fail(function(data){
               new Noty({text: 'proplem' , type: 'error'  }).show();
            });
        },
        ContatctedOrNot(item){
            $.ajax({
               type:"get",
               url: `${Admin_BASE_url}/${this.api_switch_contacted}/${item.id}` ,
               headers: { 'jwt': localStorage.getItem('jwt') }
           })
           .done(function(Response){
              item.is_contacted = Response.case;
              if(Response.case){
                 new Noty({text: 'Client has been contacted', type: 'success'  }).show();
              }
              else {
                 new Noty({text: 'Client is not contacted' , type: 'error'  }).show();
              }
           }.bind(this))
           .fail(function(data){
              new Noty({text: 'proplem' , type: 'error'  }).show();
           });
        },
        create(reload_table=false)
        {
              this.$refs.createForm.validate();

              if( this.isValid_createForm )
              {
                  this.btn_submit = true;
                  this.action_spinner = true;

                     let my_formData = new FormData($('#create_form')[0]);

                     for (var key in { ...this.CF })
                     {
                        if (this.CF.hasOwnProperty(key)) {
                             my_formData.append(key, this.CF[key] );
                        }
                     }
                     // Attach files
                     $("#create_form input[type=file]").each(function(){
                           if( $(this).get(0).files.length != 0 ){
                                my_formData.append( $(this).attr("name") , $(this)[0].files[0]);
                           }
                     });

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
                              if(reload_table){
                                  this.getResults();
                              }
                              else {
                                this.mainList.data.unshift(responce.data);
                              }
                              new Noty({ text: 'Content has created', type: 'success',timeout: 1500  }).show();
                              $('#create_form').find('img').prop('src','');

                              this.$refs.createForm.reset();
                              this.$refs.createForm.resetValidation();
                              this.createDialog = false;
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
                          this.action_spinner = false;
                          this.btn_submit = false;
                      }.bind(this) ,
                  })
                  .fail(function(data){
                     new Noty({text: 'proplem' , type: 'error'  }).show();
                  });
              }
        },
        edit(reload_table=false)
        {
             this.$refs.editForm.validate();

             if( this.isValid_editForm )
             {
                 this.btn_submit = true;
                 this.action_spinner = true;
                 let my_formData = new FormData($('#edit_form')[0]);

                 for (var key in { ...this.EF })
                 {
                     if ( this.EF.hasOwnProperty(key) ) {
                           if(!key.includes('image')){
                              my_formData.append(key, this.EF[key] );
                           }
                     }
                 }

                 // Attach files
                 $("#edit_image input[type=file]").each(function(){
                       if( $(this).get(0).files.length != 0 ){
                           my_formData.append( $(this).attr("name") , $(this)[0].files[0]);
                       }
                 });

                 $.ajax({
                     type:"post",
                     url: `${Admin_BASE_url}/${this.api_update}`,
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
                              if(reload_table){
                                 this.getResults();
                              }
                              else
                              {
                                  let find = this.mainList.data.find(obj => obj.id == responce.data.id);
                                  find.image = responce.data.image;
                                  find = responce.data;
                              }
                              this.editDialog = false;
                              new Noty({text: 'Content has edited', type: 'success',timeout: 1500  }).show();
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

                        this.btn_submit = false;
                        this.action_spinner = false;
                     }.bind(this) ,
                 })
                 .fail(function(data){
                    new Noty({text: 'proplem' , type: 'error'  }).show();
                 });//End ajax
             }
        },
        characters_number_only(longString,number)
        {
           if(longString.length > number) {
             return longString.substr(0, number) + '...';
           }
           else {
             return longString;
           }
      },
      replace_underscore_with_space(the_string)
      {
         if(the_string)
             return  the_string.split("_").join(" ");
      },
        switch_in_home(id)
        {
           $.get(switch_in_home_api+'/'+id ,(responce)=>{
             let find = myVue.mainList.data.find(obj => obj.id == id);
                find.in_home = responce.case;
                if(responce.case){
                  new Noty({text: 'Content has been added to the home page ', type: 'success'  }).show();
                }
                else {
                  new Noty({text: 'Content has been removed from the home page ' , type: 'error'  }).show();
                }
           });
      },
        add_to_home_items(id,type)
        {
           $.get( `${add_to_home_items_api}/${id}/${type}` ,(responce)=>{
                if(responce.status == 'success'){
                  new Noty({text: 'Content has been added to the home items ', type: 'success'  }).show();
                }
                else {
                  new Noty({text: 'Content has been removed from the home items ' , type: 'error'  }).show();
                }
           });
      },
        del_row(item,index)
        {
            Swal.fire({
              title: `you wanna delete (${item.id}) ?`,
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
                        url: `${Admin_BASE_url}/${this.api_delete}/${item.id}` ,
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
                        this.mainList.data.splice(index,1);
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
   }//End methods
};//End export const
