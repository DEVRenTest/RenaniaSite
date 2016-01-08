//send 
$(function(){
	//display cities when county is changed; addresses
	$("#companiesBox :radio[name*='companytype']").change(function(){
        id = $(this).attr('name').replace('companytype_', '');
		//var id = $(this).attr('name').split('_');
		if($(this).val() == 'pfa'){
			$("#fiscalcode_"+id).prev().text('CNP');
		}
		if($(this).val() == 'sc'){
			$("#fiscalcode_"+id).prev().text('Cod fiscal');
		}
	});
	
	//display cities when county is changed; addresses
	$("#addressesBox select[name*='county']").change(function(){
		//name = $(this).attr('name').split('_');
        name = $(this).attr('name').replace('county_', '');
		$.ajax({
			type: "GET",
			url: "index.php?page=myinfo&view=addresses&action=getcities&county="+$(this).val(),
			success: function(data) {
				//console.log(data);
				console.log(data);
				$("#city_"+name).html(data);
			}
		});
	});
	
	//display cities when county is changed; customer data
	$("#addressBox select[name='county']").change(function(){
		$.ajax({
			type: "GET",
			url: "index.php?page=myinfo&view=info&action=getcities&county="+$(this).val(),
			success: function(data) {
				//console.log(data);
				console.log(data);
				$("#city").html(data);
			}
		});
	});
	
	//display cities when county is changed; companies
	$("#companiesBox select[name*='companycounty']").change(function(){
		//name = $(this).attr('name').split('_');
        name = $(this).attr('name').replace('companycounty_', '');
		$.ajax({
			type: "GET",
			url: "index.php?page=myinfo&view=companies&action=getcities&county="+$(this).val(),
			success: function(data) {
				//console.log(data);
				console.log(data);
				$("#companycity_"+name).html(data);
			}
		});
	});
	
});