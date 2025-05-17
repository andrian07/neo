<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
//require 'vendor/autoload.php';


class Sales extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('master_model');
		$this->load->model('sales_model');
		$this->load->model('global_model');
		$this->load->helper(array('url', 'html'));
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index(){
		$this->check_auth();
		$role  	= $_SESSION['user_role'];
		$modul 	= 'Sales';
		$check_role = $this->check_role($role, $modul);
		if($check_role[0]->view_ac == 'Y'){
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			if($start_date == null){
				$start_date = date('Y-m-01');
				$end_date = date('Y-m-d');
			}
			$sales_list['sales_list'] = $this->sales_model->sales_list($start_date, $end_date);
			$check_role['check_role'] = $check_role;
			$data['data'] = array_merge($sales_list, $check_role);
			$this->load->view('Pages/Sales/salestransaction', $data);
		}else{
			print_r("No Akses");die();
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

	public function add_sales(){
		$this->check_auth();
		$role  	= $_SESSION['user_role'];
		$modul 	= 'Sales';
		$check_role = $this->check_role($role, $modul);
		if($check_role[0]->add_ac == 'Y'){
			$customer_list['customer_list'] = $this->master_model->customer_list();
			$payment_list['payment_list'] = $this->master_model->payment_list();
			$salesman_list['salesman_list'] = $this->master_model->sales_list();
			$check_role['check_role'] = $check_role;
			$data['data'] = array_merge($customer_list, $payment_list, $salesman_list, $check_role);
			$this->load->view('Pages/Sales/addsales', $data);
		}else{
			print_r("No Akses");die();
		}
	}

	public function save_sales()
	{
		$customer_id     				= $this->input->post('customer_id');
		$no_hp        					= $this->input->post('no_hp');
		$address   	   	   				= $this->input->post('address');
		$ekspedisi   	   	   			= $this->input->post('ekspedisi');
		$payment_id           			= $this->input->post('payment_id');
		$sales_id						= $this->input->post('sales_id');
		$send_date 						= $this->input->post('send_date');
		$type 							= $this->input->post('type');
		$due_date    					= $this->input->post('due_date');
		$sendtype 						= $this->input->post('sendtype');
		$sales_remark 					= $this->input->post('sales_remark');
		$footer_discount_submit 		= $this->input->post('footer_discount_submit');
		$footer_sub_total_submit 		= $this->input->post('footer_sub_total_submit');
		$footer_discount_nota_submit 	= $this->input->post('footer_discount_nota_submit');
		$footer_ongkir_submit 			= $this->input->post('footer_ongkir_submit');
		$footer_total_ppn_submit 		= $this->input->post('footer_total_ppn_submit');
		$footer_total_invoice_submit	= $this->input->post('footer_total_invoice_submit');
		$footer_dp_submit 				= $this->input->post('footer_dp_submit');
		$footer_remaining_debt_submit	= $this->input->post('footer_remaining_debt_submit');
		$userid 						= $_SESSION['user_id'];
		$date 							= date('Y-m-d');

		if($footer_total_invoice_submit < 1){
			$msg = "Silahkan Isi Data Terlebih Dahulu";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$maxCode = $this->sales_model->get_last_sales_code();
		if ($maxCode == NULL) {
			$last_code = 'S-'.$userid.'/'.'0000000001';
		} else {
			$maxCode = $maxCode[0]->hd_sales_invoice;
			$last_code = substr($maxCode, -10);
			$last_code = 'S-'.$userid.'/'.substr('000000000' . strval(floatval($last_code) + 1), -10);
		}

		if($footer_total_ppn_submit > 0){
			$gol = 'Y';
		}else{
			$gol = 'N';
		}

		if($sendtype == 'notsend'){
			$status_send = 'Belum';
		}else{
			$status_send = 'Sudah';
		}

		$data_insert = array(
			'hd_sales_invoice'	    	=> $last_code,
			'hd_sales_date'	    		=> $date,
			'hd_sales_customer'	    	=> $customer_id,
			'hd_sales_address'	    	=> $address,
			'hd_sales_ekspedisi'	    => $ekspedisi,
			'hd_sales_phone'	    	=> $no_hp,
			'hd_sales_payment_type'	    => $payment_id,
			'hd_sales_sales'	       	=> $sales_id,
			'hd_delivery_status'		=> $status_send,
			'hd_sales_send_date'	    => $send_date,
			'hd_sales_due_date'	    	=> $due_date,
			'hd_sales_remark'			=> $sales_remark,
			'hd_sales_subtotal'	       	=> $footer_sub_total_submit,
			'hd_sales_discount'	        => $footer_discount_submit,
			'hd_sales_discount_nota'	=> $footer_discount_nota_submit,
			'hd_sales_ongkir'			=> $footer_ongkir_submit,
			'hd_sales_ppn'	    		=> $footer_total_ppn_submit,
			'hd_sales_total'			=> $footer_total_invoice_submit,
			'hd_sales_dp'	       		=> $footer_dp_submit,
			'hd_sales_remaining_debt'	=> $footer_remaining_debt_submit,
			'hd_sales_user'	        	=> $userid,
		);
		$this->sales_model->save_sales($data_insert);

		$get_temp = $this->sales_model->get_temp_sales($userid);

		foreach($get_temp as $row){
			$data_insert_detail = array(
				'dt_sales_invoice'	    	=> $last_code,
				'dt_sales_product_id'	    => $row->product_id,
				'dt_sales_price'	       	=> $row->product_price,
				'dt_sales_qty'	        	=> $row->sales_qty,
				'dt_sales_subtotal'	    	=> $row->sales_subtotal,
				'dt_sales_discount'	    	=> $row->sales_discount,
				'dt_sales_total'			=> $row->sales_total,
			);
			$this->sales_model->save_sales_detail($data_insert_detail);

			$product_id = $row->product_id;
			$qty 		= $row->sales_qty;

			$get_last_stock = $this->sales_model->get_last_stock($product_id);
			$last_stock  = $get_last_stock[0]->item_stock;
			$new_stock = $last_stock - $qty;
			$this->sales_model->update_stock($product_id, $new_stock);
			$this->stock_movement_minus($product_id, $qty, $userid, $last_code, $last_stock, $new_stock);

			if($new_stock < 0){
				$data_insert_minus = array(
					'report_minus_sales_invoice'	=> $last_code,
					'report_minus_sales_product_id'	=> $product_id,
					'report_minus_sales_before_qty' => $last_stock,
					'report_minus_sales_qty'	    => $qty
				);
				$this->sales_model->insert_report_minus($data_insert_minus);
			}

			$last_stock_not_send  = $get_last_stock[0]->item_not_send;
			$new_stock_not_send = $last_stock_not_send + $qty;
			if($sendtype == 'notsend'){
				$this->sales_model->update_stock_not_send($product_id, $new_stock_not_send);
			}

		}
		
		$this->sales_model->clear_temp_sales($userid);

		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function insert_temp_sales()
	{	

		$item_id_temp   	   		= $this->input->post('item_id');
		$price_temp   	   			= $this->input->post('price_temp');
		$qty_temp              		= $this->input->post('qty_temp');
		$total_price_temp 	   		= $this->input->post('total_price_temp');
		$discount_temp   	   		= $this->input->post('discount_temp');
		$discount_temp_percentage   = $this->input->post('discount_temp_percentage');
		$user_id 			   		= $_SESSION['user_id'];

		if($item_id_temp == null){
			$msg = "Silahkan Isi Produk Terlebih Dahulu";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		if($total_price_temp == null){
			$msg = "Silahkan Isi Data Terlebih Dahulu";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$check_input_temp = $this->sales_model->get_edit_temp($item_id_temp, $user_id);

		if($check_input_temp == null){
			$data_insert = array(
				'product_id'	    		=> $item_id_temp,
				'product_price'	    		=> $price_temp,
				'sales_qty'	       			=> $qty_temp,
				'sales_subtotal'	        => $price_temp * $qty_temp,
				'sales_discount'	    	=> $discount_temp,
				'sales_discount_percentage'	=> $discount_temp_percentage,
				'sales_total'				=> $total_price_temp,
				'user_id'					=> $user_id
			);
			$this->sales_model->save_temp_sales($data_insert);
		}else{
			$data_edit = array(
				'product_id'	    		=> $item_id_temp,
				'product_price'	    		=> $price_temp,
				'sales_qty'	       			=> $qty_temp,
				'sales_subtotal'	        => $price_temp * $qty_temp,
				'sales_discount'	    	=> $discount_temp,
				'sales_discount_percentage'	=> $discount_temp_percentage,
				'sales_total'				=> $total_price_temp,
				'user_id'					=> $user_id
			);
			$this->sales_model->edit_temp_sales($data_edit, $item_id_temp, $user_id);
		}
		
		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function search_product()
	{
		$keyword = $this->input->get('term');
		if($keyword == null){
			$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => 'Silahkan Isi Data Terlebih Dahulu'];
		}else{
			$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
			if (!($keyword == '' || $keyword == NULL)) {
				$find = $this->sales_model->search_product($keyword)->result_array(); 
				$find_result = [];
				foreach ($find as $row) {
					$diplay_text = $row['item_name'];
					$find_result[] = [
						'id'                  => $row['item_id'],
						'value'               => $diplay_text,
						'sales_price'         => $row['item_price_3'],
						'modal_price'         => $row['item_cogs'],
					];
				}
				$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
			}
		}
		echo json_encode($result);
	}

	public function get_customer_info()
	{
		$id  = $this->input->post('id');
		$data = $this->sales_model->get_customer_info($id);
		echo json_encode(['code'=>200, 'data'=>$data]);
		die();
	}

	public function check_pass()
	{
		$password = $this->input->post('password');
		$data = $this->sales_model->check_owner_pass($password);
		if($data == null){
			echo json_encode(['code'=>0, 'data'=>'Password Salah']);die();
		}else{
			echo json_encode(['code'=>200, 'data'=>'Sukses']);die();
		}
	}

	public function get_temp_sales()
	{
		$userid = $_SESSION['user_id'];
		$get_temp_sales = $this->sales_model->get_temp_sales($userid);
		echo json_encode($get_temp_sales);
	}

	public function delete_temp()
	{
		$id  = $this->input->post('id');
		$userid = $_SESSION['user_id'];
		$this->sales_model->delete_temp_sales($id, $userid);
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();

	}

	public function get_total_footer_sales()
	{
		$userid = $_SESSION['user_id'];
		$get_total_footer_sales = $this->sales_model->get_total_footer_sales($userid);
		echo json_encode(['code'=>200, 'result'=>$get_total_footer_sales]);
		die();
	}

	public function get_edit_temp()
	{
		$id  = $this->input->post('id');
		$userid = $_SESSION['user_id'];
		$get_edit_temp = $this->sales_model->get_edit_temp($id, $userid);
		echo json_encode(['code'=>200, 'result'=>$get_edit_temp]);
		die();
	}

	public function clear_temp_sales()
	{
		$userid = $_SESSION['user_id'];
		$this->sales_model->clear_temp_sales($userid);
		echo json_encode(['code'=>200, 'result'=>'Success']);
		die();
	}

	public function stock_movement_minus($product_id, $qty, $user_id, $invoice, $last_stock, $new_stock)
	{
		date_default_timezone_set('Asia/Jakarta');
		$cur_date = date('Y-m-d');

		$data_insert = array(
			'stock_movement_product_id'		=> $product_id,
			'stock_movement_qty'			=> $qty,
			'stock_movement_before_stock'	=> $last_stock,
			'stock_movement_new_stock'		=> $new_stock,
			'stock_movement_desc'       	=> 'Sales',
			'stock_movement_calculate'		=> 'Minus',
			'stock_movement_date'			=> $cur_date,
			'stock_movement_creted_by'  	=> $user_id,
			'stock_movement_inv'			=> $invoice
		);

		$this->global_model->save_movement_stock($data_insert);
	}


	public function stock_movement_plus($product_id, $qty, $user_id, $invoice, $last_stock, $new_stock)
	{
		date_default_timezone_set('Asia/Jakarta');
		$cur_date = date('Y-m-d');

		$data_insert = array(
			'stock_movement_product_id'		=> $product_id,
			'stock_movement_qty'			=> $qty,
			'stock_movement_before_stock'	=> $last_stock,
			'stock_movement_new_stock'		=> $new_stock,
			'stock_movement_desc'       	=> 'Cancel Sales',
			'stock_movement_calculate'		=> 'Plus',
			'stock_movement_date'			=> $cur_date,
			'stock_movement_creted_by'  	=> $user_id,
			'stock_movement_inv'			=> $invoice
		);

		$this->global_model->save_movement_stock($data_insert);
	}

	public function detail_sales()
	{
		$id = $this->input->get('id');
		$get_detail_sales_header['get_detail_sales_header'] = $this->sales_model->get_detail_sales_header($id);
		$get_detail_sales_detail['get_detail_sales_detail'] = $this->sales_model->get_detail_sales_detail($id);
		$data['data'] = array_merge($get_detail_sales_header, $get_detail_sales_detail);
		$this->load->view('Pages/Sales/detailsales', $data);
	}

	public function invoice()
	{
		$id = $this->input->get('id');
		$get_detail_sales_header['get_detail_sales_header'] = $this->sales_model->get_detail_sales_header($id);
		$get_detail_sales_detail['get_detail_sales_detail'] = $this->sales_model->get_detail_sales_detail($id);
		$data['data'] = array_merge($get_detail_sales_header, $get_detail_sales_detail);
		$this->load->view('Pages/Sales/invoice', $data);
	}

	public function invoice_dispatch()
	{
		$id = $this->input->get('id');
		$get_detail_sales_header['get_detail_sales_header'] = $this->sales_model->get_detail_sales_header($id);
		$get_detail_sales_detail['get_detail_sales_detail'] = $this->sales_model->get_detail_sales_detail($id);
		$get_detail_sales_detail_dispatch = $this->sales_model->get_detail_sales_detail($id);
		if($get_detail_sales_header['get_detail_sales_header'][0]->hd_delivery_status == 'Belum'){
			foreach($get_detail_sales_detail_dispatch as $row){
				$product_id = $row->dt_sales_product_id;
				$qty = $row->dt_sales_qty;

				$get_last_stock = $this->sales_model->get_last_stock($product_id);
				$last_stock_not_send  = $get_last_stock[0]->item_not_send;
				$new_stock_not_send = $last_stock_not_send - $qty;
				$this->sales_model->update_stock_not_send($product_id, $new_stock_not_send);
			}
			$this->sales_model->update_delivery_status($id);
		}
		$data['data'] = array_merge($get_detail_sales_header, $get_detail_sales_detail);
		$this->load->view('Pages/Sales/dispatch', $data);
	}

	public function delete_sales()
	{
		$id  = $this->input->post('id');
		$userid = $_SESSION['user_id'];
		$this->sales_model->delete_sales($id);
		$get_detail_sales = $this->sales_model->get_detail_sales($id);

		foreach($get_detail_sales as $row){
			$product_id = $row->dt_sales_product_id;
			$qty = $row->dt_sales_qty;
			$last_code = $row->dt_sales_invoice;
			$get_last_stock = $this->sales_model->get_last_stock($product_id);
			$last_stock  = $get_last_stock[0]->item_stock;
			$new_stock = $last_stock + $qty;
			$this->sales_model->update_stock($product_id, $new_stock);
			$this->stock_movement_plus($product_id, $qty, $userid, $last_code, $last_stock, $new_stock);
		}
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}


}

