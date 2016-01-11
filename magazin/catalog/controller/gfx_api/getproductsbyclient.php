<?php
class ControllerGfxApiGetProductsByClient extends Controller {

    private $error = array( );
    private $tax_rate_id;
    private $customer_id = 0;


    public function index()
    {
        // se citeste id-ul ratei de impozitare
        $this->tax_rate_id = $this->getTaxRateId();

        // verificarea validitatii codului de securitate
        if ( $this->validateCustomer() )
        {
                // salvarea in tabelul log
                $this->api_log->write( "Autentificare reusita", "info" );

                $this->load->model( 'catalog/category' );
                $this->load->model( 'catalog/product' );
                $this->load->model( 'tool/image' );
                $all_products = $this->model_catalog_product->getProducts();

                // salvam intr-un new array numai acele produse care nu au option sau option combination - produsele simple
                foreach( $all_products as $product )
                {
                    $option_data    = $this->model_catalog_product->getProductOptions( $product['product_id'] );
                    $nr_option_data = sizeof( $option_data );
                    if( $nr_option_data == 0 ) // simple product without option
                    {
                        $products[$product['product_id']] = $product;
                    }
                }

                // se verifica daca avem in get variabila SAP
                if( ( isset( $this->request->get['sap'] ) && $this->request->get['sap'] == 1 ) || ( isset( $this->request->get['SAP'] ) && $this->request->get['SAP'] == 1 ))
                {
                    $output = $this->generateBME( $products );

                    // salvarea in tabelul log
                    $this->api_log->write( "S-a generat xml-ul BME", "info" );
                }
                else
                {
                    $output = $this->generateXML( $products );
                    // salvarea in tabelul log
                    $this->api_log->write( "S-a generat xml-ul normal", "info" );
                }

                $this->response->addHeader( 'Content-Type: text/xml' );
                $this->response->setOutput( $output );
        }
        else
        {
            // salvarea in tabelul log
            $this->api_log->write( "Autentificare nereusita", "info" );

            if( isset( $this->error['warning'] ) )
            {
                $this->data['error'] = $this->error['warning'];
            }
            else
            {
                $this->data['error'] = '';
            }

            $output = '<?xml version="1.0" encoding="UTF-8"?>';
            $output .= '    <header>';
            $output .= '        <message>';
            $output .=              $this->data['error'];
            $output .= '        </message>';
            $output .= '    </header>';


            $this->response->addHeader( 'Content-Type: text/xml' );
            $this->response->setOutput( $output );

/*            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/gfx_api/getproductsbyapi.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/gfx_api/getproductsbyclient.tpl';
            } else {
                $this->template = 'default/template/gfx_api/getproductsbyclient.tpl';
            }

            $this->children = array(
                'common/footer',
                'common/header'
            );

            $this->response->setOutput($this->render());*/
        }
    }

    protected function getPath($parent_id, $current_path = '')
    {
        $category_info = $this->model_catalog_category->getCategory($parent_id);

        if ($category_info)
        {
            if (!$current_path)
            {
                $new_path = $category_info['category_id'];
            }
            else
            {
                $new_path = $category_info['category_id'] . '_' . $current_path;
            }

            $path = $this->getPath($category_info['parent_id'], $new_path);

            if ($path)
            {
                return $path;
            }
            else
            {
                return $new_path;
            }
        }
    }


    protected function validateCustomer()
    {
        $this->language->load( 'gfx_api/getproductsbyclient' );

        // se citeste key-ul din url
        $pos = strpos( $_SERVER['REQUEST_URI'], 'key' );
        if( $pos != FALSE )
        {
            $customer_security_code = substr( $_SERVER['REQUEST_URI'], $pos + strlen( 'key' ) + 1, 10 );
        }
        else
        {
            // salvarea in tabelul log
            $this->api_log->write( "Codul de securitate lipseste", "info" );

            $this->error['warning'] = $this->language->get( 'text_missing_security' );
            return false;
        }

        // se verifica lungimea codului de securitate
        if( strlen( $customer_security_code ) != 10 )
        {
            // salvarea in tabelul log
            $this->api_log->write( "Codul trebuie sa contina 10 caractere", "info" );
            $this->error['warning'] = $this->language->get( 'text_security_code_lenght_error' );
            return false;
        }


        // se verifica daca codul de securitate exista in baza de date
        $this->load->model( 'catalog/api_access' );
        $this->customer_id = $this->model_catalog_api_access->getCustomerId( $customer_security_code );
        if( $this->customer_id == 0 )
        {
            // salvarea in tabelul log
            $this->api_log->write( "Cod inextintent", "info" );
            $this->error['warning'] = $this->language->get( 'text_code_inexistent' );
            return false;
        }
        else
        {
            // se verifica daca codul clientului corespunde cu cel din url
            if( $customer_security_code != $this->model_catalog_api_access->getCustomerSecurityCode( $this->customer_id ) )
            {
                // salvarea in tabelul log
                $this->api_log->write( "Codul nu corespunde", "info" );
                $this->error['warning'] = $this->language->get( 'text_code_does_not_match' );
                return false;
            }

            // se citeste numele controllerului din link
            $route_info = explode("/", $this->request->get['route'] );

            // se citeste numele controllerelor operatiuniilor permise clientului
            $this->load->model( 'catalog/api_customer_operation' );
            $webservice_names = $this->model_catalog_api_customer_operation->getControllerNames( $this->customer_id );

            if ( !in_array( $route_info[1], $webservice_names ))
            {
                // salvarea in tabelul log
                $this->api_log->write( "Nu aveti permis pentru acest webservice", "info" );
                $this->error['warning'] = $this->language->get( 'text_permission_failed' );
                return false;
            }
        }

        if( !$this->error )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function generateBME( $products )
    {
        // Load the XML source
        $xml = new DOMDocument;
        //$xml->load( DIR_GFX_API."input.xml" );
        $xml->load( DIR_GFX_API."OpenCartSimpleProduct.xml" );

        $xsl = new DOMDocument;
        $xsl->load(DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/gfx_api/xsl_template/BMEcat.xsl');
        //$xsl->load(DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/gfx_api/xsl_template/tranform.xsl');
        // Configure the transformer
        $proc = new XSLTProcessor;
        $proc->importStyleSheet($xsl); // attach the xsl rules

        $output = $proc->transformToXML($xml);

        return $output;

        /*
        //https://help.sap.com/saphelp_ccm10/helpdata/en/5e/bce517c6bf44fcb9054c39af7aac3f/content.htm
        $output = '<?xml version="1.0" encoding="UTF-8"?>';
        $output .= '<BMECAT version="1.2">';
        $output .= '    <HEADER>';
        $output .=  '       <GENERATOR_INFO>SAP AG</GENERATOR_INFO>';
        $output .= '        <CATALOG>';
        $output .= '            <LANGUAGE>RON</LANGUAGE>';// $this->config->get('config_language') = ro
        $output .= '            <CATALOG_ID>Renania Catalog</CATALOG_ID>';
        $output .= '            <CATALOG_VERSION>1</CATALOG_VERSION>';
        $output .= '            <CURRENCY>'.$this->currency->getCode().'</CURRENCY>';
        //$output .= '            <MIME_ROOT>http://test/</MIME_ROOT>';
        $output .= '        </CATALOG>';

        $output .= '        <AGREEMENT>';
        $output .= '            <AGREEMENT_START_DATE>'.date("Y-m-d").'</AGREEMENT_START_DATE>';
        $output .= '            <AGREEMENT_END_DATE>2020-01-01</AGREEMENT_END_DATE>';
        $output .= '        </AGREEMENT>';

        // se citeste informatiile clientului, care s-a loghat
        $customer_info = $this->getCustomerInfo();

        $output .= '        <BUYER>';
        $output .= '            <BUYER_ID type="buyer_specific">B2B</BUYER_ID>';
        $output .= '            <BUYER_NAME>'.$customer_info['name'].'</BUYER_NAME>';
        $output .= '            <ADDRESS type="buyer">';
        $output .= '                <NAME>'.$customer_info['name'].'</NAME>';
        $output .= '                <CONTACT>'.$customer_info['name'].'</CONTACT>';
        $output .= '            </ADDRESS>';
        $output .= '        </BUYER>';

        $output .= '        <SUPPLIER>';
        $output .= '            <SUPPLIER_NAME>'.$this->config->get('config_owner').'</SUPPLIER_NAME>';//$this->config->get('config_name')
        $output .= '        </SUPPLIER>';

        $output .= '    </HEADER>';

        foreach( $products as $product )
        {
            $output .= '<ARTICLE mode="new">';
            $output .= '    <SUPPLIER_AID>'.$product['product_id'].'</SUPPLIER_AID>'; // product id ?
            $output .= '    <ARTICLE_DETAILS>';
            $output .= '        <DESCRIPTION_SHORT>'.htmlspecialchars( $product['name'] ).'</DESCRIPTION_SHORT>';
            $output .= '        <DESCRIPTION_LONG>'.htmlspecialchars( $product['description'] ).'</DESCRIPTION_LONG>';
            $output .= '        <MANUFACTURER_NAME>'.$product['manufacturer'].'</MANUFACTURER_NAME>';
            $output .= '        <DELIVERY_TIME>3</DELIVERY_TIME>'; // working days only
            $output .= '    </ARTICLE_DETAILS>';

            $output .= '    <ARTICLE_FEATURES>';
            $output .= '        <REFERENCE_FEATURE_SYSTEM_NAME>PAPER AG</REFERENCE_FEATURE_SYSTEM_NAME>'; // ?????????
            $output .= '        <REFERENCE_FEATURE_GROUP_ID>3.4</REFERENCE_FEATURE_GROUP_ID>';  // ????????????????
            $output .= '    </ARTICLE_FEATURES>';

            $output .= '    <ARTICLE_ORDER_DETAILS>';
            $output .= '        <ORDER_UNIT>PCE</ORDER_UNIT>';// ??
            $output .= '        <CONTENT_UNIT>PCE</CONTENT_UNIT>';// ??
            $output .= '        <NO_CU_PER_OU>--</NO_CU_PER_OU>';// ??
            $output .= '        <QUANTITY_INTERVAL>1</QUANTITY_INTERVAL>'; // ???
            $output .= '    </ARTICLE_ORDER_DETAILS>';
            $output .= '    <ARTICLE_PRICE_DETAILS>';
            $output .= '        <DATETIME type="valid_start_date">';
            $output .= '            <DATE>'.$product['date_available'].'</DATE>';
            //$output .= '            <TIME>00:00:00</TIME>';
            $output .= '        </DATETIME>';
            //$output .= '        <DATETIME type="valid_end_date">';
            //$output .= '            <DATE>2007-12-31</DATE>';
            //$output .= '            <TIME>00:00:00</TIME>';
            //$output .= '        </DATETIME>';
            $output .= '        <ARTICLE_PRICE price_type="net_customer">'; //? price_type = net_customer ??

            $currencies = array('USD', 'EUR', 'GBP' );
            if( in_array( $this->currency->getCode(), $currencies ) )
            {
                $currency_code  = $this->currency->getCode();
                $currency_value = $this->currency->getValue();
            } else
            {
                $currency_code  = 'USD';
                $currency_value = $this->currency->getValue( 'USD' );
            }

            $tax_info = $this->tax->getRates($product['price'], $product['tax_class_id']);
            $tax = $tax_info[$this->tax_rate_id]['rate'];

            if( (float) $product['special'] )
            {
                $price = $this->currency->format( $this->tax->calculate( $product['special'], $product['tax_class_id'] ), $currency_code, $currency_value, FALSE );
            }
            else
            {
                $price = $this->currency->format( $this->tax->calculate( $product['price'], $product['tax_class_id'] ), $currency_code, $currency_value, FALSE );
            }

            $output .= '            <PRICE_AMOUNT>'.$price.'</PRICE_AMOUNT>';


            $output .= '            <LOWER_BOUND>1</LOWER_BOUND>'; // ??
            $output .= '            <PRICE_CURRENCY>'.$this->currency->getCode().'</PRICE_CURRENCY>'; // ??
            $output .= '            <TAX>'.($tax/100).'</TAX>';
            $output .= '        </ARTICLE_PRICE>';
            $output .= '    </ARTICLE_PRICE_DETAILS>';

            // returneaza datele categoriei
            $category_info = $this->getCategory( $product['product_id'] );

            $output .= '    <CATALOG_GROUP_SYSTEM>';
            $output .= '        <GROUP_SYSTEM_ID>'.$category_info['category_id'].'</GROUP_SYSTEM_ID>';
            $output .= '        <GROUP_SYSTEM_NAME>'.$category_info['category_name'].'</GROUP_SYSTEM_NAME>';
            $output .= '        <PARENT_ID>0</PARENT_ID>';
            $output .= '        <CATALOG_STRUCTURE type="node">...</CATALOG_STRUCTURE>';
            $output .= '        <CATALOG_STRUCTURE type="leaf">...</CATALOG_STRUCTURE>';
            $output .= '        <GROUP_SYSTEM_DESCRIPTION>'.$category_info['category_name'].'</GROUP_SYSTEM_DESCRIPTION>';
            $output .= '    </CATALOG_GROUP_SYSTEM>';



            $output .= '    <MIME_INFO>';

            if( $product['image'] )
            {
                $image = $this->model_tool_image->resize( str_replace( "&", "&amp;", $product['image'] ), 500, 500 );
            } else
            {
                $image = $this->model_tool_image->resize( 'no_image.jpg', 500, 500 );
            }

            $output .= '        <MIME>';
            $output .= '            <MIME_SOURCE>'.$image.'</MIME_SOURCE>';
            $output .= '            <MIME_PURPOSE>normal</MIME_PURPOSE>'; //?
            $output .= '        </MIME>';
            $output .= '</MIME_INFO>';
            $output .= '</ARTICLE>';
        }

        $output .= '</BMECAT>';

        return $output;
        */
    }


    private function generateXML( $products )
    {
        $output = '<?xml version="1.0" encoding="UTF-8" ?>';
        $output .= '<channel>';
        $output .= '<title>' . $this->config->get( 'config_name' ) . '</title>';
        $output .= '<description>' . $this->config->get( 'config_meta_description' ) . '</description>';
        $output .= '<link>' . HTTP_SERVER . '</link>';

        $output .= '    <header>';
        $output .=  '       <generator_info>SAP AG</generator_info>';
        $output .= '        <catalog>';
        $output .= '            <language>RON</language>';// $this->config->get('config_language') = ro
        $output .= '            <catalog_id>Renania Catalog</catalog_id>';
        $output .= '            <catalog_version>1</catalog_version>';
        $output .= '            <currency>'.$this->currency->getCode().'</currency>';
        $output .= '        </catalog>';

        $output .= '        <agreement>';
        $output .= '            <agreement_start_date>'.date("Y-m-d").'</agreement_start_date>';
        $output .= '            <agreement_end_date>2020-01-01</agreement_end_date>';
        $output .= '        </agreement>';

        // se citeste informatiile clientului, care s-a loghat
        $customer_info = $this->getCustomerInfo();

        $output .= '        <buyer>';
        $output .= '            <buyer_id type="buyer_specific">B2B</buyer_id>';
        $output .= '            <buyer_name>'.$customer_info['name'].'</buyer_name>';
        $output .= '            <address type="buyer">';
        $output .= '                <name>'.$customer_info['name'].'</name>';
        $output .= '                <contact>'.$customer_info['name'].'</contact>';
        $output .= '            </address>';
        $output .= '        </buyer>';

        $output .= '        <supplier>';
        $output .= '            <supplier_name>'.$this->config->get('config_owner').'</supplier_name>';//$this->config->get('config_name')
        $output .= '        </supplier>';

        $output .= '    </header>';

        foreach( $products as $product )
        {
            $output .= '<item>';

            /* se verifica daca in link este setat variabila - title -
            daca este si are valoarea 1 atunci trebuie generat numele produsului in xml */
            if( !isset( $this->request->get['title'] ) || ( isset( $this->request->get['title'] ) && $this->request->get['title'] == 1 ) )
            {
                $output .= '<name>' . htmlspecialchars( $product['name'] ) . '</name>'; //htmlspecialchars($product['name'])
                //html_entity_decode( str_replace( "amp;", "", $category->$function_name() ) );
                // strip_tags(html_entity_decode($product['name'], ENT_QUOTES, 'UTF-8')),
            }
            //$output .= '<link>' . $this->url->link('product/product', 'product_id=' . $product['product_id']) . '</link>';

            /* se verifica daca in link este setat variabila - description -
            daca este si are valoarea 1 atunci trebuie generat descrierea produsului in xml */
            if( !isset( $this->request->get['description'] ) || ( isset( $this->request->get['description'] ) && $this->request->get['description'] == 1 ) )
            {
                $output .= '<description>' . htmlspecialchars( $product['description'] ) . '</description>';
            }

            /* se verifica daca in link este setat variabila - manufacturer -
            daca este si are valoarea 1 atunci trebuie generat producatorul produsului in xml */
            if( !isset( $this->request->get['manufacturer'] ) || ( isset( $this->request->get['manufacturer'] ) && $this->request->get['manufacturer'] == 1 ) )
            {
                $output .= '<manufacturer>' . $product['manufacturer'] . '</manufacturer>';
            }

            /* se verifica daca in link este setat variabila - manufacturer -
            daca este si are valoarea 1 atunci trebuie generat id-ul produsului in xml */
            if( !isset( $this->request->get['product_id'] ) || ( isset( $this->request->get['product_id'] ) && $this->request->get['product_id'] == 1 ) )
            {
                $output .= '<product_id>' . $product['product_id'] . '</product_id>';
            }

            /* se verifica daca in link este setat variabila - image -
            daca este si are valoarea 1 atunci trebuie generat imaginea produsului in xml */
            if( !isset( $this->request->get['image'] ) || ( isset( $this->request->get['image'] ) && $this->request->get['image'] == 1 ) )
            {
                if( $product['image'] )
                {
                    $output .= '<image>' . $this->model_tool_image->resize( str_replace( "&", "&amp;", $product['image'] ), 500, 500 ) . '</image>';
                } else
                {
                    $output .= '<image>' . $this->model_tool_image->resize( 'no_image.jpg', 500, 500 ) . '</image>';
                }
            }

            /* se verifica daca in link este setat variabila - model -
            daca este si are valoarea 1 atunci trebuie generat modelul produsului in xml */
            if( !isset( $this->request->get['model'] ) || ( isset( $this->request->get['model'] ) && $this->request->get['model'] == 1 ) )
            {
                $output .= '<model>' . $product['model'] . '</model>';
            }

            $currencies = array('USD', 'EUR', 'GBP' );

            if( in_array( $this->currency->getCode(), $currencies ) )
            {
                $currency_code  = $this->currency->getCode();
                $currency_value = $this->currency->getValue();
            } else
            {
                $currency_code  = 'USD';
                $currency_value = $this->currency->getValue( 'USD' );
            }

            /* se verifica daca in link este setat variabila - price -
            daca este si are valoarea 1 atunci trebuie generat pretul produsului in xml */
            if( !isset( $this->request->get['price'] ) || ( isset( $this->request->get['price'] ) && $this->request->get['price'] == 1 ) )
            {
                if( (float) $product['special'] )
                {
                    $output .= '<price>' . $this->currency->format( $this->tax->calculate( $product['special'], $product['tax_class_id'] ), $currency_code, $currency_value, FALSE ) . '</price>';
                } else
                {
                    $output .= '<price>' . $this->currency->format( $this->tax->calculate( $product['price'], $product['tax_class_id'] ), $currency_code, $currency_value, FALSE ) . '</price>';
                }
            }

            /*$categories = $this->model_catalog_product->getCategories( $product['product_id'] );
            foreach( $categories as $category )
            {
                $path = $this->getPath( $category['category_id'] );

                if( $path )
                {
                    $string = '';

                    foreach( explode( '_', $path ) as $path_id )
                    {
                        $category_info = $this->model_catalog_category->getCategory( $path_id );

                        if( $category_info )
                        {
                            if( !$string )
                            {
                                $string = $category_info['name'];
                            } else
                            {
                                $string .= ' &gt; ' . $category_info['name'];
                            }
                        }
                    }

                    if( !isset( $this->request->get['category'] ) || ( isset( $this->request->get['category'] ) && $this->request->get['category'] == 1 ) )
                    {
                        $output .= '<category>' . $string . '</category>';
                    }
                }
            }*/

            $category_info = $this->getCategory( $product['product_id'] );
            if( !isset( $this->request->get['category'] ) || ( isset( $this->request->get['category'] ) && $this->request->get['category'] == 1 ) )
            {
                $output .= '<category_name>' . $category_info['category_name'] . '</category_name>';
                $output .= '<parent_id>0</parent_id>';
                $output .= '<category_id>' . $category_info['category_id'] . '</category_id>';
            }

            /* se verifica daca in link este setat variabila - quantity -
            daca este si are valoarea 1 atunci trebuie generat cantitatea produsului in xml */
            if( !isset( $this->request->get['quantity'] ) || ( isset( $this->request->get['quantity'] ) && $this->request->get['quantity'] == 1 ) )
            {
                $output .= '<quantity>' . $product['quantity'] . '</quantity>';
            }

            /* se verifica daca in link este setat variabila - upc -
            daca este si are valoarea 1 atunci trebuie generat valoarea coloanei upc in xml */
            if( !isset( $this->request->get['upc'] ) || ( isset( $this->request->get['upc'] ) && $this->request->get['upc'] == 1 ) )
            {
                $output .= '<upc>' . $product['upc'] . '</upc>';
            }

            /* se verifica daca in link este setat variabila - weight -
            daca este si are valoarea 1 atunci trebuie generat greutatea produsului in xml */
            if( !isset( $this->request->get['weight'] ) || ( isset( $this->request->get['weight'] ) && $this->request->get['weight'] == 1 ) )
            {
                $output .= '<weight>' . $this->weight->format( $product['weight'], $product['weight_class_id'] ) . '</weight>';
            }

            /* se verifica daca in link este setat variabila - availability -
            daca este si are valoarea 1 atunci trebuie generat disponibilitatea produsului in xml */
            if( !isset( $this->request->get['quantity'] ) || ( isset( $this->request->get['quantity'] ) && $this->request->get['quantity'] == 1 ) )
            {
                $output .= '<availability>' . ( $product['quantity'] ? 'in stock' : 'out of stock' ) . '</availability>';
            }

            $output .= '<reference_feature_system_name>ECLASS-5.1</reference_feature_system_name>';
            $output .= '<reference_feature_group_id>24-26-23-01</reference_feature_group_id>';

            $output .= '<order_unit>PCE</order_unit>';
            $output .= '<content_unit>PCE</content_unit>';
            $output .= '<no_cu_per_ou>--</no_cu_per_ou>';
            $output .= '<quantity_interval>'.$product['minimum'].'</quantity_interval>';
            $output .= '<price_quantity>'.$product['minimum'].'</price_quantity>';
            $output .= '<lower_bound>'.$product['minimum'].'</lower_bound>';
            $output .= '<quantity_min>'.$product['minimum'].'</quantity_min>';
            $output .= '<price_currency>'.$this->currency->getCode().'</price_currency>';
            $output .= '<valid_start_date>' . $product['date_available'] . '</valid_start_date>';

            $tax_info = $this->tax->getRates($product['price'], $product['tax_class_id']);
            $tax = $tax_info[$this->tax_rate_id]['rate'];

            $output .= '<tax>'.( $tax/100).'</tax>';

            $output .= '</item>';
        }

        $output .= '</channel>';

        $myfile = fopen( DIR_GFX_API."OpenCartSimpleProduct.xml", "w+" ) or die("Unable to open file!");
        fwrite($myfile, $output);
        fclose($myfile);

        return $output;
    }

    private function getTaxRateId()
    {
        $tax_rate_id = 0;

        $query = $this->db->query("SELECT tax_rate_id FROM " . DB_PREFIX . "tax_rate_to_customer_group WHERE `customer_group_id` = 3"); // B2B
        if( $query->num_rows!= 0 )
        {
            $tax_rate_id = $query->row['tax_rate_id'];
        }

        return $tax_rate_id;
    }

    private function getCustomerInfo()
    {
        $customer_info = array();

        $query = $this->db->query("SELECT firstname, lastname, email FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$this->customer_id . "' AND status = '1'");
        if( $query->num_rows!= 0 )
        {
            $customer_info['name'] = $query->row['firstname']." ".$query->row['lastname'];
            $customer_info['email'] = $query->row['email'];
        }

        return $customer_info;

    }


    private function getCategory( $product_id )
    {
        $category_info = array();

        $categories = $this->model_catalog_product->getCategories( $product_id );

        foreach( $categories as $category )
        {
            $path = $this->getPath( $category['category_id'] );

            if( $path )
            {
                $string = '';
                foreach( explode( '_', $path ) as $path_id )
                {
                    $category_info = $this->model_catalog_category->getCategory( $path_id );
                    if( $category_info )
                    {
                        if( !$string )
                        {
                            $string = $category_info['name'];
                        } else
                        {
                            $string .= ' &gt; ' . $category_info['name'];
                        }
                    }
                }

                $category_info['category_name'] =  $string;
                $category_info['category_id'] = $category['category_id'];
            }
        }

        return $category_info;
    }

}