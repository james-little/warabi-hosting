<?php get_header(); ?>

	<div class="columns-wrapper">
	
	    <?php 
        $column_news_class = 'column-two-thirds';
        if ( is_active_sidebar( 'blog-sidebar' ) ) {
            $column_news_class .= ' blog-has-sidebar';
        } else {
            $column_news_class .= ' blog-no-sidebar';
        }
        ?>
        
		<div class="<?php echo( esc_attr( $column_news_class ) ); ?>">

        <?php if ( hotelwp_is_displayed_title() && ( hotelwp_title_pos() == 'below_hero' ) ) : ?>
            
            <div class="content-with-padding news-title-below-hero">
                <div class="below-hero-title">
                    <?php hotelwp_get_post_title(); ?>
                </div>
            </div>
            
        <?php endif; ?>
        
        
		<?php 
		if ( have_posts() ) : 
			while ( have_posts() ) : the_post(); 
			?>
		
			<div <?php post_class( 'blog-news' ); ?>>
			
				<?php
				if ( has_post_thumbnail() ) :
					$thumbnail_url = wp_get_attachment_url( get_post_thumbnail_id() );
					$thumbnail_url_resized = aq_resize( $thumbnail_url, 930, 310, true, true, true ); 
					$alt = get_post_meta(  get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
					?>
					<div class="news-thumbnail">
						<a href="<?php the_permalink(); ?>">
							<img src="<?php echo( esc_url( $thumbnail_url_resized ) ); ?>" alt="<?php echo( esc_attr( $alt ) ); ?>" />
						</a>
					</div>
				<?php
				endif;
				?>
				
				<div class="content-with-padding">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<p>
						<?php the_excerpt(); ?>
					</p>
					<p class="news-more">
						<a href="<?php the_permalink(); ?>"><?php echo( esc_html( hotelwp_theme_get_string( 'read_more' ) ) ); ?><i class="fa fa-long-arrow-right"></i></a>
					</p>
                    <p class="news-meta">
						<?php adomus_post_meta(); ?>
					</p>
                </div>
                
			</div>
			            
			<?php
			endwhile;

            $pagination = get_the_posts_pagination( array(
                'prev_text' => '&#8249;',
                'next_text' => '&#8250;',
            ));
            if ( $pagination ) :
            ?>
                <div class="blog-pagination content-with-padding clearfix">
                    <?php echo( wp_kses_post( $pagination ) ); ?>
                </div>
            <?php
            endif;

        else :
        ?>
            
            <div class="content-with-padding">
                
                <?php if ( is_search() ) : ?>

                    <p><?php echo( esc_html( hotelwp_theme_get_string( 'search_page_no_results' ) ) ); ?></p>
                    <br/>
                    <?php get_search_form(); ?>

                <?php else : ?>

					<p><?php echo( esc_html( hotelwp_theme_get_string( '404_page_text' ) ) ); ?></p>
                    <br/>
                    <?php get_search_form(); ?>
                
                <?php endif; ?>
                
            </div>
            
        <?php endif; ?>
		
		</div>
		
		<?php if ( is_active_sidebar( 'blog-sidebar' ) ) : ?>
		
        <div class="sidebar column-one-third"><?php dynamic_sidebar( 'blog-sidebar' ); ?></div>

        <?php endif; ?>
        
	</div><!-- end .columns-wrapper -->
	
<?php get_footer(); ?>