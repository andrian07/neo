<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
date_default_timezone_set('Asia/Jakarta');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Purchase extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('master_model');
		$this->load->model('purchase_model');
		$this->load->model('global_model');
		$this->load->helper(array('url', 'html'));
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

	// start po //
	public function po(){
		$this->check_auth();
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		if($start_date == null){
			$start_date = date('Y-m-01');
			$end_date = date('Y-m-d');
		}
		$po_list['po_list'] = $this->purchase_model->po_list($start_date, $end_date);
		$this->load->view('Pages/Purchase/po', $po_list);
	}

	public function purchase_view(){
		$this->load->view('purchase');
	}

	public function add_po(){
		$this->check_auth();
		$supplier_list['supplier_list'] = $this->master_model->supplier_list();
		//$product_list['product_list'] = $this->master_model->product_list();
		//$data['data'] = array_merge($supplier_list, $product_list);
		$this->load->view('Pages/Purchase/addpo', $supplier_list);
	}

	public function search_product_supplier()
	{
		$supplier_id = $this->input->get('sup');
		$keyword = $this->input->get('term');
		if($supplier_id == null){
			$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => 'Silahkan Pilih Supplier Terlebih Dahulu'];
		}else{
			$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
			if (!($keyword == '' || $keyword == NULL)) {
				$find = $this->purchase_model->search_product_supplier($keyword, $supplier_id); 
				$find_result = [];
				foreach ($find as $row) {
					$diplay_text = $row->item_name;
					$find_result[] = [
						'id'                  => $row->item_id,
						'value'               => $diplay_text,
						'purchase_price'      => $row->item_cogs,
					];
				}
				$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
			}
		}
		echo json_encode($result);
	}

	public function insert_temp_po()
	{	

		$item_id_temp   	   = $this->input->post('item_id_temp');
		$temp_price_temp       = $this->input->post('temp_price_temp');
		$qty_temp   	   	   = $this->input->post('qty_temp');
		$total_price_temp      = $this->input->post('total_price_temp');
		$supplier_id 		   = $this->input->post('supplier_id');
		$user_id 			   = $_SESSION['user_id'];

		if($item_id_temp == null){
			$msg = "Silahkan Isi Produk Terlebih Dahulu";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		if($total_price_temp == null){
			$msg = "Silahkan Isi Data Terlebih Dahulu";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$check_input_temp = $this->purchase_model->get_edit_temp($item_id_temp, $user_id);

		if($check_input_temp == null){
			$data_insert = array(
				'product_id'	    => $item_id_temp,
				'product_price'	    => $temp_price_temp,
				'po_qty'	       	=> $qty_temp,
				'po_total'	        => $total_price_temp,
				'supplier_id'	    => $supplier_id,
				'user_id'	      	=> $user_id,
			);
			$this->purchase_model->save_temp_po($data_insert);
		}else{
			$data_edit = array(
				'product_price'	    => $temp_price_temp,
				'po_qty'	       	=> $qty_temp,
				'po_total'	        => $total_price_temp,
				'supplier_id'	    => $supplier_id,
				'user_id'	      	=> $user_id,
			);
			$this->purchase_model->edit_temp_po($data_edit, $item_id_temp, $user_id);
		}
		
		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function get_temp_po()
	{
		$userid = $_SESSION['user_id'];
		$get_temp_po = $this->purchase_model->get_temp_po($userid);
		echo json_encode($get_temp_po);
	}

	public function get_total_footer_po()
	{
		$userid = $_SESSION['user_id'];
		$get_total_footer_po = $this->purchase_model->get_total_footer_po($userid);
		echo json_encode(['code'=>200, 'result'=>$get_total_footer_po]);
		die();
	}

	public function delete_temp_po()
	{
		$id  = $this->input->post('id');
		$userid = $_SESSION['user_id'];
		$this->purchase_model->delete_temp_po($id, $userid);
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();

	}

	public function delete_po()
	{
		$id  = $this->input->post('id');
		$this->purchase_model->delete_po($id);
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function delete_purchase()
	{
		$id  = $this->input->post('id');
		$userid = $_SESSION['user_id'];
		$this->purchase_model->delete_purchase($id);
		$get_detail_purchase = $this->purchase_model->get_detail_purchase($id);

		foreach($get_detail_purchase as $row){
			$product_id = $row->dt_purchase_product_id;
			$qty = $row->dt_purchase_qty;
			$last_code = $row->dt_purchase_invoice;
			$get_last_stock = $this->purchase_model->get_last_stock($product_id);
			$last_stock  = $get_last_stock[0]->item_stock;
			$new_stock = $last_stock - $qty;
			$this->purchase_model->update_stock($product_id, $new_stock);
			$this->stock_movement_minus($product_id, $qty, $userid, $last_code, $last_stock, $new_stock);
		}
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function get_edit_temp()
	{
		$id  = $this->input->post('id');
		$userid = $_SESSION['user_id'];
		$get_edit_temp = $this->purchase_model->get_edit_temp($id, $userid);
		echo json_encode(['code'=>200, 'result'=>$get_edit_temp]);
		die();
	}

	public function copy_to_temp()
	{
		$id 	= $this->input->post('id');
		$userid = $_SESSION['user_id'];
		$this->purchase_model->clear_temp($userid);
		$get_copy_to_temp = $this->purchase_model->get_copy_to_temp($id);
		if($get_copy_to_temp[0]->hd_po_status != 'pending'){
			echo json_encode(['code'=>0, 'result'=>'Transaksi Selain Pending Tidak Bisa Di Edit']);
			die();
		}
		foreach($get_copy_to_temp as $row){
			$data_insert = array(
				'product_id'	    => $row->dt_po_product_id,
				'product_price'	    => $row->dt_po_price,
				'po_qty'	       	=> $row->dt_po_qty,
				'po_total'	        => $row->dt_po_total,
				'supplier_id'	    => $row->hd_po_supplier_id,
				'user_id'	      	=> $userid,
			);
			$this->purchase_model->save_temp_po($data_insert);
		}
		echo json_encode(['code'=>200, 'result'=>'Success']);
		die();
	}


	public function save_po()
	{
		$hd_po_supplier_id     = $this->input->post('supplier_id');
		$hd_po_subtotal        = $this->input->post('footer_sub_total_submit');
		$hd_po_ppn   	   	   = $this->input->post('footer_total_ppn_submit');
		$hd_po_total           = $this->input->post('footer_total_invoice_submit');
		$userid 			   = $_SESSION['user_id'];
		$date 				   = date("Y-m-d") ;

		if($hd_po_total < 1){
			$msg = "Silahkan Isi Data Terlebih Dahulu";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$maxCode = $this->purchase_model->get_last_po_code();
		if ($maxCode == NULL) {
			$last_code = 'PO-'.$userid.'/'.'0000000001';
		} else {
			$maxCode = $maxCode[0]->hd_po_invoice;
			$last_code = substr($maxCode, -10);
			$last_code = 'PO-'.$userid.'/'.substr('000000000' . strval(floatval($last_code) + 1), -10);
		}

		if($hd_po_ppn > 0){
			$gol = 'Y';
		}else{
			$gol = 'N';
		}

		$data_insert = array(
			'hd_po_invoice'	    	=> $last_code,
			'hd_po_supplier_id'	    => $hd_po_supplier_id,
			'hd_po_date'	       	=> $date,
			'hd_po_gol'	        	=> $gol,
			'hd_po_subtotal'	    => $hd_po_subtotal,
			'hd_po_ppn'	      		=> $hd_po_ppn,
			'hd_po_total'	       	=> $hd_po_total,
			'hd_po_user'	        => $userid,
		);
		$this->purchase_model->save_po($data_insert);

		$get_temp = $this->purchase_model->get_temp_po($userid);

		foreach($get_temp as $row){
			$data_insert_detail = array(
				'dt_po_invoice'	    	=> $last_code,
				'dt_po_product_id'	    => $row->product_id,
				'dt_po_price'	       	=> $row->product_price,
				'dt_po_qty'	        	=> $row->po_qty,
				'dt_po_total'	    	=> $row->po_total
			);
			$this->purchase_model->save_po_detail($data_insert_detail);
		}
		
		$this->purchase_model->clear_temp($userid);

		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function clear_temp_po()
	{
		$userid = $_SESSION['user_id'];
		$this->purchase_model->clear_temp($userid);
		echo json_encode(['code'=>200, 'result'=>'Success']);
		die();
	}

	public function detail_po()
	{
		$id = $this->input->get('id');
		$get_detail_po_header['get_detail_po_header'] = $this->purchase_model->get_detail_po_header($id);
		$get_detail_po_detail['get_detail_po_detail'] = $this->purchase_model->get_detail_po_detail($id);
		$data['data'] = array_merge($get_detail_po_header, $get_detail_po_detail);
		$this->load->view('Pages/Purchase/detailpo', $data);
	}
	// End po //

	// start purchase //
	public function purchase(){
		$this->check_auth();
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		if($start_date == null){
			$start_date = date('Y-m-01');
			$end_date = date('Y-m-d');
		}
		$purchase_list['purchase_list'] = $this->purchase_model->purchase_list($start_date, $end_date);
		$this->load->view('Pages/Purchase/purchase', $purchase_list);
	}

	public function add_purchase(){
		$this->check_auth();
		$po_list_pending['po_list_pending'] = $this->purchase_model->po_list_pending();
		$supplier_list['supplier_list'] = $this->master_model->supplier_list();
		//$product_list['product_list'] = $this->master_model->product_list();
		$payment_list['payment_list'] = $this->master_model->payment_list();
		$data['data'] = array_merge($supplier_list, $po_list_pending, $payment_list);
		$this->load->view('Pages/Purchase/addpurchase', $data);
	}

	public function copy_po_to_temp()
	{
		$id 	= $this->input->post('id');
		$userid = $_SESSION['user_id'];
		$this->purchase_model->clear_temp_purchase($userid);
		$get_copy_to_temp = $this->purchase_model->get_copy_to_temp($id);
		//$supplier_id = $get_copy_to_temp[0]->hd_po_supplier_id;
		foreach($get_copy_to_temp as $row){
			$data_insert = array(
				'po_id'						    => $id,
				'po_name'						=> $row->hd_po_invoice,
				'product_id'	    			=> $row->dt_po_product_id,
				'product_price'	    			=> $row->dt_po_price,
				'purchase_qty'	       			=> $row->dt_po_qty,
				'purchase_subtotal'	        	=> $row->dt_po_total,
				'purchase_discount'	    		=> 0,
				'purchase_discount_percentage'	=> 0,
				'purchase_total'	    		=> $row->dt_po_total,
				'supplier_id'	       			=> $row->hd_po_supplier_id,
				'user_id'	        			=> $userid
			);
			$this->purchase_model->save_temp_purchase($data_insert);
		}
		echo json_encode(['code'=>200, 'result'=>'Success']);
		die();
	}

	public function get_temp_purchase()
	{
		$userid = $_SESSION['user_id'];
		$get_temp_po = $this->purchase_model->get_temp_purchase($userid);
		echo json_encode($get_temp_po);
	}

	public function search_po()
	{
		$keyword = $this->input->get('term');
		if($keyword == null){
			$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => 'Silahkan Pilih Supplier Terlebih Dahulu'];
		}else{
			$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
			if (!($keyword == '' || $keyword == NULL)) {
				$find = $this->purchase_model->search_po($keyword); 
				$find_result = [];
				foreach ($find as $row) {
					$diplay_text = $row->hd_po_invoice;
					$find_result[] = [
						'id'                  => $row->hd_po_id,
						'value'               => $diplay_text
					];
				}
				$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
			}
		}
		echo json_encode($result);
	}

	public function clear_temp_purchase()
	{
		$userid = $_SESSION['user_id'];
		$this->purchase_model->clear_temp_purchase($userid);
		echo json_encode(['code'=>200, 'result'=>'Success']);
		die();
	}

	public function get_edit_temp_purchase()
	{
		$id  = $this->input->post('id');
		$userid = $_SESSION['user_id'];
		$get_edit_temp_purchase = $this->purchase_model->get_edit_temp_purchase($id, $userid);
		echo json_encode(['code'=>200, 'result'=>$get_edit_temp_purchase]);
		die();
	}

	public function insert_temp_purchase()
	{	

		$item_id_temp   	   		= $this->input->post('item_id_temp');
		$temp_price_temp       		= $this->input->post('temp_price_temp');
		$qty_temp   	   	   		= $this->input->post('qty_temp');
		$total_price_temp      		= $this->input->post('total_price_temp');
		$supplier_id 		   		= $this->input->post('supplier_id');
		$temp_discount 		   		= $this->input->post('discount_temp');
		$temp_discount_percentage	= $this->input->post('discount_temp_percentage');
		$po_id						= $this->input->post('po_id');
		$po_name					= $this->input->post('po_name');
		$user_id 			   		= $_SESSION['user_id'];

		if($item_id_temp == null){
			$msg = "Silahkan Isi Produk Terlebih Dahulu";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		if($total_price_temp == null){
			$msg = "Silahkan Isi Data Terlebih Dahulu";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$check_input_temp = $this->purchase_model->get_edit_temp_purchase($item_id_temp, $user_id);

		if($check_input_temp == null){
			$data_insert = array(
				'po_id'							=> $po_id,
				'po_name'						=> $po_name,
				'product_id'	    			=> $item_id_temp,
				'product_price'	    			=> $temp_price_temp,
				'purchase_qty'	       			=> $qty_temp,
				'purchase_subtotal'				=> $temp_price_temp * $qty_temp,
				'purchase_discount'				=> $temp_discount,
				'purchase_discount_percentage'	=> $temp_discount_percentage,
				'purchase_total'	        	=> $total_price_temp,
				'supplier_id'	    			=> $supplier_id,
				'user_id'	      				=> $user_id,
			);
			$this->purchase_model->save_temp_purchase($data_insert);
		}else{
			$data_edit = array(
				'po_id'							=> $po_id,
				'po_name'						=> $po_name,
				'product_id'	    			=> $item_id_temp,
				'product_price'	    			=> $temp_price_temp,
				'purchase_qty'	       			=> $qty_temp,
				'purchase_subtotal'				=> $temp_price_temp * $qty_temp,
				'purchase_discount'				=> $temp_discount,
				'purchase_discount_percentage'	=> $temp_discount_percentage,
				'purchase_total'	        	=> $total_price_temp,
				'supplier_id'	    			=> $supplier_id,
				'user_id'	      				=> $user_id,
			);
			$this->purchase_model->edit_temp_purchase($data_edit, $item_id_temp, $user_id);
		}
		
		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function delete_temp_purchase()
	{
		$id  = $this->input->post('id');
		$userid = $_SESSION['user_id'];
		$this->purchase_model->delete_temp_purchase($id, $userid);
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();

	}

	public function get_total_footer_purchase()
	{
		$userid = $_SESSION['user_id'];
		$get_total_footer_purchase = $this->purchase_model->get_total_footer_purchase($userid);
		echo json_encode(['code'=>200, 'result'=>$get_total_footer_purchase]);
		die();
	}

	public function save_purchase()
	{
		$po_id     						= $this->input->post('po_id');
		$supplier_id        			= $this->input->post('supplier_id');
		$payment_id   	   	   			= $this->input->post('payment_id');
		$due_date           			= $this->input->post('due_date');
		$footer_discount_submit			= $this->input->post('footer_discount_submit');
		$footer_sub_total_submit 		= $this->input->post('footer_sub_total_submit');
		$footer_total_ppn_submit 		= $this->input->post('footer_total_ppn_submit');
		$footer_total_invoice_submit    = $this->input->post('footer_total_invoice_submit');
		$footer_dp_submit 				= $this->input->post('footer_dp_submit');
		$footer_remaining_debt_submit 	= $this->input->post('footer_remaining_debt_submit');
		$date 				   			= date("Y-m-d") ;
		$userid 						= $_SESSION['user_id'];

		if($footer_total_invoice_submit < 1){
			$msg = "Silahkan Isi Data Terlebih Dahulu";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$maxCode = $this->purchase_model->get_last_purchase_code();
		if ($maxCode == NULL) {
			$last_code = 'PR-'.$userid.'/'.'0000000001';
		} else {
			$maxCode = $maxCode[0]->hd_purchase_invoice;
			$last_code = substr($maxCode, -10);
			$last_code = 'PR-'.$userid.'/'.substr('000000000' . strval(floatval($last_code) + 1), -10);
		}

		if($footer_total_ppn_submit > 0){
			$gol = 'Y';
		}else{
			$gol = 'N';
		}

		$data_insert = array(
			'hd_purchase_invoice'	    	=> $last_code,
			'hd_purchase_po'	    		=> $po_id,
			'hd_purchase_supplier_id'	    => $supplier_id,
			'hd_purchase_date'	    		=> $date,
			'hd_purchase_payment_type'	    => $payment_id,
			'hd_purchase_due_date'	       	=> $due_date,
			'hd_purchase_gol'	       		=> $gol,
			'hd_purchase_subtotal'	    	=> $footer_sub_total_submit,
			'hd_purchase_discount'	    	=> $footer_discount_submit,
			'hd_purchase_ppn'	       		=> $footer_total_ppn_submit,
			'hd_purchase_total'	        	=> $footer_total_invoice_submit,
			'hd_purchase_dp'	    		=> $footer_dp_submit,
			'hd_purchase_remaining_debt'	=> $footer_remaining_debt_submit,
			'hd_purchase_user'	       		=> $userid,
		);
		$this->purchase_model->save_purchase($data_insert);

		$get_temp = $this->purchase_model->get_temp_purchase($userid);

		foreach($get_temp as $row){
			$data_insert_detail = array(
				'dt_purchase_invoice'	    	=> $last_code,
				'dt_purchase_product_id'	    => $row->product_id,
				'dt_purchase_price'	       		=> $row->product_price,
				'dt_purchase_qty'	        	=> $row->purchase_qty,
				'dt_purchase_discount'	    	=> $row->purchase_discount,
				'dt_purchase_total'	    		=> $row->purchase_total,
			);
			$this->purchase_model->save_purchase_detail($data_insert_detail);

			$product_id = $row->product_id;
			$qty = $row->purchase_qty;

			$get_last_stock = $this->purchase_model->get_last_stock($product_id);
			$last_stock  = $get_last_stock[0]->item_stock;
			$new_stock = $last_stock + $qty;
			$this->purchase_model->update_stock($product_id, $new_stock);
			$this->stock_movement($product_id, $qty, $userid, $last_code, $last_stock, $new_stock);
		}
		
		$this->purchase_model->clear_temp_purchase($userid);

		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function stock_movement($product_id, $qty, $user_id, $invoice, $last_stock, $new_stock)
	{
		date_default_timezone_set('Asia/Jakarta');
		$cur_date = date('Y-m-d');

		$data_insert = array(
			'stock_movement_product_id'		=> $product_id,
			'stock_movement_qty'			=> $qty,
			'stock_movement_before_stock'	=> $last_stock,
			'stock_movement_new_stock'		=> $new_stock,
			'stock_movement_desc'       	=> 'Purchase',
			'stock_movement_calculate'		=> 'Plus',
			'stock_movement_date'			=> $cur_date,
			'stock_movement_creted_by'  	=> $user_id,
			'stock_movement_inv'			=> $invoice
		);

		$this->global_model->save_movement_stock($data_insert);
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
			'stock_movement_desc'       	=> 'Cancel Purchase',
			'stock_movement_calculate'		=> 'Minus',
			'stock_movement_date'			=> $cur_date,
			'stock_movement_creted_by'  	=> $user_id,
			'stock_movement_inv'			=> $invoice
		);

		$this->global_model->save_movement_stock($data_insert);
	}

	public function detail_purchase()
	{
		$id = $this->input->get('id');
		$get_detail_purchase_header['get_detail_purchase_header'] = $this->purchase_model->get_detail_purchase_header($id);
		$get_detail_purchase_detail['get_detail_purchase_detail'] = $this->purchase_model->get_detail_purchase_detail($id);
		$data['data'] = array_merge($get_detail_purchase_header, $get_detail_purchase_detail);
		$this->load->view('Pages/Purchase/detailpurchase', $data);
	}


	// end pruchase //

}	

?>