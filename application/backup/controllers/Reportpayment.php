<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
date_default_timezone_set('Asia/Jakarta');
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class Reportpayment extends CI_Controller {

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

	public function debt_view()
	{
		$this->check_auth();
		$supplier_list['supplier_list'] = $this->master_model->supplier_list();
		$this->load->view('Pages/Report/report_debt', $supplier_list);
	}

	public function debt_pdf()
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

		$data['data'] = $this->report_model->get_debt($start_date, $end_date, $supplier_id);

		$htmlView   = $this->load->view('Pages/Report/report_debt_pdf', $data, true);
		$dompdf = new Dompdf();
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('daftar_debt.pdf', array("Attachment" => false));
		exit();
	}


	public function debt_excell()
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

		$data = $this->report_model->get_debt($start_date, $end_date, $supplier_id);

		$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $excel->getActiveSheet();

		$sheet->setCellValue('A1', "Laporan Pembayaran Hutang"); // Set kolom A1 dengan tulisan "DATA SISWA"
    	$sheet->mergeCells('A1:K1'); // Set Merge Cell pada kolom A1 sampai E1
    	$sheet->getStyle('A1')->getFont()->setBold(true);
    	$sheet->getStyle('A3:K3')->getFont()->setBold(true);

    	$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    	$sheet->getStyle('A3:K3')->getAlignment()->setHorizontal('center');

    	// Buat header tabel nya pada baris ke 3
    	$sheet->setCellValue('A3', "No Transaksi"); 
    	$sheet->setCellValue('B3', "Supplier"); 
    	$sheet->setCellValue('C3', "Tgl Pembayaran"); 
    	$sheet->setCellValue('D3', "Pembayaran");
    	$sheet->setCellValue('E3', "Total Bayar");
    	$sheet->setCellValue('F3', "Jumlah Nota");
    	$sheet->setCellValue('G3', "No Pembelian");
    	$sheet->setCellValue('H3', "Potongan");
    	$sheet->setCellValue('I3', "Nominal Bayar");
    	$sheet->setCellValue('J3', "Nilai Retur");
    	$sheet->setCellValue('K3', "Sisa Hutang");

    	$i = 4;
    	$last_debt_invoice = '';
    	foreach($data as $row){
    		$ccode = $last_debt_invoice == $row['payment_debt_invoice'] ? '' : $row['payment_debt_invoice'];
    		$sheet->setCellValue('A'.$i, $ccode); 
    		$sheet->setCellValue('B'.$i, $row['supplier_name']); 
    		$sheet->setCellValue('C'.$i, $row['payment_debt_date']);
    		$sheet->setCellValue('D'.$i, $row['payment_name']);
    		$sheet->setCellValue('E'.$i, $row['payment_debt_total_invoice']);
    		$sheet->setCellValue('F'.$i, $row['payment_debt_total_pay']);
    		$sheet->setCellValue('G'.$i, $row['hd_purchase_invoice']);
    		$sheet->setCellValue('H'.$i, $row['dt_payment_debt_discount']);
    		$sheet->setCellValue('I'.$i, $row['dt_payment_debt_nominal']);
    		$sheet->setCellValue('J'.$i, $row['dt_payment_debt_retur']);
    		$sheet->setCellValue('K'.$i, $row['dt_payment_debt_remaining']);
    		$i++;
    		$last_debt_invoice = $row['payment_debt_invoice'];
    	}

    	$sheet->getColumnDimension('A')->setWidth(25); 
    	$sheet->getColumnDimension('B')->setWidth(35); 
    	$sheet->getColumnDimension('C')->setWidth(35);
    	$sheet->getColumnDimension('D')->setWidth(35); 
    	$sheet->getColumnDimension('E')->setWidth(35); 
    	$sheet->getColumnDimension('F')->setWidth(35);
    	$sheet->getColumnDimension('G')->setWidth(35); 
    	$sheet->getColumnDimension('H')->setWidth(35); 
    	$sheet->getColumnDimension('I')->setWidth(35);
    	$sheet->getColumnDimension('J')->setWidth(35);
    	$sheet->getColumnDimension('K')->setWidth(35);

	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    //$sheet->getDefaultRowDimension()->setRowHeight(-1);
	    // Set orientasi kertas jadi LANDSCAPE


    	$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
	    // Set judul file excel nya
    	$sheet->setTitle("Excell");

    	ob_end_clean();
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename="laporanHutang_' .date('Y-m-d') . '.xlsx"');
    	header('Cache-Control: max-age=0');

    	$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    	$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
    	exit($xlsxWriter->save('php://output'));
    }

    public function debt_pending_view()
    {
    	$this->check_auth();
    	$supplier_list['supplier_list'] = $this->master_model->supplier_list();
    	$this->load->view('Pages/Report/report_debt_pending', $supplier_list);
    }

    public function debt_pending_pdf()
    {
    	$this->check_auth();
    	$supplier_id = $this->input->get('supplier_id');

    	$data['data'] = $this->report_model->get_debt_pending($supplier_id);

    	$htmlView   = $this->load->view('Pages/Report/report_pending_debt_pdf', $data, true);
    	$dompdf = new Dompdf();
    	$dompdf->loadHtml($htmlView);
    	$dompdf->setPaper('A4', 'landscape');
    	$dompdf->render();
    	$dompdf->stream('daftar_debt.pdf', array("Attachment" => false));
    	exit();
    }


    public function debt_pending_excell()
    {
    	$this->check_auth();

    	$supplier_id = $this->input->get('supplier_id');


    	$data = $this->report_model->get_debt_pending_excell($supplier_id);

    	$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    	$sheet = $excel->getActiveSheet();

		$sheet->setCellValue('A1', "Laporan Pembayaran Hutang"); // Set kolom A1 dengan tulisan "DATA SISWA"
    	$sheet->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai E1
    	$sheet->getStyle('A1')->getFont()->setBold(true);
    	$sheet->getStyle('A3:F3')->getFont()->setBold(true);

    	$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    	$sheet->getStyle('A3:F3')->getAlignment()->setHorizontal('center');

    	// Buat header tabel nya pada baris ke 3
    	
    	$sheet->setCellValue('A3', "Supplier"); 
    	$sheet->setCellValue('B3', "No Pembelian"); 
    	$sheet->setCellValue('C3', "Tgl Pemblian"); 
    	$sheet->setCellValue('D3', "Jt Tempo");
    	$sheet->setCellValue('E3', "Total Nota");
    	$sheet->setCellValue('F3', "Sisa Hutang");

    	$i = 4;
    	$last_supplier_name = '';
    	foreach($data as $row){
    		$ccode = $last_supplier_name == $row['supplier_name'] ? '' : $row['supplier_name'];
    		$sheet->setCellValue('A'.$i, $ccode); 
    		$sheet->setCellValue('B'.$i, $row['hd_purchase_date']); 
    		$sheet->setCellValue('C'.$i, $row['payment_debt_date']);
    		$sheet->setCellValue('D'.$i, $row['hd_purchase_due_date']);
    		$sheet->setCellValue('E'.$i, $row['hd_purchase_total']);
    		$sheet->setCellValue('F'.$i, $row['hd_purchase_remaining_debt']);
    		$i++;
    		$last_supplier_name = $row['supplier_name'];
    	}

    	$sheet->getColumnDimension('A')->setWidth(25); 
    	$sheet->getColumnDimension('B')->setWidth(35); 
    	$sheet->getColumnDimension('C')->setWidth(35);
    	$sheet->getColumnDimension('D')->setWidth(35); 
    	$sheet->getColumnDimension('E')->setWidth(35); 
    	$sheet->getColumnDimension('F')->setWidth(35);

	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    //$sheet->getDefaultRowDimension()->setRowHeight(-1);
	    // Set orientasi kertas jadi LANDSCAPE


    	$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
	    // Set judul file excel nya
    	$sheet->setTitle("Excell");

    	ob_end_clean();
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename="laporanPendingHutang_' .date('Y-m-d') . '.xlsx"');
    	header('Cache-Control: max-age=0');

    	$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    	$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
    	exit($xlsxWriter->save('php://output'));
    }

    public function repayment_view()
    {
    	$this->check_auth();
    	$customer_list = $this->master_model->customer_list();
    	$this->load->view('Pages/Report/report_repayment', $customer_list);
    }

    public function repayment_pdf()
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

    	$data['data'] = $this->report_model->get_repayment($start_date, $end_date, $customer_id);
    	$htmlView   = $this->load->view('Pages/Report/report_repayment_pdf', $data, true);
    	$dompdf = new Dompdf();
    	$dompdf->loadHtml($htmlView);
    	$dompdf->setPaper('A4', 'landscape');
    	$dompdf->render();
    	$dompdf->stream('daftar_po.pdf', array("Attachment" => false));
    	exit();
    }


    public function repayment_excell()
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

    	$data = $this->report_model->get_repayment($start_date, $end_date, $customer_id);

    	$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    	$sheet = $excel->getActiveSheet();

		$sheet->setCellValue('A1', "Laporan Pembayaran Hutang"); // Set kolom A1 dengan tulisan "DATA SISWA"
    	$sheet->mergeCells('A1:K1'); // Set Merge Cell pada kolom A1 sampai E1
    	$sheet->getStyle('A1')->getFont()->setBold(true);
    	$sheet->getStyle('A3:K3')->getFont()->setBold(true);

    	$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    	$sheet->getStyle('A3:K3')->getAlignment()->setHorizontal('center');

    	// Buat header tabel nya pada baris ke 3
    	$sheet->setCellValue('A3', "No Transaksi"); 
    	$sheet->setCellValue('B3', "Customer"); 
    	$sheet->setCellValue('C3', "Tgl Pembayaran"); 
    	$sheet->setCellValue('D3', "Pembayaran");
    	$sheet->setCellValue('E3', "Total Bayar");
    	$sheet->setCellValue('F3', "Jumlah Nota");
    	$sheet->setCellValue('G3', "No Penjualan");
    	$sheet->setCellValue('H3', "Potongan");
    	$sheet->setCellValue('I3', "Nominal Bayar");
    	$sheet->setCellValue('J3', "Nilai Retur");
    	$sheet->setCellValue('K3', "Sisa Hutang");

    	$i = 4;
    	$last_receivable_invoice = '';
    	foreach($data as $row){
    		$ccode = $last_receivable_invoice == $row['payment_receivable_invoice'] ? '' : $row['payment_receivable_invoice'];
    		$sheet->setCellValue('A'.$i, $ccode); 
    		$sheet->setCellValue('B'.$i, $row['customer_name']); 
    		$sheet->setCellValue('C'.$i, $row['payment_receivable_date']);
    		$sheet->setCellValue('D'.$i, $row['payment_name']);
    		$sheet->setCellValue('E'.$i, $row['payment_receivable_total_invoice']);
    		$sheet->setCellValue('F'.$i, $row['payment_receivable_total_pay']);
    		$sheet->setCellValue('G'.$i, $row['hd_sales_invoice']);
    		$sheet->setCellValue('H'.$i, $row['dt_payment_receivable_discount']);
    		$sheet->setCellValue('I'.$i, $row['dt_payment_receivable_nominal']);
    		$sheet->setCellValue('J'.$i, $row['dt_payment_receivable_retur']);
    		$sheet->setCellValue('K'.$i, $row['dt_payment_receivable_remaining']);
    		$i++;
    		$last_receivable_invoice = $row['payment_receivable_invoice'];
    	}

    	$sheet->getColumnDimension('A')->setWidth(25); 
    	$sheet->getColumnDimension('B')->setWidth(35); 
    	$sheet->getColumnDimension('C')->setWidth(35);
    	$sheet->getColumnDimension('D')->setWidth(35); 
    	$sheet->getColumnDimension('E')->setWidth(35); 
    	$sheet->getColumnDimension('F')->setWidth(35);
    	$sheet->getColumnDimension('G')->setWidth(35); 
    	$sheet->getColumnDimension('H')->setWidth(35); 
    	$sheet->getColumnDimension('I')->setWidth(35);
    	$sheet->getColumnDimension('J')->setWidth(35);
    	$sheet->getColumnDimension('K')->setWidth(35);

	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    //$sheet->getDefaultRowDimension()->setRowHeight(-1);
	    // Set orientasi kertas jadi LANDSCAPE


    	$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
	    // Set judul file excel nya
    	$sheet->setTitle("Excell");

    	ob_end_clean();
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename="laporanPiutang_' .date('Y-m-d') . '.xlsx"');
    	header('Cache-Control: max-age=0');

    	$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    	$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
    	exit($xlsxWriter->save('php://output'));
    }


    public function repayment_pending_view()
    {
    	$this->check_auth();
    	$customer_list['customer_list'] = $this->master_model->customer_list();
    	$this->load->view('Pages/Report/report_repayment_pending', $customer_list);
    }

    public function repayment_pending_pdf()
    {
    	$this->check_auth();
    	$customer_id = $this->input->get('customer_id');

    	$data['data'] = $this->report_model->get_repayment_pending($customer_id);

    	$htmlView   = $this->load->view('Pages/Report/report_pending_repayment_pdf', $data, true);
    	$dompdf = new Dompdf();
    	$dompdf->loadHtml($htmlView);
    	$dompdf->setPaper('A4', 'landscape');
    	$dompdf->render();
    	$dompdf->stream('daftar_debt.pdf', array("Attachment" => false));
    	exit();
    }


    public function repayment_pending_excell()
    {
    	$this->check_auth();

    	$customer_id = $this->input->get('customer_id');
    	$data = $this->report_model->get_repayment_pending_excell($customer_id);

    	$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    	$sheet = $excel->getActiveSheet();

		$sheet->setCellValue('A1', "Laporan Pembayaran Piutang"); // Set kolom A1 dengan tulisan "DATA SISWA"
    	$sheet->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai E1
    	$sheet->getStyle('A1')->getFont()->setBold(true);
    	$sheet->getStyle('A3:F3')->getFont()->setBold(true);

    	$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    	$sheet->getStyle('A3:F3')->getAlignment()->setHorizontal('center');

    	// Buat header tabel nya pada baris ke 3
    	
    	$sheet->setCellValue('A3', "Customer"); 
    	$sheet->setCellValue('B3', "No Penjualan"); 
    	$sheet->setCellValue('C3', "Tgl Penjualan"); 
    	$sheet->setCellValue('D3', "Jt Tempo");
    	$sheet->setCellValue('E3', "Total Nota");
    	$sheet->setCellValue('F3', "Sisa Hutang");

    	$i = 4;
    	$last_customer_name = '';
    	foreach($data as $row){
    		$ccode = $customer_name == $row['customer_name'] ? '' : $row['customer_name'];
    		$sheet->setCellValue('A'.$i, $ccode); 
    		$sheet->setCellValue('B'.$i, $row['hd_sales_date']); 
    		$sheet->setCellValue('C'.$i, $row['payment_receivable_date']);
    		$sheet->setCellValue('D'.$i, $row['hd_sales_due_date']);
    		$sheet->setCellValue('E'.$i, $row['hd_sales_total']);
    		$sheet->setCellValue('F'.$i, $row['hd_sales_remaining_debt']);
    		$i++;
    		$last_customer_name = $row['customer_name'];
    	}

    	$sheet->getColumnDimension('A')->setWidth(25); 
    	$sheet->getColumnDimension('B')->setWidth(35); 
    	$sheet->getColumnDimension('C')->setWidth(35);
    	$sheet->getColumnDimension('D')->setWidth(35); 
    	$sheet->getColumnDimension('E')->setWidth(35); 
    	$sheet->getColumnDimension('F')->setWidth(35);

	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    //$sheet->getDefaultRowDimension()->setRowHeight(-1);
	    // Set orientasi kertas jadi LANDSCAPE


    	$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
	    // Set judul file excel nya
    	$sheet->setTitle("Excell");

    	ob_end_clean();
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename="laporanPendingPiutang_' .date('Y-m-d') . '.xlsx"');
    	header('Cache-Control: max-age=0');

    	$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    	$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
    	exit($xlsxWriter->save('php://output'));
    }


}

?>