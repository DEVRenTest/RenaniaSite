<?php echo $header; ?>
<div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
</div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><h1 class="heading-title"><?php echo $heading_title; ?></h1><?php echo $content_top; ?>
  <table>
    <tbody>
      <tr>
        <td width="20%"><h4><?php echo $text_file_download ?></h4></td>
        <td class='button'><a href="<?php echo $order_model_download_link; ?>" role='button'><?php echo $file_download_button ?></a></td>
      </tr>
      <tr>
        <td><h4><?php echo $text_file_upload ?></h4></td>
        <td width="80%">
          <form method="post" enctype="multipart/form-data">
            <input type="file" name="file" id="file" accept=".csv"/>
            <input type="submit" name="submit" value='<?php echo $upload_order_button ?>' class="button" style="float: right" />
          </form>
        </td>
      </tr>
    </tbody>
  </table> 
  <?php if ($input_products && ($invalid_model || $invalid_color || $invalid_size)) { ?>
  <span class="model_error_color"></span>&nbsp;<span> <?php echo $text_model_error; ?></span></br>&nbsp;</br>
  <span class="color_error_color"></span>&nbsp;<span> <?php echo $text_color_error; ?></span></br>&nbsp;</br>
  <span class="size_error_color"></span>&nbsp;<span> <?php echo $text_size_error; ?></span></br>&nbsp;
  <table class="list">
    <thead>
      <tr>
        <td><?php echo $text_model; ?></td>
        <td><?php echo $text_color; ?></td>
        <td><?php echo $text_size; ?></td>
        <td><?php echo $text_config; ?></td>
        <td><?php echo $text_quantity; ?></td>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($input_products as $key => $prod) { ?>
    <tr<?php if (in_array($key, $invalid_model)) { ?> class="bad_row"<?php } ?>>
      <td><?php echo $prod['model'] ?></td>
      <td<?php if (in_array($key, $invalid_color)) { ?> class="bad_color"<?php } ?>><?php echo $prod['color']; ?></td>
      <td<?php if (in_array($key, $invalid_size)) { ?> class="bad_size"<?php } ?>><?php echo $prod['size']; ?></td>
      <td><?php echo $prod['config']; ?></td>
      <td><?php echo $prod['quantity']; ?></td>
    </tr>
    <?php } ?>
    </tbody>
  </table>
  <?php } ?>
  <?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>