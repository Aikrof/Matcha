document.addEventListener('DOMContentLoaded', function(){
    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#friend-list li .username").filter(function() {
             $(this).parent().toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});


$('.list-group-item').click(function(){
    $('#friend-list').find('.active').removeClass('active');
    $(this).addClass('active');

    $(this).children('.miss_message').text(" ");
    $(this).children('.miss_message').hide();

    if (!$('.chat_cont').attr('style'))
    {
        $('.chat_cont').hide();
        $(this).removeClass('active');
        return;
    }

    let $login = $(this).find('.username').text();
    let $room = $(this).attr('data');

    let $data = {
        'login' : $login,
        'room' : $room
    };

    sender.form('/getMessages', {'data' : $data}, function(request){
        $('.message-scroll').children().remove();
        
        if (request.data){
            for (let data of request.data){
                $('.message-scroll').append(
                    printMessage(data)
                );
            }
        }
        
        $('.chat_header > b').text($login);
        $('.chat_header > b').attr('data', $room);
        $('.chat_cont').show();

        $('.message-scroll')[0].scrollTop = 999999;
    });
});

(function(){
    $('.chat_text').on('keypress', function(key){
        if (key.which == 13 && key.shiftKey)
            return;
        else if (key.which == 13){
            let $msg = $(this).val();

            $(this).val('');

            if (!checkText($msg))
                return;

            addNewMessage($msg);
            prepearMessage($msg);

            return (false);
        }
    });

    $('.send_text_msg').click(function(){
        let $msg = $('.chat_text').val();

        $('.chat_text').val('');

        if (!checkText($msg))
            return;

        addNewMessage($msg);
        prepearMessage($msg);
    });

    function checkText($msg){
        for (let char of $msg){
            if (char !== " " && char != '\n' &&
                char != '\t')
                return (true);
        }

        return (false);
    }

    function addNewMessage($msg){

        let date = new Date();

        $('.message-scroll').append(
            printMessage({
                'user' : 'auth',
                'msg' : $msg,
                'time' : date.getHours() + ":" + date.getMinutes(),
            })
        );
        $('.message-scroll')[0].scrollTop += 42;
    }

    function prepearMessage($msg){
        
        let data = {
            'type' : 'message',
            'room' : $('.chat_header > b').attr('data'),
            'to' : $('.chat_header > b').text(),
            'msg' : $msg
        }

        sendMsg(data);
    }
}());

function getNewMessage(data){
    if (roomActive()){
        let obj = {
            'user' : "target",
            'msg' : data.msg,
            'time' : data.time,
        }
        $('.message-scroll').append(
            printMessage(obj)
        );
        $('.message-scroll')[0].scrollTop += 42;
    }
    else{
        let $miss = $('.username:contains("'+ data.from +'")').parent().children('.miss_message');
        
        $miss.show();
        
        if ($miss.text() !== "")
            $miss.text(parseInt($miss.text()) + 1);
        else
            $miss.text(1);
    }

    function roomActive(){
        let user_room = $('.chat_header > b').attr('data');

        return (user_room === data.room ? true : false);
    }
}


function printMessage(data){
    return ('\
    <div class="row '+getClassCont(data.user)+'">\
        <div class="card message-card m-1">\
            <div class="card-body p-2 msg_'+ data.user +'">\
                <span class="">'+ data.msg +'</span>\
                <span class="float-right mx-1">\
                    <small>'+ data.time +'</small>\
                </span>\
            </div>\
        </div>\
    </div>\
   ');

    function getClassCont(user){
        return (user === "auth" ? "justify-content-end" : "");
    }
}