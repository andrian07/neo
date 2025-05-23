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
          <h1>PO</h1>
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
        <h3 class="card-title">List PO</h3>
        <div class="card-tools"> 
          <?php if($data['check_role'][0]->add_ac == 'Y'){?>
            <button type="button" class="btn btn-primary" id="add_po"><i class="fas fa-plus"></i> Tambah</button>
          <?php }else{ ?>
            <button type="button" class="btn btn-primary" id="add_po" disabled><i class="fas fa-plus"></i> Tambah</button>
          <?php } ?>
          <button id="btnreload" class="btn btn-secondary"><i class="fas fa-sync"></i> Reload</button>
        </div>
      </div>
      <div class="card-body">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>No PO</th>
              <th>Tanggal</th>
              <th>Golongan</th>
              <th>supplier</th>
              <th>Total</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($data['po_list'] as $row){ ?>
              <tr>
                <td><?php echo $row->hd_po_invoice; ?></td>
                <td><?php $date = date_create($row->hd_po_date); echo date_format($date,"d-M-Y"); ?></td>
                <td>
                  <?php if($row->hd_po_gol == 'Y'){ echo '<span class="badge badge-warning">PAJAK</span>';}else{ echo '<span class="badge badge-danger">NON PAJAK</span>';}?>
                </td>
                <td><?php echo $row->supplier_name; ?></td>
                <td><?php echo 'Rp. '.number_format($row->hd_po_total); ?></td>
                <td><?php if($row->hd_po_status == 'success'){ echo '<span class="badge badge-success">Sukses</span>';}else if($row->hd_po_status == 'cancel'){ echo '<span class="badge badge-danger">Cancel</span>';}else{echo '<span class="badge badge-primary">Pending</span>';} ?></td>
                <td>

                  <button class="btn btn-sm btn-primary" onclick="detail('<?php echo $row->hd_po_id; ?>')"><i class="fas fa-eye"></i></button>

                  <?php if($row->hd_po_status == 'pending'){  ?>
                    <?php if($data['check_role'][0]->edit_ac == 'Y'){?>
                      <button class="btn btn-sm btn-warning" onclick="edites('<?php echo $row->hd_po_id; ?>')"><i class="fas fa-edit"></i></button>
                    <?php }else{ ?>
                      <button class="btn btn-sm btn-warning" onclick="edites('<?php echo $row->hd_po_id; ?>')" disabled><i class="fas fa-edit"></i></button>
                    <?php } ?>
                  <?php } ?>
                  <?php if($data['check_role'][0]->delete_ac == 'Y'){?>
                    <button class="btn btn-sm btn-danger" onclick="deletes('<?php echo $row->hd_po_id; ?>', '<?php echo $row->hd_po_invoice; ?>')"><i class="fas fa-trash"></i></button>
                  <?php }else{ ?>
                    <button class="btn btn-sm btn-danger" onclick="deletes('<?php echo $row->hd_po_id; ?>', '<?php echo $row->hd_po_invoice; ?>')" disabled><i class="fas fa-trash"></i></button>
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
          url: "<?php echo base_url(); ?>Purchase/delete_po",
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
    $('#add_po').click(function(e){
      e.preventDefault();
      window.location.href = '<?php echo base_url(); ?>Purchase/add_po';
    });
  });

  $(document).ready(function() {
    $('#search').click(function(e){
      e.preventDefault();
      let start_Date = $('#start_date').val();
      let end_date = $('#end_date').val();
      window.location.href = '<?php echo base_url(); ?>Purchase/po?start_date='+start_Date+'&end_date='+end_date;
    });
  });

  $('#btnreload').click(function(e){
    e.preventDefault();
    location.reload();
  });

  function edites(id){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/copy_to_temp",
      dataType: "json",
      data: {id:id},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>Purchase/add_po";
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

  function detail(id){
    window.location.href = '<?php echo base_url(); ?>Purchase/detail_po?id='+id;
  }

</script>
