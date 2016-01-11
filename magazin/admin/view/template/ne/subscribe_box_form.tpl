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
<div class="box">
    <div class="heading">
        <h1><img src="view/image/ne/templates.png" alt="" width="22" height="22" /> <?php echo $heading_title; ?></h1>
        <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a> <a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a>
        </div>
    </div>
    <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
                <tr>
                    <td colspan="2"><b><?php echo $text_settings; ?></b></td>
                </tr>
                <tr>
                    <td><span class="required">*</span> <?php echo $entry_name; ?></td>
                    <td><input type="text" name="name" size="100" value="<?php echo $name; ?>" />
                    <?php if (!empty($error_name)) { ?>
                        <span class="error"><?php echo $error_name; ?></span>
                    <?php } ?></td>
                </tr>
                <tr>
                    <td><?php echo $entry_status; ?></td>
                    <td>
                        <?php if($status) {
                        $checked1 = ' checked="checked"';
                        $checked0 = '';
                        } else {
                        $checked1 = '';
                        $checked0 = ' checked="checked"';
                        } ?>
                        <label for="status__1"><?php echo $text_enabled; ?></label>
                        <input type="radio"<?php echo $checked1; ?> id="status__1" name="status" value="1" />
                        <label for="status__0"><?php echo $text_disabled; ?></label>
                        <input type="radio"<?php echo $checked0; ?> id="status__0" name="status" value="0" />
                    </td>
                </tr>
                <tr>
                    <td><?php echo $entry_show_for; ?></td>
                    <td>
                        <select name="show_for">
                            <?php if (!$show_for) { ?>
                                <option value="1"><?php echo $text_all; ?></option>
                                <option value="0" selected="selected"><?php echo $text_guests; ?></option>
                            <?php } else { ?>
                                <option value="1" selected="selected"><?php echo $text_all; ?></option>
                                <option value="0"><?php echo $text_guests; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $entry_fields; ?></td>
                    <td>
                        <select name="fields">
                            <?php if ($fields == '1') { ?>
                                <option value="1" selected="selected"><?php echo $text_only_email; ?></option>
                            <?php } else { ?>
                                <option value="1"><?php echo $text_only_email; ?></option>
                            <?php } ?>
                            <?php if ($fields == '2') { ?>
                                <option value="2" selected="selected"><?php echo $text_email_name; ?></option>
                            <?php } else { ?>
                                <option value="2"><?php echo $text_email_name; ?></option>
                            <?php } ?>
                            <?php if ($fields == '3') { ?>
                                <option value="3" selected="selected"><?php echo $text_email_full; ?></option>
                            <?php } else { ?>
                                <option value="3"><?php echo $text_email_full; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $entry_type; ?></td>
                    <td>
                        <select name="type">
                            <?php if ($type == '1') { ?>
                                <option value="1" selected="selected"><?php echo $text_content_box; ?></option>
                            <?php } else { ?>
                                <option value="1"><?php echo $text_content_box; ?></option>
                            <?php } ?>
                            <?php if ($type == '2') { ?>
                                <option value="2" selected="selected"><?php echo $text_modal_popup; ?></option>
                            <?php } else { ?>
                                <option value="2"><?php echo $text_modal_popup; ?></option>
                            <?php } ?>
                            <?php if ($type == '3') { ?>
                                <option value="3" selected="selected"><?php echo $text_content_box_to_modal; ?></option>
                            <?php } else { ?>
                                <option value="3"><?php echo $text_content_box_to_modal; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $entry_list_type; ?></td>
                    <td>
                        <select name="list_type">
                            <?php if ($list_type == '1') { ?>
                                <option value="0"><?php echo $text_checkboxes; ?></option>
                                <option value="1" selected="selected"><?php echo $text_radio_buttons; ?></option>
                            <?php } else { ?>
                                <option value="0" selected="selected"><?php echo $text_checkboxes; ?></option>
                                <option value="1"><?php echo $text_radio_buttons; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tbody id="modal">
                    <tr>
                        <td colspan="2"><b><?php echo $text_modal_popup_settings; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_modal_timeout; ?></td>
                        <td><input type="text" name="modal_timeout" value="<?php echo $modal_timeout; ?>" size="3" /></td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_modal_repeat_time; ?></td>
                        <td><input type="text" name="repeat_time" value="<?php echo $repeat_time; ?>" size="3" /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b><?php echo $text_modal_popup_style; ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_modal_bg_color; ?></td>
                        <td><input class="colorpicker_f" type="text" name="modal_bg_color" value="<?php echo $modal_bg_color; ?>" size="7" maxlength="7" /></td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_modal_line_color; ?></td>
                        <td><input class="colorpicker_f" type="text" name="modal_line_color" value="<?php echo $modal_line_color; ?>" size="7" maxlength="7" /></td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_modal_heading_color; ?></td>
                        <td><input class="colorpicker_f" type="text" name="modal_heading_color" value="<?php echo $modal_heading_color; ?>" size="7" maxlength="7" /></td>
                    </tr>
                </tbody>
            </table>
            <table class="form">
                <tr>
                    <td colspan="2">
                        <div id="languages" class="htabs">
                            <?php foreach ($languages as $language) { ?>
                            <a href="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
                            <?php } ?>
                        </div>
                        <?php foreach ($languages as $language) { ?>
                          <div id="language<?php echo $language['language_id']; ?>">
                            <table class="form">
                              <tr>
                                <td><?php echo $entry_heading; ?></td>
                                <td><input type="text" name="heading[<?php echo $language['language_id']; ?>]" size="100" value="<?php echo isset($heading[$language['language_id']]) ? $heading[$language['language_id']] : ''; ?>" /></td>
                              </tr>
                              <tr>
                                <td><?php echo $entry_text; ?></td>
                                <td><textarea name="text[<?php echo $language['language_id']; ?>]" id="text<?php echo $language['language_id']; ?>"><?php echo isset($text[$language['language_id']]) ? $text[$language['language_id']] : ''; ?></textarea></td>
                              </tr>
                            </table>
                          </div>
                        <?php } ?>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('text<?php echo $language['language_id']; ?>', {
    height: 200,
    filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
<?php } ?>
//--></script>
<script type="text/javascript"><!--
    $('select[name=type]').bind('change', function(){
        if ($(this).val() == '1') {
            $('#modal').hide();
        } else {
            $('#modal').show();
        }
    });

    $('select[name=type]').trigger('change');

    $('.colorpicker_f').ColorPicker({
        onSubmit: function(hsb, hex, rgb, el) {
            $(el).val('#' + hex);
            $(el).ColorPickerHide();
        },
        onBeforeShow: function () {
            $(this).ColorPickerSetColor(this.value);
        }
    })
    .bind('keyup', function(){
        $(this).ColorPickerSetColor(this.value);
    });
//--></script>
<script type="text/javascript"><!--
$('#tabs a').tabs();
$('#languages a').tabs();
$('#vtab-option a').tabs();
//--></script>
<?php echo $footer; ?>