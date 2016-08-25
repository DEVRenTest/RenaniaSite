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
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a>
        <a onclick="$('form').attr('action', '<?php echo $delete; ?>'); $('form').submit();" class="button"><?php echo $button_delete; ?></a>
      </div>
    </div>
    <div class="content">
      <div>
        <table class="list" style="max-width: 600px;">
          <thead>
            <tr>
              <td colspan="2" class="left"><?php echo $text_search; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="left">
                <label for="company-autocomplete"><?php echo $heading_title; ?></label>
                <input id="company-autocomplete" type="text" size="56"/>
                <input type="hidden"/>
              </td>
              <td class="left">
                <a id="jump-to-company" class="button"><?php echo $button_edit; ?></a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <form action="" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php echo $text_name; ?></td>
              <td class="left"><?php echo $text_ax_code; ?></td>
              <td class="left"><?php echo $text_cui; ?></td>
              <td class="left"><?php echo $text_cif; ?></td>
              <td class="right"><?php echo $text_action; ?></td>
            </tr>
          </thead>
          <tbody>
          <?php if ($companies) {
            foreach ($companies as $company) { ?>
            <tr>
              <td style="text-align: center;">
                <input type="checkbox" name="selected[]" value="<?php echo $company['company_id']; ?>"<?php if ($company['selected']) { ?> checked="checked"<?php } ?>/>
              <td class="left"><?php echo $company['name']; ?></td>
              <td class="left"><?php echo $company['ax_code']; ?></td>
              <td class="left"><?php echo $company['CUI']; ?></td>
              <td class="left"><?php echo $company['CIF']; ?></td>
              <td class="right">[ <a href="<?php echo $company['href']; ?>"><?php echo $button_edit; ?></a> ]</td>
            </tr>
            <?php }
          } else { ?>
            <tr>
              <td class="center" colspan="10"><?php echo $text_no_results; ?></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript">
  var company_id = 0;
  $('#company-autocomplete').autocomplete({
    delay: 300,
    source: function(request, response) {
      $.ajax({
        url: 'index.php?route=sale/company/autocomplete&token=<?php echo $token; ?>&term=' + encodeURIComponent(request.term),
        dataType: 'json',
        success: function(json) {
          response($.map(json, function(item) {
            return {
              label: item.name + ' (' + item.CIF + ', ' + item.ax_code + ', ' + item.CUI + ')',
              value: item.company_id
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
      $('#company-autocomplete').val(ui.item.label);
      company_id = ui.item.value;
    }
  });
  $('#jump-to-company').on('click', function(){
    window.location.href = '<?php echo html_entity_decode($company_edit_url); ?>&company_id=' + company_id;
  });
</script>
<?php echo $footer; ?> 