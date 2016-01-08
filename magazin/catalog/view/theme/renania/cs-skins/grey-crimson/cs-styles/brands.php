<?php
header("Content-type: text/css");
include ('./config.php');

echo '
#BreadCrumbs {
	font-size: '.$breadcrumbs_size.'px;
	line-height: '.$breadcrumbs_size.'px;
	background: '.$breadcrumbs_detail_bg.';	
	background-repeat: no-repeat;
	background-position: right top;
}
';

?>