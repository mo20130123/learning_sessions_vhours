import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

  const routes = [
     { path: '/login'      , name: 'login'      , component: () => import('@/views/login.vue'       ), meta: { guest       : true } },
     { path: '/'           , name: 'Home'       , component: () => import('@/views/Home.vue'        ), meta: { requiresAuth: true } },
     { path: '/Admin'      , name: 'Admin'      , component: () => import('@/views/Admin/Admins.vue'), meta: { requiresAuth: true } },
     { path: '/Roles'      , name: 'Roles'      , component: () => import('@/views/Admin/Roles.vue' ), meta: { requiresAuth: true } },
     { path: '/Dashboard'  , name: 'Dashboard'  , component: () => import('@/views/Dashboard.vue'   ), meta: { requiresAuth: true } },
     { path: '/PagesBanner', name: 'PagesBanner', component: () => import('@/views/PagesBanner.vue' ), meta: { requiresAuth: true } },
     { path: '/Setting'    , name: 'Setting'    , component: () => import('@/views/Setting.vue'     ), meta: { requiresAuth: true } },
//==============================================================\\
     { path: '/Member',                component: () => import('@/views/Member/index.vue'),          name:'Member',    meta: {requiresAuth: true} },
     { path: '/ContactUs',             component: () => import('@/views/ContactUs/index.vue'),       name:'ContactUs',    meta: {requiresAuth: true} },
     { path: '/BecomeProveder',        component: () => import('@/views/BecomeProveder/index.vue'),  name:'BecomeProveder',    meta: {requiresAuth: true} },
     { path: '/Subscriber',            component: () => import('@/views/Subscriber/index.vue'),      name:'Subscriber',    meta: {requiresAuth: true} },
     { path: '/Product/create',        component: () => import('@/views/Product/create.vue'),        name:'ProductCreate',    meta: {requiresAuth: true} },
     { path: '/Product/edit/:id',      component: () => import('@/views/Product/edit.vue'),          name:'ProductEdit',    meta: {requiresAuth: true} },
     { path: '/PromoCodes',            component: () => import('@/views/PromoCodes/index.vue'),      name:'PromoCodes',    meta: {requiresAuth: true} },
     { path: '/Order',                 component: () => import('@/views/Order/index.vue'),           name:'Order',    meta: {requiresAuth: true} },
     { path: '/Order/details/:id',     component: () => import('@/views/Order/details.vue'),         name:'OrderDetails',    meta: {requiresAuth: true} },
     { path: '/Ordersdetailed',        component: () => import('@/views/Order/Ordersdetailed.vue'),  name:'',                meta: {requiresAuth: true} },
     { path: '/AdsObjectives',         component: () => import('@/views/AdsObjectives/index.vue'),   name:'AdsObjectives',    meta: {requiresAuth: true} },
     { path: '/AdsObjectives/edit/:id',component: () => import('@/views/AdsObjectives/edit.vue'),    name:'AdsObjectivesEdit',    meta: {requiresAuth: true} },
     { path: '*',                      component: () => import('@/views/noRoute'),   },

];

//---------------- stadandrad page array-------------------------
var standradPagesRoutes = [
   'SeoKeywords','HomeSlider',
   'District','City','PopularQuestion','PdfDownloads','CategoriesSubCategories','Brand','FreeTestList',
   'Bundel','Recipe','TermsAndConditions','PrivacyPolicy','DeliveryPolicy','RecipesCategories' ,
   'Category','BaseProduct','Product','Provider',
   'Country','TrustedBy'
];

//---------loop for add standrad Pages Routes (array) to the routes---------
standradPagesRoutes.forEach(function (PagesRoute) {
   routes.push({
       path: `/${PagesRoute}`,
       name: PagesRoute,
       component: () => import(`@/views/${PagesRoute}/index.vue`),
       meta: {
           requiresAuth: true
        }
     },
     {
       path: `/${PagesRoute}/sort`,
       name: `${PagesRoute}Sort`,
       component: () => import(`@/views/${PagesRoute}/sort.vue`),
       meta: {
           requiresAuth: true
        }
     });
});//End loop



const router = new VueRouter({
  routes
});

// ----------Like middelware----------
router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)) {
        if (localStorage.getItem('jwt') == null) {
            next({
                path: '/login',
                params: { nextUrl: to.fullPath }
            })
        } else {
            next()
        }
    } else if(to.matched.some(record => record.meta.guest)) {
        if(localStorage.getItem('jwt') == null){
            next()
        }
        else{
            next({ name: 'Client'})
        }
    }else {
        next()
    }
    next()
});


export default router
