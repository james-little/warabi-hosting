<?php

function adomus_get_section_title( $section_id, $followed_by_content = false ) {
	$tagline = adomus_get_current_post_meta( $section_id . '_tagline' );
	$title = adomus_get_current_post_meta( $section_id . '_title' );
	$class = 'section-title';
	if ( $followed_by_content ) {
		$class .= ' section-title-followed-by-content';
	}
	?>
	<div class="<?php echo( esc_attr( $class ) ); ?>">
		<?php if ( $tagline ) : ?><p><?php echo( esc_html( $tagline ) ); ?></p><?php endif; ?>
		<?php if ( $title ) : ?><h2><?php echo( esc_html( $title ) ); ?></h2><?php endif; ?>
	</div>
	<?php
}
	
function hotelwp_section_has_title( $section_id ) {
    if ( adomus_get_current_post_meta( $section_id . '_tagline' ) || adomus_get_current_post_meta( $section_id . '_title' ) ) {
        return true;
    } else {
        return false;
    }
}

function adomus_post_meta() {
	echo( esc_html( hotelwp_theme_get_string( 'post_date' ) ) );
    echo( esc_html( get_the_date() ) );
    echo( '&nbsp;&nbsp;-&nbsp;&nbsp;' );
    echo( esc_html( hotelwp_theme_get_string( 'post_categories' ) ) );
    the_category( ', ' );
    if ( is_single() ) {
        the_tags( '&nbsp;&nbsp;-&nbsp;&nbsp;' . esc_html( hotelwp_theme_get_string( 'post_tags' ) ), ', ' ); 
    }    
}

function adomus_inner_pagination() {
	wp_link_pages( array(
		'before'      => '<hr><div class="clearfix"><p>' . hotelwp_theme_get_string( 'paginated_post_pagination_title' ) . '</p>',
		'after'       => '</div>',
		'link_before' => '<span class="page-numbers">',
		'link_after'  => '</span>',
	) );
}

function adomus_comments_callback( $comment, $args, $depth ) {
    global $post;
	$GLOBALS['comment'] = $comment;
    $comment_class = '';
    if ( $depth > 1 ) {
        $comment_class = 'comment-inner';
    }
    ?>

    <div id="comment-<?php comment_ID(); ?>" <?php comment_class( $comment_class ); ?>>

        <div class="comment-wrapper">
            
            <div class="comment-meta">

                <?php
                $author_link = get_comment_author_url();
                $avatar = get_avatar( $comment, 60 );
                if ( $author_link ) :
                ?>
                <a class="comment-profile" href="<?php echo( $author_link ); ?>"><?php echo( $avatar ); ?></a>
                <?php else : ?>
                <span class="comment-profile"><?php echo( $avatar ); ?></span>
                <?php endif; ?>

                <p class="comment-profile-name"> 
                    <?php comment_author_link(); ?>
                    <?php if ( $post->post_author === $comment->user_id ) : ?>
                    <span class="comment-post-author"><?php echo( esc_html( hotelwp_theme_get_string( 'comment_by_author' ) ) ); ?></span>
                    <?php endif; ?>
                </p>

                <p class="comment-date">
                    <?php 
                    comment_date();
					echo( ' ' );
                    echo( esc_html( hotelwp_theme_get_string( 'comment_date_time_at' ) ) );
					echo( ' ' );
                    comment_time();
                    ?>
                </p>

            </div>
            
            <div class="comment-text"><?php comment_text() ; ?></div>
        
        </div>
        
    <?php
}

function hotelwp_get_logo() {
    $logo = wp_get_attachment_url( get_option( 'hotelwp_site_logo' ) );
	$site_name = get_option( 'blogname' );
    $site_tagline = get_bloginfo( 'description' );
    
    if ( $logo ) :
        
        if ( is_front_page() ) : 
        ?>
        
        <h1 class="logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $site_name ); ?>">
            </a>
        </h1>
        
        <?php else : ?>
        
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
            <img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $site_name ); ?>">
        </a>
        
        <?php 
        endif;

    else :

        if ( is_front_page() ) : 
        ?>
            
            <h1 class="logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo( $site_name ); ?></a>
            </h1>
            
        <?php else : ?>
           
            <a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo( $site_name ) ?></a>
            
        <?php 
        endif;

    endif;
    
    if ( $site_tagline ) :
        ?>
        
        <div class="site-tagline"><p><?php echo( esc_html( $site_tagline ) ); ?></p></div>
        
        <?php
    endif;
}

function hotelwp_ratio_str_2_nbr( $ratio ) {
    if ( strpos( $ratio, '/' ) > 0 ) {
		$ratio_values = explode( '/', $ratio );
		$ratio = $ratio_values[0] / $ratio_values[1];
	}
    if ( is_numeric( $ratio ) ) {
        return $ratio;
    } else {
        return false;
    }
}

function hotelwp_is_displayed_title() {
    if ( 
        adomus_get_current_post_meta( 'display_title' ) != 'no' 
        && 
        adomus_get_current_post_meta( 'hero_type' ) != 'custom_full_screen' 
    ) {
        return true;
    } else {
        return false;
    }
}

function hotelwp_title_pos() {
    $hero_type = adomus_get_current_post_meta( 'hero_type' );
    if ( $hero_type == 'custom' || $hero_type == 'custom_full_screen' ) {
        return 'below_hero';
    }
    $title_pos = adomus_get_current_post_meta( 'title_pos' );
    if ( ! $title_pos || $title_pos == 'default' ) {
        return get_theme_mod( 'default_title_pos', 'inside_hero' );
    } else {
        return $title_pos;
    }
}

function hotelwp_get_post_title() {
    $tagline = '';
    if ( is_archive() ) {
        $title = get_the_archive_title();
        $tagline = strip_tags( get_the_archive_description() );
    } else if ( is_search() ) {
        $title = sprintf( hotelwp_theme_get_string( 'search_page_title' ), get_search_query() );
    } else if ( is_404() ) {
        $title = hotelwp_theme_get_string( '404_page_title' );
    } else if ( is_home() && is_front_page() ) {
        $title = get_bloginfo( 'description' );
    } else {
        $title = single_post_title( '', false );
        $alt_title = adomus_get_current_post_meta( 'alt_title' );
        if ( $alt_title ) {
            $title = $alt_title;
        } else {
            $title = single_post_title( '', false );
        }
        $tagline = adomus_get_current_post_meta( 'tagline' );
    }
    if ( $tagline ) {
        echo( '<p class="tagline">' . esc_html( $tagline ) . '</p>' );
    }
    if ( is_front_page() ) {
        echo( '<p class="title">' . esc_html( $title ) . '</p>' );
    } else {
        echo( '<h1>' . esc_html( $title ) . '</h1>' );
    }
}

add_filter( 'get_the_archive_title', 'hotelwp_get_the_archive_title' );

function hotelwp_get_the_archive_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif ( is_year() ) {
        $title = get_the_date( _x( 'Y', 'yearly archives date format' ) );
    } elseif ( is_month() ) {
        $title = get_the_date( _x( 'F Y', 'monthly archives date format' ) );
    } elseif ( is_day() ) {
        $title = get_the_date( _x( 'F j, Y', 'daily archives date format' ) );
	}
	return $title;
}

function hotelwp_hero_ratio() {
    $aspect_ratio = adomus_get_current_post_meta( 'hero_ratio' );
	$aspect_ratio = hotelwp_ratio_str_2_nbr( $aspect_ratio );
	if ( ! $aspect_ratio ) {
        $aspect_ratio = get_theme_mod( 'default_hero_ratio' );
        if ( ! $aspect_ratio ) {
            $aspect_ratio = 3;
        }
        $aspect_ratio = hotelwp_ratio_str_2_nbr( $aspect_ratio );
    }
	return $aspect_ratio;
}

if ( ! function_exists( 'hotelwp_img_full_width_default' ) ) {
    function hotelwp_img_full_width_default() {
        return 1600;
    }
}

if ( ! function_exists( 'hotelwp_img_full_height_default' ) ) {
    function hotelwp_img_full_height_default() {
        return 900;
    }
}

if ( ! function_exists( 'hotelwp_features_thumb_width' ) ) {
    function hotelwp_features_thumb_width() {
        return 720;
    }
}

if ( ! function_exists( 'hotelwp_features_thumb_height' ) ) {
    function hotelwp_features_thumb_height() {
        return 330;
    }
}

function hotelwp_get_slider_data( $slider_id ) {
    $sliders = json_decode( get_option( 'hotelwp_sliders' ), true );
    if ( $sliders ) {
        foreach( $sliders as $slider ){
            if ( $slider['slideshowId'] == $slider_id ) {
                return $slider;
            }
        }
    }
    return false;
}

if ( ! function_exists( 'adomus_top_header' ) ) {
    function adomus_top_header() {
        if ( is_active_sidebar( 'top-header-left' ) || is_active_sidebar( 'top-header-right' ) ) :
        ?>
        
        <div class="top-header">
			
            <?php if ( is_active_sidebar( 'top-header-left' ) ) : ?>
                <div class="widget-area-top-header-left"><?php dynamic_sidebar( 'top-header-left' ); ?></div>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'top-header-right' ) ) : ?>
                <div class="widget-area-top-header-right"><?php dynamic_sidebar( 'top-header-right' ); ?></div>
            <?php endif; ?>
            
        </div>
        
        <?php 
        endif;
    }
}

function adomus_get_testimonial_images( $testis ) {
?>
    
    <div class="testimonials-images">
		
        <?php foreach ( $testis as $testi ) : ?>

            <div class="testimonial-img background-img" style="background-image: url(<?php echo( esc_url( $testi['img'] ) ); ?>);">
                <div class="testimonial-caption">
                    <?php echo( esc_html( $testi['caption'] ) ); ?>
                    <span class="testimonial-info"><?php echo( esc_html( $testi['info'] ) ); ?></span>
                </div>
            </div>

        <?php endforeach; ?>

    </div>
    
<?php
}

function adomus_get_testimonial_texts( $testi_section_id, $testis, $testi_layout ) {
?>

    <div class="testimonials-wrapper column-has-bottom-border">
		<div class="content-with-padding">
			
		<?php 
		if ( hotelwp_section_has_title( $testi_section_id ) ) {
			adomus_get_section_title( $testi_section_id, true );
		}
		?>

        <?php 
		if ( 
			( adomus_get_current_post_meta( $testi_section_id . '_nav' ) != 'bullets' )
			&& 
			( sizeof( $testis ) > 1 || $testi_layout == 'centered_content' ) 
		) : 
		?>
        
	        <div class="testimonials-nav-thumb">

	            <?php foreach ( $testis as $testi ) : ?>

	            <a href="#" class="testimonial-thumb background-img" style="background-image: url(<?php echo( esc_url( $testi['img'] ) ); ?>)"></a>

	            <?php endforeach; ?>

	        </div>
        
        <?php endif; ?>

            <div class="testimonials-slider">

                <div class="testimonial-container">
                    <div class="testimonial-inner"></div>
                </div>

                <?php foreach ( $testis as $testi ) : ?>

                <div class="testimonial">

                    <p class="testimonial-intro">
                        <?php echo( wp_kses_post( $testi['intro'] ) ); ?>
                    </p>
                    <div class="quote-begin"></div>
                    <p class="testimonial-content">
                        <?php echo( wp_kses_post( $testi['content'] ) ); ?>
                    </p>
                    <div class="quote-end"></div>

					<?php if ( $testi_layout == 'centered_content' ) : ?>
					
					<p class="testimonial-name">
						<?php echo( esc_html( $testi['caption'] ) ); ?><span class="testimonial-info"><?php echo( esc_html( $testi['info'] ) ); ?></span>
					</p>

					<?php endif; ?>

                </div>

                <?php endforeach; ?>

            </div><!-- end .testimonials-slider -->

        <?php if ( adomus_get_current_post_meta( $testi_section_id . '_nav' ) != 'thumbs' ) : ?>
		
	        <div class="testimonials-nav-bullets">

	            <?php for ( $i = 0; $i < count( $testis ); $i++ ) : ?>

	            <a href="#" class="testimonial-bullet"></a>

	            <?php endfor; ?>

	        </div>
        
        <?php endif; ?>
        
		</div><!-- end .content-with-padding -->
    </div><!-- end .testimonials-wrapper -->
    
<?php
}

function adomus_get_sub_section_contact_form( $section_id ) {
	?>
	
	<div class="column-one-half contact-column">
		<div class="content-with-padding">
			<?php 
			$contact_form_title = adomus_get_current_post_meta( $section_id . '_contact_form_title' );
			$contact_form_tagline = adomus_get_current_post_meta( $section_id . '_contact_form_tagline' );
			if ( $contact_form_title || $contact_form_tagline ) :
			?>
			
				<div class="section-title section-title-followed-by-content">
					<?php if ( $contact_form_tagline ) : ?><p><?php echo( esc_html( $contact_form_tagline ) ); ?></p><?php endif; ?>
					<?php if ( $contact_form_title ) : ?><h2><?php echo( esc_html( $contact_form_title ) ); ?></h2><?php endif; ?>
				</div>
				
			<?php 
			endif;
            hotelwp_contact_form_display();
			?>
		</div>
	</div>
	
	<?php
}

function adomus_get_sub_section_contact_form_full_width( $section_id ) {
	?>
	
    <div class="content-with-padding">
        <?php 
        $contact_form_title = adomus_get_current_post_meta( $section_id . '_contact_form_title' );
        $contact_form_tagline = adomus_get_current_post_meta( $section_id . '_contact_form_tagline' );
        if ( $contact_form_title || $contact_form_tagline ) :
        ?>
        
            <div class="section-title section-title-followed-by-content">
                <?php if ( $contact_form_tagline ) : ?><p><?php echo( esc_html( $contact_form_tagline ) ); ?></p><?php endif; ?>
                <?php if ( $contact_form_title ) : ?><h2><?php echo( esc_html( $contact_form_title ) ); ?></h2><?php endif; ?>
            </div>
            
        <?php 
        endif;
        hotelwp_contact_form_display();
        ?>
    </div>
	
	<?php
}

function adomus_get_sub_section_contact_info( $section_id ) {
	?>
	
	<div class="column-one-half contact-column">
		<div class="content-with-padding">
			<?php 
			$contact_info_title = adomus_get_current_post_meta( $section_id . '_contact_info_title' );
			$contact_info_tagline = adomus_get_current_post_meta( $section_id . '_contact_info_tagline' );
			if ( $contact_info_title || $contact_info_tagline ) :
			?>
			
				<div class="section-title section-title-followed-by-content">
					<?php if ( $contact_info_tagline ) : ?><p><?php echo( esc_html( $contact_info_tagline ) ); ?></p><?php endif; ?>
					<?php if ( $contact_info_title ) : ?><h2><?php echo( esc_html( $contact_info_title ) ); ?></h2><?php endif; ?>
				</div>
				
			<?php 
			endif;
			echo( do_shortcode( wp_kses_post( adomus_nl2br( adomus_get_current_post_meta( $section_id . '_contact_info' ) ) ) ) );
			?>
		</div>
	</div>
	
	<?php
}

function adomus_get_sub_section_map( $section_id ) {
	wp_enqueue_script( 'adomus-google-map', 'https://maps.googleapis.com/maps/api/js?key=' . get_theme_mod( 'map_api_key' ), array( 'jquery' ), null, true );
	?>
	
	<div class="map-column">
		<?php adomus_get_map( $section_id ); ?>
	</div>
	<div class="column-one-half desktop-only">&nbsp;</div>
	
	<?php
}

function adomus_get_full_width_map( $section_id ) {
	wp_enqueue_script( 'adomus-google-map', 'https://maps.googleapis.com/maps/api/js?key=' . get_theme_mod( 'map_api_key' ), array( 'jquery' ), null, true );
	?>
	
	<div class="map-full-width">
		<?php adomus_get_map( $section_id ); ?>
	</div>
	
	<?php
}

function adomus_get_map( $map_section_id ) {
	$map_points = adomus_get_current_post_meta( $map_section_id . '_map_points' );
	$map_zoom = adomus_get_current_post_meta( $map_section_id . '_zoom' );
	if ( ! $map_zoom ) {
		$map_zoom = '12';
	}
	$map_type = adomus_get_current_post_meta( $map_section_id . '_type' );
	if ( ! $map_type ) {
		$map_type = 'satellite';
	}
	?>

	<div class="map-canvas" 
        data-map-points="<?php echo( esc_attr( $map_points ) ); ?>" 
        data-zoom="<?php echo( esc_attr( $map_zoom ) ); ?>" 
        data-type="<?php echo( esc_attr( $map_type ) ); ?>">
    </div>

	<?php
}

function adomus_kses_filter_allowed_html( $allowed ) {
    $allowed['a']['data-caption'] = true;
    $allowed['a']['data-width'] = true;
    $allowed['a']['data-height'] = true;
    return $allowed;
}

if ( ! function_exists( 'adomus_nl2br' ) ) {
	function adomus_nl2br( $text ) {
		return nl2br( $text );
	}
}