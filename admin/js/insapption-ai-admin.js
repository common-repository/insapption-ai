(function( $ ) {
	'use strict';

	jQuery(document).ready(function($) {
		$('#insapption-ai-form').submit(function(e) {
			e.preventDefault();
	
			var api_key = $('#apikey').val();
			var website_url = $('#website_url').val();
			var save_nonce = insapption_ai_admin_ajax_obj.save_nonce;

			$.ajax({
				method: "POST",
				url: "https://ai.insapption.com/api/activate-api-key",
				data: { api_key: api_key, website_url: website_url },
				success: function(response) {
					if(response.message === "success"){
						$.ajax({
							method: "POST",
							url: insapption_ai_admin_ajax_obj.ajax_url,
							data: {
								action: 'save_validated_key_to_db',
								api_key: api_key,
								nonce: save_nonce
							},
							success: function() {
								alert('API key has been saved.');
								location.reload();
							},
							error: function(error){
								alert('Could not save API key. Please try again.');
							}
						});
					}
				},
				error: function(error){
					alert("Error: " + error.responseJSON.error + " Please try again.");
				}
			})
		});

		$('#revoke_api_key').click(function(e) {
			if(confirm('Are you sure you want to revoke your API Key?')){
			var website_url = $('#website_url').val();
			var api_key = $('#apikey').val();
			var revoke_nonce = insapption_ai_admin_ajax_obj.revoke_nonce;
		
			$.ajax({
				method: "POST",
				url: "https://ai.insapption.com/api/revoke-api-key", //Replace with your revoke API url
				data: { api_key: api_key, website_url: website_url },
				success: function(response) {
				if(response.message === "success"){
					$.ajax({
						method: "POST",
						url: insapption_ai_admin_ajax_obj.ajax_url,
						data: {
							action: 'revoke_validated_key_to_db',
							nonce: revoke_nonce
						},
						success: function() {
							alert('API key has been revoked.');
							location.reload();
						},
						error: function(error){
							alert('Could not revoke API key. Please try again.');
						}
					});
				}
				},
				error: function(error){
					alert("Error: " + error.responseJSON.error + " Please try again.");
				}
			})
			}
		});
	});

})( jQuery );
