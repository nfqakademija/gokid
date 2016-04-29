/**
 * Variables
 */
var input = (document.getElementById('address'));
var latitude = $('#latitude');
var longitude = $('#longitude');
var form = $('.index-form');
var markers = [];
var clusters = [];
var infowindow = [];
var map;
var markerClusterer = null;
var green = 'http://maps.google.com/mapfiles/marker_green.png';

/**
 * Hightligths marker when offer hovered
 */
$( ".offer" ).hover(
    function () {
        var id = $(this).attr('data-id');
        markers[id].setIcon(highlightedIcon());
    },
    function () {
        var id = $(this).attr('data-id');
        markers[id].setIcon(normalIcon());
    }
);

/**
 * Focuses to location on map
 */

$( ".offers" ).on( "click", ".offer-location", function() {
        closeWindows(markers);
        var id = $(this).closest('.offer').attr('data-id');
        infowindow[id].open(map, markers[id]);
        map.setCenter(markers[id].getPosition());
        map.setZoom(14);
        $(window).scrollTop($('#map').offset().top-20);
        return false;
    }
);

function normalIcon() {
    return {
        url: 'http://maps.google.com/mapfiles/marker_green.png'
    };
}
function highlightedIcon() {
    return {
        url: 'http://maps.google.com/mapfiles/marker_orange.png'
    };
}

/**
 * Returns payment type
 */
function getPaymentType(id) {
    if (id == 0) {
        return 'Vienkartinis';
    } else if (id == 1) {
        return 'Kas savaitę';
    } else {
        return 'Kas mėnesį';
    }
}

/**
 * Generates bounds, listeners, popup windows by given offers
 * @param offers
 * @returns {boolean}
 */
function setMapParameters(offers){
    bounds = new google.maps.LatLngBounds();
    var contentString = [];

    for (var offer in offers) {
        bounds.extend(new google.maps.LatLng(offers[offer].latitude, offers[offer].longitude, offers[offer].longitude));

        contentString[offer] = '<div class="marker-infowindow">' +
            '<div>' +
            '</div>' +
            '<div class="image"><a href="offer/'+offer+'"><img width="100%" src="' + rootUrl + 'images/offerImages/' + offers[offer].image + '" />'+
            '<div class="price">' + offers[offer].price + ' € / '+getPaymentType(offers[offer].paymentType)+'</div></a></div>' +
            '<a href="offer/'+offer+'"><h4 class="name">' + offers[offer].name + '</h4></a>' +
            '<div class="marker-content">' +
            '<span class="offer-activity">'+offers[offer].activity + '</span>' +
            '<span class="offer-rating">5.0</span></div>' +
            '</div>';
        infowindow[offer] = new google.maps.InfoWindow({
            content: contentString[offer]
        });

        markers[offer].addListener('click', function() {
            closeWindows(offers);

            infowindow[this.id].open(map, markers[this.id]);

            return false;
        });
    }

    if (markers.length > 0) {
        map.fitBounds(bounds);
    }

    map.addListener('click', function() {
        closeWindows(offers);
    });

    return true;
}

/**
 * Closes all given windows
 * @param windows
 */
function closeWindows(windows){
    for (var window in windows) {
        infowindow[window].close();
    }
}

// Sets the map on all markers in the array.
function clearMarkers() {
    for (var marker in markers) {
        markers[marker].setMap(null);
    }

    if (markers.length > 0) {
        markerClusterer.clearMarkers();
    }

    markers     = [];
    clusters    = [];
}

/**
 * Sets markers
 */
function setMarkers(offers) {
    for (var offer in offers) {
        markers[offer] = new google.maps.Marker({
            position: {lat: offers[offer].latitude, lng: offers[offer].longitude},
            map: map,
            title: offers[offer].name,
            icon: green,
            id: offer
        });
        clusters.push(markers[offer]);
    }
}

/**
 * Updates offers by filter parameters
 */
function ajaxUpdate(page) {
    var url =   rootUrl + "search?address="+$('#address').val()+
                (($('#male').is(':checked')) ? '&male=1' : '')+
                (($('#female').is(':checked')) ? '&female=1' : '')+
                "&age="+$('#age').val()+
                "&latitude="+$('#latitude').val()+
                "&longitude="+$('#longitude').val()+
                "&distance="+$('#distance').val()+
                "&activity="+$( "#activity option:selected").val()+
                "&priceFrom="+$('#priceFrom').val()+
                (($('#priceTo').val().indexOf('+') === -1) ? "&priceTo="+$('#priceTo').val() : '')+
                ((page > 0) ? '&page='+page : '');

    history.pushState(null, null, url);

    $('.offer-objects').addClass('loading');

    $.get( url+"&ajax=1", function( data ) {
        clearMarkers();

        $('.offer-objects').html(data);

        setMarkers(offers);
        setMapParameters(offers);

        markerClusterer = new MarkerClusterer(map, clusters);

        $('.offer-objects').removeClass('loading');
    });
}

/**
 * Prepare nice select and sticky map
 */
$('select.activities-select').niceSelect();
$('select.age-select').niceSelect();
$("#map").sticky({topSpacing:0, bottomSpacing: 85});


/**
 * Distance slider
 */
$( "#slider-range" ).slider({
    range: "min",
    value: $( "#distance" ).val(),
    min: 1,
    max: 20,
    change: function( event, ui ) {
        ajaxUpdate();
    },
    slide: function( event, ui ) {
        $( "#distance" ).val( ui.value );
        $( "#dist" ).html( ui.value );
    }
});
$('#dist').html( $( "#slider-range" ).slider( "value" ) );


/**
 * Price slider
 */
$( "#slider-price" ).slider({
    range: true,
    min: 1,
    max: 100,
    values: [ priceFrom, priceTo ],
    change: function( event, ui ) {
        ajaxUpdate();
    },
    slide: function( event, ui ) {
        $( "#price" ).html( "€" + ui.values[ 0 ] + "&nbsp;-&nbsp;€" + ui.values[ 1 ] +
            (
                (ui.values[ 1 ] == $("#slider-price").slider("option", "max")) ? '+' : ''
            )
        );

        $( "#priceFrom" ).val( ui.values[ 0 ] );
        $( "#priceTo" ).val( ui.values[ 1 ] );
    }
});

$( "#price" ).html( "€" + $( "#slider-price" ).slider( "values", 0 ) +
    "&nbsp;-&nbsp;€" + $( "#slider-price" ).slider( "values", 1 ) +
    (
        ($( "#slider-price" ).slider( "values", 1 ) === $("#slider-price").slider("option", "max")) ?
        '+' : '')
    );

/**
 * Updates offers when filter parameters are changed
 */
$('.offers-filter input').change(function() {
    if ($(this).attr('id') == 'address') {
        return false;
    }
    ajaxUpdate();
});
$('#activity').change(function() {
    ajaxUpdate();
});
$( ".offers" ).on( "click", ".pagination a", function() {
    ajaxUpdate($(this).attr('page'));
    return false;
});
