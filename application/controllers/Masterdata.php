<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
//require 'vendor/autoload.php';


class Masterdata extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('master_model');
		$this->load->model('global_model');
		$this->load->helper(array('url', 'html'));
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index(){
		if(isset($_SESSION['user_name']) != null){
			redirect('Dashboard/Admin', 'refresh');
		}else{
			$this->load->view('Pages/login');
		}
	}


	private function check_auth(){
		if(isset($_SESSION['user_name']) == null){
			redirect('Dashboard', 'refresh');
		}
	}

	private function check_role($role, $modul){
		$check_role = $this->global_model->check_role($role, $modul);
		return $check_role;
	}

	// Brand //

	public function brand()
	{	
		$this->check_auth();
		$role  	= $_SESSION['user_role'];
		$modul 	= 'Brand';
		$check_role = $this->check_role($role, $modul);
		if($check_role[0]->view_ac == 'Y'){
			$brand_list['brand_list'] = $this->master_model->brand_list();
			$check_role['check_role'] = $check_role;
			$data['data'] = array_merge($brand_list, $check_role);
			$this->load->view('Pages/Master/brand', $data);
		}else{
			print_r("No Akses");die();
		}
		
	}

	public function insert_brand()
	{
		$brand_name   	   = $this->input->post('brand_name');
		$brand_desc        = $this->input->post('brand_desc');

		if($brand_name == null){
			$msg = "Nama Brand Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
		$insert = array(
			'brand_name'	       => $brand_name,
			'brand_desc'	       => $brand_desc,
		);
		$this->master_model->save_brand($insert);
		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function edit_brand()
	{
		$brand_id   	   = $this->input->post('id');
		$brand_name   	   = $this->input->post('brand_name_edit');
		$brand_desc        = $this->input->post('brand_desc_edit');

		if($brand_name == null){
			$msg = "Nama Brand Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$update = array(
			'brand_name'	       => $brand_name,
			'brand_desc'	       => $brand_desc,
		);

		$this->master_model->update_brand($update, $brand_id);
		$msg = "Succes Update";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function delete_brand()
	{

		$brand_id  = $this->input->post('id');
		$this->master_model->delete_brand($brand_id);
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();

	}
	// End Brand //


	// Unit //
	public function unit()
	{

		$this->check_auth();
		$role  	= $_SESSION['user_role'];
		$modul 	= 'Unit';
		$check_role = $this->check_role($role, $modul);
		if($check_role[0]->view_ac == 'Y'){
			$unit_list['unit_list'] = $this->master_model->unit_list();
			$check_role['check_role'] = $check_role;
			$data['data'] = array_merge($unit_list, $check_role);
			$this->load->view('Pages/Master/unit', $data);
		}else{
			print_r("No Akses");die();
		}
	}

	public function insert_unit()
	{
		$unit_name   	  = $this->input->post('unit_name');
		$unit_desc        = $this->input->post('unit_desc');

		if($unit_name == null){
			$msg = "Nama Unit Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
		$insert = array(
			'unit_name'	       => $unit_name,
			'unit_desc'	       => $unit_desc,
		);
		$this->master_model->save_unit($insert);
		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function edit_unit()
	{

		$unit_id   	   	= $this->input->post('id');
		$unit_name   	= $this->input->post('unit_name');
		$unit_desc      = $this->input->post('unit_desc');

		if($unit_name == null){
			$msg = "Nama Unit Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$update = array(
			'unit_name'	       => $unit_name,
			'unit_desc'	       => $unit_desc,
		);

		$this->master_model->update_unit($update, $unit_id);
		$msg = "Succes Update";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function delete_unit()
	{

		$unit_id   	   = $this->input->post('id');
		$this->master_model->delete_unit($unit_id);
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
	}
	// End Unit //


	// Category //

	public function category()
	{
		$this->check_auth();
		$role  	= $_SESSION['user_role'];
		$modul 	= 'Category';
		$check_role = $this->check_role($role, $modul);
		if($check_role[0]->view_ac == 'Y'){
			$category_list['category_list'] = $this->master_model->category_list();
			$check_role['check_role'] = $check_role;
			$data['data'] = array_merge($category_list, $check_role);
			$this->load->view('Pages/Master/category', $data);
		}else{
			print_r("No Akses");die();
		}
	}

	public function insert_category()
	{
		$category_name   	   = $this->input->post('category_name');
		$category_desc        = $this->input->post('category_desc');

		if($category_name == null){
			$msg = "Nama Kategori Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
		$insert = array(
			'category_name'	       => $category_name,
			'category_desc'	       => $category_desc,
		);
		$this->master_model->save_category($insert);
		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function edit_category()
	{

		$category_id   	   = $this->input->post('id');
		$category_name     = $this->input->post('category_name');
		$category_desc     = $this->input->post('category_desc');

		if($category_name == null){
			$msg = "Nama Kategori Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$update = array(
			'category_name'	       => $category_name,
			'category_desc'	       => $category_desc,
		);

		$this->master_model->update_category($update, $category_id);
		$msg = "Succes Update";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function delete_category()
	{
		$category_id   	   = $this->input->post('id');
		$this->master_model->delete_category($category_id);
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}
	// End Category //


	// Supplier //

	public function supplier()
	{
		$this->check_auth();
		$role  	= $_SESSION['user_role'];
		$modul 	= 'Supplier';
		$check_role = $this->check_role($role, $modul);
		if($check_role[0]->view_ac == 'Y'){
			$supplier_list['supplier_list'] = $this->master_model->supplier_list();
			$check_role['check_role'] = $check_role;
			$data['data'] = array_merge($supplier_list, $check_role);
			$this->load->view('Pages/Master/supplier', $data);
		}else{
			print_r("No Akses");die();
		}
	}

	public function insert_supplier()
	{
		
		$supplier_name       = $this->input->post('supplier_name');
		$supplier_phone   	 = $this->input->post('supplier_phone');
		$supplier_address    = $this->input->post('supplier_address');
		$supplier_npwp   	 = $this->input->post('supplier_npwp');


		if($supplier_name == null){
			$msg = "Nama Supplier Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		

		$maxCode  	        = $this->master_model->get_max_sup_code();
		if ($maxCode == NULL) {
			$supplier_code = 'SP-'.'0000000001';
		} else {
			$supplier_code   = $maxCode[0]->supplier_code;
			$supplier_code   = substr($supplier_code , -10);
			$supplier_code   = 'SP-'.substr('000000000' . strval(floatval($supplier_code) + 1), -10);
		}

		$check_supplier_code = $this->master_model->check_supplier_code($supplier_code);
		if($check_supplier_code != null)
		{
			$msg = "Kode Supplier Tidak Boleh Sama";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$insert = array(
			'supplier_code'	       => $supplier_code,
			'supplier_name'	       => $supplier_name,
			'supplier_phone'	   => $supplier_phone,
			'supplier_address'	   => $supplier_address,
			'supplier_npwp'        => $supplier_npwp
		);

		$this->master_model->save_supplier($insert);
		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function edit_supplier()
	{
		$supplier_id   	   	 = $this->input->post('supplier_id');
		$supplier_name       = $this->input->post('supplier_name');
		$supplier_phone   	 = $this->input->post('supplier_phone');
		$supplier_address    = $this->input->post('supplier_address');
		$supplier_npwp   	 = $this->input->post('supplier_npwp');

		$update = array(
			'supplier_name'	       => $supplier_name,
			'supplier_phone'	   => $supplier_phone,
			'supplier_address'	   => $supplier_address,
			'supplier_npwp'        => $supplier_npwp
		);

		$this->master_model->update_supplier($update, $supplier_id);
		$msg = "Succes Update";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function delete_supplier()
	{

		$supplier_id   	   = $this->input->post('id');
		$this->master_model->delete_supplier($supplier_id);
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	
	// End Supplier //


	// Salesman //

	public function sales()
	{
		$this->check_auth();
		$role  	= $_SESSION['user_role'];
		$modul 	= 'Salesman';
		$check_role = $this->check_role($role, $modul);
		if($check_role[0]->view_ac == 'Y'){
			$sales_list['sales_list'] = $this->master_model->sales_list();
			$check_role['check_role'] = $check_role;
			$data['data'] = array_merge($sales_list, $check_role);
			$this->load->view('Pages/Master/sales', $data);
		}else{
			print_r("No Akses");die();
		}
	}

	public function insert_sales()
	{

		$sales_name       = $this->input->post('sales_name');
		$sales_address    = $this->input->post('sales_address');
		$sales_phone      = $this->input->post('sales_phone');


		if($sales_name == null){
			$msg = "Nama Sales Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$maxCode  	        = $this->master_model->get_max_sales_code();
		if ($maxCode == NULL) {
			$sales_code = 'S-'.'0000000001';
		} else {
			$sales_code   = $maxCode[0]->sales_code;
			$sales_code   = substr($sales_code , -10);
			$sales_code   = 'S-'.substr('000000000' . strval(floatval($sales_code) + 1), -10);
		}

		$insert = array(
			'sales_code'	       => $sales_code,
			'sales_name'	       => $sales_name,
			'sales_address'	   	   => $sales_address,
			'sales_phone'	       => $sales_phone
		);

		$this->master_model->save_sales($insert);
		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function edit_sales()
	{

		$sales_id   	   	 = $this->input->post('sales_id');
		$sales_name          = $this->input->post('sales_name');
		$sales_address       = $this->input->post('sales_address');
		$sales_phone         = $this->input->post('sales_phone');

		if($sales_name == null){
			$msg = "Nama Sales Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$update = array(
			'sales_name'	       => $sales_name,
			'sales_address'	       => $sales_address,
			'sales_phone'	       => $sales_phone
		);

		$this->master_model->update_sales($update, $sales_id);
		$msg = "Succes Update";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function delete_sales()
	{
		$sales_id   	   = $this->input->post('id');
		$this->master_model->delete_sales($sales_id);
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}
	// End Salesman //

	// Customer //

	public function customer()
	{

		$this->check_auth();
		$role  	= $_SESSION['user_role'];
		$modul 	= 'Customer';
		$check_role = $this->check_role($role, $modul);
		if($check_role[0]->view_ac == 'Y'){
			$customer_list['customer_list'] = $this->master_model->customer_list();
			$check_role['check_role'] = $check_role;
			$data['data'] = array_merge($customer_list, $check_role);
			$this->load->view('Pages/Master/customer', $data);
		}else{
			print_r("No Akses");die();
		}
	}

	public function insert_customer()
	{

		$customer_name       = $this->input->post('customer_name');
		$customer_address    = $this->input->post('customer_address');
		$customer_phone      = $this->input->post('customer_phone');
		$customer_ktp 		 = $this->input->post('customer_identity');


		if($customer_name == null){
			$msg = "Nama Customer Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		if($customer_address == null){
			$msg = "Alamat Customer Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		if($customer_phone == null){
			$msg = "No Telepon Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}


		$maxCode  	        = $this->master_model->get_max_cust_code();
		if ($maxCode == NULL) {
			$customer_code = 'C-'.'0000000001';
		} else {
			$customer_code   = $maxCode[0]->customer_code;
			$customer_code   = substr($customer_code , -10);
			$customer_code   = 'C-'.substr('000000000' . strval(floatval($customer_code) + 1), -10);
		}


		$insert = array(
			'customer_code'	       => $customer_code,
			'customer_name'	       => $customer_name,
			'customer_address'	   => $customer_address,
			'customer_phone'	   => $customer_phone,
			'customer_ktp'		   => $customer_ktp
		);

		$this->master_model->save_customer($insert);
		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function edit_customer()
	{

		$customer_id   	   	 = $this->input->post('customer_id');
		$customer_name       = $this->input->post('customer_name');
		$customer_address    = $this->input->post('customer_address');
		$customer_phone      = $this->input->post('customer_phone');
		$customer_ktp 		 = $this->input->post('customer_ktp');

		if($customer_name == null){
			$msg = "Nama Customer Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		if($customer_address == null){
			$msg = "Alamat Customer Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		if($customer_phone == null){
			$msg = "No Telepon Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$update = array(
			'customer_name'	       => $customer_name,
			'customer_address'	   => $customer_address,
			'customer_phone'	   => $customer_phone,
			'customer_ktp' 		   => $customer_ktp
		);

		$this->master_model->update_customer($update, $customer_id);
		$msg = "Succes Update";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();

	}

	public function delete_customer()
	{
		$customer_id   	   = $this->input->post('id');
		$this->master_model->delete_customer($customer_id);
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}
	// End Customer //


	// Product //


	public function product()
	{

		$role  	= $_SESSION['user_role'];
		$modul 	= 'Product';
		$check_role = $this->check_role($role, $modul);
		if($check_role[0]->view_ac == 'Y'){
			$brand_list['brand_list'] = $this->master_model->brand_list();
			$unit_list['unit_list'] = $this->master_model->unit_list();
			$supplier_list['supplier_list'] = $this->master_model->supplier_list();
			$category_list['category_list'] = $this->master_model->category_list();
			$product_list['product_list'] = $this->master_model->product_list();
			$check_role['check_role'] = $check_role;
			$data['data'] = array_merge($brand_list, $unit_list, $supplier_list, $category_list, $product_list, $check_role);
			$this->load->view('Pages/Master/product', $data);
		}else{
			print_r("No Akses");die();
		}
	}

	public function insert_header_product()
	{

		$product_name 		   = $this->input->post('product_name');
		$brand_id              = $this->input->post('brand_id');
		$category_id           = $this->input->post('category_id');
		$supplier_id           = $this->input->post('supplier_id');
		$unit_id               = $this->input->post('unit_id');
		$ppn               	   = $this->input->post('ppn');
		$min_stock             = $this->input->post('min_stock');

		if($product_name == null){
			$msg = "Nama Produk Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}else if($brand_id == null){
			$msg = "Brand Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}else if($category_id == null){
			$msg = "Kategori Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}else if($supplier_id == null){
			$msg = "Supplier Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		} else if($unit_id == null){
			$msg = "Unit Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}else{
			$maxCode = $this->master_model->get_last_prodcut_code();
			if ($maxCode == NULL) {
				$last_code = 'I-'.'0000000001';
			} else {
				$maxCode = $maxCode[0]->product_code;
				$last_code = substr($maxCode, -10);
				$last_code = 'I-'.substr('000000000' . strval(floatval($last_code) + 1), -10);
			}
			if($_FILES['screenshoot']['name'] == null){
				$new_name = 'default.png';
			}else{
				$new_name = md5(time().$product_name).'.png';
				$config['upload_path'] = './assets/products/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|PNG';

				$config['file_name'] = $new_name;
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('screenshoot')) 
				{
					$error = array('error' => $this->upload->display_errors());
				} 
				else
				{
					$data = array('image_metadata' => $this->upload->data());
					echo json_encode(['code'=>'200', 'result'=>$new_name]); 
				}
			}

			$data_insert = array(
				'product_code'	       => $last_code,
				'product_name'		   => $product_name,
				'brand_id'			   => $brand_id, 
				'category_id'          => $category_id,
				'unit_id'              => $unit_id, 
				'ppn'	   			   => $ppn,
				'min_stock'	   	   	   => $min_stock,
				'product_picture'	   => $new_name
			);
			$this->master_model->save_product($data_insert);

			foreach($supplier_id as $row){
				$data_insert_supplier = array(
					'product_code'	       => $last_code,
					'supplier_id'	       => $row,
				);
				$this->master_model->save_product_supplier($data_insert_supplier);
			}

			redirect('Masterdata/product', 'refresh');
		}
	}

	public function insert_variant()
	{
		$product_id 		 = $this->input->post('product_id');
		$item_barcode 	     = '00'.str_pad(mt_rand(1,9999),6,'0',STR_PAD_LEFT);
		$item_name           = $this->input->post('item_name');
		$item_cogs           = str_replace(str_split('.Rp'), '', $this->input->post('item_cogs'));
		$item_cogs2          = str_replace(str_split('.Rp'), '', $this->input->post('item_cogs2')); 
		$item_price_1        = str_replace(str_split('.Rp'), '', $this->input->post('item_price_1'));
		$item_price_2        = str_replace(str_split('.Rp'), '', $this->input->post('item_price_2'));
		$item_price_3        = str_replace(str_split('.Rp'), '', $this->input->post('item_price_3'));

		$id = $product_id;
		$get_product_by_id = $this->master_model->get_product_by_id($id);
		$product_code = $get_product_by_id[0]['product_code'];
		if($item_name == null){
			$msg = "Nama Produk Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}else{
			if($_FILES['screenshoot']['name'] == null){
				$new_name = 'default.png';
			}else{
				$new_name = md5(time().$item_name).'.png';
				$config['upload_path'] = './assets/products/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|PNG';

				$config['file_name'] = $new_name;
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('screenshoot')) 
				{
					$error = array('error' => $this->upload->display_errors());
				} 
				else
				{
					$data = array('image_metadata' => $this->upload->data());
					echo json_encode(['code'=>'200', 'result'=>$new_name]); 
				}
			}

			$data_insert = array(
				'product_code'	       => $product_code,
				'item_barcode'		   => $item_barcode,
				'item_name'			   => $item_name, 
				'item_cogs'            => $item_cogs,
				'item_cogs2'           => $item_cogs2, 
				'item_price_1'	       => $item_price_1,
				'item_price_2'		   => $item_price_2,
				'item_price_3'		   => $item_price_3,
				'item_image'		   => $new_name
				//'item_barcode_image'   => $new_name,
			);
			$this->master_model->save_product_varian($data_insert);
			redirect('Masterdata/product_detail?id='.$product_id, 'refresh');
		}
	}

	public function get_edited_product()
	{
		$id = $this->input->post('id');
		$get_edited_product = $this->master_model->get_edited_product($id);
		echo json_encode(['code'=>200, 'msg'=>$get_edited_product]);die();
	}

	public function get_afkir()
	{
		$id = $this->input->post('id');
		$get_afkir = $this->master_model->get_afkir($id);
		echo json_encode(['code'=>200, 'msg'=>$get_afkir]);die();
	}

	public function get_edited_variant()
	{
		$id = $this->input->post('id');
		$get_edited_variant = $this->master_model->get_edited_variant($id);
		echo json_encode(['code'=>200, 'msg'=>$get_edited_variant]);die();
	}

	public function edit_product_header()
	{

		$product_id 		   = $this->input->post('product_id');
		$product_code 		   = $this->input->post('product_code');
		$product_name 		   = $this->input->post('product_name');
		$brand_id              = $this->input->post('brand_id');
		$category_id           = $this->input->post('category_id');
		$supplier_id           = $this->input->post('supplier_id');
		$unit_id               = $this->input->post('unit_id');
		$ppn               	   = $this->input->post('ppn');
		$min_stock             = $this->input->post('min_stock');

		$check_name = $_FILES["screenshoot2"]['name'];
		if($check_name != null){
			$new_name = md5(time().$product_name).'.png';
			$config['upload_path'] = './assets/products/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|PNG';
			$config['file_name'] = $new_name;
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('screenshoot2')) 
			{
				$error = array('error' => $this->upload->display_errors());
				print_r($error);die();
			} 
			else
			{
				$data = array('image_metadata' => $this->upload->data());
				echo json_encode(['code'=>'200', 'result'=>$new_name]); 
			}
		}

		if($check_name != null){
			$update_data = array(
				'product_name'		   => $product_name,
				'brand_id'			   => $brand_id, 
				'category_id'          => $category_id,
				'unit_id'              => $unit_id, 
				'ppn'	   			   => $ppn,
				'min_stock'	   	   	   => $min_stock,
				'product_picture'	   => $new_name
			);
		}else{
			$update_data = array(
				'product_name'		   => $product_name,
				'brand_id'			   => $brand_id, 
				'category_id'          => $category_id,
				'unit_id'              => $unit_id, 
				'ppn'	   			   => $ppn,
				'min_stock'	   	   	   => $min_stock
			);
		}
		

		$edit_product = $this->master_model->edit_product($update_data, $product_id);


		$delete_product_supplier = $this->master_model->delete_product_supplier($product_code);

		foreach($supplier_id as $row){
			$data_insert_supplier = array(
				'product_code'	       => $product_code,
				'supplier_id'	       => $row,
			);
			$this->master_model->save_product_supplier($data_insert_supplier);
		}

		redirect('Masterdata/product', 'refresh');
	}

	public function product_detail()
	{
		$id = $this->input->get('id');
		$get_product_by_id = $this->master_model->get_product_by_id($id);
		$code = $get_product_by_id[0]['product_code'];
		$get_header_product['get_header_product'] = $this->master_model->get_product_by_id($id);
		$get_detail_product['get_detail_product'] = $this->master_model->get_detail_product($code);
		$data['data'] = array_merge($get_header_product, $get_detail_product);
		$this->load->view('Pages/Master/product_detail', $data);
	}


	public function upload_excell_product()
	{
		$array_file = explode('.', $_FILES['file']['name']);
		$extension  = end($array_file);
		if('csv' == $extension) {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
		} else {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		}
		$spreadsheet = $reader->load($_FILES['file']['tmp_name']);
		$sheet_data  = $spreadsheet->getActiveSheet(0)->toArray();
		$array_data  = [];
		for($i = 1; $i < count($sheet_data); $i++) {
			$data = array(
				'name'       => $sheet_data[$i]['0'],
				'price'      => $sheet_data[$i]['1']
			);
			$array_data[] = $data;
		}
		print_r($array_data);die();
	}

	public function delete_variant()
	{
		$id = $this->input->post('id');
		$this->master_model->delete_variant($id);
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function delete_product()
	{
		$id 	= $this->input->post('id');
		$code 	= $this->input->post('code');
		$check_product_detail = $this->master_model->check_product_detail($code);
		if($check_product_detail >= 1){
			$msg = "Data Tidak Boleh Hapus";
			echo json_encode(['code'=>0, 'result'=>$msg]);
			die();
		}else{
			$this->master_model->delete_variant($id);
			$msg = "Succes Delete";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}
	}

	public function update_afkir()
	{
		$product_id_afkir 		= $this->input->post('product_id_afkir');
		$total_stock_now   	   	= $this->input->post('total_stock_now');
		$total_afkir_now   	   	= $this->input->post('total_afkir_now');
		$new_afkir        		= $this->input->post('new_afkir');
		$userid 				= $_SESSION['user_id'];

		$get_last_afkir = $this->master_model->get_last_afkir($product_id_afkir);

		$last_stock_afkir = $get_last_afkir[0]->item_stock;
		$last_afkir_afkir = $get_last_afkir[0]->item_afkir;

		$new_stock_afkir = $last_stock_afkir - $new_afkir;
		$new_afkir_afkir = $last_afkir_afkir + $new_afkir;

		if($new_stock_afkir < 0){
			$msg = "Stock Tidak Cukup";
			echo json_encode(['code'=>0, 'result'=>$msg]);
			die();
		}

		$update = array(
			'item_stock'	       => $new_stock_afkir,
			'item_afkir'	       => $new_afkir_afkir,
		);

		$this->master_model->update_product_afkir($update, $product_id_afkir);

		$product_id = $product_id_afkir;
		$qty = $new_afkir;
		$last_code = 'Send To Afkir';
		$last_stock = $last_stock_afkir;
		$new_stock = $new_stock_afkir;

		$this->stock_movement_minus_afkir($product_id, $qty, $userid, $last_code, $last_stock, $new_stock);

		$msg = "Succes Update";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}


	// End Product //

	// start product package //

	public function productpacket()
	{

		$this->check_auth();
		$role  	= $_SESSION['user_role'];
		$modul 	= 'ProductPackage';
		$check_role = $this->check_role($role, $modul);
		if($check_role[0]->view_ac == 'Y'){
			$brand_list['brand_list'] = $this->master_model->brand_list();
			$unit_list['unit_list'] = $this->master_model->unit_list();
			$supplier_list['supplier_list'] = $this->master_model->supplier_list();
			$category_list['category_list'] = $this->master_model->category_list();
			$product_list_package['product_list_package'] = $this->master_model->product_list_package();
			$check_role['check_role'] = $check_role;
			$data['data'] = array_merge($brand_list, $unit_list, $supplier_list, $category_list, $product_list_package, $check_role);
			$this->load->view('Pages/Master/product_package', $data);
		}else{
			print_r("No Akses");die();
		}
	}

	public function insert_package()
	{
		$item_barcode 	     = '00'.str_pad(mt_rand(1,9999),6,'0',STR_PAD_LEFT);
		$item_name           = $this->input->post('item_name');
		$item_cogs           = str_replace(str_split('.Rp'), '', $this->input->post('item_cogs'));
		$item_cogs2          = str_replace(str_split('.Rp'), '', $this->input->post('item_cogs2')); 
		$item_price_1        = str_replace(str_split('.Rp'), '', $this->input->post('item_price_1'));
		$item_price_2        = str_replace(str_split('.Rp'), '', $this->input->post('item_price_2'));
		$item_price_3        = str_replace(str_split('.Rp'), '', $this->input->post('item_price_3'));


		$product_code = '';
		if($item_name == null){
			$msg = "Nama Produk Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}else{
			if($_FILES['screenshoot']['name'] == null){
				$new_name = 'default.png';
			}else{
				$new_name = md5(time().$item_name).'.png';
				$config['upload_path'] = './assets/products/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|PNG';

				$config['file_name'] = $new_name;
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('screenshoot')) 
				{
					$error = array('error' => $this->upload->display_errors());
				} 
				else
				{
					$data = array('image_metadata' => $this->upload->data());
					echo json_encode(['code'=>'200', 'result'=>$new_name]); 
				}
			}

			$data_insert = array(
				'product_code'	       => $product_code,
				'item_barcode'		   => $item_barcode,
				'item_name'			   => $item_name, 
				'item_cogs'            => $item_cogs,
				'item_cogs2'           => $item_cogs2, 
				'item_price_1'	       => $item_price_1,
				'item_price_2'		   => $item_price_2,
				'item_price_3'		   => $item_price_3,
				'item_image'		   => $new_name,
				'is_package'	   => 'Y',
				//'item_barcode_image'   => $new_name,
			);
			$this->master_model->save_product_varian($data_insert);
			redirect('Masterdata/productpacket', 'refresh');
		}
	}

	public function get_package_detail()
	{
		$id 	= $this->input->post('id');
		$get_package_detail = $this->master_model->get_package_detail($id);
		echo json_encode($get_package_detail);
	}
	
	public function add_package()
	{
		$master_package_item_id = $this->input->post('master_package_item_id');
		$item_id 				= $this->input->post('item_id');
		$qty_package 			= $this->input->post('qty_package');
		$data_insert = array(
			'item_id'	       	=> $master_package_item_id,
			'item_package_id'	=> $item_id,
			'item_package_qty'	=> $qty_package,
		);
		$this->master_model->save_package_detail($data_insert);
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();	
	}

	public function delete_containt()
	{
		$product_packet_id  = $this->input->post('id');
		$this->master_model->delete_containt($product_packet_id);
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function package_info()
	{
		$id 	= $this->input->post('id');
		$get_package_info = $this->master_model->get_package_info($id);
		echo json_encode($get_package_info);
	}

	public function add_stock_package()
	{
		$item_stock_plus 	= $this->input->post('item_stock_plus');
		$item_stock_id 		= $this->input->post('item_stock_id');
		$item_stock_total   = $this->input->post('item_stock_total');
		$item_stock_now 	= $this->input->post('item_stock_now');
		$userid 			= $_SESSION['user_id'];

		$check_stock_input_package = $this->master_model->check_stock_input_package($item_stock_id);

		if($check_stock_input_package == null){
			$msg = "Data Tidak Di Temukan";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		foreach($check_stock_input_package as $row)
		{
			$item_package_id = $row->item_package_id;
			$item_package_qty = $row->item_package_qty;
			

			$check_stock_ready = $this->master_model->check_stock_ready($item_package_id);
			$sumber_stock = $check_stock_ready[0]->item_stock;
			$nama_stock = $check_stock_ready[0]->item_name;
			if($item_package_qty > $sumber_stock){
				$msg = "Stok ".$nama_stock." Tidak Cukup";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
		}

		foreach($check_stock_input_package as $row)
		{
			$item_package_id = $row->item_package_id;
			$item_package_qty = $row->item_package_qty;

			$check_stock_ready = $this->master_model->check_stock_ready($item_package_id);
			$nama_stock = $check_stock_ready[0]->item_name;
			$sumber_stock = $check_stock_ready[0]->item_stock;
			$butuh_stock = $check_stock_ready[0]->item_package_qty;
			$new_stock = $sumber_stock - $butuh_stock;
			$this->master_model->update_stock_package($item_package_id, $new_stock);

			$product_id = $item_package_id;
			$qty = $butuh_stock;
			
			$last_code = 'Paket'. $nama_stock;
			$last_stock = $sumber_stock;
			$this->stock_movement_minus($product_id, $qty, $userid, $last_code, $last_stock, $new_stock);
		}


		$this->master_model->update_stock_package_item($item_stock_id, $item_stock_total);

		$product_id_pkg = $item_stock_id;
		$qty_pkg  		= $item_stock_plus;
		$invoice_pkg    = 'Tambah Stok Paket';
		$last_stock_pkg = $item_stock_now;
		$new_stock_pkg  = $item_stock_total;


		$this->stock_movement($product_id_pkg, $qty_pkg, $userid, $invoice_pkg, $last_stock_pkg, $new_stock_pkg);

		$msg = "Sukses Tambah Stok";
		echo json_encode(['code'=>200, 'result'=>$msg]);die();
	}

	public function stock_movement($product_id_pkg, $qty_pkg, $userid, $invoice_pkg, $last_stock_pkg, $new_stock_pkg)
	{
		date_default_timezone_set('Asia/Jakarta');
		$cur_date = date('Y-m-d');

		$data_insert = array(
			'stock_movement_product_id'		=> $product_id_pkg,
			'stock_movement_qty'			=> $qty_pkg,
			'stock_movement_before_stock'	=> $last_stock_pkg,
			'stock_movement_new_stock'		=> $new_stock_pkg,
			'stock_movement_desc'       	=> 'Tambah Stock Paket',
			'stock_movement_calculate'		=> 'Plus',
			'stock_movement_date'			=> $cur_date,
			'stock_movement_creted_by'  	=> $userid,
			'stock_movement_inv'			=> $invoice_pkg
		);

		$this->global_model->save_movement_stock($data_insert);
	}

	public function stock_movement_minus($product_id, $qty, $userid, $invoice, $last_stock, $new_stock)
	{
		date_default_timezone_set('Asia/Jakarta');
		$cur_date = date('Y-m-d');

		$data_insert = array(
			'stock_movement_product_id'		=> $product_id,
			'stock_movement_qty'			=> $qty,
			'stock_movement_before_stock'	=> $last_stock,
			'stock_movement_new_stock'		=> $new_stock,
			'stock_movement_desc'       	=> 'Kurang Stok Produk Paket',
			'stock_movement_calculate'		=> 'Minus',
			'stock_movement_date'			=> $cur_date,
			'stock_movement_creted_by'  	=> $userid,
			'stock_movement_inv'			=> $invoice
		);

		$this->global_model->save_movement_stock($data_insert);
	}

	public function stock_movement_minus_afkir($product_id, $qty, $userid, $invoice, $last_stock, $new_stock)
	{
		date_default_timezone_set('Asia/Jakarta');
		$cur_date = date('Y-m-d');

		$data_insert = array(
			'stock_movement_product_id'		=> $product_id,
			'stock_movement_qty'			=> $qty,
			'stock_movement_before_stock'	=> $last_stock,
			'stock_movement_new_stock'		=> $new_stock,
			'stock_movement_desc'       	=> 'Kurang Stok Kirim Ke Afkir',
			'stock_movement_calculate'		=> 'Minus',
			'stock_movement_date'			=> $cur_date,
			'stock_movement_creted_by'  	=> $userid,
			'stock_movement_inv'			=> $invoice
		);

		$this->global_model->save_movement_stock($data_insert);
	}
	// end product package //

	// user //

	public function user()
	{	
		$this->check_auth();
		$role  	= $_SESSION['user_role'];
		$modul 	= 'User';
		$check_role = $this->check_role($role, $modul);
		if($check_role[0]->view_ac == 'Y'){
			$user_list['user_list'] = $this->master_model->user_list();
			$role_list['role_list'] = $this->master_model->role_list();
			$check_role['check_role'] = $check_role;
			$data['data'] = array_merge($user_list, $check_role, $role_list);
			$this->load->view('Pages/Master/user', $data);
		}else{
			print_r("No Akses");die();
		}
	}

	public function insert_user()
	{
		$user_name   	   = $this->input->post('user_name');
		$user_role   	   = $this->input->post('user_role');

		if($user_name == null){
			$msg = "Nama User Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
		$insert = array(
			'user_name'	       => $user_name,
			'user_password'	   => md5('12345'),
			'user_role'		   => $user_role
		);
		$this->master_model->save_user($insert);
		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function edit_user()
	{
		$user_id   	   = $this->input->post('id');
		$user_name     = $this->input->post('user_name_edit');
		$user_role     = $this->input->post('user_role_edit');

		if($user_name == null){
			$msg = "Nama User Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$update = array(
			'user_name'	       => $user_name,
			'user_role'		   => $user_role
		);

		$this->master_model->update_user($update, $user_id);
		$msg = "Succes Update";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function delete_user()
	{

		$user_id  = $this->input->post('id');
		$this->master_model->delete_user($user_id);
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();

	}
	// End Brand //

	// user role //
	public function user_role()
	{		
		$this->check_auth();
		$role  	= $_SESSION['user_role'];
		$modul 	= 'Role';
		$check_role = $this->check_role($role, $modul);
		if($check_role[0]->view_ac == 'Y'){
			$role_list['role_list'] = $this->master_model->role_list();
			$check_role['check_role'] = $check_role;
			$data['data'] = array_merge($role_list, $check_role);
			$this->load->view('Pages/Master/user_role', $data);
		}else{
			print_r("No Akses");die();
		}
	}

	public function insert_role()
	{
		$this->check_auth();
		$role_name   	   = $this->input->post('role_name');

		if($role_name == null){
			$msg = "Nama Role Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
		$insert = array(
			'role_name'	       => $role_name
		);
		$role_id = $this->master_model->save_role($insert);

		$get_modul = $this->master_model->get_modul();
		foreach($get_modul as $row){
			$insert_user_module = array(
				'user_role'	       => $role_id, 
				'module_name'	   => $row->module_name
			);
			$this->master_model->insert_user_module($insert_user_module);
		}


		$get_header_modul = $this->master_model->get_header_modul();
		foreach($get_header_modul as $row){
			$insert_user_header_module = array(
				'user_module_header_role'	   => $role_id, 
				'user_module_header_name'	   => $row->user_module_header_name
			);
			$this->master_model->insert_user_header_module($insert_user_header_module);
		}

		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function edit_role()
	{
		$this->check_auth();
		$role_id   	   = $this->input->post('id');
		$role_name     = $this->input->post('role_name_edit');

		if($role_name == null){
			$msg = "Nama Role Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$update = array(
			'role_name'	       => $role_name
		);

		$this->master_model->update_role($update, $role_id);
		$msg = "Succes Update";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function delete_role()
	{
		$this->check_auth();
		$role_id  = $this->input->post('id');
		$this->master_model->delete_role($role_id);
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();

	}

	public function get_setting_permission()
	{
		$this->check_auth();
		$id = $this->input->post('id');
		$get_setting_permission = $this->master_model->get_setting_permission($id);
		echo json_encode($get_setting_permission);
	}


	public function change_permision()
	{
		$module 	        = $this->input->post('permision');
		$view 				= $this->input->post('view_value');
		$add   				= $this->input->post('add_value');
		$edit 				= $this->input->post('edit_value');
		$delete 			= $this->input->post('delete_value');
		$role_id 			= $this->input->post('role_id');

		if($view == 'true'){
			$view = 'Y';
		}else{
			$view = 'N';
		}

		if($add == 'true'){
			$add = 'Y';
		}else{
			$add = 'N';
		}

		if($edit == 'true'){
			$edit = 'Y';
		}else{
			$edit = 'N';
		}

		if($delete == 'true'){
			$delete = 'Y';
		}else{
			$delete = 'N';
		}

		$data = array(
			'view_ac'	       => $view,
			'add_ac'	       => $add,
			'edit_ac'	       => $edit,
			'delete_ac'	       => $delete,
			'nav_bar'	       => $view
		);
		$this->master_model->update_permission($module, $data, $role_id);

		if($view == 'N' && $add == 'N' && $edit == 'N' && $delete == 'N'){
			$user_module_header_acc = 'N';
		}else{
			$user_module_header_acc = 'Y';
		}

		if($module == 'Brand' || $module == 'Customer' ||$module == 'Category' ||$module == 'Product' ||$module == 'ProductPackage' ||$module == 'Unit' ||$module == 'Salesman' ||$module == 'Supplier' ||$module == 'User' ||$module == 'Role'){
			$user_module_header_name = 'Masterdata';
		}else if($module == 'PO' || $module == 'Purchase'){
			$user_module_header_name = 'Pembelian';
		}else if($module == 'Sales'){
			$user_module_header_name = 'Penjualan';
		}else if($module == 'ReturSales' || $module == 'ReturPurchase'){
			$user_module_header_name = 'Retur';
		}else if($module == 'Piutang' || $module == 'Hutang'){
			$user_module_header_name = 'Pelunasan';
		}else if($module == 'Opname'){
			$user_module_header_name = 'Stockopname';
		}else if($module == 'Report'){
			$user_module_header_name = 'Laporan';
		}

		$data_header_update = array(
			'user_module_header_acc'  => $user_module_header_acc,
		);
		$this->master_model->update_header_permission($user_module_header_name, $data_header_update, $role_id);
		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();

		
	}

	// end user role  //

}

