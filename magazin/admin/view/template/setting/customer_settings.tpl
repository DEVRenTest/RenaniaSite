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
      <h1><img src="view/image/setting.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
      <div>
        <table class="list" style="max-width: 600px;">
          <thead>
            <tr>
              <td colspan="2" class="left"><?php echo $text_edit_page; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="left">
                <label for="jump-to-store-select"><?php echo $text_store; ?></label>
                <select id="jump-to-store-select">
                <?php foreach ($stores as $store) { ?>
                  <option value="<?php echo $store['id']; ?>"><?php echo $store['name']; ?></option>
                <?php } ?>
                </select>
              </td>
              <td class="left">
                <a id="jump-to-store" class="button"><?php echo $button_edit; ?></a>
              </td>
            </tr>
            <tr>
              <td class="left">
                <label for="jump-to-customer-autocomplete"><?php echo $text_customer; ?></label>
                <input id="jump-to-customer-autocomplete" class="customer_search" type="text" size="56" placeholder="<?php echo $text_customer; ?>"/>
                <input type="hidden"/>
              </td>
              <td class="left">
                <a id="jump-to-customer" class="button"><?php echo $button_edit; ?></a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <form id="customer_settings_form">
        <input type="hidden" name="form_type" value="add_only"/>
        <table class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $text_store; ?></td>
              <td class="left"><?php echo $text_customer; ?></td>
              <td class="left"><?php echo $text_group; ?></td>
              <td class="left"><?php echo $text_key; ?></td>
              <td class="left"><?php echo $text_value; ?></td>
              <td class="left"><?php echo $text_value_type; ?></td>
              <td class="left" width="1"></td>
            </tr>
          </thead>
          <tbody>
            <tr id="input_0">
              <td class="left">
                <select name="settings[0][store_id]" required="required">
                <?php foreach ($stores as $store) { ?>
                  <option value="<?php echo $store['id']; ?>"><?php echo $store['name']; ?></option>
                <?php } ?>
                </select>
              </td>
              <td class="left">
                <input class="customer_search" type="text" size="56" placeholder="<?php echo $text_customer; ?>" required="required"/>
                <input type="hidden" name="settings[0][customer_id]" value="0"/>
              </td>
              <td class="left">
                <input type="text" name="settings[0][group]" placeholder="<?php echo $text_group; ?>" required="required"/>
              </td>
              <td class="left">
                <input type="key" name="settings[0][key]" placeholder="<?php echo $text_key; ?>" required="required"/>
              </td>
              <td class="left">
                <textarea name="settings[0][value]" required="required"></textarea>
              </td class="left">
              <td class="left">
                <input id="is_json_row_0_val_0" type="radio" name="settings[0][is_json]" value="0" checked="checked"/>
                <label for="is_json_row_0_val_0"><?php echo $text_string; ?></label>
                <br />
                <input id="is_json_row_0_val_1" type="radio" name="settings[0][is_json]" value="1"/>
                <label for="is_json_row_0_val_1"><?php echo $text_array; ?></label>
              </td>
              <td class="left">
                <a class="button remove"><?php echo $button_remove; ?></a>
              </td>
            </tr>
          </tbody>
        </table>
        <a class="button" id="moar"><?php echo $button_insert; ?></a>
        <a class="button" onclick="$('#customer_settings_form').submit()"><?php echo $button_save; ?></a>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  var table_counter = 0;
  $('#moar').on('click', function(){
    table_counter++;
    var new_row = '';
    new_row += '<tr id="input_' + table_counter + '">';
    new_row +=   '<td class="left">';
    new_row +=     '<select name="settings[' + table_counter + '][store_id]" required="required">';
    <?php foreach ($stores as $store) { ?>
    new_row +=       '<option value="<?php echo $store['id']; ?>"><?php echo $store['name']; ?></option>';
    <?php } ?>
    new_row +=     '</select>';
    new_row +=   '</td>';
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
  $('#content').on('focus', '.customer_search', function(){
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
            $('#customer_settings_form table tbody').empty();
            table_counter = -1;
            $('#moar').trigger('click');
          }
        }
      });
    }
  });
  $('#jump-to-store').on('click', function(){
    window.location.href = '<?php echo html_entity_decode($customer_settings_url); ?>&store_id=' + $(this).closest('tr').find('select').val();
  });
  $('#jump-to-customer').on('click', function(){
    var jump_to_customer_id = $(this).closest('tr').find('input[type="hidden"]').val();
    if (jump_to_customer_id) {
      window.location.href = '<?php echo html_entity_decode($customer_settings_url); ?>&customer_id=' + jump_to_customer_id;
    } else {
      $('#jump-to-customer-autocomplete').attr('style', 'outline: 1px solid red;');
      $('#jump-to-customer-autocomplete').focus();
    }
  });
</script>
<?php echo $footer; ?>