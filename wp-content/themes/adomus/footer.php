	<?php 
	if ( adomus_get_current_post_meta( 'display_footer' ) != 'no' ) :
		if ( get_theme_mod( 'footer_text_color', 'footer_dark_text' ) == 'footer_light_text' ) {
			$footer_class = 'footer-light-text';
		} else {
			$footer_class = 'footer-dark-text';
		}
		?>
		
	<footer class="<?php echo( esc_attr( $footer_class ) ); ?>">
		
        <?php 
        $nb_footer_widgets = 0;
        for ( $i = 1; $i <= 4; $i++ ) { 
            if ( is_active_sidebar( 'footer-' . $i ) ) {
                $nb_footer_widgets++;
            }
        }
        
        if ( $nb_footer_widgets == 3 ) {
            $footer_column_class = 'column-one-third';
			$footer_class = 'main-footer footer-three-columns';
        } else {
            $footer_column_class = 'column-one-fourth';
			$footer_class = 'main-footer footer-four-columns';
        }
        
        if ( $nb_footer_widgets ) :
        ?>
        
		<div class="<?php echo( esc_attr( $footer_class ) ); ?>">
			<div class="columns-wrapper">
			
			<?php 
			for ( $i = 1; $i <= 4; $i++ ) : 
				if ( is_active_sidebar( 'footer-' . $i ) ) :
				?>
				
				<div class="footer-vertical-border footer-vertical-border-<?php echo( $i ); ?>"></div>
				<div class="<?php echo( esc_attr( $footer_column_class ) ); ?>">
					<div class="content-with-padding">
                		<?php dynamic_sidebar( 'footer-' . $i ); ?>
					</div>
				</div>
				
				<?php 
				endif;
			endfor; 
			?>
		
			</div>
		</div>
        
        <?php endif; ?>
        
		<div class="sub-footer">
		
			<div class="copyright">
				<?php 
                $copyright_text = get_theme_mod( 'bottom_footer_text' );
                if ( ! $copyright_text ) {
                    $copyright_text = '&copy; ' . date('Y') . ' '. get_bloginfo( 'name' );
                }
                echo( wp_kses_post( $copyright_text ) ); 
				if ( get_theme_mod( 'display_design_by_hotelwp' ) != 'no' ) {
					echo( ' - Website designed by <a href="https://hotelwp.com/">HotelWP</a>' );
				}
                ?>
			</div>
			
			<?php
			$social_websites = adomus_social_websites();
			$has_social_website = false;
			foreach ( $social_websites as $social_website ) {
				if ( get_theme_mod( $social_website ) ) {
					$has_social_website = true;
					break;
				}
			}
				
			if ( $has_social_website ) : 
			?>
				
			<div class="social">
				
				<?php 
				$social_websites = adomus_social_websites();
				foreach ( $social_websites as $social_website ) :
					if ( get_theme_mod( $social_website ) ) :
				?>
						<a target="_blank" class="social-link <?php echo( esc_attr( $social_website ) ); ?>-button" href="<?php echo( esc_url( get_theme_mod( $social_website ) ) ); ?>"></a>
				<?php 
					endif;
				endforeach;
				?>
			</div>
			
			<?php endif; ?>
		
		</div>
	
	</footer>

    <?php endif; ?>
    
</div><!-- end .main-wrapper -->

<div class="mobile-menu">
	<ul></ul>
	<a class="menu-close" href="#"><i class="fa fa-times"></i></a>
</div>

<?php wp_footer(); ?>

</body>
</html>