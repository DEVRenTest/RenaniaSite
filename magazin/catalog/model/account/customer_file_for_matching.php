<?php

class ModelAccountCustomerFileForMatching extends Model
{
    public function addFile( $file, $data )
    {
        $temp = explode( ".", $file['file_for_matching']['name'] );
        $extension = end( $temp );

        $sql_plus = "";
        if ( $extension == "csv" )
        {
           $sql_plus .=  ", csv_delimiter = '".$this->db->escape( $data['csv_delimiter'] )."'";
        }

        $this->db->query( "INSERT INTO api_customer_file_for_matching SET customer_id='".$this->customer->getId()."', original_file_name = '".$this->db->escape( $file['file_for_matching']['name'] )."', file_type = '".$this->db->escape( $extension )."', date_added = NOW() ".$sql_plus );
        $new_file_id = $this->db->getLastId();

        return $new_file_id;
    }

    public function updateFile( $file_id, $file_name )
    {
        $this->db->query( "UPDATE api_customer_file_for_matching SET file_name = '".$file_name."' WHERE api_matching_customer_file_id ='".( int ) $file_id."'" );
    }

    public function deleteFile( $file_id )
    {
        $query = $this->db->query( "SELECT file_name FROM api_customer_file_for_matching WHERE 	api_matching_customer_file_id = '".$file_id."'" );
        if( $query->num_rows > 0 )
        {
            //print "<br>file=".DIR_FILE_FOR_MATCHING.$query->row['file_name']."<br>";
            if( file_exists( DIR_FILE_FOR_MATCHING.$query->row['file_name'] ) )
            {
                @unlink( DIR_FILE_FOR_MATCHING.$query->row['file_name'] );
            }
        }
        $this->db->query( "DELETE FROM api_customer_file_for_matching WHERE api_matching_customer_file_id = '".( int ) $file_id."'" );
    }

    public function getCsvDelimiter( $file_id )
    {
        $csv_delimiter = "";
        $query = $this->db->query( "SELECT csv_delimiter FROM api_customer_file_for_matching WHERE 	api_matching_customer_file_id = '".$file_id."'" );
        if( $query->num_rows > 0 )
        {
            $csv_delimiter = $query->row['csv_delimiter'];
        }

        return $csv_delimiter;
    }



}