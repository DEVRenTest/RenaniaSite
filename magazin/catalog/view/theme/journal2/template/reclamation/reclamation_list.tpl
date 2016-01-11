<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  
  <?php if ($reclamations) { ?>
  <table class="list">
      <thead>
         <tr>
            <td class="left"><?php echo $text_subject; ?></td>
            <td class="left"><?php echo $text_insert_date; ?></td>
            <td class="right"><?php echo $text_status; ?></td>
            <td class="right"><?php echo $text_edit; ?></td>
            <td class="right">&nbsp;</td>
         </tr>
      </thead>
      <tbody>
         <?php foreach ($reclamations as $reclamation) { ?>
         <tr>
            <td class="left"><?php echo $reclamation['subject']; ?></font></td>
            <td class="left"><?php echo $reclamation['insert_date']; ?></font></td>
            <td class="right"<?php echo $reclamation['status']; ?></font></td>
            <td class="right">aaaaa</td>
            <td class="center">
               <?php if ( !empty($invoice['href']) ) { ?>
               <a href="<?php echo $invoice['href']; ?>">
                  <img src="catalog/view/theme/default/image/info.png" alt="<?php echo $button_view; ?>" title="<?php echo $button_view; ?>" />
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