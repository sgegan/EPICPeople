( function($) {
	$( '#advanced_front_page_form' )
		.on( 'click', '.delete-section', function(e) {
			e.preventDefault();
			var el = $(this),
				section_id = el.data( 'section' ),
				data = {
					action: 'delete_section',
					section_id: section_id,
					type: el.data( 'type' ),
				}
			$.post( ajaxurl, data, function( response ) {
				if ( 1 == response )
					location.reload();
			} );
		} )
		.find( '.add-new-section' ).click( function(e) {
			e.preventDefault();
			var data = {
					action: 'add_new_section',
					type: $(this).data( 'type' ),
				}
			$.post( ajaxurl, data, function( response ) {
				if ( 1 == response )
					location.reload();
			} );
		} );
} )(jQuery);