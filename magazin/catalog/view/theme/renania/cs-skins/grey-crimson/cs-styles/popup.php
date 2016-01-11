<?php
header("Content-type: text/css");
include ('./config.php');

echo '

body {
	margin: 0;
	padding: 0;
	font-family: Verdana, Arial, sans-serif;
	font-size: 11px;
	color: '.$main_Lightest_Color.';
	background: '.$main_Dark_Color.';
}

table {
	font-size: 11px;
	font-weight: bold;
}
table img {
	border: 1px solid '.$main_Lightest_Color.';
}

.fotoTable {
	background: '.$main_Dark_Color.';
}

a
 {
 	color: '.$main_Lightest_Color.' !important;
 	text-decoration: underline;
	font-size: 11px;
 }

a:visited
 {
 	color: '.$main_Lightest_Color.' !important;
 } 
 
a:hover
 {
 	color: '.$main_Light_Color.' !important;
 }

a:active
 {
 	color: #f8f8f8 !important;
 } 

';
?>