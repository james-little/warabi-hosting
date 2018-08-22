<?php

add_action( 'wp_head', 'adomus_custom_css' );

function adomus_custom_css() {
	?>
	
	<style type="text/css">
	
	<?php $link_color = get_theme_mod( 'link_color', '#46cdcf' ); ?>
	
	.button, input[type="submit"], input[type="button"], .owner-slide-overlay, .gallery-item.gallery-link-all {
		background: <?php echo( esc_html( $link_color ) ); ?>;
	}
	
	.hero-slider .slick-arrow, .owner-slider-to-left, .owner-slider-to-right, .video-section-play, .gallery-enlarge {
		background: rgba(<?php echo( esc_html( adomus_hex_2_rgb( $link_color ) ) ); ?>,0.7);
	}
	
	a.page-numbers:hover, .testimonial-bullet:hover,
	input[type="text"]:focus, input[type="email"]:focus, textarea:focus,
	.dk-select-open-up .dk-selected, .dk-select-open-down .dk-selected {
		border-color: <?php echo( esc_html( $link_color ) ); ?>;
	}
	
	.testimonial-thumb:hover {
		box-shadow: inset 0px 0px 0px 3px rgba(<?php echo( esc_html( adomus_hex_2_rgb( $link_color ) ) ); ?>, 0.7);
	}
	
	a,
	a.page-numbers:hover,
	footer a:hover {
		color: <?php echo( esc_html( $link_color ) ); ?>;
	}
	
	footer a:hover {
		border-bottom: 1px solid <?php echo( esc_html( $link_color ) ); ?>;
	}
	
	<?php $link_hover_color = get_theme_mod( 'link_hover_color', '#7098bd' ); ?>
	
	.button:hover, 
	input[type="submit"]:focus, input[type="submit"]:hover, 
	input[type="button"]:focus, input[type="button"]:hover, 
	.owner-slide-overlay:hover, .gallery-item, .gallery-item.gallery-link-all:hover,
	.featured-pages-row-img-wrapper a, .accom, .news-row .news-thumb {
		background: <?php echo( esc_html( $link_hover_color ) ); ?>;
	}
	
	.hero-slider .slick-arrow:hover, .owner-slider-to-left:hover, .owner-slider-to-right:hover, .video-section-play:hover {
		background: rgba(<?php echo( esc_html( adomus_hex_2_rgb( $link_hover_color ) ) ); ?>,0.7);
	}

	a:hover {
		color: <?php echo( esc_html( $link_hover_color ) ); ?>;
	}
	
	<?php if ( get_theme_mod( 'booking_form_white_button', 'no' ) == 'yes' ) : ?>
	.hero-booking-form input[type="submit"] {
		background: #fff;
		color: <?php echo( esc_html( $link_color ) ); ?>;
	}
	
	.hero-booking-form input[type="submit"]:focus, 
	.hero-booking-form input[type="submit"]:hover {
		background: #fff;
		color: <?php echo( get_theme_mod( 'link_hover_color', '#7098bd' ) ); ?>;
	}
	<?php endif; ?>

	<?php $booking_form_color = get_theme_mod( 'booking_form_background', get_theme_mod( 'accent_color', '#407499' ) ); ?>
	
	.hero-booking-form.hero-booking-form-is-below-hero, .hero-booking-form.hero-booking-form-always-below-hero {
		background: <?php echo( esc_html( $booking_form_color ) ); ?>;
	}
	
	.hero-booking-form {
		background: rgba(<?php echo( esc_html( adomus_hex_percent_2_rgba( $booking_form_color, get_theme_mod( 'booking_form_background_opacity', '70' ) ) ) ); ?>);
	}
	
	<?php $accent_color = get_theme_mod( 'accent_color', '#407499' ); ?>
	
	.testimonial-bullet.testimonial-current {
		background: <?php echo( esc_html( $accent_color ) ); ?>;
	}
	
	.sticky,
	input[type="text"]:focus, input[type="email"]:focus, textarea:focus, 
	.dk-option:hover,
	div.hb-accom-selected, div.hb-resa-summary-content {
		background: rgba(<?php echo( esc_html( adomus_hex_2_rgb( $accent_color ) ) ); ?>,0.2);
	}

	.map-marker-container, .map-marker-dot, .map-marker-container:before, 
	.bypostauthor .comment-wrapper, 
	blockquote,	.page-numbers.current, .testimonial-bullet.testimonial-current, table {
		border-color: <?php echo( esc_html( $accent_color ) ); ?>;
	}

	.testimonial-thumb.testimonial-current {
		box-shadow: inset 0px 0px 0px 3px rgba(<?php echo( esc_html( adomus_hex_2_rgb( $accent_color ) ) ); ?>, 0.7);
	}
	
	ul li:before, .highlight, .hightlight, .owner-name, .page-numbers.current {
		color: <?php echo( esc_html( $accent_color ) ); ?>;
	}
	
	<?php $footer_background = get_theme_mod( 'footer_background', '#ffffff' ); ?>

	footer {
		background: <?php echo( esc_html( $footer_background ) ); ?>;
	}
	
	<?php 
	$opacity_percent = get_theme_mod( 'header_background_opacity', '0' );
	if ( $opacity_percent != 0 ) :
	?>
	header {
		border: none;
	}
	.top-header {
		border-left: none;
		border-right: none;
	}
	.main-menu ul {
		top: 100px;
	}
	.main-menu ul ul {
	    top: -1px;
	}
	<?php else : ?>
	.main-menu ul li:first-child {
	    border-top: none;
	}
	<?php endif; ?>
	.top-header,
	header {
		background: rgba(<?php echo( esc_html( adomus_hex_percent_2_rgba( get_theme_mod( 'header_background', '#000000' ), $opacity_percent ) ) ); ?>);
	}
	
	.main-menu ul li,
	.mobile-top-header .widget-contact-content {
		background: rgba(<?php echo( esc_html( adomus_hex_percent_2_rgba( get_theme_mod( 'dropdown_menu_background', '#000000' ), get_theme_mod( 'dropdown_menu_background_opacity', '70' ) ) ) ); ?>);
	}
    
	.mobile-menu {
    	background: rgba(<?php echo( esc_html( adomus_hex_percent_2_rgba( get_theme_mod( 'dropdown_menu_background', '#000000' ), 95 ) ) ); ?>);
	}
	
    .hero-overlay,
    .video-block-overlay {
        background: rgba(<?php echo( esc_html( adomus_hex_percent_2_rgba( get_theme_mod( 'overlay_color', '#000000' ), get_theme_mod( 'overlay_opacity', '33' ) ) ) ); ?>);
    }
	
	<?php $gallery_img_padding = intval( get_theme_mod( 'gallery_img_padding', 0 ) ); ?>
	.gallery-item {
		bottom: <?php echo( $gallery_img_padding ); ?>px;
		left: <?php echo( $gallery_img_padding ); ?>px;
		right: <?php echo( $gallery_img_padding ); ?>px;
		top: <?php echo( $gallery_img_padding ); ?>px;
	}
	
    <?php echo( esc_html( get_theme_mod( 'custom_css' ) ) ); ?>
        
	</style>
	
	<?php
}

function adomus_hex_2_rgb( $hex ) {
	$hex = substr( $hex, 1 );
	$color = array( $hex[0] . $hex[1], $hex[2] . $hex[3], $hex[4] . $hex[5] );
	$rgb = array_map( 'hexdec', $color );
	$rgb = implode( ',', $rgb );
	return $rgb;
}

function adomus_percent_2_alpha( $percent ) {
	if ( $percent == 100 ) {
	 	return 1;
	} else if ( strlen( $percent ) == 1 ) {
		$percent = '0' . $percent;
	}
	return '0.' . $percent;
}

function adomus_hex_percent_2_rgba( $hex, $percent ) {
	return adomus_hex_2_rgb( $hex ) . ',' . adomus_percent_2_alpha( $percent );
}