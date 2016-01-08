<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><i class="icon-small-module"></i><?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
    <div class="block heading-block">
            	<div class="h1"><?php echo $heading_title; ?></div>
                <div class="h2"><?php echo $heading_slogan; ?></div>
                
       </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <h2><span><?php echo $header_top; ?></span><i class="icon-help" data-help="<?php echo $tooltip_header_top; ?>"></i></h2>
        <table class="list">
          <thead>
          	<tr>
            	<th><?php echo $entry_positions; ?></th>
                <th colspan="3"><?php echo $entry_actions; ?></th>
            </tr>
          </thead>
          <tbody class="header_top">
            <?php $module_row = 0; ?>
            <?php if (isset($modules['header_top'])) { ?>
            <?php foreach ($modules['header_top'] as $module) { ?>
            <tr class="<?php echo $module_row; ?>">
              <td class="slider-bar-wrap"><?php $module_col = 0; $values=""; $sum=0; ?>
                <?php foreach ($module as $slide) { ?>

                <input type="text" class="no-input-style <?php echo $module_col; ?>" name="d_extra_positions_unlimited_widget[header_top][<?php echo $module_row; ?>][<?php echo $module_col; ?>]" value="<?php echo $slide; ?>" style="margin-left:<?php echo $sum + ($slide/2)-2; ?>%"/>
                <?php if ($module_col<count($module)-1) {$sum+=$slide; $values.=$sum;} if ($module_col<count($module)-2) $values.=','; ?>
                <?php $module_col++;} ?>
                <div id="slider_header_top<?php echo $module_row; ?>"></div></td>
              <td class="right"><a class="button delcol" onclick="delcol('header_top', <?php echo $module_row; ?>)"><?php echo $button_delcol; ?></a></td>
              <td class="right"><a class="button addcol" onclick="addcol('header_top', <?php echo $module_row; ?>);"><?php echo $button_addcol; ?></a></td>
              <td class="right"><a class="button delrow" onclick="delrow('header_top', <?php echo $module_row; ?>);"><?php echo $button_delrow; ?></a></td>
            </tr>
            <script>
			$('tr.<?php echo $module_row; ?> div#slider_header_top<?php echo $module_row; ?>').slider({
				min: 1, 
				max: 99, 
				values: [<?php echo $values; ?>], 
				range: false, 
				stop: function(event, ui) {
					moveSlider('header_top', <?php echo $module_row; ?>, ui.values); 
				}, 
				slide: function(event, ui){
					moveSlider('header_top', <?php echo $module_row; ?>, ui.values);
				}
			});
            </script>
            <?php if ($module_col==1) { ?>
            <script>
				$('tbody.header_top tr.<?php echo $module_row; ?> #slider_header_top<?php echo $module_row; ?> a.ui-slider-handle').css("display", "none");
            </script>
            <?php } ?>
            <?php $module_row++;} } ?>
            <tr class="info">
              <td colspan="3"></td>
              <td class="right"><a class="button addrow" onclick="addrow('header_top');"><?php echo $button_addrow; ?></a></td>
            </tr>
          </tbody>
          </table>
          <h2><span><?php echo $header_bottom; ?></span><i class="icon-help" data-help="<?php echo $tooltip_header_bottom; ?>"></i></h2>
          <table class="list">
          <thead>
          	<tr>
            	<th><?php echo $entry_positions; ?></th>
                <th colspan="3"><?php echo $entry_actions; ?></th>
            </tr>
          </thead>
          <tbody class="header_bottom">
            <?php $module_row = 0; ?>
            <?php if (isset($modules['header_bottom'])) { ?>
            <?php foreach ($modules['header_bottom'] as $module) { ?>
            <tr class="<?php echo $module_row; ?>">
              <td class="slider-bar-wrap"><?php $module_col = 0; $values=""; $sum=0; ?>
                <?php foreach ($module as $slide) { ?>
                <input type="text" class="no-input-style <?php echo $module_col; ?>" name="d_extra_positions_unlimited_widget[header_bottom][<?php echo $module_row; ?>][<?php echo $module_col; ?>]" value="<?php echo $slide; ?>" style="margin-left:<?php echo $sum + ($slide/2)-2; ?>%"/>
                <?php if ($module_col<count($module)-1) {$sum+=$slide; $values.=$sum;} if ($module_col<count($module)-2) $values.=','; ?>
                <?php $module_col++;} ?>
                <div id="slider_header_bottom<?php echo $module_row; ?>"></div></td>
              <td class="right"><a class="button delcol" onclick="delcol('header_bottom', <?php echo $module_row; ?>)"><?php echo $button_delcol; ?></a></td>
              <td class="right"><a class="button addcol" onclick="addcol('header_bottom', <?php echo $module_row; ?>);"><?php echo $button_addcol; ?></a></td>
              <td class="right"><a class="button delrow" onclick="delrow('header_bottom', <?php echo $module_row; ?>);"><?php echo $button_delrow; ?></a></td>
            </tr>
            <script>
			$('tr.<?php echo $module_row; ?> div#slider_header_bottom<?php echo $module_row; ?>').slider({
					  min: 1, 
					  max: 99,
					  values: [<?php echo $values; ?>], 
					  range: false, 
					  stop: function(event, ui) {
						  moveSlider('header_bottom', <?php echo $module_row; ?>, ui.values);
						  }, 
					  slide: function(event, ui){
						  moveSlider('header_bottom', <?php echo $module_row; ?>, ui.values);
						  }
					  });
            </script>
            <?php if ($module_col==1) { ?>
            <script>
			$('tbody.header_bottom tr.<?php echo $module_row; ?> #slider_header_bottom<?php echo $module_row; ?> a.ui-slider-handle').css("display", "none"); 
            </script>
            <?php } ?>
            <?php $module_row++;} } ?>
            <tr class="info">
              <td colspan="3"></td>
              <td class="right"><a class="button addrow" onclick="addrow('header_bottom');"><?php echo $button_addrow; ?></a></td>
            </tr>
          </tbody>
          </table>
          <h2><span><?php echo $footer_top; ?></span><i class="icon-help" data-help="<?php echo $tooltip_footer_top; ?>"></i></h2>
          <table class="list">
          <thead>
          	<tr>
            	<th><?php echo $entry_positions; ?></th>
                <th colspan="3"><?php echo $entry_actions; ?></th>
            </tr>
          </thead>
          <tbody class="footer_top">
            <?php $module_row = 0; ?>
            <?php if (isset($modules['footer_top'])) { ?>
            <?php foreach ($modules['footer_top'] as $module) { ?>
            <tr class="<?php echo $module_row; ?>">
              <td class="slider-bar-wrap"><?php $module_col = 0; $values=""; $sum=0; ?>
                <?php foreach ($module as $slide) { ?>
                <input type="text" class="no-input-style <?php echo $module_col; ?>" name="d_extra_positions_unlimited_widget[footer_top][<?php echo $module_row; ?>][<?php echo $module_col; ?>]" value="<?php echo $slide; ?>" style="margin-left:<?php echo $sum + ($slide/2)-2; ?>%"/>
                <?php if ($module_col<count($module)-1) {$sum+=$slide; $values.=$sum;} if ($module_col<count($module)-2) $values.=','; ?>
                <?php $module_col++;} ?>
                <div id="slider_footer_top<?php echo $module_row; ?>"></div></td>
              <td class="right"><a class="button delcol" onclick="delcol('footer_top', <?php echo $module_row; ?>)"><?php echo $button_delcol; ?></a></td>
              <td class="right"><a class="button addcol" onclick="addcol('footer_top', <?php echo $module_row; ?>);"><?php echo $button_addcol; ?></a></td>
              <td class="right"><a class="button delrow" onclick="delrow('footer_top', <?php echo $module_row; ?>);"><?php echo $button_delrow; ?></a></td>
            </tr>
            <script>
			$('tr.<?php echo $module_row; ?> div#slider_footer_top<?php echo $module_row; ?>').slider({
				min: 1, 
				max: 99, 
				values: [<?php echo $values; ?>], 
				range: false, 
				stop: function(event, ui) {
					moveSlider('footer_top', <?php echo $module_row; ?>, ui.values);
				}, 
				slide: function(event, ui){
					moveSlider('footer_top', <?php echo $module_row; ?>, ui.values);
				}
			});
            </script>
            <?php if ($module_col==1) { ?>
            <script>
			$('tbody.footer_top tr.<?php echo $module_row; ?> #slider_footer_top<?php echo $module_row; ?> a.ui-slider-handle').css("display", "none");
            </script>
            <?php } ?>
            <?php $module_row++;} } ?>
            <tr class="info">
              <td colspan="3"></td>
              <td class="right"><a class="button addrow" onclick="addrow('footer_top');"><?php echo $button_addrow; ?></a></td>
            </tr>
          </tbody>
          </table>
          <h2><span><?php echo $footer_bottom; ?></span><i class="icon-help" data-help="<?php echo $tooltip_footer_bottom; ?>"></i></h2>
          <table class="list">
          <thead>
          	<tr>
            	<th><?php echo $entry_positions; ?></th>
                <th colspan="3"><?php echo $entry_actions; ?></th>
            </tr>
          </thead>
          <tbody class="footer_bottom">
            <?php $module_row = 0; ?>
            <?php if (isset($modules['footer_bottom'])) { ?>
            <?php foreach ($modules['footer_bottom'] as $module) { ?>
            <tr class="<?php echo $module_row; ?>">
              <td class="slider-bar-wrap"><?php $module_col = 0; $values=""; $sum=0; ?>
                <?php foreach ($module as $slide) { ?>
                <input type="text" class="no-input-style <?php echo $module_col; ?>" name="d_extra_positions_unlimited_widget[footer_bottom][<?php echo $module_row; ?>][<?php echo $module_col; ?>]" value="<?php echo $slide; ?>" style="margin-left:<?php echo $sum + ($slide/2)-2; ?>%"/>
                <?php if ($module_col<count($module)-1) {$sum+=$slide; $values.=$sum;} if ($module_col<count($module)-2) $values.=','; ?>
                <?php $module_col++;} ?>
                <div id="slider_footer_bottom<?php echo $module_row; ?>"></div></td>
              <td class="right"><a class="button delcol" onclick="delcol('footer_bottom', <?php echo $module_row; ?>)"><?php echo $button_delcol; ?></a></td>
              <td class="right"><a class="button addcol" onclick="addcol('footer_bottom', <?php echo $module_row; ?>);"><?php echo $button_addcol; ?></a></td>
              <td class="right"><a class="button delrow" onclick="delrow('footer_bottom', <?php echo $module_row; ?>);"><?php echo $button_delrow; ?></a></td>
            </tr>
            <script>
			$('tr.<?php echo $module_row; ?> div#slider_footer_bottom<?php echo $module_row; ?>').slider({
				min: 1,
				max: 99,
				values: [<?php echo $values; ?>], 
				range: false, 
				stop: function(event, ui) {
					moveSlider('footer_bottom', <?php echo $module_row; ?>, ui.values);
				}, 
				slide: function(event, ui){
					moveSlider('footer_bottom', <?php echo $module_row; ?>, ui.values);
				}
			});</script>
            <?php if ($module_col==1) { ?>
            <script>
			$('tbody.footer_bottom tr.<?php echo $module_row; ?> #slider_footer_bottom<?php echo $module_row; ?> a.ui-slider-handle').css("display", "none");
            </script>
            <?php } ?>
            <?php $module_row++;} } ?>
            <tr class="info">
              <td colspan="3"></td>
              <td class="right"><a class="button addrow" onclick="addrow('footer_bottom');"><?php echo $button_addrow; ?></a></td>
            </tr>
          </tbody>
        </table>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">

var i=0, j=0, k=0;	

var module_row = new Array(); 
module_row['header_top']=0; 
module_row['header_bottom']=0; 
module_row['footer_top']=0;
module_row['footer_bottom']=0;

var module_col = new Array(); 
module_col['header_top']=new Array(); 
module_col['header_bottom']=new Array(); 
module_col['footer_top']=new Array(); 
module_col['footer_bottom']=new Array(); 

for(i=0;i<20;i++) {
	module_col['header_top'][i]=0; 
	module_col['header_bottom'][i]=0; 
	module_col['footer_top'][i]=0; 
	module_col['footer_bottom'][i]=0;
}

var slide = new Array(); 
slide['header_top']=new Array(); 
slide['header_bottom']=new Array(); 
slide['footer_top']=new Array(); 
slide['footer_bottom']=new Array(); 

for(i=0;i<20;i++) {
	slide['header_top'][i]=new Array(); 
	slide['header_bottom'][i]=new Array(); 
	slide['footer_top'][i]=new Array(); 
	slide['footer_bottom'][i]=new Array(); 
	
	for(j=0;j<20;j++) {
		slide['header_top'][i][j]=0; 
		slide['header_bottom'][i][j]=0;
		slide['footer_top'][i][j]=0; 
		slide['footer_bottom'][i][j]=0;
	}
}

<?php foreach ($modules as $key => $module_pos) { ?>

	module_row['<?php echo $key; ?>']=<?php echo count($module_pos); ?>;
	<?php $module_row = 0; ?>
	<?php foreach ($module_pos as $module) { ?>
		module_col['<?php echo $key; ?>'][<?php echo $module_row; ?>]=<?php echo count($module)-1;?>;
		<?php $module_row++; } ?>
<?php } ?>


/*
*	Adds rows to the positions
*/
function addrow(position) {
	var html = "";
	
	html += '<tr class="'+module_row[position]+'"><td class="slider-bar-wrap"><input type="text" class="no-input-style 0" name="d_extra_positions_unlimited_widget['+position+']['+module_row[position]+'][0]" value="100" style="margin-left:'+((50-2))+'%"/>';
	html += '<div id="slider_'+position+module_row[position]+'"></div>';
	html += '</td>';
	html += '<td class="right"><a class="button delcol" onclick="delcol(\''+position+'\', '+module_row[position]+');"><?php echo $button_delcol; ?></a></td>';
	html += '<td class="right"><a class="button addcol" onclick="addcol(\''+position+'\', '+module_row[position]+');"><?php echo $button_addcol; ?></a></td>';
	html += '<td class="right"><a class="button delrow" onclick="delrow(\''+position+'\', '+module_row[position]+');"><?php echo $button_delrow; ?></a></td></tr>';
	html += '<script>$(\'tr.'+module_row[position]+' div#slider_'+position+module_row[position]+'\').slider({min: 1, max: 99, range: false});<\/script>';
	
	$('#form tbody.'+position+' .info').before(html);
	
	$('tbody.'+position+' tr.'+module_row[position]+' #slider_'+position+module_row[position]+' a.ui-slider-handle').css("display", "none");
	module_row[position]++;
}

/*
*	Deletes rows from the positions
*/
function delrow(position, row) {
	$('tbody.'+position+' tr.'+row).remove();
	module_row[position]--;
}

/*
*	Adds columns to the row
*/
function addcol(position, row) {
	var x = $('tbody.'+position+' tr.'+row).next();
	$('tbody.'+position+' tr.'+row).remove();
	module_col[position][row]++;
	
	var html=""; 
	var values="";
	
	html += '<tr class="'+row+'"><td class="slider-bar-wrap">';
	
	for(i=0;i<module_col[position][row];i++) {
		j=Math.round(100/(module_col[position][row]+1));
		slide[position][row][i]=j*(i+1);
		values +=slide[position][row][i]; 
		if (i<module_col[position][row]-1) values+=',';
		if (i==0) k=0; else k=1;
		html += '<input type="text" class="no-input-style '+i+'" name="d_extra_positions_unlimited_widget['+position+']['+row+']['+i+']" value="' + j + '" style="margin-left:' +(j*(i+0.5)-2) +'%"/>';
	}
	
	j=100-(Math.round(100/(module_col[position][row]+1))*module_col[position][row]);
	
	html += '<input type="text" class="no-input-style '+module_col[position][row]+'" name="d_extra_positions_unlimited_widget['+position+']['+row+']['+module_col[position][row]+']" value="'+j+'" style="margin-left:'+(j*(i+0.5)-2)+'%"/>';
	html += '<div id="slider_'+position+row+'"></div>';
	html += '</td>';
	html += '<td class="right"><a class="button delcol" onclick="delcol(\''+position+'\', '+row+');"><?php echo $button_delcol; ?></a></td>';
	html += '<td class="right"><a class="button addcol" onclick="addcol(\''+position+'\', '+row+');"><?php echo $button_addcol; ?></a></td>';
	html += '<td class="right"><a class="button delrow" onclick="delrow(\''+position+'\', '+row+');"><?php echo $button_delrow; ?></a></td></tr>';
	html += '<script>$(\'tr.'+row+' div#slider_'+position+row+'\').slider({min: 1, max: 99, values: ['+values+'], range: false, stop: function(event, ui) {moveSlider(\''+position+'\', '+row+', ui.values);}, slide: function(event, ui){moveSlider(\''+position+'\', '+row+', ui.values);}});<\/script>';
	
	x.before(html);
	$('tbody.'+position+' tr.'+row+' #slider_'+position+row+' a.ui-slider-handle').css("display", "block");	
}

/*
*	Deletes column from the row
*/
function delcol(position, row) {
	if (module_col[position][row]>0) {
		var x=$('tbody.'+position+' tr.'+row).next();
		$('tbody.'+position+' tr.'+row).remove();
		module_col[position][row]--;
		
		var html=""; 
		var values="";
		
		html += '<tr class="'+row+'"><td class="slider-bar-wrap">';
		for(i=0;i<module_col[position][row];i++) {
			j=Math.round(100/(module_col[position][row]+1));
			slide[position][row][i]=j*(i+1);
			values += slide[position][row][i]; 
			if (i<module_col[position][row]-1) values+=',';
			html+= '<input type="text" class="no-input-style '+i+'" name="d_extra_positions_unlimited_widget['+position+']['+row+']['+i+']" value="'+j+'" style="margin-left:'+(j*(i+0.5)-2)+'%"/>';
		}
	
	j=100-(Math.round(100/(module_col[position][row]+1))*module_col[position][row]);
	html += '<input type="text" class="no-input-style '+module_col[position][row]+'" name="d_extra_positions_unlimited_widget['+position+']['+row+']['+module_col[position][row]+']" value="'+j+'" style="margin-left:'+(j*(i+0.5)-2)+'%"/>';
	html += '<div id="slider_'+position+row+'"></div>';
	html += '</td>';
	html += '<td class="right"><a class="button delcol" onclick="delcol(\''+position+'\', '+row+');"><?php echo $button_delcol; ?></a></td>';
	html += '<td class="right"><a class="button addcol" onclick="addcol(\''+position+'\', '+row+');"><?php echo $button_addcol; ?></a></td>';
	html += '<td class="right"><a class="button delrow" onclick="delrow(\''+position+'\', '+row+');"><?php echo $button_delrow; ?></a></td></tr>';
	html += '<script>$(\'tr.'+row+' div#slider_'+position+row+'\').slider({min: 1, max: 99, values: ['+values+'], range: false, stop: function(event, ui) {moveSlider(\''+position+'\', '+row+', ui.values);}, slide: function(event, ui){moveSlider(\''+position+'\', '+row+', ui.values);}});<\/script>';
	
	x.before(html);
	if (module_col[position][row]==0) $('tbody.'+position+' tr.'+row+' #slider_'+position+row+' a.ui-slider-handle').css("display", "none");
	}	
}

/*
*	Dragging the scroller function
*/
function moveSlider(position, row, values) {

	for(i=0;i<module_col[position][row];i++) {
		slide[position][row]=values;
		//slide[position][row][i]=$('tbody.'+position+' tr.'+row+' #slider_'+position+row).slider("values",i);
		
		if (i>0) {
			if (slide[position][row][i]<=slide[position][row][i-1]) slide[position][row][i]=slide[position][row][i-1]+1; 
			$('tbody.'+position+' tr.'+row+' #slider_'+position+row).slider("values",i,slide[position][row][i]);
		}
		
		/*if (i<module_col[position][row]-1) {
			if (slide[position][row][i]>=slide[position][row][i+1]) slide[position][row][i]=slide[position][row][i+1]-1; 
			$('tbody.'+position+' tr.'+row+' #slider_'+position+row).slider("values",i,slide[position][row][i]);
		}*/
		
		if (i==0) $('tbody.'+position+' tr.'+row+' input.'+i).val(slide[position][row][i]);
		else $('tbody.'+position+' tr.'+row+' input.'+i).val(slide[position][row][i]-slide[position][row][i-1]);
		
		$('tbody.'+position+' tr.'+row+' input.'+i).css("margin-left", (slide[position][row][i]-$('tbody.'+position+' tr.'+row+' input.'+i).val()/2-2) + '%');
	}
	$('tbody.'+position+' tr.'+row+' input.'+module_col[position][row]).val(100-slide[position][row][module_col[position][row]-1]);
	$('tbody.'+position+' tr.'+row+' input.'+module_col[position][row]).css("margin-left", (100-$('tbody.'+position+' tr.'+row+' input.'+module_col[position][row]).val()/2-2)+'%');	

}		

</script>
<?php echo $footer; ?>