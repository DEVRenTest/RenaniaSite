<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  
  <?php if ($documents) { ?>
  <table class="list">
      <thead>
         <tr>
            <td class="left"><?php echo $text_useful_documents_list; ?></td>
         </tr>
      </thead>
      <tbody>
         <?php foreach ($documents as $document) { ?>
         <tr>
            <td class="left">
               <?php if( file_exists( $document['pdf'] ) ) { ?>
               <a href=" <?php echo HTTP_SERVER.'document/'.$document['document']; ?> ">
                  <?php echo $document['name']; ?>
               </a>
                <?php echo " (". $document['insert_date']  .")" ; ?>
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