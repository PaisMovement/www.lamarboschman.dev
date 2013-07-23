jQuery(document).ready(function($){
	jQuery(document).ready(function(){
	  // Create the dropdown base
	jQuery("<select />").appendTo("nav");
	  
	  // Create default option "Go to..."
	  jQuery("<option />", {
		 "selected": "selected",
		 "value"   : "",
		 "text"    : "Menu"
	  }).appendTo("nav select");
	  
	  // Populate dropdown with menu items
	  jQuery("nav a").each(function() {
	   var el = jQuery(this);
	   jQuery("<option />", {
		   "value"   : el.attr("href"),
		   "text"    : el.text()
	   }).appendTo("nav select");
	  });
	   // To make dropdown actually work
	   // To make more unobtrusive: http://css-tricks.com/4064-unobtrusive-page-changer/
	  jQuery("nav select").change(function() {
		window.location = jQuery(this).find("option:selected").val();
	  });
	 
 });
$('.blog-opts .date h1,.news-list li .date h1').each(function() {
   var html = $(this).html();
   var word = html .substr(0, html.indexOf(" "));
   var rest = html .substr(html.indexOf(" "));
   $(this).html(rest).prepend($("<span/>").html(word).addClass("monthly"));
	});
jQuery(document).ready(function(){	
function mycarousel_initCallback(carousel) {
    jQuery('.jcarousel-control a').bind('click', function() {
        carousel.scroll(jQuery.jcarousel.intval(jQuery(this).text()));
        return false;
    });

    jQuery('.jcarousel-scroll select').bind('change', function() {
        carousel.options.scroll = jQuery.jcarousel.intval(this.options[this.selectedIndex].value);
        return false;
    });

    jQuery('.jcarousel-next').bind('click', function() {
        carousel.next();
        return false;
    });

    jQuery('.jcarousel-prev').bind('click', function() {
        carousel.prev();
        return false;
    });
};

// Ride the carousel...
jQuery(document).ready(function() {
    jQuery("#mycarouselcontent").jcarousel({
        scroll: 1,
        initCallback: mycarousel_initCallback,
        // This tells jCarousel NOT to autobuild prev/next buttons
        buttonNextHTML: null,
        buttonPrevHTML: null
    });
});
});
$('.top').click(function () {
 	$('body,html').animate({
		scrollTop: 0
		}, 800);
		return false;
});	

$('form[id=login_frm]').submit(function(){
	if ( $("#log").val() == "" || $("#pwd").val() == "" ) {
		$("#login_msg").html("Empty User name or pwd");
		return false;
	}
	else return true;
});
 	
});
function cs_amimate(id){
	jQuery("#"+id).animate({
		height: 'toggle'
		}, 200, function() {
		// Animation complete.
	});
}
function map_hide_show(id){
	var $ = jQuery;
	jQuery("#"+id).toggleClass("map_hide_show");
}
function event_map(add,lat, long, zoom, counter){
	
 	var map;
		var myLatLng = new google.maps.LatLng(lat,long)
		//Initialize MAP
		var myOptions = {
		  zoom:zoom,
		  center: myLatLng,
		  disableDefaultUI: true,
		  zoomControl: true,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById('map_canvas'+counter),myOptions);
		//End Initialize MAP
		//Set Marker
		var marker = new google.maps.Marker({
		  position: map.getCenter(),
		  map: map
		});
		marker.getPosition();
		//End marker
		
		//Set info window
		var infowindow = new google.maps.InfoWindow({
			content: ""+add,
			position: myLatLng
		});
		google.maps.event.addListener(marker, 'click', function() {
    		infowindow.open(map,marker);
  		});

 }
 
 function remove_text( value ){
 	 jQuery(document).ready(function(){
 		if ( jQuery("#s").val() == value ){
			jQuery("#s").val('');
		}
	 });
	}
 function frm_newsletter( theme_url ){
	
 	$ = jQuery;
	$("#btn_newsletter").hide();
	$("#process_newsletter").html('<img src="'+theme_url+'/images/newsletter-loader.gif" />');
	$.ajax({
		type:'POST', 
		url: theme_url+'/include/newsletter_save.php',
		data:$('#frm_newsletter').serialize(), 
		success: function(response) {
			$('#frm_newsletter').get(0).reset();
			$('#newsletter_mess').show('');
			$('#newsletter_mess').html(response);
			$("#btn_newsletter").show('');
			$("#process_newsletter").html('');
			slideout_msgs();
			//$('#frm_slide').find('.form_result').html(response);
		}
	});
}
function ablum_fliterable( counter ){
	jQuery(window).load(function() {
            var filter_container = jQuery('#portfolio-item-holder'+counter);
        
            filter_container.children().css('position','absolute');	
            filter_container.masonry({
                singleMode: true,
                itemSelector: '.portfolio-item:not(.hide)',
                animate: true,
                animationOptions:{ duration: 800, queue: false }
            });	
            jQuery(window).resize(function(){
                var temp_width =  filter_container.children().filter(':first').width() + 20;
                filter_container.masonry({
                    columnWidth: temp_width,
                    singleMode: true,
                    itemSelector: '.portfolio-item:not(.hide)',
                    animate: true,
                    animationOptions:{ duration: 800, queue: false }
                });		
            });	
            jQuery('ul#portfolio-item-filter'+counter+' a').click(function(e){	
        
                jQuery(this).addClass("active");
                jQuery(this).parents("li").siblings().children("a").removeClass("active");
                e.preventDefault();
                
                var select_filter = jQuery(this).attr('data-value');
                
                if( select_filter == "All" || jQuery(this).parent().index() == 0 ){		
                    filter_container.children().each(function(){
                        if( jQuery(this).hasClass('hide') ){
                            //jQuery(this).removeClass('hide').animate({opacity:1});
                            jQuery(this).removeClass('hide');
                            jQuery(this).fadeIn();
                        }
                    });
                }else{
                    filter_container.children().not('.' + select_filter).each(function(){
                        if( !jQuery(this).hasClass('hide') ){
                            //jQuery(this).addClass('hide').animate({opacity:0});
                            jQuery(this).addClass('hide');
                            jQuery(this).fadeOut();
                        }
                    });
                    filter_container.children('.' + select_filter).each(function(){
                        if( jQuery(this).hasClass('hide') ){
                            //jQuery(this).removeClass('hide').animate({opacity:1});
                            jQuery(this).removeClass('hide');
                            jQuery(this).fadeIn();
                        }
                    });
                }
                
                filter_container.masonry();	
                
            });
        });
	}