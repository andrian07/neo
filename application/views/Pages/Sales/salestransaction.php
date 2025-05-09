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
          <h1>Penjualan</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Penjualan</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title">Cari</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            Dari: <input id="start_date" name="start_date" type="date" class="form-control" value="">
          </div>
          <div class="col-md-4">
            Sampai: <input id="end_date" name="end_date" type="date" class="form-control" value="">
          </div>
          <div class="col-md-4">
            <button type="button" class="btn btn-primary" id="search" style="margin-top:22px;"><i class="fas fa-search"></i> Search</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">List Penjualan</h3>

        <div class="card-tools">  
          <?php if($data['check_role'][0]->add_ac == 'Y'){?>
            <button type="button" class="btn btn-primary" id="add_purcchase"><i class="fas fa-plus"></i> Tambah</button>
          <?php }else{ ?>
            <button type="button" class="btn btn-primary" id="add_purcchase" disabled><i class="fas fa-plus"></i> Tambah</button>
          <?php } ?>
          <button id="btnreload" class="btn btn-secondary"><i class="fas fa-sync"></i> Reload</button>
        </div>
      </div>
      <div class="card-body">
        <table id="examplesales" class="table table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>No Invoice</th>
              <th>Tanggal</th>
              <th>Salesman</th>
              <th>Customer</th>
              <th>Diskon</th>
              <th>Total Harga</th>
              <th>Status</th>
              <th>Status Pembayaran</th>
              <th>Pengiriman</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($data['sales_list'] as $row){ ?>
              <tr>
                <td><?php echo $row->hd_sales_invoice; ?></td>
                <td><?php $date = date_create($row->hd_sales_date); echo date_format($date,"d-M-Y"); ?></td>
                <td><?php echo $row->sales_name; ?></td>
                <td><?php echo $row->customer_name; ?></td>
                <td><?php echo 'Rp. '.number_format($row->hd_sales_discount); ?></td>
                <td><?php echo 'Rp. '.number_format($row->hd_sales_total); ?></td>
                <td><?php if($row->hd_sales_status == 'Success'){ echo '<span class="badge badge-success">Success</span>';}else{ echo '<span class="badge badge-danger">Cancel</span>';} ?>
              </td>
              <td><?php if($row->hd_sales_remaining_debt <= 0){ echo '<span class="badge badge-success">Lunas</span>';}else{ echo '<span class="badge badge-danger">Belum Lunas</span>';} ?>
            </td>
            <td><?php if($row->hd_delivery_status == 'Sudah'){ echo '<span class="badge badge-success">Terkirim</span>';}else{ echo '<span class="badge badge-danger">Belum Di Kirim</span>';} ?>
          </td>
          <td>
            <?php if($data['check_role'][0]->view_ac == 'Y'){?>
              <button class="btn btn-sm btn-primary" onclick="detail('<?php echo $row->hd_sales_id; ?>')"><i class="fas fa-eye"></i></button>
            <?php }else{ ?>
              <button class="btn btn-sm btn-primary" onclick="detail('<?php echo $row->hd_sales_id; ?>')" disabled><i class="fas fa-eye"></i></button>
            <?php } ?>
            <?php if($data['check_role'][0]->delete_ac == 'Y'){?>
              <button class="btn btn-sm btn-danger" onclick="deletes('<?php echo $row->hd_sales_id; ?>', '<?php echo $row->hd_sales_invoice; ?>')"><i class="fas fa-trash"></i></button>
            <?php }else{ ?>
              <button class="btn btn-sm btn-danger" onclick="deletes('<?php echo $row->hd_sales_id; ?>', '<?php echo $row->hd_sales_invoice; ?>')" disabled><i class="fas fa-trash"></i></button>
            <?php } ?>
            <button class="btn btn-sm btn-info" onclick="print_invoice('<?php echo $row->hd_sales_id; ?>', '<?php echo $row->hd_sales_invoice; ?>')"><i class="fas fa-print"></i></button>
            <button class="btn btn-sm btn-warning" onclick="print_dispatch('<?php echo $row->hd_sales_id; ?>', '<?php echo $row->hd_sales_invoice; ?>')"><i class="fas fa-truck"></i></button>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<!-- /.card-body -->
<!-- /.card-footer-->
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
          url: "<?php echo base_url(); ?>Sales/delete_sales",
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

  function print_invoice(id, name)
  {
    window.location.href = '<?php echo base_url(); ?>Sales/invoice?id='+id;
  }

  function print_dispatch(id, name)
  { 
    Swal.fire({
      title: 'Konfirmasi?',
      text: "Apakah Anda Ingin Mengirimkan Pesanan '"+name+"' ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Kirim'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '<?php echo base_url(); ?>Sales/invoice_dispatch?id='+id;
      }
    })
  }
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#add_purcchase').click(function(e){
      e.preventDefault();
      window.location.href = '<?php echo base_url(); ?>Sales/add_sales';
    });
  });

  $(document).ready(function() {
    $('#search').click(function(e){
      e.preventDefault();
      let start_Date = $('#start_date').val();
      let end_date = $('#end_date').val();
      window.location.href = '<?php echo base_url(); ?>Sales?start_date='+start_Date+'&end_date='+end_date;
    });
  });

  $('#btnreload').click(function(e){
    e.preventDefault();
    location.reload();
  });


  function detail(id){
    window.location.href = '<?php echo base_url(); ?>Sales/detail_sales?id='+id;
  }

  new DataTable('#examplesales', {
    order: [[1, 'desc']]
  });

</script>
