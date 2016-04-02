<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

	public function __construct()
        {
                parent::__construct();
                $this->load->model('usuario_model');
        }

	public function index()
	{
		$data['usuarios'] = $this->usuario_model->get_all();
		$this->load->view('usuario/usuario', $data);
	}

}
