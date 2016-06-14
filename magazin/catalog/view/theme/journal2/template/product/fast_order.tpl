<?php echo $header; ?>
<div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>" itemprop="url"><span itemprop="title"><?php echo $breadcrumb['text']; ?></span></a></span>
    <?php } ?>
</div>
<?php echo $column_left; echo $column_right; ?>
<div id="content">
	<h1 class="heading-title"><?php echo $heading_title; ?></h1>
	<div class="content">
		<div class="xs-100 sm-100 md-40 lg-40 xl-40">
			<table class="table-condensed"> 
				<tbody>
					<tr>
						<th><label for="product-search"><?php echo $entry_search_product; ?></label></th>
						<td class="ui-front"><input id="product-search" placeholder="<?php echo $text_search_placeholder; ?>"/></td>
						<td style="width: 140px;"></td>
					</tr>
				</tbody>
			</table>
			<form id="fake-form" action="" method="post" onsubmit="return false">
			<table class="table-condensed">
				<tbody>
					<tr>
						<td><select id="product-size" disabled="disabled"><option value=""><?php echo $text_select_size; ?></option></select></td>
						<td><select id="product-color" disabled="disabled"><option value=""><?php echo $text_select_color; ?></option></select></td>
						<td style="width: 140px;"></td>
					</tr>
					<tr>
						<th><label for="input-pieces"><?php echo $text_pieces; ?></label></th>
						<td colspan="2"><input type="number" id="input-pieces" value="0" disabled="disabled" data-multiplier="1" style="width: 70px;"/></td>
					</tr>
					<tr>
						<th><label for="input-packages"><?php echo $text_packages; ?></label></th>
						<td colspan="2"><input type="number" id="input-packages" value="0" disabled="disabled" data-multiplier="1" style="width: 70px;"/></td>
					</tr>
					<tr>
						<td colspan="3">
							<div id="product-raw-data">
								<input type="hidden" name="product_id"/>
								<input type="hidden" name="quantity"/>
								<input type="hidden" name="product-base-price" value="0"/>
								<input type="hidden" name="product-vat-price" value="0"/>
								<input type="hidden" name="package-size" value="0"/>
								<input type="hidden" name="package-discount" value="0"/>
							</div>
							<input id="add-product" type="submit" class="button" value="<?php echo $button_add; ?>" />
						</td>
					</tr>
				</tbody>
			</table>
			</form>
		</div>
		<div id="product-info" class="xs-100 sm-100 md-40 lg-40 xl-40">
		</div>
		<form method="post" action="<?php echo $action; ?>">
			<div class="xs-100 sm-100 md-100 lg-100 xl-100 hide-overflow">
				<div class="mobile-horizontal-scroll">
					<table class="list">
						<thead>
							<tr>
								<td><?php echo $column_product; ?></td>
								<td style="width: 100px;"><?php echo $column_quantity; ?></td>
								<td><?php echo $text_price; ?></td>
								<td><?php echo $column_total; ?></td>
								<td style="width: 90px;"></td>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="xs-100 sm-100 md-100 lg-100 xl-100">
				<input type="submit" class="button" value="<?php echo $button_cart; ?>"/>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	var product_form_counter = 1;
	$(document).ready(function(){
		vanilla_fake_form = $('#fake-form').html();
		$('#product-search').autocomplete({
			minLength: 4,
			source: '/index.php?route=product/search/autocomplete',
			select: function(event, ui){
				event.preventDefault();
				$(this).val(ui.item.label);
				if (ui.item.value != 0) {
					$.ajax({
						url: '/index.php?route=product/product',
						data: {
							product_id: ui.item.value,
							ajax: 1
						},
						dataType: 'json',
						success: function(data){
							$('#fake-form').html(vanilla_fake_form);
							$('input[name="product_id"]').val(ui.item.value);
							content = '';
							content += '<h2>' + data.heading_title + '</h2>';
							content += '<ul>';
							content += '<li>' + data.text_model + data.model + '</li>';
							content += '<li class="price-list">' + data.text_price_per_piece + '<span id="display-price-piece"> ...</span>' + '</li>';
							if (data.container_size != 0) {
								content += '<li class="price-list">' + data.text_price_per_package + '<span id="display-price-package"> ...</span>' + '</li>';
								content += '<li>' + data.text_pieces_per_package + data.container_size + '</li>';
								$('#input-packages').prop('disabled', false);
								$('#input-packages').attr('data-multiplier', data.container_size);
								$('input[name="package-size"]').val(data.container_size);
								$('input[name="package-discount"]').val(data.package_discount);
								if (!data.customer_forced_buy_bulk) {
									$('#input-pieces').prop('disabled', false);
								}
							} else {
								$('#input-pieces').prop('disabled', false);
							}
							content += '</ul>';
							$('#product-info').html(content);
							update_price();
							if ('options' in data) {
								$.each(data.options, function(key, value){
									options_html = '';
									$.each(value.option_value, function(k, v){
										options_html += '<option value="' + v.product_option_value_id + '">' + v.name + '</option>';
									});
									if (value.option_id == 1) {
										$('#product-size').append(options_html);
										$('#product-size').attr('product-option-id', value.product_option_id);
										$('#product-size').prop('disabled', false);
										if (value.required == 1) {
											$('#product-size').attr('required', 'required');
										}
									} else if (value.option_id == 2) {
										$('#product-color').append(options_html);
										$('#product-color').attr('product-option-id', value.product_option_id);
										$('#product-color').prop('disabled', false);
										if (value.required == 1) {
											$('#product-color').attr('required', 'required');
										}
									}
								});
							}
						}
					});
				}
			},
		    focus: function(event, ui) {
		        return false;
		    }
		});
		$('#content').on('change', '#product-size, #product-color', function(){
			if (($('#product-color').prop('required') && $('#product-color').val() == '')
			|| ($('#product-size').prop('required') && $('#product-size').val() == '')) {
				return false;
			}
			update_price();
		});
		$('#content').on('keyup change', '#input-packages, #input-pieces', function(){
			$('input[name="quantity"]').val(0);
			$('#input-packages, #input-pieces').each(function(){
				$('input[name="quantity"]').val(parseInt($('input[name="quantity"]').val()) + parseInt($(this).val()) * parseInt($(this).attr('data-multiplier')));
			});
		});
		$('#content').on('click', '#add-product', function(){
			if ($('#fake-form')[0].checkValidity()) {
				product_option_combo = ['product', $('input[name="product_id"]').val(), $('#product-size').val(), $('#product-color').val()].join('-');
				$('#' + product_option_combo).remove();
				product_row = '';
				product_row += '<tr id="' + product_option_combo + '">';
				product_row += '<td>' + $('h2').html() + '<ul>';
				if ($('#product-size').val() != '') {
					product_row += '<li><?php echo $entry_size; ?>: ' + $('#product-size option:selected').text() + '</li>';
				}
				if ($('#product-color').val() != '') {
					product_row += '<li><?php echo $entry_color; ?>: ' + $('#product-color option:selected').text() + '</li>';
				}
				product_row += '</ul>';
				product_row += '<input type="hidden" name="products[' + product_form_counter +  '][id]" value="' + $('input[name="product_id"]').val() + '"/>';
				product_row += '<input type="hidden" name="products[' + product_form_counter +  '][quantity]" value="' + $('input[name="quantity"]').val() + '"/>';
				$('#product-size, #product-color').each(function(){
					if ($(this).val() != '') {
						product_row += '<input type="hidden" name="products[' + product_form_counter +  '][option][' + $(this).attr('product-option-id') + ']" value="' + $(this).val() + '"/>';
					}
				});
				product_row += '</td>';
				product_row += '<td><ul>';
				if ($('input[name="package-size"]').val() == 0) {
					product_row += '<li><?php echo $text_pieces; ?>: ' + $('input[name="quantity"]').val() + '</li>';
				} else {
					product_row += '<li><?php echo $text_pieces; ?>: ' + $('input[name="quantity"]').val() % $('input[name="package-size"]').val() + '</li>';
					product_row += '<li><?php echo $text_packages; ?>: ' + Math.floor($('input[name="quantity"]').val() / $('input[name="package-size"]').val()) + '</li>';
				}
				product_row += '</ul></td>';
				product_row += '<td><ul>';
				$('.price-list').each(function(){
					product_row += '<li>' + $(this).text() + '</li>';
				});
				product_row += '</ul></td>';
				product_row += '<td>';
				if ($('input[name="package-size"]').val() != 0 && $('input[name="package-discount"]') != 0) {
					product_row += appendCurrency(($('input[name="quantity"]').val() % $('input[name="package-size"]').val() * $('input[name="product-vat-price"]').val() + ($('input[name="quantity"]').val() - $('input[name="quantity"]').val() % $('input[name="package-size"]').val()) * $('input[name="product-vat-price"]').val() * (100 - $('input[name="package-discount"]').val()) / 100).toFixed(2)) + ' <br />(<?php echo $text_without_vat; ?> ' + appendCurrency(($('input[name="quantity"]').val() % $('input[name="package-size"]').val() * $('input[name="product-base-price"]').val() + ($('input[name="quantity"]').val() - $('input[name="quantity"]').val() % $('input[name="package-size"]').val()) * $('input[name="product-base-price"]').val() * (100 - $('input[name="package-discount"]').val()) / 100).toFixed(2)) + ')';
				} else {
					product_row += appendCurrency(($('input[name="quantity"]').val() * $('input[name="product-vat-price"]').val()).toFixed(2)) + ' <br />(<?php echo $text_without_vat; ?> ' + appendCurrency(($('input[name="quantity"]').val() * $('input[name="product-base-price"]').val()).toFixed(2)) + ')';
				}
				product_row += '</td>';
				product_row += '<td><button class="button purge-parent"><?php echo $button_remove; ?></button></td>';
				product_row += '</tr>';
				$('.list tbody').prepend(product_row);
				product_form_counter++;
			}
		});
		$('#content').on('click', '.purge-parent', function(){
			$(this).closest('tr').remove();
		});
	});
	function update_price()
	{
		$.ajax({
			url: '/index.php?route=myoc/live_price_update',
			type: 'POST',
			data: $('input[name="product_id"], #product-size, #product-color'),
			dataType: 'json',
			success: function(data) {
				if ('raw_price_data' in data) {
					$('#product-info #display-price-piece').html(appendCurrency(data.raw_price_data.vat_price.toFixed(2)) + ' (<?php echo $text_without_vat; ?> ' + appendCurrency(data.raw_price_data.base_price.toFixed(2)) + ')');
					$('input[name="product-base-price"]').val(data.raw_price_data.base_price);
					$('input[name="product-vat-price"]').val(data.raw_price_data.vat_price);
					if ($('input[name="package-size"]').val() != 0) {
						$('#product-info #display-price-package').html(appendCurrency((data.raw_price_data.vat_price * $('input[name="package-size"]').val() * (100 - $('input[name="package-discount"]').val()) / 100).toFixed(2)) + ' (<?php echo $text_without_vat; ?> ' + appendCurrency((data.raw_price_data.base_price * $('input[name="package-size"]').val() * (100 - $('input[name="package-discount"]').val()) / 100).toFixed(2)) + ')');
					}
				}
			}
		});
	}
	function appendCurrency(price)
	{
		return price + ' <?php echo $this->currency->getSymbolRight(); ?>';
	}
	// I'm not proud of myself
</script>
<?php echo $content_top; echo $footer; ?>
