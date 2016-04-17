/* Offers */

$( ".offer" ).hover(
    function () {
        // first we need to know which <div class="marker"></div> we hovered
        var id = $(this).attr('data-id');
        markers[id].setIcon(highlightedIcon());
    },
    // mouse out
    function () {
        // first we need to know which <div class="marker"></div> we hovered
        var id = $(this).attr('data-id');
        markers[id].setIcon(normalIcon());
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

function getBounds(offers){
    bounds = new google.maps.LatLngBounds();

    for (var offer in offers) {
        bounds.extend(new google.maps.LatLng(offers[offer].latitude, offers[offer].longitude, offers[offer].longitude));
    }
    return bounds;
}

function getInfowindows(offers){
    var contentString = [];
    var infowindow = [];
    for (var offer in offers) {
        contentString[offer] = '<div id="content">' +
            '<div id="siteNotice">' +
            '</div>' +
            '<a href=""><h4 id="firstHeading" class="firstHeading">' + offers[offer].name + '</h4></a>' +
            '<div class="bodyContent">' +
            '<a href=""><img width="100%" src="images/' + offers[offer].image + '" /></a>' +
            '<p>' + offers[offer].description + '</p>' +
            '</div>' +
            '</div>';
        infowindow[offer] = new google.maps.InfoWindow({
            content: contentString[offer]
        });
    }
    return infowindow;
}

/* End of Offers */