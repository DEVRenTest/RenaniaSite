<?php echo $header; ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
   <div class="breadcrumb">
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
      <?php } ?>
   </div>
   <h1><?php echo $heading_title; ?></h1>
   <h2><?php echo $text_reclamation; ?> </h2>
   <div class="content">
      <form action="<?php echo $send_reclamation; ?>" method="post" enctype="multipart/form-data" id="form">
         <table class="form">
<!--            <tr>
               <td><span class="required">*</span> <?php echo $entry_number; ?>:</td>
               <td><input type="text" name="number" value="<?php echo $number; ?>" />
                  <?php if ($error_number) { ?>
                  <span class="error"><?php echo $error_number; ?></span>
                  <?php } ?></td>
            </tr>-->
            <tr>
               <td><span class="required">*</span> <?php echo $entry_subject; ?>:</td>
               <td><input type="text" name="subject" value="<?php echo $subject; ?>" />
                  <?php if ($error_subject) { ?>
                  <span class="error"><?php echo $error_subject; ?></span>
                  <?php } ?></td>
            </tr>
            <tr>
               <td valign="top"><span class="required">*</span> <?php echo $entry_description; ?>:</td>
               <td>
                  <textarea rows="10" cols="40" name="description"><?php echo $description; ?></textarea>
                  <?php if ($error_description) { ?>
                  <span class="error"><?php echo $error_description; ?></span>
                  <?php } ?></td>
            </tr>
            <tr>
               <td valign="top"><span class="required"></span> <?php echo $entry_documents; ?>:</td>
               <td align="left">
                  <input type="file" name="attachment[]" value="" />
                  <span class="small">
                     <a id="AddMoreFileBox" class="btn btn-info" href="#"><?php echo $text_add_another_one; ?></a>
                  </span>
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
<!--         <input type="submit" value="<?php echo $text_send; ?>" class="button" />-->
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


function checkFileSize(id) {
	// See also http://stackoverflow.com/questions/3717793/javascript-file-upload-size-validation for details
	var input, file, file_size;

	if (!window.FileReader) {
		// The file API isn't yet supported on user's browser
		return true;
	}

	//input = document.getElementById(id);
   input = document.getElementsByName(id);
	if (!input) {
		// couldn't find the file input element
		return true;
	}
	else if (!input.files) {
		// browser doesn't seem to support the `files` property of file inputs
		return true;
	}
	else if (!input.files[0]) {
		// no file has been selected for the upload
		alert( "<?php echo $error_select_file; ?>" );
		return false;
	}
	else {
		file = input.files[0];
		file_size = file.size;
		<?php if (!empty($post_max_size)) { ?>
		// check against PHP's post_max_size
		post_max_size = <?php echo $post_max_size; ?>;
		if (file_size > post_max_size) {
			alert( "<?php echo $error_post_max_size; ?>" );
			return false;
		}
		<?php } ?>
		<?php if (!empty($upload_max_filesize)) { ?>
		// check against PHP's upload_max_filesize
		upload_max_filesize = <?php echo $upload_max_filesize; ?>;
		if (file_size > upload_max_filesize) {
			alert( "<?php echo $error_upload_max_filesize; ?>" );
			return false;
		}
		<?php } ?>
		return true;
	}
}

function upload() 
{
  console.log("benne");
	if (checkFileSize('attachment')) 
   {
		$('#form').submit();
	}
}
</script>