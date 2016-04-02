<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("secure_area.php");

class Sql_consulta extends secure_area{

	function __construct()
    {
        parent::__construct();
        $this->load->model('consulta_model');
    }

    // metodo que muestra las pruebas asignadas a un usuario especifico
    public function pruebas_asignadas()
    {
        $usuario = '95970044';
        $datos = $this->consulta_model->get_lista($usuario);

        $contenido="";

        $this->contenido="<style>

            table.first {
            color: #003300;
            font-family: helvetica;
            font-size: 8pt;
        
            border-collapse: collapse; 
            border-left-width: 1px;
            border-right-width: 1px;
            border-top-width: 1px;
            border-bottom-width: 1px;
            
            border: solid #DDDDDD 1px; 
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            border-radius: 6px;
        
            }

            

            td {
       
            border: solid #DDDDDD 1px; 
            border-left-width: 1px;
            border-right-width: 1px;
            border-top-width: 1px;
            border-bottom-width: 1px;
            }
        </style>";

        $this->contenido.="<div><p><b>Asignaciones de prueba</b></p></div>";
        $this->contenido.="<table class='first' border='1'>
                        <tr bgcolor='#F5F5F5'>
                            <td> N°</td>
                            <td> Curso</td>
                            <td> Prueba</td>
                            <td> Inicio</td>
                            <td> Termino</td>
                            <td> Realizado</td>
                            <td> Estado</td>
                        </tr>";
    
        if (is_array($datos) || is_object($datos))
        {
            foreach ($datos as $key => $value) 
            {
                // extraigo el nombre de los campos
                $curso = $value->curso;
                $codigo = $value->codigo;
                $inicio = $value->inicio;
                $termino = $value->termino;
                $ejecutado   = $value->realizado;
                $estado  = $value->estado;
           
                $this->contenido.="<tr valign='top'>
                                <td> ".($key+1)."</td>
                                <td> ".$curso."</td>
                                <td> ".$codigo."</td>
                                <td> ".$inicio."</td>
                                <td> ".$termino."</td>
                                <td> ".$ejecutado."</td>
                                <td> ".$estado."</td>
                            </tr>";
            }
        }

        $this->contenido.="</table>";

        //print_r($this->contenido);
    }

    // metodo que muestra las pruebas asignadas 
    function asignacion_pruebas()
    {
        $datos_bd = $this->consulta_model->get_asignaciones_gen();

        $id_asignacionprueba = array();
        $curso_id_curso = array();

        if (is_array($datos_bd) || is_object($datos_bd))
        {
            foreach ($datos_bd as $key => $value) 
            {
                $this->id_asignacionprueba[] = $value->id_asignacionprueba;
                $this->curso_id_curso[] = $value->curso_id_curso;
            }
        }

        //print_r($this->id_asignacionprueba);
    }


    public function rendimiento_global()
    {
        $contenido_rg="";

        $this->contenido_rg="<style>

            table.first {
            color: #003300;
            font-family: helvetica;
            font-size: 8pt;
        
            border-collapse: collapse; 
            border-left-width: 1px;
            border-right-width: 1px;
            border-top-width: 1px;
            border-bottom-width: 1px;
            
            border: solid #DDDDDD 1px; 
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            border-radius: 6px;
        
            }

            

            td {
       
            border: solid #DDDDDD 1px; 
            border-left-width: 1px;
            border-right-width: 1px;
            border-top-width: 1px;
            border-bottom-width: 1px;
            }
        </style>";

        $this->contenido_rg.="<div align='center' class='fuente'>Rendimiento Global</div>";
        $this->contenido_rg.="<table class='first' cellpadding='0' cellspacing='0' border='1'>
                        <tr valign='top' bgcolor='#F5F5F5'>
                            <td colspan='3' align='center'> Rendimiento del Curso</td>
                            <td colspan='3' align='center'> % Alumnos por Nivel Simce</td>
                            <td align='center'>&nbsp;</td>
                        </tr>
                        <tr valign='top' align='center'>
                            <td> % Correctas</td>
                            <td> % Incorrectas</td>
                            <td> % Omitidas</td>
                            <td> Insuficiente</td>
                            <td> Elemental</td>
                            <td> Adecuado</td>
                            <td> Ptje. promedio</td>
                        </tr>
                        </table>";

        //print_r($this->contenido_rg);
    }

}