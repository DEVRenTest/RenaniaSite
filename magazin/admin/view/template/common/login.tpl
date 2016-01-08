<?php echo $header; ?>
<div id="content">
  <div class="box" style="width: 400px; min-height: 300px; margin-top: 40px; margin-left: auto; margin-right: auto;">
    <div class="heading">
      <h1><img src="view/image/lockscreen.png" alt="" /> <?php echo $text_login; ?></h1>
    </div>
    <div class="content" style="min-height: 150px; overflow: hidden;">
      <?php if ($success) { ?>
      <div class="success"><?php echo $success; ?></div>
      <?php } ?>
      <?php if ($error_warning) { ?>
      <div class="warning"><?php echo $error_warning; ?></div>
      <?php } ?>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table style="width: 100%;">
          <tr>
            <td style="text-align: center;" rowspan="4"><img src="view/image/login.png" alt="<?php echo $text_login; ?>" /></td>
          </tr>
           <?php  $isLoggedButNoValidation = $this->user->isLoggedWithoutValidationCode(); ?>
           <?php if( empty( $isLoggedButNoValidation ) || $redirect_from_logout == 1 ){ ?>
               <tr>
                  <td><?php echo $entry_username; ?><br />
                  <input type="text" name="username" value="<?php echo $username; ?>" style="margin-top: 4px;" />
                  <br />
                  <br />
                  <?php echo $entry_password; ?><br />
                  <input type="password" name="password" value="<?php echo $password; ?>" style="margin-top: 4px;" />
                  <?php if ($forgotten) { ?>
                  <br />
                  <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
                  <?php } ?>
                  </td>
               </tr> 
          <?php  } else { ?>
               <tr>
                  <td><?php echo $entry_validation_code; ?><br />
                  <input type="text" name="validation_code" value="" style="margin-top: 4px;" />
                  </td>
               </tr>
          <?php } ?>
          
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: right;"><a onclick="$('#form').submit();" class="button"><?php echo $button_login; ?></a></td>
          </tr>
        </table>
        <?php if ($redirect) { ?>
        <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
        <?php } ?>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#form').submit();
	}
});
//--></script> 
<?php echo $footer; ?>