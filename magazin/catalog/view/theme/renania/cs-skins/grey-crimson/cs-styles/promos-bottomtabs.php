<?php
header("Content-type: text/css");
include ('./config.php');

echo '

/* begin styles */
#promosContainer {
	margin-top: 0px;
	width: 550px;
	margin-left: 2px;
	height: 290px;
	text-align: right;
	overflow: hidden;
}
.promoPic {
	float: left;
}

.promosNav {
	width:550px;
	list-style-type:none;
	position: absolute;
	top:377px !important;
	height: 64px;
	font-family: Arial, Helvetica, sans-serif;
	margin-bottom:0px;
	margin-left: 3px;
}
*:first-child+html .promosNav {
	margin-left: 0px;
}
.promosNav li {
	width: 261px;
	height: 31px;
	float: left;
	margin-right: 3px;
	margin-top:3px;
	/*background:#000;*/
	cursor: pointer;
	background: url("../cs-images/promotab_on.gif") no-repeat top left;
	padding: 0px 0px 0px 10px;
	line-height: 30px;
}
.promosNav li a {
	text-decoration:none;
	color:#000;
	font-family: Arial, Helvetica, sans-serif;
	font-size:11px;
	display: block;
	font-weight: bold;
	outline: none;
	height: 30px;
	width: 230px;
	overflow: hidden;
}
.promosNav li a span {
	font-weight: normal;
	color: #9c9c9c;
}
.promosNav li.current {
	background:#fff;
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