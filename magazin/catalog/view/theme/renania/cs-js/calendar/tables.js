		function checking(checkboxname) {
			
			document.getElementById(checkboxname).checked = (document.getElementById(checkboxname).checked ? false : true);
		}	
		
		function changecolor(rowname, changetype) {
			
			checkname = 'check'+rowname;
			rowname = 'table'+rowname;
			
			switch (changetype) {
			 case 'over':
				if (document.getElementById(checkname).checked == false) {
				rowclass = document.getElementById(rowname).className;
				document.getElementById(rowname).className = rowclass+'sel';
				}
			 break;
			 
		  	 case 'out':
				if (document.getElementById(checkname).checked == false) {
					nr = document.getElementById(rowname).className.length;
					rowclass = document.getElementById(rowname).className.substr(0, nr-3);
					document.getElementById(rowname).className = rowclass;	
				}
			 break;
			}
			
		}
		
		function changeformcolor(rowname, changetype) {
			
			checkname = 'check'+rowname;
			rowname = 'table'+rowname;
			
			switch (changetype) {
			 case 'over':
				rowclass = document.getElementById(rowname).className;
				document.getElementById(rowname).className = rowclass+'sel';
			 break;
			 
		  	 case 'out':
					nr = document.getElementById(rowname).className.length;
					rowclass = document.getElementById(rowname).className.substr(0, nr-3);
					document.getElementById(rowname).className = rowclass;	
			 break;
			}
			
		}		
