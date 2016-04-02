<?php 

$data['title_page'] = "Control Ensayo | Profesor";
$this->load->view('partial/header', $data);

?>
<style type="text/css">
	.text-black{
		color: black;
	}
</style>
	<!-- end: HEAD -->
	<body>
		<div id="app">
			<!-- sidebar -->
			<div class="sidebar app-aside" id="sidebar">
				<div class="sidebar-container perfect-scrollbar">
					<nav>
						<!-- start: MAIN NAVIGATION MENU -->
						<div class="navbar-title">
							<span>MENU</span>
						</div>
						<ul class="main-navigation-menu">
							<li>
								<a href="<?php echo base_url();?>index.php/profesor">
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
							<li>
								<a href="<?php echo base_url();?>index.php/profesor/ensayos">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-file"></i>
										</div>
										<div class="item-inner">
											<span class="title"> Ensayos </span>
										</div>
									</div>
								</a>
							</li>
							<li class="active open">
								<a href="#">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-target"></i>
										</div>
										<div class="item-inner">
											<span class="title"> Control Ensayo </span>
										</div>
									</div>
								</a>
							</li>
						</ul>
						<!-- end: MAIN NAVIGATION MENU -->
						<!-- start: CORE FEATURES -->
						<div class="navbar-title">
							<span>PRUEBAS PENDIENTES</span>
						</div>
						<ul class="folders">
							¿?
						</ul>
						<!-- end: CORE FEATURES -->
						<!-- start: DOCUMENTATION BUTTON -->
						<div class="wrapper">
							<a href="#" class="button-o">
								<span>SOPORTE TECNICO</span>
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
						<a href="#" class="sidebar-toggler pull-right visible-md visible-lg" data-toggle-class="app-sidebar-closed" data-toggle-target="#app">
							<i class="ti-align-justify"></i>
						</a>
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
										<span class="username">Apellido, Nombre
											<i class="ti-angle-down"></i>
										</span>
									</div>
								</a>
								<ul class="dropdown-menu dropdown-dark">
									<li>
										<a href="#">
											Editar mis datos
										</a>
									</li>
									<li>
										<a href="#">
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
									<h1 class="mainTitle"><?php echo $data['title_page']; ?></h1>
									<span class="mainDescription">Bienvenido %NOMBREPROFESOR%!</span>
								</div>
								<div class="col-sm-5 text-center">
									<!-- start: MINI STATS WITH SPARKLINE -->
									<span class="badge badge-success">Finalizados 23</span>
									<span class="badge badge-primary">Online 14</span>
									<span class="badge badge-warning">Bloqueados 2 </span>
									<span class="badge badge-inverse">Inasistentes 1</span>
									<!-- end: MINI STATS WITH SPARKLINE -->
								</div>
							</div>
						</section>
						<!-- end: DASHBOARD TITLE -->
						<!-- start: FEATURED BOX LINKS -->
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-sm-12 text-center">
									<h1> Control de Ensayo: Matematicas Ensayo 1</h1>
									<hr>
									<div class="col-sm-4 text-left">
											<button type="button" class="btn btn-wide btn-success  col-sm-12">
												Finalizar Prueba
											</button>
										<h3>Hora Inicio</h3>
										<h2 class="text-center">15:00:05 Hrs</h2>
									</div>
									<div class="col-sm-4 text-left">
											<button type="button" class="btn btn-wide btn-warning  col-sm-12">
												Desbloquear Todos
											</button>
										<h3>Tiempo Transcurrido</h3>
										<h2 class="text-center">00:36:35 Hrs</h2>
									</div>
									<div class="col-sm-4 text-left">
											<button type="button" class="btn btn-wide btn-danger  col-sm-12">
												Bloquear Alumno
											</button>
										<h3>Hora Finalizacion</h3>
										<h2 class="text-center">17:30:05 Hrs</h2>
									</div>

									<div class="col-sm-3 text-left">
										<div class="panel panel-white">
												<div class="panel-heading">
													<h4 class="panel-title text-green"><strong> Alumnos Finalizados </strong></h4>
												</div>
												<div class="panel-body">
													<div class="panel-scroll height-180 ps-container ps-active-y">
																<ol>
																	<?php 
																	for ($i=0; $i < 23; $i++) { 
																		echo "<li><a href='#' class='text-success'>Federico</a></li>";
																	}
																	?>
																</ol>
													<div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; height: 180px; right: 3px;"><div class="ps-scrollbar-y" style="top: 0px; height: 86px;"></div></div></div>
												</div>
											</div>
									</div>
									<div class="col-sm-3 text-left">
										<div class="panel panel-white">
												<div class="panel-heading">
													<h4 class="panel-title text-blue"><strong>Alumnos Online</strong></h4>
												</div>
												<div class="panel-body">
													<div class="panel-scroll height-180 ps-container ps-active-y">
																<ol>
																	<?php 
																	for ($i=0; $i < 14; $i++) { 
																		echo "<li><a href='#' class='text-info'>Juan</a></li>";
																	}
																	?>
																</ol>
													<div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; height: 180px; right: 3px;"><div class="ps-scrollbar-y" style="top: 0px; height: 86px;"></div></div></div>
												</div>
											</div>
									</div>
									<div class="col-sm-3 text-left">
										<div class="panel panel-white">
												<div class="panel-heading">
													<h4 class="panel-title text-orange"><strong>Alumnos Bloqueados</strong></h4>
												</div>
												<div class="panel-body">
													<div class="panel-scroll height-180 ps-container ps-active-y">
																<ol>
																	<?php 
																	for ($i=0; $i < 2; $i++) { 
																		echo "<li><a href='#' class='text-orange'>Pepe</a></li>";
																	}
																	?>
																</ol>
													<div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; height: 180px; right: 3px;"><div class="ps-scrollbar-y" style="top: 0px; height: 86px;"></div></div></div>
												</div>
											</div>
									</div>
									<div class="col-sm-3 text-left">
										<div class="panel panel-white">
												<div class="panel-heading">
													<h4 class="panel-title text-black"><strong>Alumnos Inasistentes</strong></h4>
												</div>
												<div class="panel-body">
													<div class="panel-scroll height-180 ps-container ps-active-y">
																<ol>
																	<?php 
																	for ($i=0; $i < 1; $i++) { 
																		echo "<li><a href='#' class='text-black'>Julio</a></li>";
																	}
																	?>
																</ol>
													<div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; height: 180px; right: 3px;"><div class="ps-scrollbar-y" style="top: 0px; height: 86px;"></div></div></div>
												</div>
											</div>
									</div>

											
								</div>
							</div>
						</div>
						<!-- end: FEATURED BOX LINKS -->
					</div>
				</div>
			</div>


<?php 
$data['close_menu'] = false;
$this->load->view('partial/footer', $data);
?>