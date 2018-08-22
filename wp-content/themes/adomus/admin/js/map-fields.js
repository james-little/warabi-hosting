jQuery( document ).ready( function( $ ) {

    $( 'body' ).on( 'click', '.adomus-add-map-point', function() {
        $( this ).blur();
        var $map_points = $( this ).parents( '.adomus-section-fields' ).find( '.adomus-map-points' ),
            $new_point_markup = $( '<div></div>' );
        $new_point_markup.addClass( 'adomus-map-point' );
        $new_point_markup.html( $( '.adomus-map-new-point' ).html() );
        $new_point_markup.find( '.adomus-new-point-number' ).html( $map_points.find( '.adomus-map-point' ).length + 1 );
        $map_points.append( $new_point_markup );
        update_map_points_json( $( this ).parents( '.adomus-section-fields' ) );
    });
    
    $( 'body' ).on( 'click', '.adomus-delete-map-point', function() {
        if ( confirm( adomus_meta_box_strings.delete_point ) ) {
            var $section = $( this ).parents( '.adomus-section-fields' );
            $( this ).blur();
            $( this ).parents( '.adomus-map-point' ).remove();
            update_map_points_json( $section );
        }
        return false;
    });
        
    $( 'body' ).on( 'change', '.adomus-map-point-lat, .adomus-map-point-lng, .adomus-map-point-caption', function() {
        update_map_points_json( $( this ).parents( '.adomus-section-fields' ) );
    });
    
    function update_map_points_json( $section ) {
        var $input_json = $section.find( '.adomus-map-point-json' ),
            $map_points = $section.find( '.adomus-map-point' );
            map_points = [];
        $map_points.each( function() {
            var map_point = {
                'lat' : $( this ).find( '.adomus-map-point-lat' ).val(),
                'lng' : $( this ).find( '.adomus-map-point-lng' ).val(),
                'caption' : $( this ).find( '.adomus-map-point-caption' ).val(),
            };
            map_points.push( map_point );
        });
        $input_json.val( JSON.stringify( map_points ) );
    }
    
});
