<?php

add_action( 'wp_head', 'adomus_hero_css' );

function adomus_hero_css() {
    $aspect_ratio = hotelwp_hero_ratio();
    $aspect_ratio_percent = round( 100 / $aspect_ratio, 2 );
	$min_height = adomus_get_current_post_meta( 'hero_min_height' );
    if ( ! $min_height ) {
        $min_height = get_theme_mod( 'hero_default_min_height' );
    }
	if ( $min_height ) {
		$small_hero_max_width = (int)( $min_height * $aspect_ratio );
	}
	$max_height = adomus_get_current_post_meta( 'hero_max_height' );
    if ( ! $max_height ) {
        $max_height = get_theme_mod( 'hero_default_max_height' );
    }
	if ( $max_height ) {
		$big_hero_min_width = (int)( $max_height * $aspect_ratio );
	}
    ?>

<style type="text/css">
.hero {
    padding-bottom: <?php echo( esc_html( $aspect_ratio_percent ) ); ?>%;
}
</style>
       
    <?php
	if ( $min_height ) :
	?>
	
<style type="text/css">
@media only screen and (max-width: <?php echo( esc_html( $small_hero_max_width ) ); ?>px) {
    .hero {
        height: <?php echo( esc_html( $min_height ) ); ?>px;
        padding-bottom: 0;
    }
}
</style>

	<?php
	endif;
	if ( $max_height ) :
	?>
	
<style type="text/css">
@media only screen and (min-width: <?php echo( esc_html( $big_hero_min_width ) ); ?>px) {
    .hero {
        height: <?php echo( esc_html( $max_height ) ); ?>px;
        padding-bottom: 0;
    }
}
</style>

	<?php
	endif;
}