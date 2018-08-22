<?php
class HotelWPInstallImages {

	public function process() {
		if ( 
			isset( $_POST['hotelwp_theme_install_nonce'] ) && 
			wp_verify_nonce( $_POST['hotelwp_theme_install_nonce'], 'hotelwp_theme_install_nonce' ) && 
			current_user_can( 'manage_options' ) 
		) {
			$demo_num = intval( $_POST['demo_num'] );
			$sub_step = intval( $_POST['sub_step'] );
			$imgs = hotelwp_demo_install_get_img_list( $demo_num, $sub_step );
			$theme_name = strtolower( wp_get_theme() );
			$theme_dir = $theme_name . '-img-demo/';
			$server_url = 'https://hotelwp.com/demo-install-images/' . $theme_name . '/';
			global $wpdb;
			
			$upload_dir = wp_upload_dir();
			if ( $upload_dir['error'] ) {
				echo( esc_html( $upload_dir['error'] ) );
				die;
			}
			$upload_url = $upload_dir['baseurl'] . '/' . $theme_dir;
			$upload_dir = $upload_dir['basedir'] . '/' . $theme_dir;
			
			if ( $sub_step == 0 ) {
				if ( file_exists( $upload_dir ) ) {
					$this->rrmdir( $upload_dir );
				}
				wp_mkdir_p( $upload_dir );
			}
			
			foreach ( $imgs as $img ) {
				$file_src = $server_url . 'demo-' . $demo_num . '/' . $img['name'];
				$file_dest = $upload_dir . $img['name'];
				
				if ( ! copy( $file_src, $file_dest ) ) {
					esc_html_e( 'Could not copy file:', 'hotelwp' );
					echo( ' ' . $file_dest );
				}
				
				$guid = $upload_url . $img['name'];
				$now = date( 'Y-m-d H:i:s' );
				$wpdb->insert( 
					$wpdb->posts,
					array( 
						'ID' => $img['id'],
						'post_author' => 1,
						'post_title' => $img['title'],
						'post_excerpt' => $img['title'],
						'post_name' => str_replace( '.jpg', '', $img['name'] ),
						'guid' => $guid,
						'post_type' => 'attachment',
						'post_status' => 'inherit',
						'post_mime_type' => 'image/jpeg',
						'post_date' => $now,
						'post_date_gmt' => $now,
						'post_modified' => $now,
						'post_modified_gmt' => $now,
					) 
				);
				
				$wpdb->insert(
					$wpdb->postmeta,
					array(
						'post_id' => $img['id'],
						'meta_key' => '_wp_attached_file',
						'meta_value' => $theme_dir . $img['name'],
					)
				);
				
				require_once( ABSPATH . 'wp-admin/includes/image.php' );
				$attach_data = wp_generate_attachment_metadata( $img['id'], $file_dest );
				$attach_data = wp_update_attachment_metadata( $img['id'],  $attach_data );
			}
			
			echo('ok');
		}
		die;
	}
	
	private function rrmdir( $dir ) {
		if ( is_dir( $dir ) ) {
			$objects = scandir( $dir );
			foreach ( $objects as $object ) {
				if ( $object != '.' && $object != '..' ) {
					if ( is_dir( $dir . '/' . $object ) ) {
						$this->rrmdir( $dir . '/' .$object );
					} else {
						unlink( $dir . '/' . $object ); 
					}
				}
			}
			rmdir($dir);
		}
	}
	
}