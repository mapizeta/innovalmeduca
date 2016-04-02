<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once ("secure_area.php");

class Prueba extends Secure_area
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Prueba_model');
        if(!$this->usuario_model->has_permission($this->session->userdata('perfil'),4))
        {
            redirect('no_access/'.$module_id);
        }
    }

    /********************************Funciones Generales*******************************************/
    public function selected($a, $b)
    {
        if($a == $b)
            return " selected";
        else
            return "";
    }
    /**********************************************************************************************/
    
    public function index()
    {
        $data['usuario'] = $this->session->userdata('fullname');
        $data['title_page'] = "Pruebas | Principal";
        $data['close_menu'] = false;

        $this->load->view('partial/header_buscador', $data);
        $this->load->view('admin/prueba/home', $data);
        
    }

    /* metodo que obtiene el listado de pruebas */
    public function tabla_prueba()
    {
        $data="";
        $data.="<thead><tr style='background-color: #50beef;'>
            <th style='color: white!important;'>N°</th>
            <th style='color: white!important;'>Codigo</th>
            <th style='color: white!important;'>Subsector</th>
            <th style='color: white!important;'>Tipo</th>
            <th style='color: white!important;'>Nivel</th>
            <th style='color: white!important;'>Ensayo</th>
            <th style='color: white!important;'>Acciones</th>
            </tr></thead>";

        $resultado = array();
        $pruebas = $this->Prueba_model->get_pruebas();
        foreach ($pruebas as $key => $value) 
        {
            
            $resultado[$key]=$value;

            // extraigo el nombre de los campos
            $id_prueba = $value->id_prueba;
            $codigo = $value->codigo;
            $nombre = $value->nombre;
            $tipo   = $value->tipo_tipo;
            $nivel  = $value->id_nivel;
            $evaluacion = $value->evaluacion;
           
            $data.= "<tr>
                        <td>".($key+1)."</td>
                        <td>".$codigo."</td>
                        <td>".$nombre."</td>
                        <td>".$tipo."</td>
                        <td>".$nivel."</td>
                        <td>".$evaluacion."</td>
                        <td>
                            <center>                        
                                <a href='pregunta/index/".$id_prueba."'><button type='button' class='btn btn-primary' data-toggle='' data-target=''><i class='glyphicon glyphicon-question-sign'></i> Preguntas</button></a>
                                <button type='button' class='btn btn-primary edit_prueba' data-fancybox-type='iframe' href='".base_url()."index.php/prueba/modal_edit_prueba/".$id_prueba."'><i class='glyphicon glyphicon-pencil'></i> Editar</button>
                                <a target='_blank' href='ensayo/visualizar/".$id_prueba."'><button type='button' class='btn btn-primary' ><i class='glyphicon glyphicon-eye-open'></i> Visualizar</button></a>
                                <button type='button' id='delete_prueba' class='btn btn-danger' data-fancybox-type='iframe' href='".base_url()."index.php/prueba/modal_delete_prueba/".$id_prueba."'><i class='glyphicon glyphicon-trash'></i> Eliminar</button>
                            </center>                    
                        </td>
                    </tr>";
            
        }

        $resultado["filas"]=$data;
        echo json_encode($resultado);

    }

    /* modal nueva prueba */
    public function modal_new_prueba()
    {
        $this->load->view('admin/prueba/new_prueba');
    }


    /*INSERT y UPDATE*/

    public function save($id_prueba = false)
    {
        
        $data = array(
            'codigo' => $this->input->post('codigo'),
            'nivel_id_nivel' => $this->input->post('nivel'),
            'subsector_id_subsector' => $this->input->post('subsector'), 
            'tipo' => $this->input->post('tipo'),
            'evaluacion' => $this->input->post('evaluacion')
            );
        
        if($this->Prueba_model->save($data, $id_prueba))
        {
            if($id_prueba)
                $mensaje = "Prueba actualizada satisfactoriamente";
            else
                $mensaje = "Prueba agregada satisfactoriamente";
        }
        else
            $mensaje = "un error ocurrió";
        
        $valor['mensaje'] = $mensaje;
        //$valor['mensaje'] = $data;
         
        echo json_encode($valor, true);
    }
                         

    /* Modal edición de  prueba */
    public function modal_edit_prueba($id_prueba)
    {
        $data['id_prueba'] = $id_prueba;
        $this->load->view('admin/prueba/edit_prueba', $data);
    }

    /* metodo que obtiene categorias para generar una nueva prueba */
    public function new_prueba()
    {
        $niveles        = $this->Prueba_model->get_niveles();
        $subsectores    = $this->Prueba_model->get_subsectores();

        /*CODIGO*/
        $data = "<div class='input-group'>
                    <span class='input-group-addon' id='basic-addon1'>Código</span>
                    <input type='text' class='form-control' id='codigo' name='codigo' placeholder='Código' required>
                 </div>";
        $data.= "<div id='error' class='alert alert-danger' role='alert' style='margin-bottom:-10px;display:none;padding-left:225px;padding-right:225px;'></div>";
        $data .="<div id='espacio'></div>";         
        $data .= "<input type='hidden' id='evaluacion' name='evaluacion'>";
        /*NIVELES*/
        $data .="<select name='nivel' class='form-control' required>
                    <option value=''>Nivel</option>";
        
        foreach ($niveles as $key => $value)
            $data .= "<option value='".$value->id_nivel."'>".$value->nivel."</option>";
        
        $data .="</select>";
        $data .="<div id='espacio'></div>";
        /*SUBSECTORES*/
        $data.="<select name='subsector' class='form-control' required>
                    <option value=''>Subsector</option>";
        
        foreach ($subsectores as $key => $value)
            $data .= "<option value='".$value->id_subsector."'>".$value->nombre."</option>";
        
        $data .="</select>";
        $data .="<div id='espacio'></div>";
        /*TIPO*/
        $data .= "<select name='tipo' id='tipo' class='form-control' required>
                    <option value=''>Tipo</option>";
                
        $data .= "<option value='1'>SIMCE</option>";
        $data .= "<option value='2'>PME</option>";
        
        $data .= "</select>";  
        $data .="<div id='espacio'></div>";
        /*N° Evaluacion*/
        $data .="<select name='simce' id='simce' class='form-control ensayo' style='display:none'>
                    <option value=''>Evaluacion</option>";

            $data .= "<option value='1' class='simce'>1°</option>";
            $data .= "<option value='2' class='simce'>2°</option>";
            $data .= "<option value='3' class='simce'>3°</option>";
            $data .= "<option value='4' class='simce'>4°</option>";
            $data .= "<option value='5' class='simce'>5°</option>";
            $data .= "<option value='6' class='simce'>6°</option>";
        
        $data .= "</select>";
        $data .="<div id='espacio'></div>";  
        $data .="<select name='pme' id='pme' class='form-control ensayo' style='display:none'>
                    <option value=''>Evaluacion</option>";

            $data .= "<option value='1' class='simce'>Diagnostico</option>";
            $data .= "<option value='2' class='simce'>Intermedio</option>";
            $data .= "<option value='3' class='simce'>Final</option>";
        
        $data .= "</select>";
        
        $result['niveles'] = $data;

        echo json_encode($result);
                
    }

    /* metodo que obtiene los datos de una prueba especifica */
    public function edit_prueba($id_prueba)
    {
        $prueba = $this->Prueba_model->get_prueba($id_prueba);

        $niveles        = $this->Prueba_model->get_niveles();
        $subsectores    = $this->Prueba_model->get_subsectores();

        /*CODIGO*/
        $data = "<div class='input-group'>
                    <span class='input-group-addon' id='basic-addon1'>Código</span>
                    <input type='text' class='form-control' id='codigo' name='codigo' placeholder='Código' value='".$prueba->codigo."' required>
                 </div>";
        $data.= "<div id='error' class='alert alert-danger' role='alert' style='margin-bottom:-10px;display:none;padding-left:225px;padding-right:225px;'></div>";
        $data .="<div id='espacio'></div>";
  
        $data .= "<input type='hidden' id='evaluacion' name='evaluacion' value='".$prueba->evaluacion."'>";
        $data .= "<input type='hidden' id='id_prueba' name='id_prueba' value='".$prueba->id_prueba."'>";
        /*NIVELES*/
        $data .="<select name='nivel' class='form-control'> required";
        
        foreach ($niveles as $key => $value)
            $data .= "<option value='".$value->id_nivel."'".$this->selected($value->id_nivel, $prueba->nivel_id_nivel).">".$value->nivel."</option>";
        
        $data .="</select>";
        $data .="<div id='espacio'></div>";
        /*SUBSECTORES*/
        $data.="<select name='subsector' class='form-control'> required";
        
        foreach ($subsectores as $key => $value)
            $data .= "<option value='".$value->id_subsector."'".$this->selected($value->id_subsector, $prueba->subsector_id_subsector).">".$value->nombre."</option>";
        
        $data .="</select>";
        $data .="<div id='espacio'></div>";
        /*TIPO*/
        $data .= "<select name='tipo' id='tipo' class='form-control'> required";
                
        $data .= "<option value='1'".$this->selected(1, $prueba->tipo).">SIMCE</option>";
        $data .= "<option value='2'".$this->selected(2, $prueba->tipo).">PME</option>";
        
        $data .= "</select>";  
        $data .="<div id='espacio'></div>";
        /*N° Evaluacion*/
        
        if($prueba->tipo == 1)
            {
                $data .="<select name='simce' id='simce' class='form-control ensayo'>";
                $data .= "<option value='1' class='simce'".$this->selected(1, $prueba->evaluacion).">1°</option>";
                $data .= "<option value='2' class='simce'".$this->selected(2, $prueba->evaluacion).">2°</option>";
                $data .= "<option value='3' class='simce'".$this->selected(3, $prueba->evaluacion).">3°</option>";
                $data .= "<option value='4' class='simce'".$this->selected(4, $prueba->evaluacion).">4°</option>";
                $data .= "<option value='5' class='simce'".$this->selected(5, $prueba->evaluacion).">5°</option>";
                $data .= "<option value='6' class='simce'".$this->selected(6, $prueba->evaluacion).">6°</option>";
                $data .= "</select>";

                $data .="<select name='pme' id='pme' class='form-control ensayo' style='display:none'>";
                $data .= "<option value='1' class='simce'>Diagnostico</option>";
                $data .= "<option value='2' class='simce'>Intermedio</option>";
                $data .= "<option value='3' class='simce'>Final</option>";
                $data .= "</select>";
                $data .="<div id='espacio'></div>";
            }
        else
            {
                $data .="<select name='pme' id='pme' class='form-control ensayo'>";
                $data .= "<option value='1' class='pme'".$this->selected(1, $prueba->evaluacion).">Diagnostico</option>";
                $data .= "<option value='2' class='pme'".$this->selected(2, $prueba->evaluacion).">Intermedio</option>";
                $data .= "<option value='3' class='pme'".$this->selected(3, $prueba->evaluacion).">Final</option>";
                $data .= "</select>";  
                $data .="<select name='simce' id='simce' class='form-control ensayo' style='display:none'>
                <option value='0'>Evaluacion</option>";

                $data .= "<option value='1' class='simce'>1°</option>";
                $data .= "<option value='2' class='simce'>2°</option>";
                $data .= "<option value='3' class='simce'>3°</option>";
                $data .= "<option value='4' class='simce'>4°</option>";
                $data .= "<option value='5' class='simce'>5°</option>";
                $data .= "<option value='6' class='simce'>6°</option>";
                $data .= "</select>"; 
                $data .="<div id='espacio'></div>";
            }
         
        $result['niveles'] = $data;
        echo json_encode($result);
    }

    /* modal de eliminacion de prueba */
    public function modal_delete_prueba($id_prueba)
    {
        $prueba = $this->Prueba_model->get_prueba($id_prueba);

        $this->load->model('Asignacionprueba_model');
        $this->load->model('Pregunta_model');

        if($this->Asignacionprueba_model->have_prueba($id_prueba)){
            $data['data'] = "<p class='fuente-modal-delete'>No se puede eliminar prueba ".$prueba->codigo.", debido a que tiene al menos una asignación.</p>";
            $data['data_button'] = "<button type='button' class='btn btn-cancelar cerrar' data-dismiss='modal'>Cancelar</button>";        }
        
        elseif($this->Pregunta_model->have_prueba($id_prueba))
            {
                $data['data'] = "<p class='fuente-modal-delete'>No se puede eliminar prueba ".$prueba->codigo.", debido a que tiene al menos una pregunta.</p>";
                $data['data_button'] = "<button type='button' class='btn btn-cancelar cerrar' data-dismiss='modal'>Cancelar</button>";
            }
        else
            {
                $data['data'] = "<form class='form-horizontal'>
                                            <p class='fuente-modal-delete'> Está a punto de eliminar la Prueba: '<strong>".$prueba->codigo."</strong>'</p>
                                            <p class='fuente-modal-delete'> ¿Está seguro que desea Continuar?</p>
                        
                                            <input type='hidden' id='id_prueba' name='id_prueba' value='".$id_prueba."'>
                                        </form>";
                $data['data_button'] = "<button type='button' class='btn btn-cancelar cerrar' data-dismiss='modal'>Cancelar</button>
                                        <a id='enviar' href='#' class='btn btn-eliminar'>Continuar</a>"; }

        $this->load->view('admin/prueba/eliminar', $data);
    }

    /* eliminacion de prueba */
    public function delete()
    {
        if($this->Prueba_model->delete($this->input->post('id_prueba')))
            $data['success'] = "success";

        echo json_encode($data);
    }

    /* listado de preguntas de una prueba especifica */
    public function tabla_pregunta($id_prueba)
    {
        $data="";
        $data.="<thead><tr style='background-color: #50beef;'>
            <th style='color: white!important;'>N°</th>
            <th style='color: white!important;'>Nombre</th>
            <th style='color: white!important;width:370px;'>Acciones</th>
            </thead></tr>";

        if(isset($id_prueba))
        {
        $preguntas = $this->Prueba_model->get_preguntas($id_prueba);
        
        $resultado = array();

        if (is_array($preguntas) || is_object($preguntas))
        {
            foreach ($preguntas as $key => $value) 
            {
                $id_pregunta = $value->id_pregunta;
                $cod_pregunta = $value->codigo;

                $data.="<tr>
                        <td>".($key+1)."</td>
                        <td>".$cod_pregunta."</td>
                        <td>
                            <button type='button' class='btn btn-sm btn-primary' data-toggle='modal' data-target=''><i class='glyphicon glyphicon-eye-open'></i> Ver</button>
                            

                            <button type='button' class='btn btn btn-primary btn-sm edit_prueba' data-fancybox-type='iframe' href='".base_url()."index.php/prueba/muestra_modal_preg/".$id_pregunta."'><i class='glyphicon glyphicon-pencil'></i> Editar</button>
                            
                            <button type='button' class='btn btn-default btn-sm btn-danger' data-toggle='' data-target=''><i class='glyphicon glyphicon-trash'></i> Eliminar</button>
                            <a href='".base_url()."index.php/prueba/respuestas' target='_blank'>
                            <button type='button' class='btn btn-sm btn btn-primary' data-toggle='' data-target=''>Respuestas</button></a>
                            
                        </td>
                    </tr>";
            }
        }   
       
        $resultado["filas"]=$data;
        echo json_encode($resultado);
        
        }
    }

    /* metodo que obtiene listado de ejes para mostrarse despues en ajax */
    public function listado_ejes(){
        $ejes = $this->Prueba_model->get_ejes();

        $data="";
        $resultado = array();

        if (is_array($ejes) || is_object($ejes))
        {
            foreach ($ejes as $key => $value) 
            {
                $id_eje = $value->id_eje;
                $eje = $value->eje;

                $data.="<option value=".$id_eje.">".$eje. "</option>";
            }

            $resultado["filas"]=$data;
            echo json_encode($resultado);
        }
    }

    /* metodo que obtiene listado de taxonomias para mostrarse despues en ajax */
    public function listado_taxonomias(){
        $taxonomias = $this->Prueba_model->get_taxonomias();

        $data="";
        $resultado = array();

        if (is_array($taxonomias) || is_object($taxonomias))
        {
            foreach ($taxonomias as $key => $value) 
            {
                $id_taxonomia = $value->id_taxonomia;
                $nombre_taxonomia = $value->nombre;

                $data.="<option value=".$id_taxonomia.">".$nombre_taxonomia. "</option>";
            }

            $resultado["filas"]=$data;
            echo json_encode($resultado);
        }
    }

    /* metodo que obtiene listado de dificultades para mostrarse despues en ajax */
    public function listado_dificultades()
    {
        $dificultades = $this->Prueba_model->get_dificultades();

        $data="";
        $resultado = array();

        if(is_array($dificultades)||is_object($dificultades))
        {
           foreach ($dificultades as $key => $value) 
            {
                $id_dificultad = $value->id_dificultad;
                $dificultad = $value->dificultad;
                
                $data.="<option value=".$id_dificultad.">".$dificultad. "</option>";
            }

            $resultado["filas"]=$data;
            echo json_encode($resultado);
        }
    }

    /* metodo que obtiene listado de aprendizajes para mostrarse despues en ajax */
    public function listado_aprendizajes()
    {
        $aprendizajes = $this->Prueba_model->get_aprendizajes();

        $data="";
        $resultado = array();

        if(is_array($aprendizajes)||is_object($aprendizajes))
        {
            
            foreach ($aprendizajes as $key => $value) 
            {
                $id_aprendizaje = $value->id_aprendizajeclave;
                $aprendizajeclave = $value->aprendizajeclave;
                
                $data.="<option value=".$id_aprendizaje.">".$aprendizajeclave. "</option>";
            }
            
            $resultado["filas"]=$data;
            echo json_encode($resultado);
        }
    }

    public function exist_codigo()
    {
        $resultado["success"]="false";

        $codigo = $this->input->get('codigo');

            if($this->Prueba_model->exist_codigo($codigo))
                $resultado["success"]="success";
        
                
        echo json_encode($resultado);
    }
}
?>