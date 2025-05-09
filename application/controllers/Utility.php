<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
date_default_timezone_set('Asia/Jakarta');
require 'vendor/autoload.php';


use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Zend\Barcode\Renderer;


class Utility extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('master_model');
		$this->load->model('report_model');
		$this->load->helper(array('url', 'html', 'barcode'));
	}

	public function index(){
		if(isset($_SESSION['user_name']) != null){
			$this->load->view('Pages/Report/report');
		}else{
			$this->load->view('Pages/login');
		}
	}


	private function check_auth(){
		if(isset($_SESSION['user_name']) == null){
			redirect('Report', 'refresh');
		}
	}

	public function print_catalog()
	{
		$this->check_auth();


		$category_list['category_list'] = $this->master_model->category_list();
		$brand_list['brand_list'] = $this->master_model->brand_list();
		$data['data'] = array_merge($category_list, $brand_list);
		$this->load->view('Pages/Utility/print_catalog', $data);
	}

	public function print_catalog_pdf()
	{	
		$this->check_auth();
		$category_id = $this->input->get('category_id');
		$brand_id = $this->input->get('brand_id');
		if($category_id != null || $brand_id != null){
			$catalog_pdf['catalog_pdf'] = $this->master_model->catalog_pdf($category_id, $brand_id);
			$this->load->view('Pages/Utility/print_catalog_pdf', $catalog_pdf);
		}else{
			echo 'No Data';
		}
		
	}

	public function print_stock()
	{
		$this->check_auth();
		$category_list['category_list'] = $this->master_model->category_list();
		$brand_list['brand_list'] = $this->master_model->brand_list();
		$data['data'] = array_merge($category_list, $brand_list);
		$this->load->view('Pages/Utility/print_stock_card', $data);
	}

	public function print_stock_pdf()
	{
		$this->check_auth();
		$category_id = $this->input->get('category_id');
		$brand_id = $this->input->get('brand_id');
		$stock_card['stock_card'] = $this->report_model->stock_card($category_id, $brand_id);
		$this->load->view('Pages/Utility/print_stock_card', $stock_card);
	}

	public function print_stock_card_pdf()
	{
		$this->check_auth();
		$item_id = $this->input->get('item_id');
		$stock_card_pdf['stock_card_pdf'] = $this->report_model->stock_card_pdf($item_id);
		//print_r($stock_card_pdf);die();
		$this->load->view('Pages/Utility/print_stock_card_pdf', $stock_card_pdf);
	}


	public function generate_barcode($code = 1231231231)
	{	
		$barcodeOptions = array('text' => 'ZEND-FRAMEWORK');

// No required options
		$rendererOptions = array();

// Draw the barcode in a new image,
// send the headers and the image
		Zend_Barcode::factory(
			'code39', 'image', $barcodeOptions, $rendererOptions
		)->render();
	}

	private function set_barcode($code)
	{
		return Zend_Barcode::render('code128', 'image', array('text'=>$code), array());
	}

}

?>