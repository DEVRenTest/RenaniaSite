<?php echo $header; ?>
<div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
</div>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
 <?php if ( $login_from_b2b == 1 ) { ?>
   <div class="success"><?php echo $b2b_login_explanation_text; ?></div>
   <?php } ?>
<h1 class="heading-title">
 <?php if ( !$B2B_login ) 
     {
         echo $heading_title;
     }
     else
     {
         echo $heading_title_b2b;
     } ?>
  </h1><?php echo $content_top; ?>
  <div class="login-content">
    <?php if ( !$B2B_login ) { ?>
         <div class="left">
            <h2 class="secondary-title"><?php echo $text_new_customer; ?></h2>
            <div class="content">
            <div class="login-wrap">
            <p><b><?php echo $text_register; ?></b></p>
            <p><?php echo $text_register_account; ?></p>
        	</div><hr>
            <a href="<?php echo $register; ?>" class="button"><?php echo $button_continue; ?></a></div>
         </div>
      <?php } ?>
     <?php if ( !$B2B_login ) { ?>
    <div class="right">
    <?php } ?>
     <h2 class="secondary-title">
         <?php if ( !$B2B_login ) 
         {
           echo $text_returning_customer;
         }
         else
         {
            echo $text_returning_customer_b2b;
         }?>
      </h2>

      <div class="login-wrap">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <div class="content">
          
                <?php if ( !$B2B_login ) {
                echo $text_i_am_returning_customer; 
                ?>
                <input type="hidden" name="B2B_authentication" value="0" />
              <?php } else { ?>
              <input type="hidden" name="B2B_authentication" value="1" />
              <?php } ?>
              
         
         <?php $isLoggedButNoValidation = $this->customer->isLoggedB2BWithoutValidationCode(); ?>
          <?php if( empty( $isLoggedButNoValidation ) ){ ?>
               <b customer_id="<?php echo $isLoggedButNoValidation; ?>"><?php echo $entry_email; ?></b><br />
               <input type="text" name="email" value="<?php echo $email; ?>" />
               <br />
               <br />
               <b><?php echo $entry_password; ?></b><br />
               <input type="password" name="password" value="<?php echo $password; ?>" />
               <br />
               <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a><br />
               <br />
          <?php } else { ?>

               <div  customer_id="<?php echo $isLoggedButNoValidation; ?>">
                  <br />
                  <b><?php echo $entry_validation_code; ?></b><br />
                  <input type="text" name="validation_code" value="" />
                  <br />
               </div>
          <?php } ?>
          
          <input type="submit" value="<?php echo $button_login; ?>" class="button" style="margin-top: 10px" />

          <?php if ($redirect) { ?>
          <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
          <?php } ?>
          
          <?php if( !empty( $isLoggedButNoValidation ) ){ ?>
             <input class="button" type="button" name="Button" value="<?php echo $text_login_whit_different_account; ?>" onClick="self.location.href='<?php echo $login_with_different_account; ?>'" />
          <?php } ?>
        
        </div>
      </form>     
    <?php if ( !$B2B_login ) { ?>
    </div>
    <?php } ?>
  
  
  
  </div>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('#login input').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#login').submit();
	}
});
//--></script> 
<?php echo $footer; ?>