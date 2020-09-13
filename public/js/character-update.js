(function ($) {

    $(".increment_attribute").click(function (event) {

        let attributeName = this.id;

        $('#attribute_input').val(attributeName);
    });

})(jQuery);
