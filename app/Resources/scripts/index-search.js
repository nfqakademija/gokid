var autocomplete, geocoder, coordinates = null;

// Locate the users address when globe button is clicked
$('.locate-me').click(locateUserAddress);

// Signals whether form is being submitted
var formSubmiting = false;

// Initialize address autocomplete plugin
function initAutocomplete() {
    autocomplete = new google.maps.places.Autocomplete(
        input,
        {
            types: ['geocode'],
            componentRestrictions: {country: 'ltu'}
        }
    );
    geocoder = new google.maps.Geocoder();

    // Change the coordinates variable, when user autocompletes address
    autocomplete.addListener('place_changed', function() {
        var location = autocomplete.getPlace();
        if (location) {
            changeCoordinates(
                location.geometry.location.lat(),
                location.geometry.location.lng()
            );
        }
    });
}

// Confirm that user coordinates are set when form is submitted
$(form).submit(function(event) {
    // If user has not selected their address from autocomplete list or
    // used geolocating, perform location aproximation
    if (!formSubmiting) {
        if (coordinates == null) {
            event.preventDefault();
            var userInput = $(input).val();
            // User typed nothing, proceed with form submission
            if (userInput === "") {
                formSubmiting = true;
                $(form).submit();
            } else {
                var service = new google.maps.places.AutocompleteService();
                service.getPlacePredictions(
                    {
                        input: userInput,
                        types: ['geocode'],
                        componentRestrictions: {country: 'ltu'}
                    },
                    function (predictions, status) {
                        // User typed something legible, predict the location
                        // and set coordinates
                        if (status === google.maps.places.PlacesServiceStatus.OK) {
                            if (predictions && predictions[0]) {
                                var predictedLocation = predictions[0];
                                geocode({'address': predictedLocation.description},
                                    function(results) {
                                        changeCoordinates(
                                            results[0].geometry.location.lat(),
                                            results[0].geometry.location.lng()
                                        );
                                        formSubmiting = true;
                                        $(form).submit();
                                    }
                                );
                            } else {
                                // User input illegible, set coordinates to null
                                changeCoordinates(null, null);
                                formSubmiting = true;
                                $(form).submit();
                            }
                        }
                    }
                );
            }
        }
    }
});

// Geocoding function to reduce code duplication
function geocode(params, callback) {
    geocoder.geocode(params,
        function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    callback(results);
                } else {
                    console.log('Rasti adreso nepavyko');
                }
            } else {
                console.log('Geocoderio fail del:' + status);
            }
        }
    );
}

// Set coordinates variable
function changeCoordinates(lat, lng) {
    coordinates = {
        lat: lat,
        lng: lng
    };
    setCoordinatesInputs();
}

// Set values of hidden coordinate fields
function setCoordinatesInputs() {
    $(latitude).val(coordinates.lat);
    $(longitude).val(coordinates.lng);
}

function locateUserAddress() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var latlng = new google.maps.LatLng(
                position.coords.latitude,
                position.coords.longitude
            );
            geocode({'latLng': latlng}, function(results) {
                var addressComponents = results[0].address_components;
                var address = addressComponents[1].short_name + ' ' +
                    addressComponents[0].long_name + ', ' +
                    addressComponents[2].long_name;
                $(input).val(address);
                // Change the coordinates variable, when user uses geolocation
                changeCoordinates(
                    results[0].geometry.location.lat(),
                    results[0].geometry.location.lng()
                )
            })
        });
    }
}

// Age input popover

$('#index_search_offer_age').popover({
    content: $('#popover-content').html(),
    html: true
}).click(function() {
    $('.button-container').click(function () {
        $('#index_search_offer_age').val($(this).text()).popover('hide');
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
