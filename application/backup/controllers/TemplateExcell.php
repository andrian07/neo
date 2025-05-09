<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
date_default_timezone_set('Asia/Jakarta');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TemplateExcell extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('master_model');
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

	public function download_product_template(){
		$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $excel->getActiveSheet();

		$sheet->setCellValue('A1', "Template Product"); // Set kolom A1 dengan tulisan "DATA SISWA"
    	$sheet->mergeCells('A1:N1'); // Set Merge Cell pada kolom A1 sampai E1
    	$sheet->getStyle('A1')->getFont()->setBold(true);
    	$sheet->getStyle('A3:N3')->getFont()->setBold(true);

    	$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    	$sheet->getStyle('A3:P3')->getAlignment()->setHorizontal('center');

    	// Buat header tabel nya pada baris ke 3
    	$sheet->setCellValue('A3', "Nama Produk Utama"); 
    	$sheet->setCellValue('B3', "Kode Brand"); 
    	$sheet->setCellValue('C3', "Kode Kategori"); 
    	$sheet->setCellValue('D3', "Kode Unit");
    	$sheet->setCellValue('E3', "Kode Supplier");  
    	$sheet->setCellValue('F3', "PPN"); 
    	$sheet->setCellValue('G3', "Min Stock"); 
    	$sheet->setCellValue('H3', "Nama Foto Utama"); 
    	$sheet->setCellValue('I3', "Nama Varian"); 
    	$sheet->setCellValue('J3', "Modal 1"); 
    	$sheet->setCellValue('K3', "Modal 2"); 
    	$sheet->setCellValue('L3', "Harga Toko"); 
    	$sheet->setCellValue('M3', "Harga Cabang"); 
    	$sheet->setCellValue('N3', "Harga IG"); 
    	$sheet->setCellValue('O3', "Foto Varian");
    	$sheet->setCellValue('P3', "Stok Awal"); 


    	$sheet->setCellValue('A4', "Cermin LED 211"); 
    	$sheet->setCellValue('B4', "4"); 
    	$sheet->setCellValue('C4', "5"); 
    	$sheet->setCellValue('D4', "3");
    	$sheet->setCellValue('E4', "10,12"); 
    	$sheet->setCellValue('F4', "Y"); 
    	$sheet->setCellValue('G4', "10"); 
    	$sheet->setCellValue('H4', "image1.png");

    	$sheet->setCellValue('I4', "Cermin LED 211 - (Persegi) 70*50"); 
    	$sheet->setCellValue('J4', "600000"); 
    	$sheet->setCellValue('K4', "700000"); 
    	$sheet->setCellValue('L4', "800000"); 
    	$sheet->setCellValue('M4', "900000"); 
    	$sheet->setCellValue('N4', "1000000"); 
    	$sheet->setCellValue('O4', "image4.png");

    	$sheet->setCellValue('I5', "Cermin LED 211 - (Persegi) 80*60"); 
    	$sheet->setCellValue('J5', "650000"); 
    	$sheet->setCellValue('K5', "750000"); 
    	$sheet->setCellValue('L5', "850000"); 
    	$sheet->setCellValue('M5', "950000"); 
    	$sheet->setCellValue('N5', "1500000"); 
    	$sheet->setCellValue('O5', "Fot1.png");

    	$sheet->setCellValue('A6', "Kasur Busa Imporial Trifold"); 
    	$sheet->setCellValue('B6', "6"); 
    	$sheet->setCellValue('C6', "5"); 
    	$sheet->setCellValue('D6', "4");
    	$sheet->setCellValue('E6', "17,18,20"); 
    	$sheet->setCellValue('F6', "N"); 
    	$sheet->setCellValue('G6', "5"); 
    	$sheet->setCellValue('H6', "Fot2.png");

    	$sheet->setCellValue('I6', "Kasur Busa Imporial Trifold - 90x200"); 
    	$sheet->setCellValue('J6', "200000"); 
    	$sheet->setCellValue('K6', "300000"); 
    	$sheet->setCellValue('L6', "400000"); 
    	$sheet->setCellValue('M6', "500000"); 
    	$sheet->setCellValue('N6', "600000"); 
    	$sheet->setCellValue('O6', "Fot4.png");

    	$sheet->setCellValue('I7', "Kasur Busa Imporial Trifold - 100x200"); 
    	$sheet->setCellValue('J7', "230000"); 
    	$sheet->setCellValue('K7', "330000"); 
    	$sheet->setCellValue('L7', "430000"); 
    	$sheet->setCellValue('M7', "530000"); 
    	$sheet->setCellValue('N7', "6300000"); 
    	$sheet->setCellValue('O7', "Fot6.png"); 


    	$sheet->getColumnDimension('A')->setWidth(25); 
    	$sheet->getColumnDimension('B')->setWidth(25); 
    	$sheet->getColumnDimension('C')->setWidth(25); 
    	$sheet->getColumnDimension('D')->setWidth(25); 
    	$sheet->getColumnDimension('E')->setWidth(25);
    	$sheet->getColumnDimension('F')->setWidth(25);
    	$sheet->getColumnDimension('G')->setWidth(25);
    	$sheet->getColumnDimension('H')->setWidth(35); 
    	$sheet->getColumnDimension('I')->setWidth(35); 
    	$sheet->getColumnDimension('J')->setWidth(25); 
    	$sheet->getColumnDimension('K')->setWidth(25); 
    	$sheet->getColumnDimension('L')->setWidth(25);
    	$sheet->getColumnDimension('M')->setWidth(25);
    	$sheet->getColumnDimension('N')->setWidth(25);
    	$sheet->getColumnDimension('O')->setWidth(35);


    	$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    	$sheet->setTitle("Excell");

    	ob_end_clean();
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename="Template_Produk.xlsx"');
    	header('Cache-Control: max-age=0');

    	$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    	$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
    	exit($xlsxWriter->save('php://output'));
    }

    public function import_brand(){
    	$array_file = explode('.', $_FILES['file_upload']['name']);
    	$extension  = end($array_file);
    	if('csv' == $extension) {
    		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    	} else {
    		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    	}
    	$spreadsheet = $reader->load($_FILES['file_upload']['tmp_name']);
    	$sheet_data  = $spreadsheet->getActiveSheet(0)->toArray();
    	$array_data  = [];

    	for($i = 3; $i < count($sheet_data); $i++) {
    		if($sheet_data[$i]['0'] != null){
    			$brand_name = $sheet_data[$i]['0'];
    			if($sheet_data[$i]['1'] == null){
    				$brand_desc = ' ';
    			}else{
    				$brand_desc = $sheet_data[$i]['1'];
    			}
    			$data_insert = array(
    				'brand_name'	       => $brand_name,
    				'brand_desc'		   => $brand_desc
    			);
    			$this->master_model->save_brand($data_insert);
    		}
    	}

    	redirect('Masterdata/brand', 'refresh');
    }

    public function import_supplier(){
    	$array_file = explode('.', $_FILES['file_upload']['name']);
    	$extension  = end($array_file);
    	if('csv' == $extension) {
    		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    	} else {
    		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    	}
    	$spreadsheet = $reader->load($_FILES['file_upload']['tmp_name']);
    	$sheet_data  = $spreadsheet->getActiveSheet(0)->toArray();
    	$array_data  = [];

    	for($i = 3; $i < count($sheet_data); $i++) {
    		if($sheet_data[$i]['0'] != null){

    			$maxCode  	        = $this->master_model->get_max_sup_code();
    			if ($maxCode == NULL) {
    				$supplier_code = 'SP-'.'0000000001';
    			} else {
    				$supplier_code   = $maxCode[0]->supplier_code;
    				$supplier_code   = substr($supplier_code , -10);
    				$supplier_code   = 'SP-'.substr('000000000' . strval(floatval($supplier_code) + 1), -10);
    			}
    			
    			$supplier_name = $sheet_data[$i]['0'];
    			if($sheet_data[$i]['1'] == null){
    				$supplier_phone = ' ';
    			}else{
    				$supplier_phone = $sheet_data[$i]['1'];
    			}
    			if($sheet_data[$i]['2'] == null){
    				$supplier_address = ' ';
    			}else{
    				$supplier_address = $sheet_data[$i]['2'];
    			}
    			if($sheet_data[$i]['3'] == null){
    				$supplier_npwp = ' ';
    			}else{
    				$supplier_npwp = $sheet_data[$i]['3'];
    			}
    			$data_insert = array(
    				'supplier_code'	       => $supplier_code,
    				'supplier_name'		   => $supplier_name,
    				'supplier_phone'	   => $supplier_phone,
    				'supplier_address'	   => $supplier_address,
    				'supplier_npwp'		   => $supplier_npwp
    			);
    			$this->master_model->save_supplier($data_insert);
    		}
    	}

    	redirect('Masterdata/supplier', 'refresh');
    }

    public function import_category(){
    	$array_file = explode('.', $_FILES['file_upload']['name']);
    	$extension  = end($array_file);
    	if('csv' == $extension) {
    		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    	} else {
    		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    	}
    	$spreadsheet = $reader->load($_FILES['file_upload']['tmp_name']);
    	$sheet_data  = $spreadsheet->getActiveSheet(0)->toArray();
    	$array_data  = [];

    	for($i = 3; $i < count($sheet_data); $i++) {
    		if($sheet_data[$i]['0'] != null){
    			$category_name = $sheet_data[$i]['0'];
    			if($sheet_data[$i]['1'] == null){
    				$category_desc = ' ';
    			}else{
    				$category_desc = $sheet_data[$i]['1'];
    			}
    			$data_insert = array(
    				'category_name'	       => $category_name,
    				'category_desc'		   => $category_desc
    			);
    			$this->master_model->save_category($data_insert);
    		}
    	}

    	redirect('Masterdata/category', 'refresh');
    }    

    public function import_product(){
    	$array_file = explode('.', $_FILES['file_upload']['name']);
    	$extension  = end($array_file);
    	if('csv' == $extension) {
    		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    	} else {
    		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    	}
    	$spreadsheet = $reader->load($_FILES['file_upload']['tmp_name']);
    	$sheet_data  = $spreadsheet->getActiveSheet(0)->toArray();
    	$array_data  = [];


    	for($i = 3; $i < count($sheet_data); $i++) {

    		$j = $i - 1;

    		if($sheet_data[$i]['0'] != null){

    			$maxCode = $this->master_model->get_last_prodcut_code();
    			if ($maxCode == NULL) {
    				$last_code = 'I-'.'0000000001';
    			} else {
    				$maxCode = $maxCode[0]->product_code;
    				$last_code = substr($maxCode, -10);
    				$last_code = 'I-'.substr('000000000' . strval(floatval($last_code) + 1), -10);
    			}

    			if($sheet_data[$i]['7'] == null){
    				$product_picture_header = 'default.png';
    			}else{
    				$product_picture_header = $sheet_data[$i]['7'];
    			}

    			if($sheet_data[$i]['6'] == null){
    				$min_stock  = 0;
    			}else{
    				$min_stock  = $sheet_data[$i]['6'];
    			}

    			if($sheet_data[$i]['5'] == null){
    				$ppn  = 0;
    			}else{
    				$ppn  = $sheet_data[$i]['5'];
    			}
    			

    			$data_insert = array(
    				'product_code'	       => $last_code,
    				'product_name'		   => $sheet_data[$i]['0'],
    				'brand_id'			   => $sheet_data[$i]['1'], 
    				'category_id'          => $sheet_data[$i]['2'],
    				'unit_id'              => $sheet_data[$i]['3'], 
    				'ppn'	   			   => $ppn,
    				'min_stock'	   	   	   => $min_stock,
    				'product_picture'	   => $product_picture_header,
    			);

    			$this->master_model->save_product($data_insert);

    			$supplier_id = $sheet_data[$i]['4'];
    			$supplier_id_array = explode(',', $supplier_id);
    			foreach($supplier_id_array as $rows_sup){
    				$data_insert_supplier = array(
    					'product_code'	       => $last_code,
    					'supplier_id'		   => $rows_sup,
    				);

    				$this->master_model->save_product_supplier($data_insert_supplier);
    			}
    		}

    		$item_barcode 	     = '00'.str_pad(mt_rand(1,9999),6,'0',STR_PAD_LEFT);

    		if($sheet_data[$i]['14'] == null){
    			$product_picture_detail = 'default.png';
    		}else{
    			$product_picture_detail = $sheet_data[$i]['14'];
    		}

    		if($sheet_data[$i]['9'] == null){
    			$item_cogs  = 0;
    		}else{
    			$item_cogs  = $sheet_data[$i]['9'];
    		}

    		if($sheet_data[$i]['10'] == null){
    			$item_cogs2  = 0;
    		}else{
    			$item_cogs2  = $sheet_data[$i]['10'];
    		}

    		if($sheet_data[$i]['11'] == null){
    			$item_price_1  = 0;
    		}else{
    			$item_price_1  = $sheet_data[$i]['11'];
    		}

    		if($sheet_data[$i]['12'] == null){
    			$item_price_2  = 0;
    		}else{
    			$item_price_2  = $sheet_data[$i]['12'];
    		}

    		if($sheet_data[$i]['13'] == null){
    			$item_price_3  = 0;
    		}else{
    			$item_price_3  = $sheet_data[$i]['13'];
    		}

    		if($sheet_data[$i]['15'] == null){
    			$item_stock  = 0;
    		}else{
    			$item_stock  = $sheet_data[$i]['15'];
    		}


    		$data_insert = array(
    			'product_code'	       => $last_code,
    			'item_barcode'		   => $item_barcode,
    			'item_name'			   => $sheet_data[$i]['8'], 
    			'item_cogs'            => $item_cogs,
    			'item_cogs2'           => $item_cogs2, 
    			'item_price_1'	       => $item_price_1,
    			'item_price_2'		   => $item_price_2,
    			'item_price_3'		   => $item_price_3,
    			'item_image'		   => $product_picture_detail,
    			'item_stock'		   => $item_stock
    		);
    		$this->master_model->save_product_varian($data_insert);
    	}

    	redirect('Masterdata/product', 'refresh');

    } 

}

?>