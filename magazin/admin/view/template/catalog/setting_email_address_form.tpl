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
         <h1><img src="view/image/pdf.png" alt="" /> <?php echo $heading_title; ?></h1>
         <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
      </div>
      <div class="content">
         <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
            <div id="languages" class="htabs">
               <?php foreach ($languages as $language) { ?>
               <a href="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
               <?php } ?>
            </div>
            <?php foreach ($languages as $language) { ?>
            <div id="language<?php echo $language['language_id']; ?>">
               <table class="form">
                  <tr>
                     <td><span class="required">*</span> <?php echo $entry_name; ?></td>
                     <td><input type="text" name="setting_email_address_description[<?php echo $language['language_id']; ?>][name]" size="50" value="<?php echo isset($setting_email_address_description[$language['language_id']]) ? $setting_email_address_description[$language['language_id']]['name'] : ''; ?>" />
                        <?php if (isset($error_name[$language['language_id']])) { ?>
                        <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
                        <?php } ?></td>
                  </tr>
                  <tr>
                     <td><span class="required">*</span> <?php echo $entry_email; ?></td>
                     <td><input type="text" name="setting_email_address_description[<?php echo $language['language_id']; ?>][email]" size="50" value="<?php echo isset($setting_email_address_description[$language['language_id']]) ? $setting_email_address_description[$language['language_id']]['email'] : ''; ?>" />
                        <?php if (isset($error_email[$language['language_id']])) { ?>
                        <span class="error"><?php echo $error_email[$language['language_id']]; ?></span>
                        <?php } ?></td>
                  </tr>
                  <tr>
                     <td><?php echo $entry_status; ?></td>
                     <td><select name="status">
                           <?php if ($status) { ?>
                           <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                           <option value="0"><?php echo $text_disabled; ?></option>
                           <?php } else { ?>
                           <option value="1"><?php echo $text_enabled; ?></option>
                           <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                           <?php } ?>
                        </select></td>
                  </tr>
                  <tr>
                     <td><?php echo $entry_sort_order; ?></td>
                     <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
                  </tr>
               </table>
            </div>
            <?php } ?>

         </form>
      </div>
   </div>
</div>


<script type="text/javascript"><!--
$('#languages a').tabs(); 
//--></script> 
<?php echo $footer; ?>