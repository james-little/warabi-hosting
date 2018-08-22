<?php

add_action( 'wp_enqueue_scripts', 'adomus_front_end_scripts' );

function adomus_front_end_scripts() {
    $theme = wp_get_theme();
    $version = $theme->get( 'Version' );
    
	wp_enqueue_style( 'adomus-style-font', adomus_fonts_url(), array(), $version );
	wp_enqueue_style( 'adomus-style', get_stylesheet_uri(), false, $version );
	wp_enqueue_style( 'adomus-style-font-awesome', get_template_directory_uri() . '/styles/font-awesome.min.css', array(), $version );
	wp_enqueue_style( 'adomus-grid', get_template_directory_uri() . '/styles/grid.css', array(), $version );
	wp_enqueue_style( 'adomus-media-queries', get_template_directory_uri() . '/styles/media-queries.css', array(), $version );
	wp_enqueue_style( 'adomus-datepicker', get_template_directory_uri() . '/styles/datepicker.css', array(), $version );
	wp_enqueue_style( 'adomus-photoswipe', get_template_directory_uri() . '/styles/photoswipe/photoswipe.css', array(), $version );
	wp_enqueue_style( 'adomus-photoswipe-skin', get_template_directory_uri() . '/styles/photoswipe/default-skin/default-skin.css', array(), $version );
	wp_enqueue_style( 'adomus-slick-slider-style', get_template_directory_uri() . '/styles/slick.css', false, $version );
    
	if ( is_singular() ) {
        wp_enqueue_script( 'comment-reply' );
    }
	wp_enqueue_script( 'adomus-dropkick', get_template_directory_uri() . '/js/dropkick.min.js', array( 'jquery' ), $version, true );
	wp_enqueue_script( 'adomus-photoswipe', get_template_directory_uri() . '/js/photoswipe.min.js', array(), $version, true );
	wp_enqueue_script( 'adomus-photoswipe-ui', get_template_directory_uri() . '/js/photoswipe-ui-default.min.js', array(), $version, true );
	wp_enqueue_script( 'adomus-photoswipe-launch', get_template_directory_uri() . '/js/photoswipe-launch.js', array(), $version, true );
	wp_enqueue_script( 'adomus-hover-intent', get_template_directory_uri() . '/js/hoverIntent.js', array( 'jquery' ), $version, true );
	wp_enqueue_script( 'adomus-superfish', get_template_directory_uri() . '/js/superfish.min.js', array( 'jquery' ), $version, true );
    wp_enqueue_script( 'adomus-slick-slider-script', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), $version, true );
	wp_enqueue_script( 'adomus-script-functions', get_template_directory_uri() . '/js/adomus-functions.js', array( 'jquery' ), $version, true );   
}

function adomus_fonts_url() {
    $fonts_url = '';
    /* Translators: If there are characters in your language that are not
    * supported by Open Sans, translate this to 'off'. Do not translate
    * into your own language.
    */
    $open_sans = _x( 'on', 'Open Sans font: on or off', 'hotelwp' );
    $font_families = 'Open Sans:400,700,800,400italic,700italic';
    if ( 'off' !== $open_sans ) {
        $query_args = array(
            'family' => urlencode( $font_families ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }
    return esc_url_raw( $fonts_url );
}