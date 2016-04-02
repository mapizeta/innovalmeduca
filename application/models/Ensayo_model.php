<?php
class Ensayo_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    function get_info($id_prueba)
    {
        $return = false;

        $query = $this->db->get_where('', array('id_respuesta' => $id_respuesta), 1);
        if ($query->num_rows() ==1)
            $return=$query->row();
        
        return $return;  
    }

    function alumno_finalizar($id_asignacionprueba,$id_usuario,$id_colegio)
    {
        
        $finalizo='1';

        $data = array(
               'finalizo' => $finalizo,
            );

        $this->db->where('asignacionprueba_id_asignacionprueba', $id_asignacionprueba);
        $this->db->where('usuario_id_usuario', $id_usuario);
        
        return $this->db->update('"'.$id_colegio.'".hojarespuesta' ,$data);
        

    }

    public function is_prueba_start($id_prueba, $rut)
    {
        $query = $this->db->query("SELECT * FROM usuario_has_prueba WHERE prueba_id_prueba = $id_prueba AND usuario_rut = '$rut' AND inicio IS NOT NULL");
        if($query->num_rows() == 1)
            return $query->result();
        else
            return false;   
    }

    public function init_fin_prueba($rut, $id_prueba, $accion)
    {
        $data = array($accion => date('Y-m-d H:i:s'));

        $this->db->where('usuario_rut', $rut);
        $this->db->where('prueba_id_prueba', $id_prueba);

        if($this->db->update('usuario_has_prueba', $data))
            return true; 
    }

    public function has_prueba($rut)
    {
        $query = $this->db->query("CALL get_ensayos('$rut')");
            $result = $query->result(); 
            $query->next_result();
            return $result;
    }
    
    
    public function get_prueba($id_prueba)
    {
        return $this->get_preguntas($id_prueba);
    }
    
    public function get_datos($id_prueba)
    {
      
        $this->db->select('p.id_prueba, p.subsector_id_subsector, pr.id_pregunta,pr.contenido');
        $this->db->from('prueba p');
        $this->db->join('pregunta pr', 'p.id_prueba=pr.prueba_id_prueba');
        $this->db->where(' p.id_prueba', $id_prueba);
        $this->db->order_by('pr.codigo', 'asc'); 
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return false;   

    }

    public function datos_excel($id_asignacionprueba)
    {
        $this->db->select('c.id_curso, p.id_prueba, co.id_colegio');
        $this->db->from('asignacionprueba a');
        $this->db->join('curso c', 'c.id_curso=a.curso_id_curso');
        $this->db->join('colegio co', 'co.id_colegio=c.colegio_id_colegio');
        $this->db->join('prueba p', 'p.id_prueba=a.prueba_id_prueba');
        $this->db->where(' a.id_asignacionprueba', $id_asignacionprueba);
        $query = $this->db->get();
        
        //if($query->num_rows() > 0)
            return $query->result();
       // else
        //    return false;   

    }

    public function get_resp($cod_pregunta)
    {
       
        $this->db->select('r.id_respuesta, r.respuesta, pr.id_pregunta');
        $this->db->from('pregunta pr');
        $this->db->join('respuesta r', 'pr.id_pregunta=r.pregunta_id_pregunta');
        $this->db->where('pr.id_pregunta', $cod_pregunta);
        $this->db->order_by('r.id_respuesta', 'asc'); 

        $query = $this->db->get();
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return false;   
        

    }

    public function get_alternativas($id_pregunta)
    {
        $query = $this->db->query("SELECT r.contenido FROM respuesta r INNER JOIN preguntas p ON r.preguntas_id_preguntas = p.id_preguntas WHERE p.id_preguntas = $id_pregunta");
            return $query->result();
        
    }

    public function get_recurso($id_pregunta, $campo)
    {
        $query = $this->db->query("SELECT $campo FROM preguntas WHERE id_preguntas = $id_pregunta");
        $row = $query->row();
        
        if($query->num_rows() == 1)
            return $row->$campo;
        else
            return false;
    }

    public function get_instruccion($id_pregunta, $campo)
    {
        $query = $this->db->query("SELECT $campo FROM preguntas WHERE id_preguntas = $id_pregunta");
        $row = $query->row();
        
        if($query->num_rows() == 1)
            return $row->$campo;
        else
            return false;
    }

    public function get_recursos($id_prueba)
    {
        $query = $this->db->query("SELECT * FROM recursos WHERE id_prueba=$id_prueba");
            return $query->result();
    }

    public function get_instrucciones($id_prueba)
    {
        $query = $this->db->query("SELECT * FROM instrucciones WHERE id_prueba=$id_prueba");
            return $query->result();
    }

    public function get_preguntas_respondidas($rut, $id_prueba)
    {
        $query = $this->db->query("SELECT * FROM pregunta_respondida('$rut', $id_prueba)");
            return $query->result();
    }
    
    public function get_nombre_prueba($id_prueba)
    {
        $query = $this->db->query("SELECT nombre FROM prueba WHERE id_prueba=$id_prueba");
        $row = $query->row();

        return $row->nombre; 
    }

    
    /******************************PREGUNTA RESPONDIDA*****************************************
    SELECT * FROM academico.pregunta_respondida('rut', id_prueba)
    *******************************************************************************************/
    public function old_get_prueba($id_prueba)
{
        $this->db->from('academico.prueba_has_pregunta');
        $this->db->where('id_prueba', $id_prueba);
        $this->db->order_by("id_pregunta", "asc");
        $query = $this->db->get(); 
        
        foreach ($query->result() as $row) {
            echo $row->id_pregunta;
        }
        
        return $query->result();
}
    public function get_pregunta($id_pregunta)
    {
        $this->db->from('academico.pregunta');
        $this->db->where('id_pregunta', $id_pregunta);
        $query = $this->db->get();   
    }

    public function get_respuesta($id_pregunta)
    {
        $this->db->from('academico.pregunta');
        $this->db->where('id_pregunta', $id_pregunta);
        $this->db->order_by("id_respuesta", "asc");
        return $this->db->get();               
    }
}
