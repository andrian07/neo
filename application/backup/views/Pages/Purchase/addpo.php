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
          <h1>Tambah PO</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Tambah PO</li>
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
      </div>
    </div>

    <div class="card">

      <div class="card-body">
        <div class="row well well-sm">

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

          <div class="col-sm-2">
            <div class="form-group">
              <label>Satuan</label>
              <input id="temp_qty" name="temp_qty" type="number" class="form-control text-right">
            </div>
          </div>


          <div class="col-sm-3">
            <div class="form-group">
              <label>Total</label>
              <input id="temp_total" name="temp_total" type="text" class="form-control text-right curency2" value="0" readonly="">
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
              <th>Kode</th>
              <th>Nama</th>
              <th>Harga</th>
              <th>Qty</th>
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
              <label for="footer_sub_total" class="col-sm-7 col-form-label text-right:">Sub Total:</label>
              <div class="col-sm-5">
                <input id="footer_sub_total" name="footer_sub_total" type="text" class="form-control text-right curency3" value="0" readonly="">
              </div>
            </div>

            <div class="form-group row">
              <label for="footer_total_ppn" class="col-sm-7 col-form-label text-right:">PPN 11% :</label>
              <div class="col-sm-4">
                <input id="footer_total_ppn" name="footer_total_ppn" type="text" class="form-control text-right curency4" value="0" readonly="">
              </div>
              <div class="col-sm-1">
                <div class="icheck-primary d-inline" >
                  <input type="checkbox" id="ppn_check" style="width:25px; height:25px; margin-top: 7px;">
                  <label for="ppn_check">
                  </label>
                </div>
              </div>
            </div>

            <div class="form-group row" style="margin-top: -25px;">
              <label for="footer_total_invoice" class="col-sm-7 col-form-label text-right:">Grand Total :</label>
              <div class="col-sm-5">
                <input id="footer_total_invoice" name="footer_total_invoice" type="text" class="form-control text-right curency5" value="0" readonly="">
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

  let temp_total = new AutoNumeric('#temp_total', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });
  
  let footer_sub_total = new AutoNumeric('#footer_sub_total', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let footer_total_invoice = new AutoNumeric('#footer_total_invoice', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let footer_total_ppn = new AutoNumeric('#footer_total_ppn', {
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
        url: "<?php echo base_url(); ?>Purchase/clear_temp_po",
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
      var supplier_id                         = $("#supplier_id").val();
      var footer_sub_total_submit             = footer_sub_total.get();
      var footer_total_ppn_submit             = footer_total_ppn.get();
      var footer_total_invoice_submit         = footer_total_invoice.get();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Purchase/save_po",
        dataType: "json",
        data: {supplier_id:supplier_id, footer_sub_total_submit:footer_sub_total_submit, footer_total_ppn_submit:footer_total_ppn_submit, footer_total_invoice_submit:footer_total_invoice_submit},
        success : function(data){
          if (data.code == "200"){
            window.location.href = "<?php echo base_url(); ?>Purchase/po";
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
      var item_id_temp             = $("#item_id").val();
      var temp_price_temp          = temp_price.get();
      var qty_temp                 = $("#temp_qty").val();
      var total_price_temp         = temp_total.get();
      var supplier_id              = $("#supplier_id").val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Purchase/insert_temp_po",
        dataType: "json",
        data: {item_id_temp:item_id_temp, temp_price_temp:temp_price_temp, qty_temp:qty_temp, total_price_temp:total_price_temp, supplier_id:supplier_id},
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
      url: "<?php echo base_url(); ?>Purchase/get_temp_po",
      dataType: "json",
      data: {},
      success : function(data){
        let text_temp = "";
        for (let i = 0; i < data.length; i++) {
          text_temp += '<tr><td>'+data[i].item_barcode+'</td><td width="50%">'+data[i].item_name+'</td><td>'+new Intl.NumberFormat().format(data[i].product_price)+'</td><td>'+data[i].po_qty+'</td><td>'+new Intl.NumberFormat().format(data[i].po_total)+'</td><td><button class="btn btn-sm btn-warning" style="margin-right:5px;" onclick="edit('+data[i].item_id+')"><i class="fas fa-edit"></i></button><button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" data-title="Hapus" data-original-title="" title="" onclick="deletes('+data[i].item_id+', '+data[i].item_barcode+')"><i class="fas fa-trash"></i></button></td></tr>';
        }
        if(data.length > 0){
          $("#supplier_id").val(data[0].supplier_id).trigger('change');
          // $('#supplier_id').prop('disabled', false);
          $('#supplier_id').prop('disabled', true);
        }else{
          $("#supplier_id").val("").trigger('change');
          $('#supplier_id').prop('disabled', false);
        }
        document.getElementById("temp").innerHTML = text_temp;
      }
    });
  }

  function get_total_footer(){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/get_total_footer_po",
      dataType: "json",
      data: {},
      success : function(data){
        if (data.code == "200"){
         footer_sub_total.set(data.result[0]['po_total']);
         footer_total_invoice.set(data.result[0]['po_total']);
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

  $('#product_name').autocomplete({ 
    minLength: 2,
    source: function(req, add) {
      $.ajax({
        url: '<?php echo base_url(); ?>/Purchase/search_product_supplier?sup='+$('#supplier_id').val(),
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
      $('#temp_qty').val(0);
      temp_total.set(0);
    },
  });

  $("#temp_qty").on("input", function(){
    let temp_qty = $('#temp_qty').val();
    let temp_price = $('#temp_price').val();
    if($('#product_name').val() == null){
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Silahkan Input Product Terlebih Dahulu',
      });
    }else{
      let prices =  AutoNumeric.getAutoNumericElement('#temp_price').get();
      let total_cal = temp_qty * prices;
      temp_total.set(total_cal);
    }
  });


  $("#ppn_check").change(function() {
    //let footer_sub_total_val = AutoNumeric.getAutoNumericElement('#footer_sub_total').get();
    let footer_sub_total_val = footer_sub_total.get();
    if(this.checked) {
      let footer_total_ppn_val = footer_sub_total_val * 11 / 100;
      footer_total_ppn.set(footer_total_ppn_val);
      let footer_total_invoice_val = footer_total_ppn_val + Number(footer_sub_total_val);
      footer_total_invoice.set(footer_total_invoice_val);
    }else{
      footer_total_ppn.set(0);
      footer_total_invoice.set(footer_sub_total_val);
    }
  });

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
          url: "<?php echo base_url(); ?>Purchase/delete_temp_po",
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
    var item_id_temp             = $("#item_id").val();
    var temp_price_temp          = temp_price.get();
    var qty_temp                 = $("#temp_qty").val();
    var total_price_temp         = temp_total.get();
    var supplier_id              = $("#supplier_id").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/get_edit_temp",
      dataType: "json",
      data: {id:id},
      success : function(data){
        if (data.code == "200"){
         console.log(data);
         $('#item_id').val(data.result[0]['product_id']);
         $('#product_name').val(data.result[0]['item_name']);
         temp_price.set(data.result[0]['product_price']);
         $('#temp_qty').val(data.result[0]['po_qty']);
         temp_total.set(data.result[0]['po_total']);
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
    temp_total.set(0);
    footer_total_ppn.set(0);
    $("#ppn_check").prop("checked", false);
  }
  
</script>


