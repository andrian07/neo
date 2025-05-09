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
        <h2 class="headline">Laporan Retur Pembelian</h2>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>No Retur Pembelian</th>
                    <th>Supplier</th>
                    <th>No Pembelian</th>
                    <th>Tanggal</th>
                    <th>Total Retur</th>
                    <th>Jenis Retur</th>
                    <th>Kode Item</th>
                    <th>Item </th>
                    <th>Qty</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $last_retur_purchase_invoice = '';
                foreach($data as $row){ 
                    $ccode = $last_retur_purchase_invoice == $row['hd_retur_purchase_invoice'] ? '' : $row['hd_retur_purchase_invoice'];
                    ?>
                    <tr>
                        <td><?php echo $ccode; ?></td>
                        <td><?php echo $row['supplier_name']; ?> </td>
                        <td><?php echo $row['hd_purchase_invoice']; ?> </td>
                        <td><?php echo $row['hd_retur_date']; ?></td>
                        <td><?php echo 'Rp.'. number_format($row['hd_retur_total_transaction']); ?> </td>
                        <td><?php  if($row['hd_retur_payment'] == 'Ya'){ echo 'Potong Nota'; }else{ echo 'Tidak Potong Nota'; } ?></td>
                        <td><?php echo $row['item_barcode']; ?></td>
                        <td><?php echo $row['item_name']; ?></td>
                        <td><?php echo $row['dt_retur_qty']; ?></td>
                        <td><?php echo 'Rp.'. number_format($row['dt_retur_total']); ?> </td>
                    </tr>
                    <?php 
                    $last_retur_purchase_invoice = $row['hd_retur_purchase_invoice'];
                } 
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>