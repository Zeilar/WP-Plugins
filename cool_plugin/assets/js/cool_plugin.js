(function($){

    $(document).ready(function() {

        let widgets = $('.widget_oneliner-widget');
        
        for (let i = 0; i < widgets.length; i++) {

            let widget = widgets[i];

            $.post(
                cp_ajax_obj.ajax_url,
                {
                    action: 'get_oneliner'
                },
                function(oneliner) {
                    $(widget).find('.content').html(oneliner);
                }
            );
        } // end of oneliner widget

        $('.widget_weather-widget').each(function(i, widget) {

            let 
                current_weather = $(widget).find('.current-weather'),
                widget_city     = $(current_weather).data('city'),
                widget_country  = $(current_weather).data('country');

            $.post(
                cp_ajax_obj.ajax_url,
                {
                    action:  'get_current_weather',
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

        $('.widget_starwars-widget').each(function(i, widget) {

            $.post(
                cp_ajax_obj.ajax_url,
                {
                    action: 'get_starwars_films'
                }
            )
            .done(function(response) {

                let 
                    html             = '',
                    films            = response,
                    content          = $(widget).find('.content');


                films.forEach(function(film) {
                    html += '<strong>Title: </strong>' + film.title;
                    html += '<br>';
                    html += '<strong>Release Date: </strong>' + film.release_date;
                    html += '<br><br>';
                });
                

                $(content).html(html);
            })
            .fail(function(error) {

                let errorOutput = "Something went wrong!";

                if (error.status == 404) {
                    errorOutput = "Data not found.";
                }

                $(content).html(errorOutput);
            });

        }); // widget_starwars-widget.each - end of Star Wars widget

    }); // document.ready

})(jQuery);