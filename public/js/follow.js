$(document).ready(function(){
	$('.a_sf').click(function(){

		$sf = $('#sf_show');
		if ($sf.attr('style') === 'display: none;')
			$sf.show();
		else
			$sf.hide();
	});
});

/*
* Close Sort / Filter settings
*/
$('.f_cancel_btn').click(function(){
	$('#sf_show').hide();
});

$('.f_lab_check').click(function(){
	$check = $(this).parent().children('.f_imp_check');
	
	if ($(this).attr('data') === '0')
	{
		$(this).children('.sort_checker').addClass('check_ok_content');
		$(this).attr('data', '1');;
		$check.val(true);

		for (let label of $('.f_lab_check')){
			if ($(this)[0] !== label)
			{
				$(label).children('.sort_checker').removeClass('check_ok_content');
				$(label).attr('data', '0');
				$(label).parent().children('.f_imp_check').val(false);
			}
		}
	}
	else
	{
		$(this).children('.sort_checker').removeClass('check_ok_content');
		$(this).attr('data', '0');
		$check.val(false);
	}
});

$('.sort_by_cont > input[name="toggle"]').click(function(){
	$('input[name="sorted_by"]').val($(this).val());
});

/*
* Send Sort / Filter request
*/
$('.f_ok_btn').click(function(){

	$sort = {
		priority: getSortPriority(),
		
		interests: getInterests($('.sort_interests').text()),

		sorted_by: getSortedBy($('input[name="sorted_by"]').val()),
	};
	
	$filter = {
		age: getAge($('.filter_range_age').attr('data-lbound'), $('.filter_range_age').attr('data-ubound')),

		distance: getDistance($('input[name="from"]').val(), $('input[name="to"]').val()),

		rating: getRating($('.filter_rating').attr('data-lbound')),

		interests: getInterests($('.filter_interests').text()),
	};

	$local = location.href.split('/');
	$local = '/' + $local[$local.length - 1];
	$local = $local.split('?')[0];
	$str = "?";

	for (let key in $sort){
		if ($sort[key] !== null && $sort[key] !== false)
			$str += 'sort['+ key + ']=' + $sort[key] + '&';
	}

	for (let key in $filter){
		if ($filter[key])
			$str += 'filter['+ key + ']=' + $filter[key] + '&';
	}

	if ($str !== "?")
		location.href = $local + encodeURI($str);
});


/*
* Delete tag
*/
$('.interest_cont, .interest_cont_filter').on('click', 'p.tag_se, p.tag_fil', function(){
	$value = $(this).text().replace('#', '');

	$(this).remove();
});


/** ADD TAG IN FILTER **/

function tagHelperFilter($value){
	$hide = 0;
    $hash = $value.split('#');
    $hash[0] = null;

    $tag = $hash[$hash.length - 1];
    
    if ($hash.length - 1 > 1)
    {
        if ($('.resultTagsFilter') !== undefined)
            $('.sendTagFilter').remove();

        sendTagFilter($hash[1]);
        $('.helperAbs').hide();
        $hide = 1;
        $('#interestsHelpFilter').val('#');
    }
    
    $('.btn_inter_filter').click(function(){
    	$hash = $('#interestsHelpFilter').val().split('#');
    	$hash[0] = null;
    	
    	if ($hash[1])
    	{
    		$hide = 1;
       		changeTagFilter($hash[1]);
    	}
	});

    if ($tag && $tag.length > 2)
    {
        sender.form('/searchTag', {'tag' : $tag}, function(request){
            if ($('.resultTagsFilter') !== undefined)
                    $('.resultTagsFilter').remove();

            if ($hide)
            	$('.helperAbs').hide();
            else if (request.similar.length)
            {
                $('.helperProfIntFilter').show();
                for (let value of request.similar){
                    $('.helperProfIntFilter').append('\
                        <p class="resultTagsFilter" onclick="changeTagFilter(this.innerText)">'
                        + value.tag + '</p>')
                }
            }
            else
                $('.helperAbs').hide();
        });
    }
}

function changeTagFilter(tag){
    sendTagFilter(tag);

    $('.resultTagsFilter').remove();
    $('.helperAbs').hide();
    $('#interestsHelpFilter').val('#');
}
function sendTagFilter(tag)
{
    let $search = '#' + tag;
    for (let $value of $('.tag_fil')){
        if ($value.innerHTML === $search)
            return;
    }

    if (tag !== '' && tag !== '#')
    {
    	$('.interest_cont_filter').prepend(
    	 	'<p class="tag_fil">#' + tag + '</p>');
    }
}
/** /ADD TAG IN FILTER **/



/*
* Hide tag helper
*/
$(window).on('click', function(event){
    let $helper = $('.helperProfInt');
	let $helper1 = $('.helperProfIntFilter');
    if ($helper !== undefined &&
        $helper.attr('style') !== 'display: none;' &&
        event.target !== $helper[0])
        $helper.hide();
    else if ($helper1 !== undefined &&
        $helper1.attr('style') !== 'display: none;' &&
        event.target !== $helper1[0])
        $helper1.hide();
});

/*
* Delete in the Distance input if this is not a number
*/
$('.distance_inp').keyup(function(){
    $testText =  $(this).val();
	
	if($testText*1 + 0  !=  $(this).val())
  		$(this).val($testText.substring(0, $testText.length - 1));
});

/*
* Add new tag in to tags select
*/
function sendTag(tag)
{
    let $search = '#' + tag;
    for (let $value of $('.tag_se')){
        if ($value.innerHTML === $search)
            return;
    }

    if (tag !== '' && tag !== '#')
    {
    	$('.interest_cont').prepend(
    	 	'<p class="tag_se">#' + tag + '</p>');
    }
}

function getSortPriority(){
	$priority = {
		age: ($('.sort_age').val() === 'false') ? false : true,
		location: ($('.sort_location').val() === 'false') ? false : true,
		rating: ($('.sort_rating').val() === 'false') ? false : true, 
	}

	for (let i in $priority){
		if ($priority[i])
			return (i);
	}

	return (null);
}

function getInterests($interestsText){
	if ($interestsText === "")
		return (null);

	return ($interestsText.split('#').splice(1));
}

function getAge($min, $max){
	if ($min === '10' &&
		$max === '60')
		return (null);
	else
		return ($min + '-' + $max);
}

function getDistance($from, $to){
	if ($from === "" && $to === "")
		return (null);

	$from = $from === "" ? '0' : $from;
	$to = $to === "" ? '1000' : $to;

	return ($from +'-'+ $to);
}

function getRating($rating){
	return ($rating === '0' ? null : $rating);
}

function getSortedBy($name){
	if ($name === "")
		return (null);

	return ($name);
}