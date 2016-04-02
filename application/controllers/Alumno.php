<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once ("secure_area.php");

class Alumno extends Secure_area {

	public function __construct()
        {
            parent::__construct();
            $this->load->model('ensayo_model');
            $this->load->model('alumno_model');
            $this->load->model('prueba_model');
            $this->load->model('hojarespuesta_model');
            $this->load->model('asignacionprueba_model');
            $this->load->helper('date');

            if(!$this->usuario_model->has_permission($this->session->userdata('perfil'), 1))
			{
				redirect('no_access/'.$module_id);
			}
        }

	public function index()
	{
		
		$data_header['title_page'] = "Home | Alumnos";
		$data_header['usuario'] = $this->session->userdata('fullname');
		$data['close_menu'] = false;
		$data['id_usuario'] = $this->session->userdata('id_usuario');

		$this->load->view('partial/header_alumno', $data_header);;
		$this->load->view('alumno/home',$data);
		$this->load->view('partial/footer_alumno');
	}

 public function ensayo_asignado()
    {
 
    $id_usuario=$this->session->userdata('id_usuario');

        $contenido="";
        $contenido.="<thead><tr style='background-color: #50beef;'>
            <th style='color: white!important;'>Codigo</th>
            <th style='color: white!important;'>Subsector</th>
            <th style='color: white!important;'>Tipo</th>
            <th style='color: white!important;'>Acciones</th>
            </tr></thead>";

		if($ejecutar = $this->alumno_model->get_ejecucion($id_usuario))
        foreach($ejecutar as $key => $value){
        	//extraigo los valores a utilizar como atributos
        	$id_asignacionprueba=$value->id_asignacionprueba;
        	$id_prueba=$value->id_prueba;
        	$id_colegio=$this->session->userdata('id_colegio');
        	
        	// extraigo los campos
            $codigo = $value->codigo;
            $nombre = $value->nombre;
            $id_subsector = $value->id_subsector;
            $num_tipo = $value->tipo;
            $tipo=$this->tipo_prueba($num_tipo);
            $color=$this->button_color($id_subsector);
            
            //Si hoja de respuesta no esta creada que muestre la prueba, si hoja de respuesta esta creada que consultesi esta finalizada
            if($this->hojarespuesta_model->have_respuesta($id_usuario, $id_asignacionprueba, $id_colegio)){
               $finalizado = $this->alumno_model->esFinalizado($id_colegio, $id_usuario, $id_asignacionprueba);
			   if($finalizado[0]=='0'){

				$contenido.="<tr>
	                        <td>".$codigo."</td>
	                        <td>".$nombre."</td>
	                        <td>".$tipo."</td>
	                        <td align='center'>  

	                            <a class='btn btn-default btn-sm btn-primary'  id_asignacion='".$id_asignacionprueba."' style='".$color." width: 179px; border-color: white;' ><i class='glyphicon glyphicon-pencil' style='margin-right: 14px; '></i>Realizar Prueba</a>
	                         </td>
	                    </tr>";
	          	}

	        }else{

	        	$contenido.="<tr>
	                        <td>".$codigo."</td>
	                        <td>".$nombre."</td>
	                        <td>".$tipo."</td>
	                        <td align='center'>  

	                            <a class='btn btn-default btn-sm btn-primary'  id_asignacion='".$id_asignacionprueba."' style='".$color." width: 179px; border-color: white;' ><i class='glyphicon glyphicon-pencil' style='margin-right: 14px; '></i>Realizar Prueba</a>
	                         </td>
	                    </tr>";

	        }
                    
        }
            
        $data['filas'] = $contenido;
        
        echo json_encode($data);
      }
    


     public function modal_instrucciones()

    {
                $data['data'] = "<form class='form-horizontal'>
                                            <p > lol </p>
                                            
                                            
                                 </form>";
              

               // if($this->Asignacionprueba_model->have_prueba($id_prueba))  

        $this->load->view('alumno/modal/modal_instrucciones', $data);
    }


    
    public function init()
    {

    $data['success']='';

    $id_usuario=$this->session->userdata('id_usuario');
    $id_asignacionprueba =$_GET['asignacion_id'];
    $id_colegio=$this->session->userdata('id_colegio');
    //$id_prueba =$_GET['prueba_id'];
   
	if($init=$this->hojarespuesta_model->init($id_usuario,$id_asignacionprueba,$id_colegio))
		$data['success'] = "success";
 

    echo json_encode($data);

    }

     public function temporizador()
    {
        $id_asignacionprueba = $this->input->post('id_asignacionprueba'); 

		if($fecha=$this->asignacionprueba_model->get_horaTermino($id_asignacionprueba));
		$mes= $fecha['mes'];
		$mes=$this->string_month($mes);
		$dia= $fecha['dia'];
		$anio= $fecha['anio'];
		$hora= $fecha['hora'];
		$minuto= $fecha['minuto'];
		$segundo= $fecha['segundo'];

		$fecha= $mes." ".$dia.", ".$anio." ".$hora.":".$minuto.":".$segundo;

		$data['fecha'] = $fecha;
        
        echo json_encode($data);
    }

 	public function string_month($mes)
   { 

   	$m='';
		   	switch ($mes) {
		       		case 01:
		       			$m ="January";
		       			break;
		       		case 02:
		       			$m ="February";
		       			break;
		       		case 03:
		       			$m ="March";
		       			break;
		       		case 04:
		       			$m ="April";
		       			break;
		       		case 05:
		       			$m ="May";
		       			break;
		       		case 06:
		       			$m ="June";
		       			break;
		       		case 07:
		       			$m ="July";
		       			break;
		       		case 08:
		       			$m ="August";
		       			break;
		       		case 09:
		       			$m ="September";
		       			break;
		       		case 10:
		       			$m ="October";
		       			break;
		       		case 11:
		       			$m ="November";
		       			break;
		       		case 12:
		       			$m ="December";
		       			break;
		       		
		       		default:
		       			# code...
		       			break;
		       	}

		       	return $m;

       }

     public function modal_finalizar_prueba($id_asignacionprueba, $id_alumno)

    {
                $data['data'] = "<form class='form-horizontal'>
                                            <p >Asegurate de haber respondido toda tu prueba.</p>
                                            <p > ¿Estás seguro que deseas Finalizar?</p>
                                            <input type='hidden' name='id_asignacionprueba' value='".$id_asignacionprueba."'>
                                            <input type='hidden' name='id_usuario' value='".$id_alumno."'>
                                 </form>";
                $data['data_button'] = "<button type='button' class='btn btn-cancelar cerrar' data-dismiss='modal'>Cancelar</button>
                                        <a id='enviar' href='#' class='btn btn-eliminar'>Continuar</a>"; 

               // if($this->Asignacionprueba_model->have_prueba($id_prueba))  

        $this->load->view('alumno/modal/modal_finalizar', $data);
    }

   public function finalizar_prueba()
   {

   $data['success']='';

    $id_asignacionprueba=$this->input->post('id_asignacionprueba');
    $id_usuario=$this->input->post('id_usuario');
    $id_colegio=$this->session->userdata('id_colegio');

        if($this->ensayo_model->alumno_finalizar($id_asignacionprueba,$id_usuario,$id_colegio))
            $data['success'] = "success";

    echo json_encode($data);
    }



     public function save()
    {
    	//pregunta , respuesta, asig,id usuario, colegio
	    $id_usuario=$this->session->userdata('id_usuario');
	    $id_colegio=$this->session->userdata('id_colegio');
	    $id_pregunta =$_GET['id_pregunta'];
	    $id_asignacionprueba =$_GET['id_asignacionprueba'];
	    $id_respuesta=$_GET['id_respuesta'];

	    $estado_asig=$this->asignacionprueba_model->get_estado($id_asignacionprueba);

	    switch ($estado_asig) {
	    	case 2: if($id_respuesta == '' )
					$id_respuesta = NULL;
					$data = array(
					'respuesta_id_respuesta' => $id_respuesta
					);

					if($update=$this->hojarespuesta_model->save($data, $id_colegio,$id_asignacionprueba, $id_pregunta,$id_usuario));

					$data['filas'] = $update;
					$data['option'] = "algo";
					echo json_encode($data);

					break;

	    	case 3: 
	    			$this->session->sess_destroy();
	    		    
	    		    $data['option'] = "logout";

	    		    echo json_encode($data);

					break;

			default:redirect('no_access');
			break;
	    }
    
		
	

    }



    public function button_color($id_subsector)
    {
        switch ($id_subsector) 
        {
          case 1:
              $color="background-color: rgba(236, 51, 12, 0.95);";
              break;
          case 3:
              $color="background-color: #105592;";
              break;
          case 5:
              $color="background-color: green;";
              break;
          case 4:
              $color="background-color: #DEDC00;";
              break;
          case 17:
              $color="background-color: #E0BB06;";
              break;
          default:
              $color="background-color: red;";
              break;
        }
        return $color;
    }



public function tipo_prueba($num_tipo)
    {
        
                    
                        switch ($num_tipo) 
                            {
                                case 1:
                                    $tipo="SIMCE";
                                    break;
                                case 2:
                                    $tipo="PME";
                                    break;
                                case 3:
                                    $tipo="PSU";
                                    break;
                                
                                default:
                                    $tipo="NO DATA";
                                    break;
                            }
                            
        return $tipo;
    }

    public function vista_ensayo()
    {
        
        $id_prueba = $this->input->get('id_prueba');

        $fila = "<table>"; 
        $fila.= $this->fila($id_prueba);

        

        foreach ($fila as $key => $value) 
        {
            $col.="<tr id_alumno=".$value->id_usuario." class='danger tr_alumno'>
                       <td><input type='checkbox'></td>
                       <th>".$value->nombre." ".$value->apellido."</th>".$this->input_respuesta($value->id_usuario, $id_prueba).
                  "</tr>";     
        }
        $col.= "</table>";
        
        $data['filas'] = $col;
        
        echo json_encode($data);
    }

	public function ensayo($id_ensayo)
	{	
		$nombre_prueba = $this->ensayo_model->get_nombre_prueba($id_ensayo);
		$data_header['title_page'] = "Ensayo | $nombre_prueba";
		$data['title_page'] = "Ensayo | $nombre_prueba";
		$data['usuario'] = $this->session->userdata('fullname');
		$data['pendiente'] = $this->ensayo_model->has_prueba($this->session->userdata('rut'));
		$data['close_menu'] = false;
		$data['id_ensayo'] = $id_ensayo;
		
		if(!$this->ensayo_model->is_prueba_start($id_ensayo, $this->session->userdata('rut')))
		{
			$this->load->view('partial/header', $data_header);
			$this->load->view('alumno/start_ensayo', $data);
			$this->load->view('partial/footer');
		}
		
		else
		{
			$data['cont'] = 1;
			$data['ensayo'] = $this->ensayo_model->get_prueba($id_ensayo);
			$data['close_menu'] = true;
			$this->load->view('alumno/alumno_ensayo', $data);
	
		}
		

	}

	public function recursos_modal($id_prueba)
	{
		$recursos = $this->ensayo_model->get_recursos($id_prueba);

		foreach ($recursos as $recurso) 
		{
			echo "<div class='modal fade in' id='idRecurso".$recurso->id_recursos."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='false' style='display: none; padding-right: 15px;'><div class='modal-backdrop fade in' style='height: 100%;'></div>
				<div class='modal-dialog'>
					<div class='modal-content'>
						<div class='modal-header'>
							<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
								<span aria-hidden='true'>×</span>
							</button>
							<h4 class='modal-title' id='myModalLabel'>Modal title</h4>
						</div>
						<div class='modal-body'>
							".$recurso->texto."
						</div>
						<div class='modal-footer'>
							<button type='button' class='btn btn-primary btn-o' data-dismiss='modal'>
								Close
							</button>
							<button type='button' class='btn btn-primary'>
								Save changes
							</button>
						</div>
					</div>
				</div>
			</div>";		
		}
		
	}

		public function instrucciones_modal($id_prueba)
	{
		$instrucciones = $this->ensayo_model->get_instrucciones($id_prueba);

		foreach ($instrucciones as $instruccion) 
		{
			echo "<div class='modal fade in' id='idInstruccion".$instruccion->id_instrucciones."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='false' style='display: none; padding-right: 15px;'><div class='modal-backdrop fade in' style='height: 100%;'></div>
				<div class='modal-dialog'>
					<div class='modal-content'>
						<div class='modal-header'>
							<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
								<span aria-hidden='true'>×</span>
							</button>
							<h4 class='modal-title' id='myModalLabel'>Modal title</h4>
						</div>
						<div class='modal-body'>
							".$instruccion->texto."
						</div>
						<div class='modal-footer'>
							<button type='button' class='btn btn-primary btn-o' data-dismiss='modal'>
								Close
							</button>
							<button type='button' class='btn btn-primary'>
								Save changes
							</button>
						</div>
					</div>
				</div>
			</div>";		
		}
		
	}

	public function ensayo_table($id_ensayo)
	{
		$ensayo = $this->ensayo_model->get_prueba($id_ensayo);
		$cont=1;

		foreach ($ensayo as $row) {
			
			if(!$instruccion = $this->ensayo_model->get_instruccion($row->id_pregunta, 'instrucciones_id_instrucciones'))
				$instruccion = 0;

			if(!$recurso = $this->ensayo_model->get_recurso($row->id_pregunta, 'recurso_id_recurso'))
				$recurso = 0;

			if($cont == 1)
				$active = ' active';
			else
				$active = '';

			echo "<div class='item".$active."' id_pregunta=".$row->id_pregunta." id_recurso=$recurso id_instruccion=$instruccion> 
				<div class='row'> 
					<div class='col-xs-8'> 
						<div class='prueba-alternativas' style='margin-left: 100px;'>
							<div class='prueba-enunciado'>
							<p><strong>".$row->pregunta."</strong></p>
						</div>				
				<div class='prueba-alternativas'>
					<div class='form-group'>
						<ul>
							<li>A)
								<div class='radio alt-psu'>
									<input name='pregunta[".$row->id_pregunta."]' type='radio' value='a' id_prueba_has_pregunta=".$row->id_prueba_has_pregunta." id='".$row->id_respuesta_a."'> 
									<label for='ensayo_pregunta_1531_7641'>
									<p>
										".$row->a." 
									</p>
									</label>
								</div><!-- radio alt-psu -->
							</li>
						<ul>
						</ul>
					<ul>
						<li>B)
							<div class='radio alt-psu'>
								<input name='pregunta[".$row->id_pregunta."]' type='radio' value='b' id_prueba_has_pregunta=".$row->id_prueba_has_pregunta." id='".$row->id_respuesta_b."'> 
								<label for='ensayo_pregunta_1531_7642'>
									<p>".$row->b."</p>
								</label>
							</div><!-- radio alt-psu -->
						</li>
					<ul></ul>
					<ul>
						<li>C)
							<div class='radio alt-psu'>
								<input name='pregunta[".$row->id_pregunta."]' type='radio' value='c' id_prueba_has_pregunta=".$row->id_prueba_has_pregunta." id='".$row->id_respuesta_c."'> 
								<label for='ensayo_pregunta_1531_7643'>
								<p>".$row->c." </p>									</label>
							</div><!-- radio alt-psu -->
						</li>
					<ul></ul>
					<ul>
						<li>D)
							<div class='radio alt-psu'>
								<input name='pregunta[".$row->id_pregunta."]' type='radio' value='d' id_prueba_has_pregunta=".$row->id_prueba_has_pregunta." id='".$row->id_respuesta_d."'> 
								<label for='ensayo_pregunta_1531_7644'>
								<p> ".$row->d."</p>									</label>
							</div><!-- radio alt-psu -->
						</li>
					<ul></ul>
					<ul>
						<li>E)
							<div class='radio alt-psu'>
								<input name='pregunta[".$row->id_pregunta."]' type='radio' value='e' id_prueba_has_pregunta=".$row->id_prueba_has_pregunta." id='".$row->id_respuesta_e."'> 
								<label for='ensayo_pregunta_1531_7645'>
								<p>".$row->e." </p>									</label>
							</div><!-- radio alt-psu -->
						</li>
					<ul></ul>
					<ul>
						<li>
							<div class='radio alt-psu'>
								<label>
								<input type='radio' for='ensayo[pregunta_1531]' name='pregunta[".$row->id_pregunta."]' checked='checked' id='666' value='' > Omitir</label>
							</div>
						</li>
					</ul>
					<div style='clear:both;'></div>
					</ul>
					</ul>
					</ul>
					</ul>
					</ul>
					</div><!-- form-group -->	
				</div>
				</div>

				</div> 
							</div> 
						</div> 
				";
				$cont++;


	}
}

	public function respuesta()
	{
		
		$data = array('id_prueba_has_pregunta' => $this->input->post("id_prueba_has_pregunta"),
			'id_respuesta' => $this->input->post("id_respuesta"),
			'rut' => $this->session->userdata('rut')
			);
		if($this->db->insert('academico.hoja_respuestas', $data))
            return true;
	
	}

	public function action_prueba($id_prueba, $accion)
	{
		if($this->ensayo_model->init_fin_prueba($this->session->userdata('rut'), $id_prueba, $accion))
			$this->ensayo($id_prueba);
		else
			echo "error al crear el ensayo";
	}

	public function recurso($id_pregunta)
	{
		if($this->ensayo_model->get_recurso($id_pregunta))
			echo true;
		else
			echo false;
	}

	public function recurso_view($id_pregunta)
	{
		$data['recurso'] = $this->ensayo_model->get_recurso($id_pregunta);
		$this->load->view('alumno/modal/recurso.php', $data);
	}

	public function preguntas_respondidas($id_prueba)
	{
		
		$data = $this->ensayo_model->get_preguntas_respondidas($this->session->userdata('rut'), $id_prueba);
		$pregunta=1;
		foreach ($data as $row) {
			if($row->id_respuesta)
				echo "<div class='badge badge-success'>$pregunta</div>&nbsp;";
			else
				echo "<div class='badge badge-inverse'>$pregunta</div>&nbsp;";
			$pregunta++;
		}
		//print_r($data);
		//echo json_encode(array("success" => "success"));
		//return $data; 
	}

}
?>