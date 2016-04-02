<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ensayo extends CI_Controller {
	
	public function __construct()
        {
            parent::__construct();
            $this->load->model('prueba_model');
            $this->load->model('ensayo_model');
            $this->load->model('asignacionprueba_model');
            $this->load->model('hojarespuesta_model');
            $this->load->model('usuario_model');
        
            if($this->session->userdata('perfil'))
                $perfil = $this->session->userdata('perfil');
            else
                $perfil = false;

            if(!$this->usuario_model->has_permission($perfil, 1))
			{
				redirect('login');
			}
        
        }

    public function icono($id_subsector)
    {
    	switch ($id_subsector) 
    	{
    	  case 1: $icono = "lengua.svg";
   		   break;
    	  case 3: $icono = "mate.svg";
   		   break;
    	  case 5: $icono = "naturales.svg";	
   		   break;
          case 4: $icono = "";
           break;
          case 719: $icono = "comprensionlectora_b.svg";
           break;
          case 17:$icono = "formacionciudadana_b.svg";
           break;
          case 6616:$icono = "resoluciondeproblemas_b.svg";
           break;
    	}

    	return $icono;
    }

    	public function alternativa($key)
    {

    	switch ($key) {
    		case 1:
    			$alternativa = "A)  ";
    			break;
    		case 2:
    			$alternativa = "B)  ";
    			break;
    		case 3:
    			$alternativa = "C)  ";
    			break;
    		case 4:
    			$alternativa = "D)  ";
    			break;
    		case 5:
    			$alternativa = "E)  ";
    			break;			
    		default:
    			$alternativa = "Z) ";
    			break;
    	}

    	return $alternativa;
    
    }

    public function tipo($tipo)
    {
        switch ($tipo) {
            case 1:
                $return = "SIMCE";
                break;
            case 2:
                $return = "PME";
                break;
            case 3:
                $return = "PSU";
                break;
        }

        return $return;
    }

	public function index($id_asignacionprueba,$id_usuario=false)
	{
        $ap         = $this->asignacionprueba_model->get_info($id_asignacionprueba);
        $id_prueba  = $ap->prueba_id_prueba;
        $id_colegio = $this->session->userdata('id_colegio');

		$ensayo= $this->prueba_model->get_prueba($id_prueba);
        $subsector_id     = $ensayo->subsector_id_subsector;
        $subsector_nombre = $this->prueba_model->get_subsector_nombre($subsector_id);
        $tipo = $this->tipo($ensayo->tipo);

		$data_header['title_page']    = "Home | Ensayo";
		$data_header['usuario']       = $this->session->userdata('fullname');
		$data['close_menu']           = false;
        $data_header['id_colegio']    = $this->session->userdata('id_colegio');
		$data['cabecera']             = "<div style='padding: 10px 10px 10px 10px;float:left;'><img height='47' src='".base_url()."assets/images/".$this->icono($subsector_id)."'></div><div style='float:left;font-size:20px;margin-top:20px;'>ENSAYO ".$tipo." '".$subsector_nombre."' - CODIGO ".$ensayo->codigo."</div>";
        $data['id_prueba']            = $id_prueba;
        $data['id_asignacionprueba']  = $ap->id_asignacionprueba;
        $data['id_usuario']           = $id_usuario;
        $data['id_colegio']           = $id_colegio;
        $data['ensayo']               = $this->ensayo($id_prueba, $id_asignacionprueba, $id_colegio, $id_usuario);

		$this->load->view('partial/header_alumno', $data_header);
		$this->load->view('alumno/prueba/home', $data);
		$this->load->view('partial/footer_alumno');
		//$this->load->view('ensayo/home', $data);
	}

    public function respondidas($id_prueba, $id_asignacionprueba, $id_colegio, $id_usuario)

    {
        $col="";
        
        $preguntas= $this->ensayo_model->get_datos($id_prueba);

        $num_pregunta = 1;
        $id=0;
        $respondidas = array();
        foreach ($preguntas as $key => $pregunta) 
        {
            $cod_pregunta=$pregunta->id_pregunta;
            $respuesta = $this->hojarespuesta_model->respondida($id_usuario, $id_asignacionprueba, $id_colegio, $cod_pregunta);       
            
            $respondidas[$num_pregunta]=$respuesta;
       
                    if ($respondidas[$num_pregunta]=='') {
                        $color='#c7c7c7';
                    }else{
                        $color='#50beef';
                    }

           if ($num_pregunta<10) {
           
                        $col.="<a class='focus' href='#' style='color:".$color."' id='".$num_pregunta."'>0".$num_pregunta."</a> ";
                    }else{
                        $col.="<a class='focus' href='#' style='color:".$color."' id='".$num_pregunta."'>".$num_pregunta."</a> ";
                    }

            $num_pregunta++;
            $id++;
        }
      
        $data['filas'] = $col;
        $data['respondidas'] = $respondidas;
        
        echo json_encode($data);
    }

	    public function ensayo($id_prueba, $id_asignacionprueba, $id_colegio, $id_usuario)

    {
       
        $col="";
        
        $preguntas= $this->ensayo_model->get_datos($id_prueba);

        $num_pregunta = 1;
        foreach ($preguntas as $key => $pregunta) 
        {
            $col.=" <div class='contenedor-pregunta' id='goto".$num_pregunta."'>
                        <div class='pregunta-numero' ><center>".$num_pregunta."</center></div>
                        <div class='pregunta-contenido'>".$pregunta->contenido."</div>
                    </div>";

            $cod_pregunta=$pregunta->id_pregunta;
            $respuesta = $this->hojarespuesta_model->respondida($id_usuario, $id_asignacionprueba, $id_colegio, $cod_pregunta);
            $respuestas= $this->ensayo_model->get_resp($cod_pregunta); 

            
            $col.="<div class='contenedor-respuestas'>";
            $col.="<ul>";
            if($respuestas)
                foreach ($respuestas as $key => $value) 
                {
                    $key++;
                    $letra=$this->alternativa($key);

                    if($value->id_respuesta == $respuesta)
                        $checked = "checked";
                    else
                        $checked = "";

                    $col.=" <li style='display:inline;'>
                                <div  class='radio alt-psu' id_pregunta='".$value->id_pregunta."'   id_respuesta='".$value->id_respuesta."'>
                                    
                                    <span >".$letra."</span>
                                    <input  name='ensayo".$value->id_pregunta."' type='radio' value='28807' id_pregunta='".$value->id_pregunta."'   id_respuesta='".$value->id_respuesta."' id='radiobutton".$value->id_respuesta."' ".$checked."> 
                                    
                                    <div style='  margin-left:50px;margin-top:-18px;'>
                                      <label for='radiobutton".$value->id_respuesta."'>
                                        <a style='color:#42474C;' class='respuesta'>".$value->respuesta."</a>  
                                      </label>
                                    </div>
                                   
                                </div><!-- radio alt-psu -->
                            </li>";
                }
            else
            $col.="Error:Pregunta sin alternativas";
            
            $col.="</ul>";
            $col.="</div>";

            $col.="<div class='pregunta-separador'></div>";
            
            $num_pregunta++;

        }
      
        //$data['filas'] = $col;
        
        return $col;
        //echo json_encode($data);

    }

    public function visualizar($id_prueba)
    {
        $ensayo= $this->prueba_model->get_prueba($id_prueba);
        $subsector_id     = $ensayo->subsector_id_subsector;
        $subsector_nombre = $this->prueba_model->get_subsector_nombre($subsector_id);
        $tipo = $this->tipo($ensayo->tipo);

        $data_header['title_page'] = "Home | Ensayo";
        $data_header['usuario'] = $this->session->userdata('fullname');
        $data['close_menu'] = false;
        $data_header['id_colegio'] = 666;//<i class='ti-write'></i>
        $data['cabecera']="<img height='47' src='".base_url()."assets/images/".$this->icono($subsector_id)."'><strong> ENSAYO $tipo '$subsector_nombre' - CÓDIGO $ensayo->codigo</strong>";
        //$data['cabecera'] = "<div style='padding: 10px 10px 10px 10px;float:left;'><img height='47' src='".base_url()."assets/images/".$this->icono($subsector_id)."'></div><div style='float:left;font-size:20px;margin-top:20px;'>ENSAYO ".$tipo." '".$subsector_nombre."' - CODIGO ".$ensayo->codigo."</div>";
        $data['id_prueba'] = $id_prueba;
        $data['id_asignacionprueba'] = 666;
        $data['id_usuario'] = 666;
        $data['id_colegio'] = 666;
        if($this->session->userdata('perfil') == 1){
            $this->load->view('partial/header', $data_header);
            $this->load->view('ensayo/ensayo', $data);
            $this->load->view('partial/footer');
            //$this->load->view('ensayo/home', $data);
        }else{
            $this->load->view('partial/header_profesor', $data_header);
            $this->load->view('ensayo/ensayo', $data);
            $this->load->view('partial/footer');
        }
        
    }

        public function visualizar_ensayo($id_prueba)

    {
        
        $col="";
        
        $preguntas= $this->ensayo_model->get_datos($id_prueba);

        $num_pregunta = 1;
        foreach ($preguntas as $key => $pregunta) 
        {
            $col.=" <div class='contenedor-pregunta'>
                        <div class='pregunta-numero'><center>".$num_pregunta."</center></div>
                        <div class='pregunta-contenido'>".$pregunta->contenido."</div>
                    </div>";

            $cod_pregunta=$pregunta->id_pregunta;
            
            $respuestas= $this->ensayo_model->get_resp($cod_pregunta); 

            
            $col.="<div class='contenedor-respuestas'>";
            $col.="<ul>";
            if($respuestas)
                foreach ($respuestas as $key => $value) 
                {
                    $key++;
                    $letra=$this->alternativa($key);

                    $col.=" <li style='display:inline;'>
                                <div  class='radio alt-psu' id_pregunta='".$value->id_pregunta."'   id_respuesta='".$value->id_respuesta."'>
                                    
                                    <span >".$letra."</span>
                                    <input  name='ensayo".$value->id_pregunta."' type='radio' value='28807' id_pregunta='".$value->id_pregunta."'   id_respuesta='".$value->id_respuesta."' id='radiobutton".$value->id_respuesta."'> 
                                    
                                    <div style='  margin-left:50px;margin-top:-18px;'>
                                      <label for='radiobutton".$value->id_respuesta."'>
                                        <a style='color:#42474C;' class='respuesta'>".$value->respuesta."</a>  
                                      </label>
                                    </div>
                                   
                                </div><!-- radio alt-psu -->
                            </li>";
                }
            else
            $col.="Error:Pregunta sin alternativas";
            
            $col.="</ul>";
            $col.="</div>";

            $col.="<div class='pregunta-separador'></div>";
            
            $num_pregunta++;

        }
      
        $data['filas'] = $col;
        
        echo json_encode($data);

    }
}
?>