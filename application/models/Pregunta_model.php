<?php
class Pregunta_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
    }

    /* metodo que obtiene listado de preguntas de una prueba especifica */
    public function get_preguntas($id_prueba)
    {
        $this->db->from('pregunta');
        $this->db->where('prueba_id_prueba', $id_prueba);
        $this->db->order_by("codigo", "asc"); 
        $query = $this->db->get();

        if($query->num_rows()>0)
            return $query->result();
        else
            return false;
    }

    /* metodo que obtiene una pregunta especifica */
    public function get_pregunta($id_pregunta)
    {
        $return = false;

        $query = $this->db->get_where('pregunta', array('id_pregunta' => $id_pregunta), 1);
        if ($query->num_rows() ==1)
            $return=$query->row();
        
        return $return;    
    }

    /* metodo que obtiene las respuestas de una pregunta especifica */
    public function get_resp($cod_pregunta)
    {
        $this->db->select('r.respuesta, r.escorrecta, pr.id_pregunta');
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

    public function get_eje($id_pregunta)
    {
        $return = false;

        $this->db->select('eje_id_eje id_eje');
        $this->db->from('pregunta');
        $this->db->where('id_pregunta', $id_pregunta);
        $query = $this->db->get();

        if ($query->num_rows() ==1)
            $return=$query->row();

        return $return;   
    }
    /* metodo que obtiene el eje de una pregunta especifica 
    public function get_preg_eje_aprendizaje($id_pregunta)
    {
        $return = false;

        $this->db->select('pregunta.id_pregunta,pregunta.codigo,pregunta.titulo,pregunta.contenido,
        pregunta.taxonomia_id_taxonomia,pregunta.dificultad_id_dificultad,
        pregunta.aprendizajeclave_id_aprendizajeclave,eje.id_eje,eje.eje');
        $this->db->from('pregunta');
        $this->db->join('aprendizajeclave', 'pregunta.aprendizajeclave_id_aprendizajeclave = aprendizajeclave.id_aprendizajeclave');
        $this->db->join('eje', 'eje.id_eje = aprendizajeclave.eje_id_eje');
        $this->db->where('pregunta.id_pregunta', $id_pregunta);
        $query = $this->db->get();

        if ($query->num_rows() ==1)
            $return=$query->row();

        return $return;    
    }
*/
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

    /* metodo que obtiene el listado de aprendizajes por eje */
    public function get_aprendizaje_eje($id_eje)
    {
        $this->db->select('id_aprendizajeclave,aprendizajeclave');
        $this->db->from('aprendizajeclave');
        $this->db->where('eje_id_eje', $id_eje);
        $query = $this->db->get();

        if($query->num_rows()>0)
            return $query->result();
        else
            return false;
    }

    /* metodo para agregar nueva pregunta o editar una pregunta */
    public function save(&$data, $id_pregunta=false)
    {
        if(!$id_pregunta or !$this->exists($id_pregunta))
        {
            if($this->db->insert('pregunta',$data))
            {
                $data['id_pregunta']=$this->db->insert_id();
                return true;
            }
            return false;
        }

        $this->db->where('id_pregunta',$id_pregunta);

        return $this->db->update('pregunta',$data);
    }

    /* metodo que verifica que una pregunta existe */
    public function exists($id_pregunta)
    {
        $this->db->from('pregunta');   
        $this->db->where('id_pregunta',$id_pregunta);
        $query = $this->db->get();
        
        return ($query->num_rows()==1);
    }

    /* metodo que verifica que la prueba tiene asignada preguntas*/
    function have_prueba($id_prueba)
    {
        $query = $this->db->get_where('pregunta', array('prueba_id_prueba' => $id_prueba), 1);
         if($query->num_rows() == 1)
            return true;
        else
            return false;
    }

    /* metodo que elimina pregunta*/
    function delete($id_pregunta)
    {
        $this->db->trans_start();
        $this->db->delete('pregunta', array('id_pregunta' => $id_pregunta)); 
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            return false;
        }
    }
}

?>