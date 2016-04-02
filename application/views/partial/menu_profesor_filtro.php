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
		<a href="#" id='menu-filtro'>
			<div class="item-content">
				<div class="item-media">
					<i class="ti-filter"></i>
				</div>
				<div class="item-inner">
					<span class="title"> Filtro </span>
				</div>
			</div>
		</a>
	</li>
	
		<li ng-class="{'active open':$state.includes('app.ui')}" class="open" style='display:none;' id='menu-filtro-tipo'>
			<a href="javascript:void(0)">
				<div class="item-content">
					<div class="item-media">
						<i class="ti-ruler-pencil"></i>
					</div>
					<div class="item-inner">
						<span class="title ng-scope" translate="sidebar.nav.element.MAIN">Tipo</span><i class="icon-arrow"></i>
					</div>
				</div>
			</a>

			<ul class="sub-menu" style="display: none;">
				
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#" class="tipo" value="simce">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">SIMCE</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.icons" href="#" class="tipo" value="pme">
						<span class="title ng-scope" translate="sidebar.nav.element.FONTAWESOME">PME</span>
					</a>
				</li>
			</ul>
		</li>
		<li ng-class="{'active open':$state.includes('app.ui')}" class="open" style='display:none;' id='menu-filtro-evaluacion'>
			<a href="javascript:void(0)">
				<div class="item-content">
					<div class="item-media">
						<i class="ti-ruler-pencil"></i>
					</div>
					<div class="item-inner">
						<span class="title ng-scope" translate="sidebar.nav.element.MAIN">Evaluacion</span><i class="icon-arrow"></i>
					</div>
				</div>
			</a>

			<ul class="sub-menu" style="display: none;" id='simce'>
				
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#" class="evaluacion" value="simce1">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">1ra</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#" class="evaluacion" value="simce2">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">2da</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#" class="evaluacion" value="simce3">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">3ra</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#" class="evaluacion" value="simce4">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">4ta</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#" class="evaluacion" value="simce5">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">5ta</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#" class="evaluacion" value="simce6">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">6ta</span>
					</a>
				</li>
			</ul>
			<ul class="sub-menu" style="display: none;" id='pme'>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#" class="evaluacion" value="pme1">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">DIAGNOSTICO</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#" class="evaluacion" value="pme2">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">INTERMEDIA</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#" class="evaluacion" value="pme3">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">FINAL</span>
					</a>
				</li>		
			</ul>
			
		</li>
		<li ng-class="{'active open':$state.includes('app.ui')}" class="open" style='display:none;' id='menu-filtro-ensenanza'>
			<a href="javascript:void(0)">
				<div class="item-content">
					<div class="item-media">
						<i class="ti-ruler-pencil"></i>
					</div>
					<div class="item-inner">
						<span class="title ng-scope" translate="sidebar.nav.element.MAIN">Enseñanza</span><i class="icon-arrow"></i>
					</div>
				</div>
			</a>

			<ul class="sub-menu" style="display: none;">
				
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#" class='ensenanza' value='basica'>
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">BASICA</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.icons" href="#" class='ensenanza' value='media'>
						<span class="title ng-scope" translate="sidebar.nav.element.FONTAWESOME">MEDIA</span>
					</a>
				</li>
			</ul>
		</li>
		<li ng-class="{'active open':$state.includes('app.ui')}" class="open" style='display:none;' id='menu-filtro-nivel'>
			<a href="javascript:void(0)">
				<div class="item-content">
					<div class="item-media">
						<i class="ti-ruler-pencil"></i>
					</div>
					<div class="item-inner">
						<span class="title ng-scope" translate="sidebar.nav.element.MAIN">Nivel</span><i class="icon-arrow"></i>
					</div>
				</div>
			</a>

			<ul class="sub-menu" style="display: none;" id='basica'>
				
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#/app/ui/links" class="nivel" value="primero">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">PRIMERO</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#/app/ui/links" class="nivel" value="segundo">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">SEGUNDO</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#/app/ui/links" class="nivel" value="tercero">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">TERCERO</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#/app/ui/links" class="nivel" value="cuarto">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">CUARTO</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#/app/ui/links" class="nivel" value="quinto">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">QUINTO</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#/app/ui/links" class="nivel" value="sexto">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">SEXTO</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#/app/ui/links" class="nivel" value="7">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">SEPTIMO</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#/app/ui/links" class="nivel" value="8">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">OCTAVO</span>
					</a>
				</li>
			</ul>

			<ul class="sub-menu" style="display: none;" id='media'>
				
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#/app/ui/links" class="nivel" value="primero">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">PRIMERO</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#/app/ui/links" class="nivel" value="segundo">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">SEGUNDO</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#/app/ui/links" class="nivel" value="tercero">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">TERCERO</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#/app/ui/links" class="nivel" value="cuarto">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">CUARTO</span>
					</a>
				</li>
				
			</ul>

		</li>
		<li ng-class="{'active open':$state.includes('app.ui')}" class="open" style='display:none;' id='menu-filtro-subsector'>
			<a href="javascript:void(0)">
				<div class="item-content">
					<div class="item-media">
						<i class="ti-ruler-pencil"></i>
					</div>
					<div class="item-inner">
						<span class="title ng-scope" translate="sidebar.nav.element.MAIN">Subsector</span><i class="icon-arrow"></i>
					</div>
				</div>
			</a>

			<ul class="sub-menu" style="display: none;">
				
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#" class="subsector" value="lenguaje">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">LENGUAJE Y COMUNICACIÓN</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#" class="subsector" value="matematicas">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">MATEMATICAS</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#" class="subsector" value="ciencias">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">CIENCIAS NATURALES</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#" class="subsector" value="historia">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">HISTORIA Y GEOGRAFÍA</span>
					</a>
				</li>
				<li ui-sref-active="active">
					<a ui-sref="app.ui.links" href="#" class="subsector" value="formacion">
						<span class="title ng-scope" translate="sidebar.nav.element.LINKS">FORMACIÓN CIUDADANA</span>
					</a>
				</li>
				
			</ul>
		</li>
	

	<li>
		<a href="<?php echo base_url();?>index.php/profesor">
			<div class="item-content">
				<div class="item-media">
					<i class="ti-check-box"></i>
				</div>
				<div class="item-inner">
					<span class="title"> Ayuda </span>
				</div>
			</div>
		</a>
	</li>
</ul>
						<!-- end: MAIN NAVIGATION MENU -->
