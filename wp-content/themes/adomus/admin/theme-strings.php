<?php

function hotelwp_get_theme_strings() {
	return array(
		'learn_more' => array(
			'name' => 'Learn more',
			'default_value' => 'Learn more'
		),
		'read_more' => array(
			'name' => 'Read more',
			'default_value' => 'Read more'
		),
		'post_date' => array(
			'name' => 'Post date',
			'default_value' => 'Published on: '
		),
		'post_categories' => array(
			'name' => 'Post categories',
			'default_value' => 'Filed under: '
		),
		'post_tags' => array(
			'name' => 'Post tags',
			'default_value' => 'Tagged: '
		),
		'previous_post' => array(
			'name' => 'Previous post',
			'default_value' => 'Previous post:'
		),
		'next_post' => array(
			'name' => 'Next post',
			'default_value' => 'Next post:'
		),
		'no_comments' => array(
			'name' => 'No comments',
			'default_value' => 'No comments yet'
		),
		'one_comment' => array(
			'name' => 'One comment',
			'default_value' => 'One comment'
		),
		'x_comments' => array(
			'name' => 'More than one comment',
			'default_value' => '%s comments'
		),
		'comment_by_author' => array(
			'name' => 'Comment by author',
			'default_value' => '(Post author)'
		),
		'comment_date_time_at' => array(
			'name' => 'Comment date time "at"',
			'default_value' => 'at'
		),
		'password_protected_comments' => array(
			'name' => 'Comments title for posts which are password protected',
			'default_value' => 'This post is password protected. Enter the password to view any comments.'
		),
		'search_page_title' => array(
			'name' => 'Search page title',
			'default_value' => 'Search results for: %s'
		),
		'search_page_no_results' => array(
			'name' => 'Search returning no results',
			'default_value' => 'Sorry, but nothing matched your search terms. Please try again with some different keywords.'
		),
		'404_page_title' => array(
			'name' => '404 page title',
			'default_value' => '404 not found'
		),
		'404_page_text' => array(
			'name' => 'Text for 404 error page',
			'default_value' => 'It seems we can not find what you are looking for. Perhaps searching can help.'
		),
		'paginated_post_pagination_title' => array(
			'name' => 'Pagination title for paginated posts',
			'default_value' => 'Continue reading:'
		),
		'send_button' => array(
			'name' => esc_html__( 'Send button', 'hotelwp' ),
			'default_value' => 'Send'
		),
		'invalid_email' => array(
			'name' => esc_html__( 'Invalid email error', 'hotelwp' ),
			'default_value' => 'Invalid email.'
		),
		'required_field' => array(
			'name' => esc_html__( 'Required field error', 'hotelwp' ),
			'default_value' => 'Required field.'
		), 
		'invalid_number' => array(
			'name' => esc_html__( 'Invalid number error', 'hotelwp' ),
			'default_value' => 'This field can only contain numbers.'
		),
		'connection_error' => array(
			'name' => esc_html__( 'Connection error', 'hotelwp' ),
			'default_value' => 'There was a connection error. Please try again.'
		),
		'contact_message_sent' => array(
			'name' => esc_html__( 'Message sent', 'hotelwp' ),
			'default_value' => 'Thanks for your message! We will reply as soon as possible.'
		),
		'contact_message_not_sent' => array(
			'name' => esc_html__( 'Message not sent', 'hotelwp' ),
			'default_value' => 'An error occured. Your message has not been sent.'
		),
		'contact_already_sent' => array(
			'name' => esc_html__( 'Message already sent', 'hotelwp' ),
			'default_value' => 'Your message has already been sent.'
		),
	);
}