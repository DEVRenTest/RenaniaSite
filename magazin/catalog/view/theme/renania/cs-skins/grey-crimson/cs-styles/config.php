<?php
//die('wtf');

// if an element doesn't have a background set the value to 'none', do not leave the value blank

// ========== new

// ---- general elements

$website_bg = "#FFFFFF  url(../cs-images/mainimages/website_bg.gif)"; //updated by configurator
$website_family = "Arial";
$website_size = 12;
$website_color = "#333333";
$website_width = 981;

$link_color = '#000000';
$link_color_hover = '#000000';
$link_underline = 'none';
$link_underline_hover = 'underline';

$column_left_width = 180;
$column_right_width = 190;
$column_space = 13;
$column_middle_width = $website_width-$column_left_width-$column_right_width-2*$column_space;
$column_middle_width_detail = $column_middle_width+$column_space+$column_right_width;

$input_border_width = 1;
$input_border_color = "#999999";
$input_bg = "none";
$input_family = "Arial"; // b: replace with $website_family
$input_size = 11; 
$input_color = "#333333"; // b: replace with $website_color
$input_space = 3; 
$input_bold = 'normal';
$input_background = '#ffffff';

$button_bg = "url(../cs-images/mainimages/generalbutton.gif)";
$button_bg_r = "url(../cs-images/mainimages/generalbutton_r.gif)";
$button_height = 19; // auto from image size (pic height / 2)

$button_size = 11;
$button_color = "#FFFFFF";
$button_bold = "normal";
$button_style = "none";

$button_bottom_margin = ($button_height - $button_size)/2; // not editable

$small_thumbnail_bg = "url(../cs-images/products/smallthumbnail.gif)";
$small_thumbnail_width = 62; // auto from image size
$small_thumbnail_height = 62; // auto from image size


// ---- header links element

$headerlinks_height = 34;
$headerlinks_size = 11;
$headerlinks_padding = ($headerlinks_height-$headerlinks_size)/2; // not editable
$headerlinks_family = "Arial"; // b: replace with $website_family

$headerlinks_text_color = $website_color;

$headerlinks_color = $links_color;
$headerlinks_color_hover = $links_color;
$headerlinks_underline = 'none'; // b: replace with $link_underline
$headerlinks_underline_hover = 'underline'; // b: replace with $link_underline_hover

$headertab_off_bg = "none";
$headertab_off_color = $link_color; // b: replace with $link_color
$headertab_off_size = "11px"; // b: replace with $headerlinks_size
$headertab_off_bold = "normal"; 
$headertab_off_width = ""; // get auto from bg image

$headertab_on_bg = "url(../cs-images/headerimages/tab_on.gif)";
$headertab_on_color = $link_color; // b: replace with $link_color
$headertab_on_size = "11px"; // b: replace with $headerlinks_size
$headertab_on_bold = "bold";
$headertab_on_width = 66; // get auto from bg image

// ---- header element

$header_bg = "none";

$logo_bg = "url(../cs-images/headerimages/logo.png)"; 
$logo_bg_hover = "url(../cs-images/headerimages/logo.png)"; 
$logo_width = $column_left_width; // resize logo at this width if is bigger
$logo_height = 61; // auto from image size


$header_facilities_width = $column_middle_width; 

$header_search_bg = "url(../cs-images/headerimages/search_bg.gif)"; 
$header_search_width = 585; //auto from image size
$header_search_height = 47; // auto from image size
$header_search_size = 11;
$header_search_bold = "bold";

$header_login_bg = "url(../cs-images/headerimages/search_bg.gif)"; // b: replace with $header_search_bg 

$header_search_padding = ($header_search_height-$input_size-19)/2; // not editable

$header_tab_size  = 11; 
$header_tab_margin = 5;
$header_tab_margin_left = 8;

$header_tab_bg  = "none"; 
$header_tab_color  = "#000000"; 
$header_tab_bold = "normal"; 

$header_tab_bg_on  = "none"; 
$header_tab_color_on  = "#000000"; 
$header_tab_bold_on = "normal"; 
$header_tab_underline_on = "underline"; 

$header_tab_bg_selected  = "none"; 
$header_tab_color_selected  = "#000000"; 
$header_tab_bold_selected = "bold"; 

$header_sctitle_bg = "url(../cs-images/headerimages/cart-icon.gif) no-repeat center left";
$header_sctitle_size = 11; // b: replace with $header_tab_size
$header_sctitle_color = "#000000";
$header_sctitle_bold = "bold"; 
$header_sctitle_margin = 5; // b: replace with $header_tab_margin
$header_sctitle_margin_left = 30; // b: replace with $header_tab_margin_left

$header_sc_off_bg = "url(../cs-images/headerimages/shoppingcart_bg.gif)"; 
$header_sc_on_bg = "url(../cs-images/headerimages/shoppingcart_bg_on.gif)"; 
$header_sc_size = 11;
$header_sc_bold = "normal";

$header_sc_width = 190; // auto from image size
$header_sc_height = 47; // auto from image size

$header_sc_off_color = "#000000";
$header_sc_on_color = "#000000";

$header_sc_padding = $header_search_padding; // not editable
$header_sc_text_width = 140;

// ---- boxes

$categories_title_bg_l = "url(../cs-images/boxesimages/categories_l.gif)";
$categories_title_bg_r = "url(../cs-images/boxesimages/categories_r.gif)";
$categories_title_height = 30; // auto from image size
$categories_title_size = 14;

$categories_title_padding = ($categories_title_height-$categories_title_size)/2; // not editable

$categories_title_color = "#FFFFFF";
$categories_title_bold = "normal";

$categories_row_height = 26; // auto from image size
$categories_row_size = 12;
$categories_row_padding = ($categories_row_height-$categories_row_size)/2; // not editable

$subcategories_row_height = 18; // auto from image size
$subcategories_row_size = 11;
$subcategories_row_padding = ($subcategories_row_height-$subcategories_row_size)/2; // not editable
$subcategories_row_indent = 15;

$subcategories_row_bg_l = "url(../cs-images/boxesimages/subcategories_row_l.gif)";
$subcategories_row_bg_r = "url(../cs-images/boxesimages/subcategories_row_r.gif)";

$subcategories_row_bg_l3 = "url(../cs-images/boxesimages/subcategories_row_l3.gif)";
$subcategories_row_bg_r3 = "url(../cs-images/boxesimages/subcategories_row_r3.gif)";

$subcategories_row_color = "#000";
$subcategories_row_bold = "normal";

$subcategories_row_bg_l_selected = "url(../cs-images/boxesimages/subcategories_row_l_selected.gif)";
$subcategories_row_bg_r_selected = "url(../cs-images/boxesimages/subcategories_row_r_selected.gif)";

$subcategories_row_bg_l_selected3 = "url(../cs-images/boxesimages/subcategories_row_l_selected3.gif)";
$subcategories_row_bg_r_selected3 = "url(../cs-images/boxesimages/subcategories_row_r_selected3.gif)";

$subcategories_row_color_selected = "#c70505";
$subcategories_row_bold_selected = "bold";
$subcategories_row_underline_selected = "none";

$depth2_padding = $categories_row_padding+$subcategories_row_indent; // not editable
$depth3_padding = $categories_row_padding+$subcategories_row_indent*2; // not editable
$depth4_padding = $categories_row_padding+$subcategories_row_indent*3; // not editable
$depth5_padding = $categories_row_padding+$subcategories_row_indent*4; // not editable

$subcategories_row_bg_l_on = "url(../cs-images/boxesimages/subcategories_row_l_on.gif)";
$subcategories_row_bg_r_on = "url(../cs-images/boxesimages/subcategories_row_r_on.gif)";

$subcategories_row_bg_l_on3 = "url(../cs-images/boxesimages/subcategories_row_l_on3.gif)";
$subcategories_row_bg_r_on3 = "url(../cs-images/boxesimages/subcategories_row_r_on3.gif)";

$subcategories_row_color_on = "#FFFFFF";
$subcategories_row_bold_on = "normal";
$subcategories_row_underline = 'none';

$categories_row_bg_l = "url(../cs-images/boxesimages/categories_row_l.gif)";
$categories_row_bg_r = "url(../cs-images/boxesimages/categories_row_r.gif)";
$categories_row_color = "#000000";
$categories_row_bold = "bold";

$categories_row_bg_l_on = "url(../cs-images/boxesimages/categories_row_l_on.gif)";
$categories_row_bg_r_on = "url(../cs-images/boxesimages/categories_row_r_on.gif)";
$categories_row_color_on = "#000000";
$categories_row_bold_on = "bold";
$categories_row_underline_on = "none";

$categories_row_bg_l_latest = "url(../cs-images/boxesimages/categories_row_l_latest.gif)";
$categories_row_bg_r_latest = "url(../cs-images/boxesimages/categories_row_r_latest.gif)";
$categories_row_bg_l_vouchers = "url(../cs-images/boxesimages/categories_row_l_vouchers.gif)";
$categories_row_bg_r_vouchers = "url(../cs-images/boxesimages/categories_row_r_vouchers.gif)";
$categories_row_color_latest = "#ffffff";
$categories_row_bold_latest = "bold";
$categories_row_underline_latest = "none";

$categories_row_bg_l_latest_on = "url(../cs-images/boxesimages/categories_row_l_latest_on.gif)";
$categories_row_bg_r_latest_on = "url(../cs-images/boxesimages/categories_row_r_latest_on.gif)";
$categories_row_bg_l_vouchers_on = "url(../cs-images/boxesimages/categories_row_l_latest_on.gif)";
$categories_row_bg_r_vouchers_on = "url(../cs-images/boxesimages/categories_row_r_latest_on.gif)";
$categories_row_color_latest_on = "#ffffff";
$categories_row_bold_latest_on = "bold";
$categories_row_underline_latest_on = "underline";

$categories_row_bg_l_selected = "url(../cs-images/boxesimages/categories_row_l_selected.gif)";
$categories_row_bg_r_selected = "url(../cs-images/boxesimages/categories_row_r_selected.gif)";
$categories_row_color_selected = "#c70505";
$categories_row_bold_selected = "bold";
$categories_row_underline_selected = "none";

$categories_row_bg_l_latest_selected = "url(../cs-images/boxesimages/categories_row_l_l_selected.gif)";
$categories_row_bg_r_latest_selected = "url(../cs-images/boxesimages/categories_row_r_l_selected.gif)";
$categories_row_color_latest_selected = "#c70505";
$categories_row_bold_latest_selected = "bold";
$categories_row_underline_latest_selected = "none";

$list_row_height = 26; // auto from image size
$list_row_size = 12;
$list_row_padding = ($list_row_height-$list_row_size)/2; // not editable

$list_row_bg_l_first = "url(../cs-images/boxesimages/list_row_l_first.gif)";
$list_row_bg_r_first = "url(../cs-images/boxesimages/list_row_r_first.gif)";
$list_row_color_first = '#000000';
$list_row_bold_first = 'normal';

$list_row_bg_l_first_on = "url(../cs-images/boxesimages/list_row_l_first_on.gif)";
$list_row_bg_r_first_on = "url(../cs-images/boxesimages/list_row_r_first_on.gif)";
$list_row_color_first_on = '#000000';
$list_row_bold_first_on = 'normal';
$list_row_underline_first_on = 'none';

$list_row_bg_l_selected = "url(../cs-images/boxesimages/list_row_l_selected.gif)";
$list_row_bg_r_selected = "url(../cs-images/boxesimages/list_row_r_selected.gif)";
$list_row_color_selected = '#000000';
$list_row_bold_selected = 'normal';


$list_row_bg_l = "url(../cs-images/boxesimages/list_row_l.gif)";
$list_row_bg_r = "url(../cs-images/boxesimages/list_row_r.gif)";
$list_row_color = '#000000';
$list_row_bold = 'normal';

$list_row_bg_l_on = "url(../cs-images/boxesimages/list_row_l_on.gif)";
$list_row_bg_r_on = "url(../cs-images/boxesimages/list_row_r_on.gif)";
$list_row_color_on = '#000000';
$list_row_bold_on = 'normal';
$list_row_underline_on = 'none';

$list_row_bg_l_selected = "url(../cs-images/boxesimages/list_row_l_selected.gif)";
$list_row_bg_r_selected = "url(../cs-images/boxesimages/list_row_r_selected.gif)";
$list_row_color_selected = '#000000';
$list_row_bold_selected = 'normal';




$list_row_bg_l_latest = "url(../cs-images/boxesimages/list_row_l_latest.gif)";
$list_row_bg_r_latest = "url(../cs-images/boxesimages/list_row_r_latest.gif)";
$list_row_color_latest = '#000000';
$list_row_bold_latest = 'normal';

$list_row_bg_l_latest_on = "url(../cs-images/boxesimages/list_row_l_latest_on.gif)";
$list_row_bg_r_latest_on = "url(../cs-images/boxesimages/list_row_r_latest_on.gif)";
$list_row_color_latest_on = '#000000';
$list_row_bold_latest_on = 'normal';
$list_row_underline_latest_on = 'none';

$list_row_bg_l_selected = "url(../cs-images/boxesimages/list_row_l_selected.gif)";
$list_row_bg_r_selected = "url(../cs-images/boxesimages/list_row_r_selected.gif)";
$list_row_color_selected = '#000000';
$list_row_bold_selected = 'normal';


$box_title_bg_l = "url(../cs-images/boxesimages/box_l.gif)";
$box_title_bg_r = "url(../cs-images/boxesimages/box_r.gif)";
$box_title_height = 30; // auto from image size
$box_title_size = 14;

$box_title_padding = ($box_title_height-$box_title_size)/2; // not editable

$box_title_color = $link_color;
$box_title_bold = "normal";

$box_content_bg_l = "url(../cs-images/boxesimages/box_content_l.gif)";
$box_content_bg_r = "url(../cs-images/boxesimages/box_content_r.gif)";

$box_content_padding = $box_title_padding; // not editable

$box_content_size = 11;
$box_content_color = "#000000";
$box_content_bold = "normal";

$box_input_width = 155;


$box_right_title_bg_l = "url(../cs-images/boxesimages/box_right_l.gif)";
$box_right_title_bg_r = "url(../cs-images/boxesimages/box_right_r.gif)";
$box_right_title_height = 39; // auto from image size
$box_right_title_size = 14;
$box_right_title_align = "center";

$box_right_title_padding = ($box_right_title_height-$box_right_title_size)/2; // not editable

$box_right_title_color = "#000000";
$box_right_title_bold = "normal";

$box_right_content_bg_l = "url(../cs-images/boxesimages/box_right_content_l.gif)";
$box_right_content_bg_r = "url(../cs-images/boxesimages/box_right_content_r.gif)";

$box_right_content_padding = $box_right_title_padding; // not editable

$box_right_content_size = 12;
$box_right_content_color = "#000000";
$box_right_content_bold = "normal";

$box_right_input_width = 155;

$special_product_picture_width = 136;
$special_product_picture_height = 136;
$special_product_price = "url(../cs-images/boxesimages/right_box_price.png)";
$special_product_width = 61;
$special_product_height = 61;
$special_product_top =76;
$special_product_left = 76;
$special_product_size = 16;
$special_product_bold = "bold";
$special_product_color = "#FFFFFF";
$special_product_padding_top = $special_product_top+($special_product_height-$special_product_size)/2; // not editable

$special_product_name_size = 12;
$special_product_name_bold = "bold";
$special_product_name_color = $link_color;

$special_product_desc_size = 12;
$special_product_desc_bold = "normal";
$special_product_desc_color = "#000000";

if ($box_right_title_align == 'center') {
	$special_product_margin_left = ($column_right_width-$box_right_title_padding*2-$special_product_picture_width)/2;
}

$latest_products_size = 11;
$latest_products_bold = "bold";
$latest_products_color = "#000000";
$latest_products_width = $column_right_width-$box_right_title_padding*2-$small_thumbnail_width-10;
$latest_products_vspace = 10;

$latest_products_price_size = 14;
$latest_products_price_bold = "bold";
$latest_products_price_color = "#c70505";


// -- product

$product_title_size = 14;
$product_title_color = "#000000";
$product_title_bold = "normal";

$product_width = 146;
$product_height = 170;
$product_pic_width = 134;
$product_pic_height = 134;

$product_1price_width = $product_width;
$product_1price_height = $product_height;
$product_1price_topspace = 125;
$product_1price_pricespace = 4;
$product_1price_height_ff = $product_1price_height-$product_1price_topspace; // not editable
$product_1price_bg = "url(../cs-images/products/product.png)";

$product_2prices_width = $product_width;
$product_2prices_height = $product_height;
$product_2prices_topspace = 122;
$product_2prices_pricespace = 4;
$product_2prices_height_ff = $product_2prices_height-$product_2prices_topspace; // not editable
$product_2prices_bg = "url(../cs-images/products/product2prices.png)";

$product_nologin_width = $product_width;
$product_nologin_height = $product_height;
$product_nologin_topspace = 145;
$product_nologin_height_ff = $product_nologin_height-$product_nologin_topspace; // not editable
$product_nologin_bg = "url(../cs-images/products/productnologin.png)";


$product_noprice_width = $product_width;
$product_noprice_height = $product_height;
$product_noprice_topspace = 129;
$product_noprice_height_ff = $product_noprice_height-$product_noprice_topspace; // not editable
$product_noprice_bg = "url(../cs-images/products/productnoprice.png)";

$product_text_width = 90;
$product_text_size = 11;
$product_text_color = "#FFFFFF";
$product_text_color_marginleft = ($product_noprice_width-$product_text_width)/2;

$product_priceold_size = 11;
$product_priceold_color = "#333333";
$product_priceold_bold = "normal";

$product_price_size = 16;
$product_price_color = "#FFFFFF";
$product_price_bold = "bold";

$product_fullstar_bg = "url(../cs-images/products/fullstar.gif)";
$product_halfstar_bg = "url(../cs-images/products/halfstar.gif)";
$product_emptystar_bg = "url(../cs-images/products/emptystar.gif)";

$product_star_width = 20; // auto from image size
$product_star_height = 20; // auto from image size

$product_stars_width = $product_star_width*5; // not editable

$home_wishlist_title_bg_r = "url(../cs-images/wishlist/homewishlisttitler.gif)";
$home_wishlist_title_bg_l = "url(../cs-images/wishlist/homewishlisttitlel.gif)";

$home_wishlist_title_size = 14;
$home_wishlist_title_color = "#ffffff";
$home_wishlist_title_bold = "normal";


$home_wishlist_title_height = 30; // auto from image size
$home_wishlist_title_padding = ($home_wishlist_title_height-$home_wishlist_title_size)/2; // not editable

$home_wishlist_row_bg = "url(../cs-images/wishlist/wishlist_row_bg.gif)";
$home_wishlist_row_bg_l = "url(../cs-images/wishlist/wishlist_row_bg_l.gif)";
$home_wishlist_row_bg_r = "url(../cs-images/wishlist/wishlist_row_bg_r.gif)";

$home_wishlist_lastrow_bg = "url(../cs-images/wishlist/wishlist_lastrow_bg.gif)";
$home_wishlist_lastrow_bg_l = "url(../cs-images/wishlist/wishlist_lastrow_bg_l.gif)";
$home_wishlist_lastrow_bg_r = "url(../cs-images/wishlist/wishlist_lastrow_bg_r.gif)";

$home_wishlist_row_size = 11;
$home_wishlist_row_color = "#000000";
$home_wishlist_row_bold = "normal";

$home_wishlist_row_height = 26; // auto from image size

$small_stars_height = 15; // auto from image size
$small_stars_width = 15; // auto from image size

if($small_stars_height < $home_wishlist_row_size) {
	$home_wishlist_row_padding = ($home_wishlist_row_height-$home_wishlist_row_size)/2; // not editable
}
else {
	$home_wishlist_row_padding = ($home_wishlist_row_height-$small_stars_height)/2; // not editable
}

$small_fullstar_bg = "url(../cs-images/products/smallfullstar.png)";
$small_halfstar_bg = "url(../cs-images/products/smallhalfstar.gif)";
$small_emptystar_bg = "url(../cs-images/products/smallemptystar.png)";

$small_star_width = 15; // auto from image size
$small_star_height = 15; // auto from image size

$home_article_title_size = 12;
$home_article_title_color = $link_color;
$home_article_title_bold = "bold";

$home_article_text_size = 11;
$home_article_text_color = "#000000";
$home_article_text_bold = "normal";

$home_article_bg = "url(../cs-images/articles/article_bg.gif)";
$home_article_pic_width = 146; // auto from image size
$home_article_pic_height = 86; // auto from image size

$home_article_padding = 10;

if ($home_article_padding >= 2) {
	$home_article_padding_elements = $home_article_padding/2; // not editable
}

$footer_bg = "url(../cs-images/footerimages/footer_bg.gif)";
$footer_padding = $column_space; // not editable

$footer_title_size = 14;
$footer_title_color = "#FFFFFF";
$footer_title_bold = "normal";

$footer_link_size = 12;
$footer_link_color = "#FFFFFF";
$footer_link_bold = "normal";

$footer_text_size = 12;
$footer_text_color = "#FFFFFF";
$footer_text_bold = "normal";

$footer_column_width = 160;

// -- listing

$filters_left_bg = "url(../cs-images/listingimages/filters_bg_tl.gif)";
$filters_right_bg = "url(../cs-images/listingimages/filters_bg_tr.gif)";

$filters_padding = $box_right_title_padding; // not editable
$filters_space = $box_right_title_padding/2; // not editable

$filters_title_bg = "url(../cs-images/listingimages/filterstitleline.gif)";
$filters_title_size = $box_right_title_size;
$filters_title_color = $box_right_title_color;
$filters_title_bold = $box_right_title_bold;


$filters_element_size = 11;
$filters_element_color = "#000000";
$filters_element_bold = "normal";
$filters_element_bg = "url(../cs-images/listingimages/filter_element_bg.gif)";

$filters_element_size_on = 11;
$filters_element_color_on = "#000000";
$filters_element_bold_on = "normal";
$filters_element_bg_on = "url(../cs-images/listingimages/filter_element_bgon.gif)";

$filters_element_bg_width = 15; // auto from image size
$filters_element_bg_padding = $filters_element_bg_width+$filters_space; // not editable

$filters_bottom_bg_r = "url(../cs-images/listingimages/filtersbottom_r.gif)";
$filters_bottom_bg_l =  "url(../cs-images/listingimages/filtersbottom_l.gif)";

$filters_bottom_button_bg =  "url(../cs-images/listingimages/filtersbottom_close.gif)";

$filters_bottom_height = 26; // auto from image size

$filters_bottom_size = 12;
$filters_bottom_color = "#000000";
$filters_bottom_bold = "normal";

$filters_bottom_padding = ($filters_bottom_height-$filters_bottom_size)/2; // not editable

$filters_bottom_off_r = "url(../cs-images/listingimages/filtersbottom_off_r.gif)";
$filters_bottom_off_l =  "url(../cs-images/listingimages/filtersbottom_off_l.gif)";
$filters_bottom_off_height = 5; // auto from image size


$breadcrumbs_bg = "url(../cs-images/listingimages/breadcrumbs_bg.gif)";
$breadcrumbs_detail_bg = "url(../cs-images/productdetail/breadcrumbs_bg.gif)";
$breadcrumbs_height = 30; // auto from image size

$breadcrumbs_middleconnection_bg = "url(../cs-images/listingimages/middleconnection.gif)"; 
$breadcrumbs_middleconnection_width = 20; // auto from image size

$breadcrumbs_lastconnection_bg = "url(../cs-images/listingimages/lastconnection.gif)";
$breadcrumbs_lastconnection_width = 20; // auto from image size

$breadcrumbs_firstlink_bg = "url(../cs-images/listingimages/firstlink.gif)";
$breadcrumbs_middle_bg = "url(../cs-images/listingimages/middlelink.gif)";

$breadcrumbs_size = 12;
$breadcrumbs_link_color = "#ffffff";
$breadcrumbs_text_color = "#000000";

$breadcrumbs_link_bold = "normal";
$breadcrumbs_text_bold = "normal";

$breadcrumbs_padding = ($breadcrumbs_height-$breadcrumbs_size)/2; // not editable
$breadcrumbs_space = $breadcrumbs_padding/2; // not editable

$rightcolumn_listing_bg = $breadcrumbs_bg; // not editable;

$page_on_bg = "url(../cs-images/listingimages/pageon.gif)";
$page_on_bg_width = 19; // auto from image size
$page_on_bg_height = 19; // auto from image size

$page_input_height = $page_on_bg_height-5; // not editable
$page_input_width = 20;

$page_padding = $breadcrumbs_padding; // not editable

$page_on_size = 12;
$page_on_color = "#c70505";
$page_on_bold = "bold";

$page_on_bg_padding = ($page_on_bg_height-$page_on_size)/2; // not editable

$page_off_bg = "none";
$page_off_bg_width = 0; // auto from image size
$page_off_bg_over = "url(../cs-images/listingimages/pageoffon.gif)";;
$page_off_overunderline = "none";
$page_elements_space = 3;

if ($page_off_bg != 'none') {
$page_elements_space_off = $page_elements_space;
}
else {
$page_elements_space_off = 0;
}

if ($page_off_bg_width == 0) {
	$page_off_bg_width =	$page_on_bg_width; // not editable
}

$page_off_size = 12;
$page_off_color = "#000000";
$page_off_bold = "normal";

$page_input_size = $page_off_size;
if ($page_input_height>$page_input_size) {
$page_input_padding = ($page_input_height-$page_input_size)/2; // not editable
}
else {
$page_input_padding = 0;
}

$page_butt_bg = "url(../cs-images/listingimages/pagebutt.gif)";
$page_butt_width = 19; // auto from image size
$page_butt_height = 19; // auto from image size

$page_prev_bg = "url(../cs-images/listingimages/prev.gif)";
$page_prev_width = 19; // auto from image size
$page_prev_height = 19; // auto from image size

$page_next_bg = "url(../cs-images/listingimages/next.gif)";
$page_next_width = 19; // auto from image size
$page_next_height = 19; // auto from image size


$page_box_bg = "url(../cs-images/listingimages/layoutbox.gif)";
$page_box_bg_on = "url(../cs-images/listingimages/layoutboxon.gif)";
$page_box_width = 19; // auto from image size
$page_box_height = 19; // auto from image size

$page_list_bg = "url(../cs-images/listingimages/layoutlist.gif)";
$page_list_bg_on = "url(../cs-images/listingimages/layoutliston.gif)";
$page_list_width = 19; // auto from image size
$page_list_height = 19; // auto from image size

// -- detail

$product_detail_picture_width = 280; 
$product_detail_picture_height = 280;
$product_detail_info_width = $column_middle_width_detail-$product_detail_picture_width-$column_space*2-$small_thumbnail_width-2;
$product_detail_picture_border = "#EFEFEF";

$product_detail_opinions_size = 11;
$product_detail_opinions_bold = "normal";
$product_detail_opinions_color = "#000000";

$product_detail_opinions_padding = ($product_star_height-$product_detail_opinions_size)/2;

$product_detail_maininfo_bg_l= "url(../cs-images/productdetail/pricebg_l.gif)";
$product_detail_maininfo_bg_r= "url(../cs-images/productdetail/pricebg_r.gif)";
$product_detail_maininfo_height = 170; //  auto from image size

$product_detail_oldprice_size = 18;
$product_detail_oldprice_color = "#92b5dc";
$product_detail_oldprice_bold = "normal";

$product_detail_oldprice_decimals = $product_detail_oldprice_size-($product_detail_oldprice_size/3); // not editable


$product_detail_price_size = 30;
$product_detail_price_color = "#c70505";
$product_detail_price_bold = "normal";

$product_detail_price_decimals = $product_detail_price_size-($product_detail_price_size/3); // not editable


$product_detail_price_padding = 20;

$addtocard_bg =  "url(../cs-images/productdetail/adaugaincos.png)";
$addtocard_width = 167; // auto from image size
$addtocard_height = 38; // auto from image size
$addtocard_toppadding = 5;

$product_detail_info_size = 12;
$product_detail_info_color = "#000000";
$product_detail_info_bold = "normal";

$product_detail_description_bg_l= "url(../cs-images/productdetail/description_l.gif)";
$product_detail_description_bg_r= "url(../cs-images/productdetail/description_r.gif)";

$product_detail_description_size = 12;
$product_detail_description_color = "#000000";
$product_detail_description_bold = "normal";

$save_bg = "url(../cs-images/productdetail/salveaza.gif)";
$save_width = 88;
$save_height = 24;

$product_lease_padding = 5;
$product_lease_size = 11;
$product_lease_color = "#000000";
$product_lease_bold = "normal";

$product_buttons_bg_l = "url(../cs-images/productdetail/buttons_bg_l.gif)";
$product_buttons_bg_r = "url(../cs-images/productdetail/buttons_bg_r.gif)";

$product_buttons_bg_height = 41;
$product_buttons_padding = round(($product_buttons_bg_height-$save_height)/2);
$product_smallbuttons_padding = $column_space;

$description_width = $product_detail_info_width-$product_detail_price_padding*2.5; // not editable
$desctiption_vertical_padding = $product_detail_price_padding/2;

$variants_bg_l = "url(../cs-images/productdetail/variantsbg_l.gif)";
$variants_bg_r = "url(../cs-images/productdetail/variantsbg_r.gif)";

$variants_size = 12;


$table_param_width = 280;
$table_padding = 5;
$table_row_bg_odd = "#eaeaea";
$table_row_bg_even = "#FFFFFF";
$table_font_size = 11;
$table_param_bold = 'normal';
$table_value_bold = 'bold';

$table_header_bg_l = "url(../cs-images/mainimages/tableheader_l.gif)";
$table_header_bg_r = "url(../cs-images/mainimages/tableheader_r.gif)";
$big_table_header_bg_l = "url(../cs-images/mainimages/bigtableheader_l.gif)";
$big_table_header_bg_r = "url(../cs-images/mainimages/bigtableheader_r.gif)";
$table_header_size = 12;
$big_table_header_size = 18;
$table_header_color = $website_color;
$table_header_bold = 'bold';

$table_chapter_size = 12;
$table_chapter_color = "#000000";
$table_chapter_bold = 'bold';
$table_chapter_bg = '#eaeaea';

$message_size = 12;
$message_color = "#ff7200";
$message_bold = "bold";

$review_name_size = 12;
$review_name_color = "#000000";
$review_name_bold = "bold";

$review_date_size = 10;
$review_date_color = "#666666";
$review_date_bold = "normal";

$review_comment_size = 11;
$review_comment_color = "#000000";
$review_comment_bold = "normal";

$commercialtext_size = 12;
$commercialtext_color = "#000000";
$commercialtext_bold = "normal";

$tehnologiesname_size = 12;
$tehnologiesname_color = "#ff7200";
$tehnologiesname_bold = "bold";

$tehnologiesdesc_size = 11;
$tehnologiesdesc_color = "#000000";
$tehnologiesdesc_bold = "normal";

$note_size = 10;
$note_color = "#666666";

$files_title_size = 12;
$files_title_color = "#000000";
$files_title_bold = "bold";

$files_size = 11;
$files_color = "#000000";
$files_bold = "normal";

$icon_calendar_bg = "url(../cs-images/productdetail/calendaricon.gif)";
$icon_calendar_width = 21; // auto from image size
$icon_calendar_height = 21; // auto from image size

$adv_search_width = $column_left_width-$filters_space*2;
$adv_search_width_i = $column_left_width-$filters_space*2-$input_space*2;

$categorylink_width = $product_width-$table_padding*2;

// SERBAN 
// ---------------------------------------

$pagenumbers_width = $column_middle_width-$page_padding*2;

// Promos 

$promo_container_width = 585;
$promo_container_height = 240;
$promo_bg = "url(../cs-images/promo/promo_bg.jpg) no-repeat top left";
$promopic_margin_top = 20;
$promopic_width = 215;
$promo_description_width = 135;
$promo_description_padding_left = 20;
$promo_tabs_container_width = 160;
$promo_tabs_container_height = 220;
$promo_tab_active_bg = "url(../cs-images/promo/promo_tab_active.png) no-repeat top left";
$promo_tab_normal_bg = "url(../cs-images/promo/promo_tab_normal.jpg) no-repeat 28px 0px";
$promo_tab_active_height = 54;
$promo_tab_active_border = "none";
$promo_tab_active_textalign = "left";
$promo_tab_height = 25;
$promosNav_padding_top = 10;
$promosNav_padding_bottom = 10;

// Bundles

$BundlesPictures_width = 317;
$BundleDescriptionText_width = 340;
$BundlePic_width = 247;
$BundlePic_height = 247;
$BundleItemTitle_height = $column_space*2;

// listing-list

$product_list_width = $column_middle_width;
$list_producttitle_width = $column_middle_width-$product_width-$column_space;

// Product Details

$stlink_height = 12;
$stlink_width = 12;
$stoctip_width = 150;

// Poll

$FilledBar_bg = "url(../cs-images/poll/poll_filledbar_bg.jpg) repeat-x top left";
$EmptyBar_bg = "url(../cs-images/poll/poll_emptybar_bg.jpg) repeat-x top left";

// Cart

$cartpopup_width = 1; // dynamic, must be calculated with JS 
$BuyerSection_width = $website_width/2-$column_space/2;
$DeliverySection_width = $website_width/2-$column_space/2;
$emptycart_lineheight = 15;
$cartpopup_bg = "url(../cs-images/headerimages/cartpopup_bg.gif) no-repeat top left";
$carttable_bg = "#ffffff url(../cs-images/headerimages/carttable_tile.gif) repeat-y top right";
$cartbottom_bg = "#ffffff url(../cs-images/headerimages/cart-bottom-r.gif) no-repeat";
$cartbottom_left_bg = "#ffffff url(../cs-images/headerimages/cart-bottom-l.gif) no-repeat bottom left";
$cartbox_padding = 10;
$cartbottom_right_width = 264; // $cartpopup_width - $cartbox_padding
$carttop_bg = '#ffffff url(../cs-images/headerimages/cart-top.gif)';

// Login

$header_logged_padding = 5;
$header_logged_width = $header_search_width-$column_space*2;
$header_logged_height = $header_search_height-$header_logged_padding*2;
$LoginLink_bg = "url(../cs-images/headerimages/login-lock.gif) no-repeat center left";
$LoginLink_padding = 11;

// Product Tags

$productTag_height = 16;
$greentag_bg = "url(../cs-images/green-tag.png) no-repeat top left";
$bluetag_bg = "url(../cs-images/blue-tag.png) no-repeat top left";
$orangetag_bg = "url(../cs-images/orange-tag.png) no-repeat top left";
$bluetag_end_bg = "url(../cs-images/blue-tag-end.png) no-repeat top right";
$greentag_end_bg = "url(../cs-images/green-tag-end.png) no-repeat top right";
$orangetag_end_bg = "url(../cs-images/orange-tag-end.png) no-repeat top right";

// Checkout

$add_address_button_bg = "url(../cs-images/mainimages/addaddress_bg.gif) no-repeat top right";
$add_address_button_padding = 9;
$finishedorderbox_height = 200; // Fullscreen - ( header-height + footer-height )

// Authors

$author_width = $column_middle_width/3-2*$column_space;

// Footer

$footer_icons_bg = "url(../cs-images/footerimages/footer_icons_bg.gif)";
$FooterCategoriesList_width = 480;
$RSSicon_width = 22;

// Links

$links_border_color = "#e2e2e2";
$links_width = $column_middle_width-2*$column_space;

function is_chrome()
{
return(eregi("chrome", $_SERVER['HTTP_USER_AGENT']));
}
 
if(is_chrome())
{
$button_padding = "2px 0px 3px 10px";
$generalbutton_padding = "2px 10px 2px 0px";
}
else {
$button_padding = "1px 0px 3px 10px";
$generalbutton_padding = "2px 10px 3px 0px";
}

?>