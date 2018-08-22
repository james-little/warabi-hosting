<?php
class HotelWPDemoInstall {
	
	private $theme_name;
	private $nb_demo;
	
	public function __construct() {
		$this->theme_name = wp_get_theme();
		add_action( 'init', array( $this, 'hotelwp_demo_install_ajax' ) );	
		add_action( 'admin_menu', array( $this, 'hotelwp_demo_install_sub_menu' ) );
		require_once 'theme-demo-install.php';
		$this->nb_demo = hotelwp_demo_install_get_nb_demo();
	}

	public function hotelwp_demo_install_ajax() {
		$install_steps = $this->demo_install_steps();
		foreach ( $install_steps as $step_id => $step ) {
			if ( $step_id != 'all_done' && ( ! strpos( $step_id, '__' ) || substr( $step_id, -1 ) == '0' ) ) {
				if ( strpos( $step_id, '__' ) ) {
					$step_id = substr( $step_id, 0, strpos( $step_id, '__' ) );
				}
				$install_class_file_name = plugin_dir_path( __FILE__ ) . $step_id . '.php';
				$install_class_name = 'HotelWPInstall' . ucfirst( $step_id );
				require_once $install_class_file_name;
				$installer = new $install_class_name();
				add_action( 'wp_ajax_hotelwp_install_step_' . $step_id, array( $installer, 'process' ) );
			}
		}
	}

	public function hotelwp_demo_install_sub_menu() {
		$page = add_theme_page( 
			sprintf( esc_html__( '%s demo install', 'hotelwp' ), $this->theme_name ), 
			sprintf( esc_html__( '%s demo install', 'hotelwp' ), $this->theme_name ), 
			'manage_options', 
			'hotelwp-demo-install', 
			array( $this, 'demo_install_page_display' ) 
		);
		add_action( 'admin_print_styles-' . $page, array( $this, 'hotelwp_demo_install_script' ) );
	}

	public function demo_install_steps() {
		return array(
			'reset' => __( 'Resetting WordPress installation.', 'hotelwp' ),
			'images__0' => __( 'Copying images (batch 1 of 4).', 'hotelwp' ),
			'images__1' => __( 'Copying images (batch 2 of 4).', 'hotelwp' ),
			'images__2' => __( 'Copying images (batch 3 of 4).', 'hotelwp' ),
			'images__3' => __( 'Copying images (batch 4 of 4).', 'hotelwp' ),
			'posts' => __( 'Installing posts.', 'hotelwp' ),
			'options' => __( 'Setting WordPress options', 'hotelwp' ),
			'all_done' => __( 'Your website has been loaded with the demo content. You can now leave this page and start editing!', 'hotelwp' ),
		);
	}
	
	public function demo_install_page_display() {
	?>
		<div class="wrap">
			<h2><?php printf( esc_html__( '%s demo install', 'hotelwp' ), $this->theme_name ); ?></h2>
			<p>
				<?php esc_html_e( 'Installing a demo includes creating pages, posts, navigation menus as well as allocating widgets to sidebars and setting options.' ,'hotelwp' ); ?>
			</p>
			<p>
				<b><?php esc_html_e( 'Warning:', 'hotelwp' ); ?></b> 
				<?php esc_html_e( 'It will delete previous posts, categories, pages, navigation menus as well as deleting sidebar widgets options and changing several options.', 'hotelwp' ); ?>
				<br/>	
				<?php esc_html_e( 'If you have HBook set up already, note that it will delete all HBook settings and content as well.', 'hotelwp' ); ?>
			</p>
			<?php for ( $i = 1; $i <= $this->nb_demo; $i++ ) : ?>
			<p>
				<input class="hotelwp-demo-install button-primary" data-demo-num="<?php echo( esc_attr( $i ) ); ?>" type="button" value="<?php echo( esc_attr( sprintf( esc_html__( 'Demo %d installation', 'hotelwp' ), $i ) ) ); ?>" />
				&nbsp;
				<a target="_blank" href="https://hotelwp.com/themes/adomus/demo-<?php echo( esc_html( $i ) ); ?>/"><?php echo( esc_attr( sprintf( esc_html__( 'View demo %d', 'hotelwp' ), $i ) ) ); ?></a>
			</p>
			<?php endfor; ?>
			<p><b><?php esc_html_e( 'This process may take several minutes. Please do not refresh or exit this page before completion.', 'hotelwp' ); ?></b></p>
			<?php
			$install_steps = $this->demo_install_steps();
			foreach ( $install_steps as $step_id => $step ) :
				$step_class = 'hotelwp-install-step hotelwp-install-step-' . $step_id;
				if ( $step_id == 'all_done' ) :
				?>
				
				<span class="<?php echo( esc_attr( $step_class ) ); ?>"><b><?php echo( esc_html( $step ) ); ?></b></span>
				
				<?php else : ?>
					
				<span class="<?php echo( esc_attr( $step_class ) ); ?>">
					<?php echo( esc_html( $step ) ); ?>
					<span class="hotelwp-install-step-done"><?php esc_html_e( 'Done.', 'hotelwp' ); ?></span>
					<span class="hotelwp-install-step-error"><?php esc_html_e( 'An error occured.', 'hotelwp' ); ?></span>
				</span>
				
				<?php
				endif;
			endforeach;
			?>
			<span class="hotelwp-install-step hotelwp-install-step-all_done-with-error"><b><?php echo( esc_html_e( 'The demo content installation could not be fully completed.', 'hotelwp' ) ); ?></b></span>
			<p class="hotelwp-install-log"></p>
		</div>
		<?php
		wp_nonce_field( 'hotelwp_theme_install_nonce', 'hotelwp_theme_install_nonce' );
	}
	
	public function hotelwp_demo_install_script() {
		wp_enqueue_style( 'hotelwp-demo-install-style', get_template_directory_uri(). '/demo-install/demo-install.css', array(), '1.0' );
		
		wp_enqueue_script( 'hotelwp-demo-install-script', get_template_directory_uri(). '/demo-install/demo-install.js', array( 'jquery' ), '1.0', true );
		$data = array(
			'confirm_text' => esc_html__( 'Installing the demo content will reset your WordPress installation (previous posts, pages, categories, tags, menus, sidebars widgets will be erased). If you have HBook set up already, note that it will delete all HBook settings and content as well. Do you want to continue?', 'hotelwp' ),
			'already_installing' => esc_html__( 'The demo content is being installed. Please wait a little longer.', 'hotelwp' ),
			'steps' => array_keys( $this->demo_install_steps() ),
		);
		wp_localize_script( 'hotelwp-demo-install-script', 'hotelwp_demo_install_data', $data );
	}
	
}
	
new HotelWPDemoInstall();