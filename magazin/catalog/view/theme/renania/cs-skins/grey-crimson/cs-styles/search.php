<?php
header("Content-type: text/css");
include ('./config.php');

echo '


.AdvancedSearch td {
	padding-bottom: 10px;
	font-size: 11px;
}

.AdvancedSearch td.Title {
	padding-top: 5px;
	padding-bottom: 3px;
}

.AdvancedSearch td select
 {
	width: '.$adv_search_width.'px;
}

.AdvancedSearch .InputText
 {
	width: '.$adv_search_width_i.'px;
}

h3 {
	text-align: left;
	padding: '.$column_space.'px;
	padding-left: '.$breadcrumbs_padding.'px;
}

.Product h3 {
	font-size: 12px;
	font-weight: normal;
	text-align: center;
	margin: 0px;
	padding-top: 0px;
	padding-bottom: 15px;
	
}

.CategoryLink {
	display: block;
	float: left;
	width: '.$categorylink_width.'px;
	padding: '.$table_padding.'px;
}

';
?>