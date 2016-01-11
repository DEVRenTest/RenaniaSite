<?php
header("Content-type: text/css");

include ('./config.php');

echo '

/* advanced wishlist module 
---------------------------
*/

div.WL p {
	font-size: 11px;
}

div.WL h1 {
	padding-bottom: 10px;
}

div.WL h3 {
	font-size: 12px;
	font-weight: bold;
	color: '.$WL_h3_fontColor.';
	padding: 10px 0;
}

div.WL hr {
	font-size: 1px;
	line-height: 1px;
	margin: 5px 0;
	padding: 0;
	background: #ddd;
	border: none !important;
	width: 100%;
	height: 1px;
}

*:first-child+html div.WL hr {
	margin: 0;
}

div.WL .ratingspace {
	float: right;
	padding: 10px 0;
}

div.WL .ratingspace p {
	float: left;
	margin: 0px;
}

table.WLList, 
table.WLCommentAdd {
	margin: 0;
	padding: 0;
	border: none;
	width: 100%;
	color: #000;
}

table.WLList th {
	background: '.$WLList_th_bg.';
	color: '.$WLList_th_fontColor.';
	text-align: center;
	padding: 3px;
	font-size: 11px;
	border-bottom: '.$WLList_border.';
	border-right: '.$WLList_border.';
	font-weight: normal;
}
table.WLList td {
	padding: 3px;
	text-align: center;
	vertical-align: middle;
}
table.WLList {
	border-left: '.$WLList_border.';
	border-top: '.$WLList_border.';
	font-size: 11px;
}
table.WLList td {
	border-bottom: '.$WLList_border.';
	border-right: '.$WLList_border.';
	background: '.$WLList_td_bg.' !important;
}

table.WLCommentAdd td {
	padding: 3px;
}

.WLdescription {
	padding: 0 0 10px 0;
	line-height: 15px;
}

.WLproductpic img {
	width: 50px;
}

.WLcomments td {
	
}

.WLcomments .commentName {
	background: url(../cs-images/comment-namebg.jpg) no-repeat top right;
	width: 90px;
}

* html .WLcomments .commentName {
	width: 80px !important;
}

*:first-child+html .WLcomments .commentName {
	width: 90px !important;
}

.WLcomments .commentName p {
	color: #555;
}
.WLcomments .commentContentTop {
	background: url(../cs-images/comment-contenttop.jpg) no-repeat top left;
}

.WLcomments .commentContentBottom {
	background: url(../cs-images/comment-contentbottom.jpg) no-repeat top left;
	height: 8px;
	width: 100%;
}

.WLcommTitle {
	font-weight: bold;
	color: #2583ad;
	padding: 8px;
	
}

.WLcommText {
	color:#777;
	line-height: 15px;
	padding: 8px;
	background: url(../cs-images/comment-contentbg.jpg) repeat-y top left;
	padding-top: 0;
	padding-bottom: 0;
}

.WLcommDate {
	color: #666;
	font-size: 10px;
	font-weight: normal;
}

.WLadd .input_text,
.WLCommentAdd .input_text {
	width: 230px;
}


.WLlisting {
	border-left: '.$WLList_border.';
	border-top: '.$WLList_border.';
	font-size: 11px;
	color: #000;
}

.WLlisting th {
	font-size: 10px;
	text-align: center;
	padding: 5px 3px 5px 5px;
	border-bottom: '.$WLList_border.';
	border-right: '.$WLList_border.';
	color: '.$WLList_th_fontColor.';
	background: '.$WLList_th_bg.';
}
.WLlisting td {
	padding: 5px 3px;
	border-bottom: '.$WLList_border.';
	border-right: '.$WLList_border.';
	text-align: center;
	vertical-align: middle;
	background:'.$WLList_td_bg.';
}

.grandTotal {
	font-size: 16px;
	font-weight: bold;
	color: '.$product_detail_price_color.';
}

.WL #SubHeader {
	background: '.$header_search_bg.';
	height: '.$header_search_height.'px;
	width: '.$header_search_width.'px;
	font-size: '.$header_search_size.'px;
	font-weight: '.$header_search_bold.';
}

.WL #SubHeader select {
	font-size: 10px;
}
.WL #SubHeader td {
	padding: 0;
	text-align: left;
}

.WL .WishlistTotal {
	color: '.$product_detail_price_color.';
	font-weight: bold;
}

.WLadd td {
	vertical-align: middle;
	font-size: 11px;
}

.WLadd select {
	font-size: 11px;
}

.WLadd .GeneralButton {
	padding-top: 6px !important;
}

.WL .odd {
	background: '.$table_rowOdd.';
}
.WL .even {
	background: '.$table_rowEven.';
}
.WLlisting a {
	color: '.$WLList_link_fontColor.';
}

.rstars img {
	margin-left: -3px;
}

.rstars span {
	padding-top: 4px;
	float: left;
}

div.WL .TableBox .WishlistBottom p {
	margin: 0px;
}

div.WL .TableBox .WishlistBottom p.recomanda {
	float: right;
}

div.WL .TableBox .WishlistBottom p.goleste {
	float: left;
}

';
?>