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
        <div class="row">
            <?php foreach($catalog_pdf as $row){ ?>
                <div class="col-sm-4 " style="margin-bottom: 15px;">
                    <div class="card" style="min-height: 460px; overflow-wrap: break-word;">
                        <div class="card-body" style="text-align:center;">

                            <?php 
                            $image = 'http://[::1]/furniture/assets/products/'.$row->item_image;
                            if (file_exists($image)) {
                                echo '<img src="http://[::1]/furniture/assets/products/<?php echo $row->item_image ?>" width="100%" style="text-align: center;">';
                            }else{
                             echo '<img src="http://[::1]/furniture/assets/products/default.png" width="100%" style="text-align: center;">';
                         }
                         ?>

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
                                <td><img src="<?php echo base_url();?>/barcode/generate_barcode"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
</div>
</body>
</html>