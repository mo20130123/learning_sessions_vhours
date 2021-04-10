<template>
  <section id="navSide-section">
      <div id="navSide-section-inner">

        <div id="navTop-info">
                  <br>
          <img :src="logo_site" width="100px">
        </div><!--End #navTop-info-->

        <div id="navTop-items">

           <p style="color:red">  </p>
           <div  v-for="Devition in theLiks">
             <p class="xs-title">{{Devition.Devition_name}}</p>
             <ul>
               <li v-for="link in Devition.links" :class="['item',{'active': link.activeLinks.includes(currentRoute) }]"  v-if="check_Permission(link.permission)" >
                 <router-link :to="link.to">
                    <font-awesome-icon :icon="link.icon" />  <span> {{link.label}} </span>
                 </router-link>
               </li>
             </ul>
           </div>



        </div><!--End navTop-items-->
      </div><!--End #navSide-section-inner-->
  </section>
</template>

<script>
  import logo_site from "@/assets/logo_site.svg";

  var theLiks = [
     {
        Devition_name: 'Dashboard',
        links: [
          {
            label: 'Dashboard',
            to: '/Dashboard',
            icon: 'tachometer-alt',
            permission: '',
            activeLinks: []
          },
        ]
     },

     {
        Devition_name: 'Products',
        links: [
          {
            label: 'Providers',
            to: '/Provider',
            icon: 'archive',
            permission: '',
            activeLinks: ['Provider','ProviderSort']
          },
          {
            label: 'Categories',
            to: '/Category',
            icon: 'archive',
            permission: '',
            activeLinks: ['Category','CategorySort']
          },
          {
            label: 'Base Products',
            to: '/BaseProduct',
            icon: 'box-open',
            permission: '',
            activeLinks: ['BaseProduct','BaseProductSort']
          },
          {
            label: 'Products',
            to: '/Product',
            icon: 'file-powerpoint',
            permission: '',
            activeLinks: ['Product','ProductSort','ProductCreate','ProductEdit']
          },
          {
            label: 'Ads',
            to: '/AdsObjectives',
            icon: 'ad',
            permission: '',
            activeLinks: ['AdsObjectives','AdsObjectivesEdit']
          },
        ]
     },

     {
        Devition_name: 'user',
        links: [
          {
            label: 'Countries',
            to: '/Country',
            icon: 'flag',
            permission: '',
            activeLinks: ['Country']
          },
          {
            label: 'Member',
            to: '/Member',
            icon: 'users',
            permission: '',
            activeLinks: ['Member']
          },
          {
            label: 'Contact Us',
            to: '/ContactUs',
            icon: 'address-card',
            permission: '',
            activeLinks: ['ContactUs']
          },
          {
            label: 'Become Proveder',
            to: '/BecomeProveder',
            icon: 'address-card',
            permission: '',
            activeLinks: ['BecomeProveder']
          },
          {
            label: 'Subscribers',
            to: '/Subscriber',
            icon: 'user-tie',
            activeLinks: ['Subscriber']
          },
        ]
     },

     {
        Devition_name: 'Orders',
        links: [
          {
            label: 'Promo Codes ',
            to: '/PromoCodes',
            icon: 'percent',
            permission: '',
            activeLinks: ['PromoCodes']
          },
          {
            label: 'Orders',
            to: '/Order',
            icon: 'receipt',
            permission: '',
            activeLinks: ['Order','OrderDetails']
          },
        ]
     },

     {
        Devition_name: 'Control',
        links: [
          {
            label: 'Trusted By',
            to: '/TrustedBy',
            icon: 'hands-helping',
            permission: '',
            activeLinks: ['TrustedBy']
          },
          {
            label: 'FAQs',
            to: '/PopularQuestion',
            icon: 'question-circle',
            permission: '',
            activeLinks: ['PopularQuestion']
          },
          {
            label: 'Terms & Conditions',
            to: '/TermsAndConditions',
            icon: 'sticky-note',
            permission: '',
            activeLinks: ['TermsAndConditions']
          },
          {
            label: 'Privacy Policy',
            to: '/PrivacyPolicy',
            icon: 'user-secret',
            permission: '',
            activeLinks: ['PrivacyPolicy']
          },
          {
            label: 'Pages Banners',
            to: '/PagesBanner',
            icon: 'image',
            permission: '',
            activeLinks: []
          },
        //   {
        //     label: 'News',
        //     to: '/News',
        //     icon: 'newspaper',
        //     permission: '',
        //     activeLinks: []
        //   },
        ]
     },

     {
        Devition_name: 'Setting',
        links: [
          {
            label: 'Info & Content',
            to: '/Setting',
            icon: 'cogs',
            permission: '',
            activeLinks: []
          },
          {
            label: 'Seo Keywords',
            to: '/SeoKeywords',
            icon: 'tachometer-alt',
            permission: '',
            activeLinks: []
          },
        ]
     },

     {
        Devition_name: 'Admin',
        links: [
          {
            label: 'Roles',
            to: '/Admin/Roles',
            icon: 'tasks',
            permission: '',
            activeLinks: []
          },
          {
            label: 'Admins',
            to: '/Admin/Admins',
            icon: 'user-cog',
            permission: '',
            activeLinks: []
          },
        ]
     },
   ];//End var theLiks


  export default {
    name: 'navSide',
    data: () => ({
      logo_site:logo_site,
      Permissions: localStorage.getItem('Permissions').split(','),
      theLiks
    }),
    mounted() {

    },
    computed: {
        currentRoute(){
          console.info('App this router:', this.$route);
          console.info('App this router:', this.$route.name);
          return this.$route.name;
        }
    },
    methods:{
        logout(){
           localStorage.removeItem('jwt');
           this.$router.push('/login');
        },
        check_Permission(Permission)
        {
           if(this.Permissions[0] == 'is_super_admin')
              return  true;
           else
              return  this.Permissions.indexOf(Permission) != -1;
        },
    }
  }
</script>
