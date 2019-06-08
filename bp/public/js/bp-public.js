(function( $ ) {

	'use strict';
	/////////////

	/*$('.widget_weather-widget').each(function(i, widget) {

		let 
			current_weather = $(widget).find('.current-weather'),
			widget_city     = $(current_weather).data('city'),
			widget_country  = $(current_weather).data('country');

		$.post(
			bp_ajax_obj.ajax_url,
			{
				action:  'bp_get_current_weather',
				city:    widget_city,
				country: widget_country
			}
		)
		.done(function(response) {

			let html = "";

			if (response.success) {

				let current_weather = response.data;
				
				html += '<div class="conditions">';

				current_weather.conditions.forEach(function(condition) {
					html += '<img src="http://openweathermap.org/img/w/' + condition.icon + '.png" alt="' + condition.main +
					'" title="' + condition.description + '">';
				});

				html += '</div>';
				html += '<strong>Temperature: </strong>' + current_weather.temperature + '&deg;C<br>';
				html += '<strong>Humidity: </strong>' + current_weather.humidity + '%<br>';
			
			} else {
				if (response.data == 404) {
					html += "Could not find weather for this city.";
				} else {
					html += "Something went wrong, try again later.";
				}
			}
			$(current_weather).html(html);
		})
		.fail(function(error) {
			
			let errorOutput = "Something went wrong!";

			if (error.status == 404) {
				errorOutput = "Could not find weather server.";
			}

			$(current_weather).html(errorOutput);
		});

	}); // widget_weather-widget.forEach - end of weather widget*/

	$('.widget_dog-widget').each(function(i, widget) {

		let dog = $(widget).find('.dog');

		$.post(
			bp_ajax_obj.ajax_url,
			{
				action:  'bp_get_current_weather',
				city:    widget_city,
				country: widget_country
			}
		)
		.done(function(response) {

			let html = "";

			if (response.success) {

				let current_weather = response.data;
				
				html += '<div class="conditions">';

				current_weather.conditions.forEach(function(condition) {
					html += '<img src="http://openweathermap.org/img/w/' + condition.icon + '.png" alt="' + condition.main +
					'" title="' + condition.description + '">';
				});

				html += '</div>';
				html += '<strong>Temperature: </strong>' + current_weather.temperature + '&deg;C<br>';
				html += '<strong>Humidity: </strong>' + current_weather.humidity + '%<br>';
			
			} else {
				if (response.data == 404) {
					html += "Could not find weather for this city.";
				} else {
					html += "Something went wrong, try again later.";
				}
			}
			$(current_weather).html(html);
		})
		.fail(function(error) {
			
			let errorOutput = "Something went wrong!";

			if (error.status == 404) {
				errorOutput = "Could not find weather server.";
			}

			$(current_weather).html(errorOutput);
		});

	}); // widget_weather-widget.forEach - end of weather widget

})( jQuery );
