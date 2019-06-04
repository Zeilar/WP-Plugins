(function($){
    $(document).ready(function(){

        let widgets = $('.widget_oneliner-widget');
        
        for (let i = 0; i < widgets.length; i++) {
            let widget = widgets[i];

            $.post(
                cp_ol_settings.ajax_url,
                {
                    action: 'get_oneliner'
                },
                function(oneliner){
                    $(widget).find('.content').html(oneliner);
                }
            );
        }

        $('.widget_weather-widget').each(function(i, widget) {
            let current_weather = $(widget).find('.current-weather'),
                widget_city = $(current_weather).data('city'),
                widget_country = $(current_weather).data('country');

            $.post(
                cp_ajaxobj.ajax_url,
                {
                    action: 'get_current_weather',
                    city: widget_city,
                    country: widget_country
                },
            )
            .done(function(response) {
                let html = "";

                if (response.success) {
                    let current_weather = response.data;
                    
                    html += '<div class="conditions">';

                    current_weather.conditions.forEach(function(condition){
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
        });
    });
})(jQuery);

function cp_get_current_weather(widget_id, widget_city, widget_country) {
    
    let url = cp_ajaxobj.ajax_url,
        payload = {
            action: 'get_current_weather',
            city: widget_city,
            country: widget_country
        };

        jQuery.post(
            url,
            payload,
            function(data) {
                var html = "";
                html += '<strong>Temperature: </strong>' + data.temperature + '&deg;C<br>';
                html += '<strong>Humidity: </strong>' + data.humidity + '%<br>';

                jQuery('#' + widget_id + ' .current-weather').html(html);
            }
        );
}