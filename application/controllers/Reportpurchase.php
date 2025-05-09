<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
date_default_timezone_set('Asia/Jakarta');
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class Reportpurchase extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('master_model');
		$this->load->model('report_model');

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

	public function po_view()
	{
		$this->check_auth();
		$supplier_list['supplier_list'] = $this->master_model->supplier_list();
		$this->load->view('Pages/Report/report_po', $supplier_list);
	}

	public function po_pdf()
	{
		$this->check_auth();
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		$product_tax = $this->input->get('product_tax');
		$supplier_id = $this->input->get('supplier_id');
		$status_po = $this->input->get('status_po');

		if($start_date == null){
			$start_date = date('Y-m-01');
		}
		if($end_date == null){
			$end_date = date('Y-m-d');
		}

		$data['data'] = $this->report_model->get_po($start_date, $end_date, $product_tax, $supplier_id, $status_po);

		$htmlView   = $this->load->view('Pages/Report/report_po_pdf', $data, true);
		$dompdf = new Dompdf();
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('daftar_po.pdf', array("Attachment" => false));
		exit();
	}


	public function po_excell()
	{
		$this->check_auth();

		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		$product_tax = $this->input->get('product_tax');
		$supplier_id = $this->input->get('supplier_id');
		$status_po = $this->input->get('status_po');

		if($start_date == null){
			$start_date = date('Y-m-01');
		}
		if($end_date == null){
			$end_date = date('Y-m-d');
		}

		$data = $this->report_model->get_po($start_date, $end_date, $product_tax, $supplier_id, $status_po);

		$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $excel->getActiveSheet();

		$sheet->setCellValue('A1', "Laporan PO"); // Set kolom A1 dengan tulisan "DATA SISWA"
    	$sheet->mergeCells('A1:J1'); // Set Merge Cell pada kolom A1 sampai E1
    	$sheet->getStyle('A1')->getFont()->setBold(true);
    	$sheet->getStyle('A3:J3')->getFont()->setBold(true);

    	$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    	$sheet->getStyle('A3:J3')->getAlignment()->setHorizontal('center');

    	// Buat header tabel nya pada baris ke 3
    	$sheet->setCellValue('A3', "No PO"); 
    	$sheet->setCellValue('B3', "Tanggal PO"); 
    	$sheet->setCellValue('C3', "Kode Barang"); 
    	$sheet->setCellValue('D3', "Nama Barang");
    	$sheet->setCellValue('E3', "Golongan");
    	$sheet->setCellValue('F3', "Kode Supplier");
    	$sheet->setCellValue('G3', "Nama Supplier");
    	$sheet->setCellValue('H3', "Harga Beli Per Unit");
    	$sheet->setCellValue('I3', "Qty");
    	$sheet->setCellValue('J3', "Total Harga");

    	$i = 4;
    	$last_po_invoice = '';
    	foreach($data as $row){
    		$ccode = $last_po_invoice == $row['hd_po_invoice'] ? '' : $row['hd_po_invoice'];

    		if($row['hd_po_gol'] == 'Y'){ 
    			$ppn =  'PPN'; 
    		}else{ 
    			$ppn =  'NON PPN';
    		}

    		$sheet->setCellValue('A'.$i, $ccode); 
    		$sheet->setCellValue('B'.$i, $row['hd_po_date']); 
    		$sheet->setCellValue('C'.$i, $row['item_barcode']);
    		$sheet->setCellValue('D'.$i, $row['item_name']);
    		$sheet->setCellValue('E'.$i, $ppn);
    		$sheet->setCellValue('F'.$i, $row['supplier_code']);
    		$sheet->setCellValue('G'.$i, $row['supplier_name']);
    		$sheet->setCellValue('H'.$i, $row['dt_po_price']);
    		$sheet->setCellValue('I'.$i, $row['dt_po_qty']);
    		$sheet->setCellValue('J'.$i, $row['dt_po_total']);
    		$i++;
    		$last_po_invoice = $row['hd_po_invoice'];
    	}

    	$sheet->getColumnDimension('A')->setWidth(25); 
    	$sheet->getColumnDimension('B')->setWidth(55); 
    	$sheet->getColumnDimension('C')->setWidth(55);
    	$sheet->getColumnDimension('D')->setWidth(55); 
    	$sheet->getColumnDimension('E')->setWidth(35); 
    	$sheet->getColumnDimension('F')->setWidth(35);
    	$sheet->getColumnDimension('G')->setWidth(55); 
    	$sheet->getColumnDimension('H')->setWidth(35); 
    	$sheet->getColumnDimension('I')->setWidth(35);
    	$sheet->getColumnDimension('J')->setWidth(35);

	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    //$sheet->getDefaultRowDimension()->setRowHeight(-1);
	    // Set orientasi kertas jadi LANDSCAPE


    	$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
	    // Set judul file excel nya
    	$sheet->setTitle("Excell");

    	ob_end_clean();
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename="laporanPO_' .date('Y-m-d') . '.xlsx"');
    	header('Cache-Control: max-age=0');

    	$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    	$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
    	exit($xlsxWriter->save('php://output'));
    }


    public function purchase_view()
    {
    	$this->check_auth();
    	$supplier_list['supplier_list'] = $this->master_model->supplier_list();
    	$brand_list['brand_list'] = $this->master_model->brand_list();
    	$category_list['category_list'] = $this->master_model->category_list();
    	$data['data'] = array_merge($supplier_list, $brand_list, $category_list);
    	$this->load->view('Pages/Report/report_purchase', $data);
    }

    public function purchase_pdf()
    {
    	$this->check_auth();
    	$start_date = $this->input->get('start_date');
    	$end_date = $this->input->get('end_date');
    	$product_tax = $this->input->get('product_tax');
    	$supplier_id = $this->input->get('supplier_id');
    	$category_id = $this->input->get('category_id');
    	$brand_id = $this->input->get('brand_id');

    	if($start_date == null){
    		$start_date = date('Y-m-01');
    	}
    	if($end_date == null){
    		$end_date = date('Y-m-d');
    	}

    	$data['data'] = $this->report_model->get_purchase($start_date, $end_date, $product_tax, $supplier_id, $category_id, $brand_id);
    	$htmlView   = $this->load->view('Pages/Report/report_purchase_pdf', $data, true);
    	$dompdf = new Dompdf();
    	$dompdf->loadHtml($htmlView);
    	$dompdf->setPaper('A4', 'landscape');
    	$dompdf->render();
    	$dompdf->stream('daftar_po.pdf', array("Attachment" => false));
    	exit();
    }


    public function purchase_excell()
    {
    	$this->check_auth();

    	$start_date = $this->input->get('start_date');
    	$end_date = $this->input->get('end_date');
    	$product_tax = $this->input->get('product_tax');
    	$supplier_id = $this->input->get('supplier_id');
    	$category_id = $this->input->get('category_id');
    	$brand_id = $this->input->get('brand_id');

    	if($start_date == null){
    		$start_date = date('Y-m-01');
    	}
    	if($end_date == null){
    		$end_date = date('Y-m-d');
    	}

    	$data = $this->report_model->get_purchase($start_date, $end_date, $product_tax, $supplier_id, $category_id, $brand_id);
    	$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    	$sheet = $excel->getActiveSheet();

		$sheet->setCellValue('A1', "Laporan Pembelian"); // Set kolom A1 dengan tulisan "DATA SISWA"
    	$sheet->mergeCells('A1:O1'); // Set Merge Cell pada kolom A1 sampai E1
    	$sheet->getStyle('A1')->getFont()->setBold(true);
    	$sheet->getStyle('A3:O3')->getFont()->setBold(true);

    	$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    	$sheet->getStyle('A3:O3')->getAlignment()->setHorizontal('center');

    	// Buat header tabel nya pada baris ke 3
    	$sheet->setCellValue('A3', "No Pembelian"); 
    	$sheet->setCellValue('B3', "Tanggal"); 
    	$sheet->setCellValue('C3', "Kode Supplier"); 
    	$sheet->setCellValue('D3', "Nama Supplier");
    	$sheet->setCellValue('E3', "Tanggal JT");
    	$sheet->setCellValue('F3', "Kode Barang");
    	$sheet->setCellValue('G3', "Nama Barang");
    	$sheet->setCellValue('H3', "Merek");
    	$sheet->setCellValue('I3', "Kategori");
    	$sheet->setCellValue('J3', "Qty");
    	$sheet->setCellValue('K3', "Satuan");
    	$sheet->setCellValue('L3', "Harga Per Unit");
    	$sheet->setCellValue('M3', "PPN");
    	$sheet->setCellValue('N3', "Total");
    	$sheet->setCellValue('O3', "DP");

    	$i = 4;
    	$last_purchase_invoice = '';
    	foreach($data as $row){
    		$ccode = $last_purchase_invoice == $row['hd_purchase_invoice'] ? '' : $row['hd_purchase_invoice'];

    		if($row['hd_po_gol'] == 'Y'){ 
    			$ppn =  'PPN'; 
    		}else{ 
    			$ppn =  'NON PPN';
    		}

    		$sheet->setCellValue('A'.$i, $ccode); 
    		$sheet->setCellValue('B'.$i, $row['hd_purchase_date']); 
    		$sheet->setCellValue('C'.$i, $row['supplier_code']);
    		$sheet->setCellValue('D'.$i, $row['supplier_name']);
    		$sheet->setCellValue('E'.$i, $row['hd_purchase_due_date']);
    		$sheet->setCellValue('F'.$i, $row['item_barcode']);
    		$sheet->setCellValue('G'.$i, $row['item_name']);
    		$sheet->setCellValue('H'.$i, $row['brand_name']);
    		$sheet->setCellValue('I'.$i, $row['category_name']);
    		$sheet->setCellValue('J'.$i, $row['dt_purchase_qty']);
    		$sheet->setCellValue('K'.$i, $row['unit_name']);
    		$sheet->setCellValue('L'.$i, $row['dt_purchase_price']);
    		$sheet->setCellValue('M'.$i, $row['hd_purchase_ppn']);
    		$sheet->setCellValue('N'.$i, $row['hd_purchase_total']);
    		$sheet->setCellValue('O'.$i, $row['hd_purchase_dp']);
    		$i++;
    		$last_purchase_invoice = $row['hd_purchase_invoice'];
    	}

    	$sheet->getColumnDimension('A')->setWidth(55); 
    	$sheet->getColumnDimension('B')->setWidth(25);
    	$sheet->getColumnDimension('C')->setWidth(25);
    	$sheet->getColumnDimension('D')->setWidth(25); 
    	$sheet->getColumnDimension('E')->setWidth(35); 
    	$sheet->getColumnDimension('F')->setWidth(25);
    	$sheet->getColumnDimension('G')->setWidth(55); 
    	$sheet->getColumnDimension('H')->setWidth(35); 
    	$sheet->getColumnDimension('I')->setWidth(35);
    	$sheet->getColumnDimension('J')->setWidth(15);
    	$sheet->getColumnDimension('K')->setWidth(25);
    	$sheet->getColumnDimension('L')->setWidth(25);
    	$sheet->getColumnDimension('M')->setWidth(25);
    	$sheet->getColumnDimension('N')->setWidth(25);
    	$sheet->getColumnDimension('O')->setWidth(25);

	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    //$sheet->getDefaultRowDimension()->setRowHeight(-1);
	    // Set orientasi kertas jadi LANDSCAPE


    	$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
	    // Set judul file excel nya
    	$sheet->setTitle("Excell");

    	ob_end_clean();
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename="laporanPembelian_' .date('Y-m-d') . '.xlsx"');
    	header('Cache-Control: max-age=0');

    	$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    	$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
    	exit($xlsxWriter->save('php://output'));
    }


    public function retur_purchase_view()
    {
    	$this->check_auth();
    	$supplier_list['supplier_list'] = $this->master_model->supplier_list();
    	$this->load->view('Pages/Report/report_retur_purchase', $supplier_list);
    }

    public function retur_purchase_pdf()
    {
    	$this->check_auth();
    	$start_date = $this->input->get('start_date');
    	$end_date = $this->input->get('end_date');
    	$supplier_id = $this->input->get('supplier_id');

    	if($start_date == null){
    		$start_date = date('Y-m-01');
    	}
    	if($end_date == null){
    		$end_date = date('Y-m-d');
    	}

    	$data['data'] = $this->report_model->get_retur_purchase($start_date, $end_date, $supplier_id);
    	$htmlView   = $this->load->view('Pages/Report/report_retur_purchase_pdf', $data, true);
    	$dompdf = new Dompdf();
    	$dompdf->loadHtml($htmlView);
    	$dompdf->setPaper('A4', 'landscape');
    	$dompdf->render();
    	$dompdf->stream('daftar_po.pdf', array("Attachment" => false));
    	exit();
    }


    public function retur_purchase_excell()
    {
    	$this->check_auth();

    	$start_date = $this->input->get('start_date');
    	$end_date = $this->input->get('end_date');
    	$supplier_id = $this->input->get('supplier_id');

    	if($start_date == null){
    		$start_date = date('Y-m-01');
    	}
    	if($end_date == null){
    		$end_date = date('Y-m-d');
    	}

    	$data = $this->report_model->get_retur_purchase($start_date, $end_date, $supplier_id);
    	$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    	$sheet = $excel->getActiveSheet();

		$sheet->setCellValue('A1', "Laporan Retur Pembelian"); // Set kolom A1 dengan tulisan "DATA SISWA"
    	$sheet->mergeCells('A1:L1'); // Set Merge Cell pada kolom A1 sampai E1
    	$sheet->getStyle('A1')->getFont()->setBold(true);
    	$sheet->getStyle('A3:L3')->getFont()->setBold(true);

    	$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    	$sheet->getStyle('A3:L3')->getAlignment()->setHorizontal('center');

    	// Buat header tabel nya pada baris ke 3
    	$sheet->setCellValue('A3', "No Retur Pembelian"); 
    	$sheet->setCellValue('B3', "Supplier"); 
    	$sheet->setCellValue('C3', "Nama Supplier"); 
    	$sheet->setCellValue('D3', "No Pembelian");
    	$sheet->setCellValue('E3', "Tanggal");
    	$sheet->setCellValue('F3', "Total Retur");
    	$sheet->setCellValue('G3', "Jenis Retur");
    	$sheet->setCellValue('H3', "Kode Item");
    	$sheet->setCellValue('I3', "Nama Item");
    	$sheet->setCellValue('J3', "Qty Retur");
    	$sheet->setCellValue('K3', "Harga");
    	$sheet->setCellValue('L3', "Sub total");

    	$i = 4;
    	$last_retur_purchase_invoice = '';
    	foreach($data as $row){
    		$ccode = $last_retur_purchase_invoice == $row['hd_retur_purchase_invoice'] ? '' : $row['hd_retur_purchase_invoice'];

    		if($row['hd_retur_payment'] == 'Ya'){ 
    			$retur_type =  'Potong Nota'; 
    		}else{ 
    			$retur_type =  'Tidak Potong Nota'; 
    		} 

    		$sheet->setCellValue('A'.$i, $ccode); 
    		$sheet->setCellValue('B'.$i, $row['supplier_name']); 
    		$sheet->setCellValue('C'.$i, $row['supplier_code']);
    		$sheet->setCellValue('D'.$i, $row['hd_purchase_invoice']);
    		$sheet->setCellValue('E'.$i, $row['hd_retur_date']);
    		$sheet->setCellValue('F'.$i, $row['hd_retur_total_transaction']);
    		$sheet->setCellValue('G'.$i, $retur_type);
    		$sheet->setCellValue('H'.$i, $row['item_barcode']);
    		$sheet->setCellValue('I'.$i, $row['item_name']);
    		$sheet->setCellValue('J'.$i, $row['dt_retur_qty']);
    		$sheet->setCellValue('K'.$i, $row['dt_retur_price']);
    		$sheet->setCellValue('L'.$i, $row['dt_retur_total']);
    		$i++;
    		$last_retur_purchase_invoice = $row['hd_retur_purchase_invoice'];
    	}

    	$sheet->getColumnDimension('A')->setWidth(55); 
    	$sheet->getColumnDimension('B')->setWidth(35);
    	$sheet->getColumnDimension('C')->setWidth(35);
    	$sheet->getColumnDimension('D')->setWidth(35); 
    	$sheet->getColumnDimension('E')->setWidth(35); 
    	$sheet->getColumnDimension('F')->setWidth(35);
    	$sheet->getColumnDimension('G')->setWidth(55); 
    	$sheet->getColumnDimension('H')->setWidth(35); 
    	$sheet->getColumnDimension('I')->setWidth(35);
    	$sheet->getColumnDimension('J')->setWidth(25);
    	$sheet->getColumnDimension('K')->setWidth(25);
    	$sheet->getColumnDimension('L')->setWidth(25);

	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    //$sheet->getDefaultRowDimension()->setRowHeight(-1);
	    // Set orientasi kertas jadi LANDSCAPE


    	$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
	    // Set judul file excel nya
    	$sheet->setTitle("Excell");

    	ob_end_clean();
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename="laporanReturPembelian_' .date('Y-m-d') . '.xlsx"');
    	header('Cache-Control: max-age=0');

    	$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    	$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
    	exit($xlsxWriter->save('php://output'));
    }


}

?>