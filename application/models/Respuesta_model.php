<?php
class Respuesta_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    function exists($id_respuesta)
    {
        $this->db->from('respuesta');   
        $this->db->where('id_respuesta',$id_respuesta);
        $query = $this->db->get();
        
        return ($query->num_rows()==1);
    }

    public function get_all($id_pregunta)
    {
        $return = false;

        $this->db->from('respuesta');
        $this->db->where('pregunta_id_pregunta',$id_pregunta);
        $this->db->order_by('id_respuesta', 'asc'); 
        
        $query = $this->db->get();

        if ($query->num_rows() >0)
            $return=$query->result();
        
        return $return;    
    }


    // obtiene respuesta correcta de una pregunta especifica si existe
    /*
    public function get_resp_correcta($id_pregunta)
    {
        $return = false;

        $this->db->from('respuesta');
        $this->db->where('pregunta_id_pregunta',$id_pregunta);
        $this->db->where_in('escorrecta', '1');

        $query = $this->db->get();

        if ($query->num_rows()>0)
            $return=$query->result();

        return $return;
    }
    */

    // obtiene respuesta correcta de una pregunta especifica si existe
    public function get_resp_correcta($id_pregunta, $id_respuesta=false)
    {
        $return = false;

        if(!$id_respuesta or !$this->exists($id_respuesta))
        {
            $this->db->from('respuesta');
            $this->db->where('pregunta_id_pregunta',$id_pregunta);
            $this->db->where_in('escorrecta', '1');
        }
        
        else
        {
            $this->db->from('respuesta');
            $this->db->where('pregunta_id_pregunta',$id_pregunta);
            $this->db->where_in('escorrecta', '1');
            $this->db->where_not_in('id_respuesta', $id_respuesta);
        }
        
        $query = $this->db->get();

        if ($query->num_rows()>0)
            $return=$query->result();

        return $return;
    }

    function get_info($id_respuesta)
    {
        $return = false;

        $query = $this->db->get_where('respuesta', array('id_respuesta' => $id_respuesta), 1);
        if ($query->num_rows() ==1)
            $return=$query->row();
        
        return $return;  
    }

    function delete($id_respuesta)
    {
        $this->db->trans_start();
        $this->db->delete('respuesta', array('id_respuesta' => $id_respuesta)); 
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            return false;
        }
    }

    function save(&$data, $id_respuesta=false)
    {
        if(!$id_respuesta or !$this->exists($id_respuesta))
        {
            if($this->db->insert('respuesta',$data))
            {
                $data['id_respuesta']=$this->db->insert_id();
                return true;
            }
            return false;
        }

        $this->db->where('id_respuesta',$id_respuesta);

        return $this->db->update('respuesta',$data);
    }

    function have_prueba($id_prueba)
    {
        $query = $this->db->get_where('respuesta', array('pregunta_id_pregunta' => $id_prueba), 1);
         if($query->num_rows() == 1)
            return true;
        else
            return false;
    }

    function get_name_prueba_pregunta($id_pregunta)
    {
        $return = false;

        $this->db->select('p.codigo cod_pregunta, t.codigo cod_prueba, t.id_prueba');
        $this->db->from('pregunta p');
        $this->db->join('prueba t', 'p.prueba_id_prueba=t.id_prueba');
        $this->db->where('p.id_pregunta',$id_pregunta);
        
        
        $query = $this->db->get();

        if ($query->num_rows() ==1)
            $return=$query->row();
        
        return $return;  
    }


}