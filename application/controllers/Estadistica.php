<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estadistica extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();
            $this->load->model('estadistica_model');
            $this->load->library('JpGraph/Graph');
    }

    public function baseurl()
    {
        $base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
        $base_url .= "://".$_SERVER['HTTP_HOST'];
        $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
        
        return $base_url;
    }


    public function existe_file($nombre_archivo)
    {
        
        $ruta_archivo ="assets/images/".$nombre_archivo;


        if(file_exists($ruta_archivo))
        {
            print_r("archivo existe");
        }
        else
        {
            print_r("no se encontro archivo");
            print_r("<br/>");
        }
    }




    public function datos_prueba($id_asignacionprueba)
    {
        $datos_prueba=$this->estadistica_model->arrayPortada($id_asignacionprueba);  
        
        $nombre_colegio='';
        $id_tipo_prueba='';
        $tipo_prueba='';
        $nivel_curso_prueba='';
        $nombre_nivel_curso='';

        $nombre_subsector='';
        $fecha_realizacion='';
        $comuna='';

        $nombre_colegio=$datos_prueba[0]->colegio;
        $nombre_colegio=strtoupper($nombre_colegio);
        $this->nombre_colegio=$nombre_colegio;
        $this->codigo_prueba = $datos_prueba[0]->codigo;
        $this->letra = $datos_prueba[0]->letra;

        $this->id_tipo_prueba=$datos_prueba[0]->id_tipo;

        $tipo_prueba=$datos_prueba[0]->tipo;
        $tipo_prueba=strtoupper($tipo_prueba);
        $this->tipo_prueba=$tipo_prueba;

        $this->nivel_curso_prueba=$datos_prueba[0]->nivel_id_nivel;

        $nombre_subsector=$datos_prueba[0]->subsector;
        $nombre_subsector=strtoupper($nombre_subsector);
        $this->nombre_subsector=$nombre_subsector;

        $this->fecha_realizacion=$datos_prueba[0]->realizado;
        
        $comuna=$datos_prueba[0]->comuna;
        $comuna=ucwords($comuna);

        $this->comuna=$comuna;

        switch($this->nivel_curso_prueba)
        {
            case 1:
                $this->nombre_nivel_curso="PRIMERO BÁSICO";
            break;

            case 2:
                $this->nombre_nivel_curso="SEGUNDO BÁSICO";
            break;

            case 3:
                $this->nombre_nivel_curso="TERCERO BÁSICO";
            break;

            case 4:
                $this->nombre_nivel_curso="CUARTO BÁSICO";
            break;

            case 5:
                $this->nombre_nivel_curso="QUINTO BÁSICO";
            break;

            case 6:
                $this->nombre_nivel_curso="SEXTO BÁSICO";
            break;

            case 7:
                $this->nombre_nivel_curso="SÉPTIMO BÁSICO";
            break;

            case 8:
                $this->nombre_nivel_curso="OCTAVO BÁSICO";
            break;

            case 9:
                $this->nombre_nivel_curso="PRIMERO MEDIO";
            break;

            case 10:
                $this->nombre_nivel_curso="SEGUNDO MEDIO";
            break;

            case 11:
                $this->nombre_nivel_curso="TERCERO MEDIO";
            break;

            case 12:
                $this->nombre_nivel_curso="CUARTO MEDIO";
            break;

            default:
                $this->nombre_nivel_curso="";
            break;
        }

    }

    public function estilo_tabla($id_asignacionprueba)
    {
        $alias_subsector= $this->estadistica_model->subsector($id_asignacionprueba);
      
        $alias='';
        $this->alias=$alias_subsector;
        
        $imagen_encabezado='';
        $imagen_pie_pagina='';
        $imagen_portada='';
        $fondo_th='';
        $fondo_principal='';
        $fondo_col_principal='';
        $fondo_col_secundaria='';
        $fuente_color='';
        $fuente_color_portada='';
        $color_barra='';

        switch ($this->alias)
        {
            case "MATE":
                $this->imagen_encabezado='encabezado_mate.jpg';
                $this->imagen_pie_pagina='pie_pag_mate.jpg';
                $this->imagen_portada='portada_informe_mate.jpg';
                $this->fondo_th='#1d71b8';
                $this->fondo_principal='#d1d1d4';
                $this->fondo_col_principal='#1d71b8';
                $this->fondo_col_secundaria='#d1d1d4';
                $this->fuente_color='#1d71b8';
                $this->fuente_color_portada='#1d71b8';
                $this->fuente_color_th = 'white';
                $this->color_barra='#1d71b8';
                break;
            case "RESOL":
                $this->imagen_encabezado='encabezado_mate.jpg';
                $this->imagen_pie_pagina='pie_pag_mate.jpg';
                $this->imagen_portada='portada_informe_mate.jpg';
                $this->fondo_th='#1d71b8';
                $this->fondo_principal='#d1d1d4';
                $this->fondo_col_principal='#1d71b8';
                $this->fondo_col_secundaria='#d1d1d4';
                $this->fuente_color='#1d71b8';
                $this->fuente_color_portada='#1d71b8';
                $this->fuente_color_th = 'white';
                $this->color_barra='#1d71b8';
                break;
            case "LENG":
                $this->imagen_encabezado='encabezado_lengua.jpg';
                $this->imagen_pie_pagina='pie_pag_lengua.jpg';
                $this->imagen_portada='portada_informe_lenguaje.jpg';
                $this->fondo_th='#ea5bOc';
                $this->fondo_principal='#d1d1d4';
                $this->fondo_col_principal='#d86639';
                $this->fondo_col_secundaria='#d1d1d4';
                $this->fuente_color='white';
                $this->fuente_color_portada='#ea5bOc';
                $this->fuente_color_th = 'white';
                $this->color_barra='#d86639';
                break;
            case "COMLEC":
                $this->imagen_encabezado='encabezado_lengua.jpg';
                $this->imagen_pie_pagina='pie_pag_lengua.jpg';
                $this->imagen_portada='portada_informe_lenguaje.jpg';
                $this->fondo_th='#ea5bOc';
                $this->fondo_principal='#d1d1d4';
                $this->fondo_col_principal='#d86639';
                $this->fondo_col_secundaria='#d1d1d4';
                $this->fuente_color='white';
                $this->fuente_color_portada='#ea5bOc';
                $this->fuente_color_th = 'white';
                $this->color_barra='#d86639';
                break;
            case "CIEN":
                $this->imagen_encabezado='encabezado_ciencias.jpg';
                $this->imagen_pie_pagina='pie_pag_ciencias.jpg';
                $this->imagen_portada='portada_informe_ciencias.jpg';
                $this->fondo_th='#009640';
                $this->fondo_principal='#d1d1d4';
                $this->fondo_col_principal='#009640';
                $this->fondo_col_secundaria='white';
                $this->fuente_color='#009640';
                $this->fuente_color_portada='#009640';
                $this->fuente_color_th = 'white';
                $this->color_barra='#009640';
                break;
            case "HIST":
                $this->imagen_encabezado="encabezado_histo.jpg";
                $this->imagen_pie_pagina="pie_pag_histo.jpg";
                $this->imagen_portada="portada_informe_historia.jpg";
                $this->fondo_th='#dedc00';
                $this->fondo_principal='#d1d1d4';
                $this->fondo_col_principal='#dedc00';
                $this->fondo_col_secundaria='#d1d1d4';
                $this->fuente_color='black';
                $this->fuente_color_portada='black';
                $this->fuente_color_th = 'white';
                $this->color_barra='#dedc00';
                break;
            case "FORM":
                $this->imagen_encabezado="encabezado_histo.jpg";
                $this->imagen_pie_pagina="pie_pag_histo.jpg";
                $this->imagen_portada="portada_informe_historia.jpg";
                $this->fondo_th='#dedc00';
                $this->fondo_principal='#d1d1d4';
                $this->fondo_col_principal='#dedc00';
                $this->fondo_col_secundaria='#d1d1d4';
                $this->fuente_color='black';
                $this->fuente_color_portada='black';
                $this->fuente_color_th = 'white';
                $this->color_barra='#dedc00';
                break;
            default:
                $this->imagen_encabezado='';
                $this->imagen_pie_pagina='';
                $this->imagen_portada='';
                $this->fondo_th='';
                $this->fondo_principal='';
                $this->fondo_col_principal='';
                $this->fondo_col_secundaria='';
                $this->fuente_color='';
                $this->fuente_color_portada='';
                $this->color_barra='';
                break;
        }

        $estilo='';
        $this->estilo=
        '<style>
            .fuente{
               font-size: 10pt; 
               font-family: helvetica;
            }

            table.first {
            color: #003300;
            font-family: helvetica;
            font-size: 8pt;
        
            border-collapse: collapse; 
            border:groove white 1px;
            border-left-width: 1px;
            border-right-width: 1px;
            border-top-width: 1px;
            border-bottom-width: 1px;
            
            }

            th {

            background-color: '.$this->fondo_th.'; 
           
            border-left-width: 1px;
            border-right-width: 1px;
            border-top-width: 1px;
            border-bottom-width: 1px;

            border-left-color: white;
            border-right-color: white;
            border-top-color: white;
            border-bottom-color: white;
            color:'.$this->fuente_color_th.';
            }

            td {
       
            border:groove #ACCFE8 1px; 
            border-left-width: 1px;
            border-right-width: 1px;
            border-top-width: 1px;
            border-bottom-width: 1px;

            border-left-color: white;
            border-right-color: white;
            border-top-color: white;
            border-bottom-color: white;

            }

            .principal{
                
            background-color: '.$this->fondo_principal.';
            color: '.$this->fuente_color.';
            font-weight: bold;
            }

            .col_principal{

            background-color:'.$this->fondo_col_principal.';
            color:'.$this->fuente_color.';

            border-left-color: white;
            border-right-color: white;
            border-top-color: white;
            border-bottom-color: white;

            }

            .col_secundaria{
            
            background-color: '.$this->fondo_col_secundaria.';
            border-left-color: white;
            border-right-color: white;
            border-top-color: white;
            border-bottom-color: white;
                
            }

            .espacio{
               
                background-color:white; 
            }

        </style>';
    }


    public function tabla_portada($id_asignacionprueba)
    {
        $this->datos_prueba($id_asignacionprueba);

        $this->estilo_tabla($id_asignacionprueba);
        $this->estilo;

        $tabla_portada_a='';
        $tabla_portada_b='';
        
        $this->tabla_portada_a='<table cellspacing="0" cellpadding="0" border="0" align="center"
                style="font-size:28;color:'.$this->fuente_color.'">
        <tr><td align="center">INFORME ESTADISTICO</td></tr>
        <tr><td><b>'.$this->nombre_colegio.'</b></td></tr></table>';
        
        $this->tabla_portada_b='<table cellspacing="0" cellpadding="0" border="0" align="center"
                style="color:'.$this->fuente_color_portada.'" class="first">
                <tr valign="top">
                    <td width="400" align="left">PRUEBA '. $this->tipo_prueba .' DE '. $this->nombre_subsector. '</td>
                </tr>
                <tr valign="top">
                    <td align="left">'.$this->nombre_nivel_curso.' '.$this->letra.'</td>
                </tr>
                <tr valign="top">
                    <td align="left">Fecha Aplicación:</td>
                </tr>
                <tr valign="top">
                    <td align="left">19/11/2015</td>
                </tr>
                <tr valign="top">
                    <td align="left">'.$this->comuna. ', Chile</td>
                </tr>
                </table>';
    }


    /* metodo que obtiene los datos de rendimiento global */
    public function rendimiento_global($id_asignacionprueba)
    {
        $rendimiento=$this->estadistica_model->getRG($id_asignacionprueba);

        $totalcorrectas="";
        $totalincorrectas="";
        $totalomitidas="";
        $porc_inicial="";
        $porc_basico="";
        $porc_avanzado="";
        $prom="";

        $this->totalcorrectas=$rendimiento['totalcorrectas'];
        $this->totalincorrectas=$rendimiento['totalincorrectas'];
        $this->totalomitidas=$rendimiento['totalomitidas'];
        $this->porc_inicial=$rendimiento['porc_inicial'];
        $this->porc_basico=$rendimiento['porc_basico'];
        $this->porc_avanzado=$rendimiento['porc_avanzado'];
        $this->prom=$rendimiento['prom'];
    }



    /* tabla de rendimiento global*/
    public function tabla_rendimiento_global($id_asignacionprueba)
    {
        $this->estilo_tabla($id_asignacionprueba);
        $this->estilo;

        $this->rendimiento_global($id_asignacionprueba); 

        $contenido_ren_global="";
        $this->contenido_ren_global=$this->estilo;
        
        $this->contenido_ren_global.='<div align="center" class="espacio">Rendimiento Global</div>
                        <table border="1" align="center" class="first" cellpading="0" cellspacing="0">
                        <tr valign="top" align="center">
                            <th colspan="3">Rendimiento del Curso</th>
                            <th colspan="3">% Alumnos por Nivel Simce</th>
                            <th colspan="1">&nbsp;</th>
                        </tr>
                        <tr valign="top"  align="center" class="principal">
                            <td>% Correctas</td>
                            <td>% Incorrectas</td>
                            <td>% Omitidas</td>
                            <td>Insuficiente</td>
                            <td>Elemental</td>
                            <td>Adecuado</td>
                            <td>Ptje. promedio</td>
                        </tr>
                        <tr valign="top" align="center" class="principal">
                            <td>' .$this->totalcorrectas.'%</td>
                            <td>' .$this->totalincorrectas.'%</td>
                            <td>' .$this->totalomitidas.'%</td>
                            <td>' .$this->porc_inicial.'%</td>
                            <td>' .$this->porc_basico.'%</td>
                            <td>' .$this->porc_avanzado.'%</td>
                            <td>' .$this->prom.'</td>
                        </tr>
                        </table>';
    }


    /* tabla_estandares por alumno */
    public function tabla_estandares_por_alumno($id_asignacionprueba)
    {
        $this->estilo_tabla($id_asignacionprueba);
        $this->estilo;

        $this->rendimiento_global($id_asignacionprueba);
        $contenido_est_alumno="";

        $this->contenido_est_alumno=$this->estilo;

        $this->contenido_est_alumno.='<div align="center" class="espacio">Estándares por Alumno</div>
                        <table align="center" class="first" cellpadding="0" cellspacing="0" border="1">
                            <tr valign="top" bgcolor="#F5F5F5" align="center">
                                <th>Insuficiente</th>
                                <th>Elemental</th>
                                <th>Adecuado</th>
                            </tr>
                            <tr valign="top" align="center" class="principal">
                                <td>' .$this->porc_inicial.'%</td>
                                <td>' .$this->porc_basico.'%</td>
                                <td>' .$this->porc_avanzado.'%</td>
                            </tr>
                        </table>';
        //print_r($this->contenido_est_alumno);
    }




    /* grafico promedio estandares por alumno (barras simples)*/
    public function grafico_prom_estandares_por_alumno($id_asignacionprueba)
    {
        require_once (APPPATH.'/libraries/JpGraph/jpgraph_bar.php');

        $this->estilo_tabla($id_asignacionprueba);
        $this->rendimiento_global($id_asignacionprueba);

        $datos = array($this->porc_inicial,$this->porc_basico,$this->porc_avanzado);

        $grafica = new Graph(500,250,'auto');
        //$grafica->SetScale("textlin");
        $grafica->SetScale('textlin',0,100); // se determina el limite del eje y
        
        //Posicion de los puntos de posiciones del eje de las Y
        //$mayor = array(0,5,10);
        // $grafica->yaxis->SetTickPositions($mayor); 
        
        $grafica->ygrid->SetFill(true,'#fff','#DDDDDD@0.5'); 

        $grafica->SetMarginColor("#fff");
        $grafica->SetFrame(true,'#fff',1);   
        $grafica->SetBox(false);
        
        //Nombre de las columnas
        $columnas = array('Inicial','Elemental','Adecuado');
        $grafica->xaxis->SetTickLabels($columnas);

        $barras = new BarPlot($datos);
        $grafica->Add($barras);
        
        /*
        $barras->SetColor("#1d71b8");
        $barras->SetFillColor("#1d71b8");
        */

        $barras->SetColor($this->color_barra);
        $barras->SetFillColor($this->color_barra);

        $barras->SetWidth(45);
        $barras->SetValuePos('center');
        $barras->value->Show();
        //$barras->value->SetFormat('%d'); // valores en formato de numero entero
        $barras->value->SetColor($this->fuente_color);
        $barras->SetLegend("Logrado");
        
        $grafica->legend->SetPos(0.5,0.99,'center','bottom');
        $grafica->legend->SetFrameWeight(1);
        $grafica->title->Set("Promedio Estándares por Alumno");
        $grafica->Stroke(_IMG_HANDLER);

        global $img_graf_pro_est_alu;
        $this->img_graf_pro_est_alu = "assets/images/graf_pro_est_alu.jpg";
        $grafica->img->Stream($this->img_graf_pro_est_alu);
        
        /*
        $grafica->img->Headers();
        $grafica->img->Stream();
        */
    }


    /* metodo que obtiene los datos de rendimiento por habilidad */
    public function rendimiento_por_habilidad_orig($id_asignacionprueba)
    {
        $rendimiento_hab=$this->estadistica_model->getRH_orig($id_asignacionprueba);

        print_r($rendimiento_hab);

        $indice_hab='';
        $valor_rend_hab='';

        $this->indice_hab='';
        $this->valor_rend_hab='';

        $hab_rendimiento=array();
        $hab_no_logrado=array();
        $nombre_hab=array();

        $this->hab_rendimiento=array();
        $this->hab_no_logrado=array();
        $this->nombre_hab=array();

        foreach($rendimiento_hab as $key=>$value) 
        {
            $this->indice_hab.='<th align="center">'.$key. '</th>';
            $this->valor_rend_hab.='<td align="center">'.$rendimiento_hab[$key]. '%</td>';

            $this->hab_no_logrado[]=(100-$value);
            $this->hab_rendimiento[]=$value;
            $this->nombre_hab[]=substr($key,0,7);
            
        }
    }

    /* metodo que obtiene los datos de rendimiento por habilidad */
    public function rendimiento_por_habilidad($id_asignacionprueba)
    {
        $rh=$this->estadistica_model->getRH($id_asignacionprueba);

        $indice_hab='';
        $valor_rend_hab='';

        $this->indice_hab='';
        $this->valor_rend_hab='';

        $hab_rendimiento=array();
        $hab_no_logrado=array();
        $nombre_hab=array();

        $this->hab_rendimiento=array();
        $this->hab_no_logrado=array();
        $this->nombre_hab=array();

        $indice_hab='';
        $valor_rend_hab='';

        $this->indice_hab='';
        $this->valor_rend_hab='';

        /*
        foreach($rendimiento_hab as $key=>$value) 
        {
            //$this->nombre_hab[]=substr($key,0,7);
            $sub_array_a=array_keys($rendimiento_hab[$key]);
           
            foreach($sub_array_a as $subkey2=>$value_sub_2)
            {
                $this->hab_no_logrado[]=(100-$value[$value_sub_2]);
                $this->hab_rendimiento[]=$value[$value_sub_2];
                $this->nombre_hab[]=substr($key,0,7);

                //$this->indice_hab.='<th align="center"><b>'.substr($value_sub_2,0,10). '</b>'.'<br/>'.substr($key,0,10) . '</th>';
                $this->indice_hab.='<th align="center"><b>'.substr($value_sub_2,0,11). '</b></th>';
                $this->valor_rend_hab.='<td align="center">'.$value[$value_sub_2]. '%</td>';
            }
        }
        */
        foreach ($rh as $key => $value) 
        {
            $this->hab_no_logrado[]=(100-$value);
            $this->hab_rendimiento[]=$value;
            $this->nombre_hab[]=substr($key,0,7);

            $this->indice_hab.='<th align="center"><b>'.substr($key,0,11). '</b></th>';
            $this->valor_rend_hab.='<td align="center">'.$value. '%</td>';

        }

    }

    /* Tabla rendimiento por habilidad*/
    public function tabla_rendimiento_por_habilidad($id_asignacionprueba)
    {
        $this->estilo_tabla($id_asignacionprueba);
        $this->estilo;

        $this->rendimiento_por_habilidad($id_asignacionprueba);
        $cont_ren_hab=""; 

        $indice_hab=$this->indice_hab;
        $valor_rend_hab=$this->valor_rend_hab;

        $this->cont_ren_hab=$this->estilo;
            
        $this->cont_ren_hab.='
                        <div align="center" class="espacio">Rendimiento por Habilidad</div>
                        <table align="center" cellpadding="0" cellspacing="0" border="1" class="first">
                        <tr valign="top" align="center" bgcolor="#F5F5F5">'
                                .$indice_hab.
                            '</tr>
                            <tr valign="top" align="center" class="principal">'
                                .$valor_rend_hab.
                            '</tr>
                        </table>';
        //print_r($this->cont_ren_hab);
    }

    /* grafico promedio rendimiento por habilidad (barras compuestas 2 colores)*/
    public function grafico_prom_rendimiento_por_habilidad($id_asignacionprueba)
    {
        require_once (APPPATH.'/libraries/JpGraph/jpgraph_bar.php');

        $this->estilo_tabla($id_asignacionprueba);
        $this->rendimiento_por_habilidad($id_asignacionprueba);

        $porc_logrado = $this->hab_rendimiento;
        //$porc_no_logrado=$this->hab_no_logrado;
        $nombre_hab=$this->nombre_hab;

        $data1y_rhab = $porc_logrado;
        //$data2y_rhab = $porc_no_logrado;

        $graph_rhab = new Graph(700,360,'auto');
        //$grafica_simce->SetScale("textlin");
        $graph_rhab->SetScale('textlin',0,100); // se determina el limite del eje y

        //Posicion de los puntos de posiciones del eje de las Y
        //$mayor = array(0,20,40,60,80,100);

        //$graph_rhab->yaxis->SetTickPositions($mayor); 
        $graph_rhab->ygrid->SetFill(true,'#fff','#DDDDDD@0.5'); 

        $graph_rhab->SetMarginColor("#fff");
        $graph_rhab->SetFrame(true,'#fff',1);   
        $graph_rhab->SetBox(false);

        //$columnas_2_rhab = $nombre_hab;
        $graph_rhab->xaxis->SetTickLabels($nombre_hab);

        //$graph_rhab->yaxis->title->Set("Porcentaje");

        $b1plot_rhab = new BarPlot($data1y_rhab);
        $graph_rhab->Add($b1plot_rhab);

        $b1plot_rhab->SetColor($this->color_barra);
        $b1plot_rhab->SetFillColor($this->color_barra);


        $b1plot_rhab->SetWeight(0);
        $b1plot_rhab->SetValuePos('center');
        $b1plot_rhab->value->Show();
        
        $b1plot_rhab->SetFillColor($this->color_barra);

        $b1plot_rhab->SetLegend("Logrado");
        
        $b1plot_rhab->value->SetColor($this->fuente_color);

        $graph_rhab->legend->SetPos(0.5,0.996,'center','bottom');
        $graph_rhab->legend->SetFrameWeight(1);
        $graph_rhab->title->Set("Promedio Rendimiento por Habilidad");
        $graph_rhab->Stroke(_IMG_HANDLER);

        global $img_graf_pro_ren_hab;
        $this->img_graf_pro_ren_hab = "assets/images/graf_pro_ren_hab.jpg";
        $graph_rhab->img->Stream($this->img_graf_pro_ren_hab);
        
    }

    /* metodo que obtiene los datos de rendimiento por eje */
    public function rendimiento_por_eje($id_asignacionprueba)
    {
        $ren_eje= $this->estadistica_model->getRCE($id_asignacionprueba);

        $indice_eje='';
        $valor_rend_eje='';

        $this->indice_eje='';
        $this->valor_rend_eje='';

        $eje_rendimiento=array();
        $eje_no_logrado=array();
        $nombre_eje=array();

        $this->eje_rendimiento=array();
        $this->eje_no_logrado=array();
        $this->nombre_eje=array();

        foreach($ren_eje as $key=>$value) 
        {
            $this->indice_eje.='<th align="center">'.$key. '</th>';
            $this->valor_rend_eje.='<td align="center">'.$ren_eje[$key]. '%</td>';

            $this->eje_no_logrado[]=(100-$value);
            $this->eje_rendimiento[]=$value;
            $this->nombre_eje[]=$key;
        }
    }

    /* tabla rendimiento por eje */
    public function tabla_rendimiento_por_eje($id_asignacionprueba)
    {
        $this->estilo_tabla($id_asignacionprueba);
        $this->estilo;

        $this->rendimiento_por_eje($id_asignacionprueba); 
        
        //$cant=$this->ren_eje_lectura;
        $indice_eje=$this->indice_eje;
        $valor_rend_eje=$this->valor_rend_eje;

        $contenido_ren_eje="";

        $this->contenido_ren_eje=$this->estilo;
        
        $this->contenido_ren_eje.='
                       
                        <div align="center" class="espacio">Rendimiento por Eje</div>
                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="1" class="first">
                            <tr valign="top" align="center" bgcolor="#F5F5F5">'
                                .$indice_eje.
                            '</tr>
                            <tr valign="top" align="center" class="principal">'
                                .$valor_rend_eje.
                            '</tr>
                        </table>';
    }


    /* grafico de puntaje simce alumno (barras simples) */
    public function grafico_rendimiento_por_eje($id_asignacionprueba)
    {
        require_once (APPPATH.'/libraries/JpGraph/jpgraph_bar.php');

        $this->estilo_tabla($id_asignacionprueba);
        $this->rendimiento_por_eje($id_asignacionprueba);

        $porc_logrado = $this->eje_rendimiento;
        //$porc_no_logrado=$this->eje_no_logrado;
        $nombre_eje=$this->nombre_eje;

        $data1y_reje = $porc_logrado;
        //$data2y_reje = $porc_no_logrado;

        $graph_reje = new Graph(700,360,'auto');
        //$grafica_simce->SetScale("textlin");
        $graph_reje->SetScale('textlin',0,100); // se determina el limite del eje y

        //Posicion de los puntos de posiciones del eje de las Y
        //$mayor = array(0,20,40,60,80,100);
        
        //$graph_reje->yaxis->SetTickPositions($mayor); 
        $graph_reje->ygrid->SetFill(true,'#fff','#DDDDDD@0.5'); 

        $graph_reje->SetMarginColor("#fff");
        $graph_reje->SetFrame(true,'#fff',1);   
        $graph_reje->SetBox(false);

        //$columnas_2_reje = $nombre_eje;
        $graph_reje->xaxis->SetTickLabels($nombre_eje);

        //$graph_reje->yaxis->title->Set("Porcentaje");

        $b1plot_reje = new BarPlot($data1y_reje);
        $graph_reje->Add($b1plot_reje);


        $b1plot_reje->SetColor($this->color_barra);
        $b1plot_reje->SetFillColor($this->color_barra);

        $b1plot_reje->SetWeight(0);
        $b1plot_reje->SetValuePos('center');
        $b1plot_reje->value->Show();

        $b1plot_reje->value->SetColor($this->fuente_color);
        $b1plot_reje->SetLegend("Logrado");
        
        $graph_reje->legend->SetPos(0.5,0.996,'center','bottom');
        $graph_reje->legend->SetFrameWeight(1);
        $graph_reje->title->Set("Rendimiento por Eje");
        $graph_reje->Stroke(_IMG_HANDLER);
        

        global $img_graf_ren_eje;
        $this->img_graf_ren_eje = "assets/images/graf_ren_eje.jpg";
        $graph_reje->img->Stream($this->img_graf_ren_eje);
        
    }

    /* Tabla distribucion por tipo de respuesta */
    public function tabla_distribucion_tipo_resp($id_asignacionprueba)
    {
        $this->estilo_tabla($id_asignacionprueba);
        $this->estilo;

        $this->rendimiento_global($id_asignacionprueba);
        $contenido_dist_resp='';

        $this->contenido_dist_resp=$this->estilo;
        
        $this->contenido_dist_resp.='
                        <div align="center" class="espacio">Distribución por Tipo de Respuesta</div>
                        <table align="center" cellpadding="0" cellspacing="0" border="1" class="first">
                            <tr valign="top" align="center" bgcolor="#F5F5F5">
                                <th align="center">% Correctas</th>
                                <th align="center">% Incorrectas</th>
                                <th align="center">% Omitidas</th>
                            </tr>
                            <tr valign="top" align="center" class="principal">
                                <td>' .$this->totalcorrectas.'%</td>
                                <td>' .$this->totalincorrectas.'%</td>
                                <td>' .$this->totalomitidas.'%</td>
                            </tr>
                        </table>';
    }

    /* grafico distribución por tipo de respuesta (circular) */
    public function grafico_distribucion_tipo_resp($id_asignacionprueba)
    {
        require_once (APPPATH.'/libraries/JpGraph/jpgraph_pie.php');

        $this->rendimiento_global($id_asignacionprueba);

        $data_circ = array($this->totalcorrectas,$this->totalincorrectas,$this->totalomitidas);
        
        $columnas_circ = array('Correctas','Incorrectas','Omitidas');

        $graph_circ = new PieGraph(400,320);
        
        $graph_circ->title->Set("Distribución por Tipo de Respuesta");

        $graph_circ->SetMarginColor("#fff");
        $graph_circ->SetFrame(true,'#fff',1);   
        $graph_circ->SetBox(false);

        $p1 = new PiePlot($data_circ);
    
        $p1->ExplodeSlice(0);

        $p1->SetCenter(0.5);

        //$p1->SetLegends('Correctas','Incorrectas','Omitidas');

        $p1->SetLegends($columnas_circ);
        // No border
        $p1->ShowBorder(false);

        $graph_circ->legend->SetPos(0.1,0.996,'left','bottom');
        $graph_circ->legend->SetFrameWeight(1);

        $p1->SetGuideLines(true,false);
        $p1->SetGuideLinesAdjust(1.5);

        $p1->SetLabelType(PIE_VALUE_PER);    
        $p1->value->Show(); 
        $p1->SetSliceColors(array('#1d71b8','#ea1d25','orange'));

        $graph_circ->Add($p1);

        $graph_circ->Stroke(_IMG_HANDLER);

        global $img_graf_dist_resp;
    
        $this->img_graf_dist_resp = "assets/images/graf_dist_resp.jpg";

        $graph_circ->img->Stream($this->img_graf_dist_resp);
        
        /*
        $graph_circ->img->Headers();
        $graph_circ->img->Stream();
        */
    }

     /* metodo que obtiene el puntaje de prueba de los alumnos */
    public function puntaje_prueba_alumno($id_asignacionprueba)
    {
        $puntaje=$this->estadistica_model->getPSA($id_asignacionprueba);

        $fullname=array();
        $correctas=array();
        $incorrectas=array();
        $omitidas=array();
        $puntaje_simce=array();

        foreach ($puntaje as $key => $value) {

            $this->fullname[]=$puntaje[$key]['fullname'];
            $this->correctas[]=$puntaje[$key]['correctas'];
            $this->incorrectas[]=$puntaje[$key]['incorrectas'];
            $this->omitidas[]=$puntaje[$key]['incorrectas'];
            $this->puntaje_simce[]=$puntaje[$key]['psa'];
        }
    }

    /* grafico de puntaje prueba alumno (barras simples) */
    public function grafico_puntaje_prueba_alumno($id_asignacionprueba)
    {
        require_once (APPPATH.'/libraries/JpGraph/jpgraph_bar.php');

        $this->datos_prueba($id_asignacionprueba);
        $this->estilo_tabla($id_asignacionprueba);
        $this->puntaje_prueba_alumno($id_asignacionprueba);
       
        $datos_simce = $this->puntaje_simce;
       
        $grafica_simce = new Graph(920,500,'auto');
        //$grafica_simce->SetScale("textlin");
        $grafica_simce->SetScale('textlin',0,400); // se determina el limite del eje y
        //Posicion de los puntos de posiciones del eje de las Y
        $mayor = array(0,20,40,60,80,100,120,140,160,180,200,220,240,260,280,300,320,340,360,380,400);
        
        $grafica_simce->yaxis->SetTickPositions($mayor); 
        $grafica_simce->ygrid->SetFill(true,'#fff','#DDDDDD@0.5'); 

        $grafica_simce->SetMarginColor("#fff");
        $grafica_simce->SetFrame(true,'#fff',1);   
        $grafica_simce->SetBox(false);
        //Nombre de las columnas
        //$columnas_simce = array($this->contador);
        //$grafica_simce->xaxis->SetTickLabels($columnas_simce);
        $grafica_simce->yaxis->title->Set("Puntaje" . $this->tipo_prueba);

        $barras_simce = new BarPlot($datos_simce);
        $grafica_simce->Add($barras_simce);
        $barras_simce->SetColor($this->color_barra);
        //$barras_simce->SetFillColor("#1d71b8");
        $barras_simce->SetFillColor($this->color_barra);
        $barras_simce->SetWidth(12);
        //$barras_simce->SetValuePos('center');
        $barras_simce->value->Show();
        $barras_simce->value->SetFormat('%d'); // valores en formato de numero entero
        $barras_simce->value->SetAngle(85);
        $barras_simce->SetLegend("Alumnos");
        $barras_simce->value->SetColor("black");

        $grafica_simce->legend->SetPos(0.5,0.98,'center','bottom');
        $grafica_simce->legend->SetFrameWeight(1);
        $grafica_simce->title->Set("Puntaje ".$this->tipo_prueba." Por Alumno");
        $grafica_simce->Stroke(_IMG_HANDLER);

        global $img_graf_ptje_simce;
        $this->img_graf_ptje_simce = "assets/images/graf_ptje_simce.jpg";
        $grafica_simce->img->Stream($this->img_graf_ptje_simce);
        
        /*
        $grafica_simce->img->Headers();
        $grafica_simce->img->Stream();
        */
    }
    
    public function tabla_rend_alu_tipo_prueba($id_asignacionprueba)
    {
        
        $puntaje=$this->estadistica_model->getPSA($id_asignacionprueba);
        $this->datos_prueba($id_asignacionprueba);

        $this->estilo_tabla($id_asignacionprueba);
        $this->estilo;

        $contenido_tabla="";
        $this->contenido_tabla="";
        $this->contenido_tabla.=$this->estilo;

        $this->contenido_tabla.='<div align="center" class="espacio">Rendimiento por Alumno - Prueba '.$this->tipo_prueba.'</div>
                        <table align="center" border="1" cellpading="0" cellspacing="0" class="first">
                            <tr valign="top" align="center">
                                <th align="center" width="30">N°</th>
                                <th align="center" width="300">Alumno</th>
                                <th align="center" width="80">N° Correctas</th>
                                <th align="center" width="80">N° Incorrectas</th>
                                <th align="center" width="80">N° Omitidas</th>
                                <th align="center" width="80">Puntaje</th>
                            </tr>';

        foreach ($puntaje as $key => $value) 
        {
            $id_usuario = $value['id_usuario'];
            $nombre_alu = $value['fullname'];
            $num_correctas = $value['correctas'];
            $num_incorrectas = $value['incorrectas'];
            $num_omitidas = $value['omitidas'];

            $porc_correctas = $value['porc_correctas'];
            $porc_incorrectas = $value['porc_incorrectas'];
            $porc_omitidas = $value['porc_omitidas'];

            $puntaje = $value['psa'];
            $nota = $value['nota'];
            $nivel = $value['nivel'];
            
            $this->contenido_tabla.='<tr>
                                        <th align="center">'.($key+1).'</th>
                                        <th align="left">'.$nombre_alu.'</th>
                                        <td align="center" class="col_secundaria">'.$num_correctas.'</td>
                                        <td align="center" class="col_secundaria">'.$num_incorrectas.'</td>
                                        <td align="center" class="col_secundaria">'.$num_omitidas.'</td>
                                        <td align="center" class="col_secundaria">'.$puntaje.'</td>
                                    </tr>';
        }

        $this->contenido_tabla.='</table>';
        //print_r($this->contenido_tabla);
    }

    public function tabla_rend_alu_nota($id_asignacionprueba)
    {
        $puntaje=$this->estadistica_model->getPSA($id_asignacionprueba);

        $this->estilo_tabla($id_asignacionprueba);
        $this->estilo;

        $tabla_b="";
        $this->tabla_b=$this->estilo;
        
        $this->tabla_b.='<div align="center" class="espacio">Rendimiento por Alumno - Nota</div>
                        <table align="center" border="1" cellpading="0" cellspacing="0" class="first">';
        $this->tabla_b.='<tr>
                            <th align="center" width="30">N°</th>
                            <th align="center" width="300">Alumno</th>
                            <th width="80">N° Correctas</th>
                            <th width="80">% Logro</th>
                            <th width="80">Nivel</th>
                            <th width="80">Nota</th>
                        </tr>';
        //$this->tabla_b.=$this->cont_tabla_b;

        foreach ($puntaje as $key => $value) 
        {

            $id_usuario = $value['id_usuario'];
            $nombre_alu = $value['fullname'];
            $num_correctas = $value['correctas'];
            $num_incorrectas = $value['incorrectas'];
            $num_omitidas = $value['omitidas'];

            $porc_correctas = $value['porc_correctas'];
            $porc_incorrectas = $value['porc_incorrectas'];
            $porc_omitidas = $value['porc_omitidas'];

            $puntaje = $value['psa'];
            $nota = $value['nota'];
            $nivel = $value['nivel'];
            
            $this->tabla_b.='<tr>
                                <th align="center">'.($key+1).'</th>
                                <th align="left">'.$nombre_alu.'</th>
                                <td align="center" class="col_secundaria">'.$num_correctas.'</td>
                                <td align="center" class="col_secundaria">'.$porc_correctas.'%</td>
                                <td align="center" class="col_secundaria">'.$nivel.'</td>
                                <td align="center" class="col_secundaria">'.$nota.'</td>
                            </tr>';
        }

        $this->tabla_b.='</table>';
        //print_r($this->fullname);
        //print_r($this->tabla_b);  
    }

    /* metodo que obtiene los datos de deciles */
    public function deciles($id_asignacionprueba)
    {
       $decil= $this->estadistica_model->getDCL($id_asignacionprueba); 

        $decil_0="";
        $decil_1="";
        $decil_2="";
        $decil_3="";
        $decil_4="";
        $decil_5="";
        $decil_6="";
        $decil_7="";
        $decil_8="";
        $decil_9="";

        $this->decil_0=$decil['0'];
        $this->decil_1=$decil['1'];
        $this->decil_2=$decil['2'];
        $this->decil_3=$decil['3'];
        $this->decil_4=$decil['4'];
        $this->decil_5=$decil['5'];
        $this->decil_6=$decil['6'];
        $this->decil_7=$decil['7'];
        $this->decil_8=$decil['8'];
        $this->decil_9=$decil['9'];
    }

    /* grafico de deciles (barras simples) */
    public function grafico_deciles($id_asignacionprueba)
    {
        require_once (APPPATH.'/libraries/JpGraph/jpgraph_bar.php');
        
        $this->deciles($id_asignacionprueba);

        $datos = array($this->decil_0,$this->decil_1,$this->decil_2,$this->decil_3,$this->decil_4,$this->decil_5,$this->decil_6,$this->decil_7,$this->decil_8,$this->decil_9);

        $grafica = new Graph(700,400,'auto');
        //$grafica->SetScale("textlin");
        $grafica->SetScale('textlin',0,50); // se determina el limite del eje y

        //Posicion de los puntos de posiciones del eje de las Y
        //$mayor = array(0,5,10);
        //$grafica->yaxis->SetTickPositions($mayor); 
        $grafica->ygrid->SetFill(true,'#fff','#DDDDDD@0.5'); 

        $grafica->SetMarginColor("#fff");
        $grafica->SetFrame(true,'#fff',1);   
        $grafica->SetBox(false);
        
        //Nombre de las columnas
        $columnas = array('0%-9%','10%-19%','20%-29%','30%-39%','40%-49%','50%-59%','60%-69%','70%-79%','80%-89%','90%-100%');
        $grafica->xaxis->SetTickLabels($columnas);
        $grafica->yaxis->title->Set("Alumnos por Decil");

        $barras = new BarPlot($datos);
        $grafica->Add($barras);
        $barras->SetColor($this->color_barra);
        //$barras->SetFillColor("#1d71b8");
        $barras->SetFillColor($this->color_barra);

        $barras->SetWidth(45);
        //$barras->SetValuePos('center');
        $barras->value->Show();
        $barras->value->SetFormat('%d'); // valores en formato de numero entero
        $barras->SetLegend("N° Alumnos");
        $barras->value->SetColor("black");
        
        $grafica->legend->SetPos(0.5,0.98,'center','bottom');
        $grafica->legend->SetFrameWeight(1);
        $grafica->title->Set("Gráfico de Deciles");
        $grafica->Stroke(_IMG_HANDLER);

        global $img_graf_deciles;
        $this->img_graf_deciles = "assets/images/graf_deciles.jpg";
        $grafica->img->Stream($this->img_graf_deciles);
        
        /*
        $grafica->img->Headers();
        $grafica->img->Stream();
        */
    }

    public function detalle_respuestas_preguntas_por_alumno($id_asignacionprueba)
    {
        $det_resp=$this->estadistica_model->getDRA($id_asignacionprueba); 

        $this->estilo_tabla($id_asignacionprueba);
        $this->estilo;

        $tabla_det='';
        $this->tabla_det=$this->estilo;

        //print_r($det_resp);

        $this->tabla_det.='<div align="center" class="espacio">Detalle de Respuestas a Preguntas por Alumno</div>';
        $this->tabla_det.='<table border="1" align="center" class="first" nobr="true">';
        $this->tabla_det.='<tr valign="top">
                                <th width="40">N°</th>
                                <th width="200">Alumno</th>
                                <th width="140">Preguntas Correctas</th>
                                <th width="140">Preguntas Incorrectas</th>
                                <th width="140">Preguntas Omitidas</th>
                            </tr>';
        
        foreach ($det_resp as $key => $value) 
        {
            $this->tabla_det.='<tr valign="top">';
            $this->tabla_det.='<th align="center">'.($key+1).'</th>
                                <th align="left">'.$det_resp[$key]['fullname'].'</th>
                                <td align="center" class="col_secundaria">'.$det_resp[$key]['correctas'].'</td>
                                <td align="center" class="col_secundaria">'.$det_resp[$key]['incorrectas'].'</td>
                                <td align="center" class="col_secundaria">'.$det_resp[$key]['omitidas'].'</td>';
            $this->tabla_det.='</tr>';

            //print_r($tabla.$det_resp[$key]['fullname'].'<br/>');
            //print_r('<br/>');
            //print_r($tabla);
        }

        $this->tabla_det.='</table>';
        //print_r($this->tabla_det);
        /* print_r($det_resp[0]['fullname']); */
    }


    public function detalle_repeticiones_alternativas_preguntas($id_asignacionprueba)
    {
        $det_repeticion=$this->estadistica_model->getRAP($id_asignacionprueba);
        
        $this->estilo_tabla($id_asignacionprueba);
        $this->estilo;

        $tabla_rep='';
        $this->tabla_rep=$this->estilo;

        $this->tabla_rep.='<div align="center" class="espacio">Detalle de Repeticiones a las Alternativas por Pregunta</div>';
        $this->tabla_rep.='<table border="1" align="center" class="first">';
        $this->tabla_rep.='<tr align="center">
                                <th width="40">N°</th>
                                <th width="100">CORRECTA</th>
                                <th width="100">A</th>
                                <th width="100">B</th>
                                <th width="100">C</th>
                                <th width="100">D</th>
                                <th width="100">OMITIDAS</th>
                            </tr>';
        
        foreach ($det_repeticion as $key => $value) 
        {
            
            $resp_correcta=$det_repeticion[$key]['correcta'];
            
            $alt_a=$det_repeticion[$key]['A'];
            $alt_b=$det_repeticion[$key]['B'];
            $alt_c=$det_repeticion[$key]['C'];
            if(isset($det_repeticion[$key]['D']))
                $alt_d=$det_repeticion[$key]['D'];
            else
                $alt_d = "";

            $omitidas=$det_repeticion[$key]['omitidas'];

            $this->tabla_rep.='<tr align="center">';
            $this->tabla_rep.='<th>'.($key+1).'</th>
                         <th>'.$resp_correcta.'</th>
                         <td class="col_secundaria">'.$alt_a.'</td>
                         <td class="col_secundaria">'.$alt_b.'</td>
                         <td class="col_secundaria">'.$alt_c.'</td>
                         <td class="col_secundaria">'.$alt_d.'</td>
                         <td class="col_secundaria">'.$omitidas.'</td>';
            $this->tabla_rep.='</tr>';
            
        }

        $this->tabla_rep.='</table>';
                        
    }

    public function detalle_preguntas_por_orden_repeticion($id_asignacionprueba)
    {
        $det_preg_ord_rep=$this->estadistica_model->getPOR($id_asignacionprueba);

        $this->estilo_tabla($id_asignacionprueba);
        $this->estilo;

        // print_r($det_preg_ord_rep);

        $tabla_ord_rep='';
        $this->tabla_ord_rep=$this->estilo;

        $this->tabla_ord_rep.='<div align="center" class="espacio">Detalle de preguntas por orden de repetición</div>';
        $this->tabla_ord_rep.='<table border="1" align="center" class="first">';
        $this->tabla_ord_rep.='<tr align="center">
                                <th width="220" colspan="2">Correctas</th>
                                <th width="220" colspan="2">Incorrectas</th>
                                <th width="220" colspan="2">Omitidas</th>
                                </tr>
                            <tr align="center">
                                <th width="110">N° Pregunta</th>
                                <th width="110">Repeticiones</th>
                                <th width="110">N° Pregunta</th>
                                <th width="110">Repeticiones</th>
                                <th width="110">N° Pregunta</th>
                                <th width="110">Repeticiones</th>
                            </tr>';
        
        foreach ($det_preg_ord_rep as $key => $value) 
        {
            $cn=$det_preg_ord_rep[$key]['cn'];
            $cr=$det_preg_ord_rep[$key]['cr'];
            $in=$det_preg_ord_rep[$key]['in'];
            $ir=$det_preg_ord_rep[$key]['ir'];
            $on=$det_preg_ord_rep[$key]['on'];
            $or=$det_preg_ord_rep[$key]['or'];

            $this->tabla_ord_rep .='<tr align="center">';
            $this->tabla_ord_rep .='<td class="col_secundaria">'.$cn.'</td>
                                <td class="col_secundaria">'.$cr.'</td>
                                <td class="col_secundaria">'.$in.'</td>
                                <td class="col_secundaria">'.$ir.'</td>
                                <td class="col_secundaria">'.$on.'</td>
                                <td class="col_secundaria">'.$or.'</td>';
            $this->tabla_ord_rep.='</tr>';

            //print_r($tabla.$det_resp[$key]['fullname'].'<br/>');
            //print_r('<br/>');
            //print_r($this->tabla_rep);
        }

        $this->tabla_ord_rep.='</table>';
        //print_r($this->tabla_ord_rep);
    }

    public function det_rend_por_hab($id_asignacionprueba)
    { 
        $det_rend_habilidades=$this->estadistica_model->getRHPA($id_asignacionprueba);  

        $this->estilo_tabla($id_asignacionprueba);
        $this->estilo;

        $ancho_columnas='';
       
        $encabezado='';
        $this->encabezado='';                

        $h=0;

        foreach($det_rend_habilidades as $clave => $valor)
        {
            if($h++>0)
                break;

            $sub_array_a=array_keys($det_rend_habilidades[$clave]);
            $sub_array_a=array_slice($sub_array_a, 2);  

            $contador_hab=count($sub_array_a);

            $this->ancho_columnas=(428/$contador_hab);

            foreach($sub_array_a as $subkey2=>$value_sub_2)
            {
               
                $this->encabezado.='<th width="'.$this->ancho_columnas.'" align="center">'.$value_sub_2.'</th>';
            }
            
        }

        $tabla_datos_1='';
        $this->tabla_datos_1=$this->estilo;

        $this->tabla_datos_1.='<div align="center" class="espacio">Rendimiento por Habilidades</div>
                        <table border="1" align="center" cellspacing="0" cellpadding="0" class="first">
                            <tr valign="top">
                            <th align="center" width="30">N°</th>
                            <th align="center" width="200">Alumno</th>'
                            .$this->encabezado.'</tr>';

        $contador=count($det_rend_habilidades);
        $i = 0;

        foreach ($det_rend_habilidades as $key => $value) 
        {
            if ($i++ == ($contador-1))
            break;

            $sub_array_1=array_keys($det_rend_habilidades[$key]);
            $sub_array_1=array_slice($sub_array_1, 1);  

            $this->tabla_datos_1.='<tr valign="top">';
            $this->tabla_datos_1.='<th align="center">'.($key+1).'</th>';

            foreach($sub_array_1 as $subkey2=>$value_sub_2)
            {
                if($value_sub_2=="alumno")
                {
                    $clase="";
                    $alineacion="left";
                    $porcentaje="";
                    $ancho="200";
                    $ti = "<th";
                    $tf = "</th>";

                }
                else
                {
                    $clase='class="col_secundaria"';
                    $alineacion="center";
                    $porcentaje="%";
                    $ancho=$this->ancho_columnas;
                    $ti = "<td";
                    $tf = "</td>";
                }
                
                $this->tabla_datos_1.=$ti.' width="'.$ancho.'" align="'.$alineacion.'" '.$clase.'>'
                .$value[$value_sub_2].$porcentaje.$tf; 

               
            }
            $this->tabla_datos_1.='</tr>';
        }

        $this->tabla_datos_1.='</table>';
       
        /* TABLA SEP */

        $totales=$det_rend_habilidades[$contador];

        $tabla_sep='';
        $this->tabla_sep=$this->estilo;

        $this->tabla_sep.='<div align="center" class="espacio"></div>';
        $this->tabla_sep.='<table border="1" align="center" cellspacing="0" cellpadding="0" class="first">
                            <tr>
                                <th align="center" width="230">SEP</th>'
                            .$this->encabezado.'
                            </tr>
                            <tr valign="top">';

        foreach($totales as $key=>$value) {
            
            $sub_array_1=array_keys($totales[$key]);
            $cont_1=1;

            $this->tabla_sep.='<th width="230" align="left" valign="top"><table border="1">
                    <tr>
                        <td> ALTO</td>
                    </tr>
                    <tr>
                        <td> MEDIO ALTO</td>
                    </tr>
                    <tr>
                        <td> MEDIO BAJO</td>
                    </tr>
                    <tr>
                        <td> BAJO</td>
                    </tr>
                </table>

            </th>';

            foreach($sub_array_1 as $subkey2=>$value_sub_2)
            {
                $sub_array_2=$totales['contador'][$value_sub_2];
                $sub_array_2 = array_reverse($sub_array_2);
            
                $this->tabla_sep.='<td width="'.$this->ancho_columnas.'" align="center" class="col_secundaria" valign="top">'; 
               
                
                foreach($sub_array_2 as $subkey3=>$value_sub_3)
                {
                   $this->tabla_sep.='<table border="1" align="left" cellspacing="0" cellpadding="0" style="border-top-color:white;border-bottom-color:white">
                            <tr>
                                <td align="center">'.$value_sub_3.'</td>
                            </tr>
                            </table>';
                }

                $this->tabla_sep.='</td>'; 
            }
            
        }
        $this->tabla_sep.='</tr></table>';
        //print_r($this->tabla_sep);
    }

    public function detalle_rendimiento_alumno_eje($id_asignacionprueba)
    {
        $det_rend_alu_eje=$this->estadistica_model->getRAE($id_asignacionprueba); 
        $encabezado_tabla=$this->estadistica_model->getTPE($id_asignacionprueba); 

        $conteo_ejes=count($encabezado_tabla);
        
        $ancho_columnas=(428/$conteo_ejes);

        $this->estilo_tabla($id_asignacionprueba);
        $this->estilo;

        $columnas_encabezado='';
        $this->columnas_encabezado='';
        
        foreach($encabezado_tabla as $key=>$value) {
            
            $vector=$encabezado_tabla[$key];
            $eje_clave  = $value->eje;
            
            $this->columnas_encabezado.='<th align="center" width="'.$ancho_columnas.'">'.$eje_clave.'</th>';

        }

        $tabla_det_rae_1='';
        $this->tabla_det_rae_1=$this->estilo;

        $this->tabla_det_rae_1.='<div align="center" class="espacio">Rendimiento por Alumno - Eje</div>
                        <table border="1" align="center" cellspacing="0" cellpadding="0" class="first">';
                           
        $this->tabla_det_rae_1.='<tr><th align="center" width="30">N°</th>
                                     <th align="center" width="200">Alumno</th>';

        $this->tabla_det_rae_1.=$this->columnas_encabezado;
        $this->tabla_det_rae_1.='</tr>';

        $contador=count($det_rend_alu_eje);
        $i = 0;

        foreach ($det_rend_alu_eje as $key => $value) 
        {
            if ($i++ == ($contador-1))
            break;

            $sub_array_1=array_keys($det_rend_alu_eje[$key]);
            $sub_array_1=array_slice($sub_array_1, 1);

            $this->tabla_det_rae_1.='<tr valign="top">';
            $this->tabla_det_rae_1.='<td align="center" class="col_principal">'.($key+1).'</td>';

            foreach($sub_array_1 as $subkey2=>$value_sub_2)
            {
                if($value_sub_2=="alumno")
                {
                    $clase="";
                    $alineacion="left";
                    $porcentaje="";
                    $ancho="200";
                    $ti = "<th";
                    $tf = "</th>";
                }
                else
                {
                    $clase='class="col_secundaria"';
                    $alineacion="center";
                    $porcentaje="%";
                    $ancho=$this->ancho_columnas;
                    $ti = "<td";
                    $tf = "</td>";
                }

                $this->tabla_det_rae_1.=$ti.' width="'.$ancho.'" align="'.$alineacion.'" '.$clase.'>'
                .$value[$value_sub_2].$porcentaje.$tf; 
            }
            $this->tabla_det_rae_1.='</tr>';
        }
        $this->tabla_det_rae_1.='</table>';
        
        /* TABLA SEP */
        
        $totales=$det_rend_alu_eje[$contador];

        $tabla_rae_sep='';
        $this->tabla_rae_sep=$this->estilo;

        $this->tabla_rae_sep.='<div align="center" class="espacio"></div>';
        $this->tabla_rae_sep.='<table border="1" align="center" cellspacing="0" cellpadding="0" class="first" ><tr>
        <th width="230">Rendimiento por Grupo - Eje</th>';
        $this->tabla_rae_sep.=$this->columnas_encabezado;
        $this->tabla_rae_sep.='</tr>';
        $this->tabla_rae_sep.='<tr>';

        foreach($totales as $key=>$value) {
            
            $sub_array_1=array_keys($totales[$key]);

            $cont_1=1;

            $this->tabla_rae_sep.='<th width="230" align="left" valign="top"><table border="1">
                    <tr>
                        <td> ALTO</td>
                    </tr>
                    <tr>
                        <td> MEDIO ALTO</td>
                    </tr>
                    <tr>
                        <td> MEDIO BAJO</td>
                    </tr>
                    <tr>
                        <td> BAJO</td>
                    </tr>
                </table>
            </th>';

            foreach($sub_array_1 as $subkey2=>$value_sub_2)
            {
                $sub_array_2=$totales['contador'][$value_sub_2];
                $sub_array_2 = array_reverse($sub_array_2);
            
                $this->tabla_rae_sep.='<td width="'.$ancho_columnas.'" align="center" class="col_secundaria">'; 
                $con=0;

                foreach($sub_array_2 as $subkey3=>$value_sub_3)
                {
                    $this->tabla_rae_sep.='<table border="1" align="left" cellspacing="0" cellpadding="0" style="border-top-color:white;border-bottom-color:white">
                            <tr>
                                <td align="center">'.$value_sub_3.'</td>
                            </tr>
                            </table>';
                }

                $this->tabla_rae_sep.='</td>'; 
            }
        }
        $this->tabla_rae_sep.='</tr></table>';
    }

    public function tabla_especificaciones($id_asignacionprueba)
    {
        $especificaciones=$this->estadistica_model->getTE($id_asignacionprueba); 

        $this->estilo_tabla($id_asignacionprueba);
        $this->estilo;

        $tabla_det_esp='';
        $this->tabla_det_esp=$this->estilo;

        $this->tabla_det_esp.='<div align="center" class="espacio">Tabla de Especificaciones</div>
                        <table border="1" align="center" cellspacing="0" cellpadding="0" class="first">
                            <tr><th>N°</th><th>Clave</th><th>Eje</th><th>Habilidad</th><th>Nivel</th></tr>';
        foreach($especificaciones as $key=>$value) {
           
            $sub_array_1=array_keys($especificaciones[$key]);

            $this->tabla_det_esp.='<tr valign="top">';
            $this->tabla_det_esp.='<td align="center" class="col_secundaria">'.($key+1).'</td>';

            foreach($sub_array_1 as $subkey2=>$value_sub_2)
            {
                $this->tabla_det_esp.='
                <td align="center" class="col_secundaria">'.$value[$value_sub_2].'</td>'; 
            }
            $this->tabla_det_esp.='</tr>';
        }
        $this->tabla_det_esp.='</table>';
    }

    
    public function testeo($id_asignacionprueba)
    {
        $test1=$this->estadistica_model->getTRCAP($id_asignacionprueba);
        $test2=$this->estadistica_model->getTPAP($id_asignacionprueba);
        $test3=$this->estadistica_model->getCAR($id_asignacionprueba);
        $test4=$this->estadistica_model->getRH($id_asignacionprueba);
        $test5=$this->estadistica_model->getPSA($id_asignacionprueba);
        $test6=$this->estadistica_model->getCRCIAP($id_asignacionprueba);
        $test7=$this->estadistica_model->getDRA($id_asignacionprueba);
        $test8=$this->estadistica_model->getRAP($id_asignacionprueba);
        $test9=$this->estadistica_model->getPOR($id_asignacionprueba);
        $test10=$this->estadistica_model->getPPP($id_asignacionprueba);
        $test11=$this->estadistica_model->getRCE($id_asignacionprueba);
        $test12=$this->estadistica_model->getTRCE($id_asignacionprueba);
        $test13=$this->estadistica_model->getRHPA($id_asignacionprueba);
        $test14=$this->estadistica_model->getRAE($id_asignacionprueba);
        $test15=$this->estadistica_model->getTPE($id_asignacionprueba);
        $test16=$this->estadistica_model->getTE($id_asignacionprueba);
        $test17=$this->estadistica_model->subsector($id_asignacionprueba);
        $test18=$this->estadistica_model->arrayPortada($id_asignacionprueba);
        $test19=$this->estadistica_model->getRG($id_asignacionprueba);
        $test20=$this->estadistica_model->getTPAP($id_asignacionprueba);
        
        print_r("getRCE:<br/>");
        print_r($test11);

        /*
        print_r("getTPAP:<br/>");
        print_r($test20);
        print_r("<br/><br/>");
        print_r("getRHPA:<br/>");
        print_r($test13);
        */

        /*
        print_r("<br/><br/>");
        print_r("getRAE:<br/>");
        print_r($test14);

        print_r("<br/><br/>");
        print_r("getRG:<br/>");
        print_r($test19);
        */

        /*
        print_r("<br/><br/>");
        print_r("getRAP:<br/>");
        print_r($test8);
        */

        //print_r($test8);

        /*
        print_r("getRCE:<br/>");
        print_r($test11['Lectura']);
        print_r("<br/>");
        print_r("getTRCE:<br/>");
        print_r($test12);
        
        
        print_r($test18);
        print_r("<br/><br/>");
        print_r($test18[0]->colegio);

        $alias_subsector=$test17;

        
        
        $encabezado_tabla=$this->estadistica_model->getTPE($id_asignacionprueba);   
        $vector = array();

        foreach($encabezado_tabla as $key=>$value) {
            
            $vector=$encabezado_tabla[$key];
            $eje_clave  = $value->eje;
           
        }

        */

        //print_r($alias_subsector);

    }
    

}
?>