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
          <h1>Tambah Penjualan</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Tambah Penjualan</li>
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
            <input id="sales_invoice" name="sales_invoice" type="text" class="form-control" value="AUTO" readonly="">
          </div>
          <label class="col-sm-1 text-right label-insert">Payment :</label>
          <div class="col-sm-3">
            <select class="form-control select2" name="payment_id" id="payment_id" >
              <option></option>
              <?php foreach($data['payment_list'] as $row){ ?>
                <option value="<?php echo $row->payment_id; ?>"><?php echo $row->payment_name; ?></option>
              <?php  } ?>
            </select>
          </div>
          <label for="tanggal" class="col-sm-1 text-right label-insert">Tanggal :</label>
          <div class="col-sm-3">
            <input id="sales_date" name="sales_date" type="date" class="form-control" value="<?php echo date("Y-m-d"); ?>" readonly="">
          </div>
        </div>

        <div class="form-group row">
          <label for="no_po" class="col-sm-1 text-right label-insert">Pelanggan :</label>
          <div class="col-sm-2">
            <select class="form-control select2" name="customer_id" id="customer_id" style="width: 260px;">
              <option></option>
              <?php foreach($data['customer_list'] as $row){ ?>
                <option value="<?php echo $row->customer_id; ?>"><?php echo $row->customer_name; ?></option>
              <?php  } ?>
            </select>
          </div>
          <div class="col-md-1" style="text-align: left;;">
            <button class="btn btn-md btn-primary float-right" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i></button>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label>Kode Customer</label>
                      <input type="text" class="form-control" id="customer_code" value="AUTO" readonly>
                    </div>
                    <div class="form-group">
                      <label>Nama Customer</label>
                      <input type="text" class="form-control" id="customer_name" placeholder="Nama Customer">
                    </div>
                    <div class="form-group">
                      <label>Alamat</label>
                      <textarea class="form-control" rows="3" id="customer_address" placeholder="Alamat ..."></textarea>
                    </div>
                    <div class="form-group">
                      <label>No Telp</label>
                      <input type="text" class="form-control" id="customer_phone" placeholder="Nomor Telepon">
                    </div>
                    <div class="form-group">
                      <label>No KTP</label>
                      <input type="text" class="form-control" id="customer_identity" placeholder="Nomor KTP">
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="addcustomer" class="btn btn-primary">Save changes</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <label for="sales_id" class="col-sm-1 text-right label-insert">Sales :</label>
          <div class="col-sm-3">
            <select class="form-control select2" name="sales_id" id="sales_id" >
              <option></option>
              <?php foreach($data['salesman_list'] as $row){ ?>
                <option value="<?php echo $row->sales_id; ?>"><?php echo $row->sales_name; ?></option>
              <?php  } ?>
            </select>
          </div>
          <label for="due_date" class="col-sm-1 text-right label-insert">Tempo :</label>
          <div class="col-sm-3">
            <input id="due_date" type="date" class="form-control">
          </div>
        </div>

        <div class="form-group row">
          <label for="no_hp" class="col-sm-1 text-right label-insert">No HP :</label>
          <div class="col-sm-3">
            <input id="no_hp" type="text" class="form-control" value="">
          </div>
          <label for="send_date" class="col-sm-1 text-right label-insert">Pengiriman :</label>
          <div class="col-sm-3">
            <input id="send_date" type="date" class="form-control" value="<?php echo date("Y-m-d"); ?>">
          </div>
          <label for="user" class="col-sm-1 text-right label-insert">User :</label>
          <div class="col-sm-3">
            <input id="display_user" type="text" class="form-control" value="<?php echo $_SESSION['user_name'] ?>" readonly="">
          </div>
        </div>

        <div class="form-group row">
          <label for="address" class="col-sm-1 text-right label-insert">Alamat:</label>
          <div class="col-sm-3">
            <textarea id="address" class="form-control"></textarea>
          </div>
          <label for="user" class="col-sm-1 text-right label-insert">Type :</label>
          <div class="col-sm-3">
            <select class="form-control select2" name="type" id="type" >
              <option value="Non Kredit">Non kredit</option>
              <option value="Kredit">Kredit</option>
            </select>
          </div>
          <label for="user" class="col-sm-1 text-right label-insert">Pengambilan :</label>
          <div class="col-sm-3">
            <select class="form-control select2" name="sendtype" id="sendtype" >
              <option value="send">Ambil Sekarang (Tidak Di kirim)</option>
              <option value="notsend">Ambil Nanti(Dikirim)</option>
            </select>
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

          <div class="col-sm-3">
            <div class="form-group">
              <label>Harga Jual</label>
              <input id="temp_price" name="temp_price" class="form-control text-right curency" value="0" data-parsley-vprice="" required="">
            </div>
          </div>

          <div class="col-sm-2">
            <div class="form-group">
              <label>Satuan</label>
              <input id="temp_qty" name="temp_qty" type="number" class="form-control text-right">
            </div>
          </div>

          <div class="col-sm-2">
            <div class="form-group">
              <label>Discount</label>
              <input id="temp_discount" name="temp_discount" type="text" class="form-control text-right curency6" value="0">
            </div>
          </div>

          <div class="col-sm-5"> </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label>Discount(%)</label>
              <input id="temp_discount_percentage" name="temp_discount_percentage" type="text" class="form-control text-right percentage" value="0">
            </div>
          </div>


          <div class="col-sm-4">
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
              <th>Diskon</th>
              <th>Total</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="temp">
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
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
              <label for="footer_discount" class="col-sm-7 col-form-label text-right:">Total Diskon:</label>
              <div class="col-sm-5">
                <input id="footer_discount" name="footer_discount" type="text" class="form-control text-right curency3" value="0" readonly="">
              </div>
            </div>

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
              <label for="footer_dp" class="col-sm-7 col-form-label text-right:">DP :</label>
              <div class="col-sm-5">
                <input id="footer_dp" name="footer_dp" type="text" class="form-control text-right curency5" value="0">
              </div>
            </div>

            <div class="form-group row">
              <label for="footer_remaining_debt" class="col-sm-7 col-form-label text-right:">Sisa Bayar :</label>
              <div class="col-sm-5">
                <input id="footer_remaining_debt" name="footer_remaining_debt" type="text" class="form-control text-right curency5" value="0" readonly="">
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

  let temp_discount = new AutoNumeric('#temp_discount', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let temp_discount_percentage = new AutoNumeric('#temp_discount_percentage', {
    allowDecimalPadding: AutoNumeric.options.allowDecimalPadding.floats,
    suffixText: AutoNumeric.options.suffixText.percentage
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

  let footer_dp = new AutoNumeric('#footer_dp', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let footer_remaining_debt = new AutoNumeric('#footer_remaining_debt', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let footer_discount = new AutoNumeric('#footer_discount', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });



  get_temp();
  get_total_footer();

  $(document).ready(function() {
    $('#addcustomer').click(function(e){
      e.preventDefault();
      var customer_name     = $("#customer_name").val();
      var customer_address  = $("#customer_address").val();
      var customer_phone    = $("#customer_phone").val();
      var customer_identity = $("#customer_identity").val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Masterdata/insert_customer",
        dataType: "json",
        data: {customer_name:customer_name, customer_address:customer_address, customer_phone:customer_phone, customer_identity:customer_identity},
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
    $('#btncancel').click(function(e){
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Sales/clear_temp_sales",
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

      var customer_id                   = $("#customer_id").val();
      var no_hp                         = $("#no_hp").val();
      var address                       = $("#address").val();
      var payment_id                    = $("#payment_id").val();
      var sales_id                      = $("#sales_id").val();
      var send_date                     = $("#send_date").val();
      var type                          = $("#type").val();
      var due_date                      = $("#due_date").val();
      var sendtype                      = $("#sendtype").val();
      var footer_discount_submit        = footer_discount.get();
      var footer_sub_total_submit       = footer_sub_total.get();
      var footer_total_ppn_submit       = footer_total_ppn.get();
      var footer_total_invoice_submit   = footer_total_invoice.get();
      var footer_dp_submit              = footer_dp.get();
      var footer_remaining_debt_submit  = footer_remaining_debt.get();

      if(sales_id == ''){
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Silahkan Isi Salesman',
        })
      }
      else if(customer_id == ''){
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Silahkan Isi Customer',
        })
      }else{
       $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Sales/save_sales",
        dataType: "json",
        data: {customer_id:customer_id, no_hp:no_hp, address:address, payment_id:payment_id, sales_id:sales_id, send_date:send_date, type:type, due_date:due_date, sendtype:sendtype, footer_discount_submit:footer_discount_submit, footer_sub_total_submit:footer_sub_total_submit, footer_total_ppn_submit:footer_total_ppn_submit, footer_total_invoice_submit:footer_total_invoice_submit, footer_dp_submit:footer_dp_submit, footer_remaining_debt_submit:footer_remaining_debt_submit},
        success : function(data){
          if (data.code == "200"){
            window.location.href = "<?php echo base_url(); ?>Sales";
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
   });
  });

  $(document).ready(function() {
    $('#btnadd_temp').click(function(e){
      e.preventDefault();
      var item_id                  = $("#item_id").val();
      var price_temp               = temp_price.get();
      var qty_temp                 = $("#temp_qty").val();
      var total_price_temp         = temp_total.get();
      var discount_temp            = temp_discount.get();
      var discount_temp_percentage = temp_discount_percentage.get();


      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Sales/insert_temp_sales",
        dataType: "json",
        data: {item_id:item_id, price_temp:price_temp, qty_temp:qty_temp, total_price_temp:total_price_temp, discount_temp:discount_temp, discount_temp_percentage:discount_temp_percentage},
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
      url: "<?php echo base_url(); ?>Sales/get_temp_sales",
      dataType: "json",
      data: {},
      success : function(data){
        let text_temp = "";
        for (let i = 0; i < data.length; i++) {
          text_temp += '<tr><td>'+data[i].item_barcode+'</td><td width="50%">'+data[i].item_name+'</td><td>'+new Intl.NumberFormat().format(data[i].product_price)+'</td><td>'+data[i].sales_qty+'</td><td>'+new Intl.NumberFormat().format(data[i].sales_discount)+'</td><td>'+new Intl.NumberFormat().format(data[i].sales_total)+'</td><td><button class="btn btn-sm btn-warning" style="margin-right:5px;" onclick="edit('+data[i].item_id+')"><i class="fas fa-edit"></i></button><button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" data-title="Hapus" data-original-title="" title="" onclick="deletes('+data[i].item_id+', '+data[i].item_barcode+')"><i class="fas fa-trash"></i></button></td></tr>';
        }
        if(data.length > 0){
          $("#supplier_id").val(data[0].supplier_id).trigger('change');
          // $('#supplier_id').prop('disabled', false);
          $('#supplier_id').prop('disabled', true);
          $("#no_po").val(data[0].po_name);
          $('#no_po').prop('disabled', true);
          $("#po_id").val(data[0].po_id);
          //$("#no_po").val(data[0].po_id).trigger('change');
        }else{
          $("#supplier_id").val("").trigger('change');
          $('#supplier_id').prop('disabled', false);
          $("#no_po").val("");
          $('#no_po').prop('disabled', false);
        }
        document.getElementById("temp").innerHTML = text_temp;
      }
    });
  }

  function get_total_footer(){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Sales/get_total_footer_sales",
      dataType: "json",
      data: {},
      success : function(data){
        if (data.code == "200"){
         footer_sub_total.set(data.result[0]['sales_total']);
         footer_total_invoice.set(data.result[0]['sales_total']);
         footer_remaining_debt.set(data.result[0]['sales_total']);
         footer_discount.set(data.result[0]['discount_total']);
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

  $('#customer_id').on('input', function(event) {
    var id = this.value;
    $.ajax({
      url: '<?php echo base_url(); ?>/Sales/get_customer_info',
      dataType: 'json',
      type: 'POST',
      data: {id:id},
      success: function(res) {
        if(res.code == 200) {
          var customer_phone = res.data[0].customer_phone;
          console.log(customer_phone);
          var customer_address = res.data[0].customer_address;
           $('#no_hp').val(customer_phone);
           $('#address').val(customer_address);
        }else{
          $('#customer_id').val('');
        }
      },
    });
  });

  $('#product_name').autocomplete({ 
    minLength: 2,
    source: function(req, add) {
      $.ajax({
        url: '<?php echo base_url(); ?>/Sales/search_product',
        dataType: 'json',
        type: 'GET',
        data: req,
        success: function(res) {
          if (res.success == true) {
            add(res.data);
            //no_hp
          }else{
            $('#product_name').val('');
          }
        },
      });
    },
    select: function(event, ui) {
      $('#item_id').val(ui.item.id);
      temp_price.set(parseFloat(ui.item.sales_price));
      $('#temp_qty').val(0);
      temp_total.set(0);
    },
  });

  
  $("#temp_price").on("input", function(){
    let temp_price = $('#temp_price').val();
    temp_discount.set(0);
    temp_discount_percentage.set(0);
    $('#temp_qty').val(0);
    temp_total.set(0);
  });

  $("#footer_dp").on("input", function(){
    let footer_total_invoice =  AutoNumeric.getAutoNumericElement('#footer_total_invoice').get();
    let footer_dp =  AutoNumeric.getAutoNumericElement('#footer_dp').get();
    footer_remaining_debt.set(footer_total_invoice - footer_dp);
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

  $("#temp_discount").on("input", function(){
    let temp_qty = $('#temp_qty').val();
    let temp_price = $('#temp_price').val();
    if($('#temp_qty').val() == null || $('#temp_qty').val() < 1){
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Silahkan Input Qty Terlebih Dahulu',
      });
      clear_input();
    }else{
      let prices =  AutoNumeric.getAutoNumericElement('#temp_price').get();
      let discount =  AutoNumeric.getAutoNumericElement('#temp_discount').get();

      let total_cal = temp_qty * prices - discount;
      temp_total.set(total_cal);
      let temp_percentage_cal = (discount / (temp_qty * prices) * 100);
      temp_discount_percentage.set(temp_percentage_cal);
    }
  });


  $("#temp_discount_percentage").on("input", function(){
    let temp_qty = $('#temp_qty').val();
    let temp_price = $('#temp_price').val();
    if($('#temp_qty').val() == null || $('#temp_qty').val() < 1){
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Silahkan Input Qty Terlebih Dahulu',
      });
      clear_input();
    }else{
      let prices =  AutoNumeric.getAutoNumericElement('#temp_price').get();
      let discount_percentage =  AutoNumeric.getAutoNumericElement('#temp_discount_percentage').get();
      let discount =  AutoNumeric.getAutoNumericElement('#temp_discount').get();
      let discount_cal = (temp_qty * prices) * (discount_percentage / 100);
      temp_discount.set(discount_cal);

      let total_cal = temp_qty * prices - discount_cal;
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
      footer_remaining_debt.set(footer_total_invoice_val);
      footer_dp.set(0);
    }else{
      footer_dp.set(0);
      footer_total_ppn.set(0);
      footer_total_invoice.set(footer_sub_total_val);
      footer_remaining_debt.set(footer_sub_total_val);
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
          url: "<?php echo base_url(); ?>Sales/delete_temp",
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
      url: "<?php echo base_url(); ?>Sales/get_edit_temp",
      dataType: "json",
      data: {id:id},
      success : function(data){
        if (data.code == "200"){
         $('#item_id').val(data.result[0]['product_id']);
         $('#product_name').val(data.result[0]['item_name']);
         temp_price.set(data.result[0]['product_price']);
         $('#temp_qty').val(data.result[0]['sales_qty']);
         temp_total.set(data.result[0]['sales_subtotal']);
         temp_discount.set(data.result[0]['sales_discount']);
         temp_discount_percentage.set(data.result[0]['sales_discount_percentage']);
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
    temp_discount.set(0);
    temp_discount_percentage.set(0);
    $('#temp_qty').val(0);
    temp_total.set(0);
    footer_total_ppn.set(0);
    footer_dp.set(0);
    $("#ppn_check").prop("checked", false);
  }
  
</script>


