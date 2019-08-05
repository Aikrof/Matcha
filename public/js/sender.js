
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
     		if (xhr.status === 422)
     			console.dir(xhr.responseText);
     		else if (xhr.status === 401)
     			location.href = '/landing';
  		}
	});
}
