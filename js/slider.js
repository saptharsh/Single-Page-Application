$(document).ready(function(){
   //alert('check');
   
   var speed = 500;                 //half a second, fade speed
   var autoswitch = true;           //auto slider options
   var autoswitch_speed = 4000;     //auto slider speed
   
   //Add initial active class(first slide)
   $('.slide').first().addClass('active');
   
   // Hide all slides
   $('.slide').hide();
   
   //Show first slide
   $('.active').show();
   
   /*
    * next functionality
    */
   //next handler
   $('#next').on('click',nextSlide);
   
   /*
    * prev functionality
    */
   //prev handler
   $('#prev').on('click',prevSlide);
   
    // auto slider handler
    if (autoswitch == true) {
        setInterval(nextSlide, autoswitch_speed);
    }
   
    //This function will switch to the next slide
    function nextSlide(){
        /*
         * next functionality
         */
        //alert('right arrow clicked');
        $('.active').removeClass('active').addClass('oldActive');

        //If the slide is the last(DIV), then we have to go back to first
        if ($('.oldActive').is(':last-child')) {
            $('.slide').first().addClass('active');
        }//If it is not the last(DIV) child, then we have to go the next one 
        else {
            $('.oldActive').next().addClass('active');
        }
        $('.oldActive').removeClass('oldActive');//".slide oldActive" becomes-> .slide
        //Class shifting is completed

        $('.slide').fadeOut(speed);
        $('.active').fadeIn(speed);
        
    }
    
    //This function will switch to the next slide
    function prevSlide(){
        /*
        * prev functionality
        */
        //alert('left arrow clicked');
        $('.active').removeClass('active').addClass('oldActive');
      
        //If the slide is the first(DIV), then we have to go back to last
        if($('.oldActive').is(':first-child')){
            $('.slide').last().addClass('active');
        }//If it is not the first(DIV) child, then we have to go the previous one 
        else{
            $('.oldActive').prev().addClass('active');
        }
        $('.oldActive').removeClass('oldActive');//".slide oldActive" becomes-> .slide
        //Class shifting is completed
       
        $('.slide').fadeOut(speed);
        $('.active').fadeIn(speed);
      
    }
    
});









