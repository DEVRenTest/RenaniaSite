<?php

class ControllerProductPopulateB2BCustomerData extends Controller
{

    public function index()
    {
        $dir = '/var/www/vhosts/renania.ro/httpdocs/magazin/iunie_19/';

        //$filename = 'CLIENTI.csv';
        //$filename = 'ADRESE.csv';
        //$filename = 'CONTURI_BANCARE.csv';
        //$filename = 'HEADER_FACTURI.csv'; 
        //$filename = 'LINII_FACTURI.csv';
        //$filename = 'FACTURI_SCADENTE.csv';
                
        //$filename = '_clienti.csv';
        //$filename = '_adrese.csv';
        //$filename = '_conturi_bancare.csv';
        //$filename = '_header_facturi.csv';
        //$filename = '_linii_facturi.csv';
       
        //$filename = 'B2B_client.csv'; 
        //$filename = 'B2B_adresa.csv'; 
        $filename = 'B2B_cont_bancar.csv'; 
        
                                      
        $filerow = array( );
        $filerow = @file( $dir.$filename );
        $size = sizeof( $filerow );

        for( $i = 1; $i < $size; $i++ )
        {
            $webdata = explode( ";", $filerow[$i] );

            if( $filename == 'CLIENTI.csv' || $filename == '_clienti.csv' || $filename == 'B2B_client.csv' )
            {
                //  NAME;   ACCOUNTNUM;     ZILEPLATA;  DISCOUNTGENERAL;    DIMENSION2_;    INCHARGE;   VATNUM;     IDENTIFICATIONNUMBER;   CREDITMAX; EMAILFORINVOICE
                $name = trim( $webdata[0]  ); // str_replace( "'", "\'", $webdata[0] )
                $accountnum = trim( $webdata[1] );
                $zileplata = trim( $webdata[2] );
                $discountgeneral = trim( $webdata[3] );
                $dimension2_ = trim( $webdata[4] );
                $incharge = trim( $webdata[5] );
                $vatnum = trim( $webdata[6] );
                $identificationnumber = trim( $webdata[7] );
                $creditmax = trim( $webdata[8] );
                $emailforinvoice = trim( $webdata[9] );

                $insert = "INSERT INTO B2B_client SET name  = '".$name."', accountnum = '".$accountnum."', zileplata = '".$zileplata."', 
                     discountgeneral = '".$discountgeneral."', dimension2_  = '".$dimension2_."', incharge = '".$incharge."', 
                     vatnum = '".$vatnum."', identificationnumber = '".$identificationnumber."', creditmax = '".$creditmax."', emailforinvoice = '".$emailforinvoice."';";
                $this->db->query( $insert );
            }
            else if( $filename == 'ADRESE.csv' || $filename == '_adrese.csv' || $filename == 'B2B_adresa.csv' )
            {
                // ﻿ACCOUNTNUM;  TIPADRESA;  NRCRT;  STREET;   CITY;   COUNTY;     ZIPCODE; RECID; RECVERSION
                $accountnum = trim( $webdata[0] );
                $tipadresa = trim( $webdata[1] );
                $nrcrt = ( int ) $webdata[2];
                $street = trim( $webdata[3]);
                $city = trim( $webdata[4] );
                $county = trim( $webdata[5] );
                $zipcode = trim( $webdata[6] );
                $recid = trim( $webdata[7] );
                $recversion = trim( $webdata[8] );
            
                $insert = "INSERT INTO B2B_adresa SET accountnum  = '".$accountnum."', tipadresa = '".$tipadresa."', nrcrt = '".$nrcrt."',
                    street = '".$street."', city = '".$city."', county = '".$county."', zipcode = '".$zipcode."', recid = '".$recid."', recversion = '".$recversion."' ;";
               //     print "<br>insert=".$insert;
                $this->db->query( $insert );
            }
            else if( $filename == 'CONTURI_BANCARE.csv' || $filename == '_conturi_bancare.csv' || $filename == 'B2B_cont_bancar.csv')
            {
                // ﻿CUSTACCOUNT; IBAN; RECID; RECVERSION
                $custaccount = trim( $webdata[0] );
                $iban = trim( $webdata[1] );
                
                
                $recid = trim( $webdata[2] );
                $custaccount = str_replace( "'", "\'", $custaccount );
                
                $recversion = trim( $webdata[3] );

                $insert = "INSERT INTO `B2B_cont_bancar` SET custaccount  = '".$custaccount."', iban = '".$iban."', recid = '".$recid."', recversion = '".$recversion."' ;";
                //print "<br>insert=".$insert;
                $this->db->query( $insert );
            }
            else if( $filename == 'HEADER_FACTURI.csv' || $filename == '_header_facturi.csv' )
            {
                //﻿INVOICEACCOUNT;   INVOICEID;  INVOICEDATE;    DUEDATE;    CURRENCYCODE;   INVOICEAMOUNT
                $invoiceaccount = trim( $webdata[0] );
                $invoiceid = trim( $webdata[1] );
                $invoicedate = trim( $webdata[2] );
                $duedate = trim( $webdata[3]);
                $currencycode = trim( $webdata[4] );
                $invoiceamount = trim( $webdata[5] );
                
                $insert = "INSERT INTO B2B_antet_factura SET invoiceaccount  = '".$invoiceaccount."', invoiceid = '".$invoiceid."', invoicedate = '".$invoicedate."',
                    duedate = '".$duedate."', currencycode = '".$currencycode."', invoiceamount = '".$invoiceamount."' ;";
               //     print "<br>insert=".$insert;
               $this->db->query( $insert );
            }
            else if( $filename == 'LINII_FACTURI.csv' || $filename == '_linii_facturi.csv')
            {
                //﻿INVOICEACCOUNT;   INVOICEID;  LINENUM;    CODART;  ITEMNAME;   QTY;    SALESUNIT;  CALCNETUNITPRICE;   LINEAMOUNT
                $invoiceaccount = trim( $webdata[0] );
                $invoiceid = trim( $webdata[1] );
                $linenum = trim( $webdata[2] );
                $codart = trim( $webdata[3]);
                $itemname = trim( $webdata[4] );
                $qty = trim( $webdata[5] );
                $salesunit = trim( $webdata[6] );
                $calcnetunitprice = trim( $webdata[7] );
                $lineamount = trim( $webdata[8] );
            
                $insert = "INSERT INTO B2B_linie_factura SET invoiceaccount  = '".$invoiceaccount."', invoiceid = '".$invoiceid."', linenum = '".$linenum."',
                    codart = '".$codart."', itemname = '".$itemname."', qty = '".$qty."', salesunit = '".$salesunit."', calcnetunitprice = '".$calcnetunitprice."', 
                    lineamount = '".$lineamount."' ;";
                //    print "<br>insert=".$insert;
                $this->db->query( $insert );
            }
            else if( $filename == 'FACTURI_SCADENTE.csv' || $filename == '_facturi_scadente.csv')
            {
                //﻿﻿CLIENT;   TIPDOC; NRDOC;  DATADOC;    SCADENTADOC;    MONEDA; SUMA
                $client = trim( $webdata[0] );
                $tipdoc = trim( $webdata[1] );
                $nrdoc = trim( $webdata[2] );
                
                $datadoc = trim( $webdata[3]);
                $exp_datadoc = explode( "/", $datadoc );
                $data_doc = $exp_datadoc[2]."-".$exp_datadoc[1]."-".$exp_datadoc[0];
                
                $scadentadoc = trim( $webdata[4] );
                $exp_scadentadoc = explode( "/", $scadentadoc );
                $scadenta_doc = $exp_scadentadoc[2]."-".$exp_scadentadoc[1]."-".$exp_scadentadoc[0];
                
                $moneda = trim( $webdata[5] );
                $suma = trim( $webdata[6] );
                            
                $insert = "INSERT INTO B2B_factura_scadenta SET client  = '".$client."', tipdoc = '".$tipdoc."', nrdoc = '".$nrdoc."',
                    datadoc = '".$data_doc."', scadentadoc = '".$scadenta_doc."', moneda = '".$moneda."', suma = '".$suma."'  ;";
                //print "<br>insert=".$insert;
                $this->db->query( $insert );
            }
           

        }

        die( 'Minden rendben!' );
    }

}

?>