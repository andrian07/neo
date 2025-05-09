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
        <h2 class="headline">Laporan Pembelian</h2>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>Kode Supplier</th>
                    <th>Nama Supplier</th>
                    <th>No Pembelian</th>
                    <th>Tanggal</th>
                    <th>Tanggal JT</th>
                    <th>PPN</th>
                    <th>DP</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $last_purchase_invoice = '';
                foreach($data as $row){ 
                    $ccode = $last_purchase_invoice == $row['hd_purchase_invoice'] ? '' : $row['hd_purchase_invoice'];
                    ?>
                    <tr>
                        <td><?php echo $row['supplier_code'];; ?></td>
                        <td><?php echo $row['supplier_name']; ?> </td>
                        <td><?php echo $ccode; ?></td>
                        <td><?php echo $row['hd_purchase_date']; ?> </td>
                        <td><?php echo $row['hd_purchase_due_date']; ?></td>
                        <td><?php echo 'Rp.'. number_format($row['hd_purchase_ppn']); ?></td>
                        <td><?php echo 'Rp.'. number_format($row['hd_purchase_dp']); ?></td>
                        <td><?php echo 'Rp.'. number_format($row['hd_purchase_total']); ?></td>
                    </tr>
                    <?php 
                    $last_purchase_invoice = $row['hd_purchase_invoice'];
                } 
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>