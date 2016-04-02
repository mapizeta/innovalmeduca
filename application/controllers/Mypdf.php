<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'libraries/tcpdf/tcpdf.php');


class Mypdf extends TCPDF
{
    public function __construct()
    {
        parent::__construct();
       // $this->load->model('estadistica_model');
    }

    public function baseurl()
    {
        $base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
        $base_url .= "://".$_SERVER['HTTP_HOST'];
        $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
        
        return $base_url;
    }

    public $alias_subsector;
    public function setECM($alias_subsector)
    {
        $this->alias_subsector = $alias_subsector;
    }

    public function muestra($alias_subsector)
    {
        
        $imagen_encabezado='';
        $imagen_pie_pagina='';

        switch ($alias_subsector)
        {
            case "MATE":
                $this->imagen_encabezado="encabezado_mate.jpg";
                $this->imagen_pie_pagina="pie_pag_mate.jpg";
                break;
            case "LENG":
                $this->imagen_encabezado="encabezado_lengua.jpg";
                $this->imagen_pie_pagina="pie_pag_lengua.jpg";
                break;
            case "CIEN":
                $this->imagen_encabezado="encabezado_ciencias.jpg";
                $this->imagen_pie_pagina="pie_pag_ciencias.jpg";
                break;
            case "HIST":
                $this->imagen_encabezado="encabezado_histo.jpg";
                $this->imagen_pie_pagina="pie_pag_histo.jpg";
                break;
            default:
                $this->imagen_encabezado="..";
                $this->imagen_pie_pagina="....";
                break;
            
        }
        
        
        
        
    }

    

    public function recibe_imagen($alias_subsector)
    {
         $this->muestra($alias_subsector);
         print_r($this->imagen_encabezado);
    }

    public $template;
    public $pie_pag_img;
     
    public function setData($template){
        $this->template = $template;
    }

    public function setPiePagina($pie_pag_img){
        $this->pie_pag_img = $pie_pag_img;
    }


    // encabezado
    public function Header() {

        $image_file = $this->baseurl().'assets/images/'.$this->template;

        

        /*
        
        Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)

        */

        $this->Image($image_file, -1, -1, 0, '26.6', 'JPG', '0', 'T', false, 300, '', false, false, 0, false, false, false);
        

        // Set font
        //$this->SetFont('helvetica', 'B', 20);
        // Title
        //$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');

    }

    // pie de pagina
    public function Footer() {

        /* $image_file = $this->baseurl().'assets/images/pie_pag_lengua.jpg'; */
        $image_file = $this->baseurl().'assets/images/'.$this->pie_pag_img;

        //$image_file = 'http://127.0.0.1/aeduc2016/assets/images/pie_pag_mate.jpg';
        $this->Image($image_file, 0, 254, 216, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Position at 15 mm from bottom
        $this->SetY(-40);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
       
        
        $this->Cell(0, 35, 'Pag '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        

        /*
        $image_file_f = 'http://127.0.0.1/aeduc2016/assets/images/encabezado_mate.jpg';

        // http://127.0.0.1/aeduc2016/
        $this->Image($image_file_f, 0, 0, 0, '26', 'JPG', '90', 'T', false, 300, '', false, false, 0, false, false, false);
        */
    }


   


   

}

?>