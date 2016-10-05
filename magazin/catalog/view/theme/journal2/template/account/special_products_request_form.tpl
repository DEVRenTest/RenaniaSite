<?php echo $header; ?>
<div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
</div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
    <form name="special_products_form" onsubmit="return validateForm()" method="post" enctype="multipart/form-data">
    <div class="special_products_form_buttons">
      <div style="float:left;"><a href="<?php echo $add_form; ?>" class="button"><?php echo $add_form_button; ?></a></div>
      <div style="float:right;"><input type="submit" name="submit" value='<?php echo $first_upload_form_button ?>' class="button" /></div>
    </div>
    <h1 class="heading-title"><center><?php echo $heading_title; ?></center></h1>
    <?php echo $content_top; ?>
      <table class="special_products_form">
        <tr>
          <td>
            <?php echo $text_product_category; ?><span class="required">*</span>
            <select id="product_category" name="product_category" required="required">
              <option value=""><?php echo $text_select_category; ?></option>
              <?php foreach ($product_categories as $product_category) { ?>
                <option value="<?php echo $product_category['name']; ?>"><?php echo $product_category['name']; ?></option>
              <?php } ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $text_customer; ?><span class="required">*</span>
            <input type="text" name="customer" style="width: auto;" /></br>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $text_customer_type; ?><span class="required">*</span>
            <select name="customer_type" required="required">
              <option value=""><?php echo $text_select_category; ?></option>
              <?php foreach ($customer_types as $customer_type) { ?>
                <option value="<?php echo $customer_type; ?>"><?php echo $customer_type; ?></option>
              <?php } ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $text_av_rv; ?><span class="required">*</span>
            <input type="text" name="av_rv" style="width: auto;" /></br>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $text_requested_delivery_term; ?><span class="required">*</span>
            <input type="date" class="date" name="requested_delivery_term" style="width: auto;" /></br>
          </td>
        </tr>
      	<tr>
          <td>
      			<?php echo $text_product_description; ?><span class="required">*</span></br>
      			<textarea type="text" name="product_description" required="required" style="width: 80%;"></textarea></br>
    		  </td>
      	</tr>
        </table>
        <div class="footwear box">
          <table class="special_products_form">
            <tr>
              <td>
                <?php echo $text_aplication_description; ?><span class="required">*</span></br>
                <textarea type="text" name="aplication_description[]" required="required" style="width: 60%;"></textarea></br>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $text_working_conditions; ?><span class="required">*</span></br>
                <textarea type="text" name="working_conditions[]" required="required" style="width: 60%;"></textarea></br>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $text_protection_type; ?><span class="required">*</span>
                <input type="checkbox" name="protection_type[]" value="non safety" /><?php echo $text_non_safety; ?>
                <input type="checkbox" name="protection_type[]" value="O1" /><?php echo $text_O1; ?>
                <input type="checkbox" name="protection_type[]" value="O2" /><?php echo $text_O2; ?>
                <input type="checkbox" name="protection_type[]" value="O3" /><?php echo $text_O3; ?>
                <input type="checkbox" name="protection_type[]" value="O4" /><?php echo $text_O4; ?>
                <input type="checkbox" name="protection_type[]" value="OB" /><?php echo $text_OB; ?>
                <input type="checkbox" name="protection_type[]" value="S1" /><?php echo $text_S1; ?>
                <input type="checkbox" name="protection_type[]" value="S1P" /><?php echo $text_S1P; ?>
                <input type="checkbox" name="protection_type[]" value="S2" /><?php echo $text_S2; ?>
                <input type="checkbox" name="protection_type[]" value="S3" /><?php echo $text_S3; ?>
                <input type="checkbox" name="protection_type[]" value="S4" /><?php echo $text_S4; ?>
                <input type="checkbox" name="protection_type[]" value="S5" /><?php echo $text_S5; ?>
                <input type="checkbox" name="protection_type[]" value="SB" /><?php echo $text_SB; ?></br>
                &emsp;&emsp;&emsp;&emsp;<input type="checkbox" name="protection_type[]" value="SB_P" /><?php echo $text_SB_P; ?>
                <input type="checkbox" name="protection_type[]" value="A E P FO WRU" /><?php echo $text_A_E_P_FO_WRU; ?>
                <input type="checkbox" name="protection_type[]" value="F2A CI HI3 SRC" /><?php echo $text_F2A_CI_HI3_SRC; ?>
                <input type="checkbox" name="protection_type[]" value="F2A CI HI3 SRC - A E P FO WRU" /><?php echo $text_F2A_CI_HI3_SRC__A_E_P_FO_WRU; ?></br>
                &emsp;&emsp;&emsp;&emsp;<input type="checkbox" value="other protection type" /><?php echo $text_other_type; ?>
                <div class="other_protection_type" style="display: none;">
                  &emsp;&emsp;&emsp;&emsp;<input type="text" name="protection_type[]" style="width: auto;" />
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $text_technical_specifications; ?><span class="required">*</span>
                <input type="checkbox" name="technical_specification[]" value="WR" /><?php echo $text_WR; ?>
                <input type="checkbox" name="technical_specification[]" value="SRC" /><?php echo $text_SRC; ?>
                <input type="checkbox" name="technical_specification[]" value="HRO" /><?php echo $text_HRO; ?>
                <input type="checkbox" name="technical_specification[]" value="HI" /><?php echo $text_HI; ?>
                <input type="checkbox" name="technical_specification[]" value="M" /><?php echo $text_M; ?>
                <input type="checkbox" name="technical_specification[]" value="CI" /><?php echo $text_CI; ?>
                <input type="checkbox" name="technical_specification[]" value="CR" /><?php echo $text_CR; ?>
                <input type="checkbox" name="technical_specification[]" value="ESD" /><?php echo $text_ESD; ?>
                <input type="checkbox" name="technical_specification[]" value="Metal free" /><?php echo $text_Metal_free; ?>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $text_product_type; ?><span class="required">*</span>
                <select name="product_type[]" required="required">
                  <option value=""><?php echo $text_select_category; ?></option>
                  <?php foreach ($footwear_product_types as $product_type) { ?>
                    <option value="<?php echo $product_type; ?>"><?php echo $product_type; ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $text_requested_material; ?><span class="required">*</span>
                <select class="other_footwear_requested_material" name="requested_material[]">
                  <option value=""><?php echo $text_select_category; ?></option>
                  <?php foreach ($footwear_requested_materials as $requested_material) { ?>
                    <option value="<?php echo $requested_material; ?>"><?php echo $requested_material; ?></option>
                  <?php } ?>
                  <option value=""><?php echo $text_other_requested_material; ?></option>
                </select>
                <div class="other_footwear_requested_material_box" style="display: none;">
                  &emsp;&emsp;&emsp;&emsp;<?php echo $text_other_type; ?><input type="text" name="requested_material[]" style="width: auto;" required="required" />
                </div>
              </td>
            </tr>
          </table>
        </div>
        <div class="clothing box">
          <table class="special_products_form">
            <tr>
              <td>
                <?php echo $text_aplication_description; ?><span class="required">*</span></br>
                <textarea type="text" name="aplication_description[]" required="required" style="width: 60%;"></textarea></br>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $text_working_conditions; ?><span class="required">*</span></br>
                <textarea type="text" name="working_conditions[]" required="required" style="width: 60%;"></textarea></br>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $text_protection_type; ?><span class="required">*</span>
                <input type="checkbox" name="protection_type[]" value="Articole complementare" /><?php echo $text_complementary_products; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie antistatica" /><?php echo $text_antistatic_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie caldura" /><?php echo $text_heat_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie chimica" /><?php echo $text_chemical_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie cleanroom" /><?php echo $text_cleanroom_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie ESD" /><?php echo $text_ESD_protection; ?></br>
                &emsp;&emsp;&emsp;&emsp;<input type="checkbox" name="protection_type[]" value="Protectie forestieri" /><?php echo $text_forest_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie frig" /><?php echo $text_cold_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie inalta vizibilitate" /><?php echo $text_high_visibility_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie ploaie" /><?php echo $text_rain_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie pompieri" /><?php echo $text_fire_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie riscuri minime" /><?php echo $text_minimum_risk_protection; ?></br>
                &emsp;&emsp;&emsp;&emsp;<input type="checkbox" name="protection_type[]" value="Protectie riscuri minime-iarna" /><?php echo $text_minimum_risk_protection_winter; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie riscuri minime-ploaie" /><?php echo $text_minimum_risk_protection_rain; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie sudura" /><?php echo $text_welding_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie taiere" /><?php echo $text_cutting_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Unica folosinta" /><?php echo $text_single_use; ?></br>
                &emsp;&emsp;&emsp;&emsp;<input type="checkbox" value="other protection type" /><?php echo $text_other_type; ?>
                <div class="other_protection_type" style="display: none;">
                  &emsp;&emsp;&emsp;&emsp;<input type="text" name="protection_type[]" style="width: auto;" />
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <div class="clothing_technical_specifications" style="display: none;">
                  <?php echo $text_technical_specifications; ?><span class="required">*</span></br>
                  &emsp;&emsp;&emsp;&emsp;<?php echo $text_chemical_substance_name; ?><input type="text" name="chemical_substance_name[]" style="width: auto;" /></br>
                  &emsp;&emsp;&emsp;&emsp;<?php echo $text_CAS_number; ?><input type="text" name="CAS_number[]" style="width: auto;" /></br>
                  &emsp;&emsp;&emsp;&emsp;<?php echo $text_contact_duration; ?><input type="text" name="contact_duration[]" style="width: auto;" /></br>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $text_product_type; ?><span class="required">*</span>
                <select name="product_type[]" required="required">
                  <option value=""><?php echo $text_select_category; ?></option>
                  <?php foreach ($clothing_product_types as $product_type) { ?>
                    <option value="<?php echo $product_type; ?>"><?php echo $product_type; ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $text_requested_material; ?><span class="required">*</span>
                <select class="other_clothing_requested_material" name="requested_material[]">
                  <option value=""><?php echo $text_select_category; ?></option>
                  <?php foreach ($clothing_requested_materials as $requested_material) { ?>
                    <option value="<?php echo $requested_material; ?>"><?php echo $requested_material; ?></option>
                  <?php } ?>
                  <option value=""><?php echo $text_other_requested_material; ?></option>
                </select>
                <div class="other_clothing_requested_material_box" style="display: none;">
                  &emsp;&emsp;&emsp;&emsp;<?php echo $text_other_type; ?><input type="text" name="requested_material[]" style="width: auto;" required="required" />
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $text_grammage; ?>
                <input type="text" name="grammage" style="width: auto;" /></br>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $text_color; ?><span class="required">*</span>
                <input type="text" name="color" required="required" style="width: auto;" /></br>
              </td>
            </tr>
          </table>
        </div>
        <div class="gloves box">
          <table class="special_products_form">
            <tr>
              <td>
                <?php echo $text_aplication_description; ?><span class="required">*</span></br>
                <textarea type="text" name="aplication_description[]" required="required" style="width: 60%;"></textarea></br>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $text_working_conditions; ?><span class="required">*</span></br>
                <textarea type="text" name="working_conditions[]" required="required" style="width: 60%;"></textarea></br>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $text_protection_type; ?><span class="required">*</span>
                <input type="checkbox" name="protection_type[]" value="Manusi electroizolante" /><?php echo $text_insulating_gloves; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie anti-vibratii" /><?php echo $text_anti_vibration_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie caldura" /><?php echo $text_heat_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie chimica" /><?php echo $text_chemical_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie ESD" /><?php echo $text_ESD_protection; ?></br>
                &emsp;&emsp;&emsp;&emsp;<input type="checkbox" name="protection_type[]" value="Protectie forestieri" /><?php echo $text_forest_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie impact" /><?php echo $text_impact_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie intepatura" /><?php echo $text_sting_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie la frig" /><?php echo $text_cold_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie mecanica" /><?php echo $text_mechanical_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie pompieri" /><?php echo $text_fire_protection; ?></br>
                &emsp;&emsp;&emsp;&emsp;<input type="checkbox" name="protection_type[]" value="Protectie riscuri minime" /><?php echo $text_minimum_risk_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie sudori" /><?php echo $text_welding_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie taiere" /><?php echo $text_cutting_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Unica folosinta" /><?php echo $text_single_use; ?></br>
                &emsp;&emsp;&emsp;&emsp;<input type="checkbox" value="other protection type" /><?php echo $text_other_type; ?>
                <div class="other_protection_type" style="display: none;">
                    &emsp;&emsp;&emsp;&emsp;<input type="text" name="protection_type[]" style="width: auto;" />
                </div>
            </tr> 
            <tr>
              <td>
                <div class="gloves_technical_specifications" style="display: none;">
                    <?php echo $text_technical_specifications; ?><span class="required">*</span></br>
                </div>
                <div class="heat_protection" style="display: none;">
                    &emsp;&emsp;&emsp;&emsp;<?php echo $text_heat_transmission_mode; ?>
                    <input type="checkbox" name="heat_transmission[]" value="Caldura contact" /><?php echo $text_contact_heat; ?>
                    <input type="checkbox" name="heat_transmission[]" value="Caldura radianta" /><?php echo $text_radiant_heat; ?>
                    <input type="checkbox" name="heat_transmission[]" value="Caldura convectiva" /><?php echo $text_convective_heat; ?>
                    <input type="checkbox" name="heat_transmission[]" value="Metal topit" /><?php echo $text_molten_metal; ?></br>                
                    &emsp;&emsp;&emsp;&emsp;<?php echo $text_temperature; ?><input type="text" name="temperature" style="width: auto;" /></br>
                </div>
                <div class="chemical_protection" style="display: none;">
                    &emsp;&emsp;&emsp;&emsp;<?php echo $text_chemical_substance_name; ?><input type="text" name="chemical_substance_name[]" style="width: auto;" /></br>
                    &emsp;&emsp;&emsp;&emsp;<?php echo $text_CAS_number; ?><input type="text" name="CAS_number[]" style="width: auto;" /></br>
                    &emsp;&emsp;&emsp;&emsp;<?php echo $text_contact_duration; ?><input type="text" name="contact_duration[]" style="width: auto;" /></br>
                </div>
                <div class="cutting_protection" style="display: none;">
                    &emsp;&emsp;&emsp;&emsp;<?php echo $text_protection_level; ?>
                    <input type="checkbox" name="protection_level[]" value="2" /><?php echo $text_protection_2; ?>
                    <input type="checkbox" name="protection_level[]" value="3" /><?php echo $text_protection_3; ?>
                    <input type="checkbox" name="protection_level[]" value="4" /><?php echo $text_protection_4; ?>
                    <input type="checkbox" name="protection_level[]" value="5" /><?php echo $text_protection_5; ?></br>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $text_product_type; ?><span class="required">*</span>
                <select name="product_type[]" required="required">
                  <option value=""><?php echo $text_select_category; ?></option>
                  <?php foreach ($gloves_product_types as $product_type) { ?>
                    <option value="<?php echo $product_type; ?>"><?php echo $product_type; ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>
          </table>
        </div>
        <div class="head_protection box">
          <table class="special_products_form">
            <tr>
              <td>
                <?php echo $text_aplication_description; ?><span class="required">*</span></br>
                <textarea type="text" name="aplication_description[]" required="required" style="width: 60%;"></textarea></br>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $text_working_conditions; ?><span class="required">*</span></br>
                <textarea type="text" name="working_conditions[]" required="required" style="width: 60%;"></textarea></br>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $text_protection_type; ?><span class="required">*</span>
                <input type="checkbox" name="protection_type[]" value="Aductiune aer" /><?php echo $text_air_culvert; ?>
                <input type="checkbox" name="protection_type[]" value="Casti de protectie" /><?php echo $text_helmets; ?>
                <input type="checkbox" name="protection_type[]" value="Presiune pozitiva si aductie aer" /><?php echo $text_positive_pressure_and_air_supplied; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie auditiva" /><?php echo $text_hearing_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie respiratorie gaze-vapori" /><?php echo $text_respiratory_protection_gases; ?></br>
                &emsp;&emsp;&emsp;&emsp;<input type="checkbox" name="protection_type[]" value="Protectie respiratorie pulberi" /><?php echo $text_respiratory_protection_dust; ?>
                <input type="checkbox" name="protection_type[]" value="Protectie vizuala" /><?php echo $text_visual_protection; ?>
                <input type="checkbox" name="protection_type[]" value="Sudura" /><?php echo $text_welding; ?></br>
                &emsp;&emsp;&emsp;&emsp;<input type="checkbox" value="other protection type" /><?php echo $text_other_type; ?>
                <div class="other_protection_type" style="display: none;">
                    &emsp;&emsp;&emsp;&emsp;<input type="text" name="protection_type[]" style="width: auto;" />
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <div class="respiratory_protection_gases" style="display: none;">
                    <?php echo $text_technical_specifications; ?><span class="required">*</span>
                    <input type="checkbox" name="respiratory_protection_gases[]" value="Gaze si vapori organici cu punct de fierbere ≤ 65°C" /><?php echo $text_gas_organic_vapors_smaller_boiling_point; ?>
                    <input type="checkbox" name="respiratory_protection_gases[]" value="Gaze si vapori organici cu punct de fierbere > 65°C" /><?php echo $text_gas_organic_vapors_bigger_boiling_point; ?></br>
                    &emsp;&emsp;&emsp;&emsp;<input type="checkbox" name="respiratory_protection_gases[]" value="Vapori anorganici" /><?php echo $text_organic_vapors; ?>
                    <input type="checkbox" name="respiratory_protection_gases[]" value="Dioxid de sulf, acid clorhidric" /><?php echo $text_sulfur_dioxide_hydrochloric_acid; ?>
                    <input type="checkbox" name="respiratory_protection_gases[]" value="Amoniac" /><?php echo $text_ammonia; ?>
                    <input type="checkbox" name="respiratory_protection_gases[]" value="Monoxid de carbon" /><?php echo $text_carbon_monoxide; ?>
                    <input type="checkbox" name="respiratory_protection_gases[]" value="Mercur" /><?php echo $text_mercury; ?>
                    <input type="checkbox" name="respiratory_protection_gases[]" value="Gaze nitrice" /><?php echo $text_nitrous_gases; ?>
                    <input type="checkbox" name="respiratory_protection_gases[]" value="Iod radioactiv" /><?php echo $text_radioiodine; ?>
                    <input type="checkbox" name="respiratory_protection_gases[]" value="Particule" /><?php echo $text_particles; ?>
                </div>
                <div class="respiratory_protection_dust" style="display: none;">
                    <input type="checkbox" name="respiratory_protection_dust[]" value="FFP1" /><?php echo $text_FFP1; ?>
                    <input type="checkbox" name="respiratory_protection_dust[]" value="FFP2" /><?php echo $text_FFP2; ?>
                    <input type="checkbox" name="respiratory_protection_dust[]" value="FFP3" /><?php echo $text_FFP3; ?></br>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $text_product_type; ?><span class="required">*</span>
                <select name="product_type[]" required="required">
                  <option value=""><?php echo $text_select_category; ?></option>
                  <?php foreach ($head_protection_product_types as $product_type) { ?>
                    <option value="<?php echo $product_type; ?>"><?php echo $product_type; ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>
          </table>
        </div>
        <div class="working_at_height box">
          <table class="special_products_form">
            <tr>
              <td>
                <?php echo $text_aplication_description; ?><span class="required">*</span></br>
                <textarea type="text" name="aplication_description[]" required="required" style="width: 60%;"></textarea></br>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $text_working_conditions; ?><span class="required">*</span></br>
                <textarea type="text" name="working_conditions[]" required="required" style="width: 60%;"></textarea></br>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $text_product_type; ?><span class="required">*</span>
                <select class="working_at_height_product_type" name="product_type[]" required="required">
                  <option value=""><?php echo $text_select_category; ?></option>
                  <?php foreach ($working_at_height_product_types as $product_type) { ?>
                    <option value="<?php echo $product_type; ?>"><?php echo $product_type; ?></option>
                  <?php } ?>
                  <option value=" "><?php echo $text_other_working_at_height_product_type; ?></option>
                </select></br>
                <div class="other_working_at_height_product_type_box" style="display: none;">
                    &emsp;&emsp;&emsp;&emsp;<?php echo $text_other_type; ?><input type="text" name="product_type[]" style="width: auto;" />
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $text_technical_specifications; ?><span class="required">*</span>
                <div class="carabiners technical_specifications_box">
                    <select class="carabiners_technical_specifications" name="technical_specification[]" required="required">
                      <option value=""><?php echo $text_select_category; ?></option>
                      <?php foreach ($carabiners as $carabiner) { ?>
                        <option value="<?php echo $carabiner; ?>"><?php echo $carabiner; ?></option>
                      <?php } ?>
                    </select>
                </div>
                <div class="belts technical_specifications_box">
                    <select class="belts_technical_specifications" name="technical_specification[]" required="required">
                      <option value=""><?php echo $text_select_category; ?></option>
                      <?php foreach ($belts as $belt) { ?>
                        <option value="<?php echo $belt; ?>"><?php echo $belt; ?></option>
                      <?php } ?>
                    </select>
                </div>
                <div class="strings technical_specifications_box">
                    <select class="strings_technical_specifications" name="technical_specification[]" required="required">
                      <option value=""><?php echo $text_select_category; ?></option>
                      <?php foreach ($strings as $string) { ?>
                        <option value="<?php echo $string; ?>"><?php echo $string; ?></option>
                      <?php } ?>
                    </select>
                </div>
                <div class="strips technical_specifications_box">
                    <select class="strips_technical_specifications" name="technical_specification[]" required="required">
                      <option value=""><?php echo $text_select_category; ?></option>
                      <?php foreach ($strips as $strip) { ?>
                        <option value="<?php echo $strip; ?>"><?php echo $strip; ?></option>
                      <?php } ?>
                    </select>
                </div>
                <div class="means_link technical_specifications_box">
                    <select class="means_link_technical_specifications" name="technical_specification[]" required="required">
                      <option value=""><?php echo $text_select_category; ?></option>
                      <?php foreach ($means_link as $means_link) { ?>
                        <option value="<?php echo $means_link; ?>"><?php echo $means_link; ?></option>
                      <?php } ?>
                    </select>
                </div>
                <div class="fall_dykes technical_specifications_box">
                    <select class="fall_dykes_technical_specifications" name="technical_specification[]" required="required">
                      <option value=""><?php echo $text_select_category; ?></option>
                      <?php foreach ($fall_dykes as $fall_dyke) { ?>
                        <option value="<?php echo $fall_dyke; ?>"><?php echo $fall_dyke; ?></option>
                      <?php } ?>
                    </select>
                </div>
              </td>
            </tr>
          </table>
        </div>
        <table class="special_products_form">
        <tr>
          <td>
            <?php echo $text_next_months_quantity; ?><span class="required">*</span></br>
            &emsp;&emsp;<?php echo $text_quantity; ?> <input type="text" name="quantity" required="required" style="width: auto;" />
            &emsp;&emsp;&emsp;&emsp;<?php echo $text_unit; ?> <input type="text" name="unit" required="required" style="width: auto;" />
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $text_initial_order_quantity; ?><span class="required">*</span></br>
            &emsp;&emsp;<?php echo $text_quantity; ?> <input type="text" name="initial_quantity" required="required" style="width: auto;" />
            &emsp;&emsp;&emsp;&emsp;<?php echo $text_unit; ?> <input type="text" name="initial_unit" required="required" style="width: auto;" /></br>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $text_order_total_value; ?><span class="required">*</span>
            <input type="text" name="total_value" required="required" style="width: auto;" /> <?php echo $text_ron; ?></br>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $text_target_price; ?><span class="required">*</span>
            <input type="text" name="target_price" required="required" style="width: auto;" /> <?php echo $text_ron; ?></br>
            &emsp;&emsp;<?php echo $text_unit; ?> <input type="text" name="target_unit" required="required" style="width: auto;" /></br>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $text_sales_arguments; ?><span class="required">*</span></br>
            <textarea type="text" name="sales_arguments" required="required" style="width: 80%;"></textarea></br>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $text_regional_manager_approval; ?><span class="required">*</span>
            <input id="yes" type="radio" name="manager_approval" value="1" checked="checked" /> <?php echo $text_yes; ?>
            <input id="no" type="radio" name="manager_approval" value="0" /> <?php echo $text_no; ?></br>
          </td>
        </tr>
        <tr>
          <td>
              <?php echo $text_order_date_estimation; ?></br>
              &emsp;&emsp;<?php echo $text_first_batch; ?> <input type="date" class="date" name="first_batch" style="width: auto;" />
              <?php echo $text_second_batch; ?> <input type="date" class="date" name="second_batch" style="width: auto;" />
              <?php echo $text_third_batch; ?> <input type="date" class="date" name="third_batch" style="width: auto;" /></br>
              &emsp;&emsp;<?php echo $text_fourth_batch; ?> <input class="date" type="date" name="fourth_batch" style="width: auto;" />
              <?php echo $text_fifth_batch; ?> <input type="date" class="date" name="fifth_batch" style="width: auto;" />
              <?php echo $text_sixth_batch; ?> <input type="date" class="date" name="sixth_batch" style="width: auto;" /></br>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $text_existent_alternative_products; ?></br>
            <?php echo $text_alternative_products; ?>
            <textarea type="text" name="alternative_products" style="width: 80%; height: 20%;"></textarea></br>
            <?php echo $text_customer_feedback; ?>
            <textarea type="text" name="customer_feedback" style="width: 80%;"></textarea></br>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $text_new_provider; ?></br>
            <?php echo $text_provider_name; ?> <input type="text" name="provider_name" style="width: auto;" /></br>
            <?php echo $text_identified_circumstances; ?></br>
            <textarea type="text" name="identified_circumstances" style="width: 80%; height: 20%;"></textarea></br>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $text_other_informations; ?></br>
            <textarea type="text" name="other_informations" style="width: 80%;"></textarea>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $text_special_product_image; ?>
            &emsp;<input type="file" name="image" value="" />
          </td>
        </tr>
      </table>
      <div class="buttons">
        <div class="form_button" style="float: right"><input type="submit" name="submit" value='<?php echo $upload_form_button ?>' class="button" /></div>
      </div>
    </form>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>
<script type="text/javascript"><!--
$(document).ready(function() {
  $('.date').datepicker({
    dateFormat: "yy-mm-dd",
    beforeShow:function(input) {
      $(input).css({
        "position": "relative",
        "z-index": 999999
      });
    }
  });
});
//--></script>
<script type="text/javascript">
function validateForm(formData) {
  if (!this.yes.checked) {
      alert('<?php echo $error_manager_approval; ?>');
      return false;
  }
}
</script>
<script type="text/javascript">
$(document).ready(function(){
    $("#product_category").change(function(){
        $(this).find("option:selected").each(function(){
            if($(this).attr("value")=="INCALTAMINTE"){
                $(".box").not(".footwear").hide();
                $(".footwear").show();
                $(".clothing :input").prop('required' ,null);
                $(".gloves :input").prop('required' ,null);
                $(".head_protection :input").prop('required' ,null);
                $(".working_at_height :input").prop('required' ,null);
            }
            else if($(this).attr("value")=="IMBRACAMINTE"){
                $(".box").not(".clothing").hide();
                $(".clothing").show();
                $(".footwear :input").prop('required' ,null);
                $(".gloves :input").prop('required' ,null);
                $(".head_protection :input").prop('required' ,null);
                $(".working_at_height :input").prop('required' ,null);
            }
            else if($(this).attr("value")=="MANUSI"){
                $(".box").not(".gloves").hide();
                $(".gloves").show();
                $(".footwear :input").prop('required' ,null);
                $(".clothing :input").prop('required' ,null);
                $(".head_protection :input").prop('required' ,null);
                $(".working_at_height :input").prop('required' ,null);
            }
            else if($(this).attr("value")=="CASTI DE PROTECTIE"){
                $(".box").not(".head_protection").hide();
                $(".head_protection").show();
                $(".footwear :input").prop('required' ,null);
                $(".clothing :input").prop('required' ,null);
                $(".gloves :input").prop('required' ,null);
                $(".working_at_height :input").prop('required' ,null);
            }
            else if($(this).attr("value")=="LUCRU LA INALTIME"){
                $(".box").not(".working_at_height").hide();
                $(".working_at_height").show();
                $(".footwear :input").prop('required' ,null);
                $(".clothing :input").prop('required' ,null);
                $(".gloves :input").prop('required' ,null);
                $(".head_protection :input").prop('required' ,null);
            }
            else {
                $(".box").hide();
            }
        });
    }).change();
});
</script>
<script type="text/javascript">
$(document).ready(function(){
    $('input[type="checkbox"]').click(function(){
        if($(this).attr("value")=="other protection type"){
            $(".other_protection_type").toggle();
        }
    });

    $('input[type="checkbox"]').click(function(){
        if($(this).attr("value")=="Protectie chimica"){
            $(".clothing_technical_specifications").toggle();
        }
    });

    $('.other_footwear_requested_material').change(function() {
      if(this.value === ""){
          $(".other_footwear_requested_material_box").show();
      } else {
          $(".other_footwear_requested_material_box").hide();
      }
    });

    $('.other_clothing_requested_material').change(function() {
      if(this.value === ""){
          $(".other_clothing_requested_material_box").show();
      } else {
          $(".other_clothing_requested_material_box").hide();
      }
    });

    $('.working_at_height_product_type').change(function() {
      if(this.value === " "){
          $(".other_working_at_height_product_type_box").show();
      } else {
          $(".other_working_at_height_product_type_box").hide();
      }
    });

    $('input[type="checkbox"]').on('change', function (){
      if(($(this).attr("value")=="Protectie caldura") || ($(this).attr("value")=="Protectie chimica") || ($(this).attr("value")=="Protectie taiere")){
          $(".gloves_technical_specifications").show();
      }
    });

    $('input[type="checkbox"]').click(function(){
      if($(this).attr("value")=="Protectie caldura"){
          $(".heat_protection").toggle();
      }
    });

    $('input[type="checkbox"]').click(function(){
      if($(this).attr("value")=="Protectie chimica"){
          $(".chemical_protection").toggle();
      }
    });

    $('input[type="checkbox"]').click(function(){
      if($(this).attr("value")=="Protectie taiere"){
          $(".cutting_protection").toggle();
      }
    });

    $('input[type="checkbox"]').click(function(){
      if($(this).attr("value")=="Protectie respiratorie gaze-vapori"){
          $(".respiratory_protection_gases").toggle();
      }
    });

    $('input[type="checkbox"]').click(function(){
      if($(this).attr("value")=="Protectie respiratorie pulberi"){
          $(".respiratory_protection_dust").toggle();
      }
    });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
    $(".working_at_height_product_type").change(function(){
        $(this).find("option:selected").each(function(){
            if($(this).attr("value")=="Carabiniere"){
                $(".technical_specifications_box").not(".carabiners").hide();
                $(".carabiners").show();
                $(".belts :input").prop('required' ,null);
                $(".strings :input").prop('required' ,null);
                $(".strips :input").prop('required' ,null);
                $(".means_link :input").prop('required' ,null);
                $(".fall_dykes :input").prop('required' ,null);
            }
            else if($(this).attr("value")=="Centuri"){
                $(".technical_specifications_box").not(".belts").hide();
                $(".belts").show();
                $(".carabiners :input").prop('required' ,null);
                $(".strings :input").prop('required' ,null);
                $(".strips :input").prop('required' ,null);
                $(".means_link :input").prop('required' ,null);
                $(".fall_dykes :input").prop('required' ,null);
            }
            else if($(this).attr("value")=="Corzi"){
                $(".technical_specifications_box").not(".strings").hide();
                $(".strings").show();
                $(".carabiners :input").prop('required' ,null);
                $(".belts :input").prop('required' ,null);
                $(".strips :input").prop('required' ,null);
                $(".means_link :input").prop('required' ,null);
                $(".fall_dykes :input").prop('required' ,null);
            }
            else if($(this).attr("value")=="Franghii"){
                $(".technical_specifications_box").not(".strips").hide();
                $(".strips").show();
                $(".carabiners :input").prop('required' ,null);
                $(".belts :input").prop('required' ,null);
                $(".strings :input").prop('required' ,null);
                $(".means_link :input").prop('required' ,null);
                $(".fall_dykes :input").prop('required' ,null);
            }
            else if($(this).attr("value")=="Mijloace de legatura"){
                $(".technical_specifications_box").not(".means_link").hide();
                $(".means_link").show();
                $(".carabiners :input").prop('required' ,null);
                $(".belts :input").prop('required' ,null);
                $(".strings :input").prop('required' ,null);
                $(".strips :input").prop('required' ,null);
                $(".fall_dykes :input").prop('required' ,null);
            }
            else if($(this).attr("value")=="Opritoare de cadere"){
                $(".technical_specifications_box").not(".fall_dykes").hide();
                $(".fall_dykes").show();
                $(".carabiners :input").prop('required' ,null);
                $(".belts :input").prop('required' ,null);
                $(".strings :input").prop('required' ,null);
                $(".strips :input").prop('required' ,null);
                $(".means_link :input").prop('required' ,null);
            }
            else {
                $(".technical_specifications_box").hide();
                $(".carabiners :input").prop('required' ,null);
                $(".belts :input").prop('required' ,null);
                $(".strings :input").prop('required' ,null);
                $(".strips :input").prop('required' ,null);
                $(".means_link :input").prop('required' ,null);
                $(".fall_dykes :input").prop('required' ,null);
            }
        });
    }).change();
});
</script>