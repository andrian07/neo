<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
date_default_timezone_set('Asia/Jakarta');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Opname extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('opname_model');
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

	private function check_role($role, $modul){
		$check_role = $this->global_model->check_role($role, $modul);
		return $check_role;
	}

	public function opname_list(){
		$this->check_auth();
		$role  	= $_SESSION['user_role'];
		$modul 	= 'Opname';
		$check_role = $this->check_role($role, $modul);
		if($check_role[0]->view_ac == 'Y'){
			$opname_list['opname_list'] = $this->opname_model->opname_list();
			$check_role['check_role'] = $check_role;
			$data['data'] = array_merge($opname_list, $check_role);
			$this->load->view('Pages/Opname/opname', $data);
		}else{
			print_r("No Akses");die();
		}
	}

	public function add_opname(){
		$this->check_auth();
		$role  	= $_SESSION['user_role'];
		$modul 	= 'Opname';
		$check_role = $this->check_role($role, $modul);
		if($check_role[0]->add_ac == 'Y'){
			$this->load->view('Pages/Opname/addopname');
		}else{
			print_r("No Akses");die();
		}

	}

	public function search_product()
	{
		$keyword = $this->input->get('term');
		if (!($keyword == '' || $keyword == NULL)) {
			$find = $this->opname_model->search_product($keyword); 
			$find_result = [];
			foreach ($find as $row) {
				$diplay_text = $row->item_name;
				$find_result[] = [
					'id'                  => $row->item_id,
					'value'               => $diplay_text,
					'purchase_price'      => $row->item_cogs,
					'stock'				  => $row->item_stock
				];
			}
			$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
		}
		echo json_encode($result);
	}

	public function insert_temp_opname()
	{

		$item_id_temp 		= $this->input->post('item_id_temp');
		$temp_price_temp 	= $this->input->post('temp_price_temp');
		$temp_stock_system 	= $this->input->post('temp_stock_system');
		$temp_stock_fisik 	= $this->input->post('temp_stock_fisik');
		$temp_stock_desc 	= $this->input->post('temp_stock_desc');
		$user_id 			= $_SESSION['user_id'];


		$stock_difference = $temp_stock_fisik - $temp_stock_system;	
		if($temp_stock_fisik > $temp_stock_system){
			$temp_stock_status = 'Plus';
		}else{
			$temp_stock_status = 'Minus';
		}

		$temp_total_price = $temp_price_temp * $stock_difference;


		$check_input_temp = $this->opname_model->get_edit_temp($item_id_temp, $user_id);

		if($check_input_temp == null){
			$data_insert = array(
				'temp_product_id'	    => $item_id_temp,
				'temp_stock_awal'		=> $temp_stock_system,
				'temp_stock_akhir'	    => $temp_stock_fisik,
				'temp_stock_difference'	=> $stock_difference,
				'temp_stock_status'	    => $temp_stock_status,
				'temp_total_price'		=> $temp_total_price,
				'temp_detail_remark'	=> $temp_stock_desc,
				'temp_user_id'			=> $user_id,
			);
			$this->opname_model->insert_temp_opname($data_insert);
		}else{
			$data_edit = array(
				'temp_product_id'	    => $item_id_temp,
				'temp_stock_awal'		=> $temp_stock_system,
				'temp_stock_akhir'	    => $temp_stock_fisik,
				'temp_stock_difference'	=> $stock_difference,
				'temp_stock_status'	    => $temp_stock_status,
				'temp_total_price'		=> $temp_total_price,
				'temp_detail_remark'	=> $temp_stock_desc,
				'temp_user_id'			=> $user_id,
			);
			$this->opname_model->edit_temp_opname($data_edit, $item_id_temp, $user_id);
		}

		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function get_temp_opname()
	{
		$userid = $_SESSION['user_id'];
		$get_temp_opname = $this->opname_model->get_temp_opname($userid);
		echo json_encode($get_temp_opname);
	}

	public function get_edit_temp_opname()
	{
		$id  = $this->input->post('id');
		$userid = $_SESSION['user_id'];
		$get_edit_temp_opname = $this->opname_model->get_edit_temp($id, $userid);
		echo json_encode(['code'=>200, 'result'=>$get_edit_temp_opname]);
		die();
	}

	public function delete_temp_opname()
	{
		$id  = $this->input->post('id');
		$userid = $_SESSION['user_id'];
		$this->opname_model->delete_temp_opname($id, $userid);
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();

	}

	public function get_total_footer_opname()
	{
		$userid = $_SESSION['user_id'];
		$get_total_footer_opname = $this->opname_model->get_total_footer_opname($userid);
		echo json_encode(['code'=>200, 'result'=>$get_total_footer_opname]);
		die();
	}

	public function save_opname()
	{
		$footer_total_selisih  = $this->input->post('footer_total_selisih_val');
		$userid 			   = $_SESSION['user_id'];
		$date 				   = date("Y-m-d") ;

		/*if($footer_total_selisih < 1){
			$msg = "Silahkan Isi Data Terlebih Dahulu";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}*/

		$maxCode = $this->opname_model->get_last_opname_code();
		if ($maxCode == NULL) {
			$last_code = 'O-'.$userid.'/'.'0000000001';
		} else {
			$maxCode = $maxCode[0]->opname_code;
			$last_code = substr($maxCode, -10);
			$last_code = 'O-'.$userid.'/'.substr('000000000' . strval(floatval($last_code) + 1), -10);
		}

		$data_insert = array(
			'opname_code'	    	=> $last_code,
			'hd_opname_date'	    => $date,
			'hd_opname_total_price'	=> $footer_total_selisih,
			'user_id'	      		=> $userid
		);
		$this->opname_model->save_opname($data_insert);

		$get_temp = $this->opname_model->get_temp_opname($userid);

		foreach($get_temp as $row){
			$data_insert_detail = array(
				'opname_code'	    			=> $last_code,
				'dt_opname_product_id'	    	=> $row->temp_product_id,
				'dt_opname_stock_awal'	       	=> $row->temp_stock_awal,
				'dt_opname_stock_akhir'	        => $row->temp_stock_akhir,
				'dt_opname_stock_difference'	=> $row->temp_stock_difference,
				'dt_opname_stock_status'		=> $row->temp_stock_status,
				'dt_opname_total_price'			=> $row->temp_total_price,
				'dt_opname_detail_remark'		=> $row->temp_detail_remark
			);
			$this->opname_model->save_opname_detail($data_insert_detail);

			$product_id = $row->temp_product_id;
			$qty = $row->temp_stock_akhir;
			$new_stock = $row->temp_stock_akhir;
			$last_stock = $row->temp_stock_awal;
			$status = $row->temp_stock_status;
			$this->purchase_model->update_stock($product_id, $new_stock);
			if($status == 'Minus'){
				$this->stock_movement_minus($product_id, $qty, $userid, $last_code, $last_stock, $new_stock);
			}else{
				$this->stock_movement($product_id, $qty, $userid, $last_code, $last_stock, $new_stock);
			}
			
		}
		
		$this->opname_model->clear_temp($userid);

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
			'stock_movement_desc'       	=> 'Opname',
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
			'stock_movement_desc'       	=> 'Opname',
			'stock_movement_calculate'		=> 'Minus',
			'stock_movement_date'			=> $cur_date,
			'stock_movement_creted_by'  	=> $user_id,
			'stock_movement_inv'			=> $invoice
		);

		$this->global_model->save_movement_stock($data_insert);
	}

	public function detail_opname()
	{
		$id = $this->input->get('id');
		$get_detail_opname_header['get_detail_opname_header'] = $this->opname_model->get_detail_opname_header($id);
		$get_detail_opname_detail['get_detail_opname_detail'] = $this->opname_model->get_detail_opname_detail($id);
		$data['data'] = array_merge($get_detail_opname_header, $get_detail_opname_detail);
		$this->load->view('Pages/Opname/detailopname', $data);
	}

}	

?>