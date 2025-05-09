<?php

class opname_model extends CI_Model {


    public function save_opname($data_insert)
    {
        $this->db->insert('hd_opname', $data_insert);
    }

    public function save_opname_detail($data_insert_detail)
    {
        $this->db->insert('dt_opname', $data_insert_detail);
    }

    public function insert_temp_opname($data_insert)
    {
        $this->db->insert('temp_opname', $data_insert);
    }

    public function opname_list()
    {
        $query = $this->db->query("select * from hd_opname");
        $result = $query->result();
        return $result;
    }

    public function search_product($keyword)
    {
        $query = $this->db->query("select * from ms_product_detail where item_name like '%".$keyword."%' and item_active = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function get_edit_temp($id, $userid)
    {
        $query = $this->db->query("select * from temp_opname a, ms_product_detail b where a.temp_product_id = b.item_id and a.temp_product_id = '".$id."' and temp_user_id = '".$userid."'");
        $result = $query->result();
        return $result;
    }

    public function edit_temp_opname($data_edit, $item_id_temp, $user_id)
    {
        $this->db->set($data_edit);
        $this->db->where('temp_product_id', $item_id_temp);
        $this->db->where('temp_user_id', $user_id);
        $this->db->update('temp_opname');
    }

    public function get_temp_opname($userid)
    {
        $query = $this->db->query("select * from temp_opname a, ms_product_detail b where a.temp_product_id = b.item_id and temp_user_id = '".$userid."'");
        $result = $query->result();
        return $result;
    }

    public function delete_temp_opname($id, $userid)
    {
        $this->db->where('temp_product_id', $id);
        $this->db->where('temp_user_id', $userid);
        $this->db->delete('temp_opname');
    }

    public function get_total_footer_opname($userid)
    {
        $query = $this->db->query("select sum(temp_total_price) as total_selisih from temp_opname where temp_user_id = '".$userid."'");
        $result = $query->result();
        return $result;
    }

    public function get_last_opname_code()
    {
        $query = $this->db->query("select opname_code from hd_opname order by hd_opname_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function clear_temp($userid)
    {
        $this->db->where('temp_user_id', $userid);
        $this->db->delete('temp_opname');
    }

    public function get_detail_opname_header($id)
    {
        $query = $this->db->query("select * from hd_opname where hd_opname_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function get_detail_opname_detail($id)
    {
        $query = $this->db->query("select * from hd_opname a, dt_opname b, ms_product_detail c where a.opname_code = b.opname_code and b.dt_opname_product_id = c.item_id and  hd_opname_id = '".$id."'");
        $result = $query->result();
        return $result;
    }




}

?>  