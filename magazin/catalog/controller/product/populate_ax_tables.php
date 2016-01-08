<?php

class ControllerProductPopulateAxTables extends Controller
{

    public function index()
    {
        $dir = '/var/www/vhosts/renania.ro/httpdocs/magazin/';

        //$filename = '_AX_CUSTOMERS.csv';
        //$filename = '_AX_DISCOUNTS.csv';
        //$filename = '_AX_PRICES.csv';
        $filename = '_AX_STOC.csv'; 

        $filerow = array( );
        $filerow = @file( $dir.$filename );
        $size = sizeof( $filerow );

        for( $i = 1; $i < $size; $i++ )
        {
            $webdata = explode( ";", $filerow[$i] );

            if( $filename == '_AX_CUSTOMERS.csv' )
            {
                //ACCOUNTNUM;  LINEDISC;    PRICEGROUP;  PROCENT_GENERAL
                $accountnum = trim( str_replace( "'", "\'", $webdata[0] ) );
                $linedisc = trim( $webdata[1] );
                $pricegroup = trim( $webdata[2] );
                $procent_general = ( int ) $webdata[3];

                $insert = "INSERT INTO _AX_CUSTOMERS SET accountnum  = '".$accountnum."', linedisc = '".$linedisc."', pricegroup = '".$pricegroup."', procent_general = '".$procent_general."';";

                $this->db->query( $insert );
            }
            else if( $filename == '_AX_DISCOUNTS.csv' )
            {
                // ITEMRELATION; ACCOUNTRELATION; QUANTITYAMOUNT; FROMDATE; TODATE; PERCENT1; PERCENT2; UNITID; INVENTDIMID; RECID; RECVERSION;INVENTCOLORID; 
                // INVENTSIZE; CONFIGID; CONCATENAT
                $itemrelation = trim( $webdata[0] );
                $accountrelation = trim( str_replace( "'", "\'", $webdata[1] ) );
                $quantityamount = ( int ) $webdata[2];

                $fromdate = trim( $webdata[3] );
                $exp_fromdate = explode( "/", $fromdate );
                $from_date = $exp_fromdate[2]."-".$exp_fromdate[0]."-".$exp_fromdate[1];

                $todate = trim( $webdata[4] );
                $exp_todate = explode( "/", $todate );
                $to_date = $exp_todate[2]."-".$exp_todate[0]."-".$exp_todate[1];

                $percent1 = trim( $webdata[5] );
                $percent2 = trim( $webdata[6] );
                $unitid = trim( $webdata[7] );
                $inventdimid = trim( $webdata[8] );
                $recid = trim( $webdata[9] );
                $recversion = trim( $webdata[10] );
                $inventcolorid = trim( $webdata[11] );
                $inventsize = trim( $webdata[12] );
                $configid = trim( ( int ) $webdata[13] );
                $concatenat = trim( $webdata[14] );

                $insert = "INSERT INTO _AX_DISCOUNTS SET itemrelation  = '".$itemrelation."', accountrelation = '".$accountrelation."', quantityamount = '".$quantityamount."',
                    fromdate = '".$from_date."', todate = '".$to_date."', percent1 = '".$percent1."', percent2 = '".$percent2."', unitid = '".$unitid."',
                    inventdimid = '".$inventdimid."', recid = '".$recid."', recversion = '".$recversion."', inventcolorid = '".$inventcolorid."', inventsize = '".$inventsize."',
                    configid = '".$configid."', concatenat = '".$concatenat."';";
//                     print "<br>insert=".$insert;
                $this->db->query( $insert );
            }
            else if( $filename == '_AX_PRICES.csv' )
            {
                // ITEMRELATION; ACCOUNTRELATION; QUANTITYAMOUNT; FROMDATE; TODATE; AMOUNT; CURRENCY; UNITID; INVENTDIMID; RECID; RECVERSION;INVENTCOLORID
                // INVENTSIZE; CONFIGID; CONCATENAT; LINEDISC
                $itemrelation = $webdata[0];
                $accountrelation = trim( $webdata[1] );
                $quantityamount = trim( $webdata[2] );

                $fromdate = trim( $webdata[3] );
                $exp_fromdate = explode( "/", $fromdate );
                $from_date = $exp_fromdate[2]."-".$exp_fromdate[0]."-".$exp_fromdate[1];

                $todate = $webdata[4];
                $exp_todate = explode( "/", $todate );
                $to_date = $exp_todate[2]."-".$exp_todate[0]."-".$exp_todate[1];

                $amount = floatval(trim( $webdata[5] ));
                $currency = $webdata[6];
                $unitid = trim( $webdata[7] );
                $inventdimid = trim( $webdata[8] );
                $recid = trim( $webdata[9] );
                $recversion = trim( $webdata[10] );
                $inventcolorid = trim( $webdata[11] );
                $inventsize = trim( $webdata[12] );
                $configid = trim( $webdata[13] );
                $concatenat = trim( $webdata[14] );
                $linedisc = trim( $webdata[15] );

                $insert = "INSERT INTO _AX_PRICES SET itemrelation  = '".$itemrelation."', accountrelation = '".$accountrelation."', quantityamount = '".$quantityamount."',
                    fromdate = '".$from_date."', todate = '".$to_date."', `amount` = '".$amount."', currency = '".$currency."', unitid = '".$unitid."',
                    inventdimid = '".$inventdimid."', recid = '".$recid."', recversion = '".$recversion."', inventcolorid = '".$inventcolorid."', inventsize = '".$inventsize."',
                    configid = '".$configid."', concatenat = '".$concatenat."', linedisc = '".$linedisc."';";
                
                print "insert=".$insert."<br>";
                
//               if ( $itemrelation == '1061-36') print "<br>$webdata[5] insert=".$insert;
               // $this->db->query( $insert );
            }
            else if( $filename == '_AX_STOC.csv' )
            {
                // CONCATENAT;  STOC;  RECID; RECVERSION
                $concatenat = trim( $webdata[0] );
                $stoc = trim( $webdata[1] );
                $recid = ( int ) $webdata[2];
                $recversion = trim( $webdata[3]);
                         
                $insert = "INSERT INTO _AX_STOC SET concatenat  = '".$concatenat."', stoc = '".$stoc."', recid = '".$recid."', recversion = '".$recversion."' ;";
                //print "<br>insert=".$insert;
                $this->db->query( $insert );
            }
        }

        die( 'Minden rendben!' );
    }

}

?>