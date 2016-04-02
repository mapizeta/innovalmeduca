<?php
class Usuario_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function is_logged_in()
    {
        if ($this->session->userdata('perfil')!=false) {
           return $this->session->userdata('perfil');
        }else{return false;}
        
    }

    public function has_permission($perfil, $controlador)
    {
        
        $query = $this->db->get_where('permisos', array('perfil_id_perfil' => (int)$perfil, 'controlador_id_controlador' => $controlador));    
        
        if($query->num_rows() == 1)
            return true;
        else
            return false;
    }

    function login($username, $password=false)
    {
        if($password)
            $contrasena = md5($password);
        else
            $contrasena = "";

        $query = $this->db->get_where('usuario', array('username' => $username,'contrasena'=>$contrasena), 1);
        if ($query->num_rows() ==1)
        {
            $row=$query->row();
            
            $id_perfil=$row->perfil_id_perfil;

            $this->session->set_userdata('rut', $username);
            $this->session->set_userdata('id_usuario', $row->id_usuario);
            $this->session->set_userdata('fullname', $row->nombre);
            $this->session->set_userdata('perfil', $id_perfil);
           
            

            if ($id_perfil==3) {
                $id_colegio=$this->get_id_colegio($row->id_usuario);
                $this->session->set_userdata('id_colegio', $id_colegio);      
            }
                     

            return $id_perfil;
        }
        return false;
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }

    public function get_all($slug = FALSE)
{
        if ($slug === FALSE)
        {
                $query = $this->db->get('usuario');
                return $query->result_array();
        }

        $query = $this->db->get_where('usuario', array('slug' => $slug));
        return $query->row_array();
}

public function get_id_colegio($id_usuario)
{
        $retorno=false;

        $this->db->select('c.colegio_id_colegio');
        $this->db->from('curso_has_usuario cu');
        $this->db->join('curso c', 'c.id_curso=cu.curso_id_curso');
        $this->db->join('usuario u', 'u.id_usuario=cu.usuario_id_usuario');
        $this->db->where('u.id_usuario', $id_usuario);
        $query = $this->db->get();

        if ($query->num_rows() ==1)
        {
            $cu= $query->row();
            $retorno = $cu->colegio_id_colegio;
        }
            
        return $retorno;
}




}