<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
//require 'vendor/autoload.php';


class Retur extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('master_model');
		$this->load->model('retur_model');
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

	public function returpurchase(){
		$this->check_auth();
		$role  	= $_SESSION['user_role'];
		$modul 	= 'ReturPurchase';
		$check_role = $this->check_role($role, $modul);
		if($check_role[0]->view_ac == 'Y'){
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			if($start_date == null){
				$start_date = date('Y-m-01');
				$end_date = date('Y-m-d');
			}
			$retur_purchase_list['retur_purchase_list'] = $this->retur_model->retur_purchase_list($start_date, $end_date);
			$check_role['check_role'] = $check_role;
			$data['data'] = array_merge($retur_purchase_list, $check_role);
			$this->load->view('Pages/Retur/returpurchase', $data);
		}else{
			print_r("No Akses");die();
		}
	}


	public function addreturpurchase(){
		$this->check_auth();
		$role  	= $_SESSION['user_role'];
		$modul 	= 'ReturPurchase';
		$check_role = $this->check_role($role, $modul);
		if($check_role[0]->add_ac == 'Y'){
			$supplier_list['supplier_list'] = $this->master_model->supplier_list();
			$check_role['check_role'] = $check_role;
			$data['data'] = array_merge($supplier_list, $check_role);
			$this->load->view('Pages/Retur/addreturpurchase', $data);
		}else{
			print_r("No Akses");die();
		}
	}

	public function search_purchase_invoice_supplier()
	{
		$supplier_id = $this->input->get('sup');
		$keyword = $this->input->get('term');
		if($supplier_id == null){
			$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => 'Silahkan Pilih Supplier Terlebih Dahulu'];
		}else{
			$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
			if (!($keyword == '' || $keyword == NULL)) {
				$find = $this->retur_model->search_purchase_invoice_supplier($keyword, $supplier_id); 
				$find_result = [];
				foreach ($find as $row) {
					$diplay_text = $row->hd_purchase_invoice;
					$find_result[] = [
						'id'                  => $row->hd_purchase_id,
						'value'               => $diplay_text
					];
				}
				$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
			}
		}
		echo json_encode($result);
	}

	public function search_product_purchase_no()
	{
		$purchase_no = $this->input->get('purchase_no');
		$keyword = $this->input->get('term');
		if($purchase_no == null){
			$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => 'Silahkan Pilih No Pembelian'];
		}else{
			$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
			if (!($keyword == '' || $keyword == NULL)) {
				$find = $this->retur_model->search_product_purchase_no($keyword, $purchase_no); 
				$find_result = [];
				foreach ($find as $row) {
					$diplay_text = $row->item_name;
					$find_result[] = [
						'id'                  => $row->item_id,
						'value'               => $diplay_text,
						'purchase_price'      => $row->dt_purchase_total,
						'purchase_qty'		  => $row->dt_purchase_qty
					];
				}
				$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
			}
		}
		echo json_encode($result);
	}

	public function insert_temp_retur_purchase()
	{

		$supplier_id 		= $this->input->post('supplier_id');
		$retur_purchase_inv = $this->input->post('retur_purchase_inv');
		$purchase_no   	   	= $this->input->post('purchase_no');
		$item_id_temp       = $this->input->post('item_id_temp');
		$temp_price_temp   	= $this->input->post('temp_price_temp');
		$qty_temp      		= $this->input->post('qty_temp');
		$temp_qty_retur		= $this->input->post('temp_qty_retur');
		$user_id 			= $_SESSION['user_id'];


		if($temp_qty_retur >  $qty_temp){
			$msg = "Tidak Bisa Retur Melebihi Trx";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$check_retur_item = $this->retur_model->check_retur_item_purchase($item_id_temp, $purchase_no);
		$total_retur_count = $check_retur_item[0]->total_retur_qty + $temp_qty_retur;
		if($total_retur_count > $qty_temp){
			$msg = "Tidak Bisa Retur Melebihi Trx";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$check_temp_retur_purchase_qty = $this->retur_model->check_temp_retur_purchase_qty($purchase_no, $item_id_temp);
		if($check_temp_retur_purchase_qty != null){
			$total_qty_retur = $check_temp_retur_purchase_qty[0]->total_qty_retur;
			$total_qty_retur_cal = $total_qty_retur + $qty_temp;
			if($temp_qty_retur >  $total_qty_retur_cal){
				$msg = "Tidak Bisa Retur Melebihi Trx";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
		}

		$check_input_temp = $this->retur_model->get_edit_retur_pruchase_temp($item_id_temp, $user_id);

		if($check_input_temp == null){
			$data_insert = array(
				'retur_purchase_no'	    => $purchase_no,
				'retur_purchase_inv'	=> $retur_purchase_inv,
				'retur_supplier_id'	    => $supplier_id,
				'retur_product_id'	    => $item_id_temp,
				'retur_price'	        => $temp_price_temp,
				'retur_qty_beli'		=> $qty_temp,
				'retur_qty'	    		=> $temp_qty_retur,
				'retur_total'	      	=> $temp_qty_retur * $temp_price_temp,
				'retur_user_id'			=> $user_id
			);
			$this->retur_model->save_temp_retur_purchase($data_insert);
		}else{
			$data_edit = array(
				'retur_purchase_no'	    => $purchase_no,
				'retur_purchase_inv'	=> $retur_purchase_inv,
				'retur_supplier_id'	    => $supplier_id,
				'retur_product_id'	    => $item_id_temp,
				'retur_price'	        => $temp_price_temp,
				'retur_qty_beli'		=> $qty_temp,
				'retur_qty'	    		=> $temp_qty_retur,
				'retur_total'	      	=> $temp_qty_retur * $temp_price_temp,
				'retur_user_id'			=> $user_id
			);
			$this->retur_model->edit_temp_retur_purchase($data_edit, $item_id_temp, $user_id);
		}
		
		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function get_temp_retur_purchase()
	{
		$userid = $_SESSION['user_id'];
		$get_temp_retur_purchase = $this->retur_model->get_temp_retur_purchase($userid);
		echo json_encode($get_temp_retur_purchase);
	}

	public function delete_temp_retur_purchase()
	{
		$id  = $this->input->post('id');
		$userid = $_SESSION['user_id'];
		$this->retur_model->delete_temp_retur_purchase($id, $userid);
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function get_edit_temp_retur_purchase()
	{
		$id  = $this->input->post('id');
		$userid = $_SESSION['user_id'];
		$get_edit_retur_pruchase_temp = $this->retur_model->get_edit_retur_pruchase_temp($id, $userid);
		echo json_encode(['code'=>200, 'result'=>$get_edit_retur_pruchase_temp]);
		die();
	}

	public function get_total_footer_retur_purchase()
	{
		$userid = $_SESSION['user_id'];
		$get_total_footer_retur_purchase = $this->retur_model->get_total_footer_retur_purchase($userid);
		echo json_encode(['code'=>200, 'result'=>$get_total_footer_retur_purchase]);
		die();
	}

	public function save_retur_purchase()
	{
		$supplier_id        			= $this->input->post('supplier_id');
		$payment_type   	   	   		= $this->input->post('payment_type');
		$total_retur_inv           		= $this->input->post('total_retur_inv');
		$date 				   			= date("Y-m-d") ;
		$userid 						= $_SESSION['user_id'];



		if($total_retur_inv < 1){
			$msg = "Silahkan Isi Data Terlebih Dahulu";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$maxCode = $this->retur_model->get_last_retur_purchase_code();
		if ($maxCode == NULL) {
			$last_code = 'RP-'.$userid.'/'.'0000000001';
		} else {
			$maxCode = $maxCode[0]->hd_retur_purchase_invoice;
			$last_code = substr($maxCode, -10);
			$last_code = 'RP-'.$userid.'/'.substr('000000000' . strval(floatval($last_code) + 1), -10);
		}

		$get_temp = $this->retur_model->get_temp_retur_purchase($userid);

		$purchase_no = $get_temp[0]->retur_purchase_no;

		$data_insert = array(
			'hd_retur_purchase_invoice'	=> $last_code,
			'hd_purchase_no'			=> $purchase_no,
			'hd_retur_date'	    		=> $date,
			'hd_retur_supplier_id'	    => $supplier_id,
			'hd_retur_total_transaction'=> $total_retur_inv,
			'hd_retur_payment'	    	=> $payment_type,
			'created_by'	    		=> $userid,
		);
		$this->retur_model->save_retur_purchase($data_insert);

		

		foreach($get_temp as $row){
			$data_insert_detail = array(
				'dt_retur_purchase_invoice'	    	=> $last_code,
				'dt_retur_supplier_id'	    		=> $row->retur_supplier_id,
				'dt_retur_item_id'	       			=> $row->retur_product_id,
				'dt_retur_price'	        		=> $row->retur_price,
				'dt_retur_qty'	    				=> $row->retur_qty,
				'dt_retur_total'	    			=> $row->retur_total,
			);
			$this->retur_model->save_retur_purchase_detail($data_insert_detail);

			$product_id = $row->retur_product_id;
			$qty = $row->retur_qty;

			$get_last_stock = $this->retur_model->get_last_stock($product_id);
			$last_stock  = $get_last_stock[0]->item_stock;
			$new_stock = $last_stock - $qty;
			$desc = 'Retur Pembelian';
			$this->retur_model->update_stock($product_id, $new_stock);
			$this->stock_movement_plus($product_id, $qty, $userid, $last_code, $last_stock, $new_stock, $desc);
		}

		if($payment_type == 'Ya'){
			$remaining_debt_purchase = $this->retur_model->remaining_debt_purchase($purchase_no);
			$remaining_debt = $remaining_debt_purchase[0]->hd_purchase_remaining_debt;
			if($total_retur_inv >= $remaining_debt){
				$this->retur_model->update_remaining_debt_purchase($purchase_no);
			}
		}
		
		
		//$update_nominal_retur = $this->retur_model->update_nominal_retur($userid);

		$this->retur_model->clear_temp_retur_purchase($userid);

		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}


	public function detail_retur_purchase()
	{
		$this->check_auth();
		$role  	= $_SESSION['user_role'];
		$modul 	= 'ReturPurchase';
		$check_role = $this->check_role($role, $modul);
		if($check_role[0]->view_ac == 'Y'){
			$id = $this->input->get('id');
			$get_detail_retur_purchase_header['get_detail_retur_purchase_header'] = $this->retur_model->get_detail_retur_purchase_header($id);
			$get_detail_retur_purchase_detail['get_detail_retur_purchase_detail'] = $this->retur_model->get_detail_retur_purchase_detail($id);
			$check_role['check_role'] = $check_role;
			$data['data'] = array_merge($get_detail_retur_purchase_header, $get_detail_retur_purchase_detail, $check_role);
			$this->load->view('Pages/Retur/detailreturpurchase', $data);
		}else{
			print_r("No Akses");die();
		}
	}

	public function delete_retur_purchase()
	{
		$id  = $this->input->post('id');
		$userid = $_SESSION['user_id'];
		$this->retur_model->delete_retur_purchase($id);
		$get_detail_retur_purchase = $this->retur_model->get_detail_retur_purchase($id);

		foreach($get_detail_retur_purchase as $row){
			
			$product_id = $row->dt_retur_item_id;
			$qty = $row->dt_retur_qty;
			$last_code = $row->dt_retur_purchase_invoice;

			$get_last_stock = $this->retur_model->get_last_stock($product_id);
			$last_stock  = $get_last_stock[0]->item_stock;
			$new_stock = $last_stock + $qty;
			$desc = 'Cancel Retur Pembelian';
			$this->retur_model->update_stock($product_id, $new_stock);
			$this->stock_movement_minus($product_id, $qty, $userid, $last_code, $last_stock, $new_stock, $desc);
		}
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function clear_temp_retur_purchase()
	{
		$userid = $_SESSION['user_id'];
		$this->retur_model->clear_temp_retur_purchase($userid);
		echo json_encode(['code'=>200, 'result'=>'Success']);
		die();
	}

	// end retur purchase



	public function retursales(){

		$this->check_auth();
		$role  	= $_SESSION['user_role'];
		$modul 	= 'ReturSales';
		$check_role = $this->check_role($role, $modul);
		if($check_role[0]->view_ac == 'Y'){
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			if($start_date == null){
				$start_date = date('Y-m-01');
				$end_date = date('Y-m-d');
			}
			$retur_sales_list['retur_sales_list'] = $this->retur_model->retur_sales_list($start_date, $end_date);
			$check_role['check_role'] = $check_role;
			$data['data'] = array_merge($retur_sales_list, $check_role);
			$this->load->view('Pages/Retur/retursales', $data);
		}else{
			print_r("No Akses");die();
		}
	}



	public function addretursales(){

		$this->check_auth();
		$role  	= $_SESSION['user_role'];
		$modul 	= 'ReturSales';
		$check_role = $this->check_role($role, $modul);
		if($check_role[0]->add_ac == 'Y'){
			$customer_list['customer_list'] = $this->master_model->customer_list();
			$check_role['check_role'] = $check_role;
			$data['data'] = array_merge($customer_list, $check_role);
			$this->load->view('Pages/Retur/addretursales', $data);
		}else{
			print_r("No Akses");die();
		}
	}

	public function search_sales_invoice_customer()
	{
		$customer_id = $this->input->get('cust');
		$keyword = $this->input->get('term');
		if($customer_id == null){
			$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => 'Silahkan Pilih customer Terlebih Dahulu'];
		}else{
			$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
			if (!($keyword == '' || $keyword == NULL)) {
				$find = $this->retur_model->search_sales_invoice_customer($keyword, $customer_id); 
				$find_result = [];
				foreach ($find as $row) {
					$diplay_text = $row->hd_sales_invoice;
					$find_result[] = [
						'id'                  => $row->hd_sales_id,
						'value'               => $diplay_text
					];
				}
				$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
			}
		}
		echo json_encode($result);
	}


	public function search_product_sales_no()
	{
		$sales_no = $this->input->get('sales_no');
		$keyword = $this->input->get('term');
		if($sales_no == null){
			$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => 'Silahkan Pilih No Penjualan'];
		}else{
			$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
			if (!($keyword == '' || $keyword == NULL)) {
				$find = $this->retur_model->search_product_sales_no($keyword, $sales_no); 
				$find_result = [];
				foreach ($find as $row) {
					$diplay_text = $row->item_name;
					$find_result[] = [
						'id'                  => $row->item_id,
						'value'               => $diplay_text,
						'sales_price'      	  => $row->dt_sales_total,
						'sales_qty'		      => $row->dt_sales_qty
					];
				}
				$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
			}
		}
		echo json_encode($result);
	}

	public function insert_temp_retur_sales()
	{


		$customer_id 		= $this->input->post('customer_id');
		$retur_sales_inv 	= $this->input->post('retur_sales_inv');
		$sales_no   	   	= $this->input->post('sales_no');
		$item_id_temp       = $this->input->post('item_id_temp');
		$temp_price_temp   	= $this->input->post('temp_price_temp');
		$qty_temp      		= $this->input->post('qty_temp');
		$temp_qty_retur		= $this->input->post('temp_qty_retur');
		$user_id 			= $_SESSION['user_id'];


		if($temp_qty_retur >  $qty_temp){
			$msg = "Tidak Bisa Retur Melebihi Trx";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$check_retur_item = $this->retur_model->check_retur_item_sales($item_id_temp, $sales_no);
		$total_retur_count = $check_retur_item[0]->total_retur_qty + $temp_qty_retur;
		if($total_retur_count > $qty_temp){
			$msg = "Tidak Bisa Retur Melebihi Trx";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$check_input_temp = $this->retur_model->get_edit_retur_sales_temp($item_id_temp, $user_id);

		if($check_input_temp == null){
			$data_insert = array(
				'retur_sales_no'	    => $sales_no,
				'retur_sales_invoice'	=> $retur_sales_inv,
				'retur_customer_id'	    => $customer_id,
				'retur_product_id'	    => $item_id_temp,
				'retur_price'	        => $temp_price_temp,
				'retur_qty_jual'		=> $qty_temp,
				'retur_qty'	    		=> $temp_qty_retur,
				'retur_total'	      	=> $temp_qty_retur * $temp_price_temp,
				'retur_user_id'			=> $user_id
			);
			$this->retur_model->save_temp_retur_sales($data_insert);
		}else{
			$data_edit = array(
				'retur_sales_no'	    => $sales_no,
				'retur_sales_invoice'	=> $retur_sales_inv,
				'retur_customer_id'	    => $customer_id,
				'retur_product_id'	    => $item_id_temp,
				'retur_price'	        => $temp_price_temp,
				'retur_qty_jual'		=> $qty_temp,
				'retur_qty'	    		=> $temp_qty_retur,
				'retur_total'	      	=> $temp_qty_retur * $temp_price_temp,
				'retur_user_id'			=> $user_id
			);
			$this->retur_model->edit_temp_retur_sales($data_edit, $item_id_temp, $user_id);
		}
		
		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function get_temp_retur_sales()
	{
		$userid = $_SESSION['user_id'];
		$get_temp_retur_sales = $this->retur_model->get_temp_retur_sales($userid);
		echo json_encode($get_temp_retur_sales);
	}

	public function get_total_footer_retur_sales()
	{
		$userid = $_SESSION['user_id'];
		$get_total_footer_retur_sales = $this->retur_model->get_total_footer_retur_sales($userid);
		echo json_encode(['code'=>200, 'result'=>$get_total_footer_retur_sales]);
		die();
	}

	public function get_edit_temp_retur_sales()
	{
		$id  = $this->input->post('id');
		$userid = $_SESSION['user_id'];
		$get_edit_retur_sales_temp = $this->retur_model->get_edit_retur_sales_temp($id, $userid);
		echo json_encode(['code'=>200, 'result'=>$get_edit_retur_sales_temp]);
		die();
	}

	public function delete_temp_retur_sales()
	{
		$id  = $this->input->post('id');
		$userid = $_SESSION['user_id'];
		$this->retur_model->delete_temp_retur_sales($id, $userid);
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function save_retur_sales()
	{
		$customer_id        			= $this->input->post('customer_id');
		$payment_type   	   	   		= $this->input->post('payment_type');
		$total_retur_inv           		= $this->input->post('total_retur_inv');
		$date 				   			= date("Y-m-d") ;
		$userid 						= $_SESSION['user_id'];

		if($total_retur_inv < 1){
			$msg = "Silahkan Isi Data Terlebih Dahulu";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$maxCode = $this->retur_model->get_last_retur_sales_code();
		if ($maxCode == NULL) {
			$last_code = 'RS-'.$userid.'/'.'0000000001';
		} else {
			$maxCode = $maxCode[0]->hd_retur_sales_invoice;
			$last_code = substr($maxCode, -10);
			$last_code = 'RS-'.$userid.'/'.substr('000000000' . strval(floatval($last_code) + 1), -10);
		}

		$get_temp = $this->retur_model->get_temp_retur_sales($userid);

		$sales_no = $get_temp[0]->retur_sales_no;

		$data_insert = array(
			'hd_retur_sales_invoice'	=> $last_code,
			'hd_sales_no'				=> $sales_no,
			'hd_retur_date'	    		=> $date,
			'hd_retur_customer_id'	    => $customer_id,
			'hd_retur_total_transaction'=> $total_retur_inv,
			'hd_retur_payment'	    	=> $payment_type,
			'created_by'	    		=> $userid,
		);
		$this->retur_model->save_retur_sales($data_insert);


		foreach($get_temp as $row){
			$data_insert_detail = array(
				'dt_retur_sales_invoice'	    	=> $last_code,
				'dt_retur_customer_id'	    		=> $row->retur_customer_id,
				'dt_retur_item_id'	       			=> $row->retur_product_id,
				'dt_retur_price'	        		=> $row->retur_price,
				'dt_retur_qty'	    				=> $row->retur_qty,
				'dt_retur_total'	    			=> $row->retur_total,
			);
			$this->retur_model->save_retur_sales_detail($data_insert_detail);

			$product_id = $row->retur_product_id;
			$qty = $row->retur_qty;

			$get_last_stock = $this->retur_model->get_last_stock($product_id);
			$last_stock  = $get_last_stock[0]->item_stock;
			$new_stock = $last_stock - $qty;
			$desc = 'Retur Penjualan';
			$this->retur_model->update_stock($product_id, $new_stock);
			$this->stock_movement_plus($product_id, $qty, $userid, $last_code, $last_stock, $new_stock, $desc);
		}

		if($payment_type == 'Ya'){
			$remaining_debt_sales = $this->retur_model->remaining_debt_sales($sales_no);
			$remaining_debt = $remaining_debt_sales[0]->hd_sales_remaining_debt;
			if($total_retur_inv >= $remaining_debt){
				$this->retur_model->update_remaining_debt_sales($sales_no);
			}
		}
		
		$this->retur_model->clear_temp_retur_sales($userid);

		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function clear_temp_retur_sales()
	{
		$userid = $_SESSION['user_id'];
		$this->retur_model->clear_temp_retur_sales($userid);
		echo json_encode(['code'=>200, 'result'=>'Success']);
		die();
	}

	public function detail_retur_sales()
	{
		$this->check_auth();
		$role  	= $_SESSION['user_role'];
		$modul 	= 'ReturSales';
		$check_role = $this->check_role($role, $modul);
		if($check_role[0]->view_ac == 'Y'){
			$id = $this->input->get('id');
			$get_detail_retur_sales_header['get_detail_retur_sales_header'] = $this->retur_model->get_detail_retur_sales_header($id);
			$get_detail_retur_sales_detail['get_detail_retur_sales_detail'] = $this->retur_model->get_detail_retur_sales_detail($id);
			$check_role['check_role'] = $check_role;
			$data['data'] = array_merge($get_detail_retur_sales_header, $get_detail_retur_sales_detail, $check_role);
			$this->load->view('Pages/Retur/detailretursales', $data);
		}else{
			print_r("No Akses");die();
		}
	}

	public function delete_retur_sales()
	{
		$id  = $this->input->post('id');
		$userid = $_SESSION['user_id'];
		$this->retur_model->delete_retur_sales($id);
		$get_detail_retur_sales = $this->retur_model->get_detail_retur_sales($id);

		foreach($get_detail_retur_sales as $row){
			
			$product_id = $row->dt_retur_item_id;
			$qty = $row->dt_retur_qty;
			$last_code = $row->dt_retur_sales_invoice;

			$get_last_stock = $this->retur_model->get_last_stock($product_id);
			$last_stock  = $get_last_stock[0]->item_stock;
			$new_stock = $last_stock - $qty;
			$desc = 'Cancel Retur Penjualan';
			$this->retur_model->update_stock($product_id, $new_stock);
			$this->stock_movement_minus($product_id, $qty, $userid, $last_code, $last_stock, $new_stock, $desc);
		}
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	// end retur sales

	public function stock_movement_plus($product_id, $qty, $user_id, $invoice, $last_stock, $new_stock, $desc)
	{
		date_default_timezone_set('Asia/Jakarta');
		$cur_date = date('Y-m-d');

		$data_insert = array(
			'stock_movement_product_id'		=> $product_id,
			'stock_movement_qty'			=> $qty,
			'stock_movement_before_stock'	=> $last_stock,
			'stock_movement_new_stock'		=> $new_stock,
			'stock_movement_desc'       	=> $desc,
			'stock_movement_calculate'		=> 'Plus',
			'stock_movement_date'			=> $cur_date,
			'stock_movement_creted_by'  	=> $user_id,
			'stock_movement_inv'			=> $invoice
		);

		$this->global_model->save_movement_stock($data_insert);
	}


	public function stock_movement_minus($product_id, $qty, $user_id, $invoice, $last_stock, $new_stock, $desc)
	{
		date_default_timezone_set('Asia/Jakarta');
		$cur_date = date('Y-m-d');

		$data_insert = array(
			'stock_movement_product_id'		=> $product_id,
			'stock_movement_qty'			=> $qty,
			'stock_movement_before_stock'	=> $last_stock,
			'stock_movement_new_stock'		=> $new_stock,
			'stock_movement_desc'       	=> $desc,
			'stock_movement_calculate'		=> 'Minus',
			'stock_movement_date'			=> $cur_date,
			'stock_movement_creted_by'  	=> $user_id,
			'stock_movement_inv'			=> $invoice
		);

		$this->global_model->save_movement_stock($data_insert);
	}

}

