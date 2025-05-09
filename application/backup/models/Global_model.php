<?php

class global_model extends CI_Model {

    public function save_movement_stock($data_insert)
    {
        $this->db->insert('stock_movement', $data_insert);
    }

}

?>