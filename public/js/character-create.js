(function($) {
    var carouselRace = $(".carousel-race");
    var carouselGender = $(".carousel-gender");

    var carouselRaceControl = $('#race-carousel');
    var carouselGenderControl = $('#gender-carousel');

    // Enable Carousel Controls
    function changeRace() {
        var raceIdRegex = /^(?:\w+)-(?:\w+)-([0-9]+)$/;
        var raceIdString = $('.item.active', carouselRaceControl).attr('id');
        var matches = raceIdRegex.exec(raceIdString);
        $('#race_id').val(matches[1]);
    }

    function changeGender() {
        var gender = $('.item.active', carouselGenderControl).attr('id');
        $('.img-race',carouselRace).hide();
        $('.img-'+gender, carouselRace).show();
        $('#gender').val(gender);
    };

    $(".left-race").click(function () {
        carouselRace.carousel("prev");
        changeRace();
    });
    $(".right-race").click(function () {
        carouselRace.carousel("next");
        changeRace();
    });

    $(".left-gender").click(function () {
        carouselGender.carousel("prev");
        changeGender();
    });
    $(".right-gender").click(function () {
        carouselGender.carousel("next");
        changeGender();
    });
})(jQuery );
