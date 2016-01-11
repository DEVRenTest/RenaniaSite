<?php
//-----------------------------------------------------
// Newsletter Enhancements for Opencart
// Created by @DmitryNek (Dmitry Shkoliar)
// exmail.Nek@gmail.com
//-----------------------------------------------------
?>
<div class="box">
    <div class="box-heading"><?php echo $heading ? $heading : '&nbsp;'; ?></div>
    <div class="box-content">
        <div id="ne_subscribe<?php echo $module; ?>" class="ne_subscribe">
            <?php echo $text; ?>
            <?php if ($fields > 1) { ?>
                <label>
                    <?php echo $fields == 2 ? $entry_name : $entry_firstname; ?><br/>
                    <input type="text" name="ne_name" style="width:90%;" />
                </label><br/>
            <?php } ?>
            <?php if ($fields == 3) { ?>
                <label>
                    <?php echo $entry_lastname; ?><br/>
                    <input type="text" name="ne_lastname" style="width:90%;" />
                </label><br/>
            <?php } ?>
            <label>
                <?php echo $entry_email; ?><br/>
                <input type="text" name="ne_email" style="width:90%;" />
            </label><br/>
            <?php if ($marketing_list) { ?>
                <label><?php echo $entry_list; ?></label><br/>
                <div class="ne_list_data">
                    <?php foreach ($marketing_list as $key => $list) { ?>
                        <label>
                            <input class="ne_subscribe_list" name="ne_list[]" type="<?php echo $list_type ? 'radio' : 'checkbox'; ?>" value="<?php echo $key; ?>" /> <?php echo $list[$this->config->get('config_language_id')]; ?>
                        </label>
                    <?php } ?>
                </div><br/>
            <?php } ?>
            <a href="#" class="button ne_submit"><span><?php echo $text_subscribe; ?></span></a>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
$('#ne_subscribe<?php echo $module; ?> a.ne_submit').click(function(e){
    e.preventDefault();

    var list = $('#ne_subscribe<?php echo $module; ?> .ne_subscribe_list:checked').map(function(i,n) {
        return $(n).val();
    }).get();

    $.post("<?php echo $subscribe; ?>", {
        email: $('#ne_subscribe<?php echo $module; ?> input[name="ne_email"]').val(),
        <?php if ($fields > 1) { ?>name: $('#ne_subscribe<?php echo $module; ?> input[name="ne_name"]').val(), <?php } ?>
        <?php if ($fields == 3) { ?>lastname: $('#ne_subscribe<?php echo $module; ?> input[name="ne_lastname"]').val(), <?php } ?>
        'list[]': list
    }, function(data) {
        if (data) {
            if (data.type == 'success') {
                $('#ne_subscribe<?php echo $module; ?> input[type="text"]').val('');
                $('#ne_subscribe<?php echo $module; ?> .ne_subscribe_list').removeAttr('checked');
            }
            $("#ne_subscribe<?php echo $module; ?> div." + data.type).remove();
            $('#ne_subscribe<?php echo $module; ?>').prepend('<div class="' + data.type + '">' + data.message + '</div>');
            $("#ne_subscribe<?php echo $module; ?> div." + data.type).delay(3000).slideUp(400, function(){
                $(this).remove();
            });
        } else {
            $('#ne_subscribe<?php echo $module; ?> input[type="text"]:first').focus();
        }
    }, "json");
});
//--></script>