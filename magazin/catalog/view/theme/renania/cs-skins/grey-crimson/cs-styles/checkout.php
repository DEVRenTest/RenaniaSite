<?php
header("Content-type: text/css");
include ('./config.php');

echo '


.StepOn {
 	font-size: 10px;
	float: left;
 	font-weight: bold;
 	padding: 3px 4px 4px 5px;
 	width: 101px;
	color: '.$StepOnColor.';
	height: 45px;
	background: '.$StepOnBg.';
 }	
 
.StepOff {
	font-size: 10px;
	float: left;
 	font-weight: normal;
 	padding: 3px 4px 4px 5px;
 	width: 105px;
	color: '.$StepOffColor.';
	height: 45px;
	background: '.$StepOffBg.';
 }	 
 
#Tab1 {
 	margin: 3px 0px 5px 0px;
	width:100px; 	
 }
 
#Tab2,
#Tab3,
#Tab4,
#Tab5 {
  	margin: 3px 0px 5px 3px;
	width:100px; 
	
 }


/* wishlist product list hover details */

a.cartItem {
    position:relative; /*this is the key*/
    z-index:24;
    text-decoration:none}

a.cartItem:hover{z-index:25;background: #eaeaea;}

a.cartItem span{display: none;}

a.cartItem:hover span{ /*the span will display just on :hover state*/
    display:block;
    position:absolute;
    top:2em; left:5em; width:250px;
    background: #fff;
	border: 3px solid #c2d1d4;
 	padding: 3px;
 	color: #444;
    text-align: left;
}
a.cartItem:hover span p {
	padding: 5px;
	line-height: 20px;
	font-size: 11px;
}

.form_error {
		color: #CC0000;
}

.creditTable {
	font-weight: normal!important;
}
.creditTable td {
	padding: 3px;
	text-align: center;
}
.creditTable td span {
	font-weight:bold!important;
}
.creditTable th {
	background: '.$CreditTable_th_bgColor.';
	color: '.$CreditTable_th_fontColor.';
	padding: 3px;
	text-aling: center;
}

.creditTable .creditTableTitle {
	background: #fff;
	color: #444;
	font-weight: normal;
	font-size: 12px;
}

.creditTable .odd {
	background: '.$table_rowOdd.';
}
.creditTable .even {
	background: '.$table_rowEven.';
}

.fieldInfo {
	background: url(../cs-images/info-icon.jpg) no-repeat top left;
	padding: 0 0 0 30px !important;
	font-weight: normal;
	color: #666;
}

.userAccountTable p {
	font-size: 11px;
	color: #444;
	padding: 5px;
}

table.Cart {
	width: 100%;
}
table.Cart th {
	text-align: left;
	padding: 6px 3px;
	background: '.$CartTable_th_bgColor.';
	font-weight: normal;
}
table.Cart td.row {
	border-bottom: 1px solid #ccc;
}

table.Cart td.GrandTotal {
	font-size: 14px;
	font-weight: bold;
	color: '.$GrandTotal_fontColor.';
}

.EmptyCart {
	background: '.$EmptyCart_bgColor.';
	text-align: center;
	font-weight: bold;
	height: 50px;
}


';
?>