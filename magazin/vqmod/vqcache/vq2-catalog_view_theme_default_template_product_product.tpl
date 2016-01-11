<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>

			
				<span xmlns:v="http://rdf.data-vocabulary.org/#">
				<?php foreach ($mbreadcrumbs as $mbreadcrumb) { ?>
				<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php echo $mbreadcrumb['href']; ?>" alt="<?php echo $mbreadcrumb['text']; ?>"></a></span>
				<?php } ?>				
				</span>
			
				<span itemscope itemtype="http://schema.org/Product">
				<meta itemprop="url" content="<?php echo $breadcrumb['href']; ?>" >
				<meta itemprop="name" content="<?php echo $heading_title; ?>" >
				<meta itemprop="model" content="<?php echo $model; ?>" >
				<meta itemprop="manufacturer" content="<?php echo $manufacturer; ?>" >
				
				<?php if ($thumb) { ?>
				<meta itemprop="image" content="<?php echo $thumb; ?>" >
				<?php } ?>
				
				<?php if ($images) { foreach ($images as $image) {?>
				<meta itemprop="image" content="<?php echo $image['thumb']; ?>" >
				<?php } } ?>
				
				<span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
				<meta itemprop="price" content="<?php echo ($special ? $special : $price); ?>" />
				<meta itemprop="priceCurrency" content="<?php echo $this->currency->getCode(); ?>" />
				<link itemprop="availability" href="http://schema.org/<?php echo (($quantity > 0) ? "InStock" : "OutOfStock") ?>" />
				</span>
				
				<span itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
				<meta itemprop="reviewCount" content="<?php echo $review_no; ?>">
				<meta itemprop="ratingValue" content="<?php echo $rating; ?>">
				</span></span>
            
			
  <h1><?php echo $heading_title; ?></h1>
  <div class="product-info">
    <?php if ($thumb || $images) { ?>
        <div class="left">
            <?php if ($thumb) { ?>
                <div class="image"><a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="colorbox"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a></div>
            <?php } ?>
            <?php if ($images) { ?>
              <div class="image-additional">
                <?php foreach ($images as $image) { ?>
                  <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="colorbox"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
                <?php } ?>
              </div>
            <?php } ?>
        </div>
    <?php } ?>
    <div class="right" style="float: right; width: 305px; margin: 0;">
      <div class="description">
        <?php if ($manufacturer) { ?>
            <span><?php echo $text_manufacturer; ?></span> <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a><br />
        <?php } ?>
        <span><?php echo $text_model; ?></span> <?php echo $model; ?><br />
        <?php if ($reward) { ?>
            <span><?php echo $text_reward; ?></span> <?php echo $reward; ?><br />
        <?php } ?>
      </div>
      <?php if ($price) { ?>
          <div class="Price">
             <?php if ( $B2B ) { ?>
             <span class="b2b_stoc" style="display: none; "><?php 

                echo ((isset($option_combo_quantity_box) && $option_combo_quantity_box) || !isset($option_combo_quantity_box)) ? $text_qty : '';

             ?> <?php echo $quantity; ?></span>
             <?php } else { ?>
             <span> <?php  echo $text_stock; ?> <span id="myoc-lpu-stock"><?php echo $stock; ?></span> </span>
             <?php } ?>

            <br />
            <?php echo $text_price; ?>
            

            <?php if (!$special) { ?>
                <span id="myoc-lpu-price"><?php echo $price; ?></span>
            <?php } else { ?>
                <span class="price-old"><span id="myoc-lpu-price"><?php echo $price; ?></span></span> <span class="price-new"><span id="myoc-lpu-special"><?php echo $special; ?></span></span>
            <?php } ?>
            <br />
            <?php if ($tax) { ?>
                <span class="price-tax">INCLUDE TVA</span><br />
            <?php } ?>
            <?php if ($points) { ?>
                <span class="reward"><small><?php echo $text_points; ?> <?php echo $points; ?></small></span><br />
            <?php } ?>
            <?php if ($discounts) { ?>
                <br />
                <div class="discount">
                    <?php foreach ($discounts as $discount) { ?>
                        <?php echo sprintf($text_discount, $discount['quantity'], $discount['price']); ?><br />
                    <?php } ?>
                </div>
            <?php } ?>
          </div>
      <?php } ?>
      <?php if ($profiles): ?>
          <div class="option">
              <h2><span class="required">*</span><?php echo $text_payment_profile ?></h2>
              <br />
              <select name="profile_id">
                  <option value=""><?php echo $text_select; ?></option>
                  <?php foreach ($profiles as $profile): ?>
                  <option value="<?php echo $profile['profile_id'] ?>"><?php echo $profile['name'] ?></option>
                  <?php endforeach; ?>
              </select>
              <br />
              <br />
              <span id="profile-description"></span>
              <br />
              <br />
          </div>
      <?php endif; ?>
      <?php if ($options) { ?>

      <div class="options">
        <h2><?php echo $text_option; ?></h2>


                <?php if(isset($option_combo_description)) { ?>

                    <?php echo $option_combo_description; ?>

                <?php } ?>

            
        <br />
        <?php foreach ($options as $option) { ?>
            

                <?php if (((isset($option_combo_option_view) && $option_combo_option_view) || !isset($option_combo_option_view)) && $option['type'] == 'select') { ?>

            
                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                  <?php if ($option['required']) { ?>
                      <span class="required">*</span>
                  <?php } ?>
                  <b><?php echo $option['name']; ?>:</b><br />
                  <select name="option[<?php echo $option['product_option_id']; ?>]" >
                    <option value=""><?php echo $text_select; ?></option>
                    <?php foreach ($option['option_value'] as $option_value) { ?>
                        <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                        <?php if ($option_value['price']) { ?>
                            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                        <?php } ?>
                        </option>
                    <?php } ?>
                  </select>
                </div>
                <br/>
            <?php } ?>
            

                <?php if (((isset($option_combo_option_view) && $option_combo_option_view) || !isset($option_combo_option_view)) && $option['type'] == 'radio') { ?>

            
                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                  <?php if ($option['required']) { ?>
                      <span class="required">*</span>
                  <?php } ?>
                  <b><?php echo $option['name']; ?>:</b><br />
                  <?php foreach ($option['option_value'] as $option_value) { ?>
                      <div class="option-piece-container">
                          <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
                          <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                              <?php if ($option_value['price']) { ?>
                                  (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                              <?php } ?>
                          </label>                      
                      </div>
                  <?php } ?>
                  <br />
                </div>
                <br />
            <?php } ?>
            

                <?php if (((isset($option_combo_option_view) && $option_combo_option_view) || !isset($option_combo_option_view)) && $option['type'] == 'checkbox') { ?>

            
                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                  <?php if ($option['required']) { ?>
                      <span class="required">*</span>
                  <?php } ?>
                  <b><?php echo $option['name']; ?>:</b><br />
                  <?php foreach ($option['option_value'] as $option_value) { ?>
                      <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
                      <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                          <?php if ($option_value['price']) { ?>
                              (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                          <?php } ?>
                      </label>
                      <br />
                  <?php } ?>
                </div>
                <br />
            <?php } ?>
            <?php if ($option['type'] == 'image') { ?>
                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                  <?php if ($option['required']) { ?>
                      <span class="required">*</span>
                  <?php } ?>
                  <b><?php echo $option['name']; ?>:</b><br />
                  <table class="option-image">
                    <?php foreach ($option['option_value'] as $option_value) { ?>
                        <tr>
                          <td style="width: 1px;"><input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" /></td>
                          <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" /></label></td>
                          <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                              <?php if ($option_value['price']) { ?>
                                  (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                              <?php } ?>
                            </label></td>
                        </tr>
                    <?php } ?>
                  </table>
                </div>
                <br />
            <?php } ?>
            <?php if ($option['type'] == 'text') { ?>
                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                  <?php if ($option['required']) { ?>
                      <span class="required">*</span>
                  <?php } ?>
                  <b><?php echo $option['name']; ?>:</b><br />
                  <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
                </div>
                <br />
            <?php } ?>
            <?php if ($option['type'] == 'textarea') { ?>
                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                    <?php if ($option['required']) { ?>
                      <span class="required">*</span>
                    <?php } ?>
                    <b><?php echo $option['name']; ?>:</b><br />
                    <textarea name="option[<?php echo $option['product_option_id']; ?>]" cols="40" rows="5"><?php echo $option['option_value']; ?></textarea>
                </div>
                <br />
            <?php } ?>
            <?php if ($option['type'] == 'file') { ?>
                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                  <?php if ($option['required']) { ?>
                  <span class="required">*</span>
                  <?php } ?>
                  <b><?php echo $option['name']; ?>:</b><br />
                  <input type="button" value="<?php echo $button_upload; ?>" id="button-option-<?php echo $option['product_option_id']; ?>" class="button">
                  <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" />
                </div>
                <br />
            <?php } ?>
            <?php if ($option['type'] == 'date') { ?>
                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                  <?php if ($option['required']) { ?>
                  <span class="required">*</span>
                  <?php } ?>
                  <b><?php echo $option['name']; ?>:</b><br />
                  <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="date" />
                </div>
                <br />
            <?php } ?>
            <?php if ($option['type'] == 'datetime') { ?>
                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                  <?php if ($option['required']) { ?>
                  <span class="required">*</span>
                  <?php } ?>
                  <b><?php echo $option['name']; ?>:</b><br />
                  <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="datetime" />
                </div>
                <br />
            <?php } ?>
            <?php if ($option['type'] == 'time') { ?>
                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                  <?php if ($option['required']) { ?>
                  <span class="required">*</span>
                  <?php } ?>
                  <b><?php echo $option['name']; ?>:</b><br />
                  <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="time" />
                </div>
                <br />
            <?php } ?>
            <?php } ?>
          <?php if ( $product_size_chart != '' ) {  ?>
          <a rel="elso_group" href="catalog/view/theme/default/image/size_chart/<?php echo $product_size_chart; ?>"><span style="text-decoration: underline"><?php echo $text_see_corresponding_size; ?></span></a>
          <?php } ?>
          </div>


                <?php if(isset($option_combo_table_view) && $option_combo_table_view) { ?>

                <style type="text/css">

                .option-combo {

                    margin: 4px 0 8px;

                    width: 100%;

                    border-collapse: collapse;

                }

                .option-combo tr th,.option-combo tr td {

                    border: 1px solid #ddd;

                    padding: 6px;

                    vertical-align: top;

                }

                .option-combo tr td ul {

                    list-style: none;

                    padding: 0;

                    margin: 0;

                }

                .option-combo tr td ul li {

                    padding: 2px 0;

                }

                .option-combo tr td.ta-center, .option-combo tr th {

                    text-align: center;

                }

                .option-combo tr td.ta-right {

                    text-align: right;

                }

                </style>

                <?php if($option_combo_table_split) { ?>

                <?php foreach($table_split_option_combos as $option_vid => $data) { ?>

                    <?php foreach($product_option_combo_headers as $header_option_id => $header) { ?>

                        <?php if($header['option_id'] == $option_combo_table_split) { ?>

                        <strong><?php echo $header['name'] . ': ' . $table_split_options[$option_vid]; ?></strong>

                        <?php } ?>

                    <?php } ?>

                    <table class="option-combo">

                        <tr>

                        <?php if($option_combo_col_select_view) { ?>

                        <th></th>

                        <?php } ?>

                        <?php foreach($product_option_combo_headers as $header) { ?>

                            <?php if($header['option_id'] != $option_combo_table_split) { ?>

                            <th><?php echo $header['name']; ?></th>

                            <?php } ?>

                        <?php } ?>

                        <?php if($option_combo_col_quantity_view) { ?>

                        <th><?php echo $text_col_quantity; ?></th>

                        <?php } ?>

                        <?php if($option_combo_col_points_view) { ?>

                        <th><?php echo $text_col_points; ?></th>

                        <?php } ?>

                        <?php if($option_combo_col_total_points_view) { ?>

                        <th><?php echo $text_col_total_points; ?></th>

                        <?php } ?>

                        <?php if($option_combo_col_price_view) { ?>

                        <th><?php echo $text_col_price; ?></th>

                        <?php } ?>

                        <?php if($option_combo_col_total_price_view) { ?>

                        <th><?php echo $text_col_total_price; ?></th>

                        <?php } ?>

                        </tr>

                        <?php foreach($data as $product_option_combo) { ?>

                        <tr>

                            <?php if($option_combo_col_select_view) { ?>

                            <td><input type="radio" value="<?php echo $product_option_combo['product_option_combination_id']; ?>" name="option_combo" /></td>

                            <?php } ?>

                            <?php foreach($product_option_combo_headers as $header) { ?>

                                <?php if($header['option_id'] != $option_combo_table_split && isset($product_option_combo['option_values'][$header['option_id']])) { ?>

                                <td>

                                <?php if(count($product_option_combo['option_values'][$header['option_id']]) > 1) { ?>

                                    <ul>

                                    <?php foreach($product_option_combo['option_values'][$header['option_id']] as $val) { ?>

                                    <li><?php echo $val; ?></li>

                                    <?php } ?>

                                    </ul>

                                <?php } else { ?>

                                    <?php foreach($product_option_combo['option_values'][$header['option_id']] as $val) { ?>

                                    <?php echo $val; ?>

                                    <?php } ?>

                                <?php } ?>

                                </td>

                            <?php } else if($header['option_id'] != $option_combo_table_split) { ?>

                                <td>-</td>

                            <?php } ?>

                        <?php } ?>

                        <?php if($option_combo_col_quantity_view) { ?>

                            <td class="ta-center"><?php echo $product_option_combo['quantity']; ?></td>

                        <?php } ?>

                        <?php if($option_combo_col_points_view) { ?>

                            <td class="ta-right"><?php echo $product_option_combo['points']; ?></td>

                        <?php } ?>

                        <?php if($option_combo_col_total_points_view) { ?>

                            <td class="ta-right"><?php echo $product_option_combo['total_points']; ?></td>

                        <?php } ?>

                        <?php if($option_combo_col_price_view) { ?>

                            <td class="ta-right">

                                <?php echo $product_option_combo['price']; ?>

                                <?php if ($option_combo_extax_view) { ?>

                                <br /><span class="price-tax"><?php echo $text_tax; ?> <?php echo $product_option_combo['extax']; ?></span>

                                <?php } ?>

                            </td>

                        <?php } ?>

                        <?php if($option_combo_col_total_price_view) { ?>

                            <td class="ta-right">

                                <?php echo $product_option_combo['total_price']; ?>

                                <?php if ($option_combo_extax_view) { ?>

                                <br /><span class="price-tax"><?php echo $text_tax; ?> <?php echo $product_option_combo['total_extax']; ?></span>

                                <?php } ?>

                            </td>

                        <?php } ?>

                        </tr>

                        <?php } ?>

                    </table>

                    <br />

                <?php } ?>

                <?php } else { ?>

                <?php if(isset($product_option_combos)) { ?>

                <table class="option-combo">

                    <tr>

                    <?php if($option_combo_col_select_view) { ?>

                    <th></th>

                    <?php } ?>

                    <?php foreach($product_option_combo_headers as $header) { ?>

                        <th><?php echo $header['name']; ?></th>

                    <?php } ?>

                    <?php if($option_combo_col_quantity_view) { ?>

                    <th><?php echo $text_col_quantity; ?></th>

                    <?php } ?>

                    <?php if($option_combo_col_points_view) { ?>

                    <th><?php echo $text_col_points; ?></th>

                    <?php } ?>

                    <?php if($option_combo_col_total_points_view) { ?>

                    <th><?php echo $text_col_total_points; ?></th>

                    <?php } ?>

                    <?php if($option_combo_col_price_view) { ?>

                    <th><?php echo $text_col_price; ?></th>

                    <?php } ?>

                    <?php if($option_combo_col_total_price_view) { ?>

                    <th><?php echo $text_col_total_price; ?></th>

                    <?php } ?>

                    </tr>

                    <?php foreach($product_option_combos as $product_option_combo) { ?>

                    <tr>

                        <?php if($option_combo_col_select_view) { ?>

                        <td><input type="radio" value="<?php echo $product_option_combo['product_option_combination_id']; ?>" name="option_combo" /></td>

                        <?php } ?>

                        <?php foreach($product_option_combo_headers as $header) { ?>

                            <?php if(isset($product_option_combo['option_values'][$header['option_id']])) { ?>

                                <td>

                                <?php if(count($product_option_combo['option_values'][$header['option_id']]) > 1) { ?>

                                    <ul>

                                    <?php foreach($product_option_combo['option_values'][$header['option_id']] as $val) { ?>

                                    <li><?php echo $val; ?></li>

                                    <?php } ?>

                                    </ul>

                                <?php } else { ?>

                                    <?php foreach($product_option_combo['option_values'][$header['option_id']] as $val) { ?>

                                    <?php echo $val; ?>

                                    <?php } ?>

                                <?php } ?>

                                </td>

                            <?php } else { ?>

                                <td>-</td>

                            <?php } ?>

                        <?php } ?>

                    <?php if($option_combo_col_quantity_view) { ?>

                        <td class="ta-center"><?php echo $product_option_combo['quantity']; ?></td>

                    <?php } ?>

                    <?php if($option_combo_col_points_view) { ?>

                        <td class="ta-right"><?php echo $product_option_combo['points']; ?></td>

                    <?php } ?>

                    <?php if($option_combo_col_total_points_view) { ?>

                        <td class="ta-right"><?php echo $product_option_combo['total_points']; ?></td>

                    <?php } ?>

                    <?php if($option_combo_col_price_view) { ?>

                        <td class="ta-right">

                            <?php echo $product_option_combo['price']; ?>

                            <?php if ($option_combo_extax_view) { ?>

                            <br /><span class="price-tax"><?php echo $text_tax; ?> <?php echo $product_option_combo['extax']; ?></span>

                            <?php } ?>

                        </td>

                    <?php } ?>

                    <?php if($option_combo_col_total_price_view) { ?>

                        <td class="ta-right">

                            <?php echo $product_option_combo['total_price']; ?>

                            <?php if ($option_combo_extax_view) { ?>

                            <br /><span class="price-tax"><?php echo $text_tax; ?> <?php echo $product_option_combo['total_extax']; ?></span>

                            <?php } ?>

                        </td>

                    <?php } ?>

                    </tr>

                    <?php } ?>

                </table>

                <?php if($option_combo_col_select_view) { ?><div class="option-combo-warning"></div><?php } ?>

                <?php } ?>

                <?php } ?>

                <?php } ?>

            
      <?php } ?>

      <div class="cart">
        <div>
          <?php /* BALAZS: majus 1 vissza csinalni ezt a reszt */ ?>
          <?php /* if ($this->customer->isLogged()) { */ ?>
              <?php if (! empty( $price )  ) {  /* && (float)$price != 0 */  ?>
                      <br>
                      <br>  
                      <?php 

                echo ((isset($option_combo_quantity_box) && $option_combo_quantity_box) || !isset($option_combo_quantity_box)) ? $text_qty : '';

             ?>         
                      

			    <input type="<?php if(isset($option_combo_quantity_box) && !$option_combo_quantity_box) { ?>hidden"<?php } else { ?>text<?php } ?>" name="quantity" size="2" value="<?php echo $minimum; ?>" />

            
                      <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
                      &nbsp;
                      <input type="button" value="<?php echo $button_cart; ?>" id="button-cart" class="button"/>
                      <span>&nbsp;&nbsp;<?php echo $text_or; ?>&nbsp;&nbsp;</span><a onclick="addToCompare('<?php echo $product_id; ?>');"><?php echo $button_compare; ?></a>
              <?php } else { ?>
                  <a href="/contact">
                    <input type="button" value="<?php echo $button_get_info; ?>" id="button-get-info" class="button" />
                  </a>
              <?php } ?>          
          <?php /* } else { */?>
              <!--div>
                <br>
                <br>
                <a href="/contact">
                  <input type="button" value="<?php echo $button_get_info; ?>" id="button-get-info" class="button" />
                </a>
              </div>
              <?php /* echo $error_cart_content; */ ?>
              <br -->
          <?php /* } */?>
          <br /><br />
          <div style="width: 230px;">
              <?php if(!strpos($_SERVER['SERVER_NAME'],'akata')) { ?>
              <div>
             <span class="product_info_text"><?php echo $text_free_delivery; ?></span>
             <span class="product_info_icon"><img src="catalog/view/theme/default/image/transport.png" title="<?php echo $text_free_delivery; ?>" alt="<?php echo $text_free_delivery; ?>" /></span>
             </div>
              <?php } ?>
             <div>
             <span class="product_info_text"><?php echo $text_return_guarantee; ?></span>
             <span class="product_info_icon"> <img src="catalog/view/theme/default/image/10 zile.png" alt="<?php echo $text_return_guarantee; ?>" title="<?php echo $text_return_guarantee; ?>" /></span>
             </div>
             <span id="delivery"></span><br />
             <span id="notify_when_appears"></span><br />
             <div id="notify_message"></div>
               
          </div>
<!--            <span class="links"><a onclick="addToWishList('<?php echo $product_id; ?>');"><?php echo $button_wishlist; ?></a><br />-->
<!--            </span>-->
        </div>
        <?php if ($minimum > 1) { ?>
        <div class="minimum"><?php echo $text_minimum; ?></div>
        <?php } ?>
      </div>
      <?php if ($review_status) { ?>
      <div class="review">
        <div><img src="catalog/view/theme/default/image/stars-<?php echo $rating; ?>.png" alt="<?php echo $reviews; ?>" />&nbsp;&nbsp;<a onclick="$('a[href=\'#tab-review\']').trigger('click');"><?php echo $reviews; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('a[href=\'#tab-review\']').trigger('click');"><?php echo $text_write; ?></a></div>
        <div class="share"><!-- AddThis Button BEGIN -->
          <div class="addthis_default_style"><a class="addthis_button_compact"><?php echo $text_share; ?></a> <a class="addthis_button_email"></a><a class="addthis_button_print"></a> <a class="addthis_button_facebook"></a> <a class="addthis_button_twitter"></a>
          </div>
<!-- Place this tag where you want the +1 button to render. -->
<div class="g-plusone" data-annotation="inline" data-width="200"></div>
<!-- Place this tag after the last +1 button tag. -->
<script type="text/javascript">
  window.___gcfg = {lang: 'ro'};
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/platform.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
          <script type="text/javascript" src="//s7.addthis.com/js/250/addthis_widget.js"></script> 
          <!-- AddThis Button END --> 
 
 
        
      </div>
      <?php } ?>
    </div>
  </div>
  <div id="tabs" class="htabs"><a href="#tab-description"><?php echo $tab_description; ?></a>
<!--    <?php if ($attribute_groups) { ?>
    <a href="#tab-attribute"><?php echo $tab_attribute; ?></a>
    <?php } ?>-->
    <?php if ($review_status) { ?>
    <a href="#tab-review"><?php echo $tab_review; ?></a>
    <?php } ?>
    <?php if ($products) { ?>
    <a href="#tab-related"><?php echo $tab_related; ?> (<?php echo count($products); ?>)</a>
    <?php } ?>
    <?php if ($products_complementary) { ?>
      <a href="#tab-complementary"><?php echo $tab_complementary; ?> (<?php echo count($products_complementary); ?>)</a>
      <?php } ?>

				
			<?php if(is_array($product_doc)) { ?>
			<a href="#tab-download" style="display: inline;" class="selected">Download</a>
			<?php } ?>
		
			
  </div>

			
			<?php if(is_array($product_doc)) { ?>
			<div id="tab-download" class="tab-content">
				<div class="download_description">
					<span><?php //echo '<pre>'; print_r($product_doc); ?></span>
					<table>
						<thead>
							<tr>
								<td>Nume document</td>
								<td>Tip document</td>
								<td>Descriere document</td>
								<td>Descarcare</td>
							</tr>
						</thead>
						<tbody>
							<?foreach ($product_doc as $doc) { ?>
							<tr>
								<td><?= $doc['name'] ?></td>
								<td><?= $doc['type'] ?></td>
								<td><?= $doc['description'] ?></td>
								<td>
									<a class="button" href="<?php echo $doc['href']; ?>">Descarcare</a><br>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<?php /*echo "<pre>"; print_r($product_doc);*/ } ?>
			
			
  <div id="tab-description" class="tab-content"><?php echo $description; ?>
    <br /><br />
    <?php if ($attribute_groups) { ?>
  
    <table class="attribute">
      <?php foreach ($attribute_groups as $attribute_group) { ?>
      <thead>
        <tr>
          <td><?php echo $attribute_group['name']; ?></td>
            <td><?php echo $attribute_group['attribute'][0]['name']; ?></td>
        </tr>
      </thead>
     <!-- <tbody>
        <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
        <tr>
          <td><?php echo $attribute['name']; ?></td>
          <td><?php echo $attribute['text']; ?></td>
        </tr>
        <?php } ?>
      </tbody> -->
      <?php } ?>
    </table>
  <?php } ?>
  </div>
<!--  <?php if ($attribute_groups) { ?>
  <div id="tab-attribute" class="tab-content">
    <table class="attribute">
      <?php foreach ($attribute_groups as $attribute_group) { ?>
      <thead>
        <tr>
          <td colspan="2"><?php echo $attribute_group['name']; ?></td>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
        <tr>
          <td><?php echo $attribute['name']; ?></td>
          <td><?php echo $attribute['text']; ?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php } ?>
    </table>
  </div>
  <?php } ?>-->
  <?php if ($review_status) { ?>
  <div id="tab-review" class="tab-content">
    <div id="review"></div>
    <h2 id="review-title"><?php echo $text_write; ?></h2>
    <b><?php echo $entry_name; ?></b><br />
    <input type="text" name="name" value="" />
    <br />
    <br />
    <b><?php echo $entry_review; ?></b>
    <textarea name="text" cols="40" rows="8" style="width: 98%;"></textarea>
    <span style="font-size: 11px;"><?php echo $text_note; ?></span><br />
    <br />
    <b><?php echo $entry_rating; ?></b> <span><?php echo $entry_bad; ?></span>&nbsp;
    <input type="radio" name="rating" value="1" />
    &nbsp;
    <input type="radio" name="rating" value="2" />
    &nbsp;
    <input type="radio" name="rating" value="3" />
    &nbsp;
    <input type="radio" name="rating" value="4" />
    &nbsp;
    <input type="radio" name="rating" value="5" />
    &nbsp;<span><?php echo $entry_good; ?></span><br />
    <br />
    <b><?php echo $entry_captcha; ?></b><br />
    <input type="text" name="captcha" value="" />
    <br />
    <img src="index.php?route=product/product/captcha" alt="" id="captcha" /><br />
    <br />
    <div class="buttons">
      <div class="right"><a id="button-review" class="button"><?php echo $button_continue; ?></a></div>
    </div>
  </div>
  <?php } ?>
  <?php if ($products) { ?>
  <div id="tab-related" class="tab-content">
    <div class="box-product">
      <?php foreach ($products as $product) { ?>
      <div>
        <?php if ($product['thumb']) { ?>
        <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
        <?php } ?>
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
        <?php if ($product['price'] && ( $this->customer->getCustomerGroupId() != 3 || !$this->customer->getCustomerGroupId() != 4 ) ) { ?>
                
        
        <div class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']." (".$text_withouth_vat." ".")"; ?>
          <?php } else { ?>
          <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
          <?php } ?>
        </div>
        
        
        
        <?php } else { ?>
        <div class="price">
           <?php echo $button_view_product; ?>
        </div>
        <?php } ?>
        
        <?php if ($product['rating']) { ?>
        <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
        <?php } ?>
        
        <?php if ( $this->customer->getCustomerGroupId() != 3 || $this->customer->getCustomerGroupId() != 4 ) { ?>
        <a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button"><?php echo $button_cart; ?></a>
        <?php } ?>
        </div>
      
      <?php } ?>
    </div>
  </div>
  <?php } ?>

  <?php if ($products_complementary) { ?>
    <div id="tab-complementary" class="tab-content">
        <div class="box-product">
            <?php foreach ($products_complementary as $product) { ?>
            <div>
                <?php if ($product['thumb']) { ?>
                <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
                <?php } ?>
                <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                <?php if ($product['price'] && ( $this->customer->getCustomerGroupId() != 3 || !$this->customer->getCustomerGroupId() != 4 ) ) { ?>


                <div class="price">
                    <?php if (!$product['special']) { ?>
                    <?php echo $product['price']." (".$text_withouth_vat." ".")"; ?>
                    <?php } else { ?>
                    <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
                    <?php } ?>
                </div>

                <?php } else { ?>
                <div class="price">
                    <?php echo $button_view_product; ?>
                </div>
                <?php } ?>

                <?php if ($product['rating']) { ?>
                <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
                <?php } ?>

                <?php if ( $this->customer->getCustomerGroupId() != 3 || $this->customer->getCustomerGroupId() != 4 ) { ?>
                <a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button"><?php echo $button_cart; ?></a>
                <?php } ?>
            </div>

            <?php } ?>
        </div>
    </div>
  <?php } ?>

  <?php if ($tags) { ?>
      <div class="tags"><b><?php echo $text_tags; ?></b>
        <?php for ($i = 0; $i < count($tags); $i++) { ?>
            <?php if ($i < (count($tags) - 1)) { ?>
                <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
            <?php } else { ?>
                <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
            <?php } ?>
        <?php } ?>
      </div>
  <?php } ?>
  <?php echo $content_bottom; ?></div>
<!-- </div> -->
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.colorbox').colorbox({
		overlayClose: true,
		opacity: 0.5,
		rel: "colorbox"
	});
});
//--></script> 
<script type="text/javascript"><!--

$('select[name="profile_id"], input[name="quantity"]').change(function(){
    $.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name="product_id"], input[name="quantity"], select[name="profile_id"]'),
		dataType: 'json',
        beforeSend: function() {
            $('#profile-description').html('');
        },
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
            
			if (json['success']) {
                $('#profile-description').html(json['success']);
			}	
		}
	});
});
    
$('#button-cart').bind('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
			
			if (json['error']) {
				if (json['error']['option']) {


                if(!jQuery.isEmptyObject(json['error']))

                {

                     $('.option-combo-warning').html('<span class="error"><?php echo $error_option_combo; ?></span>');

                }

            
					for (i in json['error']['option']) {
						$('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
					}
				}
                
                if (json['error']['profile']) {
                    $('select[name="profile_id"]').after('<span class="error">' + json['error']['profile'] + '</span>');
                }
			} 
			
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
					
				$('.success').fadeIn('slow');
					
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
});
//--></script>
<?php if ($options) { ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/ajaxupload.js"></script>
<?php foreach ($options as $option) { ?>
<?php if ($option['type'] == 'file') { ?>
<script type="text/javascript"><!--
new AjaxUpload('#button-option-<?php echo $option['product_option_id']; ?>', {
	action: 'index.php?route=product/product/upload',
	name: 'file',
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').after('<img src="catalog/view/theme/default/image/loading.gif" class="loading" style="padding-left: 5px;" />');
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', true);
	},
	onComplete: function(file, json) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', false);
		
		$('.error').remove();
		
		if (json['success']) {
			alert(json['success']);
			
			$('input[name=\'option[<?php echo $option['product_option_id']; ?>]\']').attr('value', json['file']);
		}
		
		if (json['error']) {
			$('#option-<?php echo $option['product_option_id']; ?>').after('<span class="error">' + json['error'] + '</span>');
		}
		
		$('.loading').remove();	
	}
});
//--></script>
<?php } ?>
<?php } ?>
<?php } ?>
<script type="text/javascript"><!--
$('#review .pagination a').live('click', function() {
	$('#review').fadeOut('slow');
		
	$('#review').load(this.href);
	
	$('#review').fadeIn('slow');
	
	return false;
});			

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').bind('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-review').attr('disabled', true);
			$('#review-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-review').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(data) {
			if (data['error']) {
				$('#review-title').after('<div class="warning">' + data['error'] + '</div>');
			}
			
			if (data['success']) {
				$('#review-title').after('<div class="success">' + data['success'] + '</div>');
								
				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').attr('checked', '');
				$('input[name=\'captcha\']').val('');
			}
		}
	});
});
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script> 
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {

//   $(".b2b_stoc").hide();

	if ($.browser.msie && $.browser.version == 6) {
		$('.date, .datetime, .time').bgIframe();
	}

	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
	$('.datetime').datetimepicker({
		dateFormat: 'yy-mm-dd',
		timeFormat: 'h:m'
	});
	$('.time').timepicker({timeFormat: 'h:m'});
});
//--></script> 
<script type="text/javascript"><!--
         
				function myocLivePriceUpdate(parameter) {
					var _url = 'index.php?route=myoc/live_price_update';
               
					$.ajax({
						type: 'post',
						url: _url,
						dataType: 'json',
						data: $('select[name="profile_id"], input[name^="option"][type="checkbox"]:checked, input[name^="option"][type="radio"]:checked, select[name^="option"], input[type="hidden"], input[name="quantity"][type="radio"]:checked, select[name="quantity"] '),
						/* data: $('select[name="profile_id"], input[name^="option"][type="checkbox"]:checked, input[name^="option"][type="radio"]:checked, select[name^="option"], input[type="hidden"], input[name="quantity"][type="text"], input[name="quantity"][type="radio"]:checked, select[name="quantity"]'), */

						success: function (myocData) {			
                  
							<?php if (!$this->config->get('config_customer_price') || ($this->config->get('config_customer_price') && $this->customer->isLogged())) { ?>
							$('#myoc-lpu-price').fadeOut(110).queue(function(nx) {
								$(this).html(myocData.price);
								nx();
							}).fadeIn(90);
							$('#myoc-lpu-special').fadeOut(100).delay(10).queue(function(nx) {
								$(this).html(myocData.special);
								nx();
							}).fadeIn(90);
							$('#myoc-lpu-extax').fadeOut(90).delay(20).queue(function(nx) {
								$(this).html(myocData.extax);
								nx();
							}).fadeIn(90);
              $('#myoc-lpu-stock').fadeOut(90).delay(20).queue(function(nx) {
								$(this).html(myocData.stock);
								nx();
							}).fadeIn(90);
               
 
              $('#button-cart').fadeOut(90).delay(20).queue(function(nx) {
                                         
                     if ( myocData.customer_group_id == 3 || myocData.customer_group_id == 4) // B2B client
                     {
                           if ( myocData.have_b2b_price != 0  )  //&& myocData.b2b_product_stoc != 0
                           {
                              $(this).attr( "style", "" );
                              $(this).removeAttr( "disabled" );
                           }
                           else
                           {
                              //$(this).attr( "style", "color:#BBBBBB; background: #999999;" );
                              //$(this).attr( "disabled", "disabled" );
                           }
                     }
                     else
                     {
                     //console.log( myocData.text_please_select_desired_options );
                     //console.log( myocData.stock );
                     //console.log( myocData.text_no_stock );

                          if ( parameter == 1 && myocData.product_optionNr != 0 )
                          {
                                $('#myoc-lpu-stock').html(myocData.text_please_select_desired_options);
                          }

                           if ( myocData.stock != myocData.text_no_stock) // ( myocData.stock*1 != 0 )
                           {
                              $(this).attr( "style", "" );
                              $(this).removeAttr( "disabled" );
                              $(this).attr( "value", myocData.text_add_to_cart );
                              
                              $("#delivery").html( '<div><span class="product_info_text">' + myocData.text_delivery + '</span><span class="product_info_icon"> <img src="catalog/view/theme/default/image/2 zile.png" alt="' + myocData.text_delivery + '" title="' + myocData.text_delivery + '" /></span></div>');
                            }
                           else
                           {
                              //$(this).attr( "style", "color:#BBBBBB; background: #999999;" );
                              //$(this).attr( "disabled", "disabled" );

                              if ( parameter == 1 )
                              {
                                  $(this).attr( "value", myocData.text_add_to_cart );
                              }
                              else
                              {
                                  $(this).attr( "value", myocData.text_out_of_stock );
                                  $("#delivery").html( '');
                               }
                           }                           
                     }
              
								nx();
							}).fadeIn(90);
                     
                  if (myocData.customer_group_id == 3 || myocData.customer_group_id == 4 )
                     {                              
                        if( parameter != 1 || myocData.product_optionNr == 0 )
                        {
                           $(".b2b_stoc").show();                  
                           $(".b2b_stoc").html(myocData.text_qty +' ' + myocData.b2b_product_stoc);
                                                      
                           if ( myocData.b2b_product_stoc != 0 )
                           {
                              $("#delivery").html( '<div><span class="product_info_text">' + myocData.text_delivery + '</span><span class="product_info_icon"> <img src="catalog/view/theme/default/image/2 zile.png" alt="' + myocData.text_delivery + '" title="' + myocData.text_delivery + '" /></span></div>');
                              $("#notify_when_appears").html( '' );
                           }
                           else
                           {
                              $("#delivery").html( '');
                              $("#notify_when_appears").html( '<div> <input type="button" value="Anunta-ma cand apare" id="notify_me" class="button" /></div>');
                           }
                        } 
                     }
                     else // regular customer
                     {                     
                        if ( myocData.stock != myocData.text_no_stock) // ( myocData.stock*1 != 0 )  
                        {
                           $("#notify_when_appears").html( '' );
                        }
                        else
                        {                                    
                           if ( parameter !=1 || myocData.product_optionNr == 0)
                           {
                              $("#notify_when_appears").html( '<div> <input type="button" value="Anunta-ma cand apare" id="notify_me" class="button" /></div>');
                           }
                        }     
                     }
                                          
							<?php } ?>
						},
						error: function(xhr, ajaxOptions, thrownError) {
							console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});               
               
				}
            
            $('#notify_me').live('click',function(e){
               e.preventDefault();

                  var id =  $(this).attr("id");
                  $( '#notify_message' ).html('');
                  $( '#notify_message' ).show();
                                    
                  $.ajax({ 
                     type: 'post',
                     url: 'index.php?route=myoc/notify_me',
                     dataType: 'json',
                     data: $('select[name="profile_id"], input[name^="option"][type="checkbox"]:checked, input[name^="option"][type="radio"]:checked, select[name^="option"], input[type="hidden"], input[name="quantity"][type="radio"]:checked, select[name="quantity"] '),
                     success: function (response) {		
                     
                        $( '#notify_message' ).removeClass( 'success' );
                        $( '#notify_message' ).removeClass( 'warning' );
                        if( response.status == 'ok' )
                           {
                              $( '#notify_message' ).html( response.msg );
                              $( '#notify_message' ).addClass( 'success' );
                           }
                           else
                           {
                              $( '#notify_message' ).html( response.msg );
                              $( '#notify_message' ).addClass( 'warning' );
                           }

                           setTimeout(function(){
                              $( '#notify_message' ).fadeOut( 1000 );
                           },2000);

                     },
                     error: function(xhr, ajaxOptions, thrownError) {
                        console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                     }
                  
                  });
         });

         $(document).ready(function() {

            myocLivePriceUpdate(1);

            $('select[name="profile_id"],:input[name^="option"]').change(myocLivePriceUpdate);
            var _qty = $(':input[name^="quantity"]').val();
            $(':input[name^="quantity"]').bind('change keyup', function() {
               if($(this).val() != _qty) {
                  myocLivePriceUpdate();
                  _qty = $(this).val();

               }
            });

         });
            	//--></script>
<?php echo $footer; ?>