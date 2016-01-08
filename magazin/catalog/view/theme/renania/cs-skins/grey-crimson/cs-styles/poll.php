<?php
header("Content-type: text/css");
include ('./config.php');

echo '

.FilledBar {
 	background: '.$FilledBar_bg.' ;
 	border: '.$FilledBar_border.';
 	padding: 2px;
 	font-weight: normal;
 	font-size: 11px;
 	color: '.$FilledBar_fontColor.';
 	margin: 0px;
 	display: block;
 	float: left;
 }
 
.EmptyBar {
 	background: '.$EmptyBar_bg.';
 	padding: 2px;
 	font-size: 11px;
 	color: '.$EmptyBar_fontColor.';
 	border: '.$EmptyBar_border.';
 	text-align: right;
 	margin: 0px;
 	display: block;
 	float: left;
 } 
 
.PollTitle {
 	font-weight: bold;
 	font-size: 12px;
 	margin: 10px 0px 0px 0px;
 }
 
.PollDate {
 	font-size: 11px;
 	margin: 5px 0px 10px 0px;
 }
 
 .pollTable {
 	margin-top: 3px;
 	font-size: 11px;
 }
  .pollTable td {
  height: 13px !important;
  overflow: hidden;
  	}
 
 ';
?>