<?php
class HotelWPInstallOptions {
	
	private $default_menu_item_page;
	private $default_menu_item_custom_link;
	private $default_menu_item_category;
	private $demo_posts;
	
	public function process() {
		if ( 
			isset( $_POST['hotelwp_theme_install_nonce'] ) && 
			wp_verify_nonce( $_POST['hotelwp_theme_install_nonce'], 'hotelwp_theme_install_nonce' ) && 
			current_user_can( 'manage_options' ) 
		) {
			$num = intval( $_POST['demo_num'] );
			$demo_num = 'demo_' . $num;
			$this->create_sliders( $demo_num );
			$menu_ids = $this->create_menu( $demo_num );
			$this->set_widgets( $demo_num, $menu_ids );
			$this->set_misc_options( $demo_num );
			if ( function_exists( 'hbook_is_active' ) ) {
				$this->set_hb_options();
			}
			echo( 'ok' );
		}
		die;
	}

	private function create_sliders( $demo_num ) {
		$sliders = array(
			'demo_1' => '[{"slideshowId":"Main slider544","slideshowName":"Main slider","autoplayOptionName":"Main sliderautoplay","transitionOptionName":"Main slidertransition","slideDuration":"5000","transitionDuration":"1000","paginationDuration":"1500","rewindDuration":"2000","autoplay":"yes","transitionStyle":"slide","slides":[{"mediaId":39,"mediaPath":"","thumbnailPath":"","thumbnailTitle":"","caption":"Amazing rooms","backgroundColor":"#000","textColor":"#fff","captionOpacity":"75"},{"mediaId":14,"mediaPath":"","thumbnailPath":"","thumbnailTitle":"","caption":"Wedding and conference","backgroundColor":"#000","textColor":"#fff","captionOpacity":"75"},{"mediaId":23,"mediaPath":"","thumbnailPath":"","thumbnailTitle":"","caption":"Adomus complex","backgroundColor":"#000","textColor":"#fff","captionOpacity":"75"},{"mediaId":11,"mediaPath":"","thumbnailPath":"","thumbnailTitle":"","caption":"Bar and Restaurant","backgroundColor":"#000","textColor":"#fff","captionOpacity":"75"}]}]',
			'demo_2' => '[{"slideshowId":"Main slider544","slideshowName":"Main slider","autoplayOptionName":"Main sliderautoplay","transitionOptionName":"Main slidertransition","slideDuration":"5000","transitionDuration":"1000","paginationDuration":"1500","rewindDuration":"2000","autoplay":"yes","transitionStyle":"slide","slides":[{"mediaId":1,"mediaPath":"","thumbnailPath":"","thumbnailTitle":"","caption":"Amazing camping","backgroundColor":"#000","textColor":"#fff","captionOpacity":"75"},{"mediaId":4,"mediaPath":"","thumbnailPath":"","thumbnailTitle":"","caption":"On-site activities","backgroundColor":"#000","textColor":"#fff","captionOpacity":"75"},{"mediaId":13,"mediaPath":"","thumbnailPath":"","thumbnailTitle":"","caption":"Sites and cabins","backgroundColor":"#000","textColor":"#fff","captionOpacity":"75"},{"mediaId":21,"mediaPath":"","thumbnailPath":"","thumbnailTitle":"","caption":"Modern amenities","backgroundColor":"#000","textColor":"#fff","captionOpacity":"75"}]}]',
			'demo_3' => '[{"slideshowId":"Main slider544","slideshowName":"Main slider","autoplayOptionName":"Main sliderautoplay","transitionOptionName":"Main slidertransition","slideDuration":"5000","transitionDuration":"1000","paginationDuration":"1500","rewindDuration":"2000","autoplay":"yes","transitionStyle":"slide","slides":[{"mediaId":1,"mediaPath":"","thumbnailPath":"","thumbnailTitle":"","caption":"","backgroundColor":"#000","textColor":"#fff","captionOpacity":"75"},{"mediaId":22,"mediaPath":"","thumbnailPath":"","thumbnailTitle":"","caption":"","backgroundColor":"#000","textColor":"#fff","captionOpacity":"75"},{"mediaId":2,"mediaPath":"","thumbnailPath":"","thumbnailTitle":"","caption":"","backgroundColor":"#000","textColor":"#fff","captionOpacity":"75"},{"mediaId":8,"mediaPath":"","thumbnailPath":"","thumbnailTitle":"","caption":"","backgroundColor":"#000","textColor":"#fff","captionOpacity":"75"}]}]'
		);
		
		update_option( 'hotelwp_sliders', $sliders[ $demo_num ] );
	}
	
	private function create_menu( $demo_num ) {
		
		$this->demo_posts = hotelwp_demo_install_get_posts( $demo_num );
		
		$this->default_menu_item_page = array(
			'menu-item-object' => 'page',
			'menu-item-type' => 'post_type',
			'menu-item-status' => 'publish',
		);
		
		$this->default_menu_item_custom_link = array(
			'menu-item-type' => 'custom',
			'menu-item-status' => 'publish',
		);
		
		$this->default_menu_item_category = array(
			'menu-item-object' => 'category',
		    'menu-item-type' => 'taxonomy',
		    'menu-item-status' => 'publish',
		);
				
		$main_menu = wp_create_nav_menu( 'Main menu' );
		$footer_menu = wp_create_nav_menu( 'Footer menu' );	
		$rooms_menu = wp_create_nav_menu( 'Rooms menu' );	
			
		if ( 'demo_2' == $demo_num ) {
			$category_agenda = get_term_by( 'id', '2', 'category' );
			$category_sightseeing = get_term_by( 'id', '3', 'category' );
			$category_news = get_term_by( 'id', '4', 'category' );
		}

		$main_menu_items = array(
			'demo_1' => array(
				array( 
					'type' => 'page',
					'data' => array(
						'id' => 122,
					),
					'sub_menu' => array(
						array( 
							'type' => 'page',
							'data' => array(
								'id' => 122,
							),
						),
						array( 
							'type' => 'page',
							'data' => array(
								'id' => 123,
							),
						),
						array( 
							'type' => 'page',
							'data' => array(
								'id' => 124,
							),
						),
					),
				),
				array( 
					'type' => 'page',
					'data' => array(
						'id' => 115,
					),
					'sub_menu' => array(
						array( 
							'type' => 'page',
							'data' => array(
								'id' => 116,
							),
						),
						array( 
							'type' => 'page',
							'data' => array(
								'id' => 117,
							),
						),
						array( 
							'type' => 'page',
							'data' => array(
								'id' => 118,
							),
						)
					)
				),
				array( 
					'type' => 'page',
					'data' => array(
						'id' => 103,
					),
				),
				array( 
					'type' => 'page',
					'data' => array(
						'id' => 101,
						'sub_menu' => array(
							array( 
								'type' => 'page',
								'data' => array(
									'id' => 102,
								)
							)
						)
					)
				),
				array( 
					'type' => 'page',
					'data' => array(
						'id' => 119,
					),
					'sub_menu' => array(
						array( 
							'type' => 'page',
							'data' => array(
								'id' => 108,
							),
						),
						array( 
							'type' => 'page',
							'data' => array(
								'id' => 109,
							),
						),
						array( 
							'type' => 'page',
							'data' => array(
								'id' => 110,
							),
						)
					)
				),
				array( 
					'type' => 'page',
					'data' => array(
						'id' => 107,
					)
				)
			),
			'demo_2' => array(
				array( 
					'type' => 'page',
					'data' => array(
						'id' => 122,
					),
					'sub_menu' => array(
						array( 
							'type' => 'page',
							'data' => array(
								'id' => 122,
							),
						),
						array( 
							'type' => 'page',
							'data' => array(
								'id' => 124,
							),
						),
						array( 
							'type' => 'page',
							'data' => array(
								'id' => 125,
							),
						),
					),
				),
				array( 
					'type' => 'custom_link',
					'data' => array(
						'menu-item-title' => 'Park',
						'menu-item-url' => '#',
					),
					'sub_menu' => array(
						array( 
							'type' => 'page',
							'data' => array(
								'id' => 123,
							),
							'sub_menu' => array(
								array( 
									'type' => 'page',
									'data' => array(
										'id' => 116,
									),
								),
								array( 
									'type' => 'page',
									'data' => array(
										'id' => 117,
									),
								),
								array( 
									'type' => 'page',
									'data' => array(
										'id' => 118,
									)
								)
							)
						)
					)
				),
				array( 
					'type' => 'custom_link',
					'data' => array(
						'menu-item-title' => 'Services',
						'menu-item-url' => '#',
					),
					'sub_menu' => array(
						array( 
							'type' => 'page',
							'data' => array(
								'id' => 121,
							),
						),
						array(
							'type' => 'page',
							'data' => array(
								'id' => 120,
							),
							'sub_menu' => array(
								array( 
									'type' => 'page',
									'data' => array(
										'id' => 111,
									),
								),
								array(
									'type' => 'page',
									'data' => array(
										'id' => 112,
									),
								),
								array(
									'type' => 'page',
									'data' => array(
										'id' => 119,
									)
								)
							)
						)
					)
				),			
				array( 
					'type' => 'custom_link',
					'data' => array(
						'menu-item-title' => 'Events',
						'menu-item-url' => '#',
					),
					'sub_menu' => array(
						array( 
							'type' => 'category',
							'data' => array(
								'menu-item-title' => $category_agenda->name,
							    'menu-item-object-id' => $category_agenda->term_id,
							    'menu-item-url' => get_category_link( $category_agenda->term_id ),
							),
						),
						array( 
							'type' => 'category',
							'data' => array(
								'menu-item-title' => $category_sightseeing->name,
							    'menu-item-object-id' => $category_sightseeing->term_id,
							    'menu-item-url' => get_category_link( $category_sightseeing->term_id ),
							),
						),
						array( 
							'type' => 'category',
							'data' => array(
								'menu-item-title' => $category_news->name,
							    'menu-item-object-id' => $category_news->term_id,
							    'menu-item-url' => get_category_link( $category_news->term_id ),
							)
						)
					)
				),
				array( 
					'type' => 'page',
					'data' => array(
						'id' => 109,
					)
				),
				array( 
					'type' => 'page',
					'data' => array(
						'id' => 108,
					)
				),
				array( 
					'type' => 'page',
					'data' => array(
						'id' => 106,
					)
				)
			),
			'demo_3' => array(
				array( 
					'type' => 'page',
					'data' => array(
						'id' => 122,
					),
					'sub_menu' => array(
						array( 
							'type' => 'page',
							'data' => array(
								'id' => 122,
							),
						),
						array( 
							'type' => 'page',
							'data' => array(
								'id' => 121,
							),
						),
						array( 
							'type' => 'page',
							'data' => array(
								'id' => 120,
							),
						),
					),
				),
				array( 
					'type' => 'page',
					'data' => array(
						'id' => 113,
					),
				),
				array( 
					'type' => 'page',
					'data' => array(
						'id' => 110,
					),
				),
				array( 
					'type' => 'page',
					'data' => array(
						'id' => 111,
					),
				),
				array( 
					'type' => 'page',
					'data' => array(
						'id' => 109,
					)
				)
			)
		);
				
		$this->create_menu_items( $main_menu, $main_menu_items[ $demo_num ], 0 );
			
		$footer_menu_items = array(
			'demo_1' => array(		
			),
			'demo_2' => array(
				array(
					'type' => 'page',
					'data' => array( 
						'id' => 122,
					)
				),
				array(
					'type' => 'page',
					'data' => array( 
						'id' => 120,
					)
				),
				array(
					'type' => 'page',
					'data' => array( 
						'id' => 106,
					)
				)
			),
			'demo_3' =>array(	
				array(
					'type' => 'page',
					'data' => array( 
						'id' => 120,
					)
				),
				array(
					'type' => 'page',
					'data' => array( 
						'id' => 113,
					)
				),
				array(
					'type' => 'page',
					'data' => array( 
						'id' => 110,
					)
				),
				array(
					'type' => 'page',
					'data' => array( 
						'id' => 111,
					)
				),
				array(
					'type' => 'page',
					'data' => array( 
						'id' => 109,
					)
				)					
			)
		);
		
		$this->create_menu_items( $footer_menu, $footer_menu_items[ $demo_num ], 0 );
		
		$rooms_menu_items = array(
			array(
				'type' => 'page',
				'data' => array( 
					'id' => 116,
				)
			),
			array(
				'type' => 'page',
				'data' => array( 
					'id' => 117,
				)
			),
			array(
				'type' => 'page',
				'data' => array( 
					'id' => 118,
				)
			)
		);
		
		$this->create_menu_items( $rooms_menu, $rooms_menu_items, 0 );
				
		$locations = get_theme_mod( 'nav_menu_locations' );
		$locations['adomus_menu'] = $main_menu;
		set_theme_mod( 'nav_menu_locations', $locations );
	
		$locations = get_theme_mod( 'nav_menu_locations' );
		$menu_ids = array();
		$menu_ids['footer-menu'] = $footer_menu;       
		$menu_ids['main-menu'] = $main_menu;
		$menu_ids['rooms-menu'] = $rooms_menu;
	
		return $menu_ids;
	}

	private function create_menu_items( $menu_id, $menu_items, $parent ) {
		foreach ( $menu_items as $menu_item ) {
			if ( 'page' == $menu_item['type'] ) {
				$page_id = $menu_item['data']['id'];
				$item_data = array_merge( $this->default_menu_item_page, array(
						'menu-item-title' 		=> $this->demo_posts[ $demo_num ][ $page_id ]['post_info']['post_title'],
						'menu-item-object-id'	=> $page_id,
					)
				);
			} elseif( 'custom_link' == $menu_item['type'] ) {
				$item_data = array_merge( $this->default_menu_item_custom_link, array(
						'menu-item-title' => $menu_item['data']['menu-item-title'],
						'menu-item-url'	=> $menu_item['data']['menu-item-url'],
					)
				);
			} elseif( 'category' == $menu_item['type'] ) {
				$item_data = array_merge( $this->default_menu_item_category, array(
						'menu-item-title' => $menu_item['data']['menu-item-title'],
						'menu-item-url'	=> $menu_item['data']['menu-item-url'],
						'menu-item-object-id' => $menu_item['data']['menu-item-object-id']
					)
				);
			}
			$item_data['menu-item-parent-id'] = $parent;
			
			$new_parent = wp_update_nav_menu_item( $menu_id, 0, $item_data );
			if ( array_key_exists( 'sub_menu', $menu_item ) ) {
				$this->create_menu_items( $menu_id, $menu_item['sub_menu'], $new_parent );
			}
		}
	}
	
	
	private function set_widgets( $demo_num, $menu_ids ) {
		$sidebar_names = array(
			'demo_1' => array(
				'wp_inactive_widgets' => array(),
				'blog-sidebar' => array(
					'search' => array(
						'title' => 'Search',
					),
					'recent_posts' => array(
						'title' => 'Recent posts',
						'count' => '5',
					),
					'categories' => array(
						'title' => 'Categories',
						'count' => '5',
					),
				),
				'footer-1' => array(
					'text' => array(
						'title' => 'Latest reviews',
						'text' => '<i>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sed ligula odio.</i><br/><b>Claudio, Italy.</b><br/><br/><br/><i>Vivamus consectetur consequat dolor sed porta. Sed pellentesque eleifend vulputate.</i><br/><b>Laura, Canada.</b>',
					),	
				),	
				'footer-2' => array(
					'text' => array(
						'title' => 'About us',
						'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus scelerisque libero vel odio elementum convallis. Pellentesque justo lectus, mattis vitae bibendum nec, consectetur vitae velit. Donec id felis non massa tincidunt vehicula. Suspendisse cursus eu lacus in imperdiet. Maecenas a mauris et justo congue bibendum. Donec blandit risus porta, tincidunt turpis at, lobortis tellus. Sed at mauris libero. Phasellus sit amet leo eu ipsum tempor auctor at eu elit.',
					),
				),
				'footer-3' => array(
					'text' => array(
						'title' => 'Contact us',
						'text' => '<b>Bookings: </b><br/>+65-123456789<br/>reservation@adomus.com<br/><br/><b>General information: </b><br/>+65-123456789<br/>information@adomus.com<br/><br/><b>Address</b><br/>Adomus Hotel<br/>City square, 5 - Block E<br/>Paradise Mall<br/>36985 Adomus',
					),
				),
				'accom-sidebar' => array(
					'nav_menu' => array(
						'title' => 'Rooms and Suites',
						'nav_menu' => $menu_ids['rooms-menu'],
					),
					'text' => array(
						'title' => '',
						'text' => '[hb_booking_form redirection_url="' . get_permalink( 114 ) . '"]',
					),
				),
			),
			'demo_2' => array(
				'wp_inactive_widgets' => array(),
				'blog-sidebar' => array(
					'search' => array(
						'title' => 'Search',
					),
					'categories' => array(
						'title' => 'Categories',
						'count' => '5',
					),
					'recent_posts' => array(
						'title' => 'Recent posts',
						'count' => '5',
					),
					'text' => array(
						'title' => '',
						'text' => '[hb_booking_form redirection_url="' . get_permalink( 108 ) . '"]',
					),
				),
				'footer-1' => array(
					'text' => array(
						'title' => 'Contact us',
						'text' => '<p>Have a special request? A question regarding our activities? Need a confirmation before proceeding?</p><p>Do not hesitate to <a href="' . get_permalink( 106 ) . '">contact us</a> for any enquiry!</p>',					
					),
				),	
				'footer-2' => array(
					'nav_menu' => array(
						'title' => 'Navigation',
						'nav_menu' => $menu_ids['footer-menu'],
					),
				),
				'footer-3' => array(
					'text' => array(
						'title' => 'Contact details',
						'text' => 'Adomus Campgrounds<br/>15 Paradise Lane<br/>Jackson Riverz<br/>Texas, USA<br/><br/>Phone: +1-541-754-3010<br/>Email: adomus@rvcampgrounds.com<br/>'
					),
				),
				'footer-4' => array(
					'nav_menu' => array(
						'title' => 'Site and Cabins',
						'nav_menu' => $menu_ids['rooms-menu'],
					),
				),
				'accom-sidebar' => array(
					'nav_menu' => array(
						'title' => 'Site and Cabins',
						'nav_menu' => $menu_ids['rooms-menu'],
					),
					'text' => array(
						'title' => '',
						'text' => '[hb_booking_form redirection_url="' . get_permalink( 108 ) . '"]',
					),
				),
			),
			'demo_3' => array(
				'wp_inactive_widgets' => array(),
				'blog-sidebar' => array(
					'search' =>	array(
						'title' 	=> 'Search',
					),
					'recent_posts' => array(
						'title'		=> 'Recent posts',
						'count'		=> '3',
					),
					'recent_comments' => array(
						'title'		=> 'Recent comments',
						'count'		=> '3',
					),
				),
				'footer-1'	=>	array(
					'text'		=>	array(
						'title'		=>	'',
						'text'		=>	'<img src="' . wp_get_attachment_url( 5 ) . '" alt="happy-couple-mobile" width="300" height="143" class="alignnone size-medium wp-image-71" /><br/><img src="'. wp_get_attachment_url( 6 )  . '" alt="signature" width="235" height="29" class="aligncenter size-full wp-image-57" />',
					),
				),	
				'footer-2'	=>	array(
					'text'		=>	array(
						'title'		=>	'About us',
						'text'		=>	'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam ullamcorper metus eu accumsan tristique. Nullam vel elit vel velit fringilla porta. Aenean sollicitudin ex sed lectus suscipit, tincidunt sagittis ipsum mattis. <br/>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aliquam erat volutpat. ',
					),
				),
				'footer-3'	=>	array(
					'text'		=>	array(
						'title'		=>	'Our details',
						'text'		=>	'<p>Adomus B&B<br/>27, Beach Hills<br/>Nice, France<br/><p><p>Phone: +123 45 67 89<br/>Mobile: + 123 45 67 89<br/>Email: adomus@bnb.com<br/><br/><br/></p>',
					),
				),
				'footer-4'	=>	array(
					'nav_menu'	=>	array(
						'title'		=>	'Site map',
						'nav_menu'	=>	$menu_ids['footer-menu'],
					),	
				),	
				'accom-sidebar'	=>	array(
					'text'	=>	array(
						'title'		=> 'Availability',
						'text' 		=> '[hb_availability calendar_sizes="1x3"]',
					),
					'nav_menu'	=>	array(
						'title'		=>	'Accommodation list',
						'nav_menu'	=>	$menu_ids['rooms-menu'],
					),
					'text'	=>	array(
						'title'		=> '',
						'text' 		=> '[hb_booking_form]',
					),
				),
			)
		);
		
		$counter = 1;
		foreach ( $sidebar_names[ $demo_num ] as $sidebar_name => $widgets_names ) {
		
			$sidebar_options = get_option( 'sidebars_widgets' );
			if ( ! isset( $sidebar_options[ $sidebar_name ] ) ) {
			    $sidebar_options[ $sidebar_name ] = array( '_multiwidget' => 1 );
			}
			
			foreach ( $widgets_names as $widget_name => $options ){
				
				$return = $this->allocate_widget_to_sidebar( $widget_name, $sidebar_options, $sidebar_name, $counter );
				$key = $return[0];
				$count = $return[1];
				$sidebar_options = $return[2];
				$sidebar_widgets = $return[3];
				$sidebar_widgets[$count] = $options;
				update_option( 'sidebars_widgets', $sidebar_options );
				update_option( 'widget_' . $widget_name, $sidebar_widgets);
				
				$counter++;
			}
		}
	}

			
	private function allocate_widget_to_sidebar( $widget_name, $sidebar_options, $sidebar_name, $counter ) {
		$sidebar_widgets = get_option( 'widget_' . $widget_name );
		if ( !is_array( $sidebar_widgets ) ){
			$sidebar_widgets = array();
		}
		$count = count( $sidebar_widgets ) + $counter;
		$sidebar_options[ $sidebar_name ][] = $widget_name.'-'.$count;
		$var_option = $widget_name . '-' . $count . '-';
		$key = 'widget-' . $var_option;
		$return = array( $key, $count, $sidebar_options, $sidebar_widgets );
		return $return;
	}

	
	private function set_misc_options( $demo_num ) {
		$general_options = array(
			'show_on_front' => 'page',
			'page_on_front' => 122,
			'blogname' => 'Adomus',
			'default_comment_status' => 'close',
		);
		
		$misc_options = array(
			'demo_1' => array(
				'hero_img' => 34,
				'overlay_opacity' => 20,
				'header_background_opacity' => 20,
				'dropdown_menu_background' => '#bf9346',
				'booking_form_background' => '#bf9346',
				'dropdown_menu_background_opacity' => 95,
				'booking_form_background_opacity' => 95,
				'booking_form_white_button' => 'yes',
				'link_color' => '#bf9346',
				'link_hover_color' => '#e0c566',
				'accent_color' => '#ccb18e',
				'footer_background' => '#2a2826',
				'footer_text_color' => 'footer_light_text',
			),
			'demo_2' => array(
				'hero_img' => 1,
				'overlay_opacity' => 33,
				'header_background_opacity' => 0,
				'dropdown_menu_background' => '#000000',
				'link_color' => '#8ec944',
				'link_hover_color' => '#879f76',
				'accent_color' => '#427a5b',
				'booking_form_background' => '#427a5b',
			),
			'demo_3' => array(
				'hero_img' => 3,
				'overlay_opacity' => 33,
				'header_background' => '#2b7fa4',
				'header_background_opacity' => 70,
				'dropdown_menu_background' => '#2b7fa4',
				'link_color' => '#46cdcf',
				'link_hover_color' => '#7098bd',
				'accent_color' => '#2b7fa4',
				'booking_form_background' => '#2b7fa4',
			),
		);
		
		foreach ( $general_options as $option_name => $option_value ) {
			update_option( $option_name, $option_value );
		}
		
		foreach ( $misc_options[ $demo_num ] as $name => $value ) {
			set_theme_mod( $name, $value );
		}
	}
	
	private function set_hb_options() {
		global $wpdb;
		$hb_accom_num_name_table = $wpdb->prefix . 'hb_accom_num_name';
		$hb_seasons_table = $wpdb->prefix . 'hb_seasons';
		$hb_seasons_dates_table = $wpdb->prefix . 'hb_seasons_dates';
		$hb_rates_table = $wpdb->prefix . 'hb_rates';
		$hb_rates_accom_table = $wpdb->prefix . 'hb_rates_accom';
		$hb_rates_seasons_table = $wpdb->prefix . 'hb_rates_seasons';
		
		$wpdb->query( "INSERT INTO $hb_accom_num_name_table ( accom_id, accom_num, num_name ) VALUES (116, 1, 1),(117, 1, 1), (118, 1, 1)" );
		$wpdb->query( "INSERT INTO $hb_seasons_table ( id, name ) VALUES (1, 'All year round')" );
		$wpdb->query( "INSERT INTO $hb_seasons_dates_table ( id, season_id, start_date, end_date, days ) VALUES (1, 1, '2016-12-01', '2017-12-31', '0,1,2,3,4,5,6' )" );
		$wpdb->query( "INSERT INTO $hb_rates_table ( id, type, all_accom, all_seasons, amount, nights ) VALUES (1, 'accom', 1, 1, 50.00, 1 )" );
		$wpdb->query( "INSERT INTO $hb_rates_accom_table ( rate_id, accom_id ) VALUES (1, 116 ), (1, 117 ), (1, 118 )" );
		$wpdb->query( "INSERT INTO $hb_rates_seasons_table ( rate_id, season_id ) VALUES (1, 1 )" );		
	}
	
}