<?php
class HotelWPInstallPosts {
	
	public function process() {
		if ( 
			isset( $_POST['hotelwp_theme_install_nonce'] ) && 
			wp_verify_nonce( $_POST['hotelwp_theme_install_nonce'], 'hotelwp_theme_install_nonce' ) && 
			current_user_can( 'manage_options' ) 
		) {
			$demo_num = intval( $_POST['demo_num'] );
			$posts = hotelwp_demo_install_get_posts( $demo_num );
			$categories = hotelwp_demo_install_get_categories( $demo_num );
			$now = date( 'Y-m-d H:i:s' );
			$post_default_values = array(
				'post_author' => 1,
				'post_status' => 'publish',
				'post_date' => $now,
				'post_date_gmt' => $now,
				'post_modified' => $now,
				'post_modified_gmt' => $now,
			);
			global $wpdb;
			
			foreach ( $categories as $category_id => $category ) {
				$wpdb->insert( 
					$wpdb->term_taxonomy,
					array(
						'term_taxonomy_id' => $category_id, 
						'term_id' => $category_id, 
						'taxonomy' => 'category', 
						'description' => $category['description'], 
						'parent' => 0, 
						'count' => count( $category['post_ids'] )
					)
				);
				$wpdb->insert( 
					$wpdb->terms,
					array(
						'term_id' => $category_id, 
						'name' => $category['name'], 
						'slug' => $category['slug'],
						'term_group' => 0
					)
				);
				foreach ( $category['post_ids'] as $post_id ) {
					$wpdb->insert( 
						$wpdb->term_relationships,
						array(
							'object_id' => $post_id, 
							'term_taxonomy_id' => $category_id, 
							'term_order' => 0
						)
					);
				}
			}
			
			foreach ( $posts as $post_id => $post ) {
				$post_info = $post['post_info'];
				if ( $post_info['post_type'] == 'page' ) {
					$guid = site_url() . '/?page_id=' . $post_id;
				} else {
					$guid = site_url() . '/?p=' . $post_id;
				}
				$post_info['guid'] = $guid;
				$post_info['ID'] = $post_id;
				$post_to_insert = array_merge( $post_info, $post_default_values );
				
				$wpdb->insert( 
					$wpdb->posts,
					$post_to_insert
				);
				
				foreach ( $post['meta_info'] as $meta_key => $meta_value ) {
					$meta_to_insert = array(
						'post_id' => $post_id,
						'meta_key' => $meta_key,
						'meta_value' => $meta_value
					);
					$wpdb->insert( 
						$wpdb->postmeta,
						$meta_to_insert
					);	
				}
			}
			echo( 'ok' );
		}
		die;
	}

}