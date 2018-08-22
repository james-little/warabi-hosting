<?php

add_action( 'init', 'adomus_meta_migrate' );
add_action( 'get_header', 'adomus_meta_migrate' );

function adomus_meta_migrate() {
    
    if ( is_admin() ) {
        if ( isset( $_GET['post'] ) && $_GET['action'] && $_GET['action'] == 'edit' ) {
            $post_id = $_GET['post'];
        } else {
            return;
        }
    } else if ( is_page() || is_single() ) {
        $post_id = get_queried_object_id();
		if ( ! $post_id ) {
			return;
		}
    } else {
		return;
	}
    
    if ( get_post_meta( $post_id, 'adomus_hero_type', true ) ) {
        $old_meta = array(
            'hero_type',
            'hero_video_type',
    		'hero_self_hosted_video_id',
    		'hero_youtube_video_id',
    		'hero_youtube_video_ratio',
    		'hero_slider',
    		'hero_alt_image',
    		'hero_shortcode',
    		'hero_full_screen',
    		'display_title',
    		'tagline',
    		'alt_title',
            'title_pos',
    		'hero_ratio',
    		'hero_min_height',
    		'hero_max_height',
		
            'display_booking_form',
			'booking_page_id',
			'booking_custom_shortcode',
            'booking_form_pos',
            'booking_form_style_hero',
            'booking_form_vertical_pos_hero',
            'booking_form_horizontal_pos_hero',
            'booking_form_vertical_pos_hero_narrow_screen',
            
            'display_scroll_arrow',
            'scroll_text',
            
            'display_footer',
        );
        
        $new_meta = array();
        foreach ( $old_meta as $meta_id ) {
            $new_meta[ $meta_id ] = get_post_meta( $post_id, 'adomus_' . $meta_id, true );
        }
        
        if ( 
            get_post_meta( $post_id, 'adomus_hero_type', true ) == 'video' &&
            get_post_meta( $post_id, 'adomus_hero_video_type', true ) == 'self_hosted' 
        ) {
            $new_meta[ 'hero_youtube_video_id' ] = get_post_meta( $post_id, 'adomus_hero_self_hosted_video_id', true );
            $new_meta[ 'hero_video_type' ] = 'youtube';
        }
        
        update_post_meta( $post_id, 'hotelwp_meta', wp_slash( json_encode( $new_meta ) ) );
        
        foreach ( $old_meta as $meta_id ) {
            delete_post_meta( $post_id, 'adomus_' . $meta_id );
        }
        
        $section_ids = array(
            'intro' => 'fancy_slider',
            'features' => 'pages',
            'video' => 'video',
            'accom' => 'accom',
            'gallery' => 'gallery',
            'testi' => 'testi',
            'news' => 'posts',
            'cta' => 'cta',
            'contact' => 'contact',
            'map' => 'map',
            'custom' => 'custom'
        );
        
        $meta_section_ids = array(
            'intro' => array(
                'adomus_intro_block_tagline' => 'fancy_slider__1_tagline',
                'adomus_intro_block_title' => 'fancy_slider__1_title',
                'adomus_intro_content' => 'fancy_slider__1_desc',
                'adomus_owner_img' => 'fancy_slider__1_static_img',
                'adomus_owner_mobile_img' => 'fancy_slider__1_static_mobile_img',
                'adomus_slider_imgs' => 'fancy_slider__1_slider_imgs',
                'adomus_owner_slider_autoplay' => 'fancy_slider__1_slider_autoplay',
            ),
            'features' => array(
                'adomus_features_block_tagline' => 'pages__1_tagline',
                'adomus_features_block_title' => 'pages__1_title',
                'adomus_features_page_ids' => 'pages__1_ids',
                'adomus_features_content' => 'pages__1_content',
                'adomus_features_link_title' => 'pages__1_link_title',
                'adomus_features_learn_more' => 'pages__1_link_learn_more',
                'adomus_features_thumb_link' => 'pages__1_link_thumb_link',
            ),
            'video' => array(
                'adomus_video_block_tagline' => 'video__1_tagline',
                'adomus_video_block_title' => 'video__1_title',
                'adomus_video_block_intro_text' => 'video__1_intro_text',
        		'adomus_video_block_bg_img' => 'video__1_bg_img',
        		'adomus_video_block_video_type' => 'video__1_video_type',
        		'adomus_video_block_self_hosted_video_id' => 'video__1_self_hosted_video_id',
        		'adomus_video_block_youtube_video_id' => 'video__1_youtube_video_id',
        		'adomus_video_block_youtube_video_ratio' => 'video__1_youtube_video_ratio',
            ),
            'accom' => array(
                'adomus_accom_block_tagline' => 'accom__1_tagline',
                'adomus_accom_block_title' => 'accom__1_title',
            ),
            'gallery' => array(
                'adomus_gallery_block_tagline' => 'gallery__1_tagline',
                'adomus_gallery_block_title' => 'gallery__1_title',
                'adomus_gallery_layout' => 'gallery__1_layout',
                'adomus_gallery_desc' => 'gallery__1_desc',
                'adomus_gallery_imgs' => 'gallery__1_imgs',
                'adomus_gallery_link_text' => 'gallery__1_link_text',
                'adomus_gallery_page_id' => 'gallery__1_linked_page_id',
            ),
            'testi' => array(
                'adomus_testi_block_tagline' => 'testi__1_tagline',
                'adomus_testi_block_title' => 'testi__1_title',
                'adomus_testi_layout' => 'testi__1_layout',
                'adomus_testi_nav' => 'testi__1_nav',
            ),
            'news' => array(
                'adomus_news_block_tagline' => 'posts__1_tagline',
                'adomus_news_block_title' => 'posts__1_title',
                'adomus_news_number' => 'posts__1_number',
            ),
            'cta' => array(
                'adomus_cta_text' => 'cta__1_text',
                'adomus_cta_link_text' => 'cta__1_link_text',
                'adomus_cta_link_page_id' => 'cta__1_link_page_id',
            ),
            'contact' => array(
                'adomus_contact_block_tagline' => 'contact__1_tagline',
                'adomus_contact_block_title' => 'contact__1_title',
                'adomus_contact_info' => 'contact__1_',
            ),
            'map' => array(
                'adomus_map_lat' => 'map__1_lat',
                'adomus_map_long' => 'map__1_long',
                'adomus_map_text' => 'map__1_caption',
                'adomus_map_zoom' => 'map__1_zoom',
                'adomus_map_type' => 'map__1_type',
            ),
            'custom' => array()
        );
        
        $sections = get_post_meta( $post_id, 'adomus_organizer', true );
        if ( $sections ) {
            $sections = explode( ',', $sections );
            $active_sections = array();
            $section_new_metas = array();
            $section_new_metas_inactive = array();
            foreach ( $sections as $section ) {
                $active_section = false;
                if ( get_post_meta( $post_id, 'adomus_organizer_section_' . $section, true ) == 'yes' ) {
                    $active_section = true;
                    $active_sections[] = $section_ids[ $section ];
                    foreach ( $meta_section_ids[ $section ] as $meta_old_id => $meta_new_id ) {
                        $section_new_metas[ $meta_new_id ] = get_post_meta( $post_id, $meta_old_id, true );
                    }
                } else {
                    foreach ( $meta_section_ids[ $section ] as $meta_old_id => $meta_new_id ) {
                        $section_new_metas_inactive[ $meta_new_id ] = get_post_meta( $post_id, $meta_old_id, true );
                    }
                }
            }
            
            $owner_name = get_post_meta( $post_id, 'adomus_owner_name', true );
            if ( $owner_name ) {
                $owner_name = '<p class="owner-name">' . $owner_name . '</p>';
                if ( in_array( 'fancy_slider', $active_sections ) ) {
                    $section_new_metas[ 'fancy_slider__1_desc' ] .= '<p class="owner-name">' . $owner_name . '</p>';
                } else {
                    $section_new_metas_inactive[ 'fancy_slider__1_desc' ] .= '<p class="owner-name">' . $owner_name . '</p>';
                }
				delete_post_meta( $post_id, 'adomus_owner_name' );
            }            
            $owner_title = get_post_meta( $post_id, 'adomus_owner_title', true );
            if ( $owner_title ) {
                $owner_title = '<p class="owner-title">' . $owner_title . '</p>';
                if ( in_array( 'fancy_slider', $active_sections ) ) {
                    $section_new_metas[ 'fancy_slider__1_desc' ] .= $owner_title;
                } else {
                    $section_new_metas_inactive[ 'fancy_slider__1_desc' ] .= $owner_title;
                }
				delete_post_meta( $post_id, 'adomus_owner_title' );
            }
            $img_signature = get_post_meta( $post_id, 'adomus_owner_signature', true );
            if ( $img_signature ) {
                $img_sig_url = wp_get_attachment_url( $img_signature ); 
                $img_sig_alt = get_post_meta( $img_signature, '_wp_attachment_image_alt', true );
                $img_sig_markup = '<img src="' . $img_sig_url . '" alt="' . $img_sig_alt . '" />';
                if ( in_array( 'fancy_slider', $active_sections ) ) {
                    $section_new_metas[ 'fancy_slider__1_desc' ] .= '<div class="owner-signature">';
                    $section_new_metas[ 'fancy_slider__1_desc' ] .= $img_sig_markup;
                    $section_new_metas[ 'fancy_slider__1_desc' ] .= '</div>';
                } else {
                    $section_new_metas_inactive[ 'fancy_slider__1_desc' ] .= '<div class="owner-signature">';
                    $section_new_metas_inactive[ 'fancy_slider__1_desc' ] .= $img_sig_markup;
                    $section_new_metas_inactive[ 'fancy_slider__1_desc' ] .= '</div>';
                }
				delete_post_meta( $post_id, 'adomus_owner_signature' );
            }
            
            update_post_meta( $post_id, 'hotelwp_meta_sections', wp_slash( json_encode( $section_new_metas ) ) );
            update_post_meta( $post_id, 'hotelwp_meta_sections_inactive', wp_slash( json_encode( $section_new_metas_inactive ) ) );
            if ( $active_sections ) {
                $active_sections = implode( '__1,', $active_sections ) . '__1';
            } else {
                $active_sections = '';
            }
            update_post_meta( $post_id, 'hotelwp_organizer', $active_sections );
            delete_post_meta( $post_id, 'adomus_organizer' );
            foreach ( $meta_section_ids as $section_id => $section ) {
                delete_post_meta( $post_id, 'adomus_organizer_section_' . $section_id );
                foreach ( $section as $meta_old_id => $meta_new_id ) {
                    delete_post_meta( $post_id, $meta_old_id );
                }
            }
        }
    }
	
	$meta_sections = json_decode( get_post_meta( $post_id, 'hotelwp_meta_sections', true ), true );
	if ( $meta_sections ) {
		$keys = preg_grep( '/map__._lat/', array_keys( $meta_sections, true ) );
		if ( $keys ) {
			$section_nums = array();
			foreach ( $keys as $key ) {
				$num = substr( $key, strpos( $key, '__' ) + 2, 1 );
				if ( ! in_array( $num, $section_nums ) ) {
					$section_nums[] = $num;
				}
			}
			foreach ( $section_nums as $num ) {
				$map_point = '[{"lat":"' . $meta_sections['map__' . $num . '_lat'] . '",';
				$map_point .= '"lng":"' . $meta_sections['map__' . $num . '_long'] . '",';
				$map_point .= '"caption":"' . $meta_sections['map__' . $num . '_caption'] . '"}]';
				$meta_sections['map__' . $num . '_map_points'] = $map_point;
				unset( $meta_sections['map__' . $num . '_lat'] );
				unset( $meta_sections['map__' . $num . '_long'] );
				unset( $meta_sections['map__' . $num . '_caption'] );
			}
			update_post_meta( $post_id, 'hotelwp_meta_sections', wp_slash( json_encode( $meta_sections ) ) );
		}
	}
}

add_action( 'init', 'adomus_map_contact_migrate' );
add_action( 'get_header', 'adomus_map_contact_migrate' );

function adomus_map_contact_migrate() {
	if ( is_admin() ) {
        if ( isset( $_GET['post'] ) && $_GET['action'] && $_GET['action'] == 'edit' ) {
            $post_id = $_GET['post'];
        } else {
            return;
        }
    } else if ( is_page() || is_single() ) {
        $post_id = get_queried_object_id();
		if ( ! $post_id ) {
			return;
		}
    } else {
		return;
	}
	$sections = get_post_meta( $post_id, 'hotelwp_organizer', true );
	if ( strpos( $sections, 'map_contact' ) === false && ( strpos( $sections, 'map_' ) !== false || strpos( $sections, 'contact_' ) !== false ) ) {
		if ( $sections ) {
			$sections = explode( ',', $sections );
			$map_contact_section_nb = 0;
			$new_sections = array();
			foreach ( $sections as $section ) {
				if ( strpos( $section, 'map_' ) !== false || strpos( $section, 'contact_' ) !== false ) {
					$map_contact_section_nb++;
					$section = 'map_contact__' . $map_contact_section_nb;
				}
				$new_sections[] = $section;
			}
			$new_sections = implode( ',', $new_sections );
			update_post_meta( $post_id, 'hotelwp_organizer', $new_sections );
		}
	
		$sections_info = get_post_meta( $post_id, 'hotelwp_meta_sections', true );
		if ( $sections_info ) {
			$sections_info = json_decode( $sections_info, true );
			$num = 0;
			foreach ( $sections_info as $key => $info ) {
				if ( substr( $key, 0, 3 ) == 'map' ) {
					if ( strpos( $key, 'section_editor_state' ) ) {
						$num++;
					}
					$sections_info[ 'map_contact__' . $num . '_layout' ] = 'full_width_map';
					unset( $sections_info[ $key ] );
					$current_num = substr( $key, strpos( $key, '__' ) + 2, 1 );
					$new_key = str_replace( 'map__' . $current_num, 'map_contact__' . $num, $key );
					$sections_info[ $new_key ] = $info;
				} else if ( substr( $key, 0, 7 ) == 'contact' ) {
					if ( strpos( $key, 'section_editor_state' ) ) {
						$num++;
					}				
					$sections_info[ 'map_contact__' . $num . '_layout' ] = 'contact_info_contact_form';
					unset( $sections_info[ $key ] );
					$current_num = substr( $key, strpos( $key, '__' ) + 2, 1 );
					$new_key = str_replace( 'contact__' . $current_num, 'map_contact__' . $num, $key );
					$sections_info[ $new_key ] = $info;
				}
			}
		}
		update_post_meta( $post_id, 'hotelwp_meta_sections', wp_slash( json_encode( $sections_info ) ) );
	}
}