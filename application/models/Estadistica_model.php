<?php
class Estadistica_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    /*Cantidad de preguntas de una prueba
        return integer
    */
    public function getCPP($id_asignacionprueba)
    {
        $sql = "SELECT COUNT( * ) AS preguntas
                FROM pregunta pr
                JOIN asignacionprueba a ON pr.prueba_id_prueba = a.prueba_id_prueba
                WHERE a.id_asignacionprueba = $id_asignacionprueba
                GROUP BY a.id_asignacionprueba";

        $query = $this->db->query($sql);

        if ($query->num_rows() ==1)
            $return = $query->row();
            
            return $return->preguntas;

    }

    /*obtener preguntas de una prueba por su id*/
    function getPP($id_prueba)
    {
        $sql = "SELECT p.id_pregunta
                FROM pregunta p
                WHERE p.prueba_id_prueba = $id_prueba 
                ORDER BY p.id_pregunta";

        $query = $this->db->query($sql);

        if($query->num_rows() > 0)
            return $query->result();
        else
            
            return false;     
    }
    
    /*** Obtener la lista de las  preguntas de una prueba
   * @param int $idAsignacionPrueba
   * @return type
   */
    function getPPP($id_asignacionprueba)
    {
        $sql = "SELECT p.id_pregunta, p.codigo
                FROM pregunta p
                JOIN prueba pr ON pr.id_prueba = p.prueba_id_prueba 
                JOIN asignacionprueba ap ON ap.prueba_id_prueba = pr.id_prueba
                WHERE ap.id_asignacionprueba = $id_asignacionprueba";

        $query = $this->db->query($sql);

        if($query->num_rows() > 0)
            return $query->result();
        else
            
            return false;        

    }
    
    /**
   * Obtener la lista de respuesta por preguntas
   * @param int $idPregunta
   * @return type
   */

    function getRPP($id_pregunta)
    {
        $sql = "SELECT id_respuesta, escorrecta
                FROM respuesta
                WHERE pregunta_id_pregunta = $id_pregunta
                ORDER BY id_respuesta ASC";
        
        $query = $this->db->query($sql);

        if($query->num_rows() > 0)
            return $query->result();
        else
            
            return false;        

    }

    /**
    * Obtener la cantidad de respuesta omitidas por pregunta en hojarespuesta
    * @param int $idPregunta
    * @return type
    */

    function getPO($id_colegio, $id_asignacionprueba, $id_pregunta)
    {
        $sql = "SELECT COUNT(*) AS omitidas
                FROM \"$id_colegio\".hojarespuesta
                WHERE asignacionprueba_id_asignacionprueba = $id_asignacionprueba AND pregunta_id_pregunta = $id_pregunta AND respuesta_id_respuesta ISNULL";
        
        $query = $this->db->query($sql);

        if ($query->num_rows() ==1)
            $return = $query->row();
            
            return $return->omitidas;        

    }

    function getLetra($id_respuesta, $id_pregunta)
    {
        $retorno = "error en alternativa";

        $letra = array("A", "B", "C", "D", "E");
        $rpp = $this->getRPP($id_pregunta);
        
        foreach ($rpp as $key => $value) 
            {
               if($value->id_respuesta == $id_respuesta)
               {
                    $retorno = $letra[$key]; 
               }
            }

        return $retorno;    
    }

    /**
    * Cantidad de repeticiones por alternativas por pregunta
    * @param int $idPregunta
    * @return type
    */    
    function getCRPA($id_colegio, $id_asignacionprueba, $id_pregunta, $id_respuesta)
    {
        $sql = "SELECT COUNT(respuesta_id_respuesta) AS alternativa
                FROM \"$id_colegio\".hojarespuesta
                WHERE asignacionprueba_id_asignacionprueba = $id_asignacionprueba AND pregunta_id_pregunta = $id_pregunta AND respuesta_id_respuesta = $id_respuesta";

        $query = $this->db->query($sql);

        if ($query->num_rows() ==1)
            $return = $query->row();
            
            return $return->alternativa;
    }

    /**
    * Obtener las repeticiones a las alternativas por pregunta
    * @param int $idPregunta
    * @return type
    */    


    function getRAP($id_asignacionprueba)
    {
       $ppp = $this->getPPP($id_asignacionprueba);//preguntas de una prueba
       $id_colegio = $this->get_idColegio($id_asignacionprueba);

       $array = array();
       

       foreach ($ppp as $key_prueba => $pregunta) 
       {
           $rpp = $this->getRPP($pregunta->id_pregunta);
           
           if($rpp)
               foreach ($rpp as $key => $value) //respuestas de una pregunta
               {
                   $letra = $this->getLetra($value->id_respuesta, $pregunta->id_pregunta);

                   if($value->escorrecta == 1)
                   {
                        $array[$key_prueba]['correcta'] = $letra;
                   }

                   $array[$key_prueba][$letra] = $this->getCRPA($id_colegio, $id_asignacionprueba, $pregunta->id_pregunta, $value->id_respuesta);
               }
            else
                $array[$key_prueba]['correcta'] = "Respuesta mal asignada";    
            
            $array[$key_prueba]['omitidas'] = $this->getPO($id_colegio, $id_asignacionprueba, $pregunta->id_pregunta);
        }

        return $array;
    }

    /**
    *Cantidad de alumnos que rindieron una prueba
    * @param int $idAsignacionPrueba
    * @return int
    */
    public function getCAR($id_asignacionprueba)
    {
        $id_colegio = $this->get_idColegio($id_asignacionprueba);
        
        $sql = "SELECT COUNT( * ) AS alumnos
                FROM usuario u
                WHERE u.id_usuario
                IN (
                    SELECT h.usuario_id_usuario
                    FROM \"$id_colegio\".hojarespuesta h
                    WHERE h.asignacionprueba_id_asignacionprueba = $id_asignacionprueba
                    )";

        $query = $this->db->query($sql);

        if ($query->num_rows() ==1)
            $return = $query->row();
            
            return $return->alumnos;

    }

    /**
   * Cantidad de Respuestas Correctas e Incorrectas por alumnos en la prueba (CRCIAP)
   * @param int $idAsignacionPrueba
   * @return array
   */

    function getCRCIAP($id_asignacionprueba)
    {
        $id_colegio = $this->get_idColegio($id_asignacionprueba);

        $sql = "SELECT h.usuario_id_usuario,
                CONCAT( u.apellido, ', ', u.nombre ) AS nombre_alumno,
                SUM( CASE WHEN r.escorrecta =1 THEN 1 ELSE 0 END)  AS correctas,
                SUM( CASE WHEN r.escorrecta =0 THEN 1 ELSE 0 END) AS incorrectas
                FROM \"$id_colegio\".hojarespuesta h
                LEFT JOIN respuesta r ON h.respuesta_id_respuesta = r.id_respuesta
                INNER JOIN usuario u ON h.usuario_id_usuario = u.id_usuario
                WHERE h.asignacionprueba_id_asignacionprueba = $id_asignacionprueba
                GROUP BY h.usuario_id_usuario, u.apellido, u.nombre
                ORDER BY u.apellido";

        $query = $this->db->query($sql);

        if($query->num_rows() > 0)
            return $query->result();
        else
            
            return false;         

    }

    function getTE($id_asignacionprueba)
    {
        $te = array();
        $sql="SELECT * FROM get_TE($id_asignacionprueba)";

        $query = $this->db->query($sql);

        if($query->num_rows() > 0)
        {
            $pte = $query->result();            
            
            foreach ($pte as $key => $value) 
            {
                $te[$key]['clave'] = $this->getLetra($value->id_respuesta, $value->id_pregunta);    
                $te[$key]['eje'] = $value->eje;
                $te[$key]['habilidad'] = $value->aprendizajeclave;
                $te[$key]['nivel'] = $value->dificultad;     
                
            }
        }

        return $te;
    }
    

    /**
   * Cantidad de Respuestas Correctas e Incorrectas por curso en la prueba (CRCIC)
   * @param int $idAsignacionPrueba
   * @return type
   */
    function getCRCIC($id_asignacionprueba)
    {
        $id_colegio = $this->get_idColegio($id_asignacionprueba);

        $sql="SELECT h.asignacionprueba_id_asignacionprueba, SUM( r.esCorrecta ) AS correctas, SUM( CASE WHEN r.escorrecta =0 THEN 1 ELSE 0 END) AS incorrectas
                FROM \"$id_colegio\".hojarespuesta h
                INNER JOIN respuesta r ON h.respuesta_id_respuesta = r.id_respuesta
                WHERE h.asignacionprueba_id_asignacionprueba = $id_asignacionprueba
                GROUP BY h.asignacionprueba_id_asignacionprueba";
        
        $query = $this->db->query($sql);

        if($query->num_rows() == 1)
            return $query->row();
        else
            
            return false;

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
    
    /**
   * Puntaje Simce por alumno (PSA)
   * @param int $idAsignacionPrueba
   * @return type
   */

    function getPSA($id_asignacionprueba)
    {
        $crciap = $this->getCRCIAP($id_asignacionprueba);//rppa
        $cpp    = $this->getCPP($id_asignacionprueba); //cpp
        $psa = array();

        foreach ($crciap as $key => $value) {
            $psa[$key]['id_usuario']        = $value->usuario_id_usuario;
            $psa[$key]['fullname']          = $value->nombre_alumno;
            $psa[$key]['correctas']         = $value->correctas;
            $psa[$key]['incorrectas']       = $value->incorrectas;
            $psa[$key]['porc_correctas']    = round(($value->correctas*100)/$cpp, 1);
            $psa[$key]['porc_incorrectas']  = round(($value->incorrectas*100)/$cpp, 1);
            $psa[$key]['omitidas']          = $cpp - $value->correctas - $value->incorrectas;
            $psa[$key]['porc_omitidas']     = round((($cpp - $value->correctas - $value->incorrectas)*100)/$cpp, 1);
            $psa[$key]['psa']               = round(((($value->correctas - $cpp / 2)) / 3 * (450 / $cpp) + 265), 0);

            $nota = ((round($psa[$key]['psa'])-190)*7)/130;
            
            if($nota<2)
                $nota = 2;

            $psa[$key]['nota'] = round($nota,1);

            if ($psa[$key]['psa'] < 240)
              $psa[$key]['nivel'] = 'INICIAL';
            else 
                if ($psa[$key]['psa'] >= 240 && $psa[$key]['psa'] < 280)
              $psa[$key]['nivel'] = 'BASICO';
            else
              $psa[$key]['nivel'] = 'AVANZADO';

        }

        return $psa;
    }

    function getRG($id_asignacionprueba)
    {
        $psa                = $this->getPSA($id_asignacionprueba);
        $cpp                = $this->getCPP($id_asignacionprueba);
        $crcic              = $this->getCRCIC($id_asignacionprueba);
        $car                = $this->getCAR($id_asignacionprueba);
        $correctas          = $crcic->correctas;
        $incorrectas        = $crcic->incorrectas;

        $totalcorrectas     = round(( ($correctas * 100) / ($cpp * $car) ), 1);
        $totalincorrectas   = round(( ($incorrectas * 100) / ($cpp * $car) ), 1);    
        $totalomitidas      = round(100 - ($totalcorrectas + $totalincorrectas), 1);

        /*contadores*/
        $rg = array();
        $inicial            = 0;
        $basico             = 0;
        $avanzado           = 0;
        $prom               = 0;

        foreach ($psa as $key => $value) 
        {
            $prom += round($value['psa']/$car, 0);

            if($value['nivel'] == 'INICIAL')
                $inicial++;
            if($value['nivel'] == 'BASICO')
                $basico++;
            if($value['nivel'] == 'AVANZADO') 
                $avanzado++;
            
             $porc_inicial  = round(($inicial / $car) * 100, 1);
             $porc_basico   = round(($basico / $car) * 100, 1);
             $porc_avanzado = round(($avanzado / $car) * 100, 1);
        }

        $rg['prom']             = $prom;
        $rg['totalcorrectas']   = $totalcorrectas;
        $rg['totalincorrectas'] = $totalincorrectas;
        $rg['totalomitidas']    = $totalomitidas;
        $rg['porc_inicial']     = $porc_inicial;
        $rg['porc_basico']      = $porc_basico;
        $rg['porc_avanzado']    = $porc_avanzado;


        return $rg;
    }
    

     /**
   * Obtener el total de respuestas correctas de aprendizaje clave(habilidad) por alumnos (TRHA)
   * @param int $idAsignacionPrueba
   * @return type
   */
    function getTRHA($id_asignacionprueba)
    {
        $id_colegio = $this->get_idColegio($id_asignacionprueba);
        $sql = "SELECT h.usuario_id_usuario, u.nombre, u.apellido, a.aprendizajeclave, a.id_aprendizajeclave
                FROM aprendizajeclave a
                INNER JOIN pregunta p ON a.id_aprendizajeclave = p.aprendizajeclave_id_aprendizajeclave
                INNER JOIN respuesta r ON p.id_pregunta = r.pregunta_id_pregunta
                INNER JOIN \"$id_colegio\".hojarespuesta h ON r.id_respuesta = h.respuesta_id_respuesta
                INNER JOIN usuario u ON h.usuario_id_usuario = u.id_usuario
                WHERE h.asignacionprueba_id_asignacionprueba = $id_asignacionprueba
                AND r.escorrecta = 1";
                        
        $query = $this->db->query($sql);

        if($query->num_rows() > 0)
            return $query->result();
        else
            
            return false;      
    }


     /**
   * Obtener el total de respuestas correctas de alumnos por aprendizaje clave (TRCAP)
   * @param int $idAsignacionPrueba
   * @return type
   */

    /*
    function getTRCAP_orig($id_asignacionprueba)
    {
        $id_colegio = $this->get_idColegio($id_asignacionprueba);
        $sql = "SELECT a.id_aprendizajeclave, a.aprendizajeclave, COUNT( p.id_pregunta ) AS cantidad
                FROM aprendizajeclave a
                INNER JOIN pregunta p ON a.id_aprendizajeclave = p.aprendizajeclave_id_aprendizajeclave
                INNER JOIN respuesta r ON p.id_pregunta = r.pregunta_id_pregunta
                INNER JOIN \"$id_colegio\".hojarespuesta h ON r.id_respuesta = h.respuesta_id_respuesta
                WHERE h.asignacionprueba_id_asignacionprueba = $id_asignacionprueba
                AND r.escorrecta = 1
                GROUP BY a.id_aprendizajeclave
                ORDER BY a.aprendizajeclave";
        
        $query = $this->db->query($sql);

        if($query->num_rows() > 0)
            return $query->result();
        else
            
            return false;       
    }
    */
/*
                SELECT a.id_aprendizajeclave, a.aprendizajeclave, COUNT( p.id_pregunta ) AS cantidad 
                FROM aprendizajeclave a
                INNER JOIN pregunta p ON a.id_aprendizajeclave = p.aprendizajeclave_id_aprendizajeclave
                INNER JOIN respuesta r ON p.id_pregunta = r.pregunta_id_pregunta
                INNER JOIN \"$id_colegio\".hojarespuesta h ON r.id_respuesta = h.respuesta_id_respuesta
                WHERE h.asignacionprueba_id_asignacionprueba = $id_asignacionprueba
                AND r.escorrecta = 1
                GROUP BY a.id_aprendizajeclave
                ORDER BY a.aprendizajeclave 
                */
    function getTRCAP($id_asignacionprueba)
    {
        $id_colegio = $this->get_idColegio($id_asignacionprueba);
        $sql = "SELECT a.id_aprendizajeclave, a.aprendizajeclave, COUNT( p.id_pregunta ) AS cantidad 
                FROM aprendizajeclave a
                INNER JOIN pregunta p ON a.id_aprendizajeclave = p.aprendizajeclave_id_aprendizajeclave
                INNER JOIN respuesta r ON p.id_pregunta = r.pregunta_id_pregunta
                INNER JOIN \"$id_colegio\".hojarespuesta h ON r.id_respuesta = h.respuesta_id_respuesta
                WHERE h.asignacionprueba_id_asignacionprueba = $id_asignacionprueba
                AND r.escorrecta = 1
                GROUP BY a.id_aprendizajeclave
                ORDER BY a.aprendizajeclave";
       
        $query = $this->db->query($sql);

        if($query->num_rows() > 0)
            return $query->result();
        else
           
            return false;      
    }

    /**
   * Obtener el total de preguntas por aprendizaje clave (TPAP)
   * @param int $idAsignacionPrueba
   * @return type
   */

    function getTPAP($id_asignacionprueba)
    {
        $sql = "SELECT a.aprendizajeclave, a.id_aprendizajeclave, COUNT( p.id_pregunta ) AS cantidad
                FROM aprendizajeclave a
                INNER JOIN pregunta p ON a.id_aprendizajeclave = p.aprendizajeclave_id_aprendizajeclave
                INNER JOIN prueba pr ON p.prueba_id_prueba = pr.id_prueba
                INNER JOIN asignacionprueba ap ON pr.id_prueba = ap.prueba_id_prueba
                WHERE ap.id_asignacionprueba = $id_asignacionprueba
                GROUP BY a.id_aprendizajeclave
                ORDER BY a.aprendizajeclave";
        
        $query = $this->db->query($sql);

        if($query->num_rows() > 0)
            return $query->result();
        else
            
            return false;
    }

    
    function getRH_orig($id_asignacionprueba)
    {
        $trcap = $this->getTRCAP($id_asignacionprueba);
        $tpap  = $this->getTPAP($id_asignacionprueba);
        $car   = $this->getCAR($id_asignacionprueba);
        $count_trcap = count($trcap);
        
        $rh    = array();

        foreach ($tpap as $key => $value) 
        {
            if($count_trcap > $key)
                $calculo = round((($trcap[$key]->cantidad/($value->cantidad * $car))*100),1);
            else
                $calculo = 0;

            $rh[$value->aprendizajeclave] = $calculo; 
            
        }
        
        return $rh;
  
    }
    

    function getRH($id_asignacionprueba)
    {
        $trcap = $this->getTRCAP($id_asignacionprueba);//total de respuestas correctas de alumnos por aprendizaje clave
        $tpap  = $this->getTPAP($id_asignacionprueba); //total de preguntas por aprendizaje clave
        $car   = $this->getCAR($id_asignacionprueba); //cantidad alumnos que respondieron
               
        $rh    = array();
       
        foreach ($trcap as $key_trcap => $value_trcap)
        {
            foreach ($tpap as $key_tpap => $value_tpap)
            {
                if($value_trcap->id_aprendizajeclave == $value_tpap->id_aprendizajeclave)
                    {
                        $token = $car*$value_tpap->cantidad;
                        $total = round((($value_trcap->cantidad * 100)/$token),0);
                        $rh[$value_trcap->aprendizajeclave] = $total;
                        //$rh[$value_trcap->eje][$value_trcap->aprendizajeclave] = $total;
                    }
            }
            $key_tpap = 0;
        }
       
        return $rh;
 
    }


    /**
   * Obtener la cantidad de preguntas correctas de alumnos por eje (TRCE)
   * @param int $idAsignacionPrueba
   * @return type
   */
/*


SELECT h.usuario_id_usuario, e.id_eje, e.eje, COUNT(*) cantidad 
                FROM eje e
                INNER JOIN aprendizajeclave a ON e.id_eje = a.eje_id_eje
                INNER JOIN pregunta p ON a.id_aprendizajeclave = p.aprendizajeclave_id_aprendizajeclave
                INNER JOIN respuesta r ON p.id_pregunta = r.pregunta_id_pregunta
                INNER JOIN \"$id_colegio\".hojarespuesta h ON r.id_respuesta = h.respuesta_id_respuesta
                WHERE h.asignacionprueba_id_asignacionprueba = $id_asignacionprueba
                AND r.escorrecta = 1
                GROUP BY e.id_eje, h.usuario_id_usuario

*/
    function getCPCAE($id_asignacionprueba)
    {
        $id_colegio = $this->get_idColegio($id_asignacionprueba);
        
        $sql=  "SELECT h.usuario_id_usuario, e.id_eje, e.eje, COUNT(*) cantidad 
                FROM eje e
        INNER JOIN pregunta p ON p.eje_id_eje = e.id_eje
                INNER JOIN aprendizajeclave a ON a.id_aprendizajeclave = p.aprendizajeclave_id_aprendizajeclave
                INNER JOIN respuesta r ON p.id_pregunta = r.pregunta_id_pregunta
                INNER JOIN \"$id_colegio\".hojarespuesta h ON r.id_respuesta = h.respuesta_id_respuesta
                WHERE h.asignacionprueba_id_asignacionprueba = $id_asignacionprueba
                AND r.escorrecta = 1
                GROUP BY e.id_eje, h.usuario_id_usuario";

        $query = $this->db->query($sql);

        if($query->num_rows() > 0)
            return $query->result();
        else
            
            return false;

    }

    function getRAE($id_asignacionprueba)
    {
        $rce    = $this->getTPE($id_asignacionprueba);      //total de preguntas por eje
        $cpcae  = $this->getCPCAE($id_asignacionprueba);   //cantidad de preguntas correctas de alumnos por eje
        $crciap = $this->getCRCIAP($id_asignacionprueba); //listado de alumnos

        $rae    = array();
        $arraye = array();

        foreach ($rce as $key => $value) 
        {
            $arraye[$value->eje] = $value->cantidad;
            $contador[$value->eje]['bajo'] = 0;
            $contador[$value->eje]['mediobajo'] = 0;
            $contador[$value->eje]['medioalto'] = 0;
            $contador[$value->eje]['alto'] = 0;
        }
        
         /*Se cargan los alumnos en rhpa*/
        foreach ($crciap as $key => $value) 
        {
            $rae[$key]['id_alumno'] = $value->usuario_id_usuario;   /*id usuario     */
            $rae[$key]['alumno'] = $value->nombre_alumno;          /*nombre completo*/

            foreach ($arraye as $key_rce => $value_rce) 
            {
                $rae[$key][$key_rce] = 0;       
            }

        }

        $cont = count($rae);

        foreach ($cpcae as $key => $value) 
        {
            for ($i=0; $i < $cont; $i++) 
            { 
                if($rae[$i]['id_alumno'] == $value->usuario_id_usuario)
                    {
                        $rae[$i][$value->eje] = $value->cantidad;    
                    }
            }
            
        }

        foreach ($rae as $key => $value) 
        {
            foreach ($arraye as $key_rce => $value_rce) 
            {
                $cantidad = $rae[$key][$key_rce];
                $total = round(($cantidad*100)/$value_rce, 1);
                $rae[$key][$key_rce] = $total;
            
                switch ($total) 
                {
                    case ($total <= 25):
                        $contador[$key_rce]['bajo']++;
                    break;
                    case ($total <= 50):
                        $contador[$key_rce]['mediobajo']++;
                    break;
                    case ($total <= 75):
                        $contador[$key_rce]['medioalto']++;
                    break;
                    case ($total <= 100):
                        $contador[$key_rce]['alto']++;
                    break;   
                }   
            }
        }


        $rae[$cont+1]['contador'] = $contador;
        //return $arraye;
        return $rae;
    }

    function getRHPA($id_asignacionprueba)
    {
        $tpap   = $this->getTPAP($id_asignacionprueba);     //cantidad de habilidades por prueba
        $trha   = $this->getTRHA($id_asignacionprueba);    //habilidades correctas por alumno
        $crciap = $this->getCRCIAP($id_asignacionprueba); //listado de alumnos
        
        $rhpa = array();
        $arrayh = array();

        foreach ($tpap as $tpap_key => $tpap_value) /*Se listan todas las habilidades*/ 
            {
                $arrayh[$tpap_value->aprendizajeclave] = $tpap_value->cantidad;                   
                $contador[$tpap_value->aprendizajeclave]['bajo'] = 0;
                $contador[$tpap_value->aprendizajeclave]['mediobajo'] = 0;
                $contador[$tpap_value->aprendizajeclave]['medioalto'] = 0;
                $contador[$tpap_value->aprendizajeclave]['alto'] = 0;
            }

        /*Se cargan los alumnos en rhpa*/
        foreach ($crciap as $key => $value) 
        {
            $rhpa[$key]['id_alumno'] = $value->usuario_id_usuario;   /*id usuario     */
            $rhpa[$key]['alumno'] = $value->nombre_alumno;          /*nombre completo*/

            foreach ($arrayh as $key_arrayh => $value_arrayh) 
            {
                $rhpa[$key][$key_arrayh] = 0;//$value_arrayh;   
            }
        }

        $cont = count($rhpa);

        foreach ($trha as $trha_key => $trha_value)
        {
            for ($i=0; $i < $cont; $i++) 
            { 
                if($rhpa[$i]['id_alumno'] == $trha_value->usuario_id_usuario)
                {
                    $rhpa[$i][$trha_value->aprendizajeclave]++;
                }
            }
        }
        
        foreach ($rhpa as $rhpa_key => $rhpa_value)
        {
            foreach ($arrayh as $key_arrayh => $value_arrayh) 
            {
                $contahabilidad = $rhpa[$rhpa_key][$key_arrayh]; 
                $total = round(($contahabilidad*100)/$value_arrayh, 1);
                
                $rhpa[$rhpa_key][$key_arrayh] = $total;

                switch ($total) 
                {
                    case ($total <= 25):
                        $contador[$key_arrayh]['bajo']++;
                    break;
                    case ($total <= 50):
                        $contador[$key_arrayh]['mediobajo']++;
                    break;
                    case ($total <= 75):
                        $contador[$key_arrayh]['medioalto']++;
                    break;
                    case ($total <= 100):
                        $contador[$key_arrayh]['alto']++;
                    break;   
                }   
            }
        }

        $rhpa[$cont+1]['contador'] = $contador;

        return $rhpa;    
        
    }

    /**
   * Obtener el total de respuestas correctas de alumnos por eje (TRCE)
   * @param int $idAsignacionPrueba
   * @return type
   */

/*

SELECT e.id_eje, e.eje , COUNT( * ) AS cantidad
              FROM eje e
              INNER JOIN aprendizajeclave a ON e.id_eje = a.eje_id_eje
              INNER JOIN pregunta p ON a.id_aprendizajeclave = p.aprendizajeclave_id_aprendizajeclave
              INNER JOIN respuesta r ON p.id_pregunta = r.pregunta_id_pregunta
              INNER JOIN \"$id_colegio\".hojarespuesta h ON r.id_respuesta = h.respuesta_id_respuesta
              WHERE h.asignacionprueba_id_asignacionprueba = $id_asignacionprueba
              AND r.escorrecta = 1
              GROUP BY e.id_eje

*/

    function getTRCE($id_asignacionprueba)
    {
        $id_colegio = $this->get_idColegio($id_asignacionprueba);
       
        $sql="SELECT e.id_eje, e.eje , COUNT( * ) AS cantidad
              FROM eje e
              INNER JOIN pregunta p ON p.eje_id_eje = e.id_eje
          INNER JOIN aprendizajeclave a ON a.id_aprendizajeclave = p.aprendizajeclave_id_aprendizajeclave
              INNER JOIN respuesta r ON p.id_pregunta = r.pregunta_id_pregunta
              INNER JOIN \"$id_colegio\".hojarespuesta h ON r.id_respuesta = h.respuesta_id_respuesta
              WHERE h.asignacionprueba_id_asignacionprueba = $id_asignacionprueba
              AND r.escorrecta = 1
              GROUP BY e.id_eje";

        $query = $this->db->query($sql);

        if($query->num_rows() > 0)
            return $query->result();
        else
           
            return false;

    }

    /**
   * Obtener el total de preguntas por eje (TPE)
   * @param int $idAsignacionPrueba
   * @return type
   */

    function getTPE($id_asignacionprueba)
    {
        $sql="SELECT e.id_eje, e.eje , COUNT( * ) AS cantidad
              FROM eje e
          INNER JOIN pregunta p ON p.eje_id_eje = e.id_eje
              INNER JOIN aprendizajeclave a ON a.id_aprendizajeclave = p.aprendizajeclave_id_aprendizajeclave
              INNER JOIN prueba pr ON p.prueba_id_prueba = pr.id_prueba
              INNER JOIN asignacionprueba ap ON pr.id_prueba = ap.prueba_id_prueba
              WHERE ap.id_asignacionprueba = $id_asignacionprueba
              GROUP BY e.id_eje";

        $query = $this->db->query($sql);

        if($query->num_rows() > 0)
            return $query->result();
        else
           
            return false;     
    }

    function getRCE($id_asignacionprueba)
    {
       
        $tpe   = $this->getTPE($id_asignacionprueba); //total de preguntas por eje
        $trce = $this->getTRCE($id_asignacionprueba); //total de respuestas correctas por eje
        $car   = $this->getCAR($id_asignacionprueba); //cantidad de alumnos que rindieron la prueba

        $rce    = array();

        foreach ($trce as $key_trce => $value_trce)
        {
            foreach ($tpe as $key_tpe => $value_tpe)
            {
                if($value_trce->id_eje == $value_tpe->id_eje)
                    {
                        $token = $car*$value_tpe->cantidad;
                        $total = round((($value_trce->cantidad * 100)/$token),0);
                        $rce[$value_trce->eje] = $total;
                    }
            }
            $key_tpe = 0;
        }

        return $rce;
    }

    /**
   * Obtener array para gráfico de deciles
   * @param int $idAsignacionPrueba
   * @return array (Array ( [0] => 0 [1] => 2 [2] => 2 [3] => 2 [4] => 0 [5] => 0 [6] => 0 [7] => 0 [8] => 0 [9] => 0 ))
   */

    function getDCL($id_asignacionprueba)
    {
        $psa   = $this->getPSA($id_asignacionprueba);
        $decil =  array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0);

        foreach ($psa as $key => $value) {
            $correctas = $value['porc_correctas']; 
            switch ($correctas) {
                case (0<=$correctas AND $correctas<10):
                    $decil[0]++;
                break;
                case (10<=$correctas AND $correctas<20):
                    $decil[1]++;
                break;
                case (20<=$correctas AND $correctas<30):
                    $decil[2]++;
                break;
                case (30<=$correctas AND $correctas<40):
                    $decil[3]++;
                break;
                case (40<=$correctas AND $correctas<50):
                    $decil[4]++;
                break;
                case (50<=$correctas AND $correctas<60):
                    $decil[5]++;
                break;
                case (60<=$correctas AND $correctas<70):
                    $decil[6]++;
                break;
                case (70<=$correctas AND $correctas<80):
                    $decil[7]++;
                break;
                case (80<=$correctas AND $correctas<90):
                    $decil[8]++;
                break;
                case (90<=$correctas AND $correctas<100):
                    $decil[9]++;
                break;
                
            }
        }
        
        return $decil;
    }
    
    function getPOR($id_asignacionprueba)
    {
        $array = array();

        $sql="SELECT * FROM get_por($id_asignacionprueba)";

        $query = $this->db->query($sql);

        if($query->num_rows() > 0)
        {
            $por = $query->result();
            
            foreach ($por as $key => $value) 
            {
                $correctas      = $this->separar($value->get_correctas);
                $incorrectas    = $this->separar($value->get_incorrectas);
                $omitidas       = $this->separar($value->get_omitidas);
            
                $array[$key]['cn'] = $this->getOPP($correctas[0]);
                $array[$key]['cr'] = $correctas[1];
                $array[$key]['in'] = $this->getOPP($incorrectas[0]);
                $array[$key]['ir'] = $incorrectas[1];
                $array[$key]['on'] = $this->getOPP($omitidas[0]);
                $array[$key]['or'] = $omitidas[1];
                
            }

        }

        return $array;
    }


     /**
   * Obtener array para Detalle de respuestas a preguntas por alumnos
   * @param int $idAsignacionPrueba
   * @return array 
   */

    function getDRA($id_asignacionprueba)
    {
        $retorno = false;
        $array = array();

        $sql="SELECT * FROM get_dra($id_asignacionprueba)";

        $query = $this->db->query($sql);

        if($query->num_rows() > 0)
        {
            $dra = $query->result();
            
            foreach ($dra as $key => $value) 
            {
                $array[$key]['fullname'] = $value->nombre_alumno." ".$value->apellido_alumno; 
                $array[$key]['correctas'] = $this->convierte(str_replace(array("{","}"), "", $value->correctas));
                $array[$key]['incorrectas'] = $this->convierte(str_replace(array("{","}"), "", $value->incorrectas));
                $array[$key]['omitidas'] = $this->convierte(str_replace(array("{","}"), "", $value->omitidas));
            }
            
            $retorno = $array;
        }   
        else
            return $retorno; 

        return $retorno;
    }
    
    /*Convierte los ids de las preguntas llegados en string en N° de preguntas*/
    function convierte($string)
    {
        $new_preguntas = "";

        if($string)
        {
            $preguntas = explode(",", $string);
            $new_preguntas = "";

            foreach ($preguntas as $key => $value) 
            {
                $new_preguntas.=$this->getOPP($value).", ";        
            }
        }
        else
            return $new_preguntas;


        return substr($new_preguntas, 0, -2);
    }

    function separar($string)
    {
        $quitaparentesis = str_replace(array("(",")"), "", $string);
        $duo = explode(",", $quitaparentesis);

        return $duo;
        
    }

    /*ORDEN DE UNA PREGUNTA DE UNA PRUEBA*/
    
    function getOPP($id_pregunta)
    {
        $sql = "SELECT p.id_pregunta
                FROM pregunta p
                WHERE p.prueba_id_prueba = 
                (
                    SELECT p.prueba_id_prueba
                    FROM pregunta p
                    WHERE p.id_pregunta = $id_pregunta
                )
                ORDER BY p.id_pregunta";

        $query = $this->db->query($sql);

        $preguntas = $query->result();

        foreach ($preguntas as $key => $value) {
            if($id_pregunta == $value->id_pregunta)
                $retorno = $key+1;
        }

        return $retorno;
    }


    function esCorrecta($colegio, $ap, $usuario, $pregunta)
    {
        $return = false;
        
        $sql = "SELECT r.escorrecta
            FROM \"1\".hojarespuesta h
            JOIN respuesta r ON h.respuesta_id_respuesta = r.id_respuesta
            WHERE h.asignacionprueba_id_asignacionprueba = $ap AND h.usuario_id_usuario = $usuario AND h.pregunta_id_pregunta = $pregunta";

        $query = $this->db->query($sql);

        if ($query->num_rows() ==1)
            {
                $row = $query->row();
                $return = $row->escorrecta;    
            }
            
        return $return;        
    }

    function subsector($ap)
    {
        $return = false;
       
        $sql = "SELECT s.alias
                FROM asignacionprueba a
                JOIN prueba p ON a.prueba_id_prueba = p.id_prueba
                JOIN subsector s ON p.subsector_id_subsector = s.id_subsector
                WHERE a.id_asignacionprueba = $ap";

        $query = $this->db->query($sql);

        if ($query->num_rows() ==1)
            {
                $row = $query->row();
                $return = $row->alias;   
            }
           
        return $return;       
    }

    function arrayPortada($id_asignacionprueba)
    {
        $sql = "SELECT c.nombre colegio, p.tipo id_tipo, p.codigo ||''|| l.letra codigo, l.letra,  (CASE WHEN p.tipo=1 THEN 'SIMCE' WHEN p.tipo=2 THEN 'PME' WHEN p.tipo=3 THEN 'PSU' ELSE 'Sin asignar'  END) tipo,
                 p.nivel_id_nivel, s.nombre subsector, a.realizado, co.nombre comuna
                FROM asignacionprueba a
                JOIN prueba p ON a.prueba_id_prueba = p.id_prueba
                JOIN curso cu ON a.curso_id_curso = cu.id_curso
                JOIN letra l ON l.id_letra = cu.letra_id_letra
                JOIN colegio c ON c.id_colegio = cu.colegio_id_colegio
                JOIN subsector s ON s.id_subsector = p.subsector_id_subsector
                JOIN comuna co ON c.comuna_id_comuna = co.id_comuna
                WHERE a.id_asignacionprueba = $id_asignacionprueba";

        $query = $this->db->query($sql);

        if($query->num_rows() > 0)
            return $query->result();
        else
            return false;   
    }


    
}