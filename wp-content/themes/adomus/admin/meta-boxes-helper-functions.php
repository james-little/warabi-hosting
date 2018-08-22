<?php

function adomus_meta_field_label( $id, $text ) {
    ?>
    <label for="<?php echo( esc_attr( $id ) ); ?>"><b><?php echo( esc_html( $text ) ); ?></b></label></br>
    <?php
}

function adomus_meta_class( $meta_info ) {
    if ( isset( $meta_info['class'] ) ) {
        echo( esc_attr( $meta_info['class'] ) );
    }
}

function adomus_meta_visible( $meta_info ) {
    if ( isset( $meta_info['visibility-group'] ) ) {
        $data_bind = 'visible: ' . $meta_info['visibility-group'] . '_is_visible';
        echo( esc_attr( $data_bind ) );
    }
}

function adomus_meta_input( $meta_id, $meta_info ) {
	?>
	<p class="<?php adomus_meta_class( $meta_info ); ?>" data-bind="<?php adomus_meta_visible( $meta_info ); ?>">
		<?php adomus_meta_field_label( $meta_id, $meta_info['name'] ); ?>
		<input 
            id="<?php echo( esc_attr( $meta_id ) ); ?>" 
            name="<?php echo( esc_attr( $meta_id ) ); ?>" 
            type="text" 
            class="widefat" 
            value="<?php echo( esc_attr( adomus_get_current_post_meta( $meta_id ) ) ); ?>" 
        />
	</p>
	<?php
}

function adomus_meta_select( $meta_id, $meta_info ) {
    $meta_bind = '';
    if ( isset( $meta_info['bind'] ) ) {
        $meta_bind = 'value: ' . str_replace( 'adomus_', '', $meta_id );
    }
	?>
	<p class="<?php adomus_meta_class( $meta_info ); ?>" data-bind="<?php adomus_meta_visible( $meta_info ); ?>">
		<?php adomus_meta_field_label( $meta_id, $meta_info['name'] ); ?>
		<select id="<?php echo( esc_attr( $meta_id ) ); ?>" name="<?php echo( esc_attr( $meta_id ) ); ?>" data-bind="<?php echo( esc_attr( $meta_bind ) ); ?>">
		<?php foreach ( $meta_info['values'] as $option_id => $option_text ) : ?>
			<option value="<?php echo( esc_attr( $option_id ) ); ?>" <?php echo( adomus_get_current_post_meta( $meta_id ) == $option_id ? 'selected' : '' ); ?>><?php echo( esc_html( $option_text ) ); ?></option>
		<?php endforeach; ?>
		</select>
	</p>
	<?php
}


function adomus_meta_multiple_select( $meta_id, $meta_info ) {
    $selected_choices = adomus_get_current_post_meta( $meta_id );
    if ( ! $selected_choices ) {
        if ( $meta_info['default'] == 'all' ) {
            $selected_choices = 'all';
        } else {
            $selected_choices = array();
        }
    } else if ( $selected_choices != 'all' ) {
        $selected_choices = explode( ',', $selected_choices );
    }
    $select_size = sizeof( $meta_info['values'] );
    if ( $select_size > 5 ) {
        $select_size = 5;
    }
    ?>
    <p class="<?php adomus_meta_class( $meta_info ); ?>">
		<?php adomus_meta_field_label( $meta_id, $meta_info['name'] ); ?>
        <span class="adomus-multiple-select-checkbox-wrapper">
            <input 
                id="<?php echo( esc_attr( $meta_id . '_checkbox' ) ); ?>" 
                name="<?php echo( esc_attr( $meta_id . '_checkbox' ) ); ?>" 
                type="checkbox" 
                class="adomus-multiple-select-checkbox" 
                value="all" 
                <?php if ( $selected_choices == 'all' ) { echo( 'checked' ); } ?>
            />
            <label for="<?php echo( esc_attr( $meta_id . '_checkbox' ) ); ?>"><?php esc_html_e( 'All', 'hotelwp' ); ?></label>
        </span>
        <br/>
        <select id="<?php echo( esc_attr( $meta_id ) ); ?>" name="<?php echo( esc_attr( $meta_id ) ); ?>[]" size="<?php echo( esc_attr( $select_size ) ); ?>" multiple>
		<?php foreach ( $meta_info['values'] as $option_id => $option_text ) : ?>
			<option value="<?php echo( esc_attr( $option_id ) ); ?>" <?php if ( $selected_choices == 'all' || in_array( $option_id, $selected_choices ) ) { echo( 'selected' ); } ?>><?php echo( esc_html( $option_text ) ); ?></option>
		<?php endforeach; ?>
		</select>
        <br/>
        <small class="adomus-multiple-select-legend"><?php printf( esc_html__( 'Hold down the Ctrl (windows) / Command (Mac) button to select multiple %s.', 'hotelwp' ), $meta_info[ 'type_name' ] ); ?></small>
    </p>
    <?php
}

function adomus_meta_textarea( $meta_id, $meta_info ) {
	?>
	<p class="<?php adomus_meta_class( $meta_info ); ?>" data-bind="<?php adomus_meta_visible( $meta_info ); ?>">
		<?php adomus_meta_field_label( $meta_id, $meta_info['name'] ); ?>
		<textarea id="<?php echo( esc_attr( $meta_id ) ); ?>" name="<?php echo( esc_attr( $meta_id ) ); ?>" rows="5" class="widefat"><?php echo( esc_textarea( adomus_get_current_post_meta( $meta_id ) ) ); ?></textarea>
	</p>
	<?php
}

function adomus_meta_radio( $meta_id, $meta_info ) {
    $meta_bind = '';
    if ( isset( $meta_info['bind'] ) ) {
        $meta_bind = 'checked: ' . str_replace( 'adomus_', '', $meta_id );
    }
    ?>
    <p class="<?php adomus_meta_class( $meta_info ); ?>" data-bind="<?php adomus_meta_visible( $meta_info ); ?>">
        
        <?php 
        adomus_meta_field_label( $meta_id, $meta_info['name'] ); 
        $radio_value = adomus_get_current_post_meta( $meta_id );
        if ( ! $radio_value ) {
            $radio_value = $meta_info['default'];
        }
        foreach ( $meta_info['values'] as $radio_id => $radio_text ) :
            if ( $radio_id == $radio_value ) {
                $checked = 'checked';
            } else {
                $checked = '';
            }
            $radio_full_id = $meta_id . '-' . $radio_id;
        ?>
            <input 
                type="radio" 
                name="<?php echo( esc_attr( $meta_id ) ); ?>" 
                id="<?php echo( esc_attr( $radio_full_id ) ); ?>" 
                value="<?php echo( esc_attr( $radio_id ) ); ?>" 
                data-bind="<?php echo( esc_attr( $meta_bind ) ); ?>"
                <?php echo( esc_html( $checked ) ); ?> 
            />
            <label for="<?php echo( esc_attr( $radio_full_id ) ); ?>"><?php echo( esc_attr( $radio_text ) ); ?></label>&nbsp;&nbsp;
        <?php endforeach; ?>
    </p>
    <?php
}

function adomus_meta_single_img( $meta_id, $meta_info ) {
	adomus_meta_generic_single_media( $meta_id, $meta_info, 'img' );
}

function adomus_meta_single_video( $meta_id, $meta_info ) {
	adomus_meta_generic_single_media( $meta_id, $meta_info, 'video' );
}

function adomus_meta_single_media( $meta_id, $meta_info ) {
	adomus_meta_generic_single_media( $meta_id, $meta_info, 'all' );
}

function adomus_meta_generic_single_media( $meta_id, $meta_info, $media_type ) {
	switch ( $media_type ){
		case 'img' : 
			$add_link_class = 'adomus-add-img'; 
			$add_link_text = esc_html__( 'Add image', 'hotelwp' );
		break;
		case 'video' : 
			$add_link_class = 'adomus-add-video'; 
			$add_link_text = esc_html__( 'Add video', 'hotelwp' );
		break;
		case 'all' : 
			$add_link_class = ''; 
			$add_link_text = esc_html__( 'Add media', 'hotelwp' );
		break;
	}
	$media_id = adomus_get_current_post_meta( $meta_id );	
	?>

    <div class="<?php adomus_meta_class( $meta_info ); ?>" data-bind="<?php adomus_meta_visible( $meta_info ); ?>">
        <p><b><?php echo( esc_html( $meta_info['name'] ) ); ?></b></p>
        <div class="adomus-add-media-wrapper">

            <p class="adomus-add-media-chosen">
                <a href="#" class="adomus-add-media-link <?php echo( esc_attr( $add_link_class ) ); ?>">
                    <?php
                    if ( $media_id ) {
                        $thumb_video_icon = false;
                        if ( wp_attachment_is_image( $media_id ) ) {
                            $thumb_url = aq_resize( wp_get_attachment_url( $media_id ), 200 );
                        } else {
                            $attachment = get_post( $media_id );
                            $video_thumbnail_id = get_post_meta( $attachment->ID, '_thumbnail_id', true );
                            if ( $video_thumbnail_id ) {
                                $image_attributes = wp_get_attachment_image_src( $video_thumbnail_id );
                                $thumb_url = $image_attributes[0];
                            } else {
                                $thumb_video_icon = true;
                                $thumb_url = includes_url() . 'images/media/video.png';
                            }
                        }
                        ?>
                        <img src="<?php echo( esc_url( $thumb_url ) ); ?>" />
                        <?php
                        if ( $thumb_video_icon ) {
                            echo( '<br/>' . esc_html( get_the_title( $media_id ) ) );
                        } 
                    }
                    ?>
                </a>
            </p>

            <p>
                <a href="#" class="adomus-remove-media-link"><?php esc_html_e( 'Remove', 'hotelwp' ); ?></a>
            </p>
            <p>
                <a href="#" class="adomus-add-media-link-text adomus-add-media-link <?php echo( esc_attr( $add_link_class ) ); ?>"><?php echo( esc_html( $add_link_text ) ); ?></a>
            </p>
            <input type="hidden" id="<?php echo( esc_attr( $meta_id ) ); ?>" name="<?php echo( esc_attr( $meta_id ) ); ?>" class="adomus-add-media-input" value="<?php echo( esc_attr( $media_id ) );?>" />

        </div>
    </div>
	
<?php
}

function adomus_meta_multi_imgs( $meta_id, $meta_info ) {
	$images_raw = adomus_get_current_post_meta( $meta_id );
	if ( $images_raw ) {
		$images = explode( ',', $images_raw );
	} else {
		$images = array();
	}
	?>
	<div id="<?php echo( esc_attr( $meta_id ) ); ?>-wrapper" data-sub-type="<?php echo( esc_attr( $meta_info['sub_type'] ) ); ?>" class="adomus-multiple-imgs-select">
		<p>
			<label><b><?php echo( esc_html( $meta_info['name'] ) ); ?></b></label>
		</p>
		<ul>
            <?php
            foreach ( $images as $image_id ) :
                $image_url = wp_get_attachment_url( $image_id );
                if ( $image_url ) :
                    $image_url_resized = aq_resize( $image_url, 200, 100, true, true, true );
                    ?>
                    
                    <li data-id="<?php echo( esc_attr( $image_id ) ); ?>"><img style="cursor: move" src="<?php echo( esc_attr( $image_url_resized ) ); ?>" /></li>
                    
                <?php 
                endif;
            endforeach;
            ?>
        </ul>
		<a href="#" data-meta-id="<?php echo( esc_attr( $meta_id ) ); ?>" class="adomus-select-multiple-imgs">
		    <?php esc_html_e( 'Select images', 'hotelwp' ); ?>
        </a>
        <div>
            <a href="#" data-meta-id="<?php echo( esc_attr( $meta_id ) ); ?>" class="adomus-remove-all-multiple-imgs">
                <?php esc_html_e( 'Remove all images', 'hotelwp' ); ?>
            </a>
        </div>
		<input type="hidden" name="<?php echo( esc_attr( $meta_id ) ); ?>" value="<?php echo( esc_attr( $images_raw ) ); ?>" />
	</div>
	<?php
}

function adomus_gallery_img_mark_up( $image_id ) {
	$image_url = wp_get_attachment_url( $image_id );
	if ( $image_url ) {
		$image_url_resized = aq_resize( $image_url, 200, 100, true, true, true );
		return '<li data-id="' . $image_id . '"><img style="cursor: move" src="' . $image_url_resized . '" /></li>';
	} else {
		return '';
	}
}

function adomus_meta_map_points( $meta_id, $meta_info ) {
    if ( $meta_id == 'adomus_map__0_map_points' ) {
        $points_json = '';
        $points = array(
            array( 
                'lat' => '',
                'lng' => '',
                'caption' => ''
            )
        );
    } else {
        $points_json = adomus_get_current_post_meta( $meta_id );
        $points = json_decode( $points_json, true );
        if ( ! $points ) {
            $points = array(
                array( 
                    'lat' => '',
                    'lng' => '',
                    'caption' => ''
                )
            );
        }
    }
    ?>
    
    <input 
        type="hidden" 
        id="<?php echo( esc_attr( $meta_id) ) ?>" 
        name="<?php echo( esc_attr( $meta_id ) ) ?>" 
        value="<?php echo( esc_attr( $points_json ) ) ?>" 
        class="adomus-map-point-json"
    />
    <div class="adomus-map-points adomus-contact-map-option">
        
    <?php
    $point_attributes = array(
        'lat' => esc_html__( 'Latitude', 'hotelwp' ),
        'lng' => esc_html__( 'Longitude', 'hotelwp' ),
        'caption' => esc_html__( 'Caption', 'hotelwp' ),
    );
    foreach ( $points as $point_nb => $point ) : 
    ?>
    
        <div class="adomus-map-point">
            <p>
                <?php printf( esc_html__( 'Point number %s' ), $point_nb + 1 ); ?>
            </p>
            <?php foreach ( $point_attributes as $point_attr_id => $point_attr_name ) : ?>
            <p>
                <?php 
                adomus_meta_field_label( $meta_id . '_' . $point_attr_id, $point_attr_name ); 
                $map_point_input_class = 'widefat adomus-map-point-' . $point_attr_id;
                ?>
                <input 
                    id="<?php echo( esc_attr( $meta_id . '_' . $point_attr_id ) ); ?>" 
                    name="<?php echo( esc_attr( $meta_id . '_' . $point_attr_id ) ); ?>" 
                    type="text" 
                    class="<?php echo( esc_attr( $map_point_input_class ) ); ?>" 
                    value="<?php echo( esc_attr( $point[ $point_attr_id ] ) ); ?>" 
                />
            </p>
            <?php endforeach; ?>
            <p>
                <a href="#" class="adomus-delete-map-point"><?php esc_html_e( 'Delete point', 'hotelwp' )?></a>
            </p>
        </div>
    
    <?php endforeach; ?>
    
    </div>
    
    <div class="adomus-map-new-point">
        <p>
            <?php printf( esc_html__( 'Point number %s' ), '<span class="adomus-new-point-number"></span>' ); ?>
        </p>
        <?php 
        foreach ( $point_attributes as $point_attr_id => $point_attr_name ) : 
            $map_point_input_class = 'widefat adomus-map-point-' . $point_attr_id;
        ?>
        <p>
            <?php adomus_meta_field_label( $meta_id . '_' . $point_attr_id, $point_attr_name ); ?>
            <input 
                id="<?php echo( esc_attr( $meta_id . '_' . $point_attr_id ) ); ?>" 
                name="<?php echo( esc_attr( $meta_id . '_' . $point_attr_id ) ); ?>" 
                type="text" 
                class="<?php echo( esc_attr( $map_point_input_class ) ); ?>" 
            />
        </p>
        <?php endforeach; ?>
        <p>
            <a href="#" class="adomus-delete-map-point"><?php esc_html_e( 'Delete point', 'hotelwp' )?></a>
        </p>
    </div>
    
    <p class="adomus-contact-map-option">
        <input type="button" class="adomus-add-map-point button" value="<?php esc_html_e( 'Add point', 'hotelwp' ); ?>">
    </p>
    
    <?php
}

function adomus_meta_custom( $meta_id, $meta_info ) {
    ?>
    <p><?php echo( wp_kses_post( $meta_info['custom_content'] ) ); ?></p>
    <?php
}

function adomus_meta_editor( $meta_id, $meta_info ) {
	if ( $meta_id == 'adomus_custom__0_content' ) : 
	?>
	
	<textarea id="adomus_custom__0_content" name="adomus_custom__0_content" style="width: 100%" rows="7" /></textarea>
	
	<?php
	else :
	    $wp_editor_settings = array(
	        'wpautop' => false,
	        'textarea_rows' => 7
	    );
		wp_editor( adomus_get_current_post_meta( $meta_id ), $meta_id, $wp_editor_settings );
	endif;
}