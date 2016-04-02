<ul class="main-navigation-menu">
							<li>
								<a href="<?php echo site_url();?>">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-home"></i>
										</div>
										<div class="item-inner">
											<span class="title"> Inicio </span>
										</div>
									</div>
								</a>

							</li>

							<li>
								<a href="<?php echo base_url();?>index.php/prueba">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-file"></i>
										</div>
										<div class="item-inner">
											<span class="title"> Prueba </span>
										</div>
									</div>
								</a>
							</li>
							<li>
								<a href="<?php echo base_url();?>index.php/administrator/asignar_prueba">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-check-box"></i>
										</div>
										<div class="item-inner">
											<span class="title"> Asignaciones </span>
										</div>
									</div>
								</a>
							</li>
							<li ng-class="{'active open':$state.includes('app.ui')}" class>
								<a href="javascript:void(0)">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-bar-chart"></i>
										</div>
										<div class="item-inner">
											<span class="title ng-scope" translate="sidebar.nav.element.MAIN">Estadísticas</span><i class="icon-arrow"></i>
										</div>
									</div>
								</a>
								<ul class="sub-menu" style="display: none;">
									<li ui-sref-active="active">
										<a ui-sref="app.ui.elements" href="<?php echo base_url();?>index.php/administrator/stats_profe/">
											<span class="title ng-scope" translate="sidebar.nav.element.ELEMENTS">Acceso Profesores</span>
										</a>
									</li>
								</ul>
							</li> 
							<li ng-class="{'active open':$state.includes('app.ui')}" class>
								<a href="javascript:void(0)">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-settings"></i>
										</div>
										<div class="item-inner">
											<span class="title ng-scope" translate="sidebar.nav.element.MAIN">Miscelaneos</span><i class="icon-arrow"></i>
										</div>
									</div>
								</a>
								<ul class="sub-menu" style="display: none;">
									<li ui-sref-active="active">
										<a ui-sref="app.ui.elements" href="<?php echo base_url();?>index.php/administrator/importar_alumnos">
											<span class="title ng-scope" translate="sidebar.nav.element.ELEMENTS">Importar Alumnos</span>
										</a>
									</li>
									<li ui-sref-active="active">
										<a ui-sref="app.ui.elements" href="<?php echo base_url();?>index.php/administrator/asignar_cursos">
											<span class="title ng-scope" translate="sidebar.nav.element.ELEMENTS">Asignación de Cursos</span>
										</a>
									</li>
									<li ui-sref-active="active">
										<a ui-sref="app.ui.elements" href="<?php echo base_url();?>index.php/administrator/crear_colegio">
											<span class="title ng-scope" translate="sidebar.nav.element.ELEMENTS">Crear Colegio</span>
										</a>
									</li>
								</ul>
							</li> 

						</ul>
						<!-- end: MAIN NAVIGATION MENU -->
