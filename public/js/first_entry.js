entry = {
    sexualOrient: function(){
        return ('\
                <div class="dropdown open">\
                <p class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Sexual orientations</p>'
                + ((new orient).getOrientation()) +
                '</div>\
        ');
    },
    age: function(){
        return ('\
            <div class="form-group">\
                <label>Age</label>\
                <input type="text" class="form-control" maxlength="2" placeholder="Age">\
                </div>\
        ');
    },

    birthday: function(){
        return ('\
            <div class="form-group">\
                <label>Birthday</label>\
                <div>\
                    <input type="text" name="day" class="form-control" maxlength="2" placeholder="Day">\
                    <div class="dropdown open">\
                        <p class="btn dropdown-toggle" data-toggle="dropdown">Mounth</p>'
                        + (new month()).getMonth() + 
                    '</div>\
                    <input type="text" name="year" class="form-control" maxlength="4" placeholder="Year">\
                </div>\
            </div>\
        ');
    },

    interests: function(){
        return ('\
            <div class="form-group">\
                <label for="comment">List of interests</label>\
                <textarea placeholder="Add your interests with tag #" class="form-control" rows="5" id="interests"></textarea>\
            </div>\
        ');
    },

    about: function(){
        return ('\
            <div class="form-group">\
                <label for="comment">About</label>\
                <textarea placeholder="Add some info about yourself" class="form-control" rows="5" id="interests"></textarea>\
            </div>\
        ')
    }
}

var orient = function(){
    this.div = '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
    this.orientations = [
        "Heterosexual", "Bisexual", "Homosexual"
    ];

    this.creatOrientationSelect = function(){
        var val = '';
        for (let pref of this.orientations){
            val += '<label>\
                        <input style="display: none;" type="checkbox" name="sexual_pref" value="'+ pref +'">\
                        <span class="dropdown-item">' + pref + '</span>\
                    </label>';
        }

        return (val);
    }

    this.getOrientation = function(){
        return (this.div + this.creatOrientationSelect() + '</div>');
    }
}

var month = function(){
    this.div = '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
    this.year = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December',
    ];

    this.creatMonthSelect = function(){
        var val = '';

        for (let month of this.year){
            val += '<label>\
                    <input style="display: none;" type="checkbox" name="month" value="' + month + '">\
                    <span class="dropdown-item">' + month + '</span>\
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
            entry.age() + entry.birthday() + entry.sexualOrient() +
            entry.interests() + entry.about() +
            '</form>',
    showCloseButton: true,
});

// navigator.geolocation.getCurrentPosition(function(position){
//     var latitude = position.coords.latitude;
//     var longitude = position.coords.longitude;

//     var url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+ latitude +','+ longitude +'&sensor=false&key=AIzaSyAFlQz9H-L0209Sq94idC1aY9wKOhiH0gs';
//     $.getJSON(url,function (data, textStatus) {
//            console.log(data);
//       });
// });

// if (navigator.geolocation) {
//     navigator.geolocation.getCurrentPosition(function (position) {

//         //GET USER CURRENT LOCATION
//         var locCurrent = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

//         //CHECK IF THE USERS GEOLOCATION IS IN AUSTRALIA
//         var geocoder = new google.maps.Geocoder();
//             geocoder.geocode({ 'latLng': locCurrent }, function (results, status) {
//                 var locItemCount = results.length;
//                 var locCountryNameCount = locItemCount - 1;
//                 var locCountryName = results[locCountryNameCount].formatted_address;

             
//         });
//     });
// }