
<!-- Control Sidebar -->
<aside class="control-sidebar">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- Main Footer -->

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap4.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>dist/js/adminlte.js"></script>

<!-- PAGE <?php echo base_url(); ?>plugins -->
<!-- jQuery Mapael -->
<script src="<?php echo base_url(); ?>plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?php echo base_url(); ?>plugins/raphael/raphael.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url(); ?>plugins/chart.js/Chart.min.js"></script>
<!--
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
-->
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/autoNumeric.min.js"></script>
<!-- AdminLTE for demo purposes -->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script type="text/javascript">
  $('#myModal').on('shown.bs.modal', function () {
    $('#myInput').trigger('focus')
  })

  $(document).ready(function() {
    $('.select2').select2();
  });

    
</script>

<script type="text/javascript">
 

</script>

<script type="text/javascript">
  new DataTable('#example');
  
</script>


<script src="<?php echo base_url(); ?>dist/js/pages/dashboard2.js"></script>
</body>
</html>