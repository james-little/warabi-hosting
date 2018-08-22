<?php

function adomus_get_section_fancy_slider( $fancy_slider_section_id ) {
    $row_classes = 'row fancy-slider-row row-has-bottom-border columns-wrapper';
    $owner_img = adomus_get_current_post_meta( $fancy_slider_section_id . '_static_img' );
    $slider_imgs = adomus_get_current_post_meta( $fancy_slider_section_id . '_slider_imgs' );
    if ( $owner_img ) {
        $row_has_owner_img = true;
        $owner_img_url = wp_get_attachment_url( $owner_img ); 
        $owner_img_alt = get_post_meta( $owner_img, '_wp_attachment_image_alt', true );
        if ( $slider_imgs ) {
            $row_classes .= ' row-has-owner-img';
        } else {
            $row_classes .= ' row-has-owner-img-only';
        }
    } else {
        $row_has_owner_img = false;
        $row_classes .= ' row-has-no-owner-img';
        if ( ! $slider_imgs ) {
            $row_classes .= ' row-has-no-owner-slider';
        }
    }
	?>
	
	<div class="<?php echo( esc_attr( $row_classes ) ); ?>">
		
		<div class="owner-content">
			<div class="content-with-padding">
				<?php adomus_get_section_title( $fancy_slider_section_id, true ); ?>
				<p>
					<?php echo( wp_kses_post( adomus_nl2br( adomus_get_current_post_meta( $fancy_slider_section_id . '_desc' ) ) ) ); ?>
				</p>
			</div>
		</div>
		
		<?php if ( $row_has_owner_img ) : ?>
            		
			<div class="owner-img-wrapper"><img src="<?php echo( esc_url( $owner_img_url ) ); ?>" alt="<?php echo( esc_attr( $owner_img_alt ) ); ?>" /></div>
			
        <?php endif; ?>
		
		<?php
		$img = adomus_get_current_post_meta( $fancy_slider_section_id . '_static_mobile_img', true );
		if ( $img ) :
			$img_url = wp_get_attachment_url( $img ); 
			$img_alt = get_post_meta( $img, '_wp_attachment_image_alt', true );
			?>
			
			<img class="owner-mobile-img" src="<?php echo( esc_url( $img_url ) ); ?>" alt="<?php echo( esc_attr( $img_alt ) ); ?>" />
			
			<?php
		endif;
		?>
		
		<?php
		if ( $slider_imgs ) :
            $owner_slider_autoplay = intval( adomus_get_current_post_meta( $fancy_slider_section_id . '_slider_autoplay' ), 10 );
		?>
		
		<div class="owner-slider" data-autoplay="<?php echo( esc_attr( $owner_slider_autoplay ) ); ?>">
			<div class="owner-slider-inner">
				
				<?php
				$slider_imgs = explode( ',', $slider_imgs );
				foreach ( $slider_imgs as $img_num => $img ) :
					$img_url = aq_resize( wp_get_attachment_url( $img ), 1000, 750, true, true, true );
					$img_post = get_post( $img );
					$img_caption = $img_post->post_excerpt;
					$caption_mark_up = '';
					if ( $img_caption ) {
						$caption_mark_up = '<div class="owner-slide-caption">' . $img_caption . '</div>';
					}
					$slide_class = '';
					if ( $img_num == 0 ) {
						$slide_class = 'owner-slide-current';
					} else if ( $img_num == 1 ) {
						$slide_class = 'owner-slide-next';
					} else if ( $img_num == count( $slider_imgs ) - 1 ) {
						$slide_class = 'owner-slide-previous';
					}
                    $slide_class .= ' owner-slide background-img';
				?>
				
				<div class="<?php echo( esc_attr( $slide_class ) ); ?>" style="background-image: url(<?php echo( esc_url( $img_url ) ); ?>);"><?php echo( wp_kses_post( $caption_mark_up ) ); ?></div>
				
				<?php endforeach; ?>
				
				<a href="#" class="owner-slide-overlay"></a>
				<a href="#" class="owner-slider-to-left">
					<i class="fa fa-angle-left"></i>
				</a>
				<a href="#" class="owner-slider-to-right">
					<i class="fa fa-angle-right"></i>
				</a>
			</div>
		</div>
		
		<?php endif; ?>
		
	</div>
	
	<?php
}

function adomus_get_section_text_img( $section_id ) {
	$row_class = 'row row-txt-img columns-wrapper';
	$layout = adomus_get_current_post_meta( $section_id . '_layout' );
	$img_id = adomus_get_current_post_meta( $section_id . '_img' );
	$img_url = aq_resize( wp_get_attachment_url( $img_id ), 800, null, true, true, true );
	$img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
	if ( $layout == 'text_right' ) {
		$row_class .= ' row-txt-img-txt-right';
	}
	?>
	
	<div class="<?php echo( esc_attr( $row_class ) ); ?>">
		
	<?php if ( $layout == 'text_right' ) : ?>
		<div class="column-one-half desktop-only">&nbsp;</div>
	<?php endif; ?>

		<div class="column-one-half column-has-bottom-border">
			<div class="content-with-padding">
			
			<?php adomus_get_section_title( $section_id, true ); ?>
			
			<p class="mobile-only">
				<img class="full-width-img" src="<?php echo( esc_url( $img_url ) ); ?>" alt="<?php echo( esc_attr( $img_alt ) ) ?>" />
			</p>
			
			<p>
				<?php echo( wp_kses_post( adomus_nl2br( adomus_get_current_post_meta( $section_id . '_desc' ) ) ) ); ?>
			</p>
			
			</div>
		</div>
		
		<div class="column-txt-img-img background-img" style="background-image:url(<?php echo( esc_url( $img_url ) ); ?>)"></div>
	
	</div>

	<?php
}

function adomus_get_section_pages( $pages_section_id ) {
    $current_page_id = get_the_ID();
    $row_has_title = hotelwp_section_has_title( $pages_section_id );
    ?>
    
    <?php if ( $row_has_title ) : ?>
	
    <div class="row features-title-row row-has-bottom-border">
    	<div class="content-with-padding">
    		<?php adomus_get_section_title( $pages_section_id ); ?>
    	</div>
    </div>
	
	<?php 
    endif; 
    $page_ids = adomus_get_current_post_meta( $pages_section_id . '_ids' );
    if ( ! $page_ids ) {
        return;
    }
    $args = array( 
        'include' => $page_ids,
        'orderby' => 'post__in',
        'post_type' => 'any',
    );
    $featured_pages = get_posts( $args );
    if ( count( $featured_pages ) < 2 ) {
        return;
    }
     
    $pages_row_classes = 'row featured-pages-row row-has-bottom-border columns-wrapper';
    if ( $row_has_title ) {
        $pages_row_classes .= ' featured-pages-row-has-title';
    }
    $thumb_link_type = adomus_get_current_post_meta( $pages_section_id . '_thumb_link' );
    if  ( $thumb_link_type == 'full_size_img_gallery' ) {
        $pages_row_classes .= ' gallery-wrapper';
    }
    if ( count( $featured_pages ) % 3 == 0 ) {
        $column_width = 'column-one-third';
        $features_row_class_nb_columns = 'featured-pages-row-three-columns';
        $nb_posts_in_row = 3;
    } else {
        $column_width = 'column-one-half';
        $features_row_class_nb_columns = 'featured-pages-row-two-columns';
        $nb_posts_in_row = 2;
    }
    
    global $post;
    $counter_nb_posts_in_row = 0;
    $thumb_width = 0;
    foreach ( $featured_pages as $counter => $post ) :
        if ( ( count( $featured_pages ) - $counter ) % 3 == 0 && ( $counter % 2 == 0  ) ) {
            $column_width = 'column-one-third';
            $features_row_class_nb_columns = 'featured-pages-row-three-columns';
            $nb_posts_in_row = 3;
        }
        if ( $counter_nb_posts_in_row == 0 ) :
        ?>

        <div class="<?php echo( esc_attr( $pages_row_classes . ' ' . $features_row_class_nb_columns ) ); ?>">
            
        <?php
        endif;
        $counter_nb_posts_in_row++;
        setup_postdata( $post );
        $thumb_id = get_post_thumbnail_id();
        if ( $thumb_id ) {
            if ( ! $thumb_width ) {
                $thumb_width = hotelwp_features_thumb_width();
                $thumb_height = hotelwp_features_thumb_height();
            }
            $thumb_url = aq_resize( wp_get_attachment_url( $thumb_id ), $thumb_width, $thumb_height, true, true, true );
            $thumb_alt = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
            $page_thumbnail = '<p class="featured-pages-row-img-wrapper">';
            $page_thumbnail_img = '<img src="' . $thumb_url . '" alt="' . $thumb_alt . '" />';
            if ( $thumb_link_type == 'page' ) {
                $page_thumbnail .= '<a href="' . get_permalink() . '">';
                $page_thumbnail .= $page_thumbnail_img;
                $page_thumbnail .= '</a>';
            } else if ( $thumb_link_type == 'full_size_img' || $thumb_link_type == 'full_size_img_gallery' ) {
                $img = wp_get_attachment_image_src( $thumb_id, 'full' );
                $img_post = get_post( $thumb_id );
                $img_caption = $img_post->post_excerpt;
                $photoswipe_data = 'data-caption="' . $img_caption . '" data-width="' . $img[1] . '" data-height="' . $img[2] . '"';
                $page_thumbnail .= '<a class="photoswipe-item" href="' . $img[0] . '" ' . $photoswipe_data . '>';
                $page_thumbnail .= $page_thumbnail_img;
                $page_thumbnail .= '</a>';
            } else {
                $page_thumbnail .= $page_thumbnail_img;
            }
            $page_thumbnail .= '</p>';
        }
        if ( adomus_get_current_post_meta( $pages_section_id . '_link_title' ) == 'yes' ) {
            $page_title = '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
        } else {
            $page_title = '<h3>' . get_the_title() . '</h3>';
        }
        ?>

            <div class="<?php echo( esc_attr( $column_width ) ); ?>">
                <div class="content-with-padding">
                   
                    <?php 
                    if ( $row_has_title ) { 
                        echo( wp_kses_post( $page_title ) ); 
                    } 
                   
                    if ( $thumb_id ) {
                        add_filter( 'wp_kses_allowed_html', 'adomus_kses_filter_allowed_html', 10, 1 );
                        echo( wp_kses_post( $page_thumbnail ) ); 
                        remove_filter( 'wp_kses_allowed_html', 'adomus_kses_filter_allowed_html', 10 );
                    } 
                    
                    if ( ! $row_has_title ) { 
                        echo( wp_kses_post( $page_title ) ); 
                    } 
                    
                    if ( adomus_get_current_post_meta( $pages_section_id . '_content', true ) == 'page_content' ) {
                        the_content();
                    } else {
                        the_excerpt();
                    }
                    ?>

                    <?php if ( adomus_get_current_post_meta( $pages_section_id . '_learn_more' ) == 'yes' ) : ?>
                    <p class="featured-pages-learn-more-wrapper">
                        <a href="<?php the_permalink() ?>" class="button"><?php echo( esc_html( hotelwp_theme_get_string( 'learn_more' ) ) ); ?></a>
                    </p>
                    <?php endif; ?>
                    
                </div>
            </div>

        <?php 
        if ( $counter_nb_posts_in_row == $nb_posts_in_row ) : 
            $counter_nb_posts_in_row = 0;
        ?>
        
            <div class="featured-pages-row-vertical-border"></div>
            <div class="featured-pages-row-vertical-border"></div>
        </div>

        <?php 
        endif;
    endforeach; 
    wp_reset_postdata();
}

function adomus_get_section_video( $video_section_id ) {
	$bg_img_id = adomus_get_current_post_meta( $video_section_id . '_bg_img' );
    $video_id = adomus_get_current_post_meta( $video_section_id . '_youtube_video_id' ); 

    if ( $bg_img_id && $video_id ) :
        $bg_width = hotelwp_img_full_width_default();
        $bg_height = (int) $bg_width / 3;
        $bg_url = aq_resize( wp_get_attachment_url( $bg_img_id ), $bg_width, $bg_height, true, true, true );
        
        $video_ratio = adomus_get_current_post_meta( $video_section_id . '_youtube_video_ratio' );
        $video_ratio = hotelwp_ratio_str_2_nbr( $video_ratio );
        if ( ! $video_ratio ) {
            $video_ratio = '1.78';
        }
		$video_iframe_src = 'https://www.youtube.com/embed/' . $video_id . '?enablejsapi=1&rel=0';
        ?>
	
        <div class="row video-section-row background-img" style="background-image: url(<?php echo( esc_url( $bg_url ) ); ?>);">
            <div class="video-block-overlay"></div>
            <div class="content-with-padding">
                <div class="video-block-content">
                    <?php adomus_get_section_title( $video_section_id ); ?>
                    <p class="video-intro-text">
                        <?php echo( wp_kses_post( adomus_nl2br( adomus_get_current_post_meta( $video_section_id . '_intro_text' ) ) ) ); ?>
                    </p>
                </div>
                <a href="#" class="video-section-play">
                    <i class="fa fa-play"></i>
                </a>
            </div>
            
            <div class="video-overlay">
                <a class="video-overlay-close" href="#"><i class="fa fa-times"></i></a>
                <div class="video-overlay-container">
                    <iframe data-video-ratio="<?php echo( esc_attr( $video_ratio ) ); ?>" src="<?php echo( esc_url( $video_iframe_src ) ); ?>" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        
        </div>
	
	<?php
    endif;
}

function adomus_get_section_accom( $accom_section_id ) {
    ?>
    
    <?php if ( hotelwp_section_has_title( $accom_section_id ) ) : ?>
	
	<div class="row accom-title-row">
        <div class="content-with-padding">
            <?php adomus_get_section_title( $accom_section_id ); ?>
        </div>
	</div>
	
	<?php endif; ?>
	
	<div class="row accom-row columns-wrapper">
	
	<?php
	global $post;
    $args = array( 
        'post_type' => 'hb_accommodation',
        'posts_per_page' => -1,
        'suppress_filters' => false,
		'order' => 'ASC'
    );
    $selected_accom = adomus_get_current_post_meta( $accom_section_id . '_selected_elts' );
    if ( $selected_accom != 'all' ) {
        $args['include'] = $selected_accom;
    }
	$accom_posts = get_posts( $args );
    if ( count( $accom_posts ) == 1 ) {
        $thumb_width = 1650;
		$thumb_height = 550;
		$column_width = '';
    } else {
		$thumb_width = 825;
		$thumb_height = 440;
		$column_width = 'column-one-half';
	}
	foreach ( $accom_posts as $counter => $post ) :
        if ( ( ( count( $accom_posts ) - $counter ) % 3 == 0 ) && ( $counter % 2 == 0  ) ) {
            $thumb_width = 550;
            $thumb_height = 440;
            $column_width = 'column-one-third';
        }
		setup_postdata( $post );
		$thumb_url = wp_get_attachment_url( get_post_thumbnail_id() );
		if ( ! $thumb_url ) {
			$thumb_desktop_url = get_template_directory_uri() . '/styles/images/default-img.png';
			$thumb_mobile_url = get_template_directory_uri() . '/styles/images/default-img.png';
			$thumb_alt = '';
		} else {
			$thumb_desktop_url = aq_resize( $thumb_url, $thumb_width, $thumb_height, true, true, true );
			$thumb_mobile_url = aq_resize( $thumb_url, 800, 400, true, true, true );
			$thumb_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
		}
		$accom_tagline = adomus_get_post_meta( $post->ID, 'tagline' );
		?>
		
		<a class="<?php echo( esc_attr( $column_width ) ); ?> accom accom-link" href="<?php the_permalink(); ?>">
			<img class="accom-desktop-img" src="<?php echo( esc_url( $thumb_desktop_url ) ); ?>" alt="<?php echo( esc_attr( $thumb_alt ) ); ?>" />
			<img class="accom-mobile-img" src="<?php echo( esc_url( $thumb_mobile_url ) ); ?>" alt="<?php echo( esc_attr( $thumb_alt ) ); ?>" />
			<div class="accom-title">
				<h3><?php the_title(); ?><i class="fa fa-long-arrow-right"></i></h3>
				<?php if ( $accom_tagline ) : ?>
				<p><?php echo( esc_html( $accom_tagline ) ); ?></p>
				<?php endif; ?>
			</div>
		</a>
		
		<?php	
	endforeach;
	wp_reset_postdata();
	?>
	
	</div>
	
	<?php
}

function adomus_get_section_gallery( $gallery_section_id ) {
    $gallery_imgs = adomus_get_current_post_meta( $gallery_section_id . '_imgs' );
    if ( ! $gallery_imgs ) {
        return;
    }
    $gallery_desc_pos = adomus_get_current_post_meta( $gallery_section_id . '_layout' );
    if ( $gallery_desc_pos != 'right' && $gallery_desc_pos != 'center' ) {
        $gallery_desc_pos = 'left';
    }
    $row_classes = 'row gallery-row columns-wrapper';
    $row_classes .= ' gallery-layout-desc-' . $gallery_desc_pos;
	if ( $gallery_desc_pos != 'center' ) {
        $row_classes .= ' row-has-bottom-border';
    }
	$gallery_desc = adomus_nl2br( adomus_get_current_post_meta( $gallery_section_id . '_desc' ) );
	if ( 
		adomus_get_current_post_meta( $gallery_section_id . '_tagline' ) || 
		adomus_get_current_post_meta( $gallery_section_id . '_title' ) ||
		$gallery_desc
	) {
		$gallery_has_intro = true;
	} else {
		$gallery_has_intro = false;
		$row_classes .= ' gallery-no-intro';
	}
    
	?>
	
	<div class="<?php echo( esc_attr( $row_classes ) ); ?>">
		
		<?php if ( $gallery_has_intro ) : ?>
		
		<div class="gallery-desc">
			<div class="content-with-padding">
				<?php 
				if ( $gallery_desc ) {
					adomus_get_section_title( $gallery_section_id, true );
					echo( '<p>' . wp_kses_post( $gallery_desc ) . '</p>' );
				} else {
					adomus_get_section_title( $gallery_section_id, false );
				}
				?>
			</div>
		</div>
			
		<?php endif; ?>
			
		<div class="gallery-grid gallery-wrapper">
			
			<?php
			$gallery_imgs = explode( ',', $gallery_imgs );
			$nb_img = count( $gallery_imgs );
			$gallery_url = '';
			$gallery_linked_page = adomus_get_current_post_meta( $gallery_section_id . '_linked_page_id' );
            if ( $gallery_linked_page ) {
                $gallery_url = get_permalink( $gallery_linked_page );
			}
			foreach ( $gallery_imgs as $counter => $img_id ) :
				if ( $gallery_desc_pos == 'left' && $counter % 4 == 0 ) :
				?>
				<div class="gallery-column gallery-empty"></div>
				<?php
				endif;
                $img = wp_get_attachment_image_src( $img_id, 'full' );
                if ( $img ) :
                    $img_url = aq_resize( $img[0], 350, 350, true, true, true );
                    $img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
                    $img_post = get_post( $img_id );
                    $img_caption = $img_post->post_excerpt;
                    ?>
					
					<div class="gallery-column">
						
						<?php if ( ( $counter == $nb_img - 1 ) && $gallery_url ) : ?>
							
							<a class="gallery-item gallery-link-all" href="<?php echo( esc_url( $gallery_url ) ) ?>">
		                        <img src="<?php echo( esc_url( $img_url ) ); ?>" alt="<?php echo( esc_attr( $img_alt) ); ?>" />
								<div><span><?php echo( esc_html( adomus_get_current_post_meta( $gallery_section_id . '_link_text', true ) ) ); ?><i class="fa fa-long-arrow-right"></i></span></div>
		                    </a>
							
						<?php else : ?>
							
						    <a class="gallery-item photoswipe-item" 
		                       data-caption="<?php echo( esc_attr( $img_caption ) ) ?>" 
		                       data-width="<?php echo( esc_attr( $img[1] ) ) ?>" 
		                       data-height="<?php echo( esc_attr( $img[2] ) ) ?>" 
		                       href="<?php echo( esc_url( wp_get_attachment_url( $img_id ) ) ) ?>"
							>
		                        <img src="<?php echo( esc_url( $img_url ) ); ?>" alt="<?php echo( esc_attr( $img_alt) ); ?>" />
								<div class="gallery-enlarge"></div>
		                    </a>
						
						<?php endif; ?>
					
					</div>
					
				<?php
				endif;
                if ( $gallery_desc_pos == 'right' && ( $counter - 3 ) % 4 == 0 ) :
				?>
				<div class="gallery-column gallery-empty"></div>
				<div class="gallery-clearfix clearfix"></div>
				<?php
				endif;
			endforeach;
			?>
			
		</div>
		
	</div>
	
	<?php
}

function adomus_get_section_testi( $testi_section_id ) {
    $class = 'row testimonials-row';
    $testi_layout = adomus_get_current_post_meta( $testi_section_id . '_layout' );
    if ( $testi_layout == 'big_img_right' ) {
        $class .= ' testimonials-big-img-right';
    } else if ( $testi_layout == 'centered_content' ) {
        $class .= ' testimonials-centered';
    }
    ?>

	<div class="<?php echo( esc_attr( $class ) ); ?>">
	
	<?php
	global $post;
    $args = array( 
        'post_type' => 'htw_testimonials',
        'posts_per_page'=> -1,
        'suppress_filters' => false,
    );
    $selected_testi = adomus_get_current_post_meta( $testi_section_id . '_selected_elts' );
    if ( $selected_testi != 'all' ) {
        $args['include'] = $selected_testi;
    }
	$testi_posts = get_posts( $args );
    if ( ! $testi_posts ) {
        return;
    }
	$testis = array();
	foreach ( $testi_posts as $post ) {
		setup_postdata( $post );
		$testis[] = array(
			'img' => aq_resize( wp_get_attachment_url( get_post_thumbnail_id() ), 750, 750, true, true, true ),
			'caption' => get_post_meta( $post->ID, 'htw-testimonial-author', true ),
			'info' => get_post_meta( $post->ID, 'htw-testimonial-info', true ),
			'intro' => get_post_meta( $post->ID, 'htw-testimonial-intro', true ),
			'content' => get_the_content(),
		);
	}
	wp_reset_postdata();
    if ( $testi_layout != 'centered_content' ) {
        adomus_get_testimonial_images( $testis );
    }
    adomus_get_testimonial_texts( $testi_section_id, $testis, $testi_layout );
	?>
		
	</div><!-- end .testimonials-row -->
	
	<?php
}	

function adomus_get_section_posts( $posts_section_id ) {
	?>
	
    <?php if ( hotelwp_section_has_title( $posts_section_id ) ) : ?>
	
	<div class="row news-title-row row-has-bottom-border">
        <div class="content-with-padding">
            <?php adomus_get_section_title( $posts_section_id ); ?>
        </div>
	</div>
	
	<?php 
	endif; 
	
	$layout = adomus_get_current_post_meta( $posts_section_id . '_layout' );
	$alternate_layout = false;
	$news_content_is_on_right = false;
	if ( $layout == 'img_left' || $layout == 'img_left_right' ) {
		$news_content_is_on_right = true;
	}
	if ( $layout == 'img_left_right' || $layout == 'img_right_left' ) {
		$alternate_layout = true;
	}
	$news_row_class = 'news-row';
	if ( ! $alternate_layout ) {
		$news_row_class .= ' news-row-not-alternate-layout';
	}
	?>
    
	<div class="<?php echo( esc_attr( $news_row_class ) ); ?>">
	
	<?php
	global $post;
	$post_counter = 0;
	$number_posts = adomus_get_current_post_meta( $posts_section_id . '_number' );
    $cat = adomus_get_current_post_meta( $posts_section_id . '_selected_elts' );
    if ( $cat == 'all' ) {
        $cat = '';
    }
	$args = array( 
        'posts_per_page' => $number_posts,
        'suppress_filters' => false,
        'category' => $cat
    );
	$news_posts = get_posts( $args );
	foreach ( $news_posts as $i => $post ) :
		setup_postdata( $post );
		$news_thumb = aq_resize( wp_get_attachment_url( get_post_thumbnail_id() ), 800, 400, true, true, true );
		$news_thumb_mobile = aq_resize( wp_get_attachment_url( get_post_thumbnail_id() ), 800, 266, true, true, true );
		$news_thumb_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
		$news_class = 'columns-wrapper row-has-bottom-border';
		if ( $news_content_is_on_right ) {
			$news_class .= ' news-content-right';
		}
		?>
		
		<div class="<?php echo( esc_attr( $news_class ) ); ?>">
			
			<?php if ( $news_content_is_on_right ) : ?>
			<div class="column-one-half desktop-only">&nbsp;</div>
			<?php endif; ?>
			
			<div class="column-one-half news">
				
				<img class="mobile-news-img" src="<?php echo( esc_url( $news_thumb_mobile ) ); ?>" alt="<?php echo( esc_attr( $news_thumb_alt ) ); ?>" />
				
				<div class="content-with-padding">
					<h3 class="news-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<?php the_excerpt(); ?>
					<p class="news-more">
						<a href="<?php the_permalink(); ?>"><?php echo( esc_html( hotelwp_theme_get_string( 'read_more' ) ) ); ?><i class="fa fa-long-arrow-right"></i></a>
					</p>
					<?php if ( adomus_get_current_post_meta( $posts_section_id . '_meta' ) != 'no' ) : ?>
					<p class="news-meta">
						<?php adomus_post_meta(); ?>
					</p>
					<?php endif; ?>
				</div>
			</div>
			
			<a class="news-thumb" href="<?php the_permalink(); ?>">
				<div class="news-thumb-img background-img" style="background-image: url(<?php echo( esc_url( $news_thumb ) ); ?>);"></div>
			</a>
			
		</div>
		
		<?php
		if ( $alternate_layout ) {
			$news_content_is_on_right = ! $news_content_is_on_right;
		}
	endforeach;
	wp_reset_postdata();
    ?>
    
    </div>
    
    <?php
}

function adomus_get_section_cta( $cta_section_id ) {
    $cta_text = adomus_get_current_post_meta( $cta_section_id . '_text' );
    $cta_link_text = adomus_get_current_post_meta( $cta_section_id . '_link_text' );
    if ( $cta_text || $cta_link_text ) :
    ?>
	
    <div class="row cta-row row-has-bottom-border">
    	<div class="content-with-padding">
    		<div class="section-title">
    			<h2><?php echo( esc_html( $cta_text ) ); ?></h2>
    			<?php $cta_url = get_permalink( adomus_get_current_post_meta( $cta_section_id . '_link_page_id' ) ); ?>
	    		<p>	
					<a href="<?php echo( esc_url( $cta_url ) ); ?>">
	    				<?php echo( esc_html( $cta_link_text ) ); ?>
	    				<i class="fa fa-long-arrow-right"></i>
	    			</a>
				</p>
    		</div>
        </div>
	</div>
	
<?php
    endif;
}

function adomus_get_section_map_contact( $section_id ) {
	$layout = adomus_get_current_post_meta( $section_id . '_layout' );
	if ( $layout == 'full_width_map' ) :
		adomus_get_full_width_map( $section_id );
	else :
	?>
	
		<div class="row map-contact-row row-has-bottom-border columns-wrapper">
		
		<?php
		if ( $layout == 'contact_form_only' ) {
			adomus_get_sub_section_contact_form_full_width( $section_id );
		} else if ( $layout == 'contact_form_map' ) {
			if ( adomus_get_current_post_meta( $section_id . '_contact_form_position' ) == 'left' ) {
				adomus_get_sub_section_contact_form( $section_id );
				adomus_get_sub_section_map( $section_id );
			} else {
				adomus_get_sub_section_map( $section_id );
				adomus_get_sub_section_contact_form( $section_id );
			}
		} else if ( $layout == 'contact_info_map' ) {
			if ( adomus_get_current_post_meta( $section_id . '_map_position' ) == 'left' ) {
				adomus_get_sub_section_map( $section_id );
				adomus_get_sub_section_contact_info( $section_id );
			} else {
				adomus_get_sub_section_contact_info( $section_id );
				adomus_get_sub_section_map( $section_id );
			}
		} else if ( $layout == 'contact_info_contact_form' ) {
			if ( adomus_get_current_post_meta( $section_id . '_contact_form_position' ) == 'left' ) {
				adomus_get_sub_section_contact_form( $section_id );
				adomus_get_sub_section_contact_info( $section_id );
			} else {
				adomus_get_sub_section_contact_info( $section_id );
				adomus_get_sub_section_contact_form( $section_id );
			}
			echo( '<div class="contact-row-vertical-border"></div>' );
		}
		?>
	
		</div>
		
		<?php
	endif;
}

function adomus_get_section_editor( $editor_section_id ) {
    ?>
    
    <div class="row row-has-bottom-border">
        <div class="full-width-content-with-padding">
            
            <?php the_content(); ?>
            
        </div>
    </div>
    
    <?php
}

function adomus_get_section_custom( $custom_section_id ) {
    ?>
    
    <div class="row row-has-bottom-border">
        <div class="full-width-content-with-padding">
            
            <?php echo( do_shortcode( wp_kses_post( adomus_get_current_post_meta( $custom_section_id . '_content' ) ) ) ); ?>
            
        </div>
    </div>
    
    <?php
}