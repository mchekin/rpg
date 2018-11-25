(function($) {
    $("#errors-alert").fadeTo(15000, 500).slideUp(500, function(){
        $("#errors-alert").slideUp(500);
    });
    $("#status-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#errors-alert").slideUp(500);
    });
})(jQuery);