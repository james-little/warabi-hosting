jQuery(document).ready(function( $ ){

	if ( ! wp.media ) {
		return;
	}

	$( '#new-slideshow-form' ).hide();
	$( '#add-new-slideshow' ).click( function() {
		$( '#new-slideshow-form' ).slideDown();
	} );

	$( '#submit-new-slideshow, #cancel-new-slideshow' ).click( function() {
		$( '#new-slideshow-form' ).slideUp();
		$( '#new-slideshow-name' ).val = "";
	} );

	$( '.wrap' ).on( 'click', '.edit-slideshow', function() {
		var $wrap = $( this ).parents ( '.slideshow' );
		$wrap.find( '.edit-slideshow-form' ).slideDown();
		$wrap.find( '.edit-slideshow' ).hide();
		$wrap.find( '.close-edit-slideshow' ).show();
	} );

	$( '.wrap' ).on( 'click', '.close-edit-slideshow', function() {
		var $wrap = $( this ).parents ( '.slideshow' );
		$wrap.find( '.edit-slideshow-form' ).slideUp();
		$wrap.find( '.edit-slideshow' ).show();
		$wrap.find( '.close-edit-slideshow' ).hide();
	} );

	$( '.wrap' ).on( 'click', '.hotelwp-sliders-save-changes', function() {
		$( this ).blur();
		var $wrap = $( this ).parents( 'div' );
        $wrap.find( '.slideshows-saving' ).css( 'display', 'inline-block' );
		var properties_not_saved = ['autoplayOptionName', 'autoplayOptionIdYes', 'autoplayOptionIdNo', 'transitionOptionName', 'transitionOptionIdSlide', 'transitionOptionIdFade' ];
		var data = {
			'nonce': $( '#hotelwp-sliders-nonce' ).val(),
			'action': 'hotelwp_save_slideshows',
			'slideshows': ko.toJSON( 
				slideshows.slideshows(),
				function( key, value ) {
					if ( properties_not_saved.indexOf( key ) > -1 ) {
						return;
					} else {
						return value;
					}
				}
			)
		}
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			timeout: 10000,
			data: data,
			success: function ( ajax_return ) {
                $wrap.find( '.slideshows-saving' ).css( 'display', 'none' );
                slideshows_saved = true;
				$wrap.find( '.slideshows-saved' ).slideDown();
					setTimeout( function() {
                        $wrap.find( '.slideshows-saved' ).fadeOut();
                    }, 5000 );
				},
				error: function () {
                    $wrap.find( '.slideshows-saving' ).css( 'display', 'none' );
					alert( hotelwp_slider_strings.can_not_save );
				}
		});
	} );

	function SlideshowsModel() {
		var self = this;
		this.slideshows = ko.observableArray();
		for( var i = 0; i < dbSlideshows.length; i++ ) {
			self.slideshows.push( new Slideshow( dbSlideshows[i].slideshowId, dbSlideshows[i].slideshowName, dbSlideshows[i].slideDuration, dbSlideshows[i].transitionDuration, dbSlideshows[i].paginationDuration, dbSlideshows[i].rewindDuration, dbSlideshows[i].autoplay, dbSlideshows[i].transitionStyle, dbSlideshows[i].slides ) );
		};

		this.createSlideshow = function( formElement ) {
			self.slideshows.unshift( new Slideshow( $( '#new-slideshow-name' ).val() + Math.floor( ( Math.random() * 1000 ) + 1 ) , $( '#new-slideshow-name' ).val(), '5000', '1000', '1500', '2000', 'yes', 'slide', [{ mediaId:'', thumbnailPath: defaultImages['add_media'], thumbnailTitle: '', caption: '', textColor:'#fff', backgroundColor:'#000', captionOpacity:'75' }] ) );
            slideshows_saved = false;
		};

		this.deleteSlideshow = function( slideshow ) {
			if ( confirm( hotelwp_slider_strings.delete_slideshow ) ) {
				self.slideshows.remove( slideshow );
                slideshows_saved = false;
			};
		};

	};

    function Slideshow( id, name, slideDuration, slideTransition, paginationDuration, rewindDuration, autoplay, transitionStyle, slides ){
		var self = this;
		this.slideshowId = id;
		this.slideshowName = ko.observable( name );
		this.autoplayOptionName = ko.computed( function() {
			return self.slideshowId + '-autoplay';
		});
		this.autoplayOptionIdYes = ko.computed( function() {
			return self.slideshowId + '-autoplay-yes';
		});
		this.autoplayOptionIdNo = ko.computed( function() {
			return self.slideshowId + '-autoplay-no';
		});
		this.transitionOptionName = ko.computed( function() {
			return self.slideshowId + '-transition';
		});
		this.transitionOptionIdSlide = ko.computed( function() {
			return self.slideshowId + '-transition-slide';
		});
		this.transitionOptionIdFade = ko.computed( function() {
			return self.slideshowId + '-transition-fade';
		});
		this.slideDuration = ko.observable( slideDuration );
		this.transitionDuration = ko.observable( slideTransition );
		this.paginationDuration = ko.observable( paginationDuration );
		// this.rewindDuration = ko.observable( rewindDuration );
		this.autoplay = ko.observable( autoplay );
		this.transitionStyle = ko.observable( transitionStyle );
		this.slides = ko.observableArray();
		for( var i = 0; i < slides.length ; i++ ) {
			self.slides.push( new Slide( slides[i].mediaId, slides[i].thumbnailPath, slides[i].thumbnailTitle, slides[i].caption, slides[i].textColor, slides[i].backgroundColor, slides[i].captionOpacity ) );
		};

		this.createSlideEnd = function() {
			self.slides.push( new Slide( '', defaultImages['add_media'], '', '', '#fff', '#000', '75' ) );
            slideshows_saved = false;
		};
		this.createSlideTop = function() {
			self.slides.unshift( new Slide( '', defaultImages['add_media'], '', '', '#fff', '#000', '75' ) );
            slideshows_saved = false;
		};
		this.deleteSlide = function( slide ) {
			if ( confirm( hotelwp_slider_strings.delete_slide ) ) {
				self.slides.remove( slide );
                slideshows_saved = false;
			};
		};
    };

	ko.bindingHandlers.wpColorPicker = {
		init: function( element, valueAccessor, allBindingsAccessor, data, context) {
			var color = ko.unwrap( valueAccessor() );
			$( element ).val( color );
			var options= {
				change: function (event, ui ) {
					var value = valueAccessor();
					value( ui.color.toString() );
				},
			};
			$( element ).wpColorPicker( options );
		}
	};

    function Slide( mediaId, thumbnailPath, thumbnailTitle, caption, textColor, backgroundColor, captionOpacity ){
		var self = this;
		this.mediaId = mediaId;
		this.thumbnailPath = ko.observable( thumbnailPath );
		this.thumbnailTitle = ko.observable( thumbnailTitle );
        this.caption = ko.observable( caption );
		//this.backgroundColor = ko.observable( backgroundColor );
		//this.textColor = ko.observable( textColor );
		//this.captionOpacity = ko.observable( captionOpacity );

		this.editSlide = function() {
		var hotelwp_media_window = wp.media({
			title: hotelwp_slider_strings.select_media,
			multiple: false,
			//library: { type: 'image, video' },
			library: { type: 'image' },
			button: { text: hotelwp_slider_strings.select }
		});
		hotelwp_media_window.open();
		hotelwp_media_window.on( 'select', function() {
			var img_info = hotelwp_media_window.state().get('selection').first();
			var type = img_info.attributes.type;
			self.mediaId = img_info.attributes.id;
			if ( type == 'video' ) {
				self.thumbnailPath( defaultImages['video_media'] );
				self.thumbnailTitle( img_info.attributes.title );
			} else {
				self.thumbnailPath( img_info.attributes.url );
				self.thumbnailTitle('');
			}

			});
		};
	};

	var slideshows = new SlideshowsModel();
	ko.applyBindings( slideshows );
    
    var slideshows_saved = true;
    $( '.slideshows' ).on( 'change', 'input', function() {
		slideshows_saved = false;
	});
	window.onbeforeunload = function() {
		if ( ! slideshows_saved ) {
			return hotelwp_slider_strings.unsaved_warning;
		}
     }
    
} ) ;
