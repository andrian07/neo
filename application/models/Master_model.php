<?php

class master_model extends CI_Model {


    protected $ms_brand   = 'ms_brand';
    protected $ms_category  = 'ms_category';
    protected $ms_label  = 'ms_label';
    protected $ms_unit  = 'ms_unit';
    protected $ms_supplier  = 'ms_supplier';
    protected $ms_customer  = 'ms_customer';
    protected $ms_sales  = 'ms_sales';


    // Payment //
    public function payment_list()
    {
        $query = $this->db->query("select * from ms_payment");
        $result = $query->result();
        return $result;
    }
    // End Payment //

    // Brand //
    public function save_brand($data_insert)
    {
        $this->db->insert('ms_brand', $data_insert);
    }

    public function update_brand($data_update, $brand_id)
    {
        $this->db->set($data_update);
        $this->db->where('brand_id ', $brand_id);
        $this->db->update('ms_brand');
    }

    public function delete_brand($brand_id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('brand_id ', $brand_id);
        $this->db->update('ms_brand');
    }

    public function brand_list()
    {
        $query = $this->db->query("select * from ms_brand where is_active = 'Y'");
        $result = $query->result();
        return $result;
    }
    // End Brand //


    // Unit //
    public function save_unit($data_insert)
    {
        $this->db->insert('ms_unit', $data_insert);
    }

    public function update_unit($data_update, $unit_id)
    {
        $this->db->set($data_update);
        $this->db->where('unit_id ', $unit_id);
        $this->db->update('ms_unit');
    }

    public function delete_unit($unit_id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('unit_id ', $unit_id);
        $this->db->update('ms_unit');
    }

    public function unit_list()
    {
        $query = $this->db->query("select * from ms_unit where is_active = 'Y'");
        $result = $query->result();
        return $result;
    }
    // End unit //

    // Category //
    public function save_category($data_insert)
    {
        $this->db->insert('ms_category', $data_insert);
    }

    public function update_category($data_update, $category_id)
    {
        $this->db->set($data_update);
        $this->db->where('category_id ', $category_id);
        $this->db->update('ms_category');
    }

    public function delete_category($category_id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('category_id ', $category_id);
        $this->db->update('ms_category');
    }

    public function category_list()
    {
        $query = $this->db->query("select * from ms_category where is_active = 'Y'");
        $result = $query->result();
        return $result;
    }
    // End Category //


    // Label //
    public function save_label($data_insert)
    {
        $this->db->insert('ms_label', $data_insert);
    }

    public function update_label($data_update, $label_id)
    {
        $this->db->set($data_update);
        $this->db->where('label_id ', $label_id);
        $this->db->update('ms_label');
    }

    public function delete_label($label_id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('label_id ', $label_id);
        $this->db->update('ms_label');
    }

    public function label_list($label_name, $takePage, $offset)
    {
        if($label_name == null){
            $query = $this->db->query("select * from ms_label where is_active = 'Y' ORDER BY label_id LIMIT ".$takePage." OFFSET ".$offset."");
        }else{
            $query = $this->db->query("select * from ms_label where is_active = 'Y' and label_name like '%".$label_name."%' ORDER BY label_id LIMIT ".$takePage." OFFSET ".$offset."");
        }
        $result = $query->result();
        return $result;
    }
    // End Label //


    // Supplier //
    public function save_supplier($data_insert)
    {
        $this->db->insert('ms_supplier', $data_insert);
    }

    public function update_supplier($data_update, $supplier_id)
    {
        $this->db->set($data_update);
        $this->db->where('supplier_id ', $supplier_id);
        $this->db->update('ms_supplier');
    }

    public function delete_supplier($supplier_id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('supplier_id ', $supplier_id);
        $this->db->update('ms_supplier');
    }

    public function supplier_list()
    {

        $query = $this->db->query("select * from ms_supplier where is_active = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function check_supplier_code($supplier_code)
    {
        $query = $this->db->query("select * from ms_supplier where supplier_code = '".$supplier_code."'");
        $result = $query->result();
        return $result;
    }

    public function get_max_sup_code()
    {
        $query = $this->db->query("select supplier_code from ms_supplier order by supplier_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    // End Supplier //

    // Customer //
    public function save_customer($data_insert)
    {
        $this->db->insert('ms_customer', $data_insert);
    }

    public function get_max_cust_code()
    {
        $query = $this->db->query("select customer_code from ms_customer order by customer_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function update_customer($data_update, $customer_id)
    {
        $this->db->set($data_update);
        $this->db->where('customer_id ', $customer_id);
        $this->db->update('ms_customer');
    }

    public function delete_customer($customer_id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('customer_id ', $customer_id);
        $this->db->update('ms_customer');
    }

    public function customer_list()
    {
        $query = $this->db->query("select * from ms_customer where is_active = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function check_customer_code($customer_code)
    {
        $query = $this->db->query("select * from ms_customer where customer_code = '".$customer_code."'");
        $result = $query->result();
        return $result;
    }

    // End Supplier //


    // Salesman //
    public function sales_list()
    {
        $query = $this->db->query("select * from ms_sales where is_active = 'Y'");
        $result = $query->result();
        return $result;
    }
    public function save_sales($data_insert)
    {
        $this->db->insert('ms_sales', $data_insert);
    }

    public function get_max_sales_code()
    {
        $query = $this->db->query("select sales_code from ms_sales order by sales_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function update_sales($data_update, $sales_id)
    {
        $this->db->set($data_update);
        $this->db->where('sales_id ', $sales_id);
        $this->db->update('ms_sales');
    }

    public function delete_sales($sales_id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('sales_id ', $sales_id);
        $this->db->update('ms_sales');
    }

    public function check_sales_code($sales_code)
    {
        $query = $this->db->query("select * from ms_sales where sales_code = '".$sales_code."'");
        $result = $query->result();
        return $result;
    }

    // End Salesman //

    // Product //
    public function save_product($data_insert)
    {
        $this->db->insert('ms_product', $data_insert);
    }

    public function save_package($insert_package)
    {
        $this->db->insert('ms_product_packet', $insert_package);
    }

    public function get_last_prodcut_code()
    {
        $query = $this->db->query("select product_code from ms_product order by product_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function search_product_list($searchin_key)
    {
        $this->db->select('*');
        $this->db->from('ms_product_detail');
        $this->db->join('ms_product', 'ms_product_detail.product_code = ms_product.product_code');
        $this->db->join('ms_unit', 'ms_product.unit_id = ms_unit.unit_id');
        $this->db->where('ms_product_detail.item_active', 'y');
        if($searchin_key != null){
            $this->db->where('ms_product_detail.item_name like "%'.$searchin_key.'%"');
            $this->db->or_where('ms_product_detail.item_barcode like "%'.$searchin_key.'%"');
        }
        $this->db->limit(50);
        $query = $this->db->get();
        return $query;
    }



    public function delete_product_detail($product_id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('product_id ', $product_id);
        $this->db->update('ms_product');
    }

    public function delete_product($product_group_code)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('product_group_code ', $product_group_code);
        $this->db->update('ms_product');
    }

    public function save_product_supplier($data_insert_supplier)
    {
        $this->db->insert('ms_product_supplier', $data_insert_supplier);
    }

    public function save_product_varian($insert_variant)
    {
        $this->db->insert('ms_product_detail', $insert_variant);
    }

    public function product_list()
    {
        $this->db->select('*, supplier_name AS supplier_name_group');
        $this->db->join('ms_brand', 'ms_product.brand_id = ms_brand.brand_id');
        $this->db->join('ms_category', 'ms_product.category_id = ms_category.category_id');
        $this->db->join('ms_unit', 'ms_product.unit_id = ms_unit.unit_id');
        $this->db->join('ms_product_supplier', 'ms_product.product_code = ms_product.product_code');
        $this->db->join('ms_supplier', 'ms_product_supplier.supplier_id = ms_supplier.supplier_id');
        $this->db->where('ms_product.is_active', 'Y');
        $this->db->group_by('ms_product.product_code');
        $this->db->order_by('ms_product.product_id');
        $q =  $this->db->get('ms_product');
        $query = $q->result_array();
        return $query;
    }

    public function product_list_report()
    {
        $this->db->select('*, (SELECT GROUP_CONCAT(supplier_name SEPARATOR ",") AS supplier_name_group FROM ms_product_supplier a, ms_supplier g where a.supplier_id = g.supplier_id and product_code = ms_product.product_code group by ms_product_supplier.product_code) AS supplier_name_group');
        $this->db->join('ms_product_detail', 'ms_product.product_code = ms_product_detail.product_code');
        $this->db->join('ms_brand', 'ms_product.brand_id = ms_brand.brand_id');
        $this->db->join('ms_category', 'ms_product.category_id = ms_category.category_id');
        $this->db->join('ms_unit', 'ms_product.unit_id = ms_unit.unit_id');
        $this->db->join('ms_product_supplier', 'ms_product.product_code = ms_product.product_code');
        $this->db->join('ms_supplier', 'ms_product_supplier.supplier_id = ms_supplier.supplier_id');
        $this->db->where('ms_product.is_active', 'Y');
        $this->db->group_by('ms_product_detail.item_barcode');
        $this->db->order_by('ms_product.product_id');
        $q =  $this->db->get('ms_product');
        $query = $q->result_array();
        return $query;
    }

    public function product_list_under_stock()
    {
        $this->db->select('*, (SELECT GROUP_CONCAT(supplier_name SEPARATOR ",") AS supplier_name_group FROM ms_product_supplier a, ms_supplier g where a.supplier_id = g.supplier_id and product_code = ms_product.product_code group by ms_product_supplier.product_code) AS supplier_name_group');
        $this->db->join('ms_product_detail', 'ms_product.product_code = ms_product_detail.product_code');
        $this->db->join('ms_brand', 'ms_product.brand_id = ms_brand.brand_id');
        $this->db->join('ms_category', 'ms_product.category_id = ms_category.category_id');
        $this->db->join('ms_unit', 'ms_product.unit_id = ms_unit.unit_id');
        $this->db->join('ms_product_supplier', 'ms_product.product_code = ms_product.product_code');
        $this->db->join('ms_supplier', 'ms_product_supplier.supplier_id = ms_supplier.supplier_id');
        $this->db->where('ms_product.is_active', 'Y');
        $this->db->where('item_stock < min_stock');
        $this->db->group_by('ms_product_detail.item_barcode');
        $this->db->order_by('ms_product.product_id');
        $q =  $this->db->get('ms_product');
        $query = $q->result_array();
        return $query;
    }

    public function get_edited_product($id)
    {
        $this->db->select('*, (SELECT GROUP_CONCAT(supplier_name SEPARATOR ",") AS supplier_name_group FROM ms_product_supplier a, ms_supplier g where a.supplier_id = g.supplier_id and product_code = ms_product.product_code group by ms_product_supplier.product_code) AS supplier_name_group, (SELECT GROUP_CONCAT(g.supplier_id SEPARATOR ",") AS supplier_name_group FROM ms_product_supplier a, ms_supplier g where a.supplier_id = g.supplier_id and product_code = ms_product.product_code group by ms_product_supplier.product_code) AS supplier_id_group');
        $this->db->join('ms_brand', 'ms_product.brand_id = ms_brand.brand_id');
        $this->db->join('ms_category', 'ms_product.category_id = ms_category.category_id');
        $this->db->join('ms_unit', 'ms_product.unit_id = ms_unit.unit_id');
        $this->db->join('ms_product_supplier', 'ms_product.product_code = ms_product.product_code');
        $this->db->join('ms_supplier', 'ms_product_supplier.supplier_id = ms_supplier.supplier_id');
        $this->db->where('ms_product.is_active', 'Y');
        $this->db->where('ms_product.product_id', $id);
        $this->db->group_by('ms_product.product_code');
        $this->db->order_by('ms_product.product_id');
        $q =  $this->db->get('ms_product');
        $query = $q->result_array();
        return $query;
    }

    public function get_afkir($id)
    {
        $this->db->select('item_stock, item_afkir');
        $this->db->where('item_id', $id);
        $q =  $this->db->get('ms_product_detail');
        $query = $q->result_array();
        return $query;
    }

    public function get_edited_variant($id)
    {
        $this->db->select('*');
        $this->db->where('item_active', 'Y');
        $this->db->where('item_id', $id);
        $q =  $this->db->get('ms_product_detail');
        $query = $q->result_array();
        return $query;
    }

    public function get_product_by_id($id)
    {
        $this->db->select('*');
        $this->db->join('ms_brand', 'ms_product.brand_id = ms_brand.brand_id');
        $this->db->join('ms_category', 'ms_product.category_id = ms_category.category_id');
        $this->db->join('ms_unit', 'ms_product.unit_id = ms_unit.unit_id');
        $this->db->where('ms_product.is_active', 'Y');
        $this->db->where('ms_product.product_id', $id);
        $this->db->order_by('ms_product.product_id');
        $q =  $this->db->get('ms_product');
        $query = $q->result_array();
        return $query;
    }

    public function get_product_by_id_search($id)
    {
        $this->db->select('*');
        $this->db->where('ms_product_detail.item_id', $id);
        $q =  $this->db->get('ms_product_detail');
        $query = $q->result_array();
        return $query;
    }

    

    public function check_product_detail($code)
    {
        $this->db->select('count(*)');
        $this->db->where('item_active', 'Y');
        $this->db->where('product_code', $code);
        $q =  $this->db->get('ms_product_detail');
        $query = $q->result_array();
        return $query;
    }

    public function get_detail_product($code)
    {
        $this->db->select('*');
        $this->db->where('item_active', 'Y');
        $this->db->where('product_code', $code);
        $q =  $this->db->get('ms_product_detail');
        $query = $q->result_array();
        return $query;
    }


    public function edit_product($update_data, $product_id)
    {
        $this->db->set($update_data);
        $this->db->where('product_id ', $product_id);
        $this->db->update('ms_product');
    }

    public function delete_product_supplier($product_code)
    {
        $this->db->where('product_code', $product_code);
        $this->db->delete('ms_product_supplier');
    }

    public function delete_variant($id)
    {
        $this->db->set('item_active', 'N');
        $this->db->where('item_id ', $id);
        $this->db->update('ms_product_detail');
    }

    // End Product //

    // start product package //

    public function save_package_detail($data_insert)
    {
        $this->db->insert('ms_product_packet', $data_insert);
    }

    public function product_list_package()
    {
        $query = $this->db->query("select * from ms_product_detail where is_package = 'Y' and item_active = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function get_package_detail($id)
    {
        $query = $this->db->query("select * from ms_product_detail a, ms_product_packet b where a.item_id = b.item_package_id and item_active = 'Y' and b.item_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function get_package_info($id)
    {
        $query = $this->db->query("select * from ms_product_detail where item_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function delete_containt($product_packet_id)
    {
        $this->db->where('product_packet_id', $product_packet_id);
        $this->db->delete('ms_product_packet');
    }

    public function check_stock_input_package($item_stock_id)
    {
        $query = $this->db->query("select * from ms_product_detail a, ms_product_packet b where a.item_id = b.item_id and a.item_id = '".$item_stock_id."'");
        $result = $query->result();
        return $result;
    }

    public function get_last_afkir($product_id_afkir)
    {
        $query = $this->db->query("select item_stock, item_afkir from ms_product_detail where item_id = '".$product_id_afkir."'");
        $result = $query->result();
        return $result;
    }

    public function check_stock_ready($item_package_id)
    {
        $query = $this->db->query("select * from ms_product_detail a, ms_product_packet b where a.item_id = b.item_package_id and a.item_id = '".$item_package_id."'");
        $result = $query->result();
        return $result;
    }

    public function update_stock_package($item_package_id, $new_stock)
    {
        $this->db->set('item_stock', $new_stock);
        $this->db->where('item_id', $item_package_id);
        $this->db->update('ms_product_detail');
    }

    public function update_stock_package_item($item_stock_id, $item_stock_total)
    {
        $this->db->set('item_stock', $item_stock_total);
        $this->db->where('item_id', $item_stock_id);
        $this->db->update('ms_product_detail');
    }

    public function update_product_afkir($update, $product_id_afkir)
    {
        $this->db->set($update);
        $this->db->where('item_id', $product_id_afkir);
        $this->db->update('ms_product_detail');
    }

    public function catalog_pdf($category_id, $brand_id)
    {   
        if($brand_id != null && $category_id != null){
            $query = $this->db->query("select * from ms_product a, ms_product_detail b, ms_category c, ms_brand d where a.product_code = b.product_code and a.category_id = c.category_id and a.brand_id = d.brand_id and a.category_id = '".$category_id."' and a.brand_id = '".$brand_id."'");
        }else if($brand_id != null){
            $query = $this->db->query("select * from ms_product a, ms_product_detail b, ms_category c, ms_brand d where a.product_code = b.product_code and a.category_id = c.category_id and a.brand_id = d.brand_id and a.brand_id = '".$brand_id."'");
        }else{
            $query = $this->db->query("select * from ms_product a, ms_product_detail b, ms_category c, ms_brand d where a.product_code = b.product_code and a.category_id = c.category_id and a.brand_id = d.brand_id");
        }
        $this->db->where('is_active', 'Y');
        $result = $query->result();
        return $result;
    }

    // end product package //

    // start user //

    public function user_list()
    {
        $query = $this->db->query("select * from user_login where user_name not like 'user_name' and is_active = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function save_user($insert)
    {
        $this->db->insert('user_login', $insert);
    }

    public function update_user($update, $user_id)
    {
        $this->db->set($update);
        $this->db->where('user_id ', $user_id);
        $this->db->update('user_login');
    }

    public function delete_user($user_id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('user_id ', $user_id);
        $this->db->update('user_login');
    }
    // end user //

    // role//
    public function role_list()
    {
        $query = $this->db->query("select * from ms_role where is_active = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function get_modul()
    {
        $query = $this->db->query("select module_name from user_module where user_role = 1");
        $result = $query->result();
        return $result;
    }

    public function get_header_modul()
    {
        $query = $this->db->query("select user_module_header_name from user_module_header where user_module_header_role = 1");
        $result = $query->result();
        return $result;
    }

    public function save_role($insert)
    {
        $this->db->trans_start();
        $this->db->insert('ms_role', $insert);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return  $insert_id;
    }

    public function insert_user_module($insert_user_module)
    {
        $this->db->insert('user_module', $insert_user_module);
    }

    public function insert_user_header_module($insert_user_header_module)
    {
        $this->db->insert('user_module_header', $insert_user_header_module);
    }

    public function update_role($update, $role_id)
    {
        $this->db->set($update);
        $this->db->where('role_id ', $role_id);
        $this->db->update('ms_role');
    }

    public function delete_role($role_id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('role_id ', $role_id);
        $this->db->update('ms_role');
    }

    public function get_setting_permission($id)
    {
        $query = $this->db->query("select * from ms_role a, user_module b, user_module_header c where a.role_id = b.user_role and a.role_id = c.user_module_header_role and a.role_id = '".$id."' group by module_name;");
        $result = $query->result();
        return $result;
    }

    public function update_permission($module, $data, $role_id)
    {
        $this->db->set($data);
        $this->db->where('module_name ', $module);
        $this->db->where('user_role ', $role_id);
        $this->db->update('user_module');
    }

    public function update_header_permission($user_module_header_name, $data_header_update, $role_id)
    {
        $this->db->set($data_header_update);
        $this->db->where('user_module_header_name ', $user_module_header_name);
        $this->db->where('user_module_header_role ', $role_id);
        $this->db->update('user_module_header');
    }
    // end role //
}

?>  