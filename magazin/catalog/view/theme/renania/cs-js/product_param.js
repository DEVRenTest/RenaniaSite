//remove compare product on image click action
var mouse_is_inside = false;
$(function(){
	$(".values").click(function(){
		paramid = $(this).attr('value');
		if($("#dropmenudiv_"+paramid).is(":visible")){
			show = false;
		}
		else{
			show = true;
		}
		$(".dropmenudiv").hide();
		$(".dropmenudiv").empty();
		if(show){
			$.ajax({
				type: "GET",
				url: "index.php?page=product_param&action=getparamvalues&paramid="+$(this).attr('value'),
				success: function(data) {
					$("#dropmenudiv_"+paramid).html(data);
					$("#dropmenudiv_"+paramid).show();
				}
			});
		}
		return false;
	});
	
	$(".dropmenudiv a").live('click',function(){
		paramid = $(this).parent().prev().attr('value');
		$("#info_"+paramid).val($(this).text());
		$(".dropmenudiv").hide();
		$(".dropmenudiv").empty();
		return false;
	});
	
	$('.dropmenudiv').hover(function(){ 
        mouse_is_inside=true; 
    }, function(){ 
        mouse_is_inside=false; 
    });

    $("body").mouseup(function(){
        if(! mouse_is_inside) $('.dropmenudiv').hide();
    });
	
});