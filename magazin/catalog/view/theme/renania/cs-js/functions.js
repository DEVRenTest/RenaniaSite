// Listing togglers
//-----------------

var BrowserDetect = {
	init: function () {
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
		for (var i=0;i<data.length;i++)	{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{
			string: navigator.userAgent,
			subString: "Chrome",
			identity: "Chrome"
		},
		{ 	string: navigator.userAgent,
			subString: "OmniWeb",
			versionSearch: "OmniWeb/",
			identity: "OmniWeb"
		},
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari",
			versionSearch: "Version"
		},
		{
			prop: window.opera,
			identity: "Opera"
		},
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		},
		{		// for newer Netscapes (6+)
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 		// for older Netscapes (4-)
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}
	],
	dataOS : [
		{
			string: navigator.platform,
			subString: "Win",
			identity: "Windows"
		},
		{
			string: navigator.platform,
			subString: "Mac",
			identity: "Mac"
		},
		{
			   string: navigator.userAgent,
			   subString: "iPhone",
			   identity: "iPhone/iPod"
	    },
		{
			string: navigator.platform,
			subString: "Linux",
			identity: "Linux"
		}
	]

};
BrowserDetect.init();

function showItCart(obj) {
	
	//alert($('ShoppingCart').style.left);
	//var cartDiv = document.getElementById('ShoppingCart');
	//alert(cartDiv.style.right);
	
	var el = document.getElementById(obj);
	
	xMiddle = document.body.clientWidth/2;
	xPos = xMiddle - 490;
	yPos = 114;
	
	if(BrowserDetect.browser == 'Explorer') {
		if(BrowserDetect.version == '6') {
			xPos = xMiddle + 353;
			if (document.getElementById('order')) {
			document.getElementById('order').style.visibility = 'hidden';
		}
		}
		
		if(BrowserDetect.version == '7') {
			xPos = xMiddle -490;
		}
		
		if(BrowserDetect.version == '8') {
			xPos = xMiddle - 490;
		}				
	}
	
	el.style.right = xPos+'px';
	el.style.top = yPos+'px';
	
	el.style.display = 'block';

	el.style.zIndex = '1000';
}

function hideItCart(obj) {
	var el = document.getElementById(obj);
	el.style.display = 'none';
	if(BrowserDetect.browser == 'Explorer') {
		if(BrowserDetect.version == '6') {
			if (document.getElementById('order')) {
			document.getElementById('order').style.visibility = 'visible';
		}
		}
		
		if(BrowserDetect.version == '7') {

		}
		
		if(BrowserDetect.version == '8') {

		}				
	}	
}

function showIt(obj) {
	var el = document.getElementById(obj);
	el.style.display = 'block';
	el.style.zIndex = '1000';
}
function hideIt(obj) {
	var el = document.getElementById(obj);
	el.style.display = 'none';
}

function popup(fileName, ww, wh) {
	var x = (screen.width-ww)/2;
	var y = (screen.height-wh)/2;
	OpenWin = this.open(fileName, "CtrlWindow", "width="+ww+", height="+wh+" toolbar=no,menubar=no,location=no,scrollbars=yes,resizable=yes, screenX="+x+", screenY="+y+", left="+x+", top="+y);
}

function switch_promo(objId) {
	var obj = document.getElementById(objId);
	var targ = obj.parentNode;
	var box = targ.id;
	promos = document.getElementById("HomepagePromos").getElementsByTagName('div');
	for(var i=0; i<promos.length; i++){
		promos_item = promos[i];
		if (promos_item.style.display == 'block') {
			promos_item.style.display = 'none';
			}
		}
	obj.style.display = 'block';
	if (obj.style.display = 'none')
	{
		obj.style.display = 'block';
	}
	else {
		obj.style.display = 'none';
	}
}
function set_Current(name) {
	var linkloc = name.parentNode;
	var linkbox = linkloc.id;
	promolink = document.getElementById("promolinks").getElementsByTagName('li');
	for(var i=0; i<promolink.length; i++){
		promo_link = promolink[i];
		if (promo_link.className == "current") {
			promo_link.className = "";
			}
	}
	name.className = "current";
	}




// expand collapse cart toggler 
//----------------------------

function ECCart_toggle(objId) {
	
	explink = document.getElementById('expandlink');
	cTotal = document.getElementById('cartTotal');
	
	var e = document.getElementById(objId);
       if(e.style.display == 'block'){
          e.style.display = 'none';
          explink.className = 'cartexpand';
		  cTotal.className = 'emphTotal';
		  }
       else {
          e.style.display = 'block';
          explink.className = 'cartcollapse';
		  cTotal.className = 'normalTotal';
          }
}






// product page tab toggler 
//-------------------------

/*-----------------------------------------------------------
    Toggles element's display value
    Input: any number of element id's
    Output: none 
    ---------------------------------------------------------*/
function toggleDisp() {
    for (var i=0;i<arguments.length;i++){
        var d = $(arguments[i]);
        if (d.css('display') == 'none')
            d.show();
        else
            d.hide();
    }
}
/*
function toggleDisp() {
    for (var i=0;i<arguments.length;i++){
        var d = $(arguments[i]);
        if (d.style.display == 'none')
            d.style.display = 'block';
        else
            d.style.display = 'none';
    }
}
*/
/*-----------------------------------------------------------
    Toggles tabs - Closes any open tabs, and then opens current tab
    Input:     1.The number of the current tab
                    2.The number of tabs
                    3.(optional)The number of the tab to leave open
                    4.(optional)Pass in true or false whether or not to animate the open/close of the tabs
    Output: none 
    ---------------------------------------------------------*/
function toggleTab(num,numelems,opennum,animate) {
	
    if ($('#tabContent'+num).css('display') == 'none'){
        for (var i=1;i<=numelems;i++){
            if ((opennum == null) || (opennum != i)){
                var temph = '#tabHeader'+i;
				var h = $(temph);
				
                /*if (!h.length>0){
                    var h = $('#tabHeaderActive');
                    h.id = temph;
                }*/
				
				h.removeClass('currenttab');
                var tempc = '#tabContent'+i;
                var c = $(tempc);
                if(c.css('display') != 'none'){
                    if (animate || typeof animate == 'undefined')
                        //Effect.toggle(tempc,'blind',{duration:0.5, queue:{scope:'menus', limit: 3}});
						toggleDisp(tempc);
                    else
                        toggleDisp(tempc);
                }
            }
        }
        var h = $('#tabHeader'+num);
		
        if (h){
            //h.id = 'tabHeaderActive';
			h.addClass('currenttab');
		}
        h.blur();
        var c = $('#tabContent'+num);
		
        c.css('marginTop','2px');// = '2px';
        if (animate || typeof animate == 'undefined'){
            //Effect.toggle('tabContent'+num,'blind',{duration:0.5, queue:{scope:'menus', position:'end', limit: 3}});
			toggleDisp('#tabContent'+num);
        }else{
            toggleDisp('#tabContent'+num);
        }
    }
}
/*
function toggleTab(num,numelems,opennum,animate) {
    if ($('tabContent'+num).style.display == 'none'){
        for (var i=1;i<=numelems;i++){
            if ((opennum == null) || (opennum != i)){
                var temph = 'tabHeader'+i;
                var h = $(temph);
                if (!h){
                    var h = $('tabHeaderActive');
                    h.id = temph;
                }
                var tempc = 'tabContent'+i;
                var c = $(tempc);
                if(c.style.display != 'none'){
                    if (animate || typeof animate == 'undefined')
                        Effect.toggle(tempc,'blind',{duration:0.5, queue:{scope:'menus', limit: 3}});
                    else
                        toggleDisp(tempc);
                }
            }
        }
        var h = $('tabHeader'+num);
        if (h)
            h.id = 'tabHeaderActive';
        h.blur();
        var c = $('tabContent'+num);
        c.style.marginTop = '2px';
        if (animate || typeof animate == 'undefined'){
            Effect.toggle('tabContent'+num,'blind',{duration:0.5, queue:{scope:'menus', position:'end', limit: 3}});
        }else{
            toggleDisp('tabContent'+num);
        }
    }
}
*/
function isUnsignedInteger(s) {
			return (s.toString().search(/^[0-9]+$/) == 0);
}

function validateEmail(email) {
				//alert(email);
			   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			   var address = email;
			   if(reg.test(address) == false) {
			      return false;
			   }
			   else{
				return true;
			   }
			}
function validatePhone(phone) {
				//alert(email);
			   var reg = /^(\+)*([0-9])+$/;
			   
			   if(reg.test(phone) == false) {
			      return false;
			   }
			   else{
				return true;
			   }
			}
function checkLengthNewsletter(form){
				/*
			    if (!(form.email.value.indexOf(' ')==-1 && 0<form.email.value.indexOf('@') && form.email.value.indexOf('@')+1 < form.email.value.length ) || form.email.value == 'nume@domeniu.ro'){
			        alert("Adresa de email introdusa nu este valida. Va rugam sa corectati erorile si sa incercati din nou.");
			        return false;
			    }
				
				if (!form.name.value.length){
					alert("Va rugam introduceti numele dumneavoastra.");
					return false;
				}
				*/
				if (!validateEmail(form.email.value)){
			        alert("Adresa de email introdusa nu este valida. Va rugam sa corectati erorile si sa incercati din nou.");
			        return false;
			    }
				
			    return true;
			}
function entsubn(event) {
			  if (event && event.which == 13)
			    if (checkLengthNewsletter(document.formnl)) document.formnl.submit();
			  else
			    return true;
			}

function checkDefaultValues(frm){
          var cmp1  = 1;
          var cmp11 = 1;
          var cmp2  = 1;
          var cmp3  = 1;

          if(frm.query.value == '' || frm.query.value.length < 3 || frm.query.value == 'Produs'){
              cmp1 = 0;
              if(frm.query.value.length < 3){
                  cmp11 = 0;
              }
          }
					if(frm.min){

                    if(isNaN(frm.min.value)){
                        cmp2 = 0;
                    }
					}
					if(frm.max){
                    if(isNaN(frm.max.value)){
                        cmp3 = 0;
                    }
					}
					if(frm.min){

                    if(frm.min.value == 'Pret minim'){
                        frm.min.value='';
                    }
					}
					if(frm.max){
                    if(frm.max.value == 'Pret maxim'){
                        frm.max.value='';
                    }
					}

          if(cmp1 && cmp2 && cmp3){
              frm.submit();
              return true;
          }
          else if(!cmp1){
              if(!cmp11){
                  alert("Valoare invalida!\nValoarea dupa care se face cautarea trebuie sa contina minim trei caractere.");
              }
              else{
                  alert("Valoare invalida!\nVa rog completati campul rezervat produsului cautat.");
                  frm.query.value='';
              }

              frm.query.focus();
              return false;
          }

          else if(!cmp2){
              alert("Valoare invalida!\nVa rog completati campul rezervat pretului minim cu o valoare numerica.");
              frm.min.value='';
              frm.min.focus();
              return false;
          }
          else if(!cmp3){
              alert("Valoare invalida!\nVa rog completati campul rezervat pretului maxim cu o valoare numerica.");
              frm.max.value='';
              frm.max.focus();
              return false;
          }
      }

function validInputText(frm,txt_field){
    if(document.getElementById(txt_field).value != ''){
        return true;
    }
    return false;
}

function validInputPrice(frm,txt_field){
	var price=parseFloat(document.getElementById(txt_field).value);
    if(isNaN(price) || price<=0){
        alert("Va rugam sa introduceti un pret corect. ");
        return false;
    }
    return true;
}

function resetEmail(email_field){
    if(document.getElementById('emaila').value == 'nume@domeniu.extensie'){
        document.getElementById('emaila').value = '';
    }
    return true;
}

function validateAlert(frm){
	if(!validInputText(frm,'namea')){
		alert("Va rugam completati spatiul rezervat numelui dumneavoastra!");
        frm.name.focus();
        return false;
    }
	else if(!validateEmail(frm.email.value)){
		alert("Adresa de email introdusa nu este valida. Va rugam sa corectati erorile si sa incercati din nou.");
        frm.email.focus();
        return false;
	}
	else if(!validInputPrice(frm,'price')){
		frm.price.focus();
        return false;
	}
	else{
		frm.submit();
	}
}
function validateComment(frm){
    if(!validInputText(frm,'namec')){
        alert("Va rugam completati spatiul rezervat numelui dumneavoastra.");
        frm.name.focus();
    }


	else if(!validateEmail(frm.email.value)){
		 alert('Adresa de email introdusa nu este valida. Va rugam sa corectati erorile si sa incercati din nou.');
        frm.email.focus();
    }
	else if (!validInputText(frm,'comment')){
	  alert("Va rugam introduceti un text in campul de comentariu.");
	  frm.comment.focus();
	}
	else{
		frm.submit();
	}
}


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
	
function sendRelated(){
		var BoxList = document.getElementsByTagName("input");
		var productIDS = '';
		for(var i=0;i<BoxList.length;i++){
			if(BoxList[i].name.search('orderpr')==0 && BoxList[i].value>0){
				productIDS = productIDS + BoxList[i].name.substring(8,BoxList[i].name.length) + '|'+BoxList[i].value + '|';
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
	
