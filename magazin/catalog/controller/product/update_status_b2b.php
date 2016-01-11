<?php

class ControllerProductUpdateStatusB2B extends Controller
{

    public function index() {

        $all_product_id = "SELECT `product_id` FROM `oc_product`;";
        $all_product_id = $this->db->query($all_product_id)->rows;

        echo sizeof($all_product_id)."<br>";

        $inserted_counter = 0;

        foreach ($all_product_id as $product_id) {
            $check_if_b2b = "SELECT * FROM `oc_product_to_store` WHERE product_id = ".$product_id['product_id']." AND store_id = 1;";
            echo "<pre>".$check_if_b2b."<br>";
            $check_if_b2b = $this->db->query($check_if_b2b);

            print_r($check_if_b2b);

            if (!$check_if_b2b->num_rows) {
                $insert_to_b2b = "INSERT INTO `oc_product_to_store` SET `product_id` = ".$product_id['product_id'].", `store_id` = 1 ;";
                $insert_to_b2b = $this->db->query($insert_to_b2b);
                $inserted_counter++;
                print('Inserted '.$inserted_counter.' '.$product_id['product_id']);
            }

            if($check_if_b2b->num_rows){
                //die($product_id['product_id']);
            }
            $check_if_b2b = $check_if_b2b->rows;
            //die($check_if_b2b);
        }

        echo "<pre>product ids"; print_r($all_product_id); die('dsvdv');
    }

}

?>