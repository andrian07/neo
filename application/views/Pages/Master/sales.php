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
          <h1>Sales</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Sales</li>
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
        <h3 class="card-title">List Sales</h3>

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
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Sales</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Kode Sales</label>
                    <input type="text" class="form-control" id="sales_code" value="AUTO" readonly>
                  </div>
                  <div class="form-group">
                    <label>Nama Sales</label>
                    <input type="text" class="form-control" id="sales_name" placeholder="Nama Sales">
                  </div>
                  <div class="form-group">
                    <label>No Telp</label>
                    <input type="text" class="form-control" id="sales_phone" placeholder="No Telp">
                  </div>
                  <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control" rows="3" id="sales_address" placeholder="Alamat ..."></textarea>
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
                  <h5 class="modal-title" id="exampleModalLabel">Edit Sales</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Kode Sales</label>
                    <input type="hidden" class="form-control" id="sales_id" readonly>
                    <input type="text" class="form-control" id="sales_code_edit" readonly>
                  </div>
                  <div class="form-group">
                    <label>Nama Sales</label>
                    <input type="text" class="form-control" id="sales_name_edit" placeholder="Nama Sales">
                  </div>
                  <div class="form-group">
                    <label>No Telp</label>
                    <input type="text" class="form-control" id="sales_phone_edit" placeholder="Nomor Telepon">
                  </div>
                  <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control" rows="3" id="sales_address_edit" placeholder="Alamat ..."></textarea>
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
              <th>Kode Sales</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>No Telepon</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($data['sales_list'] as $row){ ?>
              <tr>
                <td><?php echo $row->sales_code; ?></td>
                <td><?php echo $row->sales_name; ?></td>
                <td><?php echo $row->sales_address; ?></td>
                <td><?php echo $row->sales_phone; ?></td>
                <td>
                  <?php if($data['check_role'][0]->edit_ac == 'Y'){?>
                    <button data-id="<?php echo $row->sales_id; ?>" data-code="<?php echo $row->sales_code; ?>" data-name="<?php echo $row->sales_name; ?>" data-address="<?php echo $row->sales_address; ?>" data-phone="<?php echo $row->sales_phone; ?>"class="btn btn-sm btn-warning" data-toggle="modal" data-target="#exampleModaledit"><i class="fas fa-edit"></i></button>
                  <?php }else{ ?>
                    <button data-id="<?php echo $row->sales_id; ?>" data-code="<?php echo $row->sales_code; ?>" data-name="<?php echo $row->sales_name; ?>" data-address="<?php echo $row->sales_address; ?>" data-phone="<?php echo $row->sales_phone; ?>"class="btn btn-sm btn-warning" data-toggle="modal" data-target="#exampleModaledit" disabled><i class="fas fa-edit"></i></button>
                  <?php } ?>

                  <?php if($data['check_role'][0]->delete_ac == 'Y'){?>
                    <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" data-title="Hapus" data-original-title="" title="" onclick="deletes('<?php echo $row->sales_id; ?>', '<?php echo $row->sales_name; ?>')"><i class="fas fa-trash"></i></button>
                  <?php }else{ ?>
                    <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" data-title="Hapus" data-original-title="" title="" onclick="deletes('<?php echo $row->sales_id; ?>', '<?php echo $row->sales_name; ?>')" disabled><i class="fas fa-trash"></i></button>
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
          url: "<?php echo base_url(); ?>Masterdata/delete_sales",
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
      var sales_name     = $("#sales_name").val();
      var sales_address  = $("#sales_address").val();
      var sales_phone    = $("#sales_phone").val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Masterdata/insert_sales",
        dataType: "json",
        data: {sales_name:sales_name, sales_address:sales_address, sales_phone:sales_phone},
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
    var sales_id       = $("#sales_id").val();
    var sales_name     = $("#sales_name_edit").val();
    var sales_address  = $("#sales_address_edit").val();
    var sales_phone    = $("#sales_phone_edit").val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/edit_sales",
      dataType: "json",
      data: {sales_id:sales_id, sales_name:sales_name, sales_address:sales_address, sales_phone:sales_phone},
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
    var sales_id             = button.data('id')
    var sales_code_edit      = button.data('code')
    var sales_name_edit      = button.data('name')
    var sales_address_edit   = button.data('address')
    var sales_phone_edit     = button.data('phone')

    var modal = $(this)
    modal.find('.modal-title').text('Edit ' + sales_name_edit)
    modal.find('#sales_id').val(sales_id)
    modal.find('#sales_code_edit').val(sales_code_edit)
    modal.find('#sales_name_edit').val(sales_name_edit)
    modal.find('#sales_address_edit').val(sales_address_edit)
    modal.find('#sales_phone_edit').val(sales_phone_edit)
    
  })
</script>
