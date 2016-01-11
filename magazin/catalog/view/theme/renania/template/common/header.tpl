<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/renania/stylesheet/stylesheet.css" />
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<!-- Renania Template -->
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/theme/renania/cs-js/functions.js"></script>
<script type="text/javascript" src="catalog/view/theme/renania/cs-js/menu.js"></script>
<script type="text/javascript" src="catalog/view/theme/renania/cs-js/wig/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="catalog/view/theme/renania/cs-js/wig/jquery.ui.widget.min.js"></script>
<script type="text/javascript" src="catalog/view/theme/renania/cs-js/wig/jquery.ui.rcarousel.js"></script>

<!--[if lt IE 7]>
<script defer type="text/javascript" src="catalog/view/theme/renania/cs-js/pngfix.js"></script>
<![endif]-->

<script type="text/javascript" src="catalog/view/theme/renania/cs-js/promo_tabs.js"></script>
<script type="text/javascript" src="catalog/view/theme/renania/cs-js/listings.js"></script>
<script type="text/javascript" src="catalog/view/theme/renania/cs-js/Resizer.js"></script>
<!-- Renania Template END -->

<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/common.js"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>


<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />

<!-- Renania Template -->
<link rel="stylesheet" href="catalog/view/theme/renania/cs-js/wig/rcarousel.css" type="text/css" />
<link rel="stylesheet" href="catalog/view/theme/renania/cs-js/lbjs/lightbox/jquery.lightbox-0.5.css" type="text/css" />
<link href="catalog/view/theme/renania/cs-skins/grey-crimson/cs-styles/style.css" type="text/css" rel="stylesheet" />

<script type="text/javascript">
	jQuery(document).ready(function() {
	jQuery('#Menu_top ul li').mouseover(function() {
	jQuery('#Menu_top ul li ul').show();
	});
	jQuery('#Menu_top ul li').mouseleave(function() {
	jQuery('#Menu_top ul li ul').hide();
	});
	});
</script>
<script src="catalog/view/theme/renania/cs-js/jquery.bxSlider.js" type="text/javascript"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#wrapBrands').bxSlider({displaySlideQty:13, speed:900, pause:3000, tickerSpeed:7000});
	});
	$(document).ready(function(){
	  $('#sliderProd').bxSlider({auto:false, autoStart:false, displaySlideQty:3, wrapperWidth:700});
	}); 
	$(document).ready(function(){
	  $('#slider1').bxSlider({displaySlideQty:3, auto:false, autoStart:false});
	});
	$(document).ready(function(){
	  $('#slider2').bxSlider({displaySlideQty:3, auto:false, autoStart:false});
	});
	$(document).ready(function(){
	  $('#slider3').bxSlider({displaySlideQty:3, auto:false, autoStart:false});
	});
	$(document).ready(function(){
	  $('#slider4').bxSlider({displaySlideQty:3, auto:false, autoStart:false});
	});
	$(document).ready(function(){
	  $('#slider5').bxSlider({displaySlideQty:3, auto:false, autoStart:false});
	});
	$(document).ready(function(){
	  $('#slider6').bxSlider({displaySlideQty:3, auto:false, autoStart:false});
	});
	$(document).ready(function(){
	  $('#slider7').bxSlider({displaySlideQty:3, auto:false, autoStart:false});
	});
	$(document).ready(function(){
	  $('#slider8').bxSlider({auto:false, autoStart:false});
	}); 			
</script>
        
<link rel="stylesheet" href="catalog/view/theme/renania/cs-js/prettyphoto/css/prettyPhoto.css" type="text/css" media="screen" />
<script src="catalog/view/theme/renania/cs-js/prettyphoto/js/jquery.prettyPhoto.js" type="text/javascript"></script>
<!-- Renania Template END -->

<!--[if IE 7]> 
<link rel="stylesheet" type="text/css" href="catalog/view/theme/renania/stylesheet/ie7.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/renania/stylesheet/ie6.css" />
<script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('#logo img');
</script>
<![endif]-->
<?php if ($stores) { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
<?php foreach ($stores as $store) { ?>
$('body').prepend('<iframe src="<?php echo $store; ?>" style="display: none;"></iframe>');
<?php } ?>
});
//--></script>
<?php } ?>
<?php echo $google_analytics; ?>
</head>
<body>
<div id="container">
<div id="Heading">
	<a class="portal_top selected first">MAGAZIN ONLINE</a>
    <a class="portal_top second" href="https://renania.ro" target="_blank">PREZENTARE</a>
    <div class="log_lang" id="welcome">
    <?php if (!$logged) { ?>
    <?php echo $text_welcome; ?>
    <?php } else { ?>
    <?php echo $text_logged; ?>
    <?php } ?>
    </div>
    <div class="clear"></div>
</div>
<!-- Renania Template HEADER -->
<div id="Header">
    <a id="Logo" href="index.php">
    	<span class="slogan_1">siguran&#355;&#259; f&#259;r&#259; compromisuri</span>
        <span class="slogan_2">Echipamente &#351;i sisteme de protec&#355;ia muncii</span>
    </a>
    <?php echo $cart; ?>	
     <div class="cl-right"></div>
        <div id="Facilities">
        <div id="Search" >
	<form action="" method="get" name="search">
		<input type="hidden" name="page" value="search" />
		<input type="hidden" name="action" value="products" />
        <input name="query" type="text" placeholder="<?php echo $text_search; ?>" value="<?php echo $search; ?>" id="query" />
        <button class="buton_search">
            Cauta
        </button>
	</form>
    </div>
   </div>
    <div class="clear"></div>
</div>	
<!-- Renania Template HEADER EBD -->
<?php if ($error) { ?>
    <div class="warning"><?php echo $error ?><img src="catalog/view/theme/renania/image/close.png" alt="" class="close" /></div>
<?php } ?>
<div id="notification"></div>
<div id="out-content">
