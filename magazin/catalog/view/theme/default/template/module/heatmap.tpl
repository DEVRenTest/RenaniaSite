<!-- START TEMPLATE -->
<?php
$arr_enable_clickmap_for_users = array();
$arr_enable_clickmap_for_users['gabor.bodo@renania.ro']    = true;
$arr_enable_clickmap_for_users['mihai.muresan@renania.ro'] = true;
$arr_enable_clickmap_for_users['adam.nagy@renania.ro']     = true;
$arr_enable_clickmap_for_users['claudia.grec@renania.ro']  = true;
$arr_enable_clickmap_for_users['claudiu.baias@renania.ro'] = true;
$arr_enable_clickmap_for_users['bela.szasz@renania.ro']    = true;

$this->load->language('module/heatmap');
$route = "?route=module/heatmap";
$page = "";
if ( isset($this->request->get['route']) ) {
	$page = $this->request->get['route'];
}
$display_click_url = $route."/display_clicks";
$click_url = $route."/click_register";
$statistics_click_url = $route."/display_statistics";
$customer_email = $this->customer->getEmail();
# print $customer_email."<----";
$bool_show_heatmap_tool = false;
/*
if ( isset($customer_email) ) {
	if ( preg_match("/\@renania.ro$/",$customer_email) ) {
		$bool_show_heatmap_tool = true;
	}
}
*/
if ( isset($arr_enable_clickmap_for_users[$customer_email]) && $arr_enable_clickmap_for_users[$customer_email] ) {
    $bool_show_heatmap_tool = true;
} else {
    $bool_show_heatmap_tool = false;
}
$bool_register_clicks = false;
if ( isset($customer_email) && !empty($customer_email) ) {
    $bool_register_clicks = true;
}
?>
<?php
if ( $bool_register_clicks ) {
?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/style_clickmap.css" />
<script>
var display_click_url    = '<?php print $display_click_url;?>';
var click_url            = '<?php print $click_url;?>';
var statistics_click_url = '<?php print $statistics_click_url;?>';
var page                 = '<?php print $page;?>';
</script>
<script type="text/javascript" src="catalog/view/javascript/clickmap.js"></script>
<script type="text/javascript">
    $(function() {
        $(document).saveClicks(); 
        $('.displayClicks').click(function() {
            $.displayClicks();
            $('#clickmap-overlay').click(function() {
                 $.removeClicks();
                 $(document).saveClicks();
            });
            $(document).stopSaveClicks();
            return false;
        });
    });
<?php
if ( $bool_show_heatmap_tool ) {
?>
    $.get(statistics_click_url, { l:escape( document.location.pathname) },  
        function(html) { 
            $("#click_map_id_title").attr("title", html);
            $('#clickmap-loading').remove(); 
        } 
    ); 
    $("#cart").before("<a id=\"click_map_id\" class=\"displayClicks icon-only secondary-menu-item-6\"><span id=\"click_map_id_title\" title=\"\" class=\"top-menu-link\">ClickMap</span></a>");
<?php    
}
?>
</script>
<?php
}
?>
<!-- END TEMPLATE -->
