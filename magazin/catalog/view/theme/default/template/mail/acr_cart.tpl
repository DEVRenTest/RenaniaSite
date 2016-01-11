<table style="border-collapse: collapse; width: 100%; border-top: 1px dotted <?php echo $table_border_color; ?>;  margin-bottom: 20px;">
<tbody>
  <?php foreach ($products as $product) { ?>
  <tr>
	<td style="font-size: 12px; text-align: left; background-color:<?php echo $table_body_bg; ?>; color:<?php echo $table_body_text_color; ?>; border-bottom: 1px dotted <?php echo $table_border_color; ?>; padding: 7px; width: 55px;"><a href="<?php echo $product['href']; ?>" target="blank"><img src="<?php echo $product['image']; ?>" /></a></td>
	<td style="font-size: 12px;	text-align: left; background-color:<?php echo $table_body_bg; ?>; color:<?php echo $table_body_text_color; ?>; border-bottom: 1px dotted <?php echo $table_border_color; ?>; padding: 7px;"><a href="<?php echo $product['href']; ?>" target="blank"><?php echo $product['name']; ?></a>
	<?php foreach ($product['options'] as $option) { ?>
	<br />
	&nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['option_value']; ?></small>
	<?php } ?>
	</td>
	<td style="font-size: 12px;	text-align: left; background-color:<?php echo $table_body_bg; ?>; color:<?php echo $table_body_text_color; ?>; border-bottom: 1px dotted <?php echo $table_border_color; ?>; padding: 7px;"> x <?php echo $product['quantity']; ?></td>
  </tr>
  <?php } ?>
</tbody>
</table>
  
  