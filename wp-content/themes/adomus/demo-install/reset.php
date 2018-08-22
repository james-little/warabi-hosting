<?php
class HotelWPInstallReset {

	public function process() {
		if ( 
			isset( $_POST['hotelwp_theme_install_nonce'] ) && 
			wp_verify_nonce( $_POST['hotelwp_theme_install_nonce'], 'hotelwp_theme_install_nonce' ) && 
			current_user_can( 'manage_options' ) 
		) {
			global $wpdb;
			$wpdb->query( "TRUNCATE $wpdb->posts" );
			$wpdb->query( "TRUNCATE $wpdb->postmeta" );
			$wpdb->query( "TRUNCATE $wpdb->comments" );
			$wpdb->query( "TRUNCATE $wpdb->commentmeta" );
			$wpdb->query( "TRUNCATE $wpdb->term_taxonomy" );
			$wpdb->query( "TRUNCATE $wpdb->terms" );
			$wpdb->query( "TRUNCATE $wpdb->term_relationships" );
			$wpdb->query( "TRUNCATE $wpdb->posts" );
			delete_option( 'sidebars_widgets' );
			delete_option( 'theme_mods_adomus' );
			$hbook_tables = array( 'hb_accom_num_name', 'hb_seasons', 'hb_seasons_dates', 'hb_rates' );
			foreach ( $hbook_tables as $table ) {
				$hb_table = $wpdb->prefix . $table;
				$table_exists = $wpdb->query( "SHOW TABLES LIKE '$hb_table'" );
				if ( $table_exists > 0 ) {
					$wpdb->query( "TRUNCATE $hb_table" );
				}
			}
			$wpdb->query( "INSERT INTO $wpdb->term_taxonomy (term_taxonomy_id, term_id, taxonomy, description, parent, count) VALUES (1, 1, 'category', '', 0, 1)" );
			$wpdb->query( "INSERT INTO $wpdb->terms (term_id, name, slug, term_group) VALUES (1, 'Uncategorized', 'uncategorized', 0)" ); 
			$wpdb->query( "INSERT INTO $wpdb->term_relationships (object_id, term_taxonomy_id, term_order) VALUES (1, 1, 0)" );
			echo( 'ok' );
		}
		die;
	}

}