// this includes js related to product listings (listing, filters, alternating stylesheets)


function showFilter(objId) {
	var obj = document.getElementById(objId);
	obj.style.display='block';
}

function hideFilter(objId) {
	var obj = document.getElementById(objId);
	obj.style.display='none';
}
function switch_Filters(objId) {
	var obj = document.getElementById(objId);
	var targ = obj.parentNode;
	var box = targ.id;
	filters = document.getElementById("Filterbox").getElementsByTagName('div');
	for(var i=0; i<filters.length; i++){
		filters_item = filters[i];
		if (filters_item.style.display == 'block') {
			filters_item.style.display = 'none';
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

// filter hide fix
//----------------

function hideall_Filters() {
	filters = document.getElementById("Filterbox").getElementsByTagName('div');
	for(var i=0; i<filters.length; i++){
		filters_item = filters[i];
		if (filters_item.style.display == 'block') {
			filters_item.style.display = 'none';
			}
		}
	}


// Listing togglers
//-----------------

function showIt(obj) {
	var el = document.getElementById(obj);
	el.style.display = 'block';
	el.style.zIndex = '1000';
}
function hideIt(obj) {
	var el = document.getElementById(obj);
	el.style.display = 'none';
}



// Alternate stylesheet switcher
// -----------------------------

function setActiveStyleSheet(title) {
  var i, a, main;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
      a.disabled = true;
      if(a.getAttribute("title") == title) a.disabled = false;
    }
  }
}

function getActiveStyleSheet() {
  var i, a;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title") && !a.disabled) return a.getAttribute("title");
  }
  return null;
}

function getPreferredStyleSheet() {
  var i, a;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1
       && a.getAttribute("rel").indexOf("alt") == -1
       && a.getAttribute("title")
       ) return a.getAttribute("title");
  }
  return null;
}

function createCookie(name,value,days) {
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  }
  else expires = "";
  document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}

window.onload = function(e) {
  var cookie = readCookie("style");
  var title = cookie ? cookie : getPreferredStyleSheet();
  setActiveStyleSheet(title);
}

window.onunload = function(e) {
  var title = getActiveStyleSheet();
  createCookie("style", title, 365);
}

window.onunload = function(e) {
  //new SearchSuggestor('Search');
  
}

var cookie = readCookie("style");
var title = cookie ? cookie : getPreferredStyleSheet();
setActiveStyleSheet(title);


// simple toggler (advanced search)
//---------------

function AS_toggle(objId) {
	var e = document.getElementById(objId);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
}

function AS_toggle_filter(objId, from, to) {
	for(var i=from+1;i<=to;i++){
		var e = document.getElementById(objId+'_'+i);
		if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
	}
}


// slider listing
//---------------
function activateBut (pos, max, objName, div) {
	//alert(pos);
	//alert(max);
	//alert(objName);
        //alert(div);
	var maxnr = 0;
	var prev = 0;
	var next = 0;

	//alert(pos);
	if(max%4 != 0){

		maxnr = parseInt(max/4)+1;
	}
	else{
		maxnr = parseInt(max/4);
	}
	//alert(maxnr);
	for (i = 1 ; i <= maxnr ; i++) {
		document.getElementById(objName+i).className = 'inactive';
		document.getElementById(objName+"prevLink"+i).style.display = 'none';
		document.getElementById(objName+"nextLink"+i).style.display = 'none';
		document.getElementById(objName+"prevLinkOff").style.display = 'none';
		document.getElementById(objName+"nextLinkOff").style.display = 'none';
	}
	//alert(document.getElementById(objName+pos).className);
	document.getElementById(objName+pos).className = 'active';
	//alert(document.getElementById(objName+pos).className);
	prev = pos-1;
	next = pos+1;	
	if(prev > 0) {
	document.getElementById(objName+"prevLink"+prev).style.display = 'inline';
	}
	else
	{
	document.getElementById(objName+"prevLinkOff").style.display = 'inline';
	}
	
	if (next <= maxnr) {
	document.getElementById(objName+"nextLink"+next).style.display = 'inline';
	}	
	else {
	document.getElementById(objName+"nextLinkOff").style.display = 'inline';
	}
	//slide to products
	var parent  = document.getElementById(div);
	var products = new Array();
	var i = 0;
	var min = 4*(pos-1);

	products[i] = firstChild(parent);
        if (products[i] && (i >= min) && (i < min+4))
            {
               products[i].style.display = 'inline';
            }else
            {
               products[i].style.display = 'none';
            }
	parent = nextSibling(products[i]);

	while(parent != null)
	{
            i++;
            products[i] = parent;
            if ((i >= min) && (i < min+4))
            {
               products[i].style.display = 'inline';
            }else
            {
               products[i].style.display = 'none';
            }

            parent = nextSibling(products[i]);
        }//end while


}

function firstChild(parent)
{
         if (parent == null)
            return null;
         fChild = parent.firstChild;
         while(fChild && fChild.nodeType != 1)
           {
             fChild = fChild.nextSibling;
           }
         return fChild;
}
function nextSibling(obj)
{
            if (obj == null)
               return null;
            obj = obj.nextSibling;
            while (obj && obj.nodeType != 1)
            {
              obj = obj.nextSibling;
            }
            return obj;
}
