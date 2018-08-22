<?php
/**
 * Template Name: Page with sidebar
 */
?>

<?php get_header(); ?>

<div class="columns-wrapper">
    
    <?php if ( is_active_sidebar( 'page-sidebar' ) ) : ?>
    <div class="column-two-thirds">
    <?php endif; ?>
    
    <?php 
    if ( have_posts() ) : 
    	while ( have_posts() ) : the_post(); 
    	?>

    	<div <?php post_class( 'content-with-padding' ); ?>>
    	
            <?php if ( hotelwp_is_displayed_title() && ( hotelwp_title_pos() == 'below_hero' ) ) : ?>
            <div class="below-hero-title">
                <?php hotelwp_get_post_title(); ?>
            </div>
            <?php endif; ?>
            
            <div class="the-content">
                <?php the_content(); ?>
            </div>
            
            <?php adomus_inner_pagination(); ?>
                    
            <?php
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }
            ?>
            
        </div>
    	
    	<?php
    	endwhile;
    endif;
    ?>

    <?php if ( is_active_sidebar( 'page-sidebar' ) ) : ?>
    </div>
    <div class="sidebar column-one-third"><?php dynamic_sidebar( 'page-sidebar' ); ?></div>
    <?php endif; ?>
	
</div>

<?php get_footer(); ?>