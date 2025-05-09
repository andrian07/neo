<?php

class retur_model extends CI_Model {

    public function save_temp_retur_purchase($data_insert)
    {
        $this->db->insert('temp_retur_purchase', $data_insert);
    }

    public function save_retur_purchase($data_insert)
    {
        $this->db->insert('hd_retur_purchase', $data_insert);
    }

    public function save_temp_retur_sales($data_insert)
    {
        $this->db->insert('temp_retur_sales', $data_insert);
    }

    public function save_retur_sales($data_insert)
    {
        $this->db->insert('hd_retur_sales', $data_insert);
    }

    public function save_retur_purchase_detail($data_insert_detail)
    {
        $this->db->insert('dt_retur_purchase', $data_insert_detail);
    }

    public function save_retur_sales_detail($data_insert_detail)
    {
        $this->db->insert('dt_retur_sales', $data_insert_detail);
    }

    public function edit_temp_retur_purchase($data_edit, $item_id_temp, $user_id)
    {
        $this->db->set($data_edit);
        $this->db->where('retur_product_id ', $item_id_temp);
        $this->db->where('retur_user_id', $user_id);
        $this->db->update('temp_retur_purchase');
    }

    public function edit_temp_retur_sales($data_edit, $item_id_temp, $user_id)
    {
        $this->db->set($data_edit);
        $this->db->where('retur_product_id ', $item_id_temp);
        $this->db->where('retur_user_id', $user_id);
        $this->db->update('temp_retur_sales');
    }


    public function delete_temp_retur_purchase($id, $userid)
    {
        $this->db->where('retur_product_id', $id);
        $this->db->where('retur_user_id', $userid);
        $this->db->delete('temp_retur_purchase');
    }

    public function delete_temp_retur_sales($id, $userid)
    {
        $this->db->where('retur_product_id', $id);
        $this->db->where('retur_user_id', $userid);
        $this->db->delete('temp_retur_sales');
    }

    public function retur_purchase_list($start_date, $end_date)
    {
        $query = $this->db->query("select * from hd_retur_purchase a, ms_supplier b where a.hd_retur_supplier_id = b.supplier_id and hd_retur_date between '".$start_date."' and '".$end_date."'");
        $result = $query->result();
        return $result;
    }

    public function retur_sales_list($start_date, $end_date){
        $query = $this->db->query("select * from hd_retur_sales a, ms_customer b where a.hd_retur_customer_id = b.customer_id and hd_retur_date between '".$start_date."' and '".$end_date."'");
        $result = $query->result();
        return $result;
    }


    public function search_purchase_invoice_supplier($keyword, $supplier_id)
    {
        $query = $this->db->query("select * from hd_purchase where hd_purchase_invoice like '%".$keyword."%' and hd_purchase_supplier_id = '".$supplier_id."' and hd_purchase_status = 'success'");
        $result = $query->result();
        return $result;
    }

    public function check_retur_item_sales($item_id_temp, $sales_no)
    {
         $query = $this->db->query("select sum(dt_retur_qty) as total_retur_qty from hd_retur_sales a, dt_retur_sales b where a.hd_retur_sales_invoice = b.dt_retur_sales_invoice and dt_retur_item_id = '".$item_id_temp."' and hd_sales_no = '".$sales_no."'");
        $result = $query->result();
        return $result;
    }

    public function check_retur_item_purchase($item_id_temp, $purchase_no)
    {
         $query = $this->db->query("select sum(dt_retur_qty) as total_retur_qty from hd_retur_purchase a, dt_retur_purchase b where a.hd_retur_purchase_invoice = b.dt_retur_purchase_invoice and dt_retur_item_id = '".$item_id_temp."' and hd_purchase_no = '".$purchase_no."'");
        $result = $query->result();
        return $result;
    }

    public function search_sales_invoice_customer($keyword, $customer_id)
    {
        $query = $this->db->query("select * from hd_sales where hd_sales_invoice like '%".$keyword."%' and hd_sales_customer = '".$customer_id."' and hd_sales_status = 'success'");
        $result = $query->result();
        return $result;
    }

    public function search_product_purchase_no($keyword, $purchase_no)
    {
        $query = $this->db->query("select * from hd_purchase a, dt_purchase b, ms_product_detail c where a.hd_purchase_invoice = b.dt_purchase_invoice and b.dt_purchase_product_id = c.item_id and item_name like '%".$keyword."%' and hd_purchase_id = '".$purchase_no."'");
        $result = $query->result();
        return $result;
    }

    public function search_product_sales_no($keyword, $sales_no)
    {
        $query = $this->db->query("select * from hd_sales a, dt_sales b, ms_product_detail c where a.hd_sales_invoice = b.dt_sales_invoice and b.dt_sales_product_id = c.item_id and item_name like '%".$keyword."%' and hd_sales_id = '".$sales_no."'");
        $result = $query->result();
        return $result;
    }

    public function get_edit_retur_pruchase_temp($item_id_temp, $user_id)
    {
        $query = $this->db->query("select * from temp_retur_purchase a, ms_product_detail b where a.retur_product_id = b.item_id and retur_product_id = '".$item_id_temp."' and retur_user_id = '".$user_id."'");
        $result = $query->result();
        return $result;
    }

    public function get_edit_retur_sales_temp($item_id_temp, $user_id)
    {
        $query = $this->db->query("select * from temp_retur_sales a, ms_product_detail b where a.retur_product_id = b.item_id and retur_product_id = '".$item_id_temp."' and retur_user_id = '".$user_id."'");
        $result = $query->result();
        return $result;
    }

    public function get_temp_retur_purchase($user_id)
    {
        $query = $this->db->query("select * from temp_retur_purchase a, ms_product_detail b where a.retur_product_id = b.item_id and retur_user_id = '".$user_id."'");
        $result = $query->result();
        return $result;
    }

    public function get_temp_retur_sales($user_id)
    {
        $query = $this->db->query("select * from temp_retur_sales a, ms_product_detail b where a.retur_product_id = b.item_id and retur_user_id = '".$user_id."'");
        $result = $query->result();
        return $result;
    }

    public function check_temp_retur_purchase_qty($purchase_no, $item_id_temp)
    {
        $query = $this->db->query("select sum(dt_retur_qty) as total_qty_retur from hd_retur_purchase a, dt_retur_purchase b where a.hd_retur_purchase_invoice = b.dt_retur_purchase_invoice and hd_purchase_no = '".$purchase_no."' and dt_retur_item_id = '".$item_id_temp."'");
        $result = $query->result();
        return $result;
    }

    public function get_total_footer_retur_purchase($userid)
    {
        $query = $this->db->query("select sum(retur_total) as retur_total from temp_retur_purchase where retur_user_id = '".$userid."'");
        $result = $query->result();
        return $result;
    }

    public function get_total_footer_retur_sales($userid)
    {
        $query = $this->db->query("select sum(retur_total) as retur_total from temp_retur_sales where retur_user_id = '".$userid."'");
        $result = $query->result();
        return $result;
    }

    public function get_last_retur_purchase_code()
    {
        $query = $this->db->query("select hd_retur_purchase_invoice from hd_retur_purchase order by hd_retur_purchase_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function get_last_retur_sales_code()
    {
        $query = $this->db->query("select hd_retur_sales_invoice from hd_retur_sales order by hd_retur_sales_id desc limit 1");
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

    public function clear_temp_retur_purchase($userid)
    {
        $this->db->where('retur_user_id', $userid);
        $this->db->delete('temp_retur_purchase');
    }

    public function clear_temp_retur_sales($userid)
    {
        $this->db->where('retur_user_id', $userid);
        $this->db->delete('temp_retur_sales');
    }

    

    public function get_detail_retur_purchase_header($id)
    {
        $query = $this->db->query("select * from hd_retur_purchase a, ms_supplier b where a.hd_retur_supplier_id = b.supplier_id and hd_retur_purchase_id = '".$id."'");
        $result = $query->result();
        return $result;
    }


    public function get_detail_retur_purchase_detail($id)
    {
        $query = $this->db->query("select * from hd_retur_purchase a, ms_supplier b, dt_retur_purchase c, ms_product_detail d where a.hd_retur_supplier_id = b.supplier_id and a.hd_retur_purchase_invoice = c.dt_retur_purchase_invoice and c.dt_retur_item_id = d.item_id and hd_retur_purchase_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function get_detail_retur_sales_header($id)
    {
        $query = $this->db->query("select * from hd_retur_sales a, ms_customer b where a.hd_retur_customer_id = b.customer_id and hd_retur_sales_id = '".$id."'");
        $result = $query->result();
        return $result;
    }


    public function get_detail_retur_sales_detail($id)
    {
        $query = $this->db->query("select * from hd_retur_sales a, ms_customer b, dt_retur_sales c, ms_product_detail d where a.hd_retur_customer_id = b.customer_id and a.hd_retur_sales_invoice = c.dt_retur_sales_invoice and c.dt_retur_item_id = d.item_id and hd_retur_sales_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function get_detail_retur_purchase($id)
    {
        $query = $this->db->query("select * from hd_retur_purchase a, dt_retur_purchase b where a.hd_retur_purchase_invoice = b.dt_retur_purchase_invoice and hd_retur_purchase_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function get_detail_retur_sales($id)
    {
        $query = $this->db->query("select * from hd_retur_sales a, dt_retur_sales b where a.hd_retur_sales_invoice = b.dt_retur_sales_invoice and hd_retur_sales_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function remaining_debt_purchase($purchase_no)
    {
        $query = $this->db->query("select hd_purchase_remaining_debt from hd_purchase where hd_purchase_id  = '".$purchase_no."'");
        $result = $query->result();
        return $result;
    }

    public function remaining_debt_sales($sales_no)
    {
        $query = $this->db->query("select hd_sales_remaining_debt from hd_sales where hd_sales_id  = '".$sales_no."'");
        $result = $query->result();
        return $result;
    }


    public function delete_retur_purchase($id)
    {
        $this->db->set('hd_retur_status','cancel');
        $this->db->where('hd_retur_purchase_id ', $id);
        $this->db->update('hd_retur_purchase');
    }

    public function delete_retur_sales($id)
    {
        $this->db->set('hd_retur_status','cancel');
        $this->db->where('hd_retur_sales_id ', $id);
        $this->db->update('hd_retur_sales');
    }

    public function update_remaining_debt_purchase($purchase_no)
    {
        $this->db->set('hd_purchase_remaining_debt', '0');
        $this->db->where('hd_purchase_id  ', $purchase_no);
        $this->db->update('hd_purchase');
    }

    public function update_remaining_debt_sales($sales_no)
    {
        $this->db->set('hd_sales_remaining_debt', '0');
        $this->db->where('hd_sales_id  ', $sales_no);
        $this->db->update('hd_sales');
    }
}

?>  