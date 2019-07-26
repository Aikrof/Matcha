$('.form').find('input, textarea').on('keyup blur focus', function (e) {
  
  var $this = $(this),
      label = $this.prev('label');

	  if (e.type === 'keyup') {
			if ($this.val() === '') {
          label.removeClass('active highlight');
        } else {
          label.addClass('active highlight');
        }
    } else if (e.type === 'blur') {
    	if( $this.val() === '' ) {
    		label.removeClass('active highlight'); 
			} else {
		    label.removeClass('highlight');   
			}   
    } else if (e.type === 'focus') {
      
      if( $this.val() === '' ) {
    		label.removeClass('highlight'); 
			} 
      else if( $this.val() !== '' ) {
		    label.addClass('highlight');
			}
    }

});

$('.tab a').on('click', function (e) {

  e.preventDefault();
  
  $(this).parent().addClass('active');
  $(this).parent().siblings().removeClass('active');
  
  target = $(this).attr('href');

  $('.tab-content > div').not(target).hide();
  $(target).fadeIn(600);
  $('.forg_wrap').hide();
});

$('.forgot').on('click', function(event){
  event.preventDefault();

  if ($('.forg_wrap').attr('style') === 'display: none;')
  {
    $('.sig').hide();
    $('.forg_wrap').show();
  }
  else
  {
    $('.forg_wrap').hide();
    $('.sig').show();
  }
});

$('.gender').on('click', function(event){
    var f = $('#f_gender');
    var t = $('#t_gender');

    if (this === f[0])
        addMitmash(f, t);
    else
        addMitmash(t, f);

    function addMitmash(a, b)
    {
        a.addClass('mitmash_v2');
        a.removeClass('mitmash_v1');
        b.removeClass('mitmash_v2');
        b.addClass('mitmash_v1');

        $('#gender')[0].value = a[0].innerText
    }
});

$('.form').on('submit', function(event){
    event.preventDefault();

    var obj = {};
    for (let input of event.target){
      if (input.localName === 'input')
        obj[input.name] = input.value;
    }

    ajaxSender('/' + event.target.id, obj, function(request){
        if (request.susses_registr)
            swal(request.susses_registr, "", "success");
        else
            swal(request, "", "error");
    });

    return false;
});
