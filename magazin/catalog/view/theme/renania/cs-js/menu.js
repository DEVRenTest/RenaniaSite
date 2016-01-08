//functions used for menu

function openMenu(segment_id){
		var x = document.getElementById('categ_menu');
        var lis = x.getElementsByTagName('li');
		var l=lis.length;
		var arr_id = segment_id.split('_');
		var parentList = new Array();
        for(i=0;i<l;i++){
			var arr_li = lis[i].id.split('_');
			if(arr_li[1]==arr_id[2]){
				if(lis[i].style.display=='none'){
					lis[i].style.display='';
				}
				else{
					lis[i].style.display='none';
				}
			}
			if(arr_li[2]==arr_id[1]){
				var parentid = arr_li[2];
				//alert(parentid);
				var parent = lis[i].id;
				//alert(parent);
			}
        }
		if(parentid>0){
			//alert('test');
				openMenu(parent);
			}
}

function closeMenu(segment_id){

        var x = document.getElementById('categ_menu');
        var lis = x.getElementsByTagName('li');
        var i=lis.length;
		var arr_id = segment_id.split('_');
        while (i--) {
				var arr_li = lis[i].id.split('_');
				if(arr_li[1]!=0 && arr_li[1]!=arr_id[2]){
					lis[i].style.display='none';
				}
        }
}
		
		function OpenTab(obj) {
			document.getElementById('Search').style.display = 'none';
			document.getElementById('Login').style.display = 'none';
			
			document.getElementById('SearchLink').className = '';
			document.getElementById('LoginLink').className = '';
			
			document.getElementById(obj).style.display = 'block';
			document.getElementById(obj+'Link').className = 'selected';
			
		}
		
		function OverCategory(obj) {
		 ObName = document.getElementById(obj);
		 clsName = ObName.className;
		 document.getElementById(obj).className = clsName+'_on';
		 
		}
		
		function OutCategory(obj) {
		 clsName = document.getElementById(obj).className;
		 document.getElementById(obj).className = clsName.substr(0, clsName.length-3);
		 
		}		

