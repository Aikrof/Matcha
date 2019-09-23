
var socket = new WebSocket("ws://"+ location.hostname +":6322");

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
			let notifi_data = data.notifi_data;

			if (notifi_data.length == 0)
				return;

			for (let n of notifi_data){
				let result = {};
				
				switch (n.type){
					case 'message': {

						result = {
							'type' : 'message',
							'str' : "You have new Message from: ",
							'login' : n.login,
						}
						break;
					}
				}

				let $repetitive = $('.notification_login:contains('+ result.login +')')

				if ($repetitive.hasClass('notification_login') &&
					$repetitive.parent().attr('data-type') === result.type){
					
					let $small = $repetitive.parent().find('.small_n_count');
					if ($small.text() === ""){
						$small.text("2");
					}
					else
						$small.text(parseInt($small.text()) + 1);
				}
				else{
					$('.notification_ul').append(
						'<p class="dropdown-item notification_p" data-type="'+ result.type +'">\
						<span class="n_count"><small class="small_n_count"></small></span>'
						+ result.str +
						'<strong class="notification_login c-e74">'
						+ result.login +
						'</strong></p>'
					);
				}
			}

			$('.notification_count').show();
			$('.notification_count').text(notifi_data.length);
		}
	}
}


$('.logout').click(function(){
	sender.form('/logout');
});