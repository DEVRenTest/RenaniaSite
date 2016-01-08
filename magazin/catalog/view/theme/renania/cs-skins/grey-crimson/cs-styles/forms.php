<?php
header("Content-type: text/css");
include ('./config.php');

echo '
h1 {
	padding: '.$table_padding.'px;
}
h2 {
	margin-left: '.$table_padding.'px;
	text-align: left;
}
h3 {
	margin-left: '.$table_padding.'px;
	text-align: left;
	padding-top: '.$table_padding.'px;
}
 ';
 ?>