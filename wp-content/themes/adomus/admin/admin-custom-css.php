<?php

add_action( 'admin_head', 'adomus_admin_custom_css' );

function adomus_admin_custom_css() {
	echo '<style>.toplevel_page_hb_contact { display: none }</style>';
}