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
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/review.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><b><?php echo $emails_text; ?></b><br><span style="color:grey"><?php echo $emails_instruction; ?></span></td>
            <td><textarea name="review_config_emails" cols="60" rows="8"><?php echo $emails; ?></textarea>
              <?php if ($error_emails) { ?>
              <span class="error"><?php echo $error_emails; ?></span>
              <?php } ?></td>
          </tr>		   <tr>              <td><b><?php echo $review_status; ?></b><br><span style="color:grey"><?php echo $review_status_instruction; ?></span></td>              <td><?php if ($status==1) { ?>                <input type="radio" name="config_review_status" value="1" checked="checked" />                <?php echo "Da"; ?>                <input type="radio" name="config_review_status" value="0" />                <?php echo "Nu"; ?>                <?php } else { ?>                <input type="radio" name="config_review_status" value="1" />                <?php echo "Da"; ?>                <input type="radio" name="config_review_status" value="0" checked="checked" />                <?php echo "Nu"; ?>                <?php } ?></td>            </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>