<!DOCTYPE html>
<!-- Template Name: Clip-Two - Responsive Admin Template build with Twitter Bootstrap 3.x | Author: ClipTheme -->
<!--[if IE 8]><html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>
		<title><?php echo $title_page;?></title>
		<!-- start: META -->
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="Araucanía Educativa" name="description" />
		<meta content="AEDUC " name="author" />
		<!-- end: META -->
		<!-- start: GOOGLE FONTS -->
		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
		<!-- end: GOOGLE FONTS -->
		<!-- start: MAIN CSS -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/themify-icons/themify-icons.min.css">
		<link href="<?php echo base_url();?>assets/vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="<?php echo base_url();?>assets/vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="<?php echo base_url();?>assets/vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
		<!-- end: MAIN CSS -->
		<!-- start: CLIP-TWO CSS -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/styles.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/checks.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/plugins.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/themes/theme-5.css" />
		
		<!-- NACHO //17/12/2016 -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.min.css">
		
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/btn_crear_prueba.css">
		
		<!-- end: CLIP-TWO CSS -->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
		
		<!-- start: MAIN JAVASCRIPTS -->
		<script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
		<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>assets/vendor/modernizr/modernizr.js"></script>
		<script src="<?php echo base_url();?>assets/vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="<?php echo base_url();?>assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="<?php echo base_url();?>assets/vendor/switchery/switchery.min.js"></script>

		<link rel='stylesheet' href='<?php echo base_url();?>assets/css/dscountdown.css' type='text/css' media='all' >
		<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
		<!-- <script type="text/javascript" src="dscountdown.js"></script> -->
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/dscountdown.min.js"></script>

        
        <!-- NACHO //17/12/2016 -->

        <script src="<?php echo base_url();?>assets/js/otros/jquery.dataTables.min.js"></script>
		<link rel="stylesheet" href="<?php echo base_url();?>assets/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.min.css">
        <script src="<?php echo base_url();?>assets/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/pregunta-ensayo.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style_alumnos.css">
		<!-- end: MAIN JAVASCRIPTS -->

		
	</head>
		<!-- end: HEAD -->
	<body>
		<div id="app">
			<!-- sidebar -->
			<div class="sidebar app-aside" id="sidebar">
				<div class="sidebar-container perfect-scrollbar">
					<nav>
						<!-- start: MAIN NAVIGATION MENU -->
						<div class="navbar-title">
							<span>SISTEMA DE ADMINISTRACIÓN DE PRUEBAS</span>
						</div>
					<div class="nina" style="float: left; position: fixed; z-index: 5000; margin-top: 154px; margin-left: -252px;">
          				 <img style="margin-top: -153px; margin-left: 164px; margin-right: 13px;     opacity: 0.5; " src="<?php echo base_url().'assets/images/fondo.png'; ?>">
       				</div> 				
					</nav>
				</div>
			</div>
			<!-- / sidebar -->
			<div class="app-content">
				<!-- start: TOP NAVBAR -->
				<header class="navbar navbar-default navbar-static-top">
					<!-- start: NAVBAR HEADER -->
					<div class="navbar-header" >
						
						<a class="navbar-brand" href="#"  style="background-image: url(http://aeduc.cl/images/logo_nav.svg); background-size: 171px;background-repeat: no-repeat;margin-left: 32px;margin-top: 3px;margin-right: -24px;">
						
						</a>
						
						<a class="pull-right menu-toggler visible-xs-block" id="menu-toggler" data-toggle="collapse" href=".navbar-collapse">
							<span class="sr-only">Colapsar MENU</span>
							<i class="ti-view-grid"></i>
						</a>
					</div>
					<!-- end: NAVBAR HEADER -->
					<!-- start: NAVBAR COLLAPSE -->
					<div class="navbar-collapse collapse" >
					<!--
					<div class="input-group" style="margin-top: 16px;margin-left: 16px;">
					      <span class="input-group-addon"><span class="glyphicon glyphicon-search"></span> </span>
					      <input type="text" id="filtro" name="filtro">
					</div>-->


<!--

<div class="input-group" style="margin-top: 16px;margin-left: 16px;">
					      <span class="input-group-addon"><span class="glyphicon glyphicon-search"></span> </span>
					      <input type="text" id="filtro" name="filtro">
					</div>-->



					<div class="dropdown" style="
					    float: right;
					    margin-right: -17px;
					    position: relative;
					    background-color: #2F8FCE;
					    width: auto;
					    height: 64px;
						">   
					  <a class=" dropdown-toggle" style="margin-right: 21px;" type="button" id="menu1" data-toggle="dropdown">
						<span class="glyphicon glyphicon-user" style="color: white;font-size: 24px;margin-right: -18px;margin-left: 26px;margin-top: 16px;"></span>
					    <span class="username" style="color: white; font-size: 18px;margin-left: 27px;"><?php echo $usuario?></span>
					    <span class="caret" style="color: white;"></span>
					 </a>
					    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
					      <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url().'/login/logout';?>">Cerrar Sesión</a></li>
					    </ul>
					 </div>


<!--
						<ul >
							 
							<li class="dropdown current-user">
								<a href class="dropdown-toggle" data-toggle="dropdown">
									<div class="item-media">
										<span class="fa-stack"> <i class="fa fa-user" style="font-size: 41px; margin-top: 18px; color: white;"></i> </span>
										<span class="username"><?php echo ("  ".$usuario); ?>
											<i class="ti-angle-down" style="font-size: 41px; margin-top: 18px; color: white;"></i>
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
							 end: USER OPTIONS DROPDOWN 
						</ul>-->

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


				
