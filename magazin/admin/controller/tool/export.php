<?php 
class ControllerToolExport extends Controller { 
	private $error = array();
  
  const IMPORT_TYPE_BACKUP = "import_backup";
  const IMPORT_TYPE_PRODUCT = "import_csv_p";
  const IMPORT_TYPE_PRODUCT_OPTION = "import_csv_p_o";
  const IMPORT_TYPE_PRODUCT_O_COMBINATION = "import_csv_p_o_c";
  
	public function index()
  {
		$this->load->language( 'tool/export' );
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('tool/export');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			if ((isset( $this->request->files['upload'] )) && (is_uploaded_file($this->request->files['upload']['tmp_name']))) {
				$file = $this->request->files['upload']['tmp_name'];
        /*balazs*/
        if( empty( $_POST["import_type_radio"] ) || $_POST["import_type_radio"] == self::IMPORT_TYPE_BACKUP )
        {
            if ($this->model_tool_export->upload($file)===TRUE)
            {
                $this->session->data['success'] = $this->language->get('text_success');
                $this->redirect($this->url->link('tool/export', 'token=' . $this->session->data['token'], 'SSL'));
            }
            else
            {
                $this->error['warning'] = $this->language->get('error_upload');
            }
        }
        elseif( $_POST["import_type_radio"] == self::IMPORT_TYPE_PRODUCT )
        {
            $this->upload_CSV_Product( $file );
        }
        elseif( $_POST["import_type_radio"] == self::IMPORT_TYPE_PRODUCT_OPTION )
        {
            $this->upload_CSV_ProductOption( $file );
        }
        elseif( $_POST["import_type_radio"] == self::IMPORT_TYPE_PRODUCT_O_COMBINATION )
        {
            $this->upload_CSV_ProductOptionCombination( $file );
        }
        
        /*end balazs*/
			}
		}

		if (!empty($this->session->data['export_error']['errstr'])) {
			$this->error['warning'] = $this->session->data['export_error']['errstr'];
			if (!empty($this->session->data['export_nochange'])) {
				$this->error['warning'] .= '<br />'.$this->language->get( 'text_nochange' );
			}
			$this->error['warning'] .= '<br />'.$this->language->get( 'text_log_details' );
		}
		unset($this->session->data['export_error']);
		unset($this->session->data['export_nochange']);

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['entry_restore'] = $this->language->get('entry_restore');
    
		$this->data['entry_imp_prod']         = $this->language->get('entry_imp_prod');
		$this->data['entry_imp_prod_o']       = $this->language->get('entry_imp_prod_o');
		$this->data['entry_imp_prod_o_comb']  = $this->language->get('entry_imp_prod_o_comb');
    
    $this->data['const_imp_backup']       = self::IMPORT_TYPE_BACKUP;
    $this->data['const_imp_prod']         = self::IMPORT_TYPE_PRODUCT;
    $this->data['const_imp_prod_o']       = self::IMPORT_TYPE_PRODUCT_OPTION;
    $this->data['const_imp_prod_o_c']     = self::IMPORT_TYPE_PRODUCT_O_COMBINATION;		
    
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['button_import'] = $this->language->get('button_import');
		$this->data['button_export'] = $this->language->get('button_export');
		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['error_select_file'] = $this->language->get('error_select_file');
		$this->data['error_post_max_size'] = str_replace( '%1', ini_get('post_max_size'), $this->language->get('error_post_max_size') );
		$this->data['error_upload_max_filesize'] = str_replace( '%1', ini_get('upload_max_filesize'), $this->language->get('error_upload_max_filesize') );

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => FALSE
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tool/export', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		
		$this->data['action'] = $this->url->link('tool/export', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['export'] = $this->url->link('tool/export/download', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['post_max_size'] = $this->return_bytes( ini_get('post_max_size') );
		$this->data['upload_max_filesize'] = $this->return_bytes( ini_get('upload_max_filesize') );

		$this->template = 'tool/export.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
		$this->response->setOutput($this->render());
	}


	function return_bytes($val)
	{
		$val = trim($val);
	
		switch (strtolower(substr($val, -1)))
		{
			case 'm': $val = (int)substr($val, 0, -1) * 1048576; break;
			case 'k': $val = (int)substr($val, 0, -1) * 1024; break;
			case 'g': $val = (int)substr($val, 0, -1) * 1073741824; break;
			case 'b':
				switch (strtolower(substr($val, -2, 1)))
				{
					case 'm': $val = (int)substr($val, 0, -2) * 1048576; break;
					case 'k': $val = (int)substr($val, 0, -2) * 1024; break;
					case 'g': $val = (int)substr($val, 0, -2) * 1073741824; break;
					default : break;
				} break;
			default: break;
		}
		return $val;
	}


	public function download() {
		if ($this->validate()) {

			// send the categories, products and options as a spreadsheet file
			$this->load->model('tool/export');
			$this->model_tool_export->download();
			$this->redirect( $this->url->link( 'tool/export', 'token='.$this->request->get['token'], 'SSL' ) );

		} else {

			// return a permission error page
			return $this->forward('error/permission');
		}
	}


	private function validate() {
		if (!$this->user->hasPermission('modify', 'tool/export')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
  
  function upload_CSV_Product( $filename )
  {
		// we use our own error handler
		global $registry;
		$registry = $this->registry;
		set_error_handler('error_handler_for_export',E_ALL);
		register_shutdown_function('fatal_error_shutdown_handler_for_export');

		try {
			$database =& $this->db;
      
			$this->session->data['export_nochange'] = 1;
      
      $file = fopen( $filename, "r") or exit("Unable to open file!");
      $sqlCounter = 0;
      $sqlTotalCounter = 0;
      $sql = "";
      while(!feof($file))
      {
         $line = fgets($file);
         
         if( !( preg_match( "/^([0-9]*);.+;([0-9]*);([0-9]*);(.+);([0-9\.,]*);([0-9a-zA-Z\. ]*);([0-9]*);([0-9]*);(.*)$/i", $line ) == FALSE ) )
         {
            $line2 = preg_replace( 
                    "/([0-9]*);.+;([0-9]*);([0-9]*);(.+);([0-9\.,]*);([0-9a-zA-Z\. ]*);([0-9]*);([0-9]*);(.*)/i",
                    "UPDATE `oc_product` SET `price` = '$6', `quantity` = '$7', `stock_status_limits` = '[\"0\",\"$8\",\"$8\"]' WHERE `upc` = '$4';",
                    $line
            );
            $line3 = preg_replace( 
                    "/(')la cerere(', `quantity` = ')[0-9]+(', `stock_status_limits` = '\[\"0\",\")[0-9]+(\",\")[0-9]+(\"\]')/i",
                    '${1}0${2}0${3}0${4}0$5',
                    $line2
            );

            $sql .= $line3 . "\n";         

            if( $sqlCounter > 50 )
            {               
               $this->multiquery( $database, $sql );
               $sql = "";
               $sqlCounter = 0;
            }
            $sqlCounter++;   
            $sqlTotalCounter++;
         }
         else
         {
            if( empty( $this->error['warning'] ) )
            {
                $this->error['warning'] = "";
            }
            if( ! empty( $line ) )
            {
                $this->error['warning'] .=  "Not valid row: ".$line."<br>";
            }
         }
           
      }
      fclose($file);
      
      if( empty( $this->session->data['success'] ) )
      {
          $this->session->data['success'] = "";
      }
      $this->session->data['success'] .=  $sqlTotalCounter." product affected.<br>";
      
      $this->session->data['export_nochange'] = 0;
      
			return TRUE;
      
		} catch (Exception $e) {
			$errstr = $e->getMessage();
			$errline = $e->getLine();
			$errfile = $e->getFile();
			$errno = $e->getCode();
			$this->session->data['export_error'] = array( 'errstr'=>$errstr, 'errno'=>$errno, 'errfile'=>$errfile, 'errline'=>$errline );
			if ($this->config->get('config_error_log')) {
				$this->log->write('PHP ' . get_class($e) . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
			}
			return FALSE;
		}
	}
  
  private function upload_CSV_ProductOption( $filename )
  {
		// we use our own error handler
		global $registry;
		$registry = $this->registry;
		set_error_handler('error_handler_for_export',E_ALL);
		register_shutdown_function('fatal_error_shutdown_handler_for_export');

		try {
			$database =& $this->db;
      
      if( empty( $this->error['warning'] ) )
      {
          $this->error['warning'] = "";
      }
      
			$this->session->data['export_nochange'] = 1;
      
      $file = fopen( $filename, "r") or exit("Unable to open file!");
      
      $sqlTotalCounter = 0;
      
      $stockCollector = array();
      
      while(!feof($file))
      {
         $line = fgets($file);
         
         $explodedLine = explode( ";", $line );
         
         $sqlTotalCounter += ( $this->processLineForOptionUpdate( $database, $explodedLine ) ? 1 : 0 );
         
         if( $this->validateLineForOptionUpdate( $explodedLine ) )
          {
              $productId    = $explodedLine[0];
              $pret         = $explodedLine[5];
              $stock        = $explodedLine[6];
              
              $this->updateStockCollectorArray( $stockCollector, $productId, $pret, $stock );  
          }
      }
      fclose($file);
      
      $this->applyCollectedStockToDatabase( $database, $stockCollector );
      
      if( empty( $this->session->data['success'] ) )
      {
          $this->session->data['success'] = "";
      }
      $this->session->data['success'] .=  $sqlTotalCounter." product affected.<br>";
      
      $this->session->data['export_nochange'] = 0;
      
			return TRUE;
      
		} catch (Exception $e) {
			$errstr = $e->getMessage();
			$errline = $e->getLine();
			$errfile = $e->getFile();
			$errno = $e->getCode();
			$this->session->data['export_error'] = array( 'errstr'=>$errstr, 'errno'=>$errno, 'errfile'=>$errfile, 'errline'=>$errline );
			if ($this->config->get('config_error_log')) {
				$this->log->write('PHP ' . get_class($e) . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
			}
			return FALSE;
		}
	}
  
  private function validateLineForOptionUpdate( $explodedLine )
  {
      if( count( $explodedLine ) == 9 && is_numeric($explodedLine[0]) )
      {
          return TRUE;
      }
      else
      {
          return FALSE;
      }
  }     
  
  private function processLineForOptionUpdate( &$database, $explodedLine )
  {
      if( $this->validateLineForOptionUpdate( $explodedLine ) )
      {

         $productId  = $explodedLine[0];
         $code       = $explodedLine[1];
         $denumire   = $explodedLine[2];
         $optionId   = $explodedLine[3];
         $marime     = $explodedLine[4];
         $pret       = $explodedLine[5];
         $stock      = $explodedLine[6];
         $stockMinim = $explodedLine[7];
         $stockInfo  = $explodedLine[8];   

         $o_v_id  = $this->getOptionValueIdByOptionAndName( $database, $optionId, $marime );
         
         if( $o_v_id )
         {
             if( ! is_numeric( $pret ) )
             {
                 $pret = 0;
                 $stock = 0;
             }            
             
             $originalPret = $this->getPriceOfProductById( $database, $productId );

             $pret -= $originalPret;
             
             $insertNeeded = ! $this->updateOptionRow( $database, $productId, $optionId, $stock, $pret, $o_v_id );

             // if no update then insert in affected tables
             if( $insertNeeded )
             {
                 if( ! $this->insertProductOptionAndOptionValue( $database, $productId, $optionId, $o_v_id, $stock, $pret ) )
                 {
                     return FALSE;
                 }
             }
             return TRUE;
         }
         else
         {
             $this->error['warning'] .=  "\"Not valid row: ".implode( ";", $explodedLine )."\" -> combination: `option_id` = '".$optionId."' AND `name` LIKE '".$marime."' not exists in database! <br>";
             return FALSE;
         }                 

      }
      else
      {            
         if( ! empty( $line ) )
         {
             $this->error['warning'] .=  "Not valid row: ".$line."<br>";
             return FALSE;
         }
      }
  }        
    
  private function updateOptionRow( &$database, $productId, $optionId, $stock, $pret, $o_v_id )
  {
      $price_prefix = "+";
      if( $pret < 0 )
      {
          $pret *= -1;
          $price_prefix = "-";
      }
    
      $updateSQL = "UPDATE `oc_product_option_value` SET"
                  ." `quantity` = '".$stock."',"
                  ." `price` = '".$pret."',"
                  ." `price_prefix` = '".$price_prefix."'"
                  ." WHERE `product_id` = '".$productId."' AND `option_value_id` = '".$o_v_id."'"
                  ." AND `option_id` = '".$optionId."'";
                
      $query  = $database->query( $updateSQL );
      
      $insertNeeded = FALSE;
      if( $database->countAffected() <= 0 )
      {
          if( ! $this->productHasOptionWithValue( $database, $productId, $o_v_id, $optionId ) )
          {
              $insertNeeded = TRUE;
          }
      }
      return ! $insertNeeded;
  }
  
  private function productHasOptionWithValue( &$database, $productId, $o_v_id, $optionId )
  {
      $sqlForCheck = "SELECT * FROM `oc_product_option_value`"
              . " WHERE `product_id` = '".$productId."' AND `option_value_id` = '".$o_v_id."'"
              ." AND `option_id` = '".$optionId."'";

      $queryForCheck  = $database->query( $sqlForCheck );
      if( $queryForCheck->num_rows == 0 )
      {
          return FALSE;
      }
      return TRUE;
  }
  
  function insertProductOptionAndOptionValue( &$database, $productId, $optionId, $o_v_id, $stock, $pret )
  {
      $product_option_id = FALSE;
      $sqlForCheck = "SELECT `product_option_id` FROM `oc_product_option`"
              . " WHERE `product_id` = '".$productId."' AND `option_id` = '".$optionId."' LIMIT 1";

      $queryForCheck  = $database->query( $sqlForCheck );
      if( $queryForCheck->num_rows > 0 )
      {
          $product_option_id = $queryForCheck->row["product_option_id"];
      }
      
      if( empty( $product_option_id ) )
      {
          $updateSQL = "INSERT INTO `oc_product_option`"
                  . " (`product_option_id`, `product_id`, `option_id`, `option_value`, `required`)"
                  . " VALUES ( NULL, '".$productId."', '".$optionId."', '', '1')";
          $query  = $database->query( $updateSQL );
          $product_option_id = $database->getLastId();
      }
      
      if(  ! empty( $product_option_id ) )
      {
          $price_prefix = "+";
          if( $pret < 0 )
          {
              $pret *= -1;
              $price_prefix = "-";
          }
      
          $updateSQL = "INSERT INTO `oc_product_option_value` (`product_option_value_id`,"
                  . " `product_option_id`, `product_id`, `option_id`, `option_value_id`,"
                  . " `quantity`, `subtract`, `price`, `price_prefix`, `points`,"
                  . " `points_prefix`, `weight`, `weight_prefix`)"
                  . "VALUES (NULL, '".$product_option_id."', '".$productId."', '".$optionId."', '".$o_v_id."',"
                  . " '".$stock."', '1', '".$pret."', '".$price_prefix."', '0', '+', '0.00000000', '+')";
          $query  = $database->query( $updateSQL );
          $lastId = $database->getLastId();
          
          if( ! $query )
          {              
              $this->error['warning'] .=  "\"Insert failed INTO `oc_product_option_value` at product_id : '".$productId." <br>";
              return FALSE;
          }
          else
          {
              return TRUE;
          }
      }
      else
      {
          $this->error['warning'] .=  "\"Insert failed INTO `oc_product_option`: product_id: '".$productId."', option_id: '".$optionId."' <br>";
          return FALSE;
      }
      return FALSE; // never return here :)
  }
  
  function getPriceOfProductById( &$database, $productId )
  {
      $query = $database->query( 
                        "SELECT DISTINCT `price` FROM "
                        ."`oc_product` WHERE "
                        ."`product_id` = '".$productId."'" 
                    );
      
      if( $query->num_rows )
      {
          return $query->row['price'];
      }
      else
      {
          return 0;
      }
  }
  
  function upload_CSV_ProductOptionCombination( $filename )
  {
		// we use our own error handler
		global $registry;
		$registry = $this->registry;
		set_error_handler('error_handler_for_export',E_ALL);
		register_shutdown_function('fatal_error_shutdown_handler_for_export');

		try {
			$database =& $this->db;
      
      if( empty( $this->error['warning'] ) )
      {
          $this->error['warning'] = "";
      }
      
			$this->session->data['export_nochange'] = 1;
      
      $file = fopen( $filename, "r") or exit("Unable to open file!");
      
      $sqlTotalCounter = 0;
      
      $stockCollector = array();
      
      while(!feof($file))
      {
          $line = fgets($file);

          $explodedLine = explode( ";", $line );
          
          if( count( $explodedLine ) == 11 && is_numeric( $explodedLine[0]) )
          {
              $productId    = $explodedLine[0];
              $pret         = $explodedLine[7];
              $stock        = $explodedLine[8];

              $this->updateStockCollectorArray( $stockCollector, $productId, $pret, $stock );
          }
          
          $sqlTotalCounter += $this->processLineForOptionCombination( $database, $explodedLine, $line ) ? 1 : 0;        

      }
      fclose($file);
      
      $this->applyCollectedStockToDatabase( $database, $stockCollector );
      
      if( empty( $this->session->data['success'] ) )
      {
          $this->session->data['success'] = "";
      }
      $this->session->data['success'] .=  $sqlTotalCounter." product affected.<br>";
      
      $this->session->data['export_nochange'] = 0;
      
			return TRUE;
      
		} catch (Exception $e) {
			$errstr = $e->getMessage();
			$errline = $e->getLine();
			$errfile = $e->getFile();
			$errno = $e->getCode();
			$this->session->data['export_error'] = array( 'errstr'=>$errstr, 'errno'=>$errno, 'errfile'=>$errfile, 'errline'=>$errline );
			if ($this->config->get('config_error_log')) {
				$this->log->write('PHP ' . get_class($e) . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
			}
			return FALSE;
		}
	}
    
  private function updateStockCollectorArray( &$collector, $productId, $pret, $stock )
  {
      if( ! is_numeric( $pret ) )
      {
          $pret = 0;
          $stock = 0;
      }
      
      if( ! isset( $collector[$productId] ) )
      {
          $collector[$productId] = 0;
      }
      $collector[$productId] += $stock;
  }
  
  private function applyCollectedStockToDatabase( &$database, $collected )
  {
      if( $collected )
      {
          foreach( $collected as $index => $value )
          {
              $database->query( "UPDATE `oc_product` SET `quantity` = '".$value."' WHERE `product_id` = '".$index."'" );
          }
      }
  }


  private function processLineForOptionCombination( &$database, $explodedLine, $line )
  {      
      if( count( $explodedLine ) == 11 && is_numeric( $explodedLine[0]) )
      {

         $productId  = $explodedLine[0];
         $code       = $explodedLine[1];
         $denumire   = $explodedLine[2];
         $optionId1  = $explodedLine[3];
         $color      = $explodedLine[4];
         $optionId2  = $explodedLine[5];
         $marime     = $explodedLine[6];
         $pret       = $explodedLine[7];
         $stock      = $explodedLine[8];
         $stockMinim = $explodedLine[9];
         $stockInfo  = $explodedLine[10];   

         $o_v_id1  = $this->getOptionValueIdByOptionAndName( $database, $optionId1, $color );

         $o_v_id2  = $this->getOptionValueIdByOptionAndName( $database, $optionId2, $marime );

         if( $o_v_id1 && $o_v_id2 )
         {
             $updateSuccess = $this->tryToUpdateOptionCombinationIfExist( $database, $productId, $o_v_id1, $o_v_id2, $stock, $pret );

             if( ! $updateSuccess )
             {
                 // try to create rows ... :P
                 $isExists1 = $this->productHasOptionWithValue( $database, $productId, $o_v_id1, $optionId1 );
                 if( ! $isExists1 )
                 {
                    if( ! $this->insertProductOptionAndOptionValue( $database, $productId, $optionId1, $o_v_id1, 0, 0 ) )
                    {
                        return FALSE;
                    }
                 }
                 $isExists2 = $this->productHasOptionWithValue( $database, $productId, $o_v_id2, $optionId2 );
                 if( ! $isExists2 )
                 {
                    if( ! $this->insertProductOptionAndOptionValue( $database, $productId, $optionId2, $o_v_id2, 0, 0 ) )
                    {
                        return FALSE;
                    }
                 }
                 
                 $insertSuccess = $this->insertOptionCombination( $database, $productId, $o_v_id1, $o_v_id2, $stock, $pret );
                 
             }
             return TRUE;
         }
         else
         {
             $this->error['warning'] .=  "\"Not valid row in CSV: ".$line."\" "
                 ."-> combination: `option_id1` = '".$optionId1."' "
                 . " and `name1` = '".$color."'"
                 . " and `option_id2` = '".$optionId2."' "
                 . " and `name2` = '".$marime."' not exists in database! <br>";
         } 
      }
      else
      {            
         if( ! empty( $line ) )
         {
             $this->error['warning'] .=  "Not valid row in CSV: ".$line."<br>";
         }
      }
      return FALSE;
  }
  
  private function getOptionValueIdByOptionAndName( &$database, $optionId, $name )
  {
      $query_o_v_id = $database->query( 
                        "SELECT DISTINCT `option_value_id` FROM "
                        ."`oc_option_value_description` WHERE "
                        ."`option_id` = '".$optionId."' AND `name` LIKE '".$name."'" 
                    );
//      print "SELECT DISTINCT `option_value_id` FROM "
//                        ."`oc_option_value_description` WHERE "
//                        ."`option_id` = '".$optionId."' AND `name` LIKE '".$name."'<br>";
      if( $query_o_v_id->num_rows )
      {   
          return $query_o_v_id->row['option_value_id'];
      }
      else
      {
          return FALSE;
      }
  }
  
  private function tryToUpdateOptionCombinationIfExist( &$database, $productId, $o_v_id1, $o_v_id2, $stock, $pret )
  {
      if( ! is_numeric( $pret ) )
      {
          $pret = 0;
          $stock = 0;
      }

      // here we are
      $query_p_o_c = $database->query( 
                          "SELECT poc.`product_option_combination_id` AS poc_id FROM `oc_product_option_combination` AS poc 
                            JOIN `oc_product_option_combination_value` pocv1
                            ON ( pocv1.product_option_combination_id = poc.product_option_combination_id AND pocv1.`option_value_id` = '".$o_v_id1."' )
                            JOIN `oc_product_option_combination_value` pocv2
                            ON ( pocv2.product_option_combination_id = poc.product_option_combination_id AND pocv2.`option_value_id` = '".$o_v_id2."' ) 
                           WHERE poc.product_id = '".$productId."'
                           GROUP BY poc.`product_option_combination_id`
                           LIMIT 1" 
                      );

      if( $query_p_o_c->num_rows )
      {
          $p_o_c_id = $query_p_o_c->row['poc_id'];

          $updateSQL = "UPDATE `oc_product_option_combination` SET"
                  . " `stock` = '".$stock."',"
                  . " `price` = '".$pret."'"
                  . " WHERE `product_id` = '".$productId."'"
                  . " AND `product_option_combination_id` = '".$p_o_c_id."'";

          $query  = $database->query( $updateSQL );

          return TRUE;
      }
      else
      {
         return FALSE;
      }
  }
  
  private function insertOptionCombination( &$database, $productId, $o_v_id1, $o_v_id2, $stock, $pret )
  {
      if( ! is_numeric( $pret ) )
      {
          $pret = 0;
          $stock = 0;
      }

      $insertSQL = "INSERT INTO `oc_product_option_combination`
        (`product_option_combination_id`, `product_id`, `stock`,
        `subtract`, `quantity`, `sort_order`, `customer_group_id`,
        `price`, `price_prefix`, `points`, `points_prefix`, `weight`,
        `weight_prefix`, `date_start`, `date_end`)
        VALUES ( NULL, '".$productId."', '".$stock."', '1', '0', '0', '1',
        '".$pret."', '=', '0', '=', '0.00000000',
        '=', '0000-00-00', '0000-00-00')";
      
      $query  = $database->query( $insertSQL );
      $product_option_combination_id = $database->getLastId();

      $query = $database->query( "INSERT INTO `oc_product_option_combination_value` (`product_option_combination_id`, `option_value_id`) VALUES ('".$product_option_combination_id."', '".$o_v_id1."')" );
      $query = $database->query( "INSERT INTO `oc_product_option_combination_value` (`product_option_combination_id`, `option_value_id`) VALUES ('".$product_option_combination_id."', '".$o_v_id2."')" );
      
       return TRUE;
  }
  
  private function multiquery( &$database, $sql )
  {
		foreach (explode(";\n", $sql) as $sql)
    {
			$sql = trim($sql);
			if ($sql)
      {
				$database->query($sql);
			}
		}
	}
  
}

?>