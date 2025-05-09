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
          <h1>Customer</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Customer</li>
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
        <h3 class="card-title">List Customer</h3>

        <div class="card-tools">  
          <?php if($data['check_role'][0]->add_ac == 'Y'){?>
            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Tambah</button>
          <?php }else{ ?>
            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" disabled><i class="fas fa-plus"></i> Tambah</button>
          <?php } ?>
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
                  <button type="button" id="add" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>


          <div class="modal fade" id="exampleModaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Customer</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Kode Customer</label>
                    <input type="hidden" class="form-control" id="customer_id" readonly>
                    <input type="text" class="form-control" id="customer_code_edit" readonly>
                  </div>
                  <div class="form-group">
                    <label>Nama Customer</label>
                    <input type="text" class="form-control" id="customer_name_edit" placeholder="Nama Customer">
                  </div>
                  <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control" rows="3" id="customer_address_edit" placeholder="Alamat ..."></textarea>
                  </div>
                  <div class="form-group">
                    <label>No Telp</label>
                    <input type="text" class="form-control" id="customer_phone_edit" placeholder="Nomor Telepon">
                  </div>
                  <div class="form-group">
                    <label>No KTP</label>
                    <input type="text" class="form-control" id="customer_identity_edit" placeholder="Nomor KTP">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" id="edit" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>


          <button id="btnreload" class="btn btn-secondary"><i class="fas fa-sync"></i> Reload</button>
        </div>
      </div>
      <div class="card-body">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>Kode Customer</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>No Telepon</th>
              <th>No KTP</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($data['customer_list'] as $row){ ?>
              <tr>
                <td><?php echo $row->customer_code; ?></td>
                <td><?php echo $row->customer_name; ?></td>
                <td><?php echo $row->customer_address; ?></td>
                <td><?php echo $row->customer_phone; ?></td>
                <td><?php echo $row->customer_ktp; ?></td>
                <td>
                 <?php if($data['check_role'][0]->edit_ac == 'Y'){?>
                  <button data-id="<?php echo $row->customer_id; ?>" data-code="<?php echo $row->customer_code; ?>" data-name="<?php echo $row->customer_name; ?>" data-address="<?php echo $row->customer_address; ?>" data-phone="<?php echo $row->customer_phone; ?>" data-identity="<?php echo $row->customer_ktp; ?>" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#exampleModaledit"><i class="fas fa-edit"></i></button>
                <?php }else{ ?>
                  <button data-id="<?php echo $row->customer_id; ?>" data-code="<?php echo $row->customer_code; ?>" data-name="<?php echo $row->customer_name; ?>" data-address="<?php echo $row->customer_address; ?>" data-phone="<?php echo $row->customer_phone; ?>" data-identity="<?php echo $row->customer_ktp; ?>" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#exampleModaledit" disabled><i class="fas fa-edit"></i></button>
                <?php } ?>

                <?php if($data['check_role'][0]->delete_ac == 'Y'){?>
                  <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" data-title="Hapus" data-original-title="" title="" onclick="deletes('<?php echo $row->customer_id; ?>', '<?php echo $row->customer_name; ?>')"><i class="fas fa-trash"></i></button>
                <?php }else{ ?>
                  <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" data-title="Hapus" data-original-title="" title="" onclick="deletes('<?php echo $row->customer_id; ?>', '<?php echo $row->customer_name; ?>')" disabled><i class="fas fa-trash"></i></button>
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
          url: "<?php echo base_url(); ?>Masterdata/delete_customer",
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
    $('#add').click(function(e){
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


  $('#edit').click(function(e){
    e.preventDefault();
    var customer_id       = $("#customer_id").val();
    var customer_name     = $("#customer_name_edit").val();
    var customer_address  = $("#customer_address_edit").val();
    var customer_phone    = $("#customer_phone_edit").val();
    var customer_ktp      = $("#customer_identity_edit").val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/edit_customer",
      dataType: "json",
      data: {customer_id:customer_id, customer_name:customer_name, customer_address:customer_address, customer_phone:customer_phone, customer_ktp:customer_ktp},
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

  $('#btnreload').click(function(e){
    e.preventDefault();
    location.reload();
  });

  $('#exampleModaledit').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var customer_id             = button.data('id')
    var customer_code_edit      = button.data('code')
    var customer_name_edit      = button.data('name')
    var customer_address_edit   = button.data('address')
    var customer_phone_edit     = button.data('phone')
    var customer_identity_edit  = button.data('identity')

    var modal = $(this)
    modal.find('.modal-title').text('Edit ' + customer_name_edit)
    modal.find('#customer_id').val(customer_id)
    modal.find('#customer_code_edit').val(customer_code_edit)
    modal.find('#customer_name_edit').val(customer_name_edit)
    modal.find('#customer_address_edit').val(customer_address_edit)
    modal.find('#customer_phone_edit').val(customer_phone_edit)
    modal.find('#customer_identity_edit').val(customer_identity_edit)
    
  })
</script>
