<?php
class Colegio_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	// lista de asignaciones por usuario especifico
	public function get_all()
    {
        $return = false;

        $this->db->from('colegio');
        $query = $this->db->get();

        if ($query->num_rows() > 0)
            $return=$query->result();
        
        return $return;      
    }

    public function get_cursos($id_colegio)
    {
        $sql = "SELECT c.id_curso, n.nivel, l.letra 
                FROM curso c
                JOIN letra l on c.letra_id_letra = l.id_letra
                JOIN nivel n on c.nivel_id_nivel = n.id_nivel
                WHERE colegio_id_colegio = $id_colegio
                ORDER BY c.nivel_id_nivel, c.letra_id_letra";

        $query = $this->db->query($sql);

        if($query->num_rows() > 0)
            return $query->result();
        else
            
            return false;
    }

     public function insert_curso($colegio_id, $id_letra, $id_nivel)
    {
        $nivel = $id_nivel."°";
        $letra = array('A','B','C','D','E','F','G', 'H','I','J','K','L');
        if($id_nivel > 8)
        {
            $nivel_tmp = $id_nivel - 8;
            $nivel = $nivel_tmp."°ME";
        }
       
        $data = array(
            'curso' => $nivel." ".$letra[$id_letra-1],
            'letra_id_letra' => $id_letra,
            'nivel_id_nivel' => $id_nivel,
            'colegio_id_colegio' => $colegio_id
            );

        if($this->db->insert('curso',$data))
            {
                $data['id_curso']=$this->db->insert_id();
                return true;
            }
        else
            return false;
    }

    public function insert_colegio($nombre, $rbd, $director, $direccion, $telefono, $email, $comuna_id_comuna)
    {
        $data = array(
            'nombre' => $nombre,
            'rbd' => $rbd,
            'director' => $director,
            'direccion' => $direccion,
            'telefono' => $telefono,
            'email' => $email,
            'comuna_id_comuna' => $comuna_id_comuna,
            );

        if($this->db->insert('colegio',$data))
            {
                $data['id_colegio']=$this->db->insert_id();
                return true;
            }
        else
            return false;
    }
}
?>