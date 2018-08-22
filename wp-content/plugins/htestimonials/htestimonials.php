<?php
/**
 * Plugin Name: HTestimonials
 * Plugin URI: http://hotelwp.com
 * Description: Manage testimonials.
 * Author: HotelWP
 * Version: 1.0.3
 * Author URI: http://hotelwp.com
*/

add_action( 'plugins_loaded', 'htw_load_textdomain' );

function htw_load_textdomain() {
	load_plugin_textdomain( 'hotelwp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}

add_action( 'init', 'htw_testimonials_init' );

function htw_testimonials_init() {
	
	$labels = array(
		'name'				=> __( 'Testimonials', 'hotelwp' ),
		'singular_name' 	=> __( 'Testimonial', 'hotelwp' ),
		'menu_name'			=> __( 'Testimonials', 'hotelwp' ),
		'add_new_item'		=> __( 'Add new testimonial', 'hotelwp' ),
	);	
	
	$args = array(
		'labels'			=> $labels,
		'description'		=> __( 'Manage your testimonials', 'hotelwp' ),
		'public' 			=> false,
		'show_ui'			=> true,
		'supports'			=> array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes', 'post-formats' ),
		'menu_icon' 		=> 'dashicons-format-quote',
	);

	register_post_type( 'htw_testimonials', $args );
}


function htw_testimonials_meta_box() {
	add_meta_box( 'htw-testimonials-meta-box', __( 'Testimonial', 'hotelwp' ), 'htw_testimonials_meta_box_display', 'htw_testimonials', 'normal', 'high' );
}

function htw_testimonials_meta_box_display( $post ) {
	$metas = array(
		array(
			'id' => 'htw-testimonial-author',
			'name' => __( 'Author name', 'hotelwp' ),
		),
		array(
			'id' => 'htw-testimonial-info',
			'name' => __( 'Author information', 'hotelwp' ),
		),
		array(
			'id' => 'htw-testimonial-intro',
			'name' => __( 'Introduction text', 'hotelwp' ),
		),
	);
	foreach ( $metas as $meta ) :
	?>
	
	<p>
		<label for="<?php echo( $meta['id'] ); ?>"><b><?php echo( $meta['name'] ); ?></b></label><br/>
		<input id="<?php echo( $meta['id'] ); ?>" name="<?php echo( $meta['id'] ); ?>" type="text" class="widefat" value="<?php echo( esc_attr( get_post_meta( $post->ID, $meta['id'] , true ) ) ); ?>" />
	</p>
	
	<?php
	endforeach;
}

add_action( 'add_meta_boxes', 'htw_testimonials_meta_box' );

function htw_testimonials_save_postdata( $post_id ) {
	if ( get_post_type( $post_id ) == 'htw_testimonials' ) {
		$meta_keys = array(
			'htw-testimonial-author',
			'htw-testimonial-info',
			'htw-testimonial-intro',
		);
		foreach( $meta_keys as $meta_key ) {
			if ( isset( $_POST[$meta_key] ) ) {
				update_post_meta( $post_id, $meta_key , wp_kses_post( stripslashes( $_POST[ $meta_key ] ) ) );
			}
		}
	}
}

add_action( 'save_post', 'htw_testimonials_save_postdata' );
add_action( 'publish_post', 'htw_testimonials_save_postdata');

function htestimonials_is_active() {
}