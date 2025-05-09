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
          <h1>Stok Opname</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Stok Opname</li>
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
        <h3 class="card-title">List Opname</h3>
        <div class="card-tools">  
          <?php if($data['check_role'][0]->add_ac == 'Y'){?>
            <button type="button" class="btn btn-primary" id="add_opname"><i class="fas fa-plus"></i> Tambah</button>
          <?php }else{ ?>
            <button type="button" class="btn btn-primary" id="add_opname" disabled><i class="fas fa-plus"></i> Tambah</button>
          <?php } ?>
          <button id="btnreload" class="btn btn-secondary"><i class="fas fa-sync"></i> Reload</button>
        </div>
      </div>
      <div class="card-body">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>Kode Opname</th>
              <th>Tanggal</th>
              <th>Total Selisih</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($data['opname_list'] as $row){ ?>
              <tr>
                <td><?php echo $row->opname_code; ?></td>
                <td><?php $date = date_create($row->hd_opname_date); echo date_format($date,"d-M-Y"); ?></td>
                <td><?php echo 'Rp. '.number_format($row->hd_opname_total_price); ?></td>
                <td>
                  <?php if($row->hd_opname_status == 'Success'){ echo '<span class="badge badge-success">Success</span>';}else{ echo '<span class="badge badge-danger">Cancel</span>';}?>
                </td> 
                <td>
                  <?php if($data['check_role'][0]->view_ac == 'Y'){?>
                    <button class="btn btn-sm btn-primary" onclick="detail('<?php echo $row->hd_opname_id; ?>')"><i class="fas fa-eye"></i></button>
                  <?php }else{ ?>
                    <button class="btn btn-sm btn-primary" onclick="detail('<?php echo $row->hd_opname_id; ?>')" disabled><i class="fas fa-eye"></i></button>
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
  $(document).ready(function() {
    $('#add_opname').click(function(e){
      e.preventDefault();
      window.location.href = '<?php echo base_url(); ?>Opname/add_opname';
    });
  });

  $('#btnreload').click(function(e){
    e.preventDefault();
    location.reload();
  });

  function detail(id){
    window.location.href = '<?php echo base_url(); ?>Opname/detail_opname?id='+id;
  }

</script>
