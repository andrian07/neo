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
            <li class="breadcrumb-item active">PO</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->

  <section class="content"> 

    <!-- Default box -->
    <div class="card">
      <div class="card-header p-2">
        <ul class="nav nav-pills">
          <li class="nav-item"><a class="nav-link active" href="#receivables" data-toggle="tab">Daftar Piutang</a></li>
          <li class="nav-item"><a class="nav-link" href="#receivables_history" data-toggle="tab">History Pelunasan Piutang</a></li>
        </ul>
      </div><!-- /.card-header -->
      <div class="card-body">
        <div class="tab-content">
          <div class="tab-pane active" id="receivables">
            <table id="example" class="table table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>Nama Customer</th>
                  <th>Alamat</th>
                  <th>No Telp</th>
                  <th>Jumlah Nota</th>
                  <th>Total Hutang</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($data['receivables_customer'] as $row){ ?>
                  <tr>
                    <td><?php echo $row->customer_name; ?></td>
                    <td><?php echo $row->customer_address; ?></td>
                    <td><?php echo $row->customer_phone; ?></td>
                    <td><?php echo $row->total_nota; ?></td>
                    <td><?php echo 'Rp. '.number_format($row->total_piutang); ?></td>
                    <td>
                      <button onclick="pay('<?php echo $row->customer_id; ?>')" class="btn btn-sm btn-success btnrepayment" data-toggle="tooltip" data-placement="top" data-title="Pelunasan" data-original-title="" title=""><i class="fas fa-money-bill-wave"></i></button>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="receivables_history">
             <table id="examples" class="table table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>No Transaksi</th>
                  <th>Customer</th>
                  <th>Tgl Pembayaran</th>
                  <th>Pembayaran</th>
                  <th>Total Bayar</th>
                  <th>Jumlah Nota</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($data['receivables_history'] as $row){ ?>
                  <tr>
                    <td><?php echo $row->payment_receivable_invoice; ?></td>
                    <td><?php echo $row->customer_name; ?></td>
                    <td><?php $date = date_create($row->payment_receivable_date); echo date_format($date,"d-M-Y"); ?></td>
                    <td><?php echo $row->payment_name; ?></td>
                    <td><?php echo 'Rp. '.number_format($row->payment_receivable_total_invoice); ?></td>
                    <td><?php echo $row->payment_receivable_total_pay; ?></td>
                    <td><?php if($row->payment_receivable_status == 'Success'){ echo '<span class="badge badge-success">Sukses</span>';}else{ echo '<span class="badge badge-danger">Cancel</span>'; } ?></td>
                    <td>
                      <button class="btn btn-sm btn-primary" onclick="detail('<?php echo $row->payment_receivable_id; ?>')"><i class="fas fa-eye"></i></button>
                       <button class="btn btn-sm btn-danger" onclick="deletes('<?php echo $row->payment_receivable_id; ?>', '<?php echo $row->payment_receivable_invoice; ?>')"><i class="fas fa-trash"></i></button>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.tab-content -->
      </div><!-- /.card-body -->
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
  function pay(id){
    window.location.href = '<?php echo base_url(); ?>Payment/copy_pay_receivables?id='+id;
  }

  $('#btnreload').click(function(e){
    e.preventDefault();
    location.reload();
  });

  function detail(id){
    window.location.href = '<?php echo base_url(); ?>Payment/detail_payment_receivables?id='+id;
  }

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
          url: "<?php echo base_url(); ?>Payment/delete_receivables",
          dataType: "json",
          data: {id:id},
          success : function(data){
            if (data.code == "200"){
              location.reload();
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
  

</script>
