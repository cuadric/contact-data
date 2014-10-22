			jQuery(document).ready(function($) {
				$("#tabs").tabs();

				$( '.sortable' ).sortable({
			    	placeholder: "sortable-placeholder",
			    	handle: '.handle'
				});
    			$( '.sortable' ).disableSelection();

			});