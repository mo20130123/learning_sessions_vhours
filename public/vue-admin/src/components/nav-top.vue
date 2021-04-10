<style lang="scss">
@import "@/scss/_variables.scss";
   #nav-top
   {
      height: 50px;
      background-color: black;
      box-shadow: 2px 2px  #ccc;
      background: $_mainColor;
      padding-left: 225px;
      position: fixed;
      left: 0; right: 0;
      z-index: 3;
      ul{
         padding-top: 8px;
         li{
            display: inline;
            color: white;
            font-size: 20px;
            padding: 0px 15px;
            cursor: pointer;
         }
      }
   }//End #nav-top
</style>
<template>
 <div id="nav-top">

      <ul>
         <li @click="logout()"> <b-icon-lock></b-icon-lock> Logout </li>
         <li @click="toggleDarkTheme()">

            <v-tooltip v-if="!$vuetify.theme.dark" bottom>
               <template v-slot:activator="{ on }">
                  <v-btn v-on="on" color="info" small fab  >
                     <v-icon class="mr-1">mdi-moon-waxing-crescent</v-icon>
                  </v-btn>
               </template>
               <span>Dark Mode On</span>
               </v-tooltip>

               <v-tooltip v-else bottom>
               <template v-slot:activator="{ on }">
                  <v-btn v-on="on" color="info" small fab  >
                     <v-icon color="yellow">mdi-white-balance-sunny</v-icon>
                  </v-btn>
               </template>
               <span>Dark Mode Off</span>
            </v-tooltip>

         </li>
      </ul>

 </div>
</template>

<script>
  export default {
    name: 'navBar',
    mounted(){

   },
    data: () => ({

    }),
    methods:{
        logout(){
           localStorage.removeItem('jwt');
           this.$router.push('/login');
        },
        toggleDarkTheme() {
              this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
              console.log(this.$vuetify.theme.dark);
        },
    }
  }
</script>
