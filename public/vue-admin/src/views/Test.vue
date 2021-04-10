<template>
  <div class="Test">
    <h1>This is a Test page</h1>
    {{myText}}

    <pre>
    <textarea name="name" rows="8" cols="80" v-model="myText" style="white-space:pre">  </textarea>

    <v-textarea label="Description En" v-model="myText" name="input-7-4" outlined rows="5"   style="white-space:pre"></v-textarea>
    </pre>


  </div>
</template>
<script>
export default {
  name: 'Test',
   data: () => ({
     // myText: ' line one\nline two2 '
     myText: '222\nd1\nd2\nd3'
  }),//end
  created(){
    this.getResults();
  },
  methods:{
       getResults(){
            this.Applicants = [];
            this.show_spinner = true;
            // $.ajax({
            //       type:"get",
            //       url: `${Admin_BASE_url}/Product/show/1063` ,
            //       headers: { 'jwt': localStorage.getItem('jwt') },
            //  })
            //  .done(function(Response){
            //
            //     this.Ef = Response.Product;
            //     this.myText = Response.Product.description_en.toString();
            //          this.$forceUpdate();
            //
            //  }.bind(this))
            //  .fail(function(data){
            //    new Noty({text: 'proplem' , type: 'error'  }).show();
            //  });

             axios.get(`${Admin_BASE_url}/Product/show/1063`, {
                  headers: {
                    'jwt': localStorage.getItem('jwt')
                  }
              })
              .then(function (response) { console.log('then');
              console.log(this.myText);
                console.log(response.data.Product.description_en);
                this.myText = response.data.Product.description_en.replace('\\n','\n') ;
                this.$forceUpdate();
              }.bind(this))
              .catch(function (error) {
                new Noty({text: 'proplem' , type: 'error'  }).show();
              }) ;

       },
  }
}

</script>
