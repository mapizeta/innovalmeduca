<?php
class Secure_area extends CI_Controller
{
	/*
	Controllers that are considered secure extend Secure_area, optionally a $module_id can
	be set to also check if a user can access a particular module in the system.
	*/
	
	public function __construct()
	{
		parent::__construct();	
		$this->load->model('usuario_model');
		
		if(!$this->usuario_model->is_logged_in())
		{
			redirect('login');
		}
		
	}
	
}
?>