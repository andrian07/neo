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
          <h1>Pelunasan Piutang</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Pelunasan Piutang</li>
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
       <div class="row">
        <div class="col-sm-12 col-md-3">
          <!-- text input -->
          <div class="form-group">
            <label>Nama Customer</label>
            <input id="customer_id" name="customer_id" type="hidden" class="form-control" value="<?php echo $_GET['id']; ?>" readonly>
            <input id="customer_name" name="customer_name" type="text" class="form-control" readonly="">
          </div>
        </div>

        <div class="col-sm-12 col-md-2">
          <!-- text input -->
          <div class="form-group">
            <label>Tanggal Pembayaran</label>
            <input id="repayment_date" name="repayment_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
          </div>
        </div>

        <div class="col-sm-12 col-md-3">
          <!-- text input -->
          <div class="form-group">
            <label>Metode Pembayaran</label>
            <select class="form-control select2" name="payment_id" id="payment_id" >
              <option></option>
              <?php foreach($data['payment_list'] as $row){ ?>
                <option value="<?php echo $row->payment_id; ?>"><?php echo $row->payment_name; ?></option>
              <?php  } ?>
            </select>
          </div>
        </div>


        <div class="col-sm-12 col-md-2">
          <!-- text input -->
          <div class="form-group">
            <label>User</label>
            <input id="display_user" type="text" class="form-control" value="<?php echo $_SESSION['user_name'] ?>" readonly="">
          </div>
        </div>
        <div class="col-sm-12 col-md-2">
          <!-- text input -->
          <div class="form-group">
            <label>Total Piutang</label>
            <input id="customer_total_debt" name="customer_total_debt" type="text" class="form-control text-right" value="0" readonly="">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card">

    <div class="card-body">
      <div class="row well well-sm">
        <input id="sales_admin_id" name="sales_admin_id" type="hidden" value="">

        <div class="col-sm-12 col-md-3">
          <!-- text input -->
          <div class="form-group">
            <label>No Invoice</label>
            <input id="sales_admin_invoice" name="sales_admin_invoice" type="text" class="form-control" placeholder="No Invoice" value="" readonly="">
          </div>
        </div>


        <div class="col-sm-12 col-md-2">
          <!-- text input -->
          <div class="form-group">
            <label>Tanggal Invoice</label>
            <input id="sales_admin_date" name="sales_admin_date" type="date" class="form-control" placeholder="Tanggal Invoice" value="" readonly="">
          </div>
        </div>

        <div class="col-sm-12 col-md-2">
          <!-- text input -->
          <div class="form-group">
            <label>Jatuh Tempo</label>
            <input id="due_date" name="due_date" type="date" class="form-control" placeholder="Tanggal Jatuh Tempo" value="" readonly="">
          </div>
        </div>



        <div class="col-sm-12 col-md-5">
          <!-- text input -->
          <div class="form-group">
            <label>Nominal Retur</label>
            <input id="sales_admin_retur_nominal" name="sales_admin_retur_nominal" class="form-control text-right" value="0" readonly="">
          </div>
        </div>



        <div class="col-sm-12 col-md-3">
          <!-- text input -->
          <div class="form-group">
            <label>Saldo Piutang</label>
            <input id="remaining_receivable" name="remaining_receivable" type="text" class="form-control text-right" value="0" readonly="">
          </div>
        </div>

        <div class="col-sm-12 col-md-2">
          <!-- text input -->
          <div class="form-group">
            <label>Pembayaran</label>
            <input id="repayment_total" name="repayment_total" type="text" class="form-control text-right" value="0" data-parsley-vrepaymenttotal="" required="">
          </div>
        </div>

        <div class="col-sm-12 col-md-2">
          <!-- text input -->
          <div class="form-group">
            <label>Pembulatan/Disc</label>
            <input id="repayment_disc" name="repayment_disc" type="text" class="form-control text-right" value="0" required="">
          </div>
        </div>

        <div class="col-sm-12 col-md-4">
          <!-- text input -->
          <div class="form-group">
            <label>Sisa Piutang</label>
            <input id="new_remaining_receivable" name="new_remaining_receivable" type="text" class="form-control text-right" data-parsley-vnewdebt="" value="0" readonly="">
          </div>
        </div>


        <div class="col-sm-1">
          <!-- text input -->
          <label>&nbsp;</label>
          <div class="form-group">
            <div class="col-12">
              <button id="btnadd_temp" class="btn btn-md btn-primary rounded-circle float-right"><i class="fas fa-plus"></i></button>
            </div>
          </div>
        </div>
      </div>

      <table id="example" class="table table-bordered" style="width:100%">
        <thead>
          <tr>
            <th>No Invoice</th>
            <th>Tanggal Invoice</th>
            <th>Jt. Tempo</th>
            <th>Saldo Piutang</th>
            <th>Pembulatan / Disc</th>
            <th>Pembayaran</th>
            <th>Sisa Hutang</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="temp">
        </tbody>
      </table>

      <div class="row form-space" style="margin-top:45px;">

        <div class="col-lg-6">

        </div>

        <div class="col-lg-6 text-right">

          <div class="form-group row">
            <label for="footer_invoice_total" class="col-sm-7 col-form-label text-right:">Total Pembayaran:</label>
            <div class="col-sm-5">
              <input id="footer_invoice_total" name="footer_invoice_total" type="text" class="form-control text-right" value="0" readonly="">
            </div>
          </div>

          <div class="form-group row">
            <label for="footer_nota_pay" class="col-sm-7 col-form-label text-right:">Jumlah Nota:</label>
            <div class="col-sm-5">
              <input id="footer_nota_pay" name="footer_nota_pay" type="text" class="form-control text-right" value="0" readonly="">
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

  let temp_piutang = new AutoNumeric('#customer_total_debt', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let sisa_hutang = new AutoNumeric('#remaining_receivable', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let repayment_total = new AutoNumeric('#repayment_total', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let repayment_disc = new AutoNumeric('#repayment_disc', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let new_remaining_receivable = new AutoNumeric('#new_remaining_receivable', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let sales_admin_retur_nominal = new AutoNumeric('#sales_admin_retur_nominal', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let footer_invoice_total = new AutoNumeric('#footer_invoice_total', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });


  $('#btnadd_temp').prop('disabled', true);

  get_header();
  get_temp();
  get_footer();

  function get_header(){
    let customer_id = $("#customer_id").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Payment/get_header_pay_receivables",
      dataType: "json",
      data: {customer_id:customer_id},
      success : function(data){
        if (data.code == "200"){
         $("#customer_name").val(data.result[0]['customer_name']);
         temp_piutang.set(data.result[0]['total_piutang']);
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

  function get_temp() {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Payment/get_temp_receivables",
      dataType: "json",
      data: {},
      success : function(data){
        let text_temp = "";
        for (let i = 0; i < data.length; i++) {
          text_temp += '<tr><td width="20%">'+data[i].hd_sales_invoice+'</td><td>'+data[i].hd_sales_date+'</td><td>'+data[i].hd_sales_due_date+'</td><td>'+new Intl.NumberFormat().format(data[i].temp_sisa_hutang)+'</td><td>'+new Intl.NumberFormat().format(data[i].temp_debt_discount)+'</td><td>'+new Intl.NumberFormat().format(data[i].temp_debt_nominal)+'</td><td>'+new Intl.NumberFormat().format(data[i].temp_debt_remaining)+'</td><td><button class="btn btn-sm btn-warning" style="margin-right:5px;" onclick="edits('+data[i].temp_sales_id+')"><i class="fas fa-edit"></i></button></td></tr>';
        }
        document.getElementById("temp").innerHTML = text_temp;
      }
    });
  }

  function edits(id) {
   $.ajax({
    type: "POST",
    url: "<?php echo base_url(); ?>Payment/get_temp_receivables_edit",
    dataType: "json",
    data: {temp_sales_id:id},
    success : function(data){
      if (data.code == "200"){
        $("#sales_admin_invoice").val(data.result[0]['hd_sales_invoice']);
        $("#sales_admin_id").val(data.result[0]['hd_sales_id']);
        $("#sales_admin_date").val(data.result[0]['hd_sales_date']);
        $("#due_date").val(data.result[0]['hd_sales_due_date']);
        sisa_hutang.set(data.result[0]['temp_sisa_hutang']);
        repayment_total.set(data.result[0]['temp_debt_nominal']);
        repayment_disc.set(data.result[0]['temp_debt_discount']);
        sales_admin_retur_nominal.set(data.total_retur[0]['total_retur']);
        new_remaining_receivable.set(data.result[0]['temp_sisa_hutang'] - data.total_retur[0]['total_retur']);
        $('#btnadd_temp').prop('disabled', false);
      }else {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: data.result,
        })
      }
    }
  });
 }

 $(document).ready(function() {
  $('#btnsave').click(function(e){
    e.preventDefault();
    var customer_id                     = $("#customer_id").val();
    var footer_invoice_total_val        = footer_invoice_total.get();
    var payment_receivable_total_pay    = $("#footer_nota_pay").val();
    var payment_receivable_method_id    = $("#payment_id").val();
    var new_remaining_receivable_val    = new_remaining_receivable.get();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Payment/save_receivables",
      dataType: "json",
      data: {customer_id:customer_id, footer_invoice_total_val:footer_invoice_total_val, payment_receivable_total_pay:payment_receivable_total_pay, payment_receivable_method_id:payment_receivable_method_id, new_remaining_receivable_val:new_remaining_receivable_val},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>Payment/receivables";
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
  $('#btnadd_temp').click(function(e){
    e.preventDefault();
    var sales_admin_id                  = $("#sales_admin_id").val();
    var sales_admin_date                = $("#sales_admin_date").val();
    var due_date                        = $("#due_date").val();
    var sales_admin_retur_nominal_val   = sales_admin_retur_nominal.get();
    var remaining_receivable            = sisa_hutang.get();
    var repayment_total_val             = repayment_total.get();
    var repayment_disc_val              = repayment_disc.get();
    var new_remaining_receivable_val    = new_remaining_receivable.get();


    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Payment/insert_temp_receivables",
      dataType: "json",
      data: {sales_admin_id:sales_admin_id, sales_admin_date:sales_admin_date, due_date:due_date, sales_admin_retur_nominal_val:sales_admin_retur_nominal_val, remaining_receivable:remaining_receivable, repayment_total_val:repayment_total_val, repayment_disc_val:repayment_disc_val, new_remaining_receivable_val:new_remaining_receivable_val},
      success : function(data){
        if (data.code == "200"){
          get_header();
          get_temp();
          get_footer();
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

 $("#repayment_total").on("input", function(){
  let retur = AutoNumeric.getAutoNumericElement('#sales_admin_retur_nominal').get();
  let saldo = AutoNumeric.getAutoNumericElement('#remaining_receivable').get();
  let pay =  AutoNumeric.getAutoNumericElement('#repayment_total').get();
  let disc =  AutoNumeric.getAutoNumericElement('#repayment_disc').get();

  let total_remaining = saldo - retur - pay - disc;
  new_remaining_receivable.set(total_remaining);
});


 $("#repayment_disc").on("input", function(){
  let repayment_total = $('#repayment_total').val();
  if($('#repayment_total').val() == null){
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Silahkan Isi Total Pembayaran Terlebih Dahulu',
    });
  }else{
    let retur = AutoNumeric.getAutoNumericElement('#sales_admin_retur_nominal').get();
    let saldo = AutoNumeric.getAutoNumericElement('#remaining_receivable').get();
    let pay =  AutoNumeric.getAutoNumericElement('#repayment_total').get();
    let disc =  AutoNumeric.getAutoNumericElement('#repayment_disc').get();
    let total_remaining = saldo - retur - pay - disc;
    new_remaining_receivable.set(total_remaining);
  }
});

 function get_footer(){
  $.ajax({
    type: "POST",
    url: "<?php echo base_url(); ?>Payment/footer_pay_receivables",
    dataType: "json",
    data: {},
    success : function(data){
      if (data.code == "200"){
       footer_invoice_total.set(data.result[0]['total_payment']);
       $("#footer_nota_pay").val(data.result[0]['total_nota']);
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


$(document).ready(function() {
  $('#btncancel').click(function(e){
    window.location.href = "<?php echo base_url(); ?>Payment/receivables";
  });
});

function clear_input(){
  $('#sales_admin_id').val('');
  $('#sales_admin_invoice').val('');
  $('#sales_admin_date').val('');
  $('#due_date').val('');
  sales_admin_retur_nominal.set(0);
  sisa_hutang.set(0);
  repayment_total.set(0);
  repayment_disc.set(0);
  new_remaining_receivable.set(0);
}



</script>


