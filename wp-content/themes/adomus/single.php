<?php get_header(); ?>

	<div class="columns-wrapper">
	
		<?php 
        $column_class = 'column-two-thirds';
        if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
            $column_class .= ' blog-no-sidebar';
        }
        ?>
        
		<div class="<?php echo( esc_attr( $column_class ) ); ?>">

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
                
                <hr/>
                
                <div class="the-meta">
                    <p>
                        <?php adomus_post_meta(); ?>
                    </p>
                </div>
                
                <?php
                if ( comments_open() || get_comments_number() ) {
                    comments_template();
                }
                ?>
                
                <hr/>
                
                <?php
                the_post_navigation( 
                    array(
                        'next_text' => esc_html( hotelwp_theme_get_string( 'next_post' ) ) . '&nbsp;&nbsp;%title' . '&nbsp;&nbsp;<i class="fa fa-long-arrow-right"></i>',
                        'prev_text' => '<i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;' . esc_html( hotelwp_theme_get_string( 'previous_post' ) ) . '&nbsp;&nbsp;%title'
                    ) 
                );
                ?>
                
			</div>
			
			<?php
			endwhile;
		endif;
		?>
		
		</div>
		
		<?php if ( is_active_sidebar( 'blog-sidebar' ) ) : ?>
		
        <div class="sidebar column-one-third"><?php dynamic_sidebar( 'blog-sidebar' ); ?></div>

        <?php endif; ?>
		
	</div><!-- end .columns-wrapper -->
	
<?php get_footer(); ?>