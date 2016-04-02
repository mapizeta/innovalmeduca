<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("Sql_consulta.php");

class Grafico extends Sql_consulta {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('JpGraph/Graph');
        $this->pruebas_asignadas();
        $this->asignacion_pruebas();
    }

    // lista de asignaciones realizadas
    public function tabla_asignacion()
    {
        $datos_tabla=$this->contenido; 
        $muestra_tabla="";
        $this->muestra_tabla=$datos_tabla;
    }

    // grafico de barras simple
    public function grafico_1_bd()
    {
        require_once (APPPATH.'/libraries/JpGraph/jpgraph_bar.php');

        $datos = $this->id_asignacionprueba;
        
        $grafica = new Graph(500,300,'auto');
        $grafica->SetScale("textlin");
        
        //Posicion de los puntos de posiciones del eje de las Y
        //$mayor = array(0,5,10);
		// $grafica->yaxis->SetTickPositions($mayor); 
        $grafica->ygrid->SetFill(true,'#fff','#DDDDDD@0.5'); 

        $grafica->SetMarginColor("#fff");
        $grafica->SetFrame(true,'#fff',1);   
        $grafica->SetBox(false);
        
        //Nombre de las columnas
        //$columnas = array(1,2,3,4,5);
		//$grafica->xaxis->SetTickLabels($columnas);

        $barras = new BarPlot($datos);
        $grafica->Add($barras);
        $barras->SetColor("#0C6");
        $barras->SetFillColor("#0C6");
        $barras->SetWidth(45);
        $barras->SetValuePos('center');
        $barras->value->Show();
        $barras->value->SetFormat('%d'); // valores en formato de numero entero
		$barras->SetLegend("id asignacion");
        
        $grafica->legend->SetPos(0.5,0.98,'center','bottom');
        $grafica->legend->SetFrameWeight(1);
        $grafica->title->Set("Grafico 1 - de barras simples");
        $grafica->Stroke(_IMG_HANDLER);

        
        global $fileName_bd;
        $this->fileName_bd = "assets/images/grafica_muestra_bd.jpg";
        $grafica->img->Stream($this->fileName_bd);
		
        /*
        $grafica->img->Headers();
        $grafica->img->Stream();
        */
	}

	// grafico de barras compuestas (2 colores)
    public function grafico_2_bd()
    {
        require_once (APPPATH.'/libraries/JpGraph/jpgraph_bar.php');

        $data1y = $this->id_asignacionprueba;
        $data2y = $this->curso_id_curso;

        $graph = new Graph(700,360,"auto");    
        $graph->SetScale("textlin");

        $graph->img->SetMargin(30,30,20,65);

        $graph->ygrid->SetFill(true,'#fff','#DDDDDD@0.5'); 

        $graph->SetMarginColor("#fff");
        $graph->SetFrame(true,'#fff',1);   
        $graph->SetBox(false);

        //$columnas_2 = array('Ext. Info Explicita','Ext. Info Implicita','Ref. Contenido Texto','Ref. Sobre Texto');
        //$graph->xaxis->SetTickLabels($columnas_2);

        $b1plot = new BarPlot($data1y);

        $b1plot->SetWeight(0);
        $b1plot->SetFillColor("#61A9F3");
        $b1plot->SetLegend("id asignacion");
        $b1plot->SetValuePos('center');

        $b2plot = new BarPlot($data2y);

        $b2plot->SetWeight(0);
        $b2plot->SetFillColor("#F381B9");
        $b2plot->SetLegend("id curso");
        $b2plot->SetValuePos('center');

        $gbplot = new AccBarPlot(array($b1plot,$b2plot));
    
        $graph->Add($gbplot);

        $b1plot->value->Show();
        $b2plot->value->Show();
        $b1plot->value->SetFormat('%d');
        $b2plot->value->SetFormat('%d');

        $graph->title->Set("Grafico 2 - de barras compuestas");

        $graph->legend->SetPos(0.5,0.99,'center','bottom');
        $graph->legend->SetFrameWeight(1);

        $graph->Stroke(_IMG_HANDLER);

        
        global $fileName_bd_2;
    
        $this->fileName_bd_2 = "assets/images/grafica_muestra_bd_2.jpg";
        $graph->img->Stream($this->fileName_bd_2);
		
        /*
        $graph->img->Headers();
        $graph->img->Stream();
        */
        
    }

    // grafico circular o de pastel
    public function grafico_3_bd()
    {
        require_once (APPPATH.'/libraries/JpGraph/jpgraph_pie.php');

        $data_circ = $this->id_asignacionprueba;
        
		$columnas_circ = array('Correctas','Omitidas','Incorrectas');

        $graph_circ = new PieGraph(500,400);
        
		$graph_circ->title->Set("Grafico 3 - circular o de pastel");

        $graph_circ->SetMarginColor("#fff");
        $graph_circ->SetFrame(true,'#fff',1);   
        $graph_circ->SetBox(false);

        $p1 = new PiePlot($data_circ);
    
        $p1->ExplodeSlice(0);

        $p1->SetCenter(0.5);

        $p1->SetLegends($this->id_asignacionprueba);

        $graph_circ->legend->SetPos(0.2,0.99,'right','bottom');
        $graph_circ->legend->SetFrameWeight(1);

        $p1->SetGuideLines(true,false);
        $p1->SetGuideLinesAdjust(1.5);

        $p1->SetLabelType(PIE_VALUE_PER);    
        $p1->value->Show();   
 
        $graph_circ->Add($p1);

        $graph_circ->Stroke(_IMG_HANDLER);

        
        global $fileName_bd_3;
    
        $this->fileName_bd_3 = "assets/images/grafica_muestra_bd_3.jpg";

        $graph_circ->img->Stream($this->fileName_bd_3);
        
        /*
        $graph_circ->img->Headers();
        $graph_circ->img->Stream();
        */

	}

	// grafico de barras
    public function grafico_4_bd()
    {
        require_once (APPPATH.'/libraries/JpGraph/jpgraph_bar.php');

    	$datos_sial = $this->id_asignacionprueba;

    	$grafica_sial = new Graph(500,400,'auto');
        $grafica_sial->SetScale("textlin");
        $grafica_sial->yaxis->scale->SetGrace(20);

        $mayor_sial = array(2,4,6,8,10);

        $grafica_sial->yaxis->SetTickPositions($mayor_sial); 
        $grafica_sial->SetBox(false);

        //$columnas_sial = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20);
        //$grafica_sial->xaxis->SetTickLabels($columnas_sial);

        $grafica_sial->SetMarginColor("#fff");
        $grafica_sial->SetFrame(true,'#fff',1);   
        $grafica_sial->SetBox(false);

        //$grafica_sial->SetFont(FF_ARIAL);

        $barras_sial = new BarPlot($datos_sial);

        $grafica_sial->Add($barras_sial);

        $barras_sial->SetColor("#FF4A4A");
        $barras_sial->SetFillColor("#FF4A4A");
        $barras_sial->SetWidth(12);
    
        $barras_sial->value->Show();
        $barras_sial->value->SetFormat('%d');
        $barras_sial->value->SetAngle(85);

        $barras_sial->SetLegend("id asignacion");

        $grafica_sial->legend->SetPos(0.5,0.95,'center','bottom');
        $grafica_sial->legend->SetFrameWeight(1);

        $grafica_sial->title->Set("Grafico 4 - de barras simples");
        $grafica_sial->title->SetFont(FF_FONT2,FS_NORMAL);

        $grafica_sial->Stroke(_IMG_HANDLER);

        
        global $fileName_bd_4;
    
        $this->fileName_bd_4 = "assets/images/grafica_muestra_bd_4.jpg";

        $grafica_sial->img->Stream($this->fileName_bd_4);

        /*
		$grafica_sial->img->Headers();
        $grafica_sial->img->Stream();
        */
    }

}
?>