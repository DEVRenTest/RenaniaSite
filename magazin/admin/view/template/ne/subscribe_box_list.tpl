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
            <h1><img src="view/image/ne/templates.png" alt="" width="22" height="22" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a onclick="$('#form-save').submit();" class="button"><span><?php echo $button_save; ?></span></a> <a onclick="$('#form').attr('action', '<?php echo $copy; ?>'); $('#form').submit();" class="button"><span><?php echo $button_copy; ?></span></a> <a onclick="location = '<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a> <a onclick="$('#form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
        </div>
        <div class="content">
            <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="list">
                    <thead>
                        <tr>
                            <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
                            <td class="left"><?php echo $column_name; ?></td>
                            <td class="left"><?php echo $column_last_change; ?></td>
                            <td class="left"><?php echo $column_status; ?></td>
                            <td class="right"><?php echo $column_actions; ?></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($subscribe_boxes) { ?>
                        <?php foreach ($subscribe_boxes as $subscribe_box) { ?>
                        <tr>
                            <td style="text-align: center;">
                                <?php if ($subscribe_box['selected']) { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $subscribe_box['subscribe_box_id']; ?>" checked="checked" />
                                <?php } else { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $subscribe_box['subscribe_box_id']; ?>" />
                                <?php } ?>
                            </td>
                            <td class="left"><?php echo $subscribe_box['name']; ?></td>
                            <td class="left"><?php echo $subscribe_box['datetime']; ?></td>
                            <td class="left">
                                <?php if ($subscribe_box['status']) { ?>
                                    <?php echo $text_enabled; ?>
                                <?php } else { ?>
                                    <?php echo $text_disabled; ?>
                                <?php } ?>
                            </td>
                            <td align="right">[ <a href="<?php echo $edit . $subscribe_box['subscribe_box_id']; ?>"><?php echo $button_edit; ?></a> ]</td>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </form>
            <?php if ($subscribe_boxes) { ?>
            <form action="<?php echo $save; ?>" method="post" enctype="multipart/form-data" id="form-save">
                <table id="module" class="list">
                    <thead>
                        <tr>
                            <td class="left"><?php echo $entry_subscribe_box; ?></td>
                            <td class="left"><?php echo $entry_store; ?></td>
                            <td class="left"><?php echo $entry_layout; ?></td>
                            <td class="left"><?php echo $entry_position; ?></td>
                            <td class="left"><?php echo $entry_status; ?></td>
                            <td class="left"><?php echo $entry_sort_order; ?></td>
                            <td></td>
                        </tr>
                    </thead>
                    <?php $module_row = 0; ?>
                    <?php foreach ($modules as $module) { ?>
                    <tbody id="module-row<?php echo $module_row; ?>">
                        <tr>
                            <td class="left"><select name="ne_module[<?php echo $module_row; ?>][subscribe_box_id]">
                            <?php foreach ($subscribe_boxes as $subscribe_box) { ?>
                                <?php if ($subscribe_box['subscribe_box_id'] == $module['subscribe_box_id']) { ?>
                                    <option value="<?php echo $subscribe_box['subscribe_box_id']; ?>" selected="selected"><?php echo $subscribe_box['name']; ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $subscribe_box['subscribe_box_id']; ?>"><?php echo $subscribe_box['name']; ?></option>
                                <?php } ?>
                            <?php } ?>
                            </select></td>
                            <td class="left"><select name="ne_module[<?php echo $module_row; ?>][store]">
                            <?php foreach ($stores as $store) { ?>
                                <?php if ($store['store_id'] == $module['store']) { ?>
                                    <option value="<?php echo $store['store_id']; ?>" selected="selected"><?php echo $store['name']; ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
                                <?php } ?>
                            <?php } ?>
                            </select></td>
                            <td class="left"><select name="ne_module[<?php echo $module_row; ?>][layout_id]">
                            <?php foreach ($layouts as $layout) { ?>
                                <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                                <?php } ?>
                            <?php } ?>
                            </select></td>
                            <td class="left"><select name="ne_module[<?php echo $module_row; ?>][position]">
                            <?php if ($module['position'] == 'content_top') { ?>
                                <option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
                            <?php } else { ?>
                                <option value="content_top"><?php echo $text_content_top; ?></option>
                            <?php } ?>
                            <?php if ($module['position'] == 'content_bottom') { ?>
                                <option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
                            <?php } else { ?>
                                <option value="content_bottom"><?php echo $text_content_bottom; ?></option>
                            <?php } ?>
                            <?php if ($module['position'] == 'column_left') { ?>
                                <option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
                            <?php } else { ?>
                                <option value="column_left"><?php echo $text_column_left; ?></option>
                            <?php } ?>
                            <?php if ($module['position'] == 'column_right') { ?>
                                <option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
                            <?php } else { ?>
                                <option value="column_right"><?php echo $text_column_right; ?></option>
                            <?php } ?>
                            </select></td>
                            <td class="left"><select name="ne_module[<?php echo $module_row; ?>][status]">
                            <?php if ($module['status']) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                            <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                            <?php } ?>
                            </select></td>
                            <td class="left">
                                <input type="text" name="ne_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" />
                            </td>
                            <td class="right">
                                <a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><span><?php echo $button_remove; ?></span></a>
                            </td>
                        </tr>
                    </tbody>
                    <?php $module_row++; ?>
                    <?php } ?>
                    <tfoot>
                        <tr>
                            <td colspan="6"></td>
                            <td class="right"><a onclick="addModule();" class="button"><span><?php echo $button_add_module; ?></span></a></td>
                        </tr>
                    </tfoot>
                </table>
            </form>
            <?php } ?>
        </div>
    </div>
</div>
<?php if ($subscribe_boxes) { ?>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {
    html  = '<tbody id="module-row' + module_row + '">';
    html += '  <tr>';
    html += '    <td class="left"><select name="ne_module[' + module_row + '][subscribe_box_id]">';
    <?php foreach ($subscribe_boxes as $subscribe_box) { ?>
    html += '      <option value="<?php echo $subscribe_box['subscribe_box_id']; ?>"><?php echo $subscribe_box['name']; ?></option>';
    <?php } ?>
    html += '    </select></td>';
    html += '    <td class="left"><select name="ne_module[' + module_row + '][store]">';
    <?php foreach ($stores as $store) { ?>
    html += '      <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>';
    <?php } ?>
    html += '    </select></td>';
    html += '    <td class="left"><select name="ne_module[' + module_row + '][layout_id]">';
    <?php foreach ($layouts as $layout) { ?>
    html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
    <?php } ?>
    html += '    </select></td>';
    html += '    <td class="left"><select name="ne_module[' + module_row + '][position]">';
    html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
    html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
    html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
    html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
    html += '    </select></td>';
    html += '    <td class="left"><select name="ne_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
    html += '    <td class="left"><input type="text" name="ne_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
    html += '    <td class="right"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
    html += '  </tr>';
    html += '</tbody>';

    $('#module tfoot').before(html);

    module_row++;
}
//--></script>
<?php } ?>
<?php echo $footer; ?>