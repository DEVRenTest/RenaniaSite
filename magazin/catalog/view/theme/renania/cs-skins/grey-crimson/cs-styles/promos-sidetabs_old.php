<?php
header("Content-type: text/css");
include ('./config.php');

echo '

/* begin styles */

#promosContainer {
	margin-top: 0px;
	width: '.$column_middle_width.'px;
	height: '.$promo_container_height.'px;
	text-align: right;
	overflow: hidden;
}

#promoItem {
	background: '.$promo_bg.';
	height: '.$promo_container_height.'px;
}

#promoItem table {
	float: left;
}

.promoPic img {
	float: left;
	border: none;
	margin-top: '.$promopic_margin_top.'px;
	width: '.$promopic_width.'px;
}

#PromoDescription {
	float: left;
	width: '.$promo_description_width.'px;
	padding-left: '.$promo_description_padding_left.'px;
	color: '.$categories_title_color.';
	text-align: left;
}

.promosNav {
	width: '.$promo_tabs_container_width.'px;
	list-style-type:none;
	height: '.$promo_tabs_container_height.'px;
	float: right;
	padding-top: '.$promosNav_padding_top.'px;
	padding-bottom: '.$promosNav_padding_bottom.'px;
	margin: 0px;
}

*:first-child+html .promosNav {
	margin-left: 0px;
}

.promosNav li {
	width: '.$promo_tabs_container_width.'px;
	height: 37px;
	cursor: pointer;
}

.promosNav td {
	width: '.$promo_tabs_container_width.'px;
	background: '.$promo_tab_normal_bg.';
	height: 54px;
	cursor: pointer;
}

.promosNav li a {
	text-decoration:none;
	color: '.$categories_row_color.';
	display: block;
	font-weight: bold;
	text-align: '.$promo_tab_active_textalign.';
	outline: none;
	height: '.$promo_tab_height.'px;
	width: 117px;
	overflow: hidden;
	line-height: 16px;
	border-bottom: 1px solid #e0e0e0; 
	margin-right: 15px;
	float:right;
	padding-top: 11px;
}

.promosNav td a {
	text-decoration:none;
	color: '.$categories_row_color.';
	display: block;
	font-weight: bold;
	text-align: '.$promo_tab_active_textalign.';
	outline: none;
	/* height: '.$promo_tab_height.'px; */
	width: 117px;
	overflow: hidden;
	line-height: 16px;
	/* border-bottom: 1px solid #e0e0e0; */
	margin-right: 15px;
	float:right;
	padding-top: 0px;
}

.promosNav li a span {
	font-weight: normal;
	color: #9c9c9c;
}
.promosNav li.current {
	background: '.$promo_tab_active_bg.';
	width: '.$promo_tabs_container_width.'px;
	height: '.$promo_tab_active_height.'px;
}

.promosNav td.current {
	background: '.$promo_tab_active_bg.';
	width: '.$promo_tabs_container_width.'px;
	height: '.$promo_tab_active_height.'px;
}

* html .promosNav li.current {
	width: 120px;
}

.promosNav li.current a {
	color: '.$categories_title_color.';
	border: '.$promo_tab_active_border.';
	text-align: '.$promo_tab_active_textalign.';
	padding-top: 17px;
}

.promosNav td.current a {
	color: '.$categories_title_color.';
	border: '.$promo_tab_active_border.';
	text-align: '.$promo_tab_active_textalign.';
}

.promosNav li.current a span {
	font-weight: normal;
	color:#aaa;
}


/* end styles */

';
?>