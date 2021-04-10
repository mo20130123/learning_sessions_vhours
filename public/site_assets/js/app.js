        $(function(){
            $('.fa-bars').on('click',function(){
                $('#menu').addClass('active');
            });
            $('.close-menu').on('click',function(){
                $('#menu').removeClass('active');
            });
        });

        // /*slider drag*/
        //     /*--definitions--*/
        //     const slider = document.querySelector('.slider');
        //     let isDown = false;
        //     let startX;
        //     let scrollLeft;

        //     /*--mousedown event--*/
        //     slider.addEventListener('mousedown',(e) => {
        //         isDown = true;
        //         slider.classList.add('active');
        //         startX = e.pageX - slider.offsetLeft;
        //         scrollLeft = slider.scrollLeft;
        //     });

        //     /*--mouseleave event--*/
        //     slider.addEventListener('mouseleave',() => {
        //         isDown = false;
        //         slider.classList.remove('active');
        //     });

        //     /*--mouseup event--*/
        //     slider.addEventListener('mouseup',() => {
        //         isDown = false;
        //         slider.classList.remove('active');
        //     });

        //     /*--mousemove event--*/
        //     slider.addEventListener('mousemove',(e) => {
        //         if(!isDown) return;
        //         e.preventDefault();
        //         const x = e.pageX - slider.offsetLeft;
        //         const walk = (x - startX) ;
        //         slider.scrollLeft = scrollLeft - walk;

        //     });

     

       