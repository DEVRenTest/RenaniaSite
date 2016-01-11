<?php if ($testmode) { ?>
<div class="warning"><?php echo $text_testmode; ?></div>
<?php } ?>
<form id="PaymentForm" name="PaymentForm" method="post" action="<?php echo $action; ?>">    
    <input type="hidden" name="AMOUNT" value="<?php echo $amount; ?>" />
    <input type="hidden" name="CURRENCY" value="<?php echo $currency; ?>" />
    <input type="hidden" name="ORDER" value="<?php echo $order; ?>" />
    <input type="hidden" name="DESC" value="<?php echo $desc; ?>" />
    <input type="hidden" name="TERMINAL" value="<?php echo $terminal; ?>" />
    <input type="hidden" name="TIMESTAMP" value="<?php echo $timestamp; ?>" />
    <input type="hidden" name="NONCE" value="<?php echo $nonce; ?>" />
    <input type="hidden" name="BACKREF" value="<?php echo $backhref; ?>" />		
	<input type="hidden" name="DATA_CUSTOM" value="<?php echo $data_custom; ?>" />	
    <input type="hidden" name="STRING" value="<?php echo $str_p_sign; ?>" />		
    <input type="hidden" name="P_SIGN" value="<?php echo $p_sign; ?>" />
    <div class="buttons">
        <div class="right">
          <input type="submit" value="<?php echo $button_confirm; ?>" class="button" />
        </div>
    </div>
</form>
