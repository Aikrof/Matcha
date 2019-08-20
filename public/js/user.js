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

$('.tag_se').click(function(){
	$value = $(this).text().replace('#', '');

	$(this).remove();
	sender.form('/user/removeTag', {'tag' : $value});
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
    	sender.form('/user/saveNewTag', {'tag' : tag}, function(request){
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
	sender.form('/profileUpdate', $obj);
}

