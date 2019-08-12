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
