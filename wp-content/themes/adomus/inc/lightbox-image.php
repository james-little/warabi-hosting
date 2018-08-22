<?php

add_shortcode( 'htw_lightbox_image', 'hotelwp_lightbox_image' );

function hotelwp_lightbox_image( $atts ) {
    extract( shortcode_atts(
        array(
            'img_id' => '',
            'width' => '100%',
            'ratio' => '16/9',
        ), 
        $atts, 
        'htw_lightbox_image' 
    ) );
    
    if ( ! $img_id ) {
        return esc_html__( 'The "img_id" argument is missing.', 'hotelwp' );
    }
    
    if ( substr( $width, -1 ) == '%' ) {
        $percent_width = str_replace( '%', '', $width );
        $img_width = round( hotelwp_img_full_width_default() * $percent_width / 100 );
    } else if ( substr( $width, -2 ) == 'px' ) {
        $img_width = str_replace( 'px', '', $width );
    } else {
        return esc_html__( 'The value of the "width" argument is not valid.', 'hotelwp' );
    }
    
    $img_ratio = hotelwp_ratio_str_2_nbr( $ratio );
    if ( ! $img_ratio ) {
        $img_ratio = $ratio;
    }
    
    $img_height = round( $img_width / $img_ratio );
    
    $img = wp_get_attachment_image_src( $img_id, 'full' );
    $img_url = aq_resize( $img[0], $img_width, $img_height, true, true, true );
    $img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
    $img_post = get_post( $img_id );
    $img_caption = $img_post->post_excerpt;
    $photoswipe_data = 'data-caption="' . $img_caption . '" data-width="' . $img[1] . '" data-height="' . $img[2] . '"';
    
    $mark_up = '<a style="width: ' . $width . '" class="photoswipe-item" ' . $photoswipe_data . ' href="' . $img[0] .'">';
    $mark_up .= '<img src="' . $img_url . '" alt="' . $img_alt . '" />';
    $mark_up .= '</a>';
    
    return $mark_up;
}