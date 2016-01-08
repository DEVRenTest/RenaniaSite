<?php
header("Content-type: text/css");
include ('./config.php');

echo '

#Header #cart a span {
	line-height: 16px;
}

button {
	padding-bottom: 2px;
}

#HeaderLinks #HeaderTabs {
	line-height: 12px;
}

#MiddleColumn #ProductsTop .HomeWishlistTable td.FirstColumnLast {
	line-height: 17px;
}

.TableBox tr {
	position: relative;
}

.TableForm .TableHeader td,
.TableBox .TableHeader td,
.TablePlaceOrder .TableHeader td {
	background-image: none;
	background-position: 0 20%;
}

.PageNumbers .PageOn {
	line-height: 13px;
}

.PageNumbers a {
	line-height: 13px;
}


';
?>