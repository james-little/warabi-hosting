<?php

function adomus_meta_box_page_sections_display() {
    $available_sections = array(
        'pages' => esc_html__( 'Pages', 'hotelwp' ),
        'accom'	=> esc_html__( 'Accommodation', 'hotelwp' ),
        'testi'	=> esc_html__( 'Testimonials', 'hotelwp' ),
        'posts' => esc_html__( 'Posts', 'hotelwp' ),
        'video'	=> esc_html__( 'Video', 'hotelwp' ),
        'fancy_slider' => esc_html__( 'Slider / Text / Owner image', 'hotelwp' ),
        'text_img' => esc_html__( 'Text / Image', 'hotelwp' ),
        'gallery' => esc_html__( 'Gallery', 'hotelwp' ),
        'cta' => esc_html__( 'Call to Action', 'hotelwp' ),
        'map_contact' => esc_html__( 'Map / Contact', 'hotelwp' ),
        'custom' => esc_html__( 'Custom Content', 'hotelwp' ),
        'editor' => esc_html__( 'Editor Content', 'hotelwp' ),
    );
    $page_sections = adomus_get_current_post_meta( 'organizer' );
    ?>
    
    <input id="adomus-sections-organizer-input" name="adomus_organizer" type="hidden" value="<?php echo( esc_attr( $page_sections ) ); ?>">
    
    <label for="adomus-add-section-type"><b><?php esc_html_e( 'Add a section:', 'hotelwp' ); ?></b></label>
    <select id="adomus-add-section-type">
        <option value=""><?php esc_html_e( 'Select section type', 'hotelwp' ); ?></option>
        <?php foreach ( $available_sections as $section_type => $section_name ) : ?>
        <option value="<?php echo( esc_html( $section_type ) ); ?>"><?php echo( esc_html( $section_name ) ); ?></option>
        <?php endforeach; ?>
    </select>
    &nbsp;
    <input id="adomus-add-section" type="button" class="button" value="<?php esc_html_e( 'Add section', 'hotelwp' ); ?>">
    
    <ul id="adomus-sections-organizer">
        
        <?php
        if ( $page_sections ) {
            $page_sections = explode( ',', $page_sections );
            foreach ( $page_sections as $section ) {
                $section = explode( '__', $section );
                $section_type = $section[0];
                $section_title = $available_sections[ $section_type ];
                $section_num = $section[1];
                adomus_admin_section_display( $section_type, $section_title, $section_num );
            }
        }
        ?>
    
    </ul>

    <ul id="adomus-section-creator">
        
        <?php
        foreach ( $available_sections as $section_type => $section_title ) {
            adomus_admin_section_display( $section_type, $section_title );
        }
        ?>
        
    </ul>
    
    <?php
}

function adomus_admin_section_display( $section_type, $section_title, $section_num = 0 ) {
    $sections_meta_fields = adomus_section_meta_fields();
    $section_id = $section_type . '__' . $section_num;
    $section_class = 'adomus-section';
    $section_state = adomus_get_current_post_meta( $section_id . '_section_editor_state' );
    if ( $section_state == 'closed' ) {
        $section_class .= ' adomus-section-closed';
    } else {
        $section_class .= ' adomus-section-opened';
    }
    $section_class .= ' adomus-section-' . $section_type;
    ?>
    
    <li 
        class="<?php echo( esc_attr( $section_class ) ); ?>" 
        data-type="<?php echo ( esc_attr( $section_type ) ); ?>" 
        data-num="<?php echo ( esc_attr( $section_num ) ); ?>"
        data-id="<?php echo ( esc_attr( $section_id ) ); ?>"
    >
        <span class="adomus-section-title">
            <?php echo( esc_html( $section_title ) ); ?>
            <a href="#" class="adomus-section-open dashicons dashicons-arrow-down"></a>
            <a href="#" class="adomus-section-close dashicons dashicons-arrow-up"></a>
        </span>
        <div class="adomus-section-actions">
            <a class="adomus-section-delete" href="#"><?php esc_html_e( 'Delete section', 'hotelwp' ); ?></a>
             | 
            <a class="adomus-section-close" href="#"><?php esc_html_e( 'Close section', 'hotelwp' ); ?></a>
        </div>
        <div class="adomus-section-fields">
            <?php 
            foreach ( $sections_meta_fields[ $section_type ] as $meta_id => $meta ) {
                $field_function = 'adomus_meta_' . $meta['type'];
                $meta_id = 'adomus_' . $section_id . '_' . $meta_id;
                $field_function( $meta_id, $meta );
            }
            ?>
        </div>
        <div class="adomus-section-actions">
            <a class="adomus-section-delete" href="#"><?php esc_html_e( 'Delete section', 'hotelwp' ); ?></a>
             | 
            <a class="adomus-section-close" href="#"><?php esc_html_e( 'Close section', 'hotelwp' ); ?></a>
        </div>
    </li>
    
    <?php
}