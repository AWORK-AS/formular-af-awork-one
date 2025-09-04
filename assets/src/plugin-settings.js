import './styles/settings.scss';

/**
 * Search for an element with the "tabs" id then fire the "tabs" function
 *
 * @param {jQuery} $ The jQuery object to be used in the function body
 */
( ( $ ) => {
	$( () => {
		
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
