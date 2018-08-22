<?php

add_action( 'customize_register', 'adomus_customizer' );

function adomus_customizer( $wp_customize ) {
	
    $contact_details_settings = array();
    for ( $i = 1; $i <= 4; $i++ ) {
        $contact_details_settings[] = array(
            'id' => 'contact_detail_' . $i,
            'label'	=> sprintf( esc_html__( 'Contact detail %d', 'hotelwp' ), $i ),
            'type' => 'text',
        );
    }
    
    $top_hero_settings = $contact_details_settings;
    
    $logo_settings = array(
        array(
            'id' => 'hotelwp_site_logo',
            'label' => esc_html__( 'Logo', 'hotelwp' ),
            'type' => 'img',
        ),
    );
    
    $hero_settings = array(
        array(
            'id' => 'hero_img',
            'label' => esc_html__( 'Default hero image', 'hotelwp' ),
            'type' => 'img',
        ),
        array(
            'id' => 'default_title_pos',
            'label' => esc_html__( 'Default title position', 'hotelwp' ),
            'type' => 'select',
            'choices' => array(
                'inside_hero' => esc_html__( 'Inside hero', 'hotelwp' ),
                'below_hero' => esc_html__( 'Below hero', 'hotelwp' ),
            ),
            'default' => 'inside_hero',
        ),
        array(
            'id' => 'default_hero_ratio',
            'label' => esc_html__( 'Default hero ratio', 'hotelwp' ),
            'type' => 'text',
            'default' => '3/1',
        ),
        array(
            'id' => 'hero_default_min_height',
            'label' => esc_html__( 'Default hero minimum height' ),
            'type' => 'int',
        ),
        array(
            'id' => 'hero_default_max_height',
            'label' => esc_html__( 'Default hero maximum height' ),
            'type' => 'int',
        ),
    );
    
    $color_settings = array(
		array(
            'id' => 'overlay_color',
            'label' => esc_html__( 'Overlay color (hero and video section)', 'hotelwp' ),
            'type' => 'color',
            'default' => '#000000',
        ),
        array(
            'id' => 'overlay_opacity',
            'label' => esc_html__( 'Overlay opacity (hero and video section) (percentage)', 'hotelwp' ),
            'type' => 'int',
            'default' => '33',
        ),
		array(
            'id' => 'header_background',
            'label' => esc_html__( 'Header background color', 'hotelwp' ),
            'type' => 'color',
            'default' => '#000000',
        ),
        array(
            'id' => 'header_background_opacity',
            'label' => esc_html__( 'Header background opacity (percentage)', 'hotelwp' ),
            'type' => 'int',
            'default' => '0',
        ),
		array(
            'id' => 'booking_form_background',
            'label' => esc_html__( 'Booking form background color', 'hotelwp' ),
            'type' => 'color',
            'default' => '#407499',
        ),
        array(
            'id' => 'booking_form_background_opacity',
            'label' => esc_html__( 'Booking form background opacity (percentage)', 'hotelwp' ),
            'type' => 'int',
            'default' => '70',
        ),
		array(
            'id' => 'booking_form_white_button',
            'label' => esc_html__( 'Hero booking form white button', 'hotelwp' ),
			'type' => 'select',
			'choices' => array(
				'yes' => esc_html__( 'Yes', 'hotelwp' ),
				'no' => esc_html__( 'No', 'hotelwp' ),
			),
			'default' => 'no'
        ),
		array(
            'id' => 'dropdown_menu_background',
            'label' => esc_html__( 'Drop-down menu background color', 'hotelwp' ),
            'type' => 'color',
            'default' => '#000000',
        ),
        array(
            'id' => 'dropdown_menu_background_opacity',
            'label' => esc_html__( 'Drop-down menu background opacity (percentage)', 'hotelwp' ),
            'type' => 'int',
            'default' => '70',
        ),
		array(
            'id' => 'link_color',
            'label' => esc_html__( 'Link color', 'hotelwp' ),
            'type' => 'color',
            'default' => '#46cdcf',
        ),
		array(
            'id' => 'link_hover_color',
            'label' => esc_html__( 'Link hover color', 'hotelwp' ),
            'type' => 'color',
            'default' => '#7098bd',
        ),
        array(
            'id' => 'accent_color',
            'label' => esc_html__( 'Accent color', 'hotelwp' ),
            'type' => 'color',
            'default' => '#407499',
        ),
        array(
			'id' => 'footer_background',
            'label' => esc_html__( 'Footer background color', 'hotelwp' ),
            'type' => 'color',
            'default' => '#ffffff',
		),
		array(
			'id' => 'footer_text_color',
            'label' => esc_html__( 'Footer text color', 'hotelwp' ),
			'type' => 'select',
            'choices' => array(
                'footer_dark_text' => esc_html__( 'Dark', 'hotelwp' ),
                'footer_light_text' => esc_html__( 'Light', 'hotelwp' ),
            ),
            'default' => 'footer_dark_text',
		),
    );
    
	$map_settings = array(
		array(
			'id' => 'map_api_key',
			'label' => esc_html__( 'Google map api key', 'hotelwp' ),
			'type' => 'text'
		)
	);	
	
	$misc_settings = array(
		array(
			'id' => 'gallery_img_padding',
			'label' => esc_html__( 'Default padding for images in galleries (in px)', 'hotelwp' ),
			'type' => 'int',
            'default' => '0',
		)
	);
	
    $social_websites_settings = array();
    foreach ( adomus_social_websites() as $social_website ) {
        $social_websites_settings[] = array(
            'id' => $social_website,
            'label'	=> ucfirst( $social_website ) . ' ' . esc_html__( 'url', 'hotelwp' ),
            'type' => 'url'
        );
    }

    $footer_settings = array_merge(
        array(
            array(
                'id' => 'bottom_footer_text',
                'label'	=> esc_html__( 'Copyright text', 'hotelwp' ),
                'type' => 'text'
            ),
			array(
				'id' => 'display_design_by_hotelwp',
				'label'	=> esc_html__( 'Display "Website designed by HotelWP"', 'hotelwp' ),
				'type' => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'hotelwp' ),
					'no' => esc_html__( 'No', 'hotelwp' ),
				),
				'default' => 'yes'
			),
        ),
        $social_websites_settings
    );
    
        	
    $customizer_settings = array(
        'logo_section' => array(
            'title' => esc_html__( 'Logo', 'hotelwp' ),
            'settings' => $logo_settings,
        ),
        'hero_section' => array(
            'title' => esc_html__( 'Hero', 'hotelwp' ),
            'settings' => $hero_settings,
        ),
        'color_section' => array(
            'title' => esc_html__( 'Colors', 'hotelwp' ),
            'settings' => $color_settings,
        ),
		'map_section' => array(
			'title' => esc_html__( 'Map', 'hotelwp' ),
			'settings' => $map_settings,
		),
		'misc_section' => array(
			'title' => esc_html__( 'Misc', 'hotelwp' ),
			'settings' => $misc_settings,
		),
        'footer_section' => array(
            'title' => esc_html__( 'Footer', 'hotelwp' ),
            'settings' => $footer_settings,
        ),
        'custom_css' => array(
            'title' => esc_html__( 'Custom CSS', 'hotelwp' ),
            'settings' => array(
                array(
                    'id' => 'custom_css',
                    'label'	=> esc_html__( 'Custom CSS', 'hotelwp' ),
                    'type' => 'textarea'
                )
            )
        )
    );
    
    foreach ( $customizer_settings as $section_id => $section_data ) {
        $wp_customize->add_section( $section_id, array( 'title' => $section_data['title'] ) );
        foreach ( $section_data['settings'] as $setting ) {
            $sanitize_callback = 'adomus_sanitize_text';
            switch ( $setting['type'] ) {
                case 'int' : $sanitize_callback = 'adomus_sanitize_int'; break;
                case 'img' : $sanitize_callback = 'adomus_sanitize_int'; break;
                case 'url' : $sanitize_callback = 'esc_url_raw'; break;
                case 'color' : $sanitize_callback = 'adomus_sanitize_color'; break;
            }
            $setting_arg = array(
                'capability' => 'edit_theme_options',
                'sanitize_callback'	=> $sanitize_callback,
            );
            if ( $setting['id'] == 'hotelwp_site_logo' ) {
                $setting_arg['type'] = 'option';
            }
            if ( isset( $setting['default'] ) ) {
                $setting_arg['default'] = $setting['default'];
            }
            $wp_customize->add_setting( $setting['id'], $setting_arg );
            $control_args = array(
                'label' => $setting['label'],
                'section' => $section_id,
                'settings' => $setting['id'],
				'mime_type' => 'image',
            );
            if ( $setting['type'] == 'img' ) {
                $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $setting['id'], $control_args ) );
            } else if ( $setting['type'] == 'color' ) {
                $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $setting['id'], $control_args ) );
            } else if ( $setting['type'] == 'select' ) {
                $control_args['type'] = 'select';
                $control_args['choices'] = $setting['choices'];
                $wp_customize->add_control( new WP_Customize_Control( $wp_customize, $setting['id'], $control_args ) );
            } else if ( $setting['type'] == 'textarea' ) {
                $control_args['type'] = 'textarea';
                $wp_customize->add_control( $setting['id'], $control_args );
            } else {
                $wp_customize->add_control( $setting['id'], $control_args );
            }
        }
    }
}

function adomus_sanitize_text( $input ) {
	return wp_kses_post( $input );
}

function adomus_sanitize_int( $input ) {
	return intval( $input );
}

function adomus_sanitize_color( $color ) {
	if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
    } else {
		return '';
	}
}

function adomus_social_websites() {
	return array( 'facebook' , 'twitter', 'google', 'instagram', 'linkedin', 'youtube', 'flickr', 'pinterest' );
}