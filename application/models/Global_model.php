<?php

class global_model extends CI_Model {

    public function save_movement_stock($data_insert)
    {
        $this->db->insert('stock_movement', $data_insert);
    }

    public function check_role($role, $modul)
    {
        $query = $this->db->query("select * from user_module where module_name = '".$modul."' and user_role = '".$role."'");
        $result = $query->result();
        return $result;
    }

}

?>