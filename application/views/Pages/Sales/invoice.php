<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!doctype html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Faktur</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <style type="text/css" media="all">
            body { color: #000; }
            
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
                    <div class="row">
                        <div class="col-md-6" style="width: 10%;">
                            <div class="header-title" style="text-align: left;">
                                <img src="<?php echo base_url(); ?>dist/img/logo.png" width="300%" style="margin-top: 30px;">
                            </div>
                        </div>
                        <div class="col-md-6" style="width: 70%;">
                            <div class="header-title" style="text-align: center; ">
                                <h2 style="text-decoration: underline;">Nota Penjualan</h2>
                                <p>Homeliving Furniture & Electronics <br />
                                Jl. Raya Desa Kapur Desa Mekar No 1- 3 <br />
                                0812-508-6166 / IG: Homeliving</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <table width="100%" class="header-table-title" style="border-top:3px #000 double;"> 
                            <?php foreach($data['get_detail_sales_header'] as $row){ ?>
                                <tr>
                                    <td width="10%">No. Order</td><td>:</td><td width="60%;"><?php echo $row->hd_sales_invoice; ?></td><td>Nama</td><td>:</td><td width="30%"><?php echo $row->customer_name; ?></td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td><td>:</td><td><?php $date = date_create($row->hd_sales_date); echo date_format($date,"d-M-Y"); ?></td><td>No Hp</td><td>:</td><td><?php echo $row->hd_sales_phone; ?></td>
                                </tr>
                                <tr>
                                    <td>Sales</td><td>:</td><td><?php echo $row->sales_name; ?></td><td rowspan="2">Alamat</td><td rowspan="2">:</td><td rowspan="2"><?php echo $row->hd_sales_address; ?></td>
                                </tr>
                                <tr>
                                    <td>J.Tempo</td><td>:</td><td><?php $date = date_create($row->hd_sales_due_date); echo date_format($date,"d-M-Y"); ?></td><td></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    
                    <table width="100%" class="header-table-title" style="border-top:1px #000 solid; border-collapse: collapse; width: 100%; margin-top: 10px;margin-left: -10px;">
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
                        <div class="col-md-2">
                            <p>
                                Rekening Eric Edward <br />
                                BCA: 1234567890 <br />
                                BRI: 1234567890 <br />
                                BNI: 1234567890 <br />
                                Mandiri: 1234567890 <br />
                                KalBar: 1234567890 <br />
                                Permata: 1234567890 <br />
                            </p>
                        </div>
                        <div class="col-md-6">
                            <table width="100%" style="height:160px;">
                                <tr>
                                    <td style="text-align:center;">Kasir, </td>
                                    <td style="text-align:center;">Supir, </td>
                                    <td style="text-align:center;">Penerima, </td>
                                    <td style="text-align:center;">Teli, </td>
                                </tr>
                                <tr>
                                    <td style="text-align:center;">-------------</td>
                                    <td style="text-align:center;">-------------</td>
                                    <td style="text-align:center;">-------------</td>
                                    <td style="text-align:center;">-------------</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <table width="100%" class="footer-table-inv">
                                <?php foreach ($data['get_detail_sales_header'] as $row) { ?>
                                <tr>
                                    <td style="text-align:right; font-weight: 600;">Subtotal</td>
                                    <td>:</td>
                                    <td style="text-align:right;"><?php echo 'Rp. '.number_format($row->hd_sales_subtotal); ?></td>
                                </tr>
                                 <tr>
                                    <td style="text-align:right; font-weight: 600;">Disc</td>
                                    <td>:</td>
                                    <td style="text-align:right;"><?php echo 'Rp. '.number_format($row->hd_sales_discount); ?></td>
                                </tr>
                                <tr>
                                    <td style="text-align:right; font-weight: 600;">Total</td>
                                    <td>:</td>
                                    <td style="text-align:right;"><?php echo 'Rp. '.number_format($row->hd_sales_subtotal); ?></td>
                                </tr>
                                <tr>
                                    <td style="text-align:right; font-weight: 600;">DP</td>
                                    <td>:</td>
                                    <td style="text-align:right;"><?php echo 'Rp. '.number_format($row->hd_sales_dp); ?></td>
                                </tr>
                                <tr>
                                    <td style="text-align:right; font-weight: 600;">Sisa Bayar</td>
                                    <td>:</td>
                                    <td style="text-align:right;"><?php echo 'Rp. '.number_format($row->hd_sales_total); ?></td>
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

