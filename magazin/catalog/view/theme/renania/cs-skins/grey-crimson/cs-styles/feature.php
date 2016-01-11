<?php
header("Content-type: text/css");
include ('./config.php');

echo '
h1 {
	margin: 0px;
	padding-left: 5px;
	padding-top: 5px;
	padding-bottom: 5px;
}

h2 {
	margin-left: 5px;
	text-align: left;
}

h3 {
	margin-top: 5px;
	margin-left: 5px;
	text-align: left;
	display: block;
	margin-bottom: '.$column_space.'px;
}

h3 img {
	float: right;
}

.Product h2 {
	text-align: center;
	font-weight: bold;
}
.Product h3 {
	text-align: center;

}
 ';
 ?>