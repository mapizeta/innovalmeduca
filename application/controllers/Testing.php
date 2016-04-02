<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once ("secure_area.php");

class Testing extends Secure_area 
{
    public function __construct()
        {
            parent::__construct();
            $this->load->model('asignacionprueba_model');
            $this->load->model('estadistica_model');

            
        }

	public function index($id_asignacionprueba)
	{
        //$test = $this->estadistica_model->getPSA($id_asignacionprueba);
        //$test = $this->estadistica_model->getTRCAP($id_asignacionprueba);
        $test = $this->estadistica_model->getRH($id_asignacionprueba);
        //$test = $this->asignacionprueba_model->cambiar_estado(1, 2);

        //$test = $this->asignacionprueba_model->get_horaInicio(2);
        print_r($test);
    }

}


?>

