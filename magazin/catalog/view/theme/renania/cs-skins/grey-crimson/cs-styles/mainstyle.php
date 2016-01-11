<?php

header("Content-type: text/css");



include ('./config.php');



echo '





* {

	outline: none;

}



body {

 	margin: 0;

 	padding: 0;

 	background: '.$website_bg.';

 	background-repeat: repeat-x;

 	font-family: '.$website_family.'; /*website font face*/

 	font-size: '.$website_size.'px;

 	color: '.$website_color.';

}



a {

 	color: '.$link_color.';

 	text-decoration: '.$link_underline.';

	outline: none;

}



a:active, a:focus {

	outline: none;

}



a:hover {

 	color: '.$link_color_hover.';

 	text-decoration: '.$link_underline_hover.';

}

.selected{color:#df0000;}

.whitelink{

	color:#efefef;

	}

.whitelink:hover{

	color:#ffffff;

	}

img {

	border: none;

}



input, select, textarea, file {

	border-width: '.$input_border_width.'px;

	border-color: '.$input_border_color.';

	border-style: solid;

	background: '.$input_background.';

	

	font-family: '.$input_family.';

	font-size: '.$input_size.'px;

	color: '.$input_color.';

	padding: '.$input_space.'px;

	font-weight: '.$input_bold.';

}



.CheckRadio {

	border: none;

	background: none;

}



button {

	background: '.$button_bg.';

	background-repeat: no-repeat;

	background-position: left top;

	border: none;

	padding: '.$button_padding.';

	/*padding: 1px 0px 3px 10px;   still working */

	font-size: '.$button_size.'px;

	color: '.$button_color.';

	font-weight: '.$button_bold.';

	text-transform: '.$button_style.';

	cursor: pointer;

	text-decoration: none;

}



button:hover {

	text-decoration: none;

}



.EmphasizeType {

	color: '.$product_detail_price_color.';

	font-weight: bold;

}



.GeneralButton {

	background: '.$button_bg_r.';

	background-repeat: no-repeat;	

	background-position: right top;

	padding: '.$generalbutton_padding.';	

	/*padding: 2px 10px 3px 0px;*/

	cursor: pointer;

	font-size: '.$input_size.'px;

}



a .GeneralButton button:hover {

	text-decoration: none;

}



#MiddleColumn .DivButton {

	padding-top: 1px;

}



#LeftColumn {

	width: '.$column_left_width.'px;

	padding-right: '.$column_space.'px;

	float: left;

}



#RightColumn {

	width: '.$column_right_width.'px;

	padding-left: '.$column_space.'px;

	float: left;

}



#MiddleColumn {

	width: '.$column_middle_width.'px;

	float: left;

}





/* Header */





#HeaderLinks {

	width: '.$website_width.'px;

	margin: 0 auto;

	height: '.$headerlinks_height.'px; 



	vertical-align: middle;

	line-height: '.$headerlinks_size.'px;

	font-size: '.$headerlinks_size.'px;

	font-family: '.$headerlinks_family.';

	color: '.$headerlinks_text_color.';

}



#HeaderLinks a {

	color: '.$headerlinks_color.';

	padding-top: '.$headerlinks_padding.'px;	

	display: block;

	float: left;

	margin-right: 10px;

	text-decoration: '.$headerlinks_underline.';

}



#HeaderLinks a:hover {

	color: '.$headerlinks_color_hover.';

	text-decoration: '.$headerlinks_underline_hover.';

}



#HeaderLinks #HeaderPhones {



}



#HeaderLinks #HeaderPhones .Phones{

	padding: 0px 0px 0px 10px;

	float: left;

	padding-top: '.$headerlinks_padding.'px;	

}



#HeaderLinks #HeaderPhones .Phones span {

	padding: 0px 10px 0px 0px;

}



#HeaderLinks #HeaderTabs {

	float: right;

}



#HeaderLinks #HeaderTabs .HeaderTabsText {

	padding-top: '.$headerlinks_padding.'px;	

	padding-right: 10px;

	float: left;

}



#HeaderLinks #HeaderTabs a {

	padding-top: '.$headerlinks_padding.'px;	

	padding-bottom: '.$headerlinks_padding.'px;	

}	



#HeaderLinks #HeaderTabs .off {

	background: '.$headertab_off_bg.';

	font-size: '.$headertab_off_size.';

	color: '.$headertab_off_color.';

	font-weight: '.$headertab_off_bold.';

	width: '.$headertab_off_width.'px;	

	text-align: center;

}



#HeaderLinks #HeaderTabs .on {

	background: '.$headertab_on_bg.';

	font-size: '.$headertab_on_size.';

	color: '.$headertab_on_color.';

	font-weight: '.$headertab_on_bold.';

	width: '.$headertab_on_width.'px;	

	text-align: center;

}



#Header {

	clear: both;

	padding-top: '.$column_space.'px;

	padding-bottom: '.$column_space.'px;

	width: '.$website_width.'px;

	margin: 0 auto;

	background: '.$header_bg.';

}



#Header #Logo {

	float: left;

	width: '.$logo_width.'px;	

	padding-right: '.$column_space.'px;

}



#Header #Logo a {

	display: block;

	background: '.$logo_bg.';

	background-repeat: no-repeat;

	background-position: center center;

	width: '.$logo_width.'px;

	height: '.$logo_height.'px;

}



#Header #Logo a:hover {

	background: '.$logo_bg_hover.';

	background-repeat: no-repeat;

	background-position: center center;

	

}



#Header #Facilities {

	float: left;

	padding-right: '.$column_space.'px;

	width: '.$header_facilities_width.'px;

}



#Header #Facilities #Search {

	background: '.$header_search_bg.';

	height: '.$header_search_height.'px;

	width: '.$header_search_width.'px;

	font-size: '.$header_search_size.'px;

	font-weight: '.$header_search_bold.';

}



#Header #Facilities #Search input {

	width: 250px;

}



#Header #Facilities #Search select {

	width: 200px;

}



#Header #Facilities #Search .SearchTable {

	padding-top: '.$header_search_padding.'px;	

}



#MiddleColumn #Search {

	background: '.$header_search_bg.';

	height: '.$header_search_height.'px;

	width: '.$header_search_width.'px;

	font-size: '.$header_search_size.'px;

	font-weight: '.$header_search_bold.';

}



#MiddleColumn #Search input {

	width: 250px;

}



#MiddleColumn #Search select {

	width: 200px;

}



#MiddleColumn #Search .SearchTable {

	margin-top: '.$header_search_padding.'px;	

}



#Header #Facilities #Login{

	background: '.$header_login_bg.';

	height: '.$header_search_height.'px;

	width: '.$header_search_width.'px;

	font-size: '.$header_search_size.'px;

	font-weight: '.$header_search_bold.';

	display: none;

}



#Header #Facilities #Login #Logged {

	height: '.$header_logged_height.'px;

	width: '.$header_logged_width.'px;

	padding-top: '.$header_logged_padding.'px;

	padding-bottom: '.$header_logged_padding.'px;

	padding-left: '.$column_space.'px;

	padding-right: '.$column_space.'px;

	float: left;

}



#Header #Facilities #Login #Logged p {

	margin: 0px;

	float: left;

	padding-bottom: '.$header_logged_padding.'px;

}



#Header #Facilities #Login input {

	width: 205px;

}



#Header #Facilities #Login .LoginTable {

	padding-top: '.$header_search_padding.'px;	

}



#Header #FacilitiesTabs {

	padding-bottom: '.$header_tab_margin.'px;

	padding-left: '.$header_tab_margin_left.'px;

}



#Header #FacilitiesTabs #LoginLink {

	background: '.$LoginLink_bg.';

	padding-left: '.$LoginLink_padding.'px;

}



.TagsBox1Price {

	width: '.$product_1price_width.'px;

	margin-top: 105px;

	text-align: center;

	float: left;

	position: absolute;

}



.TagsBox2Prices {

	width: '.$product_1price_width.'px;

	text-align: center;

	position: absolute;

	margin-top: 98px;

}



.productTag {

	font-size: '.$note_size.'px;

	color: '.$button_color.';

	height: '.$productTag_height.'px;

	overflow: hidden;

}



.greentag {

	background: '.$greentag_end_bg.';

	padding: 2px 4px 3px 0px;

	display: inline;

}



.greentag strong {

	background: '.$greentag_bg.';

	padding: 2px 0px 4px 4px;

}



.bluetag {

	background: '.$bluetag_end_bg.';

	padding: 2px 0px;

	display: inline;

}



.bluetag strong {

	background: '.$bluetag_bg.';

	padding: 2px 0px 3px 4px;

	margin-right:4px;

	line-height: 12px;

}



.orangetag {

	background: '.$orangetag_end_bg.';

	padding: 2px 0px;

	display: inline;

}



.orangetag strong {

	background: '.$orangetag_bg.';

	padding: 2px 0px 3px 4px;

	margin-right:4px;

	line-height: 12px;

}



#Header #FacilitiesTabs a {

	background: '.$header_tab_bg .';

	font-size: '.$header_tab_size.'px;	

	color: '.$header_tab_color.';	

	font-weight: '.$header_tab_bold.';	

	padding: '.$header_tab_margin.'px;

	display: inline;

}



#Header #FacilitiesTabs a:hover {

	background: '.$header_tab_bg_on .';

	color: '.$header_tab_color_on.';	

	font-weight: '.$header_tab_bold_on.';	

	text-decoration: '.$header_tab_underline_on.';	

}



#Header #FacilitiesTabs a.selected {

	background: '.$header_tab_bg_selected .';

	color: '.$header_tab_color_selected.';	

	font-weight: '.$header_tab_bold_selected.';	

}



#Header #cart {

	float: left;

	width: '.$column_right_width.'px;

	font-size: 

}



#Header #cart a {

	background: '.$header_sc_off_bg.';

	/* height: '.$header_sc_height.'px; */

	font-size: '.$header_sc_size.'px;

	color: '.$header_sc_off_color.';

	font-weight: '.$header_sc_bold.';

	background-repeat: no-repeat;

	display: block;

}





#Header #cart a:hover {

	background: '.$header_sc_off_bg.';

	color: '.$header_sc_on_color.';

	background-repeat: no-repeat;

	text-decoration: none;

}



#Header #cart a span {

	display: block;

	padding: '.$header_sc_padding.'px;

	width: '.$header_sc_text_width.'px;

	line-height: '.$emptycart_lineheight.'px;

}



#Header #cart a.STlink {

	width: '.$header_sc_width.'px;

	height: '.$header_sc_height.'px;

	float: none;

	margin-top: 0px;

	padding-left: 0px;

}



#Header #cart a.HasProducts-off {

	background: '.$header_sc_off_bg.';

}



#Header #cart a.HasProducts-on {

	background: '.$header_sc_on_bg.';

}



#Header #cartTitle {

	float: left;

	/*background: '.$header_sctitle_bg.';*/

	margin-bottom: '.$header_sctitle_margin.'px;

	/*padding-left: '.$header_sctitle_margin_left.'px;*/

	font-weight:  '.$header_sctitle_bold.';

	font-size:  '.$header_sctitle_size.'px;

}



/* Boxes */



#LeftColumn .Categories .Title {

	background: '.$categories_title_bg_r.';

	background-repeat: no-repeat;

	background-position: right top;

}



#LeftColumn .Categories .Title span{

	background: '.$categories_title_bg_l.';

	background-repeat: no-repeat;

	background-position: left top;

	margin-right: 10px;

	display: block;

	padding: '.$categories_title_padding.'px;

	font-size: '.$categories_title_size.'px;

	color: '.$categories_title_color.';

	line-height: '.$categories_title_size.'px;

	font-weight: '.$categories_title_bold.';

}



#LeftColumn .Categories .Content span.depth1 {

	background: '.$categories_row_bg_r.';

	background-repeat: no-repeat;

	background-position: right bottom;

	display: block;

}



#LeftColumn .Categories .Content span.depth1 a{

	background: '.$categories_row_bg_l.';

	background-repeat: no-repeat;

	background-position: left bottom;

	display: block;

	margin-right: 10px;

	padding: '.$categories_row_padding.'px;

	font-size: '.$categories_row_size.'px;

	color: '.$categories_row_color.';

	line-height: '.$categories_row_size.'px;	

	font-weight: '.$categories_row_bold.';

}





/*#####################################################################################*/



#LeftColumn .Categories .Content span.depthLatest {

    background: '.$categories_row_bg_r.';

    background-repeat: no-repeat;

    background-position: right top;

    display: block;

    border-bottom:1px solid '.$input_border_color.';

}



#LeftColumn .Categories .Content span.depthLatest_on {

    background: '.$categories_row_bg_r.';

    background-repeat: no-repeat;

    background-position: right top;

    display: block;

    border-bottom:1px solid '.$input_border_color.';

}





#LeftColumn .Categories .Content span.depthLatest a{

    background: '.$categories_row_bg_l.';

    background-repeat: no-repeat;

    background-position: left top;

    display: block;

    margin-right: 10px;

    padding: '.$categories_row_padding.'px;

    font-size: '.$categories_row_size.'px;

    color: '.$categories_row_color.';

    line-height: '.$categories_row_size.'px;   

    font-weight: '.$categories_row_bold.';

}



#LeftColumn .Categories .Content span.latestselectedLatest,

#LeftColumn .Categories .Content span.latestselectedLatest_on

 {

    background: '.$categories_row_bg_r_selected.';

    background-repeat: no-repeat;

    background-position: right top;

    display: block;

}



#LeftColumn .Categories .Content span.latestselectedLatest a,

#LeftColumn .Categories .Content span.latestselectedLatest_on a

{

    background: '.$categories_row_bg_l_selected.';

    background-repeat: no-repeat;

    background-position: left top;

    display: block;

    margin-right: 10px;

    padding: '.$categories_row_padding.'px;

    font-size: '.$categories_row_size.'px;

    color: '.$categories_row_color_latest_selected.';

    line-height: '.$categories_row_size.'px;   

    font-weight: '.$categories_row_latest_bold_selected.';

    text-decoration: '.$categories_row_latest_underline_selected.';

}



/*#####################################################################################*/









#LeftColumn .Categories .Content span.depth1_on {

	background: '.$categories_row_bg_r_on.';

	background-repeat: no-repeat;

	background-position: right top;

	display: block;

}



#LeftColumn .Categories .Content span.depth1_on a{

	background: '.$categories_row_bg_l_on.';

	background-repeat: no-repeat;

	background-position: left top;

	display: block;

	margin-right: 10px;

	padding: '.$categories_row_padding.'px;

	font-size: '.$categories_row_size.'px;

	color: '.$categories_row_color_on.';

	line-height: '.$categories_row_size.'px;	

	font-weight: '.$categories_row_bold_on.';

	text-decoration: '.$categories_row_underline_on.';

}



#LeftColumn .Categories .Content span.latest {

	background: '.$categories_row_bg_r_latest.';

	background-repeat: no-repeat;

	background-position: right top;

	display: block;

}



#LeftColumn .Categories .Content span.latest a{

	background: '.$categories_row_bg_l_latest.';

	background-repeat: no-repeat;

	background-position: left top;

	display: block;

	margin-right: 10px;

	padding: '.$categories_row_padding.'px;

	font-size: '.$categories_row_size.'px;

	color: '.$categories_row_color_latest.';

	line-height: '.$categories_row_size.'px;	

	font-weight: '.$categories_row_bold_latest.';

	text-decoration: '.$categories_row_underline_latest.';

}



#LeftColumn .Categories .Content span.latest_on {

	background: '.$categories_row_bg_r_latest_on.';

	background-repeat: no-repeat;

	background-position: right top;

	display: block;

}



#LeftColumn .Categories .Content span.latest_on a{

	background: '.$categories_row_bg_l_latest_on.';

	background-repeat: no-repeat;

	background-position: left top;

	display: block;

	margin-right: 10px;

	padding: '.$categories_row_padding.'px;

	font-size: '.$categories_row_size.'px;

	color: '.$categories_row_color_latest_on.';

	line-height: '.$categories_row_size.'px;	

	font-weight: '.$categories_row_bold_latest_on.';

	text-decoration: '.$categories_row_underline_latest_on.';

}



#LeftColumn .Categories .Content span.vouchers {

	background: '.$categories_row_bg_r_vouchers.';

	background-repeat: no-repeat;

	background-position: right top;

	display: block;

}



#LeftColumn .Categories .Content span.vouchers a{

	background: '.$categories_row_bg_l_vouchers.';

	background-repeat: no-repeat;

	background-position: left top;

	display: block;

	margin-right: 10px;

	padding: '.$categories_row_padding.'px;

	font-size: '.$categories_row_size.'px;

	color: '.$categories_row_color_latest.';

	line-height: '.$categories_row_size.'px;	

	font-weight: '.$categories_row_bold_latest.';

	text-decoration: '.$categories_row_underline_latest.';

}



#LeftColumn .Categories .Content span.vouchers_on {

	background: '.$categories_row_bg_r_vouchers_on.';

	background-repeat: no-repeat;

	background-position: right top;

	display: block;

}



#LeftColumn .Categories .Content span.vouchers_on a{

	background: '.$categories_row_bg_l_vouchers_on.';

	background-repeat: no-repeat;

	background-position: left top;

	display: block;

	margin-right: 10px;

	padding: '.$categories_row_padding.'px;

	font-size: '.$categories_row_size.'px;

	color: '.$categories_row_color_latest_on.';

	line-height: '.$categories_row_size.'px;	

	font-weight: '.$categories_row_bold_latest_on.';

	text-decoration: '.$categories_row_underline_latest_on.';

}



#LeftColumn .Categories .Content span.selected,

#LeftColumn .Categories .Content span.selected_on

 {

	/*background: '.$categories_row_bg_r_selected.';

	background-repeat: no-repeat;

	background-position: right top;

	display: block;*/

}



#LeftColumn .Categories .Content span.selected a,

#LeftColumn .Categories .Content span.selected_on a

{

/*	background: '.$categories_row_bg_l_selected.';

	background-repeat: no-repeat;

	background-position: left top;

	display: block;*/

	margin-right: 10px;

	padding: '.$categories_row_padding.'px;

	font-size: '.$categories_row_size.'px;

	color: /*'.$categories_row_color_selected.';*/#af0000;

	line-height: '.$categories_row_size.'px;	

	font-weight: '.$categories_row_bold_selected.';

	text-decoration: '.$categories_row_underline_selected.';

}



#LeftColumn .Categories .Content span.selected_on a:hover {

	text-decoration: '.$categories_row_underline_selected.';

}



#LeftColumn .Categories .Content span.latestselected,

#LeftColumn .Categories .Content span.latestselected_on

 {

	background: '.$categories_row_bg_r_latest_selected.';

	background-repeat: no-repeat;

	background-position: right top;

	display: block;

}



#LeftColumn .Categories .Content span.latestselected a,

#LeftColumn .Categories .Content span.latestselected_on a

{

	background: '.$categories_row_bg_l_latest_selected.';

	background-repeat: no-repeat;

	background-position: left top;

	display: block;

	margin-right: 10px;

	padding: '.$categories_row_padding.'px;

	font-size: '.$categories_row_size.'px;

	color: '.$categories_row_color_latest_selected.';

	line-height: '.$categories_row_size.'px;	

	font-weight: '.$categories_row_latest_bold_selected.';

	text-decoration: '.$categories_row_latest_underline_selected.';

}



#LeftColumn .Categories .Content span.latestselected_on a:hover {

	text-decoration: '.$categories_row_underline_latest_selected.';

}





#LeftColumn .Categories .Content span.depth2 {

	background: '.$subcategories_row_bg_r.';

	background-repeat: no-repeat;

	background-position: right bottom;

	display: block;

	min-height: '.$subcategories_row_height.'px;	

}



#LeftColumn .Categories .Content span.depth2 a{

	background: '.$subcategories_row_bg_l.';

	background-repeat: no-repeat;

	background-position: left bottom;

	display: block;

	margin-right: 10px;

	padding: '.$subcategories_row_padding.'px;

	padding-left: '.$depth2_padding.'px;

	font-size: '.$subcategories_row_size.'px;

	/*color: '.$subcategories_row_color.';

	line-height: '.$subcategories_row_size.'px;	*/

	line-height: 12px;	

	font-weight: '.$subcategories_row_bold.';

}





#LeftColumn .Categories .Content span.depth2_on {

	background: '.$subcategories_row_bg_r_on.';

	background-repeat: no-repeat;

	background-position: right top;

	display: block;

}



#LeftColumn .Categories .Content span.depth2_on a, 

#LeftColumn .Categories .Content span.depth2_on a:hover{

	background: '.$subcategories_row_bg_l_on.';

	background-repeat: no-repeat;

	background-position: left top;

	display: block;

	margin-right: 10px;

	padding-top: '.$subcategories_row_padding.'px;

	padding-bottom: '.$subcategories_row_padding.'px;

	padding-left: '.$depth2_padding.'px;

	font-size: '.$subcategories_row_size.'px;

	color: '.$subcategories_row_color_on.';

	line-height: '.$subcategories_row_size.'px;	

	font-weight: '.$subcategories_row_bold_on.';

	text-decoration: '.$subcategories_row_underline.';

}



#LeftColumn .Categories .Content span.depth2selected,

#LeftColumn .Categories .Content span.depth2selected_on

 {

	background: '.$subcategories_row_bg_r_selected.';

	background-repeat: no-repeat;

	background-position: right top;

	display: block;

}



#LeftColumn .Categories .Content span.depth2selected a,

#LeftColumn .Categories .Content span.depth2selected_on a

{

	background: '.$subcategories_row_bg_l_selected.';

	background-repeat: no-repeat;

	background-position: left top;

	color: /*'.$subcategories_row_color_selected.';*/#af0000;

	font-weight: '.$subcategories_row_bold_selected.';

	text-decoration: '.$subcategories_row_underline_selected.';

}



#LeftColumn .Categories .Content span.depth2selected_on a:hover {

	text-decoration: '.$subcategories_row_underline_selected.';

}





#LeftColumn .Categories .Content span.depth3 {

	background: '.$subcategories_row_bg_r3.';

	background-repeat: no-repeat;

	background-position: right bottom;

	display: block;

	min-height: '.$subcategories_row_height.'px;	

}



#LeftColumn .Categories .Content span.depth3 a{

	background: '.$subcategories_row_bg_l3.';

	background-repeat: no-repeat;

	background-position: left bottom;

	display: block;

	margin-right: 10px;

	padding: '.$subcategories_row_padding.'px;

	padding-left: '.$depth3_padding.'px;

	font-size: '.$subcategories_row_size.'px;

	/*color: '.$subcategories_row_color.';*/

	/*line-height: '.$subcategories_row_size.'px;	*/

	line-height: 12px;		

	font-weight: '.$subcategories_row_bold.';

}





#LeftColumn .Categories .Content span.depth3_on {

	background: '.$subcategories_row_bg_r_on3.';

	background-repeat: no-repeat;

	background-position: right top;

	display: block;

}



#LeftColumn .Categories .Content span.depth3_on a, 

#LeftColumn .Categories .Content span.depth3_on a:hover{

	background: '.$subcategories_row_bg_l_on3.';

	background-repeat: no-repeat;

	background-position: left top;

	display: block;

	margin-right: 10px;

	padding-top: '.$subcategories_row_padding.'px;

	padding-bottom: '.$subcategories_row_padding.'px;

	padding-left: '.$depth3_padding.'px;

	font-size: '.$subcategories_row_size.'px;

	color: '.$subcategories_row_color_on.';

	line-height: '.$subcategories_row_size.'px;	

	font-weight: '.$subcategories_row_bold_on.';

	text-decoration: '.$subcategories_row_underline.';

}



#LeftColumn .Categories .Content span.depth3selected,

#LeftColumn .Categories .Content span.depth3selected_on

 {

	background: '.$subcategories_row_bg_r_selected3.';

	background-repeat: no-repeat;

	background-position: right top;

	display: block;

}



#LeftColumn .Categories .Content span.depth3selected a,

#LeftColumn .Categories .Content span.depth3selected_on a

{

	background: '.$subcategories_row_bg_l_selected3.';

	background-repeat: no-repeat;

	background-position: left top;

	color: /*'.$subcategories_row_color_selected.';*/#af0000;

	font-weight: '.$subcategories_row_bold_selected.';

	text-decoration: '.$subcategories_row_underline_selected.';

}



#LeftColumn .Categories .Content span.depth3selected_on a:hover {

	text-decoration: '.$subcategories_row_underline_selected.';

}



#LeftColumn .ContentList span {

	background: '.$list_row_bg_r.';

	background-repeat: no-repeat;

	background-position: right top;

	display: block;

}



#LeftColumn .ContentList span a {

	background: '.$list_row_bg_l.';

	background-repeat: no-repeat;

	background-position: left top;

	display: block;

	margin-right: 10px;

	padding: '.$list_row_padding.'px;

	font-size: '.$list_row_size.'px;

	color: '.$list_row_color.';

	line-height: '.$list_row_size.'px;	

	font-weight: '.$list_row_bold.';

}



#LeftColumn .ContentBoxAllI span a {

	color: '.$list_row_color.';

	font-size: '.$list_row_size.'px;

	line-height: '.$list_row_size.'px;	

	font-weight: '.$list_row_bold.';

}



#LeftColumn .ContentList span.normal_on {

	background: '.$list_row_bg_r_on.';

	background-repeat: no-repeat;

	background-position: right top;

	display: block;

}



#LeftColumn .ContentList span.normal_on a

{

	background: '.$list_row_bg_l_on.';

	background-repeat: no-repeat;

	background-position: left top;

	display: block;

	margin-right: 10px;

	padding: '.$list_row_padding.'px;

	font-size: '.$list_row_size.'px;

	color: '.$list_row_color_on.';

	line-height: '.$list_row_size.'px;	

	font-weight: '.$list_row_bold_on.';

	text-decoration: '.$list_row_underline_on.';

}



#LeftColumn .ContentList span.normal_on a:hover {

	text-decoration: '.$list_row_underline_on.';

}



#LeftColumn .ContentList span.first {

	background: '.$list_row_bg_r_first.';

	background-repeat: no-repeat;

	background-position: right top;

	display: block;

}



#LeftColumn .ContentList span.first a{

	background: '.$list_row_bg_l_first.';

	background-repeat: no-repeat;

	background-position: left top;

	display: block;

	margin-right: 10px;

	padding: '.$list_row_padding.'px;

	font-size: '.$list_row_size.'px;

	color: '.$list_row_color_first.';

	line-height: '.$list_row_size.'px;	

	font-weight: '.$list_row_bold_first.';

}





#LeftColumn .ContentList span.first_on {

	background: '.$list_row_bg_r_first_on.';

	background-repeat: no-repeat;

	background-position: right top;

	display: block;

}



#LeftColumn .ContentList span.first_on a{

	background: '.$list_row_bg_l_first_on.';

	background-repeat: no-repeat;

	background-position: left top;

	display: block;

	margin-right: 10px;

	padding: '.$list_row_padding.'px;

	font-size: '.$list_row_size.'px;

	color: '.$list_row_color_first_on.';

	line-height: '.$list_row_size.'px;	

	font-weight: '.$list_row_bold_first_on.';

}



#LeftColumn .ContentList span.first_on a:hover {

	text-decoration: '.$list_row_underline_first_on.';

}



#LeftColumn .ContentList span.latest,

#LeftColumn .ContentBoxAllLink .latest {

	background: '.$list_row_bg_r_latest.';

	background-repeat: no-repeat;

	background-position: right top;

	display: block;

}



#LeftColumn .ContentList span.latest a,

#LeftColumn .ContentBoxAllLink .latest a{

	background: '.$list_row_bg_l_latest.';

	background-repeat: no-repeat;

	background-position: left top;

	display: block;

	margin-right: 10px;

	padding: '.$list_row_padding.'px;

	font-size: '.$list_row_size.'px;

	color: '.$list_row_color_latest.';

	line-height: '.$list_row_size.'px;	

	font-weight: '.$list_row_bold_latest.';

}



#LeftColumn .ContentList span.latest_on,

#LeftColumn .ContentBoxAllLink .latest_on {

	background: '.$list_row_bg_r_latest_on.';

	background-repeat: no-repeat;

	background-position: right top;

	display: block;

}



#LeftColumn .ContentList span.latest_on a,

#LeftColumn .ContentBoxAllLink .latest_on a{

	background: '.$list_row_bg_l_latest_on.';

	background-repeat: no-repeat;

	background-position: left top;

	display: block;

	margin-right: 10px;

	padding: '.$list_row_padding.'px;

	font-size: '.$list_row_size.'px;

	color: '.$list_row_color_latest_on.';

	line-height: '.$list_row_size.'px;	

	font-weight: '.$list_row_bold_latest_on.';

}



#LeftColumn .ContentList span.latest_on a:hover,

#LeftColumn .ContentBoxAllLink .latest_on a:hover {

	text-decoration: '.$list_row_underline_latest_on.';

}



#LeftColumn .BoxTitle {

	margin-top: '.$column_space.'px;

	background: '.$box_title_bg_r.';

	background-repeat: no-repeat;

	background-position: right top;

}



#LeftColumn .BoxTitle span{

	background: '.$box_title_bg_l.';

	background-repeat: no-repeat;

	background-position: left top;

	margin-right: 10px;

	display: block;

	padding: '.$box_title_padding.'px;

	font-size: '.$box_title_size.'px;

	color: '.$box_title_color.';

	line-height: '.$box_title_size.'px;

	font-weight: '.$box_title_bold.';

}



#LeftColumn .ContentBox {

	background: '.$box_content_bg_r.';

	background-position: right bottom;

	background-repeat: no-repeat;

	padding-right: '.$box_content_padding.'px;

	font-size: '.$box_content_size.'px;

	color: '.$box_content_color.';

	font-weight: '.$box_content_bold.';	

}



#LeftColumn .ContentBoxI{

	background: '.$box_content_bg_l.';

	background-position: left bottom;

	background-repeat: no-repeat;

	padding-left: '.$box_content_padding.'px;

	padding-bottom: '.$box_content_padding.'px;

	padding-top: '.$box_content_padding.'px;

	display: block;

	font-size: '.$box_content_size.'px;

	color: '.$box_content_color.';

	font-weight: '.$box_content_bold.';	

}



#LeftColumn .ContentBoxAll {

	background: '.$box_content_bg_r.';

	background-position: right top;

	background-repeat: no-repeat;

	padding-right: '.$box_content_padding.'px;

	font-size: '.$box_content_size.'px;

	color: '.$box_content_color.';

	font-weight: '.$box_content_bold.';	

}



#LeftColumn .ContentBoxAllI{

	background: '.$box_content_bg_l.';

	background-position: left top;

	padding-left: '.$box_content_padding.'px;

	padding-bottom: '.$box_content_padding.'px;

	padding-top: '.$box_content_padding.'px;

	display: block;

	font-size: '.$box_content_size.'px;

	color: '.$box_content_color.';

	font-weight: '.$box_content_bold.';	

}



#LeftColumn .ContentBox .fieldtitle {

	display: block;

	padding: 5px 0px 3px 0px;

	font-weight: bold;

}



#LeftColumn .ContentBox input {

	width: '.$box_input_width.'px;

}



#LeftColumn .ContentBox .BoxButton {

	margin-top: 5px;

}

	

#LeftColumn #LeftBanners {

	width: '.$column_left_width.'px;

	overflow: hidden;

	padding-top: 5px;

	padding-bottom: 5px;

}









#RightColumn .BoxRightTitle {

	background: '.$box_right_title_bg_r.';

	background-repeat: no-repeat;

	background-position: right top;

}



#RightColumn .BoxRightTitle span{

	background: '.$box_right_title_bg_l.';

	background-repeat: no-repeat;

	background-position: left top;

	margin-right: 10px;

	display: block;

	padding: '.$box_right_title_padding.'px;

	font-size: '.$box_right_title_size.'px;

	color: '.$box_right_title_color.';

	line-height: '.$box_right_title_size.'px;

	font-weight: '.$box_right_title_bold.';

	text-align: '.$box_right_title_align.';

}



#RightColumn .ContentRightBox {

	background: '.$box_right_content_bg_r.';

	background-position: right bottom;

	background-repeat: no-repeat;

	padding-right: '.$box_right_content_padding.'px;

	font-size: '.$box_right_content_size.'px;

	color: '.$box_right_content_color.';

	font-weight: '.$box_right_content_bold.';	

	margin-bottom: '.$column_space.'px;

}



#RightColumn .ContentRightBoxI{

	background: '.$box_right_content_bg_l.';

	background-position: left bottom;

	padding-left: '.$box_right_content_padding.'px;

	padding-bottom: '.$box_right_content_padding.'px;

	padding-top: '.$box_right_content_padding.'px;

	display: block;

	font-size: '.$box_right_content_size.'px;

	color: '.$box_right_content_color.';

	font-weight: '.$box_right_content_bold.';	

	text-align: '.$box_right_title_align.';

}





#RightColumn .SpecialProductImg {

	width: '.$special_product_picture_width.'px;

	height: '.$special_product_picture_height.'px;	

	background-position: center center;

	margin-left: '.$special_product_margin_left.'px;

   

}



#RightColumn .SpecialProduct {

	background: '.$special_product_price.';

	background-position: '.$special_product_left.'px '.$special_product_top.'px;

	padding-left: '.$special_product_left.'px;

	padding-top: '.$special_product_padding_top.'px;

	background-repeat: no-repeat;

	width: '.$special_product_width.'px;

	height: '.$special_product_height.'px;

	font-size: '.$special_product_size.'px;

	line-height: '.$special_product_size.'px;

	color: '.$special_product_color.';

	font-weight: '.$special_product_bold.';

	text-align: center;

}



#RightColumn .SpecialProductDesc {

	font-size: '.$special_product_desc_size.'px;	

	color: '.$special_product_desc_color.';

	font-weight: '.$special_product_desc_bold.';



}



#RightColumn .SpecialProductDesc a.ProductName{

	font-size: '.$special_product_name_size.'px;	

	color: '.$special_product_name_color.';

	font-weight: '.$special_product_name_bold.';



}



.SmallThumbnail {

	display: block;

	width: '.$small_thumbnail_width.'px;

	height: '.$small_thumbnail_height.'px;

	float: left;

	clear: left;

	margin-bottom:  '.$latest_products_vspace.'px;

	margin-right: 5px;

}



.SmallThumbnail a {

	background: '.$small_thumbnail_bg.';

	width: '.$small_thumbnail_width.'px;

	height: '.$small_thumbnail_height.'px;

	display: block;

}



#RightColumn .LatestProductDesc {

	float: left;

	width: '.$latest_products_width.'px;	

	text-align: left;

	padding-bottom: '.$latest_products_vspace.'px;

}



#RightColumn .LatestProductDesc a.ProductName {

	font-size: '.$latest_products_size.'px;

	font-weight: '.$latest_products_bold.';

	color: '.$latest_products_color.';

}



#RightColumn .LatestProductDesc .Price, #RightColumn .ContentRightBoxI .ProductPrice {

	font-size: '.$latest_products_price_size.'px;

	font-weight: '.$latest_products_price_bold.';

	color: '.$latest_products_price_color.';

}



#RightColumn #RightBanners {

	width: '.$column_right_width.'px;

	overflow: hidden;

	padding-top: 5px;

	padding-bottom: 5px;

}



#ProductsTop {

	float: left;

}



h1 {

	font-size: 20px;

	color: #000000;

	font-weight: normal;

	margin: 0px;

}



h2 { /* de modificat */

	font-size: 12px;

	line-height: 15px;

	font-weight: bold;

	text-align: center;

	margin: 0px;

	padding: 0px;

}



#MiddleColumn .HomeArticles {

	clear: both;

	margin-top: '.$column_space.'px;

}



#MiddleColumn .HomeArticles .HomeArticle {

	width: '.$home_article_pic_width.'px;

	float: left;

}





#MiddleColumn .HomeArticles .HomeArticle .HomeArticlePic{

	width:'.$home_article_pic_width.'px; 

	height:'.$home_article_pic_height.'px; 

	background: '.$home_article_bg.';

}



#MiddleColumn .HomeArticles .HomeArticle .ArticleTitle{

	font-size: '.$home_article_title_size.'px;

	color: '.$home_article_title_color.';

	font-weight: '.$home_article_title_bold.';		

	padding-top: '.$home_article_padding.'px;

	padding-left: '.$home_article_padding.'px;

	padding-right: '.$home_article_padding.'px;

}



#MiddleColumn .HomeArticles .HomeArticle .ArticleText{

	font-size: '.$home_article_text_size.'px;

	color: '.$home_article_text_color.';

	font-weight: '.$home_article_text_bold.';		

	padding-top: '.$home_article_padding_elements.'px;

	padding-left: '.$home_article_padding.'px;

	padding-right: '.$home_article_padding.'px;	

}



#MiddleColumn .AdminLinks {

	padding: '.$column_space.'px;

	border-width: 1px;

	border-color: '.$links_border_color.';

	border-style: solid;

	margin-top: '.$column_space.'px;

	float: left;

	width: '.$links_width.'px;

	display: block;

}



#MiddleColumn .HomeArticles .HomeArticle .ArticleText .GeneralButton {

	text-align: center;

}



#BreadCrumbs {

	font-size: '.$breadcrumbs_size.'px;

	line-height: '.$breadcrumbs_size.'px;

	background: '.$breadcrumbs_bg.';	

	background-repeat: repeat-x;

}



#BreadCrumbs .FirstLink {

	background: '.$breadcrumbs_firstlink_bg.';

	display: block;

	height: '.$breadcrumbs_height.'px;

	float: left;

	background-repeat: no-repeat;	

	padding-left: '.$breadcrumbs_padding.'px;



}



#BreadCrumbs a{

	font-weight: '.$breadcrumbs_link_blod.';	

	color: '.$breadcrumbs_link_color.';	

	padding-top: '.$breadcrumbs_padding.'px;

	padding-bottom: '.$breadcrumbs_padding.'px;

	display: block;

}



#BreadCrumbs .MiddleLink {

	background: '.$breadcrumbs_middle_bg.';

	display: block;

	height: '.$breadcrumbs_height.'px;

	float: left;	

	background-repeat: repeat-x;

	padding-left: '.$breadcrumbs_space.'px;

}



#BreadCrumbs .LastText {

	display: block;

	float: left;	

	font-weight: '.$breadcrumbs_text_blod.';	

	color: '.$breadcrumbs_text_color.';		

	padding-left: '.$breadcrumbs_space.'px;

	padding-top: '.$breadcrumbs_padding.'px;

	padding-bottom: '.$breadcrumbs_padding.'px;

}



#BreadCrumbs .MiddleConnection {

	background: '.$breadcrumbs_middleconnection_bg.';

	width: '.$breadcrumbs_middleconnection_width.'px;

	height: '.$breadcrumbs_height.'px;

	display: block;

	float: left;

	background-repeat: no-repeat;

}







#BreadCrumbs .LastConnection {

	background: '.$breadcrumbs_lastconnection_bg.';

	width: '.$breadcrumbs_lastconnection_width.'px;

	height: '.$breadcrumbs_height.'px;

	display: block;

	float: left;

}



#Footer {

	background: '.$footer_bg.';

	padding-top: '.$footer_padding.'px;

}	



#Footer .FooterArticles {

	width: '.$website_width.'px;

	margin: 0 auto;

}



#Footer .FooterCategoriesList {

	width: '.$FooterCategoriesList_width.'px;

}



#Footer .PoweredBy {

	float: left;

	margin-right: '.$column_space.'px;

}



#Footer .Rss {

	float: left;

	margin-left: '.$column_space.'px;

	width: '.$RSSicon_width.'px;

}





#Footer .FooterArticles .FooterArticle {

	float: left;

	display: inline;

}



#Footer .FooterArticles .FooterArticle .FooterTitle {

	font-size: '.$footer_title_size.'px;

	color: '.$footer_title_color.';

	font-weight: '.$footer_title_bold.';		

	display: block;

	width: '.$footer_column_width.'px;

	padding-bottom: 5px;

}



#Footer .FooterArticles .FooterArticle a{

	font-size: '.$footer_link_size.'px;

	color: '.$footer_link_color.';

	font-weight: '.$footer_link_bold.';		

	display: block;

	width: '.$footer_column_width.'px;

}



#Footer .FooterText {

	font-size: '.$footer_text_size.'px;

	color: '.$footer_text_color.';

	font-weight: '.$footer_text_bold.';		

	padding-top: '.$footer_padding.'px;

	margin-top: '.$column_space.'px;

	background: '.$footer_icons_bg.';

	background-repeat: repeat-x;

	background-position: top left;

	padding-bottom: '.$footer_padding.'px;

}



#Footer .FooterText .Icons {

	margin: 0 auto;

	width: '.$website_width.'px;

}





#Website {

	width:'.$website_width.'px; /* main container width */

	background: '.$content_bg.'; /* main container background */

	margin: 0 auto;

}







.cleaner, 

.Cleaner {

	clear: both;

}





/* Recaptcha */

.recaptchatable .recaptcha_image_cell, #recaptcha_table {

   background-color:'.$header_bg.' !important; //reCaptcha widget background color

 }

 

#recaptcha_table {

   border-color: '.$header_bg.' !important; //reCaptcha widget border color

 }

 

#recaptcha_response_field {

   border-color: '.$header_bg.' !important; //Text input field border color

   background-color:'.$header_bg.' !important; //Text input field background color

 }



.TableBox {

	width: 100%;

}



.TableBox td, .TablePlaceOrder td {

	padding: '.$table_padding.'px;

	font-size: '.$table_font_size.'px;

}



.TableForm .TableHeader,

.TableBox .TableHeader,

.TablePlaceOrder .TableHeader  {

	background: '.$table_header_bg_l.';	

	background-position: left top;

	background-repeat: no-repeat;

	font-size: '.$table_header_size.'px;

	color: '.$table_header_color.';

	font-weight: '.$table_header_bold.';

	padding: 0px;

}



.TableForm .TableHeader span,

.TableBox .TableHeader span,

.TablePlaceOrder .TableHeader span

 {

	background: '.$table_header_bg_r.';	

	background-position: right top;

	background-repeat: no-repeat;

	padding: '.$table_padding.'px;

	display: block;

}



.TableForm .TableHeader .End,

.TableBox .TableHeader .End {

	background: '.$table_header_bg_r.';	

	background-position: right top;

	background-repeat: no-repeat;

}



.TableBox .BigTableHeader {

	background: '.$big_table_header_bg_l.';	

	background-position: left top;

	background-repeat: no-repeat;

	font-size: '.$big_table_header_size.'px;

	color: '.$table_header_color.';

	font-weight: '.$table_header_bold.';

	padding: 0px 0px 0px 5px;

}



.TableBox .BigTableHeader span 

 {

	background: '.$big_table_header_bg_r.';	

	background-position: right top;

	background-repeat: no-repeat;

	padding: '.$table_padding.'px;

	display: block;

}



.TableBox .BigTableHeader span.Addspan {

	background: none;

	float: left;

}



.TableBox .BigTableHeader a.AddAddress {

	color: #fff;

	background: '.$add_address_button_bg.';

	padding: '.$add_address_button_padding.'px;

	text-decoration: none;

	cursor: pointer;

	float: right;

	font-size: '.$product_text_size.'px;

}





.TableForm .TableValue .ValueContent {

	float: left;

	padding-left: '.$table_padding.'px;



}



.TableForm .TableValue .ValueInput {

	float: left;

	clear: left;

	padding-right: '.$table_padding.'px;

	display: block;



}



.TableForm .TableValue .ValueInput input {

	margin: 0px;

}



.TableBox .TableParam{

	width: '.$table_param_width.'px;

	font-weight: '.$table_param_bold.';

	color: '.$table_param_color.';

}



.LeftSection .TableBox .TableParam {

	padding-left: 21px;

	width: 1%;

}



.RightSection .TableBox .TableParam {

	padding-left: 21px;

	width: 1%;

}



.TableBox .TableValue{

	font-weight: '.$table_value_bold.';

	color: '.$table_value_color.';

}



.TableBox .odd {

	background: '.$table_row_bg_odd.';

}



.TableBox .even {

	background: '.$table_row_bg_even.';

}



.TableForm {

	width: 100%;

}



.TableForm td {

	padding: '.$table_padding.'px;

	font-size: '.$table_font_size.'px;

}



.TableForm .TableParam{

	width: '.$table_param_width.'px;

	font-weight: '.$table_param_bold.';	

}



.TableForm .TableValue{

	font-weight: '.$table_value_bold.';	

}



.FormMessage {

	padding: '.$table_padding.'px;

	font-size: '.$message_size.'px;

	color: '.$message_color.';

	font-weight: '.$message_bold.';

}



.TableForm .TableChapter{

	font-size: '.$table_chapter_size.'px;

	color: '.$table_chapter_color.';

	font-weight: '.$table_chapter_bold.';	

	background: '.$table_chapter_bg.';

}



.cartpopup {

	color:'.$note_color.';

	font-size: '.$note_size.'px;

	margin-left:-126px;

	margin-top:-1px;

	position:absolute;

	text-align:left;

	font-weight: normal;

}



.topcart {

	background: '.$carttop_bg.';

	background-position: top right;

	background-repeat: no-repeat;

}



.leftcart {

	background-color: #fff;

	border-left: 1px solid #e0e0e0;

	border-top: 1px solid #e0e0e0;

	padding-left: '.$cartbox_padding.'px;

}



.rightcart {

	background: '.$carttable_bg.';

	padding-right: '.$cartbox_padding.'px;

}



.cartbottom {

	background: '.$cartbottom_bg.';

	background-position: bottom right;

	height: '.$column_space.'px;

	padding-right: '.$cartbox_padding.'px;

	float: right;

	width: '.$cartbox_padding.'px;

}



.cartbottommiddle {

	background: '.$cartbottom_bg.';

	background-position: bottom left;

	height: '.$column_space.'px;

}



.cartbottom-l {

	background: '.$cartbottom_left_bg.';

	height: '.$column_space.'px;

	padding-left: '.$cartbox_padding.'px;

	float: left;

	width: '.$cartbox_padding.'px;

}



.tablebody {

	width: 247px;

}



/* .SCProductDetail {

	float: left;

}



.SCProductQuantity {

	text-align: right;

	float: right;

} */



.Totals {

	border-top: 1px solid '.$note_color.';

}



.inactive .cartinfo_delete {

	display: none;

}



.active .cartinfo_delete {

	float: right;

	margin-top: 2px;

	margin-right: 5px;

	cursor: pointer;

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



#RightColumn .LatestProductDesc .Price, #RightColumn .ContentRightBoxI .bundleSave {

	color:'.$website_color.';

}



.error{

	color:red;

}
.HomeWishlistTable {
	width:100%;
}
.HomeWishlistTitle {
	font-weight:bold;
	margin-top:15px;
}
#quickOrder {
	padding: 0 12px 12px;
	background-color:#f9f9f9!important;	
	margin:0 auto; 	
	position:absolute; 
	top: -65px; 
	left: 90px;
	z-index:999; 
	background-color:#CCCCCC; 
	border: 1px solid #000000; 
	width:430px;	
}

#quickorderclose {
	float:right;
}

#quickOrder .GeneralButton {
	margin-left:-2px;	
}

#quickOrder input[name=quickname], #quickOrder input[name=quickemail] {
	margin-right:5px;	
}
#quickOrder label[for=quickcnp] {
	margin-right:13px;
}
#quickOrder label[for=smsname] {
	margin-right:8px;	
}
#quickOrder label[for=smsfirstname] {
	margin-right:3px;	
	margin-left: 7px;
}
#quickOrder label[for=smsemail] {
    margin-left: 7px;
    margin-right: 26px;
}
#quickOrder label[for=smsphone] {
}

#quickOrder input {
	width:110px!important;	 
}
.wrapCloseOrder {
	position:relative;
}
';

?>