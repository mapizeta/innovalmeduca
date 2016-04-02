<?php 

$data['title_page'] = "Ensayos | Profesor";
$this->load->view('partial/header_buscador', $data);
$this->load-> helper('url');

?>

<div class="main-content" >

	<div class="wrap-content container" id="container">
						
		<!-- start: FEATURED BOX LINKS -->
		<div class="container-fluid container-fullw bg-white">

			<div class="row">
				<div class="col-sm-12">
					<div class="table-responsive">

						<div class="product-photo">
   						  <a style=" float: right; top:0px;" href="#">
     						  <span class='c_prueba' style='float: right;' ></span>						
  						  </a>
  						  <a style=" float: right; top:0px;" href="#">
     						  <span class='c_pregunta' style='float: right;' ></span>						
  						  </a>
  						  <a style=" float: right; top:0px;" href="#">
     						  <span class='c_alternativa' style='float: right;' ></span>						
  						  </a>
						</div> 
						<table class="table table-bordered table-hover table-striped" id="sample-table-1">
							<thead>
								<tr style="background-color: #50beef; ">
									<th style="color: white!important;">Subsector</th>
									<th style="color: white!important;">Tipo</th>
									<th style="color: white!important;">Nivel</th>
									<th style="color: white!important;">Letra</th>
									<th style="color: white!important;">Ensayo</th>
									<th style="color: white!important;">Acciones</th>
								</tr>
							</thead>
							<tbody>
								<tr >
									<td>
									Subsector 1
									</td>
									<td>SIMCE</td>
									<td>1</td>
									<td>A</td>
									<td>2</td>
									<td class="text-center">
										
											<a class="btn btn-default btn-sm btn-primary" href="#"><i class="glyphicon glyphicon-question-sign"></i> Preguntas</a>
											<a class="btn btn-default btn-sm btn-primary" href="#"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
											<a class="btn btn-default btn-sm  btn-primary" href="#"><i class="glyphicon glyphicon-eye-open" ></i> Visualizar</a>
											<a class="btn btn-default btn-sm btn-danger" href="#"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
										
										
									</td>
								</tr>
								<tr >
									<td>
									Subsector 1
									</td>
									<td>SIMCE</td>
									<td>1</td>
									<td>A</td>
									<td>2</td>
									<td class="text-center">
										
											<a class="btn btn-default btn-sm btn-primary" href="#"><i class="glyphicon glyphicon-question-sign"></i> Preguntas</a>
											<a class="btn btn-default btn-sm btn-primary" href="#"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
											<a class="btn btn-default btn-sm  btn-primary" href="#"><i class="glyphicon glyphicon-eye-open" ></i> Visualizar</a>
											<a class="btn btn-default btn-sm btn-danger" href="#"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
										
									</td>

								</tr >
								<tr >
									<td>
									Subsector 2
									</td>
									<td>SIMCE</td>
									<td>1</td>
									<td>A</td>
									<td>2</td>
									<td class="text-center">
										
											<a class="btn btn-default btn-sm btn-primary" href="#"><i class="glyphicon glyphicon-question-sign"></i> Preguntas</a>
											<a class="btn btn-default btn-sm btn-primary" href="#"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
											<a class="btn btn-default btn-sm  btn-primary" href="#"><i class="glyphicon glyphicon-eye-open" ></i> Visualizar</a>
											<a class="btn btn-default btn-sm btn-danger" href="#"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
										
									</td>
								</tr>
								<tr >
									<td>
									Subsector 3
									</td>
									<td>SIMCE</td>
									<td>2</td>
									<td>B</td>
									<td>2</td>
									<td class="text-center">
										
											<a class="btn btn-default btn-sm btn-primary" href="#"><i class="glyphicon glyphicon-question-sign"></i> Preguntas</a>
											<a class="btn btn-default btn-sm btn-primary" href="#"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
											<a class="btn btn-default btn-sm  btn-primary" href="#"><i class="glyphicon glyphicon-eye-open" ></i> Visualizar</a>
											<a class="btn btn-default btn-sm btn-danger" href="#"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
									</td>
									
								</tr>
								<tr >
									<td>
									Subsector 4
									</td>
									<td>SIMCE</td>
									<td>1</td>
									<td>A</td>
									<td>2</td>
									<td class="text-center">
										
											<a class="btn btn-default btn-sm btn-primary" href="#"><i class="glyphicon glyphicon-question-sign"></i> Preguntas</a>
											<a class="btn btn-default btn-sm btn-primary" href="#"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
											<a class="btn btn-default btn-sm  btn-primary" href="#"><i class="glyphicon glyphicon-eye-open" ></i> Visualizar</a>
											<a class="btn btn-default btn-sm btn-danger" href="#"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
									</td>
									
								</tr>

							</tbody>
						</table>
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
