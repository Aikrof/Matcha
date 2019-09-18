$(window).ready(function(){

	var socket = new WebSocket("ws://127.0.0.1:9547");

	$('.s').click(function(){
		socket.send($('#f').val());
	});

	socket.onmessage = function(event){
		console.log(event);
	}
});

$('.logout').click(function(){
	sender.form('/logout');
});