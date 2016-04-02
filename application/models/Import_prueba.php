<?php
class Import_prueba extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_all($slug = FALSE)
{
        if ($slug === FALSE)
        {
                $query = $this->db->get('usuarios.usuario');
                return $query->result_array();
        }

        $query = $this->db->get_where('usuarios.usuario', array('slug' => $slug));
        return $query->row_array();
}

    public function insert_pregunta($data_pregunta, $data_respuesta, $CORRECTA)
    {
        $CONT=1;
        $this->db->trans_start();
        if($this->db->insert('academico.pregunta',$data_pregunta))
            $id_pregunta = $this->db->insert_id();
            echo $this->db->last_query();
        foreach ($data_respuesta as $value) {
            
            $respuesta=array(
                    'contenido'=>$value,
                    'id_pregunta' => $id_pregunta
                    );
            if($CONT == $CORRECTA)
                $respuesta['correcta']=1;
            else
                $respuesta['correcta']=0;

            if($this->db->insert('academico.respuesta', $respuesta))
                $CONT++;    
            echo $this->db->last_query();    
        }
        
        
        $data_prueba_has_pregunta['id_pregunta'] = $id_pregunta;
        $data_prueba_has_pregunta['id_prueba'] = 2;

        if($this->db->insert('academico.prueba_has_pregunta',$data_prueba_has_pregunta))
            echo "perfecto";    
        echo $this->db->last_query();
        $this->db->trans_complete();
    }
    
}