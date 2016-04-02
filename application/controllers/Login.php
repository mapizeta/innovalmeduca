<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

public function __construct()
        {
            parent::__construct();
            $this->load->model('usuario_model');
            $this->load->model('registros_model');
        }

	function index()
	{
				
		if($perfil = $this->usuario_model->is_logged_in())
		{
			//echo $perfil;

			
			switch ($perfil) {
				case 1:
					$this->registros_model->save($this->session->userdata('id_usuario'), 'login');
					redirect('administrator');
					break;
				case 2:
					$this->registros_model->save($this->session->userdata('id_usuario'), 'login');
					redirect('profesor');
					break;
				case 3:
					redirect('alumno');
					break;
				
				default:
					redirect('no_access');
					break;
			}
			
		}
		else
		{
			$this->load->view('login/login');
			
		}
		
	}
	
	function login_check()
	{
		$username = $this->input->post("username");	
		$password = $this->input->post("password");	
		
		$character = array(".", "-");
		$rut = str_replace($character, "", $username);

		if(!$this->usuario_model->login($rut,$password))
		{
			echo false;
		}
		else
		echo true;		
	}

	function logout()
	{
		$this->usuario_model->logout();
	}
}

?>