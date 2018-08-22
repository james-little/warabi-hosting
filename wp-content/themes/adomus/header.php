<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
$post_id = 0;
$template = basename( apply_filters( 'template_include', get_page_template_slug( get_queried_object_id() ) ) );

$hero_class = 'hero';
$hero_full_screen = ( adomus_get_current_post_meta( 'hero_full_screen' ) == 'yes' );

if ( $hero_full_screen ) {
    $hero_class .= ' hero-full-screen hero-no-padding';
}

$hero_type = adomus_get_current_post_meta( 'hero_type' );

$hero_scroll_arrow = ( adomus_get_current_post_meta( 'display_scroll_arrow' ) == 'yes' && $template == 'template-advanced-layout.php' );

if ( adomus_get_current_post_meta( 'booking_form_style_hero' ) == 'vertical' ) {
    if ( adomus_get_current_post_meta( 'booking_form_horizontal_pos_hero' ) == 'right_hero' ) {
        $hero_class .= ' hero-caption-left-on-wide-screen';
    } else {
        $hero_class .= ' hero-caption-right-on-wide-screen';
    }
}

$hero_img_id = 0;
if ( is_single() || is_page() || is_home() ) {
	$post_id = get_queried_object_id();
    $hero_img_id = adomus_get_current_post_meta( 'hero_alt_image' );
    if ( ! $hero_img_id ) {
        $hero_img_id = get_post_thumbnail_id( $post_id );
    }
}
if ( ! $hero_img_id ) {
	$hero_img_id = get_theme_mod( 'hero_img' );
}

$hero_img_url = '';
if ( $hero_img_id ) {
	$hero_img_url = wp_get_attachment_url( $hero_img_id );
	$hero_img_alt = get_post_meta( $hero_img_id, '_wp_attachment_image_alt', true );
}

$default_img_width = hotelwp_img_full_width_default();
if ( $hero_full_screen ) {
    $default_img_height = hotelwp_img_full_height_default();
} else {
    $default_img_height = (int) ( $default_img_width / hotelwp_hero_ratio() );
}

if ( $hero_type == 'video' ) {

	$video_id = adomus_get_current_post_meta( 'hero_youtube_video_id' );
	if ( get_post( $video_id ) ) {
		$hero_type = 'video-self-hosted';
        $video_url = wp_get_attachment_url( $video_id );
        $video_data = wp_get_attachment_metadata( $video_id );
        $attachment = get_post( $video_id );
        $video_thumbnail_id = get_post_meta( $attachment->ID, '_thumbnail_id', true );
        $image_attributes = wp_get_attachment_image_src( $video_thumbnail_id );
	} else {
		$hero_type = 'video-youtube';
        $video_id = adomus_get_current_post_meta( 'hero_youtube_video_id' );
        $video_ratio = adomus_get_current_post_meta( 'hero_youtube_video_ratio' );
        $video_ratio = hotelwp_ratio_str_2_nbr( $video_ratio );
        if ( ! $video_ratio ) {
            $video_ratio = '1.78';
        }
        $video_ratio_width = (int) ( 100 * $video_ratio );
        $video_ratio_height = 100;
        $video_start = adomus_get_current_post_meta( 'hero_youtube_video_start');
        if ( ! $video_start ) {
            $video_start = '0';
        }
	}

} else if ( $hero_type == 'slider' ) {

    $slider = hotelwp_get_slider_data( adomus_get_current_post_meta( 'hero_slider' ) );

} else if ( $hero_type == 'custom' ) {

    $hero_class .= ' hero-custom';

} else {
    
    if ( $hero_img_url ) {
        $hero_type = 'image';
    } else {
        $hero_type = '';
    }
    
}

if ( get_theme_mod( 'header_background_opacity', '0' ) == 0 ) {
	$hero_class .= ' header-no-bg';
}
?>
	
<div class="<?php echo( esc_attr( $hero_class ) ); ?>">
	
    <?php if ( $hero_type != 'custom' ) : ?>
    <div class="hero-media-wrapper" data-hero-ratio="<?php echo( round( $default_img_width / $default_img_height, 3 ) ); ?>">
    <?php endif; ?>
    
    <?php if ( $hero_img_url && ( $hero_type == 'image' || $hero_type == 'video-youtube' || $hero_type == 'video-self-hosted' ) ) : ?>
        <img 
            class="hero-img" 
            data-native-width="<?php echo( esc_attr( $default_img_width ) ); ?>" 
            data-native-height="<?php echo( esc_attr( $default_img_height ) ); ?>" 
            src="<?php echo( esc_url( aq_resize( $hero_img_url, $default_img_width, $default_img_height, true, true, true ) ) ); ?>" 
            alt="<?php echo( esc_attr( $hero_img_alt ) ); ?>" 
        />
    <?php endif; ?>

    <?php if ( $hero_type == 'video-youtube' ) : ?>
        
        <div 
            id="hero-youtube-video-player" 
            class="hero-youtube-video-player" 
            data-video-id="<?php echo( esc_attr( $video_id ) ); ?>" 
            data-native-width="<?php echo( esc_attr( $video_ratio_width ) ); ?>"
            data-native-height="<?php echo( esc_attr( $video_ratio_height ) ); ?>"
            data-start="<?php echo( esc_attr( $video_start ) ); ?>"
        >
        </div>
        
    <?php elseif ( $hero_type == 'video-self-hosted' ) : ?>

        <video data-native-width="<?php echo( esc_attr( $video_data['width'] ) ); ?>" data-native-height="<?php echo( esc_attr( $video_data['height'] ) ); ?>" preload="auto" loop muted autoplay >
            <source src="<?php echo( esc_url( $video_url ) ); ?>" type="<?php echo( esc_attr( $attachment->post_mime_type ) ); ?>" />
            <?php if ( $image_attributes ) : ?>
            <img src="<?php echo( esc_url( $image_attributes[0] ) ); ?>"' title="<?php esc_html_e( 'Your browser does not support the &lt;video&gt; tag', 'hotelwp' ) ?> "'/>
            <?php else : ?>
            <?php esc_html_e( 'Your browser does not support the &lt;video&gt; tag', 'hotelwp' ); ?>
            <?php endif; ?>
        </video>
        
    <?php elseif ( $hero_type == 'slider' ) : ?>
    
        <div class="hero-slider" 
           data-transition="<?php echo( esc_attr( $slider['transitionStyle'] ) ); ?>" 
           data-autoplay-speed="<?php echo( esc_attr( $slider['slideDuration'] ) ); ?>"
           data-speed="<?php echo( esc_attr( $slider['transitionDuration'] ) ); ?>" 
           data-autoplay="<?php echo( esc_attr( $slider['autoplay'] ) ); ?>" 
        >

        <?php 
        if ( $slider ) :
            foreach ( $slider['slides'] as $slide ) : 
                $slide_img_url = wp_get_attachment_url( $slide['mediaId'] );
                $slide_img_url = aq_resize( $slide_img_url, $default_img_width, $default_img_height, true, true, true );
                $slide_img_alt = get_post_meta( $slide['mediaId'], '_wp_attachment_image_alt', true );
                ?>

                    <div class="hero-slide-wrapper">
                        <img 
                            data-native-width="<?php echo( esc_attr( $default_img_width ) ); ?>"
                            data-native-height="<?php echo( esc_attr( $default_img_height ) ); ?>"
                            class="hero-img"
                            src="<?php echo( esc_attr( $slide_img_url ) ); ?>" 
                            alt="<?php echo( esc_attr( $slide_img_alt ) ); ?>" 
                        />
                        <?php if ( isset( $slide['caption'] ) ) : ?>
                        <div class="hero-overlay"></div>
                        <div class="hero-caption">
                            <p class="title">
                            <?php echo( wp_kses_post( $slide['caption'] ) ); ?>
                            </p>
                        </div>
                        <?php endif; ?>
                        
                    </div>

            <?php 
            endforeach; 
        endif;	
        ?>

        </div><!-- end .hero-slider -->
    
    <?php elseif ( $hero_type == 'custom' ) : ?>

        <?php echo( do_shortcode( wp_kses_post( adomus_get_current_post_meta( 'hero_shortcode' ) ) ) ); ?>

    <?php endif; ?>
    
    <?php if ( $hero_type == 'image' || $hero_type == 'video-self-hosted' || $hero_type == 'video-youtube' ) : ?>
    <div class="hero-overlay"></div>
    <?php endif; ?>
    
    <?php if ( $hero_type != 'custom' ) : ?>
    </div><!-- end .hero-media-wrapper -->
    <?php endif; ?>
    
    <?php adomus_top_header(); ?>

    <header>

        <?php 
        hotelwp_get_logo();
        wp_nav_menu( array( 'container' => false, 'theme_location' => 'adomus_menu', 'menu_class' => 'main-menu' ) ); 
        ?>

        <a class="mobile-menu-trigger" href="#"><i class="fa fa-reorder"></i></a>

    </header>
    
    <?php if ( hotelwp_is_displayed_title() && ( hotelwp_title_pos() == 'inside_hero' ) ) : ?>
    
        <div class="hero-caption"><?php hotelwp_get_post_title(); ?></div>

    <?php endif; ?>
    
    <?php if ( $hero_scroll_arrow ) : 
		$scroll_text = adomus_get_current_post_meta( 'scroll_text' );
		?>
            
        <div class="hero-scroll">
			<?php if ( $scroll_text ) : ?>
            <div class="hero-scroll-text"><?php echo( esc_html( $scroll_text ) ); ?></div>
			<?php endif; ?>
            <a href="#" class="hero-scroll-link"><i class="fa fa-angle-down"></i></a>
        </div>
            
    <?php endif; ?>
	
	<?php do_action( 'adomus_end_hero', $post_id ); ?>
	
</div><!-- end .hero -->
	
<?php
if ( adomus_get_current_post_meta( 'display_booking_form' ) == 'yes' && $template == 'template-advanced-layout.php' ) : 
    $booking_form_class = 'hero-booking-form';
    if ( adomus_get_current_post_meta( 'booking_form_pos' ) == 'below_hero' ) {
        $booking_form_class .= ' hero-booking-form-always-below-hero';
    } else if ( adomus_get_current_post_meta( 'booking_form_pos' ) == 'always_inside_hero' ) {
        $booking_form_class .= ' hero-booking-form-always-inside-hero';
    }
    if ( adomus_get_current_post_meta( 'booking_form_style_hero' ) == 'vertical' ) {
        $booking_form_class .= ' hero-booking-form-vertical-on-wide-screen';
        if ( adomus_get_current_post_meta( 'booking_form_horizontal_pos_hero' ) == 'right_hero' ) {
            $booking_form_class .= ' hero-booking-form-right-on-wide-screen';
        } else {
            $booking_form_class .= ' hero-booking-form-left-on-wide-screen';
        }
        if ( adomus_get_current_post_meta( 'booking_form_vertical_pos_hero_narrow_screen' ) == 'top_hero' ) {
            $booking_form_class .= ' hero-booking-form-pos-top-hero-on-narrow-screen';
        }
    } else {
        if ( adomus_get_current_post_meta( 'booking_form_vertical_pos_hero' ) == 'top_hero' ) {
            $booking_form_class .= ' hero-booking-form-pos-top-hero';
        }
    }
    ?>
            
<div class="<?php echo( esc_attr( $booking_form_class ) ); ?>">
    <?php 
    $booking_page_id = adomus_get_current_post_meta( 'booking_page_id' );
    $booking_custom_shortcode = adomus_get_current_post_meta( 'booking_custom_shortcode' );
    if ( $booking_page_id ) :
        $redirection_url = get_permalink( $booking_page_id );
        echo( do_shortcode( '[hb_booking_form form_id="hero-search-form" search_form_placeholder="yes" search_only="yes" redirection_url="' . $redirection_url . '"]' ) ); 
    elseif ( $booking_custom_shortcode ) :
        echo( do_shortcode( $booking_custom_shortcode ) ); 
    else :
    ?>
      
    <span class="hero-booking-form-no-id"><?php esc_html_e( 'Please insert the booking page id in the Booking form option or insert a custom shortcode.', 'hotelwp' ); ?></span>
    
    <?php endif; ?>
    
</div><!-- end .hero-booking-form -->

<?php endif; ?>
	
<div class="main-wrapper">