jQuery( document ).ready( function( $ ) {
	
	if ( ! wp.media ) {
		return;
	}
	
	$( 'body' ).on( 'click', '.adomus-select-multiple-imgs', function() {
		
		var $wrapper = $( this ).parents( '.adomus-multiple-imgs-select' ),
            imgs_media_window = wp.media({
                title: adomus_media_window_strings.select_imgs,
                library: { type: 'image' },
                multiple: 'add',
            });
        
		imgs_media_window.on( 'open', function() {
			var selection = imgs_media_window.state().get( 'selection' ),
                ids_str = $wrapper.find( 'input' ).val();
            
			if ( ids_str != '' ) {
				ids = ids_str.split( ',' );
				for ( var i = 0; i < ids.length; i++ ) {
					var attachment = wp.media.attachment( ids[i] );
					selection.add( attachment );
				}
			}
		});
	
		imgs_media_window.open();
		
		imgs_media_window.on( 'select', function() {
			var selection = imgs_media_window.state().get('selection'),
				new_ids = [],
				new_imgs = [];
			selection.map( function( attachment ) {
				attachment = attachment.toJSON();
				if ( attachment.url ) {
					new_ids.push( attachment.id );
					new_imgs[ attachment.id ] = attachment.url;
				}
			});
			var ordered_ids = [],
				ids = $wrapper.find( 'input' ).val();
			for ( var i = 0; i < ids.length; i++ ) {
				if ( new_ids.indexOf( ids[i] ) > -1 ) {
					ordered_ids.push( ids[i] );
					new_ids.remove( ids[i] );
				}
			}
			ordered_ids = ordered_ids.concat( new_ids );
			$wrapper.find( 'input' ).val( ordered_ids.join() );
			var mark_up = '';
			for ( var i = 0; i < ordered_ids.length; i++ ) {
				mark_up += '<li data-id="' + ordered_ids[i] + '" style="height: 100px; overflow: hidden;" ><img style="width: 200px; cursor: move;" src="' + new_imgs[ ordered_ids[i] ] + '" /></li>';
			}
            if ( ordered_ids.length ) {
                $wrapper.find( '.adomus-remove-all-multiple-imgs' ).show();    
            } else {
                $wrapper.find( '.adomus-remove-all-multiple-imgs' ).hide();
            }
			$wrapper.find( 'ul' ).html( mark_up );
		});
		return false;
	});
	
    $( 'body' ).on( 'click', '.adomus-remove-all-multiple-imgs', function() {
        var $wrapper = $( this ).parents( '.adomus-multiple-imgs-select' );
        if ( confirm( adomus_media_window_strings.confirm_remove_all_imgs.replace( '%s', $wrapper.data( 'sub-type' ) ) ) ) {
            $wrapper.find( 'ul' ).html( '' );
            $wrapper.find( 'input' ).val( '' );
            $( this ).hide();
        }
        return false;
    });
    
    $( '.adomus-multiple-imgs-select' ).each( function() {
        if ( $( this ).find( 'img' ).length ) {
            $( this ).find( '.adomus-remove-all-multiple-imgs' ).show();
        }
    });
        
});
