<?php

add_action( 'admin_menu', 'hotelwp_slider_admin_menu' );

function hotelwp_slider_admin_menu() {
	$slider_page = add_menu_page( esc_html__( 'Sliders', 'hotelwp' ), esc_html__( 'Sliders', 'hotelwp' ), 'manage_options', 'hotelwp_sliders', 'hotelwp_slideshow_display', 'dashicons-images-alt2', 11 );
	add_action( 'admin_print_styles-' . $slider_page, 'hotelwp_slideshow_enqueue_admin_files' );
}

function hotelwp_slideshow_enqueue_admin_files( $hook ){
	wp_enqueue_media();
	wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_style( 'hotelwp-sliders-back-end', get_template_directory_uri() . '/admin/css/sliders-back-end.css' );
	wp_enqueue_script( 'hotelwp-knockout', get_template_directory_uri() . '/admin/js/knockout-3.2.0.js', array(), '1.0', true );
	wp_enqueue_script( 'hotelwp-knockout-sortable', get_template_directory_uri() . '/admin/js/knockout-sortable.min.js', array(), '1.0', true );
	wp_enqueue_script( 'hotelwp-sliders', get_template_directory_uri() . '/admin/js/sliders-back-end.js', array( 'jquery', 'wp-color-picker'  ), '1.0', true );
}

add_action( 'wp_ajax_hotelwp_save_slideshows', 'hotelwp_save_slideshows' );

function hotelwp_save_slideshows() {
	if ( isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'hotelwp_sliders_nonce' ) && current_user_can( 'manage_options' ) ) {
		update_option( 'hotelwp_sliders', stripslashes( $_POST['slideshows'] ) );
	}
	die;
}

function hotelwp_slideshow_display() {
	if ( ! current_user_can( 'manage_options' ) )  {
		wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'hotelwp' ) );
	} else {
		$db_slideshows = get_option( 'hotelwp_sliders' );
		if ( ! $db_slideshows ) {
			$db_slideshows = array();
		} else {
			$db_slideshows = json_decode( $db_slideshows, true) ;
		}
		foreach ( $db_slideshows as $slideshows_key => $slideshows ) {
			foreach ( $slideshows['slides'] as $slide_key => $slide ) {
				$media_attachment = wp_get_attachment_metadata( $slide['mediaId'] );
				if ( wp_attachment_is_image( $slide['mediaId'] ) ) {
					$db_slideshows[ $slideshows_key ]['slides'][ $slide_key ]['thumbnailPath'] = aq_resize( wp_get_attachment_url( $slide['mediaId'] ), 200, 150, true, true, true );
				} else {
					$db_slideshows[ $slideshows_key ]['slides'][ $slide_key ]['thumbnailPath'] = get_template_directory_uri() . '/admin/img/add-slide.jpg';
					//$db_slideshows[ $slideshows_key ]['slides'][ $slide_key ]['thumbnailPath'] = get_template_directory_uri() . '/admin/img/video-slide.jpg';
				}
			}
		}		
		wp_localize_script( 'hotelwp-sliders', 'dbSlideshows', $db_slideshows );

		$template_directory = get_template_directory_uri();
		$default_images = array(
			'add_media'		=> 	$template_directory . '/admin/img/add-slide.jpg',
			'video_media'	=>	$template_directory . '/admin/img/video-slide.jpg',
		);
		wp_localize_script( 'hotelwp-sliders', 'defaultImages', $default_images );

		$hotelwp_slider_strings = array(
			'select_media'		=>	esc_html__( 'Select a media', 'hotelwp' ),
			'select_button'		=>	esc_html__( 'Select', 'hotelwp' ),
			'delete_slideshow'	=>	esc_html__( 'Are you sure you want to delete this slider? Click OK to confirm.', 'hotelwp' ),
			'delete_slide'		=>	esc_html__( 'Are you sure you want to delete this slide? Click OK to confirm.', 'hotelwp' ),
			'can_not_save'		=>	esc_html__( 'Changes could not be saved. Please try again.', 'hotelwp' ),
			'unsaved_warning'	=>	esc_html__( 'Changes you made may not be saved.', 'hotelwp' ),
		);
		wp_localize_script( 'hotelwp-sliders', 'hotelwp_slider_strings', $hotelwp_slider_strings );
		?>

		<div class="wrap">
			<h2><?php _e( 'Sliders', 'hotelwp' ); ?></h2>
			
			<div>
				<p>
					<button class="button-primary hotelwp-sliders-save-changes"><?php _e( 'Save', 'hotelwp' ); ?></button>
					<span class="slideshows-saving"></span>
					<?php wp_nonce_field( 'hotelwp_sliders_nonce', 'hotelwp-sliders-nonce' ); ?>
				<p>
				<p class="slideshows-saved"><?php _e( 'All sliders changes have been saved.', 'hotelwp' ) ?></p>
			</div>
			
			<p>
				<button id="add-new-slideshow" class="button"><?php _e( 'Add a slider', 'hotelwp' ); ?></button>
			</p>
			
			<div id="new-slideshow-form">
				<form data-bind="submit: createSlideshow">
				<?php _e( 'Slider name: ', 'hotelwp' ); ?><input id="new-slideshow-name" type="text" />
				<button class="secondary button" id="submit-new-slideshow" type="submit"><?php _e( 'Add', 'hotelwp' ); ?></button>
				<button class="secondary button" id="cancel-new-slideshow" type="button"><?php _e( 'Cancel', 'hotelwp' ); ?></button>
				</form>

			</div>
			
			<div class="slideshows">
			
                <div data-bind="template: { name: 'slideshow-template', foreach: slideshows, as: 'slideshow' }"></div>

                <script type="text/html" id="slideshow-template"><div class="slideshow">
                        <h3 class= "slideshow-name" data-bind="text: slideshowName"></h3>
                            <button type="button" class="button-secondary edit-slideshow"><?php _e( 'Edit Slider', 'hotelwp' ); ?></button>
                            <button type="button" class="button-secondary close-edit-slideshow"><?php _e( 'Close Slider', 'hotelwp' ); ?></button>
                            <button data-bind="click: $root.deleteSlideshow" type="button" class="button-secondary delete-slideshow"><?php _e( 'Delete Slider', 'hotelwp' ); ?></button>
							
							<div class="edit-slideshow-form">
                                <p><span class="label"><?php _e( 'Slider name', 'hotelwp' ); ?></span><input type="text" data-bind="textInput: slideshowName" /></p>
                                <span class="label"><?php _e( 'Autoplay', 'hotelwp' ); ?></span>
                                <div><input type="radio" data-bind="attr: { id: autoplayOptionIdYes, name: autoplayOptionName }, checked: autoplay" value="yes" /> <label data-bind="attr: { for: autoplayOptionIdYes}"><?php _e( 'Yes', 'hotelwp' ); ?></label></div>
                                <div><input type="radio" data-bind="attr: { id: autoplayOptionIdNo, name: autoplayOptionName }, checked: autoplay" value="no" /> <label data-bind="attr: { for: autoplayOptionIdNo}"><?php _e( 'No', 'hotelwp' ); ?></label></div>
                                <p><span class="label"><?php _e( 'Slide display duration in miliseconds', 'hotelwp' ); ?></span><input type="text" size= "10" data-bind="textInput: slideDuration" /></p>
                                <p><span class="label"><?php _e( 'Transition duration in miliseconds', 'hotelwp' ); ?></span><input type="text" size= "10" data-bind="textInput: transitionDuration" /></p>
                                <span class="label"><?php _e( 'Transitions style', 'hotelwp' ); ?></span>
                                <div><input type="radio" data-bind="attr: { id: transitionOptionIdSlide, name: transitionOptionName }, checked: transitionStyle" value="slide" /> <label data-bind="attr: { for: transitionOptionIdSlide}"><?php _e( 'Slide', 'hotelwp' ); ?></label></div>
                                <div><input type="radio" data-bind="attr: { id: transitionOptionIdFade, name: transitionOptionName }, checked: transitionStyle" value="fade" /> <label data-bind="attr: { for: transitionOptionIdFade}"><?php _e( 'Fade', 'hotelwp' ); ?></label></div>
                                <!--
                                <div><input type="radio" data-bind="attr: { name: transitionOptionName }, checked: transitionStyle" value="backSlide" /><?php _e( 'Back slide', 'hotelwp' ); ?></div>
                                <div><input type="radio" data-bind="attr: { name: transitionOptionName }, checked: transitionStyle" value="goDown" /><?php _e( 'Go Down', 'hotelwp' ); ?></div>
                                <div><input type="radio" data-bind="attr: { name: transitionOptionName }, checked: transitionStyle" value="fadeUp" /><?php _e( 'Fade Up', 'hotelwp' ); ?></div>
                                -->
                                <br/>
                                <!--
                                <p><span class="label"><?php _e( 'Pagination duration in miliseconds ', 'hotelwp' ); ?></span><input type="text" size= "10" data-bind="textInput: paginationDuration" /></p>
                                <p><span class="label"><?php _e( 'Rewind duration in miliseconds ', 'hotelwp' ); ?></span><input type="text" size= "10" data-bind="textInput: rewindDuration" /></p>
                                -->
                                <p><button data-bind="click: createSlideTop" class="button-secondary add-new-slide"><?php _e( 'Add a slide', 'hotelwp' ); ?></button></p>
                                <div data-bind="sortable: { template: 'slides-template', data: slides} "></div>
                                <p class="add-slide-button-wrapper"><button data-bind="click: createSlideEnd" class="button-secondary add-new-slide"><?php _e( 'Add a slide', 'hotelwp' ); ?></button></p>
								<div>
									<p>
										<button class="button-primary hotelwp-sliders-save-changes"><?php _e( 'Save', 'hotelwp' ); ?></button>
										<span class="slideshows-saving"></span>
										<?php wp_nonce_field( 'hotelwp_sliders_nonce', 'hotelwp-sliders-nonce' ); ?>
									<p>
									<p class="slideshows-saved"><?php _e( 'All sliders changes have been saved.', 'hotelwp' ) ?></p>
								</div>
                            </div>
                        </div>
                    </div>
                </script>

                <script type="text/html" id="slides-template"><div class="slide-display">
                        <div class="slide-image">
                            <a href="#" data-bind="click: editSlide"><img data-bind="attr: {src: thumbnailPath}" /><span class="slide-title" data-bind="text: thumbnailTitle"></span></a>
                        </div>
                        
                        <div class="caption">
                            <p>
                                <?php esc_html_e( 'Caption', 'hotelwp' ); ?>
                                <textarea class="widefat" rows="3" data-bind="value: caption"></textarea>
                            </p>
                            <!--
                            <p class="background-color"><span class="label"><?php _e( 'Caption background color', 'hotelwp' ); ?></span><input data-default-color="#000" data-bind="wpColorPicker: backgroundColor"/></p>
                            <p class="text-color"><span class="label"><?php _e( 'Caption text color', 'hotelwp' ); ?></span><input data-default-color="#fff" data-bind="wpColorPicker: textColor"  /></p>
                            <p class="caption-opacity"><span class="label"><?php _e( 'Caption background opacity (%)', 'hotelwp' ); ?></span><input type="text" size= "10" data-bind="textInput: captionOpacity" /></p>
                            -->
                        </div>
                        
                        <button data-bind="click: $parent.deleteSlide" class="delete-slide button-secondary"><?php _e( 'Delete Slide', 'hotelwp' ); ?></button>
                    </div>
                </script>
                
            </div><!-- .slideshows -->
            
		</div><!-- .wrap -->
		
		<?php
	}
}