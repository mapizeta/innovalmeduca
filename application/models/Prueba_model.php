<?php
class Prueba_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
        $this->load->model('asignacionprueba_model');
    }

    /* metodo que verifica si una prueba existe */
    function exists($id_prueba)
    {
        $this->db->from('prueba');   
        $this->db->where('id_prueba',$id_prueba);
        $query = $this->db->get();
        
        return ($query->num_rows()==1);
    }

    function exist_codigo($codigo)
    {
        $this->db->from('prueba');   
        $this->db->where('codigo',$codigo);
        $query = $this->db->get();
        
        return ($query->num_rows()==1);
    }

    /* metodo que obtiene el listado de pruebas */
    public function get_pruebas()
    {
        $query = $this->db->query("SELECT p.id_prueba,p.codigo, s.nombre, 
                                        (
                                        SELECT 
                                            CASE 
                                                WHEN p.tipo=1 THEN 'SIMCE' 
                                                WHEN p.tipo=2 THEN 'PME' 
                                                WHEN p.tipo=3 THEN 'PSU' 
                                            END
                                        ) AS tipo_tipo,n.id_nivel, p.evaluacion
                                        FROM prueba as p 
                                        JOIN subsector as s ON(s.id_subsector=p.subsector_id_subsector) 
                                        JOIN nivel as n ON(n.id_nivel=p.nivel_id_nivel) ORDER BY p.id_prueba ASC");
        if($query->num_rows() > 0)
            return $query->result();
        else
            
            return false; 
        
        //return $query;

    }

    /* metodo que obtiene los datos de una prueba especifica */
    public function get_prueba($id_prueba)
    {
        $return = false;

        $query = $this->db->get_where('prueba', array('id_prueba' => $id_prueba), 1);
        if ($query->num_rows() ==1)
            $return=$query->row();
        
        return $return;    
    }

    /* metodo que inserta o edita una prueba */
    public function save(&$data, $id_prueba=false)
    {       
        if (!$id_prueba or !$this->exists($id_prueba))
        {
            if($this->db->insert('prueba',$data))
            {
                $data['id_prueba']=$this->db->insert_id();
                return true;
            }
            return false;
        }
                        
        $this->db->where('id_prueba', $id_prueba);
                                 
        return $this->db->update('prueba',$data);       
    }

    /* metodo que elimina una prueba */
    function delete($id_prueba)
    {
        return $this->db->delete('prueba', array('id_prueba' => $id_prueba)); 
    }

    /* metodo que obtiene las preguntas de una prueba especifica */
    public function get_preguntas($id_prueba)
    {
        $this->db->select('id_pregunta,codigo');
        $this->db->from('pregunta');
        $this->db->where('prueba_id_prueba', $id_prueba);
        $this->db->order_by('id_pregunta', 'asc'); 
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return false;
    }
    
    /* metodo que obtiene el listado completo de niveles */
    public function get_niveles()
    {
        $return = false;

        $this->db->from('nivel');
        $query = $this->db->get();

        if ($query->num_rows() > 0)
            $return=$query->result();
        
        return $return;   
    }

    /* metodo que obtiene el listado completo de subsectores */
    public function get_subsectores()
    {
        $return = false;

        $this->db->from('subsector');
        $query = $this->db->get();

        if ($query->num_rows() > 0)
            $return=$query->result();
        
        return $return;   
    }

    /* metodo que obtiene el listado completo de ejes */
    public function get_ejes()
    {
        $this->db->select('id_eje,eje');
        $this->db->from('eje');
        $query = $this->db->get();

        if($query->num_rows()>0)
            return $query->result();
        else
            return false;
    }

    /* metodo que obtiene el listado completo de taxonomias */
    public function get_taxonomias()
    {
        $this->db->select('id_taxonomia,nombre');
        $this->db->from('taxonomia');
        $query = $this->db->get();

        if($query->num_rows()>0)
            return $query->result();
        else
            return false;
    }

    /* metodo que obtiene el listado completo de dificultades */
    public function get_dificultades()
    {
        $this->db->select('id_dificultad,dificultad');
        $this->db->from('dificultad');
        $query = $this->db->get();

        if($query->num_rows()>0)
            return $query->result();
        else
            return false;
    }

    /* metodo que obtiene el listado completo de aprendizajes */
    public function get_aprendizajes()
    {
        $this->db->select('id_aprendizajeclave,aprendizajeclave');
        $this->db->from('aprendizajeclave');
        $query = $this->db->get();

        if($query->num_rows()>0)
            return $query->result();
        else
            return false;
    }

    public function get_subsector_nombre($id_subsector)
    {
        $this->db->select('nombre');
        $this->db->from('subsector');
        $this->db->where('id_subsector', $id_subsector);
        $query = $this->db->get();

        if ($query->num_rows() ==1)
            $return=$query->row();
        
        return $return->nombre;    
    }

    function cambiar_estado($asignacionprueba)
    {

    $id_asignacionprueba=$asignacionprueba;


     $estado='3';//Estado al cual se cambiará la prueba

        if($estado == 3)
        {
            $id_colegio = $this->asignacionprueba_model->get_idColegio($id_asignacionprueba);
            $data = array(
            'finalizo' => 1,
             );
            $this->db->where('asignacionprueba_id_asignacionprueba', $id_asignacionprueba);
            $this->db->update('"'.$id_colegio.'".hojarespuesta',$data);
            $this->db->flush_cache(); 
        }
            
        $data = array(
            'estado' => $estado,
             );

        $this->db->where('id_asignacionprueba', $id_asignacionprueba);
                                 
        return $this->db->update('asignacionprueba',$data); 
    }

    
    

}