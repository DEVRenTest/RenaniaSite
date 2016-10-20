<?php

class ControllerAccountSpecialProductsRequest extends Controller
{
    public function specialProductsRequest()
    {
        
        if(!$this->customer->isLogged())
        {
            $this->session->data['redirect'] = $this->url->link('account/special_products_request/specialproductsrequest', '', 'SSL');
            $this->redirect( $this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('account/special_products_request');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['breadcrumbs'] = array( );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('account/account', '', 'SSL'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_upload_report'),
            'href' => $this->url->link('account/special_products_request/specialproductsrequest', '', 'SSL'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['heading_title'] = $this->language->get('special_products_request_heading_title');
        $this->data['text_product_description'] = $this->language->get('text_product_description');
        $this->data['text_next_months_quantity'] = $this->language->get('text_next_months_quantity');
        $this->data['text_quantity'] = $this->language->get('text_quantity');
        $this->data['text_unit'] = $this->language->get('text_unit');
        $this->data['text_initial_order_quantity'] = $this->language->get('text_initial_order_quantity');
        $this->data['text_order_total_value'] = $this->language->get('text_order_total_value');
        $this->data['text_ron'] = $this->language->get('text_ron');
        $this->data['text_target_price'] = $this->language->get('text_target_price');
        $this->data['text_sales_arguments'] = $this->language->get('text_sales_arguments');
        $this->data['text_regional_manager_approval'] = $this->language->get('text_regional_manager_approval');
        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['text_no'] = $this->language->get('text_no');
        $this->data['text_order_date_estimation'] = $this->language->get('text_order_date_estimation');
        $this->data['text_first_batch'] = $this->language->get('text_first_batch');
        $this->data['text_second_batch'] = $this->language->get('text_second_batch');
        $this->data['text_third_batch'] = $this->language->get('text_third_batch');
        $this->data['text_fourth_batch'] = $this->language->get('text_fourth_batch');
        $this->data['text_fifth_batch'] = $this->language->get('text_fifth_batch');
        $this->data['text_sixth_batch'] = $this->language->get('text_sixth_batch');
        $this->data['text_existent_alternative_products'] = $this->language->get('text_existent_alternative_products');
        $this->data['text_alternative_products'] = $this->language->get('text_alternative_products');
        $this->data['text_customer_feedback'] = $this->language->get('text_customer_feedback');
        $this->data['text_new_provider'] = $this->language->get('text_new_provider');
        $this->data['text_provider_name'] = $this->language->get('text_provider_name');
        $this->data['text_identified_circumstances'] = $this->language->get('text_identified_circumstances');
        $this->data['text_other_informations'] = $this->language->get('text_other_informations');
        $this->data['text_product_category'] = $this->language->get('text_product_category');
        $this->data['text_select_category'] = $this->language->get('text_select_category');
        $this->data['text_special_product_image'] = $this->language->get('text_special_product_image');
        $this->data['text_customer'] = $this->language->get('text_customer');
        $this->data['text_customer_type'] = $this->language->get('text_customer_type');
        $this->data['text_av_rv'] = $this->language->get('text_av_rv');
        $this->data['text_requested_delivery_term'] = $this->language->get('text_requested_delivery_term');
        $this->data['text_aplication_description'] = $this->language->get('text_aplication_description');
        $this->data['text_working_conditions'] = $this->language->get('text_working_conditions');
        $this->data['text_protection_type'] = $this->language->get('text_protection_type');
        $this->data['text_non_safety'] = $this->language->get('text_non_safety');
        $this->data['text_O1'] = $this->language->get('text_O1');
        $this->data['text_O2'] = $this->language->get('text_O2');
        $this->data['text_O3'] = $this->language->get('text_O3');
        $this->data['text_O4'] = $this->language->get('text_O4');
        $this->data['text_OB'] = $this->language->get('text_OB');
        $this->data['text_S1'] = $this->language->get('text_S1');
        $this->data['text_S1P'] = $this->language->get('text_S1P');
        $this->data['text_S2'] = $this->language->get('text_S2');
        $this->data['text_S3'] = $this->language->get('text_S3');
        $this->data['text_S4'] = $this->language->get('text_S4');
        $this->data['text_S5'] = $this->language->get('text_S5');
        $this->data['text_SB'] = $this->language->get('text_SB');
        $this->data['text_SB_P'] = $this->language->get('text_SB_P');
        $this->data['text_A_E_P_FO_WRU'] = $this->language->get('text_A_E_P_FO_WRU');
        $this->data['text_F2A_CI_HI3_SRC'] = $this->language->get('text_F2A_CI_HI3_SRC');
        $this->data['text_F2A_CI_HI3_SRC__A_E_P_FO_WRU'] = $this->language->get('text_F2A_CI_HI3_SRC__A_E_P_FO_WRU');
        $this->data['text_other_type'] = $this->language->get('text_other_type');
        $this->data['text_technical_specifications'] = $this->language->get('text_technical_specifications');
        $this->data['text_WR'] = $this->language->get('text_WR');
        $this->data['text_SRC'] = $this->language->get('text_SRC');
        $this->data['text_HRO'] = $this->language->get('text_HRO');
        $this->data['text_HI'] = $this->language->get('text_HI');
        $this->data['text_M'] = $this->language->get('text_M');
        $this->data['text_CI'] = $this->language->get('text_CI');
        $this->data['text_CR'] = $this->language->get('text_CR');
        $this->data['text_ESD'] = $this->language->get('text_ESD');
        $this->data['text_Metal_free'] = $this->language->get('text_Metal_free');
        $this->data['text_product_type'] = $this->language->get('text_product_type');
        $this->data['text_requested_material'] = $this->language->get('text_requested_material');
        $this->data['text_complementary_products'] = $this->language->get('text_complementary_products');
        $this->data['text_insulating_gloves'] = $this->language->get('text_insulating_gloves');
        $this->data['text_anti_vibration_protection'] = $this->language->get('text_anti_vibration_protection');
        $this->data['text_antistatic_protection'] = $this->language->get('text_antistatic_protection');
        $this->data['text_heat_protection'] = $this->language->get('text_heat_protection');
        $this->data['text_chemical_protection'] = $this->language->get('text_chemical_protection');
        $this->data['text_cleanroom_protection'] = $this->language->get('text_cleanroom_protection');
        $this->data['text_ESD_protection'] = $this->language->get('text_ESD_protection');
        $this->data['text_forest_protection'] = $this->language->get('text_forest_protection');
        $this->data['text_cold_protection'] = $this->language->get('text_cold_protection');
        $this->data['text_high_visibility_protection'] = $this->language->get('text_high_visibility_protection');
        $this->data['text_rain_protection'] = $this->language->get('text_rain_protection');
        $this->data['text_fire_protection'] = $this->language->get('text_fire_protection');
        $this->data['text_minimum_risk_protection'] = $this->language->get('text_minimum_risk_protection');
        $this->data['text_welding_protection'] = $this->language->get('text_welding_protection');
        $this->data['text_minimum_risk_protection_winter'] = $this->language->get('text_minimum_risk_protection_winter');
        $this->data['text_minimum_risk_protection_rain'] = $this->language->get('text_minimum_risk_protection_rain');
        $this->data['text_welding_protection'] = $this->language->get('text_welding_protection');
        $this->data['text_cutting_protection'] = $this->language->get('text_cutting_protection');
        $this->data['text_impact_protection'] = $this->language->get('text_impact_protection');
        $this->data['text_sting_protection'] = $this->language->get('text_sting_protection');
        $this->data['text_mechanical_protection'] = $this->language->get('text_mechanical_protection');
        $this->data['text_single_use'] = $this->language->get('text_single_use');
        $this->data['text_chemical_substance_name'] = $this->language->get('text_chemical_substance_name');
        $this->data['text_CAS_number'] = $this->language->get('text_CAS_number');
        $this->data['text_contact_duration'] = $this->language->get('text_contact_duration');
        $this->data['text_grammage'] = $this->language->get('text_grammage');
        $this->data['text_color'] = $this->language->get('text_color');
        $this->data['text_heat_transmission_mode'] = $this->language->get('text_heat_transmission_mode');
        $this->data['text_contact_heat'] = $this->language->get('text_contact_heat');
        $this->data['text_radiant_heat'] = $this->language->get('text_radiant_heat');
        $this->data['text_convective_heat'] = $this->language->get('text_convective_heat');
        $this->data['text_molten_metal'] = $this->language->get('text_molten_metal');
        $this->data['text_temperature'] = $this->language->get('text_temperature');
        $this->data['text_protection_level'] = $this->language->get('text_protection_level');
        $this->data['text_protection_2'] = $this->language->get('text_protection_2');
        $this->data['text_protection_3'] = $this->language->get('text_protection_3');
        $this->data['text_protection_4'] = $this->language->get('text_protection_4');
        $this->data['text_protection_5'] = $this->language->get('text_protection_5');
        $this->data['text_air_culvert'] = $this->language->get('text_air_culvert');
        $this->data['text_helmets'] = $this->language->get('text_helmets');
        $this->data['text_positive_pressure_and_air_supplied'] = $this->language->get('text_positive_pressure_and_air_supplied');
        $this->data['text_hearing_protection'] = $this->language->get('text_hearing_protection');
        $this->data['text_respiratory_protection_gases'] = $this->language->get('text_respiratory_protection_gases');
        $this->data['text_respiratory_protection_dust'] = $this->language->get('text_respiratory_protection_dust');
        $this->data['text_visual_protection'] = $this->language->get('text_visual_protection');
        $this->data['text_welding'] = $this->language->get('text_welding');
        $this->data['text_gas_organic_vapors_smaller_boiling_point'] = $this->language->get('text_gas_organic_vapors_smaller_boiling_point');
        $this->data['text_gas_organic_vapors_bigger_boiling_point'] = $this->language->get('text_gas_organic_vapors_bigger_boiling_point');
        $this->data['text_organic_vapors'] = $this->language->get('text_organic_vapors');
        $this->data['text_sulfur_dioxide_hydrochloric_acid'] = $this->language->get('text_sulfur_dioxide_hydrochloric_acid');
        $this->data['text_ammonia'] = $this->language->get('text_ammonia');
        $this->data['text_carbon_monoxide'] = $this->language->get('text_carbon_monoxide');
        $this->data['text_mercury'] = $this->language->get('text_mercury');
        $this->data['text_nitrous_gases'] = $this->language->get('text_nitrous_gases');
        $this->data['text_radioiodine'] = $this->language->get('text_radioiodine');
        $this->data['text_particles'] = $this->language->get('text_particles');
        $this->data['text_FFP1'] = $this->language->get('text_FFP1');
        $this->data['text_FFP2'] = $this->language->get('text_FFP2');
        $this->data['text_FFP3'] = $this->language->get('text_FFP3');
        $this->data['text_other_working_at_height_product_type'] = $this->language->get('text_other_working_at_height_product_type');
        $this->data['text_other_requested_material'] = $this->language->get('text_other_requested_material');

        $this->data['upload_form_button'] = $this->language->get('upload_form_button');
        $this->data['first_upload_form_button'] = $this->language->get('first_upload_form_button');
        $this->data['add_form_button'] = $this->language->get('add_form_button');
        $this->data['error_manager_approval'] = $this->language->get('error_manager_approval');


        $this->load->model('catalog/category');
        $product_categories = $this->model_catalog_category->getCategories();

        $this->data['product_categories'] = array();
        foreach ($product_categories as $product_category) {
            if ($product_category['top']) {
                $this->data['product_categories'][] = array(
                    'category_id' => $product_category['category_id'],
                    'name'        => $product_category['name']
                );
            }
        }

        $this->data['customer_types'] = array('CLIENT', 'CLIENT KA', 'CLIENT UP', 'DISTRIB', 'RECOM A', 'RECOM B', 'EXT-EU', 'EXT-NON-EU', 'PF', 'ANGAJAT');
        $this->data['footwear_product_types'] = array('Accesorii', 'Bocanci', 'Cizme', 'Pantofi', 'Saboti', 'Sandale');
        $this->data['footwear_requested_materials'] = array('piele box', 'piele spalt', 'velur', 'nubuck', 'microfibra', 'textil');
        $this->data['clothing_product_types'] = array('Accesorii', 'Bodywear', 'Caciuli', 'Camasi', 'Capisoane', 'Ciorapi', 'Combinezoane', 'Combinezoane vatuite', 'Compleuri', 'Compleuri vatuite', 'Halate', 'Jachete', 'Jachete vatuite', 'Mantale', 'Pantaloni cu Pieptar', 'Pantaloni cu Pieptar vatuiti', 'Pantaloni scurti', 'Pantaloni talie', 'Pantaloni talie vatuiti', 'Pelerine', 'Pulovere', 'Sarafane', 'Sepci', 'Sorturi', 'Sube', 'Tricouri', 'Veste', 'Veste vatuite', 'Hanorace', 'Fuste', 'Robe');
        $this->data['clothing_requested_materials'] = array('100% bumbac', 'tercot', 'poliester', 'material peliculizat');
        $this->data['gloves_product_types'] = array('Accesorii', 'Manecute', 'Manusi butil', 'Manusi fibre speciale', 'Manusi fibre speciale impregnate', 'Manusi latex', 'Manusi neopren', 'Manusi nitril', 'Manusi piele', 'Manusi piele sintetica', 'Manusi polietilena', 'Manusi PVA', 'Manusi PVC', 'Manusi textil', 'Manusi tricot impregnat', 'Manusi vinil', 'Manusi zale', 'Palmare');
        $this->data['head_protection_product_types'] = array('Accesorii aductiune aer', 'Accesorii antifoane', 'Accesorii casti', 'Accesorii ochelari', 'Accesorii protectie respiratorie', 'Accesorii sudura', 'Antifoane externe', 'Antifoane interne', 'Casca alpinist', 'Casca electrician', 'Casca pompieri', 'Casti aductiune aer', 'Casti de protectie uz general', 'Casti protectie aplicatii speciale', 'Costum sablator', 'Dispensere', 'Diverse', 'Filtre', 'Masti complexe sudura', 'Masti simple sudura', 'Masti-semimasti cu filtre', 'Ochelari aplicatii speciale', 'Ochelari de prescriptie', 'Ochelari de tip goggles', 'Ochelari lentila colorata', 'Ochelari lentila incolora', 'Semimasti aplicatii speciale', 'Semimasti pliate', 'Semimasti tip cupa', 'Sistem aductiune', 'Sistem de respiratie autonom', 'Sisteme comunicatie');
        $this->data['working_at_height_product_types'] = array('Bucle', 'Carabiniere', 'Centuri', 'Corzi', 'Franghii', 'Mijloace de legatura', 'Opritoare de cadere', 'Puncte de ancorare', 'Salvare si interventie', 'Dispozitive de salvare', 'Echipamente speciale pentru escalada', 'Seturi', 'Sisteme de acces in canale', 'Sisteme de asigurare stationare', 'Veste si haine');
        $this->data['carabiners'] = array('otel', 'aluminiu');
        $this->data['belts'] = array('multifunctionale', 'complexe', 'de pozitionare');
        $this->data['strings'] = array('fara ocheti', 'cu 1 ochet', 'cu 2 ocheti');
        $this->data['strips'] = array('fara ocheti', 'cu 1 ochet', 'cu 2 ocheti');
        $this->data['means_link'] = array('Ancorare', 'Conectare', 'Cu absorbitor de energie', 'Pozitionare');
        $this->data['fall_dykes'] = array('Cu chinga retractabila', 'Pe suport flexibil', 'Retractabil');

        $this->load->model('account/customer');
        $customer_additional_groups = $this->model_account_customer->getCustomerGroups();

        $customer_all_groups = array_merge(array_flip($customer_additional_groups), array($this->customer->getCustomerGroupId()));
        $allowed_groups = $this->config->get('config_customer_group_access') ? $this->config->get('config_customer_group_access') : array();
        if (!(bool)array_intersect($customer_all_groups, $allowed_groups)) {
            $this->redirect($this->url->link('account/account', '', 'SSL'));
        }

        $this->load->model('account/special_products_request');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $allowedExts = array("jpeg", "jpg", "png");
            $temp = explode( ".", $this->request->files['image']['name']);
            $extension = end( $temp );
            if ($this->request->files['image']['name'] != '' && in_array($extension, $allowedExts)) {
                $name = basename($this->request->files["image"]["name"]);
                $image = $this->request->files['image']['name'];
                move_uploaded_file($this->request->files['image']['tmp_name'], "image/specialProduct/$name");
                $attachment = "image/specialProduct/$name";
            } else {
                $image = '';
            }

            if (isset($this->request->post['technical_specification'])) {
                $technical_specification = implode(', ', array_filter($_POST['technical_specification']));
            } else {
                $technical_specification = '';
            }

            if (isset($this->request->post['protection_type'])) {
                $protection_type = implode(', ', array_filter($_POST['protection_type']));
            } else {
                $protection_type = '';
            }

            if (isset($this->request->post['aplication_description'])) {
                $aplication_description = implode(', ', array_filter($_POST['aplication_description']));
            } else {
                $aplication_description = '';
            }

            if (isset($this->request->post['working_conditions'])) {
                $working_conditions = implode(', ', array_filter($_POST['working_conditions']));
            } else {
                $working_conditions = '';
            }

            if (isset($this->request->post['product_type'])) {
                $product_type = implode('', array_filter($_POST['product_type']));
            } else {
                $product_type = '';
            }

            if (isset($this->request->post['requested_material'])) {
                $requested_material = implode('', array_filter($_POST['requested_material']));
            } else {
                $requested_material = '';
            }

            if (isset($this->request->post['respiratory_protection_gases'])) {
                $respiratory_protection_gases = implode(', ', array_filter($_POST['respiratory_protection_gases']));
            } else {
                $respiratory_protection_gases = '';
            }

            if (isset($this->request->post['respiratory_protection_dust'])) {
                $respiratory_protection_dust = implode(', ', array_filter($_POST['respiratory_protection_dust']));
            } else {
                $respiratory_protection_dust = '';
            }

            if (isset($this->request->post['heat_transmission'])) {
                $heat_transmission = implode(', ', array_filter($_POST['heat_transmission']));
            } else {
                $heat_transmission = '';
            }

            if (isset($this->request->post['protection_level'])) {
                $protection_level = implode(', ', array_filter($_POST['protection_level']));
            } else {
                $protection_level = '';
            }

            if (isset($this->request->post['chemical_substance_name'])) {
                $chemical_substance_name = implode(', ', array_filter($_POST['chemical_substance_name']));
            } else {
                $chemical_substance_name = '';
            }

            if (isset($this->request->post['CAS_number'])) {
                $CAS_number = implode(', ', array_filter($_POST['CAS_number']));
            } else {
                $CAS_number = '';
            }

            if (isset($this->request->post['contact_duration'])) {
                $contact_duration = implode(', ', array_filter($_POST['contact_duration']));
            } else {
                $contact_duration = '';
            }

            $this->model_account_special_products_request->addSpecialProductsForm($this->request->post, $image, $technical_specification, $protection_type, $aplication_description, $working_conditions, $product_type, $requested_material, $respiratory_protection_gases, $respiratory_protection_dust, $heat_transmission, $protection_level, $chemical_substance_name, $CAS_number, $contact_duration);

            $subject = $this->language->get('mail_subject_special_products');
            $message = $this->language->get('mail_message_special_products') . " " . $this->customer->getFirstName() . " " . $this->customer->getLastName();
            $message .= $this->language->get('text_mail_address') . " " . $this->customer->getEmail() . "\n\n";

            $special_product_form_entries = $this->model_account_special_products_request->getSpecialProductsForm($this->customer->getId());
            echo "<pre>";
            print_r($special_product_form_entries);
            echo "<pre>";

            foreach ($special_product_form_entries as $special_product_form_entrie) {
                $message .= $this->language->get('text_customer') . "\n\t" . $special_product_form_entrie['customer'] . "\n";
                $message .= $this->language->get('text_customer_type') . "\n\t" . $special_product_form_entrie['customer_type'] . "\n";
                $message .= $this->language->get('text_av_rv') . "\n\t" . $special_product_form_entrie['av_rv'] . "\n";
                $message .= $this->language->get('text_requested_delivery_term') . "\n\t" . $special_product_form_entrie['requested_delivery_term'] . "\n";
                $message .= $this->language->get('text_product_description') . "\n\t" . $special_product_form_entrie['product_description'] . "\n";
                $message .= $this->language->get('text_aplication_description') . "\n\t" . $special_product_form_entrie['aplication_description'] . "\n";
                $message .= $this->language->get('text_working_conditions') . "\n\t" . $special_product_form_entrie['working_conditions'] . "\n";
                if ($special_product_form_entrie['protection_type']) {
                    $message .= $this->language->get('text_protection_type') . "\n\t" . $special_product_form_entrie['protection_type'] . "\n";    
                }
                if ($special_product_form_entrie['technical_specification']) {
                    $message .= $this->language->get('text_technical_specifications') . "\n\t" . $special_product_form_entrie['technical_specification'] . "\n";
                }
                if ($special_product_form_entrie['chemical_substance_name'] && $special_product_form_entrie['CAS_number'] && $special_product_form_entrie['contact_duration']) {
                    $message .= $this->language->get('text_chemical_substance_name') . "\n\t" . $special_product_form_entrie['chemical_substance_name'] . "\n";
                    $message .= $this->language->get('text_CAS_number') . "\n\t" . $special_product_form_entrie['CAS_number'] . "\n";
                    $message .= $this->language->get('text_contact_duration') . "\n\t" . $special_product_form_entrie['contact_duration'] . "\n";
                }
                if ($special_product_form_entrie['heat_transmission'] && $special_product_form_entrie['temperature']) {
                    $message .= $this->language->get('text_heat_transmission_mode') . "\n\t" . $special_product_form_entrie['heat_transmission'] . "\n";
                    $message .= $this->language->get('text_temperature') . "\n\t" . $special_product_form_entrie['temperature'] . "\n";
                }
                if ($special_product_form_entrie['protection_level']) {
                    $message .= $this->language->get('text_protection_level') . "\n\t" . $special_product_form_entrie['protection_level'] . "\n";
                }
                if ($special_product_form_entrie['respiratory_protection_gases']) {
                    $message .= $this->language->get('text_respiratory_protection_gases') . "\n\t" . $special_product_form_entrie['respiratory_protection_gases'] . "\n";
                }
                if ($special_product_form_entrie['respiratory_protection_dust']) {
                    $message .= $this->language->get('text_respiratory_protection_dust') . "\n\t" . $special_product_form_entrie['respiratory_protection_dust'] . "\n";
                }
                $message .= $this->language->get('text_product_type') . "\n\t" . $special_product_form_entrie['product_type'] . "\n";
                if ($special_product_form_entrie['requested_material']) {
                    $message .= $this->language->get('text_requested_material') . "\n\t" . $special_product_form_entrie['requested_material'] . "\n";
                }
                if ($special_product_form_entrie['grammage']) {
                    $message .= $this->language->get('text_grammage') . "\n\t" . $special_product_form_entrie['grammage'] . "\n";
                }
                if ($special_product_form_entrie['color']) {
                    $message .= $this->language->get('text_color') . "\n\t" . $special_product_form_entrie['color'] . "\n";
                }
                $message .= $this->language->get('text_next_months_quantity') . "\n\t" . $this->language->get('text_quantity') . " " . $special_product_form_entrie['quantity'] . "\n\t" .
                            $this->language->get('text_unit') . " " . $special_product_form_entrie['unit'] . "\n";
                $message .= $this->language->get('text_initial_order_quantity') . "\n\t" . $this->language->get('text_quantity') . " " . $special_product_form_entrie['initial_quantity'] . "\n\t" .
                            $this->language->get('text_unit') . " " . $special_product_form_entrie['initial_unit'] . "\n";
                $message .= $this->language->get('text_order_total_value') . " " . $special_product_form_entrie['total_value'] . " " . $this->language->get('text_ron') . "\n";
                $message .= $this->language->get('text_target_price') . " " . $special_product_form_entrie['target_price'] . " " . $this->language->get('text_ron') . "\n\t" .
                            $this->language->get('text_unit') . " " . $special_product_form_entrie['target_unit'] . "\n";
                $message .= $this->language->get('text_product_category') . "\n\t" . $special_product_form_entrie['product_category'] . "\n";
                $message .= $this->language->get('text_sales_arguments') . "\n\t" . $special_product_form_entrie['sales_arguments'] . "\n";
                $message .= $this->language->get('text_regional_manager_approval') . " ";
                if ($special_product_form_entrie['manager_approval'] == 1) {
                    $message .= $this->language->get('text_yes') . "\n";
                } else {
                    $message .= $this->language->get('text_no') . "\n";
                }
                $message .= $this->language->get('text_order_date_estimation') . "\n\t";
                $message .= $this->language->get('text_first_batch') . " ";
                strtotime($special_product_form_entrie['first_batch']) > 0 ? $message .= $special_product_form_entrie['first_batch'] . "\n\t" : $message .= " " . "\n\t";
                $message .= $this->language->get('text_second_batch') . " ";
                strtotime($special_product_form_entrie['second_batch']) > 0 ? $message .= $special_product_form_entrie['second_batch'] . "\n\t" : $message .= " " . "\n\t";
                $message .= $this->language->get('text_third_batch') . " ";
                strtotime($special_product_form_entrie['third_batch']) > 0 ? $message .= $special_product_form_entrie['third_batch'] . "\n\t" : $message .= " " . "\n\t";
                $message .= $this->language->get('text_fourth_batch') . " ";
                strtotime($special_product_form_entrie['fourth_batch']) > 0 ? $message .= $special_product_form_entrie['fourth_batch'] . "\n\t" : $message .= " " . "\n\t";
                $message .= $this->language->get('text_fifth_batch') . " ";
                strtotime($special_product_form_entrie['fifth_batch']) > 0 ? $message .= $special_product_form_entrie['fifth_batch'] . "\n\t" : $message .= " " . "\n\t";
                $message .= $this->language->get('text_sixth_batch') . " ";
                strtotime($special_product_form_entrie['sixth_batch']) > 0 ? $message .= $special_product_form_entrie['sixth_batch'] . "\n" : $message .= " " . "\n";
                $message .= $this->language->get('text_existent_alternative_products') . "\n\t" . $this->language->get('text_alternative_products') . "\n\t\t" . $special_product_form_entrie['alternative_products'] . "\n\t" .
                            $this->language->get('text_customer_feedback') . "\n\t\t" . $special_product_form_entrie['customer_feedback'] . "\n";
                $message .= $this->language->get('text_new_provider') . "\n\t" . $this->language->get('text_provider_name') . " " . $special_product_form_entrie['provider_name'] . "\n\t" .
                            $this->language->get('text_identified_circumstances') . "\n\t\t" . $special_product_form_entrie['identified_circumstances'] . "\n";
                $message .= $this->language->get('text_other_informations') . "\n\t" . $special_product_form_entrie['other_informations'] . "\n";
            }

            $mail = new Mail();
                $mail->protocol = $this->config->get('config_mail_protocol');
                $mail->parameter = $this->config->get('config_mail_parameter');
                $mail->hostname = $this->config->get('config_smtp_host');
                $mail->username = $this->config->get('config_smtp_username');
                $mail->password = $this->config->get('config_smtp_password');
                $mail->port = $this->config->get('config_smtp_port');
                $mail->timeout = $this->config->get('config_smtp_timeout');
				if($special_product_form_entrie['product_category'] == 'INCALTAMINTE'){
					$mail->setTo('incaltaminte@renania.ro');
				}else if($special_product_form_entrie['product_category'] == 'IMBRACAMINTE'){
					$mail->setTo('imbracaminte@renania.ro');
				}else if($special_product_form_entrie['product_category'] == 'MANUSI'){
					$mail->setTo('manusi@renania.ro');
				}else if($special_product_form_entrie['product_category'] == 'CASTI DE PROTECTIE'){
					$mail->setTo('protectia.capului@renania.ro');
				}else if($special_product_form_entrie['product_category'] == 'PROTECTIE VIZUALA'){
					$mail->setTo('protectia.capului@renania.ro');
				}else if($special_product_form_entrie['product_category'] == 'PROTECTIE AUDITIVA'){
					$mail->setTo('protectia.capului@renania.ro');
				}else if($special_product_form_entrie['product_category'] == 'PROTECTIE RESPIRATORIE'){
					$mail->setTo('protectia.capului@renania.ro');
				}else if($special_product_form_entrie['product_category'] == 'LUCRU LA INALTIME'){
					$mail->setTo('lucru.inaltime@renania.ro');
				}else if($special_product_form_entrie['product_category'] == 'ARTICOLE TEHNICE'){
					$mail->setTo('tehnice.curatenie@renania.ro');
				}else if($special_product_form_entrie['product_category'] == 'CURATENIE SI IGIENA'){
					$mail->setTo('tehnice.curatenie@renania.ro');
				}else{
					$mail->setTo('claudia.grec@renania.ro');
				}
                $mail->setFrom($this->config->get('config_email'));
                $mail->setSender($this->config->get('config_name'));
                $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
                $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
                $mail->AddAttachment($attachment);
                $mail->send();
            $this->redirect($this->url->link('account/account', '', 'SSL'));
        }

        $this->data['add_form'] = $this->url->link('account/special_products_request/specialproductsrequest', '', 'SSL');

        if( file_exists( DIR_TEMPLATE.$this->config->get('config_template').'/template/account/special_products_request_form.tpl'))
        {
            $this->template = $this->config->get('config_template').'/template/account/special_products_request_form.tpl';
        }
        else
        {
            $this->template = 'default/template/account/special_products_request_form.tpl';
        }

        $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/header'
        );

        $this->response->setOutput($this->render());
    }
}

?>