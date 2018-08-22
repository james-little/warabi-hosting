<?php

if ( ! function_exists( 'hbook_is_active' ) ) {
	add_action( 'init', 'adomus_create_accommodation_post_type' );
	add_action( 'add_meta_boxes', 'adomus_accommodation_meta_box' );
	add_action( 'save_post_hb_accommodation', 'adomus_save_accommodation_meta' );
	add_action( 'pre_get_posts', 'adomus_admin_accom_order' );
} else {
	add_filter( 'hb_accommodation_supports', 'adomus_accommodation_excerpts' );
}

if ( ! function_exists( 'adomus_create_accommodation_post_type' ) ) {
    function adomus_create_accommodation_post_type() {
        register_post_type( 'hb_accommodation',
            array(
                'labels' => array(
                    'name' => esc_html__( 'Accommodation', 'hotelwp' ),
                    'add_new' => esc_html__( 'Add New Accommodation', 'hotelwp' ),
                    'add_new_item' => esc_html__( 'Add New Accommodation', 'hotelwp' ),
                    'edit_item' => esc_html__( 'Edit Accommodation', 'hotelwp' ),
                    'new_item' => esc_html__( 'New Accommodation', 'hotelwp' ),
                    'view_item' => esc_html__( 'View Accommodation post', 'hotelwp' ),
                    'search_items' => esc_html__( 'Search Accommodation', 'hotelwp' ),
                    'not_found' => esc_html__( 'No accommodation found.', 'hotelwp' ),
                    'not_found_in_trash' => esc_html__( 'No accommodation post found in trash.', 'hotelwp' ),
                ),
                'public' => true,
                'has_archive' => true,
                'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
                'menu_icon' => 'dashicons-admin-home'
            )
        );
    }
}

function adomus_accommodation_meta_box() {
	add_meta_box( 'accommodation_side_meta_box', __( 'Accommodation display', 'hotelwp' ), 'adomus_accommodation_side_meta_box_display', 'hb_accommodation', 'side' );
}

function adomus_accommodation_side_meta_box_display( $post ) {
	?>
	
	<p>
        <label for="hb-accom-page-template" class="adomus-accom-template-choice-label"><?php _e( 'Select a template:', 'hotelwp' ); ?></label>
        <?php
		$page_templates = array(
			'post' => __( 'Accommodation post', 'hotelwp' ),
			'template-advanced-layout.php' => __( 'Advanced layout Template', 'hotelwp' ),
		);
        $current_template = get_post_meta( $post->ID, 'accom_page_template', true ); 
        ?>
        <select id="hb-accom-page-template" name="hb-accom-page-template">
            <?php foreach ( $page_templates as $template_file => $template_name ) : ?>
            <option value="<?php echo( $template_file ); ?>"<?php if ( $template_file == $current_template ) : ?> selected<?php endif; ?>>
                <?php echo( $template_name );?>
            </option>
            <?php endforeach; ?>
        </select>
    </p>
	
	<?php
}

function adomus_save_accommodation_meta( $post_id ) {
	if ( isset( $_REQUEST['hb-accom-page-template'] ) ) {
		update_post_meta( $post_id, 'accom_page_template', sanitize_text_field( $_REQUEST['hb-accom-page-template'] ) );
	}
}

function adomus_admin_accom_order( $query ) {
	if ( is_admin() && $query->get( 'post_type' ) == 'hb_accommodation' ) {
		$query_orderby = $query->get( 'orderby' );
		if ( ! $query_orderby ) {
			$query->set( 'order', 'ASC' );
		}
	}
}

function adomus_accommodation_excerpts( $supports ) {
	$supports[] = 'excerpt';
	return $supports;
}