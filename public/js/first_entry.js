entry = {
    icon: function(){
        return ('\
<div class="row fle_xeble">\
<div class="col-md-6 pr-1">\
    <div class="f_icon_con border_custom">\
        <label class="pattaya_style">Add icon:</label>\
        <div class="custom-file">\
            <label>\
                <input type="file" id="f_icon">\
                <img id="f_img_icon" src="img/icons/spy.png">\
            </label>\
        </div>\
    </div>\
</div>\
</div>\
        ')
    },

    sexualOrient: function(){
        return ('\
<div class="row h-180">\
<div class="col-md-12 pr-1 fle_xeble">\
    <form class="dropdown open f_sexual">\
        <label class="pattaya_style">Sexual orientations:</label>\
        <p class="btn btn-secondary dropdown-toggle orient_dropdown-item" data-toggle="dropdown">Sexual orientations</p>\
        <input type="hidden" name="orientation">'
        + ((new orient).getOrientation()) +
    '</form>\
</div>\
</div>\
        ');
    },
    age: function(){
        return ('\
<div class="row h-180">\
<div class="col-md-12 pr-1 fle_xeble">\
    <form class="form-group f_age_cont f_age" onsubmit="return false first_container">\
        <label class="pattaya_style">Age:</label>\
        <input type="text" class="form-control" maxlength="2" placeholder="Age" name="age" autocomplete="off">\
    </form>\
</div>\
</div>\
        ');
    },

    birthday: function(){
        return ('\
<div class="row h-180">\
<div class="col-md-12 pr-1 fle_xeble">\
    <div class="form-group">\
        <label class="pattaya_style">Birthday:</label>\
        <form class="f_birthday">\
            <input type="text" name="day" class="form-control" maxlength="2" placeholder="Day" autocomplete="off">\
            <div class="dropdown open m_nth">\
                <p class="btn dropdown-toggle f_birthday_buttn" data-toggle="dropdown"><span class="month_dropdown-item">Month</span></p>\
                <input type="hidden" name="month">'
                + (new month()).getMonth() +
            '</div>\
            <input type="text" name="year" class="form-control" maxlength="4" placeholder="Year" autocomplete="off">\
        </form>\
    </div>\
</div>\
</div>\
        ');
    },

    interests: function(){
        return ('\
<div class="row pr-1 fle_xeble_col">\
<label class="pattaya_style">List of interests:</label>\
<div class="row col-md-4 pr-1">\
    <p class="form-control dropdown-toggle nav-link flexible" data-toggle="dropdown">\
        <span>Your Tags</span>\
    </p>\
    <input type="hidden" class="form-control">\
    <ul class="dropdown-menu orient_choose"></ul>\
</div>\
<form class="row col-md-8 pr-1">\
    <input type="interests" class="form-control" placeholder="Add your interests with tag #" name="interests" autocomplete="off" oninput="tagHelper(this.value)" id="interestsHelp">\
</form>\
</div>\
<div class="row pr-1 h-20 fle_xeble_col helperRel">\
    <div class="col-md-6 helperAbs"></div>\
</div>\
        ');
    },

    about: function(){
        return ('\
<div class="row h-180">\
<div class="col-md-12 pr-1 fle_xeble">\
    <form class="form-group f_about_cont f_about" onsubmit="return false">\
        <label class="pattaya_style">About:</label>\
        <textarea name="about" placeholder="Add some info about yourself" class="form-control"></textarea>\
    </form>\
</div>\
</div>\
        ')
    },

    location: function(){
        return ('\
<div class="row h-180">\
<div class="col-md-12 pr-1 fle_xeble">\
<form class="form-group" onsubmit="return false">\
    <label class="f_location">\
        <i class="fa fa-map-marker"></i>\
        <p class="pattaya_style">Add your location:</p>\
        <input type="hidden" name="latitude">\
        <input type="hidden" name="longitude">\
        <input type="hidden" name="country">\
        <input type="hidden" name="city">\
    </label>\
</form>\
</div>\
</div>\
        ')
    }
}

var orient = function(){
    this.div = '<div class="dropdown-menu f_orient" aria-labelledby="dropdownMenuLink" style="z-index: 4000;">';
    this.orientations = [
        "Heterosexual", "Bisexual", "Homosexual"
    ];

    this.creatOrientationSelect = function(){
        var val = '';
        for (let pref of this.orientations){
            val += '<label>\
                        <span class="dropdown-item" onclick="orientCh(event)">' + pref + '</span>\
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
                    <span class="dropdown-item" onclick="birthMonthCh(event)">' + month + '</span>\
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
//     title: '<h1 class="f_info">Add info about yourself</h1>',
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



// $('#tagHelper').bind('input', function(){
//     $tag = $(this).val().split('#');

//     $tag[0] = null;
//     $tag = $tag[$tag.length - 1];
    
//     if ($tag && $tag.length > 2)
//     {
//         sender.form('/searchTag', {'tag' : $tag}, function(request){
//             console.log(request);
//         });
//     }
// });

function tagHelper($value){
    $hash = $value.split('#');
    $hash[0] = null;

    $tag = $hash[$hash.length - 1];
    
    if ($hash.length - 1 > 1)
    {
        let inp = document.getElementById('interestsHelp');
        inp.value = '#' + $tag;
    }
    
    if ($tag && $tag.length > 2)
    {
        sender.form('/searchTag', {'tag' : $tag}, function(request){
            console.log(request);
        });
    }
}

/*
| Change icon
*/
$('#f_icon').change(function(){
    let $url = '/saveUserIcon';

    let $file = new ImgWorker($(this));
    $file.imgSend($url, $('#f_img_icon'), function(request){
        console.log(request);
    });   
});

/*
| Changes Birth month in select block
*/
function birthMonthCh(event){
    $('input[name="month"]').val(event.target.innerText);
    $('.month_dropdown-item')[0].innerHTML = event.target.innerText;
};


/*
| Changes  orientation in select block
*/
function orientCh(event){
    $('input[name="orientation"]').val(event.target.innerText);
    $('.orient_dropdown-item')[0].innerHTML = event.target.innerText;
};

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