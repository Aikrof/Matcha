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