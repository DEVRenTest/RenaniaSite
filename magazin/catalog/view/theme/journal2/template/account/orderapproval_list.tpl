<?php echo $header; ?>
<div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
</div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><h1 class="heading-title"><?php echo $heading_title; ?></h1><?php echo $content_top; ?>
  <?php if ($orders) { ?>
  <form method="post" enctype="multipart/form-data" id="form">
    <table>
      <tbody>
        <?php foreach ($orders as $order) { ?>
        <tr>
          <td>
            <input type="checkbox" name="orders[]" value="<?php echo $order['order_id']; ?>"/>      
          </td>
          <td>
            <div class="order-list">
              <div class="order-id"><b><?php echo $text_order_id; ?></b> #<?php echo $order['order_id']; ?></div>
              <div class="order-status"><b><?php echo $text_status; ?></b> <?php echo $order['status']; ?></div>
              <div class="order-content">
                <div><b><?php echo $text_date_added; ?></b> <?php echo $order['date_added']; ?><br />
                  <b><?php echo $text_products; ?></b> <?php echo $order['products']; ?></div>
                <div><b><?php echo $text_customer; ?></b> <?php echo $order['name']; ?><br />
                  <b><?php echo $text_total; ?></b> <?php echo $order['total']; ?></div>
                <div class="order-info">
                  <a href="<?php echo $order['href']; ?>"><img src="catalog/view/theme/default/image/info.png" alt="<?php echo $button_view; ?>" title="<?php echo $button_view; ?>" /></a>
                </div>
              </div>
            </div>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <input type="hidden" name="order_status">
  </form>
    <script>
      $(document).ready(function(){
          $(".order_status").on('click', function(){
              $('input[name="order_status"]').val($(this).val());
              $('#form').submit();
          });
      });
    </script>
  <?php } else { ?>
  <div class="content"><p class="text-empty"><?php echo $text_empty; ?></p></div>
  <?php } ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
    <button value="1" class="button order_status"><?php echo $button_approve; ?></button>
    <button value="0" class="button order_status"><?php echo $button_deny; ?></button>
  </div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>