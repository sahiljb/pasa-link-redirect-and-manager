jQuery(function() {

	var ajaxurl = pasa_link_redirect.ajaxurl;

	jQuery(document).on('click', '#addNewRule', function(e){
		e.preventDefault();
		var fromdata = jQuery('#formAddNewRule').serialize();
		fromdata += "&action=pasa_link_redirect_request&todo=addNewRule";

		jQuery.post( ajaxurl, fromdata, function(response){
			if ( response.status == 'success' ) {
				document.getElementById("formAddNewRule").reset();
				location.reload();
			};
		});
	});

	jQuery(document).on( 'click', '.removeThisRule', function(e){
		e.preventDefault();

		var confirmDelete = confirm("Are you sure you want to delete this redirect rule?");

		if ( confirmDelete ) {
			var ruleID = jQuery(this).data('id');

			var fromdata = "id="+ruleID+"&action=pasa_link_redirect_request&todo=deleteRule";

			jQuery.post( ajaxurl, fromdata, function(response){
				if ( response.status == 'success' ) {
					location.reload();
				};
			});
		}
	});
});