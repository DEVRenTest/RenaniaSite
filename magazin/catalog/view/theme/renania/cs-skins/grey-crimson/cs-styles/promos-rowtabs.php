<?php
header("Content-type: text/css");
include ('./config.php');

echo '

/* begin styles */
#promosContainer {
	margin-top: 0px;
	width: 568px;
	height: 193px;
	text-align: right;
	overflow: hidden;
	border-top: solid 1px #318bba;
	border-left: solid 1px #318bba;
	border-right: solid 1px #318bba;
}
.promoPic {
	float: left;
}

.promosNav {
	border-top: solid 1px #318bba;
	width:570px;
	list-style-type:none;
	/*position: absolute;
	top:41px !important;*/
	height: 28px;
	font-family: Tahoma, Arial, Helvetica, sans-serif;
	margin-bottom:10px;
}

*:first-child+html .promosNav {
	margin-left: 0px;
}

.promosNav li {
	width: 82px;
	height: 28px;
	float: left;
	margin-right: 3px;
	margin-top:-1px;
	cursor: pointer;
	background: transparent url("../cs-images/itm-imagini/but_promo_off.jpg") top left no-repeat;
	padding: 0px 0px 0px 10px;
	line-height: 26px;
}
.promosNav li a {
	text-decoration:none;
	color:#fff;
	font-family: Tahoma, Arial, Helvetica, sans-serif;
	font-style:normal;
	font-size:10px;
	display: block;
	font-weight: bold;
	outline: none;
	height: 28px;
	width: 74px;
	overflow: hidden;
}
.promosNav li a span {
	font-weight: normal;
	color: #9c9c9c;
}
.promosNav li.current {
	background: transparent url("../cs-images/itm-imagini/but_promo_on.jpg") top left no-repeat !important;
}
.promosNav li.current a {
	color:#000;
}
.promosNav li.current a span {
	font-weight: normal;
	color:#000;
}



/* end styles */

';
?>