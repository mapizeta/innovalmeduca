<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."/phpexcel/PHPExcel.php";
require_once APPPATH."/phpexcel/PHPExcel/Reader/Excel2007.php";

class Ensayo_import extends CI_Controller {
	public function __construct()
        {
                parent::__construct();
                $this->load->model('import_prueba');
        }
	public function index()
	{	//temporal pruebas
		$this->load->view('import/ensayo');
	}
	public function upload()
	{
		try
        { 
            if($this->input->post("enviar"))
            {        
                //cargamos el archivo al servidor con el mismo nombre
//solo le agregue el sufijo bak_ 
			$archivo = $_FILES['excel']['name'];
			$tipo = $_FILES['excel']['type'];
			$destino = $_SERVER['DOCUMENT_ROOT']."/psu/bak_".$archivo;
			
			if (copy($_FILES['excel']['tmp_name'],$destino)) echo "Archivo Cargado Con Éxito<br>";
			else echo "Error Al Cargar el Archivo";
////////////////////////////////////////////////////////
		if (file_exists ("bak_".$archivo)){ 

			// Cargando la hoja de cálculo
			$objReader = new PHPExcel_Reader_Excel2007();
			$objPHPExcel = $objReader->load("bak_".$archivo);
			$objFecha = new PHPExcel_Shared_Date();       

			// Asignar hoja de excel activa
			$objPHPExcel->setActiveSheetIndex(0);

			//conectamos con la base de datos 
			//$cn = mysql_connect ("localhost","root","mysql") or die ("ERROR EN LA CONEXION");
			//$db = mysql_select_db ("prueba",$cn) or die ("ERROR AL CONECTAR A LA BD");

			        // Llenamos el arreglo con los datos  del archivo xlsx
			$cont = 0;
			for ($i=8;$i<=14;$i++){
				/*
				if($item_number = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue())
				{
					$_DATOS_EXCEL[$i]['item_number'] = $item_number;
				}
				else
				{
					$_DATOS_EXCEL[$i]['item_number'] = "SIN_CODIFICAR_".$cont;
					$cont++;
				}
				PREGUNTA
				*/	
				$_DATOS_EXCEL[$i]['contenido'] = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
				//alternativas
				$_DATOS_EXCEL[$i]['A'] = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
				$_DATOS_EXCEL[$i]['B'] = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
				$_DATOS_EXCEL[$i]['C'] = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
				$_DATOS_EXCEL[$i]['D'] = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
				$_DATOS_EXCEL[$i]['E'] = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();

				$_DATOS_EXCEL[$i]['id_nivel'] = 1;
				$_DATOS_EXCEL[$i]['id_sub_sector'] = 2;
				
			}		
		}
		//si por algo no cargo el archivo bak_ 
		else{echo "Necesitas primero importar el archivo";}
		$errores=0;
		//recorremos el arreglo multidimensional 
		//para ir recuperando los datos obtenidos
		//del excel e ir insertandolos en la BD

		foreach($_DATOS_EXCEL as $campo => $valor){
			/*$sql = "INSERT INTO 'academico'.'pregunta'(contenido, id_nivel, id_sub_sector) VALUES ('";*/
			
			$data_pregunta=array(
	    			'contenido'=>$valor['contenido'],
	    			'id_sub_sector'=>2,
	    			'id_nivel'=>2
	    			);
			$data_respuesta=array(
	    			'A'=>$valor['A'],
	    			'B'=>$valor['B'],
	    			'C'=>$valor['C'],
	    			'D'=>$valor['D'],
	    			'E'=>$valor['E'],
	    			);
			
			if($this->import_prueba->insert_pregunta($data_pregunta, $data_respuesta));
				echo "pregunta cargada satisfactoriamente";
			
		}	
				unlink($destino);
		}
	}
          
        catch(Exception $err)
        {
            log_message("error",$err->getMessage());
            return show_error($err->getMessage());
        }

}
	public function puntaje()
	{
		try
        { 
            if($this->input->post("enviar"))
            {        
                //cargamos el archivo al servidor con el mismo nombre
//solo le agregue el sufijo bak_ 
			$archivo = $_FILES['excel']['name'];
			$tipo = $_FILES['excel']['type'];
			$destino = $_SERVER['DOCUMENT_ROOT']."/psu/bak_".$archivo;
			
			if (copy($_FILES['excel']['tmp_name'],$destino)) echo "Archivo Cargado Con Éxito<br>";
			else echo "Error Al Cargar el Archivo";
////////////////////////////////////////////////////////
		if (file_exists ("bak_".$archivo)){ 

			// Cargando la hoja de cálculo
			$objReader = new PHPExcel_Reader_Excel2007();
			$objPHPExcel = $objReader->load("bak_".$archivo);
			$objFecha = new PHPExcel_Shared_Date();       

			// Asignar hoja de excel activa
			$objPHPExcel->setActiveSheetIndex(0);

			//conectamos con la base de datos 
			//$cn = mysql_connect ("localhost","root","mysql") or die ("ERROR EN LA CONEXION");
			//$db = mysql_select_db ("prueba",$cn) or die ("ERROR AL CONECTAR A LA BD");

			        // Llenamos el arreglo con los datos  del archivo xlsx
			$cont = 0;
			for ($i=2;$i<=82;$i=$i++){
					
				$_DATOS_EXCEL[$i]['correctas'] = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
				//alternativas
				$_DATOS_EXCEL[$i]['puntaje'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();

				$_DATOS_EXCEL[$i]['id_sub_sector'] = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
				
			}		
		}
		//si por algo no cargo el archivo bak_ 
		else{echo "Necesitas primero importar el archivo";}
		$errores=0;
		//recorremos el arreglo multidimensional 
		//para ir recuperando los datos obtenidos
		//del excel e ir insertandolos en la BD

		foreach($_DATOS_EXCEL as $campo => $valor){
			$sql = "INSERT INTO 'estadisticas'.'tabla_puntajes'(correctas, puntaje, id_sector) VALUES ('";
			$sql.= $valor['correctas'].", ".$valor['puntaje'].", ".$valor['id_sub_sector'].";";
			/*
			$data_puntaje=array(
	    			'correctas'=>$valor['correctas'],
	    			'puntaje'=>$valor['puntaje'],
	    			'id_sub_sector'=>$valor['id_sub_sector']
	    			);
			
			if($this->import_prueba->insert_pregunta($data_pregunta, $data_respuesta));
				echo "pregunta cargada satisfactoriamente";
			*/
			echo $sql;
		}	
				unlink($destino);
		}
	}
          
        catch(Exception $err)
        {
            log_message("error",$err->getMessage());
            return show_error($err->getMessage());
        }

}
	


}
?>