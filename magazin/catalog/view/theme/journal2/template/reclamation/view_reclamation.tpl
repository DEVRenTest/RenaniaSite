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
   <h2 class="secondary-title">
      <?php echo $text_history; ?>
   </h2>
<div class="content">
   <table class="list history">
      <thead>
         <tr>
           <td class="left" width="50%">
              <?php if ( !empty($recl_subject) ) {
              echo $entry_subject." :";  echo $recl_subject; } ?> <br>
              <?php if ( !empty($recl_subject) ) {
              echo $entry_status." :";  echo $recl_status; } ?> <br>
              <?php if ( !empty($recl_number) ) { 
                  echo $entry_number.": "; echo $recl_number;
               } ?>
              
            </td>
            <td class="left">
               <div class="right">
                  <a id="reply" class="button">
                     <span><?php echo $text_reply; ?></span>
                  </a>     
                  <a id="cancel" class="button">
                     <span><?php echo $text_cancel; ?></span>
                  </a>     
               </div>
            </td>
         </tr>
      </thead>

      <tbody>
         <?php if ( $histories && !empty( $histories ) ) { 
            foreach ($histories as $key => $history) { ?>
<!--              <?php if ( $history['customer_id'] == '-99999' ) { ?>
               <tr>
                  <td <?php  if ( ($key +1 ) % 2 == 0  ) {  ?> style="background-color: #EFEFEF" <?php } ?> colspan="2" valign="top" class="left"> 
                     <?php echo $entry_number; ?>: <strong><?php echo $history['number']; ?></strong>
                  </td>
               </tr>
               <?php } ?>-->
               <tr>
                  <td <?php  if ( ($key +1 ) % 2 == 0  ) {  ?> style="background-color: #EFEFEF" <?php } ?> colspan="2" valign="top" class="left"> 
                     <?php echo $text_insert_date; ?>: <?php echo $history['insert_date']; ?>
                  </td>
               </tr>
<!--               <tr>
                  <td <?php  if ( ($key +1 ) % 2 == 0  ) {  ?> style="background-color: #EFEFEF" <?php } ?> colspan="2" valign="top" class="left"> 
                     <?php echo $entry_status; ?>: <?php echo $history['status']; ?></td>
               </tr>-->
               <tr>
                  <td <?php  if ( ($key +1 ) % 2 == 0  ) {  ?> style="background-color: #EFEFEF" <?php } ?> colspan="2" valign="top" class="left"> 
                     <?php echo $entry_description; ?>: <?php echo $history['description']; ?>
                  </td>
               </tr>
               <tr>
                  <td <?php  if ( ($key +1 ) % 2 == 0  ) {  ?> style="background-color: #EFEFEF" <?php } ?> colspan="2"> 
                     <?php echo $text_attached_documents; ?>:
                     <?php if (!empty( $history['attachment'] ))  { ?>
                     <br> <?php echo $history['attachment']; ?>
                     <?php }
                     else { 
                      echo $text_no_document;
                     } ?>
                  </td>
               </tr>
               <tr>
                  <td <?php  if ( ($key +1 ) % 2 == 0  ) {  ?> style="background-color: #EFEFEF" <?php } ?> colspan="2"> &nbsp;</td>
               </tr>
         <?php } ?>
         <?php } ?>
         
         <tr>
            <td colspan="2">
               <div id="reply_reclamation">
               <div>
                  <form action="<?php echo $send_reclamation; ?>" method="post" enctype="multipart/form-data" id="form">
                     <input type="hidden" value="<?php echo $id; ?>" name="id">
                     <input type="hidden" value="<?php echo $id_parent; ?>" name="id_parent">
                     <table class="form">
                        <tr>
                           <td class="left" valign="top" style="width: 50%;"><span class="required">*</span> <?php echo $entry_description; ?>:</td>
                           <td class="left" style="width: 50%;">
                              <textarea rows="10" cols="40" name="description"><?php echo $description; ?></textarea>
                              <?php if ($error_description) { ?>
                              <span class="error"><?php echo $error_description; ?></span>
                              <?php } ?></td>
                        </tr>
                        <tr>
                           <td class="left" valign="top">
                              <?php echo $entry_documents; ?></td>
                           <td class="left" align="left">
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
                        <tr>
                           <td class="left" valign="top"> <?php echo $entry_status; ?>:</td>
                           <td class="left">
<!--                              <select id="status" name="status" >
                                 <option value="<?php echo $text_new; ?>" disabled><?php echo $text_new; ?></option>
                                 <option value="<?php echo $text_in_progress; ?>"><?php echo $text_in_progress; ?></option>
                                 <option value="<?php echo $text_resolved; ?>"><?php echo $text_resolved; ?></option>
                              </select>   -->
                              <select id="status" name="status" >
                                 <?php if ( $status == $text_new ) { ?>
                                 <option value="<?php echo $text_new; ?>" disabled selected ><?php echo $text_new; ?></option>
                                 <option value="<?php echo $text_in_progress; ?>"><?php echo $text_in_progress; ?></option>
                                 <option value="<?php echo $text_resolved; ?>"><?php echo $text_resolved; ?></option>
                                 <?php } else if ( $status == $text_in_progress ) { ?>
                                 <option value="<?php echo $text_new; ?>" disabled><?php echo $text_new; ?></option>
                                 <option value="<?php echo $text_in_progress; ?>" selected><?php echo $text_in_progress; ?></option>
                                 <option value="<?php echo $text_resolved; ?>"><?php echo $text_resolved; ?></option>
                                 <?php } else if ( $status == $text_resolved ) { ?>
                                 <option value="<?php echo $text_new; ?>" disabled><?php echo $text_new; ?></option>
                                 <option value="<?php echo $text_in_progress; ?>"><?php echo $text_in_progress; ?></option>
                                 <option value="<?php echo $text_resolved; ?>" selected><?php echo $text_resolved; ?></option>
                                 <?php } ?>
                              </select>   
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
               </div>

            </td>
         </tr>
         
      </tbody>
   </table>
</div>

<?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>

<script type="text/javascript">
   $(document).ready(function() {
   
   var MaxInputs       = 10; //maximum input boxes allowed
   var InputsWrapper   = $("#attachment_div"); 
   var AddButton       = $("#AddMoreFileBox");

   var x = InputsWrapper.length;
   var FieldCount=1;

   $(AddButton).click(function (e) {
      if(x <= MaxInputs) 
       {
          FieldCount++;
          $(InputsWrapper).append('<div><input type="file" name="attachment[]"  ><a href="#" class="removeclass">&times;</a></div>');
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
   
        
   $('#reply_reclamation').hide();
   $('#cancel').hide();
   
   <?php if (!empty($msg)) { ?>
      $('#reply_reclamation').show();
   <?php  }?>

   $("#reply").click(function (e){
     ScrollToBottom();

      $('#reply_reclamation').show();
      $('#reply').hide();
      $('#cancel').show();
   });
   
   $("#cancel").click(function (e){
      $('#reply_reclamation').hide();
      $('#reply').show();
      $('#cancel').hide();
   });
   
});

function ScrollToBottom()
{
   window.scrollTo(0,document.body.scrollHeight);
}


function upload() 
{
   $('#form').submit();
}
</script>