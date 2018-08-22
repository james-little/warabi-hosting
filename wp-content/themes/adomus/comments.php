<hr/>

<div id="comments">
	
	<?php if ( post_password_required() ) : ?>
		
    <p><?php echo( esc_html( hotelwp_theme_get_string( 'password_protected_comments' ) ) ); ?></p>
</div>
    
	<?php
		return;
	endif;
	?>
	
	<?php if ( get_comments_number() == 0 ) : ?>
    	
		<h3><?php echo( esc_html( hotelwp_theme_get_string( 'no_comments' ) ) ); ?></h3>
		<hr class="hr-no-comment" />    
    
	<?php elseif ( get_comments_number() == 1 ) : ?>
    
		<h3><?php echo( esc_html( hotelwp_theme_get_string( 'one_comment' ) ) ); ?></h3>
    
	<?php else : ?>
        
    	<h3><?php printf( esc_html( hotelwp_theme_get_string( 'x_comments' ) ), get_comments_number() ); ?></h3>
		
	<?php endif; ?>
	
	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		
        <p><?php paginate_comments_links(); ?></p>
    
	<?php endif; ?>
	
    <div id="comments-list">
	<?php wp_list_comments( array( 'style' => 'div', 'callback' => 'adomus_comments_callback' ) ); ?>
	</div>
    
	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		
        <p><?php paginate_comments_links(); ?></p>
    
    <?php endif; ?>
		
</div>


<div id="post-comment">

	<?php
	$comments_args = array(
		// remove "Text or HTML to be displayed after the set of comment fields"
		'comment_notes_after' => ''
	); 
	comment_form( $comments_args ); 
	?>
	
</div>