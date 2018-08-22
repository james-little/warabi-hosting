jQuery( document ).ready( function( $ ) {

    function htwMetaFieldsViewModel() {
        
        var self = this;

        /* begin hero */
        
        this.hero_type = ko.observable();
        this.hero_full_screen = ko.observable( $( 'input[name="adomus_hero_full_screen"]:checked' ).val() );
        this.display_title = ko.observable( $( 'input[name="adomus_display_title"]:checked' ).val() );
        
        this.hero_image_is_visible = ko.computed( function() {
            return ( self.hero_type() == 'image' || self.hero_type() == 'video' );
        });

        this.hero_video_is_visible = ko.computed( function() {
            return self.hero_type() == 'video';
        });

        this.hero_slider_is_visible = ko.computed( function() {
            return self.hero_type() == 'slider';
        });    

        this.hero_custom_is_visible = ko.computed( function() {
            return self.hero_type() == 'custom';
        });

        this.hero_video_youtube_is_visible = ko.computed( function() {
            return self.hero_type() == 'video';
        });

        this.hero_full_screen_is_visible = ko.computed( function() {
            return self.hero_type() != 'custom';
        });

        this.title_is_visible = ko.computed( function() {
            return self.display_title() == 'yes';
        });
        
        this.title_pos_is_visible = ko.computed( function() {
            return self.display_title() == 'yes' && self.hero_type() != 'custom';
        });
        
        this.hero_size_is_visible = ko.computed( function() {
            return self.hero_type() != 'custom' && self.hero_full_screen() != 'yes';
        });
        
        /* end hero */
        
        /* begin booking form */
        
        this.display_booking_form = ko.observable( $( 'input[name="adomus_display_booking_form"]:checked' ).val() );
        this.booking_form_pos = ko.observable();
        this.booking_form_style_hero = ko.observable();
        
        this.booking_form_options_is_visible = ko.computed( function() {
            return self.display_booking_form() == 'yes';
        });
        
        this.booking_form_hero_options_is_visible = ko.computed( function() {
            return ( ( self.display_booking_form() == 'yes' ) && ( self.booking_form_pos() == 'inside_hero' || self.booking_form_pos() == 'always_inside_hero' ) );
        });
        
        this.booking_form_horizontal_pos_hero_is_visible = ko.computed( function() {
            return self.booking_form_hero_options_is_visible() && self.booking_form_style_hero() == 'horizontal';
        });
        
        this.booking_form_vertical_pos_hero_is_visible = ko.computed( function() {
            return self.booking_form_hero_options_is_visible()  && self.booking_form_style_hero() == 'vertical';
        });
        
        this.booking_form_vertical_pos_narrow_hero_is_visible = ko.computed( function() {
            return self.booking_form_hero_options_is_visible()  && self.booking_form_style_hero() == 'vertical' && self.booking_form_pos() == 'always_inside_hero';
        });
        
        /* end booking form */
        
    };

    ko.applyBindings( new htwMetaFieldsViewModel() );
    
    $( '.adomus-multiple-select-checkbox' ).each( function() {
        show_hide_multiple_select( $( this ) );
    });
    
    $( 'body' ).on( 'change', '.adomus-multiple-select-checkbox',  function() {
        show_hide_multiple_select( $( this ) );
    });
    
    function show_hide_multiple_select( $checkbox) {
        $multiple_select = $checkbox.parents( 'p' ).find( 'select' );
        $multiple_select_legend = $checkbox.parents( 'p' ).find( '.adomus-multiple-select-legend' );
        if ( $checkbox.is( ':checked') ) {
            $multiple_select.hide().find( 'option' ).prop( 'selected', true );
            $multiple_select_legend.hide();
        } else {
            $multiple_select.show();
            $multiple_select_legend.show();
        }
    }
    
	$( '.adomus-contact-map-layout select' ).each( function() {
		show_map_contact_layout_options( $( this ) );
	});
	
	$( 'body' ).on( 'change', '.adomus-contact-map-layout select', function() {
		show_map_contact_layout_options( $( this ) );
	});
	
	function show_map_contact_layout_options( $layout_select ) {
		var layout = $layout_select.val(),
            $map_contact_options_wrapper = $layout_select.parents( '.adomus-section-fields' );
        if ( layout == 'contact_form_only' ) {
            $map_contact_options_wrapper.find( '.adomus-contact-form-option' ).show();
            $map_contact_options_wrapper.find( '.adomus-contact-form-position-option, .adomus-contact-map-option, .adomus-contact-info-option, .adomus-contact-map-position-option' ).hide();
		} else if ( layout == 'full_width_map' ) {
			$map_contact_options_wrapper.find( '.adomus-contact-map-option' ).show();
			$map_contact_options_wrapper.find( '.adomus-contact-form-option, .adomus-contact-info-option, .adomus-contact-map-position-option' ).hide();
		} else if ( layout == 'contact_form_map' ) {
			$map_contact_options_wrapper.find( '.adomus-contact-form-option, .adomus-contact-map-option' ).show();
			$map_contact_options_wrapper.find( '.adomus-contact-info-option, .adomus-contact-map-position-option' ).hide();
		} else if ( layout == 'contact_info_map' ) {
			$map_contact_options_wrapper.find( '.adomus-contact-info-option, .adomus-contact-map-option' ).show();
			$map_contact_options_wrapper.find( '.adomus-contact-form-option' ).hide();
		} else if ( layout == 'contact_info_contact_form' ) {
			$map_contact_options_wrapper.find( '.adomus-contact-map-option' ).hide();
			$map_contact_options_wrapper.find( '.adomus-contact-form-option' ).show();
			$map_contact_options_wrapper.find( '.adomus-contact-info-option' ).show();
		}
	}
    
});