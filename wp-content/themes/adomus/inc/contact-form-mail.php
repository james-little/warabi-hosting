<?php
class HotelWPContactFormMail {
	
	public function __construct() {
		add_action( 'wp_ajax_hotelwp_contact_form_send_email', array( $this, 'send_email' ) );
		add_action( 'wp_ajax_nopriv_hotelwp_contact_form_send_email', array( $this, 'send_email' ) );
	}

	public function send_email() {
		$fields = get_option( 'hotelwp_contact_form_fields' );
		if ( $fields ) {
			$fields = json_decode( $fields, true );
		} else {
			return 'Unexpected error (no fields).';
		}
		$vars = array();
		foreach ( $fields as $field ) {
			$vars[] = $field['id'];
		}
		
		$settings = get_option( 'hotelwp_contact_form_settings' );
		if ( $settings ) {
			$settings = json_decode( $settings, true );
		} else {
			return 'Unexpected error (no email settings).';
		}

		$emails_vars = array( 'reply_to_address', 'from_address', 'subject', 'message' );
		foreach ( $emails_vars as $email_var ) {
			$$email_var = $settings[ $email_var ];
			foreach ( $vars as $var ) {
				$value = '';
				if ( isset( $_POST[ 'hotelwp_cf_field_' . $var ] ) ) {
					if ( is_array( $_POST[ 'hotelwp_cf_field_' . $var ] ) ) {
						$value =  strip_tags( stripslashes( implode( ', ', $_POST[ 'hotelwp_cf_field_' . $var ] ) ) );
					} else {
						$value =  strip_tags( stripslashes( $_POST[ 'hotelwp_cf_field_' . $var ] ) );
					}
				}
				$$email_var = str_replace( '[' . $var . ']', $value, $$email_var );
			}
		}
		
		if ( substr_count( $from_address, '@' ) > 1 ) {
			$from_address = '';
		}
		if ( substr_count( $reply_to_address, '@' ) > 1 ) {
			$reply_to_address = '';
		}
		$subject = str_replace( '@', '[at]', $subject );
		
		$header = array();
		if ( $from_address != '' ) {
			$header[] = 'From: ' . $from_address;
		}
		if ( $reply_to_address != '' ) {
			$header[] = 'Reply-To: ' . $reply_to_address;
		}
		if ( $settings['message_type'] == 'html' ) {
			$header[] = 'Content-type: text/html';
		}
		
		$admin_email = $settings['to_address'];
		if ( ! $admin_email ) {
			$admin_email = get_option( 'admin_email' );
		}
		
		try {
			if ( wp_mail( $admin_email, $subject, $message, $header ) ) {
				$response['success'] = true;
				$response['msg'] = hotelwp_theme_get_string( 'contact_message_sent' );
			} else {
				global $phpmailer;
				$response['success'] = false;
				$response['error_msg'] = hotelwp_theme_get_string( 'contact_message_not_sent' ) . ' ' . $phpmailer->ErrorInfo;
			}
		} catch( phpmailerException $e ) {
			$response['success'] = false;
			$response['error_msg'] = hotelwp_theme_get_string( 'contact_message_not_sent' ) . ' ' . $e->getMessage();
		}
		echo( json_encode( $response ) );
		die;
	}
}

$hotelwp_contact_form_mail = new HotelWPContactFormMail();