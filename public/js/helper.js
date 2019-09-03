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

    file: function(url, $file, $appendName,call){
        var callback = call || function() {};

        let formData = new FormData;
        formData.append($appendName, $file);

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

    this.iconSend = function($url, $putResultInto, $appendName, $putErrorInto){
        if (!checkSize(this.file))
            return;

        var $errorCall = $putErrorInto || function() {};

        sender.file($url, this.file, $appendName,function(request){
            if (request.src && $putResultInto !== undefined)
                $putResultInto.attr('src', request.src);
            else if (request.error && $putErrorInto)
                $errorCall(request.error);
        });   
    }

    this.imgSend = function($url, $appendName, $putResultInto, $putErrorInto){

        if (!checkSize(this.file))
            return;

        var $resultCall = $putResultInto || function() {};
        var $errorCall = $putErrorInto || function() {};

        sender.file($url, this.file, $appendName, function(request){
            if (request.src)
                $resultCall(request.src);
            else if (request.error)
                $errorCall(request.error)
        });
    }

    var checkSize = function(file){
        if (file === undefined)
            return;
        return (file.size <= 10000000);
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
