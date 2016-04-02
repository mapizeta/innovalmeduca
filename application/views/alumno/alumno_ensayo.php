<?php 

$this->load->view('partial/header');

?>
	<!-- end: HEAD -->
	<style>
		.carousel-indicators .active{ background: #31708f; } 
		.content{ margin-top:20px; } 
		.adjust1{ float:left; width:100%; margin-bottom:0; } 
		.adjust2{ margin:0; } 
		.carousel-indicators li{ border :1px solid #ccc; } 
		.carousel-control{ color:#31708f; width:5%; } 
		.carousel-control:hover, 
		.carousel-control:focus{ color:#31708f; } 
		.carousel-control.left, 
		.carousel-control.right { background-image: none; } 
		.media-object{ margin:auto; margin-top:15%; } 
		@media screen and (max-width: 768px) { .media-object{ margin-top:0; } }

		.btn-block {
			display: inline;
			width: 41%;
			}
		.badge-inverse {
			background-color: #C9BEBE;
		}
		.modal-content {
			background: #FFFFFF;
		}	
	</style>	
	<body>
		<div id='loadingDiv'>								 
    		Please wait...  <img src="<?php echo base_url()."assets/images/loading_spinner.gif";?>" />
 		</div> 
		<div id="app">
			<div id="modales_instrucciones">
			</div>
			<div id="modales_recursos">
			</div>
			<div id="modales">	
				<!-- MODAL RIGHT -->
			<div class="modal fade modal-aside horizontal right bs-example-modal-right in" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="false" style="display: none;"><div class="modal-backdrop fade in" style="height: 100%;"></div>
				<div class="modal-dialog modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
							<h4 class="modal-title" id="myModalLabel">Preguntas Respondidas</h4>
						</div>
						<div class="modal-body preguntas_respondidas">
							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary btn-o" data-dismiss="modal">
								Cerrar
							</button>
							<button type="button" class="btn btn-primary">
								Finalizar Ensayo
							</button>
						</div>
					</div>
				</div>
			</div>
		<!--  FIN MODAL RIGHT  -->
		<!-- MODAL ABOUT -->
		<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">Modal title</h4>
					</div>
					<div class="modal-body">
						Modal Content
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary btn-o" data-dismiss="modal">
							Close
						</button>
						<button type="button" class="btn btn-primary">
							Save changes
						</button>
					</div>
				</div>
			</div>
		</div>
		<!-- FIN ABOUT MODAL-->
			</div>
			




			<!-- sidebar -->
			<div class="sidebar app-aside" id="sidebar">
				<div class="sidebar-container perfect-scrollbar">
					<nav>
						<!-- start: MAIN NAVIGATION MENU -->
						<div class="navbar-title">
							<span>MENU</span>
						</div>
						<ul class="main-navigation-menu">
							<li class="active open">
								<a href="index.html">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-home"></i>
										</div>
										<div class="item-inner">
											<span class="title"> Home </span>
										</div>
									</div>
								</a>
							</li>
						</ul>
						<!-- end: MAIN NAVIGATION MENU -->
						<!-- start: CORE FEATURES -->
						<div class="navbar-title">
							<span>ENSAYOS PENDIENTES</span>
						</div>
						<ul class="folders">
							<?php 
							foreach ($pendiente as $row) {
								echo "<li>
								<a href='".base_url()."index.php/alumno/ensayo/".$row->id_prueba."'>
									<div class='item-content'>
										<div class='item-media'>
											<span class='fa-stack'> <i class='fa fa-square fa-stack-2x'></i> <i class='fa fa-edit fa-stack-1x fa-inverse'></i> </span>
										</div>
										<div class='item-inner'>
											<span class='title'> ".$row->nombre."</span>
										</div>
									</div>
								</a>
							</li>";
							}
								
							?>
						</ul>
						<!-- end: CORE FEATURES -->
						<!-- start: DOCUMENTATION BUTTON -->
						<div class="wrapper">
							<a href="#" class="button-o">
								<span>BANNER UMT</span>
							</a>
						</div>
						<!-- end: DOCUMENTATION BUTTON -->
					</nav>
				</div>
			</div>
			<!-- / sidebar -->
			<div class="app-content">
				<!-- start: TOP NAVBAR -->
				<header class="navbar navbar-default navbar-static-top">
					<!-- start: NAVBAR HEADER -->
					<div class="navbar-header">
						<a href="#" class="sidebar-mobile-toggler pull-left hidden-md hidden-lg" class="btn btn-navbar sidebar-toggle" data-toggle-class="app-slide-off" data-toggle-target="#app" data-toggle-click-outside="#sidebar">
							<i class="ti-align-justify"></i>
						</a>
						<a class="navbar-brand" href="#">
							IMAGEN LOGO
						</a>
						<div id="containercmenubar">
						<a href="#" id="cmenubar" class="sidebar-toggler pull-right visible-md visible-lg" data-toggle-class="app-sidebar-closed" data-toggle-target="#app">
							<i class="ti-align-justify"></i>
						</a>
						</div>
						<a class="pull-right menu-toggler visible-xs-block" id="menu-toggler" data-toggle="collapse" href=".navbar-collapse">
							<span class="sr-only">Colapsar MENU</span>
							<i class="ti-view-grid"></i>
						</a>
					</div>
					<!-- end: NAVBAR HEADER -->
					<!-- start: NAVBAR COLLAPSE -->
					<div class="navbar-collapse collapse">
						<ul class="nav navbar-right">
							<!-- start: USER OPTIONS DROPDOWN -->
							<li class="dropdown current-user">
								<a href class="dropdown-toggle" data-toggle="dropdown">
									<div class="item-media">
										<span class="fa-stack"> <i class="fa fa-user"></i> </span>
										<span class="username"><?php echo $usuario; ?>
											<i class="ti-angle-down"></i>
										</span>
									</div>
								</a>
								<ul class="dropdown-menu dropdown-dark">
									<li>
										<a href="#" data-toggle="modal" data-target=".bs-example-modal-sm">
											Acerca de...
										</a>
									</li>
									<li>
										<a href="<?php echo base_url();?>index.php/login/logout">
											Cerrar Sesión
										</a>
									</li>
								</ul>
							</li>
							<!-- end: USER OPTIONS DROPDOWN -->
						</ul>
						<!-- start: MENU TOGGLER FOR MOBILE DEVICES -->
						<div class="close-handle visible-xs-block menu-toggler" data-toggle="collapse" href=".navbar-collapse">
							<div class="arrow-left"></div>
							<div class="arrow-right"></div>
						</div>
						<!-- end: MENU TOGGLER FOR MOBILE DEVICES -->
					</div>
					<!-- end: NAVBAR COLLAPSE -->
				</header>
				<!-- end: TOP NAVBAR -->

				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<!-- start: DASHBOARD TITLE -->
						<section id="page-title" class="padding-top-15 padding-bottom-15">
							<div class="row">
								<div class="col-sm-7">
									<h1 class="mainTitle"><?php echo $title_page; ?></h1>
									<span class="mainDescription">Bienvenido <?php echo $usuario; ?>!</span>
								</div>
								<div class="col-sm-5">
									<!-- start: MINI STATS WITH SPARKLINE -->
									<div class="text-right">
										<span class="btn btn-danger" id="btnRecurso" idRecurso="1" href="#"><i class="fa fa-file-text"></i> Recurso</span>
										<span class="btn btn-danger" id="btnInstruccion" idInstruccion="1" href="#"><i class="fa fa-file-text"></i> Instrucciones</span>
												
										
										<button type="button" class="btn btn-primary btn-block btn-scroll btn-scroll-top ti-arrow-right" data-toggle="modal" data-target=".bs-example-modal-right" id="preguntas_respondidas_btn">
											<span>Preguntas Respondidas</span>
										</button>
										
										<!--<span class="label label-default" >Preguntas Respondidas: 10</span>-->
									</div>
									<!-- end: MINI STATS WITH SPARKLINE -->
								</div>
							</div>
						</section>
						<!-- end: DASHBOARD TITLE -->
						<!-- start: FEATURED BOX LINKS -->
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="text-center">
									<ul class="pagination-sm pagination"></ul>
									<div id="pregunta" class="well text-left">

									


		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel"> 
	
	<div class="carousel-inner"> 




</div>

</div>






									
									</div>
									<ul class="pagination-sm pagination"></ul>		
								</div>
								<div class="text-center">
									<button type="button" class="btn btn-squared btn-success btn-wide btn-scroll btn-scroll-top ti-write">
										<span>Finalizar Prueba</span>
									</button>
								</div>
							</div>
						</div>
						<!-- end: FEATURED BOX LINKS -->
					</div>
				</div>
			</div>

<?php 

$this->load->view('partial/footer');

?>

<!-- start: Script paginacion alumnos -->
<script src="<?php echo base_url();?>assets/vendor/twbs-pagination/jquery.twbsPagination.js"></script>
<!-- end: Script paginacion alumnos -->
<script type="text/javascript">

	$(document).ready(function() {

		$('#loadingDiv').hide().ajaxStart( function() 
			{
				$(this).show();  // show Loading Div
			} ).ajaxStop ( function()
			{
				$(this).hide(); // hide loading div
			});

		$(".carousel-inner").load("<?php echo base_url()."index.php/alumno/ensayo_table/$id_ensayo"; ?>");
		$("#modales_recursos").load("<?php echo base_url()."index.php/alumno/recursos_modal/$id_ensayo"; ?>");
		$("#modales_instrucciones").load("<?php echo base_url()."index.php/alumno/instrucciones_modal/$id_ensayo"; ?>");
	});

	$("input:radio").click(function()
	{
    	var id_prueba_has_pregunta = $( this ).attr('id_prueba_has_pregunta');
    	var id_respuesta = $( this ).attr('id');

    	//console.log($( this ).attr('id'));
    	
    	var formData = {id_prueba_has_pregunta:id_prueba_has_pregunta, id_respuesta:id_respuesta};
    	$.ajax({
						
					url : '<?php echo base_url();?>index.php/alumno/respuesta',
					type: 'post',
					data: formData,
					success: function(response)
					{
						
						if (response != 1) {
							console.log("correctamente respondida");
							
						}

						else
							console.log("error al ingresar respuesta");

					}
					});
	});


/*
	$('.recurso').on('click', function () {
      $.fancybox({
          type: 'iframe',
          maxHeight : 190,
          href: $( this ).attr('href'),
          padding: 1
      });
      return false;
    });
*/
	$('#preguntas_respondidas_btn').on('click', function () {
      console.log('preguntas_respondidas');
       $(".preguntas_respondidas").load("<?php echo base_url()."index.php/alumno/preguntas_respondidas/$id_ensayo"; ?>");
    });

	$(".pagination").twbsPagination({
		totalPages: 80, //nro preguntas
		visiblePages: 10, 
		onPageClick: function(event, page) {
		setTimeout(function()
		{
		
        var idRecurso = $( "div.active" ).attr( "id_recurso" );
        var idInstruccion = $( "div.active" ).attr( "id_instruccion" );

       		if(idInstruccion == 0)
       		{
       			console.log("sin instruccion");
       			$("#btnInstruccion").css( "display", "none" );
       		}
       		else
       		{
       			//instrucciones
				
       			$("#btnInstruccion").css( "display", "show" );
       			$("#btnInstruccion").attr("data-toggle", "modal");
       			$("#btnInstruccion").attr("data-target", "#idInstruccion"+idInstruccion);
				$("#btnInstruccion").attr("idInstruccion", idPregunta);
       		}

       		if(idRecurso == 0)
       		{
       			console.log("sin recurso");
       			$("#btnRecurso").css( "display", "none" );
       		}
       		else
       		{
       			//recursos
       			
       			$("#btnRecurso").css( "display", "show" );
       			$("#btnRecurso").attr("data-toggle", "modal");
       			$("#btnRecurso").attr("data-target", "#idRecurso"+idRecurso);
				$("#btnRecurso").attr("idRecurso", idPregunta);
			
       		}	
						
			console.log(idPregunta);
		}, 800);

		var suma = parseInt(page) - 1;
		$(".carousel").carousel(suma);
		}
	});

</script>