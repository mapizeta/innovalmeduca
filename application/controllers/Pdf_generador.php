<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("Estadistica.php");
require_once('Mypdf.php');

class Pdf_generador extends Estadistica
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Pdf');
        $this->load->model('estadistica_model');
    }

    public function mostrar_pdf($id_asignacionprueba)
    {
         $this->estilo_tabla($id_asignacionprueba);
         $id_colegio= $this->estadistica_model->get_idColegio($id_asignacionprueba);
         $imagen_encabezado=$this->imagen_encabezado;
         $imagen_pie_pagina=$this->imagen_pie_pagina;


        //$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        //$id_asignacionprueba = $this->uri->segment(3, 0);
        $last = $this->uri->total_segments();
        $asignacion_prueba = $this->uri->segment($last);
        $id_asignacionprueba =$asignacion_prueba;

        $verificacion_sub=$this->estilo_tabla($id_asignacionprueba);
        


        $pdf = new Mypdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

        $pdf->setData($this->imagen_encabezado);
        $pdf->setPiePagina($this->imagen_pie_pagina);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('AEDUC TECNOLOGIA EDUCATIVA');
        $pdf->SetTitle('INFORME ESTADISTICO');
        $pdf->SetSubject('Mideteed 2016');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide'); 

        $pdf->setPrintHeader(False);



        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128)); 
 
        // set header and footer fonts
        //$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
 
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); 
 
        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        
        //$pdf->SetMargins(0, 0, 0, true);

        
        //$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        //$pdf->SetHeaderMargin((PDF_MARGIN_TOP-28));

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);    
 
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); 
 
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);   
 
        
        
        //$pdf->AddPage();
        $pdf->AddPage('P', 'LETTER');
        // remove default footer
        $pdf->setPrintFooter(false);
        $pdf->setXY(20,120);

        // -- set new background ---




        // llamada a metodo que muestra imagen de portada
        //$this->variables();

        
        //$img_portada=$this->img_portada; 

        $imagen_portada=$this->imagen_portada;

         // llamada a metodo
        $this->tabla_portada($id_asignacionprueba);
        $tabla_portada_a=$this->tabla_portada_a; 
        $tabla_portada_b=$this->tabla_portada_b; 

        // get the current page break margin
        $bMargin = $pdf->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $pdf->getAutoPageBreak();
        // disable auto-page-break
        $pdf->SetAutoPageBreak(false, 0);
        // set bacground image
        //$img_file = 'assets/images/fn_portada_iest.jpg';
        $img_file = 'assets/images/'.$imagen_portada;


        //$pdf->Image($img_file, 0, 0, 216, 297, '', '', '', false, 300, '', false, false, 0);
        $pdf->Image('assets/images/logo1.png', '3', '3', '30', '30', '', '', '', true, 300, '', false, false, 0, false, false, false);
        // restore auto-page-break status
        $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $pdf->setPageMark();
        

        $salto_linea="<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
        //$pdf->writeHTML($salto_linea, true, 0, true, true);

        // Print a text
        
        //$pdf->writeHTML($html, true, false, true, false, '');

        $pdf->writeHTML($tabla_portada_a, true, false, true, false, '');

        $pdf->setXY(60,187);
        $pdf->SetFont('dejavusans', '', 16, '', true); 

        $pdf->writeHTML($tabla_portada_b, true, false, true, false, '');

       

        


        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 8, '', true); 

        

        //$id_asignacionprueba = $this->uri->segment(3, 0);
        //$id_asignacionprueba=1;

        // 2da pagina
        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->setHeaderFont(Array('helvetica', '', 8));
        $pdf->SetHeaderData('', '', 'Araucanía Educativa', 'www.aeduc.cl - contacto@aeduc.cl');
        $pdf->setHeaderMargin(2);
        $pdf->setPrintHeader(true);

        $pdf->AddPage(); 

        //$pdf->setXY(0,28);
        
        $pdf->setPrintFooter(true);

        // set text shadow effect
        //$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    

        $salto="<br/>";
        $salto_doble="<br/><br/>";
        
       

        // llamada a metodo
        $this->tabla_rendimiento_global($id_asignacionprueba);
        $contenido_ren_global=$this->contenido_ren_global; // se obtiene la variable contenido del metodo tabla_rendimiento_global();

        $pdf->writeHTML($contenido_ren_global, '',true, false, true, false, '');
        
        //$pdf->writeHTML($product_id, true, 0, true, true);
        $pdf->writeHTML($salto, true, 0, true, true);

        // llamada a metodo
        $this->tabla_estandares_por_alumno($id_asignacionprueba);
        $contenido_est_alumno=$this->contenido_est_alumno; // se obtiene la variable contenido del metodo tabla_rendimiento_global();

        $pdf->writeHTML($contenido_est_alumno, '',true, false, true, false, '');

        $pdf->writeHTML($salto, true, 0, true, true);

        // llamada a metodo que muestra grafico 1
        $this->grafico_prom_estandares_por_alumno($id_asignacionprueba);
        $archivo_img=$this->img_graf_pro_est_alu; 

        $grafico_a = '<div align="center"><img src="'.$archivo_img.'" border="0" height="250" width="500" /></div>';
        $pdf->writeHTML($grafico_a, true, 0, true, true);
        
        $pdf->writeHTML($salto, true, 0, true, true);

        // llamada a metodo
        
        $this->tabla_rendimiento_por_habilidad($id_asignacionprueba);
        $cont_ren_hab=$this->cont_ren_hab; 

        $pdf->writeHTML($cont_ren_hab, true, false, false, false, '');
        $pdf->writeHTML($salto, true, 0, true, true);
        
        // llamado a metodo que muestra grafico 2
        
        
        $this->grafico_prom_rendimiento_por_habilidad($id_asignacionprueba);
        $archivo_img_2=$this->img_graf_pro_ren_hab;

        $grafico_b = '<div align="center"><img src="'. $archivo_img_2.'" border="0" height="300" width="600"  /></div><br/><br/>';
        $pdf->writeHTML($grafico_b, true, 0, true, true);
        
        
        $pdf->AddPage(); 
        //$pdf->setXY(0,28);

        // llamada a metodo
        $this->tabla_rendimiento_por_eje($id_asignacionprueba);
        $contenido_ren_eje=$this->contenido_ren_eje; 

        $pdf->writeHTML($contenido_ren_eje, true, false, false, false, '');


        // llamado a metodo que muestra grafico rendimiento por eje
        $this->grafico_rendimiento_por_eje($id_asignacionprueba);
        $archivo_img_ren_eje=$this->img_graf_ren_eje;

        $grafico_c = '<div align="center"><img src="'. $archivo_img_ren_eje.'" border="0" height="300" width="600"  /></div><br/><br/>';
        $pdf->writeHTML($grafico_c, true, 0, true, true);

        // llamada a metodo
        $this->tabla_distribucion_tipo_resp($id_asignacionprueba);
        $contenido_dist_resp=$this->contenido_dist_resp; 

        $pdf->writeHTML($contenido_dist_resp, true, false, false, false, '');

        // llamado a metodo que muestra grafico distribucion respuesta
        $this->grafico_distribucion_tipo_resp($id_asignacionprueba);
        $img_graf_dist_resp=$this->img_graf_dist_resp;

        $grafico_d = '<div align="center"><img src="'. $img_graf_dist_resp.'" border="0" height="320" width="400"  /></div><br/><br/>';
        $pdf->writeHTML($grafico_d, true, 0, true, true);

        $pdf->AddPage(); 
        //$pdf->setXY(0,28);

        // llamado a metodo que muestra grafico deciles
        $this->grafico_puntaje_prueba_alumno($id_asignacionprueba);
        $img_graf_ptje_simce=$this->img_graf_ptje_simce;

        $grafico_e = '<div align="center"><img src="'. $img_graf_ptje_simce.'" border="0" height="500" width="920"  /></div><br/><br/>';
        $pdf->writeHTML($grafico_e, true, 0, true, true);

        $pdf->AddPage(); 
        //$pdf->setXY(0,28);

        // llamada a metodo
        $this->tabla_rend_alu_tipo_prueba($id_asignacionprueba);
        $contenido_tabla=$this->contenido_tabla; 

        $pdf->writeHTML($contenido_tabla, true, false, false, false, '');


        $pdf->AddPage(); 
        //$pdf->setXY(0,28);

        // llamada a metodo
        $this->tabla_rend_alu_nota($id_asignacionprueba);
        $tabla_b=$this->tabla_b; 

        $pdf->writeHTML($tabla_b, true, false, false, false, '');


        $pdf->AddPage(); 
        //$pdf->setXY(0,28);

        // llamado a metodo que muestra grafico deciles
        $this->grafico_deciles($id_asignacionprueba);
        $img_graf_deciles=$this->img_graf_deciles;

        $grafico_e = '<div align="center"><img src="'. $img_graf_deciles.'" border="0" height="400" width="700"  /></div><br/><br/>';
        $pdf->writeHTML($grafico_e, true, 0, true, true);

        
        
        $pdf->AddPage();
        //$pdf->setXY(0,28); 
       

        // llamada a metodo
        $this->detalle_respuestas_preguntas_por_alumno($id_asignacionprueba);
        $tabla_det=$this->tabla_det; 

        

        //$pdf->writeHTML($tabla_det, true, false, false, false, '');
        $pdf->writeHTML($tabla_det, true, false, false, false, '');
        $pdf->lastPage();
        
        $pdf->AddPage();
        //$pdf->setXY(0,28); 

        // llamada a metodo
        $this->detalle_repeticiones_alternativas_preguntas($id_asignacionprueba);
        $tabla_rep=$this->tabla_rep; 

        $pdf->writeHTML($tabla_rep, true, false, false, false, '');
        
        $pdf->AddPage(); 
        //$pdf->setXY(0,28);

        // llamada a metodo
        $this->detalle_preguntas_por_orden_repeticion($id_asignacionprueba);
        $tabla_rep=$this->tabla_ord_rep; 

        $pdf->writeHTML($tabla_rep, true, false, false, false, '');

        $pdf->AddPage(); 
        
        $salto_br='<br/>';

        // llamada a metodo
        $this->det_rend_por_hab($id_asignacionprueba);
        $tabla_datos_1=$this->tabla_datos_1; 
        $tabla_sep=$this->tabla_sep; 

        $pdf->writeHTML($tabla_datos_1, true, false, false, false, '');

        $pdf->writeHTML($salto_br, true, false, false, false, '');
        $pdf->writeHTML($tabla_sep, true, false, false, false, '');

        $pdf->AddPage(); 
        $this->detalle_rendimiento_alumno_eje($id_asignacionprueba);
        $tabla_det_rae_1=$this->tabla_det_rae_1;
        $tabla_rae_sep=$this->tabla_rae_sep; 

        $pdf->writeHTML($tabla_det_rae_1, true, false, false, false, '');
        $pdf->writeHTML($salto_br, true, false, false, false, '');
        $pdf->writeHTML($tabla_rae_sep, true, false, false, false, '');

        $pdf->AddPage(); 
        $this->tabla_especificaciones($id_asignacionprueba);
        $tabla_det_esp=$this->tabla_det_esp;

        $pdf->writeHTML($tabla_det_esp, true, false, false, false, '');

         
        // reset pointer to the last page
        $pdf->lastPage();

        
        //$ruta = '/var/www/html/aeduc2016/assets/images/';       
        $ruta = '/var/www/html/aeduc2016/informes/'.$id_colegio.'/'; 
        $mensaje="";

        $data=array();
        $data['filas']="";
        $data['columnas']="";
        $this->mensaje="<a href='".site_url()."/pdf_generador/mostrar_pdf/".$id_asignacionprueba."'>enlace de descarga</a>";
        $this->data['filas'] = "id recibido: ".$id_asignacionprueba;
        $this->data['columnas'] = $this->mensaje;
        
        
        $pdf->Output($ruta.$this->codigo_prueba, 'FD');
        /*
        if($pdf->Output($ruta.$this->codigo_prueba, 'FI'))
            $data['success'] = "true";
        else
            $data['success'] = "false";
        
        echo json_encode($data);
        
        /*
        $pdf->Output($ruta.'informe_estadistico.pdf', 'S');

        if($pdf->Output($ruta.'informe_estadistico.pdf', 'S')==TRUE)

        {
            print_r("Archivo correctamente descargado");
        }
        else
        {
            print_r("No se pudo completar la descarga");
        }
        */

        //$pdf->Output('informe_estadistico.pdf', 'D');  // el parametro 'D' lo hace descargable  
        //$pdf->Output('informe_estadistico.pdf', 'I');  // el parametro 'I' lo hace visible en el navegador   
  
    }
}

?>