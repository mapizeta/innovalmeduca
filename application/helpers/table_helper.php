<?php
/*
****************************************************************
Ejemplo práctico comentado por MapiZ para el uso de table_heper.
****************************************************************
Alumnos
*/

function get_alumno_manage_table($alumnos, $controller)
{
	//Declaramos la tabla(clase, id, etc.) 
	$table='<table class="tablesorter" id="sortable_table">';
	//Declramos los headers de la tabla en un array
	$headers = array('<input type="checkbox" id="select_all" />', 
	"Rut", 
	"Nombres",
	"Apellidos",
	'&nbsp');//podemos dejar esta columna vacía para usar opciones por alumno
	
	//concatenamos el header con la tabla usando el array previamente definido
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	//concatenamos con la información que sacaremos de la base de datos almacenada en la variable $alumnos
	$table.=get_people_manage_table_data_rows($alumnos,$controller);
	$table.='</tbody></table>';
	return $table;
}

/*
Obtener las columnas con datos del active record
*/
function get_alumno_manage_table_data_rows($alumnos,$controller)
{
	
	$table_data_rows='';
	
	//Obtenemos cada fila con cada resultado del active record
	foreach($alumnos->result() as $alumno)
	{
		$table_data_rows.=get_alumno_data_row($alumno,$controller);
	}
	
	if($alumnos->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;'>No existen datos para mostrar</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_alumno_data_row($alumno,$controller)
{
	$CI =& get_instance();
	$controller_name=$CI->uri->segment(1);
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='alumno_$alumno->alumno_id' value='".$alumno->alumno_id."'/></td>";
	$table_data_row.='<td width="20%">'.character_limiter($alumno->last_name,13).'</td>';
	$table_data_row.='<td width="20%">'.character_limiter($alumno->first_name,13).'</td>';
	$table_data_row.='<td width="30%" id="mail">'.mailto($alumno->email,character_limiter($alumno->email,22)).'</td>';
	$table_data_row.='<td width="20%">'.character_limiter($alumno->phone_number,13).'</td>';		
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$alumno->alumno_id/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}