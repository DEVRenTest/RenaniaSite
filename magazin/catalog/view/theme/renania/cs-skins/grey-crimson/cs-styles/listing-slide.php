<?php
header("Content-type: text/css");
include ('./config.php');

echo '

/* The toolbar for the content box */

ul#toolbar,
ul#toolbar_topsold,
ul#toolbar_popular,
ul#toolbar_appreciated {
	text-align: center;
	list-style: none;
	margin: 0;
	float: right;
	padding-top: 5px;
	padding-left: 5px;
	padding-right: 0px;
}

ul#toolbar li,
ul#toolbar_topsold li,
ul#toolbar_popular li,
ul#toolbar_appreciated li {
	float: left;
	text-indent: -9999px;
}
	
ul#toolbar li a,
ul#toolbar_topsold li a,
ul#toolbar_popular li a,
ul#toolbar_appreciated li a {
	height: 5px;
	width: 5px;
	display: block;
	background: url(../cs-images/slidebox-a-inactive.png) no-repeat top left;
	cursor:pointer;
	margin-right: 4px;
	outline: none;
	margin-top: 9px;
}

ul#toolbar li.active a ,
ul#toolbar_topsold li.active a ,
ul#toolbar_popular li.active a ,
ul#toolbar_appreciated li.active a {
	background: #06828d url(../cs-images/slidebox-a-active.png) no-repeat top left;
}

ul#toolbar li.inactive a,
ul#toolbar_topsold li.inactive a,
ul#toolbar_popular li.inactive a,
ul#toolbar_appreciated li.inactive a {
	background: #222 url(../cs-images/slidebox-a-inactive.gif) no-repeat top left;
}
	
ul#toolbar li a:hover,
ul#toolbar_topsold li a:hover,
ul#toolbar_popular li a:hover,
ul#toolbar_appreciated li a:hover {
	background: #9eb0b8 url(../cs-images/slidebox-a-active.gif) no-repeat top left;
	}

.nextprev {
	position: relative;
	z-index: 1000;
	float: right;
	padding-top: 7px;
	padding-right: 4px;
}
.nextprev div,
.nextprev a {
	padding-left: 0 !important;
	padding-right: 0 !important;
	margin-left: 1px !important;
	margin-right: 1px !important;
}

#demo-wrapper,
#demo-wrapper_topsold,
#demo-wrapper_popular,
#demo-wrapper_appreciated {
	background: '.$slider_product_bg.';
	border: '.$slider_product_border.';
}

	
#slideBox0-tab { 
	margin-top:-2px;
	margin-left:435px;
}
#slideBox1-tab {
	margin-top:-2px;
}
#slideBox2-tab {
	margin-top:-2px;
}
div.button#left { 
	position: absolute;
	float:left;
	margin-left:504px;
	margin-top:222px;
	top: 0px;
	height: 20px;
	width:17px;
	_margin-top:225px;
}
div.button#right { 
	position: absolute;
	float:left;
	margin-left:521px;
	margin-top:222px;
	top:0px;
	height: 20px;
	width:17px;
	_margin-top:225px;
}

#scroller {
	width: 550px;
	height:190px;
	margin: 0 auto;	
	border-top: none;
	background: none;
	overflow: hidden;
}

.section {
	width: 540px;
	margin: 20px 0;
	float: left;
}

/* homepage product boxes */
#scroller .pSmallBox {
	background: #fff;
	float:left;
	padding:5px 10px 5px 10px;
	text-align: center;
	width:160px;
}
#scroller .pSmallBox p {
	font-size: 11px;
	padding: 5px 0;
	color: #333;
}

.pSmallBox {
	border: none;
	text-align: center;
	float: left;
	padding: 5px 5px 5px 5px;
	width: 125px;
	margin-right: 5px;
}
.pSmallBox .img {
}
.pSmallBox h2 {
	font-weight: normal;
	font-size: 12px !important;
}
.pSmallBox a {
	color: '.$slider_product_link_color.';
	font-weight: normal;
	text-decoration: none;
	text-align: center;
}
.pSmallBox a:hover {
	color: '.$slider_product_link_color_hover.' !important;
	text-decoration: underline;
}
.pDetailsMini {
	background: '.$main_Lightest_Color.';
	border: 4px solid '.$main_Lightest_Color.';
	width: 180px;
	position: absolute;
	z-index: 10;
	margin-top: -11px;
	margin-left: -33px;
}

.pDetailsMiniInner {
	border: 1px solid #ccc;
	width: 166px;
	text-align:left;
	padding: 5px;
}
.pDetailsMiniInner a {
	text-decoration: underline;
}
.pDetailsMiniInner p {
	font-size: 11px;
	padding: 5px 0;
	color: #333;
}
.pDetailsMiniPrice {
	font-size: 12px;
	font-weight: bold;
	text-decoration: none !important;
	color: '.$slider_product_price_color.';
}
.pDetailsMiniPrice .decimal {
	font-size: 12px;
	vertical-align: text-top;
}
.pDetailsMiniPrice .currency {
	font-size: 12px;
	font-weight: bold;
}
.stars {
	padding-top: 5px;
}

.pDetailsPic {
	text-align: center;
	margin-bottom: 2px;
	border: 1px solid #ccc;
	width:110px!important;
	height: 100px;
	overflow: hidden;
	margin:0 auto;
	background:#fff;
}

.pDetailsPic:hover {
	border: 1px solid #80949c;
} 

.pDetailsPic img {
	width: 110px;
}

/* scroll arrows */

.button a.scroll_left_arr {
	display: block;
	width: 25px;
	height: 25px;
	background: url("../cs-images/imagini/listing/stanga_off.jpg") no-repeat top left;
}
.button a.scroll_left_arr:hover {
	background: url("../cs-images/imagini/listing/stanga_on.jpg") no-repeat top left;
}

.button a.scroll_right_arr {
	display: block;
	width: 25px;
	height: 25px;
	background: url("../cs-images/imagini/listing/dreapta_off.jpg") no-repeat top right;
}
.button a.scroll_right_arr:hover {
	background: url("../cs-images/imagini/listing/dreapta_on.jpg") no-repeat top right;
}



';
?>
