jQuery(document).ready( function( $ ) {

	$(  '.hotelwp-settings-save' ).click( function() {
		$( this ).blur();
		var $wrap = $( this ).parents( '.hotelwp-settings-save-wrapper' );
        $wrap.find( '.hotelwp-saving-settings' ).css( 'display', 'inline-block' );
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			timeout: 10000,
			data: $( '#hotelwp-theme-strings-form' ).serialize(),
			success: function( ajax_return ) {
				$wrap.find( '.hotelwp-saving-settings' ).css( 'display', 'none' );
				if ( ajax_return.trim() == 'settings_saved' ) {
                    settings_saved = true;
					$wrap.find( '.hotelwp-settings-saved' ).slideDown();
					setTimeout( function() {
                        $wrap.find( '.hotelwp-settings-saved' ).fadeOut();
                    }, 5000 );
				} else {
					alert( hotelwp_settings_text.can_not_save + ' (' + ajax_return + ')');	
				}
			},
			error: function () {
                $wrap.find( '.hotelwp-settings-saved' ).css( 'display', 'none' );
				alert( hotelwp_settings_text.can_not_save );
			}
		});
	});
	
	var settings_saved = true;
    $( '.hotelwp-settings' ).on( 'change', 'input', function() {
		settings_saved = false;
	});

	window.onbeforeunload = function() {
		if ( ! settings_saved ) {
			return hotelwp_settings_text.unsaved_warning;
		}
	 }
	 
	 $( '.hotelwp-export-lang-file' ).click( function() {
		$( this ).blur();
		$( '#hotelwp-locale-export' ).val( $( this ).data( 'locale' ) );
		$( '#hotelwp-export-lang-form' ).submit();
		return false;
	});

	$( '#hotelwp-import-file-form' ).submit( function() {
		$( '#hotelwp-import-lang-submit' ).blur();
		if ( $( '#hotelwp-import-lang-code' ).val() == '' ) {
			alert( hotelwp_settings_text.select_language );
			return false;
		}
		if ( $( '#hotelwp-import-lang-file' ).val() == '' ) {
			alert( hotelwp_settings_text.choose_file );
			return false;
		}
	});

});