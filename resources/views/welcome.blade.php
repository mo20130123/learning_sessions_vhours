
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <style>
        /*body{ width: 100%; height: 100%; }*/
        /*.wrapper{ width: 100%; height: 100%; }*/
        .flex-contanier{
            display: flex;
            flex-wrap: wrap;
            background-color: honeydew;
        }
        .box{
            height: 100px;
            min-width: 100px;
        }
        .one{
            background-color: blueviolet;
            flex-grow: 3;
        }
        .two{
            background-color: red;
            flex-grow: 6;
        }
        .three{
            background-color: green;
            flex-grow: 3;
        }

        .go {
            background-color: #00a651;
        }
    </style>
</head>
<body >
<div id="myVue">

    <div class="wrapper">
        <div class="flex-contanier">
            <div class="box one">

            </div>
            <div class="box two">

            </div>
            <div class="box three">

            </div>
        </div>
    </div>

    <z-row class="go" style="color: black">
        <z-col col="5">
            col 1
        </z-col>
        <z-col col="10">
            col 2
        </z-col>
    </z-row>

</div>



<script src="{{asset('js/app.js')}}"></script>

<script>
    let myVue = new Vue({
        el: '#myVue',
        data: {

        },
        mounted(){

        },
        methods:{

        }//End methods
    });//End myVue
</script>

</body>
</html>
