<?php

add_filter( 'post_gallery', 'adomus_gallery', 10, 2);

function adomus_gallery( $output, $atts ) {
	extract( shortcode_atts( array(  
		'ids' => '',
		'columns' => 3,
		'orderby' => '',
        'ratio' => '16/9',
        'padding' => ''
    ), $atts ) );
	
    $img_ratio = hotelwp_ratio_str_2_nbr( $ratio );
    if ( ! $img_ratio ) {
        $img_ratio = $ratio;
    }
    
    $column_ratio = round( 100 / $img_ratio / $columns, 2);
    
    $column_width = round( 100 / $columns, 2 );
    
	$img_width = round( 1650 / $columns );
	$img_height = round( $img_width / $img_ratio );
	
    $img_mobile_size = 500;

	if ( ! $padding ) {
		$padding = intval( get_theme_mod( 'gallery_img_padding', 0 ) );
	}
	
	if ( $ids ) {
		$img_ids = explode( ',', $ids );
	} else {
		$img_ids = array();
	}
	
	if ( $orderby == 'rand' ) {
		shuffle( $img_ids );
	}
	
	static $gallery_num = 0;
	$gallery_num++;
	$id = 'gallery-' . $gallery_num;
	$mark_up = '<div class="' . $id . ' gallery-wrapper columns-wrapper">';
	foreach ( $img_ids as $img_id ) {
		$img = wp_get_attachment_image_src( $img_id, 'full' );
		$img_url_desktop = aq_resize( $img[0], $img_width, $img_height, true, true, true );
		$img_url_mobile = aq_resize( $img[0], $img_mobile_size, $img_mobile_size, true, true, true );
		$img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
		$img_post = get_post( $img_id );
		$img_caption = $img_post->post_excerpt;
		$photoswipe_data = 'data-caption="' . $img_caption . '" data-width="' . $img[1] . '" data-height="' . $img[2] . '"';
		$mark_up .=	'<div class="gallery-column">';
		$mark_up .= '<a class="gallery-item photoswipe-item" ' . $photoswipe_data . ' href="' . wp_get_attachment_url( $img_id ) .'">';
		$mark_up .= '<img class="gallery-img-desktop" src="' . $img_url_desktop . '" alt="' . $img_alt . '" />';
		$mark_up .= '<img class="gallery-img-mobile" src="' . $img_url_mobile . '" alt="' . $img_alt . '" />';
		$mark_up .= '<div class="gallery-enlarge"></div>';
		$mark_up .= '</a>';
		$mark_up .= '</div>';
	}
    $mark_up .= '<style type="text/css">';
    $mark_up .= '.' . $id . ' .gallery-column { width: ' .  $column_width . '%; padding-bottom: ' . $column_ratio . '%; }';
    $mark_up .= '.' . $id . ' { margin-left: -' .  $padding . 'px; margin-right: -' . $padding . 'px; }';
    $mark_up .= '.' . $id . ' .gallery-item {';
    $mark_up .= 'bottom: ' . $padding . 'px;';
    $mark_up .= 'left: ' . $padding . 'px;';
    $mark_up .= 'right: ' . $padding . 'px;';
    $mark_up .= 'top: ' . $padding . 'px;';
    $mark_up .= '}';
    $mark_up .= '</style>';
	$mark_up .= '</div>';

	return $mark_up;	
}	