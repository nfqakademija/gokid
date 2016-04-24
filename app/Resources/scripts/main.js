/* Offers */

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
$( ".offer-location" ).click(
    function(){
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
 * Generates bounds, listeners, popup windows by given offers
 * @param offers
 * @returns {boolean}
 */
function setMapParameters(offers){
    bounds = new google.maps.LatLngBounds();
    var contentString = [];

    for (var offer in offers) {
        bounds.extend(new google.maps.LatLng(offers[offer].latitude, offers[offer].longitude, offers[offer].longitude));

        console.log(rootUrl);
        contentString[offer] = '<div class="marker-infowindow">' +
            '<div>' +
            '</div>' +
            '<div class="image"><a href="offer/'+offer+'"><img width="100%" src="' + rootUrl + '/images' + offers[offer].image + '" /><div class="price">' + offers[offer].price + ' € / Mėn</div></a></div>' +
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
    map.fitBounds(bounds);

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

/* End of Offers */

/* Index search */

// Age input popover

$('#age').popover({
    content: $('#popover-content').html(),
    html: true
}).click(function() {
    $('.button-container').click(function () {
        $('#age').val($(this).text()).popover('hide');
    });
});

$('body').on('click', function (e) {
    $('[data-toggle="popover"]').each(function () {
        //the 'is' for buttons that trigger popups
        //the 'has' for icons within a button that triggers a popup
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
});

/* End of index search */