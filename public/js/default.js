var socket = new WebSocket("ws://matcha.localhost:6322");

socket.onopen = function(open){
	socket.send(JSON.stringify({'type' : 'notification'}))
};

$('.s').click(function(){
	socket.send($('#f').val());
});

function sendMsg($data){
	socket.send(JSON.stringify($data));
}

socket.onmessage = function(event){
	let $path = location.pathname.split('/');

	let data = JSON.parse(event.data);
	
	switch (data.type){

		case 'message': {

			if ($path[$path.length - 1] === 'chat')
				getNewMessage(data);
			else{
				const Notifi = Swal.mixin({
  					toast: true,
  					position: 'bottom-end',
  					showConfirmButton: false,
				})
				Notifi.fire({
  					type: 'success',
  					html: '<p class="notify_p">You have new message from</p>\
  					<p class="notify_p notify_username c-e74">' + data.from + '</p>',
				});
			}

			break;
		}
		case 'notification': {
			
		}
	}
}


$('.logout').click(function(){
	sender.form('/logout');
});