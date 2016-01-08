<?php
//-----------------------------------------------------
// Newsletter Enhancements for Opencart
// Created by @DmitryNek (Dmitry Shkoliar)
// exmail.Nek@gmail.com
//-----------------------------------------------------
?>
<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if ($error_warning) { ?>
        <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <?php if ($success) { ?>
        <div class="success"><?php echo $success; ?></div>
    <?php } ?>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/ne/subscribers.png" alt="" width="22" height="22" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a onclick="$('#mainform').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
        </div>
        <div class="content">
            <p><?php echo $text_add_info; ?></p>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <textarea name="emails" style="width:99%; height:100px; padding:4px; margin-bottom:5px;"></textarea>
                <a onclick="$('#form').submit();" class="button" style="float:right; margin-bottom:15px;"><span><?php echo $button_insert; ?></span></a>
            </form>
            <div style="clear:both;"></div>
            <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="mainform">
                <table class="list">
                    <thead>
                        <tr>
                            <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
                            <td class="left">
                                <?php if ($sort == 'email') { ?>
                                <a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_email; ?></a>
                                <?php } else { ?>
                                <a href="<?php echo $sort_email; ?>"><?php echo $column_email; ?></a>
                                <?php } ?>
                            </td>
                            <td class="left">
                                <?php if ($sort == 'date') { ?>
                                <a href="<?php echo $sort_date; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date; ?></a>
                                <?php } else { ?>
                                <a href="<?php echo $sort_date; ?>"><?php echo $column_date; ?></a>
                                <?php } ?>
                            </td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="filter">
                            <td></td>
                            <td class="left"><input type="text" name="filter_email" value="<?php echo $filter_email; ?>" /></td>
                            <td class="left"><input type="text" name="filter_date" value="<?php echo $filter_date; ?>" size="12" class="date" /></td>
                            <td class="right">
                                <a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a>
                            </td>
                        </tr>
                        <?php if ($blacklisted) { ?>
                        <?php foreach ($blacklisted as $entry) { ?>
                        <tr>
                            <td style="text-align: center;">
                                <?php if ($entry['selected']) { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $entry['blacklist_id']; ?>" checked="checked" />
                                <?php } else { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $entry['blacklist_id']; ?>" />
                                <?php } ?>
                            </td>
                            <td class="left"><?php echo $entry['email']; ?></td>
                            <td class="left"><?php echo $entry['datetime']; ?></td>
                            <td></td>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </form>
            <div class="pagination"><?php echo $pagination; ?></div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
function filter() {
    url = 'index.php?route=ne/blacklist&token=<?php echo $token; ?>';

    var filter_email = $('input[name=\'filter_email\']').attr('value');

    if (filter_email) {
        url += '&filter_email=' + encodeURIComponent(filter_email);
    }

    var filter_date = $('input[name=\'filter_date\']').attr('value');

    if (filter_date) {
        url += '&filter_date=' + encodeURIComponent(filter_date);
    }

    location = url;
}
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
    $('.date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<script type="text/javascript"><!--
$('#mainform input').keydown(function(e) {
    if (e.keyCode == 13) {
        filter();
    }
});
//--></script>
<?php echo $footer; ?>