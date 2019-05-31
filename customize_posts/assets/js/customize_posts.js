(function($){

    $(document).ready(function(){
        $.post(
            cp_ajaxobj.ajax_url,
            {
                action: 'get_current_weather'
            },
            null,
            function(response) {
                console.log("Response:", response);
            }
        );
    });

})(jQuery);