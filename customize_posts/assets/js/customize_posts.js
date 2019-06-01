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