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
<?php echo $footer; ?> 