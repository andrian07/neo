<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Ganti Password</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Ganti Password</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-5" style="background-color: #fff; padding: 40px; border-radius: 5%;">
          <div class="form-group">
            <label>Password Lama</label>
            <input type="Password" class="form-control" id="old_pass" placeholder="Password Lama" required>
          </div>

          <div class="form-group">
            <label>Password Baru</label>
            <input type="Password" class="form-control" id="new_pass" placeholder="Password Baru" required>
          </div>

          <div class="form-group">
            <label>Ulangi Password Baru</label>
            <input type="Password" class="form-control" id="cf_new_pass" placeholder="Ulangi Password Baru" required>
          </div>
          <div class="form-group" style="text-align:right;">
            <button type="button" id="add" class="btn btn-primary" style="margin-top:30px;">Ganti Password</button>
          </div>
        </div>
      </div>

    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php 
require DOC_ROOT_PATH . $this->config->item('footer');
?>

<script type="text/javascript">
  $(document).ready(function() {
    $('#add').click(function(e){
      e.preventDefault();
      var old_pass    = $("#old_pass").val();
      var new_pass    = $("#new_pass").val();
      var cf_new_pass = $("#cf_new_pass").val();
      if(old_pass == "" || new_pass == "" || cf_new_pass == ""){
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Silahkan Lengkapi Data',
        })
      }
      else if(new_pass != cf_new_pass){
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Ulangi Password Tidak Sama',
        })
      }else{
       $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Auth/change_pass",
        dataType: "json",
        data: {old_pass:old_pass, new_pass:new_pass},
        success : function(data){
          if (data.code == "200"){
            window.location.href = "<?php echo base_url(); ?>Auth/processlogout"; 
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
     
   });
  });
</script>