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
        <h2 class="headline">Laporan Kartu Stok</h2>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>Kode Produk</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Stok Awal</th>
                    <th>Stok Akhir</th>
                    <th>Perubahan Stok</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($stock_card_pdf as $row){ 
                    ?>
                    <tr>
                        <td><?php echo $row['item_barcode']; ?></td>
                        <td><?php echo $row['item_name']; ?> </td>
                        <td><?php echo $row['stock_movement_date']; ?></td>
                        <td><?php echo $row['stock_movement_before_stock']; ?> </td>
                        <td><?php echo $row['stock_movement_new_stock']; ?> </td>
                        <td><?php  if($row['stock_movement_calculate'] == 'Plus'){echo '+'; }else{ echo '-';} ?>  <?php echo $row['stock_movement_qty']; ?></td>
                        <td><?php echo $row['stock_movement_desc']; ?></td>
                    </tr>
                    <?php 
                } 
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>