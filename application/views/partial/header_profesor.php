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
		<!--<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style_alumnos.css">
		 NACHO //17/12/2016 -->
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
        
        <!-- NACHO //17/12/2016 -->

        <script src="<?php echo base_url();?>assets/js/otros/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.min.css">
        <script src="<?php echo base_url();?>assets/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/pregunta-ensayo.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style_alumnos.css">
        <script src="<?php echo base_url();?>assets/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
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
						<?php
							/*Menu botones*/
							$this->load->view('partial/menu_profesor');
						?>	
						
					</nav>
				</div>
			</div>
			<!-- / sidebar -->
			<div class="app-content">
				<!-- start: TOP NAVBAR -->
				<header class="navbar navbar-default navbar-static-top">
					<!-- start: NAVBAR HEADER -->
					<div class="navbar-header" >
						<a href="#" class="sidebar-mobile-toggler pull-left hidden-md hidden-lg" class="btn btn-navbar sidebar-toggle" data-toggle-class="app-slide-off" data-toggle-target="#app" data-toggle-click-outside="#sidebar">
							<i class="ti-align-justify"></i>
						</a>
						<a class="navbar-brand" href="#"  style="background-image: url(http://aeduc.cl/images/logo_nav.svg); background-size: 171px;background-repeat: no-repeat;margin-left: 32px;margin-top: 3px;margin-right: -24px;">
						
						</a>
						<a href="#" class="sidebar-toggler pull-right visible-md visible-lg" data-toggle-class="app-sidebar-closed" data-toggle-target="#app" style="margin-left: -3px;">
							
							<i class="ti-align-justify"></i>
						</a>
						<a class="pull-right menu-toggler visible-xs-block" id="menu-toggler" data-toggle="collapse" href=".navbar-collapse">
							<span class="sr-only">Colapsar MENU</span>
							<i class="ti-view-grid"></i>
						</a>
					</div>
					<!-- end: NAVBAR HEADER -->
			<div class="navbar-collapse collapse" >										
				<div class="dropdown" style="
					    float: right;
					    margin-right: -17px;
					    position: relative;
					    background-color: #2C3541;
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
			</div>
		</header>
				<!-- end: TOP NAVBAR -->