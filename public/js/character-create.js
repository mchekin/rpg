(function($) {
    var carouselRace = $(".carousel-race");
    var carouselGender = $(".carousel-gender");

    // Enable Carousel Controls
    $(".left-race").click(function () {
        carouselRace.carousel("prev");
    });
    $(".right-race").click(function () {
        carouselRace.carousel("next");
    });

    $(".left-gender").click(function () {
        carouselGender.carousel("prev");
        changeGenderImage();
    });
    $(".right-gender").click(function () {
        carouselGender.carousel("next");
        changeGenderImage();
    });

    var changeGenderImage = function () {
        var gender = $('.item.active', carouselGender).attr('id');
        $('.img-race',carouselRace).hide();
        $('.img-'+gender, carouselRace).show();
    };

})(jQuery );