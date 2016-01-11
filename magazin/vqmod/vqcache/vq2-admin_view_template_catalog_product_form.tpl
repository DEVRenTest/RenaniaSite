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

                <script type="text/javascript" src="view/javascript/fileuploader.js"></script>
                <link rel="stylesheet" type="text/css" href="view/stylesheet/fileuploader.css" />
            
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      

                <div id="tabs" class="htabs">

                    <a href="#tab-general"><?php echo $tab_general; ?></a>

                    <a href="#tab-data"><?php echo $tab_data; ?></a>

                    <a href="#tab-links"><?php echo $tab_links; ?></a>

                    <a href="#tab-attribute"><?php echo $tab_attribute; ?></a>

                    <a href="#tab-option"><?php echo $tab_option; ?></a>

                    <a href="#tab-option-combo"><?php echo $tab_option_combo; ?></a>

            <a href="#tab-profile"><?php echo $tab_profile; ?></a><a href="#tab-discount"><?php echo $tab_discount; ?></a><a href="#tab-special"><?php echo $tab_special; ?></a><a href="#tab-image"><?php echo $tab_image; ?></a><a href="#tab-reward"><?php echo $tab_reward; ?></a><a href="#tab-design"><?php echo $tab_design; ?></a>
			
			<a href="#tab-mapping-ax_code"><?php echo $tab_mapping_ax_code; ?></a><a href="#tab-download-pdf"><?php echo $tab_download_pdf; ?></a></div>
			
			
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <div id="languages" class="htabs">
            <?php foreach ($languages as $language) { ?>
            <a href="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
            <?php } ?>
          </div>
          <?php foreach ($languages as $language) { ?>
          <div id="language<?php echo $language['language_id']; ?>">
            <table class="form">
              <tr>
                <td><span class="required">*</span> <?php echo $entry_name; ?></td>
                <td><input type="text" name="product_description[<?php echo $language['language_id']; ?>][name]" size="100" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['name'] : ''; ?>" />
                  <?php if (isset($error_name[$language['language_id']])) { ?>
                  <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
                  <?php } ?></td>
              </tr>
              <tr>
<td><?php echo $entry_custom_title; ?></td>
			<td><input type="text" name="product_description[<?php echo $language['language_id']; ?>][custom_title]" size="100" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['custom_title'] : ''; ?>" /></td>
              </tr>
              <tr>
                <td><?php echo $entry_meta_description; ?></td>
                <td><textarea name="product_description[<?php echo $language['language_id']; ?>][meta_description]" cols="40" rows="5"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_description'] : ''; ?></textarea></td>
              </tr>
              <tr>
                <td><?php echo $entry_meta_keyword; ?></td>
                <td><textarea name="product_description[<?php echo $language['language_id']; ?>][meta_keyword]" cols="40" rows="5"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea></td>
              </tr>
              <tr>
                <td><?php echo $entry_description; ?></td>
                <td><textarea name="product_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['description'] : ''; ?></textarea></td>
              </tr>
              <tr>


                    <td><?php echo $entry_combo_description; ?></td>

                    <td><textarea name="product_option_combination_description[<?php echo $language['language_id']; ?>][description]" id="option_combo_description<?php echo $language['language_id']; ?>"><?php echo isset($product_option_combo_description[$language['language_id']]) ? $product_option_combo_description[$language['language_id']]['description'] : ''; ?></textarea></td>

                </tr>

                <tr>

            
                <td><?php echo $entry_tag; ?></td>
                <td><input type="text" name="product_description[<?php echo $language['language_id']; ?>][tag]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['tag'] : ''; ?>" size="80" /></td>
              </tr>
            </table>
          </div>
          <?php } ?>
        </div>
        <div id="tab-data">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $entry_model; ?></td>
              <td><input type="text" name="model" value="<?php echo $model; ?>" />
                <?php if ($error_model) { ?>
                <span class="error"><?php echo $error_model; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_sku; ?></td>
              <td><input type="text" name="sku" value="<?php echo $sku; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_upc; ?></td>
              <td><input type="text" name="upc" value="<?php echo $upc; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_ean; ?></td>
              <td><input type="text" name="ean" value="<?php echo $ean; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_jan; ?></td>
              <td><input type="text" name="jan" value="<?php echo $jan; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_isbn; ?></td>
              <td><input type="text" name="isbn" value="<?php echo $isbn; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_mpn; ?></td>
              <td><input type="text" name="mpn" value="<?php echo $mpn; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_location; ?></td>
              <td><input type="text" name="location" value="<?php echo $location; ?>" /></td>
            </tr>
            <tr>
                <td><?php echo $entry_price; ?></td>
                <td><input type="text" name="price" value="<?php echo $price; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_tax_class; ?></td>
              <td><select name="tax_class_id">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($tax_classes as $tax_class) { ?>
                  <?php if ($tax_class['tax_class_id'] == $tax_class_id) { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_quantity; ?></td>
              <td><input type="text" name="quantity" value="<?php echo $quantity; ?>" size="2" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_minimum; ?></td>
              <td><input type="text" name="minimum" value="<?php echo $minimum; ?>" size="2" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_subtract; ?></td>
              <td><select name="subtract">
                  <?php if ($subtract) { ?>
                  <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                  <option value="0"><?php echo $text_no; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_yes; ?></option>
                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_stock_status; ?></td>
              <td><select name="stock_status_id">
                  <?php foreach ($stock_statuses as $stock_status) { ?>
                  <?php if ($stock_status['stock_status_id'] == $stock_status_id) { ?>
                  <option value="<?php echo $stock_status['stock_status_id']; ?>" selected="selected"><?php echo $stock_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_stock_status_limits; ?></td>
              <td>
                <input size="5" type="text" name="stock_status_limit[0]" value="<?php echo (isset( $stock_status_limit[0] ) ? $stock_status_limit[0] : 0 ); ?>" />
                <input size="5" type="text" name="stock_status_limit[1]" value="<?php echo (isset( $stock_status_limit[1] ) ? $stock_status_limit[1] : 2 ); ?>" />
                <input size="5" type="text" name="stock_status_limit[2]" value="<?php echo (isset( $stock_status_limit[2] ) ? $stock_status_limit[2] : 5 ); ?>" />              
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_shipping; ?></td>
              <td><?php if ($shipping) { ?>
                <input type="radio" name="shipping" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="shipping" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="shipping" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="shipping" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_keyword; ?></td>
              <td><input type="text" name="keyword" value="<?php echo $keyword; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_image; ?></td>
              <td><div class="image"><img src="<?php echo $thumb; ?>" alt="" id="thumb" /><br />
                  <input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
                  <a onclick="image_upload('image', 'thumb');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
            </tr>
            <tr>
              <td><?php echo $entry_date_available; ?></td>
              <td><input type="text" name="date_available" value="<?php echo $date_available; ?>" size="12" class="date" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_dimension; ?></td>
              <td><input type="text" name="length" value="<?php echo $length; ?>" size="4" />
                <input type="text" name="width" value="<?php echo $width; ?>" size="4" />
                <input type="text" name="height" value="<?php echo $height; ?>" size="4" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_length; ?></td>
              <td><select name="length_class_id">
                  <?php foreach ($length_classes as $length_class) { ?>
                  <?php if ($length_class['length_class_id'] == $length_class_id) { ?>
                  <option value="<?php echo $length_class['length_class_id']; ?>" selected="selected"><?php echo $length_class['title']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $length_class['length_class_id']; ?>"><?php echo $length_class['title']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_weight; ?></td>
              <td><input type="text" name="weight" value="<?php echo $weight; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_weight_class; ?></td>
              <td><select name="weight_class_id">
                  <?php foreach ($weight_classes as $weight_class) { ?>
                  <?php if ($weight_class['weight_class_id'] == $weight_class_id) { ?>
                  <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="status">
                  <?php if ($status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_sort_order; ?></td>
              <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="2" /></td>
            </tr>
          </table>
        </div>
        <div id="tab-links">
          <table class="form">
            <tr>
              <td><?php echo $entry_manufacturer; ?></td>
              <td><input type="text" name="manufacturer" value="<?php echo $manufacturer ?>" /><input type="hidden" name="manufacturer_id" value="<?php echo $manufacturer_id; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_category; ?></td>
              <td><input type="text" name="category" value="" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><div id="product-category" class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($product_categories as $product_category) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div id="product-category<?php echo $product_category['category_id']; ?>" class="<?php echo $class; ?>"><?php echo $product_category['name']; ?><img src="view/image/delete.png" alt="" />
                    <input type="hidden" name="product_category[]" value="<?php echo $product_category['category_id']; ?>" />
                  </div>
                  <?php } ?>
                </div></td>
            </tr> 
            <tr>
              <td><?php echo $entry_filter; ?></td>
              <td><input type="text" name="filter" value="" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><div id="product-filter" class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($product_filters as $product_filter) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div id="product-filter<?php echo $product_filter['filter_id']; ?>" class="<?php echo $class; ?>"><?php echo $product_filter['name']; ?><img src="view/image/delete.png" alt="" />
                    <input type="hidden" name="product_filter[]" value="<?php echo $product_filter['filter_id']; ?>" />
                  </div>
                  <?php } ?>
                </div></td>
            </tr>                       
            <tr>
              <td><?php echo $entry_store; ?></td>
              <td><div class="scrollbox">
                  <?php $class = 'even'; ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array(0, $product_store)) { ?>
                    <input type="checkbox" name="product_store[]" value="0" checked="checked" />
                    <?php echo $text_default; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="product_store[]" value="0" />
                    <?php echo $text_default; ?>
                    <?php } ?>
                  </div>
                  <?php foreach ($stores as $store) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($store['store_id'], $product_store)) { ?>
                    <input type="checkbox" name="product_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                    <?php echo $store['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="product_store[]" value="<?php echo $store['store_id']; ?>" />
                    <?php echo $store['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div></td>
            </tr>
            <tr>
              <td><?php echo $entry_download; ?></td>
              <td><input type="text" name="download" value="" /></td>
            </tr>			
            <tr>
              <td>&nbsp;</td>
              <td><div id="product-download" class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($product_downloads as $product_download) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div id="product-download<?php echo $product_download['download_id']; ?>" class="<?php echo $class; ?>"> <?php echo $product_download['name']; ?><img src="view/image/delete.png" alt="" />
                    <input type="hidden" name="product_download[]" value="<?php echo $product_download['download_id']; ?>" />
                  </div>
                  <?php } ?>
                </div></td>
            </tr>
            <tr>
              <td><?php echo $entry_related; ?></td>
              <td><input type="text" name="related" value="" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><div id="product-related" class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($product_related as $product_related) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div id="product-related<?php echo $product_related['product_id']; ?>" class="<?php echo $class; ?>"> <?php echo $product_related['name']; ?><img src="view/image/delete.png" alt="" />
                    <input type="hidden" name="product_related[]" value="<?php echo $product_related['product_id']; ?>" />
                  </div>
                  <?php } ?>
                </div></td>
            </tr>
          <tr>
              <td><?php echo $entry_complementary; ?></td>
              <td><input type="text" name="complementary" value="" /></td>
          </tr>
              <tr>
                  <td>&nbsp;</td>
                  <td><div id="product-complementary" class="scrollbox">
                          <?php $class = 'odd'; ?>
                          <?php foreach ($product_complementary as $product_complementary) { ?>
                          <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                          <div id="product-complementary<?php echo $product_complementary['product_id']; ?>" class="<?php echo $class; ?>"> <?php echo $product_complementary['name']; ?><img src="view/image/delete.png" alt="" />
                              <input type="hidden" name="product_complementary[]" value="<?php echo $product_complementary['product_id']; ?>" />
                          </div>
                          <?php } ?>
                      </div></td>
              </tr>
          </table>
        </div>
        <div id="tab-attribute">
          <table id="attribute" class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $entry_attribute; ?></td>
                <td class="left"><?php echo $entry_text; ?></td>
                <td></td>
              </tr>
            </thead>
            <?php $attribute_row = 0; ?>
            <?php foreach ($product_attributes as $product_attribute) { ?>
            <tbody id="attribute-row<?php echo $attribute_row; ?>">
              <tr>
                <td class="left"><input type="text" name="product_attribute[<?php echo $attribute_row; ?>][name]" value="<?php echo $product_attribute['name']; ?>" />
                  <input type="hidden" name="product_attribute[<?php echo $attribute_row; ?>][attribute_id]" value="<?php echo $product_attribute['attribute_id']; ?>" /></td>
                <td class="left"><?php foreach ($languages as $language) { ?>
                  <textarea name="product_attribute[<?php echo $attribute_row; ?>][product_attribute_description][<?php echo $language['language_id']; ?>][text]" cols="40" rows="5"><?php echo isset($product_attribute['product_attribute_description'][$language['language_id']]) ? $product_attribute['product_attribute_description'][$language['language_id']]['text'] : ''; ?></textarea>
                  <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" align="top" /><br />
                  <?php } ?></td>
                <td class="left"><a onclick="$('#attribute-row<?php echo $attribute_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
              </tr>
            </tbody>
            <?php $attribute_row++; ?>
            <?php } ?>
            <tfoot>
              <tr>
                <td colspan="2"></td>
                <td class="left"><a onclick="addAttribute();" class="button"><?php echo $button_add_attribute; ?></a></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <div id="tab-option">
          <div id="vtab-option" class="vtabs">
            <?php $option_row = 0; ?>
            <?php foreach ($product_options as $product_option) { ?>
                <a href="#tab-option-<?php echo $option_row; ?>" id="option-<?php echo $option_row; ?>"><?php echo $product_option['name']; ?>&nbsp;<img src="view/image/delete.png" alt="" onclick="$('#option-<?php echo $option_row; ?>').remove(); $('#tab-option-<?php echo $option_row; ?>').remove(); $('#vtabs a:first').trigger('click'); return false;" /></a>
                <?php $option_row++; ?>
            <?php } ?>
            <span id="option-add">
            <input name="option" value="" style="width: 130px;" />
            &nbsp;<img src="view/image/add.png" alt="<?php echo $button_add_option; ?>" title="<?php echo $button_add_option; ?>" /></span></div>
          <?php $option_row = 0; ?>
          <?php $option_value_row = 0; ?>
          <?php foreach ($product_options as $product_option) { ?>
          <div id="tab-option-<?php echo $option_row; ?>" class="vtabs-content">
            <input type="hidden" name="product_option[<?php echo $option_row; ?>][product_option_id]" value="<?php echo $product_option['product_option_id']; ?>" />
            <input type="hidden" name="product_option[<?php echo $option_row; ?>][name]" value="<?php echo $product_option['name']; ?>" />
            <input type="hidden" name="product_option[<?php echo $option_row; ?>][option_id]" value="<?php echo $product_option['option_id']; ?>" />
            <input type="hidden" name="product_option[<?php echo $option_row; ?>][type]" value="<?php echo $product_option['type']; ?>" />
            <table class="form">
              <tr>
                <td><?php echo $entry_required; ?></td>
                <td><select name="product_option[<?php echo $option_row; ?>][required]">
                    <?php if ($product_option['required']) { ?>
                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="0"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_yes; ?></option>
                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select></td>
              </tr>
              <?php if ($product_option['type'] == 'text') { ?>
              <tr>
                <td><?php echo $entry_option_value; ?></td>
                <td><input type="text" name="product_option[<?php echo $option_row; ?>][option_value]" value="<?php echo $product_option['option_value']; ?>" /></td>
              </tr>
              <?php } ?>
              <?php if ($product_option['type'] == 'textarea') { ?>
              <tr>
                <td><?php echo $entry_option_value; ?></td>
                <td><textarea name="product_option[<?php echo $option_row; ?>][option_value]" cols="40" rows="5"><?php echo $product_option['option_value']; ?></textarea></td>
              </tr>
              <?php } ?>
              <?php if ($product_option['type'] == 'file') { ?>
              <tr style="display: none;">
                <td><?php echo $entry_option_value; ?></td>
                <td><input type="text" name="product_option[<?php echo $option_row; ?>][option_value]" value="<?php echo $product_option['option_value']; ?>" /></td>
              </tr>
              <?php } ?>
              <?php if ($product_option['type'] == 'date') { ?>
              <tr>
                <td><?php echo $entry_option_value; ?></td>
                <td><input type="text" name="product_option[<?php echo $option_row; ?>][option_value]" value="<?php echo $product_option['option_value']; ?>" class="date" /></td>
              </tr>
              <?php } ?>
              <?php if ($product_option['type'] == 'datetime') { ?>
              <tr>
                <td><?php echo $entry_option_value; ?></td>
                <td><input type="text" name="product_option[<?php echo $option_row; ?>][option_value]" value="<?php echo $product_option['option_value']; ?>" class="datetime" /></td>
              </tr>
              <?php } ?>
              <?php if ($product_option['type'] == 'time') { ?>
              <tr>
                <td><?php echo $entry_option_value; ?></td>
                <td><input type="text" name="product_option[<?php echo $option_row; ?>][option_value]" value="<?php echo $product_option['option_value']; ?>" class="time" /></td>
              </tr>
              <?php } ?>
            </table>
            <?php if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') { ?>
            <table id="option-value<?php echo $option_row; ?>" class="list">
              <thead>
                <tr>
                  <td class="left"><?php echo $entry_option_value; ?></td>
                  <td class="right"><?php echo $entry_quantity; ?></td>
                  <td class="left"><?php echo $entry_subtract; ?></td>
                  <td class="right"><?php echo $entry_price; ?></td>
                  <td class="right"><?php echo $entry_option_points; ?></td>
                  <td class="right"><?php echo $entry_weight; ?></td>
                  <td></td>
                </tr>
              </thead>
              <?php foreach ($product_option['product_option_value'] as $product_option_value) { ?>
              <tbody id="option-value-row<?php echo $option_value_row; ?>">
                <tr>
                  <td class="left"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][option_value_id]">
                      <?php if (isset($option_values[$product_option['option_id']])) { ?>
                          <?php foreach ($option_values[$product_option['option_id']] as $option_value) { ?>
                              <?php if ($option_value['option_value_id'] == $product_option_value['option_value_id']) { ?>
                                  <option value="<?php echo $option_value['option_value_id']; ?>" selected="selected"><?php echo $option_value['name']; ?></option>
                              <?php } else { ?>
                                  <option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?></option>
                              <?php } ?>
                          <?php } ?>
                      <?php } ?>
                    </select>
                    <input type="hidden" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][product_option_value_id]" value="<?php echo $product_option_value['product_option_value_id']; ?>" /></td>
                  <td class="right"><input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][quantity]" value="<?php echo $product_option_value['quantity']; ?>" size="3" /></td>
                  <td class="left"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][subtract]">
                      <?php if ($product_option_value['subtract']) { ?>
                      <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                      <option value="0"><?php echo $text_no; ?></option>
                      <?php } else { ?>
                      <option value="1"><?php echo $text_yes; ?></option>
                      <option value="0" selected="selected"><?php echo $text_no; ?></option>
                      <?php } ?>
                    </select></td>
                  <td class="right"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][price_prefix]">
                      <?php if ($product_option_value['price_prefix'] == '+') { ?>
                      <option value="+" selected="selected">+</option>
                      <?php } else { ?>
                      <option value="+">+</option>
                      <?php } ?>
                      <?php if ($product_option_value['price_prefix'] == '-') { ?>
                      <option value="-" selected="selected">-</option>
                      <?php } else { ?>
                      <option value="-">-</option>
                      <?php } ?>
                    </select>
                    <input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][price]" value="<?php echo $product_option_value['price']; ?>" size="5" /></td>
                  <td class="right"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][points_prefix]">
                      <?php if ($product_option_value['points_prefix'] == '+') { ?>
                      <option value="+" selected="selected">+</option>
                      <?php } else { ?>
                      <option value="+">+</option>
                      <?php } ?>
                      <?php if ($product_option_value['points_prefix'] == '-') { ?>
                      <option value="-" selected="selected">-</option>
                      <?php } else { ?>
                      <option value="-">-</option>
                      <?php } ?>
                    </select>
                    <input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][points]" value="<?php echo $product_option_value['points']; ?>" size="5" /></td>
                  <td class="right"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][weight_prefix]">
                      <?php if ($product_option_value['weight_prefix'] == '+') { ?>
                      <option value="+" selected="selected">+</option>
                      <?php } else { ?>
                      <option value="+">+</option>
                      <?php } ?>
                      <?php if ($product_option_value['weight_prefix'] == '-') { ?>
                      <option value="-" selected="selected">-</option>
                      <?php } else { ?>
                      <option value="-">-</option>
                      <?php } ?>
                    </select>
                    <input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][weight]" value="<?php echo $product_option_value['weight']; ?>" size="5" /></td>
                  <td class="left"><a onclick="$('#option-value-row<?php echo $option_value_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
                </tr>
              </tbody>
              <?php $option_value_row++; ?>
              <?php } ?>
              <tfoot>
                <tr>
                  <td colspan="6"></td>
                  <td class="left"><a onclick="addOptionValue('<?php echo $option_row; ?>');" class="button"><?php echo $button_add_option_value; ?></a></td>
                </tr>
              </tfoot>
            </table>
            <select id="option-values<?php echo $option_row; ?>" style="display: none;">
              <?php if (isset($option_values[$product_option['option_id']])) { ?>
              <?php foreach ($option_values[$product_option['option_id']] as $option_value) { ?>
              <option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
            <?php } ?>
          </div>
          <?php $option_row++; ?>
          <?php } ?>
        </div>
        <div id="tab-profile">
            <table class="list">
                <thead>
                    <tr>
                        <td class="left"><?php echo $entry_profile ?></td>
                        <td class="left"><?php echo $entry_customer_group ?></td>
                        <td class="left"></td>
                    </tr>
                </thead>
                <tbody>
                    <?php $profileCount = 0; ?>
                    <?php foreach ($product_profiles as $product_profile): ?>
                        <?php $profileCount++ ?>
                    
                        <tr id="profile-row<?php echo $profileCount ?>">
                            <td class="left">
                                <select name="product_profiles[<?php echo $profileCount ?>][profile_id]">
                                    <?php foreach ($profiles as $profile): ?>
                                        <?php if ($profile['profile_id'] == $product_profile['profile_id']): ?>
                                            <option value="<?php echo $profile['profile_id'] ?>" selected="selected"><?php echo $profile['name'] ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo $profile['profile_id'] ?>"><?php echo $profile['name'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td class="left">
                                <select name="product_profiles[<?php echo $profileCount ?>][customer_group_id]">
                                    <?php foreach ($customer_groups as $customer_group): ?>
                                        <?php if ($customer_group['customer_group_id'] == $product_profile['customer_group_id']): ?>
                                            <option value="<?php echo $customer_group['customer_group_id'] ?>" selected="selected"><?php echo $customer_group['name'] ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo $customer_group['customer_group_id'] ?>"><?php echo $customer_group['name'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td class="left">
                                <a class="button" onclick="$('#profile-row<?php echo $profileCount ?>').remove()"><?php echo $button_remove ?></a>
                            </td>
                        </tr>
                    
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"></td>
                        <td class="left"><a onclick="addProfile()" class="button"><?php echo $button_add_profile ?></a></td>
                    </tr>
                </tfoot>
            </table>
        </div>


                <style type="text/css">

                    .list tbody td {

                        vertical-align: top;

                    }

                    .list td a img, .ahelp img, .chelp img {

                        position: relative;

                        top: 3px;

                        cursor: pointer;

                    }

                    .list td a, .ahelp, .chelp {

                        margin-left: 6px;

                    }

                </style>

                <div id="tab-option-combo">

                    <?php if($options == '') { ?>

                    <div><span class="error"><?php echo $error_option_exist; ?></span></div>

                    <?php } else { ?>

                    <div id="htab-option-combo" class="htabs">

                        <a href="#tab-option-combo-settings">Settings</a>

                        <a href="#tab-option-combo-values">Values</a>

                    </div>

                    <div id="tab-option-combo-settings">

                        <table class="form">

                            <tr>

                                <td><?php echo $entry_combo_status; ?></td>

                                <td>

                                    <select name="option_combo_status">

                                      <?php if ($option_combo_status) { ?>

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

                                <td><?php echo $entry_combo_price_view; ?></td>

                                <td>

                                    <?php if ($option_combo_price_view) { ?>

                                    <input type="radio" name="option_combo_price_view" value="1" checked="checked" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_price_view" value="0" />

                                    <?php echo $text_no; ?>

                                    <?php } else { ?>

                                    <input type="radio" name="option_combo_price_view" value="1" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_price_view" value="0" checked="checked" />

                                    <?php echo $text_no; ?>

                                    <?php } ?>

                                    <a href="view/image/combo-help/ahelp1-price-view.png" class="ahelp" rel="<?php echo $text_ahelp1_price_view; ?>"><img src="view/image/question-balloon.png" /></a>

                                </td>

                            </tr>

                            <tr>

                                <td><?php echo $entry_combo_description_view; ?></td>

                                <td>

                                    <?php if ($option_combo_description_view) { ?>

                                    <input type="radio" name="option_combo_description_view" value="1" checked="checked" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_description_view" value="0" />

                                    <?php echo $text_no; ?>

                                    <?php } else { ?>

                                    <input type="radio" name="option_combo_description_view" value="1" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_description_view" value="0" checked="checked" />

                                    <?php echo $text_no; ?>

                                    <?php } ?>

                                    <a href="view/image/combo-help/ahelp2-description-view.png" class="ahelp" rel="<?php echo $text_ahelp2_description_view; ?>"><img src="view/image/question-balloon.png" /></a>

                                </td>

                            </tr>

                            <tr>

                                <td><?php echo $entry_combo_option_view; ?></td>

                                <td>

                                    <?php if ($option_combo_option_view) { ?>

                                    <input type="radio" name="option_combo_option_view" value="1" checked="checked" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_option_view" value="0" />

                                    <?php echo $text_no; ?>

                                    <?php } else { ?>

                                    <input type="radio" name="option_combo_option_view" value="1" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_option_view" value="0" checked="checked" />

                                    <?php echo $text_no; ?>

                                    <?php } ?>

                                    <a href="view/image/combo-help/ahelp3-option-view.png" class="ahelp" rel="<?php echo $text_ahelp3_option_view; ?>"><img src="view/image/question-balloon.png" /></a>

                                </td>

                            </tr>

                            <tr>

                                <td><?php echo $entry_combo_table_view; ?></td>

                                <td>

                                    <?php if ($option_combo_table_view) { ?>

                                    <input type="radio" name="option_combo_table_view" value="1" checked="checked" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_table_view" value="0" />

                                    <?php echo $text_no; ?>

                                    <?php } else { ?>

                                    <input type="radio" name="option_combo_table_view" value="1" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_table_view" value="0" checked="checked" />

                                    <?php echo $text_no; ?>

                                    <?php } ?>

                                    <a href="view/image/combo-help/ahelp4-table-view.png" class="ahelp" rel="<?php echo $text_ahelp4_table_view; ?>"><img src="view/image/question-balloon.png" /></a>

                                </td>

                            </tr>

                            <tr>

                                <td><?php echo $entry_combo_col_select_view; ?></td>

                                <td>

                                    <?php if ($option_combo_col_select_view) { ?>

                                    <input type="radio" name="option_combo_col_select_view" value="1" checked="checked" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_col_select_view" value="0" />

                                    <?php echo $text_no; ?>

                                    <?php } else { ?>

                                    <input type="radio" name="option_combo_col_select_view" value="1" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_col_select_view" value="0" checked="checked" />

                                    <?php echo $text_no; ?>

                                    <?php } ?>

                                    <a href="view/image/combo-help/ahelp5-col-select-view.png" class="ahelp" rel="<?php echo $text_ahelp5_col_select_view; ?>"><img src="view/image/question-balloon.png" /></a>

                                </td>

                            </tr>

                            <tr>

                                <td><?php echo $entry_combo_col_quantity_view; ?></td>

                                <td>

                                    <?php if ($option_combo_col_quantity_view) { ?>

                                    <input type="radio" name="option_combo_col_quantity_view" value="1" checked="checked" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_col_quantity_view" value="0" />

                                    <?php echo $text_no; ?>

                                    <?php } else { ?>

                                    <input type="radio" name="option_combo_col_quantity_view" value="1" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_col_quantity_view" value="0" checked="checked" />

                                    <?php echo $text_no; ?>

                                    <?php } ?>

                                    <a href="view/image/combo-help/ahelp6-col-quantity-view.png" class="ahelp" rel="<?php echo $text_ahelp6_col_quantity_view; ?>"><img src="view/image/question-balloon.png" /></a>

                                </td>

                            </tr>

                            <tr>

                                <td><?php echo $entry_combo_col_points_view; ?></td>

                                <td>

                                    <?php if ($option_combo_col_points_view) { ?>

                                    <input type="radio" name="option_combo_col_points_view" value="1" checked="checked" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_col_points_view" value="0" />

                                    <?php echo $text_no; ?>

                                    <?php } else { ?>

                                    <input type="radio" name="option_combo_col_points_view" value="1" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_col_points_view" value="0" checked="checked" />

                                    <?php echo $text_no; ?>

                                    <?php } ?>

                                    <a href="view/image/combo-help/ahelp7-col-points-view.png" class="ahelp" rel="<?php echo $text_ahelp7_col_points_view; ?>"><img src="view/image/question-balloon.png" /></a>

                                </td>

                            </tr>

                            <tr>

                                <td><?php echo $entry_combo_col_total_points_view; ?></td>

                                <td>

                                    <?php if ($option_combo_col_total_points_view) { ?>

                                    <input type="radio" name="option_combo_col_total_points_view" value="1" checked="checked" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_col_total_points_view" value="0" />

                                    <?php echo $text_no; ?>

                                    <?php } else { ?>

                                    <input type="radio" name="option_combo_col_total_points_view" value="1" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_col_total_points_view" value="0" checked="checked" />

                                    <?php echo $text_no; ?>

                                    <?php } ?>

                                    <a href="view/image/combo-help/ahelp8-col-total-points-view.png" class="ahelp" rel="<?php echo $text_ahelp8_col_total_points_view; ?>"><img src="view/image/question-balloon.png" /></a>

                                </td>

                            </tr>

                            <tr>

                                <td><?php echo $entry_combo_col_price_view; ?></td>

                                <td>

                                    <?php if ($option_combo_col_price_view) { ?>

                                    <input type="radio" name="option_combo_col_price_view" value="1" checked="checked" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_col_price_view" value="0" />

                                    <?php echo $text_no; ?>

                                    <?php } else { ?>

                                    <input type="radio" name="option_combo_col_price_view" value="1" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_col_price_view" value="0" checked="checked" />

                                    <?php echo $text_no; ?>

                                    <?php } ?>

                                    <a href="view/image/combo-help/ahelp9-col-price-view.png" class="ahelp" rel="<?php echo $text_ahelp9_col_price_view; ?>"><img src="view/image/question-balloon.png" /></a>

                                </td>

                            </tr>

                            <tr>

                                <td><?php echo $entry_combo_col_total_price_view; ?></td>

                                <td>

                                    <?php if ($option_combo_col_total_price_view) { ?>

                                    <input type="radio" name="option_combo_col_total_price_view" value="1" checked="checked" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_col_total_price_view" value="0" />

                                    <?php echo $text_no; ?>

                                    <?php } else { ?>

                                    <input type="radio" name="option_combo_col_total_price_view" value="1" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_col_total_price_view" value="0" checked="checked" />

                                    <?php echo $text_no; ?>

                                    <?php } ?>

                                    <a href="view/image/combo-help/ahelp10-col-total-price-view.png" class="ahelp" rel="<?php echo $text_ahelp10_col_total_price_view; ?>"><img src="view/image/question-balloon.png" /></a>

                                </td>

                            </tr>

                            <tr>

                                <td><?php echo $entry_combo_extax_view; ?></td>

                                <td>

                                    <?php if ($option_combo_extax_view) { ?>

                                    <input type="radio" name="option_combo_extax_view" value="1" checked="checked" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_extax_view" value="0" />

                                    <?php echo $text_no; ?>

                                    <?php } else { ?>

                                    <input type="radio" name="option_combo_extax_view" value="1" />

                                    <?php echo $text_yes; ?>

                                    <input type="radio" name="option_combo_extax_view" value="0" checked="checked" />

                                    <?php echo $text_no; ?>

                                    <?php } ?>

                                    <a href="view/image/combo-help/ahelp11-extax-view.png" class="ahelp" rel="<?php echo $text_ahelp11_extax_view; ?>"><img src="view/image/question-balloon.png" /></a>

                                </td>

                            </tr>

                            <tr>

                                <td><?php echo $entry_combo_table_split; ?></td>

                                <td>

                                    <select name="option_combo_table_split">

                                        <?php echo $table_split_options; ?>

                                    </select>

                                    <a href="view/image/combo-help/ahelp12-table-split.png" class="ahelp" rel="<?php echo $text_ahelp12_table_split; ?>"><img src="view/image/question-balloon.png" /></a>

                                </td>

                            </tr>

                            <tr>

                                <td><?php echo $entry_combo_quantity_box; ?></td>

                                <td>

                                    <select name="option_combo_quantity_box">

                                      <?php if ($option_combo_quantity_box) { ?>

                                      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>

                                      <option value="0"><?php echo $text_disabled; ?></option>

                                      <?php } else { ?>

                                      <option value="1"><?php echo $text_enabled; ?></option>

                                      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>

                                      <?php } ?>

                                    </select>

                                    <a href="view/image/combo-help/ahelp13-quantity-box.png" class="ahelp" rel="<?php echo $text_ahelp13_quantity_box; ?>"><img src="view/image/question-balloon.png" /></a>

                                </td>

                            </tr>

                        </table>

                    </div>

                    <div id="tab-option-combo-values">

                        <table id="option-combo" class="list">

                            <thead>

                              <tr>

                                <td class="left"><?php echo $entry_option_value; ?><a class="chelp" rel="<?php echo $text_chelp1_option_value; ?>"><img src="view/image/question-balloon.png" /></a></td>

                                <td class="right"><?php echo $entry_stock_available; ?><a class="chelp" rel="<?php echo $text_chelp2_stock_available; ?>"><img src="view/image/question-balloon.png" /></a></td>

                                <td class="right"><?php echo $entry_quantity; ?><a class="chelp" rel="<?php echo $text_chelp3_quantity; ?>"><img src="view/image/question-balloon.png" /></a></td>

                                <td class="right"><?php echo $entry_price; ?><a class="chelp" rel="<?php echo $text_chelp4_price; ?>"><img src="view/image/question-balloon.png" /></a></td>

                                <td class="right"><?php echo $entry_option_points; ?><a class="chelp" rel="<?php echo $text_chelp5_points; ?>"><img src="view/image/question-balloon.png" /></a></td>

                                <td class="right"><?php echo $entry_weight; ?><a class="chelp" rel="<?php echo $text_chelp6_weight; ?>"><img src="view/image/question-balloon.png" /></a></td>

                                <td class="right"><?php echo $entry_priority; ?><a class="chelp" rel="<?php echo $text_chelp7_priority; ?>"><img src="view/image/question-balloon.png" /></a></td>

                                <td class="left"><?php echo $entry_customer_group; ?><a class="chelp" rel="<?php echo $text_chelp8_customer_group; ?>"><img src="view/image/question-balloon.png" /></a></td>

                                <td class="left"><?php echo $entry_combo_duration; ?><a class="chelp" rel="<?php echo $text_chelp9_duration; ?>"><img src="view/image/question-balloon.png" /></a></td>

                                <td class="left"></td>

                              </tr>

                            </thead>

                            <?php echo $product_option_combo; ?>

                            <tfoot>

                                <tr><td colspan="10" class="right"><a onclick="add_combo();" class="button"><span><?php echo $button_add_option_combo; ?></span></a></td></tr>

                            </tfoot>

                        </table>

                    </div>

                <?php } ?>

                </div>

            
        <div id="tab-discount">
          <table id="discount" class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $entry_customer_group; ?></td>
                <td class="right"><?php echo $entry_quantity; ?></td>
                <td class="right"><?php echo $entry_priority; ?></td>
                <td class="right"><?php echo $entry_price; ?></td>
                <td class="left"><?php echo $entry_date_start; ?></td>
                <td class="left"><?php echo $entry_date_end; ?></td>
                <td></td>
              </tr>
            </thead>
            <?php $discount_row = 0; ?>
            <?php foreach ($product_discounts as $product_discount) { ?>
            <tbody id="discount-row<?php echo $discount_row; ?>">
              <tr>
                <td class="left"><select name="product_discount[<?php echo $discount_row; ?>][customer_group_id]">
                    <?php foreach ($customer_groups as $customer_group) { ?>
                    <?php if ($customer_group['customer_group_id'] == $product_discount['customer_group_id']) { ?>
                    <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
                <td class="right"><input type="text" name="product_discount[<?php echo $discount_row; ?>][quantity]" value="<?php echo $product_discount['quantity']; ?>" size="2" /></td>
                <td class="right"><input type="text" name="product_discount[<?php echo $discount_row; ?>][priority]" value="<?php echo $product_discount['priority']; ?>" size="2" /></td>
                <td class="right"><input type="text" name="product_discount[<?php echo $discount_row; ?>][price]" value="<?php echo $product_discount['price']; ?>" /></td>
                <td class="left"><input type="text" name="product_discount[<?php echo $discount_row; ?>][date_start]" value="<?php echo $product_discount['date_start']; ?>" class="date" /></td>
                <td class="left"><input type="text" name="product_discount[<?php echo $discount_row; ?>][date_end]" value="<?php echo $product_discount['date_end']; ?>" class="date" /></td>
                <td class="left"><a onclick="$('#discount-row<?php echo $discount_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
              </tr>
            </tbody>
            <?php $discount_row++; ?>
            <?php } ?>
            <tfoot>
              <tr>
                <td colspan="6"></td>
                <td class="left"><a onclick="addDiscount();" class="button"><?php echo $button_add_discount; ?></a></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <div id="tab-special">
          <table id="special" class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $entry_customer_group; ?></td>
                <td class="right"><?php echo $entry_priority; ?></td>
                <td class="right"><?php echo $entry_price; ?></td>
                <td class="left"><?php echo $entry_date_start; ?></td>
                <td class="left"><?php echo $entry_date_end; ?></td>
                <td></td>
              </tr>
            </thead>
            <?php $special_row = 0; ?>
            <?php foreach ($product_specials as $product_special) { ?>
            <tbody id="special-row<?php echo $special_row; ?>">
              <tr>
                <td class="left"><select name="product_special[<?php echo $special_row; ?>][customer_group_id]">
                    <?php foreach ($customer_groups as $customer_group) { ?>
                    <?php if ($customer_group['customer_group_id'] == $product_special['customer_group_id']) { ?>
                    <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
                <td class="right"><input type="text" name="product_special[<?php echo $special_row; ?>][priority]" value="<?php echo $product_special['priority']; ?>" size="2" /></td>
                <td class="right"><input type="text" name="product_special[<?php echo $special_row; ?>][price]" value="<?php echo $product_special['price']; ?>" /></td>
                <td class="left"><input type="text" name="product_special[<?php echo $special_row; ?>][date_start]" value="<?php echo $product_special['date_start']; ?>" class="date" /></td>
                <td class="left"><input type="text" name="product_special[<?php echo $special_row; ?>][date_end]" value="<?php echo $product_special['date_end']; ?>" class="date" /></td>
                <td class="left"><a onclick="$('#special-row<?php echo $special_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
              </tr>
            </tbody>
            <?php $special_row++; ?>
            <?php } ?>
            <tfoot>
              <tr>
                <td colspan="5"></td>
                <td class="left"><a onclick="addSpecial();" class="button"><?php echo $button_add_special; ?></a></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <div id="tab-image">
          <table id="images" class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $entry_image; ?></td>
                <td class="right"><?php echo $entry_sort_order; ?></td>

                <td>Default Image</td>
            
                <td></td>
              </tr>
            </thead>
            <?php $image_row = 0; ?>
            <?php foreach ($product_images as $product_image) { ?>
            <tbody id="image-row<?php echo $image_row; ?>">
              <tr>
                <td class="left"><div class="image"><img src="<?php echo $product_image['thumb']; ?>" alt="" id="thumb<?php echo $image_row; ?>" />
                    <input type="hidden" name="product_image[<?php echo $image_row; ?>][image]" value="<?php echo $product_image['image']; ?>" id="image<?php echo $image_row; ?>" />
                    <br />
                    <a onclick="image_upload('image<?php echo $image_row; ?>', 'thumb<?php echo $image_row; ?>');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb<?php echo $image_row; ?>').attr('src', '<?php echo $no_image; ?>'); $('#image<?php echo $image_row; ?>').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
                <td class="right"><input type="text" name="product_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $product_image['sort_order']; ?>" size="2" /></td>

                <td><input type="radio" name="def_img" value="<?php  if (isset($product_image['image'])) { echo $product_image['image']; } ?>"></td>
            
                <td class="left"><a onclick="$('#image-row<?php echo $image_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
              </tr>
            </tbody>
            <?php $image_row++; ?>
            <?php } ?>
            <tfoot>
              <tr>
                <td colspan="2"></td>
                <td class="left">
			</td><td><div id="file-uploader"><noscript><p>Please enable JavaScript to use file uploader.</p><!-- or put a simple form for upload here --></noscript></div><a onclick="addImage();" class="button"><?php echo $button_add_image; ?></a>
            </td>
              </tr>
            </tfoot>
          </table>
        </div>
        <div id="tab-reward">
          <table class="form">
            <tr>
              <td><?php echo $entry_points; ?></td>
              <td><input type="text" name="points" value="<?php echo $points; ?>" /></td>
            </tr>
          </table>
          <table class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $entry_customer_group; ?></td>
                <td class="right"><?php echo $entry_reward; ?></td>
              </tr>
            </thead>
            <?php foreach ($customer_groups as $customer_group) { ?>
            <tbody>
              <tr>
                <td class="left"><?php echo $customer_group['name']; ?></td>
                <td class="right"><input type="text" name="product_reward[<?php echo $customer_group['customer_group_id']; ?>][points]" value="<?php echo isset($product_reward[$customer_group['customer_group_id']]) ? $product_reward[$customer_group['customer_group_id']]['points'] : ''; ?>" /></td>
              </tr>
            </tbody>
            <?php } ?>
          </table>
        </div>
        <div id="tab-design">
          <table class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $entry_store; ?></td>
                <td class="left"><?php echo $entry_layout; ?></td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="left"><?php echo $text_default; ?></td>
                <td class="left"><select name="product_layout[0][layout_id]">
                    <option value=""></option>
                    <?php foreach ($layouts as $layout) { ?>
                    <?php if (isset($product_layout[0]) && $product_layout[0] == $layout['layout_id']) { ?>
                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
              </tr>
            </tbody>
            <?php foreach ($stores as $store) { ?>
            <tbody>
              <tr>
                <td class="left"><?php echo $store['name']; ?></td>
                <td class="left"><select name="product_layout[<?php echo $store['store_id']; ?>][layout_id]">
                    <option value=""></option>
                    <?php foreach ($layouts as $layout) { ?>
                    <?php if (isset($product_layout[$store['store_id']]) && $product_layout[$store['store_id']] == $layout['layout_id']) { ?>
                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
              </tr>
            </tbody>
            <?php } ?>
          </table>
        </div>

        <div id="tab-mapping-ax_code">
            <input type="hidden" name="product_type" value="<?php echo $mapping['type']; ?>" >
            <table class="list">
                <thead>
                <tr>
                    <td class="left"><?php echo $text_product_id; ?></td>
                    <td class="left"><?php echo $text_product_code; ?></td>
                    <td class="left"><?php echo $column_name; ?></td>
                    <td class="left"><?php echo $text_possible_variants; ?><br><?php  echo $text_colour; ?> - <?php echo $text_size; ?> - <?php echo $text_configuration; ?></td>
                    <td class="left"><?php echo $text_concatenated_ax_code; ?></td>
                </tr>
                </thead>

                <?php
                /*if( $_SERVER['REMOTE_ADDR'] == '188.26.23.46' ){
                print_r( $mapping );
                } */
                if ( $mapping['type'] == 1 ) {  ?>
                <tbody>
                <tr>
                    <td class="left"><?php echo $mapping['product_id']; ?></td>
                    <td class="left"><?php echo $mapping['product_upc']; ?></td>
                    <td class="left"><?php echo $mapping['Denumire']; ?></td>
                    <td class="left">---</td>
                    <td class="left">
                        <input type="text" name="product_ax_code[<?php echo $mapping['product_id']; ?>]" value="<?php echo $mapping['code_ax']; ?>" />
                    </td>
                </tr>
                </tbody>
                <?php } else
                if ( $mapping['type'] == 2 ) {
                    if ( !empty( $mapping['Culori']) )
                    {
                         foreach ( $mapping['Culori'] as $key => $colour ) {  ?>
                            <tbody>
                            <tr>
                                <td class="left"><?php echo $mapping['product_id']; ?></td>
                                <td class="left"><?php echo $mapping['product_upc']; ?></td>
                                <td class="left"><?php echo $mapping['Denumire']; ?></td>
                                <td class="left"><?php echo $colour; ?> --</td>
                                <!-- <td class="left"><?php echo $mapping['code_ax'][$key]; ?></td> -->
                                <td class="left"><input type="text" name="product_ax_code[<?php echo $key; ?>]" value="<?php echo $mapping['code_ax'][$key]; ?>" /></td>
                            </tr>
                            </tbody>
                        <?php }
                    }
                    else if ( !empty( $mapping['Marimi']) )
                    {
                        foreach ( $mapping['Marimi'] as $key => $size ) { ?>
                            <tbody>
                            <tr>
                                <td class="left"><?php echo $mapping['product_id']; ?></td>
                                <td class="left"><?php echo $mapping['product_upc']; ?></td>
                                <td class="left"><?php echo $mapping['Denumire']; ?></td>
                                <td class="left"> - <?php echo $size; ?> -</td>
                                <!-- <td class="left"><?php echo $mapping['code_ax'][$key]; ?></td> -->
                                <td class="left"><input type="text" name="product_ax_code[<?php echo $key; ?>]" value="<?php echo $mapping['code_ax'][$key]; ?>" /></td>
                            </tr>
                            </tbody>
                        <?php }
                    }
                    else if ( !empty( $mapping['Configuratie']) )
                    {
                        foreach ( $mapping['Configuratie'] as $key => $configuration ) { ?>
                            <tbody>
                            <tr>
                                <td class="left"><?php echo $mapping['product_id']; ?></td>
                                <td class="left"><?php echo $mapping['product_upc']; ?></td>
                                <td class="left"><?php echo $mapping['Denumire']; ?></td>
                                <td class="left"> --<?php echo $configuration; ?></td>
                                <!-- <td class="left"><?php echo $mapping['code_ax'][$key]; ?></td> -->
                                <td class="left"><input type="text" name="product_ax_code[<?php echo $key; ?>]" value="<?php echo $mapping['code_ax'][$key]; ?>" /></td>
                            </tr>
                            </tbody>
                    <? }
                    }
                }
                else if ( $mapping['type'] == 3 ) {
                    foreach ( $mapping['Combinatii'] as $key => $combination ) {
                ?>
                        <tbody>
                        <tr>
                            <td class="left"><?php echo $mapping['product_id']; ?></td>
                            <td class="left"><?php echo $mapping['product_upc']; ?></td>
                            <td class="left"><?php echo $mapping['Denumire']; ?></td>
                            <td class="left"> <?php echo $combination['Culori']; ?> - <?php echo $combination['Marimi']; ?> - </td>
                            <!-- <td class="left"><?php echo $mapping['code_ax'][ $key ]; ?></td> -->
                            <td class="left"><input type="text" name="product_ax_code[<?php echo $key; ?>]" value="<?php echo $mapping['code_ax'][$key]; ?>" /></td>
                        </tr>
                        </tbody>
                <?php }
                }?>

            </table>
        </div>



			
			<div id="tab-download-pdf">
				<div class="heading" style="width: 500px; height: 42px; background: rgb(238, 238, 238) none repeat scroll 0px 0px; border-top-left-radius: 10px; border-top-right-radius: 10px;">
				  	<h1 style="height: 34px; background: rgb(238, 238, 238) none repeat scroll 0px 0px; border-top-left-radius: 10px; border-top-right-radius: 10px; margin: 6px; width: 250px; display: inline-block;">
				  		<img alt="" src="view/image/product.png"> Documente
					</h1>
				  	<div class="buttons" style="width: 150px; display: inline-block; float: right; margin: 8px;">
				  		<a class="button" id="get_insert_form">Inserare</a>
				  		<a class="button" id="delete_document">Sterge</a>
					</div>
				</div>
				<div id="insert_document_popup" style="display:none;">
					<form id="insert_document_form" class="mmmm">
						<table>
							<tr>
								<td>Nume document</td>
								<td>
									<input name="product_document[product_id]" type="hidden" class="product_document_element" value="<?= $product_id ?>">
									<input name="product_document[document_name]" type="text" id="new_document_name" class="product_document_element">
									<span class="error" style="display:none;">Numele documentului trebuie sa fie intre 5 si 50 charactere!</span>
								</td>
							</tr>
							<tr>
								<td>Tip document</td>
								<td><input name="product_document[document_type]" type="text" id="new_document_type" class="product_document_element">
									<span class="error" style="display:none;">Tipul documentului trebuie sa fie intre 5 si 50 charactere!</span>
								</td>
							</tr>
							<tr>
								<td>Descriere document</td>
								<td><textarea name="product_document[document_description]" id="new_document_type" class="product_document_element"></textarea>
									<span class="error" style="display:none;">Descrierea documentului trebuie sa fie intre 5 si 250 charactere!!!</span>
								</td>
							</tr>
							<tr>
								<td>Drept de access</td>
								<td>
									<?php foreach ($customer_groups as $customer_group) { ?>
										<input id="insert_pdf_to_customer_group[<?= $customer_group['customer_group_id'] ?>]" type="checkbox" name="product_document[customer_group][<?= $customer_group['customer_group_id'] ?>]" value="<?= $customer_group['customer_group_id'] ?>" class="product_document_element" />
										<label for="insert_pdf_to_customer_group[<?= $customer_group['customer_group_id'] ?>]"><?= $customer_group['name'] ?></label><br>
									<?php } ?>
									<input id="insert_pdf_to_customer_group[5]" type="checkbox" name="product_document[customer_group][5]" value="5" class="product_document_element" />
									<label for="insert_pdf_to_customer_group[5]">Public</label><br>
								</td>
							</tr>
							<tr>
								<td>Document</td>
								<td>
								<?php foreach ($languages as $language) { ?>
									<input name="product_document[language_id]" type="hidden" class="product_document_element" value="<?php echo $language['language_id']; ?>">
									<input id="field<?php echo $language['language_id']; ?>" type="text" name="product_document[file_name]" value="<?php echo isset($description_document[$language['language_id']]) ? $description_document[$language['language_id']]['file_name'] : ''; ?>" class="product_document_element" />
									<a onclick="docupload(this.id)" id="button-upload<?php echo $language['language_id']; ?>" class="button">Adaugare document</a>
									<br/><br/>
								<?php } ?>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<a class="button" id="insert_document_btn">Salvare</a>
									<a class="button" id="hide_insert_document_popup">Inchide</a>
									<span class="success" id="success_product_document_insert_<?= $document['product_description_download_pdf_id'] ?>" style="display:none;">Document adaugt cu succes!</span>
								</td>
							</tr>
						</table>
					</form>
				</div>
				<?php /* ?>
				<table class="form">
			  		<tr>

				  	</tr>
				  	<tr>
						<td><?= $entry_customer_group ?></td>
						<td></td>
					</tr>
				  	<?php foreach ($customer_groups as $customer_group) { ?>
				  	<tr>
						<td>
							<input id="description_pdf_to_customer_group[<?= $customer_group['customer_group_id'] ?>]" type="checkbox" name="description_pdf_to_customer_group[<?= $customer_group['customer_group_id'] ?>]" value="<?= $customer_group['customer_group_id'] ?>" />
							<label for="description_pdf_to_customer_group[<?= $customer_group['customer_group_id'] ?>]"><?= $customer_group['name'] ?></label>
						</td>
				  	</tr>
				  	<?php } ?>
			  	</table>
			  	<?php */ ?>
			  	<?php if($description_document) { ?>
				<div style="width: 500px;">
					<div style="border-bottom: 1px solid #DDD; ">
						<span><input type="checkbox" class="delete_document" name="delete_document[all]" value="all"></span>
						<span style="width: 300px; display: inline-block; padding: 5px;"><strong>Numele documentului</strong></span>
						<span style="width: 100px; display: inline-block; padding: 5px;"><strong>Actiune</strong></span>
					</div>
					<?php foreach ($description_document as $document) { ?>
					<div style="border-bottom: 1px solid #DDD;">
						<span><input type="checkbox" class="delete_document" name="delete_document[<?= $document['product_description_download_pdf_id'] ?>]" value="<?= $document['product_description_download_pdf_id'] ?>"></span>
						<span style="width: 300px; display: inline-block; padding: 5px;"><?= $document['document_name'] ?></span>
						<span style="width: 100px; display: inline-block; padding: 5px;">
							<a href="javascript:void(0);" id="<?= $document['product_description_download_pdf_id'] ?>" class="get_pr_document_details">Editare</a>
						</span>
					</div>
					<div class="pr_document_details" id="pr_document_details_<?= $document['product_description_download_pdf_id'] ?>" style="display:none;">
						<?php //echo "<pre>"; print_r($document); print_r($customer_groups); ?>
						<table>
							<tr>
								<td>Nume document</td>
								<td>
									<input name="product_document[product_document_id]" type="hidden" class="product_document_update_<?= $document['product_description_download_pdf_id'] ?>" value="<?= $document['product_description_download_pdf_id'] ?>">
									<input name="product_document[product_id]" type="hidden" class="product_document_update_<?= $document['product_description_download_pdf_id'] ?>" value="<?= $product_id ?>">
									<input name="product_document[document_name]" type="text" id="new_document_name" class="product_document_update_<?= $document['product_description_download_pdf_id'] ?>" value="<?= $document['document_name'] ?>" />
									<span class="error" style="display:none;">Numele documentului trebuie sa fie intre 5 si 50 charactere!</span>
								</td>
							</tr>
							<tr>
								<td>Tip document</td>
								<td><input name="product_document[document_type]" type="text" id="new_document_type" class="product_document_update_<?= $document['product_description_download_pdf_id'] ?>" value="<?= $document['document_type'] ?>" />
									<span class="error" style="display:none;">Tipul documentului trebuie sa fie intre 5 si 50 charactere!</span>
								</td>
							</tr>
							<tr>
								<td>Descriere document</td>
								<td><textarea name="product_document[document_description]" id="new_document_type" class="product_document_update_<?= $document['product_description_download_pdf_id'] ?>"><?= $document['document_description'] ?></textarea>
									<span class="error" style="display:none;">Descrierea documentului trebuie sa fie intre 5 si 250 charactere!!!</span>
								</td>
							</tr>
							<tr>
								<td>Drept de access</td>
								<td>
									<?php foreach ($customer_groups as $customer_group) { ?>
										<?php $match = false; ?>
										<?php foreach ($document['customer_to_group'] as $doc_group) { ?>
											<?php if ($doc_group['customer_group_id'] == $customer_group['customer_group_id']) { ?>
												<?php $match = true; ?>
												<input id="insert_pdf_to_customer_group[<?= $customer_group['customer_group_id'] ?>]" type="checkbox" <?= 'checked' ?> name="product_document[customer_group][<?= $customer_group['customer_group_id'] ?>]" value="<?= $customer_group['customer_group_id'] ?>" class="product_document_update_<?= $document['product_description_download_pdf_id'] ?>" />
											<?php } ?>
										<?php } ?>
										<?php if (!$match) { ?>
											<input id="insert_pdf_to_customer_group[<?= $customer_group['customer_group_id'] ?>]" type="checkbox"  name="product_document[customer_group][<?= $customer_group['customer_group_id'] ?>]" value="<?= $customer_group['customer_group_id'] ?>" class="product_document_update_<?= $document['product_description_download_pdf_id'] ?>" />
										<?php } ?>
										<label for="insert_pdf_to_customer_group[<?= $customer_group['customer_group_id'] ?>]"><?= $customer_group['name'] ?></label><br>
									<?php } ?>
									<?php $public = false; ?>
									<?php foreach ($document['customer_to_group'] as $doc_group) { ?>
										<?php if ($doc_group['customer_group_id'] == '5') { ?>
											<input id="insert_pdf_to_customer_group[5]" type="checkbox" <?= 'checked' ?> name="product_document[customer_group][5]" value="5" class="product_document_update_<?= $document['product_description_download_pdf_id'] ?>" />
										<?php $public = true; } ?>
									<?php } ?>
									<?php if (!$public) { ?>
										<input id="insert_pdf_to_customer_group[5]" type="checkbox" name="product_document[customer_group][5]" value="5" class="product_document_update_<?= $document['product_description_download_pdf_id'] ?>" />
									<?php } ?>
									<label for="insert_pdf_to_customer_group[5]">Public</label><br>
								</td>
							</tr>
							<tr>
								<td>Document</td>
								<td>
								<?php foreach ($languages as $language) { ?>
									<input name="product_document[language_id]" type="hidden" class="product_document_update_<?= $document['product_description_download_pdf_id'] ?>" value="<?php echo $language['language_id']; ?>">

									<input id="field<?php echo $document['product_description_download_pdf_id']; ?>" type="text" name="product_document[file_name]" value="<?= $document['file_name'] ?>" class="product_document_update_<?= $document['product_description_download_pdf_id'] ?>" />
									<a onclick="docupload(this.id)" id="button-upload<?php echo $document['product_description_download_pdf_id']; ?>" class="button button-upload">Adaugare document</a>
									<?php /* ?>
									<input id="field<?php echo $language['language_id']; ?>" type="text" name="description_document[<?php echo $language['language_id']; ?>][file_name]" value="<?php echo isset($description_document[$language['language_id']]) ? $description_document[$language['language_id']]['file_name'] : ''; ?>" />
            						<a onclick="docupload(this.id)" id="button-upload<?php echo $language['language_id']; ?>" class="button"><?php echo $button_upload; ?></a>
									<?php */ ?>
									<br/><br/>
								<?php } ?>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<a class="button update_document_btn" id="<?= $document['product_description_download_pdf_id'] ?>">Salvare</a>
									<a class="button hide_update_document_popup" id="<?= $document['product_description_download_pdf_id'] ?>">Inchide</a>
									<span class="success" id="success_product_document_update_<?= $document['product_description_download_pdf_id'] ?>" style="display:none;">Sa modificat cu succes!</span>
								</td>
							</tr>
						</table>
					</div>
					<?php } ?>
				</div>
			  	<?php //echo "<pre>"; print_r($description_document); ?>
			  	<?php } ?>
			</div>
			
			
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>


                CKEDITOR.replace('option_combo_description<?php echo $language['language_id']; ?>', {

                	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',

                	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',

                	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',

                	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',

                	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',

                	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'

                });

            
CKEDITOR.replace('description<?php echo $language['language_id']; ?>', {
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
$.widget('custom.catcomplete', $.ui.autocomplete, {
	_renderMenu: function(ul, items) {
		var self = this, currentCategory = '';
		
		$.each(items, function(index, item) {
			if (item.category != currentCategory) {
				ul.append('<li class="ui-autocomplete-category">' + item.category + '</li>');
				
				currentCategory = item.category;
			}
			
			self._renderItem(ul, item);
		});
	}
});

// Manufacturer
$('input[name=\'manufacturer\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/manufacturer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.manufacturer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'manufacturer\']').attr('value', ui.item.label);
		$('input[name=\'manufacturer_id\']').attr('value', ui.item.value);
	
		return false;
	},
	focus: function(event, ui) {
      return false;
   }
});

// Category
$('input[name=\'category\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.category_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('#product-category' + ui.item.value).remove();
		
		$('#product-category').append('<div id="product-category' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="product_category[]" value="' + ui.item.value + '" /></div>');

		$('#product-category div:odd').attr('class', 'odd');
		$('#product-category div:even').attr('class', 'even');
				
		return false;
	},
	focus: function(event, ui) {
      return false;
   }
});

$('#product-category div img').live('click', function() {
	$(this).parent().remove();
	
	$('#product-category div:odd').attr('class', 'odd');
	$('#product-category div:even').attr('class', 'even');	
});

// Filter
$('input[name=\'filter\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/filter/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.filter_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('#product-filter' + ui.item.value).remove();
		
		$('#product-filter').append('<div id="product-filter' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="product_filter[]" value="' + ui.item.value + '" /></div>');

		$('#product-filter div:odd').attr('class', 'odd');
		$('#product-filter div:even').attr('class', 'even');
				
		return false;
	},
	focus: function(event, ui) {
      return false;
   }
});

$('#product-filter div img').live('click', function() {
	$(this).parent().remove();
	
	$('#product-filter div:odd').attr('class', 'odd');
	$('#product-filter div:even').attr('class', 'even');	
});

// Downloads
$('input[name=\'download\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/download/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.download_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('#product-download' + ui.item.value).remove();
		
		$('#product-download').append('<div id="product-download' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="product_download[]" value="' + ui.item.value + '" /></div>');

		$('#product-download div:odd').attr('class', 'odd');
		$('#product-download div:even').attr('class', 'even');
				
		return false;
	},
	focus: function(event, ui) {
      return false;
   }
});

$('#product-download div img').live('click', function() {
	$(this).parent().remove();
	
	$('#product-download div:odd').attr('class', 'odd');
	$('#product-download div:even').attr('class', 'even');	
});

// Related
$('input[name=\'related\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('#product-related' + ui.item.value).remove();
		
		$('#product-related').append('<div id="product-related' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="product_related[]" value="' + ui.item.value + '" /></div>');

		$('#product-related div:odd').attr('class', 'odd');
		$('#product-related div:even').attr('class', 'even');
				
		return false;
	},
	focus: function(event, ui) {
      return false;
   }
});

$('#product-related div img').live('click', function() {
    $(this).parent().remove();

    $('#product-related div:odd').attr('class', 'odd');
    $('#product-related div:even').attr('class', 'even');
});


// Complementary
$('input[name=\'complementary\']').autocomplete({
    delay: 500,
    source: function(request, response) {
        $.ajax({
            url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
            dataType: 'json',
            success: function(json) {
                response($.map(json, function(item) {
                    return {
                        label: item.name,
                        value: item.product_id
                    }
                }));
            }
        });
    },
    select: function(event, ui) {
        $('#product-complementary' + ui.item.value).remove();

        $('#product-complementary').append('<div id="product-complementary' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="product_complementary[]" value="' + ui.item.value + '" /></div>');

        $('#product-complementary div:odd').attr('class', 'odd');
        $('#product-complementary div:even').attr('class', 'even');

        return false;
    },
    focus: function(event, ui) {
        return false;
    }
});

$('#product-complementary div img').live('click', function() {
	$(this).parent().remove();
	
	$('#product-complementary div:odd').attr('class', 'odd');
	$('#product-complementary div:even').attr('class', 'even');
});
//--></script> 
<script type="text/javascript"><!--
var attribute_row = <?php echo $attribute_row; ?>;

function addAttribute() {
	html  = '<tbody id="attribute-row' + attribute_row + '">';
    html += '  <tr>';
	html += '    <td class="left"><input type="text" name="product_attribute[' + attribute_row + '][name]" value="" /><input type="hidden" name="product_attribute[' + attribute_row + '][attribute_id]" value="" /></td>';
	html += '    <td class="left">';
	<?php foreach ($languages as $language) { ?>
	html += '<textarea name="product_attribute[' + attribute_row + '][product_attribute_description][<?php echo $language['language_id']; ?>][text]" cols="40" rows="5"></textarea><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" align="top" /><br />';
    <?php } ?>
	html += '    </td>';
	html += '    <td class="left"><a onclick="$(\'#attribute-row' + attribute_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
    html += '  </tr>';	
    html += '</tbody>';
	
	$('#attribute tfoot').before(html);
	
	attributeautocomplete(attribute_row);
	
	attribute_row++;
}

function attributeautocomplete(attribute_row) {
	$('input[name=\'product_attribute[' + attribute_row + '][name]\']').catcomplete({
		delay: 500,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/attribute/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
				dataType: 'json',
				success: function(json) {	
					response($.map(json, function(item) {
						return {
							category: item.attribute_group,
							label: item.name,
							value: item.attribute_id
						}
					}));
				}
			});
		}, 
		select: function(event, ui) {
			$('input[name=\'product_attribute[' + attribute_row + '][name]\']').attr('value', ui.item.label);
			$('input[name=\'product_attribute[' + attribute_row + '][attribute_id]\']').attr('value', ui.item.value);
			
			return false;
		},
		focus: function(event, ui) {
      		return false;
   		}
	});
}

$('#attribute tbody').each(function(index, element) {
	attributeautocomplete(index);
});
//--></script> 
<script type="text/javascript"><!--	
var option_row = <?php echo $option_row; ?>;

$('input[name=\'option\']').catcomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/option/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						category: item.category,
						label: item.name,
						value: item.option_id,
						type: item.type,
						option_value: item.option_value
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		html  = '<div id="tab-option-' + option_row + '" class="vtabs-content">';
		html += '	<input type="hidden" name="product_option[' + option_row + '][product_option_id]" value="" />';
		html += '	<input type="hidden" name="product_option[' + option_row + '][name]" value="' + ui.item.label + '" />';
		html += '	<input type="hidden" name="product_option[' + option_row + '][option_id]" value="' + ui.item.value + '" />';
		html += '	<input type="hidden" name="product_option[' + option_row + '][type]" value="' + ui.item.type + '" />';
		html += '	<table class="form">';
		html += '	  <tr>';
		html += '		<td><?php echo $entry_required; ?></td>';
		html += '       <td><select name="product_option[' + option_row + '][required]">';
		html += '	      <option value="1"><?php echo $text_yes; ?></option>';
		html += '	      <option value="0"><?php echo $text_no; ?></option>';
		html += '	    </select></td>';
		html += '     </tr>';
		
		if (ui.item.type == 'text') {
			html += '     <tr>';
			html += '       <td><?php echo $entry_option_value; ?></td>';
			html += '       <td><input type="text" name="product_option[' + option_row + '][option_value]" value="" /></td>';
			html += '     </tr>';
		}
		
		if (ui.item.type == 'textarea') {
			html += '     <tr>';
			html += '       <td><?php echo $entry_option_value; ?></td>';
			html += '       <td><textarea name="product_option[' + option_row + '][option_value]" cols="40" rows="5"></textarea></td>';
			html += '     </tr>';						
		}
		 
		if (ui.item.type == 'file') {
			html += '     <tr style="display: none;">';
			html += '       <td><?php echo $entry_option_value; ?></td>';
			html += '       <td><input type="text" name="product_option[' + option_row + '][option_value]" value="" /></td>';
			html += '     </tr>';			
		}
						
		if (ui.item.type == 'date') {
			html += '     <tr>';
			html += '       <td><?php echo $entry_option_value; ?></td>';
			html += '       <td><input type="text" name="product_option[' + option_row + '][option_value]" value="" class="date" /></td>';
			html += '     </tr>';			
		}
		
		if (ui.item.type == 'datetime') {
			html += '     <tr>';
			html += '       <td><?php echo $entry_option_value; ?></td>';
			html += '       <td><input type="text" name="product_option[' + option_row + '][option_value]" value="" class="datetime" /></td>';
			html += '     </tr>';			
		}
		
		if (ui.item.type == 'time') {
			html += '     <tr>';
			html += '       <td><?php echo $entry_option_value; ?></td>';
			html += '       <td><input type="text" name="product_option[' + option_row + '][option_value]" value="" class="time" /></td>';
			html += '     </tr>';			
		}
		
		html += '  </table>';
			
		if (ui.item.type == 'select' || ui.item.type == 'radio' || ui.item.type == 'checkbox' || ui.item.type == 'image') {
			html += '  <table id="option-value' + option_row + '" class="list">';
			html += '  	 <thead>'; 
			html += '      <tr>';
			html += '        <td class="left"><?php echo $entry_option_value; ?></td>';
			html += '        <td class="right"><?php echo $entry_quantity; ?></td>';
			html += '        <td class="left"><?php echo $entry_subtract; ?></td>';
			html += '        <td class="right"><?php echo $entry_price; ?></td>';
			html += '        <td class="right"><?php echo $entry_option_points; ?></td>';
			html += '        <td class="right"><?php echo $entry_weight; ?></td>';
			html += '        <td></td>';
			html += '      </tr>';
			html += '  	 </thead>';
			html += '    <tfoot>';
			html += '      <tr>';
			html += '        <td colspan="6"></td>';
			html += '        <td class="left"><a onclick="addOptionValue(' + option_row + ');" class="button"><?php echo $button_add_option_value; ?></a></td>';
			html += '      </tr>';
			html += '    </tfoot>';
			html += '  </table>';
            html += '  <select id="option-values' + option_row + '" style="display: none;">';
			
            for (i = 0; i < ui.item.option_value.length; i++) {
				html += '  <option value="' + ui.item.option_value[i]['option_value_id'] + '">' + ui.item.option_value[i]['name'] + '</option>';
            }

            html += '  </select>';			
			html += '</div>';	
		}
		
		$('#tab-option').append(html);
		
		$('#option-add').before('<a href="#tab-option-' + option_row + '" id="option-' + option_row + '">' + ui.item.label + '&nbsp;<img src="view/image/delete.png" alt="" onclick="$(\'#option-' + option_row + '\').remove(); $(\'#tab-option-' + option_row + '\').remove(); $(\'#vtab-option a:first\').trigger(\'click\'); return false;" /></a>');
		
		$('#vtab-option a').tabs();
		
		$('#option-' + option_row).trigger('click');		
		
		$('.date').datepicker({dateFormat: 'yy-mm-dd'});
		$('.datetime').datetimepicker({
			dateFormat: 'yy-mm-dd',
			timeFormat: 'h:m'
		});	
			
		$('.time').timepicker({timeFormat: 'h:m'});	
				
		option_row++;
		
		return false;
	},
	focus: function(event, ui) {
      return false;
   }
});
//--></script> 
<script type="text/javascript"><!--		
var option_value_row = <?php echo $option_value_row; ?>;

function addOptionValue(option_row) {	
	html  = '<tbody id="option-value-row' + option_value_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][option_value_id]">';
	html += $('#option-values' + option_row).html();
	html += '    </select><input type="hidden" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][product_option_value_id]" value="" /></td>';
	html += '    <td class="right"><input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][quantity]" value="" size="3" /></td>'; 
	html += '    <td class="left"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][subtract]">';
	html += '      <option value="1"><?php echo $text_yes; ?></option>';
	html += '      <option value="0"><?php echo $text_no; ?></option>';
	html += '    </select></td>';
	html += '    <td class="right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][price_prefix]">';
	html += '      <option value="+">+</option>';
	html += '      <option value="-">-</option>';
	html += '    </select>';
	html += '    <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][price]" value="" size="5" /></td>';
	html += '    <td class="right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][points_prefix]">';
	html += '      <option value="+">+</option>';
	html += '      <option value="-">-</option>';
	html += '    </select>';
	html += '    <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][points]" value="" size="5" /></td>';	
	html += '    <td class="right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][weight_prefix]">';
	html += '      <option value="+">+</option>';
	html += '      <option value="-">-</option>';
	html += '    </select>';
	html += '    <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][weight]" value="" size="5" /></td>';
	html += '    <td class="left"><a onclick="$(\'#option-value-row' + option_value_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#option-value' + option_row + ' tfoot').before(html);

	option_value_row++;
}
//--></script> 
<script type="text/javascript"><!--
var discount_row = <?php echo $discount_row; ?>;

function addDiscount() {
	html  = '<tbody id="discount-row' + discount_row + '">';
	html += '  <tr>'; 
    html += '    <td class="left"><select name="product_discount[' + discount_row + '][customer_group_id]">';
    <?php foreach ($customer_groups as $customer_group) { ?>
    html += '      <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>';
    <?php } ?>
    html += '    </select></td>';		
    html += '    <td class="right"><input type="text" name="product_discount[' + discount_row + '][quantity]" value="" size="2" /></td>';
    html += '    <td class="right"><input type="text" name="product_discount[' + discount_row + '][priority]" value="" size="2" /></td>';
	html += '    <td class="right"><input type="text" name="product_discount[' + discount_row + '][price]" value="" /></td>';
    html += '    <td class="left"><input type="text" name="product_discount[' + discount_row + '][date_start]" value="" class="date" /></td>';
	html += '    <td class="left"><input type="text" name="product_discount[' + discount_row + '][date_end]" value="" class="date" /></td>';
	html += '    <td class="left"><a onclick="$(\'#discount-row' + discount_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';	
    html += '</tbody>';
	
	$('#discount tfoot').before(html);
		
	$('#discount-row' + discount_row + ' .date').datepicker({dateFormat: 'yy-mm-dd'});
	
	discount_row++;
}
//--></script> 
<script type="text/javascript"><!--
var special_row = <?php echo $special_row; ?>;

function addSpecial() {
	html  = '<tbody id="special-row' + special_row + '">';
	html += '  <tr>'; 
    html += '    <td class="left"><select name="product_special[' + special_row + '][customer_group_id]">';
    <?php foreach ($customer_groups as $customer_group) { ?>
    html += '      <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>';
    <?php } ?>
    html += '    </select></td>';		
    html += '    <td class="right"><input type="text" name="product_special[' + special_row + '][priority]" value="" size="2" /></td>';
	html += '    <td class="right"><input type="text" name="product_special[' + special_row + '][price]" value="" /></td>';
    html += '    <td class="left"><input type="text" name="product_special[' + special_row + '][date_start]" value="" class="date" /></td>';
	html += '    <td class="left"><input type="text" name="product_special[' + special_row + '][date_end]" value="" class="date" /></td>';
	html += '    <td class="left"><a onclick="$(\'#special-row' + special_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
    html += '</tbody>';
	
	$('#special tfoot').before(html);
 
	$('#special-row' + special_row + ' .date').datepicker({dateFormat: 'yy-mm-dd'});
	
	special_row++;
}
//--></script> 
<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'text',
					success: function(text) {
						$('#' + thumb).replaceWith('<img src="' + text + '" alt="" id="' + thumb + '" />');

              var row =field.replace('image','');  $('#radio_'+row).replaceWith('<input type="radio" name="def_img" value='+$('#' + field).attr('value')+'>');
            
					}
				});
			}
		},	
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script> 
<script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;

function addImage() {
    html  = '<tbody id="image-row' + image_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><div class="image"><img src="<?php echo $no_image; ?>" alt="" id="thumb' + image_row + '" /><input type="hidden" name="product_image[' + image_row + '][image]" value="" id="image' + image_row + '" /><br /><a onclick="image_upload(\'image' + image_row + '\', \'thumb' + image_row + '\');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$(\'#thumb' + image_row + '\').attr(\'src\', \'<?php echo $no_image; ?>\'); $(\'#image' + image_row + '\').attr(\'value\', \'\');"><?php echo $text_clear; ?></a></div></td>';
	html += '    <td class="right"><input type="text" name="product_image[' + image_row + '][sort_order]" value="" size="2" /></td>';

                html += '<td><input type="radio" name="def_img" id="radio_' + image_row + '" value="" disabled="disabled"></td>';
            
	html += '    <td class="left"><a onclick="$(\'#image-row' + image_row  + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#images tfoot').before(html);
	
	image_row++;
}
//--></script> 
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
$('.date').datepicker({dateFormat: 'yy-mm-dd'});
$('.datetime').datetimepicker({
	dateFormat: 'yy-mm-dd',
	timeFormat: 'h:m'
});
$('.time').timepicker({timeFormat: 'h:m'});
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
$('#languages a').tabs(); 
$('#vtab-option a').tabs();

var profileCount = <?php echo $profileCount ?>;

function addProfile() {
    profileCount++;
    
    var html = '';
    html += '<tr id="profile-row' + profileCount + '">';
    html += '  <td class="left">';
    html += '    <select name="product_profiles[' + profileCount + '][profile_id]">';
    <?php foreach ($profiles as $profile): ?>
    html += '      <option value="<?php echo $profile['profile_id'] ?>"><?php echo $profile['name'] ?></option>';
    <?php endforeach; ?>
    html += '    </select>';
    html += '  </td>';
    html += '  <td class="left">';
    html += '    <select name="product_profiles[' + profileCount + '][customer_group_id]">';
    <?php foreach ($customer_groups as $customer_group): ?>
    html += '      <option value="<?php echo $customer_group['customer_group_id'] ?>"><?php echo $customer_group['name'] ?></option>';
    <?php endforeach; ?>
    html += '    <select>';
    html += '  </td>';
    html += '  <td class="left">';
    html += '    <a class="button" onclick="$(\'#profile-row' + profileCount + '\').remove()"><?php echo $button_remove ?></a>';
    html += '  </td>';
    html += '</tr>';
    
    $('#tab-profile table tbody').append(html);
}

<?php if (isset($this->request->get['product_id'])) { ?>
    function openbayLinkStatus(){
        var product_id = '<?php echo $this->request->get['product_id']; ?>';
        $.ajax({
            type: 'GET',
            url: 'index.php?route=extension/openbay/linkStatus&token=<?php echo $token; ?>&product_id='+product_id,
            dataType: 'html',
            success: function(data) {
                //add the button to nav
                $('<a href="#tab-openbay"><?php echo $tab_marketplace_links ?></a>').hide().appendTo("#tabs").fadeIn(1000);
                $('#tab-general').before(data);
                $('#tabs a').tabs();
            },
            failure: function(){

            },
            error: function() {

            }
        });
    }

    $(document).ready(function(){
        openbayLinkStatus();
    });
<?php } ?>

//--></script>



                <script type="text/javascript"><!--

                $("select[name='options']").live('change', function() {

                    var this_option = $(this);

                    var option_id = $(this).val();

                    //var product_id = $("input[name='product_id']").val();

                    // BALAZS

                    var thisRowNumber = $(this_option).attr("id").substring( 12 );

                    var product_id = $("input[name='product_option_combo[" + thisRowNumber + "][product_id]']").val();

                    $.ajax({

            			url: 'index.php?route=catalog/product/option&token=<?php echo $token; ?>&option_id=' + option_id + '&product_id=' + product_id,

            			type: 'GET',

            			dataType: 'html',

            			success: function(data) {

                            $("#" + $(this_option).attr("id") + "-value").html(data);

            			}

            		});

                }).change();

                $("a.add-option-value-btn").live('click', function() {

                    var option_value_val = $("#combo-option" + $(this).attr("name") + "-value option:selected").val();

                    var option_html = $("#combo-option" + $(this).attr("name") + " option:selected").html() + " > " + $("#combo-option" + $(this).attr("name") + "-value option:selected").html();

                    var exist = false;

                    var option_value_count = 0;

                    $("#combo-option" + $(this).attr("name") + "-values-selected option").each(function() {

                        if($(this).val() == option_value_val)

                        {

                            exist = true;

                            return false;

                        }

                        option_value_count++;

                    });

                    if(!exist)

                    {

                        $("#combo-option" + $(this).attr("name") + "-values-selected").append('<option value="' + option_value_val + '">' + option_html + '</option>');

                    }

                    return false;

                });

                $("a.remove-option-value-btn").live('click', function() {

                    $("#combo-option" + $(this).attr("name") + "-values-selected option:selected").remove();

                    return false;

                });

                var combo_row = <?php echo $product_option_combo_count; ?>;



                function add_combo()

                {

                    var html = '<tbody id="combo-row' + combo_row + '"><tr>';

                    html += '<td class="left"><input type="hidden" name="product_option_combo[' + combo_row + '][product_id]" value="<?php echo $product_id; ?>" />';

                    html += '<select name="options" id="combo-option' + combo_row + '" style="width: 200px;"><?php echo $options; ?></select><br /><select name="option-values" id="combo-option' + combo_row + '-value" style="width: 150px;"></select>';

                    html += '<a href="#" class="add-option-value-btn" name="' + combo_row + '"><img src="view/image/add.png" /></a> <a href="#" class="remove-option-value-btn" name="' + combo_row + '"><img src="view/image/delete.png" /></a>';

                    html += '<br /><select multiple="multiple" name="product_option_combo[' + combo_row + '][product_option_combo_values][]" id="combo-option' + combo_row + '-values-selected" class="option-combo-values-selected" size="5" style="width: 200px;"></select></td>';

                    html += '<td class="right"><input type="text" name="product_option_combo[' + combo_row + '][stock]" value="0" size="3" /><br />';

                    html += '<?php echo $entry_subtract; ?><select name="product_option_combo[' + combo_row + '][subtract]">';

                    html += '<option value="1"><?php echo $text_yes; ?></option><option value="0"><?php echo $text_no; ?></option></select></td>';

                    html += '<td class="right"><input type="text" name="product_option_combo[' + combo_row + '][quantity]" value="0" size="4" /></td>';

                    html += '<td class="right"><select name="product_option_combo[' + combo_row + '][price_prefix]">';

                    html += '<option value="=">Absolute</option><option value="+">+</option><option value="-">-</option><option value="0">Disable</option></select><input type="text" name="product_option_combo[' + combo_row + '][price]" value="0" size="8" /></td>';

                    html += '<td class="right"><select name="product_option_combo[' + combo_row + '][points_prefix]">';

                    html += '<option value="=">Absolute</option><option value="+">+</option><option value="-">-</option><option value="0">Disable</option></select><input type="text" name="product_option_combo[' + combo_row + '][points]" value="0" size="8" /></td>';

                    html += '<td class="right"><select name="product_option_combo[' + combo_row + '][weight_prefix]">';

                    html += '<option value="=">Absolute</option><option value="+">+</option><option value="-">-</option><option value="0">Disable</option></select><input type="text" name="product_option_combo[' + combo_row + '][weight]" value="0" size="8" /></td>';

                    html += '<td class="right"><input type="text" name="product_option_combo[' + combo_row + '][sort_order]" value="0" size="1" /></td>';

                    html += '<td class="right"><select name="product_option_combo[' + combo_row + '][customer_group_id]">';

                    <?php foreach ($customer_groups as $customer_group) { ?>

                    html += '<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>';

                    <?php } ?>

                    html += '</select></td>';

                    html += '<td class="center"><?php echo $entry_date_start; ?><input type="text" name="product_option_combo[' + combo_row + '][date_start]" class="date" value="0000-00-00" size="8" /><br /><br /><?php echo $entry_date_end; ?><input type="text" name="product_option_combo[' + combo_row + '][date_end]" class="date" value="0000-00-00" size="8" /></td>';

                    html += '<td class="center"><a onclick="$(this).parent().parent().find(\'td\').fadeOut(\'slow\', function(){$(this).remove();});" class="button"><span><?php echo $button_remove; ?></span></a></td></tr></tbody>';

                    html += '</tr></tbody>';



                    $('#option-combo tfoot').before(html);

                    $('select#combo-option' + combo_row).change();



	                $('#combo-row' + combo_row + ' .date').datepicker({dateFormat: 'yy-mm-dd'});



                    combo_row++;

                }

                $('#htab-option-combo a').tabs();

                $("#form").submit(function() {

                    $(".option-combo-values-selected option").each(function() {

                         $(this).attr("selected", "selected");

                    });

                });



                $('.ahelp').each( function() {

                    var href = "";

                    var extra = "";

                    if($(this).attr('href') != undefined)

                    {

                        href = '<img src="' + $(this).attr('href') + '" />';

                    }

                    if($(this).attr('rel') != undefined)

                    {

                        extra = '<p>' + $(this).attr('rel') + '</p>';

                    }



                    $(this).qtip({

                        content: href + extra,

                        position: {

                            corner: {

                                target: 'rightMiddle',

                                tooltip: 'leftMiddle'

                            }

                        },

                        style: {

                            tip: 'leftMiddle',

                            width: 520,

                            border: { color: "#AAAAAA" },

                            background: "#FFFFFF",

                        },

                    }).click(function() {

                        return false;

                    });

                });

                $('.chelp').each( function() {

                    var href = "";

                    var extra = "";

                    if($(this).attr('href') != undefined)

                    {

                        href = '<img src="' + $(this).attr('href') + '" />';

                    }

                    if($(this).attr('rel') != undefined)

                    {

                        extra = '<p>' + $(this).attr('rel') + '</p>';

                    }



                    $(this).qtip({

                        content: href + extra,

                        position: {

                            corner: {

                                target: 'topMiddle',

                                tooltip: 'bottomMiddle'

                            }

                        },

                        style: {

                            tip: 'bottomMiddle',

                            border: { color: "#AAAAAA" },

                            background: "#FFFFFF",

                        },

                    }).click(function() {

                        return false;

                    });

                });



                //--></script>

            

			
		<script type="text/javascript" src="view/javascript/jquery/ajaxupload.js"></script>
	<?php foreach ($languages as $language) { ?>
	<script type="text/javascript"><!--
	new AjaxUpload('#button-upload<?php echo $language['language_id']; ?>', {
		action: 'index.php?route=catalog/download/upload&token=<?php echo $token; ?>',
		name: 'file',
		autoSubmit: true,
		responseType: 'json',
		onSubmit: function(file, extension) {
			$('#button-upload<?php echo $language['language_id']; ?>').after('<img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" />');
			$('#button-upload<?php echo $language['language_id']; ?>').attr('disabled', true);
		},
		onComplete: function(file, json) {
			$('#button-upload<?php echo $language['language_id']; ?>').attr('disabled', false);

			if (json['success']) {
				alert(json['success']);
				$('#field<?php echo $language['language_id']; ?>').attr('value', json['filename']);
			}

			if (json['error']) {
				alert(json['error']);
			}

			$('.loading').remove();
		}
	});
	//--></script>
	<?php } ?>
	<?php foreach ($description_document as $document) { ?>
	<script type="text/javascript"><!--
	new AjaxUpload('#button-upload<?php echo $document['product_description_download_pdf_id']; ?>', {
		action: 'index.php?route=catalog/download/upload&token=<?php echo $token; ?>',
		name: 'file',
		autoSubmit: true,
		responseType: 'json',
		onSubmit: function(file, extension) {
            console.log(file+' '+extension);
			$('#button-upload<?php echo $document['product_description_download_pdf_id']; ?>').after('<img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" />');
			$('#button-upload<?php echo $document['product_description_download_pdf_id']; ?>').attr('disabled', true);
		},
		onComplete: function(file, json) {
			console.log(file+' '+json);
			$('#button-upload<?php echo $document['product_description_download_pdf_id']; ?>').attr('disabled', false);

			if (json['success']) {
				alert(json['success']);
				console.log(json['success']);
				$('#field<?php echo $document['product_description_download_pdf_id']; ?>').attr('value', json['filename']);
			}

			if (json['error']) {
				alert(json['error']);
				console.log(json['error']);
			}

			$('.loading').remove();
		}
	});
	//--></script>
	<?php } ?>
	<script type="text/javascript">
	$( document ).ready(function() {
		$('#get_insert_form').on( "click", function() {
		  	$('#insert_document_popup').show();
		  	$('.success').hide();
		});

		$('#hide_insert_document_popup').on( "click", function() {
		  	$('#insert_document_popup').hide();
		  	$('.success').hide();
		});

		$('#insert_document_btn').on( "click", function() {
			var form_validation = false;

			if ($('#new_document_name').val().length < 5 || $('#new_document_name').val().length > 50) {
				//console.log('length validation '+$('#new_document_name').val().length);
				form_validation = false;
				$('#new_document_name').next('span').show();
			} else {
				$('#new_document_name').next('span').hide();
				form_validation = true;
			}

			if ($('#new_document_type').val().length < 5 || $('#new_document_type').val().length > 50) {
				//console.log('length validation '+$('#new_document_name').val().length);
				form_validation = false;
				$('#new_document_type').next('span').show();
			} else {
				$('#new_document_type').next('span').hide();
				form_validation = true;
			}

			var insert_document_data = $('#form :input[class=product_document_element]').serialize();

			if (form_validation) {
				$.ajax({
					url: 'index.php?route=catalog/product/insert_product_document&token=<?php echo $token; ?>',
					type: 'POST',
					async: false,
					data: insert_document_data,
					dataType: 'json',
					success: function (response) {
						console.log('insert_product_document response '+response);

						//$('#success_product_document_insert').show();

						window.location.reload(true);

						//var obj = jQuery.parseJSON(response);
					},
					error: function (response) {
						alert('insert_product_document error '+response);
					}
				});
			}

			console.log('length '+$('#new_document_name').val().length);
		});

		$('.get_pr_document_details').on('click', function(){

			var pr_document_id = $(this).attr('id');

			$('.success').hide();

			$('#pr_document_details_'+pr_document_id).show();
			console.log('pr documet_id '+pr_document_id);
		});

		$('.hide_update_document_popup').on('click', function() {

			var pr_document_id = $(this).attr('id');

			$('.success').hide();

			$('#pr_document_details_'+pr_document_id).hide();
		});

		$('.update_document_btn').on('click', function() {

			var pr_document_id = $(this).attr('id');

			if(pr_document_id){

				var update_document_data = $('#form :input[class=product_document_update_'+pr_document_id+']').serialize();

				$.ajax({
					url: 'index.php?route=catalog/product/update_pr_document_details&token=<?php echo $token; ?>',
					type: 'POST',
					async: false,
					data: update_document_data,
					dataType: 'json',
					success: function (response) {
						console.log('update_product_document response '+response);

						$('#success_product_document_update_'+pr_document_id).show();

						//var obj = jQuery.parseJSON(response);
					},
					error: function (response) {
						alert('update_product_document error '+response);
					}
				});
			}
		});

		$('#delete_document').on('click', function() {

			var pr_document_id = $(this).attr('id');

			if(pr_document_id){

				var delete_document_data = $('#form :input[class=delete_document]').serialize();

				$.ajax({
					url: 'index.php?route=catalog/product/delete_pr_document_details&token=<?php echo $token; ?>',
					type: 'POST',
					async: false,
					data: delete_document_data,
					success: function (response) {
						console.log('delete_product_document response '+response);
                        if(response == "delete_success") {
					        window.location.reload(true);
					    }
						//var obj = jQuery.parseJSON(response);
					},
					error: function (response) {
						console.log('delete_product_document error '+response);
					}
				});
			}
		});

	});
	</script>
			
			

<script type="text/javascript"><!--
var uploader = new qq.FileUploader({
    element: document.getElementById('file-uploader'),
    action: 'index.php?route=tool/upload&token=<?php echo $token;?>',
    allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
    onComplete: function(id, fileName, responseJSON){addMultiImage(responseJSON.fileName); },
});
var image_row = <?php echo $image_row; ?>;
function addMultiImage(img) {

            html ='<tbody id="image-row'+ image_row +'">';
              html+='<tr>';
                html+='<td class="left"><div class="image"><img src="<?php echo HTTP_CATALOG."image/"; ?>/'+img+'" alt="" id="thumb' + image_row + '" height=100 />';
                    html+='<input type="hidden" name="product_image[' + image_row + '][image]" value="' + img + '" id="image' + image_row + '" />';
                    html+='<br />';
                    html+='<a onclick="image_upload(\'image' + image_row + '\', \'thumb' + image_row + '\');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;';
                    html+='<a onclick="$(\'#thumb' + image_row + '\').attr(\'src\', \'<?php echo $no_image; ?>\'); $(\'#image' + image_row + '\').attr(\'value\', \'\');"><?php echo $text_clear; ?></a></div></td>';
                    html+='<td class="right"><input type="text" name="product_image[' + image_row + '][sort_order]" value="<?php if (isset($product_image['image'])) { echo $product_image["sort_order"]; } ?>" size="2" /></td>';
                    html += '<td><input type="radio" name="def_img" value="'+img+'"></td>';
                    html+='<td class="left"><a onclick=\'$("#image-row' + image_row + '").remove();\' class="button"><?php echo $button_remove; ?></a></td>';
              html+='</tr>';
              html+='</tbody>';	
	$('#images tfoot').before(html);
	image_row++;
}
//--></script> 
            
<?php echo $footer; ?>