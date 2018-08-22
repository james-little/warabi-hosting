<?php

function adomus_menu_init() {
	register_nav_menus( array(
		'adomus_menu' => esc_html__( 'Header Menu', 'hotelwp' )
	) );
}

add_action( 'init', 'adomus_menu_init' );

function adomus_excerpt_support_for_pages() {
	add_post_type_support( 'page', 'excerpt' );
}

add_action( 'init', 'adomus_excerpt_support_for_pages' );

if ( ! isset( $content_width ) ) {
	$content_width = 1290;
}

add_filter( 'widget_text', 'do_shortcode' );

function adomus_custom_theme_setup() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	load_theme_textdomain( 'hotelwp', get_template_directory() . '/languages' );
}

add_action( 'after_setup_theme', 'adomus_custom_theme_setup' );

add_action( 'after_switch_theme', 'adomus_setup_options' );

function adomus_setup_options() {
	$contact_form_settings = get_option( 'hotelwp_contact_form_settings' );
	if ( ! $contact_form_settings ) {
		$contact_form_settings = array(
			'to_address' => '',
			'reply_to_address' => '[name] <[email]>',
			'from_address' => '',
			'subject' => 'New message from your website',
			'message' => "Here is a new message form your website:\r\n\r\nName:[name]\r\nEmail:[email]\r\nMessage:\r\n[message]",
			'message_type' => 'text'
		);
		update_option( 'hotelwp_contact_form_settings', json_encode( $contact_form_settings ) );
		$contact_form_fields = array(
			array(
				'id' => 'name',
				'name' => 'Name',
				'type' => 'text',
				'required' => 'yes',
				'choices' => array(),
				'column_width' => 'half'
			),
			array(
				'id' => 'email',
				'name' => 'Email',
				'type' => 'email',
				'required' => 'yes',
				'choices' => array(),
				'column_width' => 'half'
			),
			array(
				'id' => 'message',
				'name' => 'Message',
				'type' => 'textarea',
				'required' => 'yes',
				'choices' => array(),
				'column_width' => ''
			)
		);
		update_option( 'hotelwp_contact_form_fields', json_encode( $contact_form_fields ) );
	}
}