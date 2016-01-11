<?php
header("Content-type: text/css");
include ('./config.php');

echo '

h1 {
	margin-top: '.$column_space.'px;
	padding-left: 0px;
}

h2 {
	text-align: left;
	padding-top: '.$column_space.'px;
}

h2 a {
	height: auto;
	padding: 0px;
}

h4 {
	font-weight: normal;
}

#BreadCrumbs {
	font-size: '.$breadcrumbs_size.'px;
	line-height: '.$breadcrumbs_size.'px;
	background: '.$breadcrumbs_detail_bg.';	
	background-repeat: no-repeat;
	background-position: right top;
}

#MiddleColumn {
	width: '.$column_middle_width_detail.'px;
}

#MiddleColumn ul {
	list-style-type: none;
	padding: 0px;
	margin: 0px;
}

.bundle img {
	border: none;
	border-width: 1px;
	border-style: solid;
	border-color: '.$product_detail_picture_border.';
}

.bundleDetails {
	margin-top: '.$column_space.'px;
}

.bundleDetails .bundlePictures {
	float: left;
	width: '.$BundlesPictures_width.'px;
}

.bundlePriceBox {
	float: right;
}

.MainInfo {
	float: right;
	height: '.$product_detail_maininfo_height.'px;	
	vertical-align: middle;
	clear: none;
}

.MainInfo table {
	width: 100%;
}

.MainInfo .InfoLeft {
	background: '.$product_detail_maininfo_bg_l.';
	background-repeat: no-repeat;
	padding-left: '.$product_detail_price_padding.'px;
	padding-right: '.$product_detail_price_padding.'px;
	height: '.$product_detail_maininfo_height.'px;		
	vertical-align: middle;
}


.MainInfo .InfoRight {
	background: '.$product_detail_maininfo_bg_r.';
	background-repeat: no-repeat;
	background-position: right top;
	padding-left: '.$product_detail_price_padding.'px;
	padding-right: '.$product_detail_price_padding.'px;
	height: '.$product_detail_maininfo_height.'px;		
	vertical-align: middle;
	font-size: '.$product_detail_info_size.'px;
	color: '.$product_detail_info_color.';
	font-weight: '.$product_detail_info_bold.';
}

.MainInfo .InfoRight a {
	font-weight: bold;
	color: '.$product_detail_info_color.';
}

.MainInfo .OldPrice {
	text-decoration: line-through;
	font-size: '.$product_detail_oldprice_size.'px;
	color: '.$product_detail_oldprice_color.';
	font-weight: '.$product_detail_oldprice_bold.';
	line-height: '.$product_detail_oldprice_size.'px;

}

.MainInfo .OldPrice .Decimals {
	font-size: '.$product_detail_oldprice_decimals.'px;
	vertical-align: text-top;
	
}

.MainInfo .Price {
	font-size: '.$product_detail_price_size.'px;
	color: '.$product_detail_price_color.';
	font-weight: '.$product_detail_price_bold.';
	line-height: '.$product_detail_price_size.'px;	
}

.MainInfo .Price .Decimals {
	font-size: '.$product_detail_price_decimals.'px;
	vertical-align: text-top;	
}

.MainInfo .TVA {
	color: '.$product_detail_price_color.';
	font-size: 10px;	
}

.AddToCart {
	background: '.$addtocard_bg.';
	display: block;
	width: '.$addtocard_width.'px;
	height: '.$addtocard_height.'px;
	margin-top: '.$addtocard_toppadding.'px;
}

.Thumbnails {
	width: '.$small_thumbnail_width.'px;
	float: left;
	margin-right: '.$column_space.'px;
}

.bundleSave {
	color: '.$product_detail_oldprice_color.';
	font-size: '.$product_detail_oldprice_size.'px;
	font-weight: bold;
}

.BundleDetailPicture {
	float: left;
}

.BundleItem .BundleDetailPicture {
	float: left;
	margin-bottom: '.$column_space.'px;
}

.BundleItemList h4 {
	margin-top: 0px;
}

h4.BundleDescriptionText {
	float: left;
	width: '.$BundleDescriptionText_width.'px;
	margin-top: 0px;
}

h1.BundleName {
	margin-bottom: '.$column_space.'px;
}

.BundleItemList {
	margin-top: '.$column_space.'px;
}

.BundleItem {
	float: left;
	margin-right: '.$column_space.'px;
	width: 249px;
	text-align: left;
}

.BundleDescriptionTitle {
	margin-bottom: '.$column_space.'px;
}

.BundleDescriptionTitle h2 {
	text-align: center;
	height: '.$BundleItemTitle_height.'px;
}

.BundlePic {
	width: '.$BundlePic_width.'px;
	height: '.$BundlePic_height.'px;
	display: block;
	border: none;
	border-width: 1px;
	border-style: solid;
	border-color: '.$product_detail_picture_border.';
	float: left;
}

.Note {
	font-size: '.$note_size.'px;
	color: '.$note_color.';
	padding: '.$table_padding.'px;
	display: block;
}


';

?>