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

    $(input).change(function() {
        coordinates = null;
    });

    // Change the coordinates variable, when user autocompletes address
    autocomplete.addListener('place_changed', function() {
        var location = autocomplete.getPlace();
        if (location && ('geometry' in location)) {
            changeCoordinates(
                location.geometry.location.lat(),
                location.geometry.location.lng()
            );
        } else {
            coordinates = null;
        }
        return false;
    });

    $('input#address').change(function () {
        if ($(this).val() == '') {
            changeCoordinates(
                0,
                0
            );
        }
    });
}
// Confirm that user coordinates are set when form is submitted
if(typeof form != 'undefined') {
    $(form).submit(function (event) {
        if (typeof searchPage !== 'undefined' && searchPage && formSubmiting) {
            event.preventDefault();
            ajaxUpdate();
            formSubmiting = false;
            coordinates = null;
            return;
        }
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
                                        function (results) {
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
                                    $(input).val('');
                                    $(form).submit();
                                }
                            } else {
                                $(input).val('');
                                $(form).submit();
                            }
                        }
                    );
                }
            }
        }
    });
}

// Geocoding function to reduce code duplication
function geocode(params, callback, failCallback) {
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
                failCallback(status);
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
    if (typeof map != 'undefined') {
        ajaxUpdate();
    }
}

function locateUserAddress() {
    addressLoading(true);
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
                );
                addressLoading(false);
            }, function(status) {
                addressLoading(false, true);
            })
        }, function(status) {
            addressLoading(false, true);
        });
    }
}

var addressValue;

function addressLoading(isLoading, failed) {
    if (isLoading) {
        $(input).attr('disabled', true);
        $('.locate-me').addClass('hidden');
        $('.loader-div').removeClass('hidden');
        $(input).attr('placeholder', '');
        addressValue = $(input).val();
        $(input).val('');
        $(input).addClass('absolute');
    } else {
        $(input).attr('placeholder', 'Gyvenamoji vieta');
        $('.loader-div').addClass('hidden');
        $(input).attr('disabled', false);
        $('.locate-me').removeClass('hidden');
        $(input).removeClass('absolute');
    }
    if (failed) {
        $(input).val(addressValue);
    }
}
