    <?php foreach ($products as $product) { ?>
    <div>
      <?php if ($product['thumb']) { ?>
      <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
      <?php } else { ?>
      <div class="image"><a href="<?php echo $product['href']; ?>"><img src="catalog/view/theme/default/image/nophoto.png" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>      
      <?php } ?>
      <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
      <div class="description"><?php echo $product['description']; ?></div>
      <?php if ($product['price'] /*&& !( $this->customer->getCustomerGroupId() == 3 || $this->customer->getCustomerGroupId() == 4 )*/) { ?>
      <div class="price">
        <?php if (!$product['special']) { ?>
            <?php if( (float) $product['price'] != 0 ) { ?>
                <?php echo $text_price_from . " " . $product['price']; ?>
            <?php } else { ?>
                <?php echo $text_price_ask; ?>
            <?php } ?>
        <?php } else { ?>
        <span class="price-old"><?php echo $text_price_from . " " . $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
        <?php } ?>
        <?php if ($product['tax']) { ?>
        <br />
        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
        <?php } ?>
      </div>
      <?php } ?>
      <?php if ($product['rating']) { ?>
      <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
      <?php } ?>
      <div class="cart">
        <?php if ($this->customer->isLogged()) { ?>
            <?php ;/* onclick="addToCart('<php echo $product['product_id']; >');" */ ?>
            <input type="button" value="<?php echo $button_view_product;/* $button_cart; */ ?>" onclick="window.location.href ='<?php echo $product['href']; ?>';" class="button" />
        <?php } else { ?>
            <input type="button" value="<?php echo $button_view_product; ?>" onclick="window.location.href ='<?php echo $product['href']; ?>';" class="button" />
        <?php } ?>
      </div>
<!--      <div class="wishlist"><a onclick="addToWishList('<?php echo $product['product_id']; ?>');"><?php echo $button_wishlist; ?></a></div>-->
      <div class="compare"><a onclick="addToCompare('<?php echo $product['product_id']; ?>');"><?php echo $button_compare; ?></a></div>
    </div>
    <?php } ?>