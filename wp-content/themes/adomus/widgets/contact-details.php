<?php

add_action( 'widgets_init', 'hotelwp_register_contact_details_widget' );

function hotelwp_register_contact_details_widget() {
    register_widget( 'hotelwp_contact_details_widget' );
}

class hotelwp_contact_details_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'hotelwp_contact_details',
			__( 'Contact Details', 'hotelwp' ),
			array( 'description' => __( 'Display the contact details entered in the Contact details page.', 'hotelwp' ), )
		);
	}
	
	public function widget( $args, $instance ) {
		$widget_id = $args['id'];
     	echo( wp_kses_post( $args['before_widget'] ) );
		if ( $widget_id == 'top-header-left' || $widget_id == 'top-header-right' ) {
			$tag_begin = '<span>';
			$tag_end = '</span>';
			$title = ( ! empty( $instance['title'] ) ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
			$title_link = '<a href="#" class="contact-details-trigger">' . $title;
			$title_link .= '<span>&nbsp;<i class="fa fa-angle-down"></i></span></a>';
			echo( wp_kses_post( $title_link ) );
			echo( '<div class="widget-contact-content">' );
		} else {
			$tag_begin = '<li>';
			$tag_end = '</li>';
			if ( ! empty( $instance['title'] ) ) {
				echo( wp_kses_post( $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'] ) );
			}
			echo( '<ul class="widget-contact-content">' );
		}
		
		for ( $i = 1; $i <= 5; $i++ ) {
			$detail_id = 'hotelwp_contact_detail_' . $i;
			$detail_value = get_option( $detail_id );
			if ( 
				$detail_value && 
				isset( $instance[ $detail_id . '-is-displayed' ] ) && 
				( $instance[ $detail_id . '-is-displayed' ] == 'yes' )
			) {
				$link = $instance[ $detail_id . '-url-or-page-id' ];
				$url = '';
				if ( $link ) {
					if ( is_numeric( $link ) ) {
						$url = get_permalink( $link );
					} else {
						$url = esc_url( $link );
					}
				}
				$tag_link_begin = '';
				$tag_link_end = '';
				if ( $url ) {
					$tag_link_begin = '<a href="' . $url . '">';
					$tag_link_end = '</a>';
				}
				if ( ( $widget_id != 'top-header-left' ) && ( $widget_id != 'top-header-right' ) ) {
					$detail_value = nl2br( $detail_value );
				}
				$detail_html = $tag_begin . $instance[ $detail_id . '-label' ];
				$detail_html .= $tag_link_begin . $detail_value . $tag_link_end . $tag_end;
				echo( wp_kses_post( $detail_html ) );
			}
		}
		
		if ( $widget_id == 'top-header-left' || $widget_id == 'top-header-right' ) {
			echo( '</div>' );
		} else {
			echo( '</ul>' );
		}
		echo( wp_kses_post( $args['after_widget'] ) );
	}

	public function form( $instance ) {
		$has_defined_element = false;
		for ( $i = 1; $i <= 5; $i++ ) {
			if ( get_option( 'hotelwp_contact_detail_' . $i ) ) {
				$has_defined_element = true;
				break;
			}
		}
		if ( ! $has_defined_element ) :
		?>
			<p>
				<?php printf( esc_html__( 'You need to enter information in the %s Contact details page %s before using this widget.', 'hotelwp' ), '<a href="' . admin_url( 'admin.php?page=hotelwp_contact_details' ) . '">', '</a>' ); ?>
			</p>
		<?php
		else :
			$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			?>
			
			<p>
				<b><label for="<?php echo( esc_attr( $this->get_field_id( 'title' ) ) ); ?>"><?php esc_html_e( 'Title:', 'hotelwp' ); ?></label></b>
				<input 
					class="widefat" 
					id="<?php echo( esc_attr( $this->get_field_id( 'title' ) ) ); ?>" 
					name="<?php echo( esc_attr( $this->get_field_name( 'title' ) ) ); ?>" 
					type="text" 
					value="<?php echo( esc_html( $title ) ); ?>" 
				/>				
			</p>
			
			<p><b><?php _e( 'Choose and set the contact details you want to display:', 'hotelwp' ); ?></b></p>
			
			<?php
			$is_displayed_choices = array(
				'yes' => __( 'Yes', 'hotelwp' ),
				'no' => __( 'No', 'hotelwp' ),
			);
			for ( $i = 1; $i <= 5; $i++ ) : 
				$detail_id = 'hotelwp_contact_detail_' . $i;
				if ( get_option( $detail_id ) ) :
					
					$is_displayed_detail = $detail_id . '-is-displayed';
					$is_displayed_value = 'yes';
					if ( isset( $instance[ $is_displayed_detail ] ) && $instance[ $is_displayed_detail ] ) {
						$is_displayed_value = $instance[ $is_displayed_detail ];
					}
					?>
					
					<p>
						
						<?php 
						printf( esc_html__( 'Display contact detail %s ?', 'hotelwp' ), '<b>(' . $i . ')</b>' ); 
						echo( '<br/>' );
						$field_name = $this->get_field_name( $is_displayed_detail );
						foreach ( $is_displayed_choices as $choice_id => $choice_text ) : 
							$field_id = $this->get_field_id( $is_displayed_detail . '-' . $choice_id );
							?>
							
						<input 
							type="radio" 
							id="<?php echo( esc_attr( $field_id ) ); ?>" 
							name="<?php echo( esc_attr( $field_name ) ); ?>" 
							value="<?php echo( esc_attr( $choice_id ) ); ?>" 
							<?php echo( $is_displayed_value == $choice_id ? 'checked' : '' ); ?>
						/>
						<label for="<?php echo( esc_attr( $field_id ) ); ?>"><?php echo( esc_html( $choice_text ) ); ?></label>
						<br/>
						
						<?php endforeach; ?>
						
					</p>
					
					<?php
					$detail_label = $detail_id . '-label';
					$detail_label_value = '';
					if ( isset( $instance[ $detail_label ] ) ) {
						$detail_label_value = $instance[ $detail_label ];
					}
					$field_id = $this->get_field_id( $detail_label );
					$field_name = $this->get_field_name( $detail_label );
					?>
					
					<p>
						<label for="<?php echo( esc_attr( $field_id ) ); ?>"><?php printf( esc_html__( 'Contact detail %s label:', 'hotelwp' ), '<b>(' . $i . ')</b>' ); ?></label><br/>
						<input 
							type="text" 
							class="widefat"
							id="<?php echo( esc_attr( $field_id ) ); ?>" 
							name="<?php echo( esc_attr( $field_name ) ); ?>" 
							value="<?php echo( esc_attr( $detail_label_value ) ); ?>" 
						/>
					</p>
										
					<?php
					$detail_url = $detail_id . '-url-or-page-id';
					$detail_url_value = '';
					if ( isset( $instance[ $detail_url ] ) ) {
						$detail_url_value = $instance[ $detail_url ];
					}
					$field_id = $this->get_field_id( $detail_url );
					$field_name = $this->get_field_name( $detail_url );
					?>
					
					<p>
						<label for="<?php echo( esc_attr( $field_id ) ); ?>"><?php printf( esc_html__( 'Contact detail %s link (url or page id):', 'hotelwp' ), '<b>(' . $i . ')</b>' ); ?></label><br/>
						<input 
							type="text" 
							class="widefat"
							id="<?php echo( esc_attr( $field_id ) ); ?>" 
							name="<?php echo( esc_attr( $field_name ) ); ?>" 
							value="<?php echo( esc_attr( $detail_url_value ) ); ?>" 
						/>
					</p>
					
				<?php 
				endif;
			endfor;
		endif;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		if ( ! $instance['title'] ) {
			$instance['title'] = __( 'Contact details', 'hotelwp' );
		}
		$fields = array( 'is-displayed', 'label', 'url-or-page-id' );
		for ( $i = 1; $i <= 5; $i++ ) {
			$detail_id = 'hotelwp_contact_detail_' . $i;
			if ( get_option( $detail_id ) ) {
				foreach ( $fields as $field ) {
					$detail_field = $detail_id . '-' . $field;
					$instance[ $detail_field ] = ( ! empty( $new_instance[ $detail_field ] ) ) ? strip_tags( $new_instance[ $detail_field ] ) : '';
				}
			}
		}
		return $instance;
	}
}