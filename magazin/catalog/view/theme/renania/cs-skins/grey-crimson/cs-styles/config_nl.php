<?php

// ---- general elements
//echo SITEURL;
//echo $skin;
$website_bg = "#FFFFFF";
$website_family = "Arial";
$light_background_font_color = "#000000";
$dark_background_font_color = "ffffff";
$logo = SITEURL."cs-skins/".CS_CURRENT_SKIN."/cs-images/headerimages/logo.png";
$links_color = "20528f";


//-----  promo


$promo_height = 247;  // --- get out from image size
$promo_bg = "url(".SITEURL."cs-skins/".CS_CURRENT_SKIN."/cs-images/newsletter/promo_bg.gif) no-repeat top center";
$promo_button = SITEURL."cs-skins/".CS_CURRENT_SKIN."/cs-images/newsletter/promobutton.gif";
$promo_text_height = 110;  // --- should be related to promo_height somehow

//  -------  product listing

$product_box_bg = "url(".SITEURL."cs-skins/".CS_CURRENT_SKIN."/cs-images/newsletter/product.png) no-repeat top center";
$product_box_width = 180;  // --- for determining the number of products per row
$product_picture_height = 127;  // 
$product_price_height = 25;    //  --- these three values should vary depending on the product-box height AND it's design???
$product_title_height = 55;   //
$price_color = "ffffff";

//  -------  articles

$articles_header_bg = "url(".SITEURL."cs-skins/".CS_CURRENT_SKIN."/cs-images/newsletter/articles_bg.gif) no-repeat top center";

// ------ footer

$footer_bg = "url(".SITEURL."cs-skins/".CS_CURRENT_SKIN."/cs-images/newsletter/footer_bg.gif) repeat-x top left";
$address = "Bd. Banu Manta, nr.21, bl.35, sc.B, ap.65, sector 1, Bucuresti";
$phone_no = "031 107 1801";
$fax_no = "031 107 1801";
$email = "office@upgrades.ro";

?>
