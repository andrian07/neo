<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Faktur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style type="text/css" media="all">
        body { color: #000; padding: 20px;}

        .header-title p{
            font-size: 1em; 

        }

        .header-table-title td{
            font-size: 15px;
        }

        #container-footer p{
            font-size: 15px;
            margin: 0;
        }
        #wrapper { max-width: 1100px; margin: 0 auto;}
        .btn { border-radius: 0; margin-bottom: 5px;}

        .bootbox .modal-footer { border-top: 0; text-align: center; }

        h3 { margin: 5px 0; }

        .order_barcodes img { float: none !important; margin-top: 5px;}

        .center-store-name{
            text-align: center;
        }
        .center-store-name{
            text-align: left;
        }

        td.no-border.center-store-name {
            width: 260px;
        }   

        td.no-border.center-store-name.invoice-number {
            width: 200px;
        }

        #wrapper {
            max-width: 1100px;
            margin: 0 auto;
        }
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }
        .header-table{
            border-bottom: 1px solid ;
            border-top: 1px solid  !important;
        }
        .right{
            text-align: right;
        }
        .left{
            text-align: left;
        }
        .center{
            text-align: center;
        }

        td {
            font-size: 13px;
        }

        .total-table{
            border-top: 1px solid  !important;
        }
        .body-table{
            min-height: 50px;
            width: 100%;
        }
        .sign{
            padding-top: 70px !important;
        }
        .ttd p{
            display: inline;
        }
        .ttd_word{
            margin-right: 20%;
        }
        .ttd_word_titik{
            margin-right: 8%;
        }
        .ttd_word_supir{
            margin-right: 20%;
        }
        .ttd_word_supir_titik{
            margin-right: 8%;
        }
        .sign-border{
            padding-top: 25px !important;
        }
        .table{
            margin-bottom: 0px;
        }
        p{
            font-size: 13px;
        }
        h3{
            font-size: 20px;
        }
        h4{
            font-size: 24px;
        }
        .invoice-number p{
            margin-left: 28%;
        }
        .footer-table-inv td{
            font-size: 16px;
        }
        #container-footer{width:100%;}
        #left{float:left;width:25%;}
        #right{float:right;width:35%;}
        #center{margin:0 auto;width:35%;}
           /* @media print {
                .no-print { display: none; }
                #wrapper { max-width: 1100px; width: 100%; min-width: 250px; margin: 0 auto; }
                .no-border { border: none !important; }
                table tfoot { display: table-row-group; }
            }*/
        </style>
    </head>

    <body>
        <div id="wrapper">
            <div id="receiptData">
                <div class="no-print">
                </div>
                <div id="receipt-data">
                    <div style="clear:both;"></div>
                    <?php foreach($data['get_detail_sales_header'] as $row){ ?>
                        <div class="row">
                            <div class="col-md-4" style="padding-top:20px;">
                                <div class="header-title">
                                    <div class="row">
                                        <div class="col-md-4">No. Order</div>
                                        <div class="col-md-8">: <?php echo $row->hd_sales_invoice; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Tanggal</div>
                                        <div class="col-md-8">: <?php $date = date_create($row->hd_sales_date); echo date_format($date,"d-M-Y"); ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Sales</div>
                                        <div class="col-md-8">: <?php echo $row->sales_name; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Pembayaran</div>
                                        <div class="col-md-8">: <?php echo $row->payment_name; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Notes</div>
                                        <div class="col-md-8">: <?php echo $row->hd_sales_remark; ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" style="text-align:center;">
                                <div class="header-title">
                                    <img src="<?php echo base_url(); ?>dist/img/logo-black.png" width="25%" /> <br />
                                    <img src="<?php echo base_url(); ?>dist/img/ig-logo.png" width="5%" /> neofurnituree
                                    <h2 style="font-size: 25px; margin-top:-2px;">NOTA PENJUALAN</h2>
                                    <P style="font-size: 14px; margin-top:-10px;">Jl. Desa Kapur, Ruko Bhayangkara Asri 2, no. 2-4</P>
                                </div>
                            </div>
                            <div class="col-md-4" style="padding:0 !important;">
                                <div class="header-title">
                                    <div class="row">
                                        <div class="col-md-4">Nama</div>
                                        <div class="col-md-8">: <?php echo $row->customer_name; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">No. HP</div>
                                        <div class="col-md-8">: <?php echo $row->hd_sales_phone; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Alamat</div>
                                        <div class="col-md-8">: <?php echo $row->hd_sales_address; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Tgl Kirim</div>
                                        <div class="col-md-8">: <?php $date = date_create($row->hd_sales_send_date); echo date_format($date,"d-M-Y"); ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Pengiriman</div>
                                        <div class="col-md-8">: <?php echo $row->hd_sales_ekspedisi; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <table width="100%" class="header-table-title" style="border-top:1px #000 solid; border-collapse: collapse; width: 100%; margin-left: -10px;">
                        <tbody style="min-height: 300px;display: block;">
                            <tr>
                                <td width="40%" style="border-bottom: 1px #000 solid;">Nama Produk</td>
                                <td width="15%" style="border-bottom: 1px #000 solid;">Harga</td>
                                <td width="13%" style="border-bottom: 1px #000 solid;">Qty</td>
                                <td width="13%" style="border-bottom: 1px #000 solid;">Diskon</td>
                                <td width="50%" style="border-bottom: 1px #000 solid;">Jumlah</td>
                                <td width="1%"></td>
                            </tr>
                            <?php foreach ($data['get_detail_sales_detail'] as $row) { ?>
                                <tr style="height:5px;">
                                    <td class="no-border"><?php echo $row->item_name; ?></td>
                                    <td class="no-border"><?php echo 'Rp. '.number_format($row->dt_sales_price); ?></td>
                                    <td class="no-border"><?php echo $row->dt_sales_qty; ?></td>
                                    <td class="no-border"><?php echo 'Rp. '.number_format($row->dt_sales_discount); ?></td>
                                    <td class="no-border"><?php echo 'Rp. '.number_format($row->dt_sales_total); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <div class="row" style="border-top:2px double #000; padding-top: 10px;">
                        <div class="col-md-6">
                            <ul style="line-height: 12px;"> 
                                <li style="font-size: 11px; color:red;">Barang yang sudah dibeli tidak dapat dikembalikan, kecuali ada perjanjian terlebih dahulu </li>
                                <li style="font-size: 11px; color:red;">Semua pesanan tidak dapat dibatalkan tanpa alasan apapun</li>
                                <li style="font-size: 11px; color:red;">Setuju membeli berarti setuju dengan aturan toko</li>
                            </ul>
                            <div class="row" style="margin-top: -10px;">
                                <div class="col-md-8">
                                    <table>
                                        <tr style="line-height: 14px;"><td colspan="3">Rekening Eric Edward</td></tr>
                                        <tr style="line-height: 14px;"><td>BCA</td><td>:</td><td>8855-015-885</td></tr>
                                        <tr style="line-height: 14px;"><td>BRI</td><td>:</td><td>0716-038-410</td></tr>
                                        <tr style="line-height: 14px;"><td>KALBAR</td><td>:</td><td>1152-6784-83</td></tr>
                                        <tr style="line-height: 14px;"><td>MANDIRI</td><td>:</td><td>14600-5501-5882</td></tr>
                                        <tr style="line-height: 14px;"><td>BRI</td><td>:</td><td>2061-01-005012-50-9</td></tr>
                                    </table>
                                </div>
                                <div class="col-md-4" style="text-align:center;">
                                    <img src="<?php echo base_url(); ?>dist/img/qrcode.png" width="50%" />
                                    <p>Scan Di Sini Untuk Info</p>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-3">
                            <table width="100%">
                                <tr>
                                    <td style="text-align:center; font-size: 17px; width: 40%;">Penerima, </td>
                                    <td style="text-align:center; font-size: 17px; width: 10%;"></td>
                                    <td style="text-align:center; font-size: 17px; width: 40%;">Hormat Kami,</td>
                                </tr>
                                <tr>
                                    <td style="text-align:center; border-bottom:1px solid #000;"></td>
                                    <td style="text-align:center;"></td>
                                    <td style="text-align:center; border-bottom:1px solid #000;"><img src="<?php echo base_url(); ?>dist/img/logo.png" width="100%" /></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-3">
                            <table width="100%" class="footer-table-inv">
                                <?php foreach ($data['get_detail_sales_header'] as $row) { ?>
                                    <tr>
                                        <td style="text-align:right; font-weight: 600;">Subtotal</td>
                                        <td>:</td>
                                        <td style="text-align:right;"><?php echo 'Rp. '.number_format($row->hd_sales_subtotal); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:right; font-weight: 600;">Ongkir</td>
                                        <td>:</td>
                                        <td style="text-align:right;"><?php echo 'Rp. '.number_format($row->hd_sales_ongkir); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:right; font-weight: 600;">Disc</td>
                                        <td>:</td>
                                        <td style="text-align:right;"><?php echo 'Rp. '.number_format($row->hd_sales_discount_nota); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:right; font-weight: 600; border-bottom:1px solid #000;">PPN</td>
                                        <td style="border-bottom:1px solid #000;">:</td>
                                        <td style="text-align:right; border-bottom:1px solid #000;"><?php echo 'Rp. '.number_format($row->hd_sales_ppn); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:right; font-weight: 600; font-weight: 800;">Total</td>
                                        <td>:</td>
                                        <td style="text-align:right;"><?php echo 'Rp. '.number_format($row->hd_sales_total); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:right; font-weight: 600;">DP</td>
                                        <td>:</td>
                                        <td style="text-align:right;"><?php echo 'Rp. '.number_format($row->hd_sales_dp); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:right; font-weight: 600; font-weight: 800;">Sisa</td>
                                        <td>:</td>
                                        <td style="text-align:right;"><?php echo 'Rp. '.number_format($row->hd_sales_remaining_debt); ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>

                    <!--
                    <div id="container-footer" style="border-top:2px double #000;">
                        <div id="left">

                        </div>
                        <div id="right">
                            <table>
                                <tr>
                                    <td>Subtotal</td>
                                    <td>:</td>
                                    <td>1231231231</td>
                                </tr>
                            </table>
                        </div>
                        <div id="center">
                            <table width="80%" style="margin-top:50px;">
                                <tr>
                                    <td width="50%">Sales,</td>
                                    <td width="40%">Supir,</td>
                                    <td width="40%">Penerima,</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    -->

                </div>
                <div style="clear:both;"></div>
            </div></div>

        </div>
    </div>
</div>

</body>
</html>

