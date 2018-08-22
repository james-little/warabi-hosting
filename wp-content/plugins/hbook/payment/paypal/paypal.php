<?php
class HbPayPal extends HbPaymentGateway {
    
    public function __construct( $hbdb, $version, $utils ) {
        $this->id = 'paypal';
        $this->name = 'PayPal';
        $this->has_redirection = 'yes';
        $this->version = $version;
        $this->hbdb = $hbdb;
        $this->utils = $utils;
        
        add_filter( 'hbook_payment_gateways', array( $this, 'add_paypal_gateway_class' ) );
    }
    
    public function add_paypal_gateway_class( $hbook_gateways ) {
        $hbook_gateways[] = $this;
        return $hbook_gateways;
    }

    public function get_payment_method_label() {
        $payment_method_label = $this->hbdb->get_string( 'paypal_payment_method_label' );
        $payment_method_icons = array( 'paypal' );
        $output = $payment_method_label;
        foreach ( $payment_method_icons as $icon ) {
            $output .= '&nbsp;<img src="' . plugin_dir_url( __FILE__ ) . '../img/' . $icon . '.png" alt="" />';
        }
        return apply_filters( 'hb_paypal_payment_method_label', $output, $payment_method_label, $payment_method_icons );
    }
    
    public function admin_fields() {
        return array(
			'label' => esc_html__( 'Paypal settings', 'hbook-admin' ),
			'options' => array(
			
				'hb_paypal_mode' => array(
					'label' => esc_html__( 'Paypal mode:', 'hbook-admin' ),
					'type' => 'radio',
                    'choice' => array(
						'live' => esc_html__( 'Live', 'hbook-admin' ),
						'sandbox' => esc_html__( 'Sandbox', 'hbook-admin' ),
					),
					'default' => 'live'
				),
				'hb_paypal_api_sandbox_user' => array(
					'label' => esc_html__( 'Sandbox API Username:', 'hbook-admin' ),
					'type' => 'text',
					'wrapper-class' => 'hb-paypal-mode-sandbox',
				),					
				'hb_paypal_api_sandbox_psw' => array(
					'label' => esc_html__( 'Sandbox API Password:', 'hbook-admin' ),
					'type' => 'text',
					'wrapper-class' => 'hb-paypal-mode-sandbox',
				),					
				'hb_paypal_api_sandbox_signature' => array(
					'label' => esc_html__( 'Sandbox API Signature:', 'hbook-admin' ),
					'type' => 'text',
					'wrapper-class' => 'hb-paypal-mode-sandbox',
				),
                'hb_paypal_api_live_user' => array(
					'label' => esc_html__( 'Live API Username:', 'hbook-admin' ),
					'type' => 'text',
					'wrapper-class' => 'hb-paypal-mode-live',
				),					
				'hb_paypal_api_live_psw' => array(
					'label' => esc_html__( 'Live API Password:', 'hbook-admin' ),
					'type' => 'text',
					'wrapper-class' => 'hb-paypal-mode-live',
				),					
				'hb_paypal_api_live_signature' => array(
					'label' => esc_html__( 'Live API Signature:', 'hbook-admin' ),
					'type' => 'text',
					'wrapper-class' => 'hb-paypal-mode-live',
				),	
				
			)
        );
    }

	public function admin_js_scripts() {
        return array(
            array(
                'id' => 'hb-paypal-admin',
                'url' => plugin_dir_url( __FILE__ ) . 'paypal-admin.js',
                'version' => $this->version
            ),
        );
    }
    
    public function js_scripts() {
        return array(
            array(
                'id' => 'hb-paypal',
                'url' => plugin_dir_url( __FILE__ ) . 'paypal.js',
                'version' => $this->version
            ),
        );
    }
	
    public function js_data() {
        if ( get_option( 'hb_paypal_mode' ) == 'sandbox' ) {
            $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout';
        } else {
            $paypal_url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout';
        }
        return array(
            'hb_paypal_url' => $paypal_url,
        );
    }
    
    public function payment_form() {
        $paypal_txt = $this->hbdb->get_string( 'paypal_text_before_form' );
        if ( $paypal_txt ) {
            return '<p>' . $paypal_txt . '</p>';
        } else {
            return '';
        }
    }
    
    public function process_payment( $resa_info, $customer_info, $amount_to_pay ) {
        $hb_strings = $this->hbdb->get_strings();
        
		
		$parameters_to_remove = array( 'token', 'PayerID' );
		$return_urls = $this->get_return_urls( $parameters_to_remove );
		
		$set_express_check_out_args = array(
			'METHOD' => 'SetExpressCheckout',
			'PAYMENTREQUEST_0_AMT' => $amount_to_pay,
			'PAYMENTREQUEST_0_CURRENCYCODE' => get_option( 'hb_currency' ),
			'L_PAYMENTREQUEST_0_NAME0' => $this->get_external_payment_desc( $resa_info, $customer_info ),
			'L_PAYMENTREQUEST_0_AMT0' => $amount_to_pay,
			'NOSHIPPING' => '1',
			'RETURNURL' => $return_urls['payment_confirm'],
			'CANCELURL' => $return_urls['payment_cancel'],
			'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
			'SOLUTIONTYPE' => 'Sole',
			'LANDINGPAGE' => 'Billing'
		);
		$response = $this->remote_post_to_paypal( $set_express_check_out_args );
        if ( is_wp_error( $response ) ) {
			return array( 'success' => false, 'error_msg' => 'WP error: ' . $response->get_error_message() );
		}
		$paypal_response = '';
		parse_str( $response['body'], $paypal_response );
		if ( $paypal_response['ACK'] == 'Success' ) {
			return array( 'success' => true, 'payment_token' => $paypal_response['TOKEN'] );
		} else {
			return array( 'success' => false, 'error_msg' => 'PayPal error : '. $paypal_response['L_LONGMESSAGE0'] );
		}        
    }
    
	public function get_payment_token() {
		return $_GET['token'];
	}
	
    public function confirm_payment() {
        $resa = $this->hbdb->get_resa_by_payment_token( $_GET['token'] );
		if ( ! $resa ) {
			$response = array(
                'success' => false,
    			'error_msg' => $this->hbdb->get_string( 'timeout_error' )
            );
		} else {
			$customer = $this->hbdb->get_customer_info( $resa['customer_id'] );
			$payment_desc = $this->get_external_payment_desc( $resa, $customer );
            $do_express_check_out_args = array(
    			'METHOD' => 'DoExpressCheckoutPayment',
    			'TOKEN' => $_GET['token'],
				'PAYERID' => $_GET['PayerID'],
				'L_PAYMENTREQUEST_0_NAME0' => $payment_desc,
    			'PAYMENTREQUEST_0_AMT' => $resa['amount_to_pay'],
    			'PAYMENTREQUEST_0_CURRENCYCODE' => get_option( 'hb_currency' )
    		);
			$response = $this->remote_post_to_paypal( $do_express_check_out_args );
            if ( is_wp_error( $response ) ) {
    			return array( 'success' => false, 'error_msg' => 'WP error: ' . $response->get_error_message() );
    		}
    		$paypal_response = '';
    		parse_str( $response['body'], $paypal_response );
    		if ( $paypal_response['ACK'] == 'Success' ) {
    			$payment_status = strip_tags( $paypal_response['PAYMENTINFO_0_PAYMENTSTATUS'] );
    			$payment_status_reason = '';
    			if ( $payment_status == 'Pending' ) {
    				$payment_status_reason = strip_tags( $paypal_response['PAYMENTINFO_0_PENDINGREASON'] );
    			}
    			if ( $payment_status == 'Completed-Funds-Held' ) {
    				$payment_status_reason = strip_tags( $paypal_response['PAYMENTINFO_0_HOLDDECISION'] );
    			}
    			$response = array( 
                    'success' => true, 
                    'payment_status' => $payment_status, 
                    'payment_status_reason' => $payment_status_reason 
                );
    		} else {
    			$response = array( 
                    'success' => false, 
                    'error_msg' => strip_tags( $paypal_response['L_LONGMESSAGE0'] ) 
                );
    		}
            
			if ( $response['success'] ) {
				$resa_id = $this->hbdb->update_resa_after_payment( $_GET['token'], $payment_status, $response['payment_status_reason'], $resa['amount_to_pay'] );
				if ( ! $resa_id ) {
					$response = array(
                        'success' => false,
					    'error_msg' => 'Error (could not update reservation).'
                    );
				} else {
					$this->utils->send_email( 'new_resa', $resa_id );
				}
			}
		}
		return $response;
    }
        
    private function remote_post_to_paypal( $body_args ) {
        if ( get_option( 'hb_paypal_mode' ) == 'sandbox' ) {
			$paypal_api_url = 'https://api-3t.sandbox.paypal.com/nvp';
            $paypal_settings = array(
    			'USER' => get_option( 'hb_paypal_api_sandbox_user' ),
    			'PWD' => get_option( 'hb_paypal_api_sandbox_psw' ),
    			'SIGNATURE' => get_option( 'hb_paypal_api_sandbox_signature' ),
    		);
		} else {
			$paypal_api_url = 'https://api-3t.paypal.com/nvp';
            $paypal_settings = array(
                'USER' => get_option( 'hb_paypal_api_live_user' ),
                'PWD' => get_option( 'hb_paypal_api_live_psw' ),
                'SIGNATURE' => get_option( 'hb_paypal_api_live_signature' ),
            );
		}
        $paypal_settings['VERSION'] = '119.0';
        $body_args = array_merge( $paypal_settings, $body_args );
		$post_args = array(
			'body' => $body_args
		);
		$response = $this->hb_remote_post( $paypal_api_url, $post_args );
        return $response;
    }
    
}