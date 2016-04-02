<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once ("secure_area.php");

class Pregunta extends Secure_area
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pregunta_model');
        $this->load->model('Prueba_model');
        
        if(!$this->usuario_model->has_permission($this->session->userdata('perfil'),4))
        {
            redirect('no_access/'.$module_id);
        }
    }
    
     /********************************Funciones Generales****************************************/
    public function selected($a, $b)
    {
        if($a == $b)
            return " selected";
        else
            return "";
    }
    /*******************************************************************************************/

    public function index($id_prueba){
        
        $prueba = $this->Prueba_model->get_prueba($id_prueba);

        $data['usuario'] = $this->session->userdata('fullname');
        $data['title_page'] = "Pruebas | Preguntas";
        $data['close_menu'] = false;
        $data['id_prueba'] = $id_prueba;
        $data['cod_prueba']=$prueba->codigo;

        $this->load->view('partial/header_buscador', $data);
        $this->load->view('admin/pregunta/home', $data);
        $this->load->view('partial/footer', $data);
    }

    /* obtiene el listado de preguntas de una prueba */
    public function tabla($id_prueba)
    {
        
        $data="";
        $data.="<thead><tr style='background-color: #50beef;'>
            <th style='color: white!important;' width='100px'>N°</th>
            <th style='color: white!important;' width='500px'>Nombre</th>
            <th style='color: white!important;' width='164px '>Correcta</th>
            <th style='color: white!important;' width='400px'>Acciones</th>
            </thead></tr>";


        if(isset($id_prueba))
        {
        $preguntas = $this->Pregunta_model->get_preguntas($id_prueba);
        
        $resultado = array();

        if (is_array($preguntas) || is_object($preguntas))
        {
            foreach ($preguntas as $key => $value) 
            {
                $id_pregunta  = $value->id_pregunta;
                $cod_pregunta = $value->codigo;
                $cod_prueba   = $value->prueba_id_prueba;
                $correcta=$this->get_correcta($id_pregunta);

                $data.="<tr valign='top'>
                        <td>".($key+1)."</td>
                        <td>".$cod_pregunta."</td>
                        <td  style='text-align: center;' '>".$correcta."</td>
                        <td align='center'>
                            <button type='button' class='btn btn-primary btn-sm ver_pregunta' data-fancybox-type='iframe' href='".base_url()."index.php/pregunta/modal_ver_pregunta/".$id_pregunta."/".($key+1)."'><i class='glyphicon glyphicon-eye-open'></i> Ver</button>
                            <a class='btn btn btn-primary btn-sm' target='_blank' href='".base_url()."index.php/pregunta/edit_pregunta/".$id_pregunta."/".$cod_prueba."'><i class='glyphicon glyphicon-pencil'></i> Editar</a>
                            <button type='button' id='delete' class='btn btn-default btn-sm btn-danger' data-fancybox-type='iframe' href='".base_url()."index.php/pregunta/modal_delete/".$id_pregunta."'><i class='glyphicon glyphicon-trash'></i> Eliminar</button>
                            <a class='btn btn-sm btn btn-primary' href='".base_url()."index.php/respuesta/index/".$id_pregunta."' target='_blank'>Respuestas</a>
                        </td>
                    </tr>";
            }
        }   
       
        $resultado["filas"]=$data;
        echo json_encode($resultado);
        
        }
    }

    /* modal eliminacion pregunta */
    public function modal_delete($id_pregunta)
    {
        $this->load->model('Respuesta_model');
        $pregunta = $this->Pregunta_model->get_pregunta($id_pregunta);

        if($this->Respuesta_model->have_prueba($id_pregunta))
            {
                $mensaje = "<p class='fuente-modal-delete'>Error a intentar eliminar la pregunta, asegurese de haber eliminado las respuestas con anterioridad.</p>";
                $data['data_button'] = '<button type="button" class="btn btn-cancelar cerrar" data-dismiss="modal">Cancelar</button>';
            }
        else
            {
                $mensaje = "<form class='form-horizontal'>
                                <p class='fuente-modal-delete'> Está a punto de eliminar la Pregunta: '<strong>".$pregunta->codigo."</strong>'</p>
                                <p class='fuente-modal-delete'> ¿Está seguro que desea Continuar?</p>
                                <input type='hidden' id='id_pregunta' name='id_pregunta' value='".$id_pregunta."'>
                            </form>";
                $data['data_button'] = '<button type="button" class="btn btn-cancelar cerrar" data-dismiss="modal">Cancelar</button>
                                        <a id="enviar" href="#" class="btn btn-eliminar">Continuar</a>';
            }

        $data['data'] = $mensaje;

        $this->load->view('admin/pregunta/eliminar', $data);
    }

    /* metodo que elimina pregunta */ 
    public function delete()
    {
        if($this->Pregunta_model->delete($this->input->post('id_pregunta')))
            $data['success'] = "success";
        else
            $data['success'] = "error";

        echo json_encode($data);
    }

    /* INSERT Y UPDATE PREGUNTA*/

    public function save($id_pregunta=false)
    {
        $data=array(
            'codigo' => $this->input->post('codigo'),
            'titulo' => $this->input->post('codigo'),
            'contenido' => $this->input->post('editor'), 
            'prueba_id_prueba' => $this->input->post('id_prueba'),
            'taxonomia_id_taxonomia' => $this->input->post('taxonomia'),
            'dificultad_id_dificultad' => $this->input->post('dificultad'),
            'aprendizajeclave_id_aprendizajeclave' => $this->input->post('aprendizaje'),
            'eje_id_eje' => $this->input->post('eje')
            );

        
        if($this->Pregunta_model->save($data, $id_pregunta))
        {
            if($id_pregunta)
                $mensaje = "Pregunta actualizada satisfactoriamente";
            else
                $mensaje = "Pregunta agregada satisfactoriamente";
        }
        else
            $mensaje = "un error ocurrió";
        

        $valor['mensaje'] = $mensaje;
        
        echo json_encode($valor);
    }

    /* metodo que asigna una letra de altenrativa*/
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

    /* metodo que permite visualizar contenido de la pregunta */
    public function ver_pregunta($id_pregunta, $num_pregunta)
    {
        $pregunta = $this->Pregunta_model->get_pregunta($id_pregunta);

        $cod_pregunta=$pregunta->id_pregunta;
        $codigo_pregunta=$pregunta->codigo;
        $contenido_pregunta=$pregunta->contenido;

        $col="";
/*
        $col.="<div>    
                    <div style='float: left;background-color: 2f8fce; color:white; '>".$codigo_pregunta."&nbsp;</div>
                    <div style='background-color: 2f8fce; color:white; '>".$contenido_pregunta."</div>";
*/
        $col.=" <div class='contenedor-pregunta'>
                        <div class='pregunta-numero'><center>".$num_pregunta."</center></div>
                        <div class='pregunta-contenido'>".$contenido_pregunta."</div>
                    </div>";


        $respuestas= $this->Pregunta_model->get_resp($cod_pregunta);
        /*
        $col.="<div style='background-color: white; color:black; '>";
          */
        $col.="<div class='form-group' style='background-color:white;margin-bottom:-9px;padding:10px 0 10px 0;'>";
            $col.="<ul>";    
        if (is_array($respuestas) || is_object($respuestas))
        {
            foreach ($respuestas as $key => $value) 
            { 

                $key++;
                $letra=$this->alternativa($key);
                /*
                $col.= "<div><div style='float: left;'>".$letra."<input type='radio' name='respuesta' value='".$value->respuesta."' checked></div><div>".
                    $value->respuesta."</div></div>";
                */
                 $col.=" <li style='display:inline;'>
                            <div class='radio alt-psu'>
                                <span>".$letra."</span>
                                <input onclick='checkPreguntaMenuFixed(this)' name='ensayo[pregunta_5783]' type='radio' value='28807' id='ensayo_pregunta_5783_28807'> 
                                <div style='margin-left:50px;margin-top:-18px'>".$value->respuesta."</div>
                                </label>
                            </div><!-- radio alt-psu -->
                        </li>";   
            }

        }
            //$col.="</div></div>";
        $col.="</ul>";
            $col.="</div>";
        $result['data'] = $col;
       
        echo json_encode($result);
        
    }
    
    /* metodo que carga la vista de nueva pregunta */
    public function new_pregunta($id_prueba)
    {
        $prueba = $this->Prueba_model->get_prueba($id_prueba);

        $data['usuario'] = $this->session->userdata('fullname');
        $data['title_page'] = "Pruebas | Preguntas ingreso";
        $data['close_menu'] = false;
        $data['id_prueba'] = $id_prueba;
        //$data['fck1'] = $this->ckeditor();
        $data['cod_prueba']=$prueba->codigo;

        $this->load->view('partial/header', $data);
        $this->load->view('admin/pregunta/new_pregunta', $data);
        //$this->load->view('partial/footer', $data);
    }

    /* metodo que carga la vista para edicion de pregunta */
    public function edit_pregunta($id_pregunta, $id_prueba)
    {
        $prueba = $this->Prueba_model->get_prueba($id_prueba);

        $data['usuario'] = $this->session->userdata('fullname');
        $data['title_page'] = "Pruebas | Preguntas edicion";
        $data['close_menu'] = false;
        $data['id_pregunta']=$id_pregunta; 
        //$data['fck1'] = $this->ckeditor();
        $data['cod_prueba']=$prueba->codigo;

        $this->load->view('partial/header', $data);
        $this->load->view('admin/pregunta/edicion_pregunta', $data);
    }

    /* Modal para ver o visualizar pregunta */
    public function modal_ver_pregunta($id_pregunta, $num_pregunta)
    {
        $data['id_pregunta'] = $id_pregunta;
        $data['num_pregunta'] = $num_pregunta;
        $this->load->view('admin/pregunta/ver_pregunta', $data);
    }

    /* metodo que carga vista de listado de preguntas por prueba, se llama a través de ajax */
    public function pruebapreguntas($id_prueba){
        $data['usuario'] = $this->session->userdata('fullname');
        $data['title_page'] = "Pruebas | Preguntas";
        $data['close_menu'] = false;
        $data['id_prueba'] = $id_prueba;

        $this->load->view('partial/header_buscador', $data);
        $this->load->view('admin/preguntas/prueba_preg', $data);
        $this->load->view('partial/footer', $data);
    }

    /* obtiene los datos de una pregunta especifica */
    public function select_edit_pregunta($id_pregunta)
    {
        $pregunta = $this->Pregunta_model->get_pregunta($id_pregunta);
        $eje_pregunta = $this->Pregunta_model->get_eje($id_pregunta);

        $taxonomias = $this->Pregunta_model->get_taxonomias();
        $dificultades = $this->Pregunta_model->get_dificultades();
        $aprendizajes = $this->Pregunta_model->get_aprendizajes();
        $ejes = $this->Pregunta_model->get_ejes();

        /* CODIGO */
        $data = "<div class='input-group'>
                <span class='input-group-addon' id='basic-addon1' style='padding: 9px 42px;
                color: white;background-color: #2f8fce;'>Código</span>
                <input type='text' id='codigo' name='codigo' class='form-control' required='required' value='".$pregunta->codigo."' required>
                </div>";
        $data .= "<input type='hidden' id='id_prueba' name='id_prueba' required='required' value='".$pregunta->prueba_id_prueba."'>";
        $data .="<div id='espacio'>&nbsp;</div>"; 

        
        /* TAXONOMIAS */
        $data .= "<div class='input-group'>
                <span class='input-group-addon' id='basic-addon2' style='padding: 7px 29px;color: white;
                background-color: #2f8fce;'>Taxonomia</span>";

        $data .="<select name='taxonomia' class='form-control'>";
        
        foreach ($taxonomias as $key => $value)
            $data .= "<option value='".$value->id_taxonomia."'".$this->selected($value->id_taxonomia, $pregunta->taxonomia_id_taxonomia).">".$value->nombre."</option>";
        
        $data .="</select>";
        $data .="</div>";
        $data .="<div id='espacio'>&nbsp;</div>"; 


        /* DIFICULTADES */
        $data .= "<div class='input-group'>
                <span class='input-group-addon' id='basic-addon3' style='padding: 7px 34px;color: white;
                background-color: #2f8fce;'>Dificultad</span>";
        $data .="<select name='dificultad' class='form-control'>";
        $data .="<option value=''>Clic para seleccionar</option>";
        foreach ($dificultades as $key => $value)
            $data .= "<option value='".$value->id_dificultad."'".$this->selected($value->id_dificultad, $pregunta->dificultad_id_dificultad).">".$value->dificultad."</option>";
        
        $data .="</select>";
        $data .="</div>";
        $data .="<div id='espacio'>&nbsp;</div>"; 

        /* EJES */
        $data .= "<div class='input-group'>
                <span class='input-group-addon' id='basic-addon1' style='
                padding: 7px 53px;color: white;background-color: #2f8fce;'>Eje</span>";
        $data .= "<select name='eje' id='eje' class='form-control' required>";
        $data .="<option value=''>Clic para seleccionar</option>";
        foreach ($ejes as $key => $value)
            $data .= "<option value='".$value->id_eje."'".$this->selected($value->id_eje, $eje_pregunta->id_eje).">".$value->eje."</option>";

        $data.="</select>";
        $data .="</div>";
        $data .="<div id='espacio'>&nbsp;</div>"; 

        /* APRENDIZAJES */
        $data .= "<div class='input-group'>
                <span class='input-group-addon' id='basic-addon1' style='
                padding: 7px 26px;color: white;background-color: #2f8fce;'>Aprendizaje</span>";
        $data .="<select name='aprendizaje' id='aprendizaje' class='form-control' required>";
        $data .="<option value=''>Clic para seleccionar</option>";
        foreach ($aprendizajes as $key => $value)
            $data .= "<option value='".$value->id_aprendizajeclave."'".$this->selected($value->id_aprendizajeclave, $pregunta->aprendizajeclave_id_aprendizajeclave).">".$value->aprendizajeclave."</option>";
        
        $data .="</select>";
        $data .="</div>";
        $data .="<div id='espacio'>&nbsp;</div>";
        $data .=$this->ckeditor($pregunta->contenido);
        /**/
        $result['data'] = $data;
        //$result['editor'] = $pregunta->contenido;

        echo json_encode($result);
    }

    /* metodo que integra ckeditor */
    public function ckeditor($contenido)
    {// ckEditor es integrado al contralador cargando la libreria de esta manera para CodeIgniter 1.7.3, para anterioes versiones versiones cambia un poco
        $this->load->library('CKEditor',array('instanceName' => 'CKEDITOR1','basePath' => base_url()."ckeditor/", 'outPut' => true));                             
         
        // declaracion de arreglo
        $config = array();
         
        // dentro del arreglo asociativo, anidamos otro arreglo donde indicamos los elementos que la toolbar debe contener. En caso de omitir carga por defecto la toolbar completa
        $config['toolbar'] = array(
                array( 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike' ),
                array( 'Image', 'Link', 'Unlink', 'Anchor' ),
                array('JustifyCenter', 'JustifyLeft', 'JustifyRight', 'JustifyBlock'),
                array('TextColor', 'FontSize', 'Font'),
                array('Blockquote', 'SpecialChar', 'Preview', 'EqnEditor', 'Templates', 'CreateDiv')


        );
         
        // indicamos la ruta para ckFinder
        $config['filebrowserBrowseUrl'] = base_url()."ckeditor/ckfinder/ckfinder.html";
         
        // indicamos la ruta para el boton de la toolbar para subir imagenes
        $config['filebrowserImageBrowseUrl'] = base_url()."ckeditor/ckfinder/ckfinder.html?type=Images";
         
        // indicamos la ruta para subir archivos desde la pestaña de la toolbar (Quick Upload)
        $config['filebrowserUploadUrl'] = base_url()."ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files";
         
        // indicamos la ruta para subir imagenesdesde la pestaña de la toolbar (Quick Upload)
        $config['filebrowserImageUploadUrl'] = base_url()."ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images";
         
        // cargamos al arreglo que será enviado a la vista con el textarea ya convertido a editor de texto :D
        return $this->ckeditor->editor("editor", $contenido, $config);
        //$data['fck1'] = $this->ckeditor->editor("mi-textarea", "<p>Valor inicial.</p>",$config);
         
        // vista, aqui tienes tu pedido
        //$this->load->view('articles/add',$data);
    }


    /* obtiene los datos de una pregunta especifica */
    public function select_new_pregunta()
    {
        $taxonomias     = $this->Pregunta_model->get_taxonomias();
        $dificultades   = $this->Pregunta_model->get_dificultades();
        $aprendizajes   = $this->Pregunta_model->get_aprendizajes();
        $ejes           = $this->Pregunta_model->get_ejes();

        /*CODIGO*/

        $data = "<div class='input-group'>
                <span class='input-group-addon' id='basic-addon1' style='padding: 9px 42px;
                color: white;background-color: #2f8fce;'>Código</span>
                <input type='text' id='codigo' name='codigo' class='form-control' required>
                </div>";
        $data .="<div id='espacio'>&nbsp;</div>"; 

        /*TAXONOMIAS*/
        $data .="<div class='input-group'>
                <span class='input-group-addon' id='basic-addon1' style='padding: 7px 29px;color: white;
                background-color: #2f8fce;'>Taxonomia</span>
                <select name='taxonomia' id='taxonomia' class='form-control' required>
                    <option value=''>Seleccione</option>";
        
        foreach ($taxonomias as $key => $value)
            $data .= "<option value='".$value->id_taxonomia."'>".$value->nombre."</option>";
        
        $data .="</select></div>";
        $data .="<div id='espacio'>&nbsp;</div>"; 

        /*DIFICULTADES*/
        $data .="<div class='input-group'>
                <span class='input-group-addon' id='basic-addon1' style='padding: 7px 34px;color: white;
                background-color: #2f8fce;'>Dificultad</span>
                <select name='dificultad' id='dificultad' class='form-control' required>
                    <option value=''>Seleccione</option>";
        
        foreach ($dificultades as $key => $value)
            $data .= "<option value='".$value->id_dificultad."'>".$value->dificultad."</option>";
        
        $data .="</select></div>";
        $data .="<div id='espacio'>&nbsp;</div>"; 

        /*EJES*/
        $data .= "<div class='input-group'>
                <span class='input-group-addon' id='basic-addon1' style='
                padding: 7px 53px;color: white;background-color: #2f8fce;'>Eje</span>
                <select name='eje' id='eje' class='form-control' required>
                    <option value=''>Seleccione</option>";

        foreach ($ejes as $key => $value)
            $data .= "<option value='".$value->id_eje."'>".$value->eje."</option>";
        $data .="</select></div>";
        $data .="<div id='espacio'>&nbsp;</div>"; 

        /*APRENDIZAJES*/
        $data .="<div class='input-group'>
                <span class='input-group-addon' id='basic-addon1' style='
                padding: 7px 26px;color: white;background-color: #2f8fce;'>Aprendizaje</span>
                <select name='aprendizaje' id='aprendizaje' class='form-control' required>
                    <option value=''>Seleccione</option>";
        foreach ($aprendizajes as $key => $value)
            $data .= "<option value='".$value->id_aprendizajeclave."'>".$value->aprendizajeclave."</option>";            
        $data .="</select></div>";
                
        $data .="<div id='espacio'>&nbsp;</div>"; 
        $data .=$this->ckeditor("Ingrese nuevo texto");

        $result['data'] = $data;

        echo json_encode($result);
    }

    public function get_correcta($id_pregunta)
    {
        
        $correcta="No data";

            if($respuestas = $this->Pregunta_model->get_resp($id_pregunta))
                foreach ($respuestas as $key => $value) 
                    if ($value->escorrecta==1) 
                        switch ($key) 
                            {
                                case 0:
                                    $correcta="A";
                                    break;
                                case 1:
                                    $correcta="B";
                                    break;
                                case 2:
                                    $correcta="C";
                                    break;
                                case 3:
                                    $correcta="D";
                                    break;
                                case 4:
                                    $correcta="E";
                                    break;
                                default:
                                    $correcta="Z";
                                    break;
                            }
                            
        return $correcta;
    }
    

    /* metodo que obtiene listado de ejes para mostrarse despues en ajax */
    public function listado_ejes()
    {
        $ejes = $this->Pregunta_model->get_ejes();

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

    /* obtiene los ejes y aprendizajes de una pregunta especifica */
    public function aprendizaje_eje($id_eje)
    {
        $id_eje  = $this->input->post('elegido');
        $aprendizaje_eje = $this->Pregunta_model->get_aprendizaje_eje($id_eje);
        
        /*APRENDIZAJES DEL EJE*/

        $data="";
        $resultado = array();

        if (is_array($aprendizaje_eje) || is_object($aprendizaje_eje))
        {
            
            
            $data.="<option value=''>Seleccione</option>";
            foreach ($aprendizaje_eje as $key => $value)
            {
                $id_aprendizajeclave = $value->id_aprendizajeclave;
                $aprendizajeclave = $value->aprendizajeclave;

                $data .= "<option value='".$id_aprendizajeclave."'>"  .$aprendizajeclave."</option>";
            }
            
        }
       
        $resultado["filas"]=$data;
        print_r($data);

        //echo json_encode($resultado);
    }
}

?>