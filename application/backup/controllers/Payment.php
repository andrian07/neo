<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
date_default_timezone_set('Asia/Jakarta');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Payment extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('master_model');
		$this->load->model('payment_model');
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


	// start piutang //
	public function receivables(){
		$this->check_auth();
		$receivables_customer['receivables_customer'] = $this->payment_model->receivables_customer();
		$receivables_history['receivables_history'] = $this->payment_model->receivables_history();
		$data['data'] = array_merge($receivables_customer, $receivables_history);
		$this->load->view('Pages/Payment/receivables', $data);
	}


	public function copy_pay_receivables()
	{
		$this->check_auth();
		$id = $this->input->get('id');
		$userid = $_SESSION['user_id'];
		$this->payment_model->clear_temp_receivables($userid);
		$get_copy_to_temp_receivables = $this->payment_model->get_copy_to_temp_receivables($id);

		foreach($get_copy_to_temp_receivables as $row){
			$data_insert = array(
				'temp_sales_nominal'	    => $row->hd_sales_total,
				'temp_sales_id'	    		=> $row->hd_sales_id,
				'temp_debt_discount'	    => 0,
				'temp_sisa_hutang'	        => $row->hd_sales_remaining_debt,
				'temp_debt_nominal'	    	=> 0,
				'temp_debt_remaining'		=> $row->hd_sales_remaining_debt,
				'temp_user_id'				=> $userid,
			);
			$this->payment_model->save_temp_receivables($data_insert);
		}
		$this->pay_receivables();
	}

	public function pay_receivables(){
		$payment_list['payment_list'] = $this->master_model->payment_list();
		$this->load->view('Pages/Payment/addreceivables', $payment_list);
	}



	public function insert_temp_receivables()
	{
		$temp_sales_nominal = $this->input->post('remaining_receivable');
		$temp_sales_id 		= $this->input->post('sales_admin_id');
		$temp_debt_discount = $this->input->post('repayment_disc_val');
		$temp_sisa_hutang = $this->input->post('remaining_receivable');
		$temp_debt_nominal = $this->input->post('repayment_total_val');
		$temp_debt_remaining = $this->input->post('new_remaining_receivable_val');
		$temp_debt_retur = $this->input->post('sales_admin_retur_nominal_val');
		$userid = $_SESSION['user_id'];

		if($temp_debt_remaining < 0){
			$msg = "Pembayaran Tidak Bisa Minus";
			echo json_encode(['code'=>0, 'result'=>$msg]);
			die();
		}

		$data_insert = array(
			'temp_sales_nominal'	    => $temp_sales_nominal,
			'temp_sales_id'	    		=> $temp_sales_id,
			'temp_debt_discount'	    => $temp_debt_discount,
			'temp_sisa_hutang'	        => $temp_sisa_hutang,
			'temp_debt_nominal'	    	=> $temp_debt_nominal,
			'temp_payment_isedit'		=> 'Y',
			'temp_debt_remaining'		=> $temp_debt_remaining,
			'temp_debt_retur'			=> $temp_debt_retur,
			'temp_user_id'				=> $userid,
		);

		$this->payment_model->edit_temp_receivables($data_insert, $temp_sales_id, $userid);

		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function save_receivables()
	{
		$payment_receivable_customer_id 	= $this->input->post('customer_id');
		$payment_receivable_total_invoice 	= $this->input->post('footer_invoice_total_val');
		$payment_receivable_total_pay 		= $this->input->post('payment_receivable_total_pay');
		$payment_receivable_method_id 		= $this->input->post('payment_receivable_method_id');
		$new_remaining_receivable_val       = $this->input->post('new_remaining_receivable_val');
		$date 				   				= date("Y-m-d") ;
		$userid 							= $_SESSION['user_id'];


		if($payment_receivable_method_id == null){
			$msg = "Silahkan Input Metode Pembayaran";
			echo json_encode(['code'=>0, 'result'=>$msg]);
			die();
		}
		if($payment_receivable_total_invoice == 0){
			$msg = "Silahkan Isi Data Pembyaran";
			echo json_encode(['code'=>0, 'result'=>$msg]);
			die();
		}
		$maxCode = $this->payment_model->get_last_receivables();
		if ($maxCode == NULL) {
			$last_code = 'PP-'.$userid.'/'.'0000000001';
		} else {
			$maxCode = $maxCode[0]->payment_receivable_invoice;
			$last_code = substr($maxCode, -10);
			$last_code = 'PP-'.$userid.'/'.substr('000000000' . strval(floatval($last_code) + 1), -10);
		}

		$data_insert = array(
			'payment_receivable_invoice'	    => $last_code,
			'payment_receivable_customer_id'	=> $payment_receivable_customer_id,
			'payment_receivable_total_invoice'	=> $payment_receivable_total_invoice,
			'payment_receivable_total_pay'	    => $payment_receivable_total_pay,
			'payment_receivable_method_id'	   	=> $payment_receivable_method_id,
			'payment_receivable_date'			=> $date,
			'user_id'							=> $userid
		);

		$get_temp_receivables = $this->payment_model->get_temp_receivables($userid);
		foreach($get_temp_receivables as $row){
			$data_insert_detail = array(
				'payment_receivable_invoice'	    => $last_code,
				'dt_payment_receivable_sales_id'	=> $row->temp_sales_id,
				'dt_payment_receivable_discount'	=> $row->temp_debt_discount,
				'dt_payment_receivable_nominal'	    => $row->temp_debt_nominal,
				'dt_payment_receivable_retur'		=> $row->temp_debt_retur,
				'dt_payment_receivable_remaining'	=> $row->temp_debt_remaining,
			);
			
			if($row->temp_payment_isedit == 'Y'){
				$sales_id = $row->temp_sales_id;
				$remaining_debt = $row->temp_debt_remaining;
				$this->payment_model->insert_detail_receivables($data_insert_detail);
				$update_remaining_sales = $this->payment_model->update_remaining_sales($sales_id, $remaining_debt);
				$update_retur_status = $this->payment_model->update_retur_status($sales_id);
			}
		}

		$this->payment_model->save_receivables($data_insert);
		$this->payment_model->clear_temp_receivables($userid);
		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();

	}


	public function get_header_pay_receivables()
	{
		$id = $this->input->post('customer_id');
		$get_header_pay_receivables = $this->payment_model->get_header_pay_receivables($id);
		echo json_encode(['code'=>200, 'result'=>$get_header_pay_receivables]);
		die();
	}

	public function get_temp_receivables()
	{
		$userid = $_SESSION['user_id'];
		$get_temp_receivables = $this->payment_model->get_temp_receivables($userid);
		echo json_encode($get_temp_receivables);
	}

	public function get_temp_receivables_edit()
	{
		$temp_sales_id = $this->input->post('temp_sales_id');
		$get_temp_receivables_edit = $this->payment_model->get_temp_receivables_edit($temp_sales_id);
		$get_total_retur_sales = $this->payment_model->get_total_retur_sales($temp_sales_id);
		echo json_encode(['code'=>200, 'result'=>$get_temp_receivables_edit, 'total_retur'=>$get_total_retur_sales]);
	}

	public function footer_pay_receivables()
	{
		$userid = $_SESSION['user_id'];
		$get_footer_pay_receivables = $this->payment_model->get_footer_pay_receivables($userid);
		echo json_encode(['code'=>200, 'result'=>$get_footer_pay_receivables]);
		die();
	}

	public function detail_payment_receivables()
	{
		$id = $this->input->get('id');
		$get_detail_payment_receivables_header['get_detail_payment_receivables_header'] = $this->payment_model->get_detail_payment_receivables_header($id);
		$get_detail_payment_receivables_detail['get_detail_payment_receivables_detail'] = $this->payment_model->get_detail_payment_receivables_detail($id);
		$data['data'] = array_merge($get_detail_payment_receivables_header, $get_detail_payment_receivables_detail);
		$this->load->view('Pages/Payment/detailreceivables', $data);
	}

	public function delete_receivables()
	{
		$id  = $this->input->post('id');
		$get_detail_payment_receivables_detail = $this->payment_model->get_detail_payment_receivables_detail($id);
		foreach($get_detail_payment_receivables_detail as $row){
			$sales_id = $row->dt_payment_receivable_sales_id;
			$nominal_pay = $row->dt_payment_receivable_nominal;
			$last_remaining_debt = $row->hd_sales_remaining_debt;
			$retur_nominal = $row->dt_payment_receivable_retur;
			$remaining_debt = $last_remaining_debt + $nominal_pay + $retur_nominal;
			$update_remaining_sales_debt = $this->payment_model->update_remaining_sales($sales_id, $remaining_debt);
		}
		$this->payment_model->delete_payment_receivables($id);
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	// end piutang //

	// start hutang //

	public function debt(){
		$this->check_auth();
		$debt_supplier['debt_supplier'] = $this->payment_model->debt_supplier();
		$debt_history['debt_history'] = $this->payment_model->debt_history();
		$data['data'] = array_merge($debt_supplier, $debt_history);
		$this->load->view('Pages/Payment/debt', $data);
	}

	public function copy_pay_debt()
	{
		$this->check_auth();
		$id = $this->input->get('id');
		$userid = $_SESSION['user_id'];
		$this->payment_model->clear_temp_debt($userid);
		$get_copy_to_temp_debt = $this->payment_model->get_copy_to_temp_debt($id);
		foreach($get_copy_to_temp_debt as $row){
			$data_insert = array(
				'temp_purchase_nominal'	    => $row->hd_purchase_total,
				'temp_purchase_id'	    	=> $row->hd_purchase_id,
				'temp_debt_discount'	    => 0,
				'temp_sisa_hutang'	        => $row->hd_purchase_remaining_debt,
				'temp_debt_nominal'	    	=> 0,
				'temp_debt_remaining'		=> $row->hd_purchase_remaining_debt,
				'temp_user_id'				=> $userid,
			);
			$this->payment_model->save_temp_debt($data_insert);
		}
		$this->pay_debt();
	}

	public function pay_debt(){
		$payment_list['payment_list'] = $this->master_model->payment_list();
		$this->load->view('Pages/Payment/adddebt', $payment_list);
	}

	public function get_temp_debt()
	{
		$userid = $_SESSION['user_id'];
		$get_temp_debt = $this->payment_model->get_temp_debt($userid);
		echo json_encode($get_temp_debt);
	}


	public function get_temp_debt_edit()
	{
		$temp_purchase_id = $this->input->post('temp_purchase_id');
		$get_temp_debt_edit = $this->payment_model->get_temp_debt_edit($temp_purchase_id);
		$get_total_retur_purchase = $this->payment_model->get_total_retur_purchase($temp_purchase_id);
		echo json_encode(['code'=>200, 'result'=>$get_temp_debt_edit, 'total_retur'=>$get_total_retur_purchase]);
	}

	public function get_header_pay_debt()
	{
		$id = $this->input->post('supplier_id');
		$get_header_pay_debt = $this->payment_model->get_header_pay_debt($id);
		echo json_encode(['code'=>200, 'result'=>$get_header_pay_debt]);
		die();
	}


	public function insert_temp_debt()
	{
		$temp_purchase_nominal 	= $this->input->post('remaining_receivable');
		$temp_purchase_id 		= $this->input->post('purchase_id');
		$temp_debt_discount 	= $this->input->post('repayment_disc_val');
		$temp_sisa_hutang 		= $this->input->post('remaining_debt');
		$temp_debt_nominal 		= $this->input->post('repayment_total_val');
		$temp_debt_remaining 	= $this->input->post('new_remaining_debt_val');
		$temp_debt_retur 		= $this->input->post('purchase_retur_nominal_val');
		$userid 				= $_SESSION['user_id'];

		if($temp_debt_remaining < 0){
			$msg = "Pembayaran Tidak Bisa Minus";
			echo json_encode(['code'=>0, 'result'=>$msg]);
			die();
		}

		$data_insert = array(
			'temp_purchase_nominal'	    => $temp_purchase_nominal,
			'temp_purchase_id'	    	=> $temp_purchase_id,
			'temp_debt_discount'	    => $temp_debt_discount,
			'temp_sisa_hutang'	        => $temp_sisa_hutang,
			'temp_debt_nominal'	    	=> $temp_debt_nominal,
			'temp_payment_isedit'		=> 'Y',
			'temp_debt_remaining'		=> $temp_debt_remaining,
			'temp_debt_retur'			=> $temp_debt_retur,
			'temp_user_id'				=> $userid,
		);

		$this->payment_model->edit_temp_debt($data_insert, $temp_purchase_id, $userid);

		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function footer_pay_debt()
	{
		$userid = $_SESSION['user_id'];
		$get_footer_pay_debt = $this->payment_model->get_footer_pay_debt($userid);
		echo json_encode(['code'=>200, 'result'=>$get_footer_pay_debt]);
		die();
	}

	public function save_debt()
	{
		$payment_debt_supplier_id 			= $this->input->post('supplier_id');
		$payment_debt_total_invoice 		= $this->input->post('footer_invoice_total_val');
		$payment_debt_total_pay 			= $this->input->post('payment_debt_total_pay');
		$payment_debt_method_id 			= $this->input->post('payment_debt_method_id');
		$new_debt_receivable_val       		= $this->input->post('new_debt_receivable_val');
		$date 				   				= date("Y-m-d") ;
		$userid 							= $_SESSION['user_id'];


		if($payment_debt_method_id == null){
			$msg = "Silahkan Input Metode Pembayaran";
			echo json_encode(['code'=>0, 'result'=>$msg]);
			die();
		}
		if($payment_debt_total_invoice == 0){
			$msg = "Silahkan Isi Data Pembyaran";
			echo json_encode(['code'=>0, 'result'=>$msg]);
			die();
		}
		$maxCode = $this->payment_model->get_last_debt();
		if ($maxCode == NULL) {
			$last_code = 'PH-'.$userid.'/'.'0000000001';
		} else {
			$maxCode = $maxCode[0]->payment_debt_invoice;
			$last_code = substr($maxCode, -10);
			$last_code = 'PH-'.$userid.'/'.substr('000000000' . strval(floatval($last_code) + 1), -10);
		}

		$data_insert = array(
			'payment_debt_invoice'	    	=> $last_code,
			'payment_debt_supplier_id'		=> $payment_debt_supplier_id,
			'payment_debt_total_invoice'	=> $payment_debt_total_invoice,
			'payment_debt_total_pay'	    => $payment_debt_total_pay,
			'payment_debt_method_id'	   	=> $payment_debt_method_id,
			'payment_debt_date'				=> $date,
			'user_id'						=> $userid
		);

		$get_temp_debt = $this->payment_model->get_temp_debt($userid);
		foreach($get_temp_debt as $row){
			$data_insert_detail = array(
				'payment_debt_invoice'	    	=> $last_code,
				'dt_payment_debt_purchase_id'	=> $row->temp_purchase_id,
				'dt_payment_debt_discount'		=> $row->temp_debt_discount,
				'dt_payment_debt_nominal'	    => $row->temp_debt_nominal,
				'dt_payment_debt_retur'			=> $row->temp_debt_retur,
				'dt_payment_debt_remaining'		=> $row->temp_debt_remaining,
			);
			
			if($row->temp_payment_isedit == 'Y'){
				$purchase_id = $row->temp_purchase_id;
				$remaining_debt = $row->temp_debt_remaining;
				$this->payment_model->insert_detail_debt($data_insert_detail);
				$update_remaining_purchase = $this->payment_model->update_remaining_purchase($purchase_id, $remaining_debt);
				$update_retur_status = $this->payment_model->update_retur_status_debt($purchase_id);
			}
		}

		$this->payment_model->save_debt($data_insert);
		$this->payment_model->clear_temp_debt($userid);
		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();

	}


	public function detail_payment_debt()
	{
		$id = $this->input->get('id');
		$get_detail_payment_debt_header['get_detail_payment_debt_header'] = $this->payment_model->get_detail_payment_debt_header($id);
		$get_detail_payment_debt_detail['get_detail_payment_debt_detail'] = $this->payment_model->get_detail_payment_debt_detail($id);
		$data['data'] = array_merge($get_detail_payment_debt_header, $get_detail_payment_debt_detail);
		$this->load->view('Pages/Payment/detaildebt', $data);
	}

	public function delete_debt()
	{
		$id  = $this->input->post('id');
		$get_detail_payment_debt_detail = $this->payment_model->get_detail_payment_debt_detail($id);
		foreach($get_detail_payment_debt_detail as $row){
			$purchase_id = $row->dt_payment_debt_purchase_id;
			$nominal_pay = $row->dt_payment_debt_nominal;
			$last_remaining_debt = $row->hd_purchase_remaining_debt;
			$retur_nominal = $row->dt_payment_debt_retur;
			$remaining_debt = $last_remaining_debt + $nominal_pay + $retur_nominal;
			$update_remaining_purchase_debt = $this->payment_model->update_remaining_purchase($purchase_id, $remaining_debt);
		}
		$this->payment_model->delete_payment_debt($id);
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}
	// end hutang //


}	

?>