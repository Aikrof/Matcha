sender = {
    form: function(url, obj, call){
        var callback = call || function() {};

        $.ajax({
            url: url,
            type: 'POST',
            headers:{
                'X-CSRF-TOKEN':
                $('meta[name="csrf_token"]').attr('content'),
            },
            data: JSON.stringify(obj),
            contentType: "application/json",
            dataType:'json',
            success: function(request){
                callback(request);
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                if (xhr.status === 422)
                    console.dir(xhr.responseText);
                else if (xhr.status === 401)
                    location.href = '/landing';
            }
        });
    },

    file: function(url, $file, call){
        var callback = call || function() {};

        let formData = new FormData;
        formData.append('icon', $file);

        $.ajax({
            url: url,
            type: 'POST',
            headers:{
                'X-CSRF-TOKEN':
                $('meta[name="csrf_token"]').attr('content'),
            },
            data: formData,
            contentType: false,
            processData: false,
            dataType:'json',
            success: function(request){
                callback(request);
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                if (xhr.status === 422)
                    console.dir(xhr.responseText);
            }
        });
    },
}

function ImgWorker($inp)
{
    this.file = $inp.prop('files')[0];

    this.imgSend = function($url, $putResultInto, $putErrorInto){
        
        sender.file($url, this.file, function(request){
            if (request.src && $putResultInto !== undefined)
                $putResultInto.attr('src', request.src);
            else if (request.error && $putErrorInto)
                console.log(request.error);
        });   
    }
}

/*
* Get user location
*/
function getUserLocation(call){
    var callback = call || function() {};

    navigator.geolocation.getCurrentPosition(function(position){
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;

    // var url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+ latitude +','+ longitude +'&sensor=false&key=AIzaSyAFlQz9H-L0209Sq94idC1aY9wKOhiH0gs';
    var url = 'http://api.geonames.org/findNearbyPlaceNameJSON?lat='+latitude+'&lng='+longitude+'&username=localdev'
    // var url =  'https://restcountries.eu/rest/v2/all';
        $.getJSON(url, function(data, textStatus){
            var geonames = data.geonames[0];
            if (geonames)
            {
                var country = geonames.countryName;
                var city = geonames.adminName1.split(' ')[0];

                var location = {
                    'latitude' : latitude,
                    'longitude' : longitude,
                    'country' : country,
                    'city' : city,
                }

                callback(location);
            }
        });
    });
};
