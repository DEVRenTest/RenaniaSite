//send 
$(function(){
	$(".AddToCart").click(function(){
		carturl = $(this).attr('href')+'&ajax=1';
		//productID = $(this).attr('productid');
		//bundleID = $(this).attr('bundleid');
		//variantID = $(this).attr('variantid');
		//quantity = $("#quantity_"+productID).val();
		// if(productID){
			// carturl = "http://ladysshop.speedsites.ro/index.php?page=cart&action=add&productid="+productID+"&pvid="+variantID+"&qty="+quantity+"&ajax=1";
		// }
		// else if(bundleID){
			// carturl = "http://ladysshop.speedsites.ro/index.php?page=cart&action=add_bundle&bundleid="+bundleID+"&qty="+quantity+"&ajax=1";
		// }
		//console.log(carturl);
		
		$.ajax({
			type: "GET",
			url: carturl,
			beforeSend: function(data) {
				//$("#loader_"+productID).show();
			},
			success: function(data) {
				
				//console.log(data['popup']);
				if(data['message']){
					$("#message").text(data['message']);
				}
				if(data['data']){
					$("#ShoppingCart").replaceWith(data['data']);
				}
				if(data['error']){
					alert(data['error']);
					//$("#add_"+productID).attr('checked',false);
				}
				if(data['popup']){
					$("#Website").prepend(data['popup']);
				}
			}
		});
		return false;
	});
	
	$("em.plus").click(function(){
		productID = $(this).attr('productid');
		qty = parseInt ($("#quantity_"+productID).val(),10);
		qty = qty + 1;
		$("#quantity_"+productID).val(qty);
	});
	
	$("em.minus").click(function(){
		productID = $(this).attr('productid');
		qty = parseInt ($("#quantity_"+productID).val(),10);
		qty = qty - 1;
		if (qty < 1) qty = 1;
		$("#quantity_"+productID).val(qty);
	});
	
	
});