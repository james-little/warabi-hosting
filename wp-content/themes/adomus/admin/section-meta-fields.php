<?php

function adomus_section_meta_fields() {
    $section_meta_fields = array(
        'fancy_slider' => array(
            'desc' => array(
                'name' => esc_html__( 'Text', 'hotelwp' ),
                'type' => 'textarea',
            ),
            'static_img' => array(
                'name' => esc_html__( 'Static image', 'hotelwp' ),
                'type' => 'single_img',
            ),
            'static_mobile_img' => array(
                'name' => esc_html__( 'Static mobile image', 'hotelwp' ),
                'type' => 'single_img',
            ),
            'slider_imgs' => array(
                'name' => esc_html__( 'Slider images', 'hotelwp' ),
                'type' => 'multi_imgs',
                'sub_type' => esc_html__( 'slider', 'hotelwp' ),
            ),
            'slider_autoplay' => array(
                'name' => esc_html__( 'Slider autoplay speed (in ms - leave blank for no autoplay)', 'hotelwp' ),
                'type' => 'input'
            )
        ),
        
		'text_img' => array(
			'layout' => array(
                'name' => esc_html__( 'Layout', 'hotelwp' ),
                'type' => 'select',
                'values' => array(
                    'text_left' => esc_html__( 'Text on left', 'hotelwp' ),
                    'text_right' => esc_html__( 'Text on right', 'hotelwp' ),
                )
            ),
			'desc' => array(
				'name' => esc_html__( 'Text', 'hotelwp' ),
				'type' => 'textarea',
			),
			'img' => array(
				'name' => esc_html__( 'Image', 'hotelwp' ),
				'type' => 'single_img',
			),
		),
		
        'pages' => array(
            'ids' => array(
                'name' => esc_html__( 'Page ids (comma-separated)', 'hotelwp' ),
                'type' => 'input',
            ),
            'content' => array(
                'name' => esc_html__( 'Displayed content', 'hotelwp' ),
                'type' => 'radio',
                'values' => array(
                    'page_content' => esc_html__( 'Page content', 'hotelwp' ),
                    'excerpt' => esc_html__( 'Excerpt', 'hotelwp' ),
                ),
                'default' => 'page_content',
            ),
            'link_title' => array(
                'name' => esc_html__( 'Link title to page', 'hotelwp' ),
                'type' => 'radio',
                'values' => array(
                    'yes' => esc_html__( 'Yes', 'hotelwp' ),
                    'no' => esc_html__( 'No', 'hotelwp' ),
                ),
                'default' => 'no',
            ),
            'learn_more' => array(
                'name' => esc_html__( 'Display a "Learn more" button', 'hotelwp' ),
                'type' => 'radio',
                'values' => array(
                    'yes' => esc_html__( 'Yes', 'hotelwp' ),
                    'no' => esc_html__( 'No', 'hotelwp' ),
                ),
                'default' => 'no',
            ),
            'thumb_link' => array(
                'name' => esc_html__( 'Thumbnail link type', 'hotelwp' ),
                'type' => 'select',
                'values' => array(
                    'no_link' => esc_html__( 'No link', 'hotelwp' ),
                    'full_size_img' => esc_html__( 'Full-size image', 'hotelwp' ),
                    'full_size_img_gallery' => esc_html__( 'Full-size image (gallery)', 'hotelwp' ),
                    'page' => esc_html__( 'Page', 'hotelwp' ),
                ),
            ),
        ),
        
        'video' => array(
            'intro_text' => array(
                'name' => esc_html__( 'Video introduction text', 'hotelwp' ),
                'type' => 'textarea',
            ),
            'bg_img' => array(
                'name' => esc_html__( 'Background image', 'hotelwp' ),
                'type' => 'single_img',
            ),
            'youtube_video_id' => array(
                'name' => esc_html__( 'YouTube video id', 'hotelwp' ),
                'type' => 'input',
                'class' => 'adomus-video-block-youtube'
            ),
            'youtube_video_ratio' => array(
                'name' => esc_html__( 'Video ratio', 'hotelwp' ),
                'type' => 'input',
                'class' => 'adomus-video-block-youtube'
            ),
        ),
        
        'accom' => array(
            'selected_elts' => array(
                'name' => esc_html( 'Displayed accommodation', 'hotelwp' ),
                'type' => 'multiple_select',
                'type_name' => esc_html__( 'accommodation', 'hotelwp' ),
                'values' => adomus_get_post_type_titles( 'hb_accommodation' ),
                'default' => 'all'
            )
        ),
        
        'gallery' => array(
            'layout' => array(
                'name' => esc_html__( 'Layout', 'hotelwp' ),
                'type' => 'select',
                'values' => array(
                    'left' => esc_html__( 'Text left', 'hotelwp' ),
                    'center' => esc_html__( 'Text center', 'hotelwp' ),
                    'right' => esc_html__( 'Text right', 'hotelwp' ),
                )
            ),
            'desc' => array(
                'name' => esc_html__( 'Text', 'hotelwp' ),
                'type' => 'textarea',
            ),
            'imgs' => array(
                'name' => esc_html__( 'Images', 'hotelwp' ),
                'type' => 'multi_imgs',
                'sub_type' => esc_html__( 'gallery', 'hotelwp' ),
            ),
            'link_text' => array(
                'name' => esc_html__( 'Link text', 'hotelwp' ),
                'type' => 'input',
            ),
            'linked_page_id' => array(
                'name' => esc_html__( 'ID of the gallery page', 'hotelwp' ),
                'type' => 'input',
            ),
        ),
        
        'testi' => array(
            'layout' => array(
                'name' => esc_html__( 'Layout', 'hotelwp' ),
                'type' => 'select',
                'values' => array(
                    'big_img_left' => esc_html__( 'Big image on left', 'hotelwp' ),
                    'big_img_right' => esc_html__( 'Big image on right', 'hotelwp' ),
                    'centered_content' => esc_html__( 'Centered content', 'hotelwp' ),
                )  
            ),
            'nav' => array(
                'name' => esc_html__( 'Navigation', 'hotelwp' ),
                'type' => 'select',
                'values' => array(
                    'thumbs' => esc_html__( 'Thumbnails', 'hotelwp' ),
                    'bullets' => esc_html__( 'Bullets', 'hotelwp' ),
                    'thumbs_and_bullets' => esc_html__( 'Thumbnails and bullets', 'hotelwp' ),
                )  
            ),
            'selected_elts' => array(
                'name' => esc_html( 'Displayed testimonials', 'hotelwp' ),
                'type' => 'multiple_select',
                'type_name' => esc_html__( 'testimonials', 'hotelwp' ),
                'values' => adomus_get_post_type_titles( 'htw_testimonials' ),
                'default' => 'all'
            )
        ),
        
        'posts' => array(
            'number' => array(
                'name' => esc_html__( 'Number of posts to display', 'hotelwp' ),
                'type' => 'input',
            ),
			'layout' => array(
                'name' => esc_html__( 'Layout', 'hotelwp' ),
                'type' => 'select',
                'values' => array(
                    'img_right' => esc_html__( 'Images on right', 'hotelwp' ),
                    'img_left' => esc_html__( 'Images on left', 'hotelwp' ),
                    'img_right_left' => esc_html__( 'Images on right / left', 'hotelwp' ),
                    'img_left_right' => esc_html__( 'Images on left / right', 'hotelwp' ),
                )  
            ),
			'meta' => array(
                'name' => esc_html__( 'Display meta information', 'hotelwp' ),
                'type' => 'radio',
                'values' => array(
                    'yes' => esc_html__( 'Yes', 'hotelwp' ),
                    'no' => esc_html__( 'No', 'hotelwp' ),
                ),
                'default' => 'yes',
            ),
            'selected_elts' => array(
                'name' => esc_html( 'Displayed category', 'hotelwp' ),
                'type' => 'multiple_select',
                'type_name' => esc_html__( 'categories', 'hotelwp' ),
                'values' => adomus_get_category_titles(),
                'default' => 'all'
            )
        ),
        
        'cta' => array(
            'text' => array(
                'name' => esc_html__( 'Text', 'hotelwp' ),
                'type' => 'input',
            ),
            'link_text' => array(
                'name' => esc_html__( 'Link text', 'hotelwp' ),
                'type' => 'input',
            ),
            'link_page_id' => array(
                'name' => esc_html__( 'Link page id', 'hotelwp' ),
                'type' => 'input',
            ),
        ),
        
        'map_contact' => array(
			'layout' => array(
				'name' => esc_html__( 'Layout', 'hotelwp' ),
				'type' => 'select',
                'values' => array(
                    'contact_form_map' => esc_html__( 'Contact form and map', 'hotelwp' ),
                    'contact_info_map' => esc_html__( 'Contact information and map', 'hotelwp' ),
                    'contact_info_contact_form' => esc_html__( 'Contact information and contact form', 'hotelwp' ),
                    'contact_form_only' => esc_html__( 'Contact form only', 'hotelwp' ),
					'full_width_map' => esc_html__( 'Full-width map', 'hotelwp' ),
                ),
				'class' => 'adomus-contact-map-layout'
			),
			'map_position' => array(
				'name' => esc_html__( 'Map position', 'hotelwp' ),
				'type' => 'select',
                'values' => array(
                    'right' => esc_html__( 'Right', 'hotelwp' ),					
                    'left' => esc_html__( 'Left', 'hotelwp' ),
                ),
				'class' => 'adomus-contact-map-option adomus-contact-map-position-option'
			),
			'contact_form_position' => array(
				'name' => esc_html__( 'Contact form position', 'hotelwp' ),
				'type' => 'select',
                'values' => array(
					'right' => esc_html__( 'Right', 'hotelwp' ),
                    'left' => esc_html__( 'Left', 'hotelwp' ),
                ),
				'class' => 'adomus-contact-form-option adomus-contact-form-position-option'
			),
			'contact_form_tagline' => array(
				'name' => esc_html__( 'Contact form tagline', 'hotelwp' ),
				'type' => 'input',
				'class' => 'adomus-contact-form-option'
			),
			'contact_form_title' => array(
				'name' => esc_html__( 'Contact form title', 'hotelwp' ),
				'type' => 'input',
				'class' => 'adomus-contact-form-option'
			),
			'contact_info_tagline' => array(
				'name' => esc_html__( 'Contact info tagline', 'hotelwp' ),
				'type' => 'input',
				'class' => 'adomus-contact-info-option'
			),
			'contact_info_title' => array(
				'name' => esc_html__( 'Contact info title', 'hotelwp' ),
				'type' => 'input',
				'class' => 'adomus-contact-info-option'
			),
            'contact_info' => array(
                'name' => esc_html__( 'Contact information', 'hotelwp' ),
                'type' => 'textarea',
				'class' => 'adomus-contact-info-option'
            ),
			'type' => array(
                'name' => esc_html__( 'Map type', 'hotelwp' ),
                'type' => 'select',
                'values' => array(
                    'road' => esc_html__( 'Road', 'hotelwp' ),
                    'satellite' => esc_html__( 'Satellite', 'hotelwp' ),
                    'hybrid' => esc_html__( 'Hybrid', 'hotelwp' ),
                    'terrain' => esc_html__( 'Terrain', 'hotelwp' )
                ),
				'class' => 'adomus-contact-map-option'
            ),
            'zoom' => array(
                'name' => esc_html__( 'Map zoom', 'hotelwp' ),
                'type' => 'input',
				'class' => 'adomus-contact-map-option'
            ),
            'map_points' => array(
                'type' => 'map_points',
            ),
        ),
        
        'editor' => array(
            'desc' => array(
                'type' => 'custom',
                'custom_content' => esc_html__( 'This section will contain the content of the WordPress default editor (located at the top of this page).', 'hotelwp' )
            )
        ),
        
        'custom' => array(
            'content' => array(
                'type' => 'editor',
            )
        ),
    );
    
    foreach ( $section_meta_fields as $section_id => $meta_fields ) {
        $section_editor_state = array(
            'section_editor_state' => array(
                'name' => '',
                'type' => 'input',
                'class' => 'section-editor-state'
            )
        );
        $title_tagline = array();
        $sections_witout_title = array( 'map_contact', 'cta', 'editor', 'custom' );
        if ( ! in_array( $section_id, $sections_witout_title) ) {
            $title_tagline = array(
                'tagline' => array(
                    'name' => esc_html__( 'Section tagline', 'hotelwp' ),
                    'type' => 'input'
                ),
                'title' => array(
                    'name' => esc_html__( 'Section title', 'hotelwp' ),
                    'type' => 'input'
                ),
            );
        }
        $section_meta_fields[ $section_id ] = array_merge( $section_editor_state, $title_tagline, $meta_fields );
    }
    return $section_meta_fields;
}

function adomus_get_post_type_titles( $post_type ) {
    global $post;
    $args = array( 
        'post_type' => $post_type,
        'posts_per_page'=> -1,
        'suppress_filters' => false,
    );
	$posts = get_posts( $args );
    $post_type_titles = array();
    foreach ( $posts as $post ) {
		setup_postdata( $post );
        $post_type_titles[ $post->ID ] = get_the_title();
	}
	wp_reset_postdata();
    return $post_type_titles;
}

function adomus_get_category_titles() {
    $cat = get_categories();
    $returned_cat = array();
    foreach ( $cat as $c ) {
        $returned_cat[ $c->cat_ID ] = get_cat_name( $c->cat_ID );
    }
    return $returned_cat;
}
