<style  lang="scss" scoped>
@import "@/scss/login.scss";
html, body{
   overflow: hidden;
}

#img_loginPage_logoSite{
   // background-color: black;

   margin: 15%;
   position: absolute;
   top: 30%;
   -ms-transform: translateY(-50%);
   transform: translateY(-50%);
   width: 200px;
}
</style>
<template>

   <div class="limiter">
   <div class="container-login100">
   <div class="wrap-login100">
   <div class="login100-pic js-tilt" data-tilt="" style="will-change: transform; transform: perspective(300px) rotateX(0deg) rotateY(0deg);">
   <img :src="logo_site" alt="IMG" id="img_loginPage_logoSite">
   </div>
   <form v-on:submit.prevent="login()" type="post" class="login100-form validate-form">
   <span class="login100-form-title"> Admin Login </span>
   <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
      <input v-model="username" class="input100" type="text" name="username" placeholder="user name">
   <span class="focus-input100"></span>
   <span class="symbol-input100">
   <i class="fa fa-envelope" aria-hidden="true"></i>
   </span>
   </div>
   <div class="wrap-input100 validate-input" data-validate="Password is required">
      <input v-model="password" class="input100" type="password" name="pass" placeholder="Password">
   <span class="focus-input100"></span>
   <span class="symbol-input100">
   <i class="fa fa-lock" aria-hidden="true"></i>
   </span>
   </div>

   <!-- - - - - - -START spinner- - - - - - - -->
   <spinner3 v-if="show_spinner"></spinner3>
   <!-- - - - - - -End spinner- - - - - - - -->

   <div class="container-login100-form-btn">
   <button  :disabled="btn_submit" class="login100-form-btn">Login</button>
   </div>
   <div class="text-center p-t-136"></div>
   </form>
   </div>
   </div>
   </div>


</template>

<script>
    import spinner3 from '@/components/spinner3';
    import logo_site from "@/assets/Logo-login.png";

  export default {
    name: 'login',
    components: {
      spinner3
    },
     data: () => ({
        logo_site:logo_site,
        username: null,
        password: null,
        show_spinner: false,
        btn_submit: false,
     }),//end data
    created(){
      if( localStorage.getItem('jwt') )
      {
         console.log('(login)auth redirect');
         this.$router.push('/Product');
      }
    },
    methods:{
      login()
      {
         if(!this.username || !this.password){
            new Noty({text: 'please enter the data' , type: 'error' ,layout:'center' }).show(); //alert(xhr.responseText);
            return ;
         }

         var the_data = {
            username: this.username ,
            password: this.password ,
         };

         this.show_spinner = true;

         $.post(`${Admin_BASE_url}/login`, the_data )
          .done( function(Response){
               if(Response.status == 'failed'){
                  new Noty({text: 'wrong data' , type: 'error',layout:'center'  }).show();
                  this.show_spinner = false;
               }
               else {
                  localStorage.setItem('jwt',Response.jwt);
                  localStorage.setItem('Permissions',Response.Permissions);
                  this.$router.push('/');
               }
          }.bind(this))
          .fail( function(xhr, textStatus, errorThrown) {
               new Noty({text: 'proplem' , type: 'error' ,layout:'center'  }).show();
               this.show_spinner = false;
          }.bind(this));
      }
    }//End methods
}//End export default
</script>
