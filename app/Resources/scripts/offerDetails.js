/**
 * Variables
 */
var ratingStar = $('#rating label');

/**
 * Owl carousel
 */
$(".owl-carousel").owlCarousel({
    loop: true,
    autoplay: true,
    autoplayTimeout: 2000,
    responsiveClass: true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000 :{
            items:3
        }
    }
});

/**
 * Initializes map
 * @param lat
 * @param lng
 */
function detailsMap(lat, lng) {
    map = new google.maps.Map(document.getElementById('map-details'), {
        zoom: 15,
        center: {lat: lat, lng: lng},
        scrollwheel: false,
        zoomControlOptions: {
            position: google.maps.ControlPosition.LEFT_TOP
        }
    });
    marker = new google.maps.Marker({
        position: {lat: lat, lng: lng},
        map: map,
        icon: green,
    });
}

/**
 * Keeps rating value after click
 */
ratingStar.click(function () {
    $('.rating label').removeClass('selected');
    $( this ).addClass('selected');
});

ratingStar.mouseover(function () {
    $('#post-rating').html($(this).attr('title'));
});

ratingStar.mouseout(function () {
    $('#post-rating').html($('#rating .selected').attr('title'));
});
