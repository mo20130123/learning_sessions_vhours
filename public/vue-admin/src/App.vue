<style  lang="scss">
@import "@/scss/main.scss";
</style>
<template>
    <div>
          <div v-if="currentRoute == 'login'">
              <login></login>
          </div>
          <v-app v-else>
                  <nav-side />
                  <nav-top />
                  <div id="right-content">
                      <vue-page-transition name="fade-in-left">
                        <router-view/>
                    </vue-page-transition>
                  </div><!--end #right-content -->
          </v-app>
      </div>
</template>

<script>
import navTop from '@/components/nav-top';
import navSide from '@/components/nav-side';
import login from '@/views/login';

export default {
  name: 'App',

  components: {
    navTop,navSide, login
  },

  data: () => ({
    //
   }),
   computed: {
       currentRoute(){
         console.info('App this router: AppVue', this.$route.name);
         // console.info('get jwt ', localStorage.getItem('jwt'));
         return this.$route.name;
       }
   },
};
</script>
