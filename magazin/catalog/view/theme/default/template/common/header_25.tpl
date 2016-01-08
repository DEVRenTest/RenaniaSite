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
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/stylesheet.css" />
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="catalog/view/javascript/common.js"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<!--[if IE 7]> 
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie7.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie6.css" />
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
   <?php if (!$logged) { ?>
	<a class="portal_top selected first" href="<?php echo $home; ?>">MAGAZIN ONLINE</a>
   <?php } else { ?>
    <a class="portal_top second" href="<?php echo $home; ?>">MAGAZIN ONLINE</a>
    <?php } ?>
    <a class="portal_top second" href="https://renania.ro" target="_blank">PREZENTARE</a>
    <a href="https://renania.ro/gallery/showGalleryImages/" class="portal_top second">GALERIE</a> 
    <?php if (!$logged) { ?>
        <a href="<?php echo $text_b2b_login; ?>" class="portal_top second">B2B</a> 
    <?php } else { ?>
         <a style="cursor: none;" class="portal_top selected first">B2B</a>
    <?php } ?>
    <div class="log_lang" id="LoginLink">
    <?php if (!$logged) { ?>
    <?php echo $text_welcome; ?>
    <?php } else { ?>
    <?php echo $text_logged; ?>
    <?php } ?>
    </div>
    <div class="clear"></div>
</div>
<div id="Header"> <a id="Logo" href="index.php"> <span class="slogan_1">siguran&#355;&#259; f&#259;r&#259; compromisuri</span> <span class="slogan_2">Echipamente &#351;i sisteme de protec&#355;ia muncii</span> </a> 
    
    <!-- Shopping Cart -->
    <?php echo $cart; ?>
    <div class="cl-right"></div>
    <div id="Facilities">
<!--      <div id="Search">
        <form action="index.php" method="get" name="search">
          
          
          <input type="hidden" value="search" name="page">
          <input type="hidden" value="products" name="action">        
          
          
          <input type="text" name="search" placeholder="<?php echo $text_search; ?>" value="<?php echo $search; ?>" />
          <button class="buton_search"> <?php echo $search; ?> </button>
        </form>
      </div> -->

      <div id="search">
        <div class="button-search"></div>
        <input type="text" name="search" placeholder="<?php echo $text_search; ?>" value="<?php echo $search; ?>" />
        <button class="buton_search button-search"> <?php echo $search; ?> </button>
      </div>

    </div>
    <div class="clear"></div>
  </div>

<?php if ($error) { ?>
    
    <div class="warning"><?php echo $error ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
    
<?php } ?>
<div id="notification"></div>
