<!DOCTYPE html>
<?php
    if (!defined('JOURNAL_INSTALLED')) {
        echo '
            <h3>Journal Installation Error</h3>
            <p>Make sure you have uploaded all Journal files to your server and successfully replaced <b>system/engine/front.php</b> file.</p>
            <p>You can find more information <a href="http://docs.digital-atelier.com/opencart/journal/#/settings/install" target="_blank">here</a>.</p>
        ';
        exit();
    }
?>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="<?php echo $this->journal2->html_classes->getAll(); ?>" data-j2v="<?php echo JOURNAL_VERSION; ?>">
<head>
<meta charset="UTF-8" />
<?php if ($this->journal2->settings->get('responsive_design')): ?>
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
<?php endif; ?>
<meta name="format-detection" content="telephone=no">
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/><![endif]-->
<!--[if lt IE 9]><script src="//ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script><![endif]-->
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($meta_title = $this->journal2->settings->get('blog_meta_title')): ?>
<meta name="title" content="<?php echo $meta_title; ?>" />
<?php endif; ?>
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<meta property="og:title" content="<?php echo $this->journal2->settings->get('fb_meta_title'); ?>" />
<meta property="og:description" content="<?php echo $this->journal2->settings->get('fb_meta_description'); ?>" />
<meta property="og:url" content="<?php echo $this->journal2->settings->get('fb_meta_url'); ?>" />
<meta property="og:image" content="<?php echo $this->journal2->settings->get('fb_meta_image'); ?>" />
    <style>
        <?php /*var_dump($home_page); die(' asdfvasfdva '.$home_page);*/ if (strpos($title, 'enania') > 8 || !strpos($title, 'enania')) { ?>
        .journal-menu.j-min.xs-100.sm-100.md-100.lg-100.xl-100 {
            position: fixed;
            top: 40px;
            background-color: #fff;
            z-index: 0;
            height: 20px;
        }
        <?php } ?>
        .secondary-menu-item-1 > i > img {
            height: 80px!important;
            top: 5px;
        }
    </style>
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php if ($blog_feed_url = $this->journal2->settings->get('blog_blog_feed_url')): ?>
<link rel="alternate" type="application/rss+xml" title="RSS" href="<?php echo $blog_feed_url; ?>" />
<?php endif; ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<?php foreach ($styles as $style) { ?>
<?php $this->journal2->minifier->addStyle($style['href']); ?>
<?php } ?>
<?php foreach ($this->journal2->google_fonts->getFonts() as $font): ?>
<link rel="stylesheet" href="<?php echo $font; ?>"/>
<?php endforeach; ?>
<?php foreach ($scripts as $script) { ?>
<?php $this->journal2->minifier->addScript($script, 'header'); ?>
<?php } ?>
<?php
    $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/hint.min.css');
    $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/journal.css');
    $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/features.css');
    $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/header.css');
    $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/module.css');
    $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/pages.css');
    $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/account.css');
    $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/blog-manager.css');
    $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/side-column.css');
    $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/product.css');
    $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/category.css');
    $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/footer.css');
    $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/icons.css');

            $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/multicart.css');
            
    if ($this->journal2->settings->get('responsive_design')) {
        $this->journal2->minifier->addStyle('catalog/view/theme/journal2/css/responsive.css');
    }
?>
<?php echo $this->journal2->minifier->css(); ?>
<?php if ($this->journal2->cache->getDeveloperMode() || !$this->journal2->minifier->getMinifyCss()): ?>
<link rel="stylesheet" href="index.php?route=journal2/assets/css&amp;j2v=<?php echo JOURNAL_VERSION; ?>" />
<?php endif; ?>
<?php $this->journal2->minifier->addScript('catalog/view/theme/journal2/js/journal.js', 'header'); ?>
<?php echo $this->journal2->minifier->js('header'); ?>
<!--[if (gte IE 6)&(lte IE 8)]><script src="catalog/view/theme/journal2/lib/selectivizr/selectivizr.min.js"></script><![endif]-->
<?php if (isset($stores)): /* v1541 compatibility */ ?>
<?php if ($stores) { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
<?php foreach ($stores as $store) { ?>
$('body').prepend('<iframe src="<?php echo $store; ?>" style="display: none;"></iframe>');
<?php } ?>
});
//--></script>
<?php } ?>
<?php endif; /* end v1541 compatibility */ ?>

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
<script>
    <?php if ($this->journal2->settings->get('show_countdown', 'never') !== 'never' || $this->journal2->settings->get('show_countdown_product_page', 'on') == 'on'): ?>
    Journal.COUNTDOWN = {
        DAYS    : "<?php echo $this->journal2->settings->get('countdown_days', 'Days'); ?>",
        HOURS   : "<?php echo $this->journal2->settings->get('countdown_hours', 'Hours'); ?>",
        MINUTES : "<?php echo $this->journal2->settings->get('countdown_min', 'Min'); ?>",
        SECONDS : "<?php echo $this->journal2->settings->get('countdown_sec', 'Sec'); ?>"
    };
    <?php endif; ?>
    Journal.NOTIFICATION_BUTTONS = '<?php echo $this->journal2->settings->get('notification_buttons'); ?>';
</script>

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
<!--[if lt IE 9]>
<div class="old-browser"><?php echo $this->journal2->settings->get('old_browser_message', 'You are using an old browser. Please <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">upgrade to a newer version</a> or <a href="http://browsehappy.com/">try a different browser</a>.'); ?></div>
<![endif]-->
<?php if ($this->journal2->settings->get('config_header_modules')):  ?>
<?php echo $this->journal2->settings->get('config_header_modules'); ?>
<?php endif; ?>
<?php if ($this->journal2->config->admin_warnings): ?>
<div class="admin-warning"><?php echo $this->journal2->config->admin_warnings; ?></div>
<?php endif; ?>
<?php
    $header_type = $this->journal2->settings->get('header_type', 'default');
    if ($header_type === 'center') {
        if (!$this->journal2->settings->get('config_secondary_menu')) {
            $header_type = 'center.nosecond';
        } else {
            if (!$currency && !$language) {
                $header_type = 'center.nolang-nocurr';
            } else if (!$currency) {
                $header_type = 'center.nocurr';
            } else if (!$language) {
                $header_type = 'center.nolang';
            }
        }
    }

    if ($header_type === 'mega') {
        if (!$this->journal2->settings->get('config_secondary_menu')) {
            $header_type = 'mega.nosecond';
        } else {
            if (!$currency && !$language) {
                $header_type = 'mega.nolang-nocurr';
            } else if (!$currency) {
                $header_type = 'mega.nocurr';
            } else if (!$language) {
                $header_type = 'mega.nolang';
            }
        }
    }

    if ($header_type === 'default' || $header_type === 'extended') {
        $no_cart = $this->journal2->settings->get('catalog_header_cart', 'block') === 'none';
        $no_search = $this->journal2->settings->get('catalog_header_search', 'block') === 'none';
        if ($no_cart && $no_search) {
            $header_type = $header_type . '.nocart-nosearch';
        } else if ($no_cart) {
            $header_type = $header_type . '.nocart';
        } else if ($no_search) {
            $header_type = $header_type . '.nosearch';
        }
    }
    if (class_exists('VQMod')) {
        global $vqmod;
        if ($vqmod !== null) {
            require $vqmod->modCheck(DIR_TEMPLATE . $this->config->get('config_template') . "/template/journal2/headers/{$header_type}.tpl");
        } else {
            require VQMod::modCheck(DIR_TEMPLATE . $this->config->get('config_template') . "/template/journal2/headers/{$header_type}.tpl");
        }
    } else {
        require DIR_TEMPLATE . $this->config->get('config_template') . "/template/journal2/headers/{$header_type}.tpl";
    }
?>
<?php if ($this->journal2->settings->get('config_top_modules')): ?>
<div id="top-modules">
   <?php echo $this->journal2->settings->get('config_top_modules'); ?>
</div>
<?php endif; ?>

<div class="extended-container">
<div id="container" class="j-container">

<?php if(isset($error)): /* v156 compatibility */ ?>
<?php if ($error) { ?>
    <div class="warning"><?php echo $error ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?>
<?php endif; /* end v156 compatibility */ ?>
<div id="notification"></div>

        <?php echo $dream_column_header_bottom; ?>
      