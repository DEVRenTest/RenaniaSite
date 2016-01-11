	
//display cities when county is changed
$(function(){
	$("fieldset select[name*='county']").change(function(){
		name = $(this).attr('id').replace('_county', '');
		orderid = ($("form[name=orderForm] :input[name=orderid]").val());
        //alert("index.php?page=orders_form&orderid="+orderid+"&action=getcities&county="+$(this).val());
		$.ajax({
			type: "GET",
			url: "index.php?page=orders_form&orderid="+orderid+"&action=getcities&county="+$(this).val(),
			success: function(data) 
            {
				$("#"+name+"_city").html(data);
			}
		});
	});
	//display/hide companies box
	$("#customerTypeBox input:radio").live('change',function(){
		
		if($(this).attr('id') == 'customer_type_pj' && $(this).is(':checked')){
			$("#companyBox").show();
		}
		else{
			$("#companyBox").hide();
		}
	});
	
	$("input[name=deliveryaddress]").live('change', function(){
		$("#action").val('changedeliveryaddress');
		$("#orderForm").submit();
	});
	
	$("input[name=payment]").live('change', function(){
		$("#action").val('changepayment');
		$("#orderForm").submit();
	});
	
	
	//change delivery address
	$("#change_deliveryaddress").live('change',function(){
		streetaddress = $(this).find(':selected').attr('streetaddress');
		city = $(this).find(':selected').attr('city');
		county = $(this).find(':selected').attr('county');
		$("#delivery_streetaddress").val(streetaddress);
		$("#delivery_city >option").remove();
		$("#delivery_city").append($("<option></option>").attr("value",city).text(city));
		$("#delivery_county").val(county);
		//reset showroom
		$("#showroom").val("");
		
		//check delivery address, uncheck showroom
		$("#deliveryaddress").attr("checked","checked");
		//$("#deliveryaddress_showroom").removeAttr("checked");
	});
	
	//change address
	$("#change_invoiceaddress").live('change',function(){
		streetaddress = $(this).find(':selected').attr('streetaddress');
		city = $(this).find(':selected').attr('city');
		county = $(this).find(':selected').attr('county');
		$("#invoice_streetaddress").val(streetaddress);
		$("#invoice_city >option").remove();
		$("#invoice_city").append($("<option></option>").attr("value",city).text(city));
		$("#invoice_county").val(county);
	});
	
	//change company
	$("#change_company").live('change',function(){
		companyname = $(this).find(':selected').attr('companyname');
		fiscalcode = $(this).find(':selected').attr('fiscalcode');
		commerceregistry = $(this).find(':selected').attr('commerceregistry');
		bankname = $(this).find(':selected').attr('bankname');
		bankaccount = $(this).find(':selected').attr('bankaccount');
		$("#companyname").val(companyname);
		$("#fiscalcode").val(fiscalcode);
		$("#commerceregistry").val(commerceregistry);
		$("#bankname").val(bankname);
		$("#bankaccount").val(bankaccount);
	});
	
	//check showroom
	$("#showroom").live('change',function(){
		//check delivery address, uncheck showroom
		$("#deliveryaddress_showroom").attr("checked","checked");
		$("#deliveryaddress").removeAttr("checked");
	});
	
	//display cities when county is changed
	$("#county").change(function(){
		orderid = ($("form[name=orderForm] :input[name=orderid]"));
		$.ajax({
			type: "GET",
			url: "index.php?page=orders_form&orderid="+orderid+"&action=getstores&county="+$(this).val(),
			dataType: 'json',
			success: function(data) {
				$("#store").html(data['stores']);
			}
		});
	});
	
	$("#orderForm").live('submit',function(){
		
		if($("#action").val()=='changepayment' || $("#action").val()=='changedeliveryaddress'){
			
			dataString = $("#orderForm").serialize();
			$.ajax({
				type: "POST",
				url: "index.php?page=orders_form",
				dataType: 'json',
				data: dataString,
				success: function(data) {
					
					if(data['payment'] != ''){
						$("#paymentBox").html(data['payment']);
					}
					if(data['delivery'] != ''){
						$("#deliveryBox").html(data['delivery']);
					}
					/*
					if(data['delivery_price'] != ''){
						$("#deliveryPrice").html(data['delivery_price']);
					}
					if(data['grandtotal_livrare'] != ''){
						$("#grandtotalDelivery").html(data['grandtotal_livrare']);
					}
					*/
				}
			});
			return false;
		}
		else{
			
			return true;
			
		}
	});
});