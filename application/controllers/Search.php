<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
//require 'vendor/autoload.php';


class Search extends CI_Controller {

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
			$this->load->view('Pages/search');
		}else{
			$this->load->view('Pages/login');
		}
	}


	private function check_auth(){
		if(isset($_SESSION['user_name']) == null){
			redirect('Dashboard', 'refresh');
		}
	}

	public function product_list(){
		$searchin_key = $this->input->post('key');
		$product_list = $this->master_model->search_product_list($searchin_key)->result_array();
		echo json_encode($product_list);
	}

	public function detailsearch(){
		$id = $this->input->get('id');
		$get_product_by_id['get_product_by_id'] = $this->master_model->get_product_by_id_search($id);
		$this->load->view('Pages/detailsearch', $get_product_by_id);
	}

	// Cari //


}

