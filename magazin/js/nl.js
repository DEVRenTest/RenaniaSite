
$(document).ready(function() {
	$('.submit-nl').bind('click',function(e){
		e.preventDefault();
		$.ajax({
			url: 'index.php/frontend/newsletter/ajax_add',
			type: 'POST',
			data: {
				email: $('.email-field').val()
			},
			success: function(response) {
				if( response == 0 ) {
					$('.fail-container').show();
				} else {
					$('.success-container').show();
				}
			}
		});
	});
	$('.fail-nl .close').bind('click',function(e){
		e.preventDefault();
		$('.fail-container').hide();
	});
	$('.success-nl .close').bind('click',function(e){
		e.preventDefault();
		$('.success-container').hide();
	});
	
});
