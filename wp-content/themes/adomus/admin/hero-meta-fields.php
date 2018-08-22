<?php

function adomus_hero_meta_fields( $sliders_names ) {
    return array(
        'hero_type' => array(
            'name' => esc_html__( 'Hero type', 'hotelwp' ),
            'type' => 'select',
            'values' => array(
                'image' => esc_html__( 'Image', 'hotelwp' ),
                'video' => esc_html__( 'Video', 'hotelwp' ),
                'slider' => esc_html__( 'Slider', 'hotelwp' ),
                'custom' => esc_html__( 'Custom', 'hotelwp' ),
            ),
            'bind' => true
        ),
        'hero_youtube_video_id' => array(
            'name' => esc_html__( 'YouTube video id', 'hotelwp' ),
            'type' => 'input',
            'visibility-group' => 'hero_video_youtube',
        ),
        'hero_youtube_video_ratio' => array(
            'name' => esc_html__( 'Video ratio', 'hotelwp' ),
            'type' => 'input',
            'visibility-group' => 'hero_video_youtube',
            'default' => '16/9'
        ),
		'hero_youtube_video_start' => array(
            'name' => esc_html__( 'Start video at (in seconds - leave blank to start at the beginning)', 'hotelwp' ),
            'type' => 'input',
            'visibility-group' => 'hero_video_youtube',
        ),
        'hero_slider' => array(
            'name' => esc_html__( 'Slider', 'hotelwp' ),
            'type' => 'select',
            'values' => $sliders_names,
            'visibility-group' => 'hero_slider',
        ),
        'hero_alt_image' => array(
            'name' => esc_html__( 'Alternative image (leave blank to use the featured image)', 'hotelwp' ),
            'type' => 'single_img',
            'visibility-group' => 'hero_image',
        ),
        'hero_shortcode' => array(
            'name' => esc_html__( 'Shortcode', 'hotelwp' ),
            'type' => 'input',
            'visibility-group' => 'hero_custom'
        ),
        'hero_full_screen' => array(
            'name' => esc_html__( 'Full screen hero', 'hotelwp' ),
            'type' => 'radio',
            'values' => array(
                'yes' => esc_html__( 'Yes', 'hotelwp' ),
                'no' => esc_html__( 'No', 'hotelwp' ),
            ),
            'default' => 'no',
            'visibility-group' => 'hero_full_screen',
            'bind' => true
        ),
        'display_title' => array(
            'name' => esc_html__( 'Display title', 'hotelwp' ),
            'type' => 'radio',
            'class' => 'htw-meta-display-title',
            'values' => array(
                'yes' => esc_html__( 'Yes' ),
                'no' => esc_html__( 'No' ),
            ),
            'default' => 'yes',
            'bind' => true
        ),
        'tagline' => array(
            'name' => esc_html__( 'Tagline', 'hotelwp' ),
            'type' => 'input',
            'visibility-group' => 'title'
        ),
        'alt_title' => array(
            'name' => esc_html__( 'Alternative title', 'hotelwp' ),
            'type' => 'input',
            'visibility-group' => 'title'
        ),
        'title_pos' => array(
            'name' => esc_html__( 'Title position', 'hotelwp' ),
            'type' => 'select',
            'values' => array(
                'default' => esc_html__( 'Default', 'hotelwp' ),
                'inside_hero' => esc_html__( 'Inside hero', 'hotelwp' ),
                'below_hero' => esc_html__( 'Below hero', 'hotelwp' ),
            ),
            'visibility-group' => 'title_pos'
        ),              
        'hero_ratio' => array(
            'name' => esc_html__( 'Ratio', 'hotelwp' ),
            'type' => 'input',
            'visibility-group' => 'hero_size'
        ),
        'hero_min_height' => array(
            'name' => esc_html__( 'Minimum height', 'hotelwp' ),
            'type' => 'input',
            'visibility-group' => 'hero_size'
        ),
        'hero_max_height' => array(
            'name' => esc_html__( 'Maximum height', 'hotelwp' ),
            'type' => 'input',
            'visibility-group' => 'hero_size'
        ),
    );
}