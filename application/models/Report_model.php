<?php

class report_model extends CI_Model {

    public function get_po($start_date, $end_date, $product_tax, $supplier_id, $status_po)
    {

        $this->db->select('*');
        $this->db->join('dt_po', 'hd_po.hd_po_invoice = dt_po.dt_po_invoice');
        $this->db->join('ms_product_detail', 'dt_po.dt_po_product_id = ms_product_detail.item_id');
        $this->db->join('ms_supplier', 'hd_po.hd_po_supplier_id = ms_supplier.supplier_id');
        $this->db->where('hd_po_date between "'.$start_date.'" and "'.$end_date.'"');
        if($product_tax != '' || $product_tax != null){
            $this->db->where('hd_po_gol', $product_tax);
        }
        if($supplier_id != '' || $supplier_id != null){
            $this->db->where('hd_po_supplier_id', $supplier_id);
        }
        if($status_po != '' || $status_po != null){
            $this->db->where('status_po', $status_po);
        }
        $q =  $this->db->get('hd_po');
        $query = $q->result_array();
        return $query;
    }

    public function get_purchase($start_date, $end_date, $product_tax, $supplier_id, $category_id, $brand_id)
    {

        $this->db->select('*');
        $this->db->join('dt_purchase', 'hd_purchase.hd_purchase_invoice = dt_purchase.dt_purchase_invoice');
        $this->db->join('ms_product_detail', 'dt_purchase.dt_purchase_product_id = ms_product_detail.item_id');
        $this->db->join('ms_product', 'ms_product_detail.product_code = ms_product.product_code');
        $this->db->join('ms_supplier', 'hd_purchase.hd_purchase_supplier_id = ms_supplier.supplier_id');
        $this->db->join('ms_category', 'ms_product.category_id = ms_category.category_id');
        $this->db->join('ms_brand', 'ms_product.brand_id = ms_brand.brand_id');
        $this->db->join('ms_unit', 'ms_product.unit_id = ms_unit.unit_id');
        $this->db->where('hd_purchase_date between "'.$start_date.'" and "'.$end_date.'"');
        if($product_tax != '' || $product_tax != null){
            $this->db->where('hd_po_gol', $product_tax);
        }
        if($supplier_id != '' || $supplier_id != null){
            $this->db->where('hd_purchase_supplier_id', $supplier_id);
        }
        if($category_id != '' || $category_id != null){
            $this->db->where('category_id', $category_id);
        }
        if($brand_id != '' || $brand_id != null){
            $this->db->where('brand_id', $brand_id);
        }
        $q =  $this->db->get('hd_purchase');
        $query = $q->result_array();
        return $query;
    }

    public function get_retur_purchase($start_date, $end_date, $supplier_id)
    {
        $this->db->select('*');
        $this->db->join('dt_retur_purchase', 'hd_retur_purchase.hd_retur_purchase_invoice = dt_retur_purchase.dt_retur_purchase_invoice');
        $this->db->join('hd_purchase', 'hd_retur_purchase.hd_purchase_no = hd_purchase.hd_purchase_id');
        $this->db->join('ms_product_detail', 'dt_retur_purchase.dt_retur_item_id = ms_product_detail.item_id');
        $this->db->join('ms_product', 'ms_product_detail.product_code = ms_product.product_code');
        $this->db->join('ms_supplier', 'hd_retur_purchase.hd_retur_supplier_id = ms_supplier.supplier_id');
        $this->db->join('ms_category', 'ms_product.category_id = ms_category.category_id');
        $this->db->join('ms_brand', 'ms_product.brand_id = ms_brand.brand_id');
        $this->db->join('ms_unit', 'ms_product.unit_id = ms_unit.unit_id');
        $this->db->where('hd_retur_date between "'.$start_date.'" and "'.$end_date.'"');
        if($supplier_id != '' || $supplier_id != null){
            $this->db->where('hd_retur_supplier_id', $supplier_id);
        }
        $q =  $this->db->get('hd_retur_purchase');
        $query = $q->result_array();
        return $query;
    }

    public function get_product_catalog($category_id, $brand_id)
    {
        $this->db->select('*');
        $this->db->join('ms_product', 'ms_product_detail.product_code = ms_product.product_code');
        $this->db->join('ms_category', 'ms_product.category_id = ms_category.category_id');
        $this->db->join('ms_brand', 'ms_product.brand_id = ms_brand.brand_id');
        $this->db->join('ms_unit', 'ms_product.unit_id = ms_unit.unit_id');
        if($category_id != '' || $category_id != null){
            $this->db->where('ms_product.category_id', $category_id);
        }
        if($brand_id != '' || $brand_id != null){
            $this->db->where('ms_product.brand_id', $brand_id);
        }
        $q =  $this->db->get('ms_product_detail');
        $query = $q->result_array();
        return $query;
    }   

    public function get_sales($start_date, $end_date, $customer_id, $salesman_id, $status)
    {

        $cur_date = date('Y-m-d');
        $this->db->select('*');
        $this->db->join('dt_sales', 'hd_sales.hd_sales_invoice = dt_sales.dt_sales_invoice');
        $this->db->join('ms_product_detail', 'dt_sales.dt_sales_product_id = ms_product_detail.item_id');
        $this->db->join('ms_product', 'ms_product_detail.product_code = ms_product.product_code');
        $this->db->join('ms_customer', 'hd_sales.hd_sales_customer = ms_customer.customer_id');
        $this->db->join('ms_category', 'ms_product.category_id = ms_category.category_id');
        $this->db->join('ms_brand', 'ms_product.brand_id = ms_brand.brand_id');
        $this->db->join('ms_unit', 'ms_product.unit_id = ms_unit.unit_id');
        $this->db->join('ms_sales', 'hd_sales.hd_sales_sales = ms_sales.sales_id');
        $this->db->where('hd_sales_date between "'.$start_date.'" and "'.$end_date.'"');

        if($customer_id != '' || $customer_id != null){
            $this->db->where('hd_sales_customer', $customer_id);
        }
        if($salesman_id != '' || $salesman_id != null){
            $this->db->where('hd_sales_sales', $salesman_id);
        }
        if($status != '' || $status != null){
            $this->db->where('hd_sales_due_date >=', $cur_date);
        }
        $q =  $this->db->get('hd_sales');
        $query = $q->result_array();
        return $query;
    }

    public function get_sales_due($start_date, $end_date, $customer_id, $salesman_id, $status)
    {

        $cur_date = date('Y-m-d');
        $this->db->select('*');
        $this->db->join('dt_sales', 'hd_sales.hd_sales_invoice = dt_sales.dt_sales_invoice');
        $this->db->join('ms_product_detail', 'dt_sales.dt_sales_product_id = ms_product_detail.item_id');
        $this->db->join('ms_product', 'ms_product_detail.product_code = ms_product.product_code');
        $this->db->join('ms_customer', 'hd_sales.hd_sales_customer = ms_customer.customer_id');
        $this->db->join('ms_category', 'ms_product.category_id = ms_category.category_id');
        $this->db->join('ms_brand', 'ms_product.brand_id = ms_brand.brand_id');
        $this->db->join('ms_unit', 'ms_product.unit_id = ms_unit.unit_id');
        $this->db->join('ms_sales', 'hd_sales.hd_sales_sales = ms_sales.sales_id');
        $this->db->where('hd_sales_due_date between "'.$start_date.'" and "'.$end_date.'"');
        
        if($customer_id != '' || $customer_id != null){
            $this->db->where('hd_sales_customer', $customer_id);
        }
        if($salesman_id != '' || $salesman_id != null){
            $this->db->where('hd_sales_sales', $salesman_id);
        }
        if($status != '' || $status != null){
            $this->db->where('hd_sales_due_date >=', $cur_date);
        }
        $q =  $this->db->get('hd_sales');
        $query = $q->result_array();
        return $query;
    }

    public function get_sales_not_send(){
        $this->db->select('*');
        $this->db->join('dt_sales', 'hd_sales.hd_sales_invoice = dt_sales.dt_sales_invoice');
        $this->db->join('ms_product_detail', 'dt_sales.dt_sales_product_id = ms_product_detail.item_id');
        $this->db->join('ms_product', 'ms_product_detail.product_code = ms_product.product_code');
        $this->db->join('ms_customer', 'hd_sales.hd_sales_customer = ms_customer.customer_id');
        $this->db->join('ms_category', 'ms_product.category_id = ms_category.category_id');
        $this->db->join('ms_brand', 'ms_product.brand_id = ms_brand.brand_id');
        $this->db->join('ms_unit', 'ms_product.unit_id = ms_unit.unit_id');
        $this->db->join('ms_sales', 'hd_sales.hd_sales_sales = ms_sales.sales_id');
        $this->db->where('hd_delivery_status', 'Belum');
        $q =  $this->db->get('hd_sales');
        $query = $q->result_array();
        return $query;
    }

    public function get_debt($start_date, $end_date, $supplier_id)
    {
        $this->db->select('*');
        $this->db->join('dt_payment_debt', 'hd_payment_debt.payment_debt_invoice = dt_payment_debt.payment_debt_invoice'); 
        $this->db->join('hd_purchase', 'dt_payment_debt.dt_payment_debt_purchase_id = hd_purchase.hd_purchase_id'); 
        $this->db->join('ms_supplier', 'hd_payment_debt.payment_debt_supplier_id = ms_supplier.supplier_id'); 
        $this->db->join('ms_payment', 'hd_payment_debt.payment_debt_method_id = ms_payment.payment_id');
        $this->db->where('payment_debt_date between "'.$start_date.'" and "'.$end_date.'"');
        if($supplier_id != '' || $supplier_id != null){
            $this->db->where('payment_debt_supplier_id', $supplier_id);
        }
        $q =  $this->db->get('hd_payment_debt');
        $query = $q->result_array();
        return $query;
    }

    public function get_debt_pending($supplier_id)
    {
        $this->db->select('count(*) as total_nota, supplier_name, sum(hd_purchase_remaining_debt) as total_hutang'); 
        $this->db->join('ms_supplier', 'hd_purchase.hd_purchase_supplier_id = ms_supplier.supplier_id'); 
        if($supplier_id != '' || $supplier_id != null){
            $this->db->where('hd_purchase_supplier_id', $supplier_id);
        }
        $this->db->where('hd_purchase_remaining_debt > 0');
        $q =  $this->db->get('hd_purchase');
        $query = $q->result_array();
        return $query;
    }

    public function get_debt_pending_excell($supplier_id)
    {        
        $this->db->select('*');
        $this->db->join('dt_payment_debt', 'hd_payment_debt.payment_debt_invoice = dt_payment_debt.payment_debt_invoice'); 
        $this->db->join('hd_purchase', 'dt_payment_debt.dt_payment_debt_purchase_id = hd_purchase.hd_purchase_id'); 
        $this->db->join('ms_supplier', 'hd_payment_debt.payment_debt_supplier_id = ms_supplier.supplier_id'); 
        $this->db->join('ms_payment', 'hd_payment_debt.payment_debt_method_id = ms_payment.payment_id');
        if($supplier_id != '' || $supplier_id != null){
            $this->db->where('payment_debt_supplier_id', $supplier_id);
        }
        $this->db->order_by('supplier_name', 'desc');
        $q =  $this->db->get('hd_payment_debt');
        $query = $q->result_array();
        return $query;
    }

    public function get_repayment($start_date, $end_date, $customer_id)
    {
        $this->db->select('*');
        $this->db->join('dt_payment_receivable', 'hd_payment_receivable.payment_receivable_invoice = dt_payment_receivable.payment_receivable_invoice'); 
        $this->db->join('hd_sales', 'dt_payment_receivable.dt_payment_receivable_sales_id = hd_sales.hd_sales_id'); 
        $this->db->join('ms_customer', 'hd_payment_receivable.payment_receivable_customer_id = ms_customer.customer_id'); 
        $this->db->join('ms_payment', 'hd_payment_receivable.payment_receivable_method_id = ms_payment.payment_id');
        $this->db->where('payment_receivable_date between "'.$start_date.'" and "'.$end_date.'"');
        if($customer_id != '' || $customer_id != null){
            $this->db->where('payment_receivable_customer_id', $customer_id);
        }
        $q =  $this->db->get('hd_payment_receivable');
        $query = $q->result_array();
        return $query;
    }

    public function get_repayment_pending($customer_id)
    {
        $this->db->select('count(*) as total_nota, customer_name, sum(hd_sales_remaining_debt) as total_hutang'); 
        $this->db->join('ms_customer', 'hd_sales.hd_sales_customer = ms_customer.customer_id'); 
        if($customer_id != '' || $customer_id != null){
            $this->db->where('hd_sales_customer_id', $customer_id);
        }
        $this->db->where('hd_sales_remaining_debt > 0');
        $q =  $this->db->get('hd_sales');
        $query = $q->result_array();
        return $query;
    }


    public function get_repayment_pending_excell($customer_id)
    {        
        $this->db->select('*');
        $this->db->join('dt_payment_receivable', 'hd_payment_receivable.payment_receivable_invoice = dt_payment_receivable.payment_receivable_invoice'); 
        $this->db->join('hd_sales', 'dt_payment_receivable.dt_payment_receivable_sales_id = hd_sales.hd_sales_id'); 
        $this->db->join('ms_customer', 'hd_payment_receivable.payment_receivable_customer_id = ms_customer.customer_id'); 
        $this->db->join('ms_payment', 'hd_payment_receivable.payment_receivable_method_id = ms_payment.payment_id');
        if($customer_id != '' || $customer_id != null){
            $this->db->where('payment_receivable_customer_id', $customer_id);
        }
        $this->db->order_by('customer_name', 'desc');
        $q =  $this->db->get('hd_payment_receivable');
        $query = $q->result_array();
        return $query;
    }

    public function get_retur_sales($start_date, $end_date, $customer_id)
    {
        $this->db->select('*');
        $this->db->join('dt_retur_sales', 'hd_retur_sales.hd_retur_sales_invoice = dt_retur_sales.dt_retur_sales_invoice');
        $this->db->join('hd_sales', 'hd_retur_sales.hd_sales_no = hd_sales.hd_sales_id');
        $this->db->join('ms_product_detail', 'dt_retur_sales.dt_retur_item_id = ms_product_detail.item_id');
        $this->db->join('ms_product', 'ms_product_detail.product_code = ms_product.product_code');
        $this->db->join('ms_customer', 'hd_retur_sales.hd_retur_customer_id = ms_customer.customer_id');
        $this->db->join('ms_category', 'ms_product.category_id = ms_category.category_id');
        $this->db->join('ms_brand', 'ms_product.brand_id = ms_brand.brand_id');
        $this->db->join('ms_unit', 'ms_product.unit_id = ms_unit.unit_id');
        $this->db->where('hd_retur_date between "'.$start_date.'" and "'.$end_date.'"');
        if($customer_id != '' || $customer_id != null){
            $this->db->where('hd_retur_customer_id', $customer_id);
        }
        $q =  $this->db->get('hd_retur_sales');
        $query = $q->result_array();
        return $query;
    }

    public function get_sales_minus($start_date, $end_date)
    {
        $this->db->select('*');
        $this->db->join('ms_product_detail', 'report_minus_sales.report_minus_sales_product_id = ms_product_detail.item_id ');
        $this->db->where('report_minus_sales_date between "'.$start_date.'" and "'.$end_date.'"');
        $q =  $this->db->get('report_minus_sales');
        $query = $q->result_array();
        return $query;
    }

    public function stock_card($category_id, $brand_id)
    {
        $this->db->select('*');
        $this->db->join('ms_product_detail', 'stock_movement.stock_movement_product_id = ms_product_detail.item_id');
        $this->db->join('ms_product', 'ms_product_detail.product_code = ms_product.product_code');
        $this->db->join('ms_category', 'ms_product.category_id = ms_category.category_id');
        $this->db->join('ms_brand', 'ms_product.brand_id = ms_brand.brand_id');
        $this->db->join('ms_unit', 'ms_product.unit_id = ms_unit.unit_id');
        $this->db->where('hd_retur_date between "'.$start_date.'" and "'.$end_date.'"');
        if($category_id != '' || $category_id != null){
            $this->db->where('category_id', $category_id);
        }
        if($brand_id != '' || $brand_id != null){
            $this->db->where('brand_id', $brand_id);
        }
        $q =  $this->db->get('stock_movement');
        $query = $q->result_array();
        return $query;
    }

    public function stock_card_pdf($item_id)
    {
        $this->db->select('*');
        $this->db->join('ms_product_detail', 'stock_movement.stock_movement_product_id = ms_product_detail.item_id');
        $this->db->join('ms_product', 'ms_product_detail.product_code = ms_product.product_code');
        $this->db->join('ms_category', 'ms_product.category_id = ms_category.category_id');
        $this->db->join('ms_brand', 'ms_product.brand_id = ms_brand.brand_id');
        $this->db->join('ms_unit', 'ms_product.unit_id = ms_unit.unit_id');
        $this->db->where('stock_movement_product_id', $item_id);
        $q =  $this->db->get('stock_movement');
        $query = $q->result_array();
        return $query;
    }


}

?>  