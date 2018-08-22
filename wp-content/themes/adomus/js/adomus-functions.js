/*
1) mobile menu
2) mobile contact
3) drop-down menu
4) hero slider
5) hero video
6) resize
7) hero caption fade in
8) hover
9) scroll
10) owner slider
11) video block
12) testimonials
13) form elements
14) map
*/

jQuery( document ).ready( function( $ ) {
	
    "use strict";
    
	/* 1) mobile menu */
	
	$( '.mobile-menu ul' ).html( $( 'header ul' ).html() );
	
	$( '.mobile-menu-trigger' ).on( 'click', function() {
        $( '.mobile-menu' ).show();
		$( '.mobile-menu' ).animate({ 'top': '-1px' });
        return false;
	});
	
	$( '.menu-close' ).on( 'click', function() {
		hide_menu_top();
        return false;
	}).click();

    function hide_menu_top() {
        var menu_height = $( '.mobile-menu' ).outerHeight();
		$( '.mobile-menu' ).animate({ 'top': '-' + menu_height + 'px' });
    }
    
    function hide_menu_top_on_resize() {
        if ( $( '.mobile-menu' ).css( 'top' ) != '-1px' ) {
            hide_menu_top();
        }
    }
    
	/* end 1) mobile menu */
	
    /* 2) mobile contact */
	
	$( '.contact-details-trigger' ).on( 'click', function() {
		$( '.top-header .widget-contact-content' ).slideToggle();
	});
    
    /* end 2) mobile contact */
    
    /* 3) drop-down menu */
    
    $('.main-menu').superfish({
        onBeforeShow: function() {
            if ( $( this ).parents( 'ul' ).length > 1 ){
                var w = $( window ).width(),
                    ul_offset = $( this ).parents( 'ul' ).offset(),
                    ul_width = $( this ).parents( 'ul' ).outerWidth();
                if ( ul_offset.left + ul_width * 2 > w ) {
                    $( this ).addClass( 'menu-sub-left' );
                } else {
                    $( this ).removeClass( 'menu-sub-left' );
                }
           };
        }
    });
    
    /* end 3) drop-down menu */
    
    /* 4) hero slider */
    
    var hero_slider_args = {
        speed: $( '.hero-slider' ).data( 'speed' ),
        pauseOnHover: false,
        accessibility: false
    };
    if ( $( '.hero-slider' ).data( 'autoplay' ) == 'yes' ) {
        hero_slider_args['autoplay'] = true;
        hero_slider_args['autoplaySpeed'] = $( '.hero-slider' ).data( 'autoplay-speed' );
    }
    if ( $( '.hero-slider' ).data( 'transition' ) == 'fade' ) {
        hero_slider_args['fade'] = true;
    }
    $( '.hero-slider' ).slick( hero_slider_args );
    
    /* end 4) hero slider */
    
    /* 5) hero video */
    
    var youtube_player;
    
    if ( $( '#hero-youtube-video-player' ).length ) {
        var tag = document.createElement( 'script' );
        tag.src = 'https://www.youtube.com/iframe_api';
        var firstScriptTag = document.getElementsByTagName( 'script' )[0];
        firstScriptTag.parentNode.insertBefore( tag, firstScriptTag );
        
        window.onYouTubeIframeAPIReady = function() {
            youtube_player = new YT.Player( 'hero-youtube-video-player', {
                videoId: $( '#hero-youtube-video-player' ).data( 'video-id' ),
                playerVars: {
                    controls: 0,
                    showinfo: 0,
                    modestbranding: 1,
					wmode: 'transparent',
					rel: 0
                },
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        window.onPlayerReady = function() {
            hero_media_resize();
            youtube_player.mute();
            youtube_player.playVideo();
            youtube_player.seekTo( $( '#hero-youtube-video-player' ).data( 'start' ) );
        }

        window.onPlayerStateChange = function( state ) {
            if ( state.data === 0 ) {
                youtube_player.seekTo( $( '#hero-youtube-video-player' ).data( 'start' ) );
            }
            if ( state.data === 1 ) {
                $( '#hero-youtube-video-player' ).css({ display: 'block', opacity: 1 });
            }
        }
        
    }
    
    function videos_autoplay_test() {
        
        var autoplay_test_content = document.createElement('video');

        //create mp4 and webm sources, 5s long
        var mp4 = document.createElement('source');
        mp4.src = "data:video/mp4;base64,AAAAFGZ0eXBNU05WAAACAE1TTlYAAAOUbW9vdgAAAGxtdmhkAAAAAM9ghv7PYIb+AAACWAAACu8AAQAAAQAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgAAAnh0cmFrAAAAXHRraGQAAAAHz2CG/s9ghv4AAAABAAAAAAAACu8AAAAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAABAAAAAAFAAAAA4AAAAAAHgbWRpYQAAACBtZGhkAAAAAM9ghv7PYIb+AAALuAAANq8AAAAAAAAAIWhkbHIAAAAAbWhscnZpZGVBVlMgAAAAAAABAB4AAAABl21pbmYAAAAUdm1oZAAAAAAAAAAAAAAAAAAAACRkaW5mAAAAHGRyZWYAAAAAAAAAAQAAAAx1cmwgAAAAAQAAAVdzdGJsAAAAp3N0c2QAAAAAAAAAAQAAAJdhdmMxAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAAAAFAAOABIAAAASAAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGP//AAAAEmNvbHJuY2xjAAEAAQABAAAAL2F2Y0MBTUAz/+EAGGdNQDOadCk/LgIgAAADACAAAAMA0eMGVAEABGjuPIAAAAAYc3R0cwAAAAAAAAABAAAADgAAA+gAAAAUc3RzcwAAAAAAAAABAAAAAQAAABxzdHNjAAAAAAAAAAEAAAABAAAADgAAAAEAAABMc3RzegAAAAAAAAAAAAAADgAAAE8AAAAOAAAADQAAAA0AAAANAAAADQAAAA0AAAANAAAADQAAAA0AAAANAAAADQAAAA4AAAAOAAAAFHN0Y28AAAAAAAAAAQAAA7AAAAA0dXVpZFVTTVQh0k/Ou4hpXPrJx0AAAAAcTVREVAABABIAAAAKVcQAAAAAAAEAAAAAAAAAqHV1aWRVU01UIdJPzruIaVz6ycdAAAAAkE1URFQABAAMAAAAC1XEAAACHAAeAAAABBXHAAEAQQBWAFMAIABNAGUAZABpAGEAAAAqAAAAASoOAAEAZABlAHQAZQBjAHQAXwBhAHUAdABvAHAAbABhAHkAAAAyAAAAA1XEAAEAMgAwADAANQBtAGUALwAwADcALwAwADYAMAA2ACAAMwA6ADUAOgAwAAABA21kYXQAAAAYZ01AM5p0KT8uAiAAAAMAIAAAAwDR4wZUAAAABGjuPIAAAAAnZYiAIAAR//eBLT+oL1eA2Nlb/edvwWZflzEVLlhlXtJvSAEGRA3ZAAAACkGaAQCyJ/8AFBAAAAAJQZoCATP/AOmBAAAACUGaAwGz/wDpgAAAAAlBmgQCM/8A6YEAAAAJQZoFArP/AOmBAAAACUGaBgMz/wDpgQAAAAlBmgcDs/8A6YEAAAAJQZoIBDP/AOmAAAAACUGaCQSz/wDpgAAAAAlBmgoFM/8A6YEAAAAJQZoLBbP/AOmAAAAACkGaDAYyJ/8AFBAAAAAKQZoNBrIv/4cMeQ==";

        var webm = document.createElement('source');
        webm.src = "data:video/webm;base64,GkXfo49CgoR3ZWJtQoeBAUKFgQEYU4BnAQAAAAAAF60RTZt0vE27jFOrhBVJqWZTrIIQA027jFOrhBZUrmtTrIIQbE27jFOrhBFNm3RTrIIXmU27jFOrhBxTu2tTrIIWs+xPvwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAFUmpZuQq17GDD0JATYCjbGliZWJtbCB2MC43LjcgKyBsaWJtYXRyb3NrYSB2MC44LjFXQY9BVlNNYXRyb3NrYUZpbGVEiYRFnEAARGGIBc2Lz1QNtgBzpJCy3XZ0KNuKNZS4+fDpFxzUFlSua9iu1teBAXPFhL4G+bmDgQG5gQGIgQFVqoEAnIEAbeeBASMxT4Q/gAAAVe6BAIaFVl9WUDiqgQEj44OEE95DVSK1nIN1bmTgkbCBULqBPJqBAFSwgVBUuoE87EQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAB9DtnVB4eeBAKC4obaBAAAAkAMAnQEqUAA8AABHCIWFiIWEiAICAAamYnoOC6cfJa8f5Zvda4D+/7YOf//nNefQYACgnKGWgQFNANEBAAEQEAAYABhYL/QACIhgAPuC/rOgnKGWgQKbANEBAAEQEAAYABhYL/QACIhgAPuC/rKgnKGWgQPoANEBAAEQEAAYABhYL/QACIhgAPuC/rOgnKGWgQU1ANEBAAEQEAAYABhYL/QACIhgAPuC/rOgnKGWgQaDANEBAAEQEAAYABhYL/QACIhgAPuC/rKgnKGWgQfQANEBAAEQEAAYABhYL/QACIhgAPuC/rOgnKGWgQkdANEBAAEQEBRgAGFgv9AAIiGAAPuC/rOgnKGWgQprANEBAAEQEAAYABhYL/QACIhgAPuC/rKgnKGWgQu4ANEBAAEQEAAYABhYL/QACIhgAPuC/rOgnKGWgQ0FANEBAAEQEAAYABhYL/QACIhgAPuC/rOgnKGWgQ5TANEBAAEQEAAYABhYL/QACIhgAPuC/rKgnKGWgQ+gANEBAAEQEAAYABhYL/QACIhgAPuC/rOgnKGWgRDtANEBAAEQEAAYABhYL/QACIhgAPuC/rOgnKGWgRI7ANEBAAEQEAAYABhYL/QACIhgAPuC/rIcU7trQOC7jLOBALeH94EB8YIUzLuNs4IBTbeH94EB8YIUzLuNs4ICm7eH94EB8YIUzLuNs4ID6LeH94EB8YIUzLuNs4IFNbeH94EB8YIUzLuNs4IGg7eH94EB8YIUzLuNs4IH0LeH94EB8YIUzLuNs4IJHbeH94EB8YIUzLuNs4IKa7eH94EB8YIUzLuNs4ILuLeH94EB8YIUzLuNs4INBbeH94EB8YIUzLuNs4IOU7eH94EB8YIUzLuNs4IPoLeH94EB8YIUzLuNs4IQ7beH94EB8YIUzLuNs4ISO7eH94EB8YIUzBFNm3SPTbuMU6uEH0O2dVOsghTM";

        //append sources to test video 
        autoplay_test_content.appendChild(webm);
        autoplay_test_content.appendChild(mp4);

        //set attributes - needs to be visible or IE squawks, so we move it way outside  
        autoplay_test_content.id = "base64_test_video";
        autoplay_test_content.autoplay = true;
        autoplay_test_content.style.position = "fixed";
        autoplay_test_content.style.left = "9999px";

        //add to DOM       
        document.getElementsByTagName("body")[0].appendChild(autoplay_test_content);

        var base64_test_video = document.getElementById("base64_test_video");

        //test for autoplay 
        setTimeout(function(){
            if ( base64_test_video.paused ) {
                videos_can_not_autoplay();
            } else {
                videos_can_autoplay();
            }
            document.getElementsByTagName("body")[0].removeChild(autoplay_test_content);
        }, 1000 );

    }
    
    videos_autoplay_test();
 
    function videos_can_autoplay() {
        $( '.hero-media-wrapper video' ).css( 'opacity', 1 );
    }
    
    function videos_can_not_autoplay() {
        $( '#hero-youtube-video-player, .hero-media-wrapper video' ).css( 'display', 'none' );
    }
	
    /* end 5) hero video */
    
	/* 6) resize */
	
    var resize_timer;
    
	$( window ).resize( debouncer( function () {
        adomus_on_resize();
	}));
	
	function adomus_on_resize() {
		hide_menu_top_on_resize();
		top_header_resize();
		menu_resize();
        hero_scroll_arrow();
		hero_booking_form_resize();
        hero_caption_left_right();
        hero_min_height();
		hero_media_resize();
        hero_vertical_centering();
		advanced_layout_video_resize();
		testimonials_resize();
		gallery_resize();
        clearTimeout( resize_timer );
        resize_timer = setTimeout( function() {
            hero_min_height() ;
            hero_vertical_centering();
            hero_media_resize();
        }, 100 );
	}
	
	var top_header_non_contact_widget_width = 0,
		top_header_contact_widget_width = 0;

	if ( $( '.widget-area-top-header-left .widget-contact-content' ).length ) {
		$( '.widget-area-top-header-left .widget-contact-content span' ).each( function() {
			top_header_contact_widget_width = top_header_contact_widget_width + $( this ).outerWidth( true );
		});
		top_header_non_contact_widget_width = $( '.widget-area-top-header-right' ).width();
	}

	if ( $( '.widget-area-top-header-right .widget-contact-content' ).length ) {
		$( '.widget-area-top-header-right .widget-contact-content span' ).each( function() {
			top_header_contact_widget_width = top_header_contact_widget_width + $( this ).outerWidth( true );
		});
		top_header_non_contact_widget_width = $( '.widget-area-top-header-left' ).width();
	}

	adomus_on_resize();
	
	function debouncer( func ) {
		var timeoutID,
			timeout = 50;
		return function () {
			var scope = this,
				args = arguments;
			clearTimeout( timeoutID );
			timeoutID = setTimeout( function () {
				func.apply( scope , Array.prototype.slice.call( args ) );
			} , timeout );
		}
	}
    
    function top_header_resize() {
		var available_space_top_header = $( 'header' ).width() - top_header_contact_widget_width - top_header_non_contact_widget_width - 40;
		if ( available_space_top_header <= 0 ) {
			$( '.top-header' ).addClass( 'mobile-top-header' );
		} else {
			$( '.top-header' ).removeClass( 'mobile-top-header' );
		}
	}
	
	function menu_resize() {
        var logo_area_width = $( '.logo' ).width(),
            menu_area_width = $( 'header ul' ).width(),
            site_tagline_width = $( '.site-tagline' ).width();
        logo_area_width += site_tagline_width;
		if ( logo_area_width + menu_area_width + 150 > $( 'header' ).width() ) {
			$( 'header' ).addClass( 'mobile-header' );
            if ( logo_area_width + 200 > $( 'header' ).width() ) {
                $( 'header' ).addClass( 'mobile-header-smaller' );
            } else {
                $( 'header' ).removeClass( 'mobile-header-smaller' );
            }
		} else {
			$( 'header' ).removeClass( 'mobile-header' );
		}
	}
	
    function hero_min_height() {
        if ( ! $( '.hero').hasClass( 'hero-custom' ) ) {
            var header_height = $( '.top-header' ).height() + $( 'header' ).outerHeight( true ),
                hero_caption_height = 0,
                booking_form_height = 0,
                scroll_arrow_height = 0;
            
            if ( $( '.hero' ).hasClass( 'has-booking-form' ) ) {
                booking_form_height = $( '.hero-booking-form' ).outerHeight( true );
            }
            if ( $( '.hero-has-scroll-arrow' ).length ) {
                scroll_arrow_height = $( '.hero-scroll' ).outerHeight( true );
            }
            $( '.hero-caption' ).each( function() {
                if ( $( this ).outerHeight( true ) > hero_caption_height ) {
                    hero_caption_height = $( this ).outerHeight( true );
                }
            });
            
            if ( $( '.hero-booking-form-vertical' ).length ) {
                if ( hero_caption_height > booking_form_height ) {
                    booking_form_height = 0;
                } else {
                    hero_caption_height = 0;
                }
            }
            var hero_elts_height = header_height + hero_caption_height + booking_form_height + scroll_arrow_height;
            if ( $( '.hero-height-mod' ).length ) {
                var max_width = $( '.hero-height-mod' ).data( 'max-width' );
                if ( $( '.hero' ).width() < max_width )  {
                    var height_value = parseInt( $( '.hero-height-mod' ).data( 'height-value' ) );
                    hero_elts_height += height_value;
                }
            }
            
            var ratio = $( '.hero-media-wrapper' ).data( 'hero-ratio' ),
                hero_with_padding_height = $( '.hero' ).width() / ratio;
                
			if ( $( '.hero' ).hasClass( 'hero-full-screen' ) ) {
				var window_height = $( window ).height();
				if ( $( '#wpadminbar' ).length ) {
					window_height = window_height - $( '#wpadminbar' ).height();
				}
				if ( hero_elts_height < window_height ) {
					$( '.hero' ).addClass( 'hero-is-full-screen' ).css( 'height', window_height + 'px' ).css( 'min-height', window_height + 'px' );
				} else {
					$( '.hero' ).removeClass( 'hero-is-full-screen' ).css( 'min-height', hero_elts_height + 'px' );
				}
			} else {
				if ( hero_with_padding_height < hero_elts_height ) {
	                $( '.hero' ).addClass( 'hero-no-padding' ).css( 'min-height', hero_elts_height + 'px' );
	            } else {
	                $( '.hero' ).removeClass( 'hero-no-padding' ).css( 'min-height', '' );
	            }
			}
        }
    }
    
	function hero_booking_form_resize() {
        if ( ! $( '.hero-booking-form' ).hasClass( 'hero-booking-form-vertical-on-wide-screen' ) ) {
			if ( ! $( '.hero-booking-form' ).hasClass( 'hero-booking-form-always-below-hero' ) ) {
				if ( $( '.hero' ).width() < 900 ) {
	                if ( ! $( '.hero-booking-form' ).hasClass( 'hero-booking-form-always-inside-hero' ) ) {
	                    $( '.hero' ).removeClass( 'has-booking-form' );
	                    $( '.hero-booking-form' ).addClass( 'hero-booking-form-is-below-hero' );
	                } else {
	                    $( '.hero' ).addClass( 'has-booking-form' );
	                }
	            } else {
	                $( '.hero-booking-form' ).removeClass( 'hero-booking-form-is-below-hero' );
	                if ( $( '.hero-booking-form' ).length ) {
	                    $( '.hero' ).addClass( 'has-booking-form' );
	                }
	            }
			}
        } else {
            if ( $( '.hero' ).width() < 680 ) {
                $( '.hero-booking-form' ).removeClass( 'hero-booking-form-left hero-booking-form-right' );
                $( '.hero-booking-form' ).removeClass( 'hero-booking-form-vertical' );
                if ( ! $( '.hero-booking-form' ).hasClass( 'hero-booking-form-always-inside-hero' ) ) {
                    $( '.hero' ).removeClass( 'has-booking-form' );
                    $( '.hero-booking-form' ).addClass( 'hero-booking-form-is-below-hero' );
                } else {
                    if ( $( '.hero-booking-form' ).hasClass( 'hero-booking-form-pos-top-hero-on-narrow-screen' ) ) {
                        $( '.hero-booking-form' ).addClass( 'hero-booking-form-pos-top-hero' );    
                    }
                }
            } else {
                $( '.hero-booking-form' ).addClass( 'hero-booking-form-vertical' );
                $( '.hero-booking-form' ).removeClass( 'hero-booking-form-pos-top-hero' );
                if ( $( '.hero-booking-form' ).hasClass( 'hero-booking-form-left-on-wide-screen' ) ) {
                    $( '.hero-booking-form' ).addClass( 'hero-booking-form-left' );
                }
                if ( $( '.hero-booking-form' ).hasClass( 'hero-booking-form-right-on-wide-screen' ) ) {
                    $( '.hero-booking-form' ).addClass( 'hero-booking-form-right' );
                }
                $( '.hero-booking-form' ).removeClass( 'hero-booking-form-is-below-hero' );
                if ( $( '.hero-booking-form' ).length ) {
                    $( '.hero' ).addClass( 'has-booking-form' );
                }
            }
        }
	}
    
    function hero_caption_left_right() {
        if ( $( '.hero' ).width() < 680 ) {
            $( '.hero' ).removeClass( 'hero-wide' );
            $( '.hero-caption' ).removeClass( 'hero-caption-left hero-caption-right' );
        } else {
            $( '.hero' ).addClass( 'hero-wide' );
            if ( $( '.hero-caption-left-on-wide-screen' ).length ) {
                $( '.hero-caption' ).addClass( 'hero-caption-left' );
            }
            if ( $( '.hero-caption-right-on-wide-screen' ).length ) {
                $( '.hero-caption' ).addClass( 'hero-caption-right' );
            }
        }
    }
    
    function hero_vertical_centering() {
        var header_height = $( '.top-header' ).height() + $( 'header' ).height(),
            hero_height = $( '.hero' ).outerHeight(),
            booking_form_height = 0,
            scroll_arrow_height = 0,
            booking_form_top,
            available_space_top,
            available_space_bottom,
            available_height,
            vertical_center;
        
        if ( $( '.hero-has-scroll-arrow' ).length ) {
            scroll_arrow_height = $( '.hero-scroll' ).outerHeight( true );
        }
        
        if ( $( '.hero' ).hasClass( 'has-booking-form' ) ) {
            booking_form_height = $( '.hero-booking-form' ).outerHeight( true );
        }
        
        available_space_top = header_height;
        available_space_bottom = hero_height - scroll_arrow_height;
        available_height = available_space_bottom - available_space_top;
        vertical_center = parseInt( available_height / 2, 10 ) + header_height;
        
        if ( 
			$( '.hero-booking-form' ).length && 
			! $( '.hero-booking-form-vertical' ).length &&
			! $( '.hero-booking-form-is-below-hero' ).length &&
			! $( '.hero-booking-form-always-below-hero' ).length
		) {
            if ( $( '.hero-booking-form-pos-top-hero' ).length ) {
                booking_form_top = header_height;
                available_space_top = header_height + booking_form_height;
                available_height = available_space_bottom - available_space_top;
                vertical_center = parseInt( available_height / 2, 10 ) + available_space_top;
            } else {
                booking_form_top = hero_height - booking_form_height - scroll_arrow_height;
                available_space_bottom = booking_form_top;
                available_height = available_space_bottom - available_space_top;
                vertical_center = parseInt( available_height / 2, 10 ) + header_height;
            }
            $( '.hero-booking-form' ).css( 'top', booking_form_top + 'px' );
        }
        
        if ( $( '.hero-booking-form-vertical' ).length ) {
            booking_form_top = vertical_center - parseInt( booking_form_height / 2, 10 );
			if ( scroll_arrow_height && ! $( '.scroll-text' ).length ) {
				booking_form_top += parseInt( scroll_arrow_height / 2, 10 );
			}
            $( '.hero-booking-form' ).css( 'top', booking_form_top + 'px' );
        }
                
        $( '.slick-arrow' ).css( 'top', vertical_center + 'px' );
        $( '.hero-caption' ).each( function() {
            var hero_caption_height = $( this ).height(),
                hero_caption_top = vertical_center - parseInt( hero_caption_height / 2, 10 );
            $( this ).css( 'top', hero_caption_top + 'px' );    
        });
    }
    
    function hero_scroll_arrow() {
		if ( $( '.hero-scroll-text' ).length ) {
	        if ( $( '.hero' ).width() < 900 ) {
	            $( '.hero-scroll' ).hide();
	            $( '.hero' ).removeClass( 'hero-has-scroll-arrow' );
	        } else {
	            $( '.hero-scroll' ).show();
	            if ( $( '.hero-scroll' ).length ) {
	                $( '.hero' ).addClass( 'hero-has-scroll-arrow' );
	            }
	        }
		} else if ( $( '.hero-scroll' ).length ) {
			$( '.hero' ).addClass( 'hero-has-scroll-arrow' );
		}
    }

    function hero_media_resize() {
        var container_width = $( '.hero' ).width(),
            container_height = $( '.hero' ).outerHeight(),
            $media = $( '.hero video, .hero .hero-media-wrapper iframe, .hero-img' ),
            media_width,
            media_height,
            ratio;

        $media.each( function() { 
            ratio = $( this ).data( 'native-width' ) / $( this ).data( 'native-height' );
            if ( container_width / ratio < container_height ) {
                media_width = Math.ceil( container_height * ratio );
                $( this ).width( media_width ).height( container_height ).css({ left: ( container_width - media_width ) / 2, top: 0 });
            } else {
                media_height = Math.ceil( container_width / ratio );
                $( this ).width( container_width ).height( media_height ).css({ left: 0, top: ( container_height - media_height ) / 2 });
            }
            if ( $( this ).hasClass( 'hero-img' ) ) {
                $( this ).css( 'opacity', 1 );
            }
        });
    }
    
	function advanced_layout_video_resize() {
        var $videos = $( '.video-overlay iframe' );
		if ( $videos ) {
			$videos.each( function() {
	            var $video = $( this ),
					$video_section = $( this ).parents( '.video-section-row' ),
					wrapper_ratio = $video_section.find( '.video-overlay-container' ).width() / $video_section.find( '.video-overlay-container' ).height(),
	                video_ratio = $video.data( 'video-ratio' );
	            if ( wrapper_ratio > video_ratio ) {
	                var height = $video_section.find( '.video-overlay-container' ).height(),
	                    width = parseInt( height * video_ratio, 10 );
	            } else {
	                var width = $video_section.find( '.video-overlay-container' ).width(),
	                    height = parseInt( width / video_ratio );
	            }
	            $video.css({ width: width + 'px', height: height + 'px' });
				
				var margin_left = $video.width() / 2,
	                margin_top = $video.height() / 2;
	            $video.css({ 'margin-top':  '-' + margin_top + 'px', 'margin-left': '-' + margin_left + 'px' });
	        });
		}
	}
	
	function testimonials_resize() {
		$( '.testimonials-row' ).each( function() {
			var bigest_testi_height = 0,
				$testimonials = $( this ).find( '.testimonial' );
			$testimonials.each( function() {
				if ( $( this ).height() > bigest_testi_height ) {
					bigest_testi_height = $( this ).height();
				}
			});
			$( this ).find( '.testimonial-container' ).css( 'height', bigest_testi_height );
		});
	}
    
	function gallery_resize() {
		$( '.gallery-row' ).each( function() {
			var padding_bottom = parseInt( $( this ).css( 'padding-bottom' ) );
			if ( $( this ).height() <= $( this ).find( '.gallery-desc' ).height() - padding_bottom ) {
				$( this ).height( $( this ).find( '.gallery-desc' ).height() - padding_bottom );
			} else {
				$( this ).height( 'auto' );
			}
		});
	}
	
	/* end 6) resize */
	
    /* 7) hero caption fade in */
    
    setTimeout( function () {
        $( '.hero-caption, .hero-booking-form' ).css( 'opacity', 1 );
    }, 100 );
    
    /* end 7) hero caption fade in */
    
	/* 8) hover */
	
	$( '.main-menu > li > a' ).on( 'mouseenter', function() {
        $( this ).parents( 'li' ).addClass( 'menu-item-hover' );
    });
    
    $( '.main-menu > li > a' ).on( 'mouseleave', function() {
		$( this ).parents( 'li' ).removeClass( 'menu-item-hover' );
		
    });
	
	$( '.accom-link' ).on( 'mouseenter', function() {
		$( this ).addClass( 'accom-hover' );
	});
    
    $( '.accom-link' ).on( 'mouseleave', function() {
		$( this ).removeClass( 'accom-hover' );
    });
	
	/* end 8) hover */
	
	/* 9) scroll */
	
	$( '.hero-scroll-link' ).on( 'click', function() {
		$( 'html, body' ).animate({ scrollTop: $( '.hero' ).offset().top + $( '.hero' ).outerHeight() }, 600 );
		return false;
	});
	
	/* end 9) scroll */
	
	/* 10) owner slider */
	
	$( '.fancy-slider-row' ).each( function() {
		
	    var $fancy_slider_section = $( this ),
			owner_slider_timer,
	        owner_slider_autoplay = $fancy_slider_section.find( '.owner-slider' ).data( 'autoplay' ),
	        owner_slider_no_anim_class = '';
	    
	    if ( $fancy_slider_section.find( '.owner-slide' ).length < 4 ) {
	        owner_slider_no_anim_class = ' owner-slide-no-anim';
	    }
	    
	    if ( $fancy_slider_section.find( '.owner-slide' ).length <= 2 ) {
	        $fancy_slider_section.find( '.owner-slider-to-left, .owner-slider-to-right' ).hide();
	        $fancy_slider_section.find( '.owner-slide-overlay' ).css({ cursor: 'default' });
			if ( $fancy_slider_section.find( '.owner-slide' ).length == 1 ) {
	        	$fancy_slider_section.find( '.owner-slide-overlay' ).css({ opacity: 1 });
			}
	    }
	    
		$fancy_slider_section.find( '.owner-slider-to-right, .owner-slide-overlay' ).on( 'click', function() {
	        if ( $fancy_slider_section.find( '.owner-slide' ).length > 2 ) {
	            clearTimeout( owner_slider_timer );
	            owner_go_to_next_slide();
	        }
			return false;
		});
		
		$fancy_slider_section.find( '.owner-slider-to-left' ).on( 'click', function() {
	        clearTimeout( owner_slider_timer );
			owner_go_to_previous_slide();
	        return false;
		});
		
	    function owner_go_to_next_slide() {
	        var next_slide = $fancy_slider_section.find( '.owner-slide' ).index( $fancy_slider_section.find( '.owner-slide-next' ) ) + 1;
			if ( next_slide >= $fancy_slider_section.find( '.owner-slide' ).length ) {
				next_slide = 0;
			}
			$fancy_slider_section.find( '.owner-slide-previous' ).removeClass( 'owner-slide-previous' );
			$fancy_slider_section.find( '.owner-slide-current' ).removeClass( 'owner-slide-current' ).addClass( 'owner-slide-previous' );
			$fancy_slider_section.find( '.owner-slide-next' ).removeClass( 'owner-slide-next' ).addClass( 'owner-slide-current' );
			$fancy_slider_section.find( '.owner-slide' ).eq( next_slide ).addClass( 'owner-slide-next' + owner_slider_no_anim_class );
	        setTimeout( function() {
	            $fancy_slider_section.find( '.owner-slide' ).removeClass( owner_slider_no_anim_class );    
	        }, 600 );
	        if ( owner_slider_autoplay ) {
	            owner_slider_auto_next();
	        }
	    }
	    
	    function owner_go_to_previous_slide() {
	        var previous_slide = $fancy_slider_section.find( '.owner-slide' ).index( $fancy_slider_section.find( '.owner-slide-previous' ) ) - 1;
			if ( previous_slide < 0 ) {
				previous_slide = $fancy_slider_section.find( '.owner-slide' ).length - 1;
			}
	        $fancy_slider_section.find( '.owner-slide-next' ).removeClass( 'owner-slide-next' );
	        $fancy_slider_section.find( '.owner-slide-current' ).removeClass( 'owner-slide-current' ).addClass( 'owner-slide-next' + owner_slider_no_anim_class );    
			$fancy_slider_section.find( '.owner-slide-previous' ).removeClass( 'owner-slide-previous' ).addClass( 'owner-slide-current' );
			$fancy_slider_section.find( '.owner-slide' ).eq( previous_slide ).addClass( 'owner-slide-previous' + owner_slider_no_anim_class );
	        setTimeout( function() {
	            $fancy_slider_section.find( '.owner-slide' ).removeClass( owner_slider_no_anim_class );    
	        }, 600 );
	        if ( owner_slider_autoplay ) {
	            owner_slider_auto_next();
	        }
	    }
	    
	    function owner_slider_auto_next() {
	        owner_slider_timer = setTimeout( owner_go_to_next_slide, owner_slider_autoplay );
	    }
	    
	    if ( owner_slider_autoplay ) {
	        owner_slider_auto_next();
	    }
		
	});
    
	/* end 10) owner slider */
	
	/* 11) video block */
	
	$( '.video-section-play' ).on( 'click', function() {
		var $video_section = $( this ).parents( '.video-section-row' );
		$video_section.find( '.video-overlay' ).fadeIn( function() {
			advanced_layout_video_resize();
			var iframe = $video_section.find( '.video-overlay iframe' )[0].contentWindow;
            iframe.postMessage( '{ "event": "command", "func": "playVideo", "args": "" }', '*' );
		});
		$( 'html' ).css( 'overflow', 'hidden' );
		return false;
	});
	
	$( '.video-overlay-close' ).on( 'click', function() {
		var $video_section = $( this ).parents( '.video-section-row' ),
        	iframe = $video_section.find( '.video-overlay iframe' )[0].contentWindow;
        iframe.postMessage( '{ "event": "command", "func": "pauseVideo", "args": "" }', '*' );
        $video_section.find( '.video-overlay' ).fadeOut();
        $( 'html' ).css( 'overflow', 'auto' );
		return false;
	});
	
	/* end 11) video block */
	
	/* 12) testimonials */
	
	$( '.testimonials-row' ).each( function() {
		
		var current_testimonial = 1,
			$row = $( this );

		if ( $row.find( '.testimonial' ).length ) {
			show_testimonial();
		}

		/*
		$( '.testimonial-next' ).on( 'click', function() {
			hide_testimonial();
			current_testimonial++;
			if ( current_testimonial > $( '.testimonial' ).length ) {
				current_testimonial = 1;
			}
			show_testimonial();
			return false;
		});

		$( '.testimonial-prev' ).on( 'click', function() {
			hide_testimonial();
			current_testimonial--;
			if ( current_testimonial < 1 ) {
				current_testimonial = $( '.testimonial' ).length;
			}
			show_testimonial();
			return false;
		});
		*/
		
		$row.find( '.testimonial-thumb' ).on( 'click', function() {
			hide_testimonial();
			current_testimonial = $row.find( '.testimonial-thumb' ).index( $( this ) ) + 1;  
			show_testimonial();
			return false;
		});

		$row.find( '.testimonial-bullet' ).on( 'click', function() {
			hide_testimonial();
			current_testimonial = $row.find( '.testimonial-bullet' ).index( $( this ) ) + 1;  
			show_testimonial();
			return false;
		});
			
		function hide_testimonial() {
			$row.find( '.testimonial-container' ).css( 'opacity', 0 );
		}

		function show_testimonial() {
			$row.find( '.testimonial-img' ).eq( current_testimonial - 1 ).hide().css( 'z-index', 11 ).fadeIn( function() {
				$row.find( '.testimonial-img' ).css( 'z-index', 9 );
				$row.find( '.testimonial-img' ).eq( current_testimonial - 1 ).css( 'z-index', 10 );
			});
			$row.find( '.testimonial-mobile-img' ).attr( 'src', $row.find( '.testimonial' ).eq( current_testimonial - 1 ).data( 'mobile-img' ) );
			$row.find( '.testimonial-inner' ).html( $row.find( '.testimonial' ).eq( current_testimonial - 1 ).html() );
			$row.find( '.testimonial-container' ).css( 'opacity', 1 );
			$row.find( '.testimonial-thumb' ).removeClass( 'testimonial-current' ).eq( current_testimonial - 1 ).addClass( 'testimonial-current' );
			$row.find( '.testimonial-bullet' ).removeClass( 'testimonial-current' ).eq( current_testimonial - 1 ).addClass( 'testimonial-current' );
		}
		
	});
	
	/* end 12) testimonials */
	
	/* 13) form elements */
	
	$( 'select' ).dropkick();
	
	/* end 13) form elements */
	
	/* 14) map */
	
	function init_map( $map ) {
		var zoom = $map.data('zoom');
		var map_type;
		switch ( $map.data('type') ) {
			case 'road' : map_type = google.maps.MapTypeId.ROADMAP; break;
			case 'satellite' : map_type = google.maps.MapTypeId.SATELLITE; break;
			case 'hybrid' : map_type = google.maps.MapTypeId.HYBRID; break;
			case 'terrain' : map_type = google.maps.MapTypeId.TERRAIN; break;
		}
		var markers = $map.data('map-points');
		var overlays = [];
		var map;
		var center = new google.maps.LatLng(parseFloat(markers[0].lat), parseFloat(markers[0].lng));
		CustomOverlay.prototype = new google.maps.OverlayView();
		function initialize() {
			var mapOptions = {
				zoom: zoom,
				center: center,
				mapTypeId: map_type,
				scrollwheel: false
			};
			var bounds = new google.maps.LatLngBounds();
			map = new google.maps.Map( $map[0], mapOptions);
			for (var i = 0; i < markers.length; i++) {
				var latlng = new google.maps.LatLng(parseFloat(markers[i].lat), parseFloat(markers[i].lng));
				overlays[i] = new CustomOverlay(latlng, markers[i].caption, map);
				bounds.extend(latlng);
			}
			if (markers.length > 1) {
				map.fitBounds(bounds);
				setTimeout( function() { map.setZoom(zoom); }, 1000 );
			}
		}
		function CustomOverlay(latlng, text, map) {
			this.latlng_ = latlng;
			this.text_ = text;
			this.map_ = map;
			this.div_ = null;
			this.dot_ = null;
			this.setMap(map);
		}
		CustomOverlay.prototype.onAdd = function () {
			var div = document.createElement('div');
			div.className = "map-marker-container";
			div.innerHTML = this.text_;
			var dot = document.createElement('div');
			dot.className = "map-marker-dot";
			div.appendChild(dot);
			var inner_dot = document.createElement('div');
			inner_dot.className = "map-marker-dot-inner";
			dot.appendChild(inner_dot);
			this.div_ = div;
			this.dot_ = dot;
			var panes = this.getPanes();
			panes.overlayLayer.appendChild(div);
		};
		CustomOverlay.prototype.draw = function () {
			var overlayProjection = this.getProjection();
			var latlng = overlayProjection.fromLatLngToDivPixel(this.latlng_);
			var div = this.div_;
			var dot = this.dot_;
			var dot_distance = parseInt(window.getComputedStyle(dot).bottom);
			var div_width = div.clientWidth;
			var div_height = div.clientHeight;
			div.style.left = (latlng.x - div_width / 2 ) + 'px';
			div.style.top = (latlng.y - div_height + dot_distance) + 'px';
		};
		google.maps.event.addDomListener(window, 'load', initialize);
		$(window).resize(debouncer(function () {
			if ( typeof map != 'undefined' && markers.length == 1 ) {
				map.setCenter(center);
			}
		}));
	}
	
	$( '.map-canvas' ).each( function() {
		init_map( $(this) );	
	});
	
	/* 14) end map */
	
});