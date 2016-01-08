<table class="list">
<thead>
  <tr>
	<td class="left"><?php echo $column_customer; ?></td>
	<td class="left"><?php echo $column_coupon_code; ?></td>
	<td class="left"><?php echo $column_coupon_used; ?></td>
	<td class="left"><?php echo $column_date_sent; ?></td>
	<td class="center"><?php echo $column_action; ?></td>
  </tr>
</thead> 
<tbody>
  <tr class="filter">
	<td><input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" /></td>
	<td><input type="text" name="filter_coupon_code" value="<?php echo $filter_coupon_code; ?>" /></td>
	<td></td>
	<td><input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" class="date" /></td>
	<td align="center"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
  </tr>  
  <?php if ($reminders) { ?>
  <?php foreach ($reminders as $reminder) { ?>
  <tr>
	<td class="left"><?php echo $reminder['customer_name']; ?></td>
	<td class="left"><?php echo $reminder['coupon_code']; ?></td>
	<td class="left"><?php echo $reminder['coupon_used']; ?></td>
	<td class="left"><?php echo $reminder['date_sent']; ?></td>
	<td class="center"><a onclick="showReminderEmail(<?php echo $reminder['acr_history_id']; ?>);" title="<?php echo $button_view_reminder; ?>"><img src="view/image/abandoned_cart_reminder/preview.png" /></a></td>
  </tr>
  <?php } ?>
  <?php } else { ?>
  <tr>
	<td class="center" colspan="5"><?php echo $text_no_results; ?></td>
  </tr>
  <?php } ?>
</tbody>
</table>

<div class="pagination"><?php echo $pagination; ?></div>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script> 