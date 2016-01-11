<?php
header("Content-type: text/css");
include ('./config.php');

echo '

/* fixes for IE6 - the crappiest browser in use today */

.HeaderLinks {
	top:83px;
	float: left !important;
} 
#Search {
	top: -66px;
	right: -10px;
}

.btn {
	padding-left: 5px !important;
	display: inline-table;
	overflow: visible;
	word-break: keep-all !important;
	white-space: nowrap !important;
	height: 27px;
	
}
.btn span {
	top: 0px;
	margin-left: 5px;
	height: 27px;
	line-height: 27px;
}

a.btn {
	padding: 0 !important;
	line-height: 12px !important; 
}
a.btn span {
	top: 0px;
	padding: 6px;
	display: inline;
}

.comanda,
#mareste,
#modifica,
#goleste,
#incheiecomanda,
#lanseazacomanda,
#verificasilanseaza,
#cereinfo {
	height: 28px;
	overflow: hidden;
}
#comandaprodus {
	height: 38px;
	overflow: hidden;
}

.stoctip {
	margin-left: -10px;
	margin-top: 10px;
}

.pageNumbers a.pg-next, .pageNumbers a.pg-prev {
	width: 18px;
	height: 20px;
}

.ie6wrapfix {
	width: 100% !important;
}

#LeftColumn {
	display: inline;
}
#RightColumn {
	display: inline;
}
.filterList {
	font-size: 100% !important;
	zoom: 1;
	filter:alpha(opacity=95);
}
.filterList ul {
	font-size: 100% !important;
}

.cartexpand,
.cartcollapse {
	position: relative;
	left: -20px;
	overflow: hidden;
	margin-right: 0 !important;
}

.pageNumbers a {
	padding: 2px 6px 1px 6px;
}

h3.homeWLtitle {
	margin-right: 0 !important;
	padding: 7px 6px 0px 8px;
	width: 544px;
}

.Filters {
	width: 530px !important;
 } 
 
.productpicture  {
	padding-left:5px;
}

.productpicture  {
	float: right;
}


.producttitle{
	width: 280px !important;
}


.producttext {
	padding-left: 10px !important;
}

.productPriceBox {
	float: right;
	margin-right: -100px;
	position: relative;
}

ul#toolbar,
ul#toolbar_topsold,
ul#toolbar_popular,
ul#toolbar_appreciated {
	background: url("../cs-images/promotitlebg.gif") repeat-x top left;
	height: 23px !important;
	overflow: hidden;
	margin-left: -5px !important;
}

ul#toolbar li a,
ul#toolbar_topsold li a,
ul#toolbar_popular li a,
ul#toolbar_appreciated li a {
	line-height: 5px;
	font-size: 5px;
}

.nextprev div,
.nextprev a {
	padding-left: 0 !important;
	padding-right: 0 !important;
	margin-left: 1px !important;
	margin-right: 1px !important;
}

.nextprev {
	height: 21px;
	background: url("../cs-images/promotitlebg.gif") repeat-x top left;
}

#slideBox0-tab { 
	display:inline;
}
#slideBox1-tab {
	display:inline;
}
#slideBox2-tab {
	margin-top:-2px;
}
div.button#left { 
	margin-top:225px;
}
div.button#right { 
	margin-top:225px;
}

.pDetailsMini {
	margin-left: -43px;
}

 a.productmodel:hover span {
	font-size: 100% !important;
	zoom: 1;
} 

';
?>