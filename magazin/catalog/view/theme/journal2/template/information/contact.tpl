<?php if (!isset($is_j2_popup)): ?>
<?php echo $header; ?>
<div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
</div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content" class="contact-page"><h1 class="heading-title"><?php echo $heading_title; ?></h1><?php echo $content_top; ?>
<?php endif; ?>

  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <?php if (isset($product_id) && $product_id): ?>
    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
    <?php endif; ?>
    <?php if (!isset($is_j2_popup)): ?>
    <h2 class="secondary-title"><?php echo $text_location; ?></h2>
    <div class="contact-info">
      <div class="content"><div class="left">
              <h3 class="contactCity">Targu Mures</h3>
              <b><?php echo $text_address; ?></b><br />
        <?php echo $store; ?><br />
        <?php echo $address; ?></div>
        <div class="right">
          <?php if ($telephone) { ?>
          <b><?php echo $text_telephone; ?></b><br />
          <?php echo $telephone; ?><br />
          <br />
          <?php } ?>
          <b>Fax:</b><br />
		  0265 26 09 06
         
        </div>
      </div>
    </div>
    <div class="contact-info">
      <div class="content">
          <div class="left">
              <h3 class="contactCity">Bucuresti</h3>
              <b><?php echo $text_address; ?></b><br />
              <?php //echo $store; ?>
              Soseaua Bucuresti-Ploiesti nr. 42-44, Complex Baneasa Business Technology Park, Cladirea C1, Aripa 1, sector 1, Bucuresti
			  
			   <br /><br /><b>Email</b><br />
              <a href="mailto:bucuresti@renania.ro">bucuresti@renania.ro</a>
          </div>
            <div class="right">
              <b><?php echo $text_telephone; ?></b><br />
              +40 372 759 283<br />
              <br />
              <?php /*if ($fax) { ?>
              <b><?php echo $text_fax; ?></b><br />
              <?php echo $fax; ?>
              <?php }*/ ?>
			    <b>Fax:</b><br />
				  0214 04 33 44
               
            </div>
      </div>
    </div>
      <div class="contact-info">
          <div class="content">
              <div class="left">
                  <h3 class="contactCity">Timisoara</h3>
                  <b><?php echo $text_address; ?></b><br />
                  <?php //echo $store; ?>
                  Bulevardul Ghioceilor nr. 3, Dumbravita, 307160, Jud. Timis
				  
				   <br /><br /><b>Email</b><br />
                  <a href="mailto:timisoara@renania.ro">timisoara@renania.ro</a>
              </div>
              <div class="right">
                  <b><?php echo $text_telephone; ?></b><br />
                  +40 372 759 301<br />
                  <br />
                  <?php /*if ($fax) { ?>
                  <b><?php echo $text_fax; ?></b><br />
                  <?php echo $fax; ?>
                  <?php }*/ ?>
				   <b>Fax:</b><br />
					0214 04 33 44
                 
              </div>
          </div>
      </div>
      <div class="contact-info">
          <div class="content">
              <div class="left">
                  <h3 class="contactCity">Iasi</h3>
                  <b><?php echo $text_address; ?></b><br />
                  <?php //echo $store; ?>
                  Letcani, nr. 1113, Parcul Logistic SOLO, Jud. Iasi
				  
				   <br /><br /><b>Email</b><br />
                  <a href="mailto:iasi@renania.ro">iasi@renania.ro</a>
              </div>
              <div class="right">
                  <b><?php echo $text_telephone; ?></b><br />
                  +40 372 759 246<br />
                  <br />
                  <?php /*if ($fax) { ?>
                  <b><?php echo $text_fax; ?></b><br />
                  <?php echo $fax; ?>
                  <?php }*/ ?>
				   <b>Fax:</b><br />
				     0214 04 33 44
                 
              </div>
          </div>
      </div>
      <div class="contact-info">
          <div class="content">
              <div class="left">
                  <h3 class="contactCity">Craiova</h3>
                  <b><?php echo $text_address; ?></b><br />
                  <?php //echo $store; ?>
                  Str. Stirbei Voda Nr. 30, 200760, Craiova
				  
				   <br /><br /><b>Email</b><br />
                  <a href="mailto:craiova@renania.ro">craiova@renania.ro</a>
              </div>
              <div class="right">
                  <b><?php echo $text_telephone; ?></b><br />
                  +40 722 366 809<br />
                  <br />
                  <?php /*if ($fax) { ?>
                  <b><?php echo $text_fax; ?></b><br />
                  <?php echo $fax; ?>
                  <?php }*/ ?>
				   <b>Fax:</b><br />
				    0214 04 33 44
                 
              </div>
          </div>
      </div>
    <h2 class="secondary-title"><?php echo $text_contact; ?></h2>
    <?php endif; ?>
    <div class="content">
    <b><?php echo $entry_name; ?></b><br />
    <input type="text" name="name" value="<?php echo $name; ?>" />
    <br />
    <?php if ($error_name) { ?>
    <span class="error"><?php echo $error_name; ?></span>
    <?php } ?>
    <br />
    <b><?php echo $entry_email; ?></b><br />
    <input type="text" name="email" value="<?php echo $email; ?>" />
    <br />
    <?php if ($error_email) { ?>
    <span class="error"><?php echo $error_email; ?></span>
    <?php } ?>
    <br />
    <b><?php echo $entry_enquiry; ?></b><br />
    <textarea name="enquiry" cols="40" rows="10"><?php echo $enquiry; ?></textarea>
    <br />
    <?php if ($error_enquiry) { ?>
    <span class="error"><?php echo $error_enquiry; ?></span>
    <?php } ?>
    <br />
    <b><?php echo $entry_captcha; ?></b><br />
    <input type="text" name="captcha" value="<?php echo $captcha; ?>" />
    <br />
    <img src="index.php?route=information/contact/captcha" alt="" />
    <?php if ($error_captcha) { ?>
    <span class="error"><?php echo $error_captcha; ?></span>
    <?php } ?>
    </div>
    <?php if (!isset($is_j2_popup)): ?>
    <div class="buttons">
        <div class="right"><input type="submit" value="<?php echo $button_continue; ?>" class="button" /></div>
    </div>
    <?php endif; ?>
  </form>
<?php if (!isset($is_j2_popup)): ?>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>
<?php endif; ?>