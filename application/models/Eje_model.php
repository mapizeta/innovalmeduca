<?php
class Eje_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    function exists($id_eje)
    {
        $this->db->from('eje');   
        $this->db->where('id_eje',$id_eje);
        $query = $this->db->get();
        
        return ($query->num_rows()==1);
    }

    function get_all()
    {
        $return = false;

        $this->db->from('eje');
        $query = $this->db->get();

        if ($query->num_rows() > 0)
            $return=$query->result();
        
        return $return;   
    }
}