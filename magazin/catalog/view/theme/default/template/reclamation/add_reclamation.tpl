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
   <h2>
      <?php if ( empty($id) ) 
      { 
      echo $text_add_reclamation; 
      }
      else
      {
      echo $text_mod_reclamation;
      } ?>
   </h2>
   <div class="content">
      <form action="<?php echo $send_reclamation; ?>" method="post" enctype="multipart/form-data" id="form">
         <input type="hidden" value="<?php echo $id; ?>" name="id">
         <table class="form">
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
               <td valign="top"><span class="required"></span> 
                  <?php if ( empty($id) )  
                  { echo $entry_documents;}
                  else if ( !empty($id) && !empty( $documents ) )
                  { echo $text_attached_documents;}
                  ?></td>
               <td align="left">
                  <?php if ( !empty($id) ) {
                  echo $documents;
                  } 
                  else { ?>
                  
<!--                  <div class="fileinputs">       class="file"          -->
                    <input type="file" id="attachment_1" name="attachment[]" value=""  />
<!--                    <div class="fakefile">
                        <input />
                        <img src="catalog/view/theme/default/image/buton_search-on.png" />
                     </div>
                  </div>-->
                  
                  <span class="small">
                     <a id="AddMoreFileBox" class="btn btn-info" href="#"><?php echo $text_add_another_one; ?></a>
                  </span>
                  <br>
                  <?php echo $text_allowed_extensions; ?>
                  <div id="attachment_div">
                  </div>
                  <?php } ?>

               </td>
            </tr>
            <tr>
               <td valign="top"> <?php echo $entry_status; ?>:</td>
               <td>
                  <select id="status" name="status" >
                     <option value="<?php echo $text_new; ?>"><?php echo $text_new; ?></option>
                     <option value="<?php echo $text_in_progress; ?>" <?php if ( empty($id) )  { ?> disabled <?php } ?> ><?php echo $text_in_progress; ?></option>
                     <option value="<?php echo $text_resolved; ?>" <?php if ( empty($id) ) { ?> disabled <?php } ?> ><?php echo $text_resolved; ?></option>
                  </select>   
               </td>
            </tr>
            <div id="another_one">
            </div>

         </table>


   <div class="buttons">
      <div class="right">
         <a onclick="upload();" class="button">
            <span><?php echo $text_send; ?></span>
         </a>     
      </div>
   </div>
         
            </div>
</form>


<?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>


<style>
   
div.fileinputs {
	position: relative;
}

div.fakefile {
	position: absolute;
	top: 0px;
	left: 0px;
	z-index: 1;
}

input.file {
	position: relative;
	text-align: right;
	-moz-opacity:0 ;
	filter:alpha(opacity=0);
	opacity: 0;
	z-index: 2;
}
</style>

<script>
   var FieldCount=1;
   $(document).ready(function() {

   var MaxInputs       = 10; //maximum input boxes allowed
   var InputsWrapper   = $("#attachment_div"); 
   var AddButton       = $("#AddMoreFileBox");

   var x = InputsWrapper.length;
   

   $(AddButton).click(function (e) {
      if(x <= MaxInputs) 
       {
          FieldCount++;
          $(InputsWrapper).append('<div><input type="file" id="attachment_"'+FieldCount+' name="attachment[]"  ><a href="#" class="removeclass">&times;</a></div>');
          x++; 
       }
       return false;
    });

    $("body").on("click",".removeclass", function(e){
      if( x > 1 ) 
      {
         $(this).parent('div').remove();
         x--;
      }
      return false;
    });
});


function upload() 
{
   $('#form').submit();
}
</script>