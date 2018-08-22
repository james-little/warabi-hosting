jQuery( document ).ready( function( $ ) {
	
    display_meta();
    
	$( '#page_template, #hb-accom-page-template' ).on( 'change', function() {
		display_meta();
	}).change();

    function display_meta() {
        var meta_boxes = ['booking', 'scroll', 'sections', 'footer'],
            template =  $( '#page_template option:selected' ).val() || $( '#hb-accom-page-template option:selected' ).val();
        for ( var i = 0; i < meta_boxes.length; i++ ) {
            if ( template == 'template-advanced-layout.php' ) {
                $( '#adomus-meta-box-' + meta_boxes[ i ] ).show();
            } else {
                $( '#adomus-meta-box-' + meta_boxes[ i ] ).hide();
            }
        }
    }
    
	$( '#adomus-sections-organizer' ).on( 'click', '.adomus-section-open', function() {
		$( this ).parents( '.adomus-section' ).removeClass( 'adomus-section-closed' ).addClass( 'adomus-section-opened' );
		$( this ).parents( '.adomus-section' ).find( '.section-editor-state input' ).val( 'opened' );
		return false;
	});
	    
	$( '#adomus-sections-organizer' ).on( 'click', '.adomus-section-close', function() {
		$( this ).parents( '.adomus-section' ).removeClass( 'adomus-section-opened' ).addClass( 'adomus-section-closed' );
		$( this ).parents( '.adomus-section' ).find( '.section-editor-state input' ).val( 'closed' );
		return false;
	});
	
	$( '#adomus-add-section' ).click( function() {
		$( this ).blur();
		if ( ! $( '#adomus-add-section-type' ).val() ) {
			alert( adomus_meta_box_strings.select_section_type );
			$( '#adomus-add-section-type' ).focus();
		} else {
			var section_type = $( '#adomus-add-section-type' ).val(),
				section = $( '#adomus-section-creator .adomus-section-' + section_type )[0].outerHTML,
				num = 0,
				id,
				$section;
				
			$( '#adomus-sections-organizer .adomus-section-' + section_type ).each( function() {
				if ( $( this ).data( 'num' ) > num ) {
					num = $( this ).data( 'num' );
				}
			});
			num = num + 1;
			$( '#adomus-sections-organizer' ).prepend( section );
			$section = $( '#adomus-sections-organizer .adomus-section[data-id="' + section_type + '__0"]' );
			id = section_type + '__' + num;
			$section.attr( 'data-num', num ).attr( 'data-id', id );
			var organizer_current_value = $( '#adomus-sections-organizer-input' ).val();
			if ( organizer_current_value ) {
				$( '#adomus-sections-organizer-input' ).val( id + ',' + organizer_current_value );
			} else {
				$( '#adomus-sections-organizer-input' ).val( id );	
			}
			$section.find( 'input, select, textarea, .adomus-multiple-imgs-select' ).each( function() {
				if ( $( this ).attr( 'name') ) {
					$( this ).attr( 'name', $( this ).attr( 'name' ).replace( '__0', '__' + num ) );
				}
				if ( $( this ).attr( 'id') ) {
					$( this ).attr( 'id', $( this ).attr( 'id' ).replace( '__0', '__' + num ) );
				}
			});
			$section.find( 'label' ).each( function() {
				if ( $( this ).attr( 'for' ) ) {
					$( this ).attr( 'for', $( this ).attr( 'for' ).replace( '__0', '__' + num ) );
				}
			});
			if ( section_type == 'gallery' || section_type == 'fancy_slider' ) {
				$section.find( '.adomus-multiple-imgs-select' ).each( function() {
					adomus_sortable_elts( $( this ).find( 'ul' ), '#' + $( this ).attr( 'id' ) + ' ul li', $( this ).find( 'input' ) );
				});
			}
			if ( section_type == 'custom' ) {
				if ( wp.editor.initialize ) {
					wp.editor.initialize( 
						'adomus_custom__' + num + '_content', {
							tinymce: {
								wpautop: false,
								toolbar1: 'formatselect bold italic bullist numlist blockquote alignleft aligncenter alignright link unlink wp_more spellchecker dfw',
								toolbar2: 'strikethrough hr forecolor pastetext removeformat charmap outdent indent undo redo wp_help'
							}, 
							quicktags: { 
								buttons : 'strong,em,link,block,del,ins,img,ul,ol,li,code,more,close' 
							}
						}
					);
				} else {
					$( '#adomus_custom__' + num + '_content' ).before( '<p>Editor could not be loaded (WordPress version < 4.8). Update the page to reload the editor.</p>' );
				}
			}
		}
		return false;
	});
	
	$( '#adomus-sections-organizer' ).on( 'click', '.adomus-section-delete', function() {
		if ( confirm( adomus_meta_box_strings.delete_section ) ) {
			var sections = $( '#adomus-sections-organizer-input' ).val();
			sections = sections.split( ',' );
			sections.splice( sections.indexOf( $( this ).parents( '.adomus-section' ).data( 'id') ), 1 );
			sections = sections.join( ',' );
			$( '#adomus-sections-organizer-input' ).val( sections );
			$( this ).parents( '.adomus-section' ).remove();
		}
		return false;
	});
	
});
