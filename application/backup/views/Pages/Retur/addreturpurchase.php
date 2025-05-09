<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Tambah Retur Pembelian</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Tambah Retur Pembelian</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <div class="form-group row">
          <label class="col-sm-1 text-right label-insert">No Invoice :</label>
          <div class="col-sm-3">
            <input id="purchase_order_invoice" name="purchase_order_invoice" type="text" class="form-control" value="AUTO" readonly="">
            <input id="purchase_order_id" name="purchase_order_id" type="hidden" class="form-control">
          </div>
          <div class="col-md-4"></div>
          <label for="tanggal" class="col-sm-1 text-right label-insert">Tanggal :</label>
          <div class="col-sm-3">
            <input id="purchase_order_date" name="purchase_order_date" type="date" class="form-control" value="<?php echo date("Y-m-d"); ?>" readonly="">
          </div>
        </div>


        <div class="form-group row">
          <label for="supplier_id" class="col-sm-1 text-right label-insert">Supplier :</label>
          <div class="col-sm-3">
            <select class="form-control select2" name="supplier_id" id="supplier_id" >
              <option></option>
              <?php foreach($supplier_list as $row){ ?>
                <option value="<?php echo $row->supplier_id; ?>"><?php echo $row->supplier_name; ?></option>
              <?php  } ?>
            </select>
          </div>
          <div class="col-md-4"></div>
          <label for="user" class="col-sm-1 text-right label-insert">User :</label>
          <div class="col-sm-3">
            <input id="display_user" type="text" class="form-control" value="<?php echo $_SESSION['user_name'] ?>" readonly="">
          </div>
        </div>

        <div class="form-group row">
          <label for="payment_id" class="col-sm-1 text-right label-insert">Potong Nota :</label>
          <div class="col-sm-3">
            <select class="form-control" name="payment_type" id="payment_type" >
              <option value="Tidak">Tidak</option>
              <option value="Ya">Ya</option>
            </select>
          </div>
          <div class="col-md-8"></div>
        </div>

      </div>
    </div>

    <div class="card">

      <div class="card-body">
        <div class="row well well-sm">

          <div class="col-sm-5">
            <div class="form-group">
              <label>No Invoice Pembelian</label>
              <input type="hidden" id="purchase_no" name="purchase_no" class="form-control text-right" required="">
              <input id="purchase_inv" name="purchase_inv" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan No Invoice Pembelian">
            </div>
          </div>

          <div class="col-sm-4">
            <div class="form-group">
              <label>Produk</label>
              
              <input type="hidden" id="item_id" name="item_id" class="form-control text-right" required="">
              <input id="product_name" name="product_name" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan nama produk">
            </div>
          </div>

          <div class="col-sm-2">
            <div class="form-group">
              <label>Harga Beli Per Unit</label>
              <input id="temp_price" name="temp_price" class="form-control text-right curency" value="0" data-parsley-vprice="" required="">
            </div>
          </div>

          <div class="col-md-5">
            
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label>Qty Beli</label>
              <input id="temp_qty" name="temp_qty" type="number" class="form-control text-right" readonly>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="form-group">
              <label>Qty Retur</label>
              <input id="temp_qty_retur" name="temp_qty_retur" type="text" class="form-control text-right" value="0">
            </div>
          </div>


          <div class="col-sm-1" style="padding-right: 62px;">
            <label>&nbsp;</label>
            <div class="form-group">
              <button id="btnadd_temp" class="btn btn-md btn-primary rounded-circle float-right"><i class="fas fa-plus"></i></button>
            </div>
          </div> 
        </div>

        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>No Pembelian</th>
              <th>Nama Produk</th>
              <th>Harga</th>
              <th>Qty Retur</th>
              <th>Total</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="temp">
          </tbody>
        </table>

        <div class="row form-space" style="margin-top: 50px;">
          <div class="col-lg-6">
            <div class="form-group">
              <div class="col-sm-12">

              </div>
            </div>
          </div>

          <div class="col-lg-6 text-right">
            <div class="form-group row">
              <label for="total_retur_inv" class="col-sm-7 col-form-label text-right:">Total:</label>
              <div class="col-sm-5">
                <input id="total_retur_inv" name="total_retur_inv" type="text" class="form-control text-right curency3" value="0" readonly="">
              </div>
            </div>

            

            <div class="form-group row">
              <div class="col-sm-12">
                <button id="btncancel" class="btn btn-danger"><i class="fas fa-times-circle"></i> Batal</button>
                <button id="btnsave" class="btn btn-success button-header-custom-save"><i class="fas fa-save"></i> Simpan</button>
              </div>
            </div>

          </div>


        </div>

      </div>
    </div>

    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php 
require DOC_ROOT_PATH . $this->config->item('footer');
?>

<script type="text/javascript">

  let temp_price = new AutoNumeric('#temp_price', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  
  let total_retur_inv = new AutoNumeric('#total_retur_inv', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });




  get_temp();
  get_total_footer();

  $(document).ready(function() {
    $('#btncancel').click(function(e){
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Retur/clear_temp_retur_purchase",
        dataType: "json",
        data: {},
        success : function(data){
          if (data.code == "200"){
            location.reload();
            Swal.fire('Saved!', '', 'success');
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: data.result,
            })
          }
        }
      });
    });
  });


  $(document).ready(function() {
    $('#btnsave').click(function(e){
      e.preventDefault();
      var supplier_id                   = $("#supplier_id").val();
      var payment_type                  = $("#payment_type").val();
      var total_retur_inv_val           = total_retur_inv.get();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Retur/save_retur_purchase",
        dataType: "json",
        data: {supplier_id:supplier_id, payment_type:payment_type, total_retur_inv:total_retur_inv_val},
        success : function(data){
          if (data.code == "200"){
            window.location.href = "<?php echo base_url(); ?>Retur/returpurchase";
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: data.result,
            })
          }
        }
      });
    });
  });

  $(document).ready(function() {
    $('#btnadd_temp').click(function(e){
      e.preventDefault();
      var supplier_id              = $("#supplier_id").val();
      var retur_purchase_inv       = $("#purchase_inv").val();
      var purchase_no              = $("#purchase_no").val();
      var item_id_temp             = $("#item_id").val();
      var temp_price_temp          = temp_price.get();
      var qty_temp                 = $("#temp_qty").val();
      var temp_qty_retur           = $("#temp_qty_retur").val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Retur/insert_temp_retur_purchase",
        dataType: "json",
        data: {supplier_id:supplier_id, retur_purchase_inv:retur_purchase_inv, purchase_no:purchase_no, item_id_temp:item_id_temp, temp_price_temp:temp_price_temp, qty_temp:qty_temp, temp_qty_retur:temp_qty_retur},
        success : function(data){
          if (data.code == "200"){
            get_temp();
            get_total_footer();
            clear_input();
            Swal.fire('Saved!', '', 'success'); 
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: data.result,
            })
          }
        }
      });
    });
  });

  function get_temp() {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Retur/get_temp_retur_purchase",
      dataType: "json",
      data: {},
      success : function(data){
        let text_temp = "";
        for (let i = 0; i < data.length; i++) {
          text_temp += '<tr><td>'+data[i].retur_purchase_inv+'</td><td width="50%">'+data[i].item_name+'</td><td>'+new Intl.NumberFormat().format(data[i].retur_price)+'</td><td>'+data[i].retur_qty+'</td><td>'+new Intl.NumberFormat().format(data[i].retur_total)+'</td><td><button class="btn btn-sm btn-warning" style="margin-right:5px;" onclick="edit('+data[i].retur_product_id+')"><i class="fas fa-edit"></i></button><button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" data-title="Hapus" data-original-title="" title="" onclick="deletes('+data[i].retur_product_id+', '+data[i].item_barcode+')"><i class="fas fa-trash"></i></button></td></tr>';
        }
        if(data.length > 0){
          console.log(data);
          $("#supplier_id").val(data[0].retur_supplier_id).trigger('change');
          $('#supplier_id').prop('disabled', true);
          $("#purchase_inv").val(data[0].retur_purchase_inv);
          $('#purchase_inv').prop('disabled', true);
          $("#purchase_no").val(data[0].retur_purchase_no);
          $('#purchase_no').prop('disabled', true);
        }else{
          $("#supplier_id").val("").trigger('change');
          $('#supplier_id').prop('disabled', false);
          $("#purchase_inv").val("");
          $('#purchase_inv').prop('disabled', false);
          $("#purchase_no").val(0);
        }
        document.getElementById("temp").innerHTML = text_temp;
      }
    });
  }

  function get_total_footer(){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Retur/get_total_footer_retur_purchase",
      dataType: "json",
      data: {},
      success : function(data){
        if (data.code == "200"){
         total_retur_inv.set(data.result[0]['retur_total']);
       } else {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: data.result,
        })
      }
    }
  });
  }

  $('#purchase_inv').autocomplete({ 
    minLength: 2,
    source: function(req, add) {
      $.ajax({
        url: '<?php echo base_url(); ?>/Retur/search_purchase_invoice_supplier?sup='+$('#supplier_id').val(),
        dataType: 'json',
        type: 'GET',
        data: req,
        success: function(res) {
          if (res.success == true) {
            add(res.data);
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Silahkan Pilih Supplier Terlebih Dahulu',
            });
            $('#purchase_inv').val('');
          }
        },
      });
    },
    select: function(event, ui) {
      $('#purchase_no').val(ui.item.id);
    },
  });

  $('#product_name').autocomplete({ 
    minLength: 2,
    source: function(req, add) {
      $.ajax({
        url: '<?php echo base_url(); ?>/Retur/search_product_purchase_no?purchase_no='+$('#purchase_no').val(),
        dataType: 'json',
        type: 'GET',
        data: req,
        success: function(res) {
          if (res.success == true) {
            add(res.data);
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Silahkan Pilih Supplier Terlebih Dahulu',
            });
            $('#product_name').val('');
          }
        },
      });
    },
    select: function(event, ui) {
      $('#item_id').val(ui.item.id);
      temp_price.set(parseFloat(ui.item.purchase_price));
      $('#temp_qty').val(ui.item.purchase_qty);
    },
  })

  function deletes(id, name){
    Swal.fire({
      title: 'Konfirmasi?',
      text: "Apakah Anda Yakin Menghapus '"+name+"' ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Retur/delete_temp_retur_purchase",
          dataType: "json",
          data: {id:id},
          success : function(data){
            if (data.code == "200"){
              get_temp();
              get_total_footer();
              Swal.fire('Saved!', '', 'success'); 
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.msg,
              })
            }
          }
        });
      }
    })
  }

  function edit(id){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Retur/get_edit_temp_retur_purchase",
      dataType: "json",
      data: {id:id},
      success : function(data){
        if (data.code == "200"){
         $('#purchase_no').val(data.result[0]['retur_purchase_no']);
         $('#purchase_inv').val(data.result[0]['retur_purchase_inv']);
         $('#item_id').val(data.result[0]['item_id']);
         $('#product_name').val(data.result[0]['item_name']);
         temp_price.set(data.result[0]['retur_price']);
         $('#temp_qty').val(data.result[0]['retur_qty_beli']);
         $('#temp_qty_retur').val(data.result[0]['retur_qty']);
       } else {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: data.result,
        })
      }
    }
  });
  }

  function clear_input(){
    $('#item_id').val('');
    $('#product_name').val('');
    temp_price.set(0);
    $('#temp_qty').val(0);
    $('#temp_qty_retur').val(0);
  }
  
</script>


