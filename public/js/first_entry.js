entry = {
    sexualOrient: function(){
        return ('\
            <li class="dropdown nav-item">\
                <p class="dropdown-toggle nav-link" data-toggle="dropdown">Sexual orientations:</p>\
                <ul class="dropdown-menu">\
                <input>\
                    <a class="dropdown-item">Heterosexual</a>\
                    <a class="dropdown-item">Bisexual</a>\
                    <a class="dropdown-item">Homosexual</a>\
                </ul>\
            </li>\
        ');
    },
    age: function(){
        return ('\
            <li class="dropdown nav-item">\
                <p class="dropdown-toggle nav-link" data-toggle="dropdown">Your tags:</p>\
                <ul class="dropdown-menu">\
                    <a class="dropdown-item" href="#">Notification 1</a>\
                    <a class="dropdown-item" href="#">Notification 2</a>\
                    <a class="dropdown-item" href="#">Notification 3</a>\
                    <a class="dropdown-item" href="#">Notification 4</a>\
                    <a class="dropdown-item" href="#">Another notification</a>\
                </ul>\
            </li>\
        ');
    },
}

// Swal.fire({
//     type: 'question',
//     title: 'Add info about yourself',
//     html: '<form>' + entry.sexualOrient() + entry.age() + '</form>',
//     showCloseButton: true,
// });