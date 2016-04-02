<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registros extends CI_Controller {
	
	public function __construct()
        {
            parent::__construct();
            $this->load->model('registros_model');

        }


	public function index($id_asignacionprueba)
	{
        //$cpp= $this->estadistica_model->getPSA($id_asignacionprueba);
        $cpp= $this->registros_model->save(1, 'login');
        //echo $cpp;
        //print_r($cpp);
		//$this->load->view('ensayo/home', $data);
	}

}
?>