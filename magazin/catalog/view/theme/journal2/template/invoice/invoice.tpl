<table width="800" border="1" cellspacing="0" cellpadding="0" align="center" > 
   <tr>
      <td width="300">
         <table border="0" align="left"> 
            <tr valign="top"> 
               <td>
                  <font size="4"><strong><?php echo $text_supplier; ?></strong>Renania Trade SRL</font> <br /> 
                  <font size="3"><strong><?php echo $text_commercial_register_number; ?></strong> J26/822/1995</font><br /> 
                  <font size="3"><strong><?php echo $text_social_capital; ?></strong> ...</font><br /> 
                  <font size="3"><strong><?php echo $text_registration_code_for_vat_purposes; ?></strong> R0 8006912</font><br /> 
                  <font size="3"><strong><?php echo $text_headquarters; ?></strong> Strada Budiului Nr. 68 540390 Targu Mures , România</font> <br /> 
                  <font size="3"><strong><?php echo $text_county; ?></strong> Mures</font> <br /> 
                  <font size="3"><strong><?php echo $text_account; ?></strong> RO ...... </font> <br /> 
                  <font size="3"><strong><?php echo $text_bank; ?></strong> Banca</font> <br /> 
               </td> 
            </tr> 
         </table> 
      </td>
      <td width="200" align="center">
         <strong><font size="5"><?php echo $heading_title; ?></font></strong>
      </td>
   <td width="300" valign="top">
      <table border="0" cellspacing="1" cellpadding="1" align="right">
         <tr> 
            <td height="22"><strong><font size="4"><?php echo $text_buyer; ?>{COMPANY_NAME}</font></strong></td>
         </tr>
         <tr> 
            <td><?php echo $text_commercial_register_number; ?></td>
         </tr>
         <tr align="right" valign="top" > 
            <td align="left" ><?php echo $text_registration_code_for_vat_purposes; ?></td>
         </tr>    
         <tr align="right" valign="top" > 
            <td align="left" ><?php echo $text_headquarters; ?><?php echo $address[0]['street']; ?> <?php echo $address[0]['city']; ?> <?php echo $address[0]['zipcode']; ?></td>
         </tr>
         <tr align="right" valign="top" > 
            <td align="left" ><?php echo $text_county; ?> <?php echo $address[0]['county']; ?></td>
         </tr>
         <tr align="right" valign="top" > 
            <td align="left" ><?php echo $text_bank; ?></td>
         </tr>
      </table>
   </td>
</tr>
<tr> 
   <td colspan="3">
      <table width="200" border="0" align="center"> 
         <tr> 
            <td valign="top"><strong><?php echo $text_invoice_number; ?>aaa</strong>&nbsp;</td> 
            <td valign="top">{nr factura}</td> 
         </tr> 
         <tr> 
            <td valign="top"><strong><?php echo $text_date_day_month_year; ?></strong>&nbsp;</td> 
            <td valign="top">15/05/2014</td> 
         </tr> 
         <tr> 
            <td valign="top"><strong><?php echo $text_number_accompanying_the_goods; ?></strong>&nbsp;</td> 
            <td valign="top">&nbsp;</td> 
         </tr> 
      </table> 
</tr> 
<tr>
   <td colspan="3">
      <table width="800" border="0" align="center" cellpadding="1" cellspacing="1" > 
         <tr> 
            <td align="center"><br /> 
               <table width="75%" border="0" align="center" cellpadding="3" cellspacing="0" > 
                  <tr align="left" > 
                     <td colspan="4" ><hr size="1" /> </td> 
                  </tr> 
                  <tr align="left" > 
                     <th width="30%"><div align="left"><strong>{LANG_PRODUCT}</strong></div></th> 
                  <th width="20%"><div align="right"><strong>{LANG_PR}</strong></div></th> 
                  <th width="25%"><div align="right"><strong>{LANG_QUANTITY}</strong></div></th> 
                  <th width="25%" align="right"><strong>{LANG_TOTAL}</strong></th> 
         </tr> 
         <!-- BEGIN DYNAMIC BLOCK: row --> 
         <tr> 
            <td ><div align="left">{PRODUCTNAME}</div></td> 
            <td ><div align="right">{PRICE}</div></td> 
            <td ><div align="right">{QUANTITY}</div></td> 
            <td ><div align="right">{TOTAL}</div></td> 
         </tr> 
         <!-- END DYNAMIC BLOCK: row --> 
         <tr> 
            <td colspan="4" ><table width="50%" border="0" align="right" cellpadding="1" cellspacing="0" > 
                  <tr> 
                     <td colspan="3" ><div align="left"><strong>{LANG_SUBTOTPRICE}:</strong></div></td> 
                     <td align="right" ><div align="right"><strong>{SUBTOTAL_PRICE}</strong></div></td> 
                  </tr> 
                  {FINALPRICE}
                  <tr> 
                     <td colspan="3" ><div align="left"><strong>{LANG_TAXA}:</strong></div></td> 
                     <td align="right" ><div align="right"><strong>{SHIPPING_TAXA}</strong></div></td> 
                  </tr> 
                  <tr> 
                     <td colspan="3" ><div align="left"><strong><strong>{LANG_TOTPRICE}</strong>:</strong></div></td> 
                     <td align="right" ><div align="right"><strong>{TOTAL_PRICE}</strong></div></td> 
                  </tr> 
                  <tr> 
                     <td colspan="3" ><div align="left"><strong><font color="#FF0000"><strong>{TAXES_WEIGHT} {TOTAL_WEIGHT}{WEIGHT}</strong></font></strong></div></td> 
                     <td align="right" ><div align="right"><strong><font color="#FF0000">{WEIGHTT}</font></strong></div></td> 
                  </tr> 
                  <tr> 
                     <td colspan="3" ><strong>{LANG_FINPRICE}:</strong></td>
                     <td align="right" ><strong>{FINPR}</strong></td> 
                  </tr> 
                  <tr> 
                     <td colspan="3" ><div align="left"><strong>{PAYEDVIA}:</strong></div></td>
                     <td align="right" ><div align="right"><strong>{FINPR}</strong></div></td> 
                  </tr> 
               </table></td> 
         </tr> 
      </table> 
      <br /> 
      <table width="75%" border="0" align="center" cellpadding="1" cellspacing="1" > 
         <tr> 
            <td width="100%">{LANG_SHIPMENTCOMPLETE}</td> 
         </tr> 
      </table> 
      <br /> 
      <table width="75%" border="0" align="center" cellpadding="1" cellspacing="1" > 
         <tr> 
            <td colspan="2"><hr size="1" /> </td> 
         </tr> 
         <tr> 
            <td width="25%"><div align="left"><strong>{LANG_TRANSPORTMODE}:</strong></div></td> 
            <td width="26%"><div align="right">{TRANSPORT_MODE}</div></td> 
         </tr> 
      </table> 
      <br /> 
      <table width="75%" border="0" align="center" cellpadding="1" cellspacing="1" > 
         <tr> 
            <td colspan="2"><hr size="1" /> </td> 
         </tr> 
         <tr> 
            <td width="23%"><strong>{LANG_USERNOTES}</strong></td> 
            <td width="77%">{USER_NOTES}</td> 
         </tr> 
         <tr> 
            <td><strong>{LANG_ADMINNOTES}</strong></td> 
            <td>{ADMIN_NOTES}</td> 
         </tr> 
      </table></td> 
</tr> 
</table>
</td>
</tr>
</table>