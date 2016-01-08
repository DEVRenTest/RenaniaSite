<?php
class ModelCatalogDExtraPositionsUnlimited extends Model {
	public function getExtraPositions(&$modules) {
			
			$arr_pos=$this->config->get("d_extra_positions_unlimited_widget");
			//$arr_pos=array(); $i=0; foreach($arr as $val) {$arr_pos[$i]=$val; $i++;}
			$this->load->language('module/d_extra_positions_unlimited');
			$text_column_header_top = $this->language->get('text_column_header_top');
			$text_column_header_bottom = $this->language->get('text_column_header_bottom');
			$text_column_footer_top = $this->language->get('text_column_footer_top');
			$text_column_footer_bottom = $this->language->get('text_column_footer_bottom');
			$text_row=$this->language->get('text_row');
			$text_col=$this->language->get('text_col');
			
			foreach($modules as &$module) {
			$html="";
			if (isset($module['position'])) {
				
				if (isset($arr_pos['header_top'])) { $i=0;
				foreach($arr_pos['header_top'] as $row) {$j=0;
				foreach($row as $col) {
					if ($module['position']=="column_header_top_row".$i."_col".$j) {$html.='<option value="column_header_top_row'.$i.'_col'.$j.'" selected="selected">'.$text_column_header_top.' '.$text_row.($i+1).' '.$text_col.($j+1).'</option>';}
					else {$html.='<option value="column_header_top_row'.$i.'_col'.$j.'">'.$text_column_header_top.' '.$text_row.($i+1).' '.$text_col.($j+1).'</option>';}
					$j++;
				}
				$i++;
				}
				}
				
				if (isset($arr_pos['header_bottom'])) { $i=0;
				foreach($arr_pos['header_bottom'] as $row) {$j=0;
				foreach($row as $col) {
					if ($module['position']=="column_header_bottom_row".$i."_col".$j) {$html.='<option value="column_header_bottom_row'.$i.'_col'.$j.'" selected="selected">'.$text_column_header_bottom.' '.$text_row.($i+1).' '.$text_col.($j+1).'</option>';}
					else {$html.='<option value="column_header_bottom_row'.$i.'_col'.$j.'">'.$text_column_header_bottom.' '.$text_row.($i+1).' '.$text_col.($j+1).'</option>';}
					$j++;
				}
				$i++;
				}
				}
				
				if (isset($arr_pos['footer_top'])) { $i=0;
				foreach($arr_pos['footer_top'] as $row) {$j=0;
				foreach($row as $col) {
					if ($module['position']=="column_footer_top_row".$i."_col".$j) {$html.='<option value="column_footer_top_row'.$i.'_col'.$j.'" selected="selected">'.$text_column_footer_top.' '.$text_row.($i+1).' '.$text_col.($j+1).'</option>';}
					else {$html.='<option value="column_footer_top_row'.$i.'_col'.$j.'">'.$text_column_footer_top.' '.$text_row.($i+1).' '.$text_col.($j+1).'</option>';}
					$j++;
				}
				$i++;
				}
				}
				
				if (isset($arr_pos['footer_bottom'])) { $i=0;
				foreach($arr_pos['footer_bottom'] as $row) {$j=0;
				foreach($row as $col) {
					if ($module['position']=="column_footer_bottom_row".$i."_col".$j) {$html.='<option value="column_footer_bottom_row'.$i.'_col'.$j.'" selected="selected">'.$text_column_footer_bottom.' '.$text_row.($i+1).' '.$text_col.($j+1).'</option>';}
					else {$html.='<option value="column_footer_bottom_row'.$i.'_col'.$j.'">'.$text_column_footer_bottom.' '.$text_row.($i+1).' '.$text_col.($j+1).'</option>';}
					$j++;
				}
				$i++;
				}
				}
                  
			$module['extra_position_html']=$html;
			}
			}
			
			$js="";
			if (isset($arr_pos['header_top'])) {$i=0;
			foreach($arr_pos['header_top'] as $row) {$j=0;
			foreach($row as $col) {
				$js.='<option value="column_header_top_row'.$i.'_col'.$j.'">'.$text_column_header_top.' '.$text_row.($i+1).' '.$text_col.($j+1).'</option>';
				$j++;
			}
			$i++;
			}
			}
			if (isset($arr_pos['header_bottom'])) { $i=0;
			foreach($arr_pos['header_bottom'] as $row) {$j=0;
			foreach($row as $col) {
				$js.='<option value="column_header_bottom_row'.$i.'_col'.$j.'">'.$text_column_header_bottom.' '.$text_row.($i+1).' '.$text_col.($j+1).'</option>';
				$j++;
			}
			$i++;
			}
			}
			if (isset($arr_pos['footer_top'])) { $i=0;
			foreach($arr_pos['footer_top'] as $row) {$j=0;
			foreach($row as $col) {
				$js.='<option value="column_footer_top_row'.$i.'_col'.$j.'">'.$text_column_footer_top.' '.$text_row.($i+1).' '.$text_col.($j+1).'</option>';
				$j++;
			}
			$i++;
			}
			}
			if (isset($arr_pos['footer_bottom'])) { $i=0;
			foreach($arr_pos['footer_bottom'] as $row) {$j=0;
			foreach($row as $col) {
				$js.='<option value="column_footer_bottom_row'.$i.'_col'.$j.'">'.$text_column_footer_bottom.' '.$text_row.($i+1).' '.$text_col.($j+1).'</option>';
				$j++;
			}
			$i++;
			}
			}
			return $js;
			
	}
	
}
?>