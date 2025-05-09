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
          <h1>Retur Penjualan</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Retur Penjualan</li>
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
        <h3 class="card-title">List Retur Penjualan</h3>

        <div class="card-tools">  
          <?php if($data['check_role'][0]->add_ac == 'Y'){?> 
            <button type="button" class="btn btn-primary" id="add_retursales"><i class="fas fa-plus"></i> Tambah</button>
          <?php }else{ ?>
           <button type="button" class="btn btn-primary" id="add_retursales" disabled><i class="fas fa-plus"></i> Tambah</button>
         <?php } ?>
         <button id="btnreload" class="btn btn-secondary"><i class="fas fa-sync"></i> Reload</button>
       </div>
     </div>
     <div class="card-body">
      <table id="example" class="table table-bordered" style="width:100%">
        <thead>
          <tr>
            <th>No Invoice</th>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Total</th>
            <th>Status</th>
            <th>Pembayaran</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($data['retur_sales_list'] as $row){ ?>
            <tr>
              <td><?php echo $row->hd_retur_sales_invoice; ?></td>
              <td><?php $date = date_create($row->hd_retur_date); echo date_format($date,"d-M-Y"); ?></td>
              <td><?php echo $row->customer_name; ?></td>
              <td><?php echo 'Rp. '.number_format($row->hd_retur_total_transaction); ?></td>
              <td><?php if($row->hd_retur_status == 'Success'){ echo '<span class="badge badge-success">Sukses</span>';}else{ echo '<span class="badge badge-danger">Cancel</span>';} ?>
            </td>
            <td><?php if($row->hd_retur_payment == 'Ya'){ echo '<span class="badge badge-success">Potong Nota</span>';}else{ echo '<span class="badge badge-danger">Tidak Potong Nota</span>';} ?>
          </td>
          <td>
            <?php if($data['check_role'][0]->view_ac == 'Y'){?>
              <button class="btn btn-sm btn-primary" onclick="detail('<?php echo $row->hd_retur_sales_id; ?>')"><i class="fas fa-eye"></i></button>
            <?php }else{ ?>
              <button class="btn btn-sm btn-primary" onclick="detail('<?php echo $row->hd_retur_sales_id; ?>')" disabled><i class="fas fa-eye"></i></button>
            <?php } ?>
            <?php if($data['check_role'][0]->delete_ac == 'Y'){?>
              <button class="btn btn-sm btn-danger" onclick="deletes('<?php echo $row->hd_retur_sales_id; ?>', '<?php echo $row->hd_retur_sales_invoice; ?>')"><i class="fas fa-trash"></i></button>
            <?php }else{ ?>
              <button class="btn btn-sm btn-danger" onclick="deletes('<?php echo $row->hd_retur_sales_id; ?>', '<?php echo $row->hd_retur_sales_invoice; ?>')" disabled><i class="fas fa-trash"></i></button>
            <?php } ?>
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
          url: "<?php echo base_url(); ?>Retur/delete_retur_sales",
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
<script type="text/javascript">
  $(document).ready(function() {
    $('#add_retursales').click(function(e){
      e.preventDefault();
      window.location.href = '<?php echo base_url(); ?>Retur/addretursales';
    });
  });

  $(document).ready(function() {
    $('#search').click(function(e){
      e.preventDefault();
      let start_Date = $('#start_date').val();
      let end_date = $('#end_date').val();
      window.location.href = '<?php echo base_url(); ?>Retur/purchase?start_date='+start_Date+'&end_date='+end_date;
    });
  });

  $('#btnreload').click(function(e){
    e.preventDefault();
    location.reload();
  });


  function detail(id){
    window.location.href = '<?php echo base_url(); ?>Retur/detail_retur_sales?id='+id;
  }

</script>
