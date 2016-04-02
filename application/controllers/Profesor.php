<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."/tcpdf/tcpdf.php";
require_once ("secure_area.php");

class Profesor extends Secure_area {
    public function __construct()
        {
            parent::__construct();
            $this->load->model('prueba_model');
            $this->load->model('profesor_model');
            $this->load->model('alumno_model');
            $this->load->model('hojarespuesta_model');
            $this->load->model('asignacionprueba_model');
            $this->load->model('respuesta_model');
            $this->load->model('ensayo_model');

            if(!$this->usuario_model->has_permission($this->session->userdata('perfil'), 3))
            {
                redirect('no_access/'.$module_id);
            }
        }

	public function index()
	{
        $data['usuario'] = $this->session->userdata('fullname');
        
        //$this->load->view('partial/header', $data);
    
		$this->load->view('profesor/home', $data);
        //$this->load->view('partial/footer', $data);
	}

    public function tabulador($id_asignacionprueba)
    {
        $data['usuario']                = $this->session->userdata('fullname');
        $data['id_asignacionprueba']    = $id_asignacionprueba;
        $data['title_page']             = "Profesor | Tabulacion";

        $this->load->view('partial/header_profesor', $data);
        $this->load->view('profesor/tabulador', $data);
        $this->load->view('partial/footer', $data);
    }

    public function get_datos()
    {
        $usuario = $this->session->userdata('rut');
        
        $contenido="";
        $contenido.="<thead><tr style='background-color: #50beef;'>
            <th style='color: white!important;'>N°</th>

            <th style='color: white!important;'>Tipo</th>
            <th style='color: white!important;'>Enseñanza</th>
            <th style='color: white!important;'>Nivel</th>
            <th style='color: white!important;'>Subsector</th>
            <th style='color: white!important;'>Evaluacion</th>

            <th style='color: white!important;'>Curso</th>
            <th style='color: white!important;'>Prueba</th>
            <th style='color: white!important;'>Inicio</th>
            <th style='color: white!important;'>Finalizado</th>
            <th style='color: white!important;'>Estado</th>
            <th style='color: white!important;'>Acciones</th>
            </tr></thead>";

        $datos = $this->profesor_model->get_lista($usuario);

        if (is_array($datos) || is_object($datos))
        {

            foreach ($datos as $key => $value)
            {
                // extraigo el nombre de los campos
                $curso                  = $value->curso;
                $codigo                 = $value->codigo;
                $inicio                 = $value->inicio;
                $colegio                = $value->colegio_id_colegio;
                $ejecutado              = $value->realizado;
                $id_estado              = $value->estado;
                $tipo                   = $this->tipo($value->tipo);
                $nivel                  = $this->nivel($value->nivel_id_nivel);
                $estado                 = $this->txt_estado($id_estado);
                $evaluacion             = $value->evaluacion;
                $subsector              = $this->subsector($value->subsector_id_subsector);
                $id_asignacionprueba    = $value->id_asignacionprueba;
                $colortd                = $this->colortd($id_estado);

                $i=0;
                
                if($prueba = $this->ensayo_model->datos_excel($id_asignacionprueba))
                    foreach ($prueba as $i => $value) {
                    $id_prueba = $value->id_prueba;
                    }

                $fecha_inicio_tmp       = "";
                $fecha_inicio           = "";
                $fecha_inicio_title     = "";
                $fecha_fin_tmp          = "";
                $fecha_fin              = "";
                $fecha_fin_title        = "";

                if($inicio)
                {
                    $fecha_inicio_tmp       = new DateTime($inicio);
                    $fecha_inicio           = $fecha_inicio_tmp->format('d-m-y');
                    $fecha_inicio_title     = $fecha_inicio_tmp->format('d-m-y H:i:s');
                }
                
                if($ejecutado)

                {   $fecha_fin_tmp          = new DateTime($ejecutado);
                    $fecha_fin              = $fecha_fin_tmp->format('d-m-y');
                    $fecha_fin_title        = $fecha_fin_tmp->format('d-m-y H:i:s');
                }

                if($id_estado == 1)
                {
                    $boton_estado   = "<a class='btn btn-warning btn-sm btn-primary cambiar_estado' data-fancybox-type='iframe' href='".site_url()."/profesor/modal_cambiar_estado/$id_asignacionprueba/2"."'><i class='glyphicon glyphicon-play-circle' ></i> Ejecutar</a>";        
                    $boton_tabulado = "<a class='btn btn-default btn-sm btn-primary' href='#'><i class='glyphicon glyphicon-list-alt' ></i> Respuestas</a>";
                    $select_informe  = "";
                }
                
                if($id_estado == 2)
                    {
                        $boton_estado = "<a class='btn btn-success btn-sm btn-primary cambiar_estado' data-fancybox-type='iframe' href='".site_url()."/profesor/modal_cambiar_estado/$id_asignacionprueba/3"."'> <i class='glyphicon glyphicon-off' ></i> Finalizar</a>";
                        $boton_tabulado = "<a class='btn btn-default btn-sm btn-primary' href='".site_url()."/profesor/tabulador/$id_asignacionprueba"."'><i class='glyphicon glyphicon-list-alt' ></i> Respuestas</a>";
                        $select_informe  = "";
                    }
                
                if($id_estado == 3)
                    {
                        $boton_estado = "<a class='btn btn-warning btn-sm btn-primary cambiar_estado' data-fancybox-type='iframe' href='".site_url()."/profesor/modal_cambiar_estado/$id_asignacionprueba/2"."'><i class='glyphicon glyphicon-play-circle' ></i> Ejecutar</a>";                                        
                        $boton_tabulado = "<a class='btn btn-default btn-sm btn-primary' href='".site_url()."/profesor/tabulador/$id_asignacionprueba"."'><i class='glyphicon glyphicon-list-alt' ></i> Respuestas</a>";
                        $select_informe  = "<li><a class='genera_pdfs' href='".site_url()."/pdf_generador/mostrar_pdf/$id_asignacionprueba"."'>Informe Estadístico</a></li>";
                    }

                $contenido.= "<tr>
                            <td style='background-color:".$colortd.";color:black!important;'><CENTER>".($key+1)."</CENTER></td>
                            <td>$tipo</td>
                            <td>basica</td>
                            <td>$nivel</td>
                            <td>$subsector</td>
                            <td>".$tipo.$evaluacion."</td>
                            <td>".$curso."</td>
                            <td>".$codigo."</td>
                            <td><span title='".$fecha_inicio_title."'>".$fecha_inicio."</span></td>
                            <td><span title='".$fecha_fin_title."'>".$fecha_fin."</span></td>
                            <td style='background-color:".$colortd.";color:black!important;'><CENTER>".$estado."</CENTER></td>
                            <td>
                                <div style='float:left;margin-left:10px'>
                                    <a class='btn btn-default btn-sm btn-primary' target='_blank' href='".site_url()."/ensayo/visualizar/".$id_prueba."' ><i class='glyphicon glyphicon-eye-open'></i></a>
                                </div>                  
                                <div style='float:left;margin-left:10px'>
                                    <a class='btn btn-default btn-sm btn-primary' href='".site_url()."/profesor/show_alumnos/".$value->id_curso."/$id_asignacionprueba/$colegio/$id_estado' data-fancybox-type='iframe' id='alumnos'><i class='glyphicon glyphicon-list-alt'></i> Alumnos</a>
                                </div>

                                <div style='float:left;margin-left:10px'>
                                    ".$boton_estado."
                                </div>

                                <div style='float:left;margin-left:10px'>
                                    ".$boton_tabulado."
                                </div>
                                <div class='dropdown' style='float:left;margin-left:10px'>
                                    <button class=btn btn-default btn-sm btn-primary dropdown-toggle 
                                            type='button' 
                                            id='dropdownMenu1' 
                                            data-toggle='dropdown' 
                                            aria-haspopup='true' 
                                            aria-expanded='true'
                                            style='background-color: #50BEEF;color:white;padding:4px 12px;'
                                            >

                                        <i class='glyphicon glyphicon-cloud-download'></i> Descargas
                                        <span class='caret'></span>
                                    </button>
                                    <ul class='dropdown-menu' aria-labelledby='dropdownMenu1'>
                                        ".$select_informe."
                                        <li><a href='".base_url()."prueba/".$codigo.".pdf'>Prueba Escrita</a></li>
                                        <li><a href='".base_url()."remedial/".$codigo.".pdf/'>Remedial</a></li>
                                    </ul>
                                </div>
                            </td>


                           
                        </tr>";

            }
        }

        $data['filas'] = $contenido;

        echo json_encode($data);
    }

    public function columnas($id_prueba)
    {
        $filas = $this->prueba_model->get_preguntas($id_prueba);
        $i=1;
        $col="<th bgcolor='#C5D5FE' style='font-size: 11px;'>Presente</th><th bgcolor='#C5D5FE' style='font-size: 11px;' >NOMBRE ALUMNO</th>";

        foreach ($filas as $key => $value) 
        {
            $num_pregunta = "P".$i;

            if($i<=9)
                $num_pregunta = "P0".$i;                
            
            $col.="<th style='width: 20px; font-size: 11px;' bgcolor='#C5D5FE' id='".$value->id_pregunta."'>".$num_pregunta."</th>";
            
            $i++;
        }
        return $col;  
       
    }
       
    


     public function respondida($id_usuario, $id_asignacionprueba, $id_colegio, $id_pregunta)
    {
            $respuesta = $this->hojarespuesta_model->respondida($id_usuario, $id_asignacionprueba, $id_colegio, $id_pregunta);
        
            
            
            $alternativa='';
            if($respuestas= $this->ensayo_model->get_resp($id_pregunta)) 
            foreach ($respuestas as $key => $value) {

                        $id_respuesta=$value->id_respuesta;

                            if ($respuesta==$id_respuesta) {
                            
                                switch ($key) {
                                    case 0:
                                        $alternativa='A';
                                        break;
                                    case 1:
                                        $alternativa='B';
                                        break;
                                    case 2:
                                        $alternativa='C';
                                        break;
                                    case 3:
                                        $alternativa='D';
                                        break;
                                    case 4:
                                        $alternativa='E';
                                    break;
                                    
                                    default:
                                        $alternativa='';
                                        break;
                                }
                            }
            }
             

            return $alternativa;

    }

    public function tabla_tabulado()
    {
        $id_asignacionprueba  = $this->input->get('id_asignacion'); 
        if($datos= $this->ensayo_model->datos_excel($id_asignacionprueba));
        
        foreach ($datos as $key => $value) 
        {  
        $id_prueba = $value->id_prueba;
        $id_curso= $value->id_curso;
        $id_colegio=$value->id_colegio;
        }

        $filas = $this->alumno_model->get_from_curso($id_curso);
        $col = "<table>"; 
        $col.= $this->columnas($id_prueba);

        $finalizado = $this->asignacionprueba_model->get_estado($id_asignacionprueba);

        foreach ($filas as $key => $value) 
        {  
            $id_usuario=$value->id_usuario;

            $result = $this->hojarespuesta_model->have_respuesta($id_usuario, $id_asignacionprueba, $id_colegio);

            if(!$result==false)
            {
                $estado='check_activo';
            }
            else
            {
                if ($finalizado[0]==3)
                {
                    $estado='check_inactivo_disabled';
                }
                else
                {
                    $estado='check_inactivo';
                }
            }

            if ($finalizado[0]==3)
            {

            $col.="<tr style='font-size: 10px; ' class='tr_alumno active' >
                       <td style='width: 67px;'><div  id='".$estado."' ></div></td>
                       <th>".$value->nombre." ".$value->apellido."</th>".$this->input_respuesta($id_usuario, $id_prueba,$id_asignacionprueba,$id_colegio).
                  "</tr>";  
            $botones = "<button type='button' id='reiniciar'  class='btn btn-default btn-sm btn-danger' data-fancybox-type='iframe' href='".site_url()."/profesor/modal_reiniciar_prueba/$id_asignacionprueba"."'><i class='glyphicon glyphicon-refresh'></i> Reiniciar </button>";
            }
            else
            {
                $col.="<tr style='font-size: 10px; ' class='tr_alumno active' >
                       <td style='width: 67px;'><div class='check' href='".base_url()."index.php/profesor/modal_crear_hoja/".$id_usuario."/".$id_asignacionprueba."/".$id_colegio."' data-fancybox-type='iframe'  id='".$estado."' ></div></td>
                       <th>".$value->nombre." ".$value->apellido."</th>".$this->input_respuesta($id_usuario, $id_prueba,$id_asignacionprueba,$id_colegio).
                  "</tr>";
                $botones = "<button type='button' id='reiniciar'  class='btn btn-default btn-sm btn-danger' data-fancybox-type='iframe' href='".site_url()."/profesor/modal_reiniciar_prueba/$id_asignacionprueba"."'><i class='glyphicon glyphicon-refresh'></i> Reiniciar </button>
                            <button type='button' id='finalizar' class='btn btn-primary btn-sm ver_pregunta' data-fancybox-type='iframe' href='".site_url()."/profesor/modal_cambiar_estado/$id_asignacionprueba/3"."'><i class='glyphicon glyphicon-off'></i> Finalizar</button>";    
            }


        }
        $col.= "</table>";
        
        $data['filas']      = $col;
        $data['botones']    = $botones;
              
        
        echo json_encode($data);
    }

    public function input_respuesta($id_usuario, $id_prueba,$id_asignacionprueba,$id_colegio)
    {
        $filas = $this->prueba_model->get_preguntas($id_prueba);
        $i=1;
        $col="";
        $set='';

        $estado = $this->asignacionprueba_model->get_estado($id_asignacionprueba);
        

    
         foreach ($filas as $key => $value) {

                $id_pregunta = $value->id_pregunta;
                $set         = $this->respondida($id_usuario, $id_asignacionprueba, $id_colegio, $id_pregunta);       
                $result      = $this->hojarespuesta_model->have_respuesta($id_usuario, $id_asignacionprueba, $id_colegio);
                $finalizado  = $this->alumno_model->esFinalizado($id_colegio, $id_usuario, $id_asignacionprueba);


                 if ($estado[0]==2){
                    
                    if(!$result==false){
                        if($finalizado[0]=='0'){
                            $col.="<td ><input num_pregunta='Nº".$i."'  id_alumno='".$id_usuario."' id_pregunta='".$id_pregunta."' width='2' value='".$set."' id_colegio='".$id_colegio."' id_asignacion='".$id_asignacionprueba."' style='text-transform:uppercase; font-size: 10px;' type='text' maxlength='1' onkeypress='return isNumber(event)' /></td>";
                        }else{  
                            $col.="<td ><input num_pregunta='Nº".$i."' disabled='disabled' id_alumno='".$id_usuario."' id_pregunta='".$id_pregunta."' value='".$set."' id_colegio='".$id_colegio."' id_asignacion='".$id_asignacionprueba."' width='2' style='text-transform:uppercase; font-size: 10px;' type='text' maxlength='1' onkeypress='return isNumber(event)' /></td>";
                        }
                    }
                    else
                    {
                        $col.="<td ><input num_pregunta='Nº".$i."' disabled='disabled' id_alumno='".$id_usuario."' id_pregunta='".$id_pregunta."' id_colegio='".$id_colegio."' id_asignacion='".$id_asignacionprueba."' width='2' style='text-transform:uppercase; font-size: 10px;' type='text' maxlength='1' onkeypress='return isNumber(event)' /></td>";
                    }
                     
                }else{
                        $col.="<td ><input num_pregunta='Nº".$i."' disabled='disabled' id_alumno='".$id_usuario."' id_pregunta='".$id_pregunta."' value='".$set."' id_colegio='".$id_colegio."' id_asignacion='".$id_asignacionprueba."' width='2' style='text-transform:uppercase; font-size: 10px;' type='text' maxlength='1' onkeypress='return isNumber(event)' /></td>";

                }
        $i++;
         } 





        return $col;
    }
    public function modal_crear_hoja($id_usuario,$id_asignacion,$id_colegio)

    { 
      if($usuario=$this->alumno_model->get_name($id_usuario))
        foreach ($usuario as $key => $value) {
            $name_user=$value->nombre." ".$value->apellido;
        }
        //$usuario='Yohana Saldaña';
        if($this->hojarespuesta_model->have_respuesta($id_usuario, $id_asignacion, $id_colegio)){

            $data['data'] = "<form class='form-horizontal'>
                                    <p> Esta Hoja de respuesta fue creada con anterioridad.</p>
                                    <p> Si el alumno figura inactivo, comunicarse con el área de soporte.</p>
                         </form>";
            $data['data_button'] = '<button type="button" class="btn btn-cancelar cerrar" data-dismiss="modal" style=" margin-top: 10px; margin-right: 154px;">Cancelar</button>';
            


        }else{

            $data['data'] = "<form class='form-horizontal'>
                                        <p> Se creará la hoja de respuesta para el alumno: <br> 
                                        <strong>".$name_user."</strong> </p>
                                        
                                        <p> ¿Está seguro que desea Continuar?</p>
                                        <input type='hidden' name='id_usuario' value='".$id_usuario."'>
                                        <input type='hidden' name='id_asignacion' value='".$id_asignacion."'>
                                        <input type='hidden' name='id_colegio' value='".$id_colegio."'>
                             </form>";
            $data['data_button'] = "<button type='button' class='btn btn-cancelar cerrar' data-dismiss='modal'>Cancelar</button>
                                    <a id='enviar' href='#' class='btn btn-eliminar'>Continuar</a>"; 
       
            }

        $this->load->view('profesor/excel/modal_crear', $data);  


    }


    public function generar_hoja()
    { 
         $id_usuario  = $this->input->post('id_usuario'); 
         $id_asignacionprueba = $this->input->post('id_asignacion');
         $id_colegio = $this->input->post('id_colegio');
       // $id_usuario  = '20'; 
       //  $id_asignacionprueba = '2';
       //  $id_colegio = '1';
   
        if($this->hojarespuesta_model->init($id_usuario,$id_asignacionprueba,$id_colegio));
        $data['success'] = "success";

        echo json_encode($data);
    }



    public function cambiar_estado($id_asignacionprueba, $estado)
    {

       
            if($this->asignacionprueba_model->cambiar_estado($id_asignacionprueba, $estado))
                $data['success'] = "success";

        echo json_encode($data);
    }


    public function modal_reiniciar_prueba($id_asignacionprueba)

    {
                $data['data'] = "<form class='form-horizontal'>
                                            <p> Se borrará la hoja de respuesta de cada alumno.</p>
                                            <p> ¿Está seguro que desea Continuar?</p>
                                            <input type='hidden' name='id_asignacionprueba' value='".$id_asignacionprueba."'>
                                 </form>";
                $data['data_button'] = "<button type='button' class='btn btn-cancelar cerrar' data-dismiss='modal'>Cancelar</button>
                                        <a id='enviar' href='#' class='btn btn-eliminar'>Continuar</a>"; 

               // if($this->Asignacionprueba_model->have_prueba($id_prueba))  

        $this->load->view('profesor/excel/modal_reiniciar', $data);
    }

    public function modal_cambiar_estado($id_asignacionprueba, $estado)

    {
        
        switch ($estado) 
        {
            case 1:
                $mensaje = "<form class='form-horizontal'>
                            <p > Se pondrá ĺa prueba en estado de 'ASIGNADA', No se perderán las respuestas de sus alumnos. Si desea que los alumnos visualicen esta prueba debe cambiarle el estado a 'EJECUCIÓN'.</p>
                            <p > ¿Está seguro que desea Continuar?</p>
                            
                         </form>";
                break;
            case 2:
                $mensaje = "<form class='form-horizontal'>
                            <p > Se pondrá ĺa prueba en estado de 'EN EJECUCIÓN'.</p>
                            <p > ¿Está seguro que desea Continuar?</p>
                           
                         </form>";
                break;
            case 3:
                $mensaje = "<form class='form-horizontal'>
                            <p > Se modificará el estado de la prueba a 'FINALIZADA'.</p>
                            <p > ¿Está seguro que desea Continuar?</p>
                           
                         </form>";
                break;
            
        }
        
        $data['asignacion'] = $id_asignacionprueba;
        $data['estado'] = $estado;
        $data['data'] = $mensaje;
        $data['data_button'] = "<button type='button' class='btn btn-cancelar cerrar' data-dismiss='modal'>Cancelar</button>
                                <a id='enviar' href='#' class='btn btn-eliminar'>Continuar</a>"; 

        $this->load->view('profesor/modal/cambiar_estado', $data);
    }

    public function delete_hojarespuesta()
    {
        $id_asignacionprueba=$this->input->post('id_asignacionprueba');
        $id_colegio='';

        if($datos= $this->ensayo_model->datos_excel($id_asignacionprueba));
        foreach ($datos as $key => $value) {

           $id_colegio=$value->id_colegio;

        }

    if($this->asignacionprueba_model->cambiar_estado($id_asignacionprueba, 1))
        if($this->hojarespuesta_model->delete($id_colegio, $id_asignacionprueba))
            $data['success'] = "success";

        echo json_encode($data);
    }

     public function save($alternativa,$id_pregunta,$id_usuario,$id_colegio,$id_asignacionprueba)
    {
        
        $alternativa = strtoupper($alternativa); //Strtouper cambia cualquier string a MAYUSCULAS

        $id_respuesta=$this->get_id_respuesta($id_pregunta,$alternativa);

        $data = array(
              'respuesta_id_respuesta' => $id_respuesta
                );
    
        if($update=$this->hojarespuesta_model->save($data, $id_colegio,$id_asignacionprueba, $id_pregunta,$id_usuario));
    }


    public function get_id_respuesta($id_pregunta, $alternativa)
    { 
        $respuestas=$this->respuesta_model->get_all($id_pregunta);

        foreach ($respuestas as $key => $value) {
            $array[$key]= $value->id_respuesta;
        }

        switch ($alternativa) {
            case 'A':
                $id_respuesta = $array[0];
                break;
            case 'B':
                $id_respuesta = $array[1];
                break;
            case 'C':
                $id_respuesta = $array[2];
                break;
            case 'D':
                $id_respuesta = $array[3];
                break;
            case 'E':
                $id_respuesta = $array[4];
                break; 
            default:
                $id_respuesta = NULL;
                break;
        }
        return $id_respuesta;
    }

    public function colortd($estado)
    {
        
        switch ($estado) {
            case 1:
                $color = '#2F8ECD';
                break;
            case 2:
                $color = '#eea236';
                break;
            case 3:
                $color = '#3ACD45';
                break;    
            default:
                # code...
                break;
        }

        return $color;
    }

    public function txt_estado($estado)
    {
        switch ($estado) {
            case 1:
                $color = 'ASIGNADA';
                break;
            case 2:
                $color = 'EJECUCION';
                break;
            case 3:
                $color = 'FINALIZADA';
                break;    
            default:
                # code...
                break;
        }

        return $color;
    }

    public function tipo($tipo)
    {
        switch ($tipo) {
            case 1:
                $color = 'SIMCE';
                break;
            case 2:
                $color = 'PME';
                break;
            case 3:
                $color = 'PSU';
                break;    
            default:
                # code...
                break;
        }

        return $color;
    }

    public function nivel($tipo)
    {
        switch ($tipo) 
        {
            case 1:
                $color = 'PRIMERO';
                break;
            case 2:
                $color = 'SEGUNDO';
                break;
            case 3:
                $color = 'TERCERO';
                break;
            case 4:
                $color = 'CUARTO';
                break;
            case 5:
                $color = 'QUINTO';
                break;
            case 6:
                $color = 'SEXTO';
                break;
            case 7:
                $color = 'SEPTIMO';
                break;
            case 8:
                $color = 'OCTAVO';
                break;
            case 9:
                $color = 'PRIMERO';
                break;
            case 10:
                $color = 'SEGUNDO';
                break;
            case 11:
                $color = 'TERCERO';
                break;
            case 12:
                $color = 'CUARTO';
                break;            
        }
        return $color;
    }

    public function subsector($subsector)
    {
        switch ($subsector) 
        {
            case 1:
                $return = "lenguaje";
                break;
            case 3:
                $return = "matematicas";
                break;
            case 4:
                $return = "historia";
                break;
            case 5:
                $return = "ciencias";
                break;            
            case 17:
                $return = "formacion";
                break;
            case 719:
                $return = "comprension";
                break;
            case 6616:
                $return = "resolucion";
                break;
        }

        return $return;
    }

    public function postest()
    {
        
        echo $this->input->get('test1'); 
    }
    
	public function ensayos()
	{
        $data['usuario'] = $this->session->userdata('fullname');
		$this->load->view('profesor/profesor_ensayos',$data);
        
	}
    
	public function control_ensayo()
	{
		$this->load->view('profesor/profesor_control_ensayo');
	}

    public function show_alumnos($id_curso, $ap, $colegio, $id_estado)
    {
         
        $alumnos    = $this->alumno_model->get_from_curso($id_curso);
        $cont       = 1;

        $tabla = "<table class='table table-bordered table-hover table-striped'>
                    <thead>
                        <tr style='background-color: #50beef;'>
                            <th style='color: white!important;'>N°</th>
                            <th style='color: white!important;'>Rut</th>
                            <th style='color: white!important;'>Alumno</th>
                            <th style='color: white!important;'>Acciones</th>
                        </tr></thead>";      
        foreach ($alumnos as $key => $value) 
        {
            if($this->hojarespuesta_model->have_respuesta($value->id_usuario, $ap, $colegio))
            {
                $colortr = " style='background-color: #DFF0D8;'";
            }
            else
                $colortr = "";   

            $finalizado = $this->alumno_model->esFinalizado($colegio, $value->id_usuario, $ap);
            
            if($finalizado == 1 && $id_estado != 3)
                $habilitar = "<a class='habilitar' id='".$value->id_usuario."' href='#'>Habilitar</a>";
            else
                $habilitar = "";

            $tabla  .= "<tr".$colortr.">
                        <td>$cont</td>
                        <td>".$this->formatea_rut($value->rut)."</td>
                        <td>".$value->nombre." ".$value->apellido."</td>
                        <td>".$habilitar."</td>
                        </tr>";
            $cont++;                
        }

        $tabla .= "</table>";

        $data['id_asignacionprueba']    = $ap;
        $data['colegio']               = $colegio;
        $data['alumnos']                = $tabla; 

        $this->load->view('profesor/alumnos', $data);
    }

    function formatea_rut( $rut ) 
    {
    
        return number_format( substr ( $rut, 0 , -1 ) , 0, "", ".") . '-' . substr ( $rut, strlen($rut) -1 , 1 );
    }

    
    function habilitar_alumno($id_usuario, $colegio, $id_asignacionprueba)
    {
        $data['success'] = "error";

        if($this->alumno_model->habilitar_alumno($colegio, $id_usuario, $id_asignacionprueba))
            $data['success'] = "success";

        echo json_encode($data);
    }
	
}
?>