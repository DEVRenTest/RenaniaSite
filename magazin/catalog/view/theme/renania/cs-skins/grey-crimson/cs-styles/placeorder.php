<?php
header("Content-type: text/css");
include ('./config.php');

echo '

#MiddleColumn {
	width: '.$website_width.'px;
}

.FinishedOrderTextBox {
	float: left;
	margin: '.$column_space.'px;
	height: '.$finishedorderbox_height.'px;
}

 ';
?>