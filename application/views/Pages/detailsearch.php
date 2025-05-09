<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>

  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap4.css">
  <style type="text/css">
    .title-detail{
      text-align: right;
    }
    .row {
      --bs-gutter-x: 0 !important;
    }
    body{
      background: #fff;
    }
  </style>
</head>
<body>
  <div class="cards" style="padding:0;">
    <div class="d-flex align-items-left">
      <div>
        <h3 class="fw-bold mb-3">Detail Product</h3>
      </div>
      <div class="ms-md-auto py-2 py-md-0">
      </div>
    </div>
    <div class="card-body" style="padding:0;">
      <?php foreach($get_product_by_id as $row){ ?>
        <div class="row">
          <div class="col-md-5">
            <div class="table-responsive">
              <table class="table table-bordered">
               <tbody>

                <tr>
                  <th scope="col" class="productinfo-text-right">Item Barcode:</th>
                  <td colspan="4"><?php echo $row['item_barcode']; ?></td>
                </tr>
                <tr>
                  <th scope="col" class="productinfo-text-right">Nama Barang:</th>
                  <td colspan="4"><?php echo $row['item_name']; ?></td>
                </tr>
                <tr>
                  <th scope="col" class="productinfo-text-right">Stok:</th>
                  <td colspan="4"><?php echo $row['item_stock']; ?></td>
                </tr>
                <tr>
                  <th scope="col" class="productinfo-text-right">Stok Tidak Terkirim:</th>
                  <td colspan="4"><?php echo $row['item_not_send']; ?></td>
                </tr>
                <tr>
                  <th scope="col" class="productinfo-text-right">Harga Toko:</th>
                  <td colspan="4"><?php echo 'Rp. '.number_format($row['item_price_1']); ?></td>
                </tr>
                <tr>
                  <th scope="col" class="productinfo-text-right">Harga Sosmed:</th>
                  <td colspan="4"><?php echo 'Rp. '.number_format($row['item_price_3']); ?></td>
                </tr>

              </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-1">
        </div>
        <div class="col-md-6">
          <div class="table-responsive">

          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>
</body>

</html>  


