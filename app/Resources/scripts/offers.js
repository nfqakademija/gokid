/**
 * Variables
 */
var input = (document.getElementById('address'));
var latitude = $('#latitude');
var longitude = $('#longitude');
var form = $('.index-form');
var markers = [];
var clusters = [];
var infobox = [];
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
        var id = $(this).closest('.offer').attr('data-id');
        openInfobox(id);
        map.setZoom(14);
        map.setCenter(markers[id].getPosition());
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
 * Opens infobox in map
 * @param marker
 */
function openInfobox(id) {
    closeWindows();

    markers[id].setVisible(false);
    infobox[id].open(map, markers[id]);

    return true;
}

/**
 * Generates bounds, listeners, popup windows by given offers
 * @returns {boolean}
 */
function setMapParameters(){
    bounds = new google.maps.LatLngBounds();

    for (var id in offers) {
        bounds.extend(new google.maps.LatLng(offers[id].latitude, offers[id].longitude));

        infobox[id] = new InfoBox({
            content: '<div class="marker-infowindow">' +
            '<div class="image"><a href="offer/'+id+'"><img width="100%" src="' + rootUrl + 'images/offerImages/' + offers[id].image + '" />'+
            '<div class="price">' + offers[id].price + ' € / '+getPaymentType(offers[id].paymentType)+'</div></a></div>' +
            '<a href="offer/'+id+'"><h4 class="name">' + offers[id].name + '</h4></a>' +
            '<div class="marker-content">' +
            '<span class="offer-activity">'+offers[id].address + '</span>' +
            '<span class="offer-rating">5.0</span></div>' +
            '</div>',
            closeBoxURL: '',
            pixelOffset: new google.maps.Size(-130, -260)
        });

        markers[id].addListener('click', function() {
            openInfobox(this.id);

            return false;
        });
    }

    if (markers.length > 0) {
        map.fitBounds(bounds);
    }

    map.addListener('click', function() {
        closeWindows();
    });

    return true;
}

/**
 * Closes all given windows
 * @param windows
 */
function closeWindows(){
    for (var id in markers) {
        infobox[id].close();
        markers[id].setVisible(true);
    }
}

// Sets the map on all markers in the array.
function clearMarkers() {
    closeWindows();

    for (var id in markers) {
        markers[id].setMap(null);
    }

    if (markers.length > 0) {
        markerClusterer.clearMarkers();
    }

    markers     = [];
    clusters    = [];
    infobox     = [];
}

/**
 * Sets markers
 */
function setMarkers() {
    for (var id in offers) {
        markers[id] = new google.maps.Marker({
            position: {lat: offers[id].latitude, lng: offers[id].longitude},
            map: map,
            title: offers[id].name,
            icon: green,
            id: id
        });
        clusters.push(markers[id]);
    }
}

/**
 * Updates offers by filter parameters
 */
function ajaxUpdate(page) {
    var offerObjects = $('.offer-objects');

    var url =   rootUrl + "search?address="+$('#address').val()+
                (($('#male').is(':checked')) ? '&male=1' : '')+
                (($('#female').is(':checked')) ? '&female=1' : '')+
                "&age="+$('#age').val()+
                "&latitude="+$('#latitude').val()+
                "&longitude="+$('#longitude').val()+
                "&distance="+$('#distance').val()+
                "&activity="+$( "#activity option:selected").val()+
                "&priceFrom="+$('#priceFrom').val()+
                "&priceTo="+$('#priceTo').val()+
                ((page > 0) ? '&page='+page : '');

    history.pushState(null, null, url);

    offerObjects.addClass('loading');

    $.get( url+"&ajax=1", function( data ) {
        clearMarkers();

        offerObjects.html(data);

        setMarkers();
        setMapParameters();

        markerClusterer = new MarkerClusterer(map, clusters);

        offerObjects.removeClass('loading');
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
    values: [ $( "#priceFrom" ).val(), $( "#priceTo" ).val() ],
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
