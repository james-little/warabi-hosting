<?php

add_action( 'admin_menu', 'hotelwp_contact_details_menu' );

function hotelwp_contact_details_menu() {
	$page = add_theme_page( __( 'Adomus contact details', 'hotelwp' ), __( 'Adomus contact details', 'hotelwp' ), 'manage_options', 'hotelwp_contact_details', 'hotelwp_contact_details_display' );
}

function hotelwp_contact_details_display() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have sufficient permissions to access this page.', 'hotelwp' ) );
	}
	?>
	
	<div class="wrap">
		<form method="POST">
			<h1><?php esc_html_e( 'Contact details', 'hotelwp' ); ?></h1>
			<?php
			if ( isset( $_POST['hotelwp_update_property_information'] ) ) {
				for ( $i = 1; $i <= 5; $i++ ) {
					update_option( 'hotelwp_contact_detail_' . $i, stripslashes( strip_tags( $_POST[ 'hotelwp_contact_detail_' . $i ] ) ) );
				}
				?>
				<div class="updated"><p><?php esc_html_e( 'All fields have been saved.', 'hotelwp' ); ?></p></div>
				<?php
			} 
			?>

			<p>
				<?php esc_html_e( 'Please enter here all information you wish to provide in your website regarding contact details.', 'hotelwp' ); ?> 
				<br/>
				<?php esc_html_e( 'You can then display these information thanks to the "Contact Details" widget. You can add this widget in your header, your footer or sidebar.', 'hotelwp' ); ?>
			</p>
			
			<?php 
			for ( $i = 1; $i <= 5; $i++ ) : 
				$id = 'hotelwp_contact_detail_' . $i;
				?>
			
			<p>
				<label for="<?php echo( esc_attr( $id ) ); ?>">
					<b>
						<?php 
						esc_html_e( 'Contact detail ', 'hotelwp' ); 
						echo( esc_html( $i ) );
						echo( ':' );
						?>
					</b>
				</label></br>
				<textarea style="height:50px; width: 200px" id="<?php echo( esc_attr( $id ) ); ?>" name="<?php echo( esc_attr( $id ) ); ?>"><?php echo( esc_textarea( get_option( $id ) ) ); ?></textarea>
			</p>
			
			<?php endfor; ?>
			
			<p>
				<input type="submit" name="hotelwp_update_property_information" value="<?php esc_html_e( 'Save changes', 'hotelwp' ); ?>" class="button-primary" />
			</p>
		</div>
		
		<?php
}
		