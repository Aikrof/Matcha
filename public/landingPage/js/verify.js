$('meta').attr('name', 'csrf_token');
$('meta').attr('content', window.parent.frames.document.all.csrf_token.content);

$('#resend').on('click', function(event){
	var obj = {
		'login' : window.parent.frames.document.activeElement.attributes.obj.value,
	};
	ajaxSender('/' + event.target.id, obj, function(request){
		console.log(request);
	});
});