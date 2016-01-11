<div class="box">

  <div class="box-heading-leftcat">
    <div class="Title">
      <a id="showMenu" class="whitelink" href="javascript:void(0);"></a>
    </div>
  </div>
  <div class="Content" style="font-family: primeregular;">
    <?php $filterProCounter = 1;?>
    <?php foreach ($categories as $category) { ?>
    <?php $jsForMenu = '';?>
    <?php if ($category['category_id'] == $category_id) { ?>
    <?php $jsForMenu = 'onclick="handleMenuHideing( event );"';?>
            <span style="background-repeat:no-repeat;">
            <a href="<?php echo $category['href']; ?>" <?php echo $jsForMenu;?> class="active" style=" background-image:url(<?php echo $category['image']; ?>)"><?php echo $category['name']; ?></a>
            </span>
    <?php } else { ?>
            <span style="background-repeat:no-repeat;">          
            <a href="<?php echo $category['href']; ?>" style="background-image:url(<?php echo $category['image']; ?>)"><?php echo $category['name']; ?>
            </a>
            </span>
    <?php } ?>
    <!-- BALAZS -->

    <?php if ($category['category_id'] == $category_id) { ?>
    <div class="hideable-menu">
      <?php if( $filterProCounter == 1 && ! empty( $filterProExtra ) && is_array( $filterProExtra )) { ?>
      <?php foreach ($filterProExtra as $module) { ?>
      <?php echo $module; ?>
      <?php } ?>
      <?php $filterProCounter = 0; }?>
    </div>
    <?php } ?>

    <!-- EOF BALAZS -->
    <!-- CU PROBLEME -->
    <?php if ($category['children']) { ?>
    <div id="Filters">
      <div class="FiltersContent">
        <?php foreach ($category['children'] as $child) { ?>
        <span class="FilterTitle">Tip de protectie</span>
        <div id="Tip de protectie">
          <?php if ($child['category_id'] == $child_id) { ?>
          <a href="<?php echo $child['href']; ?>" class="active"> - <?php echo $child['name']; ?></a>
          <?php } else { ?>
          <a href="<?php echo $child['href']; ?>"> - <?php echo $child['name']; ?></a>
          <?php } ?>
        </div>
        <?php } ?>
      </div><div class="colt_2"></div></div>
    <?php } ?>
    <!-- CU PROBLEME -->



    <?php } ?>
  </div>


  <div class="colt_4"></div>
  <div id="Newsletter">
    <div class="BoxTitle">
      <span>Newsletter</span>
      <div class="clear"></div>
      <p>Aboneaza-te si noi iti vom trimite periodic informatii cu privire la ultimele noutati.</p>
    </div>

    <div class="ContentBox" style="position:relative;">
      <span class="ContentBoxI">
          <input type="hidden" name="newsletter" value="1" checked="checked" />        
          <span class="GeneralButton">
          <a class="subscribe" type="button" onclick="document.location.href = 'index.php?route=account/newsletter'">Aboneaza-te</a>
          </span>
      </span>
    </div>

    <div class="colt_3"></div>
  </div>

  <div class="clear"></div>
</div>