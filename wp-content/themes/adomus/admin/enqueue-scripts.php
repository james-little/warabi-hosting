<?php

add_action( 'admin_enqueue_scripts', 'adomus_admin_scripts' );

function adomus_admin_scripts( $hook ) {
    if ( $hook == 'post.php' || $hook == 'post-new.php' || $hook == 'edit.php' ) {
        $theme = wp_get_theme();
        $version = $theme->get( 'Version' );

        wp_enqueue_style( 'adomus-admin-css', get_template_directory_uri() . '/admin/css/admin-styles.css', false, $version );

        wp_enqueue_script( 'adomus-knockout', get_template_directory_uri() . '/admin/js/knockout-3.2.0.js', array( 'jquery' ), $version, true );
        wp_enqueue_script( 'adomus-admin-meta-box-display', get_template_directory_uri() . '/admin/js/meta-box-display.js', array( 'jquery' ), $version, true );
        wp_enqueue_script( 'adomus-admin-meta-fields-visibility', get_template_directory_uri() . '/admin/js/meta-fields-visibility.js', array( 'jquery' ), $version, true );
        wp_enqueue_script( 'adomus-add-single-media', get_template_directory_uri() . '/admin/js/add-single-media.js', array( 'jquery' ), $version, true );
        wp_enqueue_script( 'adomus-add-multiple-imgs', get_template_directory_uri() . '/admin/js/add-multiple-images.js', array( 'jquery' ), $version, true );
        wp_enqueue_script( 'adomus-sortable', get_template_directory_uri() . '/admin/js/sortable.js', array( 'jquery' ), $version, true );
        wp_enqueue_script( 'adomus-map-fields', get_template_directory_uri() . '/admin/js/map-fields.js', array( 'jquery' ), $version, true );
        wp_enqueue_script( 'jquery-ui-draggable', array( 'jquery' ) );
        wp_enqueue_script( 'jquery-ui-sortable', array( 'jquery' ) );
		wp_enqueue_editor();
        $media_text = array(
            'add_img' => esc_html__( 'Add image', 'hotelwp' ),
            'add_video' => esc_html__( 'Add video', 'hotelwp' ),
            'add_media' => esc_html__( 'Add media', 'hotelwp' ),
            'select_imgs' => esc_html__( 'Select images', 'hotelwp' ),
            'confirm_remove_all_imgs' => esc_html__( 'Are you sure to remove all images from the %s?', 'hotelwp' ),
        );
        wp_localize_script( 'adomus-add-single-media', 'adomus_media_window_strings', $media_text );
        $meta_box_text = array(
            'select_section_type' => esc_html__( 'Select a section type.', 'hotelwp' ),
            'delete_section' => esc_html__( 'Delete section?', 'hotelwp' ),
            'delete_point' => esc_html__( 'Delete point?', 'hotelwp' ),
        );
        wp_localize_script( 'adomus-admin-meta-box-display', 'adomus_meta_box_strings', $meta_box_text );
    }
    if ( $hook == 'appearance_page_hotelwp-contact-form' ) {
        $theme = wp_get_theme();
        $version = $theme->get( 'Version' );
        wp_enqueue_style( 'adomus-admin-css', get_template_directory_uri() . '/admin/css/admin-styles.css', false, $version );
    }
}