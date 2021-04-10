import spinner1 from '@/components/spinner1';
import spinner2 from '@/components/spinner2';
import spinner3 from '@/components/spinner3';

export const AdminSortMixin = {
   components: {
     spinner1 , spinner2, spinner3
   },
   data: () => ({
      mainList_no_Paginate: [],
      show_spinner:true,
      Permission: null
   }),//end data
   created(){
      if(!localStorage.getItem('jwt')){
         this.$router.push('/login');
      }
      this.check_Permission(this.Permission);
      console.log(`From (${this.$options.name}) component`);
      this.listWithoutPaginate();
   },//End mounted()

   methods:{
        listWithoutPaginate()
        {
          this.mainList_no_Paginate = [];
          this.show_spinner = true;
           $.ajax({
             type:"get",
             url: `${Admin_BASE_url}/${this.api_get_listWithoutPaginate}` ,
             headers: { 'jwt': localStorage.getItem('jwt') }
           })
           .done(function(Response){
                if(Response.status == 'unValidJWT'){
                   localStorage.removeItem('jwt');
                   this.$router.push('/login');
                }
                this.mainList_no_Paginate = Response;
                this.show_spinner = false;

                $( ".row_sortable" ).sortable({
                    delay: 150,
                    stop: function() {
                        var selectedData = new Array();
                        $('.row_sortable>tr').each(function() {
                             selectedData.push($(this).data("id"));
                        });
                        this.updateRowsPosition(selectedData);
                    }.bind(this)
                 });//End sortable()

           }.bind(this))
           .fail(function(data){
              new Noty({text: 'proplem' , type: 'error'  }).show();
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
   }//End methods
};//End export const
