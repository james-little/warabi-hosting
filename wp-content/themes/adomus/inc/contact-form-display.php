<?php

add_shortcode( 'hb_contact_form', 'hotelwp_contact_form_display' );

function hotelwp_contact_form_display() {
	$fields = get_option( 'hotelwp_contact_form_fields' );
	if ( $fields ) {
		$fields = json_decode( $fields, true );
	} else {
		return;
	}
  
	$output = '';
	$nb_columns = 0;
	$current_columns_wrapper = 0;
	$column_num = 0;
	foreach ( $fields as $field ) {
		$output = apply_filters( 'hotelwp_contact_form_markup_before_field', $output, $field );
		if ( $field['column_width'] == 'half' ) {
			$nb_columns = 2;
		} else if ( $field['column_width'] == 'third' ) {
			$nb_columns = 3;
		} else {
			$nb_columns = 0;
		}
		if ( $nb_columns ) {
			if ( $column_num && ( $current_columns_wrapper != $nb_columns ) ) {
				$column_num = 0;
				$current_columns_wrapper = 0;
				$output .= '</div><!-- end .clearfix -->';
			}
			if ( ! $column_num ) {
				$column_num = 1;
				$current_columns_wrapper = $nb_columns;
				$output .= '<div class="clearfix">';
			} else {
				$column_num++;
			}
		} else if ( $column_num != 0 ) {
			$column_num = 0;
			$nb_columns = 0;
			$current_columns_wrapper = 0;
			$output .= '</div><!-- end .clearfix -->';
		}

		$output .= hotelwp_get_contact_form_field_mark_up( $field );
		
		if ( $current_columns_wrapper && ( $current_columns_wrapper == $column_num ) ) {
			$column_num = 0;
			$nb_columns = 0;
			$current_columns_wrapper = 0;
			$output .= '</div><!-- end .clearfix -->';
		}
		$output = apply_filters( 'hotelwp_contact_form_markup_after_field', $output, $field );
	}
	if ( $current_columns_wrapper ) {
		$output .= '</div><!-- end .htw-contact-form-clearfix -->';
	}
	$output .= '<p class="hotelwp-cf-submit clearfix">';
	$output .= '<input type="submit" value="' . hotelwp_theme_get_string( 'send_button' ) . '" />';
	$output .= '<span class="hotelwp-cf-processing"></span>';
	$output .= '</p>';
	$output .= '<p class="hotelwp-cf-error"></p>';
	$output .= '<p class="hotelwp-cf-msg-send"></p>';
	$output .= '<input type="hidden" name="action" value="hotelwp_contact_form_send_email" />';
	
	$allowed_html_tags = array(
		'br' => array(),
		'div' => array(
			'class' => true,
		),
		'h3' => array(),
		'h4' => array(),
		'hr' => array(),
		'input' => array(
			'checked' => true,
			'data-validation' => true,
			'id' => true,
			'name' => true,
			'type' => true,
			'value' => true,
		),
		'label' => array(
			'for' => true,
		),
		'option' => array(
			'value' => true,
		),
		'p' => array(
			'class' => true,
		),
		'select' => array(
			'data-validation' => true,
			'id' => true,
			'name' => true,
		),
		'span' => array(
			'class' => true,
		),
		'textarea' => array(
			'data-validation' => true,
			'id' => true,
			'name' => true,
		),
	);
	echo( '<form class="hotelwp-contact-form" method="post">' . wp_kses( $output, $allowed_html_tags ) . '</form>' );
	
	$contact_form_text = array();
	$strings_to_front = array( 'invalid_email', 'required_field', 'invalid_number', 'connection_error', 'contact_already_sent' );
	foreach ( $strings_to_front as $string_id ) {
		$contact_form_text[ $string_id ] = hotelwp_theme_get_string( $string_id );
	}
	$contact_form_data = array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
	);
	wp_enqueue_script( 'hotelwp-contact-form-validate-script', get_template_directory_uri() . '/js/jquery.form-validator.min.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'hotelwp-contact-form-script', get_template_directory_uri() . '/js/contact-form.js', array( 'jquery' ), '1.0', true );
	wp_localize_script( 'hotelwp-contact-form-script', 'hotelwp_contact_form_text', $contact_form_text );
	wp_localize_script( 'hotelwp-contact-form-script', 'hotelwp_contact_form_data', $contact_form_data );
}

function hotelwp_get_contact_form_field_mark_up( $field ) {
	if ( $field['type'] == 'column_break' ) {
		return '';
	}
	$output = '';
	$field_display_name = hotelwp_theme_get_string( $field['id'] );
	if ( $field['column_width'] ) {
		$output .= '<div class="hotelwp-cf-column-' . $field['column_width'] . '">';
	}
	if ( ( $field['type'] == 'title' ) || ( $field['type'] == 'sub_title' ) || ( $field['type'] == 'explanation' ) || ( $field['type'] == 'separator' ) ) {
		if ( $field['type'] == 'title' ) {
			$output .= '<h3>' . $field_display_name . '</h3>';
		} else if ( $field['type'] == 'sub_title' ) {
			$output .= '<h4>' . $field_display_name . '</h4>';
		} else if ( $field['type'] == 'explanation' ) {
			$output .= '<p class="hotelwp-cf-explanation">' . $field_display_name . '</p>';
		} else if ( $field['type'] == 'separator' ) {
			$output .= '<hr/>';
		}
		if (  $field['column_width'] ) {
			$output .= '</div><!-- end .hotelwp-cf-column-' . $field['column_width'] . ' -->';
		}
		$output = apply_filters( 'hotelwp_contact_form_markup_field', $output, $field );
		return $output;
	}
	$required_text = '';
	if ( $field['required'] == 'yes' ) {
		$required_text = '*';
	}
	$output .= '<p>';
	$output .= '<label for="' . $field['id'] . '">' . $field_display_name . $required_text . '</label>';

	$data_validation = '';
	if ( $field['required'] == 'yes' ) {
		$data_validation = 'required';
	}
	if ( $field['type'] == 'email' ) {
		$data_validation .= ' email';
	}
	if ( $field['type'] == 'number' ) {
		$data_validation .= ' number';
	}
	$field_attributes = 'id="' . $field['id'] . '" name="hotelwp_cf_field_' . $field['id'] . '" data-validation="' . $data_validation . '"';
	
	if ( $field['type'] == 'text' || $field['type'] == 'email' || $field['type'] == 'number' ) {
		$output .= '<input ' . $field_attributes . ' type="text" />';
	} else if ( $field['type'] == 'textarea' ) {
		$output .= '<textarea ' . $field_attributes . '></textarea>';
	} else if ( $field['type'] == 'select' || $field['type'] == 'radio' || $field['type'] == 'checkbox' ) {
		$choices_mark_up = '';
		foreach ( $field['choices'] as $i => $choice ) {
			$choice_display_name = hotelwp_theme_get_string( $choice['id'] );
			if ( $field['type'] == 'select' ) {
				$choices_mark_up .= '<option value="' . $choice['name'] . '"';
				$choices_mark_up .= '>' . $choice_display_name . '</option>';
			} else if ( ( $field['type'] == 'radio' ) || ( $field['type'] == 'checkbox' ) ) {
				$choices_mark_up .= '<input type="' . $field['type'] . '"';
				$field_name = 'hotelwp_cf_field_' . $field['id'];
				if ( $field['type'] == 'checkbox' ) {
					$field_name .= '[]';
					if ( $field['required'] == 'yes' ) {
						$choices_mark_up .= ' data-validation="checkbox_group" data-validation-qty="min1"';
					}
				}
				if ( ( $field['type'] == 'radio' ) && ( $i == 0 ) ) {
					$choices_mark_up .= ' checked';
				}
				$choices_mark_up .= ' id="' . $field['id'] . '-' . $choice['id'] . '" name="' . $field_name . '" value="' . $choice['name'] . '">';
				$choices_mark_up .= '<label for="' . $field['id'] . '-' . $choice['id'] . '">' . $choice_display_name . '</label>';
				$choices_mark_up .= '<br/>';
			}
		}
		if ( $field['type'] == 'select' ) {
			$output .= '<select ' . $field_attributes . '>';
			$output .= $choices_mark_up;
			$output .= '</select>';
		}
		if ( $field['type'] == 'radio' || $field['type'] == 'checkbox' ) {
			$output .= $choices_mark_up;
		}
	}
	$output .= '</p>';
	if ( $field['column_width'] ) {
		$output .= '</div><!-- end .hotelwp-cf-column-' . $field['column_width'] . ' -->';
	}
	$output = apply_filters( 'hotelwp_contact_form_markup_field', $output, $field );
	return $output;
}