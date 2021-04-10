$(function(){
    $('header .fa-bars').on('click',function(){
        console.log('hello');
        $('nav').addClass('active')
    });
    $('nav .fa-times').on('click',function(){
        $('nav').removeClass('active')
    });
})