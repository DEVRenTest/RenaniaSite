
//remove selects for IE
var Remove = new Array();
Remove['option1'] = 'true';
Remove['option2'] = 'true';
Remove['option3'] = 'false';


function getElementsByClassName(oElm, strTagName, strClassName){
    var arrElements = (strTagName == "*" && oElm.all)? oElm.all : oElm.getElementsByTagName(strTagName);
    var arrReturnElements = new Array();
    strClassName = strClassName.replace(/\-/g, "\\-");
    var oRegExp = new RegExp("(^|\\s)" + strClassName + "(\\s|$)");
    var oElement;
    for(var i=0; i<arrElements.length; i++){
        oElement = arrElements[i];      
        if(oRegExp.test(oElement.className)){
            arrReturnElements.push(oElement);
        }   
    }
    return (arrReturnElements)
}

function MakeLoginButt() {
	var SmallButt = new Array();
	var SmallButt1 = new Array();
	// grey buttons
	SmallButt = getElementsByClassName(document, 'td', 'ButtBigGreyL');
	for (i = 0 ; i < SmallButt.length ; i++) {
			
			idname = SmallButt[i].id;
			document.getElementById(idname).onmouseover = function() {

					nname = this.id.substring(0,this.id.length-1)+"L";
					document.getElementById(nname).className='ButtBigGreyL_on';
					nname1 = this.id.substring(0,this.id.length-1)+"R";
					document.getElementById(nname1).className='ButtBigGrey_on';					

			}
			document.getElementById(idname).onmouseout = function() {

					nname = this.id.substring(0,this.id.length-1)+"L";
					document.getElementById(nname).className='ButtBigGreyL';
					nname1 = this.id.substring(0,this.id.length-1)+"R";
					document.getElementById(nname1).className='ButtBigGrey';

			}
	}
	
	SmallButt1 = getElementsByClassName(document, 'td', 'ButtBigGrey');
	for (j = 0 ; j < SmallButt1.length ; j++) {
			
			idname1 = SmallButt1[j].id;
			
			document.getElementById(idname1).onmouseover = function() {
					nname1 = this.id.substring(0,this.id.length-1)+"R";
					document.getElementById(nname1).className='ButtBigGrey_on';
					nname = this.id.substring(0,this.id.length-1)+"L";
					document.getElementById(nname).className='ButtBigGreyL_on';
			}
			document.getElementById(idname1).onmouseout = function() {
					nname1 = this.id.substring(0,this.id.length-1)+"R";
					document.getElementById(nname1).className='ButtBigGrey';
					nname = this.id.substring(0,this.id.length-1)+"L";
					document.getElementById(nname).className='ButtBigGreyL';
				}
	}		

	SmallButt2 = getElementsByClassName(document, 'input', 'logininput');
	for (i = 0 ; i < SmallButt2.length ; i++) {
			idname = SmallButt2[i].id;
			document.getElementById(idname).onfocus = function() {
				this.className = 'logininput_s';
			}
			document.getElementById(idname).onblur = function() {
				this.className = 'logininput';
			}
		
	}	
	
}

function RemoveButtons() {
	var RemButtons = new Array();
	 
	 RemButtons = element.getElementsByTagName('select');
	 
	 for (i = 0 ; i < RemButtons.length ; i++) {
	 	
	 	selectID = RemButtons[i].id;	 	
	 	if (Remove[selectID] == 'true') {
			document.getElementById(selectID).style.display = 'none';	 		
	 	}
	}	 
}

function PutButtons() {
	var RemButtons = new Array();
	 
	 RemButtons = element.getElementsByTagName('select');
	 
	 for (i = 0 ; i < RemButtons.length ; i++) {
	 	
	 	selectID = RemButtons[i].id;	 	
	 	if (Remove[selectID] == 'true') {
			document.getElementById(selectID).style.display = 'inline';	 		
	 	}
	}	 
}

function MakeButtons() {
	var SmallButt = new Array();
	var SmallButt1 = new Array();
	var SmallButtM = new Array();
	
	// small buttons
	SmallButt = getElementsByClassName(document, 'td', 'ButtSmallL');
	for (i = 0 ; i < SmallButt.length ; i++) {
			
			idname = SmallButt[i].id;
			document.getElementById(idname).onmouseover = function() {
				nname = this.id.substring(0,this.id.length-1)+"R";

					this.className = 'ButtSmallL_on';
					document.getElementById(nname).className='ButtSmall_on';
			}
			document.getElementById(idname).onmouseout = function() {
				nname = this.id.substring(0,this.id.length-1)+"R";
					this.className = 'ButtSmallL';
					document.getElementById(nname).className='ButtSmall';
			}
	}
	
	SmallButt1 = getElementsByClassName(document, 'td', 'ButtSmall');
	for (j = 0 ; j < SmallButt1.length ; j++) {
			
			idname1 = SmallButt1[j].id;
			
			document.getElementById(idname1).onmouseover = function() {
				
				this.className = 'ButtSmall_on';
				nname1 = this.id.substring(0,this.id.length-1)+"L";
				document.getElementById(nname1).className='ButtSmallL_on';
			}
			document.getElementById(idname1).onmouseout = function() {
				this.className = 'ButtSmall';
				nname1 = this.id.substring(0,this.id.length-1)+"L";
				document.getElementById(nname1).className='ButtSmallL';
			}
	}	
	
// grey buttons
	SmallButt = getElementsByClassName(document, 'td', 'ButtBigGreyL');
	for (i = 0 ; i < SmallButt.length ; i++) {
			
			idname = SmallButt[i].id;
			document.getElementById(idname).onmouseover = function() {
				mname = this.id.substring(0,this.id.length-1)+"M";
				if (document.getElementById(mname).style.display == 'none') {				
					this.className = 'ButtBigGreyL_on';
					nname = this.id.substring(0,this.id.length-1)+"R";
					document.getElementById(nname).className='ButtBigGrey_on';
				}
			}
			document.getElementById(idname).onmouseout = function() {
				mname = this.id.substring(0,this.id.length-1)+"M";
				if (document.getElementById(mname).style.display == 'none') {				
					this.className = 'ButtBigGreyL';
					nname = this.id.substring(0,this.id.length-1)+"R";
					document.getElementById(nname).className='ButtBigGrey';
				}
			}
	}

// grey buttons
	SmallButtM = getElementsByClassName(document, 'div', 'DropDownMenu');
	
	for (i = 0 ; i < SmallButtM.length ; i++) {
			
			idname = SmallButtM[i].id;
			document.getElementById(idname).onmouseover = function() {
				mname = this.id.substring(0,this.id.length-1)+"L";
				document.getElementById(mname).className='ButtBigGreyL_c';
				
				nname = this.id.substring(0,this.id.length-1)+"R";
				document.getElementById(nname).className='ButtBigGrey_c';
				
			}

	}
	
	SmallButt1 = getElementsByClassName(document, 'td', 'ButtBigGrey');
	for (j = 0 ; j < SmallButt1.length ; j++) {
			
			idname1 = SmallButt1[j].id;
			
			document.getElementById(idname1).onmouseover = function() {
				mname = this.id.substring(0,this.id.length-1)+"M";
				if (document.getElementById(mname).style.display == 'none') {				
					this.className = 'ButtBigGrey_on';
					nname1 = this.id.substring(0,this.id.length-1)+"L";
					document.getElementById(nname1).className='ButtBigGreyL_on';
				}
			}
			document.getElementById(idname1).onmouseout = function() {
				mname = this.id.substring(0,this.id.length-1)+"M";
				if (document.getElementById(mname).style.display == 'none') {
					this.className = 'ButtBigGrey';
					nname1 = this.id.substring(0,this.id.length-1)+"L";
					document.getElementById(nname1).className='ButtBigGreyL';
				}
			}
	}		
	
// title buttons
	SmallButt = getElementsByClassName(document, 'td', 'ButtTitleGreyL');
	for (i = 0 ; i < SmallButt.length ; i++) {
			
			idname = SmallButt[i].id;
			document.getElementById(idname).onmouseover = function() {
				this.className = 'ButtTitleGreyL_on';
				nname = this.id.substring(0,this.id.length-1)+"R";
				document.getElementById(nname).className='ButtTitleGrey_on';
			}
			document.getElementById(idname).onmouseout = function() {
				this.className = 'ButtTitleGreyL';
				nname = this.id.substring(0,this.id.length-1)+"R";
				document.getElementById(nname).className='ButtTitleGrey';
			}
	}
	
	SmallButt1 = getElementsByClassName(document, 'td', 'ButtTitleGrey');
	for (j = 0 ; j < SmallButt1.length ; j++) {
			
			idname1 = SmallButt1[j].id;
			
			document.getElementById(idname1).onmouseover = function() {
				
				this.className = 'ButtTitleGrey_on';
				nname1 = this.id.substring(0,this.id.length-1)+"L";
				document.getElementById(nname1).className='ButtTitleGreyL_on';
			}
			document.getElementById(idname1).onmouseout = function() {
				this.className = 'ButtTitleGrey';
				nname1 = this.id.substring(0,this.id.length-1)+"L";
				document.getElementById(nname1).className='ButtTitleGreyL';
			}
	}		
	


// brown buttons
	SmallButt = getElementsByClassName(document, 'td', 'ButtBigBrownL');
	for (i = 0 ; i < SmallButt.length ; i++) {
			idname = SmallButt[i].id;
			document.getElementById(idname).onmouseover = function() {
				mname = this.id.substring(0,this.id.length-1)+"M";
				if (document.getElementById(mname).style.display == 'none') {						
					this.className = 'ButtBigBrownL_on';
					nname = this.id.substring(0,this.id.length-1)+"R";
					document.getElementById(nname).className='ButtBigBrown_on';
				}
			}
			document.getElementById(idname).onmouseout = function() {
				mname = this.id.substring(0,this.id.length-1)+"M";
				if (document.getElementById(mname).style.display == 'none') {						
					this.className = 'ButtBigBrownL';
					nname = this.id.substring(0,this.id.length-1)+"R";
					document.getElementById(nname).className='ButtBigBrown';
				}
			}
	}
	
	SmallButt1 = getElementsByClassName(document, 'td', 'ButtBigBrown');
	for (j = 0 ; j < SmallButt1.length ; j++) {
			
			idname1 = SmallButt1[j].id;
			
			document.getElementById(idname1).onmouseover = function() {
				mname = this.id.substring(0,this.id.length-1)+"M";
				if (document.getElementById(mname).style.display == 'none') {						
					this.className = 'ButtBigBrown_on';
					nname1 = this.id.substring(0,this.id.length-1)+"L";
					document.getElementById(nname1).className='ButtBigBrownL_on';
				}
			}
			document.getElementById(idname1).onmouseout = function() {
				mname = this.id.substring(0,this.id.length-1)+"M";
				if (document.getElementById(mname).style.display == 'none') {						
					this.className = 'ButtBigBrown';
					nname1 = this.id.substring(0,this.id.length-1)+"L";
					document.getElementById(nname1).className='ButtBigBrownL';
				}
			}
	}		
	
// normal buttons
	SmallButt = getElementsByClassName(document, 'td', 'ButtBigL');
	for (i = 0 ; i < SmallButt.length ; i++) {
			
			idname = SmallButt[i].id;
			document.getElementById(idname).onmouseover = function() {

				mname = this.id.substring(0,this.id.length-1)+"M";
				if (document.getElementById(mname).style.display == 'none') {				
					this.className = 'ButtBigL_on';
					nname = this.id.substring(0,this.id.length-1)+"R";
					document.getElementById(nname).className='ButtBig_on';
				}
			}
			document.getElementById(idname).onmouseout = function() {
				mname = this.id.substring(0,this.id.length-1)+"M";
				if (document.getElementById(mname).style.display == 'none') {				
					this.className = 'ButtBigL';
					nname = this.id.substring(0,this.id.length-1)+"R";
					document.getElementById(nname).className='ButtBig';
				}
			}
	}
	
	SmallButt1 = getElementsByClassName(document, 'td', 'ButtBig');
	for (j = 0 ; j < SmallButt1.length ; j++) {
			
			idname1 = SmallButt1[j].id;
			
			document.getElementById(idname1).onmouseover = function() {
				mname = this.id.substring(0,this.id.length-1)+"M";
				if (document.getElementById(mname).style.display == 'none') {					
					this.className = 'ButtBig_on';
					nname1 = this.id.substring(0,this.id.length-1)+"L";
					document.getElementById(nname1).className='ButtBigL_on';
				}
			}
			document.getElementById(idname1).onmouseout = function() {
				mname = this.id.substring(0,this.id.length-1)+"M";
				if (document.getElementById(mname).style.display == 'none') {					
					this.className = 'ButtBig';
					nname1 = this.id.substring(0,this.id.length-1)+"L";
					document.getElementById(nname1).className='ButtBigL';
				}
			}
	}			
	
// red buttons
	SmallButt = getElementsByClassName(document, 'td', 'ButtBigRedL');
	for (i = 0 ; i < SmallButt.length ; i++) {
			
			idname = SmallButt[i].id;
			document.getElementById(idname).onmouseover = function() {
				this.className = 'ButtBigRedL_on';
				nname = this.id.substring(0,this.id.length-1)+"R";
				document.getElementById(nname).className='ButtBigRed_on';
			}
			document.getElementById(idname).onmouseout = function() {
				this.className = 'ButtBigRedL';
				nname = this.id.substring(0,this.id.length-1)+"R";
				document.getElementById(nname).className='ButtBigRed';
			}
	}
	
	SmallButt1 = getElementsByClassName(document, 'td', 'ButtBigRed');
	for (j = 0 ; j < SmallButt1.length ; j++) {
			
			idname1 = SmallButt1[j].id;
			
			document.getElementById(idname1).onmouseover = function() {
				
				this.className = 'ButtBigRed_on';
				nname1 = this.id.substring(0,this.id.length-1)+"L";
				document.getElementById(nname1).className='ButtBigRedL_on';
			}
			document.getElementById(idname1).onmouseout = function() {
				this.className = 'ButtBigRed';
				nname1 = this.id.substring(0,this.id.length-1)+"L";
				document.getElementById(nname1).className='ButtBigRedL';
			}
	}				
	
// table headers
	SmallButt = getElementsByClassName(document, 'td', 'THeader');
	for (i = 0 ; i < SmallButt.length ; i++) {
			
			idname = SmallButt[i].id;
			document.getElementById(idname).onmouseover = function() {
				this.className = 'THeader_on';
				//corners
				nname = this.id+"img";
				if (document.getElementById(nname)) {
					imgsrc = document.getElementById(nname).src;
					imgsrc = imgsrc.substring(imgsrc.length-7, imgsrc.length);
						if (imgsrc == 'eft.gif') {
						document.getElementById(nname).src='images/table/left_on.gif';
					}
					if (imgsrc == 'ght.gif') {
						document.getElementById(nname).src='images/table/right_on.gif';
					}				
				}
			}
			document.getElementById(idname).onmouseout = function() {
				this.className = 'THeader';
				//corners
				nname = this.id+"img";
				if (document.getElementById(nname)) {
					imgsrc = document.getElementById(nname).src;
					imgsrc = imgsrc.substring(imgsrc.length-9, imgsrc.length);
						if (imgsrc == 'ft_on.gif') {
						document.getElementById(nname).src='images/table/left.gif';
					}
					if (imgsrc == 'ht_on.gif') {
						document.getElementById(nname).src='images/table/right.gif';
					}				
				}				
			}
	}
		
		
	SmallButt = getElementsByClassName(document, 'td', 'THeader_s');
	for (i = 0 ; i < SmallButt.length ; i++) {
			
			idname = SmallButt[i].id;
			document.getElementById(idname).onmouseover = function() {
				this.className = 'THeader_s_on';
				//corners
				nname = this.id+"img";
				if (document.getElementById(nname)) {
					imgsrc = document.getElementById(nname).src;
					imgsrc = imgsrc.substring(imgsrc.length-7, imgsrc.length);
						if (imgsrc == 'eft.gif') {
						document.getElementById(nname).src='images/table/left_on.gif';
					}
					if (imgsrc == 'ght.gif') {
						document.getElementById(nname).src='images/table/right_on.gif';
					}				
				}
			}
			document.getElementById(idname).onmouseout = function() {
				this.className = 'THeader_s';
				//corners
				nname = this.id+"img";
				if (document.getElementById(nname)) {
					imgsrc = document.getElementById(nname).src;
					imgsrc = imgsrc.substring(imgsrc.length-9, imgsrc.length);
						if (imgsrc == 'ft_on.gif') {
						document.getElementById(nname).src='images/table/left.gif';
					}
					if (imgsrc == 'ht_on.gif') {
						document.getElementById(nname).src='images/table/right.gif';
					}				
				}				
			}
		}

	SmallButt = getElementsByClassName(document, 'input', 'WInput');
	for (i = 0 ; i < SmallButt.length ; i++) {
			
			idname = SmallButt[i].id;
			document.getElementById(idname).onfocus = function() {
				this.className = 'WInput_s';
			}
			document.getElementById(idname).onblur = function() {
				this.className = 'WInput';
			}
		
	}
			
	SmallButt = getElementsByClassName(document, 'input', 'FInput');
	for (i = 0 ; i < SmallButt.length ; i++) {
			
			idname = SmallButt[i].id;
			document.getElementById(idname).onfocus = function() {
				this.className = 'FInput_s';
			}
			document.getElementById(idname).onblur = function() {
				this.className = 'FInput';
			}			
	
	}		
	
	SmallButt = getElementsByClassName(document, 'textarea', 'FInput');
	for (i = 0 ; i < SmallButt.length ; i++) {
			
			idname = SmallButt[i].id;
			document.getElementById(idname).onfocus = function() {
				this.className = 'FInput_s';
			}
			document.getElementById(idname).onblur = function() {
				this.className = 'FInput';
			}			
	
	}		
	
// next & previous buttons
	if(document.getElementById("prev")) {
		document.getElementById("prev").onmouseover = function() {
			this.src='images/table/prev_on.gif';
		}
		document.getElementById("next").onmouseover = function() {
			this.src='images/table/next_on.gif';
		}	
		
		document.getElementById("prev").onmouseout = function() {
			this.src='images/table/prev.gif';
		}
		document.getElementById("next").onmouseout = function() {
			this.src='images/table/next.gif';
		}		
 	}
}
		
function resetCheckbox(checkName) {		

		if (document.getElementById(checkName).checked == true) {
			document.getElementById(checkName).checked = false;
		}
		else {
			document.getElementById(checkName).checked = true;
		}

}

function selectRow(row, colNr) {
	
	checkName = "c"+row.substring(1, row.length);


	
	if (document.getElementById(checkName).checked != true) {
		for (i = 1 ; i <= colNr ; i++) {
			document.getElementById("c"+i+row).className = document.getElementById('c'+i+row).className+'_on';
			document.getElementById(checkName).checked = true;
		}
	}
	else	{
		for (i = 1 ; i <= colNr ; i++) {
			nrchars = document.getElementById('c'+i+row).className.length;
			document.getElementById("c"+i+row).className = document.getElementById('c'+i+row).className.substring(0, nrchars-3);
			document.getElementById(checkName).checked = false;
		}		 	
	}
	
}
function selectRows(row, colNr) {
	var count=0;
	for (var j=0;j<row.length;j++){
		checkName = "c"+row[j].substring(1, row[j].length);
		if (document.getElementById(checkName) && document.getElementById(checkName).checked == true) {
			count+=1;
		}
	}
	for (var j=0;j<row.length;j++){
	checkName = "c"+row[j].substring(1, row[j].length);


	
	if (count==0) {
		for (i = 1 ; i <= colNr ; i++) {
			if (document.getElementById("c"+i+row[j])){
				document.getElementById("c"+i+row[j]).className = document.getElementById('c'+i+row[j]).className+'_on';
				document.getElementById(checkName).checked = true;
			}
		}
	}
	else	{
		for (i = 1 ; i <= colNr ; i++) {
			if(document.getElementById('c'+i+row[j])){
			nrchars = document.getElementById('c'+i+row[j]).className.length;
			if(document.getElementById("c"+i+row[j]).className.charAt(nrchars-1)=='n'){
			document.getElementById("c"+i+row[j]).className = document.getElementById('c'+i+row[j]).className.substring(0, nrchars-3);
			document.getElementById(checkName).checked = false;
			}
			}
		}		 	
	}
	}
	
}
function selectRows2(row, colNr) {
	var count=0;
	for (var j=0;j<row.length;j++){
		checkName = "p"+row[j].substring(1, row[j].length);
		if (document.getElementById(checkName) && document.getElementById(checkName).checked == true) {
			count+=1;
		}
	}
	for (var j=0;j<row.length;j++){
	checkName = "p"+row[j].substring(1, row[j].length);


	
	if (count==0) {
		for (i = 1 ; i <= colNr ; i++) {
			if (document.getElementById("p"+i+row[j])){
				document.getElementById("p"+i+row[j]).className = document.getElementById('p'+i+row[j]).className+'_on';
				document.getElementById(checkName).checked = true;
			}
		}
	}
	else	{
		for (i = 1 ; i <= colNr ; i++) {
			if(document.getElementById('p'+i+row[j])){
			nrchars = document.getElementById('p'+i+row[j]).className.length;
			if(document.getElementById("p"+i+row[j]).className.charAt(nrchars-1)=='n'){
			document.getElementById("p"+i+row[j]).className = document.getElementById('p'+i+row[j]).className.substring(0, nrchars-3);
			document.getElementById(checkName).checked = false;
			}
			}
		}		 	
	}
	}
	
}
function selectRow2(row, colNr) {
	
	checkName = "p"+row.substring(1, row.length);


	
	if (document.getElementById(checkName).checked != true) {
		for (i = 1 ; i <= colNr ; i++) {
			document.getElementById("p"+i+row).className = document.getElementById('p'+i+row).className+'_on';
			document.getElementById(checkName).checked = true;
		}
	}
	else	{
		for (i = 1 ; i <= colNr ; i++) {
			nrchars = document.getElementById('p'+i+row).className.length;
			document.getElementById("p"+i+row).className = document.getElementById('p'+i+row).className.substring(0, nrchars-3);
			document.getElementById(checkName).checked = false;
		}		 	
	}
	
}

//drag windows

function getMouseY(e) // works on IE6,FF,Moz,Opera7
{ 
  if (!e) e = window.event; // works on IE, but not NS (we rely on NS passing us the event)
 
  if (e)
  { 
    if (e.pageX || e.pageY)
    { // this doesn't work on IE6!! (works on FF,Moz,Opera7)
      mousex = e.pageX;
      mousey = e.pageY;
      algor = '[e.pageX]';

      if (e.clientX || e.clientY) algor += ' [e.clientX] '
    }
    else if (e.clientX || e.clientY)
    { // works on IE6,FF,Moz,Opera7
      // Note: I am adding together both the "body" and "documentElement" scroll positions
      //       this lets me cover for the quirks that happen based on the "doctype" of the html page.
      //         (example: IE6 in compatibility mode or strict)
      //       Based on the different ways that IE,FF,Moz,Opera use these ScrollValues for body and documentElement
      //       it looks like they will fill EITHER ONE SCROLL VALUE OR THE OTHER, NOT BOTH 
      //         (from info at http://www.quirksmode.org/js/doctypes.html)
      mousex = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
      mousey = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
      algor = '[e.clientX]';
      if (e.pageX || e.pageY) algor += ' [e.pageX] '
    }
  }
  return mousey;
}

function getMouseX(e) // works on IE6,FF,Moz,Opera7
{ 
  if (!e) e = window.event; // works on IE, but not NS (we rely on NS passing us the event)
 
  if (e)
  { 
    if (e.pageX || e.pageY)
    { // this doesn't work on IE6!! (works on FF,Moz,Opera7)
      mousex = e.pageX;
      mousey = e.pageY;
      algor = '[e.pageX]';

      if (e.clientX || e.clientY) algor += ' [e.clientX] '
    }
    else if (e.clientX || e.clientY)
    { // works on IE6,FF,Moz,Opera7
      // Note: I am adding together both the "body" and "documentElement" scroll positions
      //       this lets me cover for the quirks that happen based on the "doctype" of the html page.
      //         (example: IE6 in compatibility mode or strict)
      //       Based on the different ways that IE,FF,Moz,Opera use these ScrollValues for body and documentElement
      //       it looks like they will fill EITHER ONE SCROLL VALUE OR THE OTHER, NOT BOTH 
      //         (from info at http://www.quirksmode.org/js/doctypes.html)
      mousex = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
      mousey = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
      algor = '[e.clientX]';
      if (e.pageX || e.pageY) algor += ' [e.pageX] '
    }
  }
  return mousex;
}

var xoff = 0;
var nrobj = 2;
var yoff = 0;
var selectedW = '';

function DragWindow(obj, ev, xoff, yoff) {
		document.getElementById(obj).style.left = getMouseX(ev)-xoff;
		//document.getElementById("valori").value=getMouseX(ev)-xoff;
		document.getElementById(obj).style.top = getMouseY(ev)-yoff+"px";
			
}

function startDrag(obj, ev) {
					
		xoff = getMouseX(ev) - document.getElementById(obj).offsetLeft;
		yoff = getMouseY(ev) - document.getElementById(obj).offsetTop;
		
		document.getElementById(obj).style.zIndex = nrobj;
		
		selectedW = obj;
}

function stopDrag() {
	document.body.onmousemove = function() {};
	selectedW = '';
}

function ResetMenus(obj) {
	var Menus = new Array();
	
	Menus = getElementsByClassName(document, 'div', 'DropDownMenu');
	
	for (i = 0 ; i < Menus.length ; i++) {
		MenuIdName = Menus[i].id;
		if (document.getElementById(MenuIdName).style.display == 'inline' && MenuIdName != obj+'M') {

			document.getElementById(MenuIdName).style.display='none'; 
			
			myobj = MenuIdName.substring(0, MenuIdName.length-1);
			//document.getElementById(myobj + 'I').style.display='none'; 
			
			//alert (ObjClassNameL);
			
			
			document.getElementById(myobj+'L').className = ObjClassNameL;
			document.getElementById(myobj+'R').className = ObjClassNameR;
			

			if(document.getElementById(myobj+'arrow')) {
				document.getElementById(myobj+'arrow').src='images/buttons/rarrow.gif';
		}
			
		}
	}
	
}

var ObjClassNameL;
var ObjClassNameR;

function OpenMenu(obj) {

//	alert(obj);
	
	ResetMenus(obj);
	
	if (document.getElementById(obj+'M').style.display=='inline') { 
		document.getElementById(obj+'M').style.display='none'; 
//		document.getElementById(obj+'I').style.display='none'; 
		document.getElementById(obj+'L').className='ButtBigGreyL_on';
		document.getElementById(obj+'R').className='ButtBigGrey_on';
		if(document.getElementById(obj+'arrow')) {
			document.getElementById(obj+'arrow').src='images/buttons/rarrow.gif';
		}
	}
	else {
		document.getElementById(obj+'M').style.display='inline'; 
//		document.getElementById(obj+'I').style.height = document.getElementById(obj+'end').offsetTop;
//		document.getElementById(obj+'I').style.display='inline'; 
		
		
		ObjClassNameL = document.getElementById(obj+'L').className.substring(0, document.getElementById(obj+'L').className.length-3);
		ObjClassNameR = document.getElementById(obj+'R').className.substring(0, document.getElementById(obj+'R').className.length-3);;
		
		
		document.getElementById(obj+'L').className='ButtBigGreyL_c';
		document.getElementById(obj+'R').className='ButtBigGrey_c';
		if(document.getElementById(obj+'arrow')) {
			document.getElementById(obj+'arrow').src='images/buttons/rarrowu.gif';
		}
		
	}
		
}

function findPos(obj) {
	var curleft = curtop = 0;
	//obj = document.getElementById('list');
	if (obj.offsetParent) {
		do {
			curleft += obj.offsetLeft;
			curtop += obj.offsetTop;
		} while (obj = obj.offsetParent);
	}
	//document.write(curtop);
	return curtop;
}

var resize = 0;
var resizeHeight = 0;
var diff = 0;
var count=0;

function ResizeList() {
	WHeight = window.innerHeight;
	count=count+1;
	if (!WHeight) {
		WHeight = document.body.clientHeight;
	}
	if(count==1){
	footerTop=findPos(document.getElementById('minimizebutt'));
	}
	//alert(WHeight);
	//alert(footerTop);
	//alert(diff);
	//alert(resizeHeight);
	document.getElementById('lista').style.height=WHeight-(footerTop-143)+diff+resizeHeight;
	difference = parseInt(document.getElementById('end').offsetTop) - parseInt(document.getElementById('lista').style.height);
	if (difference > 0 && resize != 1)
	 {
		document.getElementById('statussize').width=document.getElementById('statussize').width-20; 		
		resize=1;
	 }
	 else
	 	 {
	 	 	if(resize == 1 && difference < 0) {
	 	 		document.getElementById('statussize').width=document.getElementById('statussize').width+20; 		
	 	 		resize = 0;
	 	 	}
	 	}
	if(count==1){
		footerTopAfter=findPos(document.getElementById('minimizebutt'));
		diff=footerTopAfter-footerTop;
		footerTop=findPos(document.getElementById('minimizebutt'));
	}
	
}

function ResizeForm() {
	
	WHeight = window.innerHeight;
	
	if (!WHeight) {
		WHeight = document.body.clientHeight+21;
	}
	//alert (WHeight);
	document.getElementById('formular').style.height=WHeight-267+resizeHeight;
	
	
}

function ResizeHelp() {
	
	WHeight = window.innerHeight;

	if (!WHeight) {
		WHeight = document.body.clientHeight+21;
	}	
	
	document.getElementById('helpleft').style.height=WHeight-231+resizeHeight;
		document.getElementById('helpcontent').style.height=WHeight-231+resizeHeight;
	
}

var minimize = 0;
function minimizeBar(template) {
	
	if (minimize == 1) {
		document.getElementById('bottomBar').style.display = 'inline';
		minimize = 0;
		resizeHeight = 0;
		if(template == 'lista')		
			ResizeList();
		if(template == 'form')		
			ResizeForm();
		if(template == 'help')		
			ResizeHelp();						
		document.getElementById('minimizebutt').src = 'images/footer/minimize.gif';
		}
		else {
			document.getElementById('bottomBar').style.display = 'none';
			minimize = 1;
			resizeHeight = 72;
			if(template == 'lista')		
				ResizeList();
			if(template == 'form')		
				ResizeForm();
			if(template == 'help')	{
				resizeHeight = 88;
				ResizeHelp();				
			}		
			document.getElementById('minimizebutt').src = 'images/footer/maximize.gif';
		}
}

function getCookie(c_name)
{
if (document.cookie.length>0)
  {
  c_start=document.cookie.indexOf(c_name + "=")
  if (c_start!=-1)
    { 
    c_start=c_start + c_name.length+1 
    c_end=document.cookie.indexOf(";",c_start)
    if (c_end==-1) c_end=document.cookie.length
    return unescape(document.cookie.substring(c_start,c_end))
    } 
  }
return ""
}

function setCookie(c_name,value,expiredays)
{
var exdate=new Date()
exdate.setDate(exdate.getDate()+expiredays)
document.cookie=c_name+ "=" +escape(value)+
((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
}

function incrementCookie()
{
help=getCookie('help');
if (help!=null && help!="")
  {
  help=parseInt(help);
  help+=1;
  setCookie('help',help,365);
  }
}

function checkCookie()
{
help=getCookie('help');
if (help==null || help=="")
  {
  help='0';
  if (help!=null && help!="")
    {
    setCookie('help',help,365)
    }
  }
  else if(parseInt(help)%2!=0){
			minimizeBar('lista');
		}
}
function checkCookieForm()
{
help=getCookie('help');
if (help==null || help=="")
  {
  help='0';
  if (help!=null && help!="")
    {
    setCookie('help',help,365)
    }
  }
  else if(parseInt(help)%2!=0){
			minimizeBar('form');
		}
}



/***********************************************
* Image w/ description tooltip- By Dynamic Web Coding (www.dyn-web.com)
* Copyright 2002-2007 by Sharon Paine
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

/* IMPORTANT: Put script after tooltip div or 
	 put tooltip div just before </BODY>. */

var dom = (document.getElementById) ? true : false;
var ns5 = (!document.all && dom || window.opera) ? true: false;
var ie5 = ((navigator.userAgent.indexOf("MSIE")>-1) && dom) ? true : false;
var ie4 = (document.all && !dom) ? true : false;
var nodyn = (!ns5 && !ie4 && !ie5 && !dom) ? true : false;

var origWidth, origHeight;

// avoid error of passing event object in older browsers
if (nodyn) { event = "nope" }

///////////////////////  CUSTOMIZE HERE   ////////////////////
// settings for tooltip 
// Do you want tip to move when mouse moves over link?
var tipFollowMouse= true;	
// Be sure to set tipWidth wide enough for widest image
var tipWidth= 200;
var offX= 20;	// how far from mouse to show tip
var offY= 12; 
var tipFontFamily= "Verdana, arial, helvetica, sans-serif";
var tipFontSize= "8pt";
// set default text color and background color for tooltip here
// individual tooltips can have their own (set in messages arrays)
// but don't have to
var tipFontColor= "#000000";
var tipBgColor= "white"; 
var tipBorderColor= "#c2cbd5";
var tipBorderWidth= 3;
var tipBorderStyle= "solid";
var tipPadding= 4;

// tooltip content goes here (image, description, optional bgColor, optional textcolor)
var messages = new Array();
// multi-dimensional arrays containing: 
// image and text for tooltip
// optional: bgColor and color to be sent to tooltip
//messages[0] = new Array('red_balloon.gif','Here is a red balloon on a white background',"#FFFFFF");
//messages[1] = new Array('duck2.gif','Here is a duck on a light blue background.',"#DDECFF");
//messages[2] = new Array('test.gif','Test description','black','white');

////////////////////  END OF CUSTOMIZATION AREA  ///////////////////

// preload images that are to appear in tooltip
// from arrays above
if (document.images) {
	var theImgs = new Array();
	for (var i=0; i<messages.length; i++) {
  	theImgs[i] = new Image();
		theImgs[i].src = messages[i][0];
  }
}

// to layout image and text, 2-row table, image centered in top cell
// these go in var tip in doTooltip function
// startStr goes before image, midStr goes between image and text
var startStr = '<table width="' + tipWidth + '"><tr><td align="center" width="100%">';
var picStrStart='<img src="';
var picStrEnd='" border="0">';
var midStr = '</td></tr><tr><td valign="top">';
var endStr = '</td></tr></table>';

////////////////////////////////////////////////////////////
//  initTip	- initialization for tooltip.
//		Global variables for tooltip. 
//		Set styles
//		Set up mousemove capture if tipFollowMouse set true.
////////////////////////////////////////////////////////////
var tooltip, tipcss;
function initTip() {
	if (nodyn) return;
	tooltip = (ie4)? document.all['tipDiv']: (ie5||ns5)? document.getElementById('tipDiv'): null;
	tipcss = tooltip.style;
	if (ie4||ie5||ns5) {	// ns4 would lose all this on rewrites
		tipcss.width = tipWidth+"px";
		tipcss.fontFamily = tipFontFamily;
		tipcss.fontSize = tipFontSize;
		tipcss.color = tipFontColor;
		tipcss.backgroundColor = tipBgColor;
		tipcss.borderColor = tipBorderColor;
		tipcss.borderWidth = tipBorderWidth+"px";
		tipcss.padding = tipPadding+"px";
		tipcss.borderStyle = tipBorderStyle;
	}
	if (tooltip&&tipFollowMouse) {
		document.onmousemove = trackMouse;
	}
}

//window.onload = initTip;

/////////////////////////////////////////////////
//  doTooltip function
//			Assembles content for tooltip and writes 
//			it to tipDiv
/////////////////////////////////////////////////
var t1,t2;	// for setTimeouts
var tipOn = false;	// check if over tooltip link
function doTooltip(evt,pic,message) {
	if (!tooltip) return;
	if (t1) clearTimeout(t1);	if (t2) clearTimeout(t2);
	tipOn = true;
	// set colors if included in messages array
	//if (messages[num][2])	var curBgColor = messages[num][2];
	//else 
	curBgColor = tipBgColor;
	//if (messages[num][3])	var curFontColor = messages[num][3];
	//else 
	curFontColor = tipFontColor;
	if (ie4||ie5||ns5) {
		if(pic!=''){
			var tip = startStr + picStrStart + pic +picStrEnd + midStr + '<span style="font-family:' + tipFontFamily + '; font-size:' + tipFontSize + '; color:' + curFontColor + ';">'+ message +'</span>' + endStr;
		}
		else{
			var tip = startStr + midStr + '<span style="font-family:' + tipFontFamily + '; font-size:' + tipFontSize + '; color:' + curFontColor + ';">'+ message +'</span>' + endStr;
		}
		tipcss.backgroundColor = curBgColor;
	 	tooltip.innerHTML = tip;
	}
	if (!tipFollowMouse) positionTip(evt);
	else t1=setTimeout("tipcss.visibility='visible'",100);
}

var mouseX, mouseY;
function trackMouse(evt) {
	standardbody=(document.compatMode=="CSS1Compat")? document.documentElement : document.body //create reference to common "body" across doctypes
	mouseX = (ns5)? evt.pageX: window.event.clientX + standardbody.scrollLeft;
	mouseY = (ns5)? evt.pageY: window.event.clientY + standardbody.scrollTop;
	if (tipOn) positionTip(evt);
}

/////////////////////////////////////////////////////////////
//  positionTip function
//		If tipFollowMouse set false, so trackMouse function
//		not being used, get position of mouseover event.
//		Calculations use mouseover event position, 
//		offset amounts and tooltip width to position
//		tooltip within window.
/////////////////////////////////////////////////////////////
function positionTip(evt) {
	if (!tipFollowMouse) {
		standardbody=(document.compatMode=="CSS1Compat")? document.documentElement : document.body
		mouseX = (ns5)? evt.pageX: window.event.clientX + standardbody.scrollLeft;
		mouseY = (ns5)? evt.pageY: window.event.clientY + standardbody.scrollTop;
	}
	// tooltip width and height
	var tpWd = (ie4||ie5)? tooltip.clientWidth: tooltip.offsetWidth;
	var tpHt = (ie4||ie5)? tooltip.clientHeight: tooltip.offsetHeight;
	// document area in view (subtract scrollbar width for ns)
	var winWd = (ns5)? window.innerWidth-20+window.pageXOffset: standardbody.clientWidth+standardbody.scrollLeft;
	var winHt = (ns5)? window.innerHeight-20+window.pageYOffset: standardbody.clientHeight+standardbody.scrollTop;
	// check mouse position against tip and window dimensions
	// and position the tooltip 
	if ((mouseX+offX+tpWd)>winWd) 
		tipcss.left = mouseX-(tpWd+offX)+"px";
	else tipcss.left = mouseX+offX+"px";
	if ((mouseY+offY+tpHt)>winHt) 
		tipcss.top = winHt-(tpHt+offY)+"px";
	else tipcss.top = mouseY+offY+"px";
	if (!tipFollowMouse) t1=setTimeout("tipcss.visibility='visible'",100);
}

function hideTip() {
	if (!tooltip) return;
	t2=setTimeout("tipcss.visibility='hidden'",100);
	tipOn = false;
}

//document.write('<div id="tipDiv" style="position:absolute; visibility:hidden; z-index:100"></div>');



// submit on enter press

function entsub(event,ourform) {
  if (event && event.which == 13)
    ourform.submit();
  else
    return true;
    }
    
    
// simple toggler

function toggleSearch(objId) {
	var e = document.getElementById(objId);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
}
function checkForm(form,fields,messages,alerts){
		//document.write(fields);
		for(i=0; i<form.elements.length; i++)
		{
			//var fields = new Array('product','stockid','price','description');
			//alert(fields[0]);
			for(j=0; j<fields.length; j++){
				var mystr = fields[j];
				var message = messages[j];
				//alert (mystr);
				var field = form.elements[i].name;
				var fieldtype = form.elements[i].type;
				//alert(fieldtype);
				if(field.search(mystr)==0){
					//alert(field.search(mystr));
					if(fieldtype=='text'){
						var fieldvalue = form.elements[i].value.length;
						if(!fieldvalue){
							//alert(field);
							alert(alerts[0]+message);
							return false;
						}
					}
					else if(fieldtype=='select-one'){
						var selectvalue = form.elements[i].selectedIndex;
						if(selectvalue == 0){
							//alert(field);
							alert(alerts[1]+message);
							return false;
						}
					
					}
					else if(fieldtype=='textarea'){
						var fieldvalue = form.elements[i].value;
						if(!fieldvalue){
							//alert(field);
							alert(alerts[0]+message);
							return false;
						}
					
					}
					else if(fieldtype=='file'){
						var fieldvalue = form.elements[i].value;
						if(!fieldvalue){
							alert(alerts[2]+message);
							return false;
						}
					
					}
				}
			//document.write("The field name is: " + document.productForm.elements[i].name + " and it\'s value is: " + document.productForm.elements[i].value + ".<br />");
			}
		}
		//form.onsubmit();
		form.submit();
		return true;
}

function checkFormProduct(form,fields,messages,alerts){
		//document.write(fields);
		for(i=0; i<form.elements.length; i++)
		{
			//var fields = new Array('product','stockid','price','description');
			//alert(fields[0]);
			for(j=0; j<fields.length; j++){
				var mystr = fields[j];
				var message = messages[j];
				//alert (mystr);
				var field = form.elements[i].name;
				var fieldtype = form.elements[i].type;
				//alert(fieldtype);
				if(field.search(mystr)==0){
					//alert(field.search(mystr));
					if(fieldtype=='text'){
						var fieldvalue = form.elements[i].value.length;
						if(!fieldvalue){
							//alert(field);
							alert(alerts[0]+message);
							return false;
						}
					}
					else if(fieldtype=='select-one'){
						var selectvalue = form.elements[i].selectedIndex;
						if(selectvalue == 0){
							//alert(field);
							alert(alerts[1]+message);
							return false;
						}
					
					}
					else if(fieldtype=='textarea'){
						var fieldvalue = form.elements[i].value;
						if(!fieldvalue){
							//alert(field);
							alert(alerts[0]+message);
							return false;
						}
					
					}
					else if(fieldtype=='file'){
						var fieldvalue = form.elements[i].value;
						if(!fieldvalue){
							alert(alerts[2]+message);
							return false;
						}
					
					}
				}
			//document.write("The field name is: " + document.productForm.elements[i].name + " and it\'s value is: " + document.productForm.elements[i].value + ".<br />");
			}
		}
		form.onsubmit();
		form.submit();
		return true;
}

// Showhide togglers
function showIt(obj) {
	var el = document.getElementById(obj);
	el.style.display = 'block';
	el.style.zIndex = '1000';
}
function hideIt(obj) {
	var el = document.getElementById(obj);
	el.style.display = 'none';
}

// Showhide product pic on mouseover

function showPPic(obj) {


	var el = document.getElementById(obj);
	el.style.display = 'block';


	el.style.zIndex = '1000';
}

function hidePPic(obj) {


	var el = document.getElementById(obj);
	el.style.display = 'none';

}