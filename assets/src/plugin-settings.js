import './styles/settings.scss';

/**
 * Search for an element with the "tabs" id then fire the "tabs" function
 *
 * @param {jQuery} $ The jQuery object to be used in the function body
 */
( ( $ ) => {
	$( () => {

		$( '#tabs' ).tabs();

		var faaone_modal = $("#faaone-plugin-modal");
        var faaone_closeBtn = $(".faaone-plugin-modal-close");
		var faaone_cancelBtn = $("#faaone-cancel-modal");

		faaone_closeBtn.on("click", function() {
			faaone_modal.css("display", "none");
		});

		faaone_cancelBtn.on("click", function() {
			faaone_modal.css("display", "none");
		});

		$(window).on("click", function(event) {
			if ($(event.target).is(faaone_modal)) {
				faaone_modal.css("display", "none");
			}
		});

	} );
	// Place your administration-specific JavaScript here
} )( jQuery );
