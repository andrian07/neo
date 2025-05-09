<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BackOffice</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/fontawesome-free/css/all.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
	<div class="login-box">
		<!-- /.login-logo -->
		<div class="card card-outline card-primary">
			<div class="card-header text-center">
				<a href="" class="h1"><b>Login</b></a>
			</div>
			<div class="card-body">
				<p class="login-box-msg">Sign in to start your session</p>
				<form action="../../index3.html" method="post">
					<div class="input-group mb-3">
						<input type="text" id="username" class="form-control" placeholder="Username">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-user"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="password" id="password" class="form-control" placeholder="Password">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<!-- /.col -->
						<div class="col-12">
							<button type="button" id="login" class="btn btn-primary btn-block">Sign In</button>
						</div>
						<!-- /.col -->
					</div>
				</form>
				<!-- /.social-auth-links -->

			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->
	</div>
	<!-- /.login-box -->

	<!-- jQuery -->
	<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url(); ?>dist/js/adminlte.min.js"></script>

	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#login').click(function(e){
				e.preventDefault();
				var username = $("#username").val();
				var password = $("#password").val();

				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>Auth/processlogin",
					dataType: "json",
					data: {username:username, password:password},
					success : function(data){
						if (data.code == "200"){
							window.location.replace('<?php echo base_url();?>Dashboard');
						} else {
							Swal.fire({
								icon: 'error',
								title: 'Oops...',
								text: data.msg,
							})
						}
					}
				});
			});
		});
	</script>
</body>
</html>