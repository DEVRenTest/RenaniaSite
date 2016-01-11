<?php echo $header; ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<div class="breadcrumb">
   <?php foreach ($breadcrumbs as $breadcrumb) { ?>
   <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
   <?php } ?>
</div>
<div id="content"><?php echo $content_top; ?>
   <h1 class="heading-title"><?php echo $heading_title; ?></h1>

   <?php if ($reclamations) { ?>
   <table class="list">
      <thead>
         <tr>
            <td class="left"><?php echo $entry_subject; ?></td>
            <td class="left"><?php echo $text_insert_date; ?></td>
            <td class="left"><?php echo $entry_status; ?></td>
            <td class="center"><?php echo $text_edit; ?></td>
            <td class="center"><?php echo $text_delete; ?></td>
         </tr>
      </thead>
      <tbody>
         <?php foreach ($reclamations as $reclamation) { ?>
         <tr>
            <td class="left"><?php echo $reclamation['subject']; ?></td>
            <td class="left"><?php echo $reclamation['insert_date']; ?></td>
            <td class="left"><?php echo $reclamation['status']; ?></td>
            <td class="center">
               <?php if ( !empty($reclamation['edit_href']) ) { ?>
               <a href="<?php echo $reclamation['edit_href']; ?>">
                  <img src="catalog/view/theme/default/image/info.png" alt="<?php echo $button_view; ?>" title="<?php echo $button_view; ?>" />
               </a>
               <?php } ?>
            </td>
            <td class="center">
               <?php if ( !empty($reclamation['delete_href']) ) { ?>
               <a class="confirm" href="<?php echo $reclamation['delete_href']; ?>">
                  <img src="catalog/view/theme/default/image/remove.png" alt="<?php echo $button_view; ?>" title="<?php echo $button_view; ?>" />
               </a>
               <?php } ?>
            </td>
         </tr>
         <?php } ?>
      </tbody>

   </table>

   <div class="pagination"><?php echo $pagination; ?></div>
   <?php } else { ?>
   <div class="content"><?php echo $text_empty; ?></div>
   <?php } ?>
   <div class="buttons">
      <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
   </div>
   <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>

<script>
   $(document).ready(function(){
   
      $('.confirm').click(function(){
         var answer = confirm("<?php echo $text_are_you_sure; ?> ");
         if (answer)
         {
               return true;
         } 
         else 
         {
            return false;
         }
       });
   
   });
</script>