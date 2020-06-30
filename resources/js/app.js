require('./bootstrap');
var multirange = require('./multirange');
if (typeof multirange == 'function') {
    window.MultiRange = multirange;
}

window.map = null;
window.marker = null;

function placeMarker(location) {
    if (window.marker) {
        //if marker already was created change positon
        window.marker.setPosition(location);
        window.map.setCenter(location);
    } else {
        //create a marker
        window.marker = new google.maps.Marker({
            position: location,
            map: window.map,
            draggable: false,
            title: "Building"
        });

        window.map.panTo(location);
        window.map.setZoom(9);
    }
}

function geocodeAddress(geocoder, resultsMap) {
    var address = document.getElementById('address').value;
    geocoder.geocode({'address': address}, function (results, status) {
        if (status === 'OK') {
            let location = results[0].geometry.location;
            placeMarker(location);
            window.livewire.emit('setLocation', JSON.stringify({lat: location.lat(), lng: location.lng()}))
        } else {
            console.log('Geocode was not successful for the following reason: ' + status);
        }
    });
}

markStations = function () {
    fetch('/api/stations')
        .then(
            function (response) {
                if (response.status !== 200) {
                    console.log('Looks like there was a problem. Status Code: ' +
                        response.status);
                    return;
                }

                // Examine the text in the response
                response.json().then(function (data) {
                    data.forEach(function (point) {
                        new google.maps.Marker({
                            position: new google.maps.LatLng({
                                lat: parseFloat(point[1]),
                                lng: parseFloat(point[0])
                            }),
                            map: window.map,
                            draggable: false,
                            icon: {
                                path: google.maps.SymbolPath.CIRCLE,
                                fillColor: '#5145cd',
                                fillOpacity: 0.6,
                                strokeColor: '#00A',
                                strokeOpacity: 0.9,
                                strokeWeight: 1,
                                scale: 2
                            }
                        });
                    })
                });
            }
        )
}

window.initMap = function () {
    var centerPosition = new google.maps.LatLng(54.5260, 15.2551);
    var options = {
        zoom: 3,
        center: centerPosition,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        gestureHandling: 'none',
        zoomControl: false
    };
    window.map = new google.maps.Map(document.getElementById('map'), options);
    var geocoder = new google.maps.Geocoder();

    window.livewire.on('addressChanged', function () {
        geocodeAddress(geocoder);
    })

    markStations();

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const lat = urlParams.get('lat')
    const lng = urlParams.get('lng')
    if (lat && lng) {
        placeMarker(new google.maps.LatLng({
            lat: parseFloat(lat),
            lng: parseFloat(lng)
        }))
    }
}
