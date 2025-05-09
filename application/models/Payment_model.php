<?php

class payment_model extends CI_Model {

    public function save_receivables($data_insert)
    {
        $this->db->insert('hd_payment_receivable', $data_insert);
    }

    public function save_debt($data_insert)
    {
        $this->db->insert('hd_payment_debt', $data_insert);
    }

    public function save_temp_receivables($data_insert)
    {
        $this->db->insert('temp_payment_receivables', $data_insert);
    }

    public function save_temp_debt($data_insert)
    {
        $this->db->insert('temp_payment_debt', $data_insert);
    }

    public function insert_detail_receivables($data_insert_detail)
    {
        $this->db->insert('dt_payment_receivable', $data_insert_detail);
    }

    public function insert_detail_debt($data_insert_detail)
    {
        $this->db->insert('dt_payment_debt', $data_insert_detail);
    }

    public function edit_temp_receivables($data_insert, $temp_sales_id, $userid)
    {
        $this->db->set($data_insert);
        $this->db->where('temp_sales_id ', $temp_sales_id);
        $this->db->where('temp_user_id ', $userid);
        $this->db->update('temp_payment_receivables');
    }

    public function edit_temp_debt($data_insert, $temp_purchase_id, $userid)
    {
        $this->db->set($data_insert);
        $this->db->where('temp_purchase_id ', $temp_purchase_id);
        $this->db->where('temp_user_id ', $userid);
        $this->db->update('temp_payment_debt');
    }

    public function receivables_customer()
    {
        $query = $this->db->query("select customer_id, customer_name, customer_address, customer_phone, count(*) as total_nota, sum(hd_sales_remaining_debt) as total_piutang from hd_sales a, ms_customer b where a.hd_sales_customer = b.customer_id and hd_sales_remaining_debt > 0 group by hd_sales_customer asc");
        $result = $query->result();
        return $result;
    }

    public function debt_supplier()
    {
        $query = $this->db->query("select supplier_id, supplier_name, supplier_address, supplier_phone, count(*) as total_nota, sum(hd_purchase_remaining_debt) as total_hutang from hd_purchase a, ms_supplier b where a.hd_purchase_supplier_id = b.supplier_id and hd_purchase_remaining_debt > 0 group by hd_purchase_supplier_id asc");
        $result = $query->result();
        return $result;
    }


    public function receivables_history()
    {
        $query = $this->db->query("select * from hd_payment_receivable a, ms_customer b, ms_payment c where a.payment_receivable_customer_id = b.customer_id and a.payment_receivable_method_id = c.payment_id");
        $result = $query->result();
        return $result;
    }

    public function debt_history()
    {
        $query = $this->db->query("select * from hd_payment_debt a, ms_supplier b, ms_payment c where a.payment_debt_supplier_id = b.supplier_id and a.payment_debt_method_id = c.payment_id");
        $result = $query->result();
        return $result;
    }

    public function get_header_pay_receivables($id)
    {   
        $query = $this->db->query("select customer_name, sum(hd_sales_remaining_debt) as total_piutang from hd_sales a, ms_customer b where a.hd_sales_customer = b.customer_id and hd_sales_remaining_debt > 0 and hd_sales_customer = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function get_header_pay_debt($id)
    {   
        $query = $this->db->query("select supplier_name, sum(hd_purchase_remaining_debt) as total_hutang from hd_purchase a, ms_supplier b where a.hd_purchase_supplier_id = b.supplier_id and hd_purchase_remaining_debt > 0 and hd_purchase_supplier_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function clear_temp_receivables($userid)
    {
        $this->db->where('temp_user_id', $userid);
        $this->db->delete('temp_payment_receivables');
    }

    public function clear_temp_debt($userid)
    {
        $this->db->where('temp_user_id', $userid);
        $this->db->delete('temp_payment_debt');
    }

    public function get_copy_to_temp_receivables($id)
    {
        $query = $this->db->query("select * from hd_sales a, ms_customer b where a.hd_sales_customer = b.customer_id and hd_sales_remaining_debt > 0 and hd_sales_customer = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function get_copy_to_temp_debt($id)
    {
        $query = $this->db->query("select * from hd_purchase a, ms_supplier b where a.hd_purchase_supplier_id = b.supplier_id and hd_purchase_remaining_debt > 0 and hd_purchase_supplier_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function get_temp_receivables($userid)
    {
        $query = $this->db->query("select * from temp_payment_receivables a, hd_sales b where a.temp_sales_id = b.hd_sales_id and temp_user_id = '".$userid."'");
        $result = $query->result();
        return $result;
    }

    public function get_temp_debt($userid)
    {
        $query = $this->db->query("select * from temp_payment_debt a, hd_purchase b where a.temp_purchase_id = b.hd_purchase_id and temp_user_id = '".$userid."'");
        $result = $query->result();
        return $result;
    }

    public function get_temp_receivables_edit($temp_sales_id)
    {
        $query = $this->db->query("select * from temp_payment_receivables a, hd_sales b where a.temp_sales_id = b.hd_sales_id and temp_sales_id = '".$temp_sales_id."'");
        $result = $query->result();
        return $result;
    }

    public function get_total_retur_sales($temp_sales_id)
    {
        $query = $this->db->query("select sum(hd_retur_total_transaction) as total_retur from hd_retur_sales where  hd_sales_no = '".$temp_sales_id."' and hd_retur_used = 'N' and hd_retur_status = 'Success'");
        $result = $query->result();
        return $result;
    }

    public function get_temp_debt_edit($temp_purchase_id)
    {
        $query = $this->db->query("select * from temp_payment_debt a, hd_purchase b where a.temp_purchase_id = b.hd_purchase_id and temp_purchase_id = '".$temp_purchase_id."'");
        $result = $query->result();
        return $result;
    }

    public function get_total_retur_purchase($temp_purchase_id)
    {
        $query = $this->db->query("select sum(hd_retur_total_transaction) as total_retur from hd_retur_purchase where hd_purchase_no = '".$temp_purchase_id."' and hd_retur_used = 'N' and hd_retur_status = 'Success'");
        $result = $query->result();
        return $result;
    }

    public function get_footer_pay_receivables($userid)
    {
        $query = $this->db->query("select sum(temp_debt_nominal) as total_payment, count(*) as total_nota from temp_payment_receivables where  temp_user_id = '".$userid."' and temp_payment_isedit = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function get_footer_pay_debt($userid)
    {
        $query = $this->db->query("select sum(temp_debt_nominal) as total_payment, count(*) as total_nota from temp_payment_debt where  temp_user_id = '".$userid."' and temp_payment_isedit = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function get_last_receivables()
    {
        $query = $this->db->query("select payment_receivable_invoice from hd_payment_receivable order by payment_receivable_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function get_last_debt()
    {
        $query = $this->db->query("select payment_debt_invoice from hd_payment_debt order by payment_debt_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function get_detail_payment_receivables_header($id)
    {
        $query = $this->db->query("select * from hd_payment_receivable a, ms_customer b, ms_payment c where a.payment_receivable_customer_id = b.customer_id and a.payment_receivable_method_id = c.payment_id and payment_receivable_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function get_detail_payment_receivables_detail($id)
    {
        $query = $this->db->query("select * from hd_payment_receivable a, ms_customer b, ms_payment c, dt_payment_receivable d, hd_sales e where a.payment_receivable_customer_id = b.customer_id and a.payment_receivable_method_id = c.payment_id and a.payment_receivable_invoice = d.payment_receivable_invoice and d.dt_payment_receivable_sales_id = e.hd_sales_id and payment_receivable_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function get_detail_payment_debt_header($id)
    {
        $query = $this->db->query("select * from hd_payment_debt a, ms_supplier b, ms_payment c where a.payment_debt_supplier_id = b.supplier_id and a.payment_debt_method_id = c.payment_id and payment_debt_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function get_detail_payment_debt_detail($id)
    {
        $query = $this->db->query("select * from hd_payment_debt a, ms_supplier b, ms_payment c, dt_payment_debt d, hd_purchase e where a.payment_debt_supplier_id = b.supplier_id and a.payment_debt_method_id = c.payment_id and a.payment_debt_invoice = d.payment_debt_invoice and d.dt_payment_debt_purchase_id = e.hd_purchase_id and payment_debt_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function update_remaining_sales($sales_id, $remaining_debt)
    {
        $this->db->set('hd_sales_remaining_debt',$remaining_debt);
        $this->db->where('hd_sales_id ', $sales_id);
        $this->db->update('hd_sales');
    }


    public function update_remaining_purchase($purchase_id, $remaining_debt)
    {
        $this->db->set('hd_purchase_remaining_debt',$remaining_debt);
        $this->db->where('hd_purchase_id ', $purchase_id);
        $this->db->update('hd_purchase');
    }

    public function update_retur_status($sales_id)
    {
        $this->db->set('hd_retur_used', 'Y');
        $this->db->where('hd_sales_no ', $sales_id);
        $this->db->update('hd_retur_sales');
    }

    public function update_retur_status_debt($purchase_id)
    {
        $this->db->set('hd_retur_used', 'Y');
        $this->db->where('hd_purchase_no ', $purchase_id);
        $this->db->update('hd_retur_purchase');
    }

    public function delete_payment_receivables($id)
    {
        $this->db->set('payment_receivable_status', 'Cancel');
        $this->db->where('payment_receivable_id ', $id);
        $this->db->update('hd_payment_receivable');
    }

    public function delete_payment_debt($id)
    {
        $this->db->set('payment_debt_status', 'Cancel');
        $this->db->where('payment_debt_id ', $id);
        $this->db->update('hd_payment_debt');
    }

}

?>  