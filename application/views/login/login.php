<?php 

$data['title_page'] = "Login | NombreSistema";
$this->load->view('partial/header_login', $data);

?>
		<link href="<?php echo base_url();?>assets/vendor/sweetalert/sweet-alert.css" rel="stylesheet" media="screen">
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body class="login" style="background: url('<?php echo base_url()."assets/images/login.jpg";?>') no-repeat center center fixed;background-size: 1736px;">
		<!-- start: LOGIN -->
		<div class="row">
			<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
				<div class="logo margin-top-30">
					<img src='<?php echo base_url()."assets/images/login.png";?>' style="height: 151px;margin-left: 94px;">
				</div>
				<!-- start: LOGIN BOX -->
				<div class="box-login">
					<form class="form-login" action="index.html">
						<fieldset>
							<legend>
								SIMCE
							</legend>
							<p style="color:#FFFFFF;">
								Por favor, ingresa tu Rut y tu contraseña.
							</p>
							<div class="form-group">
								<span class="input-icon">
									<input id="rut" type="text" class="form-control" name="username" placeholder="12.123.123-4">
									<label class="label label-danger" id="rut-incorrecto">Rut Incorrecto</label>
									<i class="fa fa-user"></i> </span>
							</div>
							<div class="form-group form-actions">
								<span class="input-icon">
									<input id="pas" type="password" class="form-control password" name="password" placeholder="Contraseña">
									<i class="fa fa-lock"></i>
								</span>
							</div>
							<div class="form-actions">
								
								<button type="submit" class="btn btn-primary pull-right">
									Entrar <i class="fa fa-arrow-circle-right"></i>
								</button>
							</div>
						</fieldset>
					</form>
					<!-- start: COPYRIGHT -->
					<div class="copyright" style="color:#FFFFFF;">
							&copy; <span class="current-year"></span><span class="text-bold text-uppercase"> MIDETEED 2016 (v 2.0) </span>. <span>Desarrollado por Aeduc</span>
					</div>
					<!-- end: COPYRIGHT -->
				</div>
				<!-- end: LOGIN BOX -->
			</div>
		</div>


		<script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
		<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>assets/vendor/modernizr/modernizr.js"></script>
		<script src="<?php echo base_url();?>assets/vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="<?php echo base_url();?>assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="<?php echo base_url();?>assets/vendor/switchery/switchery.min.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="<?php echo base_url();?>assets/vendor/jquery-validation/jquery.validate.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CLIP-TWO JAVASCRIPTS -->
		<script src="<?php echo base_url();?>assets/js/main.js"></script>
		<!-- start: JavaScript Event Handlers for this page -->
		<script src="<?php echo base_url();?>assets/js/login.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.Rut.js"></script>
				<script src="<?php echo base_url();?>assets/vendor/sweetalert/sweet-alert.min.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
			});
		</script>
		<script type="text/javascript">
			var rutEsValido = false;
			$("#rut-incorrecto").hide();
			var form = $('.form-login');
			var errorHandler = $('.errorHandler', form);
			form.validate({
				rules : {
					username : {
						required : true
					},
					password : {
						required : false
					}

				},
				submitHandler : function(form) {
					errorHandler.hide();
					if (rutEsValido) {
						var param = {
							username : $("#rut").val(),
							password : $("#pas").val()
						};
						$.ajax({
							data: param,
							url : '<?php echo base_url();?>index.php/login/login_check',
							type: 'post',
							success: function(response){
								
								if (!response) {
									console.log(response);
									swal({
										title: "Error de Usuario o Contraseña",
										confirmButtonColor: "#d9534f",
										type: "error"
									});
								}
								else{location.reload();};
							}
						});
					}else{
						$("#rut-incorrecto").show();	
						swal({
							title: "Por favor, verifica tu rut",
							confirmButtonColor: "#007AFF",
							type: "error"
						});
					};
				},
				invalidHandler : function(event, validator) {//display error alert on form submit
				}
			});

			$('#rut').Rut({
     			on_error: function(){ 
					$("#rut-incorrecto").show();
     			},
      			format_on: 'keyup',
      			on_success: function(){
      				rutEsValido = true;
      				$("#rut-incorrecto").hide();
      			}
    		});

		</script>
		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->
	</body>
	<!-- end: BODY -->
</html>