<?php

function adomus_booking_meta_fields() {
    return array(
        'display_booking_form' => array(
            'name' => esc_html__( 'Display booking form', 'hotelwp' ),
            'type' => 'radio',
            'values' => array(
                'yes' => esc_html__( 'Yes' ),
                'no' => esc_html__( 'No' ),
            ),
            'default' => 'no',
            'bind' => true,
        ),
        'booking_page_id' => array(
            'name' => esc_html__( 'ID of the main booking page...', 'hotelwp' ),
            'type' => 'input',
            'visibility-group' => 'booking_form_options',
        ),
        'booking_custom_shortcode' => array(
            'name' => esc_html__( '...or insert a custom shortcode', 'hotelwp' ),
            'type' => 'input',
            'visibility-group' => 'booking_form_options',
        ),
        'booking_form_pos' => array(
            'name' => esc_html__( 'Booking form position', 'hotelwp' ),
            'type' => 'select',
            'values' => array(
                'inside_hero' => esc_html__( 'Inside hero on wide devices / below hero on narrow devices', 'hotelwp' ),
                'below_hero' => esc_html__( 'Below hero', 'hotelwp' ),
                'always_inside_hero' => esc_html__( 'Always inside hero', 'hotelwp' ),
            ),
            'visibility-group' => 'booking_form_options',
            'bind' => true,
        ),
        'booking_form_style_hero' => array(
            'name' => esc_html__( 'Booking form style', 'hotelwp' ),
            'type' => 'select',
            'values' => array(
                'horizontal' => esc_html__( 'Horizontal', 'hotelwp' ),
                'vertical' => esc_html__( 'Vertical', 'hotelwp' ),
            ),
            'visibility-group' => 'booking_form_hero_options',
            'bind' => true
        ),
        'booking_form_vertical_pos_hero' => array(
            'name' => esc_html__( 'Booking form vertical position in hero', 'hotelwp' ),
            'type' => 'select',
            'values' => array(
                'bottom_hero' => esc_html__( 'At the bottom of hero', 'hotelwp' ),
                'top_hero' => esc_html__( 'At the top of hero', 'hotelwp' ),
            ),
            'visibility-group' => 'booking_form_horizontal_pos_hero',
        ),                
        'booking_form_horizontal_pos_hero' => array(
            'name' => esc_html__( 'Booking form horizontal position in hero', 'hotelwp' ),
            'type' => 'select',
            'values' => array(
                'left_hero' => esc_html__( 'Left part of hero', 'hotelwp' ),
                'right_hero' => esc_html__( 'Right part of hero', 'hotelwp' ),
            ),
            'visibility-group' => 'booking_form_vertical_pos_hero',
        ),
        'booking_form_vertical_pos_hero_narrow_screen' => array(
            'name' => esc_html__( 'Booking form vertical position in hero (on narrow screen)', 'hotelwp' ),
            'type' => 'select',
            'values' => array(
                'bottom_hero' => esc_html__( 'At the bottom of hero', 'hotelwp' ),
                'top_hero' => esc_html__( 'At the top of hero', 'hotelwp' ),
            ),
            'visibility-group' => 'booking_form_vertical_pos_narrow_hero',
        ),   
    );
}

function adomus_scroll_meta_fields() {
    return array(
        'display_scroll_arrow' => array(
            'name' => esc_html__( 'Display scroll text and arrow', 'hotelwp' ),
            'type' => 'radio',
            'values' => array(
                'yes' => esc_html__( 'Yes' ),
                'no' => esc_html__( 'No' ),
            ),
            'default' => 'no',
        ),
        'scroll_text' => array(
            'name' => esc_html__( 'Call to scroll text', 'hotelwp' ),
            'type' => 'input',
        ),
    );
}

function adomus_footer_meta_fields() {
    return array(
        'display_footer' => array(
            'name' => esc_html__( 'Display footer', 'hotelwp' ),
            'type' => 'radio',
            'values' => array(
                'yes' => esc_html__( 'Yes' ),
                'no' => esc_html__( 'No' ),
            ),
            'default' => 'yes',
        )
    );
}