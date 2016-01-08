<?php echo $header; ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div class="breadcrumb">
   <?php foreach ($breadcrumbs as $breadcrumb) { ?>
   <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
   <?php } ?>
</div>
<div id="content"><?php echo $content_top; ?>
   <h1 class="heading-title"><?php echo $heading_title; ?></h1>
   <?php /* ?><h2><?php echo $text_send_mail; ?> </h2><?php */ ?>
   <div class="content">
      <form action="<?php echo $send_message; ?>" method="post" enctype="multipart/form-data" id="form">
         <table class="form">
            <tr>
               <td><span class="required">*</span> <?php echo $entry_name; ?>:</td>
               <td><input type="text" name="name" value="<?php echo $name; ?>" />
                  <?php if ($error_name) { ?>
                  <span class="error"><?php echo $error_name; ?></span>
                  <?php } ?></td>
            </tr>
            <tr>
               <td><span class="required">*</span> <?php echo $entry_email; ?>:</td>
               <td><input type="text" name="email" value="<?php echo $email; ?>" />
                  <?php if ($error_email) { ?>
                  <span class="error"><?php echo $error_email; ?></span>
                  <?php } ?></td>
            </tr>
            <tr>
               <td valign="top"><span class="required">*</span> <?php echo $entry_message; ?>:</td>
               <td>
                  <textarea rows="10" cols="40" name="message"><?php echo $message; ?></textarea>

                  <?php if ($error_message) { ?>
                  <span class="error"><?php echo $error_message; ?></span>
                  <?php } ?></td>
            </tr>
            <tr>
               <td valign="top"><span class="required"></span> <?php echo $entry_attachments; ?>:</td>
               <td align="left">
                  <input type="file" name="attachment[]" value="" />
                  <span class="small">
                     <a id="AddMoreFileBox" class="btn btn-info" href="#"><?php echo $text_add_another_one; ?></a>
                  </span>
                  <br>
                  <?php echo $text_allowed_extensions; ?>
                  <div id="attachment_div">
                  </div>

               </td>
            </tr>
            <div id="another_one">
            </div>

         </table>
   </div>

   <div class="buttons">
      <div class="right">
             <a onclick="upload();" class="button">
                <span><?php echo $text_send; ?></span>
             </a>     
      </div>
   </div>
</form>


<?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>

<script>
   
   $(document).ready(function() {

   var MaxInputs       = 10; //maximum input boxes allowed
   var InputsWrapper   = $("#attachment_div"); 
   var AddButton       = $("#AddMoreFileBox");

   var x = InputsWrapper.length; //initlal text box count
   var FieldCount=1; //to keep track of text box added

   $(AddButton).click(function (e)  //on add input button click
   {
      if(x <= MaxInputs) //max input box allowed
       {
             FieldCount++; //text box added increment
          //add input box
          //id="field_'+ FieldCount +'"
          //value="Text '+ FieldCount +'"
          $(InputsWrapper).append('<div><input type="file" name="attachment[]"  ><a href="#" class="removeclass">&times;</a></div>');
          x++; //text box increment
       }
       return false;
    });

    $("body").on("click",".removeclass", function(e){ //user click on remove text
    if( x > 1 ) {
    $(this).parent('div').remove(); //remove text box
    x--; //decrement textbox
 }
 return false;
})

});


function upload() 
{
   $('#form').submit();
}
</script>