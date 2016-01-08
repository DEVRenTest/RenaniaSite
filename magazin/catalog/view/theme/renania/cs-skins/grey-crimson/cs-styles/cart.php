<?php
header("Content-type: text/css");
include ('./config.php');

echo '

#MiddleColumn {
	width: '.$column_middle_width_detail.'px;
}

.CartTotal {
	color: '.$product_detail_price_color.';
	font-weight: bold;
}

.Big {
	font-size: 20px;
	font-size: bold;
}

h4 {
	font-weight: normal;
}

.TablePlaceOrder {
	width: 50%;
	padding: '.$column_space.'px;
}

.Left {
	float: left;
}

.Right {
	float: right;
}

.LeftSection {
	width: '.$BuyerSection_width.'px;
	float: left;
	margin-bottom: '.$column_space.'px;
	display: block;
}

.RightSection {
	width: '.$DeliverySection_width.'px;
	float: right;
	margin-bottom: '.$column_space.'px;
}

.TableBox .TableParam {
	width: 30%;
}

.inactive {
	padding: 2px 0px;
	float: left;
	clear: left;
	width: 100%;
}

.active {
	font-weight: bold;
	padding: 10px 0px;
	float: left;
	clear: left;
	width: 93.5%;
	background-color: '.$table_row_bg_odd.';
}

.inactive input, .active input {
	float: left;
}

.inactive span, .active span {
	float: left;
}

.inactive span {
	padding-top: 4px;
	font-size: '.$note_size.'px;
	color: '.$note_color.';
}

.active span {
	padding-top: 2px;
}

.odd {
	background: '.$table_row_bg_odd.';
}

.even {
	background: '.$table_row_bg_even.';
}

.TotalTop {
	border-top: 1px solid #666666;
}

.tarea {
	overflow: auto;
}

.OrderSent {
	padding: 50px 0px;
}

.overlay{
    background:transparent url(../cs-images/overlay.png) repeat top left;
    position:fixed;
    top:0px;
    bottom:0px;
    left:0px;
    right:0px;
    z-index:100;
}


.voucher {
	margin-top: 30px;
	border-bottom: 1px solid #BBBBBB;
}

.registerForm {
	margin-top: 10px;
}

.registerForm label{
	font-size: 12px;
	color: #3D3D3D;
	padding: 0 0 5px;	
	cursor:pointer;
}

.registerForm p{
	font-size: 12px;
	color: #3D3D3D;
	padding: 0 0 5px;
}

.registerForm p.header{
	font-size: 12px;
	padding: 5px 0;
	margin: 5px 0;
	font-weight:bold;
}

.registerForm input[type=text], .registerForm input[type=password], .registerForm textarea{
	border: 1px solid #BBBBBB;
	font-size: 14px;
	padding: 3px 5px;
	margin-right: 15px;
}

.registerForm fieldset{
	border:none;
	border-bottom: 1px solid #EFEFEF;
}

label.error, p.error{
	color:red;
}
.sugestions p{
	font-weight:bold;
}

#addressesBox label, #companiesBox label, #customerBox label{
	float:left;
	width: 120px;
}
.MyInfo{
	float: left;
	width: 595px;"
}

.MyInfo p{
	font-size: 14px;
}
.MyInfo p a{
	float:right;
}
.MyInfoLinks {
	float: left;
	margin-left: 10px;
}
.MyInfoLinks ul{
	list-style-type: none;
	font-size: 14px;
	font-weight: bold;
	margin: 0;
	padding:0
	
}
.MyInfoLinks ul li{
	border-bottom: 1px solid #000000;
	padding: 10px 0;
}

.MyInfoLinks ul li.current a{
	color: '.$product_detail_price_color.';
}
 ';
?>