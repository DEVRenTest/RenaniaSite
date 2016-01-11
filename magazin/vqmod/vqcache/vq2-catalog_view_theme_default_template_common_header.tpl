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

				<script type="text/javascript" src="catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js"></script>
			
<script type="text/javascript" src="catalog/view/javascript/fancybox/jquery.fancybox.js"></script>
<script type="text/javascript" src="catalog/view/javascript/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
    $(document).ready(function() {
        $("a[rel=elso_group]").fancybox({
            'transitionIn'  : 'none',
            'transitionOut'  : 'none',
            'titlePosition'  : 'over'
        });
    });
</script>
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

            <?php $this->language->load( 'common/cookie' ); ?>
<!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
<link rel="stylesheet" type="text/css" href="https://s3-eu-west-1.amazonaws.com/assets.cookieconsent.silktide.com/current/style.min.css"/>
<script type="text/javascript" src="https://s3-eu-west-1.amazonaws.com/assets.cookieconsent.silktide.com/current/plugin.min.js"></script>
<script type="text/javascript">
// <![CDATA[
cc.initialise({
	cookies: {
		social: {},
		analytics: {},
		necessary: {}
	},
	settings: {
		style: "monochrome",
		bannerPosition: "push",
		tagPosition: "vertical-left",
		ignoreDoNotTrack: true,
		disableallsites: true,
		useSSL: true
	},
  strings: {
      jqueryWarning:"<?php echo $this->language->get( 'heading_title' ); ?>",
      noJsBlocksWarning:"<?php echo $this->language->get( 'text_noJsBlocksWarning' ); ?>",
      noKeyWarning:"<?php echo $this->language->get( 'text_noKeyWarning' ); ?>",
      invalidKeyWarning:"<?php echo $this->language->get( 'text_invalidKeyWarning' ); ?>",
      necessaryDefaultTitle:"<?php echo $this->language->get( 'text_necessaryDefaultTitle' ); ?>",
      socialDefaultTitle:"<?php echo $this->language->get( 'text_socialDefaultTitle' ); ?>",
      analyticsDefaultTitle:"<?php echo $this->language->get( 'text_analyticsDefaultTitle' ); ?>",
      advertisingDefaultTitle:"<?php echo $this->language->get( 'text_advertisingDefaultTitle' ); ?>",
      defaultTitle:"<?php echo $this->language->get( 'text_defaultTitle' ); ?>",
      necessaryDefaultDescription:"<?php echo $this->language->get( 'text_necessaryDefaultDescription' ); ?>",
      socialDefaultDescription:"<?php echo $this->language->get( 'text_socialDefaultDescription' ); ?>",
      analyticsDefaultDescription:"<?php echo $this->language->get( 'text_analyticsDefaultDescription' ); ?>",
      advertisingDefaultDescription:"<?php echo $this->language->get( 'text_advertisingDefaultDescription' ); ?>",
      defaultDescription:"<?php echo $this->language->get( 'text_defaultDescription' ); ?>",
      notificationTitle:"<?php echo $this->language->get( 'text_notificationTitle' ); ?>",
      notificationTitleImplicit:"<?php echo $this->language->get( 'text_notificationTitleImplicit' ); ?>",
      poweredBy:"<?php echo $this->language->get( 'text_poweredBy' ); ?>",
      privacyPolicy:"<?php echo $this->language->get( 'text_privacyPolicy' ); ?>",
      learnMore:"<?php echo $this->language->get( 'text_learnMore' ); ?>",
      seeDetails:"<?php echo $this->language->get( 'text_seeDetails' ); ?>",
      seeDetailsImplicit:"<?php echo $this->language->get( 'text_seeDetailsImplicit' ); ?>",
      hideDetails:"<?php echo $this->language->get( 'text_hideDetails' ); ?>",
      savePreference:"<?php echo $this->language->get( 'text_savePreference' ); ?>",
      saveForAllSites:"<?php echo $this->language->get( 'text_saveForAllSites' ); ?>",
      allowCookies:"<?php echo $this->language->get( 'text_allowCookies' ); ?>",
      allowCookiesImplicit:"<?php echo $this->language->get( 'text_allowCookiesImplicit' ); ?>",
      allowForAllSites:"<?php echo $this->language->get( 'text_allowForAllSites' ); ?>",
      customCookie:"<?php echo $this->language->get( 'text_customCookie' ); ?>",
      privacySettings:"<?php echo $this->language->get( 'text_privacySettings' ); ?>",
      privacySettingsDialogTitleA:"<?php echo $this->language->get( 'text_privacySettingsDialogTitleA' ); ?>",
      privacySettingsDialogTitleB:"<?php echo $this->language->get( 'text_privacySettingsDialogTitleB' ); ?>",
      privacySettingsDialogSubtitle:"<?php echo $this->language->get( 'text_privacySettingsDialogSubtitle' ); ?>",
      closeWindow:"<?php echo $this->language->get( 'text_closeWindow' ); ?>",
      changeForAllSitesLink:"<?php echo $this->language->get( 'text_changeForAllSitesLink' ); ?>",
      preferenceUseGlobal:"<?php echo $this->language->get( 'text_preferenceUseGlobal' ); ?>",
      preferenceConsent:"<?php echo $this->language->get( 'text_preferenceConsent' ); ?>",
      preferenceDecline:"<?php echo $this->language->get( 'text_preferenceDecline' ); ?>",
      preferenceAsk:"<?php echo $this->language->get( 'text_preferenceAsk' ); ?>",
      preferenceAlways:"<?php echo $this->language->get( 'text_preferenceAlways' ); ?>",
      preferenceNever:"<?php echo $this->language->get( 'text_preferenceNever' ); ?>",
      notUsingCookies:"<?php echo $this->language->get( 'text_notUsingCookies' ); ?>",
      clearedCookies:"<?php echo $this->language->get( 'text_clearedCookies' ); ?>",
      allSitesSettingsDialogTitleA:"<?php echo $this->language->get( 'text_allSitesSettingsDialogTitleA' ); ?>",
      allSitesSettingsDialogTitleB:"<?php echo $this->language->get( 'text_allSitesSettingsDialogTitleB' ); ?>",
      allSitesSettingsDialogSubtitle:"<?php echo $this->language->get( 'text_allSitesSettingsDialogSubtitle' ); ?>",
      backToSiteSettings:"<?php echo $this->language->get( 'text_backToSiteSettings' ); ?>"
 }

   
});
// 
</script>

<!-- End Cookie Consent plugin -->
<!-- with credits to Stokeyblokey for the Opencart extension -->
<script type="text/plain" class="cc-onconsent-analytics">
<?php echo str_replace('<script type="text/javascript">$(function() {var addToCartBu','$(function() {var addToCartBu',$google_analytics); ?> </script>

			<link rel="stylesheet" href="catalog/view/javascript/jquery.cluetip.css" type="text/css" />
			<script src="catalog/view/javascript/jquery.cluetip.js" type="text/javascript"></script>
			
			<script type="text/javascript">
				$(document).ready(function() {
				$('a.title').cluetip({splitTitle: '|'});
				  $('ol.rounded a:eq(0)').cluetip({splitTitle: '|', dropShadow: false, cluetipClass: 'rounded', showtitle: false});
				  $('ol.rounded a:eq(1)').cluetip({cluetipClass: 'rounded', dropShadow: false, showtitle: false, positionBy: 'mouse'});
				  $('ol.rounded a:eq(2)').cluetip({cluetipClass: 'rounded', dropShadow: false, showtitle: false, positionBy: 'bottomTop', topOffset: 70});
				  $('ol.rounded a:eq(3)').cluetip({cluetipClass: 'rounded', dropShadow: false, sticky: true, ajaxCache: false, arrows: true});
				  $('ol.rounded a:eq(4)').cluetip({cluetipClass: 'rounded', dropShadow: false});  
				});
			</script>
			
</head>
<body>
<div id="container">
<div id="Heading">

    <?php if (!$header_B2B_tab) { ?>
	    <a class="portal_top selected first" href="<?php echo $home; ?>">MAGAZIN ONLINE</a>
    <?php } else { ?>
        <a class="portal_top second" href="<?php echo $home; ?>">MAGAZIN ONLINE</a>
    <?php } ?>

    <a class="portal_top second" href="https://renania.ro" target="_blank">PREZENTARE</a>
    <a href="https://renania.ro/gallery/showGalleryImages/" class="portal_top second">GALERIE</a> 

    <?php if (!$header_B2B_tab) { ?>
        <a class="portal_top second" href="<?php echo $text_b2b_login; ?>">B2B</a>
    <?php } else { ?>
        <a class="portal_top selected first" style="cursor: none;">B2B</a>
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
<div id="Header"> <a id="Logo" href="index.php">
        <img src="catalog/view/theme/default/image/logo.png" alt=""  />
        <!-- <span class="slogan_1">siguran&#355;&#259; f&#259;r&#259; compromisuri</span>
         <span class="slogan_2">Echipamente &#351;i sisteme de protec&#355;ia muncii</span> -->
     </a>

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

        <?php echo $dream_column_header_bottom; ?>
      
