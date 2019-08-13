$('.edit_orient').click(function(){
	$change = $(this).attr('change');

	if ($change)
		$('.' + $change).text($(this).text());
	
	editProfile($(this), $(this).text());
});

$('.edit_inp').change(function(){
	editProfile($(this), $(this).val());
});

function editProfile($target, $value)
{
	$name = $target.attr('name');

	let $obj = {[$name] : $value};
	sender.form('/profileUpdate', $obj);
}