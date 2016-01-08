<?php
header("Content-type: text/css");
include ('./config.php');

echo '

h1 {
	padding-left: '.$product_detail_price_padding.'px;
}

#MiddleColumn {
	width: '.$column_middle_width_detail.'px;
	float: left;
}

.ProductBigPicture{
	float: left;
}

.ProductBigPicture .Pic{
	float: left;
	display: block;
	width: '.$product_detail_picture_width.'px;
	height: '.$product_detail_picture_height.'px;
	margin-top: '.$column_space.'px;
	margin-right: '.$column_space.'px;
	border-width: 1px;
	border-style: solid;
	border-color: '.$product_detail_picture_border.';
}

.ProductBigPicture .UnderPicture {
	clear: left;
	float:left;
	width: '.$product_detail_picture_width.'px;
}

.ProductBigPicture .UnderPicture .Note {
	font-size: '.$note_size.'px;
	color: '.$note_color.';
	padding: '.$table_padding.'px;
	display: block;
}

#ProductInfo {
	float: left;
	width: '.$product_detail_info_width.'px;
	margin-top: '.$column_space.'px;
}

.Thumbnails {
	width: '.$small_thumbnail_width.'px;
	float: left;
	margin-right: '.$column_space.'px;
	margin-top: '.$column_space.'px;
}

#ProductInfo .Stars {
	padding-left: '.$product_detail_price_padding.'px;
}

.Opinions {
	float: left;
	margin: 5px 0px;
	font-size: '.$product_detail_opinions_size.'px;
	line-height: '.$product_detail_opinions_size.'px;
	color: '.$product_detail_opinions_color.';
	font-weight: '.$product_detail_opinions_bold.';
	padding: '.$product_detail_opinions_padding.'px;
	
}

.Reccomend-Print {
	float: left;
	margin: 0px 0px 5px 0px;
	font-size: '.$product_detail_opinions_size.'px;
	line-height: '.$product_detail_opinions_size.'px;
	color: '.$product_detail_opinions_color.';
	font-weight: '.$product_detail_opinions_bold.';
	padding: '.$product_detail_opinions_padding.'px;
	
}

.Code, .Opinions, .Reccomend-Print {
	padding-left: '.$product_detail_price_padding.'px;
}

.MainInfo {
	clear: left;
	/*float: left;*/
	height: '.$product_detail_maininfo_height.'px;	
	vertical-align: middle;
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
	text-align: right;
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
	font-size: '.$note_size.'px;
}

.MainInfo .TaxaVerde {
	font-size: '.$note_size.'px;
}

.Description {
	background: '.$product_detail_description_bg_r.';
	background-repeat: no-repeat;
	background-position: right top;
	padding-right: '.$product_detail_price_padding.'px;
	clear: left;
	float: left;
	display: block;
}

.Description .DescriptionContent{
	background: '.$product_detail_description_bg_l.';
	background-repeat: no-repeat;
	background-position: left top;
	padding-top: '.$desctiption_vertical_padding.'px;
	padding-bottom: '.$desctiption_vertical_padding.'px;
	padding-left: '.$product_detail_price_padding.'px;	
	font-size: '.$product_detail_description_size.'px;
	color: '.$product_detail_description_color.';
	font-weight: '.$product_detail_description_bold.';
	display: block;
	width: '.$description_width.'px;
}

.Description .DescriptionContent a{
	font-size: '.$product_detail_opinions_size.'px;
	font-weight: '.$product_detail_opinions_bold.';

}


.AddToCart {
	background: '.$addtocard_bg.';
	display: block;
	width: '.$addtocard_width.'px;
	height: '.$addtocard_height.'px;
	margin-top: '.$addtocard_toppadding.'px;
}

.SaveButton {
	background: '.$save_bg.';
	display: block;
	width: '.$save_width.'px;
	height: '.$save_height.'px;	
	float: left;
}

.Rate {
	padding-top: '.$product_lease_padding.'px;
	font-size: '.$product_lease_size.'px;
	color: '.$product_lease_color.';
	font-weight: '.$product_lease_bold.';
}

.RateLink {
	display: block;
}

.ProductButtons {
	float: left;
	background: '.$product_buttons_bg_l.';
	background-repeat: no-repeat;

}

.ProductButtons .ProductButtonsContent {
	padding-right: '.$product_detail_price_padding.'px;	
	float: left;
	background: '.$product_buttons_bg_r.';
	background-position: right top;
	background-repeat: no-repeat;
	margin-left: '.$product_detail_price_padding.'px;	
	padding-top: '.$product_buttons_padding	.'px;
	padding-bottom: '.$product_buttons_padding.'px;
	font-size: '.$box_content_size.'px;
	width: '.$description_width.'px;	
}

.Variants {
	float: left;
	background: '.$variants_bg_l.';
}

.Variants .VariantsContent {
	padding-right: '.$product_detail_price_padding.'px;	
	float: left;
	background: '.$variants_bg_r.';
	background-position: right top;
	margin-left: '.$product_detail_price_padding.'px;	
	padding-top: '.$product_buttons_padding	.'px;
	padding-bottom: '.$product_buttons_padding.'px;
	font-size: '.$variants_size.'px;
	width: '.$description_width.'px;			
}

.ReviewName {
	font-size: '.$review_name_size.'px;
	color: '.$review_name_color.';
	font-weight: '.$review_name_bold.';
	float: left;
	padding-left: '.$table_padding.'px;
	padding-top: '.$table_padding.'px;
}

.ReviewStars {
	float: left;
	padding-left: '.$table_padding.'px;
	padding-top: '.$table_padding.'px;	
}

.ReviewDate {
	font-size: '.$review_date_size.'px;
	color: '.$review_date_color.';
	font-weight: '.$review_date_bold.';
	float: left;
	padding-left: '.$table_padding.'px;
	padding-top: '.$table_padding.'px;	
}

.ReviewComment {
	font-size: '.$review_comment_size.'px;
	color: '.$review_comment_color.';
	font-weight: '.$review_comment_bold.';
	float: left;
	clear: left;	
	padding: '.$table_padding.'px;
}

.CommercialText {
	font-size: '.$commercialtext_size.'px;
	color: '.$commercialtext_color.';
	font-weight: '.$commercialtext_bold.';	
	padding: '.$table_padding.'px;
}

.Video {
	padding: '.$table_padding.'px;
	text-align: center;	
}

.TehnologiesName {
	font-size: '.$tehnologiesname_size.'px;
	color: '.$tehnologiesname_color.';
	font-weight: '.$tehnologiesname_bold.';
}

.TehnologiesDescription {
	font-size: '.$tehnologiesdesc_size.'px;
	color: '.$tehnologiesdesc_color.';
	font-weight: '.$tehnologiesdesc_bold.';
}
		
.TableBox .SmallThumbnail {
	margin: 0px;
}

.TableBox .TableFilesTitle {
	font-size: '.$files_title_size.'px;
	color: '.$files_title_color.';
	font-weight: '.$files_title_bold.';
}

.TableBox .TableFiles {
	font-size: '.$files_size.'px;
	color: '.$files_color.';
	font-weight: '.$files_bold.';
}

#BreadCrumbs {
	font-size: '.$breadcrumbs_size.'px;
	line-height: '.$breadcrumbs_size.'px;
	background: '.$breadcrumbs_detail_bg.';	
	background-repeat: no-repeat;
	background-position: right top;
}

.Calendar {
	background: '.$icon_calendar_bg.';
	width: '.$icon_calendar_width.'px;
	height: '.$icon_calendar_height.'px;
	display: block;
	float: left;
}

.STlink {
	height: '.$stlink_height.'px;
	width: '.$stlink_width.'px;
	display:block;
	float:right;
}

.stoctip {
	color:'.$note_color.';
	font-size: '.$note_size.'px;
	width:'.$stoctip_width.'px;
	border-width: '.$input_border_width.'px;
	border-color: '.$input_border_color.';
	border-style: solid;
	background: '.$table_row_bg_odd.';
	margin-left:-160px;
	padding:10px;
	position:absolute;
	text-align:left;
	font-weight: normal;
}

.pricetip {
	color:'.$note_color.';
	font-size: '.$note_size.'px;
	width:'.$stoctip_width.'px;
	border-width: '.$input_border_width.'px;
	border-color: '.$input_border_color.';
	border-style: solid;
	background: '.$table_row_bg_odd.';
	margin-left:-160px;
	padding:10px;
	position:absolute;
	text-align:left;
	font-weight: normal;
}

.productTag {
	float: left;
	margin-right: '.$column_space.'px;
	margin-bottom: '.$column_space.'px;
}


/****Tabs*****/

#tabs {
	/*margin-left: 4px;
	padding: 0;*/
	background: transparent;
	voice-family: "\"}\"";
	voice-family: inherit;
	/*padding-left: 5px;*/
}
#tabs ul {
	font: normal 11px Arial, Verdana, sans-serif;
	margin:0;
	padding:0;
	list-style:none;
}
#tabs li {
	display:inline;
	margin:0 2px 0 0;
	padding:0;
	text-transform:none;
}
#tabs a {
	float:left;
	background:url("../cs-images/mainimages/tableheader_l.gif") no-repeat scroll left top transparent;
	margin:0 2px 0 0;
	padding:0 0 1px 3px;
	text-decoration:none;
	color: #363636;
}
#tabs a span {
	float:left;
	display:block;
	background:url("../cs-images/mainimages/tableheader_r.gif") no-repeat scroll right top transparent;
	padding:4px 9px 2px 6px;
}
#tabs a span {
	float:none;
}
#tabs a:hover {
	background-color: #ebebeb;
	color: #000;
}
#tabs a:hover span {
	background-color: #ebebeb;
}
/*
#tabHeaderActive span, #tabHeaderActive a,
#tabHeaderActive span:hover, #tabHeaderActive a:hover { 
	background-color: #D9D9D9 !important; 
	color:#000 !important;
	font-weight:bold;
}
*/
#tabs .currenttab span, #tabs .currenttab a,
#tabs .currenttab span:hover, #tabs .currenttab a:hover { 
	background-color: #D9D9D9 !important; 
	color:#000 !important;
	font-weight:bold;
}

.tabContent {
	clear:both;
}


/**********Bundles product***********/

.BundlesTab ul {
	padding:0;
	margin:0;
	list-style-type:none;
	overflow:hidden;
} 

.BundlesTab li {
	width:465px;
	overflow:hidden;
	float:left; 
	margin-right:50px;
}

.BundlesTab .SmallThumbnail {
	clear:both;
}

.BundlesTab .SmallThumbnail a {
	color:#1258a1;
}

.BundlesTab .SmallThumbnail a span {
	color:#1258a1;
	font:normal 12px/15px Trebuchet MS, Arial, sans-serif;
	position:relative;
	left:90px;
	display:block;
	width:100px;
	margin-top:13px;
}

.BundlesTab .button_em {margin:0;}

.BundlePrice {
	float:right;
	padding:25px 0 0 55px;
	overflow:hidden;
	background:url(../cs-images/products/bundle_price.png) no-repeat center left;
	/*height:185px;*/
}

.BundlePrice strong {
	font:bold 17px/25px Trebuchet MS, Arial, sans-serif;
	color:#5fa1ca;
	display:block;
	margin-bottom:10px;
}


 ';
?>