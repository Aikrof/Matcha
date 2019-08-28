$('.tab a').click(function(){
    $(this).parent().addClass('active');
    $(this).parent().siblings().removeClass('active');

    $target = $(this).attr('href').toLowerCase();

    $('#profile-content > .profile_choice').not($target).hide();
    $($target).fadeIn(600);
});


birthday = {};

$('.edit_select').click(function(){
	let $val;
	let $change = $(this).attr('change');
	
	if ($change)
		$('.' + $change).text($(this).text());
	
	let $name = $(this).attr('name');
	if ($name === 'month')
	{
		birthday[$name] = $(this).text();
		if (!checkElseBirthParam())
			return;
		$val = birthday;
		$name = 'birthday';
	}
	else
		$val = $(this).text();

	editProfile($name, $val);
});

$('.edit_inp').change(function(){
	let $val;
	let $name = $(this).attr('name');
	
	if ($name=== 'day' ||
		$name === 'year')
	{
		birthday[$name] = $(this).val();
		if (!checkElseBirthParam())
			return;
		$val = birthday;
		$name = 'birthday';
	}
	else
		$val = $(this).val();

	editProfile($name, $val);
});

$('.remove_birthday').click(function(){
	$('input[name="day"]').val("");
	$('input[name="year"]').val("");
	$('.birthday_buttn').text("Month");

	sender.form('/profile/removeBirthday', null);
});

$('.tag_se').click(function(){
	$value = $(this).text().replace('#', '');

	$(this).remove();
	sender.form('/profile/removeTag', {'tag' : $value});
});

/*
* Add icon
*/
$('#profile_avatar').change(function(){

    let $file = new ImgWorker($(this));
    $file.iconSend('/saveUserIcon', $('.avatar'), $(this).attr('name'));    
});

/*** USER IMG ***/

/**
* Add user img
**/
$('#inp_img').change(function(){

    let $file = new ImgWorker($(this));
    
    $(this).val("");
    
    $file.imgSend('/saveUserImg', $(this).attr('name'), function(request){
        
        if ($('.pr_img_21').length == 4)
            $('.taget_img').last().remove();

    	$('.user_img_area').prepend(
        	'<div class="row fle_xeble taget_img">\
                <div class="col-md-11">\
                    <img class="form-group pr_img_21" src='+ request.img_src +' data='+ request.id +'>\
                </div>\
            </div>');
    }, function(error){
    	console.log(error);
    });
});

/*
* Add img likes and comments
*/
$('.img_cont').mouseenter(function(){
    $(this).children('.user_func').show();
});

/*
* Remove img likes and comments
*/
$('.img_cont').mouseleave(function(){
    $(this).children('.user_func').hide();
});

/*
* Show who likes and add like
*/
$('.like').click(function(){
    let $likes_area = $(this).parent().parent().children('.box_likes_hidden').removeClass("none");
    let $targetArrea = $(this).parents('.img_cont').children('.box_likes_hidden').children('.like_box').children('.users_like');

    let $img = getImg($likes_area.parent().children('.pr_img_21').attr('src'));

    $targetArrea.empty();

    sender.form('/user/getLikes', {'img': $img}, function(request){
        if (request.data)
            console.log(request.data);
        else if (request.empty)
        {
            $targetArrea.append('\
                <div class="empty_comment">\
                    <p>'+ request.empty +'</p>\
                </div>\
            ');
        }
    })
});


/*
* Show comments
*/
$('.hov_comments_fa').click(function(e){
    let $area = $(this).parent().parent().children('.box_commnets_hidden').removeClass("none");
    let $targetArrea = $(this).parents('.img_cont').children('.box_commnets_hidden').children('.comment_box').children('.users_coments');

    let $img = getImg($area.parent().children('.pr_img_21').attr('src'));

    $targetArrea.empty();

    sender.form('/user/getComments', {'commentImg' : $img}, function(request){
        if (request.data)
        {
            for (let $data of request.data){
                addCommentsToArea($targetArrea, $data);
            }
        }
        else if (request.empty)
        {
            $targetArrea.append('\
                <div class="empty_comment">\
                    <p>'+ request.empty +'</p>\
                </div>\
                ');
        }

    });
});

/*
* Close comments and likes
*/
$('.comment_close').click(function(){
    $(this).parent().parent().addClass("none");
});

/*
* Send new comment
*/
$('.snd_new_comment').click(function(){
    let $text = $(this).parent().children('textarea');
    let $targetArrea = $(this).parents('.comment_box').children('.users_coments');

    $obj = {
        'img' : getImg($(this).parents('.img_cont').children('.pr_img_21').attr('src')),
        'comment' : $text.val(),
        'id' : $(this).parents('.img_cont').children('.pr_img_21').attr('data')
    };
   
    sender.form('/user/addComment', {'comment' : $obj}, function(request){
        if (request.data)
        {
            if ($('.empty_comment') !== undefined)
                $('.empty_comment').remove();
            addCommentsToArea($targetArrea, request.data);
        }
    });

    $text.val("");
});

/*
* New like
*/
$('.snd_new_like').click(function(){

    $obj = {
        'img' : getImg($(this).parents('.img_cont').children('.pr_img_21').attr('src')),
        'id' : $(this).parents('.img_cont').children('.pr_img_21').attr('data'),
    };

    sender.form('/user/addLike', {'like':$obj}, function(request){
        console.log(request);
    });
});

/*
* Show resize img
*/
$('.pr_img_21').click(function(){
    Swal.fire({
        html: '\
         <div class="full_scr_cont">\
            <img class="full_scr_img" src='
            +  $(this).attr('src') + 
            '>\
            <div class="full_src_lay">\
                <div class="full_src_comments">\
                </div>\
                <div class="full_src_addComments">\
                    <textarea rows="4" cols="80" class="form-control add_comment" name="comment" placeholder="Type your comment"></textarea>\
                    <p class="btn add_comment_btn">Add</p>\
                </div>\
            </div>\
        </div>',
        customClass: 'swal-wide',
        showCloseButton: true,
        showConfirmButton: false,
    })
});

/*** /USER IMG ***/

$('.btn_inter').click(function(){
	$hash = $('#interestsHelp').val().split('#');
    $hash[0] = null;
    
    if ($hash[1])
    	changeTag($hash[1]);
});

function tagHelper($value){
	$hash = $value.split('#');
    $hash[0] = null;

    $tag = $hash[$hash.length - 1];
    
    if ($hash.length - 1 > 1)
    {
        if ($('.resultTags') !== undefined)
            $('.resultTags').remove();

        sendTag($hash[1]);
        $('#interestsHelp').val('#');
    }
    
    if ($tag && $tag.length > 2)
    {
        sender.form('/searchTag', {'tag' : $tag}, function(request){
            if ($('.resultTags') !== undefined)
                    $('.resultTags').remove();

            if (request.similar.length)
            {
                $('.helperProfInt').show();
                for (let value of request.similar){
                    $('.helperProfInt').append('\
                        <p class="resultTags" onclick="changeTag(this.innerText)">'
                        + value.tag + '</p>')
                }
            }
            else
                $('.helperProfInt').hide();
        });
    }
}

$('.user_location_add').click(function(){
	getUserLocation(function(location){
		$('.city_local').val(location.city);
		$('.country_local').val(location.country);

		sender.form('/profile/profileUpdate', {'location' : location});
	});
});
$('.user_location_remove').click(function(){
	$('.city_local').val("");
	$('.country_local').val("");

	sender.form('/profile/removeLocation');
});
function changeTag(tag){
    sendTag(tag);

	$('.resultTags').remove();
  	$('.helperAbs').hide();
   	$('#interestsHelp').val('#');
}

function sendTag(tag)
{
    if (tag !== '' && tag !== '#')
    {
    	$('.interest_cont').prepend(
    	 	'<p class="tag_se">#' + tag + '</p>');
    	let arr = [tag];
    	sender.form('/profile/profileUpdate', {'interests' : arr}, function(request){
			console.log(request);
        });
    }
}

function checkElseBirthParam(){
	var count = 0;

	for (let property in birthday){
    	if (birthday.hasOwnProperty(property))
			count++;
    }
    return (count == 3);
}

function editProfile($name, $value){
	let $obj = {[$name] : $value};
	sender.form('/profile/profileUpdate', $obj);
}

var getImg = function($path){
    $img = $path.split('/');
    return ($img[$img.length - 1]);
}

function addCommentsToArea($targetArrea, $data){
    $targetArrea.append('\
        <div class="comment_area_cont form-group">\
            <a href='+ $data.login +'>\
                <img class="comment_area_img" src='+ $data.icon +'>\
            </a>\
            <div class="comment_area">\
                <p class="comment_area_login pattaya_style">'+ $data.login +'</p>\
                <div class="comment_area_comment">\
                    <p>'+ $data.comment +'</p>\
                </div>\
            </div>\
        </div>')
}