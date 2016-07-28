<?php echo $header; ?>
<div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
</div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><h1 class="heading-title"><?php echo $heading_title; ?> <?php echo $report_name; ?> </h1><?php echo $content_top; ?>
	<table class="list">
		<thead>
			<tr>
				<td class="left"><?php echo $text_customer_name; ?></td>
		        <td class="left"><?php echo $text_work_address; ?></td>
		        <td class="left"><?php echo $text_CUI; ?></td>
		        <td class="left"><?php echo $text_product_code; ?></td>
		        <td class="left"><?php echo $text_product_name; ?></td>
		        <td class="left"><?php echo $text_buy_price; ?></td>
		        <td class="left"><?php echo $text_net_sale_price; ?></td>
		        <td class="left"><?php echo $text_product_quantity; ?></td>
		        <td class="left"><?php echo $text_sale_agent_name; ?></td>
		        <td class="left"><?php echo $text_month; ?></td>
			</tr>
		</thead>
	    <tbody>
	    	<?php foreach ($reports as $key => $report) { ?>
	    	<tr>
	    		<td><?php echo $report['customer_name']; ?></td>
	    		<td><?php echo $report['work_address']; ?></td>
	    		<td><?php echo $report['CUI']; ?></td>
	    		<td><?php echo $report['product_code']; ?></td>
	    		<td><?php echo $report['product_name']; ?></td>
	    		<td><?php echo $report['buy_price']; ?></td>
	    		<td><?php echo $report['net_sale_price']; ?></td>
	    		<td><?php echo $report['product_quantity']; ?></td>
	    		<td><?php echo $report['sale_agent_name']; ?></td>
	    		<td><?php echo $report['month']; ?></td>
	    	</tr>
	    	<?php } ?>
	    </tbody>
	</table>
	<div class="buttons">
      <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_back_report_list; ?></a></div>
   </div>
  <?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>