<?php 

$data['title_page'] = "Home | Alumnos";
$this->load->view('partial/header', $data);

?>
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
							<span>PRUEBAS PENDIENTES</span>
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
											<span class='title'> ".$row->ensayos_pendientes."</span>
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
										<span class="username"><?php echo $usuario;?>
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
									<h1 class="mainTitle"><?php echo $data['title_page']; ?></h1>
									<span class="mainDescription">Bienvenido %NOMBREALUMNO%!</span>
								</div>
								<div class="col-sm-5">
									<!-- start: MINI STATS WITH SPARKLINE -->
									
									<!-- end: MINI STATS WITH SPARKLINE -->
								</div>
							</div>
						</section>
						<!-- end: DASHBOARD TITLE -->
						<!-- start: FEATURED BOX LINKS -->
						<div class="container-fluid container-fullw bg-white">
							<div class="row">

								<div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-4x"> <i class="fa fa-square fa-stack-2x text-red"></i> <i class="fa fa-plus-square fa-stack-1x fa-inverse "></i> </span>
											<h2 class="StepTitle">720pts.</h2>
											<p class="text-small">
												Matematicas
											</p>
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