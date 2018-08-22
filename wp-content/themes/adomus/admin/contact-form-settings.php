<?php
class HotelWPContactFormSettings {
	
	public $contact_form_settings;
	
	public function __construct() {
		if ( get_option( 'hb_contact_message_type' ) ) {
			$contact_form_settings = array(
				'to_address' => get_option( 'hb_contact_email' ),
				'from_address' => '',
				'reply_to_address' => get_option( 'hb_contact_from' ),
				'subject' => get_option( 'hb_contact_subject' ),
				'message' => get_option( 'hb_contact_message' ),
				'message_type' => get_option( 'hb_contact_message_type' ),
			);
			$contact_form_settings = json_encode( $contact_form_settings );
			update_option( 'hotelwp_contact_form_settings', $contact_form_settings );

			global $wpdb;
			$fields_table = $wpdb->prefix . 'hb_fields';
			$fields_choices_table = $wpdb->prefix . 'hb_fields_choices';
			$legacy_fields = $wpdb->get_results( "SELECT * FROM $fields_table WHERE form_name = 'contact' ORDER BY order_num", ARRAY_A );
			$new_fields = array();
			foreach ( $legacy_fields as $field ) {
				if ( $field['required'] ) {
					$required = 'yes';
				} else {
					$required = 'no';
				}
				if ( $field['has_choices'] ) {
					$choices = $wpdb->get_results( 
						$wpdb->prepare( 
							"SELECT * FROM $fields_choices_table WHERE field_id = %s",
							$field['id']
						)
						, ARRAY_A 
					);
				} else {
					$choices = array();
				}
				if ( isset( $field['column_width'] ) ) {
					$column_width = $field['column_width'];
				} else {
					$column_width = '';
				}
				$new_field = array(
					'id' => $field['id'],
					'name' => $field['name'],
					'type' => $field['type'],
					'required' => $required,
					'choices' => $choices,
					'column_width' => $column_width
				);
				$new_fields[] = $new_field;
			}
			update_option( 'hotelwp_contact_form_fields', json_encode( $new_fields ) );
			delete_option( 'hb_contact_message_type' );
		}
		
		add_action( 'wp_ajax_hotelwp_save_cf_settings', array( $this, 'save_settings' ) );
		add_action( 'admin_menu', array( $this, 'add_page' ) );
		$this->contact_form_settings = get_option( 'hotelwp_contact_form_settings' );
		if ( $this->contact_form_settings ) {
			$this->contact_form_settings = json_decode( $this->contact_form_settings, true );
		} else {
			$this->contact_form_settings = array(
				'to_address' => '',
				'from_address' => '',
				'reply_to_address' => '',
				'subject' => '',
				'message' => '',
				'message_type' => 'text',
			);
		}
	}
	
	public function add_page() {
		$page = add_theme_page( 
			esc_html__( 'Adomus contact form', 'hotelwp' ),
			esc_html__( 'Adomus contact form', 'hotelwp' ),
			'manage_options', 
			'hotelwp-contact-form', 
			array( $this, 'page_display' )
		);
		add_action( 'admin_print_styles-' . $page, array( $this, 'load_scripts' ) );
	}
	
	public function load_scripts() {
		$hotelwp_settings_text = array(
			'new_field' => esc_html__( 'New field', 'hotelwp' ),
			'confirm_delete_field' => esc_html__( 'Remove \'%field_name\'?', 'hotelwp' ),
			'confirm_delete_field_no_name' => esc_html__( 'Remove field?', 'hotelwp' ),
			'new_choice' => esc_html__( 'New choice', 'hotelwp' ),
			'confirm_delete_choice' => esc_html__( 'Remove \'%choice_name\'?', 'hotelwp' ),
			'variables_intro' => esc_html__( 'In the following fields you can use these variables:', 'hotelwp' ),
			'can_not_save' => esc_html__( 'Changes could not be saved. Please try again.', 'hotelwp' ),
			'unsaved_warning' => esc_html__( 'Changes you made may not be saved.', 'hotelwp' ),
		);
		
		$fields = get_option( 'hotelwp_contact_form_fields' );
		if ( $fields ) {
			$fields = json_decode( $fields, true );
		} else {
			$fields = array();
		}
	
		wp_enqueue_style( 'hotelwp-contact-form-settings-style', get_template_directory_uri(). '/admin/css/contact-form-settings.css', array(), '1.0' );
		
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'hotelwp-knockout', get_template_directory_uri() . '/admin/js/knockout-3.2.0.js', array(), '1.0', true );
		wp_enqueue_script( 'hotelwp-knockout-sortable', get_template_directory_uri() . '/admin/js/knockout-sortable.min.js', array(), '1.0', true );
		wp_enqueue_script( 'hotelwp-contact-form-settings-script', get_template_directory_uri() . '/admin/js/contact-form-settings.js', array( 'jquery' ), '1.0', true );
		wp_localize_script( 'hotelwp-contact-form-settings-script', 'hotelwp_settings_text', $hotelwp_settings_text );
		wp_localize_script( 'hotelwp-contact-form-settings-script', 'hotelwp_cf_fields', $fields );
	}
	
	public function page_display() {
	?>
		<div class="wrap">
			<div class="hotelwp-contact-form-settings">
				
				<h2><?php echo( esc_html__( 'Contact form settings', 'hotelwp' ) ); ?></h2>
				<div class="hotelwp-settings-save-wrapper">
					<p>
						<input type="button" class="button-primary hotelwp-settings-save" value="<?php esc_html_e( 'Save changes', 'hotelwp' ); ?>" />
						<span class="hotelwp-saving-settings"></span>
					</p>
					<p class="hotelwp-settings-saved"><?php _e( 'All settings have been saved.', 'hotelwp' ); ?></p>
				</div>
				
				<hr/>
				
				<h3><?php esc_html_e( 'Fields', 'hotelwp' ); ?></h3>
							
				<p>
					<i>
						<?php esc_html_e( 'Customize the Contact form.', 'hotelwp' ); ?>
						<?php esc_html_e( 'Drag and drop fields to reorder them.', 'hotelwp' ); ?>
					</i>
				</p>
				
				<input id="hotelwp-cf-add-field-top" type="button" class="button" value="<?php esc_attr_e( 'Add a field', 'hotelwp' ); ?>" data-bind="click: add_field_top" />
				
				<div class="hotelwp-cf-fields-container" data-bind="sortable: { data: fields, connectClass: 'hotelwp-cf-fields-container' }">
		
					<div class="hotelwp-cf-field" data-bind="attr: { id: id }">
						<a class="hotelwp-cf-field-delete dashicons dashicons-no" href="#" data-bind="click: function( data, event ) { $root.remove_field( data, event ) }" title="<?php esc_attr_e( 'Remove field', 'hotelwp' ); ?>"></a>
						<p data-bind="visible: type() != 'separator' && type() != 'column_break'" class="hotelwp-cf-field-name">
							<span data-bind="visible: ! editing_name(), text: name"></span>
							<input data-bind="visible: editing_name, value: name" type="text" class="hotelwp-cf-input-field-name" />
							<a data-bind="visible: ! editing_name(), click: $root.edit_field_name" class="dashicons dashicons-edit hotelwp-cf-field-edit-name" title="<?php esc_attr_e( 'Edit field name', 'hotelwp' ); ?>" href="#"></a>
							<a data-bind="visible: editing_name, click: $root.stop_edit_field_name" class="button" href="#"><?php esc_html_e( 'OK', 'hotelwp' ); ?></a>
						</p>
						<p data-bind="visible: type() != 'title' && type() != 'sub_title' && type() != 'explanation' && type() != 'separator' && type() != 'column_break'">
							<span class="hotelwp-cf-field-attribute"><?php esc_html_e( 'Required?', 'hotelwp' ); ?></span>
							<input data-bind="checked: required, attr: { id: required_yes_input_id }" type="radio" value="yes" />
							<label data-bind="attr: { 'for': required_yes_input_id }"><?php esc_html_e( 'Yes', 'hotelwp' ); ?></label>
							&nbsp;&nbsp;
							<input data-bind="checked: required, attr: { id: required_no_input_id }" type="radio" value="no" />
							<label data-bind="attr: { 'for': required_no_input_id }"><?php esc_html_e( 'No', 'hotelwp' ); ?></label>
						</p>
						<?php
						$field_types = array(
							'text' => esc_html__( 'Text', 'hotelwp' ),
							'email' => esc_html__( 'Email', 'hotelwp' ),
							'number' => esc_html__( 'Number', 'hotelwp' ),
							'textarea' => esc_html__( 'Text area', 'hotelwp' ),
							'select' => esc_html__( 'Select', 'hotelwp' ),
							'radio' => esc_html__( 'Radio buttons', 'hotelwp' ),
							'checkbox' => esc_html__( 'Check boxes', 'hotelwp' ),
							'title' => esc_html__( 'Title', 'hotelwp' ),
							'sub_title' => esc_html__( 'Sub-title', 'hotelwp' ),
							'explanation' => esc_html__( 'Explanation', 'hotelwp' ),
							'separator' => esc_html__( 'Separator', 'hotelwp' ),
							'column_break' => esc_html__( 'Column break', 'hotelwp' ),
						);
						?>
						<p>
							<span class="hotelwp-cf-field-attribute"><?php esc_html_e( 'Field type:', 'hotelwp' ); ?></span>
							<select class="hotelwp-cf-field-select" data-bind="value: type">
								<?php foreach ( $field_types as $ft_id => $ft_label ) : ?>
								<option value="<?php echo( esc_attr( $ft_id ) ); ?>"><?php echo( $ft_label); ?></option>
								<?php endforeach; ?>
							</select>
						</p>
						<div class="hotelwp-cf-field-choices" data-bind="visible: ( type() == 'checkbox' ) || ( type() == 'radio' ) || ( type() == 'select' )">
							<?php esc_html_e( 'Choices:', 'hotelwp' ); ?>
							<a data-bind="click: add_choice" class="dashicons dashicons-plus" title="<?php esc_attr_e( 'Add a choice', 'hotelwp' ); ?>" href="#"></a>
							<ul class="hotelwp-cf-fields-choices-ul" data-bind="sortable: { data: choices, connectClass: 'hotelwp-cf-fields-choices-ul' }">
								<li>
									<span data-bind="visible: ! editing_choice(), text: name"></span>
									<input data-bind="visible: editing_choice, value: name" type="text" class="hotelwp-cf-input-choice-name" />
									<a data-bind="visible: ! editing_choice(), click: $parent.edit_choice_name" class="dashicons dashicons-edit hotelwp-cf-field-edit-choice" title="<?php esc_attr_e( 'Edit choice', 'hotelwp' ); ?>" href="#"></a>
									<a data-bind="visible: editing_choice, click: $parent.stop_edit_choice_name" class="button" href="#"><?php esc_html_e( 'OK', 'hotelwp' ); ?></a>
									<a data-bind="click: $parent.remove_choice" class="dashicons dashicons-no hotelwp-cf-field-remove-choice" title="<?php esc_attr_e( 'Remove choice', 'hotelwp' ); ?>" href="#"></a>
								</li>
							</ul>
						</div>
						<p data-bind="visible: type() != 'title' && type() != 'sub_title' && type() != 'explanation' && type() != 'separator' && type() != 'column_break'">
							<span class="hotelwp-cf-field-attribute"><?php esc_html_e( 'Column width:', 'hotelwp' ); ?></span>
							<select class="hotelwp-cf-field-select" data-bind="value: column_width">
								<option value=""><?php esc_html_e( 'Full', 'hotelwp' ); ?></option>
								<option value="half"><?php esc_html_e( 'One half', 'hotelwp' ); ?></option>
								<option value="third"><?php esc_html_e( 'One third', 'hotelwp' ); ?></option>
							</select>
						</p>
					</div>
					
				</div><!-- end .hotelwp-cf-fields-container -->
	
				<p>
					<input id="hotelwp-cf-add-field-bottom" type="button" class="button" value="<?php esc_attr_e( 'Add a field', 'hotelwp' ); ?>" data-bind="click: add_field_bottom" />
				</p>
				
				<div class="hotelwp-settings-save-wrapper">
					<p>
						<input type="button" class="button-primary hotelwp-settings-save" value="<?php esc_html_e( 'Save changes', 'hotelwp' ); ?>" />
						<span class="hotelwp-saving-settings"></span>
					</p>
					<p class="hotelwp-settings-saved"><?php _e( 'All settings have been saved.', 'hotelwp' ); ?></p>
				</div>
				
				<hr/>
				
				<h3><?php echo( esc_html__( 'Email settings', 'hotelwp' ) ); ?></h3>
				
				<form id="hotelwp-cf-settings">
					<input type="hidden" name="action" value="hotelwp_save_cf_settings" />
					<input type="hidden" id="hotelwp_cf_fields" name="hotelwp_cf_fields" />
					<?php wp_nonce_field( 'hotelwp_theme_settings_nonce', 'hotelwp_theme_settings_nonce' ); ?>

					<p>
						<label for="to"><?php echo( esc_html__( 'Email address: (leave blank to use WordPress admin email)', 'hotelwp' ) ); ?></label><br/>
						<input type="text" id="to" name="to" value="<?php echo( esc_attr( $this->contact_form_settings['to_address'] ) ); ?>" />
					</p>
					<p>
						<label><?php echo( esc_html__( 'Message type:', 'hotelwp' ) ); ?></label><br>
						<input type="radio" id="htw_cf_message_type_text" name="htw_cf_message_type" value="text" <?php if ( $this->contact_form_settings['message_type'] == 'text' ) : ?>checked<?php endif; ?> />
						<label for="htw_cf_message_type_text">Text</label>&nbsp;&nbsp;
						<input type="radio" id="htw_cf_message_type_html" name="htw_cf_message_type" value="html" <?php if ( $this->contact_form_settings['message_type'] == 'html' ) : ?>checked<?php endif; ?> />
						<label for="htw_cf_message_type_html">HTML</label>&nbsp;&nbsp;
					</p>
					<small data-bind="html: variables_list"></small>
					<p>
						<label for="htw_cf_reply_to"><?php echo( esc_html__( 'Reply-to:', 'hotelwp' ) ); ?></label><br/>
						<input type="text" id="htw_cf_reply_to" name="htw_cf_reply_to" value="<?php echo( esc_attr( $this->contact_form_settings['reply_to_address'] ) ); ?>" />
					</p>
					<p>
						<label for="htw_cf_from"><?php echo( esc_html__( 'From:', 'hotelwp' ) ); ?></label><br/>
						<input type="text" id="htw_cf_from" name="htw_cf_from" value="<?php echo( esc_attr( $this->contact_form_settings['from_address'] ) ); ?>" />
					</p>
					<p>
						<label for="htw_cf_subject"><?php echo( esc_html__( 'Subject:', 'hotelwp' ) ); ?></label><br/>
						<input type="text" id="htw_cf_subject" name="htw_cf_subject" value="<?php echo( esc_attr( $this->contact_form_settings['subject'] ) ); ?>" />
					</p>
					<p>
						<label for="htw_cf_message"><?php echo( esc_html__( 'Message:', 'hotelwp' ) ); ?></label><br/>
						<textarea id="htw_cf_message" name="htw_cf_message" rows="8"><?php echo( esc_textarea( $this->contact_form_settings['message'] ) ); ?></textarea>
					</p>
				</form>
				
				<div class="hotelwp-settings-save-wrapper">
					<p>
						<input type="button" class="button-primary hotelwp-settings-save" value="<?php esc_html_e( 'Save changes', 'hotelwp' ); ?>" />
						<span class="hotelwp-saving-settings"></span>
					</p>
					<p class="hotelwp-settings-saved"><?php _e( 'All settings have been saved.', 'hotelwp' ); ?></p>
				</div>
				
			</div><!-- end .hotelwp-contact-form-settings -->
		</div><!-- end .wrap -->
		
	<?php
	}
	
	public function save_settings() {
		if ( 
			isset( $_POST['hotelwp_theme_settings_nonce'] ) && 
			wp_verify_nonce( $_POST['hotelwp_theme_settings_nonce'], 'hotelwp_theme_settings_nonce' ) && 
			current_user_can( 'manage_options' ) 
		) {
			$contact_form_settings = array(
				'to_address' => stripslashes( $_POST['to'] ),
				'reply_to_address' => stripslashes( $_POST['htw_cf_reply_to'] ),
				'from_address' => stripslashes( $_POST['htw_cf_from'] ),
				'subject' => stripslashes( $_POST['htw_cf_subject'] ),
				'message' => stripslashes( $_POST['htw_cf_message'] ),
			);
			if ( isset( $_POST['htw_cf_message_type'] ) && $_POST['htw_cf_message_type'] ) {
				$contact_form_settings['message_type'] = stripslashes( $_POST['htw_cf_message_type'] );
			} else {
				$contact_form_settings['message_type'] = 'text';
			}
			$contact_form_settings = json_encode( $contact_form_settings );
			update_option( 'hotelwp_contact_form_settings', $contact_form_settings );
			
			$contact_form_fields = json_decode( stripslashes( $_POST['hotelwp_cf_fields'] ), true );
			$fields = $contact_form_fields['fields'];
			$field_properties = array( 'id', 'name', 'type', 'required', 'choices', 'column_width' );
			$fields_to_save = array();
			foreach ( $fields as $field ) {
				$field_to_save = array();
				foreach ( $field_properties as $field_property ) {
					if ( $field_property == 'choices' ) {
						$choices = array();
						foreach ( $field[ 'choices' ] as $choice ) {
							$choices[] = array(
								'id' => $choice['id'],
								'name' => $choice['name'],
							);
						}
						$field_to_save['choices'] = $choices;
					} else {
						$field_to_save[ $field_property ] = $field[ $field_property ];
					}
				}
				$fields_to_save[] = $field_to_save;
			}
			update_option( 'hotelwp_contact_form_fields', json_encode( $fields_to_save ) );
			
			echo( 'settings_saved' );
		}
		die;		
	}
	
}
	
$hotelwp_contact_form_settings = new HotelWPContactFormSettings();