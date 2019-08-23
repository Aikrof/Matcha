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
    
    $file.imgSend('/saveUserImg', $(this).attr('name'), function(src){
        if ($('.pr_img_21').length == 4)
            $('.taget_img').last().remove();

    	$('.user_img_area').prepend(
        	'<div class="row fle_xeble taget_img">\
        		<div class="col-md-11">\
                    <img class="form-group pr_img_21" src=' + src +'>\
                </div>\
        	</div>'
        );
    }, function(error){
    	console.log(error);
    });
});

/*
* Add img likes and comments
*/
$('.img_cont').mouseenter(function(){
    $(this).children('.fa').removeClass("i_none");
    $(this).children('.like_count').removeClass("none");
});

/*
* Remove img likes and comments
*/
$('.img_cont').mouseleave(function(){
    $(this).children('.fa').addClass("i_none");
    $(this).children('.like_count').addClass("none");
});

/*
* Show who like img
*/
$('.like').click(function(){
    console.log('like');
});

/*
* Show comments
*/
$('.comments').click(function(){
    console.log('comments');
});

/*
* Show resize img
*/
$('.img_cont').click(function(){
    Swal.fire({
        html: '\
         <div class="full_scr_cont">\
            <img class="full_scr_img" src='
            +  $(this).children('.pr_img_21').attr('src') + 
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

function editProfile($name, $value)
{
	let $obj = {[$name] : $value};
	sender.form('/profile/profileUpdate', $obj);
}

