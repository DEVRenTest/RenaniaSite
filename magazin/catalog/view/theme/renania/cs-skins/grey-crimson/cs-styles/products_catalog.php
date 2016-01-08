<?php
header("Content-type: text/css");

include ('./config.php');

echo '
h1
 {
 	font-family: '.$mainFont.';
 	font-size: 24px;
 	color: '.$main_Darker_Color.';
 	font-weight: normal;
 	height: 45px; 	
 	margin-top: 100px;
 }
 
h2
 {
 	font-family: '.$mainFont.';
 	font-size: 14px;
 	color: #000000;
 	display: inline;
 } 
 
h3
 {
 	font-family: '.$mainFont.';
 	font-size: 12px;
 	color: #000000;
 	display: inline;
 	font-weight: normal;
 	width: 400px;
 } 

.productPriceBox 
 {
 	font-family: '.$mainFont.';
 	background-color: '.$main_Lighter_Color.';
 	color: #000000;
 	display: inline;
 	padding: 10px; 	
 	font-size: 14px;
 	margin-top: 20px;
 }

.productpicture 
 {	
 	float: left;
 	font-family: '.$mainFont.';
 	font-size: 12px;
 	text-aling: center;	
 	width: 120px;
 	height: 135px;
 }



.Cleaner 
 {
 	clear: both;
 }
 
.product
 {
 	height: 135px;
 	margin-bottom: 10px;
 	
 }
 
 ';
?>