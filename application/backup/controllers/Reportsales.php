<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
date_default_timezone_set('Asia/Jakarta');
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class Reportsales extends CI_Controller {

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

	public function sales_view()
	{
		$this->check_auth();
		$customer_list['customer_list'] = $this->master_model->customer_list();
		$sales_list['sales_list'] = $this->master_model->sales_list();
		$data['data'] = array_merge($customer_list, $sales_list);
		$this->load->view('Pages/Report/report_sales', $data);
	}

	public function sales_pdf()
	{
		$this->check_auth();
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		$customer_id = $this->input->get('customer_id');
		$salesman_id = $this->input->get('salesman_id');
		$status = $this->input->get('status');

		if($start_date == null){
			$start_date = date('Y-m-01');
		}
		if($end_date == null){
			$end_date = date('Y-m-d');
		}

		$data['data'] = $this->report_model->get_sales($start_date, $end_date, $customer_id, $salesman_id, $status);

		$htmlView   = $this->load->view('Pages/Report/report_sales_pdf', $data, true);
		$dompdf = new Dompdf();
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('daftar_sales.pdf', array("Attachment" => false));
		exit();
	}


	public function sales_excell()
	{
		$this->check_auth();

		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		$customer_id = $this->input->get('customer_id');
		$salesman_id = $this->input->get('salesman_id');
		$status = $this->input->get('status');

		if($start_date == null){
			$start_date = date('Y-m-01');
		}
		if($end_date == null){
			$end_date = date('Y-m-d');
		}

		$data = $this->report_model->get_sales($start_date, $end_date, $customer_id, $salesman_id, $status);

		$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $excel->getActiveSheet();

		$sheet->setCellValue('A1', "Laporan Penjualan"); // Set kolom A1 dengan tulisan "DATA SISWA"
    	$sheet->mergeCells('A1:P1'); // Set Merge Cell pada kolom A1 sampai E1
    	$sheet->getStyle('A1')->getFont()->setBold(true);
    	$sheet->getStyle('A3:P3')->getFont()->setBold(true);

    	$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    	$sheet->getStyle('A3:P3')->getAlignment()->setHorizontal('center');

    	// Buat header tabel nya pada baris ke 3
    	$sheet->setCellValue('A3', "Invoice"); 
    	$sheet->setCellValue('B3', "Tanggal"); 
    	$sheet->setCellValue('C3', "Jt Tempo"); 
    	$sheet->setCellValue('D3', "Sales");
    	$sheet->setCellValue('E3', "Customer");
    	$sheet->setCellValue('F3', "Sub Total");
    	$sheet->setCellValue('G3', "Diskon");
    	$sheet->setCellValue('H3', "PPN");
    	$sheet->setCellValue('I3', "Total");
    	$sheet->setCellValue('J3', "DP");
    	$sheet->setCellValue('K3', "Nama Barang");
    	$sheet->setCellValue('L3', "Merek");
    	$sheet->setCellValue('M3', "Kategori");
    	$sheet->setCellValue('N3', "Qty");
    	$sheet->setCellValue('O3', "Satuan");
    	$sheet->setCellValue('P3', "Harga Jual");

    	$i = 4;
    	$last_sales_invoice = '';
    	foreach($data as $row){
    		$ccode = $last_sales_invoice == $row['hd_sales_invoice'] ? '' : $row['hd_sales_invoice'];

    		$sheet->setCellValue('A'.$i, $ccode); 
    		$sheet->setCellValue('B'.$i, $row['hd_sales_date']); 
    		$sheet->setCellValue('C'.$i, $row['hd_sales_due_date']);
    		$sheet->setCellValue('D'.$i, $row['sales_name']);
    		$sheet->setCellValue('E'.$i, $row['customer_name']);
    		$sheet->setCellValue('F'.$i, $row['hd_sales_subtotal']);
    		$sheet->setCellValue('G'.$i, $row['hd_sales_discount']);
    		$sheet->setCellValue('H'.$i, $row['hd_sales_ppn']);
    		$sheet->setCellValue('I'.$i, $row['hd_sales_total']);
    		$sheet->setCellValue('J'.$i, $row['hd_sales_dp']);
    		$sheet->setCellValue('K'.$i, $row['item_name']);
    		$sheet->setCellValue('L'.$i, $row['brand_name']);
    		$sheet->setCellValue('M'.$i, $row['category_name']);
    		$sheet->setCellValue('N'.$i, $row['dt_sales_qty']);
    		$sheet->setCellValue('O'.$i, $row['unit_name']);
    		$sheet->setCellValue('P'.$i, $row['dt_sales_price']);
    		$i++;
    		$last_sales_invoice = $row['hd_sales_invoice'];
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
    	$sheet->getColumnDimension('K')->setWidth(35);
    	$sheet->getColumnDimension('L')->setWidth(35);
    	$sheet->getColumnDimension('M')->setWidth(35);
    	$sheet->getColumnDimension('N')->setWidth(35);
    	$sheet->getColumnDimension('O')->setWidth(35);
    	$sheet->getColumnDimension('P')->setWidth(35);

	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    //$sheet->getDefaultRowDimension()->setRowHeight(-1);
	    // Set orientasi kertas jadi LANDSCAPE


    	$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
	    // Set judul file excel nya
    	$sheet->setTitle("Excell");

    	ob_end_clean();
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename="laporanPenjualan_' .date('Y-m-d') . '.xlsx"');
    	header('Cache-Control: max-age=0');

    	$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    	$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
    	exit($xlsxWriter->save('php://output'));
    }


    public function sales_due_view()
    {
    	$this->check_auth();
    	$customer_list['customer_list'] = $this->master_model->customer_list();
    	$sales_list['sales_list'] = $this->master_model->sales_list();
    	$data['data'] = array_merge($customer_list, $sales_list);
    	$this->load->view('Pages/Report/report_sales_due', $data);
    }

    public function sales_due_pdf()
    {
    	$this->check_auth();
    	$start_date = $this->input->get('start_date');
    	$end_date = $this->input->get('end_date');
    	$customer_id = $this->input->get('customer_id');
    	$salesman_id = $this->input->get('salesman_id');
    	$status = $this->input->get('status');

    	if($start_date == null){
    		$start_date = date('Y-m-d');
    	}
    	if($end_date == null){
    		$end_date = date('Y-m-31');
    	}

    	$data['data'] = $this->report_model->get_sales_due($start_date, $end_date, $customer_id, $salesman_id, $status);

    	$htmlView   = $this->load->view('Pages/Report/report_sales_pdf', $data, true);
    	$dompdf = new Dompdf();
    	$dompdf->loadHtml($htmlView);
    	$dompdf->setPaper('A4', 'landscape');
    	$dompdf->render();
    	$dompdf->stream('daftar_sales_jatuh_tempo.pdf', array("Attachment" => false));
    	exit();
    }

    public function sales_due_excell()
    {
    	$this->check_auth();

    	$start_date = $this->input->get('start_date');
    	$end_date = $this->input->get('end_date');
    	$customer_id = $this->input->get('customer_id');
    	$salesman_id = $this->input->get('salesman_id');
    	$status = $this->input->get('status');

    	if($start_date == null){
    		$start_date = date('Y-m-d');
    	}
    	if($end_date == null){
    		$end_date = date('Y-m-31');
    	}

    	$data = $this->report_model->get_sales_due($start_date, $end_date, $customer_id, $salesman_id, $status);

    	$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    	$sheet = $excel->getActiveSheet();

		$sheet->setCellValue('A1', "Laporan Penjualan"); // Set kolom A1 dengan tulisan "DATA SISWA"
    	$sheet->mergeCells('A1:P1'); // Set Merge Cell pada kolom A1 sampai E1
    	$sheet->getStyle('A1')->getFont()->setBold(true);
    	$sheet->getStyle('A3:P3')->getFont()->setBold(true);

    	$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    	$sheet->getStyle('A3:P3')->getAlignment()->setHorizontal('center');

    	// Buat header tabel nya pada baris ke 3
    	$sheet->setCellValue('A3', "Invoice"); 
    	$sheet->setCellValue('B3', "Tanggal"); 
    	$sheet->setCellValue('C3', "Jt Tempo"); 
    	$sheet->setCellValue('D3', "Sales");
    	$sheet->setCellValue('E3', "Customer");
    	$sheet->setCellValue('F3', "Sub Total");
    	$sheet->setCellValue('G3', "Diskon");
    	$sheet->setCellValue('H3', "PPN");
    	$sheet->setCellValue('I3', "Total");
    	$sheet->setCellValue('J3', "DP");
    	$sheet->setCellValue('K3', "Nama Barang");
    	$sheet->setCellValue('L3', "Merek");
    	$sheet->setCellValue('M3', "Kategori");
    	$sheet->setCellValue('N3', "Qty");
    	$sheet->setCellValue('O3', "Satuan");
    	$sheet->setCellValue('P3', "Harga Jual");

    	$i = 4;
    	$last_sales_invoice = '';
    	foreach($data as $row){
    		$ccode = $last_sales_invoice == $row['hd_sales_invoice'] ? '' : $row['hd_sales_invoice'];

    		$sheet->setCellValue('A'.$i, $ccode); 
    		$sheet->setCellValue('B'.$i, $row['hd_sales_date']); 
    		$sheet->setCellValue('C'.$i, $row['hd_sales_due_date']);
    		$sheet->setCellValue('D'.$i, $row['sales_name']);
    		$sheet->setCellValue('E'.$i, $row['customer_name']);
    		$sheet->setCellValue('F'.$i, $row['hd_sales_subtotal']);
    		$sheet->setCellValue('G'.$i, $row['hd_sales_discount']);
    		$sheet->setCellValue('H'.$i, $row['hd_sales_ppn']);
    		$sheet->setCellValue('I'.$i, $row['hd_sales_total']);
    		$sheet->setCellValue('J'.$i, $row['hd_sales_dp']);
    		$sheet->setCellValue('K'.$i, $row['item_name']);
    		$sheet->setCellValue('L'.$i, $row['brand_name']);
    		$sheet->setCellValue('M'.$i, $row['category_name']);
    		$sheet->setCellValue('N'.$i, $row['dt_sales_qty']);
    		$sheet->setCellValue('O'.$i, $row['unit_name']);
    		$sheet->setCellValue('P'.$i, $row['dt_sales_price']);
    		$i++;
    		$last_sales_invoice = $row['hd_sales_invoice'];
    	}

    	$sheet->getColumnDimension('A')->setWidth(35); 
    	$sheet->getColumnDimension('B')->setWidth(25); 
    	$sheet->getColumnDimension('C')->setWidth(25);
    	$sheet->getColumnDimension('D')->setWidth(35); 
    	$sheet->getColumnDimension('E')->setWidth(35); 
    	$sheet->getColumnDimension('F')->setWidth(35);
    	$sheet->getColumnDimension('G')->setWidth(55); 
    	$sheet->getColumnDimension('H')->setWidth(35); 
    	$sheet->getColumnDimension('I')->setWidth(35);
    	$sheet->getColumnDimension('J')->setWidth(35);
    	$sheet->getColumnDimension('K')->setWidth(45);
    	$sheet->getColumnDimension('L')->setWidth(35);
    	$sheet->getColumnDimension('M')->setWidth(35);
    	$sheet->getColumnDimension('N')->setWidth(35);
    	$sheet->getColumnDimension('O')->setWidth(35);
    	$sheet->getColumnDimension('P')->setWidth(35);

	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    //$sheet->getDefaultRowDimension()->setRowHeight(-1);
	    // Set orientasi kertas jadi LANDSCAPE


    	$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
	    // Set judul file excel nya
    	$sheet->setTitle("Excell");

    	ob_end_clean();
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename="laporanPenjualan_' .date('Y-m-d') . '.xlsx"');
    	header('Cache-Control: max-age=0');

    	$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    	$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
    	exit($xlsxWriter->save('php://output'));
    }

    public function sales_not_send_view()
    {
    	$this->check_auth();

    	$data = $this->report_model->get_sales_not_send();

    	$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    	$sheet = $excel->getActiveSheet();

		$sheet->setCellValue('A1', "Laporan Penjualan Belum Terkirim"); // Set kolom A1 dengan tulisan "DATA SISWA"
    	$sheet->mergeCells('A1:P1'); // Set Merge Cell pada kolom A1 sampai E1
    	$sheet->getStyle('A1')->getFont()->setBold(true);
    	$sheet->getStyle('A3:P3')->getFont()->setBold(true);

    	$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    	$sheet->getStyle('A3:P3')->getAlignment()->setHorizontal('center');

    	// Buat header tabel nya pada baris ke 3
    	$sheet->setCellValue('A3', "Invoice"); 
    	$sheet->setCellValue('B3', "Tanggal"); 
    	$sheet->setCellValue('C3', "Customer");
    	$sheet->setCellValue('D3', "Nama Item");
    	$sheet->setCellValue('E3', "Qty");

    	$i = 4;
    	$last_sales_invoice = '';
    	foreach($data as $row){
    		$ccode = $last_sales_invoice == $row['hd_sales_invoice'] ? '' : $row['hd_sales_invoice'];

    		$sheet->setCellValue('A'.$i, $ccode); 
    		$sheet->setCellValue('B'.$i, $row['hd_sales_date']); 
    		$sheet->setCellValue('C'.$i, $row['customer_name']);
    		$sheet->setCellValue('D'.$i, $row['item_name']);
    		$sheet->setCellValue('E'.$i, $row['dt_sales_qty']);
    		$i++;
    		$last_sales_invoice = $row['hd_sales_invoice'];
    	}

    	$sheet->getColumnDimension('A')->setWidth(35); 
    	$sheet->getColumnDimension('B')->setWidth(25); 
    	$sheet->getColumnDimension('C')->setWidth(25);
    	$sheet->getColumnDimension('D')->setWidth(35); 
    	$sheet->getColumnDimension('E')->setWidth(15); 
    	

	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    //$sheet->getDefaultRowDimension()->setRowHeight(-1);
	    // Set orientasi kertas jadi LANDSCAPE


    	$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
	    // Set judul file excel nya
    	$sheet->setTitle("Excell");

    	ob_end_clean();
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename="laporanPenjualanBelumTerkirim_' .date('Y-m-d') . '.xlsx"');
    	header('Cache-Control: max-age=0');

    	$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    	$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
    	exit($xlsxWriter->save('php://output'));
    }

    public function retur_sales_view()
    {
    	$this->check_auth();
    	$customer_list['customer_list'] = $this->master_model->customer_list();
    	$this->load->view('Pages/Report/report_retur_sales', $customer_list);
    }

    public function retur_sales_pdf()
    {
    	$this->check_auth();
    	$start_date = $this->input->get('start_date');
    	$end_date = $this->input->get('end_date');
    	$customer_id = $this->input->get('customer_id');
    	if($start_date == null){
    		$start_date = date('Y-m-01');
    	}
    	if($end_date == null){
    		$end_date = date('Y-m-d');
    	}
    	$data['data'] = $this->report_model->get_retur_sales($start_date, $end_date, $customer_id);
    	$htmlView   = $this->load->view('Pages/Report/report_retur_sales_pdf', $data, true);
    	$dompdf = new Dompdf();
    	$dompdf->loadHtml($htmlView);
    	$dompdf->setPaper('A4', 'landscape');
    	$dompdf->render();
    	$dompdf->stream('daftar_retur_sales.pdf', array("Attachment" => false));
    	exit();
    }

    public function retur_sales_excell()
    {
    	$this->check_auth();

    	$start_date = $this->input->get('start_date');
    	$end_date = $this->input->get('end_date');
    	$customer_id = $this->input->get('customer_id');

    	if($start_date == null){
    		$start_date = date('Y-m-01');
    	}
    	if($end_date == null){
    		$end_date = date('Y-m-d');
    	}

    	$data = $this->report_model->get_retur_sales($start_date, $end_date, $customer_id);
    	$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    	$sheet = $excel->getActiveSheet();

		$sheet->setCellValue('A1', "Laporan Retur Penjualan"); // Set kolom A1 dengan tulisan "DATA SISWA"
    	$sheet->mergeCells('A1:L1'); // Set Merge Cell pada kolom A1 sampai E1
    	$sheet->getStyle('A1')->getFont()->setBold(true);
    	$sheet->getStyle('A3:L3')->getFont()->setBold(true);

    	$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    	$sheet->getStyle('A3:L3')->getAlignment()->setHorizontal('center');

    	// Buat header tabel nya pada baris ke 3
    	$sheet->setCellValue('A3', "No Retur Penjualan"); 
    	$sheet->setCellValue('B3', "Customer"); 
    	$sheet->setCellValue('C3', "Nama Customer"); 
    	$sheet->setCellValue('D3', "No Penjualan");
    	$sheet->setCellValue('E3', "Tanggal");
    	$sheet->setCellValue('F3', "Total Retur");
    	$sheet->setCellValue('G3', "Jenis Retur");
    	$sheet->setCellValue('H3', "Kode Item");
    	$sheet->setCellValue('I3', "Nama Item");
    	$sheet->setCellValue('J3', "Qty Retur");
    	$sheet->setCellValue('K3', "Harga");
    	$sheet->setCellValue('L3', "Sub total");

    	$i = 4;
    	$last_retur_sales_invoice = '';
    	foreach($data as $row){
    		$ccode = $last_retur_sales_invoice == $row['hd_retur_sales_invoice'] ? '' : $row['hd_retur_sales_invoice'];

    		if($row['hd_retur_payment'] == 'Ya'){ 
    			$retur_type =  'Potong Nota'; 
    		}else{ 
    			$retur_type =  'Tidak Potong Nota'; 
    		} 

    		$sheet->setCellValue('A'.$i, $ccode); 
    		$sheet->setCellValue('B'.$i, $row['customer_name']); 
    		$sheet->setCellValue('C'.$i, $row['customer_code']);
    		$sheet->setCellValue('D'.$i, $row['hd_sales_invoice']);
    		$sheet->setCellValue('E'.$i, $row['hd_retur_date']);
    		$sheet->setCellValue('F'.$i, $row['hd_retur_total_transaction']);
    		$sheet->setCellValue('G'.$i, $retur_type);
    		$sheet->setCellValue('H'.$i, $row['item_barcode']);
    		$sheet->setCellValue('I'.$i, $row['item_name']);
    		$sheet->setCellValue('J'.$i, $row['dt_retur_qty']);
    		$sheet->setCellValue('K'.$i, $row['dt_retur_price']);
    		$sheet->setCellValue('L'.$i, $row['dt_retur_total']);
    		$i++;
    		$last_retur_sales_invoice = $row['hd_retur_sales_invoice'];
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
    	header('Content-Disposition: attachment;filename="laporanReturPenjualan_' .date('Y-m-d') . '.xlsx"');
    	header('Cache-Control: max-age=0');

    	$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    	$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
    	exit($xlsxWriter->save('php://output'));
    }


    public function sales_minus_view()
    {
    	$this->check_auth();
    	$this->load->view('Pages/Report/report_sales_minus');
    }

    public function sales_minus_pdf()
    {
    	$this->check_auth();
    	$start_date = $this->input->get('start_date');
    	$end_date = $this->input->get('end_date');
    	if($start_date == null){
    		$start_date = date('Y-m-01');
    	}
    	if($end_date == null){
    		$end_date = date('Y-m-d');
    	}
    	$data['data'] = $this->report_model->get_sales_minus($start_date, $end_date);
    	$htmlView   = $this->load->view('Pages/Report/report_sales_minus_pdf', $data, true);
    	$dompdf = new Dompdf();
    	$dompdf->loadHtml($htmlView);
    	$dompdf->setPaper('A4', 'landscape');
    	$dompdf->render();
    	$dompdf->stream('sales_minus.pdf', array("Attachment" => false));
    	exit();
    }

    public function sales_minus_excell()
    {
    	$this->check_auth();

    	$start_date = $this->input->get('start_date');
    	$end_date = $this->input->get('end_date');

    	if($start_date == null){
    		$start_date = date('Y-m-01');
    	}
    	if($end_date == null){
    		$end_date = date('Y-m-d');
    	}

    	$data  = $this->report_model->get_sales_minus($start_date, $end_date);
    	$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    	$sheet = $excel->getActiveSheet();

		$sheet->setCellValue('A1', "Laporan Penjualan Minus"); // Set kolom A1 dengan tulisan "DATA SISWA"
    	$sheet->mergeCells('A1:L1'); // Set Merge Cell pada kolom A1 sampai E1
    	$sheet->getStyle('A1')->getFont()->setBold(true);
    	$sheet->getStyle('A3:L3')->getFont()->setBold(true);

    	$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    	$sheet->getStyle('A3:L3')->getAlignment()->setHorizontal('center');

    	// Buat header tabel nya pada baris ke 3
    	$sheet->setCellValue('A3', "Nama Produk"); 
    	$sheet->setCellValue('B3', "No Invoice Sales"); 
    	$sheet->setCellValue('C3', "Tanggal	"); 
    	$sheet->setCellValue('D3', "Qty Jual");
    	$sheet->setCellValue('E3', "Stok Setelah Jual");

    	$i = 4;
    	$last_retur_sales_invoice = '';
    	foreach($data as $row){

    		$sheet->setCellValue('A'.$i, $row['item_name']); 
    		$sheet->setCellValue('B'.$i, $row['report_minus_sales_invoice']); 
    		$sheet->setCellValue('C'.$i, $row['report_minus_sales_date']);
    		$sheet->setCellValue('D'.$i, $row['report_minus_sales_qty']);
    		$sheet->setCellValue('E'.$i, $row['report_minus_sales_qty'] - $row['report_minus_sales_before_qty']);
    		$i++;
    	}

    	$sheet->getColumnDimension('A')->setWidth(55); 
    	$sheet->getColumnDimension('B')->setWidth(35);
    	$sheet->getColumnDimension('C')->setWidth(35);
    	$sheet->getColumnDimension('D')->setWidth(35); 
    	$sheet->getColumnDimension('E')->setWidth(35);


    	$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    	$sheet->setTitle("Excell");

    	ob_end_clean();
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename="laporanPenjualanMinus_' .date('Y-m-d') . '.xlsx"');
    	header('Cache-Control: max-age=0');

    	$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    	$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
    	exit($xlsxWriter->save('php://output'));
    }
}

?>