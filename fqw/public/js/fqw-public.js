(function($) {
	'use strict';
	/////////////

	$('.widget_famous-quote-widget').each(function(i, widget) {

		let quote 	 = $(widget).find('.famous-quote');
		let category = $(quote).data('category');
		
		$.post(
			'http://wordpress.test/wp-admin/admin-ajax.php',
			{
				action:   'fqw_famous_quote__get',
				category:  category,
			}
		)
		.done(function(response) {

			let html = "";

			if (response.success) {

				let quote = response.data[0];
				
				html = '<div class="quote">';
				html += "'" + quote.quote + "'" + ' - ' + quote.author;
				html += '</div>';
			
			} else {
				if (response.data == 404) {
					html += "Could not find quote.";
				} else {
					html += "Something went wrong, try again later.";
				}
			}
			$(widget).find('.famous-quote').html(html);
		})
		.fail(function(error) {
			
			let errorOutput = "Something went wrong!";

			if (error.status == 404) {
				errorOutput = "Could not find quote.";
			}

			$(widget).find('.famous-quote').html(errorOutput);
		});

	}); // end of Famous Quote widget

})(jQuery);