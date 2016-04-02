<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once ("secure_area.php");

class Administrator extends Secure_area 
{
    public function __construct()
        {
            parent::__construct();
            $this->load->model('Prueba_model');
            $this->load->model('alumno_model');
            $this->load->model('colegio_model');
            $this->load->model('registros_model');
            $this->load->model('Asignacionprueba_model');
            $this->load->model('comunas_model');
            if(!$this->usuario_model->has_permission($this->session->userdata('perfil'), 2))
            {
                redirect('no_access/'.$module_id);
            }
        }

	public function index()
	{

        $data['usuario'] = $this->session->userdata('fullname');
		$data['title_page'] = "Admin | Principal";
        $data['close_menu'] = false;

        $this->load->view('partial/header', $data);
        $this->load->view('admin/admin_home', $data);
        $this->load->view('partial/footer', $data);
    }

    function setearmeses()
    {
        $mes_actual = date('m');
        $stat       = array();
        $meses      = array('enero','febrero','marzo','abril','mayo','junio','julio', 'agosto','septiembre','octubre','noviembre','diciembre');
        $colegios   = $this->colegio_model->get_all();

        foreach ($colegios as $colegio_key => $colegio_value) 
        {
            foreach ($meses as $meses_key => $meses_value) 
            {
                $mes = $meses_key+1;

                if($mes_actual >= $mes)
                    $stat[$colegio_value->nombre][$mes] = 0;
            }    
        }

        return $stat;
    }

    public function stats_profe()
    {
        $mes_actual = date('m');
        $data['usuario']    = $this->session->userdata('fullname');
        $data['title_page'] = "Admin | Principal";
        $data['close_menu'] = false;
        $colegios           = $this->colegio_model->get_all();
        $meses              = array('enero','febrero','marzo','abril','mayo','junio','julio', 'agosto','septiembre','octubre','noviembre','diciembre');
        $series             = "";
        $colegios           = "";

        $stat = $this->setearmeses();

        for ($i=1; $i <= $mes_actual; $i++) 
        { 
            $registros = $this->registros_model->get_all($i);

            if($registros)
                foreach ($registros as $key => $value) 
                {
                    $stat[$value->nombre][$i] = $value->count;
                }
        }


        for ($i=1; $i <= $mes_actual; $i++) 
        { 
            $series.= "{
                name: '".$meses[$i-1]."', data:[";
            foreach ($stat as $key => $value) 
            {
                $series.= $value[$i].",";    
            }
            $series.= "]},";
            
        }

        foreach ($stat as $key => $value) 
        {
            $colegios.= "'".$key."',";    
        }
          

        $data_body['series']    = $series;
        $data_body['colegios']  = $colegios;
        
        $this->load->view('partial/header', $data);
        $this->load->view('admin/estadisticas/acceso_profesores',$data_body);
        $this->load->view('partial/footer', $data);
    
    }

    public function crear_colegio()
    {

        $data_header['usuario'] = $this->session->userdata('fullname');
        $data_header['title_page'] = "Admin | Principal";
        $data_footer['close_menu'] = false;

        $this->load->view('partial/header', $data_header);
        $this->load->view('admin/miscelaneos/crear_colegio');
        $this->load->view('partial/footer', $data_footer);
    }

    public function importar_alumnos()
    {
        $data_header['usuario'] = $this->session->userdata('fullname');
        $data_header['title_page'] = "Admin | Principal";
        $data_footer['close_menu'] = false;

        $colegios = $this->colegio_model->get_all();
        $select = "<option value=''>Click aquí</option>";
        
        foreach ($colegios as $key => $value) 
        {
            $select .= "<option value='".$value->id_colegio."'>".$value->nombre."</option>";
        }

        $data['colegios'] = $select;

        $this->load->view('partial/header', $data_header);
        $this->load->view('admin/miscelaneos/importar_alumnos', $data);
        $this->load->view('partial/footer', $data_footer);
    }

    public function importar_alumno()
    {          
        $rut        =   $this->input->post('rut');
        $nombre     =   $this->input->post('nombre');
        $apellido   =   $this->input->post('apellido');
        $curso      =   $this->input->post('curso');
        $response['mensaje'] = "Ha ocurrido un error inesperado al ingresar el alumno";
        $response['success'] = "error";   

        if($this->alumno_model->existeRut($rut))
            {
                $response['mensaje'] = "Rut ya existe en la base de datos";
                $response['success'] = "error";   
            }
        else
            {
                              
                $data = array
                (
                    'username' => $rut,
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'perfil_id_perfil' => 3,
                    'contrasena' => '',
                    'email' => 'alumno@simce.cl'
                );
                
                if($this->alumno_model->save($data, $curso))
                    {
                        $response['mensaje'] = "Alumno ingresado de forma satisfactoria";
                        $response['success'] = "success";
                    }
            }
        
        echo json_encode($response);        
    }

    public function tabla_asignaciones()
    {
        $data="";
        $data.="<thead><tr style='background-color: #50beef;'>
            <th style='color: white!important;'>N°</th>
            <th style='color: white!important;'>Colegio</th>
            <th style='color: white!important;'>Profesor</th>
            <th style='color: white!important;'>Prueba</th>
            <th style='color: white!important;'>Inicio</th>
            <th style='color: white!important;'>Término</th>
            <th style='color: white!important;'>Estado</th>
            <th style='color: white!important;'>Acciones</th>
            </tr></thead>";

        $resultado = array();
        $asignaciones = $this->asignacionprueba_model->get_all();
        foreach ($asignaciones as $key => $value) 
        {
            
            $resultado[$key]=$value;

            // extraigo el nombre de los campos
            $colegio    = $value->colegio; 
            $profesor   = $value->username." - ".$value->nombre." ".$value->apellido;
            $prueba     = $value->codigo;
            $inicio     = $value->inicio;
            $termino    = $value->termino;
            $estado     = $value->estado;
            $id_asignacionprueba = $value->id_asignacionprueba;
            $id_prueba  = 1;

            if($id_estado=$this->asignacionprueba_model->get_estado($id_asignacionprueba));


            if($id_estado == 1)
                {
                    $boton_estado   = "<a class='btn btn-warning btn-sm btn-primary cambiar_estado' data-fancybox-type='iframe' asignacion='".$id_asignacionprueba."' id='2' ><i class='glyphicon glyphicon-play-circle' ></i> Ejecutar</a>";        
                }
                
            if($id_estado == 2)
                {
                    $boton_estado = "<a class='btn btn-success btn-sm btn-primary cambiar_estado' data-fancybox-type='iframe' asignacion='".$id_asignacionprueba."' id='3' > <i class='glyphicon glyphicon-off' ></i> Finalizar</a>";
                }
            
            if($id_estado == 3)
                {
                    $boton_estado = "<a class='btn btn-warning btn-sm btn-primary cambiar_estado' data-fancybox-type='iframe' asignacion='".$id_asignacionprueba."' id='2' ><i class='glyphicon glyphicon-play-circle' ></i> Ejecutar</a>";                                        
                }

            $data.= "<tr>
                        <td>".($key+1)."</td>
                        <td>".$colegio."</td>
                        <td>".$profesor."</td>
                        <td>".$prueba."</td>
                        <td>".$inicio."</td>
                        <td>".$termino."</td>
                        <td>".$estado."</td>
                        <td>
                            <center>                        
                                ".$boton_estado."
                            </center>                    
                        </td>
                    </tr>";
            
        }

        $resultado["filas"]=$data;
        echo json_encode($resultado);

    }

    public function cambiar_estado($id_asignacionprueba, $estado)
    {

            $data['success'] = "";
       
            if($this->asignacionprueba_model->cambiar_estado($id_asignacionprueba, $estado))
                $data['success'] = "success";

        echo json_encode($data);
    }

    public function asignar_prueba()
    {
        $data['usuario'] = $this->session->userdata('fullname');
        $data['title_page'] = "Pruebas | Principal";
        $data['close_menu'] = false;

        $this->load->view('partial/header_buscador', $data);
        $this->load->view('admin/asignaciones/prueba', $data);
    }

    public function modal_asignarprueba()
    {
        $colegios = $this->colegio_model->get_all();
        $pruebas  = $this->prueba_model->get_pruebas();
        $select = "";
        
        foreach ($colegios as $key => $value) 
        {
            $select .= "<option value='".$value->id_colegio."'>".$value->nombre."</option>";
        }
        $data['colegios'] = $select;

        $select = "";
        
        foreach ($pruebas as $key => $value) 
        {
            $select .= "<option value='".$value->id_prueba."'>".$value->codigo."</option>";
        }
        $data['pruebas'] = $select;

        $this->load->view('admin/asignaciones/modal/new_asignacion', $data);
    }

    function save()
    {
        $colegio    = $this->input->post('colegio');
        $prueba     = $this->input->post('prueba');

        $data = array(
            'codigo' => $this->input->post('codigo'),
            'nivel_id_nivel' => $this->input->post('nivel'),
            'subsector_id_subsector' => $this->input->post('subsector'), 
            'tipo' => $this->input->post('tipo'),
            'evaluacion' => $this->input->post('evaluacion')
            );

        if($this->asignacionprueba_model->existe_asignacion($colegio, $prueba))
            $success = "existe";
        else
            if($this->asignacionprueba_model->save($data))
                $success = "success";

        $data['success'] = $success;
        echo json_encode($data);
    }

   public function asignar_cursos()
    {
        $data_header['usuario'] = $this->session->userdata('fullname');
        $data_header['title_page'] = "Admin | Principal";
        $data_footer['close_menu'] = false;
        $colegios = $this->colegio_model->get_all();
        
        $select = "<option value=''>Click aquí</option>";
        
        foreach ($colegios as $key => $value) 
        {
            $select .= "<option value='".$value->id_colegio."'>".$value->nombre."</option>";
        }

        $data['colegios'] = $select;

        $this->load->view('partial/header', $data_header);
        $this->load->view('admin/miscelaneos/asignar_cursos', $data);
        $this->load->view('partial/footer', $data_footer);
    }
 
//Importar desde Excel con libreria de PHPExcel
    public function cargar_excel(){

        $this->load->library('excel');

        $name   = $_FILES['archivo']['name'];
        $tname  = $_FILES['archivo']['tmp_name'];

        $html=' <thead>
                <tr>
                 <th>N°</th>
                 <th>Rut</th>
                 <th>Nombre</th>
                 <th>Apellido</th>
                 <th>Acción</th>
                  </tr>
                 </thead> <tbody>';

        $obj_excel = PHPExcel_IOFactory::load($tname);       
        $sheetData = $obj_excel->getActiveSheet()->toArray(null,true,true,true);

        $arr_datos = array();
        foreach ($sheetData as $index => $value) {   
        $html .= "<tr id=tr".($index-1).">";         
            if ( $index != 1 ){
 
                $html .="<td>".($index-1)."</td>";
                $html .="<td><input type='text' value='".$value['A']."'></td>";
                $html .="<td><input type='text' value='".$value['B']."'></td>";
                $html .="<td><input type='text' value='".$value['C']."'></td>";
                $html .="<td><button type='button' identificador='".($index-1)."' class=' btnRecorrer btn btn-default btn-sm ' data-fancybox-type='iframe' style='color: #f8f8f8; background-color: #2AA92E;' ><i class='glyphicon glyphicon-cloud-upload'></i></button></td>";
            $html .="</tr>";

            } 

            
        }

        $data['filas'] = $html;
         
        echo json_encode($data);           
    }


    function get_cursos($id_colegio)
    {
        $cursos = $this->colegio_model->get_cursos($id_colegio);

        $select = "<option value=''>Click aquí</option>";
        
        foreach ($cursos as $key => $value) 
        {
            $select .= "<option value='".$value->id_curso."'>".$value->nivel." ".$value->letra."</option>";
        }

        $data['cursos'] = $select;

        echo json_encode($data);
    }

    function get_regiones()
    {
        $regiones = $this->comunas_model->get_regiones();

        $select = "<option value=''>Click aquí</option>";
        
        foreach ($regiones as $key => $value) 
        {
            $select .= "<option value='".$value->id_region."'>".$value->nombre."</option>";
        }

        $data['regiones'] = $select;

        echo json_encode($data);
    }

    function get_provincias($id_region)
    {
        $provincias = $this->comunas_model->get_provincias($id_region);

        $select = "<option value=''>Click aquí</option>";
        
        foreach ($provincias as $key => $value) 
        {
            $select .= "<option value='".$value->id_provincia."'>".$value->nombre."</option>";
        }

        $data['provincias'] = $select;

        echo json_encode($data);
    }

     function get_comunas($id_provincia)
    {
        $comunas = $this->comunas_model->get_comunas($id_provincia);

        $select = "<option value=''>Click aquí</option>";
        
        foreach ($comunas as $key => $value) 
        {
            $select .= "<option value='".$value->id_comuna."'>".$value->nombre."</option>";
        }

        $data['comunas'] = $select;

        echo json_encode($data);
    }

    function add_cursos($id_colegio, $mediabasica, $maxletra)
    {
        $errores = "";

        switch ($mediabasica) 
        {
            case 'b':
                for ($nivel=1; $nivel <= 8 ; $nivel++) 
                { 
                    for ($letra=1; $letra <= $maxletra; $letra++) 
                    { 
                        if(!$this->colegio_model->insert_curso($id_colegio, $letra, $nivel))
                           $errores .= "\n * colegio:".$id_colegio." nivel:".$nivel." letra:".$letra; 
                    }
                }
                break;
            case 'm':
                for ($nivel=9; $nivel <= 12 ; $nivel++) 
                { 
                    for ($letra=1; $letra <= $maxletra; $letra++) 
                    { 
                        if(!$this->colegio_model->insert_curso($id_colegio, $letra, $nivel))
                           $errores .= "\n * colegio:".$id_colegio." nivel:".$nivel." letra:".$letra; 
                    }
                }
                break;
            case 'bm':
                for ($nivel=1; $nivel <= 12 ; $nivel++) 
                { 
                    for ($letra=1; $letra <= $maxletra; $letra++) 
                    { 
                        if(!$this->colegio_model->insert_curso($id_colegio, $letra, $nivel))
                           $errores .= "\n * colegio:".$id_colegio." nivel:".$nivel." letra:".$letra; 
                    }
                }
                break;    
            default:
                # code...
                break;
        }
        
        
        $data['errores'] = $errores;

        echo json_encode($data);
    }
   
}
?>
