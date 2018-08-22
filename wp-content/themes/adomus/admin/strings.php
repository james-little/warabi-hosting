<?php
class HotelWPThemeStrings {
	
	private $theme_name;
	private $langs;
	private $strings;
	public $string_values;
	
	public function __construct() {
		$this->theme_name = wp_get_theme();
		$this->langs = $this->get_langs();
		$this->strings = array();
		$strings_values_default = array();
		$theme_strings = hotelwp_get_theme_strings();
		$contact_form_fields = get_option( 'hotelwp_contact_form_fields' );
		if ( $contact_form_fields ) {
			$contact_form_fields = json_decode( $contact_form_fields, true );
		} else {
			$contact_form_fields = array();
		}
		$contact_form_fields_strings = array();
		foreach ( $contact_form_fields as $field ) {
			$contact_form_fields_strings[ $field['id'] ] = array(
				'name' => $field['name'],
				'default_value' => $field['name'],
			);
			if ( $field['type'] == 'checkbox' || $field['type'] == 'radio' || $field['type'] == 'select' ) {
				foreach ( $field['choices'] as $choice ) {
					$contact_form_fields_strings[ $choice['id'] ] = array(
						'name' => $choice['name'],
						'default_value' => $choice['name'],
					);
				}
			}
		}
		$theme_strings = array_merge( $theme_strings, $contact_form_fields_strings );
		foreach ( $theme_strings as $theme_string_id => $theme_string ) {
			$this->strings[ $theme_string_id ] = $theme_string['name'];
			$strings_values_default[ $theme_string_id ] = $theme_string['default_value'];
		}
		$this->string_values = get_option( strtolower( $this->theme_name ) . '_theme_strings' );
		if ( ! $this->string_values ) {
			$this->string_values = array();
		} else {
			$this->string_values = json_decode( $this->string_values, true );
		}
		foreach ( $strings_values_default as $string_id => $string_value ) {
			if ( ! isset( $this->string_values[ $string_id ] ) ) {
				$this->string_values[ $string_id ]['en_US'] = $strings_values_default[ $string_id ];
			}
		}
		add_action( 'init', array( $this, 'export_lang_file' ) );
		add_action( 'wp_ajax_hotelwp_save_strings', array( $this, 'save_settings' ) );
		add_action( 'admin_menu', array( $this, 'add_page' ) );
	}

	public function add_page() {
		$page = add_theme_page( 
			sprintf( esc_html__( '%s theme strings', 'hotelwp' ), $this->theme_name ), 
			sprintf( esc_html__( '%s theme strings', 'hotelwp' ), $this->theme_name ), 
			'manage_options', 
			'hotelwp-theme-strings', 
			array( $this, 'page_display' ) 
		);
		add_action( 'admin_print_styles-' . $page, array( $this, 'load_scripts' ) );
	}

	public function load_scripts() {
		wp_enqueue_style( 'hotelwp-theme-strings-style', get_template_directory_uri(). '/admin/css/strings.css', array(), '1.0' );
		
		wp_enqueue_script( 'hotelwp-theme-strings-script', get_template_directory_uri(). '/admin/js/strings.js', array( 'jquery' ), '1.0', true );
		$data = array(
			'can_not_save' => esc_html__( 'Changes could not be saved. Please try again.', 'hotelwp' ),
			'unsaved_warning' => esc_html__( 'Changes you made may not be saved.', 'hotelwp' ),
			'select_language' => esc_html__( 'Select a language.', 'hotelwp' ),
			'choose_file' => esc_html__( 'Choose a file to import.', 'hotelwp' ),
		);
		wp_localize_script( 'hotelwp-theme-strings-script', 'hotelwp_settings_text', $data );
	}

	public function page_display() {
	?>
		<div class="wrap">
			<h2><?php printf( esc_html__( '%s theme strings', 'hotelwp' ), $this->theme_name ); ?></h2>
			<p><?php esc_html_e( 'From this page you can modify any string displayed by the theme.', 'hotelwp' ); ?></p>
			<hr/>

			<h3><?php esc_html_e( 'Import a language file', 'hotelwp' ); ?></h3>

			<?php
			if ( 
				isset( $_POST['hotelwp-import-export-action'] ) && 
				( $_POST['hotelwp-import-export-action'] == 'import-lang' ) && 
				wp_verify_nonce( $_POST['hotelwp_import_export'], 'hotelwp_import_export' ) && 
				current_user_can( 'manage_options' ) 
			) {
				$import_file = $_FILES['hotelwp-import-lang-file']['tmp_name'];
				$file_content = file_get_contents( $import_file );
				$re_id = "/msgid\\s*\"(.*)\"/"; 
				$re_str = "/msgstr\\s*\"(.*)\"/"; 
				preg_match_all( $re_id, $file_content, $matches_id );
				preg_match_all( $re_str, $file_content, $matches_str );
				$ids = $matches_id[1];
				$strings = $matches_str[1];
				$nb_valid_ids = 0;
				if ( ( count( $ids ) > 0 ) && ( count( $ids ) == count( $strings ) ) ) {
					$valid_ids = array_keys( hotelwp_get_theme_strings() );
					for ( $i = 0; $i < count( $ids ); $i++ ) {
						if ( in_array( $ids[ $i ], $valid_ids ) ) {
							$this->string_values[ $ids[ $i ] ][ $_POST['hotelwp-import-lang-code'] ] = $strings[ $i ];
							$nb_valid_ids++;
						}
					}
				}
				if ( $nb_valid_ids ) {
					update_option( strtolower( $this->theme_name ) . '_theme_strings', json_encode( $this->string_values ) );
					?>
					<div class="updated">
						<p><?php printf( esc_html__( 'The import was successful (%d strings have been imported).', 'hotelwp' ), $nb_valid_ids ); ?></p>
					</div>
				<?php
				} else {
				?>
				<div class="error">
					<p><?php esc_html_e( 'The language file is not valid.', 'hotelwp' ); ?></p>
				</div>
				<?php
				}
			}
			?>

			<form id="hotelwp-import-file-form" method="post" enctype="multipart/form-data">
				<p>
					<label><?php esc_html_e( 'Language', 'hotelwp' ); ?></label><br/>
					<?php
					$select_lang_options = '<option value=""></option>';
					foreach ( $this->langs as $locale => $lang_name ) {
						$select_lang_options .= '<option value="' . $locale . '">' . $lang_name . ' (' . $locale . ')</option>';
					}
					$select_lang = '<select id="hotelwp-import-lang-code" name="hotelwp-import-lang-code">' . $select_lang_options . '</select>';
					$allowed_html = array(
						'select' => array(
							'id' => array(),
							'name' => array()
						),
						'option' => array(
							'value' => array()
						)
					);
					echo( wp_kses( $select_lang, $allowed_html ) );
					?>
				</p>
				<p>
					<input id="hotelwp-import-lang-file" type="file" name="hotelwp-import-lang-file" />
				</p>
				<p>
					<input id="hotelwp-import-lang-submit" type="submit" class="button-primary" value="<?php esc_attr_e( 'Import', 'hotelwp' ); ?>" />
				</p>
				<input type="hidden" name="hotelwp-import-export-action" value="import-lang" />
				<?php wp_nonce_field( 'hotelwp_import_export', 'hotelwp_import_export' ); ?>
			</form>
			
			<hr/>

			<h3><?php esc_html_e( 'Export a language file', 'hotelwp' ); ?></h3>
			<p>
				<?php
				foreach ( $this->langs as $locale => $lang_name ) {
				?>
				<a href="#" class="hotelwp-export-lang-file" data-locale="<?php echo( esc_attr( $locale ) ); ?>"><?php echo( wp_kses_post( $lang_name . ' (' . $locale . ')' ) ); ?></a>
				<br/>
				<?php
				}
				?>
			</p>
			
			<form id="hotelwp-export-lang-form" method="POST">
				<input type="hidden" name="hotelwp-import-export-action" value="export-lang" />
				<input id="hotelwp-locale-export" type="hidden" name="hotelwp-locale-export" />
				<?php wp_nonce_field( 'hotelwp_import_export', 'hotelwp_import_export' ); ?>
			</form>
			
			<hr/>

			<h3><?php esc_html_e( 'Modify theme strings', 'hotelwp' ); ?></h3>

			<div class="hotelwp-settings-save-wrapper">
				<p>
					<input type="button" class="button-primary hotelwp-settings-save" value="<?php esc_html_e( 'Save changes', 'hotelwp' ); ?>" />
					<span class="hotelwp-saving-settings"></span>
				</p>
				<p class="hotelwp-settings-saved"><?php _e( 'All strings have been saved.', 'hotelwp' ); ?></p>
			</div>
			
			<form id="hotelwp-theme-strings-form" class="hotelwp-settings">
				<input type="hidden" name="action" value="hotelwp_save_strings" />
				
				<?php
				wp_nonce_field( 'hotelwp_theme_settings_nonce', 'hotelwp_theme_settings_nonce' );
				foreach ( $this->strings as $string_id => $string_name ) { 
				?>
				
				<p class="string-name"><?php echo( esc_html( $string_name ) ); ?></p>
				
				<p>
				<?php
					foreach ( $this->langs as $locale => $lang_name ) {
						$string_value = '';
						if ( isset( $this->string_values[ $string_id ][ $locale ] ) ) {
							$string_value = $this->string_values[ $string_id ][ $locale ];
						}
						if ( count( $this->langs ) > 1 ) {
				?>
					<label class="string-lang"><?php echo( esc_html( $lang_name ) ); ?><span> (<?php echo( esc_html( $locale ) );?>)</span></label><br/>
				<?php
						}
				?>
					<input class="string-input" type="text" name="string-id-<?php echo( esc_html( $string_id ) ); ?>-in-<?php echo( esc_html( $locale ) ); ?>" value="<?php echo( esc_attr( $string_value ) ); ?>" />
				</p>
				
				<?php 
					}
				}
				?>
				
			</form>
			
			<div class="hotelwp-settings-save-wrapper">
				<p>
					<input type="button" class="button-primary hotelwp-settings-save" value="<?php esc_html_e( 'Save changes', 'hotelwp' ); ?>" />
					<span class="hotelwp-saving-settings"></span>
				</p>
				<p class="hotelwp-settings-saved"><?php _e( 'All strings have been saved.', 'hotelwp' ); ?></p>
			</div>
			
		</div>
		
		<?php
	}

	public function save_settings() {
		if ( 
			isset( $_POST['hotelwp_theme_settings_nonce'] ) && 
			wp_verify_nonce( $_POST['hotelwp_theme_settings_nonce'], 'hotelwp_theme_settings_nonce' ) && 
			current_user_can( 'manage_options' ) 
		) {
			$new_strings = array();
			foreach ( $this->strings as $string_id => $string_name ) {
				foreach ( $this->langs as $locale => $lang_name ) {
					$input_name = 'string-id-' . $string_id . '-in-' . $locale;
					if ( isset( $_POST[ $input_name ] ) ) {
						$new_strings[ $string_id ][ $locale ] = wp_kses_post( stripslashes( $_POST[ $input_name ] ) );
					}
				}
			}
			update_option( strtolower( $this->theme_name ) . '_theme_strings', json_encode( $new_strings ) );
			echo( 'settings_saved' );
		}
		die;		
	}
		
	public function get_langs() {
		$langs = array();
		if ( function_exists( 'icl_get_languages' ) && ! function_exists( 'pll_languages_list' ) ) {
			$wpml_langs = icl_get_languages( 'skip_missing=0&orderby=code' );
			foreach ( $wpml_langs as $lang_id => $wpml_lang ) {
				$langs[ $wpml_lang['default_locale'] ] = $wpml_lang[ 'native_name' ];
			}
		} else if ( function_exists( 'pll_languages_list' ) ) {
			$locales = pll_languages_list( array( 'fields' => 'locale' ) );
			$names = pll_languages_list( array( 'fields' => 'name' ) );
			foreach ( $locales as $i => $locale ) {
				$langs[ $locale ] = $names[ $i ];
			}
		} else if ( function_exists( 'qtranxf_getLanguage' ) ) {
			global $q_config;
			foreach ( $q_config['enabled_languages'] as $q_lang ) {
				$langs[ $q_config['locale'][ $q_lang ] ] = $q_config['language_name'][ $q_lang ];
			}
		} else {
			if ( get_locale() != 'en_US' ) {
				require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
				$translations = wp_get_available_translations();
				$langs[ get_locale() ] = $translations[ get_locale() ]['native_name'];
			}
		}
		if ( ! array_key_exists( 'en_US', $langs ) ) {
			$langs = array_merge( array( 'en_US' => 'English' ), $langs );
		}
		$langs = apply_filters( 'hotelwp_theme_language_list', $langs );
		return $langs;
	}

	public function export_lang_file() {
		if ( 
			isset( $_POST['hotelwp-import-export-action'] ) && 
			( $_POST['hotelwp-import-export-action'] == 'export-lang' ) && 
			wp_verify_nonce( $_POST['hotelwp_import_export'], 'hotelwp_import_export' ) && 
			current_user_can( 'manage_options' ) 
		) {
			header( 'Content-Description: File Transfer' );
			header( 'Content-Disposition: attachment; filename=' . strtolower( $this->theme_name ) . '-' . $_POST['hotelwp-locale-export'] . '.txt' );
			header( 'Content-Type: text; charset=' . get_option( 'blog_charset' ) );
			foreach ( $this->strings as $string_id => $string_desc ) {
				if ( isset( $this->string_values[ $string_id ]['en_US'] ) ) {
					echo( 'msgctxt "' . $this->string_values[ $string_id ]['en_US'] . '"' . "\n" );
				}
				echo( 'msgid "' . $string_id . '"' . "\n" );
				if ( isset( $this->string_values[ $string_id ][ $_POST['hotelwp-locale-export'] ] ) ) {
					echo( 'msgstr "' . $this->string_values[ $string_id ][ $_POST['hotelwp-locale-export'] ] . '"' . "\n" );
				} else {
					echo( 'msgstr ""' . "\n" );
				}
				echo( "\n" );
			}
			die;
		}
	}

}
	
$hotelwp_theme_strings = new HotelWPThemeStrings();

function hotelwp_theme_get_string( $id ) {
	global $hotelwp_theme_strings;
	$locale = get_locale();
	if ( function_exists( 'icl_object_id' ) && ! function_exists( 'pll_get_post' ) ) {
		global $sitepress;
		$locale = $sitepress->get_locale( ICL_LANGUAGE_CODE );
	}
	if ( $locale == 'en' ) {
		$locale = 'en_US';
	}
	if ( isset( $hotelwp_theme_strings->string_values[ $id ][ $locale ] ) ) {
		return $hotelwp_theme_strings->string_values[ $id ][ $locale ];
	} else {
		return $hotelwp_theme_strings->string_values[ $id ][ 'en_US' ];
	}
}