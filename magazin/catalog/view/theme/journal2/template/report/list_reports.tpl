<?php echo $header; ?>
<div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
</div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><h1 class="heading-title"><?php echo $heading_title; ?></h1><?php echo $content_top; ?>
	<?php if ($reports) { ?>
	<table class="list">
		<thead>
			<tr>
				<td class="left"><?php echo $text_report_name; ?></td>
		        <td class="left"><?php echo $text_report_date_added; ?></td>
		        <td class="left"><?php echo $text_view_report; ?></td>
			</tr>
		</thead>
	    <tbody>
	    	<?php foreach ($reports as $report) { ?>
	    	<tr>
				<td><?php echo $report['name']; ?></td>
				<td><?php echo $report['date_added']; ?></td>
				<td><?php if ( !empty($report['view_href']) ) { ?>
	               <a href="<?php echo $report['view_href']; ?>">
	                  <img src="catalog/view/theme/default/image/info.png" alt="<?php echo $button_view_report; ?>" title="<?php echo $button_view_report; ?>" />
	               </a>
	               <?php } ?>
               	</td>
	    	</tr>
	    	<?php } ?>
	    </tbody>
	</table>

	<div class="pagination"><?php echo $pagination; ?></div>
	<?php } else { ?>
	<div class="content"><?php echo $text_empty_report; ?></div>
	<?php } ?>
  <?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>