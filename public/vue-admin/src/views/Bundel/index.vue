<style  lang="scss" >
  #sec_Bundel .active{
    color: green;
  }
  #sec_Bundel
  {
      .v-carousel__controls
      {
        height: 30px;
      }
      .v-btn--icon.v-size--default
      {
        height: 30px;
        width: 30px;
      }
  }

</style>
<template>
  <div class="page-wrapper" id="sec_Bundel">
      <h2 class="font-italic font-weight-light font-weight-bold">Bundels</h2>

     <section class="section-page-control">
        <v-row>
           <v-col cols="5" style="padding-bottom: 0px;">
             <router-link to="/Bundel/create"> <v-btn class="ma-2" outlined color="indigo"> <b-icon-plus></b-icon-plus> Add New</v-btn> </router-link>
             <router-link to="/Bundel/sort"> <v-btn class="ma-2" outlined color="black"> <b-icon-filter></b-icon-filter> Sort  </v-btn> </router-link>

          </v-col>
          <v-col  style="padding-bottom: 0px;">
              <div class="text-right">
                <v-select @change="getResults()" outlined v-model="ST.stock" :items="stock_search" item-text="label" item-value="value" label="Stock" style="width:42%;display:inline-block;margin-right:10px" ></v-select>
                 <v-text-field v-model="ST.search" @keyup.enter="getResults()" label="Search" outlined shaped style="width:42%;display:inline-block;" ></v-text-field>
                <v-btn @click="getResults()" class="ma-2 btn-refresh" fab outlined color="indigo"> <b-icon-arrow-repeat font-scale="1.5"></b-icon-arrow-repeat> </v-btn>
              </div>
          </v-col>
        </v-row>
        <v-row>
          <v-col style="padding: 0 5px;">
                <div class="text-center">
                     <!-- <v-btn @click="getResults()" class="ma-2 btn-refresh" fab  outlined   color="indigo"> <b-icon-arrow-repeat font-scale="1.5"></b-icon-arrow-repeat> </v-btn> -->
                </div>
          </v-col>
        </v-row>
    </section><!--End section-page-control-->

    <table class="tbl_mainList">
       <thead>
          <th> Id </th>
          <th> Image </th>
          <th> Name   </th>
          <th> Label </th>
          <th> Created date </th>
          <th> Action </th>
       </thead>
       <tbody is="transition-group" name="my-list" >
          <tr v-for="(item,index) in mainList.data" :key="item.id">
             <td>{{ item.id }}</td>
             <td style="width: 25%;">
                 <div style="width:250px">

                   <v-carousel  height="200px">
                      <v-carousel-item v-for="image in item.images" :key="image.id" :src="image.image" ></v-carousel-item>
                   </v-carousel>

                     <!-- <swiper class="swiper" ref="mySwiper" :options="swiperOptions" :auto-update="true">
                          <swiper-slide v-for="image in item.images" :key="image.id"> <img :src="image.image" class="img-table"> </swiper-slide>
                          <div class="swiper-pagination swiper-pagination-white" slot="pagination"></div>
                     </swiper> -->
                 </div>
             </td>
             <td>
                <p>{{ item.name_en }}</p>
                <p>{{ item.name_ar }}</p>
             </td>
             <td style="background-color:#268FB3">
               <p>{{item.bundle_summary_en}}</p>
             </td>
             <td>
                {{ item.created_at }} <br> [{{ item.created_at | moment("from", "now") }}]
                     <hr>
                <p style="margin-bottom: 0px;">
                     <b>Stock:</b>
                     <span> {{item.quantity}} </span>
                </p>
                <p style="margin-bottom: 0px;">
                     <b>Price:</b>
                     <span> {{item.price}} EGP </span>
                </p>
           </td>
             <td style="width: 20%;">
               <div class="">
                   <div>
                     <b-icon-eye       v-if="item.status" @click="showORhide(item)" font-scale="1.6" variant="success"></b-icon-eye>
                     <b-icon-eye-slash v-else             @click="showORhide(item)" font-scale="1.6" variant="danger"></b-icon-eye-slash>
                   </div>
                   <div>
                     <router-link :to="'/Bundel/edit/'+item.id" >
                       <b-icon-pencil-square font-scale="1.6" color="black" ></b-icon-pencil-square>
                     </router-link>
                   </div>
                   <div>
                     <b-icon-trash @click="del_row(item,index)" font-scale="1.6" variant="danger" ></b-icon-trash>
                   </div>
               </div>
               <br>
             </td>
          </tr>
       </tbody>
    </table>

       <!-- - - - - - -START spinner & paginate - - - - - - - -->
       <spinnerPagnation :mainList="mainList" :show_spinner="show_spinner" @getResults="getResults"></spinnerPagnation>
       <!-- - - - - - -END spinner & paginate - - - - - - - -->


  </div><!--End page-wrapper-->
</template>

<script>
  import {AdminMixin} from '@/mixins/Admin_mixin';

  export default {
    name: 'Bundel',
    mixins: [AdminMixin],
     data: () => ({
        Permission: 'Bundel',
        api_get_list: 'Bundel/list',
        api_showORhide: 'Bundel/showORhide',
        api_delete: 'Bundel/delete',
        stock_search: [
          { label: 'All' , value: null },
          { label: 'stock < 15' , value: '15' },
          { label: 'stock < 10' , value: '10' },
          { label: 'stock < 5' , value: '5' },
          { label: 'stock = 0' , value: '0' },
        ],

       //  swiperOptions: {
       //     pagination: {
       //       el: '.swiper-pagination',
       //       type: 'fraction'
       //     },
       //     navigation: {
       //       nextEl: '.swiper-button-next',
       //       prevEl: '.swiper-button-prev'
       //     },
       //     flipEffect: {
       //            slideShadows : true, //slides the shadow. The default is true.
       //            limitRotation : true, // Limit the maximum rotation angle to 180 degrees, the default is true.
       //     },
       //     autoplay: {
       //            Delay: 3000, // ​​automatic switching interval, in ms
       //            stopOnLastSlide: false, //stop automatic switching when switching to the last slide
       //            stopOnLastSlide: true, // If set to true, stops automatic switching when switching to the last slide.
       //            disableOnInteraction: true, // Whether to disable autoplay after the user operates the swimper.
       //            reverseDirection: true, // Turn on reverse autorotation.
       //            waitForTransition: true, //wait for the transition to complete. Automatic switching will start timing after the slide transition is complete.
       //     },
       // }

    }),//end data
    created(){

    },
    mounted() {
        // this.swiper.slideTo(3, 1000, false)
     },
    methods:{

    },//End methods
    computed: {
      // swiper() {
      //   return this.$refs.mySwiper.$swiper
      // }
    },
}//End export default
</script>
