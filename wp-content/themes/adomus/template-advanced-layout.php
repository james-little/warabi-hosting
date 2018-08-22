<?php
/**
 * Template Name: Advanced layout Template
 */
?>

<?php get_header(); ?>

<?php 
if ( have_posts() ) : 
	while ( have_posts() ) : the_post(); 
        
        if ( hotelwp_is_displayed_title() && ( hotelwp_title_pos() == 'below_hero' ) ) :
        ?>
        
        <div class="row below-hero-title row-has-bottom-border">
		    <div class="content-with-padding">
				
            	<?php hotelwp_get_post_title(); ?>
            
			</div>
	    </div>
        
        <?php
        endif;

        $sections = adomus_get_current_post_meta( 'organizer' );
		if ( $sections ) {
	        $sections = explode( ',', $sections );
	        foreach ( $sections as $section_id ) {
				$section_type = substr( $section_id, 0, strpos( $section_id, '__' ) );
                $display_function = 'adomus_get_section_' . $section_type;
				if ( function_exists( $display_function) ) {
                	$display_function( $section_id );
				}
	        }
		}
		
	endwhile;
endif;
?>
	
<?php get_footer(); ?>