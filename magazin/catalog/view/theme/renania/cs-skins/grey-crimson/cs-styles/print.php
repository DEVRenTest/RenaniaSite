<?php
header("Content-type: text/css");
include ('./config.php');

echo '

body {
	font-family: Arial, Verdana, sans-serif;
}

#ContentPrint {
 	padding: 10px;
 	background: #fff;
 }
 
#HeaderPrint  {
 	padding: 10px;

 }

#LogoPrint, #Logo { 	
	display: block;
	background: '.$logo_bg.';
	background-repeat: no-repeat;
	background-position: center center;
	width: '.$logo_width.'px;
	height: '.$logo_height.'px;
 	cursor: pointer;
 	float: left; /*logo alignment [left, right]*/ 
	visibility: visible;
 }
 
#HeaderText {
	margin: 0px 0px 0px 10px;
	float: left;
 	font-size: 11px;
 	width: 300px;
 }  
 
#FooterPrint  {
 	border-top: 1px solid #000;
 	font-size: 12px;
 	padding: 10px;
 	background: #fff;
 }

h1 {
	font-size: 14px;
	margin: 15px 0 0 0;
	padding: 0; 
	font-weight: bold;
	color: '.$print_h1_fontColor.';
}
h2  {
	font-size: 12px;
	margin: 0;
	padding: 0; 
	font-weight: normal;
	float: left;
	width: 340px;
} 

 
.ProductDetailPicture  {
 	float: left;
 	padding: 5px 5px 5px 0px;
	margin-top:0px;
	width: 200px;
 }
 
.ProductDetailPicture img  {
 	border: 0px;
 }
 
.ProductDetailText {
 	font-size: 11px;
 	float: right; 
	text-align: left;
	width: 345px;
 }

.ProductOrderBox {
 	font-size: 11px;
 	float: left; 
	text-align: left;
	width: 200px;
	padding: 0px 0px 0px 10px;
}
 

.ProductDetailPrice  {
 	width: 170px;
	font-size: 12px;
 	color: #000000;
 	background: #eaeaea;
 	padding: 15px;
 	float: left;
	text-align: left;
 }

.ProductDetailPrice .BigPrice {
 	font-size: 24px;
 	color: #000000;
 }

.ProductDetailPrice .PriceText {
 	font-size: 11px;
 	color: #000000;
 }

.ProductDetailButtons {
	clear: left;
	padding: 10px 0px 0px 0px;
 }

.ProductDetailFacilities {
 	margin: 5px 5px 5px 0px;
 } 

.ProductDetailFacilities a {
 	font-size: 11px;
 }
 
.ProductDetailTitle {
 	margin: 20px 0px 0px 0px;
 	font-size: 12px;
 	font-weight: bold;
 }

.ProductDetailAccessories {
	font-size: 11px;
}

.Note {
	font-size: 11px;
}


table {
	border-top: '.$printTable_border.';
	border-left: '.$printTable_border.';
	margin-top: 10px;
}

table .TableTitle {
	background: #000000;
	color: #fff;
}

table td, table th {
	padding: 3px;
	border-right: '.$printTable_border.';
	border-bottom: '.$printTable_border.';
}

table .TableValue {
	color: #000000;
}
 
 ';
?>