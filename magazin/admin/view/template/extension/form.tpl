<?php echo $header; ?>
<div id="content">
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	<div class="box">
		<div class="heading">
			<h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title; ?></h1>
			<div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a></div>
		</div>
		<div class="content">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
				<div id="google-form">
					<table class="list" style="width: 40%;">
						<thead>
							<tr>
								<td class="left" colspan="3"><?php echo $text_customer_groups; ?></td>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($config_google_form_customer_group as $x) { ?>
							<tr>
								<td>
									<?php echo $google_form_simple_array[$x]; ?>
									<input type="hidden" name="config_google_form_customer_group[<?php echo $x; ?>]" value="<?php echo $x; ?>" />
								</td>
								<td class="left short-cell">
									<a class="button purge-parent"><?php echo $button_remove; ?></a>
								</td>
							</tr>
							<?php } ?>
							<tr id="more-customer-group">
								<td class="left" colspan="4">
									<label for="google_form_customer_groups"><?php echo $entry_add_group; ?></label>
									<select id="google_form_customer_groups">
										<?php foreach ($customer_groups as $customer_group) { ?>
										<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
										<?php } ?>
									</select>
									<a class="button"><?php echo $button_insert; ?></a>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="list" style="width: 40%;">
						<thead>
							<tr>
								<td class="left" colspan="4"><?php echo $text_customer; ?></td>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($form_customers as $x) { ?>
							<tr>
								<td>
									<?php echo $x['name'] . ' (' . $x['email'] . ')'; ?>
									<input type="hidden" name="form_customers[]" value="<?php echo $x['customer_id']; ?>" />
								</td>
								<td class="left short-cell">
									<a class="button purge-parent"><?php echo $button_remove; ?></a>
								</td>
							</tr>
							<?php } ?>
							<tr id="more-customer">
								<td class="left" colspan="4">
									<label for="customer_autocomplete"><?php echo $entry_add_customer; ?></label>
									<input type="text" id="customer_autocomplete" size="50"></input>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="form" style="width: 40%;">
						<tr>
							<td><?php echo $text_google_form_url; ?></td>
							<td><input type="text" name="google_form_url" value="<?php echo $google_form_url; ?>" size="50" /></td>
						</tr>
						<tr>
							<td><?php echo $text_page_url; ?></td>
							<td><input type="text" name="google_form_page_url" value="<?php echo $google_form_page_url; ?>" size="50" /></td>
						</tr>
						<tr>
							<td><?php echo $text_frequency; ?></td>
							<td><input type="text" name="google_form_frequency" value="<?php echo $google_form_frequency; ?>" size="15" /></td>
						</tr>
						<tr>
							<td><?php echo $text_status; ?></td>
							<td><select name="google_form_status" style="width: 100px">
								<?php if ($google_form_status == '1') { ?>
								<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								<?php } else { ?>
								<option value="1"><?php echo $text_enabled; ?></option>
								<?php } ?>
								<?php if ($google_form_status == '0') { ?>
								<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								<?php } else { ?>
								<option value="0"><?php echo $text_disabled; ?></option>
								<?php } ?>
								</select>
							</td>
						</tr>
					</table>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript"><!--

// customer autocomplete on google form
$(document).ready(function(){
  $('#more-customer-group').on('click', 'a.button', function(){
    $(this).closest('tr').before(
       '<tr>' +
        '<td class="left">' + $('#google_form_customer_groups option:selected').text() + '</td>' +
        '<input type="hidden" name="config_google_form_customer_group[]" value="' + $('#google_form_customer_groups').val() + '"/>' +
        '<td class="left short-cell">' +
          '<a class="button purge-parent"><?php echo $button_remove; ?></a>' +
        '</td>' +
      '</tr>'
    );
    group_counter++;
  });
  $('#google-form').on('click', '.purge-parent', function(){
    $(this).closest('tr').remove();
  });

  $('#customer_autocomplete').autocomplete({
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
      $('#customer_autocomplete').closest('tr').before(
        '<tr>' +
          '<td class="left">' +
            ui.item.label +
            '<input type="hidden" name="form_customers[]" value="' + ui.item.value + '"/>' +
          '</td>' +
          '<td class="left short-cell">' +
            '<a class="button purge-parent"><?php echo $button_remove; ?></a>' +
          '</td>' +
        '</tr>'
      );
      customer_counter++;
      return false;
    }
  });
});
//--></script>
<?php echo $footer; ?>