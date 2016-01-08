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

function AlignElements(NrItems, NrColumns) {
	var ActualRow = 0;
	var NrRows = 0;
	
	NrRows = parseInt(NrItems/NrColumns);

	while(ActualRow < NrRows) {
		StartPos = ActualRow*NrColumns;
		StopPos = ActualRow*NrColumns+NrColumns;
		
		ResizeElements(StartPos, StopPos);
	
		ActualRow = ActualRow + 1;
	}

}

function ResetElements(NrItems) {

	var AllPics = new Array();
	var AllTitles = new Array();
	var AllDesc = new Array();
	var AllLinks = new Array();
	var AllPrices = new Array();

// ------- creez listele de obiecte
	
	AllPics = getElementsByClassName(document, 'div', 'productpicture');
	AllTitles = getElementsByClassName(document, 'h2', 'producttitle');
	AllDesc = getElementsByClassName(document, 'h3', 'producttext');
	AllLinks = getElementsByClassName(document, 'a', 'picturelink');
	AllPrices = getElementsByClassName(document, 'div', 'productprice');
	
	if (AllPics.length > 0) {

		for (l = 0 ; l < AllPics.length ; l++) {
			
			PicIDs = AllPics[l].id;
			TitleIDs = AllTitles[l].id;
			DescIDs = AllDesc[l].id;
			LinksIDs = AllLinks[l].id;
			PriceIDs = AllPrices[l].id;
				
			document.getElementById(PicIDs).style.height = '';
			document.getElementById(TitleIDs).style.height = '';
			document.getElementById(DescIDs).style.height = '';
			document.getElementById(LinksIDs).style.height = '';
			document.getElementById(PriceIDs).style.width = '';
			
		}
	}
}




function ResizeElements(StartPos, StopPos) {

	var AllPics = new Array();
	var AllTitles = new Array();
	var AllDesc = new Array();
	var AllLinks = new Array();
	var AllPrices = new Array();
	var PicHMax = 0;
	var TitleHMax = 0;
	var DescHMax = 0;
	var PriceHMax = 0;

// ------- creez listele de obiecte
	
	AllPics = getElementsByClassName(document, 'div', 'productpicture');
	AllTitles = getElementsByClassName(document, 'h2', 'producttitle');
	AllDesc = getElementsByClassName(document, 'h3', 'producttext');
	AllLinks = getElementsByClassName(document, 'a', 'picturelink');
	AllPrices = getElementsByClassName(document, 'div', 'productprice');
	
	if (AllPics.length > 0 && StartPos < AllPics.length) {
	
	if (StopPos > AllPics.length) StopPos = AllPics.length;
	
	// ------- gasesc height maxim pentru fiecare lista 
	
		for (l = StartPos ; l < StopPos ; l++) {
			
			PicIDs = AllPics[l].id;
			TitleIDs = AllTitles[l].id;
			DescIDs = AllDesc[l].id;
			PriceIDs = AllPrices[l].id;
				
			PicH = document.getElementById(PicIDs).offsetHeight;
			TitleH = document.getElementById(TitleIDs).offsetHeight;
			DescH = document.getElementById(DescIDs).offsetHeight;
			PriceH = document.getElementById(PriceIDs).offsetHeight;
			//alert(PriceH);
			if(PicHMax < PicH) {
				PicHMax = PicH;
			}
			
			if(TitleHMax < TitleH) {
				TitleHMax = TitleH;
			}
			
			if(DescHMax < DescH) {
				DescHMax = DescH;
			}	
			
			if(PriceHMax < PriceH) {
				PriceHMax = PriceH;
			}	
			//alert(PriceHMax);
			
		}

	// ------- aplic height maxi m pentru fiecare lista
	
		for (l = StartPos ; l < StopPos ; l++) {
			
			PicIDs = AllPics[l].id;
			TitleIDs = AllTitles[l].id;
			DescIDs = AllDesc[l].id;		
			LinksIDs = AllLinks[l].id;
			PriceIDs = AllPrices[l].id;
			
			document.getElementById(PicIDs).style.height = PicHMax+'px';
			document.getElementById(TitleIDs).style.height = TitleHMax+'px';
			document.getElementById(DescIDs).style.height = DescHMax+'px';
			document.getElementById(PriceIDs).style.height = PriceHMax+'px';
			//alert(document.getElementById(PriceIDs).style.height);
	// ------- alinez poza pe verticala la centru
		
		 	LinkH = document.getElementById(LinksIDs).offsetHeight;	
		 	document.getElementById(LinksIDs).style.paddingTop = parseInt((PicHMax-LinkH)/2)+'px';	
				
		}
	
	}
}			

// resize articles on homepage
//----------------------------

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

function AlignArticles(NrItems, NrColumns) {
	var ActualRow = 0;
	var NrRows = 0;
	
	NrRows = parseInt(NrItems/NrColumns);

	while(ActualRow < NrRows) {
		StartPos = ActualRow*NrColumns;
		StopPos = ActualRow*NrColumns+NrColumns;
		
		ResizeArticles(StartPos, StopPos);
	
		ActualRow = ActualRow + 1;
	}

}

function ResetArticles(NrItems) {

	var AllArticles = new Array();

// ------- creez listele de obiecte
	
	AllArticles = getElementsByClassName(document, 'td', 'ArticleBox');
	
	if (AllArticles.length > 0) {

		for (l = 0 ; l < NrItems ; l++) {
			
			ArtIDs = AllArticles[l].id;
				
			document.getElementById(ArtIDs).style.height = '';
			
		}
	}
}




function ResizeArticles(StartPos, StopPos) {

	var AllArticles = new Array();
	
	var ArtHMax = 0;

// ------- creez listele de obiecte
	
	AllArticles = getElementsByClassName(document, 'td', 'ArticleBox');
	
	if (AllArticles.length > 0 && StartPos < AllArticles.length) {
	
	if (StopPos > AllArticles.length) StopPos = AllArticles.length;
	
	// ------- gasesc height maxim pentru fiecare lista 
	
		for (l = StartPos ; l < StopPos ; l++) {
			
			ArtIDs = AllArticles[l].id;
				
			ArtH = document.getElementById(ArtIDs).offsetHeight;
			
	
			if(ArtHMax < ArtH) {
				ArtHMax = ArtH;
			}			
			
		}

	// ------- aplic height maxi m pentru fiecare lista
	
		for (l = StartPos ; l < StopPos ; l++) {
			
			ArtIDs = AllArticles[l].id;
			
			document.getElementById(ArtIDs).style.height = ArtHMax+'px';
		
	// ------- alinez poza pe verticala la centru
		
		 	// LinkH = document.getElementById(LinksIDs).offsetHeight;	
		 	// document.getElementById(LinksIDs).style.paddingTop = parseInt((PicHMax-LinkH)/2)+'px';	
				
		}
	
	}
}			
