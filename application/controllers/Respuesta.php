<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once ("secure_area.php");

class Respuesta extends Secure_area
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Respuesta_model');
        if(!$this->usuario_model->has_permission($this->session->userdata('perfil'),4))
        {
            redirect('no_access/'.$module_id);
        }
    }

    public function selected($a, $b)
    {
        if($a == $b)
            return " selected";
        else
            return "";
    }
    
    public function ckeditor($inicial=false)
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
        return $this->ckeditor->editor("editor", $inicial, $config);
        //$data['fck1'] = $this->ckeditor->editor("mi-textarea", "<p>Valor inicial.</p>",$config);
         
        // vista, aqui tienes tu pedido
        //$this->load->view('articles/add',$data);
    }

    public function index($id_pregunta)
    {
        $codigos = $this->Respuesta_model->get_name_prueba_pregunta($id_pregunta);

        $data['usuario'] = $this->session->userdata('fullname');
        $data['title_page'] = "Pruebas | Respuesta";
        $data['close_menu'] = false;
        $data['id_pregunta'] = $id_pregunta;
        $data['cod_prueba'] = $codigos->cod_prueba;
        $data['id_prueba'] = $codigos->id_prueba;
        $data['cod_pregunta'] = $codigos->cod_pregunta;


        $this->load->view('partial/header_buscador', $data);
        $this->load->view('admin/respuesta/home', $data);
        
    }
    
    public function alternativa($key)
    {
    	switch ($key) {
    		case 0:
    			$alternativa = "A";
    			break;
    		case 1:
    			$alternativa = "B";
    			break;
    		case 2:
    			$alternativa = "C";
    			break;
    		case 3:
    			$alternativa = "D";
    			break;
    		case 4:
    			$alternativa = "E";
    			break;			
    		default:
    			$alternativa = "Z";
    			break;
    	}
    
    return $alternativa;
    
    }
    
    public function escorrecta($alternativa)
    {
    	if($alternativa == '1')
    		$retorno = "VERDADERA";
    	else
    		$retorno = "FALSA";

    	return $retorno;
    }

    public function tabla($id_pregunta)
    {
        $data="";
        $data.="<thead><tr style='background-color: #50beef;'>
            <th style='color: white!important;'>ALTERNATIVA</th>
            <th style='color: white!important;'>CONTENIDO</th>
            <th style='color: white!important;'>PUNTAJE</th>
            <th style='color: white!important;'>CORRECTA</th>
            <th style='color: white!important;'>ACCIONES</th>
            </tr></thead>";

        $resultado = array();
        $respuestas =$this->Respuesta_model->get_all($id_pregunta);
        
        if($respuestas)       
            foreach ($respuestas as $key => $value) 
            {
                $id_respuesta = $value->id_respuesta;
                $respuesta = $value->respuesta;
                $escorrecta = $value->escorrecta;
                $puntaje   = $value->puntaje;
                           
                
                $data.= "<tr>
                            <td>".$this->alternativa($key)."</td>
                            <td>".$respuesta."</td>
                            <td>".$puntaje."</td>
                            <td>".$this->escorrecta($escorrecta)."</td>
                            <td>                        
                                <button type='button' id='edit' class='btn btn-default btn-sm btn-primary' data-fancybox-type='iframe' href='".base_url()."index.php/respuesta/modal_edit/".$id_respuesta."'><i class='glyphicon glyphicon-pencil'></i> Editar</button>
                                <button type='button' id='delete' class='btn btn-default btn-sm btn-danger' data-fancybox-type='iframe' href='".base_url()."index.php/respuesta/modal_delete/".$id_respuesta."/".$this->alternativa($key)."'><i class='glyphicon glyphicon-trash'></i> Eliminar</button>
                            </td>
                        </tr>";
                
            }

        $resultado["filas"]=$data;
        echo json_encode($resultado);

    }
    /****************************************************Modales******************************************************/
    public function modal_new($id_pregunta)
    {
        
        $contenido   = $this->ckeditor();
        $puntaje = "<div class='input-group'>
                    <span class='input-group-addon' id='basic-addon1'>Puntaje</span>
                    <input type='text' class='form-control' id='puntaje' name='puntaje' value='0' required='required'>
                 </div>";
        $escorrecta  = "<select name='escorrecta' id='escorrecta' class='form-control'><option value='0'>INCORRECTA</option><option value='1'>CORRECTA</option></select>";
        $id_preg = "<input type='hidden' id='id_pregunta' name='id_pregunta' value='$id_pregunta'>";
        $espacio     = "<div id='espacio'></div>";

        
        $data['data'] = "<form class='form-horizontal' id='formulario'>
                            ".$id_preg."
                            ".$contenido."
                            ".$espacio."
                            ".$puntaje."
                            ".$espacio."
                            ".$escorrecta."
                        </form>";
        

        /*
        $data['data'] = "
                            ".$id_preg."
                            ".$contenido."
                            ".$espacio."
                            ".$puntaje."
                            ".$espacio."
                            ".$escorrecta."
                        ";
        */

        $data['id_pregunta'] = $id_pregunta;
        $this->load->view('admin/respuesta/new_respuesta', $data);
    }

    public function modal_edit($id_respuesta)
    {
        
        $respuesta = $this->Respuesta_model->get_info($id_respuesta);
        $contenido   = $this->ckeditor($respuesta->respuesta);

        //$puntaje     = "<label>Puntaje: </label><input type='text' id='puntaje' name='puntaje' value='".$respuesta->puntaje."'>";
        $puntaje = "<div class='input-group'>
                    <span class='input-group-addon' id='basic-addon1'>Puntaje</span>
                    <input type='text' class='form-control' id='puntaje' name='puntaje' value='".$respuesta->puntaje."' required>
                 </div>";


        $escorrecta  = "<select name='escorrecta' id='escorrecta' class='form-control'><option value='1' ".$this->selected($respuesta->escorrecta, 1).">CORRECTA</option><option value='0' ".$this->selected($respuesta->escorrecta, 0).">INCORRECTA</option></select>";
        $id_preg = "<input type='hidden' id='id_pregunta' name='id_pregunta' value='".$respuesta->pregunta_id_pregunta."'>";

        $data['data'] = "<form class='form-horizontal'>
                            ".$id_preg."
                            ".$contenido."
                            ".$puntaje."
                            ".$escorrecta."
                        </form>";
        $data['id_respuesta'] =  $respuesta->id_respuesta;
        $data['id_pregunta'] = $respuesta->pregunta_id_pregunta;              

        $this->load->view('admin/respuesta/edit_respuesta', $data);
    }

    public function modal_delete($id_respuesta, $alternativa)
    {
               
        $data['data'] = "<form class='form-horizontal'>
                            <p class='fuente-modal-delete'> Está a punto de eliminar la Alternativa: '<strong>".$alternativa."</strong>'</p>
                            <p class='fuente-modal-delete'> ¿Está seguro que desea Continuar?</p>
        
                            <input type='hidden' id='id_respuesta' name='id_respuesta' value='".$id_respuesta."'>
                        </form>";

        $this->load->view('admin/respuesta/eliminar', $data);
    }
    /****************************************************************************************************************/
    
    // metodo que verifica si hay respuesta correcta en pregunta especifica
    public function verificar_resp_cor($id_pregunta, $id_respuesta=false)
    {
        $resp_correcta = $this->Respuesta_model->get_resp_correcta($id_pregunta,$id_respuesta);

        

        $data="";
        $mensaje="";
        $resultado=array();

        $correcta = $this->input->post('option');

        if (is_array($resp_correcta) || is_object($resp_correcta))
        {
            foreach ($resp_correcta as $key => $value) 
            {
                $codigo_respuesta = $value->id_respuesta;
                $data.="<p>" . ($key+1) .  "</p>";
                
            }
        }

        if(($correcta=="1")&&($data!=""))
        {
           
           $mensaje.="esta pregunta ya tiene respuesta correcta ingresada";
        }
        
        $resultado["filas"]=$mensaje;
        //$resultado["filas"]=$correcta;
        
        echo json_encode($resultado);
        //print_r($escorrecta);
    }

    public function ver_combo()
    {
       // $correcta ="";

        $correcta = $this->input->post('escorrecta');
        //$correcta=$this->input->get_post('escorrecta',TRUE);

        //print_r($escorrecta);
        $resultado=array();
        //
        //$resultado["filas"]=$correcta;

        $data="<p>". $correcta ."</p>";

        //$data="<p>hola</p>";

        $resultado["filas"]=$data;
        //print_r($data);


        //print_r("envio");
        echo json_encode($resultado);
    }


    public function delete()
    {
        if($this->Respuesta_model->delete($this->input->post('id_respuesta')))
            $data['success'] = "success";
        else
        	$data['success'] = "error";

        echo json_encode($data);
    }

    public function save($id_respuesta=false)
    
    {
        
        $data=array(
            'respuesta' => $this->input->post('editor'),
            'puntaje' => $this->input->post('puntaje'),
            'escorrecta' => $this->input->post('escorrecta'),
            'pregunta_id_pregunta' => $this->input->post('id_pregunta') 
            );

        if($this->Respuesta_model->save($data, $id_respuesta))
        {
            if($id_respuesta)
                $mensaje = "Respuesta actualizada satisfactoriamente";
            else
                $mensaje = "Respuesta agregada satisfactoriamente";
        }
        else
            $mensaje = "un error ocurrió";
        
        $valor['mensaje'] = $mensaje;
                
        //$valor['mensaje'] = $data;
        echo json_encode($valor);
    }
}