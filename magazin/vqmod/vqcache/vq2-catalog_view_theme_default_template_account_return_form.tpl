<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <?php echo $text_description; ?>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <h2><?php echo $text_order; ?></h2>
    <div class="content">
      <div class="left"><span class="required">*</span> <?php echo $entry_firstname; ?><br />
        <input type="text" name="firstname" value="<?php echo $firstname; ?>" class="large-field" />
        <br />
        <?php if ($error_firstname) { ?>
        <span class="error"><?php echo $error_firstname; ?></span>
        <?php } ?>
        <br />
        <span class="required">*</span> <?php echo $entry_lastname; ?><br />
        <input type="text" name="lastname" value="<?php echo $lastname; ?>" class="large-field" />
        <br />
        <?php if ($error_lastname) { ?>
        <span class="error"><?php echo $error_lastname; ?></span>
        <?php } ?>
        <br />
        <span class="required">*</span> <?php echo $entry_email; ?><br />
        <input type="text" name="email" value="<?php echo $email; ?>" class="large-field" />
        <br />
        <?php if ($error_email) { ?>
        <span class="error"><?php echo $error_email; ?></span>
        <?php } ?>
        <br />
        <span class="required">*</span> <?php echo $entry_telephone; ?><br />
        <input type="text" name="telephone" value="<?php echo $telephone; ?>" class="large-field" />
        <br />
        <?php if ($error_telephone) { ?>
        <span class="error"><?php echo $error_telephone; ?></span>
        <?php } ?>
        <br />

    <?php if(!$this->customer->isLogged()) { ?>
        <?php echo $text_company_name; ?><br />
        <input type="text" name="company_name" value="<?php if(isset($company_name)) echo $company_name; ?>" class="large-field" />
        <br />
        <?php if (isset($error_text_company_name)) { ?>
        <span class="error"><?php echo $error_text_company_name; ?></span>
        <?php } ?>
        <br />
    <?php } ?>
        <span class="required">*</span> <?php echo $text_location; ?><br />
        <input type="text" name="location" value="<?php if(isset($location)) echo $location; ?>" class="large-field" />
        <br />
        <?php if (isset($error_text_location)) { ?>
        <span class="error"><?php echo $error_text_location; ?></span>
        <?php } ?>
        <br />
      </div>
      <div class="right">
        <?php if(!$this->customer->isLogged()) { ?>
        <?php echo $text_tax_id; ?><br />
        <input type="text" name="tax_id" value="<?php if(isset($tax_id)) echo $tax_id; ?>" class="large-field" />
        <br />
        <?php if (isset($error_tax_id)) { ?>
        <span class="error"><?php echo $error_text_tax_id; ?></span>
        <?php } ?>
        <br />
        <?php } ?>
        <span class="required">*</span> <?php echo $entry_order_id; ?><br />
        <input type="text" name="order_id" value="<?php echo $order_id; ?>" class="large-field" />
        <br />
        <?php if ($error_order_id) { ?>
        <span class="error"><?php echo $error_order_id; ?></span>
        <?php } ?>
        <br />
        <?php echo $entry_date_ordered; ?><br />
        <input type="text" name="date_ordered" value="<?php echo $date_ordered; ?>" class="large-field date" />
        <br />

                <br />
                <?php echo $text_invoice_nr; ?><br />
                <input type="text" name="invoice_nr" value="<?php if(isset($invoice_nr)){ echo $invoice_nr; } ?>" class="large-field invoice_nr" />
                <br />
                <br />
                <?php echo $text_date_invoice; ?><br />
                <input type="text" name="date_invoice" value="<?php if(isset($date_invoice)){ echo $date_invoice; } ?>" class="large-field date" />
                <br />
            
      </div>
    </div>
    <h2><?php echo $text_product; ?></h2>
    
    <?php for ($i = 0; $i < sizeof($products); $i++) { ?>
    <div class="return-product" line="<?php echo $i; ?>">
        <div class="content">
                <div class="return-model"><b><?php echo $entry_model; ?></b><br />
                    <input type="text" name="products[<?php echo $i; ?>][model]" value="<?php echo $products[$i]['model']; ?>" />
                    <br />
                    <?php if (isset($products[$i]['error_model'])) { ?>
                    <span class="error"><?php echo $products[$i]['error_model']; ?></span>
                    <?php } ?>
                </div>
                <div class="return-color"><b><?php echo $entry_color; ?></b><br />
                    <input type="text" name="products[<?php echo $i; ?>][color]" value="<?php echo $products[$i]['color']; ?>" />
                    <br />
                    <?php if ($error_color) { ?>
                    <span class="error"><?php echo $error_color; ?></span>
                    <?php } ?>
                </div>
                <div class="return-size"><b><?php echo $entry_size; ?></b><br />
                    <input type="text" name="products[<?php echo $i; ?>][size]" value="<?php echo $products[$i]['size']; ?>" />
                    <br />
                    <?php if ($error_size) { ?>
                    <span class="error"><?php echo $error_size; ?></span>
                    <?php } ?>
                </div>
                <div class="return-config"><b><?php echo $entry_config; ?></b><br />
                    <input type="text" name="products[<?php echo $i; ?>][config]" value="<?php echo $products[$i]['config']; ?>" />
                    <br />
                    <?php if ($error_config) { ?>
                    <span class="error"><?php echo $error_config; ?></span>
                    <?php } ?>
                </div>
                <div class="return-quantity"><b><?php echo $entry_quantity; ?></b><br />
                    <input type="text" name="products[<?php echo $i; ?>][quantity]" value="<?php echo $products[$i]['quantity']; ?>" />
                    <br />
                    <?php if (isset($products[$i]['error_quantity'])) { ?>
                    <span class="error"><?php echo $products[$i]['error_quantity']; ?></span>
                    <?php } ?>
                </div>
                <div style="float:left">
                    <a href="javascript:void(0)" class="btn-one-more-row"><?php echo $text_add_one_more_row; ?></a>
                    <?php if($i > 0) { ?>
                    <br><br><br><a href="javascript:void(0)" class="btn-remove-one-row"><?php echo $text_remove_one_row; ?></a>
                    <?php } ?>
                </div>
                <div class="return-opened"><b><?php echo $entry_opened; ?></b><br />
                    <div style="margin-top:10px;">
                        <?php if ($products[$i]['opened']) { ?>
                        <input type="radio" name="products[<?php echo $i; ?>][opened]" value="1" id="opened" checked="checked" />
                        <?php } else { ?>
                        <input type="radio" name="products[<?php echo $i; ?>][opened]" value="1" id="opened" />
                        <?php } ?>
                        <label for="opened"><?php echo $text_yes; ?></label>
                        <?php if (!$products[$i]['opened']) { ?>
                        <input type="radio" name="products[<?php echo $i; ?>][opened]" value="0" id="unopened" checked="checked" />
                        <?php } else { ?>
                        <input type="radio" name="products[<?php echo $i; ?>][opened]" value="0" id="unopened" />
                        <?php } ?>
                        <label for="unopened"><?php echo $text_no; ?></label>
                        <br />
                        <br />
                    </div>
                </div>
                <div class="return-reason"><b><?php echo $entry_reason; ?></b><br />
                    <select name="products[<?php echo $i; ?>][return_reason_id]">
                        <option selected="selected">Alegeti motivul</option>
                        <?php foreach ($return_reasons as $return_reason) { ?>
                            <?php if ($return_reason['return_reason_id'] == $products[$i]['return_reason_id']) { ?>
                                <option value="<?php echo $return_reason['return_reason_id']; ?>" id="return-reason-id<?php echo $return_reason['return_reason_id']; ?>" /><?php echo $return_reason['name']; ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $return_reason['return_reason_id']; ?>" id="return-reason-id<?php echo $return_reason['return_reason_id']; ?>" /><?php echo $return_reason['name']; ?></option>
                            <?php  } ?>
                        <?php  } ?>
                    </select>
                    <?php if ($error_reason) { ?>
                    <span class="error"><?php echo $error_reason; ?></span>
                    <?php } ?>
                </div>

                <div class="return-fault-details"><b><?php echo $entry_fault_detail; ?></b><br />
                    <textarea name="products[<?php echo $i; ?>][comment]"><?php echo $products[$i]['comment']; ?></textarea>
                </div>

        </div>
    </div>
    <?php } // END foreach ?>
    <?php if (!$this->customer->isLogged()) { ?>
    <div style="clear:both;"></div>
    <div class="content"><b><?php echo $entry_captcha; ?></b>
        <input type="text" name="captcha" value="<?php echo $captcha; ?>" /><br>
        <img src="index.php?route=account/return/captcha" alt="" style="margin-left: 215px;" />
        <?php if ($error_captcha) { ?>
        <span class="error"><?php echo $error_captcha; ?></span>
        <?php } ?>
    </div>
    <?php } ?>
            






































































    <?php if ($text_agree) { ?>
    <div class="buttons">
      <div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
      <div class="right"><?php echo $text_agree; ?>
        <?php if ($agree) { ?>
        <input type="checkbox" name="agree" value="1" checked="checked" />
        <?php } else { ?>
        <input type="checkbox" name="agree" value="1" />
        <?php } ?>
        <input type="submit" value="<?php echo $button_continue; ?>" class="button" />
      </div>
    </div>
    <?php } else { ?>
    <div class="buttons">
      <div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
      <div class="right">
        <input type="submit" value="<?php echo $button_continue; ?>" class="button" />
      </div>
    </div>
    <?php } ?>
  </form>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.colorbox').colorbox({
		width: 640,
		height: 480
	});
});
//--></script> 
<script type="text/javascript">
$(document).ready(function() {
    var new_line_nr = 0;
    $('.btn-one-more-row').live( "click", function() {
	    var last_line_nr = parseInt($('.return-product').last().attr('line'));
	    console.log('last line nr '+last_line_nr);
	    new_line_nr = last_line_nr + 1;
	    console.log('new line nr '+new_line_nr);
	    $('.return-product').last().after('<div line="'+new_line_nr+'" class="return-product"> <div class="content"> <div class="return-model"><b>Cod produs:</b><br><input type="text" value="" name="products['+new_line_nr+'][model]"> <br></div><div class="return-color"><b>Culoare:</b><br><input type="text" value="" name="products['+new_line_nr+'][color]"> <br></div><div class="return-size"><b>Marime:</b><br><input type="text" value="" name="products['+new_line_nr+'][size]"> <br></div><div class="return-config"><b>Configuratie:</b><br><input type="text" value="" name="products['+new_line_nr+'][config]"> <br></div><div class="return-quantity"><b>Cantitate:</b><br><input type="text" value="1" name="products['+new_line_nr+'][quantity]"> <br></div><div style="float:left"> <a class="btn-one-more-row" href="javascript:void(0)">Adauga linie noua</a><br><br><br><a href="javascript:void(0)" class="btn-remove-one-row"><?php echo $text_remove_one_row; ?></a> </div><div class="return-opened"> <b>Produs desigilat:</b><br><div style="margin-top:10px;"> <input type="radio" id="opened" value="1" name="products['+new_line_nr+'][opened]"> <label for="opened">Da</label> <input type="radio" checked="checked" id="unopened" value="0" name="products['+new_line_nr+'][opened]"> <label for="unopened">Nu</label> <br><br></div></div><div class="return-reason"> <b>Motiv retur:</b><br><select name="products['+new_line_nr+'][return_reason_id]"> <option selected="selected">Alegeti motivul</option> <option id="return-reason-id5" value="5">Alte cauze, va rugam detaliati</option> <option id="return-reason-id3" value="3">Eroare la comanda</option> <option id="return-reason-id1" value="1">Produs nou, defect</option> <option id="return-reason-id4" value="4">Produs utilizat, defect</option> <option id="return-reason-id2" value="2">Produse livrate gresit</option> <option id="return-reason-id6" value="6">Schimbare marime/culoare</option> </select> </div><div class="return-fault-details"><b>Detalii:</b><br><textarea rows="1" cols="17" name="products['+new_line_nr+'][comment]"></textarea> </div></div></div>');
    });

    $('.btn-remove-one-row').live( "click", function() {
	    $(this).closest('.return-product').remove();
        console.log( "removed?" );
    });
});
</script> 
<?php echo $footer; ?>