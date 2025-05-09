<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <style type="text/css">
    body{
        margin: 0 !important;
        padding: 0 !important;
    }
    .headline{
        text-align: center;
        border-bottom: double;
    }

    table, td, th {  
        border: 1px solid #000;
        text-align: left;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        padding: 5px;
    }

    th{
        background-color: #D3D0C8;
        text-align: center;
    }

    td{
       font-size: 14px;
   }

   @page { margin: 10px; }
   body { margin: 10px; }

</style>
</head>
<body>
    <div class="container">
        <h2 class="headline">Laporan Pembayaran Piutang</h2>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>No Invoice Sales</th>
                    <th>Tanggal</th>
                    <th>Qty Jual</th>
                    <th>Stok Setelah Jual</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($data as $row){ 
                    ?>
                    <tr>
                        <td><?php echo $row['item_name']; ?></td>
                        <td><?php echo $row['report_minus_sales_invoice']; ?> </td>
                        <td><?php echo $row['report_minus_sales_date']; ?></td>
                        <td><?php echo $row['report_minus_sales_qty']; ?> </td>
                        <td> -<?php echo $row['report_minus_sales_qty'] - $row['report_minus_sales_before_qty']; ?></td>
                    </tr>
                    <?php 
                } 
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>