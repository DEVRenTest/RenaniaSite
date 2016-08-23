<?php echo $header; ?>
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php
echo $column_left;
echo $column_right;
?>
<div id="content">
  <?php echo $content_top; ?>
  <h1 class="heading-title"><?php echo $heading_title; ?></h1>
  <form method="POST">
    <table style="max-width: 500px;">
      <tr>
        <td><?php echo $entry_company; ?></td>
        <td>
          <select name="company_id">
          <?php foreach ($companies as $company_id => $company) { ?>
            <option
              value="<?php echo $company_id; ?>"
              <?php if ($this->customer->getCompanyId() == $company_id) { ?>
              selected="selected"
              <?php } ?>>
              <?php echo $company; ?>
            </option>
          <?php } ?>
          </select>
        </td>
      </tr>
      <tr>
        <td colspan="2"><input class="button" type="submit" value="<?php echo $button_apply; ?>"/></td>
      </tr>
    </table>
  </form>
</div>
<?php
echo $content_bottom;
echo $footer;
?>