
 function adomus_sortable_elts( $wrapper_sortable_elt, sortable_elt, $meta_field ) {
     $wrapper_sortable_elt.sortable({ 
         placeholder: 'adomus-sorting-state',
         forcePlaceholderSize: true,
         distance: 5,
         update: function( event, ui ) {
             $meta_field.val( adomus_get_ordered_list( sortable_elt ) );
         }
     });
 }
 
 function adomus_get_ordered_list( sortable_elt ) {
     var ordered_list = [];
     jQuery( sortable_elt ).each( function() {
         var id = jQuery( this ).data( 'id' );
         ordered_list.push( id );
     });
     ordered_list.join( ',' );
     return ordered_list;
 }

jQuery( document ).ready( function( $ ) {    
	$( '.adomus-multiple-imgs-select' ).each( function() {
		adomus_sortable_elts( $( this ).find( 'ul' ), '#' + $( this ).attr( 'id' ) + ' ul li', $( this ).find( 'input' ) );
	});
    
    adomus_sortable_elts( $( '#adomus-sections-organizer' ), '#adomus-sections-organizer .adomus-section', $( '#adomus-sections-organizer-input') );	
});