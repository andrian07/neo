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
        <h2 class="headline">Laporan Penjualan</h2>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Tanggal</th>
                    <th>Jt Tempo</th>
                    <th>Sales</th>
                    <th>Customer</th>
                    <th>Diskon</th>
                    <th>PPN</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $last_sales_invoice = '';
                foreach($data as $row){ 
                    $ccode = $last_sales_invoice == $row['hd_sales_invoice'] ? '' : $row['hd_sales_invoice'];
                    ?>
                    <tr>
                        <td><?php echo $ccode; ?></td>
                        <td><?php echo $row['hd_sales_date']; ?> </td>
                        <td><?php echo $row['hd_sales_due_date']; ?></td>
                        <td><?php echo $row['sales_name']; ?> </td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo 'Rp.'. number_format($row['hd_sales_discount']); ?></td>
                        <td><?php echo 'Rp.'. number_format($row['hd_sales_ppn']); ?></td>
                        <td><?php echo 'Rp.'. number_format($row['hd_sales_total']); ?></td>
                    </tr>
                    <?php 
                    $last_sales_invoice = $row['hd_sales_invoice'];
                } 
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>