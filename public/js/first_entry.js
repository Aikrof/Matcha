entry = {
    icon: function(){
        return ('\
            <div class="f_icon_con">\
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
                <form class="dropdown open f_sexual">\
                <label>Sexual orientations:</label>\
                <p class="btn btn-secondary dropdown-toggle orient_dropdown-item" data-toggle="dropdown">Sexual orientations</p>\
                <input type="hidden" name="orientation">'
                + ((new orient).getOrientation()) +
                '</form>\
        ');
    },
    age: function(){
        return ('\
            <form class="form-group f_age_cont f_age">\
                <label>Age:</label>\
                <input type="text" class="form-control" maxlength="2" placeholder="Age" name="age">\
            </form>\
        ');
    },

    birthday: function(){
        return ('\
            <div class="form-group">\
                <label>Birthday:</label>\
                <form class="f_birthday">\
                    <input type="text" name="day" class="form-control" maxlength="2" placeholder="Day">\
                    <div class="dropdown open">\
                        <p class="btn dropdown-toggle f_birthday_buttn" data-toggle="dropdown"><span class="month_dropdown-item">Month</span></p>\
                        <input type="hidden" name="month">'
                        + (new month()).getMonth() + 
                    '</div>\
                    <input type="text" name="year" class="form-control" maxlength="4" placeholder="Year">\
                </form>\
            </div>\
        ');
    },

    interests: function(){
        return ('\
            <form class="form-group f_interests_cont f_interests">\
                <label>List of interests</label>\
                <div class="form-group">\
                        <label>Interests</label>\
                        <div style="display: flex;">\
                            <input name="interests" class="form-control" placeholder="Add your interests with tag #" id="tagHelper">\
                            <p class="btn" style="margin-left: 10px">Add</p>\
                        </div>\
                    </div>\
            </form>\
        ');
    },

    about: function(){
        return ('\
            <form class="form-group f_about_cont f_about">\
                <label for="comment">About:</label>\
                <textarea name="about" placeholder="Add some info about yourself" class="form-control"></textarea>\
            </form>\
        ')
    },

    location: function(){
        return ('\
            <form class="form-group f_location">\
                <i class="fa fa-map-marker"></i>\
                <p class="add_local">Add your location</p>\
                <input type="hidden" name="latitude">\
                <input type="hidden" name="longitude">\
                <input type="hidden" name="country">\
                <input type="hidden" name="city">\
            </form>\
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
                    <span class="dropdown-item f_dropdown-item-month" onclick="bdMonth">' + month + '</span>\
                </label>';
        }

        return (val);
    }

    this.getMonth = function(){
        return (this.div + this.creatMonthSelect() + '</div>');
    }
}

// Swal.fire({
//     type: 'question',
//     title: 'Add info about yourself',
//     html: '<form id="firstEntry">' +
//             entry.icon() + entry.age() + entry.birthday() +
//             entry.sexualOrient() + entry.interests() +
//             entry.about() + entry.location() +
//             '</form>',
//     showCloseButton: true,
// }).then((result) =>{
//     if (result)
//         (new FirstEntrySend($('#firstEntry'))).send();
// });

Swal.mixin({
    title: 'Add info about yourself',
    showCancelButton: true,
    confirmButtonText: 'Next &rarr;',
    reverseButtons: true,
    progressSteps: ['Ic', 'Ag', 'Bi', 'Or', 'In' , 'Ab' , 'Lo']
}).queue([
    {
        html: entry.icon(),
    },

    {
        html: entry.age(),
        preConfirm: function(){
            firstEntrySender.send($('.f_age'));
        }
    },

    {
        html: entry.birthday(),
        preConfirm: function(value){
            firstEntrySender.send($('.f_birthday'));
        }
    },

    {
        html: entry.sexualOrient(),
        preConfirm: function(value){
           firstEntrySender.send($('.f_sexual'));
        }
    },

    {
        html: entry.interests(),
        preConfirm: function(value){
            firstEntrySender.send($('.f_interests'));
        }
    },
    
    {
        html: entry.about(),
        preConfirm: function(value){
           firstEntrySender.send($('.f_about'));
        }
    },

    {
        html: entry.location(),
        preConfirm: function(value){
            firstEntrySender.send($('.f_location'));
        }
    },

]).then((result) => {
    console.log(result);
});


firstEntrySender = {

    send: function($form){
        var $obj = (function(){
            var $data = {};

            $form.find ('input, textarea').each(function(){
                if (this.name)
                    $data[this.name] = $(this).val();
            });

            return ($data);
        }());
        console.log($obj);
        // sender.form('/firstEntry', $obj, function(request){
        //     console.log(request);
        // });
    }
}



$('#tagHelper').bind('input', function(){
    $tag = $(this).val().split('#');

    $tag[0] = null;
    $tag = $tag[$tag.length - 1];
    
    if ($tag && $tag.length > 2)
    {
        sender.form('/searchTag', {'tag' : $tag}, function(request){
            console.log(request);
        });
    }
});

/*
| Change icon
*/
$('#f_icon').change(function(icon){
    let $url = '/saveUserIcon';

    let $file = new ImgWorker($(this));
    $file.imgSend($url, $('#f_img_icon'), function(request){
        console.log(request);
    });   
});

/*
| Change Birth month
*/

function bdMonth(){
    console.log(123);
};
$('.f_dropdown-item-month').click(function(e){
    console.log(e);
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