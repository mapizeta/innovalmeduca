<?php
class Alumno_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    /*Generar Hoja de respuesta con procedimiento de almacenado*/
    public function generar_hojarespuesta($id_prueba,$id_asignacionprueba,$id_usuario)
    {
            $query = $this->db->query("select create_hojarespuesta(".$id_prueba.",".$id_asignacionprueba.",".$id_usuario.");");
            $result = $query->result(); 
            
            return $result;

   }

    /*Listar alumnos de un curso*/
    public function get_from_curso($id_curso)
    {
        $this->db->select('u.username rut, u.id_usuario, u.nombre, u.apellido');
        $this->db->from('usuario u');
        $this->db->join('curso_has_usuario cu', 'cu.usuario_id_usuario = u.id_usuario');
        $this->db->where('cu.curso_id_curso', $id_curso);
        
         $query = $this->db->get();
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return false;   
    }

    public function get_ejecucion($id_usuario)
    {
        
        $estado=2;
        
        $this->db->select('a.id_asignacionprueba, s.id_subsector, p.id_prueba, p.codigo, s.nombre,p.tipo');
        $this->db->from('asignacionprueba a');
        $this->db->join('prueba p', 'p.id_prueba=a.prueba_id_prueba');
        $this->db->join('subsector s', 's.id_subsector=p.subsector_id_subsector');
        $this->db->join('curso c', 'a.curso_id_curso=c.id_curso');
        $this->db->join('curso_has_usuario cu', 'cu.curso_id_curso = c.id_curso');
        $this->db->join('usuario  u', 'u.id_usuario=cu.usuario_id_usuario');
        $this->db->where('a.estado', $estado);
        $this->db->where('u.id_usuario', $id_usuario);
    


       $query = $this->db->get();
      // echo $this->db->last_query();
        if($query->num_rows() > 0)
            return $query->result();
        else
            return false;   
    }

    /*Listar alumnos de un curso*/
    public function get_name($id_usuario)
    {
        $this->db->select('nombre , apellido');
        $this->db->from('usuario');
        $this->db->where('id_usuario', $id_usuario);
        
         $query = $this->db->get();
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return false;   
    }

    function esFinalizado($colegio, $id_usuario, $id_asignacionprueba)
    {
        $return = false;

        $sql = "SELECT finalizo FROM \"$colegio\".hojarespuesta WHERE usuario_id_usuario = '$id_usuario' and asignacionprueba_id_asignacionprueba = '$id_asignacionprueba' LIMIT 1";
        
        $query = $this->db->query($sql);

        if ($query->num_rows() ==1)
            {
                $row = $query->row();
                $return = $row->finalizo;
            }
        
        return $return; 
    }

    function habilitar_alumno($colegio, $id_usuario, $id_asignacionprueba)
    {
        $return = false;

        $data = array(
        'finalizo' => 0,
         );

        $this->db->where('asignacionprueba_id_asignacionprueba', $id_asignacionprueba);
        $this->db->where('usuario_id_usuario', $id_usuario);
        
        if($this->db->update('"'.$colegio.'".hojarespuesta',$data))
            $return = true; 
       
        return $return; 
    }

    function exists($id_alumno)
    {
        $this->db->from('usuario');  
        $this->db->where('id_usuario',$id_alumno);
        $query = $this->db->get();
       
        return ($query->num_rows()==1);
    }

    function existeRut($rut)
    {
        $this->db->from('usuario');  
        $this->db->where('username',$rut);
        $query = $this->db->get();
       
        return ($query->num_rows()==1);
    }

    public function save(&$data, $curso=false, $id_alumno=false)
    {      
        if (!$id_alumno or !$this->exists($id_alumno))
        {
            if($this->db->insert('usuario',$data))
            {
                $id_alumno_insert = $this->db->insert_id();
               
                $data_colegio_has_usuario = array
                (
                    'curso_id_curso' => $curso,
                    'usuario_id_usuario' => $id_alumno_insert
                );

                if($this->db->insert('curso_has_usuario',$data_colegio_has_usuario))
                {  
                    return true;
                }
                else
                    return false;
            }
            else
                return false;
        }
        else
        {
            $this->db->where('id_usuario', $id_alumno);   
           
            if($this->db->update('usuario',$data))
                return true;
        }                   
    }
}