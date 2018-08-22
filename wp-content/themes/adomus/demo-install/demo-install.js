jQuery( document ).ready( function( $ ) {
	
	"use strict";
	
	var jq_queue = $({});
	
	var ajax_queue = function( ajax_options ) {
		var old_complete = ajax_options.complete;

		jq_queue.queue(function(next) {
			ajax_options.complete = function() {
				if ( old_complete ) {
					old_complete.apply(this, arguments);
				}
				next();
			};
			$.ajax(ajax_options);
		});
	};
	
	var installing = false;
	
	$( '.hotelwp-demo-install' ).click( function( e ) {
		e.preventDefault();
		$( this ).blur();
		
		if ( installing ) {
			alert( hotelwp_demo_install_data.already_installing )
			return;
		}
		
		$( '.hotelwp-install-step' ).hide().removeClass( 'hotelwp-install-step-ok hotelwp-install-step-ko');
		$( '.hotelwp-install-log' ).html( '' );
		
		var install_steps = hotelwp_demo_install_data.steps,
			demo_num = $( this ).data( 'demo-num' ),
			error_occured = false;
		
		if ( confirm( hotelwp_demo_install_data.confirm_text ) ) {
			installing = true;
			$( '.hotelwp-install-step-' + install_steps[ 0 ] ).css( 'display', 'block' ).addClass( 'hotelwp-install-step-processing' );
			for ( var i = 0; i < install_steps.length; i++ ) {
				if ( install_steps[ i ] != 'all_done' ) {
					var action_install_step = '',
						sub_step = 0;
					if ( install_steps[ i ].indexOf( '__' ) != -1 ) {
						action_install_step = install_steps[ i ].substr( 0, install_steps[ i ].indexOf( '__' ) );
						sub_step = install_steps[ i ].slice( -1 );
					} else {
						action_install_step = install_steps[ i ];
					}
					ajax_queue({
						url: ajaxurl,
						data: {
							action: 'hotelwp_install_step_' + action_install_step,
							sub_step: sub_step,
							demo_num: demo_num,
							hotelwp_theme_install_nonce: $( '#hotelwp_theme_install_nonce' ).val()
						},
						type: 'POST',
						success: function( install_step, install_step_next ) {
							return function( response ) {
								if ( response == 'ok' ) {
									$( '.hotelwp-install-step-' + install_step ).addClass( 'hotelwp-install-step-ok' );
								} else {
									response = response.replace( 'ok', '' );
									error_occured = true;
									$( '.hotelwp-install-log' ).append( response );
									$( '.hotelwp-install-step-' + install_step ).addClass( 'hotelwp-install-step-ko' );
								}
								
								$( '.hotelwp-install-step-' + install_step ).removeClass( 'hotelwp-install-step-processing' );
								if ( install_step_next == 'all_done' ) {
									installing = false;
									if ( ! error_occured ) {
										$( '.hotelwp-install-step-all_done' ).css( 'display', 'block' );
									} else {
										$( '.hotelwp-install-step-all_done-with-error' ).css( 'display', 'block' );
									}
								} else {
									$( '.hotelwp-install-step-' + install_step_next ).css( 'display', 'block' ).addClass( 'hotelwp-install-step-processing' );
								}
							}
						}( install_steps[ i ], install_steps[ i + 1 ] )
					});
				}
			}
		}
	});
	
});