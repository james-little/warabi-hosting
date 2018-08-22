jQuery( document ).ready( function( $ ) {
	
	if ( ! wp.media ) {
		return;
	}

	$( '.adomus-add-media-wrapper' ).each( function() {
		if ( $( this ).find( '.adomus-add-media-chosen img' ).length ) {
			$( this ).find( '.adomus-add-media-link-text' ).hide();
			$( this ).find( '.adomus-remove-media-link' ).show();
		} else {
			$( this ).find( '.adomus-add-media-link' ).show();
			$( this ).find( '.adomus-remove-media-link' ).hide();
		}
	});

	$( 'body' ).on( 'click', '.adomus-add-media-link', function() {
		var all_media_window = wp.media({
			title: adomus_media_window_strings.add_media,
			library: { type: 'image, video' },
			multiple: false,
			button: { text: adomus_media_window_strings.add_media }
		});
		
		var img_media_window = wp.media({
			title: adomus_media_window_strings.add_img,
			library: { type: 'image' },
			multiple: false,
			button: { text: adomus_media_window_strings.add_img }
		});
		
		var video_media_window = wp.media({
			title: adomus_media_window_strings.add_video,
			library: { type: 'video' },
			multiple: false,
			button: { text: adomus_media_window_strings.add_video }
		});
		
		var $link = $( this ),
            $wrap = $link.parents( '.adomus-add-media-wrapper' );
        
		if ( $link.hasClass( 'adomus-add-img' ) ) {
			var media_window = img_media_window;
		} else if ( $link.hasClass( 'adomus-add-video' ) ) {
			var media_window = video_media_window;
		} else {
			var media_window = all_media_window;	
		}
        
        media_window.on( 'open', function() {
			var selection = media_window.state().get( 'selection' ),
                img_id = $wrap.find( 'input' ).val();
            
			if ( img_id ) {
                selection.add( wp.media.attachment( img_id ) );
			}
		});
        
		media_window.open();
		
		media_window.on( 'select', function() {
			var media_info = media_window.state().get('selection').first();
			if ( media_info.attributes.type == 'image' ) {
				var thumbnail_source = media_info.attributes.url;
				var thumbnail_style = 'width: 200px;';
				var thumbnail_title = '';
			} else {
				var thumbnail_source = media_info.attributes.icon;
				var thumbnail_style = 'width: 48px;';
				var thumbnail_title = '<br/>' + media_info.attributes.title;
			}
			$wrap.find( '.adomus-add-media-chosen a' ).html( '<img style="' + thumbnail_style + '" src="' + thumbnail_source + '" />' + thumbnail_title );
			$wrap.find( '.adomus-add-media-chosen' ).show();
			$wrap.find( '.adomus-add-media-input' ).val( media_info.attributes.id );
			$wrap.find( '.adomus-add-media-link-text' ).hide();
			$wrap.find( '.adomus-remove-media-link' ).show();
		});
		return false;
	});

	$( 'body' ).on( 'click', '.adomus-remove-media-link', function() {
        var $wrap = $( this ).parents( '.adomus-add-media-wrapper' );
		$wrap.find( '.adomus-add-media-chosen a' ).html( '' );
		$wrap.find( '.adomus-add-media-chosen' ).hide();
		$wrap.find( '.adomus-add-media-input' ).val( '' );
		$wrap.find( '.adomus-add-media-link' ).show();
		$wrap.find( '.adomus-remove-media-link' ).hide();
		return false;
	});

});
