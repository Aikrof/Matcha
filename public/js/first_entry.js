entry = {
    icon: function(){
        return ('\
            <div class="form-group f_icon_con">\
                <label>Add icon:</label>\
                <div class="custom-file">\
                    <label>\
                        <input type="file" id="f_icon">\
                        <img id="f_img_icon" src="img/icons/spy.png">\
                    </label>\
                </div>\
            </div>\
        ')
    },

    sexualOrient: function(){
        return ('\
                <div class="dropdown open f_sexual">\
                <label>Sexual orientations:</label>\
                <p class="btn btn-secondary dropdown-toggle orient_dropdown-item" data-toggle="dropdown">Sexual orientations</p>\
                <input type="hidden" name="orientation">'
                + ((new orient).getOrientation()) +
                '</div>\
        ');
    },
    age: function(){
        return ('\
            <div class="form-group f_age_cont">\
                <label>Age:</label>\
                <input type="text" class="form-control" maxlength="2" placeholder="Age" name="age">\
            </div>\
        ');
    },

    birthday: function(){
        return ('\
            <div class="form-group">\
                <label>Birthday:</label>\
                <div class="f_birthday">\
                    <input type="text" name="day" class="form-control" maxlength="2" placeholder="Day">\
                    <div class="dropdown open">\
                        <p class="btn dropdown-toggle f_birthday_buttn" data-toggle="dropdown"><span class="month_dropdown-item">Month</span></p>\
                        <input type="hidden" name="month">'
                        + (new month()).getMonth() + 
                    '</div>\
                    <input type="text" name="year" class="form-control" maxlength="4" placeholder="Year">\
                </div>\
            </div>\
        ');
    },

    interests: function(){
        return ('\
            <div class="form-group f_interests_cont">\
                <label for="comment">List of interests</label>\
                <textarea name="interests" placeholder="Add your interests with tag #" class="form-control" id="tagHelper"></textarea>\
            </div>\
        ');
    },

    about: function(){
        return ('\
            <div class="form-group f_about_cont">\
                <label for="comment">About:</label>\
                <textarea name="about" placeholder="Add some info about yourself" class="form-control"></textarea>\
            </div>\
        ')
    },

    location: function(){
        return ('\
            <div class="form-group f_location">\
                <i class="fa fa-map-marker"></i>\
                <p class="class="btn add_local">Add your location</p>\
                <input type="hidden" name="latitude">\
                <input type="hidden" name="longitude">\
                <input type="hidden" name="country">\
                <input type="hidden" name="city">\
            </div>\
        ')
    }
}

var orient = function(){
    this.div = '<div class="dropdown-menu f_orient" aria-labelledby="dropdownMenuLink">';
    this.orientations = [
        "Heterosexual", "Bisexual", "Homosexual"
    ];

    this.creatOrientationSelect = function(){
        var val = '';
        for (let pref of this.orientations){
            val += '<label>\
                        <span class="dropdown-item f_dropdown-item-orient">' + pref + '</span>\
                    </label>';
        }

        return (val);
    }

    this.getOrientation = function(){
        return (this.div + this.creatOrientationSelect() + '</div>');
    }
}

var month = function(){
    this.div = '<div class="dropdown-menu month_cont" aria-labelledby="dropdownMenuLink">';
    this.year = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December',
    ];

    this.creatMonthSelect = function(){
        var val = '';

        for (let month of this.year){
            val += '<label>\
                    <span class="dropdown-item f_dropdown-item-month">' + month + '</span>\
                </label>';
        }

        return (val);
    }

    this.getMonth = function(){
        return (this.div + this.creatMonthSelect() + '</div>');
    }
}

Swal.fire({
    type: 'question',
    title: 'Add info about yourself',
    html: '<form id="firstEntry">' +
            entry.icon() + entry.age() + entry.birthday() +
            entry.sexualOrient() + entry.interests() +
            entry.about() + entry.location() +
            '</form>',
    showCloseButton: true,
}).then((result) =>{
    if (result)
        (new FirstEntrySend($('#firstEntry'))).send();
});

function FirstEntrySend($form){

    var formProcessing = function(){
        var $data = {};

        $form.find ('input, textarea').each(function(){
            if (this.name)
                $data[this.name] = $(this).val();
        });

        $data['birthday'] = {
            'day' : $data['day'],
            'month' : $data['month'],
            'year' : $data['year'],
        }
        $data['location'] = {
            'latitude' : $data['latitude'],
            'longitude' : $data['longitude'],
            'country' : $data['country'],
            'city' : $data['city'],
        };
        delete $data['day'];
        delete $data['month'];
        delete $data['year'];
        delete $data['latitude'];
        delete $data['longitude'];
        delete $data['country'];
        delete $data['city'];

        return $data; 
    }

    this.send = function(){
        var obj = formProcessing();
        console.log(obj);
        ajaxSender('/firstEntry', obj, function(request){
            console.log(request);
        });
    }


}

$('#tagHelper').bind('input', function(){
    $tag = $(this).val().split('#');

    $tag[0] = null;
    $tag = $tag[$tag.length - 1];
    
    if ($tag && $tag.length > 2)
    {
        ajaxSender('/searchTag', {'tag' : $tag}, function(request){
            console.log(request);
        });
    }
});

$('#f_icon').change(function(icon){
    let $url = '/saveUserIcon';

    let $file = new ImgWorker($(this));
    $file.imgSend($url, $('#f_img_icon'));   
});

$('.f_dropdown-item-month').click(function(){
    $('input[name="month"]').val(this.innerText);
    $('.month_dropdown-item')[0].innerHTML = this.innerText;
});

$('.f_dropdown-item-orient').click(function(){
    $('input[name="orientation"]').val(this.innerText);
    $('.orient_dropdown-item')[0].innerHTML = this.innerText;
});

$('.f_location').click(function(){
    navigator.geolocation.getCurrentPosition(function(position){
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;

    var location = {
        'latitude' : latitude,
        'longitude' : longitude
    };
    $('input[name="latitude"]').val(latitude);
    $('input[name="longitude"]').val(longitude);
    // var url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+ latitude +','+ longitude +'&sensor=false&key=AIzaSyAFlQz9H-L0209Sq94idC1aY9wKOhiH0gs';
    var url = 'http://api.geonames.org/findNearbyPlaceNameJSON?lat='+latitude+'&lng='+longitude+'&username=localdev'
    // var url =  'https://restcountries.eu/rest/v2/all';
        $.getJSON(url, function(data, textStatus){
            var geonames = data.geonames[0];
            if (geonames)
            {
                var country = geonames.countryName;
                var city = geonames.adminName1.split(' ')[0];

                $('input[name="country"]').val(country);
                $('input[name="city"]').val(city);
            }
        });
    });
});