// automatic promo switch
//-----------------------
var stat = 0;
var lastID = 1;
function switchHeadline(hnr, nr1){
    if(hnr > nr1)
        hnr = hnr - nr1;
    if(hnr == 0)
        hnr = hnr + nr1;
	if(stat == 1) {
		clearTimeout(PromoTabID);
		stat = 0;
	}
		
	for (i = 1 ; i <= nr1 ; i++) {
		document.getElementById('he'+i).style.display = 'none';
		document.getElementById('nr'+i).className = '';
	
		if (hnr == i) {
			lastID = hnr;
			document.getElementById('he'+hnr).style.display = 'block';
			document.getElementById('nr'+hnr).className = 'current'	
			
		}
	}	 
	
	if (stat != 1) {	
		PromoTabID = setTimeout("switchHeadlines("+nr1+", "+hnr+")", 5000);
	}
	
}

function switchHeadlines(nr, starth) {
		document.getElementById('promoItem').style.visibility = 'visible';
		
		if (starth == nr) {
			nexth = 1;
		}
			else {
				nexth = starth+1;
			}
		
		if (stat != 1) {
			switchHeadline(nexth, nr);
		}
}