(function($){

    $(document).ready(function(){
        $.getJSON(
            'https://swapi.co/api/vehicles/6',
            null,
            function(response) {
                console.log("Response:", response);
            }
        );
    });

})(jQuery);