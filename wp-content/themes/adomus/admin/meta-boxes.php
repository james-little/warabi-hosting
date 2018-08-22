<?php

function adomus_meta_boxes() {
    $sliders = json_decode( get_option( 'hotelwp_sliders' ), true );
    $sliders_names = array();
    if ( $sliders ) {
        foreach( $sliders as $slider ){
            $sliders_names[ $slider['slideshowId'] ] = $slider['slideshowName'];
        }
    }
        
	return array(
		'hero' => array(
            'name' => esc_html__( 'Hero', 'hotelwp' ),
            'fields' => adomus_hero_meta_fields( $sliders_names )
        ),
        'booking' => array(
            'name' => esc_html__( 'Booking form', 'hotelwp' ),
            'fields' => adomus_booking_meta_fields()
		),
        'scroll' => array(
            'name' => esc_html__( 'Scroll', 'hotelwp' ),
            'fields' => adomus_scroll_meta_fields()
		),
        'sections' => array(
            'name' => esc_html__( 'Page sections', 'hotelwp' ),
            'fields' => array()
        ),
        'footer' => array(
            'name' => esc_html__( 'Footer', 'hotelwp' ),
            'fields' => adomus_footer_meta_fields()
        )
	);		
}

add_action( 'add_meta_boxes', 'adomus_add_meta_boxes' );

function adomus_add_meta_boxes() {
	$meta_boxes = adomus_meta_boxes();
	foreach ( $meta_boxes as $meta_box_id => $meta_box ) {
		add_meta_box( 'adomus-meta-box-' . $meta_box_id, $meta_box['name'], 'adomus_meta_box_display', 'page', 'normal', 'high' );
		add_meta_box( 'adomus-meta-box-' . $meta_box_id, $meta_box['name'], 'adomus_meta_box_display', 'hb_accommodation', 'normal' );
		if ( $meta_box_id == 'hero' ) {
            add_meta_box( 'adomus-meta-box-' . $meta_box_id, $meta_box['name'], 'adomus_meta_box_display', 'post', 'normal', 'high' );
		}
	}
}

function adomus_meta_box_display( $post, $params ) {
    $meta_box_id = str_replace( 'adomus-meta-box-', '', $params['id'] );
    if ( $meta_box_id == 'sections' ) {
        adomus_meta_box_page_sections_display();
    } else {
    	$meta_boxes = adomus_meta_boxes();
    	$meta_fields = $meta_boxes[ $meta_box_id ]['fields'];
    	foreach ( $meta_fields as $meta_id => $meta ) {
    		$field_function = 'adomus_meta_' . $meta['type'];
    		$field_function( 'adomus_' . $meta_id, $meta );
    	}
    }
}

add_action( 'save_post', 'adomus_save_metapostdata' );
add_action( 'publish_post', 'adomus_save_metapostdata' );

function adomus_save_metapostdata( $post_id ) {
    if ( isset( $_POST['adomus_organizer'] ) ) {
        $metas = array();
        $sections = $_POST['adomus_organizer'];
        update_post_meta( $post_id, 'hotelwp_organizer', $sections );
        if ( $sections ) {
            $sections = explode( ',', $sections );
            $section_meta_fields = adomus_section_meta_fields();
            foreach ( $sections as $section_id ) {
                $section_type = substr( $section_id, 0, strpos( $section_id, '__' ) );
                foreach ( $section_meta_fields[ $section_type ] as $meta_id => $meta ) {
                    $metas[] = $section_id . '_' . $meta_id;
                }
            }
            $meta_values = array();
            foreach ( $metas as $meta_id ) {
                if ( strpos( $meta_id, 'selected_elts' ) > 0 ) {
					if ( 
						( 
							isset( $_POST[ 'adomus_' . $meta_id . '_checkbox' ] ) && 
							$_POST[ 'adomus_' . $meta_id . '_checkbox' ] == 'all' 
						) || 
						! isset( $_POST[ 'adomus_' . $meta_id ] ) 
					) {
                        $meta_values[ $meta_id ] = 'all';
                    } else {
                        $meta_values[ $meta_id ] = esc_html( implode( ',', $_POST[ 'adomus_' . $meta_id ] ) );
                    }
                } else if ( isset( $_POST[ 'adomus_' . $meta_id ] ) ) {
                    $meta_values[ $meta_id ] = wp_kses_post( stripslashes( $_POST[ 'adomus_' . $meta_id ] ) );
                }
            }
            update_post_meta( $post_id, 'hotelwp_meta_sections', wp_slash( json_encode( $meta_values ) ) );
        } else {
            update_post_meta( $post_id, 'hotelwp_meta_sections', json_encode( array() ) );
        }
    }
    
    if ( isset( $_POST['adomus_hero_type'] ) ) {
        $meta_boxes = adomus_meta_boxes();
        $metas = array();
        foreach ( $meta_boxes as $meta_box ) {
            $metas = array_merge( $metas, array_keys( $meta_box['fields'] ) );
        }
        $meta_values = array();
        foreach ( $metas as $meta_id ) {
            if ( isset( $_POST[ 'adomus_' . $meta_id ] ) ) {
                $meta_values[ $meta_id ] = wp_kses_post( stripslashes( $_POST[ 'adomus_' . $meta_id ] ) );
            }
        }
        update_post_meta( $post_id, 'hotelwp_meta', wp_slash( json_encode( $meta_values ) ) );
    }
}

function adomus_get_current_post_meta( $meta_id ) {
    static $metas;
    if ( ! $metas ) {
        if ( is_admin() ) {
            if ( isset( $_GET['post'] ) ) {
                $post_id = $_GET['post'];
            } else {
                return '';
            }
        } else if ( is_single() || is_page() || is_home() ) {
            $post_id = get_queried_object_id();
        } else {
			return '';
		}
        $adomus_meta_sections = json_decode( get_post_meta( $post_id, 'hotelwp_meta_sections', true ), true );
        if ( ! $adomus_meta_sections ) {
            $adomus_meta_sections = array();
        }
        $adomus_meta = json_decode( get_post_meta( $post_id, 'hotelwp_meta', true ), true );
        if ( ! $adomus_meta ) {
            $adomus_meta = array();
        }
        $adomus_sections = array(
            'organizer' => get_post_meta( $post_id, 'hotelwp_organizer', true )
        );
        $metas = array_merge( $adomus_sections, $adomus_meta_sections, $adomus_meta );
    }
    $meta_id = str_replace( 'adomus_', '', $meta_id );
    if ( isset( $metas[ $meta_id ] ) ) {
        return $metas[ $meta_id ];
    } else {
        return '';
    }
}

function adomus_get_post_meta( $post_id, $meta_id ) {
    $metas = json_decode( get_post_meta( $post_id, 'hotelwp_meta', true ), true );
    if ( isset( $metas[ $meta_id ] ) ) {
        return $metas[ $meta_id ];
    } else {
        return '';
    }
}