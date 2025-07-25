/**
 *	Custom jQuery Scripts
 *	
 *	Developed by: Lisa DeBona
 */

jQuery(document).ready(function ($) {

  /* Mobile Navigation */
  adjustElements();
  $(window).on('orientationchange resize',function(){
    adjustElements();
  });

  function adjustElements() {
    if( $(window).width() < 1140 ) {
      $('.desktop-navigation .primary-menu-wrap').appendTo('.mobile-navigation');
      $('.banner-top-text .reg-button').prependTo('.home-content');
    } else {
      $('.mobile-navigation .primary-menu-wrap').appendTo('.desktop-navigation');
      $('.home-content .reg-button').prependTo('.banner-top-text .wrapper');
      // For new homepage
      $('.desktop-navigation .primary-menu-wrap').appendTo('.navigation-forall');
    }
  }

  $(document).on('click','#mobile-menu-toggle',function(){
    $('body').toggleClass('mobile-menu-open');
    $(this).toggleClass('active');
    $('.mobile-navigation').toggleClass('active');
  });

  $(document).on('click','#overlay',function(){
    $(this).removeClass('active');
    $('body').removeClass('mobile-menu-open');
    $('#mobile-menu-toggle').removeClass('active');
    $('.mobile-navigation').removeClass('active');
  });

  $('.subpageSlides').flexslider({
    animation: "fade",
    smoothHeight: true
  });

  $('.loop').owlCarousel({
    center: true,
    items:2,
    nav: true,
    loop:true,
    margin:15,
    autoplay:true,
    smartSpeed: 1000,
    autoplayTimeout:10000,
    autoplayHoverPause:true,
    // stagePadding: 20,
    responsive:{
      600:{
        items:2
      },
      400:{
        items:1
      }
    }
});

// Festival Schedule for New Homepage
// $('.festival-sched-loop').owlCarousel({
//   center: false,
//   items: 2,
//   nav: true,
//   loop: true,
//   margin: 15,
//   autoplay:true,
//   smartSpeed: 1000,
//   autoplayTimeout:5000,
//   autoplayHoverPause: true,
//   responsive:{
//     0:{
//       items:1
//     },
//     786:{
//       items:2
//     }
//   }
// });

var swiper = new Swiper(".festival-sched-swiper", {
  slidesPerView: 2,
  spaceBetween: 30,
  speed: 1000,
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  autoplay: {
    delay: 5000,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  // Responsive breakpoints
  breakpoints: {
    // when window width is >= 640px
    320: {
      slidesPerView: 1,
      spaceBetween: 20
    },
    640: {
      slidesPerView: 2,
      spaceBetween: 40
    }
  }
});


// $('.festival-sched-loop').slick({
//   arrows: true,
//   dots: true,
//   infinite: true,
//   slidesToShow: 2,
//   slidesToScroll: 1,
//   autoplay: true,
//   autoplaySpeed: 2000,
//   responsive: [
//     {
//       breakpoint: 768,
//       settings: {
//         centerMode: fasle,
//         centerPadding: '40px',
//         slidesToShow: 2
//       }
//     },
//     {
//       breakpoint: 480,
//       settings: {
//         centerMode: true,
//         centerPadding: '40px',
//         slidesToShow: 1
//       }
//     }
//   ]
// });

$('.sponsors-loop').owlCarousel({
  center: false,
  items:4,
  nav: false,
  loop:false,
  margin:15,
  autoplay:true,
  smartSpeed: 1000,
  autoplayTimeout:5000,
  autoplayHoverPause:true,
  // stagePadding: 20,
  responsive:{
    0:{
      items:1
    },
    786:{
      items:3
    },
    960:{
      items:4
    }
  }
});

  /* Move Submenu Dropdown  to #dropdown-container */
  // $('#primary-menu > li.menu-item-has-children ul.sub-menu').each(function(){
  //   var menuId = $(this).parents('li').attr('id');
  //   var submenuId = 'children-'+menuId;
  //   if( $('#dropdown-container #'+submenuId ).length==0 ) {
  //     $(this).attr('id',submenuId).appendTo('#dropdown-container');
  //   }
  // });

  $('#primary-menu > li.menu-item-has-children > a').each(function(){
    var parentLink = $(this).attr('href');
    $(this).attr('data-href',parentLink);
  });

  changeParentLinkMobile();
  $(window).on('orientationchange resize',function(){
    changeParentLinkMobile();
  });
  function changeParentLinkMobile() {
    if( $(window).width() < 1140 ) {
      /* Remove parent link on Mobile View for menu with dropdown */
      $('#primary-menu > li.menu-item-has-children > a').each(function(){
        $(this).attr('href','javascript:void(0)').addClass('mobile-parent-link');
      });
    } else {
      $('#primary-menu > li.menu-item-has-children > a').each(function(){
        var parentLink = $(this).attr('data-href');
        $(this).attr('href',parentLink).removeClass('mobile-parent-link');
      });
    }
  }

  $(document).on("click","a.mobile-parent-link",function(e){
    e.preventDefault();
    $(this).next().slideToggle();
  });
	
	var swiper = new Swiper('#slideshow', {
		effect: 'fade', /* "fade", "cube", "coverflow" or "flip" */
		loop: true,
		noSwiping: false,
		simulateTouch : false,
		speed: 1000,
		autoplay: {
			delay: 4000,
		}
    });

    /* Smooth Scroll */
    $('a[href*="#"]')
	  .not('[href="#"]')
	  .not('[href="#0"]')
	  .click(function(event) {
	    // On-page links
	    if (
	      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
	      && 
	      location.hostname == this.hostname
	    ) {
	      // Figure out element to scroll to
	      var target = $(this.hash);
	      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
	      // Does a scroll target exist?
	      if (target.length) {
	        // Only prevent default if animation is actually gonna happen
	        event.preventDefault();
	        $('html, body').animate({
	          scrollTop: target.offset().top
	        }, 1000, function() {
	          // Callback after animation
	          // Must change focus!
	          var $target = $(target);
	          $target.focus();
	          if ($target.is(":focus")) { // Checking if the target was focused
	            return false;
	          } else {
	            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
	            $target.focus(); // Set focus again
	          };
	        });
	      }
	    }
	});

  /* Artists - Accordion */
  // $('.column.post-type-artists').on("click",function(e){
  //   e.preventDefault();
  //   var target = $(this);
  //   var post_id = $(this).attr('data-postid');
  //   var parent = $(this).parents('.parent-wrap');
  //   $('.column.post-type-artists').not(target).removeClass('active');
  //   target.addClass('active');
  //   $.ajax({
  //     url : frontajax.ajaxurl,
  //     type : 'post',
  //     dataType : "json",
  //     data : {
  //       action : 'getPostData',
  //       post_id : post_id
  //     },
  //     beforeSend:function(){
  //       //$(".ml-loader-wrap").show();
  //       if( $('.event-details').length ) {
  //         $('.event-details').remove();
  //       }
  //       $(window).on('orientationchange resize',function(){
  //         if( $('.event-details').length ) {
  //           $('.event-details').remove();
  //         }
  //       });
  //       $('body').removeClass('closed-event-details');
  //     },
  //     success:function(response) {
  //       if(response.content) {

  //         if( $(window).width() < 821 ) {
  //           //$(response.content).appendTo(target);
  //           $(response.content).insertAfter(target);
  //         } else {
  //           $(response.content).appendTo(parent);
  //         }

  //         $(window).on('orientationchange resize',function(){
  //           if( $(window).width() < 821 ) {
  //             $(response.content).insertAfter(target);
  //           } else {
  //             if( $('body').hasClass('closed-event-details') ){
  //               //do nothing...
  //             } else {
  //               $(response.content).appendTo(parent);
  //             }
  //           }
  //         });

  //       }
  //     },
  //     complete:function(){
  //       $(document).on('click','.close-event-info',function(){
  //         $('#event-details').remove();
  //         $('body').addClass('closed-event-details');
  //         $('.column.post-type-artists').removeClass('active');
  //       });
  //     }
  //   });
  // });

  /* Artists - Popup */
	$('.column.post-type-artists .button-small a').on("click",function(e){
    e.preventDefault();
    var id = $(this).attr('data-id');
    $.ajax({
      url : frontajax.ajaxurl,
      type : 'post',
      dataType : "json",
      data : {
        action : 'getPostData',
        post_id : id
      },
      beforeSend:function(){
        $('#loader').show();
      },
      success : function( response ) {
        if(response.content) {
          $('#popup-content').html(response.content);
          $('#popup-content').addClass('show');
          $('#overlay').addClass('show');
          $('body').addClass('popup-open');
        } 
      },
      complete: function() {
        $('#loader').hide();
        $(document).on('click','#overlay',function(){
          $('#popup-content').removeClass('show');
          $('body').removeClass('popup-open');
          $('#overlay').removeClass('show');
        });
        $('#closePopUp').on('click',function(){
          $('#popup-content').removeClass('show');
          $('#overlay').removeClass('show');
          $('body').removeClass('popup-open');
          $('#popup-content').html("");
        });
      }
    });
  });

  /* Artists - Popup for Learn More */
	$('.column.post-type-artists .more-details').on("click", function(e){
    e.preventDefault();
    var item = $(this).data('item');
    var postId = $(this).data('id');

    $.ajax({
      url : frontajax.ajaxurl,
      type : 'post',
      dataType : "json",
      data : {
        action : 'activity_learn_more',
        postId: postId,
        item: item
      },
      beforeSend:function(){
        $('#loader').show();
      },
      success : function( response ) {
        if(response.content) {
          $('#popup-content').html(response.content);
          $('#popup-content').addClass('show');
          $('#overlay').addClass('show');
          $('body').addClass('popup-open');
        } 
      },
      complete: function() {
        $('#loader').hide();
        $(document).on('click','#overlay',function(){
          $('#popup-content').removeClass('show');
          $('body').removeClass('popup-open');
          $('#overlay').removeClass('show');
        });
        $('#closePopUp').on('click',function(){
          $('#popup-content').removeClass('show');
          $('#overlay').removeClass('show');
          $('body').removeClass('popup-open');
          $('#popup-content').html("");
        });
      }
    });
  });

	/*
	*
	*	Wow Animation
	*
	------------------------------------*/
	new WOW().init();

  $('.matchHeight').matchHeight();

	$(document).on("click","#toggleMenu",function(){
		$(this).toggleClass('open');
		$('body').toggleClass('open-mobile-menu');
	});


  /* POP-UP POST TYPE INFO */
  $('#popup-info .postinfo').on("click",function(e){
    e.preventDefault();
    var id = $(this).attr('data-id');
    $.ajax({
      url : frontajax.ajaxurl,
      type : 'post',
      dataType : "json",
      data : {
        action : 'get_post_info',
        postid : id
      },
      beforeSend:function(){
        $('#loader').show();
      },
      success : function( response ) {
        if(response.content) {
          $('#popup-content').html(response.content);
          $('#popup-content').addClass('show');
          $('#overlay').addClass('show');
          $('body').addClass('popup-open');
        } 
      },
      complete: function() {
        $('#loader').hide();
        $(document).on('click','#overlay',function(){
          $('#popup-content').removeClass('show');
          $('body').removeClass('popup-open');
          $('#overlay').removeClass('show');
        });
        $('#closePopUp').on('click',function(){
          $('#popup-content').removeClass('show');
          $('#overlay').removeClass('show');
          $('body').removeClass('popup-open');
          $('#popup-content').html("");
        });
      }
    });
  });


  /* Pop-up Scheduled Activity */
  $('.popup-activity-schedule').on("click",function(e){
    e.preventDefault();
    var id = $(this).attr('data-id');
    $.ajax({
      url : frontajax.ajaxurl,
      type : 'post',
      dataType : "json",
      data : {
        action : 'get_post_basic_content',
        postid : id
      },
      beforeSend:function(){
        $('#loader').show();
      },
      success : function( response ) {
        if(response.content) {
          $('#popup-content').html(response.content);
          $('#popup-content').addClass('show');
          $('#overlay').addClass('show');
          $('body').addClass('popup-open');
        } 
      },
      complete: function() {
        $('#loader').hide();
      }
    });
  });

  /* Close custom pop-up */
  $(document).click(function() {
    var container = $(".popup-content");
    if (!container.is(event.target) && !container.has(event.target).length) {
      closeCustomPopUp();
    }
  });

  $(document).on('click','#closeModalBtn',function(e){
    e.preventDefault();
    closeCustomPopUp();
  });

  function closeCustomPopUp() {
    $('#popup-content').removeClass('show');
    $('body').removeClass('popup-open');
    $('#overlay').removeClass('show');
    $('#popup-content .popup-content').remove();
  }

  /* FAQS */
  $(document).on('click','.faqrow .question',function(){
    $(this).parent().toggleClass('active');
    $(this).next().slideToggle();
  });

  /* SCHEDULE */
  $(document).on('click','.sched-accordion .sched-title',function(){
    var elem = $(this);
    elem.parent().toggleClass('active');

    var id = elem.attr('data-id');
    if(!elem.hasClass('loaded')) {
      $.ajax({
        url : frontajax.ajaxurl,
        type : 'post',
        dataType : "json",
        data : {
          action : 'get_post_info',
          postid : id
        },
        beforeSend:function(){
          $('#loader').show();
        },
        success : function( response ) {
          if(response.content) {
            elem.next().html(response.content);
            elem.addClass('loaded');
            elem.next().slideToggle();
          } 
        },
        complete: function() {
          $('#loader').hide();
        }
      });
    } else {
      elem.next().slideToggle();
    }
  });

  // Insider's guide sidebar scroll
  if( $('.insider-content-sidebar').length) {
    $(window).on('scroll', function() {
      let s = $('#main'),
          sw = s.find('.insider-content-sidebar'),
          sn = s.find('.stickyNav'),
          f = $('footer'),
          windowWidth = $(window).width(),
          windowScrollTop = $(window).scrollTop(),
          elementOffset = s.offset().top + 85;
      if(elementOffset <= windowScrollTop && windowWidth >= 1140) {
        sn.css({position:'fixed',width:sw.width()+'px'});

        if( ((s.offset().top + s.height()) - sn.height() - 20) <= windowScrollTop ) {
          sn.css({top:'initial',bottom:(f.height()+30)+'px'});
        } else {
          sn.css({top:'5rem',bottom:'initial'});
        }
      } else {
        sn.css({position:'initial',width:'auto'});
      }
    });
  }

  // Schedule sticky legends
  if( $('.indication').length) {
    $(window).on('scroll', function() {
      let s = $('#main'),
          sn = s.find('.indication'),
          windowWidth = $(window).width(),
          windowScrollTop = $(window).scrollTop(),
          elementOffset = s.offset().top + 350;
      if(elementOffset <= windowScrollTop && windowWidth >= 1140) {
        sn.css({position:'fixed',top:'0',width:'100%',padding:'15px 0'});
      } else if(elementOffset <= windowScrollTop && windowWidth < 1140) {
        sn.css({position:'fixed',top:'120px',width:'100%',padding:'10px 0 15px'});
      } else {
        sn.css({position:'initial'});
      }
    });
  }

});// END #####################################    END