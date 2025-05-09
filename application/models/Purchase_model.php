<?php

class purchase_model extends CI_Model {

    public function save_temp_po($data_insert)
    {
        $this->db->insert('temp_po', $data_insert);
    }

    public function save_temp_purchase($data_insert)
    {
        $this->db->insert('temp_purchase', $data_insert);
    }

    public function save_po($data_insert)
    {
        $this->db->insert('hd_po', $data_insert);
    }

    public function save_po_detail($data_insert_detail)
    {
        $this->db->insert('dt_po', $data_insert_detail);
    }

    public function save_purchase($data_insert)
    {
        $this->db->insert('hd_purchase', $data_insert);
    }

    public function save_purchase_detail($data_insert_detail)
    {
        $this->db->insert('dt_purchase', $data_insert_detail);
    }

    

    public function po_list($start_date, $end_date)
    {
        $query = $this->db->query("select * from hd_po a, ms_supplier b where a.hd_po_supplier_id = b.supplier_id and hd_po_date between '".$start_date."' and '".$end_date."'");
        $result = $query->result();
        return $result;
    }

    public function get_temp_po($userid)
    {
        $query = $this->db->query("select * from temp_po a, ms_product_detail b where a.product_id = b.item_id and a.user_id = '".$userid."'");
        $result = $query->result();
        return $result;
    }

    public function search_product_supplier($keyword, $supplier_id)
    {
        $query = $this->db->query("select * from ms_product_supplier a, ms_product_detail b, ms_supplier c where a.product_code = b.product_code and a.supplier_id = c.supplier_id and b.item_name like '%".$keyword."%' and c.supplier_id = '".$supplier_id."'");
        $result = $query->result();
        return $result;
    }

    public function delete_temp_po($id, $userid)
    {
        $this->db->where('product_id', $id);
        $this->db->where('user_id', $userid);
        $this->db->delete('temp_po');
    }

    public function clear_temp($userid)
    {
        $this->db->where('user_id', $userid);
        $this->db->delete('temp_po');
    }

    public function get_edit_temp($id, $userid)
    {
        $query = $this->db->query("select * from temp_po a, ms_product_detail b where a.product_id = b.item_id and a.product_id = '".$id."' and user_id = '".$userid."'");
        $result = $query->result();
        return $result;
    }

    public function get_edit_temp_purchase($id, $userid)
    {
        $query = $this->db->query("select * from temp_purchase a, ms_product_detail b where a.product_id = b.item_id and a.product_id = '".$id."' and user_id = '".$userid."'");
        $result = $query->result();
        return $result;
    }

    public function get_total_footer_po($userid)
    {
        $query = $this->db->query("select sum(po_total) as po_total from temp_po where user_id = '".$userid."'");
        $result = $query->result();
        return $result;
    }

    public function edit_temp_po($data_edit, $item_id_temp, $user_id)
    {
        $this->db->set($data_edit);
        $this->db->where('product_id ', $item_id_temp);
        $this->db->where('user_id ', $user_id);
        $this->db->update('temp_po');
    }

    public function delete_po($id)
    {
        $this->db->set('hd_po_status','cancel');
        $this->db->where('hd_po_id ', $id);
        $this->db->update('hd_po');
    }

    public function delete_purchase($id)
    {
        $this->db->set('hd_purchase_status','cancel');
        $this->db->where('hd_purchase_id ', $id);
        $this->db->update('hd_purchase');
    }

    public function get_last_po_code()
    {
        $query = $this->db->query("select hd_po_invoice from hd_po order by hd_po_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function get_last_purchase_code()
    {
        $query = $this->db->query("select hd_purchase_invoice from hd_purchase order by hd_purchase_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function get_copy_to_temp($id)
    {
        $query = $this->db->query("select * from hd_po a, dt_po b, ms_supplier c where a.hd_po_invoice = b.dt_po_invoice and a.hd_po_supplier_id = c.supplier_id and hd_po_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function get_detail_po_header($id)
    {
        $query = $this->db->query("select * from hd_po a, ms_supplier b where a.hd_po_supplier_id = b.supplier_id and hd_po_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function get_detail_purchase_header($id)
    {
        $query = $this->db->query("select * from hd_purchase a, ms_supplier b where a.hd_purchase_supplier_id = b.supplier_id and hd_purchase_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function get_detail_po_detail($id)
    {
        $query = $this->db->query("select * from hd_po a, ms_supplier b, dt_po c, ms_product_detail d where a.hd_po_supplier_id = b.supplier_id and a.hd_po_invoice = c.dt_po_invoice and c.dt_po_product_id = d.item_id and hd_po_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function get_detail_purchase_detail($id)
    {
        $query = $this->db->query("select * from hd_purchase a, ms_supplier b, dt_purchase c, ms_product_detail d where a.hd_purchase_supplier_id = b.supplier_id and a.hd_purchase_invoice = c.dt_purchase_invoice and c.dt_purchase_product_id = d.item_id and hd_purchase_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function purchase_list($start_date, $end_date)
    {
        $query = $this->db->query("select * from hd_purchase a, ms_supplier b where a.hd_purchase_supplier_id = b.supplier_id and hd_purchase_date between '".$start_date."' and '".$end_date."'");
        $result = $query->result();
        return $result;
    }

    public function po_list_pending()
    {
        $query = $this->db->query("select * from hd_po where hd_po_status = 'Pending'");
        $result = $query->result();
        return $result;
    }

    public function clear_temp_purchase($userid)
    {
        $this->db->where('user_id', $userid);
        $this->db->delete('temp_purchase');
    }

    public function get_temp_purchase($userid)
    {
        $query = $this->db->query("select * from temp_purchase a, ms_product_detail b where a.product_id = b.item_id and a.user_id = '".$userid."'");
        $result = $query->result();
        return $result;
    }

    public function search_po($keyword)
    {
        $query = $this->db->query("select * from hd_po where hd_po_invoice like '%".$keyword."%'");
        $result = $query->result();
        return $result;
    }

    public function edit_temp_purchase($data_edit, $item_id_temp, $user_id)
    {
        $this->db->set($data_edit);
        $this->db->where('product_id ', $item_id_temp);
        $this->db->where('user_id ', $user_id);
        $this->db->update('temp_purchase');
    }

    public function delete_temp_purchase($id, $userid)
    {
        $this->db->where('product_id', $id);
        $this->db->where('user_id', $userid);
        $this->db->delete('temp_purchase');
    }

    public function get_total_footer_purchase($userid)
    {
        $query = $this->db->query("select sum(purchase_total) as purchase_total, sum(purchase_discount) as discount_total from temp_purchase where user_id = '".$userid."'");
        $result = $query->result();
        return $result;
    }

    public function get_last_stock($product_id)
    {
        $query = $this->db->query("select * from ms_product_detail where item_id = '".$product_id."'");
        $result = $query->result();
        return $result;
    }

    public function update_stock($product_id, $new_stock)
    {
        $this->db->set('item_stock', $new_stock);
        $this->db->where('item_id', $product_id);
        $this->db->update('ms_product_detail');
    }

    public function get_detail_purchase($id)
    {
        $query = $this->db->query("select * from hd_purchase a, dt_purchase b where a.hd_purchase_invoice = b.dt_purchase_invoice and hd_purchase_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

}

?>  