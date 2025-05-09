<?php

class sales_model extends CI_Model {

    public function save_temp_sales($data_insert)
    {
        $this->db->insert('temp_sales', $data_insert);
    }

    public function save_sales($data_insert)
    {
        $this->db->insert('hd_sales', $data_insert);
    }

    public function save_sales_detail($data_insert_detail)
    {
        $this->db->insert('dt_sales', $data_insert_detail);
    }

    public function insert_report_minus($data_insert_minus)
    {
        $this->db->insert('report_minus_sales', $data_insert_minus);
    }

    public function edit_temp_sales($data_edit, $item_id_temp, $user_id)
    {
        $this->db->set($data_edit);
        $this->db->where('product_id ', $item_id_temp);
        $this->db->where('user_id ', $user_id);
        $this->db->update('temp_sales');
    }

    public function delete_temp_sales($id, $userid)
    {
        $this->db->where('product_id', $id);
        $this->db->where('user_id', $userid);
        $this->db->delete('temp_sales');
    }

     public function delete_sales($id)
    {
        $this->db->set('hd_sales_status','cancel');
        $this->db->where('hd_sales_id ', $id);
        $this->db->update('hd_sales');
    }


    public function clear_temp_sales($userid)
    {
        $this->db->where('user_id', $userid);
        $this->db->delete('temp_sales');
    }

    public function sales_list($start_date, $end_date)
    {
        $query = $this->db->query("select * from hd_sales a, ms_customer b, ms_sales c where a.hd_sales_customer = b.customer_id and a.hd_sales_sales = c.sales_id and hd_sales_date between '".$start_date."' and '".$end_date."'");
        $result = $query->result();
        return $result;
    }

    public function get_last_sales_code()
    {
        $query = $this->db->query("select hd_sales_invoice from hd_sales order by hd_sales_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function search_product($keyword)
    {
        $search_value = explode(" ",$keyword);
        $this->db->select('*');
        $this->db->from('ms_product_detail');
        if($keyword != null){
            foreach ($search_value as $row) {
                $this->db->where('item_name like "%'.$row.'%"');
            }
        }
        $query = $this->db->get();
        return $query;
    
    }

    public function get_edit_temp($id, $userid)
    {
        $query = $this->db->query("select * from temp_sales a, ms_product_detail b where a.product_id = b.item_id and a.product_id = '".$id."' and user_id = '".$userid."'");
        $result = $query->result();
        return $result;
    }

    public function get_temp_sales($userid)
    {
        $query = $this->db->query("select * from temp_sales a, ms_product_detail b where a.product_id = b.item_id and a.user_id = '".$userid."'");
        $result = $query->result();
        return $result;
    }

    public function get_total_footer_sales($userid)
    {
        $query = $this->db->query("select sum(sales_total) as sales_total, sum(sales_discount) as discount_total from temp_sales where user_id = '".$userid."'");
        $result = $query->result();
        return $result;
    }


     public function get_detail_sales_header($id)
    {
        $query = $this->db->query("select * from hd_sales a, ms_customer b, ms_payment c, ms_sales d where a.hd_sales_customer = b.customer_id and a.hd_sales_payment_type = c.payment_id and a.hd_sales_sales = d.sales_id and hd_sales_id = '".$id."'");
        $result = $query->result();
        return $result;
    }
    public function get_detail_sales_detail($id)
    {
        $query = $this->db->query("select * from hd_sales a, ms_customer b, dt_sales c, ms_product_detail d where a.hd_sales_customer = b.customer_id and a.hd_sales_invoice = c.dt_sales_invoice and c.dt_sales_product_id = d.item_id and hd_sales_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function get_detail_sales($id)
    {
         $query = $this->db->query("select * from hd_sales a, dt_sales b where a.hd_sales_invoice = b.dt_sales_invoice and hd_sales_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function get_last_stock($product_id)
    {
        $query = $this->db->query("select * from ms_product_detail where item_id = '".$product_id."'");
        $result = $query->result();
        return $result;
    }

    public function get_customer_info($id)
    {
        $query = $this->db->query("select * from ms_customer where customer_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function update_stock($product_id, $new_stock)
    {
        $this->db->set('item_stock', $new_stock);
        $this->db->where('item_id', $product_id);
        $this->db->update('ms_product_detail');
    }

    public function update_stock_not_send($product_id, $new_stock_not_send)
    {
        $this->db->set('item_not_send', $new_stock_not_send);
        $this->db->where('item_id', $product_id);
        $this->db->update('ms_product_detail');
    }

    public function update_delivery_status($id)
    {
        $this->db->set('hd_delivery_status', 'Sudah');
        $this->db->where('hd_sales_id ', $id);
        $this->db->update('hd_sales');
    }

}

?>  