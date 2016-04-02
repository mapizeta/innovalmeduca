<?php
class Profesor_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

   public function get_lista($username)
    {
        $this->db->select('a.id_asignacionprueba, c.colegio_id_colegio, c.curso, c.id_curso, p.codigo, a.inicio, a.termino, a.realizado, a.estado, p.tipo, p.nivel_id_nivel, p.subsector_id_subsector, p.evaluacion');
        $this->db->from('asignacionprueba a');
        $this->db->join('curso c', 'a.curso_id_curso=c.id_curso');
        $this->db->join('prueba p', 'a.prueba_id_prueba=p.id_prueba');
        $this->db->join('usuario u', 'u.id_usuario=a.usuario_id_usuario');
        $this->db->where('u.username', $username);
        
         $query = $this->db->get();
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return false;   
    }

    public function get_asignaciones_gen()
    {
        $this->db->select('id_asignacionprueba,curso_id_curso,estado,prueba_id_prueba');
        $this->db->from('asignacionprueba'); 
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return false;  
    }
}