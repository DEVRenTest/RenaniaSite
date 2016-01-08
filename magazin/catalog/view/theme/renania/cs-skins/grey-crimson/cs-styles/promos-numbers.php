<?php
header("Content-type: text/css");
include ('./config.php');

echo '

/* begin styles */

.MainPromoTitleBox {
	height: 33px;
	line-height: 32px;
	background: url(../cs-images/promobg.gif) no-repeat top left;
}
.MainPromoTitleBox span {
	padding-left: 8px;
	color: #fff;
	font-weight: bold;
}
#promosContainer {
 	margin-top: 0px;
	width: 560px;
	height: 200px;
	text-align: right;
	overflow: hidden;
}
.promoPic {
	float: left;
}
.promoPic img {
	width: 560px;
}
.promosNav {
	list-style-type:none;
	height: 32px;
	font-family: Arial;
	margin-bottom: 10px;
	margin-top: -32px;
	margin-left: 0;
	position: relative;
	padding-left: 8px;
}

#promoItem {
	height: 200px;
	background: url(../cs-images/promobg.gif) no-repeat bottom left;
}

*:first-child+html .promosNav {
	margin-left: 20px;
}

.promosNav li {
	margin-right: 3px;
	background:url(../cs-images/promoTab-off.png) no-repeat top right;
	cursor: pointer;
	float:left;
}
.promosNav li a {
	width: 22px;
	height: 22px;
	display: block;
	text-align: center;
	line-height: 26px;
}
.promosNav li a span {
	display: none;
	font-weight: normal;
	color: '.$promos_link_color.';
}
.promosNav li.current {
	background:url(../cs-images/promoTab-on.png) no-repeat top right;
}

* html .promosNav li.current {
	width: 22px;
}

.promosNav li.current a {
	color:'.$promos_link_hover_color.';
	font-weight:bold;
}
.promosNav li.current a span {
	font-weight:bold;
  color:'.$promos_link_hover_color.';
}


/* end styles */

';
?>