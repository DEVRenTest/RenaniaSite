<?php echo $header ?>
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
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs">
        <a href="#tab-general"><?php echo $tab_general; ?></a>
        <a href="#tab-customers"><?php echo $tab_customers; ?></a>
      </div>
      <form action="<?php echo $action; ?>" method="POST" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <table class="form">
            <tbody>
              <tr>
                <td><label for="input-name"><span class="required">*</span> <?php echo $text_name; ?></label></td>
                <td>
                  <input id="input-name" name="name" type="text" value="<?php echo $name; ?>" required="required"/>
                  <?php if ($error_name) { ?>
                  <span class="error"><?php echo $error_name; ?></span>
                  <?php } ?>
                </td>
              </tr>
              <tr>
                <td><label for="input-ax-code"><?php echo $text_ax_code; ?></label></td>
                <td>
                  <input id="input-ax-code" name="ax_code" type="text" value="<?php echo $ax_code; ?>"/>
                  <?php if ($error_ax_code) { ?>
                  <span class="error"><?php echo $error_ax_code; ?></span>
                  <?php  } ?>
                </td>
              </tr>
              <tr>
                <td><label for="input-cui"><?php echo $text_cui; ?></label></td>
                <td>
                  <input id="input-cui" name="cui" type="text" value="<?php echo $cui; ?>"/>
                  <?php if ($error_cui) { ?>
                  <span class="error"><?php echo $error_cui; ?></span>
                  <?php  } ?>
                </td>
              </tr>
              <tr>
                <td><label for="input-cif"><?php echo $text_cif; ?></label></td>
                <td>
                  RO
                  <input id="input-cif" name="cif" type="text" value="<?php echo $cif; ?>" />
                  <?php if ($error_cif) { ?>
                  <span class="error"><?php echo $error_cif; ?></span>
                  <?php  } ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div id="tab-customers">
          <table class="list" style="max-width: 600px;">
            <thead>
              <tr>
                <td class="left" colspan="2"><?php echo $text_name; ?></td>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($customers as $customer) { ?>
              <tr>
                <td class="left">
                  <?php echo $customer['name'] . ' (' . $customer['email'] . ')'; ?>
                  <input name="customers[]" type="hidden" value="<?php echo $customer['customer_id']; ?>"/>
                </td>
                <td class="left"><a class="button purge-parent"><?php echo $button_remove; ?></a></td>
              </tr>
            <?php } ?>
              <tr>
                <td class="left" colspan="2">
                  <label for="customer-autocomplete"><?php echo $text_add_customer; ?></label>
                  <input id="customer-autocomplete" type="text"/>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
  $('#tabs a').tabs();
  $('.content').on('click', '.purge-parent', function(){
    $(this).closest('tr').remove();
  });
  $('#customer-autocomplete').autocomplete({
    delay: 3,
    source: function(request, response) {
      $.ajax({
        url: 'index.php?route=sale/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
        dataType: 'json',
        data: {token: '<?php echo $token; ?>', filter_name: encodeURIComponent(request.term)},
        type: 'POST',
        success: function(json) {
          response($.map(json, function(item) {
            return {
              label: item.firstname + ' ' + item.lastname + ' (' + item.email + ')',
              value: item.customer_id
            }
          }));
        }
      });
    },
    select: function(event, ui) {
      $('#customer-autocomplete').closest('tr').before(
        '<tr>' +
          '<td class="left">' +
            ui.item.label +
            '<input name="customers[]" type="hidden" value="' + ui.item.value + '"/>' +
          '</td>' +
          '<td class="left"><a class="button purge-parent"><?php echo $button_remove; ?></a></td>' +
        '</tr>'
      );
      return false;
    }
  });
//--></script> 
<?php echo $footer; ?>