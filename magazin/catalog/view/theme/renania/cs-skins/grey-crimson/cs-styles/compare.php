<?php
header("Content-type: text/css");
include ('./config.php');

echo '

body {
 	background: #fff;
 }

#ContentCompare {
 	padding: 0px 10px 0px 10px;
	background: '.$website_bg.';
	background-repeat: repeat-x;
}

#FooterCompare {
 	padding: 8px 10px 10px 10px;
 	background: '.$footer_bg.';
 	text-align: center;
}

#FooterCompare a {
	color: '.$footer_title_color.';
}
 
.AddProduct {
 	color: #000;
 	font-size: 10px;
 	text-align: center;
 	padding: 5px;
 	margin: 0px 0px 10px 0px;
 }

.AddProduct select {
 	font-size: 10px;
	background: #fff;
	padding: 3px;
} 

.AddProduct .TableValue ,.TableParam 
 {
	background:#fff !important;
 } 
.AddProduct .TableParam, 
.AddProduct .TableValue  {
	background:#fff !important;
 } 
 
/* .productpicture {
	float: none;
	padding: 10px 0px;
	text-align: center;
}

.productpicture img {
	margin-bottom: 10px;
} */

.Product {
	width: '.$product_width.'px;
}

.Product .ProductPicture {
	display: block;
	width: '.$product_width.'px;
	height: '.$product_height.'px;
}

.Product .ProductPic1Price {
	display: block;
	width: '.$product_1price_width.'px;
	height: '.$product_1price_width.'px;	
}

.Product .ProductPic1Price a {
	display: block;
	background: '.$product_1price_bg.';
	background-repeat: no-repeat;
	width: '.$product_1price_width.'px;
	height: '.$product_1price_height_ff.'px;	
	text-align: center;
	padding-top: '.$product_1price_topspace.'px;
}

.Product .ProductPic1Price a:hover {
	text-decoration: none;
}

.Product .ProductPic2Prices {
	display: block;
	width: '.$product_2prices_width.'px;
	height: '.$product_2prices_width.'px;	
}

.Product .ProductPic2Prices a {
	display: block;
	background: '.$product_2prices_bg.';
	width: '.$product_2prices_width.'px;
	height: '.$product_2prices_height_ff.'px;	
	text-align: center;
	padding-top: '.$product_2prices_topspace.'px;

}

.Product .ProductPic2Prices a:hover {
	text-decoration: none;
}

.Product .ProductNoLogin {
	display: block;
	width: '.$product_nologin_width.'px;
	height: '.$product_nologin_width.'px;	
}

.Product .ProductNoLogin a {
	display: block;
	background: '.$product_nologin_bg.';
	width: '.$product_nologin_width.'px;
	height: '.$product_nologin_height_ff.'px;	
	text-align: center;
	padding-top: '.$product_nologin_topspace.'px;

}

.Product .ProductNoLogin a:hover {
	text-decoration: none;
}

.Product .ProductNoPrice {
	display: block;
	width: '.$product_noprice_width.'px;
	height: '.$product_noprice_width.'px;

}

.Product .ProductNoPrice a {
	display: block;
	background: '.$product_noprice_bg.';
	background-repeat: no-repeat;
	width: '.$product_noprice_width.'px;
	height: '.$product_noprice_height_ff.'px;	
	text-align: center;
	padding-top: '.$product_noprice_topspace.'px;
}

.Product .ProductNoPrice a:hover {
	text-decoration: none;
}

.Product .ProductText {
	display: block;
	font-size: '.$product_text_size.'px;
	width: '.$product_text_width.'px;
	color: '.$product_text_color.';
	margin-left: '.$product_text_color_marginleft.'px;
	line-height: '.$product_text_size.'px;
}

.Product .ProductPriceOld {
	font-size: '.$product_priceold_size.'px;
	color: '.$product_priceold_color.';
	font-weight: '.$product_priceold_bold.';
	display: block;
}


.Product .ProductPrice {
	font-size: '.$product_price_size.'px;
	color: '.$product_price_color.';
	font-weight: '.$product_price_bold.';
	padding-top: '.$product_2prices_pricespace.'px;
	display: block;
}

.Product .ProductPrice sup {
	font-size: 9px; /* de modificat */
}

.Product .Stars,
#MiddleColumn #ProductInfo .Stars
 {
	text-align: center;
	height: '.$product_star_height.'px;
	width: '.$product_stars_width.'px;
	margin: 5px auto;
}

#MiddleColumn #ProductInfo .Stars {
	text-align: left;
	margin: 5px 0px;
	float: left;
}

.Product .Stars div,
#MiddleColumn #ProductInfo .Stars div {
	display: static;
	height: '.$product_star_height.'px;
	width: '.$product_star_width.'px;
	float: left;
}

.Product .FullStar,
#MiddleColumn #ProductInfo .FullStar {
	background: '.$product_fullstar_bg.';
	background-repeat: no-repeat;

}

.Product .HalfStar,
#MiddleColumn #ProductInfo .HalfStar {
	background: '.$product_halfstar_bg.';
	background-repeat: no-repeat;

}


.Product .EmptyStar,
#MiddleColumn #ProductInfo .EmptyStar {
	background: '.$product_emptystar_bg.';
	background-repeat: no-repeat;

}

.CompareValue {
	font-weight: bold;
}

/* .even .CompareTable {
	border-right: 2px solid '.$table_row_bg_odd.';
}

.odd .CompareTable {
	border-right: 2px solid '.$table_row_bg_even.';
} */
 
 
';
?>