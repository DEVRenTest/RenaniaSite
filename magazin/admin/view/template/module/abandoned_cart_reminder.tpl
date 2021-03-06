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

<div class="box">

  <div class="heading">

    <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>

    <div class="buttons"><a onclick="$('#form').submit();" class="acr-button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="acr-button"><?php echo $button_cancel; ?></a></div>

  </div>

  <div class="content">

	<div id="total-recovered"></div>

  

	<div id="tabs" class="vtabs">

		<a href="#tab-setting"><?php echo $tab_setting; ?></a>

		<a href="#tab-coupon"><?php echo $tab_coupon; ?></a>

		<a href="#tab-email"><?php echo $tab_email; ?></a>

		<a href="#tab-abandoned-cart"><?php echo $tab_abandoned_cart; ?></a>

		<a href="#tab-history"><?php echo $tab_history; ?></a>

		<a href="#tab-help"><?php echo $tab_help; ?></a>

	</div>

  

    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">

	

	<div id="tab-setting" class="vtabs-content">

		  <table class="form">

			<tr>

				<td class="left"><?php echo $entry_secret_code; ?></td>

				<td class="left"><input type="text" name="abandoned_cart_reminder_secret_code" value="<?php echo $abandoned_cart_reminder_secret_code; ?>">

				<?php if ($error_secret_code) { ?>

				<span class="error"><?php echo $error_secret_code; ?></span>

				<?php } ?>

				</td>

			</tr>

			

			<tr>

				<td class="left"><?php echo $entry_delay; ?></td>

				<td class="left"><input type="text" name="abandoned_cart_reminder_delay" value="<?php echo $abandoned_cart_reminder_delay; ?>">

				<?php if ($error_delay) { ?>

				<span class="error"><?php echo $error_delay; ?></span>

				<?php } ?>

				</td>

			</tr>



			<tr>

				<td class="left"><?php echo $entry_max_delay; ?></td>

				<td class="left"><input type="text" name="abandoned_cart_max_reminder_delay" value="<?php echo $abandoned_cart_max_reminder_delay; ?>">

				<?php if ($error_max_delay) { ?>

				<span class="error"><?php echo $error_max_delay; ?></span>

				<?php } ?>

				</td>

			</tr>

			

			<tr>

				<td class="left"><?php echo $entry_max_reminders; ?></td>

				<td class="left"><input type="text" name="abandoned_cart_reminder_max_reminders" value="<?php echo $abandoned_cart_reminder_max_reminders; ?>">

				<?php if ($error_max_reminders) { ?>

				<span class="error"><?php echo $error_max_reminders; ?></span>

				<?php } ?>

				</td>

			</tr>



			<tr>

				<td class="left"><?php echo $entry_hide_out_stock; ?></td>

				<td><select name="abandoned_cart_reminder_hide_out_stock">

					<?php if ($abandoned_cart_reminder_hide_out_stock) { ?>

					<option value="1" selected="selected"><?php echo $text_enabled; ?></option>

					<option value="0"><?php echo $text_disabled; ?></option>

					<?php } else { ?>

					<option value="1"><?php echo $text_enabled; ?></option>

					<option value="0" selected="selected"><?php echo $text_disabled; ?></option>

					<?php } ?>

				</select>

				</td>

			</tr>

			

			<tr>

				<td class="left"><?php echo $entry_use_html_email; ?></td>

				<td><select name="abandoned_cart_reminder_use_html_email">

					<?php if ($abandoned_cart_reminder_use_html_email) { ?>

					<option value="1" selected="selected"><?php echo $text_enabled; ?></option>

					<option value="0"><?php echo $text_disabled; ?></option>

					<?php } else { ?>

					<option value="1"><?php echo $text_enabled; ?></option>

					<option value="0" selected="selected"><?php echo $text_disabled; ?></option>

					<?php } ?>

				</select>

				

				<?php if ($error_use_html_email){  ?>

				<span class="error"><?php echo $error_use_html_email; ?></span>

				<?php } ?>

				</td>

			</tr>

		  </table>

	</div>



	<div id="tab-coupon" class="vtabs-content">

		<table class="form" id="acr">

			<tr>

				<td class="left"><?php echo $entry_add_coupon; ?></td>

				<td class="left"><select name="abandoned_cart_reminder_add_coupon">

				<?php if ($abandoned_cart_reminder_add_coupon) {  ?>

					<option value="1" selected="selected"><?php echo $text_enabled; ?></option>			

					<option value="0"><?php echo $text_disabled; ?></option>			

				<?php } else { ?>

					<option value="1"><?php echo $text_enabled; ?></option>			

					<option value="0" selected="selected"><?php echo $text_disabled; ?></option>

				<?php } ?>

				</select></td>

			</tr>

			

			<tbody id="coupon-1" class="coupon">

				<tr>

					<td class="left"><?php echo $entry_coupon_type; ?></td>

					<td class="left"><select name="abandoned_cart_reminder_coupon_type">

					<?php if ($abandoned_cart_reminder_coupon_type) {  ?>

						<option value="1" selected="selected"><?php echo $text_coupon_percent; ?></option>			

						<option value="0"><?php echo $text_coupon_fixed; ?></option>			

					<?php } else { ?>

						<option value="1"><?php echo $text_coupon_percent; ?></option>			

						<option value="0" selected="selected"><?php echo $text_coupon_fixed; ?></option>

					<?php } ?>

					</select></td>

				</tr>

				

				<tr>

					<td class="left"><?php echo $entry_coupon_amount; ?></td>

					<td class="left"><input type="text" name="abandoned_cart_reminder_coupon_amount" value="<?php echo $abandoned_cart_reminder_coupon_amount; ?>">

					<?php if ($error_coupon_amount) { ?>

					<span class="error"><?php echo $error_coupon_amount; ?></span>

					<?php } ?>

					</td>

				</tr>

				

				<tr>

					<td class="left"><?php echo $entry_coupon_total; ?></td>

					<td class="left"><input type="text" name="abandoned_cart_reminder_coupon_total" value="<?php echo $abandoned_cart_reminder_coupon_total; ?>"></td>

				</tr> 				

				

				<tr>

					<td class="left"><?php echo $entry_coupon_expire; ?></td>

					<td class="left"><input type="text" name="abandoned_cart_reminder_coupon_expire" value="<?php echo $abandoned_cart_reminder_coupon_expire; ?>">

					<?php if ($error_coupon_expire) { ?>

					<span class="error"><?php echo $error_coupon_expire; ?></span>

					<?php } ?>

					</td>

				</tr>

				

				<tr>

					<td class="left"><?php echo $entry_coupon_usage; ?></td>

					<td class="left"><select name="abandoned_cart_reminder_coupon_usage">

					<?php if ($abandoned_cart_reminder_coupon_usage) {  ?>

						<option value="1" selected="selected"><?php echo $text_coupon_all_products; ?></option>			

						<option value="0"><?php echo $text_coupon_cart_products; ?></option>			

					<?php } else { ?>

						<option value="1"><?php echo $text_coupon_all_products;; ?></option>			

						<option value="0" selected="selected"><?php echo $text_coupon_cart_products; ?></option>

					<?php } ?>

					</select></td>

				</tr>

				

				<tr>

					<td class="left"><?php echo $entry_reward_limit; ?></td>

					<td class="left"><input type="text" name="abandoned_cart_reminder_reward_limit" value="<?php echo $abandoned_cart_reminder_reward_limit; ?>">

					</td>

				</tr>

			</tbody>

		</table>

	</div>



	<div id="tab-email" class="vtabs-content">		

		<div id="languages" class="htabs">

			<?php foreach ($languages as $language) { ?>

			<a href="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>

			<?php } ?>

		</div>

		

		<?php foreach ($languages as $language) { ?>

		<div id="language<?php echo $language['language_id']; ?>">

			<table class="form">

				<tr>

					<td class="left"><span class="required">* </span><?php echo $entry_subject; ?></td>

					<td><input name="abandoned_cart_reminder_mail[<?php echo $language['language_id']; ?>][subject]" size="100" value="<?php echo isset($abandoned_cart_reminder_mail[$language['language_id']]) ? $abandoned_cart_reminder_mail[$language['language_id']]['subject'] : ''; ?>" />

					<?php if (isset($error_subject[$language['language_id']])) { ?>

					<span class="error"><?php echo $error_subject[$language['language_id']]; ?></span>

					<?php } ?>

					</td>

				</tr>

				<tr>

					<td><?php echo $entry_special_keyword; ?></td>

					<td><?php echo $text_special_keyword; ?></td>

				</tr>

				<tr>

					<td class="left"><span class="required">* </span><?php echo $entry_message_reward; ?></td>

					<td><textarea name="abandoned_cart_reminder_mail[<?php echo $language['language_id']; ?>][message_reward]" id="abandoned_cart_reminder_mail_reward_<?php echo $language['language_id']; ?>" cols="120" rows="8"><?php echo isset($abandoned_cart_reminder_mail[$language['language_id']]) ? $abandoned_cart_reminder_mail[$language['language_id']]['message_reward'] : ''; ?></textarea>

					<?php if (isset($error_message_reward[$language['language_id']])) { ?>

					<span class="error"><?php echo $error_message_reward[$language['language_id']]; ?></span>

					<?php } ?>

					</td>

				</tr>

				<tr>

					<td class="left"><span class="required">* </span><?php echo $entry_message_no_reward; ?></td>

					<td><textarea name="abandoned_cart_reminder_mail[<?php echo $language['language_id']; ?>][message_no_reward]" id="abandoned_cart_reminder_mail_no_reward_<?php echo $language['language_id']; ?>" cols="120" rows="8"><?php echo isset($abandoned_cart_reminder_mail[$language['language_id']]) ? $abandoned_cart_reminder_mail[$language['language_id']]['message_no_reward'] : ''; ?></textarea>

					<?php if (isset($error_message_no_reward[$language['language_id']])) { ?>

					<span class="error"><?php echo $error_message_no_reward[$language['language_id']]; ?></span>

					<?php } ?>

					</td>

				</tr>				

			</table>

		</div>

		<?php } ?>		

	</div>	

	

	<div id="tab-abandoned-cart" class="vtabs-content">

		<div id="abandoned-cart-list"><div class="acr-loading-spinner"></div></div>

	</div>

	

	<div id="tab-history" class="vtabs-content">

		<div id="abandoned-cart-history"><div class="acr-loading-spinner"></div></div>

	</div>

	

	<div id="tab-help" class="vtabs-content">

		Changelog and HELP guide is available  : <a href="http://oc-extensions.com/Abandoned-Cart-Reminder-Pro" target="blank">HERE</a> (please check tab Help)<br /><br />

		If you need support email us at <strong>support@oc-extensions.com</strong><br /><br /><br />

		

		<u><strong>Become a Premium Member:</strong></u><br /><br />

		With Premium Membership you will can download all our products (past, present and future). Find more on <a href="http://www.oc-extensions.com">www.oc-extensions.com</a>

		<br /><br />

		<a href="http://www.oc-extensions.com/1-Year-Premium-Membership"><img class="premium" src="view/image/abandoned_cart_reminder/premium.jpg"></a>

	</div>

	</form>

  </div>

</div>



<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 

<script type="text/javascript"><!--

<?php foreach ($languages as $language) { ?>

CKEDITOR.replace('abandoned_cart_reminder_mail_reward_<?php echo $language['language_id']; ?>', {

	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',

	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',

	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',

	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',

	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',

	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'

});



CKEDITOR.replace('abandoned_cart_reminder_mail_no_reward_<?php echo $language['language_id']; ?>', {

	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',

	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',

	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',

	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',

	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',

	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'

});

<?php } ?>

//--></script>

<script type="text/javascript"><!--

$('#tabs a').tabs();

$('#languages a').tabs();



$('select[name=\'abandoned_cart_reminder_add_coupon\']').bind('change', function() {

	$('#acr .coupon').hide();

	

	$('#acr #coupon-' + $(this).attr('value').replace('_', '-')).show();

});



$('select[name=\'abandoned_cart_reminder_add_coupon\']').trigger('change');



$('#abandoned-cart-list').load('index.php?route=module/abandoned_cart_reminder/getAbandonedCarts&token=<?php echo $token; ?>');

$('#abandoned-cart-history').load('index.php?route=module/abandoned_cart_reminder/getRemindersHistory&token=<?php echo $token; ?>');



<?php if ($abandoned_cart_reminder_add_coupon) { ?>

getTotalRecovered();

<?php } ?>



$('#abandoned-cart-history .pagination a').live('click', function() {

	$('#abandoned-cart-history').html('<div class="acr-loading-spinner"></div>');

	$('#abandoned-cart-history').load(this.href);

	

	return false;

});



function reminderShow(operation, customer_id){

	customer_id = typeof(customer_id) != 'undefined' ? customer_id : 0;  // 0 = send to all customers with cart abandoned

	

	$('#dialog').remove();

	

	var iframe_url = '<?php echo $front_base_url; ?>index.php?route=cron/abandoned_cart_reminder&secret_code=<?php echo $abandoned_cart_reminder_secret_code; ?>&op_type=' + operation;

	

	if (customer_id != 0) {

		iframe_url += '&filter_customer_id=' + customer_id;

	}	

	

	$('#content').prepend('<div id="dialog" style="padding: 10px; background: #FFF;"><iframe id="iframe-preview-send" src="" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');

	

	$('#dialog').dialog({

		title: 'Reminder ' + ' [' + operation + ']',

		bgiframe: false,

		<?php  if ($abandoned_cart_reminder_use_html_email) { ?>

		width: 740,

		<?php } else { ?>

		width: 640,

		<?php } ?>

		height: 640,

		resizable: false,

		modal: true,

		open: function() {

			$('#iframe-preview-send').attr('src', iframe_url);

		},

		close: function() {

			$('#iframe-preview-send').attr('src', '');

			

			if (operation == "send") {

				$('#abandoned-cart-list').html('<div class="acr-loading-spinner"></div>');

				$('#abandoned-cart-list').load('index.php?route=module/abandoned_cart_reminder/getAbandonedCarts&token=<?php echo $token; ?>');

				

				$('#abandoned-cart-history').html('<div class="acr-loading-spinner"></div>');

				$('#abandoned-cart-history').load('index.php?route=module/abandoned_cart_reminder/getRemindersHistory&token=<?php echo $token; ?>');

			}

		}

	});

}



function showReminderEmail(acr_history_id) {

	$('#dialog').remove();

	

	var iframe_url = '<?php echo $front_base_url; ?>index.php?route=cron/abandoned_cart_reminder/getHistoryEmail&secret_code=<?php echo $abandoned_cart_reminder_secret_code; ?>&acr_history_id=' + acr_history_id;

	

	$('#content').prepend('<div id="dialog" style="padding: 10px; background: #FFF;"><iframe id="iframe-reminder" src="" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');

	

	$('#dialog').dialog({

		title: 'Reminder #' + ' [' + acr_history_id + ']',

		bgiframe: false,

		<?php  if ($abandoned_cart_reminder_use_html_email) { ?>

		width: 740,

		<?php } else { ?>

		width: 640,

		<?php } ?>

		height: 640,

		resizable: false,

		modal: true,

		open: function() {

			$('#iframe-reminder').attr('src', iframe_url);

		},

		close: function() {

			$('#iframe-reminder').attr('src', '');

		}

	});

}



function getTotalRecovered() {

	$.ajax({

		url: 'index.php?route=module/abandoned_cart_reminder/getTotalRecovered&token=<?php echo $token; ?>',

		dataType: 'json',

		success: function(json) {

			if (json['total_recovered']) {

				$('#total-recovered').prepend('<div class="success" style="display:none;">' + json['total_recovered'] + '</div>');

				$('#total-recovered .success').fadeIn('slow');

			}			

		}

	})

}

//--></script> 



<script type="text/javascript"><!--

function filter() {

	url = 'index.php?route=module/abandoned_cart_reminder/getRemindersHistory&token=<?php echo $token; ?>';

	

	var filter_customer = $('input[name=\'filter_customer\']').attr('value');

	

	if (filter_customer) {

		url += '&filter_customer=' + encodeURIComponent(filter_customer);

	}	

	

	var filter_coupon_code = $('input[name=\'filter_coupon_code\']').attr('value');

	

	if (filter_coupon_code) {

		url += '&filter_coupon_code=' + encodeURIComponent(filter_coupon_code);

	}	

	

	var filter_date_added = $('input[name=\'filter_date_added\']').attr('value');

	

	if (filter_date_added) {

		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);

	}

	

	$('#abandoned-cart-history').html('<div class="acr-loading-spinner"></div>');

				

	$('#abandoned-cart-history').load(url);

}

//--></script>  





<?php echo $footer; ?>