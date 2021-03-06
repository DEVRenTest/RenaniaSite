<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="messages"></div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/setting.png" alt="" /> <?php echo $heading_title_store; ?></h1>
    </div>
    <div class="content">
      <form id="customer_settings_form">
        <input type="hidden" name="form_type" value="store"/>
        <input type="hidden" name="store_id" value="<?php echo $store_id; ?>"/>
        <table class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $text_customer; ?></td>
              <td class="left"><?php echo $text_group; ?></td>
              <td class="left"><?php echo $text_key; ?></td>
              <td class="left"><?php echo $text_value; ?></td>
              <td class="left"><?php echo $text_value_type; ?></td>
              <td class="left" width="1"></td>
            </tr>
          </thead>
          <tbody>
          <?php for ($i=0; $i < count($current_settings); $i++) { ?>
            <tr id="input_<?php echo $i; ?>">
              <td class="left">
                <input class="customer_search" type="text" size="56" value="<?php echo $current_settings[$i]['customer_name']; ?>" required="required"/>
                <input type="hidden" name="settings[<?php echo $i; ?>][customer_id]" value="<?php echo $current_settings[$i]['customer_id']; ?>"/>
              </td>
              <td class="left">
                <input type="text" name="settings[<?php echo $i; ?>][group]" value="<?php echo $current_settings[$i]['group']; ?>" required="required"/>
              </td>
              <td class="left">
                <input type="key" name="settings[<?php echo $i; ?>][key]" value="<?php echo $current_settings[$i]['key']; ?>" required="required"/>
              </td>
              <td class="left">
                <textarea name="settings[<?php echo $i; ?>][value]" required="required"><?php echo ($current_settings[$i]['is_json'] ? htmlspecialchars(json_encode($current_settings[$i]['value']), ENT_COMPAT, 'UTF-8') : $current_settings[$i]['value']); ?></textarea>
              </td class="left">
              <td class="left">
                <input id="is_json_row_<?php echo $i; ?>_val_0" type="radio" name="settings[<?php echo $i; ?>][is_json]" value="0"<?php if (!$current_settings[$i]['is_json']) { ?> checked="checked"<?php } ?>/>
                <label for="is_json_row_<?php echo $i; ?>_val_0"><?php echo $text_string; ?></label>
                <br />
                <input id="is_json_row_<?php echo $i; ?>_val_1" type="radio" name="settings[<?php echo $i; ?>][is_json]" value="1"<?php if ($current_settings[$i]['is_json']) { ?> checked="checked"<?php } ?>/>
                <label for="is_json_row_<?php echo $i; ?>_val_1"><?php echo $text_array; ?></label>
              </td>
              <td class="left">
                <a class="button remove"><?php echo $button_remove; ?></a>
              </td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
        <a class="button" id="moar"><?php echo $button_insert; ?></a>
        <a class="button" onclick="$('#customer_settings_form').submit()"><?php echo $button_save; ?></a>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  var table_counter = <?php echo count($current_settings); ?>;
  $('#moar').on('click', function(){
    table_counter++;
    var new_row = '';
    new_row += '<tr id="input_' + table_counter + '">';
    new_row +=   '<td class="left">';
    new_row +=     '<input class="customer_search" type="text" size="56" placeholder="<?php echo $text_customer; ?>" required="required"/>';
    new_row +=     '<input type="hidden" name="settings[' + table_counter + '][customer_id]" value="0"/>';
    new_row +=   '</td>';
    new_row +=   '<td class="left">';
    new_row +=     '<input type="text" name="settings[' + table_counter + '][group]" placeholder="<?php echo $text_group; ?>" required="required"/>';
    new_row +=   '</td>';
    new_row +=   '<td class="left">';
    new_row +=     '<input type="key" name="settings[' + table_counter + '][key]" placeholder="<?php echo $text_key; ?>" required="required"/>';
    new_row +=   '</td>';
    new_row +=   '<td class="left">';
    new_row +=     '<textarea name="settings[' + table_counter + '][value]" required="required"></textarea>';
    new_row +=   '</td class="left">';
    new_row +=   '<td class="left">';
    new_row +=     '<input id="is_json_row_' + table_counter + '_val_0" type="radio" name="settings[' + table_counter + '][is_json]" value="0" checked="checked"/>'
    new_row +=     '<label for="is_json_row_' + table_counter + '_val_0"><?php echo $text_string; ?></label>'
    new_row +=     '<br />'
    new_row +=     '<input id="is_json_row_' + table_counter + '_val_1" type="radio" name="settings[' + table_counter + '][is_json]" value="1"/>'
    new_row +=     '<label for="is_json_row_' + table_counter + '_val_1"><?php echo $text_array; ?></label>'
    new_row +=   '</td>';
    new_row +=   '<td class="left">';
    new_row +=     '<a class="button remove"><?php echo $button_remove; ?></a>';
    new_row +=   '</td>';
    new_row += '</tr>';
    $('#customer_settings_form table tbody').append(new_row);
  });
  $('#customer_settings_form').on('click', '.button.remove', function(){
    $(this).closest('tr').remove();
  });
  $('#customer_settings_form').on('focus', 'input[name$="[group]"]', function(){
    $(this).autocomplete({
      delay: 300,
      source: function(request, response) {
        $.ajax({
          url: 'index.php?route=setting/customer_settings/autocompletegroup&token=<?php echo $token; ?>&group=' +  encodeURIComponent(request.term),
          dataType: 'json',
          success: function(json) {
            response($.map(json, function(item) {
              return {
                label: item,
                value: item
              }
            }));
          }
        });
      },
    });
  });
  $('#customer_settings_form').on('focus', 'input[name$="[key]"]', function(){
    var group_value = $(this).closest('tr').find('input[name$="[group]"]').val();
    $(this).autocomplete({
      delay: 300,
      source: function(request, response) {
        $.ajax({
          url: 'index.php?route=setting/customer_settings/autocompletekey&token=<?php echo $token; ?>&key='
            +  encodeURIComponent(request.term)
            + (group_value !== '' ? '&group=' + encodeURIComponent(group_value) : ''),
          dataType: 'json',
          success: function(json) {
            response($.map(json, function(item) {
              return {
                label: item,
                value: item
              }
            }));
          }
        });
      },
    });
  });
  $('#customer_settings_form').on('focus', '.customer_search', function(){
    customer_search = $(this);
    $(this).autocomplete({
      delay: 300,
      source: function(request, response) {
        $.ajax({
          url: 'index.php?route=sale/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
          dataType: 'json',
          success: function(json) {
            response($.map(json, function(item) {
              return {
                label: item.name + ' (' + item.email + ')',
                value: item.customer_id
              }
            }));
          }
        });
      },
      focus: function(event, ui) {
        return false;
      },
      select: function(event, ui){
        event.preventDefault();
        customer_search.val(ui.item.label);
        customer_search.next('input').val(ui.item.value);
      }
    });
  });
  $('#customer_settings_form').submit(function(e){
    e.preventDefault();
    if ($(this)[0].checkValidity()) {
      $.ajax({
        url: 'index.php?route=setting/customer_settings/processPostData&token=<?php echo $token; ?>',
        type: 'POST',
        data: $('#customer_settings_form').serialize(),
        dataType: 'json',
        success: function(json) {
          $('.messages').empty();
          $('#customer_settings_form input, #customer_settings_form textarea').removeAttr('style');
          if (json.hasOwnProperty('errors')) {
            for (var i = json.errors.messages.length - 1; i >= 0; i--) {
              $('.messages').append('<div class="attention">' + json.errors.messages[i] + '</div>');
            }
            if (json.errors.hasOwnProperty('invalid_groups')) {
              for (var i = json.errors.invalid_groups.length - 1; i >= 0; i--) {
                $('input[name$="settings[' + json.errors.invalid_groups[i] + '][group]"]').css('outline', '2px dashed #24FF24');
              }
            }
            if (json.errors.hasOwnProperty('invalid_keys')) {
              for (var i = json.errors.invalid_keys.length - 1; i >= 0; i--) {
                $('input[name$="settings[' + json.errors.invalid_keys[i] + '][key]"]').css('outline', '2px dotted #490092');
              }
            }
            if (json.errors.hasOwnProperty('invalid_values')) {
              for (var i = json.errors.invalid_values.length - 1; i >= 0; i--) {
                $('textarea[name$="settings[' + json.errors.invalid_values[i] + '][value]"]').css('outline', '4px double #6DB6FF');
              }
            }
            if (json.errors.hasOwnProperty('invalid_arrays')) {
              for (var i = json.errors.invalid_arrays.length - 1; i >= 0; i--) {
                $('textarea[name$="settings[' + json.errors.invalid_arrays[i] + '][value]"]').css('outline', '2px solid #920000');
              }
            }
          } else if (json.hasOwnProperty('success')) {
            $('.messages').append('<div class="success">' + json.success + '</div>');
          }
        }
      });
    }
  });
</script>
<?php echo $footer; ?>