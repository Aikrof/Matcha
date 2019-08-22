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
    
    var reader = new FileReader();
    
    reader.onload = function (e) {
        $('.avatar').attr('src', e.target.result);
    };
    reader.readAsDataURL($(this).prop('files')[0]);

    let $file = new ImgWorker($(this));
    $file.imgSend('/saveUserIcon', $('.avatar'));    
});

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
