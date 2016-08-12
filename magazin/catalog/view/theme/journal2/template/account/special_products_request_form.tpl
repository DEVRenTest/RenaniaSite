<?php echo $header; ?>
<div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
</div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
    <form method="post" enctype="multipart/form-data">
    <div class="special_products_form_buttons">
      <div style="float:left;"><a href="<?php echo $add_form; ?>" class="button"><?php echo $add_form_button; ?></a></div>
      <div style="float:right;"><input type="submit" name="submit" value='<?php echo $first_upload_form_button ?>' class="button" /></div>
    </div>
    <h1 class="heading-title"><center><?php echo $heading_title; ?></center></h1>
    <?php echo $content_top; ?>
      <table class="special_products_form">
        <tr>
          <td>
            <?php echo $text_next_months_quantity; ?><span class="required">*</span></br>
            &emsp;&emsp;<?php echo $text_quantity; ?> <input type="text" name="quantity" required="required" style="width: auto;" />
            &emsp;&emsp;&emsp;&emsp;<?php echo $text_unit; ?> <input type="text" name="unit" required="required" style="width: auto;" />
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $text_initial_order_quantity; ?><span class="required">*</span></br>
            &emsp;&emsp;<?php echo $text_quantity; ?> <input type="text" name="initial_quantity" required="required" style="width: auto;" />
            &emsp;&emsp;&emsp;&emsp;<?php echo $text_unit; ?> <input type="text" name="initial_unit" required="required" style="width: auto;" /></br>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $text_order_total_value; ?><span class="required">*</span>
            <input type="text" name="total_value" required="required" style="width: auto;" /> <?php echo $text_ron; ?></br>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $text_target_price; ?><span class="required">*</span>
            <input type="text" name="target_price" required="required" style="width: auto;" /> <?php echo $text_ron; ?></br>
            &emsp;&emsp;<?php echo $text_unit; ?> <input type="text" name="target_unit" required="required" style="width: auto;" /></br>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $text_sales_arguments; ?><span class="required">*</span></br>
            <textarea type="text" name="sales_arguments" required="required" style="width: 80%;"></textarea></br>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $text_regional_manager_approval; ?><span class="required">*</span>
            <input type="radio" name="manager_approval" value="1" checked="checked" /> <?php echo $text_yes; ?>
            <input type="radio" name="manager_approval" value="0" /> <?php echo $text_no; ?></br>
          </td>
        </tr>
        <tr>
          <td>
              <?php echo $text_order_date_estimation; ?></br>
              &emsp;&emsp;<?php echo $text_first_batch; ?> <input type="date" class="date" name="first_batch" style="width: auto;" />
              <?php echo $text_second_batch; ?> <input type="date" class="date" name="second_batch" style="width: auto;" />
              <?php echo $text_third_batch; ?> <input type="date" class="date" name="third_batch" style="width: auto;" /></br>
              &emsp;&emsp;<?php echo $text_fourth_batch; ?> <input class="date" type="date" name="fourth_batch" style="width: auto;" />
              <?php echo $text_fifth_batch; ?> <input type="date" class="date" name="fifth_batch" style="width: auto;" />
              <?php echo $text_sixth_batch; ?> <input type="date" class="date" name="sixth_batch" style="width: auto;" /></br>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $text_existent_alternative_products; ?></br>
            <?php echo $text_alternative_products; ?>
            <textarea type="text" name="alternative_products" style="width: 80%; height: 20%;"></textarea></br>
            <?php echo $text_customer_feedback; ?>
            <textarea type="text" name="customer_feedback" style="width: 80%;"></textarea></br>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $text_new_provider; ?></br>
            <?php echo $text_provider_name; ?> <input type="text" name="provider_name" style="width: auto;" /></br>
            <?php echo $text_identified_circumstances; ?></br>
            <textarea type="text" name="identified_circumstances" style="width: 80%; height: 20%;"></textarea></br>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $text_other_informations; ?></br>
            <textarea type="text" name="other_informations" style="width: 80%;"></textarea>
          </td>
        </tr>
      </table>
      <div class="buttons">
        <div class="form_button" style="float: right"><input type="submit" name="submit" value='<?php echo $upload_form_button ?>' class="button" /></div>
      </div>
    </form>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>
<script type="text/javascript"><!--
$(document).ready(function() {
  $('.date').datepicker({
    dateFormat: "yy-mm-dd",
    beforeShow:function(input) {
      $(input).css({
        "position": "relative",
        "z-index": 999999
      });
    }
  });
});
//--></script>