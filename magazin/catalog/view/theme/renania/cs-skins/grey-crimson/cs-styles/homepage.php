<?php
header("Content-type: text/css");

include ('./config.php');

echo '

/* Homepage Articles list - changes to the styles in mainstyle.css */

.homeArticle {
	width: 182px;
	margin: 0 2px;
	float: left;
	background: '.$homeArticle_bg.';
	min-height: 90px;
}
.homeArticle h4 {
	font-size: 12px;
	line-height: 20px;
	padding: 5px;
	background: '.$homeArticle_h4_bg.';
}
.homeArticle h4 a {
	text-decoration: none;
}
.homeArticle h5 a {
	font-size: 11px;
	text-transform: lowercase !important;
}
.homeArticle h5 {
	font-size: 12px;
	line-height: 18px;
	padding: 0 5px 5px 5px;
	color: '.$homeArticle_h5_fontColor.';
	font-weight: normal;
} 
h3.homeWLtitle {
	padding: 0;
	background: ;
	font-size: 12px;
	font-weight:bold;
	color: '.$h3homeWLtitle_fontColor.';
	height: 20px;
	border: none;
	margin-top: 10px;
}

.homeWLlist {
	border-top: '.$homeWLlist_border.';
	border-left: '.$homeWLlist_border.';
	font-size: 11px;
	width: 558px;
}
.homeWLlist th {
	color: '.$homeWLlist_th_fontColor.';
	background: '.$homeWLlist_th_bg.';
	padding: 5px 0 5px 5px;
	text-align: left;
}
.homeWLlist td {
	color: '.$homeWLlist_td_fontColor.';
	border-bottom: '.$homeWLlist_border.';
	border-right: '.$homeWLlist_border.';
	padding: 3px 3px 3px 3px;
	text-align: left;
	vertical-align: middle;
}
.homeWLlist .odd {
	background: '.$table_rowOdd.';
}
.homeWLlist .even {
	background: '.$table_rowEven.';
}

.homeWLlist td a {
	color: '.$homeWLlist_link_fontColor.';
}
.homeWLlist td a:hover {
	color: '.$homeWLlist_linkHover_fontColor.';
	text-decoration: none;
}




';
?>