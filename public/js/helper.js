function ajaxSender(url, arr, call)
{
	var callback = call || function() {};

	$.ajax({
    	url: url,
   		type: 'POST',
   		headers:{
    		'X-CSRF-TOKEN':
    		$('meta[name="csrf_token"]').attr('content'),
  		},
		data: JSON.stringify(arr),
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
}

function ajaxFileSender(url, $file, call)
{
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
}

function ImgWorker($inp)
{
    this.file = $inp.prop('files')[0];

    this.imgSend = function($url, $puResultInto, $putErrorInto){
        
        ajaxFileSender($url, this.file, function(request){
            if (request.src && $puResultInto !== undefined)
                $puResultInto.attr('src', request.src);
            else if (request.error && $putErrorInto)
                console.log(request.error);
        });   
    }
}