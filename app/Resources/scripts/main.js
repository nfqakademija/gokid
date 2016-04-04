/* Offers */

$( ".offer" ).hover(
    function () {
        // first we need to know which <div class="marker"></div> we hovered
        var index = $('.offer').index(this);
        markers[index].setIcon(highlightedIcon());
    },
    // mouse out
    function () {
        // first we need to know which <div class="marker"></div> we hovered
        var index = $('.offer').index(this);
        markers[index].setIcon(normalIcon());
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

/* End of Offers */