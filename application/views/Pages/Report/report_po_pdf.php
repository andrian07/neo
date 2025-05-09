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
        <h2 class="headline">Laporan PO</h2>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>No Po</th>
                    <th>Tanggal</th>
                    <th>Kode Item</th>
                    <th>Item</th>
                    <th>Supplier</th>
                    <th>Gol</th>
                    <th>Qty</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $last_po_invoice = '';
                foreach($data as $row){ 
                    $ccode = $last_po_invoice == $row['hd_po_invoice'] ? '' : $row['hd_po_invoice'];
                    ?>
                    <tr>
                        <td><?php echo $ccode; ?></td>
                        <td><?php echo $row['hd_po_date']; ?> </td>
                        <td><?php echo $row['item_barcode']; ?></td>
                        <td><?php echo $row['item_name']; ?> </td>
                        <td><?php echo $row['supplier_name']; ?></td>
                        <td><?php if($row['hd_po_gol'] == 'Y'){ echo 'PPN'; }else{ echo 'NON PPN';} ?></td>
                        <td><?php echo $row['dt_po_qty']; ?></td>
                        <td><?php echo 'Rp. '.number_format($row['dt_po_total']); ?></td>
                    </tr>
                    <?php 
                    $last_po_invoice = $row['hd_po_invoice'];
                } 
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>