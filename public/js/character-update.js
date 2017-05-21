(function($) {

    $(".increment_attribute").click(function(event){
        var attributeName = this.id;
        $('#attribute_input').val(attributeName);
    });

})(jQuery );
