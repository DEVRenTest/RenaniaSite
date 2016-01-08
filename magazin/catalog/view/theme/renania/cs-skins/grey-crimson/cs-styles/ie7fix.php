<?php
header("Content-type: text/css");
include ('./config.php');

echo '

#HeaderLinks #HeaderTabs .on {
	height: 12px;
}

.GeneralButton {
	padding: 0px 10px 0px 0px;
}

button {
	padding-top: 0px;
	padding-bottom: 2px;
}

#Header #cart a span {
	line-height: 16px;
}

.bluetag, .orangetag, .greentag {
	padding: 0px;
}

#MiddleColumn #ProductsTop .HomeWishlistTitle a {
	padding-top: 4px;
	padding-bottom: 7px;
}

#HeaderLinks a {
	line-height: 14px;
}

.TableBox tr,
{
	position: relative;
}

.TableForm .TableHeader td,
.TableBox .TableHeader td,
.TablePlaceOrder .TableHeader td {
	background-image: none;
}

#HeaderLinks #HeaderTabs .HeaderTabsText {
	line-height: 14px;
}

.TableForm .TableParam {
	/* width: 100%; */
}

#Filters {
	margin: 0px;
}

.FiltersBottomOff {
	position: relative;
}

#MiddleColumn #ProductsTop .HomeWishlistTable td.FirstColumnLast {
	line-height: 17px;
}

.PageNumbers .PageOn {
	line-height: 13px;
}

.PageNumbers a {
	line-height: 13px;
}

.MainInfo .InfoRight td {
	white-space: nowrap;
}

.MainInfo .InfoRight span {
	text-decoration: none !important;
}

#ProductInfo .MainInfo .InfoRight span.pricetip,
#ProductInfo .MainInfo .InfoRight span.stoctip {
	white-space: normal;
}

.stoctip {
	margin-top: 15px;
	margin-left: -170px;
}

#RightColumn .ContentRightBox {
	width: 93.5%;
} 

#RightColumn .ContentRightBox .ContentRightBoxI {
	float: left;
}

.cartpopup {
	margin-left: -94px;
}

#MiddleColumn #ProductsTop .Product .ProductText {
	margin-left: 0px;
}


';
?>