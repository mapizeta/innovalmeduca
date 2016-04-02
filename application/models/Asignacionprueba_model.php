<?php
class Asignacionprueba_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
        $this->load->model('prueba_model');
    }

    public function get_all()
    {
        $query = $this->db->query("SELECT c.nombre colegio, u.nombre, u.apellido, u.username, p.codigo,  ap.id_asignacionprueba, ap.inicio, ap.termino, (
                                        SELECT 
                                            CASE 
                                                WHEN ap.estado=1 THEN 'ASIGNADA' 
                                                WHEN ap.estado=2 THEN 'EJECUTADA' 
                                                WHEN ap.estado=3 THEN 'FINALIZADA' 
                                            END
                                        ) AS estado 
                                    FROM asignacionprueba ap
                                    JOIN usuario u ON ap.usuario_id_usuario = u.id_usuario
                                    JOIN curso cu ON ap.curso_id_curso = cu.id_curso
                                    JOIN colegio c ON cu.colegio_id_colegio = c.id_colegio
                                    JOIN prueba p ON ap.prueba_id_prueba = p.id_prueba");
        if($query->num_rows() > 0)
            return $query->result();
        else
            
            return false; 
        
        //return $query;

    }

    function exists($id_asignacionprueba)
    {
        $this->db->from('asignacionprueba');   
        $this->db->where('id_asignacionprueba',$id_asignacionprueba);
        $query = $this->db->get();
        
        return ($query->num_rows()==1);
    }

    function have_prueba($id_prueba)
    {
        $query = $this->db->get_where('asignacionprueba', array('prueba_id_prueba' => $id_prueba), 1);
         if($query->num_rows() == 1)
            return true;
        else
            return false;
    }
        
    function get_info($id_asignacionprueba)
    {
        $return = false;

        $query = $this->db->get_where('asignacionprueba', array('id_asignacionprueba' => $id_asignacionprueba), 1);
        //echo $this->db->last_query();
        if ($query->num_rows() ==1)
            $return=$query->row();
        
        return $return;  
    }

     function get_idColegio($id_asignacionprueba)
    {
        $sql = "SELECT c.colegio_id_colegio
                FROM asignacionprueba a
                JOIN curso c ON a.curso_id_curso = c.id_curso
                WHERE a.id_asignacionprueba = $id_asignacionprueba";

        $query = $this->db->query($sql);

        if ($query->num_rows() ==1)
            $return = $query->row();
            
            return $return->colegio_id_colegio;        
    }


    function get_estado($id_asignacionprueba)
    {
        $return = false;

        $this->db->select('estado');
        $this->db->from('asignacionprueba');
        $this->db->where('id_asignacionprueba', $id_asignacionprueba);
        
        
        $query = $this->db->get();
        
        if ($query->num_rows() ==1)
            {
                $dato = $query->row();
                $return = $dato->estado; 
            }

        return $return;
         
    }

    function exists_data($id_asignacionprueba)
    {
        $return = false;

        $this->db->select('inicio , realizado');
        $this->db->from('asignacionprueba');
        $this->db->where('id_asignacionprueba', $id_asignacionprueba);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return false;   
         
    }

    
    function cambiar_estado($id_asignacionprueba, $estado)
    {

        if($fechas=$this->exists_data($id_asignacionprueba));
          foreach ($fechas as $key => $value) {
             $inicio=$value->inicio;
             $realizado=$value->realizado;
          }

        switch ($estado) 
        {
            case 2:
                if($inicio == '')
                {
                    $sql = "UPDATE asignacionprueba SET inicio = localtimestamp(0) WHERE id_asignacionprueba=$id_asignacionprueba";
                    $query = $this->db->query($sql);  
                }      
            break;
            case 3:
                $id_colegio = $this->get_idColegio($id_asignacionprueba);
                $data = array(
                                'finalizo' => 1
                             );
                $this->db->where('asignacionprueba_id_asignacionprueba', $id_asignacionprueba);
                $this->db->update('"'.$id_colegio.'".hojarespuesta',$data);
                $this->db->flush_cache(); 

                if($realizado=='')
                {
                    $sql = "UPDATE asignacionprueba SET realizado = localtimestamp(0) WHERE id_asignacionprueba=$id_asignacionprueba";
                    $query = $this->db->query($sql);     
                }
            
            break;
            
        }
        
        if($estado == 1)
            $data = array(
                            'inicio'    => NULL,
                            'termino'   => NULL,
                            'realizado' => NULL,
                            'estado' => $estado
                         );
        else                                     
            $data = array(
                            'estado' => $estado
                         );

        $this->db->where('id_asignacionprueba', $id_asignacionprueba);
                                 
        return $this->db->update('asignacionprueba',$data); 
    }

    function get_horaTermino($id_asignacionprueba)
    {
        $return = false;

        $this->db->select('termino');
        $this->db->from('asignacionprueba');
        $this->db->where('id_asignacionprueba', $id_asignacionprueba);
        
        
        $query = $this->db->get();
        
        if ($query->num_rows() ==1)
            {
                $dato                   = $query->row();
                $fechahora              = explode(" ", $dato->termino);
                $fecha                  = $fechahora[0];
                $hora                   = $fechahora[1];
                $anomesdia              = explode("-", $fecha);
                $horaminseg             = explode(":", $hora);
                
                $return['anio']         = $anomesdia[0];
                $return['mes']          = $anomesdia[1];
                $return['dia']          = $anomesdia[2];

                $return['hora']         = $horaminseg[0];
                $return['minuto']       = $horaminseg[1];
                $return['segundo']      = $horaminseg[2]; 
            }

        return $return;
    }

    function existe_asignacion($colegio, $prueba)
    {
        $sql = "SELECT ap.id_asignacionprueba, co.id_colegio FROM asignacionprueba ap
                JOIN curso cu ON ap.curso_id_curso = cu.id_curso
                JOIN colegio co ON co.id_colegio = cu.colegio_id_colegio
                WHERE co.id_colegio = $colegio AND ap.prueba_id_prueba = $prueba";

        $query = $this->db->query($sql);

        return ($query->num_rows()==1);

    }

    public function save(&$data, $id_asignacionprueba=false)
    {       
        if (!$id_asignacionprueba or !$this->exists($id_asignacionprueba))
        {
            if($this->db->insert('asignacionprueba',$data))
            {
                $data['id_asignacionprueba']=$this->db->insert_id();
                return true;
            }
            return false;
        }
                        
        $this->db->where('id_asignacionprueba', $id_prueba);
                                 
        return $this->db->update('asignacionprueba',$data);       
    }
   
}