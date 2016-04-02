<?php
class Registros_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    function exists($id_registros)
    {
        $this->db->from('registros');   
        $this->db->where('id_registros',$id_registros);
        $query = $this->db->get();
        
        return ($query->num_rows()==1);
    }

    function get_all($month)
    {
        $sql = "SELECT c.id_colegio, uc.usuario_id_usuario, c.nombre, COUNT(*) FROM registros r
                JOIN usuario_has_colegio uc ON r.usuario_id_usuario = uc.usuario_id_usuario
                JOIN colegio c ON uc.colegio_id_colegio = c.id_colegio
                WHERE EXTRACT(MONTH FROM r.hora) = $month
                GROUP BY uc.usuario_id_usuario, c.nombre, c.id_colegio
                ORDER BY c.id_colegio ASC";

        $query = $this->db->query($sql);

        if($query->num_rows() > 0)
            return $query->result();
        else
            
            return false;  
    }

    function save($id_usuario, $descripcion)
    {
        $sql = "INSERT INTO registros (hora, usuario_id_usuario, descripcion, ip) 
        VALUES (current_timestamp, $id_usuario, '$descripcion', inet_client_addr())";

        $this->db->query($sql);

        return $this->db->affected_rows();
    }


}