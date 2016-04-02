<?php
class Comunas_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    function get_regiones()
    {
        $this->db->select('id_region, nombre');
        $this->db->from('region');
        $this->db->order_by('id_region', 'asc'); 
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return false; 
    }

    function get_provincias($id_region)
    {
        $this->db->select('id_provincia, nombre');
        $this->db->from('provincia');
        $this->db->where(' region_id_region', $id_region);
        $this->db->order_by('id_provincia', 'asc'); 
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return false;  
    }

    function get_comunas($id_provincia)
    {
        $this->db->select('id_comuna, nombre');
        $this->db->from('comuna');
        $this->db->where('provincia_id_provincia', $id_provincia);
        $this->db->order_by('id_comuna', 'asc'); 
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
            return $query->result();
        else
            return false;  
    }





}