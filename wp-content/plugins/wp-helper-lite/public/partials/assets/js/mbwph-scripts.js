//Start slide icon
jQuery(document).ready(function($){
  var slideIndex = 0;
  showSlides();
  function showSlides() {
    var i;
    var slides = document.getElementsByClassName('mbwph-sm-icon-item');
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = 'none';
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1} 
    if (slides.length != 0) {
      slides[slideIndex-1].style.display = 'block';  
      setTimeout(showSlides, 2000);  
    } else {
      return false;
    }
  }
});
//End slide icon

//Start show/hide button
jQuery(document).ready(function($){
 $('.mbwph-contact-icon.mbwph-btn').click(function(){
   $('.mbwph-contact-icon').toggleClass('is-active');
   $('.mbwph-inner-text').toggleClass('is-active');
   $('.mbwph-inner-mark').toggleClass('is-close');
   $('.mbwph-inner-mark-border').toggleClass('is-close');
   $('.mbwph-sm-icon').toggleClass('is-close');
 });
 $('.mbwph-close-inner-text').click(function() {
   $('.mbwph-inner-text').addClass('is-close');
 });
$(document).mouseup(function(e) {
  if (!$(".mbwph-contact-icon").is(e.target) && $(".mbwph-contact-icon").has(e.target).length === 0) {
    $(".mbwph-contact-icon").removeClass("is-active");
    $('.mbwph-inner-text').removeClass('is-active');
    $('.mbwph-inner-mark').removeClass('is-close');
    $('.mbwph-inner-mark-border').removeClass('is-close');
    $('.mbwph-sm-icon').removeClass('is-close');
  }
});
});


//End show/hide button

jQuery(document).ready(function($){
  //Start show FB Messenger button
  $(document).ready(function() {
    // click to show popup
    $('.mbwph-messenger').click(function(event) {
     event.preventDefault();
     $('.mbwph-fb-chat').addClass('is-active');
     console.log(FB);
     FB.CustomerChat.show();
     FB.CustomerChat.showDialog();
   });

  });
  //End show FB Messenger button

  //Start show hide scrollToTop
  $(window).scroll(function() {
    if ($(this).scrollTop() > 300) {
     $('.mbwph-scrollToTop').fadeIn();
    } else {
     $('.mbwph-scrollToTop').fadeOut();
    }
  });

   $(".mbwph-scrollToTop").click(function () {
    $("html, body").animate({scrollTop: 0}, 800);
     event.preventDefault();
  });
  //End show hide scrollToTop

});