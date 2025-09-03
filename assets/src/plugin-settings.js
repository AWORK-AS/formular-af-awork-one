import './styles/settings.scss';

/**
 * Search for an element with the "tabs" id then fire the "tabs" function
 *
 * @param {jQuery} $ The jQuery object to be used in the function body
 */
( ( $ ) => {
	$( () => {
		var facioj_transients = window.facioj_transients;
		let facioj_required_error_messages, facioj_api_error_message;
		if ( facioj_transients ) {
			facioj_required_error_messages = facioj_transients.required_error_messages ?? null;
			facioj_api_error_message = facioj_transients.api_error_message ?? null;
		}

		if( facioj_required_error_messages || facioj_api_error_message ) {
			
		}
		$( '#tabs' ).tabs();
		var facioj_modal = $("#facioj-plugin-modal");
        var facioj_closeBtn = $(".facioj-plugin-modal-close");
		var facioj_cancelBtn = $("#facioj-cancel-modal");

		facioj_closeBtn.on("click", function() {
			facioj_modal.css("display", "none");
		});
		
		facioj_cancelBtn.on("click", function() {
			facioj_modal.css("display", "none");
		});
		
		$(window).on("click", function(event) {
			if ($(event.target).is(facioj_modal)) {
				facioj_modal.css("display", "none");
			}
		});

	} );
	// Place your administration-specific JavaScript here
} )( jQuery );
