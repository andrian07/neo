<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
date_default_timezone_set('Asia/Jakarta');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Report extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('master_model');
		$this->load->helper(array('url', 'html'));
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

	public function brand()
	{
		$this->check_auth();
		$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    	$sheet = $excel->getActiveSheet();

		$sheet->setCellValue('A1', "List Brand"); // Set kolom A1 dengan tulisan "DATA SISWA"
    	$sheet->mergeCells('A1:C1'); // Set Merge Cell pada kolom A1 sampai E1
    	$sheet->getStyle('A1')->getFont()->setBold(true);
    	$sheet->getStyle('A3:C3')->getFont()->setBold(true);

    	$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    	$sheet->getStyle('A3:C3')->getAlignment()->setHorizontal('center');

    	// Buat header tabel nya pada baris ke 3
    	$sheet->setCellValue('A3', "Kode Brand"); 
    	$sheet->setCellValue('B3', "Nama Brand"); 
    	$sheet->setCellValue('C3', "Keterangan Brand"); 


    	$get_brand = $this->master_model->brand_list();
    	$i = 4;
    	foreach($get_brand as $row){
    		$sheet->setCellValue('A'.$i, $row->brand_id); 
    		$sheet->setCellValue('B'.$i, $row->brand_name); 
    		$sheet->setCellValue('C'.$i, $row->brand_desc);
    		$i++;
    	}

    	$sheet->getColumnDimension('A')->setWidth(25); 
    	$sheet->getColumnDimension('B')->setWidth(35); 
    	$sheet->getColumnDimension('C')->setWidth(55);

	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    //$sheet->getDefaultRowDimension()->setRowHeight(-1);
	    // Set orientasi kertas jadi LANDSCAPE


    	$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
	    // Set judul file excel nya
    	$sheet->setTitle("Excell");

    	ob_end_clean();
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename="brand_' .date('Y-m-d') . '.xlsx"');
    	header('Cache-Control: max-age=0');

    	$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    	$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
    	exit($xlsxWriter->save('php://output'));
	}

	public function category()
    {
    	$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    	$sheet = $excel->getActiveSheet();

		$sheet->setCellValue('A1', "List Kategori"); // Set kolom A1 dengan tulisan "DATA SISWA"
    	$sheet->mergeCells('A1:C1'); // Set Merge Cell pada kolom A1 sampai E1
    	$sheet->getStyle('A1')->getFont()->setBold(true);
    	$sheet->getStyle('A3:C3')->getFont()->setBold(true);

    	$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    	$sheet->getStyle('A3:C3')->getAlignment()->setHorizontal('center');

    	// Buat header tabel nya pada baris ke 3
    	$sheet->setCellValue('A3', "Kode Kategori"); 
    	$sheet->setCellValue('B3', "Nama Kategori"); 
    	$sheet->setCellValue('C3', "Keterangan Kategori"); 


    	$get_category = $this->master_model->category_list();
    	$i = 4;
    	foreach($get_category as $row){
    		$sheet->setCellValue('A'.$i, $row->category_id); 
    		$sheet->setCellValue('B'.$i, $row->category_name); 
    		$sheet->setCellValue('C'.$i, $row->category_desc);
    		$i++;
    	}

    	$sheet->getColumnDimension('A')->setWidth(25); 
    	$sheet->getColumnDimension('B')->setWidth(35); 
    	$sheet->getColumnDimension('C')->setWidth(55);

	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    //$sheet->getDefaultRowDimension()->setRowHeight(-1);
	    // Set orientasi kertas jadi LANDSCAPE


    	$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
	    // Set judul file excel nya
    	$sheet->setTitle("Excell");

    	ob_end_clean();
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename="category_' .date('Y-m-d') . '.xlsx"');
    	header('Cache-Control: max-age=0');

    	$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    	$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
    	exit($xlsxWriter->save('php://output'));
    }


    public function supplier()
    {
    	$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    	$sheet = $excel->getActiveSheet();

		$sheet->setCellValue('A1', "List Supplier"); // Set kolom A1 dengan tulisan "DATA SISWA"
    	$sheet->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
    	$sheet->getStyle('A1')->getFont()->setBold(true);
    	$sheet->getStyle('A3:E3')->getFont()->setBold(true);

    	$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    	$sheet->getStyle('A3:E3')->getAlignment()->setHorizontal('center');

    	// Buat header tabel nya pada baris ke 3
    	$sheet->setCellValue('A3', "Kode Supplier"); 
    	$sheet->setCellValue('B3', "Nama Supplier"); 
    	$sheet->setCellValue('C3', "Telepon Supplier"); 
    	$sheet->setCellValue('D3', "Alamat Supplier");
    	$sheet->setCellValue('E3', "NPWP Supplier");

    	$get_supplier = $this->master_model->supplier_list();
    	$i = 4;
    	foreach($get_supplier as $row){
    		$sheet->setCellValue('A'.$i, $row->supplier_code); 
    		$sheet->setCellValue('B'.$i, $row->supplier_name); 
    		$sheet->setCellValue('C'.$i, $row->supplier_phone);
    		$sheet->setCellValue('D'.$i, $row->supplier_address); 
    		$sheet->setCellValue('E'.$i, $row->supplier_npwp);
    		$i++;
    	}

    	$sheet->getColumnDimension('A')->setWidth(25); 
    	$sheet->getColumnDimension('B')->setWidth(25);
    	$sheet->getColumnDimension('C')->setWidth(25);
    	$sheet->getColumnDimension('D')->setWidth(65); 
    	$sheet->getColumnDimension('E')->setWidth(25);

	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    //$sheet->getDefaultRowDimension()->setRowHeight(-1);
	    // Set orientasi kertas jadi LANDSCAPE


    	$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
	    // Set judul file excel nya
    	$sheet->setTitle("Excell");

    	ob_end_clean();
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename="supplier_' .date('Y-m-d') . '.xlsx"');
    	header('Cache-Control: max-age=0');

    	$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    	$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
    	exit($xlsxWriter->save('php://output'));
    }


    public function unit()
    {
    	$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    	$sheet = $excel->getActiveSheet();

		$sheet->setCellValue('A1', "List Unit"); // Set kolom A1 dengan tulisan "DATA SISWA"
    	$sheet->mergeCells('A1:C1'); // Set Merge Cell pada kolom A1 sampai E1
    	$sheet->getStyle('A1')->getFont()->setBold(true);
    	$sheet->getStyle('A3:C3')->getFont()->setBold(true);

    	$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    	$sheet->getStyle('A3:C3')->getAlignment()->setHorizontal('center');

    	// Buat header tabel nya pada baris ke 3
    	$sheet->setCellValue('A3', "Kode Unit"); 
    	$sheet->setCellValue('B3', "Nama Unit"); 
    	$sheet->setCellValue('C3', "Keterangan Unit"); 

    	$get_unit = $this->master_model->unit_list();
    	$i = 4;
    	foreach($get_unit as $row){
    		$sheet->setCellValue('A'.$i, $row->unit_id); 
    		$sheet->setCellValue('B'.$i, $row->unit_name); 
    		$sheet->setCellValue('C'.$i, $row->unit_desc);
    		$i++;
    	}

    	$sheet->getColumnDimension('A')->setWidth(25); 
    	$sheet->getColumnDimension('B')->setWidth(25);
    	$sheet->getColumnDimension('C')->setWidth(65);

	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    //$sheet->getDefaultRowDimension()->setRowHeight(-1);
	    // Set orientasi kertas jadi LANDSCAPE


    	$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
	    // Set judul file excel nya
    	$sheet->setTitle("Excell");

    	ob_end_clean();
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename="unit_' .date('Y-m-d') . '.xlsx"');
    	header('Cache-Control: max-age=0');

    	$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    	$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
    	exit($xlsxWriter->save('php://output'));
    }

    public function sales()
    {
    	$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    	$sheet = $excel->getActiveSheet();

		$sheet->setCellValue('A1', "List Sale"); // Set kolom A1 dengan tulisan "DATA SISWA"
    	$sheet->mergeCells('A1:D1'); // Set Merge Cell pada kolom A1 sampai E1
    	$sheet->getStyle('A1')->getFont()->setBold(true);
    	$sheet->getStyle('A3:D3')->getFont()->setBold(true);

    	$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    	$sheet->getStyle('A3:D3')->getAlignment()->setHorizontal('center');

    	// Buat header tabel nya pada baris ke 3
    	$sheet->setCellValue('A3', "Kode Sales"); 
    	$sheet->setCellValue('B3', "Nama Sales"); 
    	$sheet->setCellValue('C3', "Alamat"); 
    	$sheet->setCellValue('D3', "No HP");

    	$get_sales = $this->master_model->sales_list();
    	$i = 4;
    	foreach($get_sales as $row){
    		$sheet->setCellValue('A'.$i, $row->sales_code); 
    		$sheet->setCellValue('B'.$i, $row->sales_name); 
    		$sheet->setCellValue('C'.$i, $row->sales_address);
    		$sheet->setCellValue('D'.$i, $row->sales_phone);
    		$i++;
    	}

    	$sheet->getColumnDimension('A')->setWidth(25); 
    	$sheet->getColumnDimension('B')->setWidth(25);
    	$sheet->getColumnDimension('C')->setWidth(65);
    	$sheet->getColumnDimension('D')->setWidth(65);

	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    //$sheet->getDefaultRowDimension()->setRowHeight(-1);
	    // Set orientasi kertas jadi LANDSCAPE


    	$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
	    // Set judul file excel nya
    	$sheet->setTitle("Excell");

    	ob_end_clean();
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename="unit_' .date('Y-m-d') . '.xlsx"');
    	header('Cache-Control: max-age=0');

    	$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    	$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
    	exit($xlsxWriter->save('php://output'));
    }


    public function customer()
    {
    	$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    	$sheet = $excel->getActiveSheet();

		$sheet->setCellValue('A1', "List Customer"); // Set kolom A1 dengan tulisan "DATA SISWA"
    	$sheet->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai E1
    	$sheet->getStyle('A1')->getFont()->setBold(true);
    	$sheet->getStyle('A3:F3')->getFont()->setBold(true);

    	$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    	$sheet->getStyle('A3:F3')->getAlignment()->setHorizontal('center');

    	// Buat header tabel nya pada baris ke 3
    	$sheet->setCellValue('A3', "Kode Customer"); 
    	$sheet->setCellValue('B3', "Nama Customer"); 
    	$sheet->setCellValue('C3', "Alamat Customer"); 
    	$sheet->setCellValue('D3', "Telephone Customer");
    	$sheet->setCellValue('E3', "Saldo Customer");
    	$sheet->setCellValue('F3', "KTP Customer");

    	$get_customer = $this->master_model->customer_list();
    	$i = 4;
    	foreach($get_customer as $row){
    		$sheet->setCellValue('A'.$i, $row->customer_code); 
    		$sheet->setCellValue('B'.$i, $row->customer_name); 
    		$sheet->setCellValue('C'.$i, $row->customer_address);
    		$sheet->setCellValue('D'.$i, $row->customer_phone);
    		$sheet->setCellValue('E'.$i, $row->customer_saldo);
    		$sheet->setCellValue('F'.$i, strval($row->customer_ktp));
    		$i++;
    	}

    	$sheet->getColumnDimension('A')->setWidth(25); 
    	$sheet->getColumnDimension('B')->setWidth(25);
    	$sheet->getColumnDimension('C')->setWidth(65);
    	$sheet->getColumnDimension('D')->setWidth(65);
    	$sheet->getColumnDimension('E')->setWidth(65);
    	$sheet->getColumnDimension('F')->setWidth(65);


	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    //$sheet->getDefaultRowDimension()->setRowHeight(-1);
	    // Set orientasi kertas jadi LANDSCAPE


    	$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
	    // Set judul file excel nya
    	$sheet->setTitle("Excell");

    	ob_end_clean();
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename="customer_' .date('Y-m-d') . '.xlsx"');
    	header('Cache-Control: max-age=0');

    	$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    	$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
    	exit($xlsxWriter->save('php://output'));
    }


    public function product()
    {
    	$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    	$sheet = $excel->getActiveSheet();

		$sheet->setCellValue('A1', "List Produk"); // Set kolom A1 dengan tulisan "DATA SISWA"
    	$sheet->mergeCells('A1:P1'); // Set Merge Cell pada kolom A1 sampai E1
    	$sheet->getStyle('A1')->getFont()->setBold(true);
    	$sheet->getStyle('A3:P3')->getFont()->setBold(true);

    	$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    	$sheet->getStyle('A3:P3')->getAlignment()->setHorizontal('center');

    	// Buat header tabel nya pada baris ke 3
    	$sheet->setCellValue('A3', "Nama Produk"); 
    	$sheet->setCellValue('B3', "Brand"); 
    	$sheet->setCellValue('C3', "Supplier"); 
    	$sheet->setCellValue('D3', "Kategori");
    	$sheet->setCellValue('E3', "Minimal Stok");
    	$sheet->setCellValue('F3', "PPN");
    	$sheet->setCellValue('G3', "Kode Barcode");
    	$sheet->setCellValue('H3', "Variant / Nama");
    	$sheet->setCellValue('I3', "Modal 1");
    	$sheet->setCellValue('J3', "Modal 2");
    	$sheet->setCellValue('K3', "Harga Toko");
    	$sheet->setCellValue('L3', "Harga Cabang");
    	$sheet->setCellValue('M3', "Harga IG");
    	$sheet->setCellValue('N3', "Stok");
    	$sheet->setCellValue('O3', "Stok Belum Terkirim");
    	$sheet->setCellValue('P3', "Stok Rusak");

    	$get_customer = $this->master_model->product_list_report();
    	$i = 4;
    	foreach($get_customer as $row){
    		$sheet->setCellValue('A'.$i, $row['product_name']); 
    		$sheet->setCellValue('B'.$i, $row['brand_name']); 
    		$sheet->setCellValue('C'.$i, $row['supplier_name_group']);
    		$sheet->setCellValue('D'.$i, $row['category_name']);
    		$sheet->setCellValue('E'.$i, $row['min_stock']);
    		$sheet->setCellValue('F'.$i, $row['ppn']);
    		$sheet->setCellValue('G'.$i, $row['item_barcode']);
    		$sheet->setCellValue('H'.$i, $row['item_name']);
    		$sheet->setCellValue('I'.$i, $row['item_cogs']);
    		$sheet->setCellValue('J'.$i, $row['item_cogs2']);
    		$sheet->setCellValue('K'.$i, $row['item_price_1']);
    		$sheet->setCellValue('L'.$i, $row['item_price_2']);
    		$sheet->setCellValue('M'.$i, $row['item_price_3']);
    		$sheet->setCellValue('N'.$i, $row['item_stock']);
    		$sheet->setCellValue('O'.$i, $row['item_not_send']);
    		$sheet->setCellValue('P'.$i, $row['item_afkir']);
    		$i++;
    	}

    	$sheet->getColumnDimension('A')->setWidth(65); 
    	$sheet->getColumnDimension('B')->setWidth(25);
    	$sheet->getColumnDimension('C')->setWidth(65);
    	$sheet->getColumnDimension('D')->setWidth(25);
    	$sheet->getColumnDimension('E')->setWidth(25);
    	$sheet->getColumnDimension('F')->setWidth(25);
    	$sheet->getColumnDimension('G')->setWidth(25);
    	$sheet->getColumnDimension('H')->setWidth(65);
    	$sheet->getColumnDimension('I')->setWidth(25);
    	$sheet->getColumnDimension('J')->setWidth(25);
    	$sheet->getColumnDimension('K')->setWidth(25);
    	$sheet->getColumnDimension('L')->setWidth(25);
    	$sheet->getColumnDimension('M')->setWidth(25);
    	$sheet->getColumnDimension('N')->setWidth(25);
    	$sheet->getColumnDimension('O')->setWidth(25);
    	$sheet->getColumnDimension('P')->setWidth(25);

    	$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
	    // Set judul file excel nya
    	$sheet->setTitle("Excell");

    	ob_end_clean();
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename="customer_' .date('Y-m-d') . '.xlsx"');
    	header('Cache-Control: max-age=0');

    	$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    	$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
    	exit($xlsxWriter->save('php://output'));
    }

    public function product_under_stock()
    {
    	$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    	$sheet = $excel->getActiveSheet();

		$sheet->setCellValue('A1', "List Produk"); // Set kolom A1 dengan tulisan "DATA SISWA"
    	$sheet->mergeCells('A1:P1'); // Set Merge Cell pada kolom A1 sampai E1
    	$sheet->getStyle('A1')->getFont()->setBold(true);
    	$sheet->getStyle('A3:P3')->getFont()->setBold(true);

    	$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    	$sheet->getStyle('A3:P3')->getAlignment()->setHorizontal('center');

    	// Buat header tabel nya pada baris ke 3
    	$sheet->setCellValue('A3', "Nama Produk"); 
    	$sheet->setCellValue('B3', "Brand"); 
    	$sheet->setCellValue('C3', "Supplier"); 
    	$sheet->setCellValue('D3', "Kategori");
    	$sheet->setCellValue('E3', "Minimal Stok");
    	$sheet->setCellValue('F3', "PPN");
    	$sheet->setCellValue('G3', "Kode Barcode");
    	$sheet->setCellValue('H3', "Variant / Nama");
    	$sheet->setCellValue('I3', "Modal 1");
    	$sheet->setCellValue('J3', "Modal 2");
    	$sheet->setCellValue('K3', "Harga Toko");
    	$sheet->setCellValue('L3', "Harga Cabang");
    	$sheet->setCellValue('M3', "Harga IG");
    	$sheet->setCellValue('N3', "Stok");
    	$sheet->setCellValue('O3', "Stok Belum Terkirim");
    	$sheet->setCellValue('P3', "Stok Rusak");

    	$get_customer = $this->master_model->product_list_under_stock();
    	$i = 4;
    	foreach($get_customer as $row){
    		$sheet->setCellValue('A'.$i, $row['product_name']); 
    		$sheet->setCellValue('B'.$i, $row['brand_name']); 
    		$sheet->setCellValue('C'.$i, $row['supplier_name_group']);
    		$sheet->setCellValue('D'.$i, $row['category_name']);
    		$sheet->setCellValue('E'.$i, $row['min_stock']);
    		$sheet->setCellValue('F'.$i, $row['ppn']);
    		$sheet->setCellValue('G'.$i, $row['item_barcode']);
    		$sheet->setCellValue('H'.$i, $row['item_name']);
    		$sheet->setCellValue('I'.$i, $row['item_cogs']);
    		$sheet->setCellValue('J'.$i, $row['item_cogs2']);
    		$sheet->setCellValue('K'.$i, $row['item_price_1']);
    		$sheet->setCellValue('L'.$i, $row['item_price_2']);
    		$sheet->setCellValue('M'.$i, $row['item_price_3']);
    		$sheet->setCellValue('N'.$i, $row['item_stock']);
    		$sheet->setCellValue('O'.$i, $row['item_not_send']);
    		$sheet->setCellValue('P'.$i, $row['item_afkir']);
    		$i++;
    	}

    	$sheet->getColumnDimension('A')->setWidth(65); 
    	$sheet->getColumnDimension('B')->setWidth(25);
    	$sheet->getColumnDimension('C')->setWidth(65);
    	$sheet->getColumnDimension('D')->setWidth(25);
    	$sheet->getColumnDimension('E')->setWidth(25);
    	$sheet->getColumnDimension('F')->setWidth(25);
    	$sheet->getColumnDimension('G')->setWidth(25);
    	$sheet->getColumnDimension('H')->setWidth(65);
    	$sheet->getColumnDimension('I')->setWidth(25);
    	$sheet->getColumnDimension('J')->setWidth(25);
    	$sheet->getColumnDimension('K')->setWidth(25);
    	$sheet->getColumnDimension('L')->setWidth(25);
    	$sheet->getColumnDimension('M')->setWidth(25);
    	$sheet->getColumnDimension('N')->setWidth(25);
    	$sheet->getColumnDimension('O')->setWidth(25);
    	$sheet->getColumnDimension('P')->setWidth(25);

    	$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
	    // Set judul file excel nya
    	$sheet->setTitle("Excell");

    	ob_end_clean();
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename="customer_' .date('Y-m-d') . '.xlsx"');
    	header('Cache-Control: max-age=0');

    	$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    	$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
    	exit($xlsxWriter->save('php://output'));
    }


}

?>