<?php
class Hojarespuesta_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
        $this->load->model('prueba_model');
    }

    function exists($id_hojarespuesta)
    {
        $this->db->from('hojarespuesta');   
        $this->db->where('id_hojarespuesta',$id_hojarespuesta);
        $query = $this->db->get();
        
        return ($query->num_rows()==1);
    }

    function init($id_usuario, $id_asignacionprueba, $id_colegio)
    {
        $retorno = false;
        
        if($respuestas = $this->have_respuesta($id_usuario, $id_asignacionprueba, $id_colegio))
            $retorno = $respuestas;
        else
            $retorno = $this->create($id_colegio,$id_asignacionprueba,$id_usuario);

        return $retorno;
    }

    function have_respuesta($id_usuario, $id_asignacionprueba, $id_colegio)
    {
        $query = $this->db->get_where('"'.$id_colegio.'".hojarespuesta', array('usuario_id_usuario' => $id_usuario, 'asignacionprueba_id_asignacionprueba' => $id_asignacionprueba));
          if($query->num_rows() > 0)
            return $query->result();
        else
            return false;
    }


    function save(&$data, $id_colegio,$id_asignacionprueba, $id_pregunta,$id_usuario)
    {       

        $retorno = false;
        
        $this->db->where('usuario_id_usuario', $id_usuario);
        $this->db->where('pregunta_id_pregunta', $id_pregunta);
        $this->db->where('asignacionprueba_id_asignacionprueba', $id_asignacionprueba);
       
        if($this->db->update('"'.$id_colegio.'".hojarespuesta' ,$data))
        $retorno = true;  
        
    }

    function create($id_colegio,$id_asignacionprueba,$id_usuario)
    {
        $query = $this->db->query("select create_hojarespuesta('".$id_colegio."',".$id_asignacionprueba.",".$id_usuario.");");
        //$result = $query->result();
        if ($query->num_rows() ==1)
        $return = $query->row();
        
        return $return->create_hojarespuesta;
    }

    function respondida($id_usuario, $id_asignacionprueba, $id_colegio, $id_pregunta)
    {
        $return = false;

        $this->db->select('respuesta_id_respuesta respuesta');
        $this->db->from('"'.$id_colegio.'".hojarespuesta');
        $this->db->where('pregunta_id_pregunta', $id_pregunta);
        $this->db->where('asignacionprueba_id_asignacionprueba', $id_asignacionprueba);
        $this->db->where('usuario_id_usuario', $id_usuario);
        
        $query = $this->db->get();
        
        if ($query->num_rows() ==1)
            {
                $fila = $query->row();
                $return = $fila->respuesta; 
            }

        return $return;

    }     

    /* metodo que elimina una prueba */
    function delete( $id_colegio, $id_asignacionprueba)
    {
      
        return $this->db->delete('"'.$id_colegio.'".hojarespuesta', array('asignacionprueba_id_asignacionprueba' =>  $id_asignacionprueba)); 
            
            
    }




}