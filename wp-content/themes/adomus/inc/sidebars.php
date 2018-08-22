<?php

add_action( 'widgets_init', 'adomus_sidebars_register' );

function adomus_sidebars_register() {

    register_sidebar( array(
        'name'          => esc_html__( 'Blog', 'hotelwp' ),
        'id'            => 'blog-sidebar',
        'description'   => esc_html__( 'Add widgets here to appear in the sidebar of your blog.', 'hotelwp' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ) );	

    register_sidebar( array(
        'name'          => esc_html__( 'Accommodation', 'hotelwp' ),
        'id'            => 'accom-sidebar',
        'description'   => esc_html__( 'Add widgets here to appear in the accommodation pages.', 'hotelwp' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ) );	
    
    register_sidebar( array(
        'name'          => esc_html__( 'Top header left', 'hotelwp' ),
        'id'            => 'top-header-left',
        'description'   => esc_html__( 'Add widgets here to appear at the left of the top header.', 'hotelwp' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Top header right', 'hotelwp' ),
        'id'            => 'top-header-right',
        'description'   => esc_html__( 'Add widgets here to appear at the right of the top header.', 'hotelwp' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ) );	

    for ( $i = 1; $i <= 4; $i++ ) {
        register_sidebar( array(
            'name'          => sprintf( esc_html__( 'Footer Column %d', 'hotelwp' ), $i ),
            'id'            => 'footer-' . $i,
            'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'hotelwp' ),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>',
        ) );
    }

    register_sidebar( array(
        'name'          => esc_html__( 'Page', 'hotelwp' ),
        'id'            => 'page-sidebar',
        'description'   => esc_html__( 'Add widgets here to appear in the sidebar of your pages.', 'hotelwp' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ) );	
}