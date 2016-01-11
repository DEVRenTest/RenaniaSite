function sendRelated(){
	var checkBoxList = document.getElementsByTagName("input");
//alert(checkBoxList.length);
	var productIDS = '';
	for(var i=0;i<checkBoxList.length;i++){
		if(checkBoxList[i].name.search('orderpr')==0 && checkBoxList[i].checked){
			productIDS = productIDS + checkBoxList[i].name.substring(8,checkBoxList[i].name.length) + '|';
		}
	}
	productIDS = productIDS.substring(0,productIDS.length-1);
	if(productIDS!=''){
		window.location='index.php?page=cart&action=add_related&productid='+productIDS;
	}
	else{
	alert('Va rugam selectati cel putin un produs.');
	}
}