//send 
$(function(){
	$("#loginFormBox input:radio").click(function(){
		
		if($(this).attr('id') == 'customer_new' && $(this).is(':checked')){
			$("#deliveryDetails").show(500);
			$(".loginFields").hide(100);
			
		}
		else{
			$("#deliveryDetails").hide(500);
			$(".loginFields").show(100);
		}
	});
	
	$("#loginFormBox .radio").live('click',function(){
		if($("#customer_new").is(':checked')){
			$("#deliveryDetails").show(500);
			$(".loginFields").hide(100);
			
		}
		else{
			$("#deliveryDetails").hide(500);
			$(".loginFields").show(100);
		}
	});
	
	//display/hide companies box
	$("#customerTypeBox input:radio").live('change',function(){
		if($(this).attr('id') == 'customer_type_pj' && $(this).is(':checked')){
			$("#companiesBox").show(500);
		}
		else{
			$("#companiesBox").hide(500);
		}
	});
	
	//display/hide companies box when clicked on radio box
	$("#customerTypeBox .radio").live('click',function(){
		if($("#customer_type_pj").is(':checked')){
			$("#companiesBox").show(500);
		}
		else{
			$("#companiesBox").hide(500);
		}
	});
	
	
	//display/hide edit links and forms for companies on select
	$("#companiesBox input:radio").live('change',function(){
		//hide all links and forms
		$(".editCompany").hide();
		$(".companyBox").hide(500);
		
		//if click on new company display form
		if($(this).val()=='0' && $(this).is(':checked')){
			$("#companyBox_"+$(this).val()).show(500);
		}
		else if($(this).is(':checked')){//show checked links
			$("#editCompany_"+$(this).val()).show();
		}
	});
	
	$("#companiesBox .radio").live('click',function(){
		if($(this).next().val() != 'sc' && $(this).next().val() != 'pfa'){
			//hide all links and forms
			$(".editCompany").hide();
			$(".companyBox").hide(500);
			
			//if click on new company display form
			$("#companiesBox input:radio").each(function(index, el){
				if($(this).val()=='0' && $(this).is(':checked')){
					$("#companyBox_"+$(this).val()).show(500);
				}
				else if($(this).is(':checked')){//show checked links
					$("#editCompany_"+$(this).val()).show();
				}
			});
		}
	});
	
	//display/hide edit links and forms for addresses on select
	$("#addressesBox input:radio").click(function(){
		//hide all links and forms
		$(".editAddress").hide();
		$(".addressBox").hide(500);
		
		//if click on new address display form
		//if click on new company display form
		if($(this).val()=='0' && $(this).is(':checked')){
			$("#addressBox_"+$(this).val()).show(500);
		}
		else if($(this).is(':checked')){//show checked links
			$("#editAddress_"+$(this).val()).show();
		}
	});
	
	//display/hide edit links and forms for addresses on select
	$("#addressesBox .radio").live('click',function(){
		//hide all links and forms
		$(".editAddress").hide();
		$(".addressBox").hide(500);
		
		//if click on new address display form
		//if click on new company display form
		$("#addressesBox input:radio").each(function(index, el){
			
			if($(this).val()=='0' && $(this).is(':checked')){
				$("#addressBox_"+$(this).val()).show(500);
			}
			else if($(this).is(':checked')){//show checked links
				$("#editAddress_"+$(this).val()).show();
			}
		});

	});
	
	//display quick order
	$('#quickorderopen').click(function(){
		$('.overlay').show();
		$('#quickOrder').fadeIn('fast',function(){
			//$('#box').animate({'top':'60px'},500);
		});
	});
	//display quick order
	$('#quickorderclose').click(function(){
		$('.overlay').hide();
		$('#quickOrder').fadeOut('fast',function(){
			//$('#box').animate({'top':'60px'},500);
		});
	});
	
	//change cart form action when payment changed
	$("#paymentBox input:radio").change(function(){
		$("#action").val('changepayment');
		$("#cartForm").submit();
	});
	
	$("#paymentBox .radio").live('click',function(){
		$("#action").val('changepayment');
		$("#cartForm").submit();
	});
	
	//change cart form action when delivery changed
	$("#deliveryBox input:radio").live('click', function(){
		$("#action").val('changedelivery');
		$("#cartForm").submit();
	});
	
	$("#deliveryBox .radio").live('click', function(){
		$("#action").val('changedelivery');
		$("#cartForm").submit();
	});
	
	$("#incheiecomanda").live('click', function(){
		$("#action").val('go');
		//$("#cartForm").submit();
	});
	
	//display cities when county is changed
	$("#addressesBox select[name*='county']").change(function(){
		//name = $(this).attr('name').split('_');
        name = $(this).attr('name').replace('county_', '');
		$.ajax({
			type: "GET",
			url: "index.php?page=cart&action=getcities&county="+$(this).val(),
			success: function(data) {
				$("#city_"+name).html(data);
				
			}
		});
	});
	
	//change company fiscalcode/cnp
	$("#companiesBox .radio").live('click', function(){
		var id = $(this).next().attr('name').split('_');
		if($(this).next().val() == 'pfa'){
			$("#fiscalcode_"+id[1]).prev().text('CNP');
		}
		if($(this).next().val() == 'sc'){
			$("#fiscalcode_"+id[1]).prev().text('Cod fiscal');
		}
	});
	
	//display cities when county is changed; companies
	$("#companiesBox select[name*='county']").change(function(){
		//name = $(this).attr('name').split('_');
         name = $(this).attr('name').replace('companycounty_', '');
		$.ajax({
			type: "GET",
			url: "index.php?page=cart&action=getcities&county="+$(this).val(),
			success: function(data) {
				$("#companycity_"+name).html(data);
			}
		});
	});
	
	$("#cartForm").live('submit',function(){
		if($("#action").val()=='changepayment' || $("#action").val()=='changedelivery'){
			dataString = $("#cartForm").serialize();
			$.ajax({
				type: "POST",
				url: "index.php?page=cart",
				dataType: 'json',
				data: dataString,
				success: function(data) {
					if(data['delivery'] != ''){
						$("#deliveryBox").html(data['delivery']);
					}
					if(data['delivery_price'] != ''){
						$("#deliveryPrice").html(data['delivery_price']);
					}
					if(data['grandtotal_livrare'] != ''){
						$("#grandtotalDelivery").html(data['grandtotal_livrare']);
					}
					Custom.init();
				}
			});
			return false;
		}
		else{
			//validate form
			
			if($("#cartForm input[name=firstname]").val() == ''){
				$("#cartForm input[name=firstname]").focus();
				alert('Nu ai introdus prenumele.');
				return false;
			}
			if($("#cartForm input[name=lastname]").val() == ''){
				$("#cartForm input[name=lastname]").focus();
				alert('Nu ai introdus numele (de familie)');
				return false;
			}
			if($("#cartForm input[name=email]").length > 0){
				if(!validateEmail($("#cartForm input[name=email]").val())){
					$("#cartForm input[name=email]").focus();
					alert('Adresa de email nu este valida.');
					return false;
				}
			}
			if(!validatePhone($("#cartForm input[name=phone]").val())){
				$("#cartForm input[name=phone]").focus();
				alert('Telefonul nu este valid');
				return false;
			}
			if($("#cartForm input:checked").val() == 'pj'){//check company
				if($("#cartForm input[name=companyname_"+$("#companiesBox input:checked").val()+"]").val() == ''){
					$("#cartForm input[name=companyname_"+$("#companiesBox input:checked").val()+"]").focus();
					alert('Nu ai introdus numele firmei');
					return false;
				}else if($("#cartForm input[name=fiscalcode_"+$("#companiesBox input:checked").val()+"]").val() == ''){
					$("#cartForm input[name=fiscalcode_"+$("#companiesBox input:checked").val()+"]").focus();
					alert('Nu ai introdus codul fiscal');
					return false;
				}else if($("#cartForm select[name=companycounty_"+$("#companiesBox input:checked").val()+"]").val() == ''){
					$("#cartForm select[name=companycounty_"+$("#companiesBox input:checked").val()+"]").focus();
					alert('Nu ai introdus judetul firmei');
					return false;
				}else if($("#cartForm select[name=companycity_"+$("#companiesBox input:checked").val()+"]").val() == ''){
					$("#cartForm select[name=companycity_"+$("#companiesBox input:checked").val()+"]").focus();
					alert('Nu ai introdus orasul firmei');
					return false;
				}else if($("#cartForm input[name=companystreetaddress_"+$("#companiesBox input:checked").val()+"]").val() == ''){
					$("#cartForm input[name=companystreetaddress_"+$("#companiesBox input:checked").val()+"]").focus();
					alert('Nu ai introdus adresa firmei');
					return false;
				}
			}
			if($("#cartForm select[name=county_"+$("#addressesBox input:checked").val()+"]").val() == ''){//check address
				$("#cartForm select[name=county_"+$("#addressesBox input:checked").val()+"]").focus();
				alert('Nu ai introdus judetul');
				return false;
			}else if($("#cartForm select[name=city_"+$("#addressesBox input:checked").val()+"]").val() == ''){
				$("#cartForm select[name=city_"+$("#addressesBox input:checked").val()+"]").focus();
				alert('Nu ai introdus orasul');
				return false;
			}else if($("#cartForm input[name=streetaddress_"+$("#addressesBox input:checked").val()+"]").val() == ''){
				$("#cartForm input[name=streetaddress_"+$("#addressesBox input:checked").val()+"]").focus();
				alert('Nu ai introdus adresa');
				return false;
			}
			if(!$("#cartForm input[name=terms]").is(":checked")){//check terms
				$("#cartForm input[name=terms]").focus();
				alert('Trebuie sa fiti de acord cu termenii si conditiile pentru a continua.');
				return false;
			}
			
			if($("#cartForm input[name=terms]").is(":checked") && !$("#cartForm input[name=deacord]").is(":checked"))
			{
				$("#cartForm input[name=deacord]").focus();
				alert('Trebuie sa fiti de acord ca toate datele introduse sunt corecte pentru a continua.');
				return false;
				}
			
			return true;
			
		}
	});
	
});