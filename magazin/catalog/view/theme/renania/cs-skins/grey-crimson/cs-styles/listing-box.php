<?php

header("Content-type: text/css");

include ('./config.php');



echo '



#Filters {

	background: '.$filters_right_bg.';

	background-repeat: no-repeat;

	padding-right: '.$filters_padding.'px;



	background-position: top right;

}



#Filters .FiltersContent{

	padding-top: '.$filters_space.'px;

	background: '.$filters_left_bg.';

	background-repeat: no-repeat;

	padding-left: '.$filters_padding.'px;



}



#Filters .FiltersContent .FilterTitle {

	font-size: '.$filters_title_size.'px;

	color: '.$filters_title_color.';

	font-weight: '.$filters_title_bold.';	

	padding-bottom: '.$filters_padding.'px;

	padding-top: '.$filters_padding.'px;

	display: block;

	background: '.$filters_title_bg.';

	background-repeat: repeat-x;

}



#Filters .FiltersContent .FilterTitleFirst {

	font-size: '.$filters_title_size.'px;

	color: '.$filters_title_color.';

	font-weight: '.$filters_title_bold.';	

	padding-bottom: '.$filters_space.'px;

	display: block;

}



#Filters .FiltersContent .FilterSelect {

	display: block;

	padding-bottom: '.$filters_padding.'px;

	

}



#Filters .FiltersContent a.FilterElement {

	display: block;

	font-size: '.$filters_element_size.'px;

	color: '.$filters_element_color.';

	font-weight: '.$filters_element_bold.';		

	background: '.$filters_element_bg.';

	background-repeat: no-repeat;

	padding-left: '.$filters_element_bg_padding.'px;

	padding-bottom: '.$filters_space.'px;

	

}





#Filters .FiltersContent a.FilterElementLast {

	display: block;

	font-size: '.$filters_element_size.'px;

	color: '.$filters_element_color.';

	font-weight: '.$filters_element_bold.';		

	background: '.$filters_element_bg.';

	background-repeat: no-repeat;

	padding-left: '.$filters_element_bg_padding.'px;

	padding-bottom: '.$filters_padding.'px;

	

}







#Filters .FiltersContent a.FilterElementOn {

	display: block;

	font-size: '.$filters_element_size_on.'px;

	color: '.$filters_element_color_on.';

	font-weight: '.$filters_element_bold_on.';		

	background: '.$filters_element_bg_on.';

	background-repeat: no-repeat;

	padding-left: '.$filters_element_bg_padding.'px;

	padding-bottom: '.$filters_space.'px;

	

}



#Filters .FiltersContent a.FilterElementOn:hover {

	background: '.$filters_bottom_button_bg.';	

	background-repeat: no-repeat;

	background-position: top left;

}





#Filters .FiltersContent a.FilterElementOnLast {

	display: block;

	font-size: '.$filters_element_size_on.'px;

	color: '.$filters_element_color_on.';

	font-weight: '.$filters_element_bold_on.';		

	background: '.$filters_element_bg_on.';

	background-repeat: no-repeat;

	padding-left: '.$filters_element_bg_padding.'px;

	padding-bottom: '.$filters_padding.'px;

	

}





.FiltersBottom {

	background: '.$filters_bottom_bg_r.';

	background-repeat: no-repeat;

	background-position: right top;

	padding-right: 10px;

	margin-bottom: '.$column_space.'px;

} 





.FiltersBottom .FiltersBottomText {

	background: '.$filters_bottom_bg_l.';

	background-repeat: no-repeat;

	display: block;

} 



.FiltersBottom  a {

	font-size: '.$filters_bottom_size.'px;

	color: '.$filters_bottom_color.';

	font-weight: '.$filters_bottom_bold.';			

	line-height: '.$filters_bottom_size.'px;

	padding-top: '.$filters_bottom_padding.'px;

	padding-bottom: '.$filters_bottom_padding.'px;

	padding-left: '.$filters_element_bg_padding.'px;

	display: block;

	margin-left: '.$filters_padding.'px;

	background: '.$filters_bottom_button_bg.';	

	background-repeat: no-repeat;

	background-position: center left;



}



.FiltersBottomOff {

	background: '.$filters_bottom_off_r.';

	background-repeat: no-repeat;

	background-position: right top;

	padding-right: 10px;

	margin-bottom: '.$column_space.'px;

} 





.FiltersBottomOff .FiltersBottomOffText {

	background: '.$filters_bottom_off_l.';

	background-repeat: no-repeat;

	display: block;

	height: '.$filters_bottom_off_height.'px;

} 



.PageNumbers {

/*	padding-left: '.$page_padding.'px;

	padding-top: '.$column_space.'px;

	padding-right: '.$page_padding.'px;

	padding-bottom: '.$column_space.'px;

	float: right;

	width: '.$pagenumbers_width.'px;
	
*/
	float: right;
	padding-right: 6px;

}



.PageNumbers a{

	display: block;

	width: '.$page_off_bg_width.'px;

	font-size: '.$page_off_size.'px;

	line-height: '.$page_off_size.'px;

	color: '.$page_off_color.';

	font-weight: '.$page_off_bold.';

	text-align: center;

	background: '.$page_off_bg.';

	padding-top: '.$page_on_bg_padding.'px;

	padding-bottom: '.$page_on_bg_padding.'px;

	float: left;

	margin-right: '.$page_elements_space_off.'px;

}



.PageNumbers a:hover{

	background: '.$page_off_bg_over.';

	text-decoration: '.$page_off_overunderline.';

}



.PageNumbers .PageText {

	float: left;

	display: block;

	padding-top: '.$page_on_bg_padding.'px;

	padding-bottom: '.$page_on_bg_padding.'px;	

	font-size: '.$page_off_size.'px;

	line-height: '.$page_off_size.'px;	

	margin-right: '.$page_elements_space.'px;	

}



.PageNumbers .PageOn{

	display: block;

	width: '.$page_on_bg_width.'px;

	font-size: '.$page_on_size.'px;

	line-height: '.$page_on_size.'px;

	color: '.$page_on_color.';

	font-weight: '.$page_on_bold.';

	text-align: center;

	background: '.$page_on_bg.';

	padding-top: '.$page_on_bg_padding.'px;

	padding-bottom: '.$page_on_bg_padding.'px;

	float: left;

	margin-right: '.$page_elements_space.'px;	

	margin-left: '.$page_elements_space.'px;	

}



.PageNumbers .PageInput {

	display: block;

	float: left;

	padding-left: 10px;

}



.PageNumbers .PageInput input {

	width: '.$page_input_width.'px;

	font-size: '.$page_input_size.'px;

	line-height: '.$page_input_size.'px;

	padding: '.$page_input_padding.'px;

	text-align: center;

}



.PageNumbers .PageGo,

.PageNumbers .PageGo:hover {

	width: '.$page_butt_width.'px;

	height: '.$page_butt_height.'px;

	background: '.$page_butt_bg.';	

	padding: 0px;

	margin-left: 2px;	

}



.PageNumbers .PageNext,

.PageNumbers .PageNext:hover {

	width: '.$page_next_width.'px;

	height: '.$page_next_height.'px;

	background: '.$page_next_bg.';	

	padding: 0px;

	margin-left: 2px;	

}



.PageNumbers .PagePrev,

.PageNumbers .PagePrev:hover {

	width: '.$page_prev_width.'px;

	height: '.$page_prev_height.'px;

	background: '.$page_prev_bg.';	

	padding: 0px;

	margin-left: 10px;	

}



.PageNumbers .LayoutBox,

.PageNumbers .LayoutBox:hover {

	width: '.$page_box_width.'px;

	height: '.$page_box_height.'px;

	background: '.$page_box_bg_on.';	

	padding: 0px;

	margin-left: 2px;	

	float: right;

}



.PageNumbers .LayoutBox:hover {

	background: '.$page_box_bg_on.';	

}



.PageNumbers .LayoutList,

.PageNumbers .LayoutList:hover {

	width: '.$page_list_width.'px;

	height: '.$page_list_height.'px;

	background: '.$page_list_bg.';	

	padding: 0px;

	margin-left: 2px;	

	float: right;

}



.PageNumbers .LayoutList:hover {

	background: '.$page_list_bg_on.';	

}



.PageNumbers .LayoutText {

	float: right;

	display: block;

	padding-top: '.$page_on_bg_padding.'px;

	padding-bottom: '.$page_on_bg_padding.'px;	

	font-size: '.$page_off_size.'px;

	line-height: '.$page_off_size.'px;	

	margin-right: '.$page_elements_space.'px;	

}



#MiddleColumn #ProductsTop .ProductTopTitle a{

	font-size: '.$product_title_size.'px;

	color: '.$product_title_color.';

	font-weight: '.$product_title_bold.';

	padding: 5px;

	display: block;

	clear: left;

}



#MiddleColumn #ProductsTop .Product {

	width: '.$product_width.'px;

	float: left;

}



#MiddleColumn #ProductsTop .Product .ProductPicture {

	display: block;

	width: '.$product_width.'px;

	height: '.$product_height.'px;

}

#MiddleColumn #ProductsTop .Product .ProductPicture2 {

	background:url(../cs-images/products/product.png);

	background-position:top center;

	background-repeat:no-repeat;

	display:table-cell;

	text-align:center;

	vertical-align:middle;

	width: '.$product_width.'px;

	height: '.$product_height.'px;

}

#MiddleColumn #ProductsTop .Product .ProductPicture2 .prod{

	background-position:top center;

	background-repeat:no-repeat;

	max-width: '.$product_width.'px;

	max-height: '.$product_height.'px;

	border:1px solid #df9900;

}



#MiddleColumn #ProductsTop .Product .ProductPic1Price {

	display: block;

	width: '.$product_1price_width.'px;

	height: '.$product_1price_width.'px;	

}



#MiddleColumn #ProductsTop .Product .ProductPic1Price a {

	display: block;

	background: '.$product_1price_bg.';

	background-repeat: no-repeat;

	width: '.$product_1price_width.'px;

	height: '.$product_1price_height_ff.'px;	

	text-align: center;

	padding-top: '.$product_1price_topspace.'px;

}



#MiddleColumn #ProductsTop .Product .ProductPic1Price a:hover {

	text-decoration: none;

}



#MiddleColumn #ProductsTop .Product .ProductPic2Prices {

	display: block;

	width: '.$product_2prices_width.'px;

	height: '.$product_2prices_width.'px;

	float: left;

}



#MiddleColumn #ProductsTop .Product .ProductPic2Prices a {

	display: block;

	background: '.$product_2prices_bg.';

	width: '.$product_2prices_width.'px;

	height: '.$product_2prices_height_ff.'px;	

	text-align: center;

	padding-top: '.$product_2prices_topspace.'px;



}



#MiddleColumn #ProductsTop .Product .ProductPic2Prices a:hover {

	text-decoration: none;

}



#MiddleColumn #ProductsTop .Product .ProductNoLogin {

	display: block;

	width: '.$product_nologin_width.'px;

	height: '.$product_nologin_width.'px;	

}



#MiddleColumn #ProductsTop .Product .ProductNoLogin a {

	display: block;

	background: '.$product_nologin_bg.';

	width: '.$product_nologin_width.'px;

	height: '.$product_nologin_height_ff.'px;	

	text-align: center;

	padding-top: '.$product_nologin_topspace.'px;



}



#MiddleColumn #ProductsTop .Product .ProductNoLogin a:hover {

	text-decoration: none;

}



#MiddleColumn #ProductsTop .Product .ProductNoPrice {

	display: block;

	width: '.$product_noprice_width.'px;

	height: '.$product_noprice_width.'px;



}



#MiddleColumn #ProductsTop .Product .ProductNoPrice a {

	display: block;

	background: '.$product_noprice_bg.';

	background-repeat: no-repeat;

	width: '.$product_noprice_width.'px;

	height: '.$product_noprice_height_ff.'px;	

	text-align: center;

	padding-top: '.$product_noprice_topspace.'px;

}



#MiddleColumn #ProductsTop .Product .ProductNoPrice a:hover {

	text-decoration: none;

}



#MiddleColumn #ProductsTop .Product .ProductText {

	display: block;

	font-size: '.$product_text_size.'px;

	width: '.$product_text_width.'px;

	color: '.$product_text_color.';

	margin-left: '.$product_text_color_marginleft.'px;

	line-height: '.$product_text_size.'px;

}



#MiddleColumn #ProductsTop .Product .ProductPriceOld {

	font-size: '.$product_priceold_size.'px;

	color: '.$product_priceold_color.';

	font-weight: '.$product_priceold_bold.';

	display: block;

}





#MiddleColumn #ProductsTop .Product .ProductPrice {

	font-size: '.$product_price_size.'px;

	color: '.$product_price_color.';

	font-weight: '.$product_price_bold.';

	padding-top: '.$product_2prices_pricespace.'px;

	display: block;

}



#MiddleColumn #ProductsTop .Product .ProductPrice sup {

	font-size: 9px; /* de modificat */

}



#MiddleColumn #ProductsTop .Product .Stars,

#MiddleColumn #ProductInfo .Stars

 {

	text-align: center;

	height: '.$product_star_height.'px;

	width: '.$product_stars_width.'px;

	margin: 5px auto;

}



#MiddleColumn #ProductInfo .Stars {

	text-align: left;

	margin: 5px 0px;

	float: left;

}



#MiddleColumn #ProductsTop .Product .Stars div,

#MiddleColumn #ProductInfo .Stars div {

	display: static;

	height: '.$product_star_height.'px;

	width: '.$product_star_width.'px;

	float: left;

}



#MiddleColumn #ProductsTop .Product .FullStar,

#MiddleColumn #ProductInfo .FullStar {

	background: '.$product_fullstar_bg.';

	background-repeat: no-repeat;



}



#MiddleColumn #ProductsTop .Product .HalfStar,

#MiddleColumn #ProductInfo .HalfStar {

	background: '.$product_halfstar_bg.';

	background-repeat: no-repeat;



}





#MiddleColumn #ProductsTop .Product .EmptyStar,

#MiddleColumn #ProductInfo .EmptyStar {

	background: '.$product_emptystar_bg.';

	background-repeat: no-repeat;



}



.SmallFullStar {

	background: '.$small_fullstar_bg.';

	background-repeat: no-repeat;

	width: '.$small_star_width.'px;

	height: '.$small_star_height.'px;

	float: left;

}



.SmallHalfStar {

	background: '.$small_halfstar_bg.';

	background-repeat: no-repeat;

	width: '.$small_star_width.'px;

	height: '.$small_star_height.'px;	

	float: left;

}



.SmallEmptyStar {

	background: '.$small_emptystar_bg.';

	background-repeat: no-repeat;

	width: '.$small_star_width.'px;

	height: '.$small_star_height.'px;

	float: left;	

}



#MiddleColumn #ProductsTop .HomeWishlistTitle {

	display: block;

	background: '.$home_wishlist_title_bg_r.';

	background-repeat: no-repeat;

	background-position: right top;

	clear: both;

	padding-right: 10px;

}



#MiddleColumn #ProductsTop .HomeWishlistTitle a{

	display: block;

	background: '.$home_wishlist_title_bg_l.';

	background-repeat: no-repeat;

	background-position: left top;

	font-size: '.$home_wishlist_title_size.'px;

	color: '.$home_wishlist_title_color.';

	font-weight: '.$home_wishlist_title_bold.';

	padding: '.$home_wishlist_title_padding.'px;

	line-height: '.$home_wishlist_title_size.'px;

}



#MiddleColumn #ProductsTop .HomeWishlistTable {

	width: 100%;

}



#MiddleColumn #ProductsTop .HomeWishlistTable td {

	text-align: center;

	background: '.$home_wishlist_row_bg.';

	background-repeat: repeat-x;

	background-position: left top;

	font-size: '.$home_wishlist_row_size.'px;

	color: '.$home_wishlist_row_color.';

	font-weight: '.$home_wishlist_row_bold.';	

	padding-top: '.$home_wishlist_row_padding.'px;

	padding-bottom: '.$home_wishlist_row_padding.'px;

	line-height: '.$home_wishlist_row_size.'px;

}



#MiddleColumn #ProductsTop .HomeWishlistTable td.LastRow {

	background: '.$home_wishlist_lastrow_bg.';

	background-repeat: repeat-x;

	background-position: left top;

}



#MiddleColumn #ProductsTop .HomeWishlistTable td.FirstColumn {

	padding-left: '.$home_wishlist_title_padding.'px;

	background: '.$home_wishlist_row_bg_l.';

	background-repeat: no-repeat;

	background-position: left top;

	text-align: left;

	font-weight: bold;

}



#MiddleColumn #ProductsTop .HomeWishlistTable td.FirstColumnLast {

	background: '.$home_wishlist_lastrow_bg_l.';

	background-repeat: no-repeat;

	background-position: left top;

}



#MiddleColumn #ProductsTop .HomeWishlistTable td.LastColumn {

	text-align: right;

	background: '.$home_wishlist_row_bg_r.';

	background-repeat: no-repeat;

	background-position: right top;

	padding-right: '.$home_wishlist_title_padding.'px;

}



#MiddleColumn #ProductsTop .HomeWishlistTable td.LastColumnLast {

	background: '.$home_wishlist_lastrow_bg_r.';

	background-repeat: no-repeat;

	background-position: right top;

}



h2 a {

	display: block;

	padding-top: 5px;

	padding-bottom: 5px;

	height: 30px;

}



h3 {

	font-size: 12px;

	font-weight: normal;

	text-align: center;

	margin: 0px;

	padding-top: 0px;

	padding-bottom: 15px;	

}



h3.BoxDescription {

	font-size: '.$note_size.'px;

	display: block;

	padding-left: '.$column_space.'px;

	padding-right: '.$column_space.'px;

	overflow: hidden;

	clear: both;

}



h3.ListDescription {

 	font-size: '.$website_size.'px;

	display: none;

}



.StockState {

	width: '.$product_width.'px;

	text-align: center;

	float:left;

	margin-bottom: '.$column_space.'px;

}

 

';

?>

