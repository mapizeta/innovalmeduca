<?php 

$data['title_page'] = "Login | NombreSistema";
$this->load->view('partial/header_login', $data);

?>
		<link href="<?php echo base_url();?>assets/vendor/sweetalert/sweet-alert.css" rel="stylesheet" media="screen">
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body>
		<!-- start: LOGIN -->
	
	  <section id="content" class="m-t-lg wrapper-md animated fadeInUp">    
    <div class="container aside-xxl">
      
      <div class="logo margin-top-30">
					<img src='<?php echo base_url()."assets/images/logo3.png";?>' style="height: 127px;">
				</div>
      <section class="panel panel-default bg-white m-t-lg">
      	
        <form action="index.html" class="panel-body wrapper-lg form-login">
          <div class="form-group">
            <label class="control-label">Usuario</label>
            <input id="rut" type="text" placeholder="12.123.123-4" class="form-control input-lg" name="username">
          </div>
          <div class="form-group">
            <label class="control-label">Contraseña</label>
            <input type="password" id="pas" placeholder="Contraseña" class="form-control input-lg" name="password">
          </div>
          <button type="submit" class="btn btn-primary pull-left">
				Entrar
		  </button>          
          
          <!--<button type="submit" class="btn btn-primary">Entrar</button>-->
          
          <div class="line line-dashed"></div>
          <!-- <a href="#" class="btn btn-facebook btn-block m-b-sm"><i class="fa fa-facebook pull-left"></i>Sign in with Facebook</a> -->
          
          <div class="line line-dashed"></div>
          
        </form>
      </section>
    </div>
  </section>
  <!-- footer -->
  <footer id="footer">
    <div class="text-center padder">
      <p>
        <small>Innovalm Educa 2016 </span>. <span>Desarrollado por Innovalm</span></small>
      </p>
    </div>
  </footer>	

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