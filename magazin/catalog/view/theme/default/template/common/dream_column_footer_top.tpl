<?php if ($modules) { ?>
<style type="text/css">
br.clear {clear:both;}
#dream_column_footer_top {width:100%;position:relative;overflow:hidden;}
#dream_column_footer_top .row {width:100%;display:block;position:relative;}
#dream_column_footer_top .row .col {display:block;position:relative;float:left;}
</style>
<div id="dream_column_footer_top">
  <?php $i=0; foreach ($modules as $key_i => $row) { ?>
  <div class="row row<?php echo $i; ?>">
  <?php $j=0; foreach ($row as $key_j => $col) { ?>
  <div class="col col<?php echo $j; ?>" style="width:<?php if (count($extra_pos_width[$key_i])==count($row)) echo $extra_pos_width[$key_i][$key_j]; else echo floor(100/count($row)); ?>%">
  <?php foreach ($col as $module) echo $module; ?>
  </div>
  <?php $j++;} ?>
  <br class="clear">
  </div>
  <?php $i++;} ?>
</div>
<?php } ?> 
