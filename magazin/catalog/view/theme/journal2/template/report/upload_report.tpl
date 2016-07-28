<?php echo $header; ?>
<div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
</div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><h1 class="heading-title"><?php echo $heading_title; ?></h1><?php echo $content_top; ?>
  <form method="post" enctype="multipart/form-data">
    <table>
      <tbody>
        <tr>
          <td width="20%"><h4 style="margin-bottom: 20px;"><?php echo $text_download_template ?></h4></td>
          <td class='button' style="margin-bottom: 20px;"><a href="<?php echo $report_model_download_link; ?>" role='button'><?php echo $template_download_button ?></a></td>
        </tr>
        <tr>
          <td><h4><?php echo $text_report_upload ?></h4></td>
          <td width="20%">
              <input type="text" name="report_name" placeholder="<?php echo $text_report_name; ?>" required="required" />
              <?php if ($invalid_report) { ?>
              <center><span class="error"><?php echo $error_report; ?></span></center>
              <?php } ?>
          </td>
          <td width="80%">
              <input type="file" name="file" id="file" />
          </td>
        </tr>
      </tbody>
    </table>
    <div class="buttons">
      <div class="right"><input type="submit" name="submit" value='<?php echo $upload_report_button ?>' class="button" /></div>
   </div>
  </form>
  <?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>