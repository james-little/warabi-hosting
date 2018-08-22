jQuery( document ).ready( function( $ ) {
	
	var Field = function( id, name, required, type, choices, column_width ) {
		var self = this;
		this.id = ko.observable( id );
		this.name = ko.observable( name );
		this.type = ko.observable( type );
		this.column_width = ko.observable( column_width );
		this.required_yes_input_id = ko.computed( function() {
			return this.id() + '_required_yes';
		}, this );
		this.required_no_input_id = ko.computed( function() {
			return this.id() + '_required_no';
		}, this );
		this.data_about_customer_input_id = ko.computed( function() {
			return this.id() + '_data_about_customer';
		}, this );
		this.data_about_booking_input_id = ko.computed( function() {
			return this.id() + '_data_about_booking';
		}, this );
		this.required = ko.observable( required );
		this.choices = ko.observableArray();
		for ( var i = 0; i < choices.length; i++ ) {
			this.choices.push( choices[i] );
		}
		this.editing_name = ko.observable( false );
		
		this.add_choice = function() {
			var id = get_unique_choice_id( 'new_choice' );
			if ( id ) {
				form_saved = false;
				self.choices.unshift( new Choice( id, hotelwp_settings_text.new_choice ) );
			} else {
				alert( 'Too many new choices. Please start renaming choices.' );
			}
		}
		
		this.remove_choice = function( choice ) {
			if ( confirm( hotelwp_settings_text.confirm_delete_choice.replace( '%choice_name', choice.name() ) ) ) {
				self.choices.remove( choice );
				form_saved = false;
			}
		}
		
		this.edit_choice_name = function( choice ) {
			choice.editing_choice( true );
		}
		
		this.stop_edit_choice_name = function( choice ) {
			choice.editing_choice( false );
			$( '.hotelwp-cf-input-choice-name' ).blur();
			var new_id = get_unique_choice_id( choice.name() );
			if ( new_id ) {
				choice.id( new_id );
			}
		}
		
		function get_unique_choice_id( name ) {
			return get_unique_id( name, self.choices() );
		}
		
	}
	
	var Choice = function( id, name ) {
		this.id = ko.observable( id );
		this.name = ko.observable( name );
		this.editing_choice = ko.observable( false );
	}
	
	var FieldsViewModel = function() {
		var self = this;
		
		var observable_fields = [];
		for ( var i = 0; i < hotelwp_cf_fields.length; i++ ) {
			var observable_choices = [];
			for ( var j = 0; j < hotelwp_cf_fields[i].choices.length; j++ ) {
				observable_choices.push( new Choice( hotelwp_cf_fields[i].choices[j].id, hotelwp_cf_fields[i].choices[j].name ) );
			}
			observable_fields.push( new Field( hotelwp_cf_fields[i].id, hotelwp_cf_fields[i].name, hotelwp_cf_fields[i].required, hotelwp_cf_fields[i].type, observable_choices, hotelwp_cf_fields[i].column_width ) );
		}
		self.fields = ko.observableArray( observable_fields );
		
		function new_field( id ) {
			var standard = 'no',
				id = id,
				name = hotelwp_settings_text.new_field,
				column_width = '',
				required = 'no',
				type = 'text',
				choices = [];
			
			return new Field( id, name, required, type, choices, column_width );
		}
		
		this.add_field_top = function() {
			$( '#hotelwp-cf-add-field-top' ).blur();
			var id = get_unique_field_id( 'new_field' );
			if ( id ) {
				form_saved = false;
				self.fields.unshift( new_field( id ) );
				$( '.hotelwp-cf-fields-container .hotelwp-cf-field' ).first().hide().slideDown();
			} else {
				alert( 'Too many new fields. Please start renaming fields.' );
			}
		}
		
		this.add_field_bottom = function() {
			$( '#hotelwp-cf-add-field-bottom' ).blur();
			var id = get_unique_field_id( 'new_field' );
			if ( id ) {
				form_saved = false;
				self.fields.push( new_field( id ) );
				$( '.hotelwp-cf-fields-container .hotelwp-cf-field' ).last().hide().slideDown();
			} else {
				alert( 'Too many new fields. Please start renaming fields.' );
			}			
		}
		
		this.remove_field = function( field ) {
			var confirm_text,
				no_name_fields = [ 'column_break', 'separator' ];
			
			if ( no_name_fields.indexOf( field.type() ) > -1 ) {
				confirm_text = hotelwp_settings_text.confirm_delete_field_no_name;
			} else {
				confirm_text = hotelwp_settings_text.confirm_delete_field.replace( '%field_name', field.name() );
			}
			if ( confirm( confirm_text ) ) {
				form_saved = false;
				$( '#' + field.id() ).slideUp( function() {
					self.fields.remove( field );
				});
			}
		}
		
		this.edit_field_name = function( field ) {
			field.editing_name( true );
		}
		
		this.stop_edit_field_name = function( field ) {
			field.editing_name( false );
			$( '.hotelwp-cf-input-field-name' ).blur();
			var new_id = get_unique_field_id( field.name() );
			if ( new_id ) {
				field.id( new_id );
			}
		}
			
		function get_unique_field_id( name ) {
			return get_unique_id( name, self.fields() );
		}
		
		this.variables_list = ko.computed( function() {
			var fields = self.fields(),
				ids = [],
				j = 0,
				no_info_fields = [ 'column_break', 'title', 'sub_title', 'explanation', 'separator' ];
				
			for ( var i = 0; i < fields.length; i++ ) {
				if ( no_info_fields.indexOf( fields[i].type() ) < 0 ) {
					if ( j % 3 == 0 ) {
						ids.push( '<br/>[' + fields[i].id() + ']' );
					} else {
						ids.push( '[' + fields[i].id() + ']' );
					}
					j++;
				}
			}
			return hotelwp_settings_text.variables_intro + ids.join( '&nbsp;&nbsp;-&nbsp;&nbsp;' );
		});
		
	}
	
	function get_unique_id( name, stack ) {
		var id_already_taken,
			id_candidate_max_length = 45,
			id_candidate = name.toLowerCase().replace( /\s/g, '_' ).replace( /[^a-z0-9_]+/g, '' ).substring( 0, id_candidate_max_length );

		for ( var i = 0; i < stack.length; i++ ) {
			if ( stack[i].id() == id_candidate ) {
				id_already_taken = true;
			}
		}
		if ( ! id_already_taken ) {
			return id_candidate;
		}
		for ( var id_num = 2; id_num < 100; id_num++ ) {
			id_already_taken = false;
			for ( var i = 0; i < stack.length; i++ ) {
				if ( stack[i].id() == id_candidate + '_' + id_num ) {
					id_already_taken = true;
				}
			}
			if ( ! id_already_taken ) {
				id_candidate += '_' + id_num;
				return id_candidate;
			}
		}
		return false;
	}
	
	ko.bindingHandlers.sortable.options = { distance: 5 };
	
	var viewModel = new FieldsViewModel();
	
	ko.applyBindings( viewModel );	
	
	$( '.hotelwp-settings-save' ).click( function() {
		$( this ).blur();
		var $wrap = $( this ).parents( '.hotelwp-settings-save-wrapper' );
        $wrap.find( '.hotelwp-saving-settings' ).css( 'display', 'inline-block' );
		$( '#hotelwp_cf_fields' ).val( ko.toJSON( viewModel ) );
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			timeout: 10000,
			data: $( '#hotelwp-cf-settings' ).serialize(),
			success: function( ajax_return ) {
				$wrap.find( '.hotelwp-saving-settings' ).css( 'display', 'none' );
				if ( ajax_return.trim() == 'settings_saved' ) {
                    form_saved = true;
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

	var form_saved = true;

	$( '.hotelwp-contact-form-settings' ).on( 'change', 'input, select', function() {
		form_saved = false;
	});
	
	window.onbeforeunload = function() {
		if ( ! form_saved ) {
			return hotelwp_settings_text.unsaved_warning;
		}
     }
	 
});