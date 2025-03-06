<script type="text/javascript">
jQuery(document).ready(function ($) {
	$(document).on("click",".wtw-options .collapsible",function(){
		//var parent = $(this).parents(".collapsible")
		var image_part = $(this).attr("data-part");
		var default_image = ( $("#defaultModel").length> 0 ) ? $("#defaultModel").attr('data-default') : '';

		if( $(this).hasClass('active') ) {
			$(this).removeClass("active fadeIn");
			$(".partImg").removeClass("fadeIn");
		} else {
			$(".wtw-options .collapsible").removeClass("active fadeIn");
			$(this).addClass("active fadeIn");

			if( default_image ) {
				if( $(image_part).length > 0 ) {
					var img_src = $(image_part).attr('data-src');
					$(".partImg").removeClass("fadeIn");
					$(image_part).addClass("fadeIn");
				} else {
					$(".partImg").removeClass("fadeIn");
				}
			}
		}		

		
	});

	$(document).on("click",".wtw-options .collapsiblewtw",function(){
		//var parent = $(this).parents(".collapsible")
		var image_part = $(this).attr("data-part");
		var default_image = ( $("#defaultModel").length> 0 ) ? $("#defaultModel").attr('data-default') : '';

		if( $(this).hasClass('active') ) {
			$(this).removeClass("active fadeIn");
			$(".partImg").removeClass("fadeIn");
		} else {
			$(".wtw-options .collapsiblewtw").removeClass("active fadeIn");
			$(this).addClass("active fadeIn");

			if( default_image ) {
				if( $(image_part).length > 0 ) {
					var img_src = $(image_part).attr('data-src');
					$(".partImg").removeClass("fadeIn");
					$(image_part).addClass("fadeIn");
				} else {
					$(".partImg").removeClass("fadeIn");
				}
			}
		}		

		
	}); 

	/* FAQS */
	// $(".faqsItems .collapsible").on("click",function(){

	// 	if( $(this).hasClass('active') ) {
	// 		$(this).removeClass("active fadeIn");
	// 	} else {
	// 		$(".faqsItems .collapsible").removeClass("active fadeIn");
	// 		$(this).addClass("active fadeIn");
	// 	}
		
	// }); 

  $(document).on("click",".collapsible h3.option-name",function(e){
   e.preventDefault();
   var parent = $(this).parent();
   if( parent.hasClass('active') ) {
     parent.removeClass("active fadeIn");
   } else {
     $(".faqsItems .collapsible").removeClass("active fadeIn");
     parent.addClass("active fadeIn");
   }
  }); 

  $(document).on("click",".collapsiblewtw",function(e){
   e.preventDefault();
   var parent = $(this).parent();
   if( parent.hasClass('active') ) {
     parent.removeClass("active fadeIn");
   } else {
     $(".faqsItems .collapsiblewtw").removeClass("active fadeIn");
     parent.addClass("active fadeIn");
   }
  });


	if( $(".col.options").length>0 && $("#defaultModel").length>0 ) {
		var optionsHeight = $(".col.options").height();
		$("#defaultModel").css("height",optionsHeight+"px");
	}

	/* page anchors */
	if( $('[data-section]').length > 0 ) {
		var tabs = '';
		$('[data-section]').each(function(){
			var name = $(this).attr('data-section').trim();
			var str = name.replace(/\s/g,'');
			var id = $(this).attr("id");
			if(str) {
				tabs += '<span class="mini-nav"><a href="#'+id+'">'+name+'</a></span>';
			}
		});

		if( $("#pageTabs").length>0 ) {
			$("#pageTabs").html('<div class="wrapper"><div id="tabcontent">'+tabs+'</div></div>');
			$("#pageTabs").show();
		}
		
	}


	$("#legend-info").on("click",function(){
		$("#legendData").toggleClass('show');
	});


	$(document).on("click",function(e) {
    var selectors = ['#legend-info','#legendData'];
    var target = e.target;
    var is_legend = [];
    if( $(target).attr("id")!=undefined && $(target).attr("id")=='legend-info' ) {
    	is_legend.push(1);
    }

    $(target).parents().each(function(k,v){
    	if( $(this).hasClass("legend") ) {
    		is_legend.push(1);
    	}
    });

    if(is_legend.length==0) {
    	$("#legendData").removeClass('show');
    }
	});

	$(document).on("click","#tabcontent a",function(e) {
		$("body").addClass('subnav-clicked');
	});
	
});
</script>