<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap4.css">
    <style type="text/css">
        body{
            margin: 0;
            font-size: 14px;
        }
        h5{
            font-size: 16px;
        }
        @page {
            size: A4;
            margin: 0;
        }
        @media print {
            html, body {
                width: 210mm;
                height: 297mm;
            }
            footer {page-break-after: always;}
        }
    </style>
    <script type="text/javascript">
        //window.print();
    </script>
</head>
<body>
    <div class="containers">
        <div class="row" style="">
            <?php foreach($catalog_pdf as $row){ ?>
                <div class="col-sm-4" style="margin-bottom: 5px;">
                    <div class="card" style="min-height: 420px; overflow-wrap: break-word;">
                        <div class="card-body" style="text-align:center;" >
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="<?php echo base_url(); ?>dist/img/logo.png" width="100%">
                                </div>
                                <div class="col-md-6">
                                    <?php echo $row->item_barcode ?>
                                    <br />
                                    <?php
                                    $item_code = $row->item_barcode;
                                    $barcode = generate_barcode($item_code, 'AUTO'); 
                                    $ubarcode = str_replace('svg width="300"', 'svg width="300"', $barcode); 
                                    ?>
                                    <img src="data:image/svg+xml;base64,<?= base64_encode($ubarcode)  ?>" width="50%"/>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 50px; border-bottom: 1px solid #000000;">
                                <div class="col-md-12"><h2>Rp. <?php echo number_format($row->item_price_1); ?></h2></div>
                            </div>

                            <div class="row" style="margin-top: 10px; height: 140px;">
                                <div class="col-md-12">
                                    <p style="font-size:15px; text-align: left;" >Product Name </p>
                                    <h2 style="font-size: 20px;"><?php echo $row->item_name ?></h2>
                                </div>
                            </div>
                            <div class="row" style="margin-top:10px; height: 80px; border-top: 1px solid #000000">
                                <div class="col-md-6" style="border-right: 1px solid #000000;">
                                    <p style="font-size:15px; text-align: left;" >Meterial </p>
                                </div>
                                <div class="col-md-6">
                                    <p style="font-size:15px; text-align: left;" >Finishing </p>
                                </div>
                            </div>
                        <?php /*
                        <h5 class="card-title" style="margin-top: 10px;"><?php echo $row->item_name ?></h5>
                   
                        <table width="100%">
                            <tr>
                                <td>Barcode</td>
                                <td>:</td>
                                <td style="text-align:left;"><?php echo $row->item_barcode ?></td>
                            </tr>
                            <tr>
                                <td>Harga</td>
                                <td>:</td>
                                <td style="text-align:left;">Rp. <?php echo number_format($row->item_price_1) ?></td>
                            </tr>
                            <tr>
                                <td>Kategori</td>
                                <td>:</td>
                                <td style="text-align:left;"><?php echo $row->category_name ?></td>
                            </tr>
                            <tr>
                                <td>Brand</td>
                                <td>:</td>
                                <td style="text-align:left;"><?php echo $row->brand_name ?></td>
                            </tr>
                            <tr>
                                <td>Barcode Image</td>
                                <td>:</td>
                                <?php $barcode = generate_barcode('ASDASD', 'AUTO'); ?>
                                <?php $ubarcode = str_replace('svg width="95"', 'svg width="80"', $barcode); ?>
                                <td><img src="data:image/svg+xml;base64,<?= base64_encode($ubarcode)  ?>" /></td>
                            </tr>
                        </table>
                        */ ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>