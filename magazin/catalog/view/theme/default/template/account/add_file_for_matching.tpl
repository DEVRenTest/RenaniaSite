<?php echo $header; ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<?php if ($warning) { ?>
<div class="warning"><?php echo $warning; ?></div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
   <div class="breadcrumb">
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
      <?php } ?>
   </div>
   <h1><?php echo $heading_title; ?></h1>
   <div class="content">
      <form action="<?php echo $upload_file; ?>" method="post" enctype="multipart/form-data" id="form">
         <table class="form">
            <tr>
               <td valign="top"><span class="required"></span> 
                  <?php echo $text_choose_file; ?>
               </td>
               <td align="left">
                  <input type="file" id="file_for_matching" name="file_for_matching" value="" onchange="getFileForMatchingContent();" />
                  <?php echo $text_allowed_extensions; ?>
                  <br>
                  <?php if ($error_file_upload) { ?>
                  <span class="error"><?php echo $error_file_upload; ?></span>
                  <?php } ?>

               </td>
            </tr>

            <tr id="csv_file">
                 <td valign="top"><span class="required"></span>
                     <?php echo $text_csv_delimiter; ?>
                 </td>
                 <td align="left">
                     <input type="text" name="csv_delimiter" value="<?php echo $csv_delimiter; ?>" />
                     <?php if ($error_csv_delimiter) { ?>
                     <span class="error"><?php echo $error_csv_delimiter; ?></span>
                     <?php } ?>

                 </td>
             </tr>

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
var file_value = '';
$(document).ready(function() {

    $("#csv_file").hide();

    <?php  if ( $error_csv_delimiter ) :?>
        $("#csv_file").show();
    <?php endif; ?>

    file_value = $('#file_for_matching').val();
});

function getFileForMatchingContent()
{
    file_value = $('#file_for_matching').val();
    var ext = $('#file_for_matching').val().split('.').pop();
    if ( ext == "csv" )
    {
        $("#csv_file").show();
    }
    else
    {
        $("#csv_file").hide();
    }
}

function upload()
{
    $('#form').submit();
}
</script>